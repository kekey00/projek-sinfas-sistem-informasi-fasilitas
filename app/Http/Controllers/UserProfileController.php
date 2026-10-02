<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Pegawai;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    /**
     * Tampilkan halaman My Profile.
     */
    public function index()
    {
        $user = Auth::user();
        $siswa = Siswa::where('nis', $user->nis)->first();

        return view('user.profile', compact('user', 'siswa'));
    }

    /**
     * Perbarui data profil dan/atau ganti kata sandi.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'nama'         => 'required|string|max:255',
            'username'     => 'nullable|string|max:50|unique:akun,username,' . $user->id_akun . ',id_akun',
            'email'        => 'nullable|email|max:255',
            'nomor_kontak' => 'nullable|string|max:50',
            'no_telepon'   => 'nullable|string|max:20',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
        ];

        $messages = [
            'nama.required'   => 'Nama lengkap wajib diisi.',
            'username.unique' => 'Username ini sudah digunakan.',
            'email.email'     => 'Format email tidak valid.',
        ];

        // Validasi ganti password jika diisi
        if ($request->filled('new_password') || $request->filled('current_password')) {
            $rules['current_password'] = 'required|string';
            $rules['new_password']     = 'required|string|min:6|confirmed';

            $messages['current_password.required'] = 'Password saat ini harus diisi untuk mengubah password.';
            $messages['new_password.required']     = 'Password baru wajib diisi.';
            $messages['new_password.min']          = 'Password baru minimal 6 karakter.';
            $messages['new_password.confirmed']    = 'Konfirmasi password baru tidak cocok.';
        }

        $request->validate($rules, $messages);

        // Cek kecocokan password saat ini jika ingin mengganti password
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.'])->withInput();
            }
        }

        DB::transaction(function () use ($request, $user) {
            // Update tabel akun
            $updateData = [
                'nama'         => $request->nama,
                'nomor_kontak' => $request->nomor_kontak,
            ];

            if ($request->filled('username')) {
                $updateData['username'] = $request->username;
            }

            if ($request->filled('new_password')) {
                $updateData['password'] = Hash::make($request->new_password);
            }

            Akun::where('id_akun', $user->id_akun)->update($updateData);

            // Update atau buat entri di tabel siswa jika ada NIS
            if ($user->nis) {
                Siswa::updateOrCreate(
                    ['nis' => $user->nis],
                    [
                        'nama'  => $request->nama,
                        'email' => $request->email,
                        'no_hp' => $request->no_telepon,
                        'jenis_kelamin' => $request->jenis_kelamin,
                    ]
                );
            }

            if ($user->nip) {
                Pegawai::updateOrCreate(
                    ['nip' => $user->nip],
                    [
                        'nama' => $request->nama,
                        'jenis_kelamin' => $request->jenis_kelamin,
                    ]
                );
            }
        });

        return back()->with('success', 'Perubahan data profil berhasil disimpan!');
    }
}
