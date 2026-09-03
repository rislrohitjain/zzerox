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

        if ($isMaintenance == '1' || $isMaintenance === 'true' || $isMaintenance === true) {
            // Allow admin routes and logged-in admins to bypass maintenance mode
            if ($request->is('admin*') || $request->is('login') || $request->is('logout')) {
                return $next($request);
            }

            if (Auth::check() && Auth::user()->isAdmin()) {
                return $next($request);
            }

            return response()->view('maintenance', [], 503);
        }

        return $next($request);
    }
}
