@extends('layouts.admin')

@section('title', 'Edit Product - Zerox Admin')
@section('page_title', 'Edit Product: ' . $product->name)

@section('content')
<div class="card border-0 shadow-sm bg-white p-4">
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Product Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">SKU Code</label>
                <input type="text" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}" required>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">Category</label>
                <select name="category_id" class="form-select" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">Dosage Form</label>
                <input type="text" name="dosage_form" class="form-control" value="{{ old('dosage_form', $product->dosage_form) }}">
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">Pack Size</label>
                <input type="text" name="pack_size" class="form-control" value="{{ old('pack_size', $product->pack_size) }}">
            </div>

            <div class="col-12">
                <label class="form-label fw-bold">Overview Description</label>
                <textarea name="description" rows="3" class="form-control" required>{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="col-12">
                <label class="form-label fw-bold">Chemical Characteristics</label>
                <textarea name="chemical_characteristics" rows="4" class="form-control">{{ old('chemical_characteristics', $product->chemical_characteristics) }}</textarea>
            </div>

            <div class="col-12">
                <label class="form-label fw-bold">Side Effects</label>
                <textarea name="side_effects" rows="3" class="form-control">{{ old('side_effects', $product->side_effects) }}</textarea>
            </div>

            <div class="col-12">
                <label class="form-label fw-bold">Administration & Uses</label>
                <textarea name="administration_uses" rows="3" class="form-control">{{ old('administration_uses', $product->administration_uses) }}</textarea>
            </div>

            <div class="col-12">
                <div class="form-check">
                    <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" {{ $product->is_active ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold" for="is_active">Publish Product to Catalog</label>
                </div>
            </div>

            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary px-4 me-2"><i class="bi bi-save me-1"></i> Update Product</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection
