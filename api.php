<?php
// ============================================================
// YK2 Gaming — PHP API Backend (Pengganti Supabase)
// File: api.php
// Database: adminpoli (MySQL via XAMPP)
// ============================================================

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// ── KONFIGURASI DATABASE ─────────────────────────────────────
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');          // Kosong = default XAMPP
define('DB_NAME', 'adminpoli');
define('DB_CHARSET', 'utf8mb4');

// ── KONEKSI DATABASE ─────────────────────────────────────────
function getDB() {
    static $pdo = null;
    if ($pdo === null) {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            sendError('Koneksi database gagal: ' . $e->getMessage(), 500);
        }
    }
    return $pdo;
}

// ── HELPERS ──────────────────────────────────────────────────
function sendJSON($data, $code = 200) {
    http_response_code($code);
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit();
}

function sendError($msg, $code = 400) {
    sendJSON(['error' => $msg], $code);
}

function sendOK($msg = 'OK', $extra = []) {
    sendJSON(array_merge(['success' => true, 'message' => $msg], $extra));
}

function genUUID() {
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}

function getBody() {
    $raw = file_get_contents('php://input');
    return json_decode($raw, true) ?? [];
}

// Format datetime untuk MySQL (Abaikan timezone, simpan persis seperti yang dikirim JS)
function toMySQL($iso) {
    if (!$iso) return null;
    return str_replace('T', ' ', substr($iso, 0, 19));
}

// Format datetime kembali ke ISO untuk JS (Tambahkan T agar diparsing sebagai local time oleh JS)
function toISO($mysql) {
    if (!$mysql) return null;
    return str_replace(' ', 'T', $mysql);
}

function formatRow($row, $dateFields = []) {
    foreach ($dateFields as $f) {
        if (isset($row[$f])) $row[$f] = toISO($row[$f]);
    }
    return $row;
}

// ── ROUTING ──────────────────────────────────────────────────
$action = $_GET['action'] ?? $_POST['action'] ?? '';
if (!$action) {
    $body = getBody();
    $action = $body['action'] ?? '';
}

switch ($action) {

    // ── FETCH ALL ──────────────────────────────────────────────
    case 'fetch_all':
        fetchAll();
        break;

    // ── UNITS ──────────────────────────────────────────────────
    case 'insert_unit':
        insertUnit();
        break;

    case 'update_unit':
        updateUnit();
        break;

    case 'delete_unit':
        deleteUnit();
        break;

    // ── SESSIONS ───────────────────────────────────────────────
    case 'insert_session':
        insertSession();
        break;

    case 'update_session':
        updateSession();
        break;

    case 'delete_session':
        deleteSession();
        break;

    // ── SAVED SESSIONS ─────────────────────────────────────────
    case 'upsert_saved':
        upsertSaved();
        break;

    case 'delete_saved':
        deleteSaved();
        break;

    // ── HISTORY ────────────────────────────────────────────────
    case 'insert_history':
        insertHistory();
        break;

    case 'delete_history':
        deleteHistory();
        break;

    case 'delete_all_history':
        deleteAllHistory();
        break;

    // ── STOP SESI (kombinasi: insert history + delete session + optional upsert saved) ──
    case 'stop_session':
        stopSession();
        break;

    // ── SIMPAN SESI PC (kombinasi: upsert saved + delete session) ──
    case 'simpan_sesi':
        simpanSesi();
        break;

    // ── RESUME SESI (kombinasi: insert session + delete saved) ──
    case 'resume_session':
        resumeSession();
        break;

    // ── DELETE UNIT + CASCADE ──────────────────────────────────
    case 'delete_unit_cascade':
        deleteUnitCascade();
        break;

    // ── TOKENS ─────────────────────────────────────────────────
    case 'generate_token':
        generateToken();
        break;

    case 'get_token_detail':
        getTokenDetail();
        break;

    case 'verify_token':
        verifyToken();
        break;

    case 'use_token':
        useToken();
        break;

    case 'cleanup_tokens':
        $count = cleanupExpiredTokens();
        sendOK('Token kedaluwarsa berhasil dibersihkan', ['count' => $count]);
        break;

    default:
        sendError('Action tidak dikenal: ' . htmlspecialchars($action));
}

// ═══════════════════════════════════════════════════════════════
// IMPLEMENTASI FUNGSI
// ═══════════════════════════════════════════════════════════════

function fetchAll() {
    $pdo = getDB();
    $unitDates    = ['created_at'];
    $sessDates    = ['start_time', 'end_time', 'created_at'];
    $savedDates   = ['saved_at'];
    $histDates    = ['start_time', 'end_time', 'created_at'];

    $units   = array_map(fn($r) => formatRow($r, $unitDates),
                   $pdo->query("SELECT * FROM units ORDER BY nomor, tipe")->fetchAll());
    $sess    = array_map(fn($r) => formatRow($r, $sessDates),
                   $pdo->query("SELECT * FROM sessions ORDER BY start_time")->fetchAll());
    $saved   = array_map(fn($r) => formatRow($r, $savedDates),
                   $pdo->query("SELECT * FROM saved_sessions ORDER BY saved_at")->fetchAll());
    $history = array_map(fn($r) => formatRow($r, $histDates),
                   $pdo->query("
                       SELECT h.*, 
                              (CASE WHEN h.tipe_struk = 'simpan_jam' THEN MIN(st.token_code) ELSE NULL END) as token_code
                       FROM history h
                       LEFT JOIN saved_tokens st ON 
                           h.unit_name = st.unit_name 
                           AND h.customer = st.customer_name
                           AND st.created_at >= h.start_time
                       GROUP BY h.id
                       ORDER BY h.created_at DESC
                   ")->fetchAll());

    sendJSON([
        'units'          => $units,
        'sessions'       => $sess,
        'saved_sessions' => $saved,
        'history'        => $history,
    ]);
}

// ── UNITS ────────────────────────────────────────────────────
function insertUnit() {
    $b = getBody();
    $required = ['nomor', 'tipe', 'mode', 'harga'];
    foreach ($required as $f) {
        if (!isset($b[$f])) sendError("Field '$f' wajib diisi");
    }
    $pdo = getDB();
    $id  = genUUID();
    $stmt = $pdo->prepare("INSERT INTO units (id, nomor, tipe, mode, harga) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$id, $b['nomor'], $b['tipe'], $b['mode'], $b['harga']]);
    sendOK('Unit berhasil ditambahkan', ['id' => $id]);
}

function updateUnit() {
    $b = getBody();
    if (empty($b['id'])) sendError('ID unit wajib diisi');
    $pdo = getDB();
    $stmt = $pdo->prepare("UPDATE units SET nomor=?, tipe=?, mode=?, harga=? WHERE id=?");
    $stmt->execute([$b['nomor'], $b['tipe'], $b['mode'], $b['harga'], $b['id']]);
    sendOK('Unit berhasil diperbarui');
}

function deleteUnit() {
    $b = getBody();
    if (empty($b['id'])) sendError('ID unit wajib diisi');
    $pdo = getDB();
    try {
        $stmt = $pdo->prepare("DELETE FROM sessions WHERE unit_id=?");
        $stmt->execute([$b['id']]);
        
        $stmt = $pdo->prepare("DELETE FROM saved_sessions WHERE unit_id=?");
        $stmt->execute([$b['id']]);
        
        $stmt = $pdo->prepare("DELETE FROM units WHERE id=?");
        $stmt->execute([$b['id']]);
        sendOK('Unit dihapus');
    } catch (Exception $e) {
        sendError("Gagal menghapus unit: " . $e->getMessage());
    }
}

function deleteUnitCascade() {
    $b = getBody();
    if (empty($b['id'])) sendError('ID unit wajib diisi');
    $pdo = getDB();
    try {
        $stmt = $pdo->prepare("DELETE FROM sessions WHERE unit_id=?");
        $stmt->execute([$b['id']]);
        
        $stmt = $pdo->prepare("DELETE FROM saved_sessions WHERE unit_id=?");
        $stmt->execute([$b['id']]);
        
        $stmt = $pdo->prepare("DELETE FROM units WHERE id=?");
        $stmt->execute([$b['id']]);
        sendOK('Unit dan semua sesi terkait dihapus');
    } catch (Exception $e) {
        sendError("Gagal menghapus unit: " . $e->getMessage());
    }
}

// ── SESSIONS ─────────────────────────────────────────────────
function insertSession() {
    $b = getBody();
    $required = ['unit_id', 'unit_name', 'customer', 'mode', 'start_time', 'end_time', 'duration_minutes', 'harga'];
    foreach ($required as $f) {
        if (!isset($b[$f])) sendError("Field '$f' wajib diisi");
    }
    $pdo  = getDB();
    $id   = genUUID();
    $metode_bayar = $b['metode_bayar'] ?? 'tunai';
    $stmt = $pdo->prepare(
        "INSERT INTO sessions (id, unit_id, unit_name, customer, mode, start_time, end_time, duration_minutes, metode_bayar, harga)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );
    $stmt->execute([
        $id, $b['unit_id'], $b['unit_name'], $b['customer'], $b['mode'],
        toMySQL($b['start_time']), toMySQL($b['end_time']),
        $b['duration_minutes'], $metode_bayar, $b['harga']
    ]);
    sendOK('Sesi berhasil dimulai', ['id' => $id]);
}

function updateSession() {
    $b = getBody();
    if (empty($b['id'])) sendError('ID sesi wajib diisi');
    $pdo  = getDB();
    $stmt = $pdo->prepare("UPDATE sessions SET end_time=?, duration_minutes=? WHERE id=?");
    $stmt->execute([toMySQL($b['end_time']), $b['duration_minutes'], $b['id']]);
    sendOK('Sesi diperbarui');
}

function deleteSession() {
    $b = getBody();
    if (empty($b['id'])) sendError('ID sesi wajib diisi');
    $pdo  = getDB();
    $stmt = $pdo->prepare("DELETE FROM sessions WHERE id=?");
    $stmt->execute([$b['id']]);
    sendOK('Sesi dihapus');
}

// ── SAVED SESSIONS ───────────────────────────────────────────
function upsertSaved() {
    $b = getBody();
    $required = ['unit_id', 'unit_name', 'customer', 'remaining_minutes'];
    foreach ($required as $f) {
        if (!isset($b[$f])) sendError("Field '$f' wajib diisi");
    }
    $pdo    = getDB();
    // Cek apakah sudah ada saved untuk unit ini
    $check  = $pdo->prepare("SELECT id FROM saved_sessions WHERE unit_id=?");
    $check->execute([$b['unit_id']]);
    $exists = $check->fetch();

    if ($exists) {
        $stmt = $pdo->prepare(
            "UPDATE saved_sessions SET unit_name=?, customer=?, remaining_minutes=?, saved_at=NOW() WHERE unit_id=?"
        );
        $stmt->execute([$b['unit_name'], $b['customer'], $b['remaining_minutes'], $b['unit_id']]);
        sendOK('Sesi tersimpan diperbarui', ['id' => $exists['id']]);
    } else {
        $id   = genUUID();
        $stmt = $pdo->prepare(
            "INSERT INTO saved_sessions (id, unit_id, unit_name, customer, remaining_minutes) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([$id, $b['unit_id'], $b['unit_name'], $b['customer'], $b['remaining_minutes']]);
        sendOK('Sesi tersimpan dibuat', ['id' => $id]);
    }
}

function deleteSaved() {
    $b = getBody();
    if (empty($b['id'])) sendError('ID saved session wajib diisi');
    $pdo  = getDB();
    $stmt = $pdo->prepare("DELETE FROM saved_sessions WHERE id=?");
    $stmt->execute([$b['id']]);
    sendOK('Simpanan dihapus');
}

// ── HISTORY ──────────────────────────────────────────────────
function insertHistory() {
    $b = getBody();
    $required = ['unit_name', 'mode', 'customer', 'duration_minutes', 'total', 'start_time', 'end_time'];
    foreach ($required as $f) {
        if (!isset($b[$f])) sendError("Field '$f' wajib diisi");
    }
    $pdo  = getDB();
    $id   = genUUID();
    $stmt = $pdo->prepare(
        "INSERT INTO history (id, unit_name, mode, tipe, customer, duration_minutes, total, start_time, end_time, tipe_struk)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );
    $stmt->execute([
        $id, $b['unit_name'], $b['mode'], $b['tipe'] ?? null, $b['customer'],
        $b['duration_minutes'], $b['total'],
        toMySQL($b['start_time']), toMySQL($b['end_time']),
        $b['tipe_struk'] ?? 'awal'
    ]);
    sendOK('History berhasil ditambahkan', ['id' => $id]);
}

function deleteHistory() {
    $b = getBody();
    if (empty($b['id'])) sendError('ID history wajib diisi');
    $pdo  = getDB();
    $stmt = $pdo->prepare("DELETE FROM history WHERE id=?");
    $stmt->execute([$b['id']]);
    sendOK('Riwayat dihapus');
}

function deleteAllHistory() {
    $b    = getBody();
    $mode = $b['mode'] ?? 'all';
    $pdo  = getDB();
    if ($mode === 'all') {
        $pdo->exec("DELETE FROM history");
    } else {
        $stmt = $pdo->prepare("DELETE FROM history WHERE mode=?");
        $stmt->execute([$mode]);
    }
    sendOK('Semua riwayat dihapus');
}

// ── STOP SESI (atomic: insert history + delete session + optional upsert saved) ──
function stopSession() {
    $b = getBody();
    $required = ['session_id', 'unit_name', 'mode', 'tipe', 'customer', 'duration_minutes', 'total', 'start_time', 'end_time'];
    foreach ($required as $f) {
        if (!isset($b[$f])) sendError("Field '$f' wajib diisi");
    }
    $pdo = getDB();
    try {
        $pdo->beginTransaction();

        // 1. Insert ke history
        $hid  = genUUID();
        
        // Ambil data sesi untuk mendapatkan metode_bayar (backward-compatible)
        $stmtSess = $pdo->prepare("SELECT * FROM sessions WHERE id = ?");
        $stmtSess->execute([$b['session_id']]);
        $sessData = $stmtSess->fetch();
        $metode_bayar = ($sessData && isset($sessData['metode_bayar'])) ? $sessData['metode_bayar'] : 'tunai';

        $tipe_struk = $b['tipe_struk'] ?? 'selesai';
        $saved_minutes = ($tipe_struk === 'simpan_jam') ? ($b['remaining_minutes'] ?? 0) : 0;
        // Token sessions are already paid — record total = 0 in history
        $recorded_total = ($metode_bayar === 'token') ? 0 : $b['total'];
        $stmt = $pdo->prepare(
            "INSERT INTO history (id, unit_name, mode, tipe, customer, duration_minutes, total, metode_bayar, start_time, end_time, tipe_struk, saved_minutes)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $hid, $b['unit_name'], $b['mode'], $b['tipe'], $b['customer'],
            $b['duration_minutes'], $recorded_total, $metode_bayar,
            toMySQL($b['start_time']), toMySQL($b['end_time']), $tipe_struk, $saved_minutes
        ]);

        // 2. Hapus sesi aktif
        $stmt = $pdo->prepare("DELETE FROM sessions WHERE id=?");
        $stmt->execute([$b['session_id']]);

        // 3. Opsional: simpan sesi PC
        $savedId = null;
        if (!empty($b['simpan']) && $b['simpan'] === true && !empty($b['unit_id']) && !empty($b['remaining_minutes'])) {
            // Hapus saved lama jika ada
            $stmt = $pdo->prepare("DELETE FROM saved_sessions WHERE unit_id=?");
            $stmt->execute([$b['unit_id']]);

            $savedId = genUUID();
            $stmt = $pdo->prepare(
                "INSERT INTO saved_sessions (id, unit_id, unit_name, customer, remaining_minutes) VALUES (?, ?, ?, ?, ?)"
            );
            $stmt->execute([$savedId, $b['unit_id'], $b['unit_name'], $b['customer'], $b['remaining_minutes']]);
        }

        $pdo->commit();
        sendOK('Sesi selesai', ['history_id' => $hid, 'saved_id' => $savedId]);
    } catch (Exception $e) {
        $pdo->rollBack();
        sendError('Gagal menyelesaikan sesi: ' . $e->getMessage(), 500);
    }
}

// ── SIMPAN SESI PC (atomic: upsert saved + delete session) ───
function simpanSesi() {
    $b = getBody();
    $required = ['session_id', 'unit_id', 'unit_name', 'customer', 'remaining_minutes'];
    foreach ($required as $f) {
        if (!isset($b[$f])) sendError("Field '$f' wajib diisi");
    }
    $pdo = getDB();
    try {
        $pdo->beginTransaction();

        // Hapus saved lama
        $stmt = $pdo->prepare("DELETE FROM saved_sessions WHERE unit_id=?");
        $stmt->execute([$b['unit_id']]);

        // Insert saved baru
        $savedId = genUUID();
        $stmt = $pdo->prepare(
            "INSERT INTO saved_sessions (id, unit_id, unit_name, customer, remaining_minutes) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([$savedId, $b['unit_id'], $b['unit_name'], $b['customer'], $b['remaining_minutes']]);

        // Hapus sesi aktif
        $stmt = $pdo->prepare("DELETE FROM sessions WHERE id=?");
        $stmt->execute([$b['session_id']]);

        $pdo->commit();
        sendOK('Sesi berhasil disimpan', ['saved_id' => $savedId]);
    } catch (Exception $e) {
        $pdo->rollBack();
        sendError('Gagal menyimpan sesi: ' . $e->getMessage(), 500);
    }
}

// ── RESUME SESI (atomic: insert session + delete saved) ──────
function resumeSession() {
    $b = getBody();
    $required = ['saved_id', 'unit_id', 'unit_name', 'customer', 'mode', 'start_time', 'end_time', 'duration_minutes', 'harga'];
    foreach ($required as $f) {
        if (!isset($b[$f])) sendError("Field '$f' wajib diisi");
    }
    $pdo = getDB();
    try {
        $pdo->beginTransaction();

        // Insert sesi baru
        $sessId = genUUID();
        $stmt = $pdo->prepare(
            "INSERT INTO sessions (id, unit_id, unit_name, customer, mode, start_time, end_time, duration_minutes, harga)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $sessId, $b['unit_id'], $b['unit_name'], $b['customer'], $b['mode'],
            toMySQL($b['start_time']), toMySQL($b['end_time']),
            $b['duration_minutes'], $b['harga']
        ]);

        // Hapus saved
        $stmt = $pdo->prepare("DELETE FROM saved_sessions WHERE id=?");
        $stmt->execute([$b['saved_id']]);

        $pdo->commit();
        sendOK('Sesi dilanjutkan', ['session_id' => $sessId]);
    } catch (Exception $e) {
        $pdo->rollBack();
        sendError('Gagal melanjutkan sesi: ' . $e->getMessage(), 500);
    }
}

// ── TOKENS ───────────────────────────────────────────────────
function generateTokenCode($pdo) {
    $attempts = 0;
    while ($attempts < 100) {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $randStr = '';
        for ($i = 0; $i < 4; $i++) {
            $randStr .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        $code = 'YK2-' . $randStr;

        $stmt = $pdo->prepare("SELECT id FROM saved_tokens WHERE token_code = ?");
        $stmt->execute([$code]);
        if (!$stmt->fetch()) {
            return $code;
        }
        $attempts++;
    }
    throw new Exception("Gagal membuat kode token unik. Hubungi admin.");
}

function generateToken() {
    $b = getBody();
    if (empty($b['unit_id'])) sendError("Field 'unit_id' wajib diisi");
    
    $pdo = getDB();
    
    // Ambil data unit aktif (session)
    $stmt = $pdo->prepare("SELECT unit_name, customer, end_time FROM sessions WHERE unit_id = ?");
    $stmt->execute([$b['unit_id']]);
    $sess = $stmt->fetch();
    
    if (!$sess) {
        sendError("Tidak ada sesi aktif di unit tersebut");
    }
    
    $remaining = $b['remaining_minutes'] ?? 0;
    if (!$remaining) {
        $endTime = strtotime($sess['end_time']);
        $remaining = max(0, ceil(($endTime - time()) / 60));
    }
    
    if ($remaining < 15) {
        sendError("Minimal sisa waktu untuk membuat token adalah 15 menit");
    }
    
    $code = generateTokenCode($pdo);
    $id = genUUID();
    
    $stmt = $pdo->prepare(
        "INSERT INTO saved_tokens (id, token_code, unit_id, unit_name, customer_name, remaining_minutes, is_used, created_at, expired_at) 
         VALUES (?, ?, ?, ?, ?, ?, 0, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY))"
    );
    $stmt->execute([$id, $code, $b['unit_id'], $sess['unit_name'], $sess['customer'], $remaining]);
    
    sendOK('Token berhasil dibuat', ['token_code' => $code]);
}

function getTokenDetail() {
    $b = getBody();
    $code = $_GET['token_code'] ?? $_POST['token_code'] ?? $b['token_code'] ?? '';
    if (!$code) sendError("Token code wajib diisi");

    $pdo = getDB();
    $stmt = $pdo->prepare("SELECT * FROM saved_tokens WHERE token_code = ?");
    $stmt->execute([$code]);
    $token = $stmt->fetch();

    if (!$token) {
        sendError("Token tidak ditemukan");
    }
    if ($token['is_used'] == 1) {
        sendError("Token sudah digunakan");
    }
    if (strtotime($token['expired_at']) < time()) {
        sendError("Token sudah kedaluwarsa");
    }

    sendOK('Token valid', [
        'token_code' => $token['token_code'],
        'unit_name' => $token['unit_name'],
        'customer_name' => $token['customer_name'],
        'remaining_minutes' => $token['remaining_minutes'],
        'expired_at' => toISO($token['expired_at'])
    ]);
}

function useToken() {
    $b       = getBody();
    $code    = strtoupper(trim($b['token_code'] ?? ''));
    $unit_id = trim($b['unit_id'] ?? '');
    if (!$code)    sendError("token_code wajib diisi");
    if (!$unit_id) sendError("unit_id wajib diisi");

    $pdo = getDB();

    // 1. Validasi token
    $stmt = $pdo->prepare("SELECT * FROM saved_tokens WHERE token_code = ?");
    $stmt->execute([$code]);
    $token = $stmt->fetch();
    if (!$token)              sendError("Token tidak ditemukan");
    if ($token['is_used'])    sendError("Token sudah digunakan");
    if (strtotime($token['expired_at']) < time()) sendError("Token sudah kedaluwarsa");

    // 2. Validasi unit ada & tidak sedang dipakai
    $stmtU = $pdo->prepare("SELECT * FROM units WHERE id = ?");
    $stmtU->execute([$unit_id]);
    $unit = $stmtU->fetch();
    if (!$unit) sendError("Unit tidak ditemukan");

    $stmtSess = $pdo->prepare("SELECT id FROM sessions WHERE unit_id = ?");
    $stmtSess->execute([$unit_id]);
    if ($stmtSess->fetch()) sendError("Unit sedang digunakan. Pilih unit lain.");

    try {
        $pdo->beginTransaction();

        // 3. Buat sesi baru dengan durasi dari remaining_minutes token
        // Gunakan start_time & end_time dari JS (waktu lokal) agar konsisten dengan sesi lain
        $sessId    = genUUID();
        $startTime = toMySQL($b['start_time'] ?? null) ?: date('Y-m-d H:i:s');
        $endTime   = toMySQL($b['end_time']   ?? null) ?: date('Y-m-d H:i:s', time() + (int)$token['remaining_minutes'] * 60);

        $stmtIns = $pdo->prepare(
            "INSERT INTO sessions (id, unit_id, unit_name, customer, mode, start_time, end_time, duration_minutes, metode_bayar, harga)
             VALUES (?, ?, ?, ?, 'ps', ?, ?, ?, 'token', ?)"
        );
        $stmtIns->execute([
            $sessId,
            $unit_id,
            $unit['tipe'] . ' ' . $unit['nomor'],
            $token['customer_name'],
            $startTime,
            $endTime,
            (int)$token['remaining_minutes'],
            (int)$unit['harga']
        ]);

        // 4. Tandai token sudah digunakan
        $stmtUpd = $pdo->prepare("UPDATE saved_tokens SET is_used = 1, used_at = NOW(), used_unit_id = ? WHERE token_code = ?");
        $stmtUpd->execute([$unit_id, $code]);

        $pdo->commit();
        sendOK('Sesi berhasil dimulai dari token', ['session_id' => $sessId]);

    } catch (Exception $e) {
        $pdo->rollBack();
        sendError('Gagal menggunakan token: ' . $e->getMessage(), 500);
    }
}
function verifyToken() {
    $b = getBody();
    $code = $_GET['token_code'] ?? $_POST['token_code'] ?? $b['token_code'] ?? '';
    if (!$code) sendError("Token code wajib diisi");

    $pdo = getDB();
    $stmt = $pdo->prepare("SELECT * FROM saved_tokens WHERE token_code = ?");
    $stmt->execute([$code]);
    $token = $stmt->fetch();

    if (!$token) {
        sendError("Token tidak ditemukan");
    }
    if ($token['is_used'] == 1) {
        sendError("Token sudah digunakan");
    }
    if (strtotime($token['expired_at']) < time()) {
        sendError("Token sudah kedaluwarsa");
    }

    sendOK('Token valid', [
        'token_code' => $token['token_code'],
        'unit_name' => $token['unit_name'],
        'customer_name' => $token['customer_name'],
        'remaining_minutes' => $token['remaining_minutes'],
        'expired_at' => toISO($token['expired_at'])
    ]);
}

function cleanupExpiredTokens() {
    $pdo = getDB();
    $stmt = $pdo->prepare("
        DELETE FROM saved_tokens 
        WHERE (is_used = 1 AND used_at < DATE_SUB(NOW(), INTERVAL 90 DAY))
           OR (is_used = 0 AND expired_at < DATE_SUB(NOW(), INTERVAL 90 DAY))
    ");
    $stmt->execute();
    return $stmt->rowCount();
}
