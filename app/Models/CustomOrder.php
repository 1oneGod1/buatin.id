<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'seller_id',
    'product_id',
    'order_code',
    'customer_name',
    'customer_whatsapp',
    'product_type',
    'material',
    'size',
    'color',
    'quantity',
    'deadline',
    'budget',
    'notes',
    'reference_path',
    'estimated_price',
    'payment_proof_path',
    'payment_status',
    'status',
])]
class CustomOrder extends Model
{
    public function getRouteKeyName(): string
    {
        return 'order_code';
    }

    protected function casts(): array
    {
        return [
            'deadline' => 'date',
            'estimated_price' => 'integer',
            'quantity' => 'integer',
        ];
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    protected function statusLabel(): Attribute
    {
        return Attribute::get(fn () => [
            'received' => 'Pesanan diterima',
            'waiting_payment' => 'Menunggu pembayaran',
            'processing' => 'Diproses',
            'ready' => 'Siap diambil/dikirim',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ][$this->status] ?? 'Pesanan diterima');
    }

    protected function paymentStatusLabel(): Attribute
    {
        return Attribute::get(fn () => [
            'unpaid' => 'Belum bayar',
            'proof_uploaded' => 'Bukti diunggah',
            'paid' => 'Lunas/terkonfirmasi',
        ][$this->payment_status] ?? 'Belum bayar');
    }

    public function whatsappSummary(): string
    {
        $lines = [
            "Halo {$this->seller->brand_name}, saya ingin konfirmasi pesanan custom.",
            "Order: {$this->order_code}",
            "Nama: {$this->customer_name}",
            "Produk: {$this->product_type}",
            "Material: ".($this->material ?: '-'),
            "Ukuran: ".($this->size ?: '-'),
            "Warna: ".($this->color ?: '-'),
            "Jumlah: {$this->quantity}",
            "Deadline: ".($this->deadline?->format('d M Y') ?: '-'),
            "Budget: ".($this->budget ?: '-'),
            "Estimasi: Rp ".number_format($this->estimated_price, 0, ',', '.'),
        ];

        return implode("\n", $lines);
    }
}
