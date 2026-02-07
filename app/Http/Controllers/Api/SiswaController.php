<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index()
    {
        return response()->json(Siswa::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|max:10|unique:siswas,nis',
            'kelas' => 'required|string|max:10',
            'password' => 'required|string|min:6',
        ]);

        $siswa = Siswa::create([
            'nis' => $request->nis,
            'kelas' => $request->kelas,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'Siswa berhasil ditambahkan',
            'data' => $siswa
        ], 201);
    }

    public function update(Request $request, $nis)
    {
        $siswa = Siswa::findOrFail($nis);

        $request->validate([
            'kelas' => 'required|string|max:10',
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'kelas' => $request->kelas,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $siswa->update($data);

        return response()->json([
            'message' => 'Siswa berhasil diupdate',
            'data' => $siswa
        ]);
    }

    public function destroy($nis)
    {
        Siswa::destroy($nis);
        return response()->json([
            'message' => 'Siswa berhasil dihapus'
        ]);
    }
}
