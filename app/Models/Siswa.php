<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
