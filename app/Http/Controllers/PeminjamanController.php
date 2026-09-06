<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    /**
     * Simpan pengajuan peminjaman dari form user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_barang'           => 'required|string|exists:barang,kode_barang',
            'tanggal_pinjam'        => 'required|date|after_or_equal:today',
            'tanggal_kembali'       => 'required|date|after:tanggal_pinjam',
            'keterangan_penggunaan' => 'required|string|max:1000',
        ], [
            'tanggal_pinjam.required'        => 'Tanggal pinjam wajib diisi.',
            'tanggal_pinjam.after_or_equal'  => 'Tanggal pinjam tidak boleh sebelum hari ini.',
            'tanggal_kembali.required'       => 'Rencana tanggal kembali wajib diisi.',
            'tanggal_kembali.after'          => 'Tanggal kembali harus setelah tanggal pinjam.',
            'keterangan_penggunaan.required' => 'Tujuan / alasan peminjaman wajib diisi.',
        ]);

        $barang = Barang::findOrFail($request->kode_barang);

        // Cek stok barang tersedia
        if ($barang->jumlah_baik < 1) {
            return back()->withErrors(['stok' => 'Maaf, barang ini sedang tidak tersedia untuk dipinjam.'])->withInput();
        }

        Peminjaman::create([
            'kode_pinjam'           => Peminjaman::generateKode(),
            'nis'                   => Auth::user()->nis,
            'kode_barang'           => $request->kode_barang,
            'tanggal_pinjam'        => $request->tanggal_pinjam,
            'tanggal_kembali'       => $request->tanggal_kembali,
            'keterangan_penggunaan' => $request->keterangan_penggunaan,
            'status_pengajuan'      => 'menunggu',
        ]);

        return redirect()->route('user.dashboard')
            ->with('success', 'Pengajuan peminjaman "' . $barang->nama_barang . '" berhasil dikirim! Silakan tunggu persetujuan admin.');
    }
}
