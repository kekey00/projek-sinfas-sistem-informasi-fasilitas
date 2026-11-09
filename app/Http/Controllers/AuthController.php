<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Controller Autentikasi Pengguna & Manajemen Sesi
 *
 * Mengelola gerbang masuk (login multi-pengidentifikasi) dan keluar (logout) sistem:
 * - Fleksibilitas login menggunakan Username, NIS (Siswa), atau NIP (Pegawai).
 * - Redirect cerdas sesuai role: 'admin_sarana', 'admin_sistem', atau 'siswa'.
 * - Proteksi regenerasi sesi dan token CSRF saat login & logout.
 */
class AuthController extends Controller
{
    /**
     * Menampilkan antarmuka formulir login.
     *
     * Jika sesi pengguna sudah aktif, otomatis dialihkan ke dashboard sesuai role.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
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
     * Memproses verifikasi kredensial login pengguna.
     *
     * @param  \Illuminate\Http\Request  $request  Input form login (username/NIS/NIP dan password).
     * @return \Illuminate\Http\RedirectResponse  Redirect ke dashboard role atau kembali dengan pesan error.
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
     * Mengarahkan pengguna ke dashboard yang sesuai dengan peran (role) hak aksesnya.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    private function redirectByRole(): \Illuminate\Http\RedirectResponse
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
     * Memproses keluar sistem (logout), memusnahkan sesi aktif, dan mereset token CSRF.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse Redirect kembali ke halaman login.
     */
    public function logout(Request $request): \Illuminate\Http\RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
