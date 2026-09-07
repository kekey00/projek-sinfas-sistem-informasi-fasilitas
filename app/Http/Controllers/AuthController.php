<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function showLogin()
    {
        // Jika sudah login, langsung arahkan ke dashboard sesuai role
        if (Auth::check()) {
            return $this->redirectByRole();
        }

        return view('auth.login');
    }

    /**
     * Tampilkan halaman register.
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectByRole();
        }

        return view('auth.register');
    }

    /**
     * Proses registrasi akun siswa baru.
     */
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:akun,username',
            'nis' => 'required|string|max:20|unique:akun,nis',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'nama.required' => 'Nama lengkap wajib diisi!',
            'username.required' => 'Username wajib diisi!',
            'username.unique' => 'Username sudah digunakan, silakan pilih username lain!',
            'nis.required' => 'NIS wajib diisi!',
            'nis.unique' => 'NIS sudah terdaftar akun!',
            'email.required' => 'Email wajib diisi!',
            'email.email' => 'Format email tidak valid!',
            'password.required' => 'Password wajib diisi!',
            'password.min' => 'Password minimal 6 karakter!',
            'password.confirmed' => 'Konfirmasi password tidak cocok!',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Pastikan data siswa ada di tabel siswa (karena foreign key nis -> siswa.nis)
            DB::table('siswa')->updateOrInsert(
                ['nis' => $request->nis],
                [
                    'nama' => $request->nama,
                    'email' => $request->email,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );

            // 2. Simpan akun ke tabel akun
            Akun::create([
                'nis' => $request->nis,
                'nama' => $request->nama,
                'role' => 'siswa',
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);
        });

        return redirect()->route('login')->with('success', 'Pendaftaran akun berhasil! Silakan masuk dengan akun Anda.');
    }

    /**
     * Proses login: cek username atau NIS & password di tabel akun.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username atau NIS wajib diisi!',
            'password.required' => 'Password wajib diisi!',
        ]);

        $loginInput = $request->username;

        // Cari akun berdasarkan username atau NIS
        $akun = Akun::where('username', $loginInput)
            ->orWhere('nis', $loginInput)
            ->first();

        if ($akun && Hash::check($request->password, $akun->password)) {
            Auth::login($akun);
            $request->session()->regenerate();
            return $this->redirectByRole();
        }

        return back()->withErrors([
            'login_error' => 'Username atau password salah. Silakan coba lagi!',
        ])->withInput(['username' => $request->username]);
    }

    /**
     * Arahkan pengguna ke dashboard sesuai role-nya.
     */
    private function redirectByRole()
    {
        $role = Auth::user()->role;

        if ($role === 'admin_sarana') {
            return redirect()->route('admin.dashboard');
        }

        if ($role === 'admin_sistem') {
            return redirect()->route('sistem.dashboard');
        }

        return redirect()->route('user.dashboard');
    }

    /**
     * Proses logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
