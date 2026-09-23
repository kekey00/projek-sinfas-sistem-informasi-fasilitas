<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Siswa;
use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PeminjamanController extends Controller
{
    /**
     * Halaman Status Pengajuan User (Daftar semua pinjaman user)
     */
    public function status()
    {
        $user = Auth::user();
        $peminjamans = Peminjaman::with(['barang.kategori', 'pengembalian'])
            ->where('nis', $user->nis)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.status', compact('peminjamans'));
    }

    /**
     * Simpan pengajuan peminjaman dari form user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_barang'           => 'required|string|exists:barang,kode_barang',
            'nomor_telepon'         => 'required|string|max:20',
            'tanggal_pinjam'        => 'required|date|after_or_equal:today',
            'tanggal_kembali'       => 'required|date|after:tanggal_pinjam',
            'keterangan_penggunaan' => 'required|string|max:1000',
        ], [
            'nomor_telepon.required'         => 'Nomor telepon / WhatsApp peminjam wajib diisi.',
            'nomor_telepon.max'              => 'Nomor telepon maksimal 20 karakter.',
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

        $kodePinjam = Peminjaman::generateKode();

        Peminjaman::create([
            'kode_pinjam'           => $kodePinjam,
            'nis'                   => Auth::user()->nis,
            'nomor_telepon'         => $request->nomor_telepon,
            'kode_barang'           => $request->kode_barang,
            'tanggal_pinjam'        => $request->tanggal_pinjam,
            'tanggal_kembali'       => $request->tanggal_kembali,
            'keterangan_penggunaan' => $request->keterangan_penggunaan,
            'status_pengajuan'      => 'menunggu',
        ]);

        // Perbarui nomor kontak di akun & data siswa agar profil selalu terupdate
        $user = Auth::user();
        if ($user) {
            Akun::where('id_akun', $user->id_akun)->update(['nomor_kontak' => $request->nomor_telepon]);
            if ($user->nis) {
                Siswa::where('nis', $user->nis)->update(['no_hp' => $request->nomor_telepon]);
            }
        }

        return redirect()->route('user.status')
            ->with('loan_submitted', true)
            ->with('loan_item_name', $barang->nama_barang)
            ->with('success', 'Pengajuan peminjaman "' . $barang->nama_barang . '" berhasil dikirim!');
    }

    /**
     * Tampilkan form pengembalian barang.
     */
    public function createPengembalian(string $kode_pinjam)
    {
        $peminjaman = Peminjaman::with(['barang.kategori', 'pengembalian'])
            ->where('nis', Auth::user()->nis)
            ->findOrFail($kode_pinjam);

        if ($peminjaman->status_pengajuan !== 'disetujui') {
            return redirect()->route('user.status')->with('error', 'Barang ini belum disetujui untuk dipinjam.');
        }

        if ($peminjaman->pengembalian()->exists()) {
            return redirect()->route('user.status')->with('error', 'Barang ini sudah pernah dilaporkan dikembalikan.');
        }

        return view('user.pengembalian', compact('peminjaman'));
    }

    /**
     * Proses pengajuan pengembalian barang dari user.
     */
    public function storePengembalian(Request $request, string $kode_pinjam)
    {
        $request->validate([
            'tanggal_kembali' => 'required|date',
            'kondisi_barang'  => 'required|in:Baik,Kurang Baik,Rusak Berat',
            'bukti_foto'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'catatan'         => 'nullable|string|max:500',
        ], [
            'tanggal_kembali.required' => 'Tanggal pengembalian wajib diisi.',
            'kondisi_barang.required'  => 'Pilih kondisi barang saat dikembalikan.',
            'bukti_foto.image'         => 'File bukti harus berupa gambar (JPG, PNG, WebP).',
            'bukti_foto.max'           => 'Ukuran foto maksimal 5 MB.',
        ]);

        $peminjaman = Peminjaman::with('barang')
            ->where('nis', Auth::user()->nis)
            ->findOrFail($kode_pinjam);

        if ($peminjaman->pengembalian()->exists()) {
            return redirect()->route('user.status')->with('error', 'Barang ini sudah dikembalikan sebelumnya.');
        }

        DB::transaction(function () use ($request, $peminjaman) {
            $fotoPath = null;
            if ($request->hasFile('bukti_foto')) {
                $fotoPath = $request->file('bukti_foto')->store('pengembalian', 'public');
            }

            // Simpan pengembalian
            Pengembalian::create([
                'kode_kembali'     => Pengembalian::generateKode(),
                'kode_pinjam'      => $peminjaman->kode_pinjam,
                'tanggal_kembali'  => $request->tanggal_kembali,
                'kondisi_barang'   => $request->kondisi_barang,
                'bukti_foto_video' => $fotoPath ?? $request->catatan,
            ]);

            // Pulihkan stok barang sesuai kondisi
            $barang = $peminjaman->barang;
            if ($barang) {
                if ($request->kondisi_barang === 'Baik') {
                    $barang->increment('jumlah_baik', 1);
                } elseif ($request->kondisi_barang === 'Kurang Baik') {
                    $barang->increment('jumlah_kurang_baik', 1);
                } elseif ($request->kondisi_barang === 'Rusak Berat') {
                    $barang->increment('jumlah_rusak_berat', 1);
                }
            }
        });

        return redirect()->route('user.status')->with('success', 'Pengembalian barang "' . ($peminjaman->barang->nama_barang ?? 'Barang') . '" berhasil diajukan!');
    }
}
