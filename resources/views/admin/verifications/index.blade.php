@extends('layouts.admin')

@section('title', 'Manage Product Verifications - Zerox Admin')
@section('page_title', 'Product Verification Scratch Codes')

@section('content')
<div class="card border-0 shadow-sm bg-white p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold m-0"><i class="bi bi-qr-code text-primary me-2"></i> Security Codes ({{ $verifications->total() }})</h5>
        <a href="{{ route('admin.verifications.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Generate Batch Codes
        </a>
    </div>

    <!-- Interactive Search & Verification Status Filter Bar -->
    <div class="row g-2 mb-3 p-3 bg-light rounded border">
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                <input type="text" id="adminCodeSearch" class="form-control" placeholder="Search by Security Code, Batch Number, or Product Name...">
            </div>
        </div>
        <div class="col-md-4">
            <select id="adminCodeStatusFilter" class="form-select">
                <option value="">Filter Verification Status (All)</option>
                <option value="Verified">Verified Scans Only</option>
                <option value="Unused">Unused / Pending Codes</option>
            </select>
        </div>
        <div class="col-md-3 text-end d-flex align-items-center justify-content-end">
            <span class="badge bg-white text-dark border py-2 px-3"><i class="bi bi-funnel text-primary me-1"></i> Live Filter</span>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle border" id="adminVerificationsTable">
            <thead class="table-light">
                <tr>
                    <th>Security Code</th>
                    <th>Product</th>
                    <th>Batch Number</th>
                    <th>Status</th>
                    <th>Verified At</th>
                    <th>IP Address</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($verifications as $v)
                    <tr>
                        <td><span class="badge bg-dark font-monospace" style="font-size: 0.9rem;">{{ $v->security_code }}</span></td>
                        <td class="fw-bold text-dark">{{ $v->product->name ?? 'General Product' }}</td>
                        <td><span class="badge bg-light text-dark border">{{ $v->batch_number }}</span></td>
                        <td>
                            @if($v->is_verified)
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25"><i class="bi bi-check-circle-fill me-1"></i> Verified</span>
                            @else
                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25"><i class="bi bi-hourglass-split me-1"></i> Unused</span>
                            @endif
                        </td>
                        <td class="small text-muted">{{ $v->verified_at ? $v->verified_at->format('Y-m-d H:i') : '-' }}</td>
                        <td class="small text-muted font-monospace">{{ $v->ip_address ?? '-' }}</td>
                        <td class="text-end">
                            <form action="{{ route('admin.verifications.destroy', $v->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete code record?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">No verification codes generated yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $verifications->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById('adminCodeSearch');
        const statusFilter = document.getElementById('adminCodeStatusFilter');
        const rows = document.querySelectorAll('#adminVerificationsTable tbody tr');

        function filterTable() {
            const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
            const status = statusFilter ? statusFilter.value.toLowerCase() : '';

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const matchesSearch = !query || text.includes(query);
                const matchesStatus = !status || text.includes(status);

                if (matchesSearch && matchesStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        if (searchInput) searchInput.addEventListener('keyup', filterTable);
        if (statusFilter) statusFilter.addEventListener('change', filterTable);
    });
</script>
@endsection
