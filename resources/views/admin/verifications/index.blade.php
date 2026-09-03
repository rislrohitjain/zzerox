@extends('layouts.admin')

@section('title', 'Manage Product Verifications - Zerox Admin')
@section('page_title', 'Product Verification Scratch Codes')

@section('content')
<div class="card border-0 shadow-sm bg-white p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold m-0"><i class="bi bi-qr-code text-primary me-2"></i> Security Codes ({{ $verifications->total() }})</h5>
        <a href="{{ route('admin.verifications.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Generate Batch Codes
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
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
                        <td class="fw-bold">{{ $v->product->name ?? 'General Product' }}</td>
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
