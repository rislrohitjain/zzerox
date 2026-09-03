@extends('layouts.admin')

@section('title', 'Site Settings - Zerox Admin')
@section('page_title', 'Dynamic System & Site Settings')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #adminPickerMap {
        height: 380px;
        width: 100%;
        border-radius: 8px;
        border: 2px solid #e2e8f0;
        margin-top: 15px;
    }
</style>
@endsection

@section('content')
<div class="card border-0 shadow-sm bg-white p-4">
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <ul class="nav nav-tabs fw-bold mb-4" id="settingsTabs" role="tablist">
            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#generalTab"><i class="bi bi-gear me-1"></i> General & System State</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#mediaTab"><i class="bi bi-image me-1"></i> Logo & Favicon</a></li>
            <li class="nav-item"><a class="nav-link" id="contactTabLink" data-bs-toggle="tab" href="#contactTab"><i class="bi bi-geo-alt me-1"></i> Contact & Location Map</a></li>
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

            <!-- Media: Header Logo, Footer Logo & Favicon Icon -->
            <div class="tab-pane fade" id="mediaTab">
                <div class="row g-4">
                    <!-- Header Logo Upload -->
                    <div class="col-md-4">
                        <div class="p-3 border rounded bg-light h-100">
                            <label class="form-label fw-bold"><i class="bi bi-layout-header text-primary me-1"></i> Upload Header Logo Real Image</label>
                            <input type="file" name="site_logo_header" class="form-control" accept="image/*">
                            <div class="form-text">Main top header brand logo.</div>
                            <div class="mt-3">
                                <small class="text-muted d-block mb-1">Current Header Logo:</small>
                                <img src="{{ asset($settings['site_logo_header'] ?? ($settings['site_logo'] ?? 'img/logo.png')) }}" style="max-height: 50px; max-width: 100%; background: #000; padding: 6px;" class="rounded border">
                            </div>
                        </div>
                    </div>

                    <!-- Footer Logo Upload -->
                    <div class="col-md-4">
                        <div class="p-3 border rounded bg-light h-100">
                            <label class="form-label fw-bold"><i class="bi bi-layout-sidebar-reverse text-success me-1"></i> Upload Footer Logo Real Image</label>
                            <input type="file" name="site_logo_footer" class="form-control" accept="image/*">
                            <div class="form-text">Bottom footer brand logo.</div>
                            <div class="mt-3">
                                <small class="text-muted d-block mb-1">Current Footer Logo:</small>
                                <img src="{{ asset($settings['site_logo_footer'] ?? ($settings['site_logo'] ?? 'img/logo.png')) }}" style="max-height: 50px; max-width: 100%; background: #000; padding: 6px;" class="rounded border">
                            </div>
                        </div>
                    </div>

                    <!-- Favicon Upload -->
                    <div class="col-md-4">
                        <div class="p-3 border rounded bg-light h-100">
                            <label class="form-label fw-bold"><i class="bi bi-globe text-info me-1"></i> Upload Favicon Icon (.png / .ico)</label>
                            <input type="file" name="site_favicon" class="form-control" accept="image/*">
                            <div class="form-text">Browser tab icon.</div>
                            <div class="mt-3">
                                <small class="text-muted d-block mb-1">Current Favicon:</small>
                                <img src="{{ asset($settings['site_favicon'] ?? 'favicon.ico') }}" style="height: 36px; width: 36px; object-fit: contain;" class="rounded border p-1 bg-white">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact & Interactive Location Map Pin Picker -->
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
                        <h6 class="fw-bold border-bottom pb-2"><i class="bi bi-geo-alt-fill text-danger me-2"></i> Interactive Location Pin Picker Map</h6>
                        <small class="text-muted d-block mb-2">Click anywhere on the map or drag the pin marker to automatically set the exact location coordinates.</small>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Location Pin Latitude</label>
                        <input type="text" id="mapLatInput" name="map_latitude" class="form-control font-monospace" placeholder="28.535516" value="{{ $settings['map_latitude'] ?? '28.535516' }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Location Pin Longitude</label>
                        <input type="text" id="mapLngInput" name="map_longitude" class="form-control font-monospace" placeholder="77.261021" value="{{ $settings['map_longitude'] ?? '77.261021' }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Map Zoom Level</label>
                        <input type="number" id="mapZoomInput" name="map_zoom" class="form-control font-monospace" value="{{ $settings['map_zoom'] ?? '14' }}">
                    </div>

                    <div class="col-12">
                        <div id="adminPickerMap"></div>
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

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const latInput = document.getElementById("mapLatInput");
        const lngInput = document.getElementById("mapLngInput");
        const zoomInput = document.getElementById("mapZoomInput");

        let lat = parseFloat(latInput.value) || 28.535516;
        let lng = parseFloat(lngInput.value) || 77.261021;
        let zoom = parseInt(zoomInput.value) || 14;

        const map = L.map('adminPickerMap').setView([lat, lng], zoom);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        const marker = L.marker([lat, lng], { draggable: true }).addTo(map);
        marker.bindPopup("<b>Selected Pin Location</b><br>Drag pin or click map to move.").openPopup();

        function updateInputs(newLat, newLng) {
            latInput.value = newLat.toFixed(6);
            lngInput.value = newLng.toFixed(6);
        }

        marker.on('dragend', function(e) {
            const position = marker.getLatLng();
            updateInputs(position.lat, position.lng);
        });

        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            updateInputs(e.latlng.lat, e.latlng.lng);
        });

        map.on('zoomend', function() {
            zoomInput.value = map.getZoom();
        });

        function onManualInputChange() {
            let nLat = parseFloat(latInput.value);
            let nLng = parseFloat(lngInput.value);
            if (!isNaN(nLat) && !isNaN(nLng)) {
                marker.setLatLng([nLat, nLng]);
                map.panTo([nLat, nLng]);
            }
        }
        latInput.addEventListener('change', onManualInputChange);
        lngInput.addEventListener('change', onManualInputChange);

        const contactTabEl = document.getElementById('contactTabLink');
        if (contactTabEl) {
            contactTabEl.addEventListener('shown.bs.tab', function () {
                map.invalidateSize();
            });
        }
    });
</script>
@endsection
