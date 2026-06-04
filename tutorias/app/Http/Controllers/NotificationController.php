<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notificaciones = Notification::where('user_id', auth()->id())
            ->latest()
            ->paginate(20);

        return view('notificaciones.index', compact('notificaciones'));
    }

    public function unread()
    {
        $notificaciones = Notification::where('user_id', auth()->id())
            ->whereNull('read_at')
            ->latest()
            ->take(10)
            ->get();

        return response()->json([
            'count' => $notificaciones->count(),
            'notificaciones' => $notificaciones,
        ]);
    }

    public function stream()
    {
        $userId = auth()->id();

        if (!$userId) {
            return response('Unauthorized', 401);
        }

        $lastCheck = now()->subSeconds(30);

        return response()->stream(function () use ($userId, &$lastCheck) {
            while (true) {
                if (connection_aborted()) break;

                $notificaciones = Notification::where('user_id', $userId)
                    ->whereNull('read_at')
                    ->where('created_at', '>', $lastCheck)
                    ->latest()
                    ->take(5)
                    ->get();

                if ($notificaciones->isNotEmpty()) {
                    $lastCheck = now();
                    echo "data: " . json_encode([
                        'count' => $notificaciones->count(),
                        'notificaciones' => $notificaciones,
                    ]) . "\n\n";
                    ob_flush();
                    flush();
                }

                sleep(5);
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
            'X-Accel-Buffering' => 'no',
        ]);
    }

    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->update(['read_at' => now()]);

        if ($notification->related_type && $notification->related_id) {
            $model = $notification->related_type;
            if (class_exists($model)) {
                $related = $model::find($notification->related_id);
                if ($related) {
                    $route = $related instanceof \App\Models\Conversation
                        ? route('chat.show', $related)
                        : url("notificaciones/{$notification->id}/read");
                    return redirect($route);
                }
            }
        }

        return back();
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return back()->with('success', 'Todas las notificaciones marcadas como leídas.');
    }
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
