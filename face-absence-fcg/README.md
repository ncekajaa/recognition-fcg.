# 🎭 Sistem Absensi Face Recognition Laravel

Sistem absensi modern berbasis pengenalan wajah menggunakan Laravel, TensorFlow.js, dan Face-api.js dengan desain UI/UX yang elegan.

## 🚀 Fitur Utama

- ✅ **Face Recognition** menggunakan Face-api.js
- 📍 **Geolocation Tracking** otomatis
- 🎨 **Modern UI/UX** dengan efek bubble dan glassmorphism
- 📊 **Dashboard CRUD** untuk manajemen user
- 📈 **Riwayat Absensi** lengkap dengan status
- 🔒 **Validasi Wajah** dengan threshold 70%
- 📱 **Responsive Design**

## 📋 Prerequisites

Pastikan Anda sudah menginstal:

- PHP >= 8.1
- Composer
- Laravel >= 10.x
- MySQL/MariaDB
- Node.js & NPM (opsional untuk development)

## 🛠️ Instalasi di Termux

### 1. Setup Environment

```bash
# Update packages
pkg update && pkg upgrade

# Install dependencies
pkg install php mariadb apache2 git

# Install Composer
curl -sS https://getcomposer.org/installer | php
mv composer.phar $PREFIX/bin/composer

# Clone atau buat project Laravel
composer create-project laravel/laravel absensi-face
cd absensi-face
```

### 2. Konfigurasi Database

```bash
# Start MariaDB
mysqld_safe -u root &

# Buat database
mysql -u root -e "CREATE DATABASE absensi_db;"
mysql -u root -e "CREATE USER 'absensi_user'@'localhost' IDENTIFIED BY 'password123';"
mysql -u root -e "GRANT ALL PRIVILEGES ON absensi_db.* TO 'absensi_user'@'localhost';"
mysql -u root -e "FLUSH PRIVILEGES;"
```

### 3. Konfigurasi .env

Edit file `.env`:

```env
APP_NAME="FaceAbsen"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=absensi_db
DB_USERNAME=absensi_user
DB_PASSWORD=password123
```

Generate APP_KEY:

```bash
php artisan key:generate
```

### 4. Buat Struktur File

#### A. Migration Files

Buat file migration di `database/migrations/`:

**File: `YYYY_MM_DD_000001_create_data_user_table.php`**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_user', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('image');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_user');
    }
};
```

**File: `YYYY_MM_DD_000002_create_data_absen_table.php`**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_absen', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->text('location');
            $table->enum('status', ['success', 'failed']);
            $table->timestamp('time_absen');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_absen');
    }
};
```

#### B. Models

**File: `app/Models/UserData.php`**

Copy kode dari artifact yang sudah dibuat.

**File: `app/Models/UserAbsen.php`**

Copy kode dari artifact yang sudah dibuat.

#### C. Controllers

**File: `app/Http/Controllers/DataController.php`**

Copy kode dari artifact yang sudah dibuat.

**File: `app/Http/Controllers/AbsenController.php`**

Copy kode dari artifact yang sudah dibuat.

#### D. Views

Buat folder dan file views:

```bash
mkdir -p resources/views/layouts
```

**File: `resources/views/layouts/app.blade.php`**

Copy kode dari artifact yang sudah dibuat.

**File: `resources/views/dashboard.blade.php`**

Copy kode dari artifact yang sudah dibuat.

**File: `resources/views/index.blade.php`**

Copy kode dari artifact yang sudah dibuat.

#### E. Routes

**File: `routes/web.php`**

Copy kode dari artifact yang sudah dibuat.

### 5. Download Face-api.js Models

```bash
# Buat folder models
mkdir -p public/models

# Download models (gunakan wget atau curl)
cd public/models

# Tiny Face Detector Model
wget https://raw.githubusercontent.com/justadudewhohacks/face-api.js-models/master/tiny_face_detector_model-weights_manifest.json
wget https://raw.githubusercontent.com/justadudewhohacks/face-api.js-models/master/tiny_face_detector_model-shard1

# Face Landmark Model
wget https://raw.githubusercontent.com/justadudewhohacks/face-api.js-models/master/face_landmark_68_model-weights_manifest.json
wget https://raw.githubusercontent.com/justadudewhohacks/face-api.js-models/master/face_landmark_68_model-shard1

# Face Recognition Model
wget https://raw.githubusercontent.com/justadudewhohacks/face-api.js-models/master/face_recognition_model-weights_manifest.json
wget https://raw.githubusercontent.com/justadudewhohacks/face-api.js-models/master/face_recognition_model-shard1
wget https://raw.githubusercontent.com/justadudewhohacks/face-api.js-models/master/face_recognition_model-shard2

cd ../..
```

**Alternatif: Download Manual**

Jika wget tidak tersedia, download file-file berikut secara manual dan simpan di `public/models/`:

- `tiny_face_detector_model-weights_manifest.json`
- `tiny_face_detector_model-shard1`
- `face_landmark_68_model-weights_manifest.json`
- `face_landmark_68_model-shard1`
- `face_recognition_model-weights_manifest.json`
- `face_recognition_model-shard1`
- `face_recognition_model-shard2`

URL: https://github.com/justadudewhohacks/face-api.js-models/tree/master/

### 6. Buat Folder Upload

```bash
mkdir -p public/uploads
chmod 755 public/uploads
```

### 7. Jalankan Migration

```bash
php artisan migrate
```

### 8. Jalankan Aplikasi

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

Akses aplikasi di: `http://localhost:8000`

## 📱 Cara Menggunakan

### 1. Registrasi User (Dashboard)

1. Buka `http://localhost:8000/dashboard`
2. Isi form "Tambah Data User":
   - Masukkan username
   - Upload foto wajah (JPEG/PNG)
3. Klik "Simpan Data"

### 2. Melakukan Absensi

1. Buka `http://localhost:8000`
2. **Step 1: Username & Lokasi**
   - Masukkan username yang sudah terdaftar
   - Klik "Ambil Lokasi & Lanjutkan"
   - Browser akan meminta izin akses lokasi
3. **Step 2: Verifikasi Wajah**
   - Izinkan akses kamera
   - Tunggu model AI selesai dimuat
   - Posisikan wajah Anda di depan kamera
   - Klik "Ambil Foto & Verifikasi"
4. Sistem akan membandingkan wajah Anda dengan foto di database
5. Jika kemiripan >= 70%, absensi **BERHASIL** → redirect ke dashboard
6. Jika kemiripan < 70%, absensi **GAGAL** → kembali ke form

### 3. Monitoring (Dashboard)

- Lihat data user terdaftar
- Lihat riwayat absensi (berhasil/gagal)
- Hapus data user atau absensi
- Cek lokasi absensi via Google Maps

## 🎨 Teknologi yang Digunakan

- **Backend**: Laravel 10.x
- **Face Recognition**: Face-api.js, TensorFlow.js
- **Database**: MySQL/MariaDB
- **Frontend**: Blade Template, Vanilla JavaScript
- **Icons**: Font Awesome 6.4
- **Styling**: Custom CSS (Glassmorphism, Bubble Effects)

## 📂 Struktur Folder

```
absensi-face/
├── app/
│   ├── Http/Controllers/
│   │   ├── AbsenController.php
│   │   └── DataController.php
│   └── Models/
│       ├── UserData.php
│       └── UserAbsen.php
├── database/migrations/
│   ├── xxxx_create_data_user_table.php
│   └── xxxx_create_data_absen_table.php
├── public/
│   ├── models/         # Face-api.js models
│   └── uploads/        # User images
├── resources/views/
│   ├── layouts/
│   │   └── app.blade.php
│   ├── dashboard.blade.php
│   └── index.blade.php
└── routes/
    └── web.php
```

## 🔧 Troubleshooting

### Error: Class not found

```bash
composer dump-autoload
```

### Error: Permission denied (uploads)

```bash
chmod -R 755 public/uploads
```

### Error: Models tidak terdeteteksi

Pastikan file model sudah ada di `public/models/` dan akses internet stabil saat load pertama kali.

### Error: Camera tidak bisa akses

- Pastikan browser support getUserMedia API
- Gunakan HTTPS atau localhost
- Izinkan akses kamera di browser

### Error: Database connection refused

```bash
# Restart MariaDB
killall mysqld
mysqld_safe -u root &
```

## 🌟 Fitur Advanced (Opsional)

### Menambah Email Notification

Install package:

```bash
composer require laravel/mail
```

Konfigurasi di `.env` dan tambahkan notifikasi email saat absensi berhasil.

### Export Data ke Excel

Install package:

```bash
composer require maatwebsite/excel
```

Tambahkan fungsi export di DataController.

## 📝 Catatan Penting

1. **Kemiripan Wajah**: Threshold default 70%, bisa diubah di `index.blade.php` baris `const status = similarity >= 70`.
2. **Format Foto**: Gunakan foto wajah yang jelas, frontal, dan lighting baik.
3. **Browser Support**: Chrome, Firefox, Edge (terbaru). Safari kadang issue dengan camera API.
4. **HTTPS**: Untuk production, gunakan HTTPS karena Geolocation API memerlukan secure context.

## 🤝 Support

Jika ada pertanyaan atau kendala:

1. Check dokumentasi Laravel: https://laravel.com/docs
2. Face-api.js docs: https://github.com/justadudewhohacks/face-api.js
3. Buka issue di repository

## 📄 License

MIT License - Bebas digunakan untuk keperluan pribadi maupun komersial.

---

**Developed with ❤️ using Laravel & Face-api.js**

🎯 Happy Coding! 🚀