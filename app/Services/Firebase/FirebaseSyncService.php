<?php

namespace App\Services\Firebase;

use App\Jobs\DeleteFirestoreDocument;
use App\Jobs\UpsertFirestoreDocument;
use App\Models\CustomOrder;
use App\Models\Product;
use App\Models\Seller;

/**
 * Mirrors local data to Firestore through queued jobs so HTTP requests never
 * wait on (or fail because of) the Firestore API. The document payload is
 * snapshotted at dispatch time; the queue worker performs the network call
 * and retries transient failures. The local database is the source of truth.
 */
class FirebaseSyncService
{
    public function __construct(private readonly FirebaseCredentials $credentials) {}

    public function seller(Seller $seller): void
    {
        $this->upsert('sellers', $seller->slug, [
            'id' => $seller->id,
            'brand_name' => $seller->brand_name,
            'slug' => $seller->slug,
            'category' => $seller->category,
            'whatsapp' => $seller->whatsapp,
            'location' => $seller->location,
            'description' => $seller->description,
            'logo_path' => $seller->logo_path,
            'banner_path' => $seller->banner_path,
            'qris_path' => $seller->qris_path,
            'payment_account' => $seller->payment_account,
            'payment_instructions' => $seller->payment_instructions,
            'qris_enabled' => $seller->qris_enabled,
            'form_fields' => $seller->enabledFields(),
            'plan' => $seller->plan,
            'subscription_status' => $seller->subscription_status,
            'public_url' => $seller->public_url,
            'created_at' => $seller->created_at,
            'updated_at' => $seller->updated_at,
        ]);
    }

    public function product(Product $product): void
    {
        $this->upsert('products', (string) $product->id, [
            'id' => $product->id,
            'seller_id' => $product->seller_id,
            'seller_slug' => $product->seller?->slug,
            'name' => $product->name,
            'category' => $product->category,
            'description' => $product->description,
            'starting_price' => $product->starting_price,
            'image_path' => $product->image_path,
            'is_featured' => $product->is_featured,
            'created_at' => $product->created_at,
            'updated_at' => $product->updated_at,
        ]);
    }

    public function deleteProduct(string $productId): void
    {
        if (! $this->credentials->enabled()) {
            return;
        }

        rescue(fn () => DeleteFirestoreDocument::dispatch('products', $productId));
    }

    public function order(CustomOrder $order): void
    {
        $this->upsert('orders', $order->order_code, [
            'id' => $order->id,
            'seller_id' => $order->seller_id,
            'seller_slug' => $order->seller?->slug,
            'product_id' => $order->product_id,
            'order_code' => $order->order_code,
            'customer_name' => $order->customer_name,
            'customer_whatsapp' => $order->customer_whatsapp,
            'product_type' => $order->product_type,
            'material' => $order->material,
            'size' => $order->size,
            'color' => $order->color,
            'quantity' => $order->quantity,
            'deadline' => $order->deadline,
            'budget' => $order->budget,
            'notes' => $order->notes,
            'reference_path' => $order->reference_path,
            'estimated_price' => $order->estimated_price,
            'payment_proof_path' => $order->payment_proof_path,
            'payment_status' => $order->payment_status,
            'status' => $order->status,
            'status_label' => $order->status_label,
            'payment_status_label' => $order->payment_status_label,
            'created_at' => $order->created_at,
            'updated_at' => $order->updated_at,
        ]);
    }

    private function upsert(string $collection, string $documentId, array $fields): void
    {
        if (! $this->credentials->enabled()) {
            return;
        }

        // rescue keeps the caller's request alive even when the queue driver
        // is "sync" and the Firestore call itself fails inline.
        rescue(fn () => UpsertFirestoreDocument::dispatch($collection, $documentId, $fields));
    }
}
