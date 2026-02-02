<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function loginAdmin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $admin = Admin::where('username', $request->username)->first();

        if (! $admin || ! Hash::check($request->password, $admin->password)) {
            throw ValidationException::withMessages([
                'username' => ['Kredensial yang diberikan salah.'],
            ]);
        }

        $token = $admin->createToken('admin-token', ['role:admin'])->plainTextToken;

        return response()->json([
            'message' => 'Login Berhasil (Admin)',
            'token' => $token,
            'user' => $admin,
            'role' => 'admin'
        ]);
    }

    public function loginSiswa(Request $request)
    {
        $request->validate([
            'nis' => 'required',
            'password' => 'required',
        ]);

        $siswa = Siswa::where('nis', $request->nis)->first();

        if (! $siswa || ! Hash::check($request->password, $siswa->password)) {
            throw ValidationException::withMessages([
                'nis' => ['Kredensial yang diberikan salah.'],
            ]);
        }

        $token = $siswa->createToken('siswa-token', ['role:siswa'])->plainTextToken;

        return response()->json([
            'message' => 'Login Berhasil (Siswa)',
            'token' => $token,
            'user' => $siswa,
            'role' => 'siswa'
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout Berhasil'
        ]);
    }
}
