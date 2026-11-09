<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom 'jenis_kelamin' (L/P) pada tabel data staf pegawai.
     *
     * @return void
     */

    public function up(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable()->after('nama');
        });
    }
    /**
     * Menghapus kolom 'jenis_kelamin' dari tabel pegawai jika rollback.
     *
     * @return void
     */


    public function down(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {
            $table->dropColumn('jenis_kelamin');
        });
    }
};