# PesanKustom.id

PesanKustom.id adalah MVP aplikasi web untuk membantu kreator dan UMKM menerima pesanan custom dengan lebih rapi. Aplikasi ini menggabungkan katalog produk, form brief pesanan, upload referensi, QRIS, WhatsApp handoff, dan status pesanan dalam satu alur.

> Catatan: repository dan beberapa nama infrastruktur masih memakai nama lama `buatin.id` karena dibuat sebelum rebranding. Nama produk yang ditampilkan ke pengguna adalah **PesanKustom.id**.

## Konteks Produk

Masalah yang diselesaikan:

- Detail pesanan custom sering tersebar di chat WhatsApp atau Instagram.
- Penjual harus menanyakan brief, ukuran, bahan, warna, referensi, dan deadline secara berulang.
- Risiko salah memahami permintaan pelanggan cukup tinggi.
- Penjual pemula sulit menampilkan portofolio dan menerima order secara profesional tanpa membuat website mahal.

Solusi MVP:

- Penjual membuat halaman toko publik.
- Pelanggan melihat katalog dan mengisi form brief.
- Sistem membuat ringkasan pesanan.
- Pembayaran awal dilakukan melalui QRIS manual.
- Ringkasan pesanan bisa dikirim ke WhatsApp penjual.
- Pelanggan dapat memantau status pesanan menggunakan kode order.

## Product Backlog Yang Diimplementasikan

| ID | Backlog | Implementasi |
| --- | --- | --- |
| PB-01 | Landing dan onboarding seller | Landing page, register/login, onboarding toko |
| PB-02 | Halaman toko publik | Route `/{seller:slug}` untuk toko publik |
| PB-03 | Katalog/portofolio produk | Product manager dan katalog toko |
| PB-04 | Form brief pesanan custom | Form order pelanggan dengan field brief |
| PB-05 | Ringkasan, QRIS, dan WhatsApp | Order summary, QRIS, upload bukti, WhatsApp handoff |
| PB-06 | Dashboard seller | Statistik kunjungan, produk, order baru, belum bayar, selesai |
| PB-07 | Page builder dan product manager | Pengaturan profil toko dan CRUD produk custom |
| PB-08 | Form builder dan setting QRIS | Pengaturan field form dan pembayaran QRIS |
| PB-09 | Order list, detail, timeline status | Daftar order, detail order, update status |
| PB-10 | Customer status page | Cek status pesanan dengan kode order |
| PB-11 | Testing, responsive, deployment | Feature test, Vite build, Docker/Render deployment |

Fitur pendukung:

- Firebase Authentication untuk akun seller.
- Firebase Storage untuk penyimpanan file/foto.
- Simulasi paket freemium sebagai bagian model bisnis.

## Alur Demo

Demo disarankan mengikuti urutan backlog:

1. Landing page PesanKustom.id.
2. Login atau masuk sebagai akun demo.
3. Dashboard seller.
4. Page builder.
5. Product manager.
6. Form builder.
7. QRIS/payment setting.
8. Halaman toko publik.
9. Form order pelanggan.
10. Ringkasan pesanan, QRIS, dan WhatsApp.
11. Cek status pesanan.
12. Order list/detail di dashboard seller.

## Tech Stack

- Laravel 13
- PHP 8.4
- Blade
- Tailwind CSS 4
- Vite
- SQLite untuk lokal
- PostgreSQL untuk Render
- Firebase Authentication
- Firebase Storage
- Render Docker deployment

## Link

- GitHub repository: <https://github.com/1oneGod1/buatin.id>
- Demo Render: <https://buatin-id-1.onrender.com/>

## Menjalankan Project Lokal

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run build
php artisan serve
```

Lalu buka:

```text
http://127.0.0.1:8000
```

Untuk masuk sebagai akun demo:

```text
http://127.0.0.1:8000/demo
```

## Environment Penting

Contoh konfigurasi utama:

```env
APP_NAME=PesanKustom.id
APP_ENV=local
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=sqlite

FIREBASE_ENABLED=true
FIREBASE_PROJECT_ID=your-firebase-project-id
FIREBASE_STORAGE_BUCKET=your-firebase-storage-bucket
FIREBASE_CREDENTIALS_BASE64=

FIREBASE_WEB_API_KEY=
FIREBASE_WEB_AUTH_DOMAIN=
FIREBASE_WEB_SENDER_ID=
FIREBASE_WEB_APP_ID=
```

Isi nilai Firebase di `.env` lokal atau Environment Variables Render. Jangan menuliskan kredensial asli di README, source code, commit GitHub, atau file yang dikumpulkan.

Jangan commit file berikut:

- `.env`
- Firebase service account JSON
- private key
- nilai asli `FIREBASE_CREDENTIALS_BASE64`
- kredensial/API config yang tidak ingin dipublikasikan
- `vendor/`
- `node_modules/`

## Deployment Render

Project sudah menyiapkan:

- `Dockerfile`
- `render.yaml`
- `scripts/render-start.sh`

Pada Render, env penting yang perlu diisi:

- `APP_KEY`
- `APP_URL`
- `DB_URL` atau `DATABASE_URL`
- `FIREBASE_ENABLED`
- `FIREBASE_PROJECT_ID`
- `FIREBASE_STORAGE_BUCKET`
- `FIREBASE_CREDENTIALS_BASE64`
- Firebase Web Auth env jika menggunakan login/register berbasis Firebase.

Panduan detail tersedia di:

- `docs/DEPLOY_RENDER.md`
- `docs/FIREBASE_SETUP.md`

## Testing

Jalankan:

```bash
php artisan test
```

Status terakhir sebelum update README:

```text
18 tests passed
74 assertions
```

## Struktur Penting

```text
app/Http/Controllers        Controller seller, customer order, auth, dan demo
app/Jobs                    Queued job sinkronisasi dokumen Firestore
app/Models                  Model User, Seller, Product, CustomOrder
app/Services/Firebase       Service Firebase Auth, Storage, dan Sync
database/migrations         Struktur tabel utama
database/seeders            Data demo Disyan 3D Studio
resources/views             Blade views untuk landing, seller, public store, auth
routes/web.php              Route utama aplikasi
tests/Feature               Feature test MVP
```

## Catatan Presentasi AFL3

Untuk presentasi maksimal 15 menit, fokuskan narasi pada:

1. Pelaksanaan 2 sprint yang sudah dilakukan.
2. GitHub repository performance.
3. Demo aplikasi sesuai Product Backlog.

Firebase Auth, Firebase Storage, dan subscription adalah pendukung teknis/model bisnis. Saat presentasi, jangan menjadikannya fokus utama agar tetap selaras dengan backlog.
