<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesSeller;
use App\Services\Firebase\FirebaseStorageService;
use App\Services\Firebase\FirebaseSyncService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SellerPageBuilderController extends Controller
{
    use ResolvesSeller;

    public function __construct(
        private readonly FirebaseStorageService $files,
        private readonly FirebaseSyncService $firebase,
    ) {}

    public function edit(): View
    {
        return view('seller.page-builder', [
            'seller' => $this->seller()->load('products'),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $seller = $this->seller();
        $validated = $request->validate([
            'brand_name' => ['required', 'string', 'max:80'],
            'category' => ['required', 'string', 'max:100'],
            'location' => ['nullable', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:500'],
            'whatsapp' => ['required', 'string', 'max:30'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'banner' => ['nullable', 'image', 'max:4096'],
        ]);

        foreach (['logo' => 'logo_path', 'banner' => 'banner_path'] as $input => $column) {
            if ($request->hasFile($input)) {
                $this->files->delete($seller->{$column});
                $validated[$column] = $this->files->upload($request->file($input), $input.'s');
            }
        }

        unset($validated['logo'], $validated['banner']);
        $seller->update($validated);
        $this->firebase->seller($seller->fresh());

        return back()->with('status', 'Halaman publik berhasil diperbarui.');
    }
}
