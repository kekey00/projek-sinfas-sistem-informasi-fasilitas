<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Model Akun (Autentikasi Pengguna)
 *
 * Entitas kredensial login utama pada sistem SINFAS untuk seluruh tingkatan pengguna.
 * Kolom 'role' menentukan otorisasi ('siswa', 'admin_sarana', 'admin_sistem').
 *
 * @property int $id_akun
 * @property string|null $nis
 * @property string|null $nip
 * @property string $nama
 * @property string|null $nomor_kontak
 * @property string $role
 * @property string $username
 * @property string $password
 * @property string|null $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Akun extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'akun';
    protected $primaryKey = 'id_akun';

    protected $fillable = [
        'nis',
        'nip',
        'nama',
        'nomor_kontak',
        'role',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis', 'nis');
    }
}

