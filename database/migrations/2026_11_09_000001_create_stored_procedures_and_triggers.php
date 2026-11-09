<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan migrasi untuk Stored Procedure, Stored Function, dan Trigger (MySQL).
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

        // 2. TRIGGER 1: Mencatat histori setiap kali status peminjaman berubah (Audit Trail)
        DB::unprepared("DROP TRIGGER IF EXISTS `trg_audit_status_peminjaman`");
        DB::unprepared("
            CREATE TRIGGER `trg_audit_status_peminjaman`
            AFTER UPDATE ON `peminjaman`
            FOR EACH ROW
            BEGIN
                IF OLD.status_pengajuan <> NEW.status_pengajuan THEN
                    INSERT INTO `log_status_peminjaman` (`kode_pinjam`, `status_lama`, `status_baru`, `waktu_perubahan`)
                    VALUES (NEW.kode_pinjam, OLD.status_pengajuan, NEW.status_pengajuan, NOW());
                END IF;
            END
        ");

        // 3. TRIGGER 2: Validasi integritas agar stok fisik layak pakai tidak boleh bernilai negatif (< 0)
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

        // 4. STORED PROCEDURE: Rekapitulasi histori transaksi peminjaman siswa berdasarkan NIS
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

        // 5. STORED FUNCTION 1: Menghitung akumulasi seluruh unit fisik barang (Baik + Kurang Baik + Rusak Berat)
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

        // 6. STORED FUNCTION 2: Menilai tingkat kelayakan ketersediaan sarana ('Tersedia' / 'Habis Dipinjam')
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

        // 7. DATABASE VIEW: View gabungan peminjaman aktif untuk kemudahan reporting SQL (Poin No. 9)
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
    }

    /**
     * Membalikkan migrasi (Drop Procedure, Function, Trigger, dan View).
     */
    public function down(): void
    {
        DB::unprepared("DROP VIEW IF EXISTS `v_peminjaman_aktif`");
        DB::unprepared("DROP FUNCTION IF EXISTS `fn_status_ketersediaan_barang`");
        DB::unprepared("DROP FUNCTION IF EXISTS `fn_total_unit_barang`");
        DB::unprepared("DROP PROCEDURE IF EXISTS `sp_rekap_peminjaman_siswa`");
        DB::unprepared("DROP TRIGGER IF EXISTS `trg_cegah_stok_negatif`");
        DB::unprepared("DROP TRIGGER IF EXISTS `trg_audit_status_peminjaman`");
        Schema::dropIfExists('log_status_peminjaman');
    }
};
