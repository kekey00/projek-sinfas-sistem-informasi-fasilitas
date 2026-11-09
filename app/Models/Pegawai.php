<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Pegawai (Data Master Tenaga Kependidikan)
 *
 * Menyimpan data profil pegawai/staf SMKN 11 Bandung yang berperan sebagai
 * admin sarana atau admin sistem pada aplikasi SINFAS (Sistem Informasi Fasilitas).
 *
 * @property string $nip           Nomor Induk Pegawai (primary key).
 * @property string $nama          Nama lengkap pegawai.
 * @property string|null $jenis_kelamin Jenis kelamin pegawai ('L' atau 'P').
 * @property \Carbon\Carbon $created_at   Waktu pembuatan record.
 * @property \Carbon\Carbon $updated_at   Waktu pembaruan terakhir record.
 */
class Pegawai extends Model
{
    protected $table = 'pegawai';
    protected $primaryKey = 'nip';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nip',
        'nama',
        'jenis_kelamin',
    ];

    /**
     * Relasi ke tabel akun (one-to-one via NIP).
     * Mengambil kredensial akun login staf sarana atau admin sistem berdasarkan Nomor Induk Pegawai.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function akun()
    {
        return $this->hasOne(Akun::class, 'nip', 'nip');
    }
}
