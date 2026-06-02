<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\View\View;

class MarketingController extends Controller
{
    public function __invoke(): View
    {
        return view('marketing.index', [
            'seller' => Seller::with('products')->first(),
        ]);
    }
}
