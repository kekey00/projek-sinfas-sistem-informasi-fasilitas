<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Pengembalian
 *
 * Merepresentasikan pencatatan pelaporan dan verifikasi fisik pengembalian sarana/prasarana.
 * Menyimpan rekam jejak kondisi fisik barang (Baik, Kurang Baik, Rusak Berat) serta berkas bukti visual.
 *
 * @property string $kode_kembali
 * @property string $kode_pinjam
 * @property \Carbon\Carbon $tanggal_kembali
 * @property string $kondisi_barang
 * @property string|null $bukti_foto_video
 * @property string $status ('menunggu', 'selesai')
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
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
        'status',
    ];

    protected $casts = [
        'tanggal_kembali' => 'date',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'kode_pinjam', 'kode_pinjam');
    }

    /**
     * Menghasilkan kode unik pelaporan pengembalian barang secara otomatis.
     *
     * Format: KMB-YYYYMMDD-XXXX (contoh: KMB-20261109-0001).
     *
     * @return string Kode pengembalian terformat unik.
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
