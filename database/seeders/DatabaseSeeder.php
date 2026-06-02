<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ],
        );

        $seller = Seller::firstOrCreate(
            ['slug' => 'disyanz3d'],
            [
                'brand_name' => 'Disyan 3D Studio',
                'category' => 'Jasa desain & cetak 3D',
                'whatsapp' => '081234567890',
                'location' => 'Surabaya, Indonesia',
                'description' => 'Melayani desain produk, mini figure, prototype casing, dan spare part custom berbasis 3D printing.',
                'qris_path' => 'https://firebasestorage.googleapis.com/v0/b/buatin-id-34ac3.firebasestorage.app/o/qris%2F0208e62e-bb3c-4596-a036-951d855c420e.png?alt=media&token=172235ba-cb20-433e-aeca-6f340dfe1de2',
                'payment_account' => 'QRIS Demo Disyan 3D Studio',
                'payment_instructions' => 'Scan QRIS demo ini, lalu upload bukti pembayaran untuk melanjutkan pesanan.',
                'qris_enabled' => true,
                'form_fields' => [
                    'material' => true,
                    'size' => true,
                    'color' => true,
                    'quantity' => true,
                    'deadline' => true,
                    'budget' => true,
                    'reference' => true,
                    'notes' => true,
                ],
            ],
        );

        if (! $seller->qris_path) {
            $seller->update([
                'qris_path' => 'https://firebasestorage.googleapis.com/v0/b/buatin-id-34ac3.firebasestorage.app/o/qris%2F0208e62e-bb3c-4596-a036-951d855c420e.png?alt=media&token=172235ba-cb20-433e-aeca-6f340dfe1de2',
                'payment_account' => 'QRIS Demo Disyan 3D Studio',
                'payment_instructions' => 'Scan QRIS demo ini, lalu upload bukti pembayaran untuk melanjutkan pesanan.',
                'qris_enabled' => true,
            ]);
        }

        $products = [
            ['Mini figure custom', 'Figur custom berbasis referensi karakter pelanggan.', 'Figurine', 150000],
            ['Prototype casing', 'Prototype casing perangkat untuk kebutuhan presentasi produk.', 'Prototype', 90000],
            ['Keychain nama', 'Gantungan kunci nama dan bentuk custom.', 'Merchandise', 35000],
        ];

        foreach ($products as [$name, $description, $category, $price]) {
            Product::firstOrCreate(
                ['seller_id' => $seller->id, 'name' => $name],
                [
                    'description' => $description,
                    'category' => $category,
                    'starting_price' => $price,
                    'is_featured' => true,
                ],
            );
        }
    }
}
