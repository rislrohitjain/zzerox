@extends('layouts.admin')

@section('title', 'Routes & Database Inspector - Zerox Admin')
@section('page_title', 'System Routes & Database Inspector')

@section('content')
<!-- DB Overview Metric Badges -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.7rem;">Database Host</span>
                    <h5 class="fw-bold text-primary m-0 font-monospace">{{ $dbInfo['host'] }}:{{ $dbInfo['port'] }}</h5>
                </div>
                <div class="p-2 bg-primary bg-opacity-10 text-primary rounded">
                    <i class="bi bi-hdd-rack fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.7rem;">Active Database</span>
                    <h5 class="fw-bold text-success m-0 font-monospace">{{ $dbInfo['database'] }}</h5>
                </div>
                <div class="p-2 bg-success bg-opacity-10 text-success rounded">
                    <i class="bi bi-database fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.7rem;">DB Tables Count</span>
                    <h5 class="fw-bold text-dark m-0">{{ $dbInfo['table_count'] }} Tables</h5>
                </div>
                <div class="p-2 bg-info bg-opacity-10 text-info rounded">
                    <i class="bi bi-table fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.7rem;">Total Application Routes</span>
                    <h5 class="fw-bold text-warning text-dark m-0">{{ count($routes) }} Registered Routes</h5>
                </div>
                <div class="p-2 bg-warning bg-opacity-10 text-warning rounded">
                    <i class="bi bi-signpost-split fs-4"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Tabs Card -->
<div class="card border-0 shadow-sm bg-white p-4">
    <ul class="nav nav-tabs border-bottom mb-4" id="inspectorTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold" id="routes-tab" data-bs-toggle="tab" data-bs-target="#routes-pane" type="button" role="tab"><i class="bi bi-signpost-split text-primary me-2"></i> Application Routes List ({{ count($routes) }})</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold" id="database-tab" data-bs-toggle="tab" data-bs-target="#database-pane" type="button" role="tab"><i class="bi bi-database-fill-gear text-success me-2"></i> Database Tables Inspector ({{ $dbInfo['table_count'] }})</button>
        </li>
    </ul>

    <div class="tab-content" id="inspectorTabsContent">
        <!-- Routes Explorer Pane -->
        <div class="tab-pane fade show active" id="routes-pane" role="tabpanel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <input type="text" id="routeSearchInput" class="form-control w-50" placeholder="🔍 Search routes by URI, Name, or Controller Action...">
                <span class="badge bg-light text-dark border"><i class="bi bi-filter me-1"></i> Live Filter</span>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle border" id="routesTable">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 130px;">HTTP Method</th>
                            <th>URI Path</th>
                            <th>Route Name</th>
                            <th>Controller / Action</th>
                            <th>Middleware</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($routes as $r)
                            <tr>
                                <td>
                                    @if(str_contains($r['methods'], 'GET'))
                                        <span class="badge bg-primary">GET</span>
                                    @elseif(str_contains($r['methods'], 'POST'))
                                        <span class="badge bg-success">POST</span>
                                    @elseif(str_contains($r['methods'], 'PUT'))
                                        <span class="badge bg-warning text-dark">PUT</span>
                                    @elseif(str_contains($r['methods'], 'DELETE'))
                                        <span class="badge bg-danger">DELETE</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $r['methods'] }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ url($r['uri']) }}" target="_blank" class="fw-bold text-dark font-monospace text-decoration-none">
                                        /{{ ltrim($r['uri'], '/') }} <i class="bi bi-box-arrow-up-right small text-muted ms-1"></i>
                                    </a>
                                </td>
                                <td>
                                    @if($r['name'] !== '-')
                                        <span class="badge bg-light text-primary border font-monospace">{{ $r['name'] }}</span>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td class="small text-muted font-monospace">{{ Str::replace('App\\Http\\Controllers\\', '', $r['action']) }}</td>
                                <td class="small"><span class="badge bg-light text-dark border">{{ $r['middleware'] ?: 'web' }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Database Inspector Pane -->
        <div class="tab-pane fade" id="database-pane" role="tabpanel">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Table Name</th>
                            <th>Storage Engine</th>
                            <th>Total Records (Rows)</th>
                            <th>Data Size (MB)</th>
                            <th>Collation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dbTables as $tbl)
                            <tr>
                                <td class="fw-bold font-monospace text-primary"><i class="bi bi-table me-2 text-secondary"></i> {{ $tbl['name'] }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $tbl['engine'] }}</span></td>
                                <td class="fw-bold text-dark">{{ number_format($tbl['rows']) }}</td>
                                <td class="font-monospace">{{ $tbl['data_size_mb'] }} MB</td>
                                <td class="small text-muted">{{ $tbl['collation'] }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted">No database tables retrieved.</td></tr>
                        @endforelse
                    </tbody>
                    <tfoot class="table-light">
                        <tr class="fw-bold">
                            <td>Total ({{ count($dbTables) }} Tables)</td>
                            <td>-</td>
                            <td>{{ number_format($dbInfo['total_rows']) }} Total Rows</td>
                            <td>{{ number_format($dbInfo['total_size_mb'], 2) }} MB Total Size</td>
                            <td>-</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById('routeSearchInput');
        const rows = document.querySelectorAll('#routesTable tbody tr');

        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const term = searchInput.value.toLowerCase();
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(term) ? '' : 'none';
                });
            });
        }
    });
</script>
@endsection
