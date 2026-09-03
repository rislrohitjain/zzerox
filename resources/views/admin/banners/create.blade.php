@extends('layouts.admin')

@section('title', 'Add New Banner - Zerox Admin')
@section('page_title', 'Create Hero Banner')

@section('content')
<div class="card border-0 shadow-sm bg-white p-4">
    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Banner Title</label>
                <input type="text" name="title" class="form-control" placeholder="e.g. Home Banner" required value="{{ old('title') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Banner Subtitle / Quote</label>
                <input type="text" name="subtitle" class="form-control" placeholder="e.g. Working together for a healthier world." value="{{ old('subtitle') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Banner Image File</label>
                <input type="file" name="banner_image" class="form-control" required accept="image/*">
                <div class="form-text">Recommended size: 1920x600 px or high resolution landscape image.</div>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-bold">Button Text (Optional)</label>
                <input type="text" name="button_text" class="form-control" placeholder="e.g. See our products" value="{{ old('button_text') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label fw-bold">Button Link URL</label>
                <input type="text" name="button_url" class="form-control" placeholder="e.g. /category/tablets" value="{{ old('button_url') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label fw-bold">Display Order</label>
                <input type="number" name="order" class="form-control" value="1">
            </div>

            <div class="col-md-9 d-flex align-items-end">
                <div class="form-check">
                    <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" checked>
                    <label class="form-check-label fw-bold" for="is_active">Active (Visible on Front End)</label>
                </div>
            </div>

            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary px-4 me-2"><i class="bi bi-save me-1"></i> Save Banner</button>
                <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection
