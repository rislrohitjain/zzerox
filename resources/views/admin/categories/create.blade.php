@extends('layouts.admin')

@section('title', 'Create Category - Zerox Admin')
@section('page_title', 'Create Category')

@section('content')
<div class="card border-0 shadow-sm bg-white p-4">
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Category Name</label>
                <input type="text" name="name" class="form-control" placeholder="e.g. Tablets" required value="{{ old('name') }}">
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

            <div class="col-md-2">
                <label class="form-label fw-bold">Display Order</label>
                <input type="number" name="order" class="form-control" value="0">
            </div>

            <div class="col-12">
                <label class="form-label fw-bold">Description</label>
                <textarea name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
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
