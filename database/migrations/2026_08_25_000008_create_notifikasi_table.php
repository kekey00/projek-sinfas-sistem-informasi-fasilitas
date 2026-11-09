<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel 'notifikasi' untuk pencatatan riwayat pemberitahuan status peminjaman.
     *
     * @return void
     */

    public function up(): void
    {
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id('id_notifikasi');
            $table->foreignId('id_akun')->constrained('akun', 'id_akun');
            $table->text('pesan');
            $table->boolean('status_baca')->default(false);
            $table->timestamps();
        });
    }
    /**
     * Membatalkan migrasi dan menghapus tabel 'notifikasi'.
     *
     * @return void
     */


    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
