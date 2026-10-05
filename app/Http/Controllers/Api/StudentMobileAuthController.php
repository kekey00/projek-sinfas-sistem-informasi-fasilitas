<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Akun;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentMobileAuthController extends Controller
{
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

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json(['message' => 'Berhasil keluar.']);
    }
}