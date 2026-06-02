<?php

namespace App\Services\Firebase;

use Google\Cloud\Storage\StorageClient;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage as LaravelStorage;
use Illuminate\Support\Str;

class FirebaseStorageService
{
    public function __construct(private readonly FirebaseCredentials $credentials) {}

    public function upload(UploadedFile $file, string $directory): string
    {
        if (! $this->credentials->enabled()) {
            return $file->store($directory, 'public');
        }

        $bucketName = config('firebase.storage_bucket');
        $extension = $file->guessExtension() ?: $file->getClientOriginalExtension() ?: 'bin';
        $objectName = trim($directory, '/').'/'.Str::uuid().'.'.$extension;
        $token = (string) Str::uuid();

        $storage = new StorageClient([
            'projectId' => $this->credentials->projectId(),
            'keyFile' => $this->credentials->keyFile(),
        ]);

        $bucket = $storage->bucket($bucketName);

        $bucket->upload(fopen($file->getRealPath(), 'r'), [
            'name' => $objectName,
            'metadata' => [
                'contentType' => $file->getMimeType(),
                'metadata' => [
                    'firebaseStorageDownloadTokens' => $token,
                ],
            ],
        ]);

        return $this->downloadUrl($bucketName, $objectName, $token);
    }

    public function delete(?string $path): void
    {
        if (! $path) {
            return;
        }

        if (! $this->credentials->enabled()) {
            LaravelStorage::disk('public')->delete($path);

            return;
        }

        $objectName = $this->objectNameFromPath($path);

        if (! $objectName) {
            return;
        }

        $storage = new StorageClient([
            'projectId' => $this->credentials->projectId(),
            'keyFile' => $this->credentials->keyFile(),
        ]);

        $object = $storage
            ->bucket(config('firebase.storage_bucket'))
            ->object($objectName);

        if ($object->exists()) {
            $object->delete();
        }
    }

    public function url(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return asset('storage/'.$path);
    }

    private function downloadUrl(string $bucket, string $objectName, string $token): string
    {
        return 'https://firebasestorage.googleapis.com/v0/b/'
            .rawurlencode($bucket)
            .'/o/'
            .rawurlencode($objectName)
            .'?alt=media&token='
            .$token;
    }

    private function objectNameFromPath(string $path): ?string
    {
        if (! str_starts_with($path, 'http://') && ! str_starts_with($path, 'https://')) {
            return $path;
        }

        $parts = parse_url($path);

        if (! isset($parts['path'])) {
            return null;
        }

        if (! preg_match('#/o/([^?]+)#', $parts['path'], $matches)) {
            return null;
        }

        return rawurldecode($matches[1]);
    }
}
