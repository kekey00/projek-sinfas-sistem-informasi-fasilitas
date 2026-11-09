<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Siswa (Data Master Peserta Didik)
 *
 * Menyimpan data profil kesiswaan SMKN 11 Bandung yang terhubung ke transaksi peminjaman sarana.
 *
 * @property string $nis
 * @property string $nama
 * @property string|null $email
 * @property string|null $no_hp
 * @property string|null $jenis_kelamin
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Siswa extends Model
{
    protected $table = 'siswa';
    protected $primaryKey = 'nis';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nis',
        'nama',
        'email',
        'no_hp',
        'jenis_kelamin',
    ];

    /**
     * Relasi ke tabel akun (one-to-one).
     * Mengambil akun login yang terhubung dengan siswa ini berdasarkan Nomor Induk Siswa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function akun()
    {
        return $this->hasOne(Akun::class, 'nis', 'nis');
    }

    /**
     * Relasi ke tabel peminjaman (one-to-many).
     * Mengambil seluruh riwayat transaksi peminjaman sarana yang dilakukan oleh siswa ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'nis', 'nis');
    }
}
