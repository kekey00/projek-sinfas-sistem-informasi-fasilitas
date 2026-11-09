<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel master 'pegawai' untuk identitas staf sarana prasarana dan tenaga kependidikan.
     *
     * @return void
     */

    public function up(): void
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->string('nip', 20)->primary();
            $table->string('nama');
            $table->timestamps();
        });
    }
    /**
     * Membatalkan migrasi dan menghapus tabel 'pegawai'.
     *
     * @return void
     */


    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
