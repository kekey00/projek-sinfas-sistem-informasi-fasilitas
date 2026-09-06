<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table      = 'barang';
    protected $primaryKey = 'kode_barang';
    public    $incrementing = false;
    protected $keyType    = 'string';

    protected $fillable = [
        'kode_barang',
        'id_kategori',
        'nama_barang',
        'merk_model',
        'no_seri_pabrik',
        'ukuran_dimensi',
        'bahan',
        'tahun_pembelian',
        'jumlah_baik',
        'jumlah_kurang_baik',
        'jumlah_rusak_berat',
        'keterangan',
        'foto',
        'kondisi',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'kode_barang', 'kode_barang');
    }

    /**
     * Cek apakah barang sedang aktif dipinjam (status disetujui & belum dikembalikan).
     */
    public function isSedangDipinjam(): bool
    {
        return $this->peminjamans()
            ->where('status_pengajuan', 'disetujui')
            ->whereDoesntHave('pengembalian')
            ->exists();
    }

    /**
     * Kembalikan label status untuk tampilan.
     */
    public function getStatusLabel(): string
    {
        if ($this->jumlah_baik > 0) {
            return 'Tersedia';
        }
        return 'Tidak Tersedia';
    }
}
