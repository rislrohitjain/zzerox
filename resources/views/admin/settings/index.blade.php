@extends('layouts.admin')

@section('title', 'Site Settings - Zerox Admin')
@section('page_title', 'Dynamic System & Site Settings')

@section('content')
<div class="card border-0 shadow-sm bg-white p-4">
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <ul class="nav nav-tabs fw-bold mb-4" id="settingsTabs" role="tablist">
            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#generalTab"><i class="bi bi-gear me-1"></i> General & System State</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#mediaTab"><i class="bi bi-image me-1"></i> Logo & Favicon</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#contactTab"><i class="bi bi-geo-alt me-1"></i> Contact & Location Map</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#seoTab"><i class="bi bi-search me-1"></i> SEO & Meta</a></li>
        </ul>

        <div class="tab-content" id="settingsTabContent">
            <!-- General & System State -->
            <div class="tab-pane fade show active" id="generalTab">
                <div class="card bg-light border-warning mb-4">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fw-bold text-dark mb-1"><i class="bi bi-tools text-warning me-2"></i> Maintenance Mode</h6>
                            <small class="text-secondary">When enabled, visitors will see the maintenance screen. Logged-in admins can still browse and access the admin panel.</small>
                        </div>
                        <div class="form-check form-switch fs-4">
                            <input class="form-check-input" type="checkbox" name="site_under_maintenance" id="maintenanceSwitch" value="1" {{ ($settings['site_under_maintenance'] ?? '0') == '1' ? 'checked' : '' }}>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Site Title</label>
                    <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name'] ?? 'Zerox Pharmaceuticals' }}">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Company Legal Name</label>
                    <input type="text" name="company_name" class="form-control" value="{{ $settings['company_name'] ?? 'Zerox Pharmaceuticals Ltd' }}">
                </div>
            </div>

            <!-- Media: Logo & Favicon -->
            <div class="tab-pane fade" id="mediaTab">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="p-3 border rounded bg-light">
                            <label class="form-label fw-bold">Upload Header & Footer Logo</label>
                            <input type="file" name="site_logo" class="form-control" accept="image/*">
                            @if(isset($settings['site_logo']))
                                <div class="mt-2">
                                    <small class="text-muted d-block mb-1">Current Logo:</small>
                                    <img src="{{ asset($settings['site_logo']) }}" style="height: 45px; background: #000; padding: 5px;" class="rounded border">
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 border rounded bg-light">
                            <label class="form-label fw-bold">Upload Favicon Icon (.png / .ico)</label>
                            <input type="file" name="site_favicon" class="form-control" accept="image/*">
                            @if(isset($settings['site_favicon']))
                                <div class="mt-2">
                                    <small class="text-muted d-block mb-1">Current Favicon:</small>
                                    <img src="{{ asset($settings['site_favicon']) }}" style="height: 32px;" class="rounded border">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact & Location Map Pin -->
            <div class="tab-pane fade" id="contactTab">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Contact Telephone Hotline</label>
                        <input type="text" name="contact_phone" class="form-control" value="{{ $settings['contact_phone'] ?? '+91 11 27023256' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Official Support Email</label>
                        <input type="email" name="contact_email" class="form-control" value="{{ $settings['contact_email'] ?? 'support@zzerox.com' }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Company Physical Address</label>
                        <textarea name="company_address" rows="2" class="form-control">{{ $settings['company_address'] ?? 'Plot No. 42, Industrial Area Phase II, New Delhi, India - 110020' }}</textarea>
                    </div>

                    <div class="col-12 mt-4">
                        <h6 class="fw-bold border-bottom pb-2"><i class="bi bi-geo-alt-fill text-danger me-2"></i> Interactive Location Map Settings</h6>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Location Pin Latitude</label>
                        <input type="text" name="map_latitude" class="form-control" placeholder="28.535516" value="{{ $settings['map_latitude'] ?? '28.535516' }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Location Pin Longitude</label>
                        <input type="text" name="map_longitude" class="form-control" placeholder="77.261021" value="{{ $settings['map_longitude'] ?? '77.261021' }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Map Zoom Level</label>
                        <input type="number" name="map_zoom" class="form-control" value="{{ $settings['map_zoom'] ?? '14' }}">
                    </div>
                </div>
            </div>

            <!-- SEO Settings -->
            <div class="tab-pane fade" id="seoTab">
                <div class="mb-3">
                    <label class="form-label fw-bold">Global Meta Title</label>
                    <input type="text" name="meta_title" class="form-control" value="{{ $settings['meta_title'] ?? '' }}">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Global Meta Description</label>
                    <textarea name="meta_description" rows="3" class="form-control">{{ $settings['meta_description'] ?? '' }}</textarea>
                </div>
            </div>
        </div>

        <div class="mt-4 pt-3 border-top">
            <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-1"></i> Save All Settings</button>
        </div>
    </form>
</div>
@endsection
