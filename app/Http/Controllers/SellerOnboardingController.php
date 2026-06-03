<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use App\Services\Firebase\FirebaseSyncService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SellerOnboardingController extends Controller
{
    public function __construct(private readonly FirebaseSyncService $firebase) {}

    public function create(Request $request): View
    {
        $isCreatingNew = $request->boolean('new');

        return view('seller.onboarding', [
            'seller' => $isCreatingNew ? null : (session('seller_id') ? Seller::find(session('seller_id')) : Seller::first()),
            'isCreatingNew' => $isCreatingNew,
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

        $seller = $request->boolean('create_new') ? null : (session('seller_id') ? Seller::find(session('seller_id')) : null);

        if ($seller) {
            $seller->update($validated);
        } else {
            $validated['slug'] = Seller::makeSlug($validated['brand_name']);
            $validated['form_fields'] = Seller::first()?->enabledFields();
            $validated['plan'] = 'free';
            $validated['subscription_status'] = 'active';
            $seller = Seller::create($validated);
        }

        session(['seller_id' => $seller->id]);
        $this->firebase->seller($seller->fresh());

        return redirect()->route('seller.dashboard')->with('status', 'Profil usaha berhasil disimpan.');
    }
}
