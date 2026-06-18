<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Firebase\FirebaseIdTokenVerifier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Throwable;

class FirebaseAuthController extends Controller
{
    public function __construct(private readonly FirebaseIdTokenVerifier $verifier) {}

    /**
     * Exchange a Firebase ID token for a Laravel session.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate(['id_token' => ['required', 'string']]);

        try {
            $claims = $this->verifier->verify($request->string('id_token'));
        } catch (Throwable) {
            return response()->json(['message' => 'Sesi Firebase tidak valid. Coba masuk ulang.'], 401);
        }

        $user = User::updateOrCreate(
            ['firebase_uid' => $claims['uid']],
            [
                'email' => $claims['email'],
                'name' => $claims['name'] ?: Str::before($claims['email'] ?? 'Penjual', '@'),
            ],
        );

        // email_verified_at is guarded; set it explicitly from the Firebase claim. Never un-verify.
        if ($claims['email_verified'] && ! $user->hasVerifiedEmail()) {
            $user->forceFill(['email_verified_at' => now()])->save();
        }

        Auth::login($user, remember: true);
        $request->session()->regenerate();

        return response()->json(['redirect' => route('seller.dashboard')]);
    }
}
