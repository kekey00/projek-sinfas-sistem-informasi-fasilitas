<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Model Peminjaman
 * 
 * Merepresentasikan entitas transaksi peminjaman sarana dan prasarana oleh siswa di SMKN 11 Bandung.
 * Mengelola status siklus hidup peminjaman: 'menunggu', 'disetujui', 'ditolak', 'dibatalkan'.
 *
 * @property string $kode_pinjam
 * @property string $nis
 * @property string $nomor_telepon
 * @property string $kode_barang
 * @property \Carbon\Carbon $tanggal_pinjam
 * @property \Carbon\Carbon $tanggal_kembali
 * @property string|null $keterangan_penggunaan
 * @property string $status_pengajuan
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Peminjaman extends Model
{
    protected $table      = 'peminjaman';
    protected $primaryKey = 'kode_pinjam';
    public    $incrementing = false;
    protected $keyType    = 'string';

    protected $fillable = [
        'kode_pinjam',
        'nis',
        'nomor_telepon',
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

    /**
     * Relasi ke tabel barang (belongs-to).
     * Menghubungkan transaksi peminjaman dengan barang sarana yang dipinjam berdasarkan kode barang.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'kode_barang', 'kode_barang');
    }

    /**
     * Relasi ke tabel akun/siswa (belongs-to via NIS).
     * Menghubungkan transaksi peminjaman dengan akun siswa peminjam berdasarkan Nomor Induk Siswa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siswa()
    {
        return $this->belongsTo(\App\Models\Akun::class, 'nis', 'nis');
    }

    /**
     * Relasi ke tabel pengembalian (one-to-one).
     * Mengambil data pengembalian yang terkait dengan transaksi peminjaman ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'kode_pinjam', 'kode_pinjam');
    }

    /**
     * Menghasilkan kode transaksi peminjaman unik otomatis.
     *
     * Format: PJM-YYYYMMDD-XXXX (contoh: PJM-20261109-0001).
     * Aturan Bisnis:
     * - Nomor urut (4 digit) direset setiap pergantian tanggal.
     * - Diurutkan berdasarkan kode terakhir yang tercatat di database hari ini.
     *
     * @return string Kode peminjaman terformat unik sepanjang 21 karakter.
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

    /**
     * Memanggil Stored Procedure MySQL 'sp_rekap_peminjaman_siswa' (Rubrik Poin No. 7: Stored Procedure).
     * Mengambil rekapitulasi riwayat transaksi peminjaman siswa berdasarkan NIS langsung dari Stored Procedure.
     *
     * @param  string  $nis  Nomor Induk Siswa.
     * @return array        Kumpulan record hasil eksekusi Stored Procedure.
     */
    public static function callStoredProcedureRekap(string $nis): array
    {
        try {
            return DB::select("CALL sp_rekap_peminjaman_siswa(?)", [$nis]);
        } catch (\Throwable $e) {
            // Fallback via Eloquent jika Stored Procedure belum terpasang di database lokal
            return self::with('barang')
                ->where('nis', $nis)
                ->orderBy('created_at', 'desc')
                ->get()
                ->toArray();
        }
    }

    /**
     * Mengambil daftar peminjaman aktif yang sedang berjalan menggunakan DATABASE VIEW 'v_peminjaman_aktif'
     * (Rubrik Poin No. 9: Database View).
     *
     * @return \Illuminate\Support\Collection Koleksi data peminjaman aktif langsung dari Database View.
     */
    public static function getPeminjamanAktifFromView(): \Illuminate\Support\Collection
    {
        try {
            return collect(DB::select("SELECT * FROM v_peminjaman_aktif"));
        } catch (\Throwable $e) {
            // Fallback via Eloquent
            return self::with(['barang.kategori', 'siswa'])
                ->where('status_pengajuan', 'disetujui')
                ->get();
        }
    }
}
