<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesSeller;
use App\Models\CustomOrder;
use App\Services\Firebase\FirebaseSyncService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SellerOrderController extends Controller
{
    use ResolvesSeller;

    public function __construct(private readonly FirebaseSyncService $firebase) {}

    public function index(): View
    {
        return view('seller.orders.index', [
            'seller' => $this->seller(),
            'orders' => $this->seller()->customOrders()->with('product')->latest()->paginate(12),
        ]);
    }

    public function show(CustomOrder $order): View
    {
        abort_unless($order->seller_id === $this->seller()->id, 404);

        return view('seller.orders.show', [
            'seller' => $this->seller(),
            'order' => $order->load('product', 'seller'),
            'whatsappUrl' => $this->whatsappUrl($order->customer_whatsapp, "Halo {$order->customer_name}, saya sudah menerima order {$order->order_code}."),
        ]);
    }

    public function update(Request $request, CustomOrder $order): RedirectResponse
    {
        abort_unless($order->seller_id === $this->seller()->id, 404);

        $validated = $request->validate([
            'status' => ['required', 'in:received,waiting_payment,processing,ready,completed,cancelled'],
            'payment_status' => ['required', 'in:unpaid,proof_uploaded,paid'],
        ]);

        $order->update($validated);
        $this->firebase->order($order->fresh(['seller', 'product']));

        return back()->with('status', 'Status pesanan berhasil diperbarui.');
    }
}
