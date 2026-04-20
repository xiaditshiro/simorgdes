<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;

class MaintenanceMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $isMaintenanceMode = Setting::get('maintenance_mode', 'false') === 'true';

        if ($isMaintenanceMode) {
            $user = $request->user();

            // Only Super Admin can bypass maintenance mode
            if (!$user || !$user->hasRole('super_admin')) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Sistem sedang dalam mode perawatan.'], 503);
                }
                return response()->view('errors.maintenance', [], 503);
            }
        }

        return $next($request);
    }
}
