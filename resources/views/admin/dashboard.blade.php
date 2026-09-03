@extends('layouts.admin')

@section('title', 'Dashboard - Zerox Management')
@section('page_title', 'System Dashboard & Graphical Analytics')

@section('styles')
<style>
    .stat-card-link {
        text-decoration: none;
        display: block;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        border-radius: 12px;
        overflow: hidden;
    }
    .stat-card-link:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.18) !important;
    }
    .stat-card-body {
        padding: 1.25rem;
        color: #ffffff;
        position: relative;
    }
    .stat-card-footer {
        background: rgba(0, 0, 0, 0.15);
        padding: 0.5rem 1.25rem;
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.8rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
</style>
@endsection

@section('content')
<!-- Colorful Interactive KPI Stat Cards Grid with Direct Links -->
<div class="row g-3 mb-4">
    <!-- Total Products Card -->
    <div class="col-md-4 col-lg-2">
        <a href="{{ route('admin.products.index') }}" class="stat-card-link shadow-sm" style="background: linear-gradient(135deg, #6366f1, #4f46e5);">
            <div class="stat-card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-white-50 text-uppercase fw-bold" style="font-size: 0.7rem;">Total Products</span>
                    <h2 class="fw-bold text-white m-0 mt-1">{{ $stats['total_products'] }}</h2>
                </div>
                <div>
                    <i class="bi bi-capsule fs-1 text-white opacity-75"></i>
                </div>
            </div>
            <div class="stat-card-footer">
                <span>Manage Catalog</span>
                <i class="bi bi-arrow-right-short fs-5"></i>
            </div>
        </a>
    </div>

    <!-- Categories Card -->
    <div class="col-md-4 col-lg-2">
        <a href="{{ route('admin.categories.index') }}" class="stat-card-link shadow-sm" style="background: linear-gradient(135deg, #3b82f6, #2563eb);">
            <div class="stat-card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-white-50 text-uppercase fw-bold" style="font-size: 0.7rem;">Categories</span>
                    <h2 class="fw-bold text-white m-0 mt-1">{{ $stats['total_categories'] }}</h2>
                </div>
                <div>
                    <i class="bi bi-folder2-open fs-1 text-white opacity-75"></i>
                </div>
            </div>
            <div class="stat-card-footer">
                <span>Manage Categories</span>
                <i class="bi bi-arrow-right-short fs-5"></i>
            </div>
        </a>
    </div>

    <!-- Scratch Codes Card -->
    <div class="col-md-4 col-lg-2">
        <a href="{{ route('admin.verifications.index') }}" class="stat-card-link shadow-sm" style="background: linear-gradient(135deg, #10b981, #059669);">
            <div class="stat-card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-white-50 text-uppercase fw-bold" style="font-size: 0.7rem;">Scratch Codes</span>
                    <h2 class="fw-bold text-white m-0 mt-1">{{ $stats['total_verifications'] }}</h2>
                </div>
                <div>
                    <i class="bi bi-qr-code-scan fs-1 text-white opacity-75"></i>
                </div>
            </div>
            <div class="stat-card-footer">
                <span>Manage Security Codes</span>
                <i class="bi bi-arrow-right-short fs-5"></i>
            </div>
        </a>
    </div>

    <!-- Verified Scans Card -->
    <div class="col-md-4 col-lg-2">
        <a href="{{ route('admin.verifications.index') }}" class="stat-card-link shadow-sm" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
            <div class="stat-card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-white-50 text-uppercase fw-bold" style="font-size: 0.7rem;">Verified Scans</span>
                    <h2 class="fw-bold text-white m-0 mt-1">{{ $stats['verified_codes'] }}</h2>
                </div>
                <div>
                    <i class="bi bi-shield-check fs-1 text-white opacity-75"></i>
                </div>
            </div>
            <div class="stat-card-footer">
                <span>View Verified Logs</span>
                <i class="bi bi-arrow-right-short fs-5"></i>
            </div>
        </a>
    </div>

    <!-- Subscribers Card -->
    <div class="col-md-4 col-lg-2">
        <a href="{{ route('admin.subscribers.index') }}" class="stat-card-link shadow-sm" style="background: linear-gradient(135deg, #ec4899, #db2777);">
            <div class="stat-card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-white-50 text-uppercase fw-bold" style="font-size: 0.7rem;">Subscribers</span>
                    <h2 class="fw-bold text-white m-0 mt-1">{{ $stats['total_subscribers'] }}</h2>
                </div>
                <div>
                    <i class="bi bi-envelope-check fs-1 text-white opacity-75"></i>
                </div>
            </div>
            <div class="stat-card-footer">
                <span>View Subscribers</span>
                <i class="bi bi-arrow-right-short fs-5"></i>
            </div>
        </a>
    </div>

    <!-- System Users Card -->
    <div class="col-md-4 col-lg-2">
        @if(Auth::user() && Auth::user()->hasRole('admin'))
            <a href="{{ route('admin.users.index') }}" class="stat-card-link shadow-sm" style="background: linear-gradient(135deg, #06b6d4, #0891b2);">
        @else
            <div class="stat-card-link shadow-sm" style="background: linear-gradient(135deg, #06b6d4, #0891b2);">
        @endif
            <div class="stat-card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-white-50 text-uppercase fw-bold" style="font-size: 0.7rem;">System Users</span>
                    <h2 class="fw-bold text-white m-0 mt-1">{{ $stats['total_users'] }}</h2>
                </div>
                <div>
                    <i class="bi bi-people fs-1 text-white opacity-75"></i>
                </div>
            </div>
            <div class="stat-card-footer">
                <span>Manage User Roles</span>
                <i class="bi bi-arrow-right-short fs-5"></i>
            </div>
        @if(Auth::user() && Auth::user()->hasRole('admin'))
            </a>
        @else
            </div>
        @endif
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
