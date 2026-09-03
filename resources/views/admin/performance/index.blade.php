@extends('layouts.admin')

@section('title', 'Site Performance & Speed - Zerox Admin')
@section('page_title', 'Backend Site Performance & Speed Manager')

@section('styles')
<style>
    .metric-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        cursor: pointer;
    }
    .metric-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08) !important;
    }
    .tooltip-inner {
        max-width: 280px;
        text-align: left;
        padding: 8px 12px;
        font-size: 0.8rem;
    }
</style>
@endsection

@section('content')
<!-- System Performance Metrics Cards with Interactive Tooltips & Colors -->
<div class="row g-4 mb-4">
    <!-- DB Latency Benchmark -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 bg-white metric-card" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="<strong class='text-warning'>Database Latency:</strong><br>Time taken to execute live MySQL benchmark query.<br><span class='badge bg-success mt-1'>Optimal Performance (&lt; 5ms)</span>">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.7rem;">DB Latency Benchmark <i class="bi bi-info-circle text-success ms-1"></i></span>
                    <h3 class="fw-bold text-success m-0">{{ $metrics['db_latency_ms'] }} <small class="fs-6 text-muted">ms</small></h3>
                    <small class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 mt-1" style="font-size: 0.68rem;"><i class="bi bi-check-circle me-1"></i> Fast SQL Response</small>
                </div>
                <div class="p-3 bg-success bg-opacity-10 text-success rounded-circle">
                    <i class="bi bi-lightning-charge fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Peak Memory Usage -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 bg-white metric-card" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="<strong class='text-primary'>Memory Allocation:</strong><br>Peak RAM consumed during request execution.<br><span class='badge bg-primary mt-1'>Efficient Memory Footprint</span>">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.7rem;">Peak Memory Usage <i class="bi bi-info-circle text-primary ms-1"></i></span>
                    <h3 class="fw-bold text-primary m-0">{{ $metrics['memory_peak_mb'] }} <small class="fs-6 text-muted">MB</small></h3>
                    <small class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 mt-1" style="font-size: 0.68rem;"><i class="bi bi-cpu me-1"></i> Low RAM Footprint</small>
                </div>
                <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-circle">
                    <i class="bi bi-cpu fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Disk Space Used -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 bg-white metric-card" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="<strong class='text-info'>Disk Storage Details:</strong><br>Storage usage for uploads & application files.<br><span class='badge bg-info text-dark mt-1'>{{ $metrics['disk_free_gb'] }} GB Available</span>">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.7rem;">Disk Space Used <i class="bi bi-info-circle text-info ms-1"></i></span>
                    <h3 class="fw-bold text-info m-0">{{ $metrics['disk_used_percent'] }}%</h3>
                    <small class="text-muted d-block mt-1" style="font-size: 0.75rem;"><strong>{{ $metrics['disk_free_gb'] }} GB</strong> Free of {{ $metrics['disk_total_gb'] }} GB</small>
                </div>
                <div class="p-3 bg-info bg-opacity-10 text-info rounded-circle">
                    <i class="bi bi-hdd-network fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Cache & Database Driver -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 bg-white metric-card" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="<strong class='text-warning'>Cache Engine:</strong><br>High-speed file caching active in project files.<br><span class='badge bg-warning text-dark mt-1'>File Cache Active</span>">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.7rem;">Cache Driver <i class="bi bi-info-circle text-warning ms-1"></i></span>
                    <h3 class="fw-bold text-dark m-0 text-uppercase">{{ $metrics['cache_driver'] }}</h3>
                    <small class="badge bg-warning bg-opacity-15 text-dark border border-warning mt-1" style="font-size: 0.68rem;"><i class="bi bi-database me-1"></i> {{ strtoupper($metrics['db_connection']) }} Connected</small>
                </div>
                <div class="p-3 bg-warning bg-opacity-10 text-warning rounded-circle">
                    <i class="bi bi-layers fs-3"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 1-Click Speed Optimization Actions Panel with Color Badges & Tooltips -->
<div class="card border-0 shadow-sm bg-white p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold m-0"><i class="bi bi-speedometer text-primary me-2"></i> 1-Click System Speed Optimization</h5>
            <small class="text-muted">Execute cache compilation, route indexing, view warm-up, and database index tuning.</small>
        </div>
        <form action="{{ route('admin.performance.optimize') }}" method="POST">
            @csrf
            <input type="hidden" name="action" value="optimize_all">
            <button type="submit" class="btn btn-warning text-dark fw-bold px-4 py-2 shadow-sm" data-bs-toggle="tooltip" data-bs-placement="left" title="Executes comprehensive 1-click speed boost across Config, Routes, Blade Views & Database indexes!">
                <i class="bi bi-rocket-takeoff-fill me-1"></i> OPTIMIZE ALL (Speed Boost)
            </button>
        </form>
    </div>

    <div class="row g-3">
        <!-- Config Cache Box -->
        <div class="col-md-3">
            <div class="p-3 border border-primary border-opacity-25 rounded bg-primary bg-opacity-10 text-center h-100 d-flex flex-column justify-content-between metric-card" data-bs-toggle="tooltip" data-bs-placement="top" title="Recompiles .env and config/*.php into a single PHP opcode array for 0ms filesystem reads.">
                <div>
                    <i class="bi bi-sliders fs-2 text-primary d-block mb-2"></i>
                    <h6 class="fw-bold mb-1 text-primary">Configuration Cache</h6>
                    <small class="text-secondary d-block mb-3" style="font-size: 0.78rem;">Re-compiles .env and config array into single opcode file.</small>
                </div>
                <form action="{{ route('admin.performance.optimize') }}" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="clear_config">
                    <button type="submit" class="btn btn-sm btn-primary w-100 fw-bold"><i class="bi bi-arrow-repeat me-1"></i> Rebuild Config Cache</button>
                </form>
            </div>
        </div>

        <!-- Route Cache Box -->
        <div class="col-md-3">
            <div class="p-3 border border-info border-opacity-25 rounded bg-info bg-opacity-10 text-center h-100 d-flex flex-column justify-content-between metric-card" data-bs-toggle="tooltip" data-bs-placement="top" title="Generates an indexed lookup tree for all application routes, bypassing route file parsing.">
                <div>
                    <i class="bi bi-signpost-split fs-2 text-info d-block mb-2"></i>
                    <h6 class="fw-bold mb-1 text-info">Route Cache</h6>
                    <small class="text-secondary d-block mb-3" style="font-size: 0.78rem;">Compiles URL routes into instant lookup array.</small>
                </div>
                <form action="{{ route('admin.performance.optimize') }}" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="clear_routes">
                    <button type="submit" class="btn btn-sm btn-info text-white w-100 fw-bold"><i class="bi bi-signpost me-1"></i> Re-Compile Routes</button>
                </form>
            </div>
        </div>

        <!-- Blade View Cache Box -->
        <div class="col-md-3">
            <div class="p-3 border border-success border-opacity-25 rounded bg-success bg-opacity-10 text-center h-100 d-flex flex-column justify-content-between metric-card" data-bs-toggle="tooltip" data-bs-placement="top" title="Pre-compiles all .blade.php view files to static PHP for instant HTML rendering.">
                <div>
                    <i class="bi bi-file-earmark-code fs-2 text-success d-block mb-2"></i>
                    <h6 class="fw-bold mb-1 text-success">Blade View Cache</h6>
                    <small class="text-secondary d-block mb-3" style="font-size: 0.78rem;">Pre-compiles HTML Blade templates to eliminate runtime compilation.</small>
                </div>
                <form action="{{ route('admin.performance.optimize') }}" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="clear_views">
                    <button type="submit" class="btn btn-sm btn-success w-100 fw-bold"><i class="bi bi-file-code me-1"></i> Pre-Compile Views</button>
                </form>
            </div>
        </div>

        <!-- Database Optimization Box -->
        <div class="col-md-3">
            <div class="p-3 border border-warning border-opacity-50 rounded bg-warning bg-opacity-10 text-center h-100 d-flex flex-column justify-content-between metric-card" data-bs-toggle="tooltip" data-bs-placement="top" title="Performs MySQL index rebuilding (ANALYZE TABLE) and purges stale database query buffers.">
                <div>
                    <i class="bi bi-database-gear fs-2 text-warning d-block mb-2"></i>
                    <h6 class="fw-bold mb-1 text-dark">Database Optimization</h6>
                    <small class="text-secondary d-block mb-3" style="font-size: 0.78rem;">Runs table index analysis and flushes stale query caches.</small>
                </div>
                <form action="{{ route('admin.performance.optimize') }}" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="optimize_db">
                    <button type="submit" class="btn btn-sm btn-warning text-dark w-100 fw-bold"><i class="bi bi-tools me-1"></i> Analyze & Optimize DB</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Section Toggle Header -->
<div class="d-flex justify-content-end mb-2">
    <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#diagnosticDetailsCollapse" aria-expanded="false" aria-controls="diagnosticDetailsCollapse">
        <i class="bi bi-sliders me-1"></i> Toggle Server Diagnostic Details
    </button>
</div>

<!-- System Status & Server Environment Details (Hidden/Collapsed by default) -->
<div class="collapse" id="diagnosticDetailsCollapse">
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
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Initialize all Bootstrap tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endsection
