# Deploy Buatin.id ke Render

Panduan ini dipakai untuk membuat link online Buatin.id agar bisa dipakai usability testing.

## Persiapan

1. Push project ini ke GitHub.
2. Buat APP_KEY lokal:

```bash
php artisan key:generate --show
```

Simpan output-nya. Contoh formatnya seperti `base64:...`.

3. Buat Firebase service account:
   - Buka Firebase Console.
   - Masuk ke **Project settings**.
   - Buka tab **Service accounts**.
   - Klik **Generate new private key**.
   - Simpan file JSON di komputer, jangan commit ke GitHub.

4. Convert service account JSON ke base64.

PowerShell:

```powershell
[Convert]::ToBase64String([IO.File]::ReadAllBytes("C:\path\to\serviceAccountKey.json"))
```

Output panjang dari command itu nanti dipakai untuk env `FIREBASE_CREDENTIALS_BASE64`.

## Cara Deploy

1. Login ke Render.
2. Pilih **New +** lalu **Blueprint**.
3. Hubungkan repository GitHub Buatin.id.
4. Render akan membaca `render.yaml` dan membuat:
   - Web Service Docker `buatin-id`
   - Render Postgres `buatin-id-db`
5. Saat Render meminta environment variable:
   - `APP_KEY`: isi dengan hasil `php artisan key:generate --show`
   - `APP_URL`: isi dengan URL Render setelah service dibuat, misalnya `https://buatin-id.onrender.com`
   - `FIREBASE_CREDENTIALS_BASE64`: isi dengan service account JSON yang sudah diubah ke base64
6. Deploy.

## Jika Deploy Menampilkan `Running '.'`

Jika log Render berisi:

```text
==> Running '.'
bash: line 1: .: filename argument required
```

Artinya service Render dibuat dengan runtime/start command yang salah. Perbaikannya:

1. Buka service `buatin-id` di Render.
2. Masuk ke **Settings**.
3. Cek **Runtime**. Untuk app ini harus **Docker**, bukan Node.
4. Jika ada **Start Command** berisi `.`, hapus isinya.
5. Untuk Docker, Start Command boleh dikosongkan karena Dockerfile sudah punya:

```text
CMD ["sh", "scripts/render-start.sh"]
```

6. Jika Render tidak mengizinkan mengganti runtime menjadi Docker, buat service baru lewat **New + > Blueprint** dari repo ini.

## Catatan Penting

- Render Postgres plan gratis cocok untuk testing, tetapi database gratis punya batas waktu dan limit. Jangan dipakai sebagai database bisnis sungguhan.
- File upload seperti logo, banner, QRIS, referensi, dan bukti pembayaran sudah diarahkan ke Firebase Storage saat `FIREBASE_ENABLED=true`.
- Data seller, product, dan order akan disinkronkan ke Firestore lewat command `php artisan firebase:sync`.
- Aplikasi masih memakai database Laravel untuk session, cache, dan operasional server-side. Firestore dipakai sebagai penyimpanan/sinkronisasi data Firebase agar data testing dapat dilihat di Firebase Console.
- Seeder akan otomatis membuat data demo `Disyan 3D Studio` saat deploy, lalu disinkronkan ke Firestore.

## URL Demo Setelah Deploy

- Landing: `/`
- Toko demo: `/disyanz3d`
- Form order pelanggan: `/disyanz3d/order`
- Dashboard penjual: `/seller/dashboard`
- Cek status pesanan: `/status`
