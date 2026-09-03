@extends('layouts.admin')

@section('title', 'Site Performance & Speed - Zerox Admin')
@section('page_title', 'Backend Site Performance & Speed Manager')

@section('content')
<!-- System Performance Metrics Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.7rem;">DB Latency Benchmark</span>
                    <h3 class="fw-bold text-success m-0">{{ $metrics['db_latency_ms'] }} <small class="fs-6 text-muted">ms</small></h3>
                </div>
                <div class="p-3 bg-success bg-opacity-10 text-success rounded-circle">
                    <i class="bi bi-lightning-charge fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.7rem;">Peak Memory Usage</span>
                    <h3 class="fw-bold text-primary m-0">{{ $metrics['memory_peak_mb'] }} <small class="fs-6 text-muted">MB</small></h3>
                </div>
                <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-circle">
                    <i class="bi bi-cpu fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.7rem;">Disk Space Used</span>
                    <h3 class="fw-bold text-info m-0">{{ $metrics['disk_used_percent'] }}%</h3>
                    <small class="text-muted" style="font-size: 0.75rem;">{{ $metrics['disk_free_gb'] }} GB Free of {{ $metrics['disk_total_gb'] }} GB</small>
                </div>
                <div class="p-3 bg-info bg-opacity-10 text-info rounded-circle">
                    <i class="bi bi-hdd-network fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.7rem;">Cache Driver</span>
                    <h3 class="fw-bold text-dark m-0 text-uppercase">{{ $metrics['cache_driver'] }}</h3>
                    <small class="text-muted" style="font-size: 0.75rem;">{{ $metrics['db_connection'] }} Database</small>
                </div>
                <div class="p-3 bg-warning bg-opacity-10 text-warning rounded-circle">
                    <i class="bi bi-layers fs-3"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 1-Click Speed Optimization Actions Panel -->
<div class="card border-0 shadow-sm bg-white p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold m-0"><i class="bi bi-speedometer text-primary me-2"></i> 1-Click System Speed Optimization</h5>
            <small class="text-muted">Execute cache compilation, route indexing, view warm-up, and database index tuning.</small>
        </div>
        <form action="{{ route('admin.performance.optimize') }}" method="POST">
            @csrf
            <input type="hidden" name="action" value="optimize_all">
            <button type="submit" class="btn btn-warning text-dark fw-bold px-4 py-2 shadow-sm">
                <i class="bi bi-rocket-takeoff-fill me-1"></i> OPTIMIZE ALL (Speed Boost)
            </button>
        </form>
    </div>

    <div class="row g-3">
        <div class="col-md-3">
            <div class="p-3 border rounded bg-light text-center h-100 d-flex flex-column justify-content-between">
                <div>
                    <i class="bi bi-sliders fs-2 text-primary d-block mb-2"></i>
                    <h6 class="fw-bold mb-1">Configuration Cache</h6>
                    <small class="text-muted d-block mb-3">Re-compiles .env and config array into single opcode file.</small>
                </div>
                <form action="{{ route('admin.performance.optimize') }}" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="clear_config">
                    <button type="submit" class="btn btn-sm btn-outline-primary w-100">Rebuild Config Cache</button>
                </form>
            </div>
        </div>

        <div class="col-md-3">
            <div class="p-3 border rounded bg-light text-center h-100 d-flex flex-column justify-content-between">
                <div>
                    <i class="bi bi-signpost-split fs-2 text-info d-block mb-2"></i>
                    <h6 class="fw-bold mb-1">Route Cache</h6>
                    <small class="text-muted d-block mb-3">Compiles URL routes into instant lookup array.</small>
                </div>
                <form action="{{ route('admin.performance.optimize') }}" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="clear_routes">
                    <button type="submit" class="btn btn-sm btn-outline-info w-100">Re-Compile Routes</button>
                </form>
            </div>
        </div>

        <div class="col-md-3">
            <div class="p-3 border rounded bg-light text-center h-100 d-flex flex-column justify-content-between">
                <div>
                    <i class="bi bi-file-earmark-code fs-2 text-success d-block mb-2"></i>
                    <h6 class="fw-bold mb-1">Blade View Cache</h6>
                    <small class="text-muted d-block mb-3">Pre-compiles HTML Blade templates to eliminate runtime compilation.</small>
                </div>
                <form action="{{ route('admin.performance.optimize') }}" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="clear_views">
                    <button type="submit" class="btn btn-sm btn-outline-success w-100">Pre-Compile Blade Views</button>
                </form>
            </div>
        </div>

        <div class="col-md-3">
            <div class="p-3 border rounded bg-light text-center h-100 d-flex flex-column justify-content-between">
                <div>
                    <i class="bi bi-database-gear fs-2 text-warning d-block mb-2"></i>
                    <h6 class="fw-bold mb-1">Database Optimization</h6>
                    <small class="text-muted d-block mb-3">Runs table index analysis and flushes stale query caches.</small>
                </div>
                <form action="{{ route('admin.performance.optimize') }}" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="optimize_db">
                    <button type="submit" class="btn btn-sm btn-outline-warning text-dark w-100">Analyze & Optimize DB</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- System Status & Server Environment Details -->
<div class="card border-0 shadow-sm bg-white p-4">
    <h6 class="fw-bold mb-3"><i class="bi bi-info-circle text-secondary me-2"></i> System & Server Environment Diagnostic Details</h6>
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <tbody class="small">
                <tr>
                    <td class="bg-light fw-bold" style="width: 250px;">PHP Version</td>
                    <td class="font-monospace fw-bold text-primary">{{ $metrics['php_version'] }}</td>
                </tr>
                <tr>
                    <td class="bg-light fw-bold">Laravel Framework Version</td>
                    <td class="font-monospace fw-bold">{{ $metrics['laravel_version'] }}</td>
                </tr>
                <tr>
                    <td class="bg-light fw-bold">Web Server Environment</td>
                    <td class="font-monospace text-muted">{{ $metrics['server_software'] }}</td>
                </tr>
                <tr>
                    <td class="bg-light fw-bold">Configuration Caching Status</td>
                    <td>
                        @if($metrics['config_cached'])
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25"><i class="bi bi-check-circle me-1"></i> Active (Fastest)</span>
                        @else
                            <span class="badge bg-warning text-dark">Uncached</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="bg-light fw-bold">Route Indexing Status</td>
                    <td>
                        @if($metrics['routes_cached'])
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25"><i class="bi bi-check-circle me-1"></i> Active (Fastest)</span>
                        @else
                            <span class="badge bg-warning text-dark">Uncached</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
