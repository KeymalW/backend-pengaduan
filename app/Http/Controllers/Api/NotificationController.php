<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = $request->user()->notifications;
        return response()->json([
            'success' => true,
            'data' => $notifications
        ]);
    }

    public function unread(Request $request)
    {
        $notifications = $request->user()->unreadNotifications;
        return response()->json([
            'success' => true,
            'data' => $notifications
        ]);
    }

    public function markAsRead(Request $request, $id)
    {
        $notification = $request->user()->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
            return response()->json([
                'success' => true,
                'message' => 'Notifikasi ditandai sudah dibaca'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Notifikasi tidak ditemukan'
        ], 404);
    }

    public function markAllAsRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();
        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi ditandai sudah dibaca'
        ]);
    }
}
