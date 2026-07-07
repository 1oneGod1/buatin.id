<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class DemoController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        abort_unless(config('app.demo_enabled'), 404);

        $seller = Seller::with('user')->firstOrFail();

        if ($seller->user) {
            Auth::login($seller->user);

            return redirect()->route('seller.dashboard')
                ->with('status', 'Kamu masuk sebagai akun demo Disyan 3D Studio.');
        }

        return redirect()->route('public.store', $seller);
    }
}
