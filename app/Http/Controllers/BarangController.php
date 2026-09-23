<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Halaman dashboard user — tampil daftar barang dengan filter search & kategori.
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
                $query->where('id_kategori', $request->kategori);
            }
        }

        $barangs   = $query->get();
        $kategoris = Kategori::all();

        return view('user.dashboard', compact('barangs', 'kategoris'));
    }

    /**
     * Halaman detail barang + form pengajuan peminjaman.
     */
    public function show(string $kode)
    {
        $barang = Barang::with('kategori')->findOrFail($kode);

        return view('user.barang_detail', compact('barang'));
    }
}
