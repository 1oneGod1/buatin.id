<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesSeller;
use Illuminate\View\View;

class SellerDashboardController extends Controller
{
    use ResolvesSeller;

    public function __invoke(): View
    {
        $seller = $this->seller()->load(['customOrders' => fn ($query) => $query->latest(), 'products']);
        $orders = $seller->customOrders;

        return view('seller.dashboard', [
            'seller' => $seller,
            'orders' => $orders->take(5),
            'stats' => [
                'products' => $seller->products->count(),
                'new_orders' => $orders->whereIn('status', ['waiting_payment', 'received'])->count(),
                'pending_payment' => $orders->whereIn('payment_status', ['unpaid', 'proof_uploaded'])->count(),
                'completed' => $orders->where('status', 'completed')->count(),
            ],
        ]);
    }
}
