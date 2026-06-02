<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesSeller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SellerPaymentSettingsController extends Controller
{
    use ResolvesSeller;

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
            if ($seller->qris_path) {
                Storage::disk('public')->delete($seller->qris_path);
            }

            $validated['qris_path'] = $request->file('qris')->store('qris', 'public');
        }

        unset($validated['qris']);
        $seller->update($validated);

        return back()->with('status', 'Pengaturan pembayaran berhasil disimpan.');
    }
}
