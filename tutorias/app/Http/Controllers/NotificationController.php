<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notificaciones = Notification::where('user_id', auth()->id())
            ->recent()
            ->paginate(20);

        return view('notificaciones.index', compact('notificaciones'));
    }

    public function unread()
    {
        $notificaciones = Notification::where('user_id', auth()->id())
            ->unread()
            ->recent()
            ->take(10)
            ->get();

        $count = Notification::where('user_id', auth()->id())
            ->unread()
            ->count();

        return response()->json([
            'notificaciones' => $notificaciones,
            'count' => $count,
        ]);
    }

    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->markAsRead();

        if ($notification->url) {
            return redirect($notification->url);
        }

        return back();
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', auth()->id())
            ->unread()
            ->update(['read_at' => now()]);

        return back()->with('success', 'Todas las notificaciones marcadas como leídas.');
    }
}
