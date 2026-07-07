<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesSeller;
use Illuminate\View\View;

class SellerDashboardController extends Controller
{
    use ResolvesSeller;

    public function __invoke(): View
    {
        $seller = $this->seller()->load('products');

        $counts = $seller->customOrders()
            ->toBase()
            ->selectRaw("
                sum(case when status in ('waiting_payment', 'received') then 1 else 0 end) as new_orders,
                sum(case when payment_status in ('unpaid', 'proof_uploaded') then 1 else 0 end) as pending_payment,
                sum(case when status = 'completed' then 1 else 0 end) as completed
            ")
            ->first();

        return view('seller.dashboard', [
            'seller' => $seller,
            'orders' => $seller->customOrders()->latest()->limit(5)->get(),
            'stats' => [
                'visits' => $seller->views,
                'products' => $seller->products->count(),
                'new_orders' => (int) $counts->new_orders,
                'pending_payment' => (int) $counts->pending_payment,
                'completed' => (int) $counts->completed,
            ],
        ]);
    }
}
