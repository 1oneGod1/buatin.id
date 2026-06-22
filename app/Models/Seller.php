<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

#[Fillable([
    'user_id',
    'brand_name',
    'slug',
    'category',
    'whatsapp',
    'location',
    'description',
    'logo_path',
    'banner_path',
    'qris_path',
    'payment_account',
    'payment_instructions',
    'qris_enabled',
    'form_fields',
    'plan',
    'subscription_status',
    'views',
])]
class Seller extends Model
{
    protected function casts(): array
    {
        return [
            'qris_enabled' => 'boolean',
            'form_fields' => 'array',
            'views' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function customOrders(): HasMany
    {
        return $this->hasMany(CustomOrder::class);
    }

    public function enabledFields(): array
    {
        return $this->form_fields ?: [
            'material' => true,
            'size' => true,
            'color' => true,
            'quantity' => true,
            'deadline' => true,
            'budget' => true,
            'reference' => true,
            'notes' => true,
        ];
    }

    public function planLabel(): string
    {
        return [
            'free' => 'Free',
            'starter' => 'Starter',
            'pro' => 'Pro',
        ][$this->plan ?? 'free'] ?? 'Free';
    }

    public function productLimit(): ?int
    {
        return match ($this->plan ?? 'free') {
            'free' => 3,
            default => null,
        };
    }

    public function canAddProduct(): bool
    {
        $limit = $this->productLimit();

        return $limit === null || $this->products()->count() < $limit;
    }

    protected function publicUrl(): Attribute
    {
        return Attribute::get(fn () => url($this->slug));
    }

    /**
     * Absolute image URL for link share previews (OpenGraph), or null for default.
     */
    public function shareImage(): ?string
    {
        $path = $this->banner_path ?: $this->logo_path;

        return $path ? app(\App\Services\Firebase\FirebaseStorageService::class)->url($path) : null;
    }

    public static function makeSlug(string $brandName): string
    {
        $base = Str::slug($brandName) ?: 'brand';
        $slug = $base;
        $counter = 2;

        while (self::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
