@extends('layouts.admin')

@section('title', 'Batch Generate Security Codes - Zerox Admin')
@section('page_title', 'Generate Security Scratch Codes')

@section('content')
<div class="card border-0 shadow-sm bg-white p-4" style="max-width: 600px;">
    <form action="{{ route('admin.verifications.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-bold">Select Product</label>
            <select name="product_id" class="form-select" required>
                <option value="">Select Product...</option>
                @foreach($products as $p)
                    <option value="{{ $p->id }}">{{ $p->name }} (SKU: {{ $p->sku }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Batch Number</label>
            <input type="text" name="batch_number" class="form-control" placeholder="e.g. ZX-2026-B9" required>
        </div>

        <div class="mb-4">
            <label class="form-label fw-bold">Number of Scratch Codes to Generate</label>
            <input type="number" name="count" class="form-control" value="10" min="1" max="100" required>
            <div class="form-text">Codes will be generated in ZX-XXXX-XXXX format and associated with the selected batch.</div>
        </div>

        <button type="submit" class="btn btn-primary px-4 me-2"><i class="bi bi-gear-fill me-1"></i> Generate Codes</button>
        <a href="{{ route('admin.verifications.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </form>
</div>
@endsection
