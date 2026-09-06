<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table      = 'peminjaman';
    protected $primaryKey = 'kode_pinjam';
    public    $incrementing = false;
    protected $keyType    = 'string';

    protected $fillable = [
        'kode_pinjam',
        'nis',
        'kode_barang',
        'tanggal_pinjam',
        'tanggal_kembali',
        'keterangan_penggunaan',
        'status_pengajuan',
    ];

    protected $casts = [
        'tanggal_pinjam'  => 'date',
        'tanggal_kembali' => 'date',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'kode_barang', 'kode_barang');
    }

    public function siswa()
    {
        return $this->belongsTo(\App\Models\Akun::class, 'nis', 'nis');
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'kode_pinjam', 'kode_pinjam');
    }

    /**
     * Generate kode pinjam unik: PJM-YYYYMMDD-XXXX
     */
    public static function generateKode(): string
    {
        $prefix = 'PJM-' . now()->format('Ymd') . '-';
        $last = static::where('kode_pinjam', 'like', $prefix . '%')
            ->orderByDesc('kode_pinjam')
            ->value('kode_pinjam');

        $seq = $last ? (intval(substr($last, -4)) + 1) : 1;
        return $prefix . str_pad($seq, 4, '0', STR_PAD_LEFT);
    }
}
