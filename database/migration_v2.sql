-- =============================================================
-- YK2 Gaming Admin Panel — Migration v2
-- Dibuat: 2026-05-19
-- Deskripsi: Menambahkan tabel users dan saved_tokens.
--            TIDAK mengubah tabel: units, sessions, saved_sessions, history.
-- Aman dijalankan ulang karena menggunakan IF NOT EXISTS / INSERT IGNORE.
-- =============================================================

-- -------------------------------------------------------------
-- TABEL: users
-- Menyimpan akun login (admin & kasir)
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
    `id`            VARCHAR(36)     NOT NULL,
    `username`      VARCHAR(50)     NOT NULL,
    `password_hash` VARCHAR(255)    NOT NULL,
    `role`          ENUM('admin','kasir') NOT NULL DEFAULT 'kasir',
    `created_at`    DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_users_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -------------------------------------------------------------
-- TABEL: saved_tokens
-- Menyimpan token sesi yang di-save (format YK2-XXXX)
-- FK ke tabel `units` — CASCADE DELETE jika unit dihapus
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `saved_tokens` (
    `id`                VARCHAR(36)     NOT NULL,
    `token_code`        VARCHAR(10)     NOT NULL COMMENT 'Format: YK2-XXXX',
    `unit_id`           VARCHAR(36)     NOT NULL,
    `unit_name`         VARCHAR(100)    NOT NULL,
    `customer_name`     VARCHAR(100)    NOT NULL,
    `remaining_minutes` INT             NOT NULL,
    `is_used`           TINYINT(1)      NOT NULL DEFAULT 0,
    `created_at`        DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `expired_at`        DATETIME        NOT NULL COMMENT 'created_at + 30 hari',
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_saved_tokens_token_code` (`token_code`),
    CONSTRAINT `fk_saved_tokens_unit_id`
        FOREIGN KEY (`unit_id`)
        REFERENCES `units` (`id`)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -------------------------------------------------------------
-- SEED DATA: Akun admin default
-- username : admin
-- password : admin123  (di-hash dengan password_hash() PHP bcrypt)
-- UUID v4  : di-generate sekali pakai, statis agar INSERT IGNORE aman
-- Jalankan ulang → dilewati karena INSERT IGNORE + UNIQUE username
-- -------------------------------------------------------------
INSERT IGNORE INTO `users` (`id`, `username`, `password_hash`, `role`, `created_at`)
VALUES (
    'a1b2c3d4-e5f6-7890-abcd-ef1234567890',
    'admin',
    '$2y$10$wR4DdmcG1QPPxFOq/MyFXeWAJ3AN6U2Q5KRqjcbudlPGpageoZNYa',
    'admin',
    NOW()
);

-- =============================================================
-- SELESAI
-- Verifikasi:
--   SHOW TABLES;
--   DESCRIBE users;
--   DESCRIBE saved_tokens;
--   SELECT id, username, role, created_at FROM users;
-- =============================================================
