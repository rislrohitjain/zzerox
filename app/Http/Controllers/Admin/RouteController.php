<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

class RouteController extends Controller
{
    public function index()
    {
        // 1. Fetch all registered application routes
        $routes = [];
        foreach (Route::getRoutes() as $route) {
            $routes[] = [
                'methods' => implode(' | ', $route->methods()),
                'uri' => $route->uri(),
                'name' => $route->getName() ?? '-',
                'action' => is_string($route->getAction('uses')) ? $route->getAction('uses') : 'Closure',
                'middleware' => implode(', ', (array) $route->middleware()),
            ];
        }

        // 2. Fetch Database Tables & System Status
        $dbTables = [];
        $dbInfo = [
            'connection' => config('database.default'),
            'host' => config('database.connections.mysql.host'),
            'port' => config('database.connections.mysql.port'),
            'database' => config('database.connections.mysql.database'),
            'username' => config('database.connections.mysql.username'),
            'table_count' => 0,
            'total_rows' => 0,
            'total_size_mb' => 0,
        ];

        try {
            $rawTables = DB::select('SHOW TABLE STATUS');
            foreach ($rawTables as $table) {
                $dataSizeMb = round(($table->Data_length + $table->Index_length) / 1024 / 1024, 2);
                $dbTables[] = [
                    'name' => $table->Name,
                    'engine' => $table->Engine ?? 'InnoDB',
                    'rows' => $table->Rows ?? 0,
                    'data_size_mb' => $dataSizeMb,
                    'collation' => $table->Collation ?? 'utf8mb4_unicode_ci',
                ];
                $dbInfo['total_rows'] += ($table->Rows ?? 0);
                $dbInfo['total_size_mb'] += $dataSizeMb;
            }
            $dbInfo['table_count'] = count($dbTables);
        } catch (\Exception $e) {
            // Fallback if SHOW TABLE STATUS fails
        }

        return view('admin.routes.index', compact('routes', 'dbTables', 'dbInfo'));
    }
}
