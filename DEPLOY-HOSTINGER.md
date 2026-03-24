# Deploy Plug and Play ke Hostinger

Dokumen ini untuk deploy project Laravel ini ke Hostinger shared hosting dengan cara upload file siap pakai.

## 1) Buat Paket Deploy Otomatis (Tanpa ZIP)

Jalankan dari PowerShell di root project:

```powershell
powershell -ExecutionPolicy Bypass -File .\scripts\package-hostinger.ps1 -NoZip
```

Hasilnya:

- `deploy/hostinger-package/laravel-app`
- `deploy/hostinger-package/public_html`
- `deploy/hostinger-package/README-UPLOAD.txt`

## 2) Upload ke Hostinger

Di hPanel File Manager, masuk ke folder domain Anda (yang berisi `public_html`), lalu:

1. Upload folder `laravel-app` dan `public_html` dari `deploy/hostinger-package`.
2. Pastikan `laravel-app` dan `public_html` berada pada parent folder yang sama.
3. Timpa isi `public_html` lama jika diminta.

Struktur target:

- `/domains/your-domain/laravel-app`
- `/domains/your-domain/public_html`

## 3) Konfigurasi Environment

Edit file berikut di hosting:

- `laravel-app/.env`

Isi minimal yang wajib:

- `APP_URL=https://domain-anda`
- `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- `APP_DEBUG=false`

## 4) Jalankan Perintah Laravel (Terminal Hostinger)

Masuk ke folder `laravel-app`, lalu jalankan:

```bash
php artisan key:generate --force
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 5) Permission Wajib

Pastikan writable:

- `laravel-app/storage`
- `laravel-app/bootstrap/cache`

## 6) Catatan Penting

- Script packaging otomatis menyesuaikan `public_html/index.php` agar menunjuk ke `../laravel-app`.
- Build asset Vite sudah dipakai dari folder `public/build` yang ikut dipaketkan.
- Jika ada error 500, cek log di `laravel-app/storage/logs/laravel.log`.
