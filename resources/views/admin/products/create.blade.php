@extends('layouts.admin')

@section('title', 'Add New Product - Zerox Admin')
@section('page_title', 'Create Product')

@section('content')
<div class="card border-0 shadow-sm bg-white p-4">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-bold">Product Name</label>
                <input type="text" id="productNameInput" name="name" class="form-control" placeholder="e.g. Anavar 10mg" required value="{{ old('name') }}">
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">URL Slug (SEO Permalink)</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted small">/product/</span>
                    <input type="text" id="productSlugInput" name="slug" class="form-control font-monospace" placeholder="anavar-10mg" value="{{ old('slug') }}">
                </div>
            </div>

            <div class="col-md-4">
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

            <!-- Main Product Image -->
            <div class="col-md-6">
                <label class="form-label fw-bold">Main Product Image</label>
                <input type="file" name="main_image" class="form-control" accept="image/*">
                <div class="form-text">Primary image shown on catalog & product card.</div>
            </div>

            <!-- Product Gallery Images -->
            <div class="col-md-6">
                <label class="form-label fw-bold">Product Image Gallery (Select Multiple)</label>
                <input type="file" name="gallery_images[]" class="form-control" accept="image/*" multiple>
                <div class="form-text">Select multiple images to create an interactive product gallery.</div>
            </div>

            <!-- Rich Text Editors with CKEditor -->
            <div class="col-12">
                <label class="form-label fw-bold"><i class="bi bi-pencil-square text-primary me-1"></i> Overview Description (CKEditor)</label>
                <textarea id="editor-description" name="description" class="form-control">{!! old('description') !!}</textarea>
            </div>

            <div class="col-12">
                <label class="form-label fw-bold"><i class="bi bi-flask text-success me-1"></i> Chemical Characteristics (CKEditor)</label>
                <textarea id="editor-chemical" name="chemical_characteristics" class="form-control" placeholder="Formula, Molar Mass, HPLC purity specs...">{!! old('chemical_characteristics') !!}</textarea>
            </div>

            <div class="col-12">
                <label class="form-label fw-bold"><i class="bi bi-exclamation-triangle text-danger me-1"></i> Side Effects (CKEditor)</label>
                <textarea id="editor-side-effects" name="side_effects" class="form-control" placeholder="Pharmacological safety notes...">{!! old('side_effects') !!}</textarea>
            </div>

            <div class="col-12">
                <label class="form-label fw-bold"><i class="bi bi-shield-check text-info me-1"></i> Administration & Uses (CKEditor)</label>
                <textarea id="editor-admin-uses" name="administration_uses" class="form-control" placeholder="Dosage protocols, storage conditions...">{!! old('administration_uses') !!}</textarea>
            </div>

            <div class="col-12">
                <div class="form-check">
                    <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" checked>
                    <label class="form-check-label fw-bold" for="is_active">Publish Product to Catalog</label>
                </div>
            </div>

            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary px-4 me-2"><i class="bi bi-save me-1"></i> Save Product & Gallery</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </div>
    </form>
</div>
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
