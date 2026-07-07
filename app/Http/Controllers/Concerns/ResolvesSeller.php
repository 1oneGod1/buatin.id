<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Seller;
use Illuminate\Http\Exceptions\HttpResponseException;

trait ResolvesSeller
{
    protected function seller(): Seller
    {
        $seller = auth()->user()?->seller;

        if (! $seller) {
            throw new HttpResponseException(
                redirect()->route('seller.start')
                    ->with('status', 'Lengkapi profil toko dulu untuk mulai berjualan.')
            );
        }

        return $seller;
    }

    protected function whatsappUrl(?string $rawNumber, string $message): string
    {
        $number = preg_replace('/\D+/', '', $rawNumber ?? '');

        if (str_starts_with($number, '0')) {
            $number = '62'.substr($number, 1);
        }

        if ($number === '') {
            return '#';
        }

        return 'https://wa.me/'.$number.'?text='.rawurlencode($message);
    }
}
