<?php

namespace App\Http\Controllers\Sistem;

use App\Http\Controllers\Controller;
use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SistemAkunController extends Controller
{
    /**
     * Tampilkan daftar semua akun.
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
     * Simpan akun baru.
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
     * Perbarui akun.
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
     * Hapus akun.
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
     * Reset password akun ke password default.
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
