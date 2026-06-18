<?php

namespace App\Services\Firebase;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Verifies a Firebase Authentication ID token (JWT, RS256) without the Admin SDK,
 * using firebase/php-jwt (already available via google/auth) and Google's
 * public securetoken certificates.
 */
class FirebaseIdTokenVerifier
{
    private const CERTS_URL = 'https://www.googleapis.com/robot/v1/metadata/x509/securetoken@system.gserviceaccount.com';

    public function __construct(private readonly FirebaseCredentials $credentials) {}

    /**
     * @return array{uid:string,email:?string,email_verified:bool,name:?string}
     */
    public function verify(string $idToken): array
    {
        $projectId = $this->credentials->projectId();

        JWT::$leeway = 60; // tolerate small clock skew

        $payload = JWT::decode($idToken, $this->keys());

        if (($payload->aud ?? null) !== $projectId) {
            throw new RuntimeException('Firebase token audience mismatch.');
        }

        if (($payload->iss ?? null) !== "https://securetoken.google.com/{$projectId}") {
            throw new RuntimeException('Firebase token issuer mismatch.');
        }

        $uid = $payload->sub ?? null;

        if (! is_string($uid) || $uid === '') {
            throw new RuntimeException('Firebase token is missing a subject.');
        }

        return [
            'uid' => $uid,
            'email' => $payload->email ?? null,
            'email_verified' => (bool) ($payload->email_verified ?? false),
            'name' => $payload->name ?? null,
        ];
    }

    /**
     * @return array<string, Key>
     */
    private function keys(): array
    {
        $certs = Cache::remember('firebase.securetoken.certs', now()->addHour(), function () {
            $response = Http::acceptJson()->get(self::CERTS_URL);

            if (! $response->successful()) {
                throw new RuntimeException('Unable to fetch Firebase signing certificates.');
            }

            return $response->json();
        });

        $keys = [];

        foreach ($certs as $kid => $certificate) {
            $keys[$kid] = new Key($certificate, 'RS256');
        }

        return $keys;
    }
}
