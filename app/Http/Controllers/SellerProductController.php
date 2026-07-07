<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesSeller;
use App\Models\Product;
use App\Models\Seller;
use App\Services\Firebase\FirebaseStorageService;
use App\Services\Firebase\FirebaseSyncService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SellerProductController extends Controller
{
    use ResolvesSeller;

    public function __construct(
        private readonly FirebaseStorageService $files,
        private readonly FirebaseSyncService $firebase,
    ) {}

    public function index(): View
    {
        return view('seller.products.index', [
            'seller' => $this->seller()->load(['products' => fn ($query) => $query->latest()]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $seller = $this->seller();

        if (! $seller->canAddProduct()) {
            return $this->productLimitReached();
        }

        $validated = $this->validateProduct($request);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $this->files->upload($request->file('image'), 'products');
        }

        unset($validated['image']);

        // Re-check the plan limit under a row lock so parallel submissions
        // cannot exceed it between the check above and the insert.
        $product = DB::transaction(function () use ($seller, $validated) {
            Seller::whereKey($seller->id)->lockForUpdate()->first();

            return $seller->canAddProduct()
                ? $seller->products()->create($validated)
                : null;
        });

        if (! $product) {
            return $this->productLimitReached();
        }

        $this->firebase->product($product->load('seller'));

        return back()->with('status', 'Produk custom berhasil ditambahkan ke katalog.');
    }

    private function productLimitReached(): RedirectResponse
    {
        return back()
            ->withErrors(['name' => 'Paket Free hanya mendukung maksimal 3 produk. Upgrade ke Starter untuk menambah produk lagi.'])
            ->withInput();
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $this->abortIfDifferentSeller($product);

        $validated = $this->validateProduct($request);

        if ($request->hasFile('image')) {
            $this->files->delete($product->image_path);
            $validated['image_path'] = $this->files->upload($request->file('image'), 'products');
        }

        unset($validated['image']);

        $product->update($validated);
        $this->firebase->product($product->fresh('seller'));

        return back()->with('status', 'Produk custom berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->abortIfDifferentSeller($product);

        $this->files->delete($product->image_path);
        $productId = (string) $product->id;
        $product->delete();
        $this->firebase->deleteProduct($productId);

        return back()->with('status', 'Produk custom berhasil dihapus dari katalog.');
    }

    private function validateProduct(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'category' => ['nullable', 'string', 'max:80'],
            'description' => ['nullable', 'string', 'max:500'],
            'starting_price' => ['required', 'integer', 'min:0', 'max:999999999'],
            'image' => ['nullable', 'image', 'max:4096'],
            'is_featured' => ['sometimes', 'boolean'],
        ]) + [
            'is_featured' => false,
        ];
    }

    private function abortIfDifferentSeller(Product $product): void
    {
        abort_unless($product->seller_id === $this->seller()->id, 404);
    }
}
