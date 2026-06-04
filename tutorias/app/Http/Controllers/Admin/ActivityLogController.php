<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        if (request()->wantsJson()) {
            $html = view('admin.partials.activity-table', compact('logs'))->render();
            return response()->json([
                'html' => $html,
                'total' => $logs->total(),
                'page' => $logs->currentPage(),
                'pages' => $logs->lastPage(),
            ]);
        }

        return view('admin.actividad', compact('logs'));
    }
}
