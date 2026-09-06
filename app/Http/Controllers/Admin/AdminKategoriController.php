<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class AdminKategoriController extends Controller
{
    /**
     * Tampilkan daftar kategori dengan jumlah barang.
     */
    public function index(Request $request)
    {
        $query = Kategori::withCount('barangs');

        if ($request->filled('q')) {
            $query->where('nama_kategori', 'like', '%' . $request->q . '%');
        }

        $kategoris = $query->orderBy('nama_kategori', 'asc')->paginate(10)->withQueryString();

        return view('admin.kategori.index', compact('kategoris'));
    }

    /**
     * Simpan kategori baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori,nama_kategori',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Nama kategori sudah ada.',
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori "' . $request->nama_kategori . '" berhasil ditambahkan!');
    }

    /**
     * Perbarui nama kategori.
     */
    public function update(Request $request, int $id)
    {
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori,nama_kategori,' . $id . ',id_kategori',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Nama kategori sudah digunakan.',
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil diperbarui menjadi "' . $kategori->nama_kategori . '"!');
    }

    /**
     * Hapus kategori.
     */
    public function destroy(int $id)
    {
        $kategori = Kategori::withCount('barangs')->findOrFail($id);

        if ($kategori->barangs_count > 0) {
            return redirect()->route('admin.kategori.index')
                ->with('error', 'Kategori "' . $kategori->nama_kategori . '" tidak dapat dihapus karena masih memiliki ' . $kategori->barangs_count . ' data alat/barang terkait!');
        }

        $nama = $kategori->nama_kategori;
        $kategori->delete();

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori "' . $nama . '" berhasil dihapus!');
    }
}
