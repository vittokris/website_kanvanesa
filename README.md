# Dokumentasi Sistem Kanvanesa

Sistem Pendukung Keputusan Pemilihan Menu Terfavorit Menggunakan Metode AHP dan SAW

Versi dokumentasi: 2.0.0  
Tanggal pembaruan: 8 Juli 2026  
Framework utama: Laravel 12  
Lokasi aplikasi: `program/kanvanesa_app`

---

## Daftar Isi

1. Ringkasan sistem
2. Istilah penting untuk orang awam
3. Aktor dan hak akses
4. Fitur sistem
5. Alur kerja sistem
6. Dependensi dan teknologi
7. Cara instalasi dan menjalankan aplikasi
8. Struktur folder proyek
9. Route atau alamat halaman
10. Database dan relasi tabel
11. Data awal dari seeder
12. Penjelasan metode AHP
13. Penjelasan metode SAW
14. Contoh sederhana perhitungan
15. Cara sistem menyimpan dan memperbarui ranking
16. Autentikasi dan keamanan dasar
17. Validasi input
18. Pengujian sistem
19. Catatan penting untuk laporan tugas akhir
20. Troubleshooting
21. FAQ
22. Ringkasan file penting

---

## 1. Ringkasan Sistem

Kanvanesa adalah aplikasi website untuk membantu menentukan menu favorit di Kantin Kanvanesa secara lebih objektif.

Jika dilakukan manual, menu favorit biasanya dipilih berdasarkan perkiraan, opini penjual, atau menu yang terasa paling sering dipesan. Cara seperti itu masih bisa digunakan, tetapi hasilnya dapat menjadi subjektif karena tidak memakai perhitungan yang jelas.

Sistem ini mencoba membuat proses tersebut lebih terukur dengan cara:

1. Pengguna memberi penilaian pada menu.
2. Penilaian dilakukan berdasarkan 5 kriteria:
   - Rasa
   - Tampilan Penyajian
   - Harga
   - Porsi
   - Gizi
3. Setiap kriteria memiliki pilihan sub-kriteria dengan nilai 1 sampai 5.
4. Sistem menghitung rata-rata penilaian pengguna.
5. Sistem memakai bobot AHP untuk menentukan seberapa besar pengaruh tiap kriteria.
6. Sistem memakai SAW untuk menghitung skor akhir tiap menu.
7. Menu diurutkan dari skor terbesar ke skor terkecil.

Metode yang digunakan:

| Metode | Fungsi di sistem | Penjelasan singkat |
| --- | --- | --- |
| AHP | Menentukan bobot kriteria | Menentukan kriteria mana yang lebih penting. |
| SAW | Menghitung skor akhir menu | Menjumlahkan nilai menu setelah dinormalisasi dan dikalikan bobot. |

Hasil akhir sistem adalah ranking menu, misalnya:

1. Menu A mendapat skor 0.953
2. Menu B mendapat skor 0.947
3. Menu C mendapat skor 0.858

Semakin besar skor SAW, semakin tinggi posisi menu pada ranking.

---

## 2. Istilah Penting Untuk Orang Awam

Bagian ini dibuat agar orang yang belum terbiasa dengan istilah sistem dan metode bisa memahami dokumentasi.

| Istilah | Arti sederhana |
| --- | --- |
| Sistem Pendukung Keputusan | Sistem yang membantu mengambil keputusan berdasarkan data dan perhitungan. |
| Alternatif | Pilihan yang akan dibandingkan. Dalam sistem ini alternatifnya adalah menu makanan. |
| Kriteria | Faktor penilaian. Contoh: rasa, harga, porsi. |
| Sub-kriteria | Pilihan nilai di dalam kriteria. Contoh pada rasa: Tidak Suka, Suka, Sangat Suka. |
| Bobot | Angka yang menunjukkan tingkat kepentingan. Bobot besar berarti pengaruhnya lebih kuat. |
| AHP | Metode untuk menentukan bobot kriteria. |
| SAW | Metode untuk menghitung skor akhir dan ranking. |
| Normalisasi | Proses menyamakan skala nilai agar bisa dibandingkan secara adil. |
| Skor SAW | Nilai akhir menu setelah semua perhitungan selesai. |
| Benefit | Jenis kriteria yang semakin besar nilainya semakin baik. |
| CRUD | Create, Read, Update, Delete. Artinya tambah, lihat, ubah, hapus data. |
| Seeder | File untuk mengisi data awal ke database. |
| Migration | File Laravel untuk membuat struktur tabel database. |
| Soft delete | Data terlihat terhapus, tetapi sebenarnya masih ada di database dengan tanda `deleted_at`. |

---

## 3. Aktor dan Hak Akses

Sistem memiliki 3 jenis akses.

| Aktor | Harus login? | Halaman utama | Fungsi |
| --- | --- | --- | --- |
| Admin | Ya | `/admin/dashboard` | Mengelola menu, melihat bobot AHP, melihat hasil SAW. |
| Pengguna | Ya untuk memberi penilaian | `/dashboard` dan `/penilaian` | Melihat ranking dan memberi penilaian menu. |
| Pengunjung publik | Tidak | `/ranking` | Melihat ranking menu tanpa login. |

Penjelasan:

- Admin adalah pihak pengelola sistem.
- Pengguna adalah orang yang memberi penilaian menu.
- Pengunjung publik adalah siapa pun yang hanya ingin melihat ranking.

---

## 4. Fitur Sistem

### 4.1 Fitur Admin

Admin dapat melakukan:

1. Login admin.
2. Logout admin.
3. Melihat dashboard admin.
4. Melihat total menu, total pengguna, total penilaian, dan total hasil SAW.
5. Melihat top ranking menu.
6. Menambah menu.
7. Mengubah menu.
8. Menghapus menu.
9. Mengunggah gambar menu.
10. Melihat bobot AHP.
11. Melihat matriks perbandingan AHP.
12. Melihat nilai Consistency Ratio.
13. Melihat hasil ranking SAW.
14. Melihat detail kontribusi skor SAW per kriteria.

### 4.2 Fitur Pengguna

Pengguna dapat melakukan:

1. Registrasi akun.
2. Login pengguna.
3. Logout pengguna.
4. Melihat dashboard pengguna.
5. Melihat halaman ranking publik.
6. Membuka daftar menu yang dapat dinilai.
7. Memilih satu menu.
8. Memberi penilaian pada 5 kriteria.
9. Mengubah penilaian yang sudah pernah diberikan.
10. Menyimpan penilaian.

### 4.3 Fitur Publik

Pengunjung tanpa login dapat:

1. Membuka halaman `/ranking`.
2. Melihat daftar menu favorit.
3. Melihat skor SAW.
4. Melihat informasi ringkas tiap menu.
5. Masuk ke halaman login atau register jika ingin menilai.

---

## 5. Alur Kerja Sistem

### 5.1 Alur Umum

Alur besar sistem:

```text
Admin mengelola data menu
        |
        v
Pengguna melihat menu
        |
        v
Pengguna memberi penilaian pada 5 kriteria
        |
        v
Sistem menyimpan penilaian ke database
        |
        v
Sistem menghitung ulang SAW
        |
        v
Sistem menyimpan skor ke tabel hasil_tb
        |
        v
Ranking menu ditampilkan ke admin, pengguna, dan publik
```

### 5.2 Alur Admin

```text
1. Admin membuka /admin/login
2. Admin memasukkan username dan password
3. Sistem memvalidasi akun admin
4. Jika benar, admin masuk ke dashboard
5. Admin dapat mengelola data menu
6. Admin dapat melihat bobot AHP
7. Admin dapat melihat ranking SAW
8. Admin logout jika selesai
```

### 5.3 Alur Pengguna Memberi Penilaian

```text
1. Pengguna membuka website
2. Pengguna dapat melihat ranking publik tanpa login
3. Jika ingin menilai, pengguna harus login atau register
4. Pengguna membuka halaman daftar menu penilaian
5. Pengguna memilih salah satu menu
6. Sistem menampilkan form penilaian untuk 5 kriteria
7. Pengguna memilih sub-kriteria untuk setiap kriteria
8. Pengguna menyimpan penilaian
9. Sistem menyimpan atau memperbarui data penilaian
10. Sistem menghitung ulang skor SAW
11. Ranking diperbarui
```

### 5.4 Alur Perhitungan

```text
Data penilaian pengguna
        |
        v
Rata-rata nilai tiap menu pada tiap kriteria
        |
        v
Normalisasi SAW
        |
        v
Dikalikan dengan bobot AHP
        |
        v
Skor akhir SAW
        |
        v
Ranking menu
```

---

## 6. Dependensi dan Teknologi

### 6.1 Teknologi Utama

| Komponen | Teknologi | Fungsi |
| --- | --- | --- |
| Backend | Laravel 12 | Kerangka utama aplikasi. |
| Bahasa backend | PHP 8.2 atau lebih baru | Menjalankan Laravel. |
| Database | MySQL atau SQLite | Menyimpan data sistem. |
| Template | Blade | Membuat tampilan halaman. |
| Frontend build tool | Vite | Membantu build asset frontend. |
| CSS/JS | Blade, CSS custom, Bootstrap icon/style di view | Tampilan antarmuka. |
| Autentikasi | Laravel session guard | Login admin dan pengguna. |
| Penyimpanan gambar | Laravel Storage | Menyimpan gambar menu. |
| Testing | PHPUnit | Pengujian fitur Laravel. |

### 6.2 Dependensi PHP Dari `composer.json`

Dependensi utama:

| Package | Versi | Fungsi |
| --- | --- | --- |
| `php` | `^8.2` | Versi PHP minimal. |
| `laravel/framework` | `^12.0` | Framework utama aplikasi. |
| `laravel/tinker` | `^2.10.1` | Menjalankan perintah interaktif Laravel. |

Dependensi development:

| Package | Fungsi |
| --- | --- |
| `fakerphp/faker` | Membuat data palsu untuk testing atau seeder. |
| `laravel/breeze` | Starter kit autentikasi Laravel. |
| `laravel/pail` | Melihat log Laravel secara real-time. |
| `laravel/pint` | Merapikan format kode PHP. |
| `laravel/sail` | Environment Docker Laravel. |
| `mockery/mockery` | Mocking untuk test. |
| `nunomaduro/collision` | Tampilan error command line yang lebih jelas. |
| `phpunit/phpunit` | Framework testing PHP. |

### 6.3 Dependensi Node Dari `package.json`

| Package | Fungsi |
| --- | --- |
| `vite` | Build dan dev server frontend. |
| `laravel-vite-plugin` | Integrasi Laravel dengan Vite. |
| `tailwindcss` | Utility CSS. |
| `@tailwindcss/forms` | Styling form. |
| `@tailwindcss/vite` | Integrasi Tailwind dengan Vite. |
| `alpinejs` | Interaksi frontend ringan. |
| `axios` | HTTP request dari JavaScript. |
| `concurrently` | Menjalankan beberapa command sekaligus. |
| `postcss` | Pemrosesan CSS. |
| `autoprefixer` | Menambahkan prefix CSS otomatis. |

### 6.4 Software yang Perlu Terpasang

Untuk menjalankan aplikasi secara lokal:

| Software | Versi disarankan | Catatan |
| --- | --- | --- |
| PHP | 8.2 atau lebih baru | Wajib untuk Laravel 12. |
| Composer | 2.x | Untuk install package PHP. |
| Node.js | 18 atau lebih baru | Untuk Vite dan asset frontend. |
| NPM | Mengikuti Node.js | Untuk install package frontend. |
| MySQL | 8.x | Disarankan untuk laporan dan deployment lokal. |
| Git | Bebas | Untuk version control. |

Catatan:

- File `.env.example` bawaan Laravel di proyek ini masih memakai `DB_CONNECTION=sqlite`.
- Untuk kebutuhan tugas akhir dan database MySQL, ubah konfigurasi database ke MySQL seperti bagian instalasi.

---

## 7. Cara Instalasi dan Menjalankan Aplikasi

Bagian ini menjelaskan dari awal untuk orang yang belum terbiasa menjalankan Laravel.

### 7.1 Masuk Ke Folder Aplikasi

Struktur folder pada komputer ini:

```text
D:\Coolyeah\SEMESTER 8'\kanvanesa_app\program\kanvanesa_app
```

Masuk ke folder tersebut:

```bash
cd "D:\Coolyeah\SEMESTER 8'\kanvanesa_app\program\kanvanesa_app"
```

### 7.2 Install Dependensi PHP

```bash
composer install
```

Perintah ini membaca `composer.json`, lalu mengunduh package PHP yang dibutuhkan Laravel.

### 7.3 Install Dependensi Frontend

```bash
npm install
```

Perintah ini membaca `package.json`, lalu mengunduh package frontend.

### 7.4 Buat File `.env`

Jika belum ada file `.env`, buat dari `.env.example`.

Windows:

```bash
copy .env.example .env
```

Mac atau Linux:

```bash
cp .env.example .env
```

### 7.5 Generate APP_KEY

```bash
php artisan key:generate
```

APP_KEY digunakan Laravel untuk keamanan enkripsi, session, dan token.

### 7.6 Atur Database MySQL

Buka file `.env`, lalu ubah bagian database menjadi:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kanvanesa_app
DB_USERNAME=root
DB_PASSWORD=
```

Jika MySQL memakai password, isi `DB_PASSWORD`.

Contoh:

```env
DB_PASSWORD=123456
```

### 7.7 Buat Database

Di phpMyAdmin atau MySQL:

```sql
CREATE DATABASE kanvanesa_app;
```

### 7.8 Jalankan Migration dan Seeder

```bash
php artisan migrate:fresh --seed
```

Artinya:

- `migrate:fresh` menghapus dan membuat ulang tabel database.
- `--seed` mengisi data awal seperti admin, user demo, menu, kriteria, dan penilaian dummy.

Peringatan:

Perintah ini menghapus data lama di database. Gunakan hanya saat setup awal atau saat ingin reset data.

### 7.9 Buat Storage Link

```bash
php artisan storage:link
```

Perintah ini membuat gambar menu yang tersimpan di `storage/app/public` dapat diakses oleh browser.

### 7.10 Jalankan Server Laravel

```bash
php artisan serve
```

Lalu buka:

```text
http://127.0.0.1:8000
```

Jika port 8000 sudah digunakan:

```bash
php artisan serve --port=8080
```

### 7.11 Jalankan Vite Saat Development

Jika tampilan membutuhkan asset frontend dari Vite:

```bash
npm run dev
```

Untuk build asset:

```bash
npm run build
```

### 7.12 Akun Demo

Setelah menjalankan seeder:

| Peran | URL | Username | Password |
| --- | --- | --- | --- |
| Admin | `/admin/login` | `admin` | `admin123` |
| Pengguna | `/login` | `user_demo` | `password123` |

---

## 8. Struktur Folder Proyek

Berikut struktur folder penting.

```text
kanvanesa_app/
|
|-- app/
|   |-- Http/
|   |   |-- Controllers/
|   |   |   |-- Admin/
|   |   |   |-- Auth/
|   |   |   |-- User/
|   |   |-- Middleware/
|   |
|   |-- Models/
|   |
|   |-- Services/
|       |-- SawService.php
|
|-- database/
|   |-- migrations/
|   |-- seeders/
|
|-- resources/
|   |-- views/
|       |-- admin/
|       |-- auth/
|       |-- user/
|       |-- layouts/
|
|-- routes/
|   |-- web.php
|
|-- storage/
|   |-- app/
|       |-- public/
|           |-- menus/
|
|-- config/
|   |-- auth.php
|   |-- database.php
|
|-- tests/
|
|-- composer.json
|-- package.json
|-- .env
|-- SYSTEM_DOCUMENTATION.md
```

Penjelasan singkat:

| Folder/File | Fungsi |
| --- | --- |
| `routes/web.php` | Mengatur semua URL halaman. |
| `app/Http/Controllers` | Mengatur logika request halaman. |
| `app/Models` | Representasi tabel database. |
| `app/Services/SawService.php` | Tempat utama perhitungan SAW. |
| `database/migrations` | Struktur tabel database. |
| `database/seeders` | Data awal sistem. |
| `resources/views` | Tampilan Blade. |
| `config/auth.php` | Konfigurasi login admin dan pengguna. |
| `tests` | File pengujian otomatis. |

---

## 9. Route atau Alamat Halaman

Route diatur di:

```text
routes/web.php
```

### 9.1 Route Publik

| Method | URL | Nama route | Controller | Fungsi |
| --- | --- | --- | --- | --- |
| GET | `/` | - | Closure | Mengarahkan ke `/ranking`. |
| GET | `/ranking` | `ranking` | `User\RankingController@index` | Menampilkan ranking publik. |
| GET | `/menu-images/{filename}` | `menu.image` | Closure | Menampilkan gambar menu dari storage. |

### 9.2 Route Admin

Prefix:

```text
/admin
```

| Method | URL | Nama route | Controller | Fungsi |
| --- | --- | --- | --- | --- |
| GET | `/admin/login` | `admin.login` | `Admin\LoginController@showLoginForm` | Form login admin. |
| POST | `/admin/login` | `admin.login.post` | `Admin\LoginController@login` | Proses login admin. |
| POST | `/admin/logout` | `admin.logout` | `Admin\LoginController@logout` | Logout admin. |
| GET | `/admin/dashboard` | `admin.dashboard` | `Admin\DashboardController@index` | Dashboard admin. |
| GET | `/admin/menus` | `admin.menus.index` | `Admin\MenuController@index` | Daftar menu. |
| POST | `/admin/menus` | `admin.menus.store` | `Admin\MenuController@store` | Tambah menu. |
| GET | `/admin/menus/{menu}/edit` | `admin.menus.edit` | `Admin\MenuController@edit` | Form edit menu. |
| PUT | `/admin/menus/{menu}` | `admin.menus.update` | `Admin\MenuController@update` | Simpan perubahan menu. |
| DELETE | `/admin/menus/{menu}` | `admin.menus.destroy` | `Admin\MenuController@destroy` | Hapus menu. |
| GET | `/admin/ahp` | `admin.ahp` | `Admin\AhpController@index` | Halaman bobot AHP. |
| GET | `/admin/saw` | `admin.saw` | `Admin\SawController@index` | Halaman ranking SAW admin. |

### 9.3 Route Pengguna

| Method | URL | Nama route | Controller | Fungsi |
| --- | --- | --- | --- | --- |
| GET | `/login` | `login` | `Auth\LoginController@showLoginForm` | Form login pengguna. |
| POST | `/login` | `login.post` | `Auth\LoginController@login` | Proses login pengguna. |
| GET | `/register` | `register` | `Auth\RegisterController@showRegistrationForm` | Form registrasi. |
| POST | `/register` | `register.post` | `Auth\RegisterController@register` | Proses registrasi. |
| POST | `/logout` | `logout` | `Auth\LoginController@logout` | Logout pengguna. |
| GET | `/dashboard` | `user.dashboard` | `User\DashboardController@index` | Dashboard pengguna. |
| GET | `/penilaian` | `user.penilaian` | `User\PenilaianController@index` | Daftar menu yang dapat dinilai. |
| GET | `/menu/{menu}/penilaian` | `user.penilaian.show` | `User\PenilaianController@show` | Form penilaian satu menu. |
| POST | `/menu/{menu}/penilaian` | `user.penilaian.store` | `User\PenilaianController@store` | Simpan penilaian menu. |

---

## 10. Database dan Relasi Tabel

### 10.1 Daftar Tabel Utama

| Tabel | Fungsi |
| --- | --- |
| `admin` | Menyimpan akun admin. |
| `user_tb` | Menyimpan akun pengguna. |
| `kriteria` | Menyimpan daftar kriteria penilaian. |
| `sub_kriteria` | Menyimpan pilihan nilai untuk setiap kriteria. |
| `menu_tb` | Menyimpan data menu makanan. |
| `penilaian_tb` | Menyimpan penilaian pengguna. |
| `hasil_tb` | Menyimpan hasil skor SAW tiap menu. |

### 10.2 Tabel Bawaan Laravel

| Tabel | Fungsi |
| --- | --- |
| `cache` | Menyimpan cache aplikasi. |
| `cache_locks` | Mengunci cache tertentu agar aman saat proses bersamaan. |
| `jobs` | Menyimpan antrean pekerjaan background. |
| `job_batches` | Menyimpan batch job. |
| `failed_jobs` | Menyimpan job yang gagal. |
| `sessions` | Menyimpan session login pengguna/admin. |

### 10.3 Detail Tabel `admin`

Migration:

```text
0001_01_01_000000_create_admin_table.php
```

Kolom:

| Kolom | Tipe | Keterangan |
| --- | --- | --- |
| `id_admin` | big integer | Primary key. |
| `admin_username` | string unique | Username admin. |
| `admin_password` | string | Password yang sudah di-hash. |
| `admin_name` | string | Nama admin. |
| `remember_token` | string nullable | Token remember me. |
| `created_at` | timestamp | Waktu data dibuat. |
| `updated_at` | timestamp | Waktu data diperbarui. |
| `deleted_at` | timestamp nullable | Penanda soft delete. |

Model:

```text
app/Models/Admin.php
```

### 10.4 Detail Tabel `user_tb`

Migration:

```text
0001_01_01_000003_create_user_tb_table.php
```

Kolom:

| Kolom | Tipe | Keterangan |
| --- | --- | --- |
| `id_user` | big integer | Primary key. |
| `user_username` | string unique | Username pengguna. |
| `user_password` | string | Password yang sudah di-hash. |
| `user_name` | string | Nama pengguna. |
| `remember_token` | string nullable | Token remember me. |
| `created_at` | timestamp | Waktu data dibuat. |
| `updated_at` | timestamp | Waktu data diperbarui. |
| `deleted_at` | timestamp nullable | Penanda soft delete. |

Model:

```text
app/Models/UserTb.php
```

Relasi:

```text
UserTb hasMany PenilaianTb
```

Artinya satu pengguna dapat memiliki banyak data penilaian.

### 10.5 Detail Tabel `kriteria`

Migration:

```text
2026_06_03_000001_create_kriteria_table.php
```

Kolom:

| Kolom | Tipe | Keterangan |
| --- | --- | --- |
| `id_kriteria` | big integer | Primary key. |
| `kriteria_name` | string | Nama kriteria. |
| `created_at` | timestamp | Waktu data dibuat. |
| `updated_at` | timestamp | Waktu data diperbarui. |
| `deleted_at` | timestamp nullable | Penanda soft delete. |

Model:

```text
app/Models/Kriteria.php
```

Relasi:

```text
Kriteria hasMany SubKriteria
Kriteria hasMany PenilaianTb
```

### 10.6 Detail Tabel `sub_kriteria`

Migration:

```text
2026_06_03_000002_create_sub_kriteria_table.php
```

Kolom:

| Kolom | Tipe | Keterangan |
| --- | --- | --- |
| `id_sub_kriteria` | big integer | Primary key. |
| `id_kriteria` | foreign key | Mengarah ke tabel `kriteria`. |
| `sub_kriteria_name` | string | Nama pilihan sub-kriteria. |
| `bobot_subkriteria` | unsigned tiny integer | Nilai pilihan, 1 sampai 5. |
| `created_at` | timestamp | Waktu data dibuat. |
| `updated_at` | timestamp | Waktu data diperbarui. |
| `deleted_at` | timestamp nullable | Penanda soft delete. |

Model:

```text
app/Models/SubKriteria.php
```

Relasi:

```text
SubKriteria belongsTo Kriteria
SubKriteria hasMany PenilaianTb
```

### 10.7 Detail Tabel `menu_tb`

Migration:

```text
2026_06_03_000003_create_menu_tb_table.php
2026_06_04_000002_add_description_to_menu_tb.php
2026_06_17_000001_add_price_to_menu_tb.php
```

Kolom:

| Kolom | Tipe | Keterangan |
| --- | --- | --- |
| `id_menu` | big integer | Primary key. |
| `menu_name` | string | Nama menu. |
| `menu_description` | text nullable | Deskripsi menu. |
| `menu_price` | unsigned integer nullable | Harga menu. |
| `menu_image` | string nullable | Path gambar menu. |
| `created_at` | timestamp | Waktu data dibuat. |
| `updated_at` | timestamp | Waktu data diperbarui. |
| `deleted_at` | timestamp nullable | Penanda soft delete. |

Model:

```text
app/Models/MenuTb.php
```

Relasi:

```text
MenuTb hasMany PenilaianTb
MenuTb hasOne HasilTb
```

### 10.8 Detail Tabel `penilaian_tb`

Migration:

```text
2026_06_03_000004_create_penilaian_tb_table.php
```

Kolom:

| Kolom | Tipe | Keterangan |
| --- | --- | --- |
| `id_penilaian` | big integer | Primary key. |
| `id_user` | foreign key | Pengguna yang memberi nilai. |
| `id_menu` | foreign key | Menu yang dinilai. |
| `id_kriteria` | foreign key | Kriteria yang dinilai. |
| `id_subkriteria` | foreign key | Sub-kriteria yang dipilih pengguna. |
| `created_at` | timestamp | Waktu data dibuat. |
| `updated_at` | timestamp | Waktu data diperbarui. |
| `deleted_at` | timestamp nullable | Penanda soft delete. |

Kunci unik:

```text
unique(id_user, id_menu, id_kriteria)
```

Artinya:

Satu pengguna hanya boleh memiliki satu penilaian untuk satu menu pada satu kriteria.

Contoh:

- User A menilai menu Nasi Liwet pada kriteria Rasa.
- User A tidak membuat baris baru lagi untuk Rasa pada menu yang sama.
- Jika User A mengubah penilaian Rasa, data lama diperbarui dengan `updateOrCreate`.

Model:

```text
app/Models/PenilaianTb.php
```

Relasi:

```text
PenilaianTb belongsTo UserTb
PenilaianTb belongsTo MenuTb
PenilaianTb belongsTo Kriteria
PenilaianTb belongsTo SubKriteria
```

### 10.9 Detail Tabel `hasil_tb`

Migration:

```text
2026_06_03_000005_create_hasil_tb_table.php
```

Kolom:

| Kolom | Tipe | Keterangan |
| --- | --- | --- |
| `id_hasil` | big integer | Primary key. |
| `id_menu` | foreign key | Menu yang punya skor. |
| `skor` | decimal(10,6) | Skor SAW. |
| `created_at` | timestamp | Waktu data dibuat. |
| `updated_at` | timestamp | Waktu data diperbarui. |
| `deleted_at` | timestamp nullable | Penanda soft delete. |

Model:

```text
app/Models/HasilTb.php
```

Relasi:

```text
HasilTb belongsTo MenuTb
```

### 10.10 Relasi Database Sederhana

```text
admin
  berdiri sendiri untuk login admin

user_tb
  1 user dapat memiliki banyak penilaian

kriteria
  1 kriteria memiliki banyak sub_kriteria
  1 kriteria memiliki banyak penilaian

sub_kriteria
  1 sub_kriteria dimiliki oleh 1 kriteria
  1 sub_kriteria dapat dipilih pada banyak penilaian

menu_tb
  1 menu dapat memiliki banyak penilaian
  1 menu memiliki 1 hasil skor SAW

penilaian_tb
  menghubungkan user, menu, kriteria, dan sub_kriteria

hasil_tb
  menyimpan skor akhir SAW tiap menu
```

Diagram relasi teks:

```text
user_tb --< penilaian_tb >-- menu_tb --< hasil_tb
              |
              v
          kriteria --< sub_kriteria
              ^
              |
        penilaian_tb memilih sub_kriteria
```

Keterangan simbol:

- `--<` artinya satu ke banyak.
- `>--` artinya banyak ke satu.

---

## 11. Data Awal Dari Seeder

Seeder adalah pengisi data awal.

Urutan seeder yang dipanggil:

```text
database/seeders/DatabaseSeeder.php
```

Isi:

```php
$this->call([
    AdminSeeder::class,
    KriteriaSeeder::class,
    MenuSeeder::class,
    UserSeeder::class,
    PenilaianSeeder::class,
]);
```

### 11.1 Admin Seeder

File:

```text
database/seeders/AdminSeeder.php
```

Data:

| Field | Nilai |
| --- | --- |
| Username | `admin` |
| Password | `admin123` |
| Nama | `Administrator Kanvanesa` |

### 11.2 User Seeder

File:

```text
database/seeders/UserSeeder.php
```

Data:

| Field | Nilai |
| --- | --- |
| Username | `user_demo` |
| Password | `password123` |
| Nama | `Pengguna Demo` |

### 11.3 Kriteria Seeder

File:

```text
database/seeders/KriteriaSeeder.php
```

Kriteria:

| No | Kriteria |
| --- | --- |
| 1 | Rasa |
| 2 | Tampilan Penyajian |
| 3 | Harga |
| 4 | Porsi |
| 5 | Gizi |

Sub-kriteria:

| Kriteria | Bobot 1 | Bobot 2 | Bobot 3 | Bobot 4 | Bobot 5 |
| --- | --- | --- | --- | --- | --- |
| Rasa | Tidak Suka | Kurang Suka | Cukup | Suka | Sangat Suka |
| Tampilan Penyajian | Tidak Menarik | Kurang Menarik | Cukup Menarik | Menarik | Sangat Menarik |
| Harga | Sangat Mahal | Mahal | Terjangkau | Murah | Sangat Murah |
| Porsi | Sangat Sedikit | Sedikit | Sedang | Banyak | Sangat Banyak |
| Gizi | Tidak Seimbang | Kurang Seimbang | Cukup Seimbang | Seimbang | Sangat Seimbang |

Catatan:

Semua kriteria diperlakukan sebagai benefit. Untuk kriteria Harga, nilai 5 berarti "Sangat Murah", sehingga tetap semakin besar semakin baik.

### 11.4 Menu Seeder

File:

```text
database/seeders/MenuSeeder.php
```

Data awal:

| No | Nama Menu | Harga awal seeder |
| --- | --- | --- |
| 1 | Nasi Liwet Kanvanesa | Rp 25.000 |
| 2 | Ayam Lodho | Rp 27.000 |
| 3 | Nasi Sup Ayam, Ayam Goreng Laos, Tahu tempe | Rp 25.000 |
| 4 | Nasi Kebuli | Rp 30.000 |
| 5 | Nasi Gudeg Komplit | Rp 28.000 |
| 6 | Nasi Madura | Rp 30.000 |
| 7 | Nasi Uduk Ayam Suwir Kare | Rp 25.000 |
| 8 | Nasi Sayur Bening, Ayam Goreng, Botok telur asin | Rp 26.000 |

Catatan:

Harga di sistem dapat berubah jika admin mengedit data menu. Jadi data seeder adalah data awal, bukan berarti data aktual selalu sama selamanya.

### 11.5 Penilaian Seeder

File:

```text
database/seeders/PenilaianSeeder.php
```

Fungsi:

1. Mengisi data penilaian dummy untuk `user_demo`.
2. Setiap menu diberi penilaian pada semua kriteria.
3. Setelah data penilaian dibuat, sistem langsung menjalankan `SawService::calculate()`.
4. Hasil skor masuk ke `hasil_tb`.

---

## 12. Penjelasan Metode AHP

### 12.1 Apa Itu AHP?

AHP adalah metode untuk menentukan bobot atau tingkat kepentingan.

Dalam sistem ini, AHP menjawab pertanyaan:

```text
Dari 5 kriteria yang ada, kriteria mana yang paling berpengaruh terhadap menu favorit?
```

Contoh:

- Rasa mungkin lebih penting daripada porsi.
- Tampilan mungkin lebih penting daripada gizi.
- Harga mungkin lebih penting daripada porsi.

Perbandingan seperti itu disusun menjadi matriks.

### 12.2 Kriteria Dalam AHP

Kriteria:

| Kode | Kriteria |
| --- | --- |
| C1 | Rasa |
| C2 | Tampilan Penyajian |
| C3 | Harga |
| C4 | Porsi |
| C5 | Gizi |

### 12.3 Matriks Perbandingan Berpasangan

Matriks dari halaman `resources/views/admin/ahp/index.blade.php`:

| Kriteria | Rasa | Tampilan Penyajian | Harga | Porsi | Gizi |
| --- | ---: | ---: | ---: | ---: | ---: |
| Rasa | 1.000 | 3.000 | 2.000 | 3.000 | 2.000 |
| Tampilan Penyajian | 0.333 | 1.000 | 2.000 | 3.000 | 2.000 |
| Harga | 0.500 | 0.500 | 1.000 | 3.000 | 2.000 |
| Porsi | 0.333 | 0.333 | 0.333 | 1.000 | 2.000 |
| Gizi | 0.500 | 0.500 | 0.500 | 0.500 | 1.000 |
| Jumlah kolom | 2.667 | 5.333 | 5.833 | 10.500 | 9.000 |

Cara membaca:

- Nilai 1 berarti sama penting dengan dirinya sendiri.
- Nilai 3 berarti kriteria baris dianggap lebih penting daripada kriteria kolom.
- Nilai 0.333 berarti kebalikan dari 3, yaitu 1/3.
- Nilai 0.500 berarti kebalikan dari 2, yaitu 1/2.

### 12.4 Rumus Normalisasi AHP

Untuk menormalisasi matriks:

```text
nilai_normalisasi = nilai_matriks / jumlah_kolom
```

Contoh:

Nilai Rasa terhadap Rasa:

```text
1.000 / 2.667 = 0.375
```

Nilai Rasa terhadap Tampilan Penyajian:

```text
3.000 / 5.333 = 0.563
```

### 12.5 Matriks Ternormalisasi dan Bobot

| Kriteria | Rasa | Tampilan Penyajian | Harga | Porsi | Gizi | Jumlah | Bobot |
| --- | ---: | ---: | ---: | ---: | ---: | ---: | ---: |
| Rasa | 0.375 | 0.563 | 0.343 | 0.286 | 0.222 | 1.788 | 0.358 |
| Tampilan Penyajian | 0.125 | 0.188 | 0.343 | 0.286 | 0.222 | 1.163 | 0.233 |
| Harga | 0.188 | 0.094 | 0.171 | 0.286 | 0.222 | 0.961 | 0.192 |
| Porsi | 0.125 | 0.063 | 0.057 | 0.095 | 0.222 | 0.562 | 0.112 |
| Gizi | 0.188 | 0.094 | 0.086 | 0.048 | 0.111 | 0.526 | 0.105 |
| Total | | | | | | | 1.000 |

Rumus bobot:

```text
bobot_kriteria = jumlah_nilai_normalisasi_pada_baris / jumlah_kriteria
```

Contoh bobot Rasa:

```text
bobot_Rasa = 1.788 / 5 = 0.358
```

### 12.6 Bobot AHP Final

Bobot ini juga ada di:

```text
app/Services/SawService.php
```

Kode:

```php
const AHP_WEIGHTS = [
    'Rasa'               => 0.358,
    'Tampilan Penyajian' => 0.233,
    'Harga'              => 0.192,
    'Porsi'              => 0.112,
    'Gizi'               => 0.105,
];
```

Tabel:

| No | Kriteria | Bobot | Persentase |
| --- | --- | ---: | ---: |
| 1 | Rasa | 0.358 | 35.8% |
| 2 | Tampilan Penyajian | 0.233 | 23.3% |
| 3 | Harga | 0.192 | 19.2% |
| 4 | Porsi | 0.112 | 11.2% |
| 5 | Gizi | 0.105 | 10.5% |
| | Total | 1.000 | 100% |

Makna:

- Rasa memiliki pengaruh paling besar.
- Gizi memiliki pengaruh paling kecil pada bobot AHP.
- Semua bobot jika dijumlahkan menjadi 1.000.

### 12.7 Uji Konsistensi AHP

AHP perlu diuji konsistensinya.

Mengapa?

Karena jika perbandingan antar kriteria tidak konsisten, bobot yang dihasilkan bisa tidak layak digunakan.

Nilai dari sistem:

| Komponen | Nilai |
| --- | ---: |
| n | 5 |
| Lambda maks | 5.442 |
| CI | 0.110 |
| RI | 1.12 |
| CR | 0.099 |

Rumus CI:

```text
CI = (lambda_maks - n) / (n - 1)
```

Perhitungan:

```text
CI = (5.442 - 5) / (5 - 1)
CI = 0.442 / 4
CI = 0.110
```

Rumus CR:

```text
CR = CI / RI
```

Perhitungan:

```text
CR = 0.110 / 1.12
CR = 0.099
```

Aturan:

```text
Jika CR < 0.1, maka konsisten.
Jika CR >= 0.1, maka tidak konsisten.
```

Hasil sistem:

```text
0.099 < 0.1
```

Kesimpulan:

Bobot AHP dianggap konsisten dan dapat digunakan dalam perhitungan SAW.

---

## 13. Penjelasan Metode SAW

### 13.1 Apa Itu SAW?

SAW adalah metode untuk menghitung nilai akhir setiap alternatif.

Dalam sistem ini:

- Alternatif = menu makanan.
- Kriteria = rasa, tampilan penyajian, harga, porsi, gizi.
- Nilai alternatif = rata-rata penilaian pengguna.
- Bobot = hasil AHP.
- Skor akhir = skor SAW.

SAW menjawab pertanyaan:

```text
Setelah semua menu dinilai, menu mana yang memiliki skor terbaik?
```

### 13.2 Lokasi Kode SAW

Semua logika utama SAW ada di:

```text
app/Services/SawService.php
```

Method penting:

| Method | Fungsi |
| --- | --- |
| `calculate()` | Menghitung ulang skor SAW dan menyimpan ke `hasil_tb`. |
| `getResults()` | Mengambil ranking dari `hasil_tb` berdasarkan skor tertinggi. |
| `getCalculationBreakdown()` | Menghasilkan detail perhitungan: raw, max, normalisasi, kontribusi, skor. |

### 13.3 Data yang Dipakai SAW

SAW memakai tabel:

| Tabel | Data yang digunakan |
| --- | --- |
| `menu_tb` | Daftar menu. |
| `kriteria` | Daftar kriteria. |
| `sub_kriteria` | Bobot pilihan 1 sampai 5. |
| `penilaian_tb` | Penilaian pengguna. |
| `hasil_tb` | Tempat menyimpan skor akhir. |

### 13.4 Semua Kriteria Bersifat Benefit

Semua kriteria dianggap benefit.

Artinya:

```text
Semakin besar nilai, semakin baik.
```

Contoh:

| Kriteria | Nilai tinggi berarti |
| --- | --- |
| Rasa | Semakin disukai. |
| Tampilan Penyajian | Semakin menarik. |
| Harga | Semakin murah atau terjangkau. |
| Porsi | Semakin sesuai atau banyak. |
| Gizi | Semakin seimbang. |

Untuk Harga, sistem tidak menganggap angka rupiah lebih besar sebagai lebih baik. Yang dinilai pengguna adalah sub-kriteria harga, misalnya:

- Sangat Mahal = 1
- Mahal = 2
- Terjangkau = 3
- Murah = 4
- Sangat Murah = 5

Jadi nilai 5 pada Harga berarti lebih baik.

### 13.5 Langkah 1: Mengambil Rata-rata Penilaian

Di `SawService.php`, sistem mengambil semua penilaian untuk setiap pasangan menu dan kriteria.

Rumus:

```text
x_ij = total_bobot_subkriteria / jumlah_penilaian
```

Keterangan:

| Simbol | Arti |
| --- | --- |
| `x_ij` | Nilai rata-rata menu ke-i pada kriteria ke-j. |
| `total_bobot_subkriteria` | Jumlah bobot sub-kriteria yang dipilih pengguna. |
| `jumlah_penilaian` | Banyaknya pengguna yang menilai menu tersebut pada kriteria tersebut. |

Contoh:

Menu Nasi Liwet pada kriteria Rasa dinilai 3 pengguna:

| Pengguna | Pilihan | Bobot |
| --- | --- | ---: |
| User 1 | Suka | 4 |
| User 2 | Sangat Suka | 5 |
| User 3 | Suka | 4 |

Perhitungan:

```text
x = (4 + 5 + 4) / 3
x = 13 / 3
x = 4.333
```

Jika belum ada penilaian:

```text
x = 0
```

### 13.6 Langkah 2: Mencari Nilai Maksimum Tiap Kriteria

Sistem mencari nilai rata-rata tertinggi pada setiap kriteria.

Rumus:

```text
max_j = nilai terbesar pada kriteria j
```

Contoh:

Nilai rata-rata kriteria Rasa:

| Menu | Nilai Rasa |
| --- | ---: |
| Menu A | 4.333 |
| Menu B | 3.500 |
| Menu C | 4.000 |

Nilai maksimum:

```text
max_Rasa = 4.333
```

### 13.7 Langkah 3: Normalisasi SAW

Karena semua kriteria benefit, rumus normalisasi:

```text
r_ij = x_ij / max_j
```

Keterangan:

| Simbol | Arti |
| --- | --- |
| `r_ij` | Nilai normalisasi menu ke-i pada kriteria ke-j. |
| `x_ij` | Nilai rata-rata menu. |
| `max_j` | Nilai tertinggi pada kriteria tersebut. |

Contoh:

```text
x_Rasa_MenuA = 4.000
max_Rasa = 4.333

r = 4.000 / 4.333
r = 0.923
```

Jika `max_j = 0`, sistem memberi nilai normalisasi:

```text
r_ij = 0
```

Ini mencegah error pembagian dengan nol.

### 13.8 Langkah 4: Menghitung Kontribusi Kriteria

Setiap nilai normalisasi dikalikan bobot AHP.

Rumus:

```text
kontribusi_ij = r_ij x w_j
```

Keterangan:

| Simbol | Arti |
| --- | --- |
| `kontribusi_ij` | Pengaruh kriteria j terhadap menu i. |
| `r_ij` | Nilai normalisasi. |
| `w_j` | Bobot AHP kriteria. |

Contoh:

Jika normalisasi Rasa = 0.923 dan bobot Rasa = 0.358:

```text
kontribusi_Rasa = 0.923 x 0.358
kontribusi_Rasa = 0.330
```

### 13.9 Langkah 5: Menghitung Skor SAW

Skor akhir menu adalah jumlah seluruh kontribusi.

Rumus:

```text
V_i = SUM(r_ij x w_j)
```

Dalam sistem:

```text
V_menu =
  (r_Rasa x 0.358)
+ (r_Tampilan x 0.233)
+ (r_Harga x 0.192)
+ (r_Porsi x 0.112)
+ (r_Gizi x 0.105)
```

Skor maksimum teoritis:

```text
0.358 + 0.233 + 0.192 + 0.112 + 0.105 = 1.000
```

Jadi skor SAW berada di rentang:

```text
0 sampai 1
```

Semakin mendekati 1, semakin baik.

### 13.10 Langkah 6: Menyimpan Hasil Ranking

Method:

```php
calculate()
```

Cara kerja:

1. Sistem memanggil `getCalculationBreakdown()`.
2. Sistem menghapus isi `hasil_tb` dengan `truncate()`.
3. Sistem mengisi ulang `hasil_tb` dengan skor baru.
4. Ranking ditampilkan berdasarkan `orderByDesc('skor')`.

Kenapa `hasil_tb` dihapus lalu diisi ulang?

Karena ranking harus selalu mengikuti data penilaian terbaru. Jika ada pengguna mengubah penilaian, hasil lama tidak boleh dipakai lagi.

---

## 14. Contoh Sederhana Perhitungan

Contoh ini memakai satu menu saja agar mudah dipahami.

Misal menu A memiliki nilai rata-rata:

| Kriteria | Nilai rata-rata | Nilai max kriteria | Normalisasi |
| --- | ---: | ---: | ---: |
| Rasa | 4.000 | 4.333 | 0.923 |
| Tampilan Penyajian | 4.333 | 4.333 | 1.000 |
| Harga | 3.000 | 3.333 | 0.900 |
| Porsi | 4.333 | 4.333 | 1.000 |
| Gizi | 4.000 | 4.000 | 1.000 |

Bobot AHP:

| Kriteria | Bobot |
| --- | ---: |
| Rasa | 0.358 |
| Tampilan Penyajian | 0.233 |
| Harga | 0.192 |
| Porsi | 0.112 |
| Gizi | 0.105 |

Kontribusi:

| Kriteria | Normalisasi | Bobot | Kontribusi |
| --- | ---: | ---: | ---: |
| Rasa | 0.923 | 0.358 | 0.330 |
| Tampilan Penyajian | 1.000 | 0.233 | 0.233 |
| Harga | 0.900 | 0.192 | 0.173 |
| Porsi | 1.000 | 0.112 | 0.112 |
| Gizi | 1.000 | 0.105 | 0.105 |

Skor akhir:

```text
V = 0.330 + 0.233 + 0.173 + 0.112 + 0.105
V = 0.953
```

Artinya:

Menu tersebut mendapatkan skor SAW 0.953 dan dapat menjadi peringkat pertama jika tidak ada menu lain dengan skor lebih tinggi.

---

## 15. Cara Sistem Menyimpan dan Memperbarui Ranking

### 15.1 Saat Pengguna Menyimpan Penilaian

Controller:

```text
app/Http/Controllers/User/PenilaianController.php
```

Method:

```php
store()
```

Urutan:

```text
1. Ambil user yang sedang login.
2. Ambil menu yang sedang dinilai.
3. Ambil semua kriteria.
4. Validasi input.
5. Simpan data penilaian dengan updateOrCreate.
6. Jalankan SawService::calculate().
7. Redirect kembali ke halaman penilaian.
```

### 15.2 Mengapa Memakai `updateOrCreate`

Kode:

```php
PenilaianTb::updateOrCreate(
    [
        'id_user' => $user->id_user,
        'id_menu' => $menu->id_menu,
        'id_kriteria' => $kriteria->id_kriteria,
    ],
    [
        'id_subkriteria' => $validated['ratings'][$kriteria->id_kriteria],
    ]
);
```

Artinya:

- Jika user belum pernah menilai menu tersebut pada kriteria itu, sistem membuat data baru.
- Jika user sudah pernah menilai, sistem memperbarui data lama.

Keuntungannya:

- Tidak ada data penilaian ganda untuk kriteria yang sama.
- Pengguna tetap bisa mengubah penilaian.
- Ranking akan mengikuti penilaian terbaru.

### 15.3 Saat Admin Melihat Ranking

Controller:

```text
app/Http/Controllers/Admin/SawController.php
```

Method:

```php
index()
```

Data yang dikirim ke view:

| Variabel | Isi |
| --- | --- |
| `$results` | Hasil ranking dari `hasil_tb`. |
| `$hasData` | Mengecek apakah ada penilaian. |
| `$calculation` | Detail raw score, max, normalisasi, kontribusi, skor. |

---

## 16. Autentikasi dan Keamanan Dasar

### 16.1 Dual Guard

Sistem memakai dua guard:

```text
config/auth.php
```

| Guard | Provider | Model | Tabel | Untuk |
| --- | --- | --- | --- | --- |
| `web` | `admins` | `Admin` | `admin` | Login admin. |
| `user` | `users` | `UserTb` | `user_tb` | Login pengguna. |

Kenapa dipisah?

Karena admin dan pengguna adalah jenis akun yang berbeda. Admin tidak disimpan di tabel user biasa.

### 16.2 Middleware

Middleware terdaftar di:

```text
bootstrap/app.php
```

Alias:

```php
'admin' => App\Http\Middleware\AdminMiddleware::class
'auth.user' => App\Http\Middleware\UserMiddleware::class
```

Fungsi:

| Middleware | Fungsi |
| --- | --- |
| `admin` | Melindungi halaman admin. |
| `auth.user` | Melindungi halaman pengguna yang membutuhkan login. |

### 16.3 Password

Password tidak disimpan dalam bentuk asli.

Laravel menyimpan password dalam bentuk hash.

Model `Admin` dan `UserTb` memiliki cast:

```php
protected function casts(): array
{
    return [
        'admin_password' => 'hashed',
    ];
}
```

dan:

```php
protected function casts(): array
{
    return [
        'user_password' => 'hashed',
    ];
}
```

Selain itu, register pengguna juga memakai:

```php
Hash::make($validated['user_password'])
```

### 16.4 CSRF

Laravel memakai token CSRF untuk form POST, PUT, dan DELETE.

Jika token expired, sistem memiliki penanganan khusus pada:

```text
bootstrap/app.php
```

Jika logout gagal karena session expired, sistem akan:

- logout guard terkait,
- invalidate session,
- regenerate token,
- redirect ke halaman login.

---

## 17. Validasi Input

### 17.1 Validasi Tambah dan Edit Menu

Controller:

```text
app/Http/Controllers/Admin/MenuController.php
```

Aturan:

| Field | Aturan |
| --- | --- |
| `menu_name` | Wajib, string, maksimal 255 karakter. |
| `menu_description` | Opsional, string, maksimal 1000 karakter. |
| `menu_price` | Opsional, integer, minimal 0, maksimal 999999999. |
| `menu_image` | Opsional, harus gambar, format jpg/jpeg/png/webp, maksimal 2048 KB. |

### 17.2 Validasi Register Pengguna

Controller:

```text
app/Http/Controllers/Auth/RegisterController.php
```

Aturan:

| Field | Aturan |
| --- | --- |
| `user_name` | Wajib, string, maksimal 255 karakter. |
| `user_username` | Wajib, string, maksimal 255, unik di `user_tb`. |
| `user_password` | Wajib, minimal 6 karakter, harus dikonfirmasi. |

### 17.3 Validasi Login Pengguna

Controller:

```text
app/Http/Controllers/Auth/LoginController.php
```

Aturan:

| Field | Aturan |
| --- | --- |
| `user_username` | Wajib, string. |
| `user_password` | Wajib, string. |

### 17.4 Validasi Login Admin

Controller:

```text
app/Http/Controllers/Admin/LoginController.php
```

Aturan:

| Field | Aturan |
| --- | --- |
| `admin_username` | Wajib, string. |
| `admin_password` | Wajib, string. |

### 17.5 Validasi Penilaian Menu

Controller:

```text
app/Http/Controllers/User/PenilaianController.php
```

Aturan:

| Field | Aturan |
| --- | --- |
| `id_menu` | Wajib, integer, harus sesuai menu pada URL. |
| `ratings` | Wajib, array, jumlahnya harus sama dengan jumlah kriteria. |
| `ratings.{id_kriteria}` | Wajib, integer, harus ada di tabel `sub_kriteria` dan sesuai kriteria. |

Maknanya:

Pengguna tidak bisa mengirim pilihan sub-kriteria yang tidak sesuai dengan kriteria.

Contoh:

Pilihan "Sangat Suka" milik kriteria Rasa tidak boleh dipakai untuk kriteria Harga.

---

## 18. Pengujian Sistem

### 18.1 Testing Otomatis

Folder:

```text
tests/
```

Jalankan:

```bash
php artisan test
```

### 18.2 Test yang Ada

File:

```text
tests/Feature/ExampleTest.php
```

Fungsi:

- Mengecek halaman `/` mengarah ke route ranking.

File:

```text
tests/Feature/UserPenilaianFlowTest.php
```

Fungsi:

1. Mengecek halaman daftar penilaian menampilkan link ke halaman penilaian per menu.
2. Mengecek form inline lama tidak muncul.
3. Mengecek penilaian user tersimpan untuk menu yang dipilih.
4. Mengecek penilaian tidak tersimpan ke menu lain.

### 18.3 Black Box Testing Manual

Black Box Testing berarti menguji sistem dari sisi pengguna tanpa melihat kode program.

Contoh skenario admin:

| No | Modul | Yang diuji | Hasil yang diharapkan |
| --- | --- | --- | --- |
| 1 | Login admin | Username dan password benar | Masuk dashboard admin. |
| 2 | Dashboard | Buka dashboard | Statistik tampil. |
| 3 | Kelola menu | Tambah menu | Menu tersimpan. |
| 4 | Kelola menu | Edit menu | Menu berubah. |
| 5 | Kelola menu | Hapus menu | Menu tidak tampil di daftar aktif. |
| 6 | Bobot AHP | Buka halaman AHP | Bobot dan CR tampil. |
| 7 | Ranking SAW | Buka halaman SAW | Ranking tampil. |
| 8 | Logout | Klik logout | Sesi admin selesai. |

Contoh skenario pengguna:

| No | Modul | Yang diuji | Hasil yang diharapkan |
| --- | --- | --- | --- |
| 1 | Register | Membuat akun baru | Akun tersimpan. |
| 2 | Login | Username dan password benar | Masuk halaman pengguna. |
| 3 | Ranking publik | Buka `/ranking` | Ranking tampil tanpa login. |
| 4 | Penilaian | Pilih menu | Form penilaian tampil. |
| 5 | Penilaian | Isi semua kriteria | Data tersimpan. |
| 6 | SAW | Setelah penilaian tersimpan | Ranking diperbarui. |
| 7 | Logout | Klik logout | Sesi pengguna selesai. |

---

## 19. Catatan Penting Untuk Laporan Tugas Akhir

Bagian ini berguna untuk menjelaskan sistem saat seminar hasil.

### 19.1 Kenapa Harus AHP dan SAW?

Pemilihan menu favorit sebenarnya bisa dilakukan dengan rata-rata biasa. Namun rata-rata biasa menganggap semua kriteria sama penting.

Contoh:

```text
Rasa dianggap sama penting dengan gizi.
Harga dianggap sama penting dengan tampilan.
Porsi dianggap sama penting dengan rasa.
```

Padahal dalam penelitian ini, setiap kriteria memiliki pengaruh yang berbeda.

AHP digunakan untuk memberi bobot:

| Kriteria | Bobot |
| --- | ---: |
| Rasa | 0.358 |
| Tampilan Penyajian | 0.233 |
| Harga | 0.192 |
| Porsi | 0.112 |
| Gizi | 0.105 |

SAW digunakan untuk menghitung ranking berdasarkan bobot tersebut.

Jadi jawaban singkat jika ditanya:

```text
Tanpa AHP-SAW, sistem hanya menghitung rata-rata biasa.
Dengan AHP-SAW, ranking mempertimbangkan tingkat kepentingan setiap kriteria.
```

### 19.2 Dari Mana Nilai SAW Muncul?

Nilai SAW muncul dari data penilaian pengguna.

Langkahnya:

```text
Penilaian user -> rata-rata per menu dan kriteria -> normalisasi -> dikali bobot AHP -> skor SAW
```

Jika banyak pengguna menilai menu yang sama:

```text
Sistem menjumlahkan bobot sub-kriteria yang dipilih,
lalu membaginya dengan jumlah penilaian pada kriteria tersebut.
```

### 19.3 Kenapa Skor Tertinggi Bisa Tidak 1?

Skor SAW maksimum teoritis adalah 1.000.

Namun skor tertinggi tidak harus selalu 1.000.

Sebab:

1. Setiap menu belum tentu menjadi terbaik di semua kriteria.
2. Nilai akhir adalah gabungan dari 5 kontribusi kriteria.
3. Jika menu hanya terbaik pada beberapa kriteria, skor akhirnya bisa di bawah 1.

Jadi skor tertinggi 0.953 tetap valid.

### 19.4 Apa Arti Validasi Excel 100%?

Validasi Excel bukan uji akurasi prediksi selera.

Validasi Excel artinya:

```text
Hasil hitung manual di Excel sama dengan hasil hitung sistem.
```

Jika 8 dari 8 menu cocok:

```text
Kesesuaian perhitungan = 8 / 8 x 100% = 100%
```

Makna:

Rumus yang dipakai sistem sudah sesuai dengan rumus manual.

### 19.5 Apakah Data Dummy Boleh?

Untuk tahap pengembangan dan demonstrasi sistem, data dummy boleh digunakan sebagai data testing.

Namun untuk hasil penelitian yang kuat, sebaiknya dijelaskan:

```text
Data dummy digunakan untuk pengujian fungsi dan validasi perhitungan sistem.
Untuk implementasi nyata, sistem perlu diisi oleh responden atau pengguna aktual Kantin Kanvanesa.
```

---

## 20. Troubleshooting

| Masalah | Penyebab umum | Solusi |
| --- | --- | --- |
| `php artisan` tidak jalan | PHP belum terpasang atau belum masuk PATH | Install PHP atau XAMPP, lalu cek `php -v`. |
| `composer install` gagal | Composer belum terpasang | Install Composer. |
| Database tidak terhubung | Konfigurasi `.env` salah | Cek `DB_CONNECTION`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`. |
| `Base table not found` | Migration belum dijalankan | Jalankan `php artisan migrate:fresh --seed`. |
| Login admin gagal | Seeder belum jalan atau password salah | Jalankan seeder, gunakan `admin` dan `admin123`. |
| Login user demo gagal | Seeder belum jalan atau password salah | Gunakan `user_demo` dan `password123`. |
| Gambar menu tidak muncul | Storage link belum dibuat | Jalankan `php artisan storage:link`. |
| Ranking kosong | Belum ada data penilaian atau hasil SAW belum dihitung | Isi penilaian atau jalankan seeder. |
| Skor semua 0 | Tidak ada penilaian yang valid | Pastikan ada data di `penilaian_tb`. |
| Port 8000 dipakai | Ada server lain berjalan | Jalankan `php artisan serve --port=8080`. |
| CSRF token mismatch | Session expired | Refresh halaman, login ulang. |
| Upload gambar gagal | Ukuran atau format tidak sesuai | Gunakan jpg, jpeg, png, webp maksimal 2 MB. |

---

## 21. FAQ

### 21.1 Apakah halaman ranking bisa dibuka tanpa login?

Ya.

Halaman:

```text
/ranking
```

dapat dibuka tanpa login.

### 21.2 Apakah pengguna harus login untuk menilai?

Ya.

Pengguna harus login atau register terlebih dahulu agar sistem tahu siapa yang memberi penilaian.

### 21.3 Apakah satu user bisa menilai menu yang sama lebih dari sekali?

User dapat mengubah penilaian, tetapi sistem tidak membuat data ganda untuk kriteria yang sama.

Sistem memakai:

```text
unique(id_user, id_menu, id_kriteria)
```

dan:

```php
updateOrCreate()
```

### 21.4 Apakah admin bisa mengubah bobot AHP dari website?

Tidak pada versi ini.

Bobot AHP bersifat statis dan ditulis di:

```text
app/Services/SawService.php
resources/views/admin/ahp/index.blade.php
```

### 21.5 Kenapa tabel `hasil_tb` dihapus dan diisi ulang?

Karena ranking harus mengikuti penilaian terbaru.

Jika user mengubah penilaian, skor lama tidak boleh dipakai lagi.

### 21.6 Apakah semua data yang dihapus benar-benar hilang?

Tidak semuanya.

Sebagian besar tabel utama memakai soft delete, sehingga data diberi tanda `deleted_at`.

Namun pada gambar menu, file gambar lama dapat dihapus dari storage ketika admin mengganti atau menghapus menu.

### 21.7 Apakah sistem ini memakai API?

Tidak ada API terpisah. Sistem menggunakan route web Laravel dan Blade view.

### 21.8 Apakah sistem memakai database MySQL atau SQLite?

Kode Laravel dapat memakai database sesuai `.env`.

Untuk tugas akhir dan sistem yang dijelaskan pada laporan, gunakan MySQL.

File `.env.example` bawaan masih default SQLite, jadi perlu diubah jika memakai MySQL.

---

## 22. Ringkasan File Penting

| File | Fungsi |
| --- | --- |
| `routes/web.php` | Daftar URL sistem. |
| `config/auth.php` | Konfigurasi guard admin dan user. |
| `bootstrap/app.php` | Registrasi middleware dan handling error session. |
| `app/Services/SawService.php` | Perhitungan SAW dan bobot AHP. |
| `app/Http/Controllers/Admin/MenuController.php` | CRUD menu admin. |
| `app/Http/Controllers/Admin/SawController.php` | Menampilkan hasil SAW admin. |
| `app/Http/Controllers/Admin/AhpController.php` | Menampilkan halaman AHP. |
| `app/Http/Controllers/User/PenilaianController.php` | Menampilkan dan menyimpan penilaian pengguna. |
| `app/Http/Controllers/User/RankingController.php` | Menampilkan ranking publik. |
| `app/Models/MenuTb.php` | Model tabel menu. |
| `app/Models/PenilaianTb.php` | Model tabel penilaian. |
| `app/Models/HasilTb.php` | Model tabel hasil SAW. |
| `database/migrations` | Struktur tabel database. |
| `database/seeders/KriteriaSeeder.php` | Data kriteria dan sub-kriteria. |
| `database/seeders/MenuSeeder.php` | Data awal menu. |
| `database/seeders/PenilaianSeeder.php` | Data dummy penilaian dan trigger SAW. |
| `resources/views/admin/ahp/index.blade.php` | Tampilan AHP, matriks, bobot, CR. |
| `resources/views/admin/saw/index.blade.php` | Tampilan ranking dan detail SAW admin. |
| `resources/views/user/ranking.blade.php` | Tampilan ranking publik. |
| `resources/views/user/penilaian/index.blade.php` | Daftar menu yang dapat dinilai. |
| `resources/views/user/penilaian/show.blade.php` | Form penilaian per menu. |

---

## 23. Catatan Developer

### 23.1 File Seeder Lama yang Tidak Dipakai

Di folder `database/seeders` terdapat file:

```text
CriteriaSeeder.php
```

Namun `DatabaseSeeder.php` memanggil:

```text
KriteriaSeeder.php
```

Jadi yang aktif untuk sistem saat ini adalah `KriteriaSeeder.php`, bukan `CriteriaSeeder.php`.

### 23.2 Salinan Service

Terdapat file:

```text
app/Services/SawService copy.php
```

File utama yang dipakai sistem adalah:

```text
app/Services/SawService.php
```

Jika ingin merapikan proyek untuk seminar atau deployment, file salinan yang tidak dipakai dapat dipertimbangkan untuk dihapus setelah dipastikan tidak dibutuhkan.

### 23.3 Format Skor

Di database:

```text
hasil_tb.skor = decimal(10,6)
```

Artinya database menyimpan sampai 6 angka di belakang koma.

Di tampilan, skor dapat diformat menjadi 3 angka di belakang koma menggunakan:

```php
number_format($skor, 3)
```

---

## 24. Kesimpulan Dokumentasi

Sistem Kanvanesa bekerja dengan konsep berikut:

```text
Admin mengelola menu.
Pengguna memberi penilaian.
Penilaian diubah menjadi rata-rata nilai alternatif.
AHP menyediakan bobot kriteria.
SAW menghitung skor akhir menu.
Sistem menampilkan ranking menu dari skor tertinggi.
```

Dengan dokumentasi ini, pembaca awam dapat memahami fungsi sistem, sedangkan developer atau dosen penguji dapat menelusuri rumus, tabel database, route, model, controller, dan file perhitungan yang digunakan dalam aplikasi.