<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use App\Services\Firebase\FirebaseSyncService;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SellerOnboardingController extends Controller
{
    public function __construct(private readonly FirebaseSyncService $firebase) {}

    public function create(Request $request): View
    {
        $seller = $request->user()->seller;

        return view('seller.onboarding', [
            'seller' => $seller,
            'isCreatingNew' => $seller === null,
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

        $seller = $request->user()->seller;

        if ($seller) {
            $seller->update($validated);
        } else {
            $validated['user_id'] = $request->user()->id;
            $validated['slug'] = Seller::makeSlug($validated['brand_name']);
            $validated['form_fields'] = [
                'material' => true,
                'size' => true,
                'color' => true,
                'quantity' => true,
                'deadline' => true,
                'budget' => true,
                'reference' => true,
                'notes' => true,
            ];
            $validated['plan'] = 'free';
            $validated['subscription_status'] = 'active';

            try {
                $seller = Seller::create($validated);
            } catch (UniqueConstraintViolationException) {
                // Two onboardings picked the same slug concurrently; regenerate once.
                $validated['slug'] = Seller::makeSlug($validated['brand_name']);
                $seller = Seller::create($validated);
            }
        }

        $this->firebase->seller($seller->fresh());

        return redirect()->route('seller.dashboard')->with('status', 'Profil usaha berhasil disimpan.');
    }
}
