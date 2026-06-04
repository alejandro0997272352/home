<?php

namespace App\Http\Middleware;

use App\Models\ActivityLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }

    public function terminate(Request $request, $response): void
    {
        if ($request->user() && $request->method() !== 'GET') {
            $actions = [
                'POST' => 'creación',
                'PUT' => 'actualización',
                'PATCH' => 'actualización',
                'DELETE' => 'eliminación',
            ];

            $action = $actions[$request->method()] ?? $request->method();

            $description = $action . ' en ' . $request->path();

            ActivityLog::log(
                $request->user()->id,
                $action,
                $description,
                $request
            );
        }
    }
}
