@extends('layouts.admin')

@section('title', 'Manage Banners - Zerox Admin')
@section('page_title', 'Hero Banners Management')

@section('content')
<div class="card border-0 shadow-sm bg-white p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold m-0"><i class="bi bi-images text-primary me-2"></i> Banners ({{ count($banners) }})</h5>
        <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add New Banner
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Order</th>
                    <th>Preview</th>
                    <th>Title & Subtitle</th>
                    <th>Button Text / Link</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($banners as $b)
                    <tr>
                        <td><span class="badge bg-light text-dark border">{{ $b->order }}</span></td>
                        <td>
                            <img src="{{ asset($b->image_path) }}" alt="Banner" style="width: 120px; height: 60px; object-fit: cover;" class="rounded border">
                        </td>
                        <td>
                            <strong class="d-block text-dark">{{ $b->title }}</strong>
                            <small class="text-muted">{{ $b->subtitle ?? 'No subtitle' }}</small>
                        </td>
                        <td>
                            @if($b->button_text)
                                <span class="badge bg-dark">{{ $b->button_text }}</span>
                                <small class="d-block text-muted">{{ $b->button_url }}</small>
                            @else
                                <span class="text-muted small">None</span>
                            @endif
                        </td>
                        <td>
                            @if($b->is_active)
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">Active</span>
                            @else
                                <span class="badge bg-secondary">Disabled</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.banners.edit', $b->id) }}" class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.banners.destroy', $b->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this banner?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">No banners created yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
