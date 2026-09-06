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

        // Search by nama barang
        if ($request->filled('q')) {
            $query->where('nama_barang', 'like', '%' . $request->q . '%');
        }

        // Filter by kategori
        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
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
