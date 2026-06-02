<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesSeller;
use App\Services\Firebase\FirebaseStorageService;
use App\Services\Firebase\FirebaseSyncService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SellerPaymentSettingsController extends Controller
{
    use ResolvesSeller;

    public function __construct(
        private readonly FirebaseStorageService $files,
        private readonly FirebaseSyncService $firebase,
    ) {}

    public function edit(): View
    {
        return view('seller.payment', [
            'seller' => $this->seller(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $seller = $this->seller();
        $validated = $request->validate([
            'qris_enabled' => ['nullable', 'boolean'],
            'payment_account' => ['nullable', 'string', 'max:120'],
            'payment_instructions' => ['nullable', 'string', 'max:700'],
            'qris' => ['nullable', 'image', 'max:4096'],
        ]);

        $validated['qris_enabled'] = $request->boolean('qris_enabled');

        if ($request->hasFile('qris')) {
            $this->files->delete($seller->qris_path);
            $validated['qris_path'] = $this->files->upload($request->file('qris'), 'qris');
        }

        unset($validated['qris']);
        $seller->update($validated);
        $this->firebase->seller($seller->fresh());

        return back()->with('status', 'Pengaturan pembayaran berhasil disimpan.');
    }
}
