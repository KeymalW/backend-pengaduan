<?php

namespace App\Http\Controllers\Api\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function stats(Request $request)
    {
        $user = $request->user();
        
        $query = Aspirasi::whereHas('inputAspirasi', function($q) use ($user) {
            $q->where('nis', $user->nis);
        });

        $stats = [
            'total' => (clone $query)->count(),
            'menunggu' => (clone $query)->where('status', 'Menunggu')->count(),
            'proses' => (clone $query)->where('status', 'Proses')->count(),
            'selesai' => (clone $query)->where('status', 'Selesai')->count(),
            'unread_notifications' => $user->unreadNotifications()->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}

