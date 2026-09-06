<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
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
