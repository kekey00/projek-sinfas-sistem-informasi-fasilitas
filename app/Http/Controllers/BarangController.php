<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;

/**
 * Controller Katalog Sarana & Fasilitas (Siswa / Publik)
 *
 * Mengelola antarmuka katalog peminjaman barang untuk siswa:
 * - Pencarian multi-kriteria (nama alat, merk, kategori, ketersediaan stok).
 * - Menampilkan detail spesifikasi teknis alat sebelum mengajukan pinjaman.
 */
class BarangController extends Controller
{
    /**
     * Menampilkan katalog barang/sarana bagi siswa dengan pagination dan pencarian cerdas.
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request dengan parameter pencarian 'q' dan filter 'kategori'.
     * @return \Illuminate\View\View Tampilan katalog kartu barang siswa.
     */
    public function index(Request $request)
    {
        $query = Barang::with('kategori');

        // Search by nama barang, merk model, atau nama kategori
        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_barang', 'like', '%' . $keyword . '%')
                  ->orWhere('merk_model', 'like', '%' . $keyword . '%')
                  ->orWhereHas('kategori', function ($kat) use ($keyword) {
                      $kat->where('nama_kategori', 'like', '%' . $keyword . '%');
                  });

                // Pencarian berdasarkan status ketersediaan
                if (stripos('tersedia', $keyword) !== false) {
                    $q->orWhere('jumlah_baik', '>', 0);
                } elseif (stripos('habis', $keyword) !== false || stripos('kosong', $keyword) !== false) {
                    $q->orWhere('jumlah_baik', '<=', 0);
                }
            });
        }

        // Filter by kategori atau sorting sering_dipinjam
        if ($request->filled('kategori')) {
            if ($request->kategori === 'sering_dipinjam') {
                $query->withCount('peminjamans')->orderBy('peminjamans_count', 'desc');
            } else {
                $query->where('id_kategori', $request->kategori)->orderBy('nama_barang', 'asc');
            }
        } else {
            $query->orderBy('nama_barang', 'asc');
        }

        $barangs   = $query->paginate(8)->withQueryString();
        $kategoris = Kategori::all();

        return view('user.dashboard', compact('barangs', 'kategoris'));
    }

    /**
     * Menampilkan halaman detail spesifikasi sarana dan form isian peminjaman alat.
     *
     * @param  string  $kode  Kode unik barang (contoh: BRG-001).
     * @return \Illuminate\View\View Tampilan detail alat dan form pengajuan pinjam.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Jika barang tidak ditemukan (HTTP 404).
     */
    public function show(string $kode)
    {
        $barang = Barang::with('kategori')->findOrFail($kode);

        return view('user.barang_detail', compact('barang'));
    }
}
