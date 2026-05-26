<?php
// ============================================================
// YK2 Gaming — Generate Struk PDF Token
// File: generate_pdf.php
// Akses: Publik (tidak butuh login)
// ============================================================

require_once __DIR__ . '/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// ── KONEKSI DB ───────────────────────────────────────────────
$token_code = strtoupper(trim($_GET['token_code'] ?? ''));

if (!$token_code) {
    http_response_code(400);
    die("Error: token_code tidak diberikan.");
}

try {
    $pdo = new PDO("mysql:host=localhost;dbname=adminpoli;charset=utf8mb4", 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    die("Koneksi database gagal.");
}

// ── VALIDASI TOKEN ───────────────────────────────────────────
$stmt = $pdo->prepare("SELECT * FROM saved_tokens WHERE token_code = ?");
$stmt->execute([$token_code]);
$token = $stmt->fetch();

if (!$token) {
    http_response_code(404);
    die("Error: Token tidak ditemukan.");
}
if ($token['is_used'] == 1) {
    http_response_code(410);
    die("Error: Token ini sudah pernah digunakan dan tidak dapat didownload ulang.");
}
if (strtotime($token['expired_at']) < time()) {
    http_response_code(410);
    die("Error: Token sudah kedaluwarsa.");
}

// ── FORMAT DATA ──────────────────────────────────────────────
$remaining  = (int) $token['remaining_minutes'];
$jam        = floor($remaining / 60);
$menit      = $remaining % 60;
$sisaWaktu  = ($jam > 0 ? "{$jam} Jam " : "") . "{$menit} Menit";

$expDate    = new DateTime($token['expired_at']);
setlocale(LC_TIME, 'id_ID', 'id');
$bulanId    = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
               'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
$berlakuHingga = $expDate->format('d') . ' ' . $bulanId[(int)$expDate->format('n')] . ' ' . $expDate->format('Y');

$genDate  = date('d') . ' ' . $bulanId[(int)date('n')] . ' ' . date('Y') . ', ' . date('H:i');
$custName = htmlspecialchars($token['customer_name']);
$unitName = htmlspecialchars($token['unit_name']);
$code     = htmlspecialchars($token['token_code']);

// ── AMBIL METODE BAYAR DARI TABEL HISTORY ────────────────────
// Cari record history terbaru milik unit yang sama dengan token ini
$stmtH = $pdo->prepare(
    "SELECT metode_bayar FROM history WHERE unit_name = ? ORDER BY created_at DESC LIMIT 1"
);
$stmtH->execute([$token['unit_name']]);
$histRow = $stmtH->fetch();
$metodeRaw = ($histRow && !empty($histRow['metode_bayar'])) ? $histRow['metode_bayar'] : 'tunai';
$metodeBayarText = (strtolower($metodeRaw) === 'qris') ? 'QRIS - DANA' : 'Tunai / Cash';

// ── HTML STRUK ───────────────────────────────────────────────
$html = <<<HTML
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
  @page { margin: 0; }
  body {
    font-family: DejaVu Sans, Arial, sans-serif;
    font-size: 13px;
    color: #1a1a2e;
    margin: 0;
    padding: 0;
    background: #ffffff;
  }
  .struk {
    width: 280px;
    margin: 20px auto;
    padding: 24px 20px;
    border: 2px solid #1a1a2e;
    border-radius: 12px;
  }
  .header {
    text-align: center;
    margin-bottom: 4px;
  }
  .logo {
    font-size: 30px;
    font-weight: bold;
    letter-spacing: 4px;
    color: #1a1a2e;
  }
  .logo span {
    color: #e63950;
  }
  .subtitle {
    font-size: 9px;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: #555;
    margin-top: 2px;
  }
  .divider {
    border: none;
    border-top: 1px dashed #aaa;
    margin: 12px 0;
  }
  .divider-solid {
    border: none;
    border-top: 2px solid #1a1a2e;
    margin: 12px 0;
  }
  .row {
    display: block;
    margin-bottom: 7px;
  }
  .row-label {
    font-size: 8px;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #777;
    display: block;
  }
  .row-value {
    font-size: 13px;
    font-weight: bold;
    color: #1a1a2e;
    display: block;
  }
  .token-block {
    text-align: center;
    margin: 16px 0;
    padding: 14px;
    background: #1a1a2e;
    border-radius: 8px;
  }
  .token-label {
    font-size: 9px;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: #aaa;
    display: block;
    margin-bottom: 6px;
  }
  .token-code {
    font-size: 30px;
    font-weight: bold;
    color: #e63950;
    letter-spacing: 5px;
    display: block;
  }
  .expired-block {
    text-align: center;
    margin-bottom: 10px;
    padding: 8px;
    background: #fff3cd;
    border: 1px solid #ffc107;
    border-radius: 6px;
  }
  .expired-label {
    font-size: 8px;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #856404;
    display: block;
  }
  .expired-value {
    font-size: 11px;
    font-weight: bold;
    color: #856404;
    display: block;
  }
  .footer {
    text-align: center;
    font-size: 9px;
    color: #888;
    line-height: 1.5;
    margin-top: 10px;
  }
  .gen-date {
    text-align: center;
    font-size: 8px;
    color: #bbb;
    margin-top: 8px;
  }
</style>
</head>
<body>
  <div class="struk">

    <div class="header">
      <div class="logo">YK2 <span>Gaming</span></div>
      <div class="subtitle">Struk Simpan Jam Digital</div>
    </div>

    <hr class="divider-solid">

    <div class="row">
      <span class="row-label">Nama Pelanggan</span>
      <span class="row-value">{$custName}</span>
    </div>
    <div class="row">
      <span class="row-label">Unit Terakhir</span>
      <span class="row-value">{$unitName}</span>
    </div>
    <div class="row">
      <span class="row-label">Sisa Waktu Main</span>
      <span class="row-value">{$sisaWaktu}</span>
    </div>
    <div class="row">
      <span class="row-label">Metode Bayar</span>
      <span class="row-value">{$metodeBayarText}</span>
    </div>

    <hr class="divider">

    <div class="token-block">
      <span class="token-label">Kode Verifikasi</span>
      <span class="token-code">{$code}</span>
    </div>

    <div class="expired-block">
      <span class="expired-label">Berlaku sampai dengan</span>
      <span class="expired-value">{$berlakuHingga}</span>
    </div>

    <hr class="divider">

    <div class="footer">
      Tunjukkan kode verifikasi ke kasir.<br>
      Data asli tersimpan di sistem.
    </div>

    <div class="gen-date">Dicetak: {$genDate}</div>

  </div>
</body>
</html>
HTML;

// ── GENERATE PDF ─────────────────────────────────────────────
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', false);
$options->set('defaultFont', 'DejaVu Sans');

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html, 'UTF-8');
$dompdf->setPaper([0, 0, 226, 400], 'portrait'); // ~80mm width thermal-style
$dompdf->render();

// ── MARK TOKEN AS USED ───────────────────────────────────────
$upd = $pdo->prepare("UPDATE saved_tokens SET is_used = 1 WHERE token_code = ?");
$upd->execute([$token_code]);

// ── KIRIM PDF ────────────────────────────────────────────────
$filename = 'struk-' . strtolower(str_replace('/', '-', $token_code)) . '.pdf';
$dompdf->stream($filename, ['Attachment' => true]);
