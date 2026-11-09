<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom 'jenis_kelamin' (L/P) pada tabel master data siswa.
     *
     * @return void
     */

    public function up(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable()->after('no_hp');
        });
    }
    /**
     * Menghapus kolom 'jenis_kelamin' dari tabel siswa jika rollback.
     *
     * @return void
     */


    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn('jenis_kelamin');
        });
    }
};