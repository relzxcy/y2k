# 🎓 Panduan Ujian Lisan: YK2 Gaming Admin Panel
> Dokumen ini dibuat khusus untuk persiapan ujian lisan. Pelajari setiap bagian dan pastikan kamu bisa menjelaskannya dengan kata-katamu sendiri.

---

## 📁 BAGIAN 1: PETA FILE (Struktur Project)

Jika dosen bertanya *"Jelaskan struktur file project kamu!"*, jawab seperti ini:

```
adminpoli/
│
├── 🔐 login.php                → Halaman login (pintu masuk)
├── 🔐 logout.php               → Proses keluar / hapus session
├── 🔐 session_check.php        → Satpam: cek apakah sudah login
│
├── 🖥️  index.php                → Dashboard utama kasir/admin
├── 📺  status.php               → Layar pelanggan (Customer Display)
│
├── ⚙️  api.php                  → Otak backend: semua logika data
├── 🖋️  app.js                   → Otak frontend: semua logika tampilan
│
├── 📄  generate_pdf.php         → Cetak struk token jadi file PDF
│
├── 🗃️  setup.sql                → Script dasar membuat database & tabel awal
├── 📂  database/
│   └── 🗃️ migration_v2.sql     → Migrasi tabel users & saved_tokens
├── 🗃️  migration_metode_bayar.sql → Migrasi penambahan kolom metode_bayar
│
├── 📦  composer.json            → Daftar library PHP yang dipakai (DomPDF)
├── 📦  vendor/                  → Folder library hasil install Composer
└── 📖  composer.phar            → Installer/tools Composer
```

---

## 🏗️ BAGIAN 2: ARSITEKTUR SISTEM (Cara Kerja Besar)

### Pertanyaan Dosen: *"Arsitektur apa yang kamu pakai?"*
**Jawaban:** Arsitektur **Three-Tier Client-Server** yang berjalan di localhost (XAMPP).

```
[BROWSER / CLIENT]          [SERVER XAMPP]         [DATABASE MySQL]
        │                          │                        │
   index.php ─── fetch() ──►  api.php  ──── SQL ────►  adminpoli DB
   app.js    ◄── JSON ────────  api.php  ◄─── Data ───  (tabel-tabel)
```

**Tier 1 - Presentation (Tampilan):**
- `index.php` + `app.js` = Dashboard Admin & Kasir
- `status.php` = Layar Pelanggan

**Tier 2 - Application (Logika):**
- `api.php` = Semua operasi data (tambah, ubah, stop sesi, token)

**Tier 3 - Data (Database):**
- MySQL database bernama `adminpoli`

---

## 🗄️ BAGIAN 3: DATABASE (Tabel-Tabel)

### Pertanyaan Dosen: *"Ada berapa tabel di database kamu?"*
**Jawaban:** Ada **6 tabel utama**.

| Tabel | Fungsi |
|---|---|
| `users` | Menyimpan akun login kasir (username, password, role) |
| `units` | Daftar unit PlayStation (PS3, PS4, dll) |
| `sessions` | Sesi yang **sedang berjalan** saat ini (dilengkapi kolom `metode_bayar`: tunai/qris) |
| `saved_sessions` | Sisa waktu yang **disimpan/ditangguhkan** pelanggan (untuk PC) |
| `saved_tokens` | Kode token sisa waktu bermain PS (`YK2-XXXX`) yang disimpan pelanggan |
| `history` | Semua transaksi yang **sudah selesai** (untuk laporan keuangan & pembukuan metode bayar) |

### Konsep Penting: Foreign Key & CASCADE
```sql
-- Di tabel sessions, kolom unit_id terhubung ke tabel units
-- Kalau unit dihapus, sesi yang berjalan otomatis ikut terhapus (CASCADE)
FOREIGN KEY (unit_id) REFERENCES units(id) ON DELETE CASCADE
```
**Jelaskan ke dosen:** *"Saya menggunakan Foreign Key dengan ON DELETE CASCADE agar tidak ada data sesi atau token yang menggantung (orphan data) ketika sebuah unit dihapus dari sistem."*

### Skema Tabel Baru: `saved_tokens` (Penyimpanan Sisa Waktu)
```sql
CREATE TABLE IF NOT EXISTS `saved_tokens` (
    `id`                VARCHAR(36)     NOT NULL PRIMARY KEY,
    `token_code`        VARCHAR(10)     NOT NULL UNIQUE, -- Format YK2-XXXX
    `unit_id`           VARCHAR(36)     NOT NULL,
    `unit_name`         VARCHAR(100)    NOT NULL,
    `customer_name`     VARCHAR(100)    NOT NULL,
    `remaining_minutes` INT             NOT NULL,
    `is_used`           TINYINT(1)      NOT NULL DEFAULT 0,
    `created_at`        DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `expired_at`        DATETIME        NOT NULL, -- Kedaluwarsa dalam 30 hari
    FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE
);
```

---

## 🔐 BAGIAN 4: SISTEM LOGIN & KEAMANAN

### File: `login.php`
```php
// Cek username & password dari form
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

// password_verify() membandingkan password asli dengan hash di database
if ($user && password_verify($password, $user['password_hash'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    header("Location: index.php"); // Redirect ke dashboard
}
```

### Pertanyaan Dosen: *"Bagaimana kamu mengamankan password?"*
**Jawaban:** *"Saya tidak menyimpan password dalam bentuk teks polos. Password di-hash menggunakan fungsi `password_hash()` PHP yang menggunakan algoritma **Bcrypt**. Saat login, fungsi `password_verify()` membandingkan password yang diketik dengan hash yang tersimpan di database. Ini adalah standar keamanan industri."*

### File: `session_check.php` (Satpam 7 Baris)
```php
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Paksa redirect ke login
    exit();
}
```
**Jelaskan:** *"File kecil ini saya sisipkan (`include`) di baris paling atas `index.php` dan `api.php`. Fungsinya adalah memblokir akses langsung ke halaman dashboard atau API jika pengguna belum login."*

---

## ⚙️ BAGIAN 5: API BACKEND (`api.php`)

### Pertanyaan Dosen: *"Bagaimana frontend berkomunikasi dengan database?"*
**Jawaban:** *"Melalui file `api.php` yang berfungsi sebagai REST API sederhana. Frontend (`app.js`) mengirim request HTTP POST/GET dengan parameter aksi tertentu, dan `api.php` merespons dengan data berformat JSON."*

### Koneksi Database (Singleton Pattern)
```php
function getDB() {
    static $pdo = null; // 'static' = hanya dibuat SEKALI selama runtime
    if ($pdo === null) {
        $pdo = new PDO("mysql:host=localhost;dbname=adminpoli", 'root', '');
    }
    return $pdo; // Selanjutnya langsung pakai koneksi yang sama
}
```
**Poin penting:** *"Saya menggunakan Static Instance (mirip pola Singleton) agar koneksi database hanya dibuka satu kali, tidak dibuka berulang kali setiap fungsi dipanggil. Ini menghemat memori server."*

### UUID (Bukan Auto-Increment Biasa)
```php
function genUUID() {
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), ...
    );
}
```
**Jelaskan ke dosen:** *"Saya menggunakan UUID v4 sebagai Primary Key, bukan angka auto-increment (1, 2, 3...). Keunggulannya adalah ID tidak bisa ditebak oleh pengguna luar. Kalau pakai angka biasa, orang bisa mencoba akses data dengan ID 1, 2, 3 secara berurutan (serangan data enumeration)."*

### Atomic Transaction (Fitur Paling Keren!)
```php
function stopSession() {
    $pdo = getDB();
    $pdo->beginTransaction(); // Mulai "zona aman" transaksi
    try {
        // Langkah 1: Catat ke riwayat (history)
        $pdo->prepare("INSERT INTO history (...) VALUES (...)")->execute([...]);
        
        // Langkah 2: Hapus dari sesi aktif
        $pdo->prepare("DELETE FROM sessions WHERE id = ?")->execute([$id]);
        
        $pdo->commit(); // Kedua langkah sukses → Simpan permanen
    } catch (Exception $e) {
        $pdo->rollBack(); // Salah satu gagal → Batalkan SEMUA perubahan
        sendError('Transaksi gagal');
    }
}
```
**Ini adalah poin nilai tertinggi!** Jelaskan: *"Saya menggunakan Database Transaction (prinsip ACID) untuk operasi Stop Sesi. Dalam satu transaksi ada 2 perintah: INSERT ke history DAN DELETE dari sessions. Jika salah satu gagal (misalnya database mati di tengah jalan), perintah `rollBack()` akan membatalkan semua perubahan sehingga data tidak pernah setengah-setengah atau korup."*

---

## 🖥️ BAGIAN 6: FRONTEND (`app.js` & `index.php`)

### Pertanyaan Dosen: *"Bagaimana metode pembayaran dipilih dan dicatat?"*
**Jawaban:** *"Saat memulai sesi di frontend (`index.php`), kasir dapat memilih metode pembayaran antara **Tunai (Cash)** atau **QRIS**. Pilihan ini disimpan di state `miPayMethod` dan dikirimkan ke backend melalui API. Pada saat stop sesi, backend akan membaca metode pembayaran sesi tersebut lalu mencatatkan nominal uang ke riwayat transaksi dengan metode pembayaran asli yang dipilih pelanggan."*

### Algoritma Timer Real-Time
```javascript
// Hitung berapa detik sisa waktu sewa
function remainingSecs(session) {
    const safeEnd = session.end_time.replace(' ', 'T');
    return Math.floor((new Date(safeEnd) - new Date()) / 1000);
}

// Jalankan setiap 1 detik (1000 milidetik)
setInterval(() => {
    sessions.forEach(session => {
        const sisaDetik = remainingSecs(session);
        if (sisaDetik <= 0) {
            handleOvertime(session); // Waktu habis → Alarm!
        } else {
            updateTimerUI(session.unit_id, sisaDetik); // Update tampilan timer
        }
    });
}, 1000);
```

### Status Visual Kartu Unit
```
✅ available  → Kartu Hijau  (unit kosong, siap disewa)
🔴 occupied   → Kartu Merah  (unit sedang dipakai, waktu aman)
⚠️ warning    → Kartu Kuning (sisa waktu < 5 menit, berkedip/pulse)
```

---

## 📄 BAGIAN 7: GENERATE PDF (`generate_pdf.php`)

### Pertanyaan Dosen: *"Bagaimana cara kamu mencetak struk PDF untuk token?"*
**Jawaban:** *"Saya menggunakan library PHP bernama **DomPDF** yang diinstall via **Composer**. Halaman `generate_pdf.php` dapat diakses secara publik menggunakan query parameter `token_code` (misal: `generate_pdf.php?token_code=YK2-ABCD`)."*

Sebelum PDF dibuat, sistem memvalidasi 3 hal:
1. ✅ Token ada di database? (`saved_tokens`)
2. ✅ Token belum pernah dipakai? (`is_used == 0`)
3. ✅ Token belum kedaluwarsa? (`expired_at > now()`)

Jika valid, DomPDF akan merender struk dalam format HTML (ukuran kertas struk thermal 80mm) menjadi file PDF yang otomatis diunduh oleh kasir untuk diberikan kepada pelanggan.

---

## 📺 BAGIAN 8: CUSTOMER DISPLAY (`status.php`)

### Pertanyaan Dosen: *"Apa itu Customer Display?"*
**Jawaban:** *"Ini adalah halaman khusus yang bisa ditampilkan di monitor/TV menghadap ke ruang tunggu pelanggan. Pelanggan bisa melihat sendiri unit mana yang kosong dan berapa sisa waktu bermain unit yang sedang aktif secara real-time karena halaman melakukan auto-refresh data secara berkala."*

---

## ❓ BAGIAN 9: PERTANYAAN JEBAKAN DOSEN & JAWABANNYA

### Q: *"Kenapa pakai PHP, bukan framework Laravel/CodeIgniter?"*
> **A:** "Untuk project skala ini, PHP Native sudah sangat cukup dan justru lebih ringan. Saya juga ingin menunjukkan pemahaman mendalam tentang dasar-dasar PHP (PDO, Session, Transaction) tanpa 'bantuan' framework. Ini menunjukkan bahwa saya benar-benar mengerti apa yang terjadi di balik layar."

### Q: *"Bagaimana Anda mengamankan token bermain agar tidak diklaim dua kali?"*
> **A:** "Saya menerapkan kolom `is_used` bertipe data boolean (TINYINT) pada tabel `saved_tokens`. Sebelum token digunakan untuk memulai sesi baru (`api.php?action=use_token`), server memvalidasi apakah `is_used` bernilai `0`. Jika `0`, sesi dimulai dan `is_used` langsung diubah menjadi `1` secara atomik di dalam database transaction, sehingga token tidak dapat disalahgunakan lagi."

### Q: *"Apa fungsi file `migration_metode_bayar.sql` dan `database/migration_v2.sql`?"*
> **A:** "File migrasi digunakan untuk memperbarui struktur database tanpa menghapus data yang sudah ada. `migration_v2.sql` menambahkan tabel login `users` dan tabel token `saved_tokens`. Sementara `migration_metode_bayar.sql` menambahkan kolom `metode_bayar` ke tabel `sessions` dan `history` agar sistem mendukung pembayaran non-tunai (QRIS) dan tunai."

### Q: *"Mengapa total pendapatan dicatat 0 di riwayat saat sesi diselesaikan menggunakan token?"*
> **A:** "Karena sistem kami menggunakan model prabayar (prepaid). Pelanggan sudah membayar lunas durasi sewa di awal saat sesi pertama dimulai. Ketika sisa waktu disimpan menjadi token, uang tersebut sudah tercatat masuk di riwayat awal. Oleh karena itu, saat sisa waktu token tersebut diklaim dan diselesaikan nanti, total pendapatan dicatat 0 agar tidak terjadi pembukuan ganda (double counting) pendapatan."

### Q: *"Bagaimana sinkronisasi waktu/tanggal dilakukan antara browser JavaScript dengan MySQL database?"*
> **A:** "JavaScript di frontend mengenerate tanggal lokal menggunakan `new Date()`. Format ISO JavaScript (`YYYY-MM-DDTHH:MM:SS.SSSZ`) dikonversi ke format yang kompatibel dengan database (`YYYY-MM-DD HH:MM:SS`) menggunakan fungsi helper `toLocalSQL()`. Data ini dikirim ke backend API. API menyimpan data tanggal tersebut persis ke tipe data `DATETIME` MySQL. Saat data ditarik kembali, backend menggunakan helper `toISO()` untuk memasang karakter `'T'` kembali agar browser memparsing data tersebut sebagai local time zona waktu PC kasir saat ini."

### Q: *"Bagaimana Anda menghindari collision (tabrakan kode) saat membuat kode token unik?"*
> **A:** "Di backend `api.php`, fungsi `generateTokenCode()` melakukan looping verifikasi ke database. Kode acak 8 karakter berformat `YK2-XXXX` dibuat terlebih dahulu. Sistem kemudian menjalankan query prepared statement `SELECT id FROM saved_tokens WHERE token_code = ?` untuk memastikan kode tersebut belum pernah ada. Sistem akan mencoba hingga 100 kali. Jika setelah 100 kali kode selalu bertabrakan (sangat jarang terjadi), sistem akan melempar eksepsi error demi keamanan."

### Q: *"Apa keunggulan arsitektur SPA berbasis Fetch API yang Anda terapkan dibandingkan MPA biasa?"*
> **A:** "Pada arsitektur MPA (Multi-Page Application), browser harus me-request dan me-load ulang seluruh dokumen HTML, CSS, dan JS dari server setiap kali kasir menekan tombol (misal: 'Mulai Sesi'). Hal ini lambat dan memakan banyak bandwidth. Dengan SPA (Single Page Application) berbasis Fetch API, halaman HTML hanya di-load sekali di awal. Seluruh transaksi data berikutnya dikirimkan di background dalam format JSON yang sangat kecil. Antarmuka DOM di-render ulang secara instan oleh JavaScript, memberikan pengalaman penggunaan sekelas aplikasi desktop yang responsif."

### Q: *"Bagaimana logic pembersihan berkala token lama (`cleanupExpiredTokens`) bekerja?"*
> **A:** "Untuk mencegah penumpukan data sampah di database yang dapat memperlambat query server, fungsi `cleanupExpiredTokens()` di backend menjalankan perintah DELETE terjadwal. Query akan menghapus token yang sudah berstatus digunakan (`is_used` = `1`) dan token kedaluwarsa (`is_used` = `0`) yang usianya telah melewati batas 90 hari sejak tanggal pembuatan/pemakaian. Ini menjaga integritas performa database."

---

## 💡 TIPS UJIAN LISAN

1. **Buka aplikasinya dulu** sebelum ujian dimulai, pastikan XAMPP menyala dan database `adminpoli` terhubung.
2. **Tunjukkan demo token.** Simpan sisa waktu sewa sebuah unit aktif menjadi token, tunjukkan file PDF struk token, lalu masukkan kode token tersebut pada menu verifikasi untuk memulai sesi baru di unit lain.
3. **Kata kunci akademik:** AJAX, Asynchronous, PDO, Prepared Statement, Database Transaction (ACID), UUID v4, Session, Bcrypt, JSON, DomPDF, Idempotency Token.
4. **Kalau tidak tahu jawaban** dari pertanyaan dosen, jangan panik. Bilang: *"Izin melihat kodenya sebentar pak/bu"* — itu jauh lebih baik dari mengarang.

---
*Dokumen ini dibuat untuk keperluan persiapan ujian lisan akademik.*
