<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use App\Models\Siswa;
use App\Models\InputAspirasi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function stats()
    {
        $stats = [
            'total_aspirasi' => Aspirasi::count(),
            'total_siswa' => Siswa::count(),
            'status_counts' => [
                'menunggu' => Aspirasi::where('status', 'Menunggu')->count(),
                'proses' => Aspirasi::where('status', 'Proses')->count(),
                'selesai' => Aspirasi::where('status', 'Selesai')->count(),
            ],
            'terbaru' => InputAspirasi::with(['siswa', 'kategori', 'aspirasi'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get()
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}
