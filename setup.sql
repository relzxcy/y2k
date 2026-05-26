-- ============================================================
-- YK2 Gaming — Setup Database MySQL (XAMPP)
-- Database: adminpoli
-- Jalankan script ini di phpMyAdmin → SQL Editor
-- ============================================================

CREATE DATABASE IF NOT EXISTS adminpoli CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE adminpoli;

-- ── TABEL UNITS ──────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS units (
  id VARCHAR(36) NOT NULL PRIMARY KEY,
  nomor INT NOT NULL,
  tipe VARCHAR(50) NOT NULL,
  mode ENUM('ps','pc') NOT NULL,
  harga INT NOT NULL DEFAULT 10000,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── TABEL SESSIONS ───────────────────────────────────────────
CREATE TABLE IF NOT EXISTS sessions (
  id VARCHAR(36) NOT NULL PRIMARY KEY,
  unit_id VARCHAR(36) NOT NULL,
  unit_name VARCHAR(100) NOT NULL,
  customer VARCHAR(100) NOT NULL DEFAULT 'Umum',
  mode ENUM('ps','pc') NOT NULL,
  start_time DATETIME NOT NULL,
  end_time DATETIME NOT NULL,
  duration_minutes INT NOT NULL,
  metode_bayar ENUM('tunai','qris') NOT NULL DEFAULT 'tunai',
  harga INT NOT NULL DEFAULT 10000,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (unit_id) REFERENCES units(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── TABEL SAVED_SESSIONS ─────────────────────────────────────
CREATE TABLE IF NOT EXISTS saved_sessions (
  id VARCHAR(36) NOT NULL PRIMARY KEY,
  unit_id VARCHAR(36),
  unit_name VARCHAR(100) NOT NULL,
  customer VARCHAR(100) NOT NULL DEFAULT 'Umum',
  remaining_minutes INT NOT NULL,
  saved_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── TABEL HISTORY ────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS history (
  id VARCHAR(36) NOT NULL PRIMARY KEY,
  unit_name VARCHAR(100) NOT NULL,
  mode ENUM('ps','pc') NOT NULL,
  tipe VARCHAR(50),
  customer VARCHAR(100) NOT NULL DEFAULT 'Umum',
  duration_minutes INT NOT NULL,
  total INT NOT NULL,
  metode_bayar ENUM('tunai','qris') NOT NULL DEFAULT 'tunai',
  start_time DATETIME NOT NULL,
  end_time DATETIME NOT NULL,
  tipe_struk VARCHAR(20) DEFAULT 'awal',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── DATA AWAL UNITS ──────────────────────────────────────────
INSERT IGNORE INTO units (id, nomor, tipe, mode, harga) VALUES
  (UUID(), 1, 'PS3', 'ps', 8000),
  (UUID(), 2, 'PS3', 'ps', 8000),
  (UUID(), 3, 'PS4', 'ps', 10000),
  (UUID(), 4, 'PS4', 'ps', 10000),
  (UUID(), 1, 'Regular', 'pc', 6000),
  (UUID(), 2, 'Regular', 'pc', 6000),
  (UUID(), 3, 'VIP', 'pc', 10000),
  (UUID(), 4, 'VIP', 'pc', 10000);

SELECT 'Setup selesai! Database adminpoli siap digunakan.' AS status;
