<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SellerOnboardingController extends Controller
{
    public function create(): View
    {
        return view('seller.onboarding', [
            'seller' => session('seller_id') ? Seller::find(session('seller_id')) : Seller::first(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'brand_name' => ['required', 'string', 'max:80'],
            'category' => ['required', 'string', 'max:100'],
            'whatsapp' => ['required', 'string', 'max:30'],
            'location' => ['nullable', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $seller = session('seller_id') ? Seller::find(session('seller_id')) : null;

        if ($seller) {
            $seller->update($validated);
        } else {
            $validated['slug'] = Seller::makeSlug($validated['brand_name']);
            $validated['form_fields'] = Seller::first()?->enabledFields();
            $seller = Seller::create($validated);
        }

        session(['seller_id' => $seller->id]);

        return redirect()->route('seller.dashboard')->with('status', 'Profil usaha berhasil disimpan.');
    }
}
