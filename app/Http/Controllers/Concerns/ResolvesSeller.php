<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Seller;

trait ResolvesSeller
{
    protected function seller(): Seller
    {
        $seller = session('seller_id')
            ? Seller::find(session('seller_id'))
            : Seller::first();

        abort_unless($seller, 404, 'Seller demo belum tersedia. Jalankan migrate dan seed terlebih dahulu.');

        session(['seller_id' => $seller->id]);

        return $seller;
    }

    protected function whatsappUrl(Seller $seller, string $message): string
    {
        $number = preg_replace('/\D+/', '', $seller->whatsapp ?? '');

        if (str_starts_with($number, '0')) {
            $number = '62'.substr($number, 1);
        }

        if ($number === '') {
            return '#';
        }

        return 'https://wa.me/'.$number.'?text='.rawurlencode($message);
    }
}
