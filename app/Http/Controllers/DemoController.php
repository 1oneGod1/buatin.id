<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\RedirectResponse;

class DemoController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        $seller = Seller::firstOrFail();

        session(['seller_id' => $seller->id]);

        return redirect()->route('seller.dashboard');
    }
}
