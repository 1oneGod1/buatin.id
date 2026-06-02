<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

#[Fillable([
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
])]
class Seller extends Model
{
    protected function casts(): array
    {
        return [
            'qris_enabled' => 'boolean',
            'form_fields' => 'array',
        ];
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

    protected function publicUrl(): Attribute
    {
        return Attribute::get(fn () => url($this->slug));
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
