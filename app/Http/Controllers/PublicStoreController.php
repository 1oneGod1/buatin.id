<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicStoreController extends Controller
{
    public function show(Request $request, Seller $seller): View
    {
        if ($request->user()?->id !== $seller->user_id) {
            // Base query increment so updated_at keeps reflecting real profile edits.
            Seller::whereKey($seller->getKey())->toBase()->increment('views');
        }

        return view('public.store', [
            'seller' => $seller->load(['products' => fn ($query) => $query->where('is_featured', true)]),
        ]);
    }
}
