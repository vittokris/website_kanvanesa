# Dokumentasi Situs Web Kanvanesa

Dokumentasi ini berisi informasi umum, panduan teknis, dan catatan terstruktur tentang cara kerja, desain, serta arsitektur situs web Kanvanesa.

Kanvanesa adalah situs web untuk menampilkan dan menentukan menu favorit di Kantin Kanvanesa. Sistem ini mengumpulkan penilaian pengguna terhadap menu, lalu mengolahnya menjadi ranking yang mudah dibaca oleh pengunjung, pengguna, dan admin.

Versi dokumentasi: 3.0.0  
Tanggal pembaruan: 17 Juli 2026  
Framework utama: Laravel 12  
Lokasi proyek: `website_kanvanesa`

---

## Daftar Isi

1. Gambaran umum
2. Pengguna sistem
3. Fitur utama
4. Cara kerja sistem
5. Penjelasan perhitungan AHP dan SAW
6. Desain dan pengalaman pengguna
7. Arsitektur teknis
8. Struktur folder
9. Database dan data utama
10. Halaman dan alamat akses
11. Panduan instalasi
12. Menjalankan aplikasi
13. Pengujian
14. Keamanan dan validasi
15. Catatan pengelolaan konten
16. Troubleshooting
17. Ringkasan file penting

---

## 1. Gambaran Umum

Situs web Kanvanesa membantu pengelola kantin mengetahui menu yang paling disukai berdasarkan data penilaian pengguna. Pengunjung dapat melihat ranking menu secara langsung, sedangkan pengguna yang memiliki akun dapat ikut memberi penilaian.

Sistem ini dibuat agar proses pemilihan menu favorit tidak hanya berdasarkan perkiraan. Setiap menu dinilai melalui beberapa kriteria, kemudian hasilnya dihitung menjadi skor akhir. Skor tersebut digunakan untuk mengurutkan menu dari yang paling tinggi sampai paling rendah.

Kriteria penilaian yang digunakan:

| Kriteria | Makna umum |
| --- | --- |
| Rasa | Seberapa disukai rasa menu. |
| Tampilan Penyajian | Seberapa menarik tampilan menu saat disajikan. |
| Harga | Seberapa sesuai atau terjangkau harga menu. |
| Porsi | Seberapa sesuai jumlah porsi menu. |
| Gizi | Seberapa baik keseimbangan gizi menu. |

Hasil utama yang ditampilkan sistem adalah ranking menu, skor akhir, dan informasi ringkas setiap menu.

---

## 2. Pengguna Sistem

Sistem ini memiliki tiga kelompok pengguna.

| Pengguna | Kebutuhan utama | Akses |
| --- | --- | --- |
| Pengunjung publik | Melihat ranking menu tanpa login. | Halaman ranking publik. |
| Pengguna terdaftar | Memberi penilaian terhadap menu. | Dashboard pengguna dan halaman penilaian. |
| Admin | Mengelola menu dan memantau hasil perhitungan. | Dashboard admin, manajemen menu, AHP, dan SAW. |

Pengunjung publik tidak perlu membuat akun untuk melihat ranking. Akun hanya diperlukan jika seseorang ingin memberi penilaian.

---

## 3. Fitur Utama

### Untuk Pengunjung Publik

- Melihat daftar ranking menu favorit.
- Melihat skor menu.
- Melihat informasi menu seperti nama, deskripsi, harga, dan gambar jika tersedia.
- Masuk ke halaman login atau register jika ingin memberi penilaian.

### Untuk Pengguna Terdaftar

- Membuat akun pengguna.
- Login dan logout.
- Melihat dashboard pengguna.
- Melihat daftar menu yang dapat dinilai.
- Memberi penilaian untuk setiap menu berdasarkan lima kriteria.
- Memperbarui penilaian yang sudah pernah diberikan.

### Untuk Admin

- Login dan logout admin.
- Melihat dashboard ringkasan data.
- Menambah, mengubah, dan menghapus menu.
- Mengunggah gambar menu.
- Melihat bobot AHP yang digunakan sistem.
- Melihat ranking SAW dan detail kontribusi tiap kriteria.

---

## 4. Cara Kerja Sistem

Alur kerja utama sistem:

```text
Admin mengelola data menu
Pengguna memberi penilaian menu
Sistem menyimpan penilaian
Sistem menghitung ulang skor SAW
Ranking menu diperbarui
Pengunjung melihat ranking terbaru
```

Penilaian pengguna disimpan berdasarkan kombinasi pengguna, menu, dan kriteria. Dengan cara ini, satu pengguna hanya memiliki satu nilai aktif untuk satu kriteria pada satu menu. Jika pengguna menilai ulang, sistem memperbarui nilai sebelumnya.

Setelah penilaian berhasil disimpan, sistem menjalankan ulang perhitungan ranking. Hasil akhir disimpan ke tabel hasil agar halaman ranking dapat menampilkan data terbaru secara cepat.

---

## 5. Penjelasan Perhitungan AHP dan SAW

Sistem menggunakan dua metode pendukung keputusan: AHP dan SAW.

### AHP

AHP digunakan untuk menentukan bobot atau tingkat kepentingan setiap kriteria. Bobot ini menunjukkan kriteria mana yang pengaruhnya lebih besar terhadap hasil akhir.

Bobot AHP yang digunakan:

| Kriteria | Bobot |
| --- | ---: |
| Rasa | 0.358 |
| Tampilan Penyajian | 0.233 |
| Harga | 0.192 |
| Porsi | 0.112 |
| Gizi | 0.105 |

Semakin besar bobot, semakin besar pengaruh kriteria tersebut terhadap ranking.

### SAW

SAW digunakan untuk menghitung skor akhir setiap menu. Secara sederhana, sistem melakukan langkah berikut:

1. Mengambil rata-rata penilaian tiap menu pada setiap kriteria.
2. Membandingkan nilai menu dengan nilai tertinggi pada kriteria yang sama.
3. Mengalikan nilai yang sudah dinormalisasi dengan bobot AHP.
4. Menjumlahkan semua kontribusi kriteria menjadi skor akhir.
5. Mengurutkan menu dari skor tertinggi ke skor terendah.

Semua kriteria diperlakukan sebagai benefit, artinya nilai yang lebih tinggi dianggap lebih baik.

---

## 6. Desain dan Pengalaman Pengguna

Tampilan situs dirancang agar mudah dipindai oleh pengunjung kantin, pengguna, dan admin.

Prinsip desain:

- Ranking harus terlihat jelas sebagai hasil keputusan.
- Form penilaian dibuat ringkas agar pengguna tidak merasa berat saat memberi nilai.
- Halaman admin menampilkan data dan aksi utama secara langsung.
- Informasi menu dibuat mudah dibaca melalui nama, gambar, harga, deskripsi, dan skor.
- Tampilan harus responsif agar dapat digunakan di perangkat desktop maupun mobile.

Secara umum, situs menggunakan pola halaman berikut:

| Area | Fokus tampilan |
| --- | --- |
| Publik | Ranking menu dan ringkasan informasi menu. |
| Pengguna | Dashboard dan form penilaian. |
| Admin | Statistik, pengelolaan menu, dan hasil perhitungan. |

---

## 7. Arsitektur Teknis

Kanvanesa dibangun sebagai aplikasi web berbasis Laravel.

| Bagian | Teknologi |
| --- | --- |
| Backend | PHP 8.2 dan Laravel 12 |
| Frontend | Blade, Tailwind CSS, Alpine.js |
| Build asset | Vite |
| Database | Diatur melalui `.env`, umumnya MySQL saat deployment |
| Autentikasi | Session guard Laravel untuk admin dan pengguna |
| Upload file | Laravel Storage disk `public` |
| Testing | PHPUnit melalui `php artisan test` |

Pola arsitektur yang digunakan:

- Route menerima permintaan dari browser.
- Controller mengatur alur halaman dan validasi input.
- Model mewakili data pada database.
- Service menangani logika perhitungan SAW.
- Blade view menampilkan antarmuka pengguna.
- Migration dan seeder mengatur struktur serta data awal database.

Alur teknis singkat:

```text
Browser
  -> Route Laravel
  -> Controller
  -> Model atau Service
  -> Database
  -> Blade View
  -> Browser
```

---

## 8. Struktur Folder

Folder penting dalam proyek:

| Folder atau file | Fungsi |
| --- | --- |
| `app/Http/Controllers` | Berisi controller untuk admin, pengguna, dan autentikasi. |
| `app/Models` | Berisi model database seperti menu, pengguna, penilaian, dan hasil. |
| `app/Services/SawService.php` | Berisi logika utama perhitungan ranking SAW. |
| `config` | Konfigurasi aplikasi Laravel. |
| `database/migrations` | Struktur tabel database. |
| `database/seeders` | Data awal seperti admin, kriteria, menu, user demo, dan penilaian contoh. |
| `public` | File publik yang dapat diakses browser. |
| `resources/views` | Tampilan halaman Blade. |
| `routes/web.php` | Daftar alamat halaman utama aplikasi. |
| `storage` | Penyimpanan file aplikasi, termasuk upload menu. |
| `tests` | Pengujian otomatis. |
| `composer.json` | Dependensi PHP dan script Laravel. |
| `package.json` | Dependensi frontend dan script Vite. |

---

## 9. Database dan Data Utama

Tabel utama yang digunakan sistem:

| Tabel | Isi data |
| --- | --- |
| `admin` | Akun admin sistem. |
| `user_tb` | Akun pengguna terdaftar. |
| `kriteria` | Daftar kriteria penilaian. |
| `sub_kriteria` | Pilihan nilai untuk setiap kriteria, dengan bobot 1 sampai 5. |
| `menu_tb` | Data menu kantin. |
| `penilaian_tb` | Nilai yang diberikan pengguna untuk menu. |
| `hasil_tb` | Skor akhir dan ranking hasil perhitungan SAW. |

Relasi data secara umum:

```text
Pengguna memberi banyak penilaian
Menu menerima banyak penilaian
Kriteria memiliki banyak sub-kriteria
Penilaian terhubung ke pengguna, menu, kriteria, dan sub-kriteria
Hasil ranking terhubung ke menu
```

Data awal dari seeder meliputi:

- Akun admin default.
- Akun pengguna demo.
- Lima kriteria penilaian.
- Sub-kriteria dengan bobot 1 sampai 5.
- Contoh data menu.
- Contoh penilaian untuk menghasilkan ranking awal.

---

## 10. Halaman dan Alamat Akses

Alamat utama yang tersedia:

| Alamat | Keterangan |
| --- | --- |
| `/` | Mengarahkan ke halaman ranking publik. |
| `/ranking` | Halaman ranking yang dapat dibuka tanpa login. |
| `/login` | Login pengguna. |
| `/register` | Registrasi pengguna. |
| `/dashboard` | Dashboard pengguna setelah login. |
| `/penilaian` | Halaman penilaian menu untuk pengguna login. |
| `/admin/login` | Login admin. |
| `/admin/dashboard` | Dashboard admin. |
| `/admin/menus` | Manajemen data menu. |
| `/admin/ahp` | Informasi bobot dan perhitungan AHP. |
| `/admin/saw` | Hasil ranking dan detail perhitungan SAW. |

---

## 11. Panduan Instalasi

Kebutuhan dasar:

- PHP 8.2 atau lebih baru.
- Composer.
- Node.js dan npm.
- Database, misalnya MySQL.

Langkah instalasi:

```bash
composer install
npm install
```

Buat file konfigurasi environment:

```bash
cp .env.example .env
```

Jika menggunakan Windows Command Prompt, gunakan:

```bat
copy .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Atur koneksi database di file `.env`, misalnya:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kanvanesa
DB_USERNAME=root
DB_PASSWORD=
```

Jalankan migration dan seeder:

```bash
php artisan migrate --seed
```

Buat symbolic link untuk file upload:

```bash
php artisan storage:link
```

---

## 12. Menjalankan Aplikasi

Untuk menjalankan backend Laravel:

```bash
php artisan serve
```

Untuk menjalankan Vite saat pengembangan:

```bash
npm run dev
```

Untuk membuat asset siap produksi:

```bash
npm run build
```

Script pengembangan terpadu juga tersedia melalui Composer:

```bash
composer run dev
```

Setelah server berjalan, aplikasi biasanya dapat dibuka melalui:

```text
http://127.0.0.1:8000
```

Akun demo dari seeder:

| Jenis akun | Username | Password |
| --- | --- | --- |
| Admin | `admin` | `admin123` |
| Pengguna | `user_demo` | `password123` |

Untuk penggunaan nyata, segera ubah password default setelah instalasi.

---

## 13. Pengujian

Jalankan pengujian otomatis dengan:

```bash
php artisan test
```

Area yang sebaiknya diuji secara manual:

- Halaman ranking dapat dibuka tanpa login.
- Pengguna dapat register, login, memberi penilaian, dan logout.
- Admin dapat login, menambah menu, mengubah menu, menghapus menu, dan logout.
- Upload gambar menu berjalan sesuai batas ukuran dan format.
- Ranking berubah setelah data penilaian diperbarui.
- Tampilan tetap rapi di desktop dan mobile.

---

## 14. Keamanan dan Validasi

Sistem menggunakan beberapa pengamanan dasar Laravel:

- Password disimpan dalam bentuk hash.
- Admin dan pengguna memakai guard autentikasi yang berbeda.
- Halaman admin dilindungi middleware admin.
- Halaman penilaian dilindungi autentikasi pengguna.
- Form menggunakan proteksi CSRF.
- Input menu, register, login, dan penilaian divalidasi sebelum disimpan.
- File gambar menu dibatasi pada format `jpg`, `jpeg`, `png`, atau `webp` dengan ukuran maksimum 2 MB.

Beberapa tabel mendukung soft delete. Artinya data dapat ditandai terhapus tanpa langsung hilang secara permanen dari database.

---

## 15. Catatan Pengelolaan Konten

Hal yang perlu diperhatikan admin:

- Nama menu sebaiknya singkat dan jelas.
- Deskripsi menu sebaiknya menjelaskan isi atau ciri utama menu.
- Harga diisi dalam angka tanpa format rupiah.
- Gambar menu sebaiknya jelas, terang, dan memperlihatkan menu sebenarnya.
- Jika ada menu baru, ranking akan lebih akurat setelah menu tersebut menerima cukup penilaian.
- Penilaian pengguna memengaruhi ranking, sehingga data contoh sebaiknya diganti dengan data nyata saat sistem digunakan.

---

## 16. Troubleshooting

Masalah umum dan solusi awal:

| Masalah | Solusi |
| --- | --- |
| Halaman tidak bisa dibuka | Pastikan `php artisan serve` berjalan. |
| Asset CSS atau JS tidak muncul | Jalankan `npm run dev` saat pengembangan atau `npm run build` untuk produksi. |
| Database error | Periksa konfigurasi database di `.env`, lalu jalankan migration. |
| Gambar menu tidak tampil | Jalankan `php artisan storage:link` dan pastikan file ada di storage public. |
| Ranking kosong | Pastikan ada menu, kriteria, sub-kriteria, dan penilaian. |
| Login gagal | Periksa username, password, dan data seeder. |

Jika konfigurasi berubah, bersihkan cache Laravel:

```bash
php artisan optimize:clear
```

---

## 17. Ringkasan File Penting

| File | Keterangan |
| --- | --- |
| `routes/web.php` | Daftar route halaman publik, pengguna, dan admin. |
| `app/Services/SawService.php` | Logika perhitungan skor dan ranking SAW. |
| `app/Http/Controllers/User/PenilaianController.php` | Alur penyimpanan penilaian pengguna. |
| `app/Http/Controllers/User/RankingController.php` | Data untuk halaman ranking publik. |
| `app/Http/Controllers/Admin/MenuController.php` | Pengelolaan menu oleh admin. |
| `app/Http/Controllers/Admin/AhpController.php` | Halaman informasi AHP. |
| `app/Http/Controllers/Admin/SawController.php` | Halaman hasil ranking SAW. |
| `database/seeders/DatabaseSeeder.php` | Urutan pengisian data awal. |
| `resources/views` | Seluruh tampilan halaman aplikasi. |

---

## Kesimpulan

Kanvanesa adalah situs web pendukung keputusan untuk membantu memilih menu favorit kantin berdasarkan penilaian pengguna. Dokumentasi ini disusun agar dapat dibaca oleh pembaca umum, admin, penguji, dan pengembang yang ingin memahami cara kerja, desain, serta struktur teknis aplikasi.
