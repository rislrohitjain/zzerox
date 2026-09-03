@extends('layouts.admin')

@section('title', 'Manage Subscribers - Zerox Admin')
@section('page_title', 'Newsletter Subscribers Management')

@section('content')
<div class="card border-0 shadow-sm bg-white p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold m-0"><i class="bi bi-envelope-check text-primary me-2"></i> Subscribers ({{ $subscribers->total() }})</h5>
        <div>
            @if(request()->get('trashed') == '1')
                <a href="{{ route('admin.subscribers.index') }}" class="btn btn-sm btn-outline-secondary">View Active Subscribers</a>
            @else
                <a href="{{ route('admin.subscribers.index', ['trashed' => 1]) }}" class="btn btn-sm btn-outline-danger">View Soft-Deleted Subscribers</a>
            @endif
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Email Address</th>
                    <th>IP Address</th>
                    <th>Subscribed At</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subscribers as $sub)
                    <tr>
                        <td class="fw-bold"><i class="bi bi-envelope text-info me-2"></i>{{ $sub->email }}</td>
                        <td><code class="text-muted">{{ $sub->ip_address ?? 'N/A' }}</code></td>
                        <td class="small text-muted">{{ $sub->subscribed_at ? $sub->subscribed_at->format('Y-m-d H:i') : $sub->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            @if($sub->trashed())
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">Soft Deleted</span>
                            @elseif($sub->is_active)
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">Subscribed</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td class="text-end">
                            @if($sub->trashed())
                                <form action="{{ route('admin.subscribers.restore', $sub->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-outline-success me-1"><i class="bi bi-arrow-counterclockwise"></i> Restore</button>
                                </form>
                                <form action="{{ route('admin.subscribers.forceDelete', $sub->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Permanently remove subscriber?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-x-circle"></i> Permanent Delete</button>
                                </form>
                            @else
                                <form action="{{ route('admin.subscribers.destroy', $sub->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Soft delete this subscriber?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Soft Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">No subscribers found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $subscribers->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
