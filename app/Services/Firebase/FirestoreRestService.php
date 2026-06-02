<?php

namespace App\Services\Firebase;

use DateTimeInterface;
use Google\Auth\Credentials\ServiceAccountCredentials;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use RuntimeException;

class FirestoreRestService
{
    private ?string $accessToken = null;

    public function __construct(private readonly FirebaseCredentials $credentials) {}

    public function enabled(): bool
    {
        return $this->credentials->enabled();
    }

    public function upsert(string $collection, string $documentId, array $data): void
    {
        if (! $this->enabled()) {
            return;
        }

        $this->client()->patch($this->documentPath($collection, $documentId), [
            'json' => [
                'fields' => $this->encodeFields($data),
            ],
        ]);
    }

    public function delete(string $collection, string $documentId): void
    {
        if (! $this->enabled()) {
            return;
        }

        $this->client()->delete($this->documentPath($collection, $documentId));
    }

    private function client(): Client
    {
        return new Client([
            'base_uri' => 'https://firestore.googleapis.com/v1/',
            'headers' => [
                'Authorization' => 'Bearer '.$this->token(),
                'Accept' => 'application/json',
            ],
            'timeout' => 20,
        ]);
    }

    private function documentPath(string $collection, string $documentId): string
    {
        $database = config('firebase.database', '(default)');
        $project = $this->credentials->projectId();

        return 'projects/'.rawurlencode($project)
            .'/databases/'.rawurlencode($database)
            .'/documents/'
            .trim($collection, '/')
            .'/'
            .rawurlencode($documentId);
    }

    private function token(): string
    {
        if ($this->accessToken) {
            return $this->accessToken;
        }

        $credentials = new ServiceAccountCredentials(
            ['https://www.googleapis.com/auth/datastore'],
            $this->credentials->keyFile(),
        );

        $token = $credentials->fetchAuthToken();

        if (! isset($token['access_token'])) {
            throw new RuntimeException('Failed to fetch Firebase access token.');
        }

        return $this->accessToken = $token['access_token'];
    }

    private function encodeFields(array $data): array
    {
        return collect($data)
            ->map(fn ($value) => $this->encodeValue($value))
            ->all();
    }

    private function encodeValue(mixed $value): array
    {
        if ($value instanceof DateTimeInterface) {
            return ['timestampValue' => $value->format(DATE_ATOM)];
        }

        if (is_null($value)) {
            return ['nullValue' => null];
        }

        if (is_bool($value)) {
            return ['booleanValue' => $value];
        }

        if (is_int($value)) {
            return ['integerValue' => (string) $value];
        }

        if (is_float($value)) {
            return ['doubleValue' => $value];
        }

        if (is_array($value)) {
            if (Arr::isAssoc($value)) {
                return ['mapValue' => ['fields' => $this->encodeFields($value)]];
            }

            return ['arrayValue' => [
                'values' => array_map(fn ($item) => $this->encodeValue($item), $value),
            ]];
        }

        return ['stringValue' => (string) $value];
    }
}
