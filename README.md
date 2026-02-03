# ⚽ Ballgrounds - Sistem Informasi Geografis Lapangan Bola

![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Leaflet](https://img.shields.io/badge/Leaflet-GIS-199900?style=for-the-badge&logo=leaflet&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-blue?style=for-the-badge)

**Ballgrounds** adalah aplikasi Sistem Informasi Geografis (SIG) berbasis web untuk memetakan lokasi dan informasi lapangan bola di Kota Payakumbuh. Aplikasi ini dibangun untuk memudahkan masyarakat mencari lokasi lapangan olahraga dan membantu pengelola lapangan dalam mempromosikan fasilitas mereka.

Proyek ini dikembangkan sebagai bagian dari Tugas Akhir/Skripsi Program Studi Informatika.

## 🌟 Fitur Utama

- **Peta Interaktif:** Visualisasi lokasi lapangan menggunakan **Leaflet JS**.
- **Polygon Area:** Menampilkan batas fisik dan luas area lapangan secara presisi di atas peta.
- **Manajemen Data (CRUD):** Admin dapat menambah, mengedit, dan menghapus data lapangan beserta koordinatnya.
- **Manajemen Pengguna:** Sistem autentikasi untuk Admin dan User.
- **Dashboard Statistik:** Ringkasan jumlah lapangan dan pengguna aktif.

## 🛠️ Teknologi yang Digunakan

- **Backend:** Laravel 10 (PHP 8.1+)
- **Database:** MySQL 8.0
- **Frontend:** Blade Templates, Tailwind CSS / Bootstrap
- **Mapping Library:** Leaflet JS & GeoJSON
- **Server Environment:** Laragon / XAMPP

## 📸 Tangkapan Layar (Screenshots)

|                  Dashboard Admin                   |              Peta Sebaran              |
| :------------------------------------------------: | :------------------------------------: |
| ![Dashboard](public/img/screenshots/dashboard.png) | ![Map](public/img/screenshots/map.png) |

## 🚀 Instalasi & Penggunaan

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di komputer lokal (Localhost):

### Prasyarat

Pastikan kamu sudah menginstal:

- PHP >= 8.1
- Composer
- MySQL

### Langkah Instalasi

1.  **Clone Repositori**

    ```bash
    git clone [https://github.com/USERNAME-KAMU/ballgrounds.git](https://github.com/USERNAME-KAMU/ballgrounds.git)
    cd ballgrounds
    ```

2.  **Install Dependensi**

    ```bash
    composer install
    npm install
    ```

3.  **Konfigurasi Environment**
    Salin file `.env.example` menjadi `.env`:

    ```bash
    cp .env.example .env
    ```

    Buka file `.env` dan sesuaikan konfigurasi database:

    ```env
    DB_DATABASE=ballgrounds
    DB_USERNAME=root
    DB_PASSWORD=
    ```

4.  **Generate App Key**

    ```bash
    php artisan key:generate
    ```

5.  **Migrasi Database & Seeding**
    Pastikan database `ballgrounds` sudah dibuat di MySQL, lalu jalankan:

    ```bash
    php artisan migrate --seed
    ```

    _(Jika kamu memiliki file SQL backup, kamu bisa mengimpornya secara manual ke database)_.

6.  **Jalankan Server**

    ```bash
    php artisan serve
    ```

7.  **Akses Aplikasi**
    Buka browser dan kunjungi: `http://127.0.0.1:8000`

## 🤝 Kontribusi

Kontribusi sangat terbuka! Jika Anda ingin memperbaiki bug atau menambahkan fitur baru (seperti fitur Booking), silakan:

1.  Fork repositori ini.
2.  Buat branch fitur baru (`git checkout -b fitur-baru`).
3.  Commit perubahan Anda (`git commit -m 'Menambahkan fitur X'`).
4.  Push ke branch (`git push origin fitur-baru`).
5.  Buat Pull Request.

## 📝 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

---

**Dibuat oleh:** Raihan Hisbullah (221013006)
