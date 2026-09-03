@extends('layouts.app')

@section('title', 'Contact Us - Zerox Pharmaceuticals Ltd')

@section('styles')
<!-- Leaflet Map CSS for Interactive Location Pin -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #locationMap {
        height: 300px;
        width: 100%;
        border-radius: 8px;
        border: 1px solid #ddd;
    }
</style>
@endsection

@section('content')
<section class="banner" style="min-height: 120px; background: #0f172a; color: #fff; padding: 40px 0;">
    <div class="container">
        <h1 style="font-size: 28px; font-weight: 700; color: #c9a227; margin-bottom: 5px;">Contact Us</h1>
        <p style="color: #aaa; margin: 0;">Get in touch with Zerox Pharmaceuticals corporate team</p>
    </div>
</section>

<div class="container" style="padding: 50px 15px;">
    @if(session('success'))
        <div style="background: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 15px; border-radius: 6px; margin-bottom: 25px;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-7 col-xs-12">
            <div style="background: #fff; border: 1px solid #eee; border-radius: 8px; padding: 30px; box-shadow: 0 4px 12px rgba(0,0,0,0.04);">
                <h3 style="font-size: 22px; font-weight: 700; margin-top: 0; margin-bottom: 20px;">Send Us a Message</h3>
                <form action="{{ route('contact.submit') }}" method="POST">
                    @csrf
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 5px;">Your Name</label>
                        <input type="text" name="name" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" required placeholder="John Doe">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 5px;">Your Email</label>
                        <input type="email" name="email" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" required placeholder="name@domain.com">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 5px;">Subject</label>
                        <input type="text" name="subject" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" required placeholder="Distribution / Batch Inquiry">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 5px;">Message</label>
                        <textarea name="message" rows="5" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" required placeholder="Type your message here..."></textarea>
                    </div>
                    <button type="submit" style="background: #c9a227; color: #000; font-weight: 700; border: none; padding: 12px 30px; border-radius: 4px; cursor: pointer; width: 100%;">Send Message</button>
                </form>
            </div>
        </div>

        <div class="col-md-5 col-xs-12">
            <div style="background: #1e293b; color: #fff; border-radius: 8px; padding: 30px; height: 100%;">
                <h3 style="font-size: 20px; font-weight: 700; color: #c9a227; margin-top: 0; margin-bottom: 20px;">Corporate Headquarters</h3>

                <p style="margin-bottom: 15px;"><i class="bi bi-geo-alt-fill text-warning me-2"></i> {{ \App\Models\SiteSetting::get('company_address', 'Plot No. 42, Industrial Area Phase II, New Delhi, India - 110020') }}</p>
                <p style="margin-bottom: 15px;"><i class="bi bi-telephone-fill text-warning me-2"></i> {{ \App\Models\SiteSetting::get('contact_phone', '+91 11 27023256') }}</p>
                <p style="margin-bottom: 25px;"><i class="bi bi-envelope-fill text-warning me-2"></i> {{ \App\Models\SiteSetting::get('contact_email', 'support@zzerox.com') }}</p>

                <!-- Interactive Location Pin Map -->
                <div style="margin-top: 20px;">
                    <h4 style="font-size: 16px; font-weight: 600; color: #fff; margin-bottom: 10px;">Facility Location Map</h4>
                    <div id="locationMap"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Leaflet JS for Map Pin Rendering -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const lat = parseFloat("{{ \App\Models\SiteSetting::get('map_latitude', '28.535516') }}");
        $lng = parseFloat("{{ \App\Models\SiteSetting::get('map_longitude', '77.261021') }}");
        const zoom = parseInt("{{ \App\Models\SiteSetting::get('map_zoom', '14') }}");

        const map = L.map('locationMap').setView([lat, $lng], zoom);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        const marker = L.marker([lat, $lng]).addTo(map);
        marker.bindPopup("<b>{{ \App\Models\SiteSetting::get('company_name', 'Zerox Pharmaceuticals Ltd') }}</b><br>{{ \App\Models\SiteSetting::get('company_address') }}").openPopup();
    });
</script>
@endsection
