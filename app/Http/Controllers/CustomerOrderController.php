<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesSeller;
use App\Models\CustomOrder;
use App\Models\Product;
use App\Models\Seller;
use App\Services\Firebase\FirebaseStorageService;
use App\Services\Firebase\FirebaseSyncService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CustomerOrderController extends Controller
{
    use ResolvesSeller;

    /**
     * Baseline estimate (Rp) when the customer orders without picking a catalog product.
     */
    private const DEFAULT_ESTIMATED_PRICE = 100000;

    public function __construct(
        private readonly FirebaseStorageService $files,
        private readonly FirebaseSyncService $firebase,
    ) {}

    public function create(Seller $seller): View
    {
        return view('public.order-form', [
            'seller' => $seller->load('products'),
            'fields' => $seller->enabledFields(),
        ]);
    }

    public function store(Request $request, Seller $seller): RedirectResponse
    {
        $validated = $request->validate($this->orderRules($seller));

        $product = isset($validated['product_id'])
            ? Product::where('seller_id', $seller->id)->find($validated['product_id'])
            : null;

        $quantity = max(1, (int) ($validated['quantity'] ?? 1));
        $estimatedPrice = ($product?->starting_price ?? self::DEFAULT_ESTIMATED_PRICE) * $quantity;

        if ($validated['reference'] ?? null) {
            $validated['reference_path'] = $this->files->upload($validated['reference'], 'references');
        }

        unset($validated['reference']);

        $order = CustomOrder::create([
            ...$validated,
            'seller_id' => $seller->id,
            'product_id' => $product?->id,
            'order_code' => CustomOrder::generateOrderCode(),
            'quantity' => $quantity,
            'estimated_price' => $estimatedPrice,
            'status' => 'waiting_payment',
            'payment_status' => 'unpaid',
        ]);

        $this->firebase->order($order->load('seller', 'product'));

        return redirect()->route('orders.summary', $order);
    }

    /**
     * Optional brief fields are only accepted when the seller enabled them
     * in the form builder, mirroring what the public form renders.
     */
    private function orderRules(Seller $seller): array
    {
        $rules = [
            'customer_name' => ['required', 'string', 'max:80'],
            'customer_whatsapp' => ['required', 'string', 'max:30'],
            'product_id' => ['nullable', 'exists:products,id'],
            'product_type' => ['required', 'string', 'max:120'],
        ];

        $optional = [
            'material' => ['nullable', 'string', 'max:80'],
            'size' => ['nullable', 'string', 'max:80'],
            'color' => ['nullable', 'string', 'max:80'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:999'],
            'deadline' => ['nullable', 'date'],
            'budget' => ['nullable', 'string', 'max:80'],
            'notes' => ['nullable', 'string', 'max:800'],
            'reference' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:10240'],
        ];

        $enabled = $seller->enabledFields();

        foreach ($optional as $field => $fieldRules) {
            if ($enabled[$field] ?? false) {
                $rules[$field] = $fieldRules;
            }
        }

        return $rules;
    }

    public function summary(CustomOrder $order): View
    {
        return view('public.summary', [
            'order' => $order->load('seller', 'product'),
            'whatsappUrl' => $this->whatsappUrl($order->seller, $order->whatsappSummary()),
        ]);
    }

    public function uploadProof(Request $request, CustomOrder $order): RedirectResponse
    {
        $request->validate([
            'payment_proof' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:5120'],
        ]);

        $this->files->delete($order->payment_proof_path);

        $order->update([
            'payment_proof_path' => $this->files->upload($request->file('payment_proof'), 'payment-proofs'),
            'payment_status' => 'proof_uploaded',
        ]);

        $this->firebase->order($order->fresh(['seller', 'product']));

        return back()->with('status', 'Bukti pembayaran berhasil diunggah.');
    }

    public function lookupForm(): View
    {
        return view('public.lookup');
    }

    public function lookup(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'order_code' => ['required', 'string', 'max:30'],
        ]);

        $order = CustomOrder::where('order_code', Str::upper(trim($validated['order_code'])))->first();

        if (! $order) {
            return back()
                ->withErrors(['order_code' => 'Kode pesanan tidak ditemukan.'])
                ->withInput();
        }

        return redirect()->route('orders.status', $order);
    }

    public function status(CustomOrder $order): View
    {
        return view('public.status', [
            'order' => $order->load('seller', 'product'),
            'whatsappUrl' => $this->whatsappUrl($order->seller, "Halo, saya ingin menanyakan status order {$order->order_code}."),
        ]);
    }
}
