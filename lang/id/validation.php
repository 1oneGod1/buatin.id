<?php

/*
|--------------------------------------------------------------------------
| Pesan Validasi (Bahasa Indonesia)
|--------------------------------------------------------------------------
|
| Mencakup aturan yang dipakai aplikasi ini. Aturan yang tidak tercantum
| akan memakai pesan bawaan (bahasa Inggris) sebagai fallback.
|
*/

return [
    'accepted' => ':attribute harus disetujui.',
    'after' => ':attribute harus tanggal setelah :date.',
    'after_or_equal' => ':attribute tidak boleh tanggal yang sudah lewat.',
    'boolean' => ':attribute harus bernilai ya atau tidak.',
    'date' => ':attribute bukan tanggal yang valid.',
    'email' => ':attribute harus berupa alamat email yang valid.',
    'exists' => ':attribute yang dipilih tidak valid.',
    'file' => ':attribute harus berupa file.',
    'image' => ':attribute harus berupa gambar.',
    'in' => ':attribute yang dipilih tidak valid.',
    'integer' => ':attribute harus berupa angka.',
    'max' => [
        'numeric' => ':attribute maksimal :max.',
        'file' => ':attribute maksimal :max kilobyte.',
        'string' => ':attribute maksimal :max karakter.',
    ],
    'mimes' => ':attribute harus berupa file: :values.',
    'min' => [
        'numeric' => ':attribute minimal :min.',
        'file' => ':attribute minimal :min kilobyte.',
        'string' => ':attribute minimal :min karakter.',
    ],
    'numeric' => ':attribute harus berupa angka.',
    'required' => ':attribute wajib diisi.',
    'string' => ':attribute harus berupa teks.',
    'uploaded' => ':attribute gagal diunggah. Coba lagi dengan file yang lebih kecil.',

    'attributes' => [
        'banner' => 'banner',
        'brand_name' => 'nama brand',
        'budget' => 'budget',
        'category' => 'kategori',
        'color' => 'warna',
        'customer_name' => 'nama pelanggan',
        'customer_whatsapp' => 'nomor WhatsApp',
        'deadline' => 'deadline',
        'description' => 'deskripsi',
        'email' => 'email',
        'id_token' => 'sesi masuk',
        'image' => 'foto produk',
        'location' => 'lokasi',
        'logo' => 'logo',
        'material' => 'bahan',
        'name' => 'nama produk',
        'notes' => 'catatan',
        'order_code' => 'kode pesanan',
        'password' => 'password',
        'payment_account' => 'nama akun pembayaran',
        'payment_instructions' => 'instruksi pembayaran',
        'payment_proof' => 'bukti pembayaran',
        'payment_status' => 'status pembayaran',
        'plan' => 'paket',
        'product_id' => 'produk acuan',
        'product_type' => 'tipe pesanan custom',
        'qris' => 'gambar QRIS',
        'qris_enabled' => 'status QRIS',
        'quantity' => 'jumlah',
        'reference' => 'file referensi',
        'size' => 'ukuran',
        'starting_price' => 'harga mulai',
        'status' => 'status pesanan',
        'whatsapp' => 'nomor WhatsApp',
    ],
];
