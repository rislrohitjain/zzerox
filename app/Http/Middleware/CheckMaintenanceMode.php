<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SiteSetting;

class CheckMaintenanceMode
{
    public function handle(Request $request, Closure $next)
    {
        $isMaintenance = SiteSetting::get('site_under_maintenance', '0');

        if ($isMaintenance == '1' || $isMaintenance === 'true' || $isMaintenance === true || $isMaintenance === 1) {
            // 1. Always allow Admin Panel, Login, and Logout routes
            if ($request->is('admin*') || $request->is('login') || $request->is('logout')) {
                return $next($request);
            }

            // 2. Allow any logged-in Admin or Operator user to browse the site while in maintenance mode
            if (Auth::check() && (Auth::user()->hasRole(['admin', 'operator1', 'operator2']) || Auth::user()->isAdmin())) {
                return $next($request);
            }

            // 3. For API endpoints, return JSON maintenance response
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status' => 'maintenance',
                    'message' => 'Zerox Pharmaceuticals web portal is currently undergoing scheduled maintenance.',
                ], 503);
            }

            // 4. For regular visitors, show full-page Maintenance view with 503 status
            return response()->view('maintenance', [], 503);
        }

        return $next($request);
    }
}
