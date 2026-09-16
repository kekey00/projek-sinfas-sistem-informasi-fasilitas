<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pengembalian', function (Blueprint $table) {
            $table->dropForeign(['kode_pinjam']);
            $table->foreign('kode_pinjam')
                  ->references('kode_pinjam')
                  ->on('peminjaman')
                  ->cascadeOnDelete();
        });

        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropForeign(['kode_barang']);
            $table->foreign('kode_barang')
                  ->references('kode_barang')
                  ->on('barang')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropForeign(['kode_barang']);
            $table->foreign('kode_barang')
                  ->references('kode_barang')
                  ->on('barang');
        });

        Schema::table('pengembalian', function (Blueprint $table) {
            $table->dropForeign(['kode_pinjam']);
            $table->foreign('kode_pinjam')
                  ->references('kode_pinjam')
                  ->on('peminjaman');
        });
    }
};
