<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminBarangController extends Controller
{
    /**
     * Tampilkan daftar seluruh alat/barang.
     */
    public function index(Request $request)
    {
        $query = Barang::with('kategori');

        // Pencarian (Nama barang, kode barang, merk)
        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_barang', 'like', "%{$keyword}%")
                  ->orWhere('kode_barang', 'like', "%{$keyword}%")
                  ->orWhere('merk_model', 'like', "%{$keyword}%");
            });
        }

        // Filter Kategori
        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        // Filter Kondisi / Status
        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        $barangs = $query->orderBy('nama_barang', 'asc')->paginate(10)->withQueryString();
        $kategoris = Kategori::orderBy('nama_kategori', 'asc')->get();

        return view('admin.barang.index', compact('barangs', 'kategoris'));
    }

    /**
     * Simpan data alat/barang baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang'        => 'required|string|max:255',
            'id_kategori'        => 'required|exists:kategori,id_kategori',
            'kode_barang'        => 'nullable|string|max:30|unique:barang,kode_barang',
            'merk_model'         => 'nullable|string|max:100',
            'no_seri_pabrik'     => 'nullable|string|max:100',
            'ukuran_dimensi'     => 'nullable|string|max:100',
            'bahan'              => 'nullable|string|max:100',
            'tahun_pembelian'    => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'jumlah_baik'        => 'required|integer|min:0',
            'jumlah_kurang_baik' => 'nullable|integer|min:0',
            'jumlah_rusak_berat' => 'nullable|integer|min:0',
            'keterangan'         => 'nullable|string',
            'foto'               => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'nama_barang.required' => 'Nama alat/barang wajib diisi.',
            'id_kategori.required' => 'Pilih kategori alat/barang.',
            'kode_barang.unique'   => 'Kode barang ini sudah digunakan.',
            'jumlah_baik.required' => 'Jumlah barang kondisi baik wajib diisi.',
            'foto.image'           => 'File foto harus berupa gambar (jpg, png, webp).',
            'foto.max'             => 'Ukuran foto maksimal 2MB.',
        ]);

        // Generate kode barang jika dikosongkan
        $kodeBarang = $request->kode_barang;
        if (empty($kodeBarang)) {
            $lastBarang = Barang::orderByDesc('kode_barang')->first();
            $nextNumber = 1;
            if ($lastBarang && preg_match('/BRG-(\d+)/', $lastBarang->kode_barang, $matches)) {
                $nextNumber = intval($matches[1]) + 1;
            } else {
                $count = Barang::count() + 1;
                $nextNumber = $count;
            }
            $kodeBarang = 'BRG-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            // Pastikan unik
            while (Barang::where('kode_barang', $kodeBarang)->exists()) {
                $nextNumber++;
                $kodeBarang = 'BRG-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            }
        }

        // Upload foto jika ada
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('barang', 'public');
        }

        // Tentukan kondisi utama
        $kondisi = 'Baik';
        if ($request->jumlah_baik == 0 && ($request->jumlah_kurang_baik ?? 0) > 0) {
            $kondisi = 'Kurang Baik';
        } elseif ($request->jumlah_baik == 0 && ($request->jumlah_rusak_berat ?? 0) > 0) {
            $kondisi = 'Rusak Berat';
        }

        Barang::create([
            'kode_barang'        => $kodeBarang,
            'id_kategori'        => $request->id_kategori,
            'nama_barang'        => $request->nama_barang,
            'merk_model'         => $request->merk_model,
            'no_seri_pabrik'     => $request->no_seri_pabrik,
            'ukuran_dimensi'     => $request->ukuran_dimensi,
            'bahan'              => $request->bahan,
            'tahun_pembelian'    => $request->tahun_pembelian,
            'jumlah_baik'        => $request->jumlah_baik ?? 0,
            'jumlah_kurang_baik' => $request->jumlah_kurang_baik ?? 0,
            'jumlah_rusak_berat' => $request->jumlah_rusak_berat ?? 0,
            'keterangan'         => $request->keterangan,
            'foto'               => $fotoPath,
            'kondisi'            => $kondisi,
        ]);

        return redirect()->route('admin.barang.index')
            ->with('success', 'Data alat/barang "' . $request->nama_barang . '" berhasil ditambahkan!');
    }

    /**
     * Perbarui data alat/barang.
     */
    public function update(Request $request, string $kode)
    {
        $barang = Barang::findOrFail($kode);

        $request->validate([
            'nama_barang'        => 'required|string|max:255',
            'id_kategori'        => 'required|exists:kategori,id_kategori',
            'merk_model'         => 'nullable|string|max:100',
            'no_seri_pabrik'     => 'nullable|string|max:100',
            'ukuran_dimensi'     => 'nullable|string|max:100',
            'bahan'              => 'nullable|string|max:100',
            'tahun_pembelian'    => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'jumlah_baik'        => 'required|integer|min:0',
            'jumlah_kurang_baik' => 'nullable|integer|min:0',
            'jumlah_rusak_berat' => 'nullable|integer|min:0',
            'keterangan'         => 'nullable|string',
            'foto'               => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $fotoPath = $barang->foto;
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }
            $fotoPath = $request->file('foto')->store('barang', 'public');
        }

        // Tentukan kondisi utama
        $kondisi = 'Baik';
        if ($request->jumlah_baik == 0 && ($request->jumlah_kurang_baik ?? 0) > 0) {
            $kondisi = 'Kurang Baik';
        } elseif ($request->jumlah_baik == 0 && ($request->jumlah_rusak_berat ?? 0) > 0) {
            $kondisi = 'Rusak Berat';
        }

        $barang->update([
            'id_kategori'        => $request->id_kategori,
            'nama_barang'        => $request->nama_barang,
            'merk_model'         => $request->merk_model,
            'no_seri_pabrik'     => $request->no_seri_pabrik,
            'ukuran_dimensi'     => $request->ukuran_dimensi,
            'bahan'              => $request->bahan,
            'tahun_pembelian'    => $request->tahun_pembelian,
            'jumlah_baik'        => $request->jumlah_baik,
            'jumlah_kurang_baik' => $request->jumlah_kurang_baik ?? 0,
            'jumlah_rusak_berat' => $request->jumlah_rusak_berat ?? 0,
            'keterangan'         => $request->keterangan,
            'foto'               => $fotoPath,
            'kondisi'            => $kondisi,
        ]);

        return redirect()->route('admin.barang.index')
            ->with('success', 'Data alat/barang "' . $barang->nama_barang . '" berhasil diperbarui!');
    }

    /**
     * Hapus data alat/barang.
     */
    public function destroy(string $kode)
    {
        $barang = Barang::findOrFail($kode);

        // Cek jika barang sedang dipinjam
        if ($barang->isSedangDipinjam()) {
            return redirect()->route('admin.barang.index')
                ->with('error', 'Barang "' . $barang->nama_barang . '" tidak dapat dihapus karena saat ini sedang aktif dipinjam!');
        }

        // Hapus file foto
        if ($barang->foto && Storage::disk('public')->exists($barang->foto)) {
            Storage::disk('public')->delete($barang->foto);
        }

        $nama = $barang->nama_barang;
        $barang->delete();

        return redirect()->route('admin.barang.index')
            ->with('success', 'Data alat/barang "' . $nama . '" berhasil dihapus!');
    }
}
