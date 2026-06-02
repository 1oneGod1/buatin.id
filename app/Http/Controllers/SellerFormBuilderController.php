<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesSeller;
use App\Services\Firebase\FirebaseSyncService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SellerFormBuilderController extends Controller
{
    use ResolvesSeller;

    public function __construct(private readonly FirebaseSyncService $firebase) {}

    public function edit(): View
    {
        return view('seller.form-builder', [
            'seller' => $this->seller(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $fields = collect(['material', 'size', 'color', 'quantity', 'deadline', 'budget', 'reference', 'notes'])
            ->mapWithKeys(fn (string $field) => [$field => $request->boolean("fields.{$field}")])
            ->all();

        $seller = $this->seller();
        $seller->update(['form_fields' => $fields]);
        $this->firebase->seller($seller->fresh());

        return back()->with('status', 'Konfigurasi form berhasil disimpan.');
    }
}
