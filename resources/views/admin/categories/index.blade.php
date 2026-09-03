@extends('layouts.admin')

@section('title', 'Manage Categories - Zerox Admin')
@section('page_title', 'Category Tree Management')

@section('content')
<div class="card border-0 shadow-sm bg-white p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold m-0"><i class="bi bi-folder2-open text-primary me-2"></i> Categories</h5>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add Category
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Order</th>
                    <th>Category Name</th>
                    <th>Slug</th>
                    <th>Parent Category</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $c)
                    <tr>
                        <td><span class="badge bg-light text-dark border">{{ $c->order }}</span></td>
                        <td class="fw-bold">{{ $c->name }}</td>
                        <td><code class="text-info">{{ $c->slug }}</code></td>
                        <td>
                            @if($c->parent)
                                <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25">{{ $c->parent->name }}</span>
                            @else
                                <span class="badge bg-secondary">Top-Level Parent</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.categories.edit', $c->id) }}" class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.categories.destroy', $c->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete category? All sub-categories will be cascade removed.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">No categories created yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $categories->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
