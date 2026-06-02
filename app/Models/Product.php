<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'seller_id',
    'name',
    'category',
    'description',
    'starting_price',
    'image_path',
    'is_featured',
])]
class Product extends Model
{
    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'starting_price' => 'integer',
        ];
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    public function customOrders(): HasMany
    {
        return $this->hasMany(CustomOrder::class);
    }
}
