-- ==============================================================================
-- SKRIP SQL: STORED PROCEDURE, STORED FUNCTION, TRIGGER & VIEW
-- SISTEM INFORMASI FASILITAS (SINFAS) - SMK NEGERI 11 BANDUNG
-- ==============================================================================

USE `sinfas`;

-- ------------------------------------------------------------------------------
-- 1. TABEL AUDIT LOG (Untuk Menampung Catatan Trigger)
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `log_status_peminjaman` (
    `id_log` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `kode_pinjam` VARCHAR(30) NOT NULL,
    `status_lama` VARCHAR(30) NULL,
    `status_baru` VARCHAR(30) NOT NULL,
    `waktu_perubahan` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ------------------------------------------------------------------------------
-- 2. TRIGGER 1: trg_audit_status_peminjaman
-- Tujuan: Otomatis mencatat histori setiap terjadi perubahan status peminjaman
--         (misal: menunggu -> disetujui, atau menunggu -> dibatalkan).
-- ------------------------------------------------------------------------------
DROP TRIGGER IF EXISTS `trg_audit_status_peminjaman`;
DELIMITER $$
CREATE TRIGGER `trg_audit_status_peminjaman`
AFTER UPDATE ON `peminjaman`
FOR EACH ROW
BEGIN
    IF OLD.status_pengajuan <> NEW.status_pengajuan THEN
        INSERT INTO `log_status_peminjaman` (`kode_pinjam`, `status_lama`, `status_baru`, `waktu_perubahan`)
        VALUES (NEW.kode_pinjam, OLD.status_pengajuan, NEW.status_pengajuan, NOW());
    END IF;
END$$
DELIMITER ;


-- ------------------------------------------------------------------------------
-- 3. TRIGGER 2: trg_cegah_stok_negatif
-- Tujuan: Menjaga integritas data agar stok fisik barang kondisi baik
--         tidak pernah bernilai minus/negatif (< 0).
-- ------------------------------------------------------------------------------
DROP TRIGGER IF EXISTS `trg_cegah_stok_negatif`;
DELIMITER $$
CREATE TRIGGER `trg_cegah_stok_negatif`
BEFORE UPDATE ON `barang`
FOR EACH ROW
BEGIN
    IF NEW.jumlah_baik < 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Kesalahan Integritas: Stok barang kondisi baik tidak boleh bernilai negatif!';
    END IF;
END$$
DELIMITER ;


-- ------------------------------------------------------------------------------
-- 4. STORED PROCEDURE: sp_rekap_peminjaman_siswa
-- Tujuan: Mengambil rekapitulasi data peminjaman berdasarkan NIS siswa.
-- Cara Panggil: CALL sp_rekap_peminjaman_siswa('20261001');
-- ------------------------------------------------------------------------------
DROP PROCEDURE IF EXISTS `sp_rekap_peminjaman_siswa`;
DELIMITER $$
CREATE PROCEDURE `sp_rekap_peminjaman_siswa`(IN p_nis VARCHAR(20))
BEGIN
    SELECT 
        p.kode_pinjam,
        b.nama_barang,
        p.tanggal_pinjam,
        p.tanggal_kembali,
        p.status_pengajuan,
        p.keterangan_penggunaan
    FROM `peminjaman` p
    JOIN `barang` b ON p.kode_barang = b.kode_barang
    WHERE p.nis = p_nis
    ORDER BY p.created_at DESC;
END$$
DELIMITER ;


-- ------------------------------------------------------------------------------
-- 5. STORED FUNCTION 1: fn_total_unit_barang
-- Tujuan: Menghitung jumlah total unit aset (Baik + Kurang Baik + Rusak Berat).
-- Cara Panggil: SELECT nama_barang, fn_total_unit_barang(kode_barang) AS total_unit FROM barang;
-- ------------------------------------------------------------------------------
DROP FUNCTION IF EXISTS `fn_total_unit_barang`;
DELIMITER $$
CREATE FUNCTION `fn_total_unit_barang`(p_kode_barang VARCHAR(30))
RETURNS INT
DETERMINISTIC
READS SQL DATA
BEGIN
    DECLARE v_total INT DEFAULT 0;
    SELECT (jumlah_baik + jumlah_kurang_baik + jumlah_rusak_berat)
    INTO v_total
    FROM `barang`
    WHERE `kode_barang` = p_kode_barang
    LIMIT 1;
    RETURN IFNULL(v_total, 0);
END$$
DELIMITER ;


-- ------------------------------------------------------------------------------
-- 6. STORED FUNCTION 2: fn_status_ketersediaan_barang
-- Tujuan: Menilai ketersediaan barang ('Tersedia' atau 'Habis Dipinjam').
-- Cara Panggil: SELECT nama_barang, fn_status_ketersediaan_barang(kode_barang) AS status_stok FROM barang;
-- ------------------------------------------------------------------------------
DROP FUNCTION IF EXISTS `fn_status_ketersediaan_barang`;
DELIMITER $$
CREATE FUNCTION `fn_status_ketersediaan_barang`(p_kode_barang VARCHAR(30))
RETURNS VARCHAR(30)
DETERMINISTIC
READS SQL DATA
BEGIN
    DECLARE v_stok INT DEFAULT 0;
    DECLARE v_status VARCHAR(30);
    
    SELECT `jumlah_baik` INTO v_stok
    FROM `barang`
    WHERE `kode_barang` = p_kode_barang
    LIMIT 1;
    
    IF v_stok > 0 THEN
        SET v_status = 'Tersedia';
    ELSE
        SET v_status = 'Habis Dipinjam';
    END IF;
    
    RETURN v_status;
END$$
DELIMITER ;


-- ------------------------------------------------------------------------------
-- 7. DATABASE VIEW: v_peminjaman_aktif (Poin No. 9)
-- Tujuan: View relasi gabungan peminjaman berstatus 'disetujui' dengan siswa & barang.
-- Cara Panggil: SELECT * FROM v_peminjaman_aktif;
-- ------------------------------------------------------------------------------
DROP VIEW IF EXISTS `v_peminjaman_aktif`;
CREATE VIEW `v_peminjaman_aktif` AS
SELECT 
    p.kode_pinjam,
    p.nis,
    s.nama AS nama_siswa,
    s.no_hp AS kontak_siswa,
    b.kode_barang,
    b.nama_barang,
    k.nama_kategori,
    p.tanggal_pinjam,
    p.tanggal_kembali,
    p.status_pengajuan
FROM `peminjaman` p
JOIN `siswa` s ON p.nis = s.nis
JOIN `barang` b ON p.kode_barang = b.kode_barang
JOIN `kategori` k ON b.id_kategori = k.id_kategori
WHERE p.status_pengajuan = 'disetujui';
