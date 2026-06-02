<?php

namespace App\Console\Commands;

use App\Models\CustomOrder;
use App\Models\Product;
use App\Models\Seller;
use App\Services\Firebase\FirestoreRestService;
use App\Services\Firebase\FirebaseCredentials;
use App\Services\Firebase\FirebaseSyncService;
use Illuminate\Console\Command;

class FirebaseSyncCommand extends Command
{
    protected $signature = 'firebase:sync';

    protected $description = 'Sync Buatin.id sellers, products, and orders to Firebase Firestore.';

    public function handle(FirebaseCredentials $credentials, FirestoreRestService $firestore, FirebaseSyncService $sync): int
    {
        if (! $firestore->enabled()) {
            if ($credentials->configured() && ! $credentials->hasCredentials()) {
                $this->components->warn('Firebase is enabled, but credentials are missing. Skipping sync.');

                return self::SUCCESS;
            }

            $this->components->info('Firebase sync is disabled.');

            return self::SUCCESS;
        }

        Seller::query()->each(fn (Seller $seller) => $sync->seller($seller));
        Product::query()->with('seller')->each(fn (Product $product) => $sync->product($product));
        CustomOrder::query()->with('seller', 'product')->each(fn (CustomOrder $order) => $sync->order($order));

        $this->components->info('Firebase sync completed.');

        return self::SUCCESS;
    }
}
