<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function stats(Request $request)
    {
        // Admin sees everything
        $query = Aspirasi::query();

        // Optional: Add filters for stats if needed in the future
        
        $stats = [
            'total' => (clone $query)->count(),
            'menunggu' => (clone $query)->where('status', 'Menunggu')->count(),
            'proses' => (clone $query)->where('status', 'Proses')->count(),
            'selesai' => (clone $query)->where('status', 'Selesai')->count(),
        ];

        return response()->json($stats);
    }
}
