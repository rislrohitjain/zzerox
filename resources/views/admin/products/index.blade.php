@extends('layouts.admin')

@section('title', 'Manage Products - Zerox Admin')
@section('page_title', 'Products Management')

@section('content')
<div class="card border-0 shadow-sm bg-white p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold m-0"><i class="bi bi-capsule text-primary me-2"></i> All Products ({{ $products->total() }})</h5>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Add Product
        </a>
    </div>

    <!-- Interactive Filter & Search Bar -->
    <div class="row g-2 mb-3 p-3 bg-light rounded border">
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                <input type="text" id="adminProductSearch" class="form-control" placeholder="Search by Product Name or SKU code...">
            </div>
        </div>
        <div class="col-md-4">
            <select id="adminStatusFilter" class="form-select">
                <option value="">Filter by Status (All)</option>
                <option value="Active">Active (Published)</option>
                <option value="Disabled">Disabled</option>
            </select>
        </div>
        <div class="col-md-3 text-end d-flex align-items-center justify-content-end">
            <span class="badge bg-white text-dark border py-2 px-3"><i class="bi bi-funnel text-primary me-1"></i> Live Filter</span>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle border" id="adminProductsTable">
            <thead class="table-light">
                <tr>
                    <th>SKU</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Dosage Form</th>
                    <th>Pack Size</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $p)
                    <tr>
                        <td><span class="badge bg-dark font-monospace">{{ $p->sku }}</span></td>
                        <td class="fw-bold text-dark">{{ $p->name }}</td>
                        <td><span class="badge bg-light text-dark border">{{ $p->category->name ?? 'N/A' }}</span></td>
                        <td class="small">{{ $p->dosage_form }}</td>
                        <td class="small">{{ $p->pack_size }}</td>
                        <td>
                            @if($p->is_active)
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">Active</span>
                            @else
                                <span class="badge bg-secondary">Disabled</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.products.edit', $p->id) }}" class="btn btn-sm btn-outline-primary me-1" title="Edit Product"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.products.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Product"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">No products created yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $products->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById('adminProductSearch');
        const statusFilter = document.getElementById('adminStatusFilter');
        const rows = document.querySelectorAll('#adminProductsTable tbody tr');

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
