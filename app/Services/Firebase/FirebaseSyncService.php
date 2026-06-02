<?php

namespace App\Services\Firebase;

use App\Models\CustomOrder;
use App\Models\Product;
use App\Models\Seller;

class FirebaseSyncService
{
    public function __construct(private readonly FirestoreRestService $firestore) {}

    public function seller(Seller $seller): void
    {
        $this->firestore->upsert('sellers', $seller->slug, [
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
            'public_url' => $seller->public_url,
            'created_at' => $seller->created_at,
            'updated_at' => $seller->updated_at,
        ]);
    }

    public function product(Product $product): void
    {
        $this->firestore->upsert('products', (string) $product->id, [
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
        $this->firestore->delete('products', $productId);
    }

    public function order(CustomOrder $order): void
    {
        $this->firestore->upsert('orders', $order->order_code, [
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
}
