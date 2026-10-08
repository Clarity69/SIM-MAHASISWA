# SIM Mahasiswa — Sistem Informasi Data Mahasiswa

Mini project Laravel untuk mengelola data mahasiswa dan program studi, dikerjakan mengikuti modul **Mini Project Laravel 11 — Sistem Informasi Data Mahasiswa**.

Alur aplikasi:

```
Login → Dashboard → Data Mahasiswa (CRUD, Pencarian, Filter) → Data Prodi → Profile → Logout
```

>  **Status:** STEP 1–20 selesai, **STEP 21 — Cetak PDF data mahasiswa** sedang dikerjakan.

---

##  Anggota Kelompok

| No | Nama | NIM |
|----|------|-----|
| 1 | Taro | 202412023 |
| 2 | Firman | 202412012 |
| 3 | Zaldy | 202412040 |
| 4 | Ninda | 202412029 |
| 5 | Yovitha | 202412044 |

---

##  Teknologi

| Komponen | Teknologi | Keterangan |
|----------|-----------|------------|
| Framework | ![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?style=for-the-badge&logo=laravel&logoColor=white) | Modul memakai Laravel 11; kode tetap kompatibel |
| Bahasa | ![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?style=for-the-badge&logo=php&logoColor=white) | Minimal PHP 8.3 |
| Dependency manager | ![Composer](https://img.shields.io/badge/Composer-2.8-885630?style=for-the-badge&logo=composer&logoColor=white) | - |
| Build tool | ![Node.js](https://img.shields.io/badge/Node.js-26-5FA04E?style=for-the-badge&logo=nodedotjs&logoColor=white) | Untuk asset Vite bawaan Breeze |
| Database | ![Supabase](https://img.shields.io/badge/Supabase-PostgreSQL-3FCF8E?style=for-the-badge&logo=supabase&logoColor=white) | Koneksi `pgsql` |
| Autentikasi | ![Laravel Breeze](https://img.shields.io/badge/Laravel%20Breeze-Auth-FF2D20?style=for-the-badge&logo=laravel&logoColor=white) | Login, register, lupa & reset password |
| Tampilan | ![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white) | Bootstrap 5.3 + Bootstrap Icons (CDN), termasuk halaman login/register |
| Grafik dashboard | ![Chart.js](https://img.shields.io/badge/Chart.js-Grafik-FF6384?style=for-the-badge&logo=chartdotjs&logoColor=white) | - |
| Akses data | ![Eloquent](https://img.shields.io/badge/Eloquent-ORM-FF2D20?style=for-the-badge&logo=laravel&logoColor=white) | Eloquent ORM, Resource Controller, Form Validation |

---

##  Progress Pengerjaan

| Step | Materi | Status |
|------|--------|--------|
| 1 | Membuat project Laravel |  Selesai |
| 2 | Membuat database |  Selesai |
| 3 | Konfigurasi `.env` |  Selesai |
| 4 | Install Laravel Breeze |  Selesai |
| 5 | Migration (`prodis`, `mahasiswas`) |  Selesai |
| 6 | Model `Prodi` dan `Mahasiswa` |  Selesai |
| 7 | Seeder Program Studi |  Selesai |
| 8 | Relasi model (Prodi → Mahasiswa) |  Selesai |
| 9 | Controller (`Dashboard`, `Mahasiswa`, `Prodi`) |  Selesai |
| 10 | Route |  Selesai |
| 11 | Layout utama |  Selesai |
| 12 | Dashboard |  Selesai |
| 13 | CRUD Program Studi |  Selesai |
| 14 | CRUD Data Mahasiswa (search, filter, pagination, validasi) |  Selesai |
| 15 | Dashboard dinamis (statistik + grafik) |  Selesai |
| 16 | Sidebar + Topbar + Responsive Layout |  Selesai |
| 17 | Profil User + Authentication |  Selesai |
| 18 | Mempercantik halaman Login & Register |  Selesai |
| 19 | Seeder + Factory data dummy |  Selesai |
| 20 | Final polish UI |  Selesai |
| 21 | Cetak PDF data mahasiswa |  Dikerjakan |

---

##  Fitur yang Sudah Berjalan

** Autentikasi** (Laravel Breeze)
- Register, login, logout (dari sidebar dan dropdown profil)
- Lupa password: tautan reset dikirim ke email, lalu atur password baru
- Semua halaman data dilindungi middleware `auth`

** Dashboard**
- Total mahasiswa, total laki-laki, total perempuan, total program studi
- Tabel 5 mahasiswa terbaru
- Jumlah mahasiswa per program studi (grafik Chart.js)

** Data Mahasiswa**
- Tambah, lihat detail, edit, hapus (CRUD)
- Konfirmasi hapus memakai modal
- Pencarian berdasarkan NIM atau nama
- Filter berdasarkan program studi
- Pagination 10 data per halaman (pencarian/filter tetap terbawa saat pindah halaman)
- Validasi input (NIM unik, jenis kelamin, email, prodi wajib ada)

** Program Studi**
- Tambah, lihat detail (beserta daftar mahasiswanya), edit, hapus
- Pencarian berdasarkan kode, nama prodi, atau fakultas
- Prodi yang masih memiliki mahasiswa tidak bisa dihapus

** Profile**
- Ubah nama dan email
- Ubah password (wajib memasukkan password lama)

** Tampilan**
- Sidebar dengan menu aktif otomatis, bisa disembunyikan di desktop
- Mode gelap / terang, tersimpan di browser
- Topbar dengan dropdown informasi user
- Notifikasi sukses, error, dan validasi
- Responsive untuk layar mobile
- Favicon dan nama aplikasi sendiri

---

##  Struktur Database

```
prodis (1) ──────< (banyak) mahasiswas
```

**prodis**

| Kolom | Keterangan |
|-------|------------|
| id | Primary key |
| kode_prodi | Unik, contoh: `TI` |
| nama_prodi | Contoh: Teknik Informatika |
| fakultas | Nullable |
| created_at, updated_at | Timestamp |

**mahasiswas**

| Kolom | Keterangan |
|-------|------------|
| id | Primary key |
| nim | Unik |
| nama | |
| jenis_kelamin | `Laki-laki` / `Perempuan` |
| tanggal_lahir | Nullable |
| alamat | Nullable |
| telepon | Nullable |
| email | Nullable |
| prodi_id | Foreign key → `prodis.id` |
| created_at, updated_at | Timestamp |

Tabel bawaan Laravel yang juga dipakai: `users`, `password_reset_tokens`, `sessions`.

Relasi Eloquent:
- `Prodi::mahasiswas()` → `hasMany`
- `Mahasiswa::prodi()` → `belongsTo`

---

##  Daftar Route Utama

| Method | URL | Nama Route | Keterangan |
|--------|-----|------------|------------|
| GET | `/dashboard` | `dashboard` | Halaman dashboard |
| GET | `/mahasiswa` | `mahasiswa.index` | Daftar mahasiswa |
| GET | `/mahasiswa/create` | `mahasiswa.create` | Form tambah |
| POST | `/mahasiswa` | `mahasiswa.store` | Simpan data |
| GET | `/mahasiswa/{mahasiswa}` | `mahasiswa.show` | Detail |
| GET | `/mahasiswa/{mahasiswa}/edit` | `mahasiswa.edit` | Form edit |
| PUT/PATCH | `/mahasiswa/{mahasiswa}` | `mahasiswa.update` | Update data |
| DELETE | `/mahasiswa/{mahasiswa}` | `mahasiswa.destroy` | Hapus data |
| GET | `/mahasiswa/pdf` | `mahasiswa.pdf` | Cetak PDF (dalam pengerjaan) |
| GET | `/prodi` | `prodi.index` | Daftar program studi |
| … | `/prodi/...` | `prodi.*` | CRUD lengkap (resource) |
| GET | `/profile` | `profile.edit` | Halaman profile |
| PATCH | `/profile` | `profile.update` | Ubah nama & email |
| PUT | `/profile/password` | `profile.password.update` | Ubah password |

Daftar lengkap: `php artisan route:list --except-vendor`

---

##  Struktur Folder Penting

```
app/
├── Http/Controllers/
│   ├── Auth/                     # controller bawaan Breeze
│   ├── DashboardController.php
│   ├── MahasiswaController.php
│   ├── ProdiController.php
│   └── ProfileController.php
└── Models/
    ├── Mahasiswa.php
    ├── Prodi.php
    └── User.php
database/
├── migrations/
│   ├── ..._create_users_table.php
│   ├── ..._create_prodis_table.php
│   └── ..._create_mahasiswas_table.php
└── seeders/
    ├── DatabaseSeeder.php        # akun admin + prodi
    └── ProdiSeeder.php
public/
└── favicon.svg
resources/views/
├── layouts/                      # layout utama (sidebar + topbar)
├── auth/                         # login, register, lupa & reset password
├── dashboard.blade.php
├── mahasiswa/                    # index, create, edit, show
├── prodi/                        # index, create, edit, show
└── profile/                      # edit profile
routes/
├── web.php
└── auth.php
```

---

##  Cara Menjalankan

**Kebutuhan:** PHP ≥ 8.3, Composer, Node.js, dan project Supabase.

1. Clone repository

   ```bash
   git clone https://github.com/Clarity69/SIM-MAHASISWA.git
   cd SIM-MAHASISWA
   ```

2. Install dependency

   ```bash
   composer install
   npm install
   ```

3. Salin file environment dan buat app key

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Atur koneksi database di `.env` (ambil dari Supabase → **Connect** → **Session pooler**)

   ```env
   DB_CONNECTION=pgsql
   DB_HOST=aws-0-xxx.pooler.supabase.com
   DB_PORT=5432
   DB_DATABASE=postgres
   DB_USERNAME=postgres.xxxxxxxx
   DB_PASSWORD=password-supabase-kamu
   DB_SSLMODE=require

   SESSION_DRIVER=file
   CACHE_STORE=file
   ```

5. (Opsional) Atur email untuk fitur lupa password, misalnya dengan Gmail + App Password

   ```env
   APP_NAME="SIM Mahasiswa"
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=emailkamu@gmail.com
   MAIL_PASSWORD=app-password-16-karakter
   MAIL_FROM_ADDRESS="emailkamu@gmail.com"
   MAIL_FROM_NAME="${APP_NAME}"
   ```

   Untuk testing tanpa email sungguhan, pakai `MAIL_MAILER=log`, lalu ambil tautan reset dari `storage/logs/laravel.log`.

6. Jalankan migration dan seeder (akun admin + data prodi awal: TI, SI, TE)

   ```bash
   php artisan migrate --seed
   ```

7. Build asset dan jalankan aplikasi

   ```bash
   npm run build
   php artisan serve
   ```

8. Buka `http://127.0.0.1:8000`, lalu login dengan akun bawaan:

   | Email | Password |
   |-------|----------|
   | `admin@example.com` | `password123` |

   Atau **register** akun baru.

>  Jangan push file `.env` ke GitHub karena berisi password database dan email.

---

##  Screenshot

| Halaman | Screenshot |
|---------|------------|
| Login | ![Login](docs/screenshots/login.png) |
| Register | ![Register](docs/screenshots/register.png) |
| Dashboard | ![Dashboard](docs/screenshots/dashboard.png) |
| Data Mahasiswa | ![Data Mahasiswa](docs/screenshots/datamhs.png) |
| Tambah Mahasiswa | ![Tambah Mahasiswa](docs/screenshots/tambahmhs.png) |
| Program Studi | ![Program Studi](docs/screenshots/prodi.png) |
| Tampilan Mobile | ![Mobile](docs/screenshots/mobile.png) |

---

##  Catatan Pengerjaan

- Modul ditulis untuk **Laravel 11**, sedangkan project ini memakai **Laravel 13**. Perbedaan utama yang ditemui: PHP minimal 8.3.
- Database memakai **Supabase (PostgreSQL)**, bukan MySQL seperti di modul. Driver diganti ke `pgsql`.
- Session dan cache disimpan sebagai file lokal (`SESSION_DRIVER=file`) agar perpindahan halaman tidak lambat; data CRUD tetap tersimpan di Supabase.
- Seluruh tampilan, termasuk login dan register, memakai Bootstrap 5 dari CDN.
- Aturan validasi `store` dan `update` digabung ke satu method `rules()` di setiap controller agar tidak ditulis dua kali.

---

##  Rencana Berikutnya

- **STEP 21** — Menyelesaikan cetak PDF data mahasiswa (sesuai pencarian/filter yang aktif)