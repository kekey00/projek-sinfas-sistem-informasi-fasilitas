<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    protected $table      = 'pengembalian';
    protected $primaryKey = 'kode_kembali';
    public    $incrementing = false;
    protected $keyType    = 'string';

    protected $fillable = [
        'kode_kembali',
        'kode_pinjam',
        'tanggal_kembali',
        'kondisi_barang',
        'bukti_foto_video',
    ];

    protected $casts = [
        'tanggal_kembali' => 'date',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'kode_pinjam', 'kode_pinjam');
    }

    /**
     * Generate kode kembali unik: KMB-YYYYMMDD-XXXX
     */
    public static function generateKode(): string
    {
        $prefix = 'KMB-' . now()->format('Ymd') . '-';
        $last = static::where('kode_kembali', 'like', $prefix . '%')
            ->orderByDesc('kode_kembali')
            ->value('kode_kembali');

        $seq = $last ? (intval(substr($last, -4)) + 1) : 1;
        return $prefix . str_pad($seq, 4, '0', STR_PAD_LEFT);
    }
}
