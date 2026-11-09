-- ==============================================================================
-- SKRIP BASIS DATA LENGKAP: STORED PROCEDURE, STORED FUNCTION, TRIGGER & VIEW
-- SISTEM INFORMASI FASILITAS (SINFAS) - SMK NEGERI 11 BANDUNG
-- ==============================================================================

USE `sinfas`;

-- ------------------------------------------------------------------------------
-- 1. TABEL AUDIT LOG (Untuk Menampung Catatan Histori Perubahan Status oleh Trigger)
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `log_status_peminjaman` (
    `id_log` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `kode_pinjam` VARCHAR(30) NOT NULL,
    `status_lama` VARCHAR(30) NULL,
    `status_baru` VARCHAR(30) NOT NULL,
    `waktu_perubahan` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ------------------------------------------------------------------------------
-- 2. TRIGGER 1: trg_peminjaman_after_update (AFTER UPDATE ON peminjaman)
-- Tujuan:
--   a) Mencatat histori perubahan status ke tabel audit log_status_peminjaman.
--   b) OTOMATIS MEMOTONG STOK barang (jumlah_baik - 1) saat pengajuan disetujui admin.
--   c) OTOMATIS MEMULIHKAN STOK barang (jumlah_baik + 1) jika pengajuan yang disetujui dibatalkan/ditolak.
-- ------------------------------------------------------------------------------
DROP TRIGGER IF EXISTS `trg_audit_status_peminjaman`;
DROP TRIGGER IF EXISTS `trg_kurangi_stok_peminjaman`;
DROP TRIGGER IF EXISTS `trg_peminjaman_after_update`;
DELIMITER $$
CREATE TRIGGER `trg_peminjaman_after_update`
AFTER UPDATE ON `peminjaman`
FOR EACH ROW
BEGIN
    -- 1. Audit Trail: Catat perubahan status transaksi
    IF OLD.status_pengajuan <> NEW.status_pengajuan THEN
        INSERT INTO `log_status_peminjaman` (`kode_pinjam`, `status_lama`, `status_baru`, `waktu_perubahan`)
        VALUES (NEW.kode_pinjam, OLD.status_pengajuan, NEW.status_pengajuan, NOW());
    END IF;

    -- 2. Pemotongan Stok Otomatis saat Disetujui
    IF OLD.status_pengajuan <> 'disetujui' AND NEW.status_pengajuan = 'disetujui' THEN
        UPDATE `barang`
        SET `jumlah_baik` = GREATEST(0, `jumlah_baik` - 1)
        WHERE `kode_barang` = NEW.kode_barang;
    END IF;

    -- 3. Pemulihan Stok Otomatis jika Pinjaman Disetujui Dibatalkan/Ditolak
    IF OLD.status_pengajuan = 'disetujui' AND NEW.status_pengajuan IN ('dibatalkan', 'ditolak') THEN
        UPDATE `barang`
        SET `jumlah_baik` = `jumlah_baik` + 1
        WHERE `kode_barang` = NEW.kode_barang;
    END IF;
END$$
DELIMITER ;


-- ------------------------------------------------------------------------------
-- 3. TRIGGER 2: trg_pengembalian_after_update (AFTER UPDATE ON pengembalian)
-- Tujuan: Otomatis menambah kembali stok barang sesuai kondisi fisik saat admin
--         memverifikasi status pengembalian menjadi 'selesai'.
-- ------------------------------------------------------------------------------
DROP TRIGGER IF EXISTS `trg_pengembalian_after_update`;
DELIMITER $$
CREATE TRIGGER `trg_pengembalian_after_update`
AFTER UPDATE ON `pengembalian`
FOR EACH ROW
BEGIN
    DECLARE v_kode_barang VARCHAR(30);

    IF OLD.status <> 'selesai' AND NEW.status = 'selesai' THEN
        SELECT `kode_barang` INTO v_kode_barang
        FROM `peminjaman`
        WHERE `kode_pinjam` = NEW.kode_pinjam
        LIMIT 1;

        IF v_kode_barang IS NOT NULL THEN
            IF NEW.kondisi_barang = 'Baik' THEN
                UPDATE `barang`
                SET `jumlah_baik` = `jumlah_baik` + 1
                WHERE `kode_barang` = v_kode_barang;
            ELSEIF NEW.kondisi_barang = 'Kurang Baik' THEN
                UPDATE `barang`
                SET `jumlah_kurang_baik` = `jumlah_kurang_baik` + 1
                WHERE `kode_barang` = v_kode_barang;
            ELSEIF NEW.kondisi_barang = 'Rusak Berat' THEN
                UPDATE `barang`
                SET `jumlah_rusak_berat` = `jumlah_rusak_berat` + 1
                WHERE `kode_barang` = v_kode_barang;
            END IF;
        END IF;
    END IF;
END$$
DELIMITER ;


-- ------------------------------------------------------------------------------
-- 4. TRIGGER 3: trg_pengembalian_after_insert (AFTER INSERT ON pengembalian)
-- Tujuan: Menangani kasus saat data pengembalian langsung diinput dengan status 'selesai'.
-- ------------------------------------------------------------------------------
DROP TRIGGER IF EXISTS `trg_pengembalian_after_insert`;
DELIMITER $$
CREATE TRIGGER `trg_pengembalian_after_insert`
AFTER INSERT ON `pengembalian`
FOR EACH ROW
BEGIN
    DECLARE v_kode_barang VARCHAR(30);

    IF NEW.status = 'selesai' THEN
        SELECT `kode_barang` INTO v_kode_barang
        FROM `peminjaman`
        WHERE `kode_pinjam` = NEW.kode_pinjam
        LIMIT 1;

        IF v_kode_barang IS NOT NULL THEN
            IF NEW.kondisi_barang = 'Baik' THEN
                UPDATE `barang`
                SET `jumlah_baik` = `jumlah_baik` + 1
                WHERE `kode_barang` = v_kode_barang;
            ELSEIF NEW.kondisi_barang = 'Kurang Baik' THEN
                UPDATE `barang`
                SET `jumlah_kurang_baik` = `jumlah_kurang_baik` + 1
                WHERE `kode_barang` = v_kode_barang;
            ELSEIF NEW.kondisi_barang = 'Rusak Berat' THEN
                UPDATE `barang`
                SET `jumlah_rusak_berat` = `jumlah_rusak_berat` + 1
                WHERE `kode_barang` = v_kode_barang;
            END IF;
        END IF;
    END IF;
END$$
DELIMITER ;


-- ------------------------------------------------------------------------------
-- 5. TRIGGER 4: trg_cegah_stok_negatif (BEFORE UPDATE ON barang)
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
-- 6. STORED PROCEDURE: sp_rekap_peminjaman_siswa
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
-- 7. STORED FUNCTION 1: fn_total_unit_barang
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
-- 8. STORED FUNCTION 2: fn_status_ketersediaan_barang
-- Tujuan: Menentukan apakah barang masih tersedia atau sudah habis dipinjam.
-- Cara Panggil: SELECT nama_barang, fn_status_ketersediaan_barang(kode_barang) FROM barang;
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
-- 9. DATABASE VIEW: v_peminjaman_aktif
-- Tujuan: View gabungan relasi tabel peminjaman, siswa, barang, dan kategori
--         khusus untuk transaksi peminjaman yang sedang aktif ('disetujui').
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
