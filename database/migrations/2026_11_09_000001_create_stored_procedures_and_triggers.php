<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan migrasi untuk Stored Procedure, Stored Function, Trigger, dan View (MySQL).
     *
     * Komponen yang dipasang:
     * - Tabel audit: log_status_peminjaman
     * - Trigger peminjaman: otomatis kurangi stok saat 'disetujui' & catat audit trail
     * - Trigger pengembalian: otomatis pulihkan stok saat status 'selesai'
     * - Trigger barang: validasi integritas agar stok tidak minus (< 0)
     * - Stored Procedure: rekap peminjaman siswa per NIS
     * - Stored Function: total unit dan status ketersediaan barang
     * - Database View: view peminjaman aktif terverifikasi
     */
    public function up(): void
    {
        // 1. Buat tabel audit log untuk mencatat histori perubahan status oleh Trigger
        if (!Schema::hasTable('log_status_peminjaman')) {
            Schema::create('log_status_peminjaman', function (Blueprint $table) {
                $table->id('id_log');
                $table->string('kode_pinjam', 30);
                $table->string('status_lama', 30)->nullable();
                $table->string('status_baru', 30);
                $table->timestamp('waktu_perubahan')->useCurrent();
            });
        }

        // 2. TRIGGER 1: trg_peminjaman_after_update (AFTER UPDATE ON peminjaman)
        // Fungsi:
        // a) Mencatat audit log setiap kali status pengajuan berubah.
        // b) Otomatis MEMOTONG stok layak pakai (jumlah_baik - 1) saat status menjadi 'disetujui'.
        // c) Otomatis MEMULIHKAN stok layak pakai (jumlah_baik + 1) jika peminjaman yang sempat 'disetujui' dibatalkan/ditolak.
        DB::unprepared("DROP TRIGGER IF EXISTS `trg_audit_status_peminjaman`");
        DB::unprepared("DROP TRIGGER IF EXISTS `trg_kurangi_stok_peminjaman`");
        DB::unprepared("DROP TRIGGER IF EXISTS `trg_peminjaman_after_update`");
        DB::unprepared("
            CREATE TRIGGER `trg_peminjaman_after_update`
            AFTER UPDATE ON `peminjaman`
            FOR EACH ROW
            BEGIN
                -- Audit Trail Log
                IF OLD.status_pengajuan <> NEW.status_pengajuan THEN
                    INSERT INTO `log_status_peminjaman` (`kode_pinjam`, `status_lama`, `status_baru`, `waktu_perubahan`)
                    VALUES (NEW.kode_pinjam, OLD.status_pengajuan, NEW.status_pengajuan, NOW());
                END IF;

                -- Otomatis Kurangi Stok saat Pengajuan Disetujui Admin
                IF OLD.status_pengajuan <> 'disetujui' AND NEW.status_pengajuan = 'disetujui' THEN
                    UPDATE `barang`
                    SET `jumlah_baik` = GREATEST(0, `jumlah_baik` - 1)
                    WHERE `kode_barang` = NEW.kode_barang;
                END IF;

                -- Otomatis Pulihkan Stok jika Pinjaman yang Disetujui Dibatalkan / Ditolak
                IF OLD.status_pengajuan = 'disetujui' AND NEW.status_pengajuan IN ('dibatalkan', 'ditolak') THEN
                    UPDATE `barang`
                    SET `jumlah_baik` = `jumlah_baik` + 1
                    WHERE `kode_barang` = NEW.kode_barang;
                END IF;
            END
        ");

        // 3. TRIGGER 2: trg_pengembalian_after_update (AFTER UPDATE ON pengembalian)
        // Fungsi: Otomatis menambah kembali stok barang sesuai kondisi fisik saat admin memverifikasi selesai.
        DB::unprepared("DROP TRIGGER IF EXISTS `trg_pengembalian_after_update`");
        DB::unprepared("
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
            END
        ");

        // 4. TRIGGER 3: trg_pengembalian_after_insert (AFTER INSERT ON pengembalian)
        // Fungsi: Menangani pengembalian instan yang langsung berstatus 'selesai'
        DB::unprepared("DROP TRIGGER IF EXISTS `trg_pengembalian_after_insert`");
        DB::unprepared("
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
            END
        ");

        // 5. TRIGGER 4: trg_cegah_stok_negatif (BEFORE UPDATE ON barang)
        // Fungsi: Validasi integritas agar stok fisik barang kondisi baik tidak boleh negatif (< 0)
        DB::unprepared("DROP TRIGGER IF EXISTS `trg_cegah_stok_negatif`");
        DB::unprepared("
            CREATE TRIGGER `trg_cegah_stok_negatif`
            BEFORE UPDATE ON `barang`
            FOR EACH ROW
            BEGIN
                IF NEW.jumlah_baik < 0 THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Kesalahan Integritas: Stok barang kondisi baik tidak boleh bernilai negatif!';
                END IF;
            END
        ");

        // 6. STORED PROCEDURE: sp_rekap_peminjaman_siswa
        DB::unprepared("DROP PROCEDURE IF EXISTS `sp_rekap_peminjaman_siswa`");
        DB::unprepared("
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
            END
        ");

        // 7. STORED FUNCTION 1: fn_total_unit_barang
        DB::unprepared("DROP FUNCTION IF EXISTS `fn_total_unit_barang`");
        DB::unprepared("
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
            END
        ");

        // 8. STORED FUNCTION 2: fn_status_ketersediaan_barang
        DB::unprepared("DROP FUNCTION IF EXISTS `fn_status_ketersediaan_barang`");
        DB::unprepared("
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
            END
        ");

        // 9. DATABASE VIEW 1: v_peminjaman_aktif (Data Peminjaman Aktif Terintegrasi)
        DB::unprepared("DROP VIEW IF EXISTS `v_peminjaman_aktif`");
        DB::unprepared("
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
            WHERE p.status_pengajuan = 'disetujui'
        ");

        // 10. DATABASE VIEW 2: v_rekap_inventaris (Rekapitulasi Fisik Inventaris Sarpras)
        DB::unprepared("DROP VIEW IF EXISTS `v_rekap_inventaris`");
        DB::unprepared("
            CREATE VIEW `v_rekap_inventaris` AS
            SELECT 
                b.kode_barang,
                b.nama_barang,
                b.merk_model,
                k.nama_kategori,
                b.jumlah_baik,
                b.jumlah_kurang_baik,
                b.jumlah_rusak_berat,
                (b.jumlah_baik + b.jumlah_kurang_baik + b.jumlah_rusak_berat) AS total_unit,
                CASE 
                    WHEN b.jumlah_baik > 0 THEN 'Tersedia' 
                    ELSE 'Habis Dipinjam' 
                END AS status_ketersediaan
            FROM `barang` b
            JOIN `kategori` k ON b.id_kategori = k.id_kategori
        ");
    }

    /**
     * Membalikkan migrasi (Drop Procedure, Function, Trigger, View, dan Tabel Log).
     */
    public function down(): void
    {
        DB::unprepared("DROP VIEW IF EXISTS `v_rekap_inventaris`");
        DB::unprepared("DROP VIEW IF EXISTS `v_peminjaman_aktif`");
        DB::unprepared("DROP FUNCTION IF EXISTS `fn_status_ketersediaan_barang`");
        DB::unprepared("DROP FUNCTION IF EXISTS `fn_total_unit_barang`");
        DB::unprepared("DROP PROCEDURE IF EXISTS `sp_rekap_peminjaman_siswa`");
        DB::unprepared("DROP TRIGGER IF EXISTS `trg_cegah_stok_negatif`");
        DB::unprepared("DROP TRIGGER IF EXISTS `trg_pengembalian_after_insert`");
        DB::unprepared("DROP TRIGGER IF EXISTS `trg_pengembalian_after_update`");
        DB::unprepared("DROP TRIGGER IF EXISTS `trg_peminjaman_after_update`");
        DB::unprepared("DROP TRIGGER IF EXISTS `trg_audit_status_peminjaman`");
        DB::unprepared("DROP TRIGGER IF EXISTS `trg_kurangi_stok_peminjaman`");
        Schema::dropIfExists('log_status_peminjaman');
    }
};
