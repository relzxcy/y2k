-- ============================================================
-- YK2 Gaming — Migration Tambah Metode Bayar
-- Dibuat: 2026-05-26
-- ============================================================

-- 1. Tambah kolom metode_bayar ke tabel sessions
ALTER TABLE `sessions` 
ADD COLUMN `metode_bayar` ENUM('tunai','qris') NOT NULL DEFAULT 'tunai' 
AFTER `duration_minutes`;

-- 2. Tambah kolom metode_bayar ke tabel history
-- (Menggunakan AFTER total karena kolom di database bernama 'total', bukan 'total_harga')
ALTER TABLE `history` 
ADD COLUMN `metode_bayar` ENUM('tunai','qris') NOT NULL DEFAULT 'tunai' 
AFTER `total`;
