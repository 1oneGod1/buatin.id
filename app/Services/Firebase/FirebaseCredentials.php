<?php

namespace App\Services\Firebase;

use RuntimeException;

class FirebaseCredentials
{
    public function enabled(): bool
    {
        return (bool) config('firebase.enabled') && $this->hasCredentials();
    }

    public function configured(): bool
    {
        return (bool) config('firebase.enabled');
    }

    public function hasCredentials(): bool
    {
        return (bool) (
            config('firebase.credentials_base64')
            || config('firebase.credentials_json')
            || config('firebase.credentials_path')
        );
    }

    public function projectId(): string
    {
        $projectId = config('firebase.project_id');

        if (! $projectId) {
            throw new RuntimeException('FIREBASE_PROJECT_ID is not configured.');
        }

        return $projectId;
    }

    public function keyFile(): array
    {
        $json = null;

        if ($encoded = config('firebase.credentials_base64')) {
            $json = base64_decode($encoded, true);

            if ($json === false) {
                throw new RuntimeException('FIREBASE_CREDENTIALS_BASE64 is not valid base64.');
            }
        } elseif ($rawJson = config('firebase.credentials_json')) {
            $json = $rawJson;
        } elseif ($path = config('firebase.credentials_path')) {
            if (! is_file($path)) {
                throw new RuntimeException("Firebase credential file does not exist: {$path}");
            }

            $json = file_get_contents($path);
        }

        if (! $json) {
            throw new RuntimeException('Firebase credentials are missing.');
        }

        $keyFile = json_decode($json, true);

        if (! is_array($keyFile)) {
            throw new RuntimeException('Firebase credentials are not valid JSON.');
        }

        return $keyFile;
    }
}
