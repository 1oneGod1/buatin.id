<?php

namespace App\Jobs;

use App\Services\Firebase\FirestoreRestService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class UpsertFirestoreDocument implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    /** @var array<int> */
    public array $backoff = [10, 60];

    public function __construct(
        public readonly string $collection,
        public readonly string $documentId,
        public readonly array $fields,
    ) {}

    public function handle(FirestoreRestService $firestore): void
    {
        $firestore->upsert($this->collection, $this->documentId, $this->fields);
    }
}
