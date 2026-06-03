<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesSeller;
use App\Services\Firebase\FirebaseSyncService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SellerSubscriptionController extends Controller
{
    use ResolvesSeller;

    public function __construct(private readonly FirebaseSyncService $firebase) {}

    public function edit(): View
    {
        return view('seller.subscription', [
            'seller' => $this->seller(),
            'plans' => $this->plans(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'plan' => ['required', 'in:free,starter,pro'],
        ]);

        $seller = $this->seller();
        $seller->update([
            'plan' => $validated['plan'],
            'subscription_status' => 'active',
        ]);

        $this->firebase->seller($seller->fresh());

        return back()->with('status', 'Paket berhasil diperbarui untuk simulasi MVP.');
    }

    private function plans(): array
    {
        return [
            'free' => [
                'name' => 'Free',
                'price' => 'Rp0',
                'period' => 'selamanya',
                'description' => 'Untuk validasi usaha dan menerima order custom pertama.',
                'features' => ['1 halaman toko publik', 'Maksimal 3 produk katalog', 'Form brief dasar', 'Tombol WhatsApp'],
            ],
            'starter' => [
                'name' => 'Starter',
                'price' => 'Rp29.000',
                'period' => 'per bulan',
                'description' => 'Untuk UMKM yang mulai aktif menerima pesanan custom.',
                'features' => ['Produk katalog lebih banyak', 'Upload logo dan banner', 'QRIS dan bukti pembayaran', 'Manajemen status order'],
            ],
            'pro' => [
                'name' => 'Pro',
                'price' => 'Rp79.000',
                'period' => 'per bulan',
                'description' => 'Untuk kreator yang butuh tampilan lebih profesional.',
                'features' => ['Semua fitur Starter', 'Custom branding penuh', 'Prioritas dukungan', 'Laporan order bulanan'],
            ],
        ];
    }
}
