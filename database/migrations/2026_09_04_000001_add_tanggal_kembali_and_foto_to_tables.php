<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom 'tanggal_kembali' pada peminjaman dan 'foto' pada master barang sarana.
     *
     * @return void
     */

    public function up(): void
    {
        // Tambah kolom foto ke tabel barang
        Schema::table('barang', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('keterangan');
            $table->enum('kondisi', ['Baik', 'Kurang Baik', 'Rusak Berat'])->default('Baik')->after('foto');
        });

        // Tambah kolom tanggal_kembali ke tabel peminjaman
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->date('tanggal_kembali')->nullable()->after('tanggal_pinjam');
        });
    }
    /**
     * Menghapus kembali kolom 'tanggal_kembali' dan 'foto' jika terjadi rollback.
     *
     * @return void
     */


    public function down(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->dropColumn(['foto', 'kondisi']);
        });

        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn('tanggal_kembali');
        });
    }
};
