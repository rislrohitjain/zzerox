@extends('layouts.admin')

@section('title', 'Dashboard - Zerox Management')
@section('page_title', 'System Dashboard Overview')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase fw-bold">Total Products</span>
                    <h2 class="fw-bold text-dark m-0">{{ $stats['total_products'] }}</h2>
                </div>
                <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-circle">
                    <i class="bi bi-capsule fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase fw-bold">Categories</span>
                    <h2 class="fw-bold text-dark m-0">{{ $stats['total_categories'] }}</h2>
                </div>
                <div class="p-3 bg-info bg-opacity-10 text-info rounded-circle">
                    <i class="bi bi-folder2-open fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase fw-bold">Security Codes</span>
                    <h2 class="fw-bold text-dark m-0">{{ $stats['total_verifications'] }}</h2>
                </div>
                <div class="p-3 bg-warning bg-opacity-10 text-warning rounded-circle">
                    <i class="bi bi-qr-code fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase fw-bold">Verified Scans</span>
                    <h2 class="fw-bold text-success m-0">{{ $stats['verified_codes'] }}</h2>
                </div>
                <div class="p-3 bg-success bg-opacity-10 text-success rounded-circle">
                    <i class="bi bi-shield-check fs-3"></i>
                </div>
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
