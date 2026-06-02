<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\View\View;

class PublicStoreController extends Controller
{
    public function show(Seller $seller): View
    {
        return view('public.store', [
            'seller' => $seller->load(['products' => fn ($query) => $query->where('is_featured', true)]),
        ]);
    }
}
