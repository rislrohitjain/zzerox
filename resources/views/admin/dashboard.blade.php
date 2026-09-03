@extends('layouts.admin')

@section('title', 'Dashboard - Zerox Management')
@section('page_title', 'System Dashboard & Graphical Analytics')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-2">
        <div class="card border-0 shadow-sm p-3 bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.7rem;">Total Products</span>
                    <h3 class="fw-bold text-dark m-0">{{ $stats['total_products'] }}</h3>
                </div>
                <div class="p-2 bg-primary bg-opacity-10 text-primary rounded-circle">
                    <i class="bi bi-capsule fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card border-0 shadow-sm p-3 bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.7rem;">Categories</span>
                    <h3 class="fw-bold text-dark m-0">{{ $stats['total_categories'] }}</h3>
                </div>
                <div class="p-2 bg-info bg-opacity-10 text-info rounded-circle">
                    <i class="bi bi-folder2-open fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card border-0 shadow-sm p-3 bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.7rem;">Scratch Codes</span>
                    <h3 class="fw-bold text-dark m-0">{{ $stats['total_verifications'] }}</h3>
                </div>
                <div class="p-2 bg-warning bg-opacity-10 text-warning rounded-circle">
                    <i class="bi bi-qr-code fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card border-0 shadow-sm p-3 bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.7rem;">Verified Scans</span>
                    <h3 class="fw-bold text-success m-0">{{ $stats['verified_codes'] }}</h3>
                </div>
                <div class="p-2 bg-success bg-opacity-10 text-success rounded-circle">
                    <i class="bi bi-shield-check fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card border-0 shadow-sm p-3 bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.7rem;">Subscribers</span>
                    <h3 class="fw-bold text-primary m-0">{{ $stats['total_subscribers'] }}</h3>
                </div>
                <div class="p-2 bg-primary bg-opacity-10 text-primary rounded-circle">
                    <i class="bi bi-envelope-check fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card border-0 shadow-sm p-3 bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.7rem;">Users</span>
                    <h3 class="fw-bold text-dark m-0">{{ $stats['total_users'] }}</h3>
                </div>
                <div class="p-2 bg-secondary bg-opacity-10 text-secondary rounded-circle">
                    <i class="bi bi-people fs-4"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Graphical Presentation Section (Chart.js) -->
<div class="row g-4 mb-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm bg-white p-4">
            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-bar-chart-fill text-primary me-2"></i> Security Scratch Codes Distribution by Batch</h6>
            <div style="height: 260px;">
                <canvas id="batchChartCanvas"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card border-0 shadow-sm bg-white p-4">
            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-pie-chart-fill text-info me-2"></i> Products Distribution by Category</h6>
            <div style="height: 260px;">
                <canvas id="categoryChartCanvas"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm bg-white p-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-clock-history text-info me-2"></i> Recent Verification Checks</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Security Code</th>
                            <th>Product</th>
                            <th>Batch</th>
                            <th>Verified At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentVerifications as $ver)
                            <tr>
                                <td><span class="badge bg-dark font-monospace">{{ $ver->security_code }}</span></td>
                                <td class="fw-bold">{{ $ver->product->name ?? 'General' }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $ver->batch_number }}</span></td>
                                <td class="small text-muted">{{ $ver->verified_at ? $ver->verified_at->diffForHumans() : 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted">No verifications logged yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card border-0 shadow-sm bg-white p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold m-0"><i class="bi bi-plus-circle text-primary me-2"></i> Latest Products</h5>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus me-1"></i> Add New</a>
            </div>
            <ul class="list-group list-group-flush">
                @foreach($latestProducts as $p)
                    <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                        <div>
                            <strong class="d-block text-dark">{{ $p->name }}</strong>
                            <small class="text-muted">{{ $p->category->name ?? 'Category' }} | SKU: {{ $p->sku }}</small>
                        </div>
                        <a href="{{ route('admin.products.edit', $p->id) }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-pencil"></i></a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Chart 1: Bar Chart for Batch Security Codes
        const batchCtx = document.getElementById('batchChartCanvas').getContext('2d');
        new Chart(batchCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($batchLabels) !!},
                datasets: [{
                    label: 'Security Codes Generated',
                    data: {!! json_encode($batchData) !!},
                    backgroundColor: 'rgba(56, 189, 248, 0.7)',
                    borderColor: 'rgba(56, 189, 248, 1)',
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });

        // Chart 2: Doughnut Chart for Category Products
        const catCtx = document.getElementById('categoryChartCanvas').getContext('2d');
        new Chart(catCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($catLabels) !!},
                datasets: [{
                    data: {!! json_encode($catData) !!},
                    backgroundColor: [
                        '#0284c7',
                        '#0d9488',
                        '#eab308',
                        '#8b5cf6',
                        '#ec4899'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    });
</script>
@endsection
