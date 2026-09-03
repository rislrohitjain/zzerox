@extends('layouts.admin')

@section('title', 'Create Category - Zerox Admin')
@section('page_title', 'Create Category')

@section('content')
<div class="card border-0 shadow-sm bg-white p-4">
    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-bold">Category Name</label>
                <input type="text" id="categoryNameInput" name="name" class="form-control" placeholder="e.g. Tablets" required value="{{ old('name') }}">
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">URL Slug (SEO Permalink)</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted small">/category/</span>
                    <input type="text" id="categorySlugInput" name="slug" class="form-control font-monospace" placeholder="tablets" value="{{ old('slug') }}">
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">Parent Category (Optional)</label>
                <select name="parent_id" class="form-select">
                    <option value="">None (Top-Level Parent)</option>
                    @foreach($parentCategories as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">Display Order</label>
                <input type="number" name="order" class="form-control" value="0">
            </div>

            <div class="col-md-8">
                <label class="form-label fw-bold">Category Image (Optional)</label>
                <input type="file" name="category_image" class="form-control" accept="image/*">
                <div class="form-text">Upload category banner/thumbnail image.</div>
            </div>

            <div class="col-12">
                <label class="form-label fw-bold"><i class="bi bi-pencil-square text-primary me-1"></i> Category Description (CKEditor)</label>
                <textarea id="editor-cat-description" name="description" class="form-control">{!! old('description') !!}</textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Meta Title (SEO)</label>
                <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Meta Description (SEO)</label>
                <input type="text" name="meta_description" class="form-control" value="{{ old('meta_description') }}">
            </div>

            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary px-4 me-2"><i class="bi bi-save me-1"></i> Save Category</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const nameInput = document.getElementById('categoryNameInput');
        const slugInput = document.getElementById('categorySlugInput');

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

        const el = document.querySelector('#editor-cat-description');
        if (el) {
            ClassicEditor.create(el).catch(error => {
                console.error('CKEditor Init Error:', error);
            });
        }
    });
</script>
@endsection
