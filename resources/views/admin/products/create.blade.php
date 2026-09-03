@extends('layouts.admin')

@section('title', 'Add New Product - Zerox Admin')
@section('page_title', 'Create Product')

@section('content')
<div class="card border-0 shadow-sm bg-white p-4">
    <form action="{{ route('admin.products.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Product Name</label>
                <input type="text" name="name" class="form-control" placeholder="e.g. Anavar 10mg" required value="{{ old('name') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">SKU Code</label>
                <input type="text" name="sku" class="form-control" placeholder="e.g. ZX-TAB-099" required value="{{ old('sku') }}">
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">Category</label>
                <select name="category_id" class="form-select" required>
                    <option value="">Select Category...</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">Dosage Form</label>
                <input type="text" name="dosage_form" class="form-control" placeholder="e.g. 10mg/tab" value="{{ old('dosage_form') }}">
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">Pack Size</label>
                <input type="text" name="pack_size" class="form-control" placeholder="e.g. 100 Tablets" value="{{ old('pack_size') }}">
            </div>

            <div class="col-12">
                <label class="form-label fw-bold">Overview Description</label>
                <textarea name="description" rows="3" class="form-control" required>{{ old('description') }}</textarea>
            </div>

            <div class="col-12">
                <label class="form-label fw-bold">Chemical Characteristics</label>
                <textarea name="chemical_characteristics" rows="4" class="form-control" placeholder="Formula, Molar Mass, HPLC purity specs...">{{ old('chemical_characteristics') }}</textarea>
            </div>

            <div class="col-12">
                <label class="form-label fw-bold">Side Effects</label>
                <textarea name="side_effects" rows="3" class="form-control" placeholder="Pharmacological safety notes...">{{ old('side_effects') }}</textarea>
            </div>

            <div class="col-12">
                <label class="form-label fw-bold">Administration & Uses</label>
                <textarea name="administration_uses" rows="3" class="form-control" placeholder="Dosage protocols, storage conditions...">{{ old('administration_uses') }}</textarea>
            </div>

            <div class="col-12">
                <div class="form-check">
                    <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" checked>
                    <label class="form-check-label fw-bold" for="is_active">Publish Product to Catalog</label>
                </div>
            </div>

            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary px-4 me-2"><i class="bi bi-save me-1"></i> Save Product</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection
