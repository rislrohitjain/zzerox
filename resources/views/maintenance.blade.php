<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Maintenance - Zerox Pharmaceuticals</title>

    <!-- Dynamic Favicon Icons -->
    @php
        $faviconPath = \App\Models\SiteSetting::get('site_favicon', 'img/favicon.png');
        $faviconUrl = asset($faviconPath);
    @endphp
    <link rel="icon" type="image/png" href="{{ $faviconUrl }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ $faviconUrl }}">
    <link rel="apple-touch-icon" href="{{ $faviconUrl }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #091528, #0f2342);
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: system-ui, -apple-system, sans-serif;
        }
        .maintenance-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 3rem;
            max-width: 550px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }
        .gold-accent {
            color: #c9a227;
        }
    </style>
</head>
<body>
    <div class="maintenance-card">
        <img src="{{ asset(\App\Models\SiteSetting::get('site_logo_header', \App\Models\SiteSetting::get('site_logo', 'img/logo.png'))) }}" alt="Zerox Logo" style="height: 50px; margin-bottom: 2rem;">
        <i class="bi bi-tools display-1 gold-accent d-block mb-3"></i>
        <h2 class="fw-bold mb-3">System Under Maintenance</h2>
        <p class="text-secondary leading-relaxed mb-4">
            Zerox Pharmaceuticals web portal is currently undergoing scheduled cryptographic security updates and catalog synchronization. Please check back shortly.
        </p>
        <div class="p-3 bg-dark bg-opacity-50 rounded border border-secondary text-muted small">
            For urgent distribution or verification inquiries, please contact: <strong class="text-light">{{ \App\Models\SiteSetting::get('contact_email', 'support@zzerox.com') }}</strong>
        </div>
        <div class="mt-4 pt-2">
            <a href="{{ route('login') }}" class="btn btn-outline-warning btn-sm"><i class="bi bi-shield-lock me-1"></i> Admin / Partner Login</a>
        </div>
    </div>
</body>
</html>
