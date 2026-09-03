@extends('layouts.admin')

@section('title', 'Contact Messages - Zerox Admin')
@section('page_title', 'Contact Us Messages & Inquiries')

@section('content')
<div class="card border-0 shadow-sm bg-white p-4">
    <!-- Live Search & Status Filter Bar -->
    <form method="GET" action="{{ route('admin.contacts.index') }}" class="row g-3 mb-4 align-items-center">
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Search by sender name, email, subject, or message..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">All Message Statuses</option>
                <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Unread Only</option>
                <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Read Only</option>
            </select>
        </div>
        <div class="col-md-3 text-end">
            <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-counterclockwise me-1"></i> Reset Filters</a>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Sender Name</th>
                    <th>Email Address</th>
                    <th>Subject</th>
                    <th>Message Snippet</th>
                    <th>Received Date</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $msg)
                    <tr class="{{ !$msg->is_read ? 'table-warning bg-opacity-25' : '' }}">
                        <td class="fw-bold">{{ $msg->id }}</td>
                        <td>
                            <strong class="text-dark">{{ $msg->name }}</strong>
                            <small class="text-muted d-block font-monospace" style="font-size: 0.75rem;">IP: {{ $msg->ip_address ?? 'N/A' }}</small>
                        </td>
                        <td><a href="mailto:{{ $msg->email }}">{{ $msg->email }}</a></td>
                        <td><span class="fw-semibold text-primary">{{ $msg->subject }}</span></td>
                        <td>
                            <span class="text-muted text-truncate d-inline-block" style="max-width: 250px;" title="{{ $msg->message }}">
                                {{ $msg->message }}
                            </span>
                        </td>
                        <td><small class="text-secondary">{{ $msg->created_at->format('M d, Y h:i A') }}</small></td>
                        <td>
                            @if($msg->is_read)
                                <span class="badge bg-secondary">Read</span>
                            @else
                                <span class="badge bg-warning text-dark"><i class="bi bi-envelope-fill me-1"></i> New Unread</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <button type="button" class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#msgModal{{ $msg->id }}" title="View Full Message">
                                <i class="bi bi-eye"></i> Read
                            </button>

                            @if(!$msg->is_read)
                                <form action="{{ route('admin.contacts.read', $msg->id) }}" method="POST" class="d-inline me-1">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Mark as Read"><i class="bi bi-check2-all"></i></button>
                                </form>
                            @endif

                            <form action="{{ route('admin.contacts.destroy', $msg->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this contact message?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Message"><i class="bi bi-trash"></i></button>
                            </form>

                            <!-- Modal for Full Message View -->
                            <div class="modal fade text-start" id="msgModal{{ $msg->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-header-title fw-bold m-0"><i class="bi bi-envelope-open text-primary me-2"></i> Inbound Inquiry #{{ $msg->id }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <small class="text-muted d-block">From:</small>
                                                <strong class="text-dark fs-6">{{ $msg->name }}</strong> (&lt;<a href="mailto:{{ $msg->email }}">{{ $msg->email }}</a>&gt;)
                                            </div>
                                            <div class="mb-3">
                                                <small class="text-muted d-block">Subject:</small>
                                                <span class="fw-bold text-primary">{{ $msg->subject }}</span>
                                            </div>
                                            <div class="mb-3">
                                                <small class="text-muted d-block">Received At:</small>
                                                <span>{{ $msg->created_at->format('l, F j, Y \a\t g:i A') }} (IP: {{ $msg->ip_address ?? 'N/A' }})</span>
                                            </div>
                                            <div class="p-3 bg-light rounded border">
                                                <small class="text-muted d-block mb-1">Message Content:</small>
                                                <p class="m-0 text-dark" style="white-space: pre-wrap;">{{ $msg->message }}</p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            @if(!$msg->is_read)
                                                <form action="{{ route('admin.contacts.read', $msg->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-check2-all me-1"></i> Mark as Read</button>
                                                </form>
                                            @endif
                                            <a href="mailto:{{ $msg->email }}?subject=Re: {{ urlencode($msg->subject) }}" class="btn btn-primary btn-sm"><i class="bi bi-reply me-1"></i> Reply via Email</a>
                                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                            No contact inquiries found matching your filters.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $messages->links() }}
    </div>
</div>
@endsection
