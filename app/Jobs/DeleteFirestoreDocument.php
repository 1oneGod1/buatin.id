<?php

namespace App\Jobs;

use App\Services\Firebase\FirestoreRestService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class DeleteFirestoreDocument implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    /** @var array<int> */
    public array $backoff = [10, 60];

    public function __construct(
        public readonly string $collection,
        public readonly string $documentId,
    ) {}

    public function handle(FirestoreRestService $firestore): void
    {
        $firestore->delete($this->collection, $this->documentId);
    }
}
