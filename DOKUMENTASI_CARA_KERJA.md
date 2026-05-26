# 📖 Dokumentasi Teknis & Cara Kerja Aplikasi: YK2 Gaming Admin Panel
> **Kategori Projek**: Sistem Informasi Manajemen Operasional & Billing Rental (Studi Kasus UKMK/UMKM)  
> **Lingkungan Running**: Localhost Server (XAMPP / LAMPP)  
> **Teknologi**: HTML5, Vanilla CSS3 (Custom Properties), Vanilla JavaScript (ES6+), PHP Native API, MySQL Database.

Dokumen ini menyajikan spesifikasi teknis dan penjelasan cara kerja sistem secara mendalam dari aplikasi **YK2 Gaming Admin Panel** sebagai dokumen referensi akademik dan panduan pengembangan sistem.

---

## 🗺️ 1. Arsitektur Sistem (Three-Tier Architecture)
Aplikasi ini diimplementasikan menggunakan pola arsitektur **Three-Tier Client-Server** local-host:

```
+---------------------------------------+
|          Presentation Layer           |
|  - index.php & app.js (Admin Panel)   |
|  - status.php & JS (Customer Display) |
+------------------+--------------------+
                   | (HTTP JSON API)
                   v
+---------------------------------------+
|           Application Layer           |
|  - api.php (RESTful API Gateway)      |
|  - generate_pdf.php (DomPDF Render)   |
+------------------+--------------------+
                   | (PDO Connections)
                   v
+---------------------------------------+
|              Data Layer               |
|  - MySQL Database: adminpoli          |
+---------------------------------------+
```

1. **Presentation Layer (Frontend)**:
   * **Admin Panel (`index.php` & `app.js`)**: Antarmuka kasir untuk memantau status unit, mengatur billing sesi, mengelola daftar unit, melihat riwayat transaksi, dan mencetak/generate token. Mengimplementasikan konsep *Single Page Application (SPA)* berbasis AJAX/Fetch API.
   * **Customer Display (`status.php`)**: Halaman publik view-only bagi pelanggan untuk memantau status unit kosong dan sisa waktu bermain secara real-time. Dilengkapi fitur pencarian status sisa waktu token pribadi serta unduh struk PDF.
2. **Application Layer (Backend)**:
   * **API Gateway (`api.php`)**: Menerima request HTTP POST/GET dari frontend, melakukan validasi payload, menjalankan query SQL melalui PDO, dan mengembalikan respons asinkron berformat JSON.
   * **Struk PDF Generator (`generate_pdf.php`)**: Memproses ekspor token sisa waktu bermain ke dalam file PDF terkompresi berukuran struk thermal 80mm menggunakan library DomPDF.
3. **Data Layer (Database)**:
   * **MySQL Server**: Menyimpan data relasional secara persisten di bawah database `adminpoli`.

---

## 🗄️ 2. Struktur Schema Basis Data (`adminpoli` Database)
Koneksi database dikonfigurasi menggunakan Driver **PDO** dengan *Character Set* `utf8mb4` untuk mendukung penyimpanan data yang aman. Berikut adalah spesifikasi kolom untuk masing-masing tabel:

### A. Tabel `units` (Daftar Konsol PS)
Menyimpan data unit fisik PlayStation yang disewakan.
* `id` (VARCHAR(36), PK): UUID v4 unik identitas unit.
* `nomor` (INT): Nomor urut fisik unit (misal: 1, 2, 3).
* `tipe` (VARCHAR(50)): Jenis konsol (misal: 'PS3', 'PS4', 'PS5').
* `mode` (ENUM('ps','pc')): Kategori billing, diset default ke `'ps'`.
* `harga` (INT): Tarif sewa dasar per jam dalam satuan Rupiah (misal: 8000).
* `created_at` (DATETIME): Timestamp perekaman data unit.

### B. Tabel `sessions` (Sesi Billing Aktif)
Menyimpan data sesi sewa yang sedang berlangsung.
* `id` (VARCHAR(36), PK): UUID v4 unik identitas sesi.
* `unit_id` (VARCHAR(36), FK): ID unit relasi ke tabel `units` dengan aturan `ON DELETE CASCADE`.
* `unit_name` (VARCHAR(100)): Nama gabungan tipe dan nomor unit (misal: 'PS4 3').
* `customer` (VARCHAR(100)): Nama pelanggan yang menyewa.
* `mode` (ENUM('ps','pc')): Mode sesi.
* `start_time` (DATETIME): Waktu mulai sesi rental.
* `end_time` (DATETIME): Estimasi waktu sewa selesai.
* `duration_minutes` (INT): Total durasi bermain yang dipesan (menit).
* `metode_bayar` (ENUM('tunai','qris','token')): Metode pembayaran yang digunakan.
* `harga` (INT): Tarif per jam yang disepakati saat sesi dimulai.
* `created_at` (DATETIME): Timestamp pembuatan record sesi.

### C. Tabel `saved_tokens` (Penyimpanan Sisa Jam Bermain)
Menyimpan token sisa waktu bermain yang dikonversi dari sesi yang dihentikan sebelum waktunya habis.
* `id` (VARCHAR(36), PK): UUID v4 unik identitas token.
* `token_code` (VARCHAR(10), UNIQUE): Kode unik format `YK2-XXXX` (XXXX adalah alphanumeric acak).
* `unit_id` (VARCHAR(36), FK): Relasi ke tabel `units` (`ON DELETE CASCADE`).
* `unit_name` (VARCHAR(100)): Nama unit asal pembuatan token.
* `customer_name` (VARCHAR(100)): Nama pelanggan pemilik sisa jam.
* `remaining_minutes` (INT): Sisa durasi sewa yang belum terpakai (menit).
* `is_used` (TINYINT(1)): Status pemakaian token (0 = Belum diklaim, 1 = Sudah diklaim).
* `created_at` (DATETIME): Timestamp pembuatan token.
* `expired_at` (DATETIME): Waktu kedaluwarsa token (diset otomatis 30 hari dari `created_at`).
* `used_at` (DATETIME, NULL): Timestamp klaim pemakaian token.
* `used_unit_id` (VARCHAR(36), NULL): Unit tempat token diklaim.

### D. Tabel `history` (Riwayat Transaksi)
Menyimpan catatan transaksi historis untuk pelaporan keuangan.
* `id` (VARCHAR(36), PK): UUID v4 unik identitas transaksi.
* `unit_name` (VARCHAR(100)): Nama unit PlayStation yang digunakan.
* `mode` (ENUM('ps','pc')): Kategori billing.
* `tipe` (VARCHAR(50)): Jenis konsol (misal: 'PS4').
* `customer` (VARCHAR(100)): Nama pelanggan.
* `duration_minutes` (INT): Total durasi sewa yang berjalan (menit).
* `total` (INT): Total uang yang dibayarkan. Nilai diset `0` jika `metode_bayar` = `'token'` untuk mencegah pencatatan laba ganda.
* `metode_bayar` (ENUM('tunai','qris','token')): Cara pembayaran transaksi.
* `start_time` (DATETIME): Waktu mulai sesi.
* `end_time` (DATETIME): Waktu akhir sesi dihentikan/diselesaikan.
* `tipe_struk` (VARCHAR(20)): Label struk ('selesai' = sewa berakhir normal, 'simpan_jam' = sisa waktu dikonversi ke token).
* `saved_minutes` (INT): Sisa menit bermain yang dikonversi ke token (jika `tipe_struk` = `'simpan_jam'`).
* `created_at` (DATETIME): Waktu pencatatan transaksi ke database.

### E. Tabel `users` (Autentikasi Pengguna)
Menyimpan akun kasir dan administrator untuk keamanan akses sistem.
* `id` (VARCHAR(36), PK): UUID v4 unik identitas user.
* `username` (VARCHAR(50), UNIQUE): Nama akun login.
* `password_hash` (VARCHAR(255)): Hash password terenkripsi menggunakan algoritma Bcrypt (`PASSWORD_BCRYPT`).
* `role` (ENUM('admin','kasir')): Hak akses pengguna.
* `created_at` (DATETIME): Waktu pembuatan akun.

---

## ⚙️ 3. Spesifikasi API Backend (`api.php`)
RESTful API di backend memproses request data menggunakan parameter parameter query `?action=X` atau payload JSON. Berikut adalah spesifikasi endpoint utama:

### A. Endpoint `fetch_all` (GET)
Mengambil seluruh data operasional sistem dalam satu *round-trip* database.
* **Response Output (JSON)**:
  ```json
  {
    "units": [...],
    "sessions": [...],
    "saved_sessions": [],
    "history": [
      {
        "id": "uuid-transaction-id",
        "unit_name": "PS4 3",
        "mode": "ps",
        "tipe": "PS4",
        "customer": "Rian",
        "duration_minutes": 120,
        "total": 20000,
        "metode_bayar": "qris",
        "start_time": "2026-05-26T08:00:00",
        "end_time": "2026-05-26T10:00:00",
        "tipe_struk": "selesai",
        "saved_minutes": 0,
        "token_code": null
      }
    ]
  }
  ```
* **Logika Khusus Query History**:
  Untuk merekatkan data token ke transaksi simpan jam, sistem menjalankan query left join khusus:
  ```sql
  SELECT h.*, (CASE WHEN h.tipe_struk = 'simpan_jam' THEN MIN(st.token_code) ELSE NULL END) as token_code
  FROM history h
  LEFT JOIN saved_tokens st ON h.unit_name = st.unit_name AND h.customer = st.customer_name AND st.created_at >= h.start_time
  GROUP BY h.id ORDER BY h.created_at DESC
  ```

### B. Endpoint `insert_session` (POST JSON)
Mulai sesi sewa baru pada unit PlayStation.
* **Payload Input**:
  ```json
  {
    "unit_id": "uuid-unit-id",
    "unit_name": "PS4 3",
    "customer": "Nama Pelanggan",
    "mode": "ps",
    "start_time": "YYYY-MM-DD HH:MM:SS",
    "end_time": "YYYY-MM-DD HH:MM:SS",
    "duration_minutes": 120,
    "harga": 10000,
    "metode_bayar": "tunai"
  }
  ```

### C. Endpoint `stop_session` (POST JSON)
Menyelesaikan sesi aktif secara atomik menggunakan database transaction (Commit / Rollback):
* **Langkah Kerja Sisi Server**:
  1. Melakukan validasi payload masukan.
  2. Memulai transaksi: `$pdo->beginTransaction()`.
  3. Mengambil metode bayar asli sesi aktif (Tunai/QRIS/Token) untuk diwariskan ke tabel riwayat.
  4. Jika sesi dijalankan dengan token (metode bayar = `'token'`), nominal uang diubah menjadi `0` untuk menghindari pendapatan ganda.
  5. Menulis data transaksi ke tabel `history` dengan menyertakan `tipe_struk` dan `saved_minutes`.
  6. Menghapus sesi aktif dari tabel `sessions`.
  7. Menjalankan `$pdo->commit()`. Jika ada eksepsi, `$pdo->rollBack()` dipanggil.

### D. Endpoint `generate_token` (POST JSON)
Membuat token sisa waktu bermain.
* **Payload Input**:
  ```json
  {
    "unit_id": "uuid-unit-id",
    "remaining_minutes": 45
  }
  ```
* **Logika Pembuatan Kode**:
  Sistem membuat kode unik 8 karakter berformat `YK2-XXXX` (XXXX adalah huruf & angka acak). Fungsi `generateTokenCode()` akan memvalidasi keunikan kode di database maksimal 100 kali percobaan untuk menghindari duplikasi kode (*collision*).

### E. Endpoint `verify_token` (POST/GET) & `use_token` (POST JSON)
Memvalidasi sisa waktu token dan memicu penggunaannya ke unit PlayStation kosong.
* **Verifikasi**: Token harus ada di tabel `saved_tokens`, status `is_used` = `0`, dan `expired_at` lebih besar dari tanggal server saat ini.
* **Klaim Penggunaan**:
  Sistem memulai transaksi database, menambahkan sesi sewa baru di tabel `sessions` dengan durasi menit dari token serta `metode_bayar` = `'token'`, dan mengubah status token menjadi terpakai:
  ```sql
  UPDATE saved_tokens SET is_used = 1, used_at = NOW(), used_unit_id = ? WHERE token_code = ?
  ```

---

## 🖥️ 4. Logika & Algoritma Utama Frontend (`app.js` & `index.php`)

### A. Konsep SPA (Single Page Application)
Semua fungsi frontend memanfaatkan manipulasi DOM secara dinamis tanpa me-refresh seluruh halaman.
* **Manajemen State**: Data units, sessions, dan history disimpan dalam variabel global di JavaScript.
* **Navigasi Kontrol**: Fungsi `showPage(p)` menyembunyikan kontainer halaman lain dan menambahkan kelas `.active` pada kontainer halaman yang dipilih serta merender data terkait.

### B. Algoritma Hitung Mundur Waktu (Real-Time Countdown Engine)
Setiap satu detik, sistem memindai sesi yang aktif di layar dan mengalkulasi sisa waktu:
1. Format tanggal MySQL diubah menjadi format ISO aman (`YYYY-MM-DDTHH:MM:SS`) agar dapat dibaca dengan benar oleh browser Safari, Chrome, dan Firefox tanpa menghasilkan nilai `NaN`.
2. Selisih milidetik dikonversi ke total detik sisa bermain.
3. Jika sisa waktu <= 300 detik (5 menit), status kartu berubah menjadi `warning` (berkedip kuning).
4. Jika sisa waktu <= 0, timer menampilkan pesan **"WAKTU HABIS"** dan warna kartu berubah menjadi berkedip merah/ungu.

---

## 📄 5. Spesifikasi Teknis Struk PDF (`generate_pdf.php`)
Ekspor struk digital PDF dijalankan menggunakan library **DomPDF**.
* **Dimensi Kertas**: Menggunakan ukuran custom seukuran lebar thermal kertas printer POS: `[0, 0, 226, 400]` poin (lebar ~80mm).
* **Validasi Keamanan Struk**:
  1. Halaman generator ini diatur publik tanpa login admin (agar pelanggan dapat mengunduh struknya sendiri melalui QR code / link cek token).
  2. Generator memvalidasi status token di database: jika token sudah kedaluwarsa atau status `is_used` = `1`, halaman akan langsung diblokir dan mengembalikan HTTP Status Code `410 Gone` atau `404 Not Found`.
  3. Setelah struk berhasil dirender ke PDF, status token diubah menjadi `is_used` = `1` di tabel `saved_tokens` untuk menghindari klaim ganda.

---

## 📺 6. Layar Tampilan Pelanggan (`status.php`)
Customer Display dipasang menghadap pelanggan di area ruang tunggu.
* **Auto-Refresh Data**: Halaman melakukan pemanggilan API `fetch_all` secara periodik setiap **30 detik** di background untuk menyinkronkan status unit.
* **Countdown UI**: Melakukan perulangan hitung mundur lokal setiap 1 detik agar transisi waktu terasa mulus bagi pelanggan yang melihat layar.
* **Cek Token Mandiri**: Pelanggan dapat mengetik kode token mereka pada form input. Jika valid, nominal waktu, unit pembuat, dan batas kedaluwarsa akan ditampilkan, lengkap dengan tautan unduh struk PDF token digital.
