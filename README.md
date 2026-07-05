# SI-GERDU PANDANG
**(Sistem Informasi Gerakan Terpadu Penanganan Penyakit Tidak Menular)**

SI-GERDU PANDANG adalah aplikasi berbasis web yang dirancang khusus untuk memfasilitasi pencatatan, pemantauan, dan pelaporan rekam medis pasien terkait Penyakit Tidak Menular (PTM) seperti Hipertensi, Obesitas, dan Diabetes. Aplikasi ini digunakan oleh jaringan Dinas Kesehatan dan Puskesmas untuk memastikan data klinis pasien terekam dengan akurat, rapi, dan tersentralisasi.

## ✨ Fitur Utama
1. **Manajemen Pengguna (Multi-Role)**
   - **Admin Dinkes**: Memiliki akses global ke seluruh data pasien, pemeriksaan, dan puskesmas di wilayahnya.
   - **Admin Puskesmas**: Memiliki akses terbatas (*data scoping*) hanya untuk mengelola pasien dan pemeriksaan di lingkungan Puskesmasnya sendiri.
2. **Manajemen Data Pasien**
   - Pencatatan identitas lengkap pasien (NIK, JKN, Prolanis).
   - Ekspor profil pasien dan riwayat kunjungan ke dalam format PDF yang siap cetak.
3. **Pemeriksaan Klinis & Rekam Medis**
   - Perhitungan **IMT (Indeks Massa Tubuh)** otomatis sesuai standar KEMENKES RI.
   - Penentuan kategori **Tekanan Darah (Tensi)** secara presisi (Hipotensi, Normal, Pra-Hipertensi, Hipertensi Derajat 1 & 2) berdasarkan standar medis KEMENKES.
   - Fitur opsional pencatatan hasil Laboratorium (GDS, Kolesterol) yang fleksibel.
   - Pembuatan resep dan terapi obat pasien.
   - Cetak (Ekstrak PDF) rekam medis terperinci untuk tiap kunjungan.
4. **Laporan & Ekspor Data**
   - Laporan rekapitulasi data pemeriksaan yang bisa difilter berdasarkan Puskesmas, rentang waktu, dan kategori IMT/Diagnosis.
   - Unduh laporan dalam format **Excel/CSV** atau **PDF**.

## 🛠️ Teknologi yang Digunakan
- **Framework Backend**: [Laravel 11.x](https://laravel.com/) (PHP)
- **Framework Frontend**: [Tailwind CSS](https://tailwindcss.com/) & [Alpine.js](https://alpinejs.dev/) (TALL Stack-lite)
- **Database**: MySQL / MariaDB
- **Pembuatan PDF**: `barryvdh/laravel-dompdf`

## 🚀 Cara Instalasi (Local Development)

Ikuti langkah-langkah di bawah ini untuk menjalankan aplikasi di lingkungan lokal Anda.

### 1. Prasyarat
Pastikan sistem Anda sudah terinstal:
- **PHP** >= 8.3
- **Composer**
- **Node.js** & **NPM**
- **MySQL / XAMPP / Laragon**

### 2. Kloning Repositori
```bash
git clone https://github.com/FahriX3/Si-Gerdu-Pandang.git
cd Si-Gerdu-Pandang
```

### 3. Instalasi Dependensi
```bash
# Instal dependensi backend (PHP)
composer install

# Instal dependensi frontend (Asset)
npm install
npm run build
```

### 4. Konfigurasi Database (Environment)
Salin file konfigurasi utama:
```bash
cp .env.example .env
```
Buka file `.env` dan sesuaikan kredensial koneksi database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=si-gerdu-pandang  # Sesuaikan dengan nama database Anda
DB_USERNAME=root              # Username database
DB_PASSWORD=                  # Password database (kosongkan jika bawaan XAMPP)
```

Generate *application key* baru:
```bash
php artisan key:generate
```

### 5. Migrasi & Seeder Database
Buat database bernama `si-gerdu-pandang` (atau nama lain sesuai pengaturan di `.env`) di MySQL (bisa lewat phpMyAdmin atau klien SQL lain). Setelah itu, jalankan migrasi beserta data awal (*seeder*):
```bash
php artisan migrate:fresh --seed
```
*Catatan: Menjalankan *seeder* akan membuatkan akun default dan data Master Puskesmas agar Anda bisa langsung login.*

### 6. Jalankan Server
```bash
php artisan serve
```
Buka *browser* Anda dan kunjungi `http://localhost:8000`.

---
*Dikembangkan oleh FahriX3 untuk digitalisasi dan efisiensi penanganan penyakit tidak menular.*
