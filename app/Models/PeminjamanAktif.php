<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Representasi Database View 'v_peminjaman_aktif'
 *
 * Mengimplementasikan Rubrik Poin No. 9: Database View.
 * Memetakan view basis data relasional 'v_peminjaman_aktif' langsung ke model Eloquent ORM
 * untuk memudahkan query tanpa perlu menulis klausa JOIN berulang di controller.
 *
 * @property string $kode_pinjam
 * @property string $nis
 * @property string $nama_siswa
 * @property string $kontak_siswa
 * @property string $kode_barang
 * @property string $nama_barang
 * @property string $nama_kategori
 * @property string $tanggal_pinjam
 * @property string $tanggal_kembali
 * @property string $status_pengajuan
 */
class PeminjamanAktif extends Model
{
    protected $table = 'v_peminjaman_aktif';
    protected $primaryKey = 'kode_pinjam';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
}
