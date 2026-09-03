@extends('layouts.admin')

@section('title', 'Edit Product - Zerox Admin')
@section('page_title', 'Edit Product: ' . $product->name)

@section('content')
<div class="card border-0 shadow-sm bg-white p-4">
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-bold">Product Name</label>
                <input type="text" id="productNameInput" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">URL Slug (SEO Permalink)</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted small">/product/</span>
                    <input type="text" id="productSlugInput" name="slug" class="form-control font-monospace" value="{{ old('slug', $product->slug) }}" required>
                </div>
            </div>

            <div class="col-md-4">
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

            <!-- Main Image Upload -->
            <div class="col-md-6">
                <label class="form-label fw-bold">Main Product Image</label>
                <input type="file" name="main_image" class="form-control" accept="image/*">
                @if($product->image_path)
                    <div class="mt-2">
                        <small class="text-muted d-block">Current Main Image:</small>
                        <img src="{{ asset($product->image_path) }}" style="height: 70px; object-fit: contain;" class="rounded border">
                    </div>
                @endif
            </div>

            <!-- Upload Additional Gallery Images -->
            <div class="col-md-6">
                <label class="form-label fw-bold">Add Additional Gallery Images</label>
                <input type="file" name="gallery_images[]" class="form-control" accept="image/*" multiple>
                <div class="form-text">Select multiple images to append to the product gallery.</div>
            </div>

            <!-- Current Gallery Images Display -->
            @if(isset($product->images) && count($product->images) > 0)
                <div class="col-12 border p-3 rounded bg-light">
                    <label class="form-label fw-bold d-block">Current Product Gallery Images</label>
                    <div class="d-flex flex-wrap gap-3">
                        @foreach($product->images as $gImg)
                            <div class="text-center p-2 bg-white border rounded">
                                <img src="{{ asset($gImg->image_path) }}" style="width: 80px; height: 80px; object-fit: cover;" class="rounded d-block mb-1">
                                <a href="{{ route('admin.products.images.destroy', $gImg->id) }}" class="btn btn-sm btn-outline-danger py-0 px-2" onclick="event.preventDefault(); if(confirm('Delete gallery image?')) document.getElementById('del-img-form-{{ $gImg->id }}').submit();"><i class="bi bi-trash"></i> Delete</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Rich Text Editors with CKEditor -->
            <div class="col-12">
                <label class="form-label fw-bold"><i class="bi bi-pencil-square text-primary me-1"></i> Overview Description (CKEditor)</label>
                <textarea id="editor-description" name="description" class="form-control">{!! old('description', $product->description) !!}</textarea>
            </div>

            <div class="col-12">
                <label class="form-label fw-bold"><i class="bi bi-flask text-success me-1"></i> Chemical Characteristics (CKEditor)</label>
                <textarea id="editor-chemical" name="chemical_characteristics" class="form-control">{!! old('chemical_characteristics', $product->chemical_characteristics) !!}</textarea>
            </div>

            <div class="col-12">
                <label class="form-label fw-bold"><i class="bi bi-exclamation-triangle text-danger me-1"></i> Side Effects (CKEditor)</label>
                <textarea id="editor-side-effects" name="side_effects" class="form-control">{!! old('side_effects', $product->side_effects) !!}</textarea>
            </div>

            <div class="col-12">
                <label class="form-label fw-bold"><i class="bi bi-shield-check text-info me-1"></i> Administration & Uses (CKEditor)</label>
                <textarea id="editor-admin-uses" name="administration_uses" class="form-control">{!! old('administration_uses', $product->administration_uses) !!}</textarea>
            </div>

            <div class="col-12">
                <div class="form-check">
                    <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" {{ $product->is_active ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold" for="is_active">Publish Product to Catalog</label>
                </div>
            </div>

            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary px-4 me-2"><i class="bi bi-save me-1"></i> Update Product & Gallery</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </div>
    </form>
</div>

<!-- Hidden Delete Image Forms -->
@if(isset($product->images))
    @foreach($product->images as $gImg)
        <form id="del-img-form-{{ $gImg->id }}" action="{{ route('admin.products.images.destroy', $gImg->id) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endforeach
@endif
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Auto-slug generator function
        const nameInput = document.getElementById('productNameInput');
        const slugInput = document.getElementById('productSlugInput');

        if (nameInput && slugInput) {
            nameInput.addEventListener('input', function() {
                if (!slugInput.dataset.userEdited) {
                    slugInput.value = nameInput.value.toLowerCase()
                        .trim()
                        .replace(/[^\w\s-]/g, '')
                        .replace(/[\s_-]+/g, '-')
                        .replace(/^-+|-+$/g, '');
                }
            });
            slugInput.addEventListener('input', function() {
                slugInput.dataset.userEdited = "true";
            });
        }

        // Initialize CKEditors
        const editors = ['#editor-description', '#editor-chemical', '#editor-side-effects', '#editor-admin-uses'];
        editors.forEach(selector => {
            const el = document.querySelector(selector);
            if (el) {
                ClassicEditor.create(el).catch(error => {
                    console.error('CKEditor Init Error:', error);
                });
            }
        });
    });
</script>
@endsection
