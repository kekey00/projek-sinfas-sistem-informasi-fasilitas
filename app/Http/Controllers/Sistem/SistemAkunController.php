<?php

namespace App\Http\Controllers\Sistem;

use App\Http\Controllers\Controller;
use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Controller Manajemen Akun Pengguna (Super Admin / Admin Sistem)
 *
 * Mengelola seluruh entitas akun pengguna di lingkungan aplikasi SINFAS:
 * - Menampilkan daftar akun dengan pencarian nama/username/NIS/NIP dan filter role.
 * - Registrasi akun baru (siswa, admin_sarana, admin_sistem) beserta sinkronisasi data master.
 * - Memperbarui profil akun & penyesuaian password baru.
 * - Fitur darurat reset password default ('sinfas123') jika pengguna lupa kata sandi.
 * - Proteksi keamanan: melarang admin menghapus akun miliknya sendiri yang sedang aktif.
 */
class SistemAkunController extends Controller
{
    /**
     * Menampilkan daftar seluruh akun pengguna beserta ringkasan statistik per role.
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request dengan opsi query 'q' dan 'role'.
     * @return \Illuminate\View\View Tampilan tabel manajemen akun.
     */
    public function index(Request $request)
    {
        $query = Akun::query();

        // Pencarian
        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', "%{$keyword}%")
                  ->orWhere('username', 'like', "%{$keyword}%")
                  ->orWhere('nis', 'like', "%{$keyword}%")
                  ->orWhere('nip', 'like', "%{$keyword}%");
            });
        }

        // Filter Role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $akunList = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        // Statistik ringkas
        $stats = [
            'total'         => Akun::count(),
            'siswa'         => Akun::where('role', 'siswa')->count(),
            'admin_sarana'  => Akun::where('role', 'admin_sarana')->count(),
            'admin_sistem'  => Akun::where('role', 'admin_sistem')->count(),
        ];

        return view('sistem.akun.index', compact('akunList', 'stats'));
    }

    /**
     * Menyimpan data akun pengguna baru dan menyinkronkan data profil master.
     *
     * Aturan Bisnis & Integritas:
     * - Username harus unik di seluruh sistem.
     * - Jika role 'siswa', data NIS disinkronkan ke tabel 'siswa' menggunakan updateOrInsert.
     * - Jika role pegawai (admin_sarana/admin_sistem), NIP disinkronkan ke tabel 'pegawai'.
     * - Kata sandi di-hash menggunakan algoritma Bcrypt (Hash::make).
     *
     * @param  \Illuminate\Http\Request  $request  Data form pembuatan akun baru.
     * @return \Illuminate\Http\RedirectResponse  Redirect kembali ke daftar akun dengan pesan sukses.
     *
     * @throws \Illuminate\Validation\ValidationException Jika validasi username/password gagal.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'         => 'required|string|max:255',
            'username'     => 'required|string|max:50|unique:akun,username',
            'role'         => 'required|in:siswa,admin_sarana,admin_sistem',
            'nis'          => 'nullable|string|max:20',
            'nip'          => 'nullable|string|max:20',
            'nomor_kontak' => 'nullable|string|max:20',
            'password'     => 'required|string|min:6|confirmed',
        ], [
            'nama.required'     => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique'   => 'Username sudah digunakan, pilih username lain.',
            'role.required'     => 'Role akun wajib dipilih.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
            'password.confirmed'=> 'Konfirmasi password tidak cocok.',
        ]);

        // Jika role siswa, pastikan data siswa ada di tabel siswa
        if ($request->role === 'siswa' && $request->filled('nis')) {
            DB::table('siswa')->updateOrInsert(
                ['nis' => $request->nis],
                [
                    'nama'       => $request->nama,
                    'email'      => $request->username . '@sinfas.sch.id',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        // Jika role pegawai, pastikan data pegawai ada di tabel pegawai
        if (in_array($request->role, ['admin_sarana', 'admin_sistem']) && $request->filled('nip')) {
            DB::table('pegawai')->updateOrInsert(
                ['nip' => $request->nip],
                [
                    'nama'       => $request->nama,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        Akun::create([
            'nama'         => $request->nama,
            'username'     => $request->username,
            'role'         => $request->role,
            'nis'          => $request->role === 'siswa' ? $request->nis : null,
            'nip'          => in_array($request->role, ['admin_sarana', 'admin_sistem']) ? $request->nip : null,
            'nomor_kontak' => $request->nomor_kontak,
            'password'     => Hash::make($request->password),
        ]);

        return redirect()->route('sistem.akun.index')
            ->with('success', 'Akun "' . $request->nama . '" berhasil ditambahkan!');
    }

    /**
     * Memperbarui informasi data akun dan password baru (opsional).
     *
     * @param  \Illuminate\Http\Request  $request  Data perubahan akun.
     * @param  int                       $id       ID akun (Primary Key id_akun).
     * @return \Illuminate\Http\RedirectResponse   Redirect ke index akun membawa pesan sukses.
     */
    public function update(Request $request, int $id)
    {
        $akun = Akun::findOrFail($id);

        $request->validate([
            'nama'         => 'required|string|max:255',
            'username'     => 'required|string|max:50|unique:akun,username,' . $id . ',id_akun',
            'role'         => 'required|in:siswa,admin_sarana,admin_sistem',
            'nis'          => 'nullable|string|max:20',
            'nip'          => 'nullable|string|max:20',
            'nomor_kontak' => 'nullable|string|max:20',
            'password'     => 'nullable|string|min:6|confirmed',
        ], [
            'nama.required'      => 'Nama lengkap wajib diisi.',
            'username.required'  => 'Username wajib diisi.',
            'username.unique'    => 'Username sudah digunakan.',
            'role.required'      => 'Role akun wajib dipilih.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $updateData = [
            'nama'         => $request->nama,
            'username'     => $request->username,
            'role'         => $request->role,
            'nis'          => $request->role === 'siswa' ? $request->nis : null,
            'nip'          => in_array($request->role, ['admin_sarana', 'admin_sistem']) ? $request->nip : null,
            'nomor_kontak' => $request->nomor_kontak,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $akun->update($updateData);

        return redirect()->route('sistem.akun.index')
            ->with('success', 'Akun "' . $akun->nama . '" berhasil diperbarui!');
    }

    /**
     * Menghapus akun pengguna dari sistem.
     *
     * Aturan Keamanan:
     * - Administrator sistem DILARANG menghapus akunnya sendiri yang sedang digunakan saat ini.
     *
     * @param  int  $id  ID akun yang akan dihapus.
     * @return \Illuminate\Http\RedirectResponse  Redirect kembali dengan notifikasi sukses/error.
     */
    public function destroy(int $id)
    {
        $akun = Akun::findOrFail($id);

        // Cegah hapus diri sendiri
        if (auth()->id() === $akun->id_akun) {
            return redirect()->route('sistem.akun.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $nama = $akun->nama;
        $akun->delete();

        return redirect()->route('sistem.akun.index')
            ->with('success', 'Akun "' . $nama . '" berhasil dihapus!');
    }

    /**
     * Mereset kata sandi akun pengguna ke nilai default sekolah ('sinfas123').
     *
     * @param  int  $id  ID akun yang akan direset kata sandinya.
     * @return \Illuminate\Http\RedirectResponse  Redirect kembali dengan informasi password default.
     */
    public function resetPassword(int $id)
    {
        $akun = Akun::findOrFail($id);
        $defaultPassword = 'sinfas123';

        $akun->update([
            'password' => Hash::make($defaultPassword),
        ]);

        return redirect()->route('sistem.akun.index')
            ->with('success', 'Password akun "' . $akun->nama . '" berhasil direset ke "' . $defaultPassword . '"!');
    }
}
