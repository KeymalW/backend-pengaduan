<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use App\Models\InputAspirasi;
use App\Models\Siswa;
use Illuminate\Http\Request;

class AspirasiController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        $query = Aspirasi::with(['inputAspirasi.siswa', 'kategori']);

        if ($user instanceof Siswa) {
            $query->whereHas('inputAspirasi', function($q) use ($user) {
                $q->where('nis', $user->nis);
            });
        }

        return response()->json($query->orderBy('created_at', 'desc')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required|exists:kategoris,id_kategori',
            'lokasi' => 'required|string|max:50',
            'ket' => 'required|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = $request->user();

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('foto', 'public');
        }

        // Create Input Aspirasi
        $input = InputAspirasi::create([
            'nis' => $user->nis,
            'id_kategori' => $request->id_kategori,
            'lokasi' => $request->lokasi,
            'ket' => $request->ket,
            'foto' => $fotoPath,
        ]);

        // Automatically create record in Aspirasi table
        $aspirasi = Aspirasi::create([
            'id_pelaporan' => $input->id_pelaporan,
            'id_kategori' => $request->id_kategori,
            'status' => 'Menunggu',
            'feedback' => null,
        ]);

        return response()->json([
            'message' => 'Aspirasi berhasil dikirim',
            'data' => $aspirasi->load('inputAspirasi')
        ], 201);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Proses,Selesai',
            'feedback' => 'nullable|string',
        ]);

        $aspirasi = Aspirasi::findOrFail($id);
        $aspirasi->update([
            'status' => $request->status,
            'feedback' => $request->feedback,
        ]);

        return response()->json([
            'message' => 'Status aspirasi berhasil diupdate',
            'data' => $aspirasi
        ]);
    }
}
