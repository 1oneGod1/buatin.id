<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Firebase\FirebaseIdTokenVerifier;
use Illuminate\Database\UniqueConstraintViolationException;
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

        // Match by Firebase UID first, then by email so an existing account
        // (created before Firebase linking) is claimed instead of colliding
        // with the unique email index.
        $user = User::where('firebase_uid', $claims['uid'])->first();

        if (! $user && $claims['email']) {
            $user = User::where('email', $claims['email'])->first();
        }

        $attributes = [
            'firebase_uid' => $claims['uid'],
            'email' => $claims['email'] ?? $user?->email,
            'name' => $claims['name'] ?: Str::before($claims['email'] ?? 'Penjual', '@'),
        ];

        try {
            $user ? $user->update($attributes) : $user = User::create($attributes);
        } catch (UniqueConstraintViolationException) {
            // The Firebase email now belongs to a different local account
            // (e.g. changed in Firebase to an address another seller uses).
            return response()->json([
                'message' => 'Email ini sudah terhubung ke akun lain di PesanKustom.id.',
            ], 409);
        }

        // email_verified_at is guarded; set it explicitly from the Firebase claim. Never un-verify.
        if ($claims['email_verified'] && ! $user->hasVerifiedEmail()) {
            $user->forceFill(['email_verified_at' => now()])->save();
        }

        Auth::login($user, remember: true);
        $request->session()->regenerate();

        return response()->json(['redirect' => route('seller.dashboard')]);
    }
}
