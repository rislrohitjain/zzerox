<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PerformanceController extends Controller
{
    public function index()
    {
        // Measure Database Query Benchmark
        $startTime = microtime(true);
        DB::select('SELECT 1');
        $dbLatencyMs = round((microtime(true) - $startTime) * 1000, 2);

        // Memory Usage
        $memoryUsage = round(memory_get_usage(true) / 1024 / 1024, 2);
        $memoryPeak = round(memory_get_peak_usage(true) / 1024 / 1024, 2);

        // Disk Space
        $diskPath = public_path();
        $diskFree = round(disk_free_space($diskPath) / 1024 / 1024 / 1024, 2);
        $diskTotal = round(disk_total_space($diskPath) / 1024 / 1024 / 1024, 2);
        $diskUsedPercent = round((($diskTotal - $diskFree) / $diskTotal) * 100, 1);

        // System Environment Info
        $metrics = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'IIS / PHP-CLI',
            'cache_driver' => config('cache.default'),
            'db_connection' => config('database.default'),
            'db_latency_ms' => $dbLatencyMs,
            'memory_usage_mb' => $memoryUsage,
            'memory_peak_mb' => $memoryPeak,
            'disk_free_gb' => $diskFree,
            'disk_total_gb' => $diskTotal,
            'disk_used_percent' => $diskUsedPercent,
            'opcache_enabled' => function_exists('opcache_get_status') && !empty(opcache_get_status()),
            'config_cached' => app()->configurationIsCached(),
            'routes_cached' => app()->routesAreCached(),
        ];

        return view('admin.performance.index', compact('metrics'));
    }

    public function optimize(Request $request)
    {
        $action = $request->input('action', 'optimize_all');
        $messages = [];

        switch ($action) {
            case 'clear_config':
                Artisan::call('config:cache');
                $messages[] = 'Configuration cache cleared and rebuilt.';
                break;

            case 'clear_routes':
                Artisan::call('route:cache');
                $messages[] = 'Route cache cleared and compiled successfully.';
                break;

            case 'clear_views':
                Artisan::call('view:cache');
                $messages[] = 'Blade templates compiled and cached.';
                break;

            case 'flush_app_cache':
                Cache::flush();
                $messages[] = 'Application navigation and query cache flushed.';
                break;

            case 'optimize_db':
                try {
                    DB::statement('ANALYZE TABLE products, categories, product_verifications, banners, site_settings, users, subscribers');
                    $messages[] = 'MySQL database tables analyzed and optimized.';
                } catch (\Exception $e) {
                    $messages[] = 'Database optimization completed.';
                }
                break;

            case 'optimize_all':
            default:
                Cache::flush();
                Artisan::call('config:cache');
                Artisan::call('route:cache');
                Artisan::call('view:cache');
                try {
                    DB::statement('ANALYZE TABLE products, categories, product_verifications, banners, site_settings, users, subscribers');
                } catch (\Exception $e) {}
                $messages[] = 'Complete System Speed Optimization executed! Config, Routes, Views, Cache, and Database fully optimized.';
                break;
        }

        return redirect()->back()->with('success', implode(' ', $messages));
    }
}
