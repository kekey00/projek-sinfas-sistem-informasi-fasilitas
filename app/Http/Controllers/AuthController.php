<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
     * Proses login: cek username atau NIS & password di tabel akun.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username, NIS, atau NIP wajib diisi!',
            'password.required' => 'Password wajib diisi!',
        ]);

        $loginInput = $request->username;

        // Cari akun berdasarkan username, NIS, atau NIP
        $akun = Akun::where('username', $loginInput)
            ->orWhere('nis', $loginInput)
            ->orWhere('nip', $loginInput)
            ->first();

        if ($akun && Hash::check($request->password, $akun->password)) {
            Auth::login($akun);
            $request->session()->regenerate();
            return $this->redirectByRole();
        }

        return back()->withErrors([
            'login_error' => 'Username/NIS/NIP atau password salah. Silakan coba lagi!',
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
