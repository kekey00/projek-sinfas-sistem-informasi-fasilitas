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

    public function akun()
    {
        return $this->hasOne(Akun::class, 'nis', 'nis');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'nis', 'nis');
    }
}
