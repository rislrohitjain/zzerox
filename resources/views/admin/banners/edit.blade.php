@extends('layouts.admin')

@section('title', 'Edit Banner - Zerox Admin')
@section('page_title', 'Edit Banner: ' . $banner->title)

@section('content')
<div class="card border-0 shadow-sm bg-white p-4">
    <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Banner Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $banner->title) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Banner Subtitle / Quote</label>
                <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $banner->subtitle) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Change Banner Image (Optional)</label>
                <input type="file" name="banner_image" class="form-control" accept="image/*">
                @if($banner->image_path)
                    <div class="mt-2">
                        <small class="text-muted d-block">Current Image:</small>
                        <img src="{{ asset($banner->image_path) }}" style="height: 70px; object-fit: cover;" class="rounded border">
                    </div>
                @endif
            </div>

            <div class="col-md-3">
                <label class="form-label fw-bold">Button Text</label>
                <input type="text" name="button_text" class="form-control" value="{{ old('button_text', $banner->button_text) }}">
            </div>

            <div class="col-md-3">
                <label class="form-label fw-bold">Button Link URL</label>
                <input type="text" name="button_url" class="form-control" value="{{ old('button_url', $banner->button_url) }}">
            </div>

            <div class="col-md-3">
                <label class="form-label fw-bold">Display Order</label>
                <input type="number" name="order" class="form-control" value="{{ old('order', $banner->order) }}">
            </div>

            <div class="col-md-9 d-flex align-items-end">
                <div class="form-check">
                    <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" {{ $banner->is_active ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold" for="is_active">Active (Visible on Front End)</label>
                </div>
            </div>

            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary px-4 me-2"><i class="bi bi-save me-1"></i> Update Banner</button>
                <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection
