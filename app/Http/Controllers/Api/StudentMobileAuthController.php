<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Akun;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Controller Autentikasi API Seluler Siswa (Sanctum Token Auth)
 *
 * Mengelola otentikasi REST API untuk aplikasi mobile kesiswaan SINFAS:
 * - Login siswa menggunakan identifier (Username / NIS) dan Password.
 * - Mengembalikan Bearer Token Sanctum ('sinfas-mobile') untuk sesi API.
 * - Menghapus token saat pengguna keluar dari aplikasi seluler (logout).
 */
class StudentMobileAuthController extends Controller
{
    /**
     * Memproses otentikasi login siswa untuk aplikasi seluler dan menerbitkan token Sanctum.
     *
     * @param  \Illuminate\Http\Request  $request  Input JSON berisi 'identifier' (username/NIS) dan 'password'.
     * @return \Illuminate\Http\JsonResponse Respon JSON berisi Bearer Token dan data ringkas profil siswa.
     */
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'identifier' => ['required', 'string', 'max:100'],
            'password' => ['required', 'string'],
        ]);

        $akun = Akun::query()
            ->where(function ($query) use ($validated) {
                $query->where('username', $validated['identifier'])
                    ->orWhere('nis', $validated['identifier']);
            })
            ->first();

        if (!$akun || !Hash::check($validated['password'], $akun->password)) {
            return response()->json(['message' => 'Username/NIS atau password salah.'], 401);
        }

        if ($akun->role !== 'siswa' || !$akun->nis) {
            return response()->json(['message' => 'Aplikasi mobile hanya tersedia untuk akun siswa.'], 403);
        }

        return response()->json([
            'data' => [
                'token' => $akun->createToken('sinfas-mobile')->plainTextToken,
                'user' => [
                    'nama' => $akun->nama,
                    'nis' => $akun->nis,
                ],
            ],
        ]);
    }

    /**
     * Menghapus personal access token Sanctum yang sedang aktif saat pengguna logout dari aplikasi mobile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json(['message' => 'Berhasil keluar.']);
    }
}