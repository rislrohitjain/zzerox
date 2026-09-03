@extends('layouts.admin')

@section('title', 'Site Settings - Zerox Admin')
@section('page_title', 'Dynamic Site Settings')

@section('content')
<div class="card border-0 shadow-sm bg-white p-4">
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        <ul class="nav nav-tabs fw-bold mb-4" id="settingsTabs" role="tablist">
            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#generalTab"><i class="bi bi-gear me-1"></i> General</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#contactTab"><i class="bi bi-telephone me-1"></i> Contact Details</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#seoTab"><i class="bi bi-search me-1"></i> SEO & Meta</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#bannerTab"><i class="bi bi-card-image me-1"></i> Hero Banners</a></li>
        </ul>

        <div class="tab-content" id="settingsTabContent">
            <!-- General Settings -->
            <div class="tab-pane fade show active" id="generalTab">
                <div class="mb-3">
                    <label class="form-label fw-bold">Site Title</label>
                    <input type="text" name="site_name" class="form-control" value="{{ \App\Models\SiteSetting::get('site_name', 'Zerox Pharmaceuticals Ltd') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Company Legal Name</label>
                    <input type="text" name="company_name" class="form-control" value="{{ \App\Models\SiteSetting::get('company_name', 'Zerox Pharmaceuticals Ltd') }}">
                </div>
            </div>

            <!-- Contact Settings -->
            <div class="tab-pane fade" id="contactTab">
                <div class="mb-3">
                    <label class="form-label fw-bold">Contact Telephone Hotline</label>
                    <input type="text" name="contact_phone" class="form-control" value="{{ \App\Models\SiteSetting::get('contact_phone', '+91 11 27023256') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Official Support Email</label>
                    <input type="email" name="contact_email" class="form-control" value="{{ \App\Models\SiteSetting::get('contact_email', 'support@zzerox.com') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Company Physical Address</label>
                    <textarea name="company_address" rows="3" class="form-control">{{ \App\Models\SiteSetting::get('company_address', 'Plot No. 42, Industrial Area Phase II, New Delhi, India - 110020') }}</textarea>
                </div>
            </div>

            <!-- SEO Settings -->
            <div class="tab-pane fade" id="seoTab">
                <div class="mb-3">
                    <label class="form-label fw-bold">Global Meta Title</label>
                    <input type="text" name="meta_title" class="form-control" value="{{ \App\Models\SiteSetting::get('meta_title') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Global Meta Description</label>
                    <textarea name="meta_description" rows="3" class="form-control">{{ \App\Models\SiteSetting::get('meta_description') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Google Analytics Container Snippet</label>
                    <textarea name="google_analytics" rows="4" class="form-control font-monospace" style="font-size: 0.85rem;">{{ \App\Models\SiteSetting::get('google_analytics') }}</textarea>
                </div>
            </div>

            <!-- Banner Settings -->
            <div class="tab-pane fade" id="bannerTab">
                <div class="mb-3">
                    <label class="form-label fw-bold">Hero Title Text</label>
                    <input type="text" name="hero_title" class="form-control" value="{{ \App\Models\SiteSetting::get('hero_title') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Hero Subtitle Text</label>
                    <textarea name="hero_subtitle" rows="3" class="form-control">{{ \App\Models\SiteSetting::get('hero_subtitle') }}</textarea>
                </div>
            </div>
        </div>

        <div class="mt-4 pt-3 border-top">
            <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-1"></i> Save All Settings</button>
        </div>
    </form>
</div>
@endsection
