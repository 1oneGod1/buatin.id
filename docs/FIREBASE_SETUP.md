# Firebase Setup PesanKustom.id

Firebase dipakai untuk dua hal:

1. Firebase Storage untuk file upload:
   - logo toko
   - banner toko
   - QRIS
   - file referensi pesanan
   - bukti pembayaran

2. Firestore untuk sinkronisasi data:
   - `sellers`
   - `products`
   - `orders`

## Environment Variable

Untuk lokal, isi `.env` seperti ini jika ingin mengaktifkan Firebase:

```env
FIREBASE_ENABLED=true
FIREBASE_PROJECT_ID=buatin-id-34ac3
FIREBASE_STORAGE_BUCKET=buatin-id-34ac3.firebasestorage.app
FIREBASE_FIRESTORE_DATABASE="(default)"
FIREBASE_CREDENTIALS_PATH=C:\path\to\serviceAccountKey.json
```

Untuk Render, lebih aman pakai:

```env
FIREBASE_CREDENTIALS_BASE64=hasil_base64_dari_service_account_json
```

## Command Sinkronisasi

```bash
php artisan firebase:sync
```

Command ini mengirim data dari database Laravel ke Firestore. Saat deploy Render, command ini otomatis jalan di `scripts/render-start.sh`.

## Catatan Keamanan

- Jangan commit `serviceAccountKey.json`.
- Firebase web config seperti `apiKey`, `authDomain`, dan `projectId` boleh berada di frontend, tetapi private key service account tidak boleh dibagikan.
- Untuk usability testing, service account dipakai server Laravel agar upload dan sync bisa dilakukan tanpa membuka permission Firestore/Storage ke publik.
