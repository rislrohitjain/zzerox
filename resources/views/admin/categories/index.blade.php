@extends('layouts.admin')

@section('title', 'Manage Categories - Zerox Admin')
@section('page_title', 'Category Tree Management')

@section('content')
<div class="card border-0 shadow-sm bg-white p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold m-0"><i class="bi bi-folder2-open text-primary me-2"></i> Categories ({{ $categories->total() }})</h5>
        <div>
            @if(request()->get('trashed') == '1')
                <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-secondary me-2">View Active Categories</a>
            @else
                <a href="{{ route('admin.categories.index', ['trashed' => 1]) }}" class="btn btn-sm btn-outline-danger me-2">View Soft-Deleted Categories</a>
            @endif
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary shadow-sm">
                <i class="bi bi-plus-lg me-1"></i> Add Category
            </a>
        </div>
    </div>

    <!-- Interactive Search & Type Filter Bar -->
    <div class="row g-2 mb-3 p-3 bg-light rounded border">
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                <input type="text" id="adminCategorySearch" class="form-control" placeholder="Search by Category Name or Slug...">
            </div>
        </div>
        <div class="col-md-4">
            <select id="adminCategoryTypeFilter" class="form-select">
                <option value="">Filter by Category Hierarchy (All)</option>
                <option value="Top-Level Parent">Top-Level Parents</option>
                <option value="Subcategory">Subcategories Only</option>
            </select>
        </div>
        <div class="col-md-2 text-end d-flex align-items-center justify-content-end">
            <span class="badge bg-white text-dark border py-2 px-3"><i class="bi bi-funnel text-primary me-1"></i> Live Filter</span>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle border" id="adminCategoriesTable">
            <thead class="table-light">
                <tr>
                    <th>Order</th>
                    <th>Image</th>
                    <th>Category Name</th>
                    <th>Slug</th>
                    <th>Parent Category</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $c)
                    <tr>
                        <td><span class="badge bg-light text-dark border">{{ $c->order }}</span></td>
                        <td>
                            @if($c->image_path)
                                <img src="{{ asset($c->image_path) }}" style="width: 50px; height: 50px; object-fit: cover;" class="rounded border">
                            @else
                                <span class="badge bg-light text-muted">No Image</span>
                            @endif
                        </td>
                        <td class="fw-bold text-dark">{{ $c->name }}</td>
                        <td><code class="text-info">{{ $c->slug }}</code></td>
                        <td>
                            @if($c->parent)
                                <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25">{{ $c->parent->name }}</span>
                            @else
                                <span class="badge bg-secondary">Top-Level Parent</span>
                            @endif
                        </td>
                        <td>
                            @if($c->trashed())
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">Soft Deleted</span>
                            @else
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">Active</span>
                            @endif
                        </td>
                        <td class="text-end">
                            @if($c->trashed())
                                <form action="{{ route('admin.categories.restore', $c->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-outline-success me-1"><i class="bi bi-arrow-counterclockwise"></i> Restore</button>
                                </form>
                                <form action="{{ route('admin.categories.forceDelete', $c->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Permanently remove category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-x-circle"></i> Permanent Delete</button>
                                </form>
                            @else
                                <a href="{{ route('admin.categories.edit', $c->id) }}" class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-pencil"></i> Edit</a>
                                <form action="{{ route('admin.categories.destroy', $c->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Soft delete category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Soft Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">No categories found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $categories->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById('adminCategorySearch');
        const typeFilter = document.getElementById('adminCategoryTypeFilter');
        const rows = document.querySelectorAll('#adminCategoriesTable tbody tr');

        function filterTable() {
            const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
            const type = typeFilter ? typeFilter.value.toLowerCase() : '';

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const matchesSearch = !query || text.includes(query);
                const matchesType = !type || (type === 'top-level parent' ? text.includes('top-level parent') : !text.includes('top-level parent'));

                if (matchesSearch && matchesType) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        if (searchInput) searchInput.addEventListener('keyup', filterTable);
        if (typeFilter) typeFilter.addEventListener('change', filterTable);
    });
</script>
@endsection
