<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel 'kategori' untuk pengelompokan jenis inventaris fasilitas sekolah.
     *
     * @return void
     */

    public function up(): void
    {
        Schema::create('kategori', function (Blueprint $table) {
            $table->id('id_kategori');
            $table->string('nama_kategori');
            $table->timestamps();
        });
    }
    /**
     * Membatalkan migrasi dan menghapus tabel 'kategori'.
     *
     * @return void
     */


    public function down(): void
    {
        Schema::dropIfExists('kategori');
    }
};
