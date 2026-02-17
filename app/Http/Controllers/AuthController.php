<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

                if ($user->role !== 'admin') {
                    return response()->json(['message' => 'Login Admin Berhasil','role' => 'admin']);
                }

            return response()->json(['message' => 'Login Siswa Berhasil','role' => 'siswa']);
        }

        return response()->json(['message' => 'Email atau password salah.'], 401);
    }
}
