<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

/**
 * Controller Manajemen Kategori Sarana & Prasarana (Admin Sarana)
 *
 * Mengelola klasifikasi kelompok inventaris barang (contoh: Multimedia, Jaringan, Audio, Olahraga).
 * Mendukung pencarian kategori, pembuatan kategori unik baru, pengubahan nama,
 * serta penghapusan kategori dengan proteksi integritas relasi data (dilarang hapus jika masih ada barang terkait).
 */
class AdminKategoriController extends Controller
{
    /**
     * Menampilkan daftar seluruh kategori sarana beserta counter jumlah barang terkait.
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request dengan opsi filter pencarian nama kategori 'q'.
     * @return \Illuminate\View\View Tampilan tabel kategori barang.
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
     * Menyimpan data nama kategori inventaris baru.
     *
     * @param  \Illuminate\Http\Request  $request  Data form penambahan kategori.
     * @return \Illuminate\Http\RedirectResponse   Redirect kembali membawa pesan sukses.
     *
     * @throws \Illuminate\Validation\ValidationException Jika nama kategori kosong atau sudah ada.
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
            ->with('success', 'Kategori "' . $request->nama_kategori . '" berhasil ditambahkan!')
            ->with('toast_title', 'Penambahan kategori berhasil');
    }

    /**
     * Memperbarui nama kategori yang sudah ada.
     *
     * @param  \Illuminate\Http\Request  $request  Data form pembaruan kategori.
     * @param  int                       $id       ID kategori (Primary Key id_kategori).
     * @return \Illuminate\Http\RedirectResponse   Redirect kembali membawa pesan sukses.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Jika kategori tidak ditemukan.
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
            ->with('success', 'Kategori berhasil diperbarui menjadi "' . $kategori->nama_kategori . '"!')
            ->with('toast_title', 'Pembaruan kategori berhasil');
    }

    /**
     * Menghapus data kategori inventaris.
     *
     * Aturan Integritas Data:
     * - DILARANG menghapus kategori yang masih memiliki data barang terhubung (barangs_count > 0)
     *   untuk mencegah error foreign key atau data barang tanpa kategori (orphan data).
     *
     * @param  int  $id  ID kategori yang akan dihapus.
     * @return \Illuminate\Http\RedirectResponse Redirect kembali dengan pesan sukses atau error integritas.
     */
    public function destroy(int $id)
    {
        $kategori = Kategori::withCount('barangs')->findOrFail($id);

        if ($kategori->barangs_count > 0) {
            return redirect()->route('admin.kategori.index')
                ->with('error', 'Kategori "' . $kategori->nama_kategori . '" tidak dapat dihapus karena masih memiliki ' . $kategori->barangs_count . ' data alat/barang terkait!')
                ->with('toast_title', 'Gagal menghapus kategori');
        }

        $nama = $kategori->nama_kategori;
        $kategori->delete();

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori "' . $nama . '" berhasil dihapus!')
            ->with('toast_title', 'Kategori berhasil dihapus');
    }
}
