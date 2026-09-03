<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', \App\Models\SiteSetting::get('meta_title', 'Zerox Pharmaceuticals Ltd - Product Authentication & Catalog'))</title>
    <meta name="description" content="@yield('meta_description', \App\Models\SiteSetting::get('meta_description', 'Official web portal of Zerox Pharmaceuticals. Verify authenticity and explore pharmaceutical products.'))">
    <meta name="keywords" content="{{ \App\Models\SiteSetting::get('meta_keywords', 'Zerox Pharmaceuticals, Product Verification, Tablets, Injectables, HGH, Peptides') }}">

    <!-- OpenGraph Meta Tags -->
    <meta property="og:title" content="@yield('title', \App\Models\SiteSetting::get('site_name', 'Zerox Pharmaceuticals Ltd'))">
    <meta property="og:description" content="@yield('meta_description', \App\Models\SiteSetting::get('meta_description', 'Official web portal of Zerox Pharmaceuticals.'))">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/logo-og.png') }}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', \App\Models\SiteSetting::get('site_name', 'Zerox Pharmaceuticals Ltd'))">
    <meta name="twitter:description" content="@yield('meta_description', \App\Models\SiteSetting::get('meta_description', 'Official web portal of Zerox Pharmaceuticals.'))">

    <!-- Bootstrap 5.3 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --zx-navy: #091528;
            --zx-dark-blue: #0f2342;
            --zx-accent-cyan: #00d2ff;
            --zx-accent-blue: #0066ff;
            --zx-light-bg: #f4f7fa;
            --zx-border: #e2e8f0;
            --zx-text-dark: #1e293b;
            --zx-text-muted: #64748b;
        }

        body {
            font-family: 'Outfit', sans-serif;
            color: var(--zx-text-dark);
            background-color: #fafbfc;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        h1, h2, h3, h4, h5, h6, .brand-font {
            font-family: 'Space Grotesk', sans-serif;
        }

        /* Navbar Styling */
        .zx-topbar {
            background-color: var(--zx-navy);
            color: #94a3b8;
            font-size: 0.85rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .zx-navbar {
            background-color: var(--zx-dark-blue);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .zx-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: #ffffff;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .zx-brand span.highlight {
            color: var(--zx-accent-cyan);
        }

        .nav-link {
            color: #cbd5e1 !important;
            font-weight: 500;
            padding: 0.6rem 1rem !important;
            transition: all 0.2s ease;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--zx-accent-cyan) !important;
        }

        .btn-auth-check {
            background: linear-gradient(135deg, var(--zx-accent-cyan), var(--zx-accent-blue));
            color: #ffffff;
            font-weight: 700;
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1.25rem;
            box-shadow: 0 4px 15px rgba(0, 210, 255, 0.3);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-auth-check:hover {
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 210, 255, 0.45);
        }

        /* Hero Section */
        .hero-banner {
            background: linear-gradient(135deg, rgba(9, 21, 40, 0.95), rgba(15, 35, 66, 0.92)), url('https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
            color: #ffffff;
            padding: 5rem 0 4rem;
        }

        /* Footer */
        footer {
            background-color: var(--zx-navy);
            color: #94a3b8;
            margin-top: auto;
        }

        footer h5 {
            color: #ffffff;
            font-size: 1.1rem;
            margin-bottom: 1.2rem;
        }

        footer a {
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.2s;
        }

        footer a:hover {
            color: var(--zx-accent-cyan);
        }

        /* Card Customization */
        .card-zx {
            border: 1px solid var(--zx-border);
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            transition: all 0.3s ease;
            background: #ffffff;
        }

        .card-zx:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.08);
            border-color: rgba(0, 210, 255, 0.4);
        }

        .badge-verified {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.3);
            font-size: 0.75rem;
            padding: 0.35rem 0.65rem;
            border-radius: 20px;
        }

        /* Search Results Modal / Box */
        .search-result-item {
            padding: 10px 15px;
            border-bottom: 1px solid #f1f5f9;
            transition: background 0.2s;
        }

        .search-result-item:hover {
            background-color: #f8fafc;
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Top Info Bar -->
    <div class="zx-topbar py-2">
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <span class="me-3"><i class="bi bi-telephone-fill text-info me-1"></i> {{ \App\Models\SiteSetting::get('contact_phone', '+91 11 27023256') }}</span>
                <span><i class="bi bi-envelope-fill text-info me-1"></i> {{ \App\Models\SiteSetting::get('contact_email', 'support@zzerox.com') }}</span>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-25"><i class="bi bi-shield-check me-1"></i> GMP & ISO Certified</span>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="text-light text-decoration-none small"><i class="bi bi-speedometer2 me-1"></i> Admin Panel</a>
                @else
                    <a href="{{ route('login') }}" class="text-light text-decoration-none small"><i class="bi bi-lock-fill me-1"></i> Partner Login</a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark zx-navbar sticky-top">
        <div class="container">
            <a class="navbar-brand zx-brand" href="{{ route('home') }}">
                <i class="bi bi-capsule-fill text-info fs-3"></i>
                ZEROX <span class="highlight">PHARMA</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-link-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a></li>

                    <!-- Dynamic Category Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Products & Categories
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark shadow-lg border-0" aria-labelledby="categoriesDropdown">
                            @if(isset($categories) && count($categories) > 0)
                                @foreach($categories as $cat)
                                    <li><a class="dropdown-header text-info fw-bold" href="{{ route('category.show', $cat->slug) }}">{{ $cat->name }}</a></li>
                                    @foreach($cat->children as $subcat)
                                        <li><a class="dropdown-item ps-4 small" href="{{ route('category.show', $subcat->slug) }}"><i class="bi bi-chevron-right me-1 text-muted" style="font-size: 0.7rem;"></i> {{ $subcat->name }}</a></li>
                                    @endforeach
                                    @if(!$loop->last) <li><hr class="dropdown-divider border-secondary opacity-25"></li> @endif
                                @endforeach
                            @endif
                        </ul>
                    </li>

                    <li class="nav-link-item"><a class="nav-link {{ request()->routeIs('authenticity') ? 'active' : '' }}" href="{{ route('authenticity') }}">Authenticity Check</a></li>
                    <li class="nav-link-item"><a class="nav-link {{ request()->routeIs('analysis') ? 'active' : '' }}" href="{{ route('analysis') }}">Lab Analysis</a></li>
                    <li class="nav-link-item"><a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About Us</a></li>
                    <li class="nav-link-item"><a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a></li>
                </ul>

                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-outline-light btn-sm px-3 rounded-pill" data-bs-toggle="modal" data-bs-target="#searchModal">
                        <i class="bi bi-search me-1"></i> Search
                    </button>
                    <a href="{{ route('authenticity') }}" class="btn btn-auth-check btn-sm text-white">
                        <i class="bi bi-qr-code-scan me-1"></i> Verify Product
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="pt-5 pb-4">
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-lg-4 col-md-6">
                    <div class="zx-brand mb-3">
                        <i class="bi bi-capsule-fill text-info"></i> ZEROX <span class="highlight">PHARMA</span>
                    </div>
                    <p class="small text-secondary">
                        Zerox Pharmaceuticals Ltd is a premier global biopharmaceutical manufacturer committed to formulation purity, quality assurance, and anti-counterfeiting verification technologies.
                    </p>
                    <div class="d-flex gap-2">
                        <span class="badge bg-dark border border-secondary text-light"><i class="bi bi-shield-lock text-info"></i> 100% Verified Batches</span>
                        <span class="badge bg-dark border border-secondary text-light"><i class="bi bi-building-check text-info"></i> WHO-GMP Facility</span>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled small d-flex flex-column gap-2">
                        <li><a href="{{ route('home') }}">Home Page</a></li>
                        <li><a href="{{ route('authenticity') }}">Product Verification</a></li>
                        <li><a href="{{ route('analysis') }}">Lab Test Certificates</a></li>
                        <li><a href="{{ route('about') }}">Quality & Standards</a></li>
                        <li><a href="{{ route('contact') }}">Global Inquiries</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5>Product Categories</h5>
                    <ul class="list-unstyled small d-flex flex-column gap-2">
                        <li><a href="{{ route('category.show', 'tablets') }}">Anabolic & Oral Tablets</a></li>
                        <li><a href="{{ route('category.show', 'injectables-1-ml') }}">Injectables (1 ml Ampoules)</a></li>
                        <li><a href="{{ route('category.show', 'hgh') }}">Recombinant HGH</a></li>
                        <li><a href="{{ route('category.show', 'peptides') }}">Synthetic Peptides</a></li>
                        <li><a href="{{ route('category.show', 'injectables-10-ml') }}">Injectables (10 ml Vials)</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5>Corporate Contact</h5>
                    <ul class="list-unstyled small text-secondary d-flex flex-column gap-2">
                        <li><i class="bi bi-geo-alt-fill text-info me-2"></i> {{ \App\Models\SiteSetting::get('company_address', 'Industrial Zone Phase II, New Delhi, India') }}</li>
                        <li><i class="bi bi-telephone-fill text-info me-2"></i> {{ \App\Models\SiteSetting::get('contact_phone', '+91 11 27023256') }}</li>
                        <li><i class="bi bi-envelope-fill text-info me-2"></i> {{ \App\Models\SiteSetting::get('contact_email', 'support@zzerox.com') }}</li>
                    </ul>
                </div>
            </div>

            <hr class="border-secondary opacity-25 my-4">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center small text-secondary">
                <div>&copy; {{ date('Y') }} Zerox Pharmaceuticals Ltd. All Rights Reserved.</div>
                <div class="mt-2 mt-md-0">
                    <span class="me-3">Security Scratch-Code Protected</span>
                    <span>ISO 9001:2015 Certified</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Search Modal -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0 bg-dark text-white">
                    <h5 class="modal-title"><i class="bi bi-search text-info me-2"></i> Live Search Catalog</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="input-group input-group-lg mb-3">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" id="liveSearchInput" class="form-control bg-light border-start-0 shadow-none" placeholder="Search by product name, SKU, compound, or category..." autocomplete="off">
                    </div>
                    <div id="liveSearchResults" class="mt-3" style="max-height: 350px; overflow-y: auto;">
                        <p class="text-muted text-center py-4">Type at least 2 characters to search across 50 products and categories.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Debounced Live Search Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('liveSearchInput');
            const searchResults = document.getElementById('liveSearchResults');
            let debounceTimer;

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(debounceTimer);
                    const query = this.value.trim();

                    if (query.length < 2) {
                        searchResults.innerHTML = '<p class="text-muted text-center py-4">Type at least 2 characters to search across 50 products and categories.</p>';
                        return;
                    }

                    searchResults.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-info" role="status"></div></div>';

                    debounceTimer = setTimeout(() => {
                        fetch(`{{ route('search') }}?q=${encodeURIComponent(query)}`)
                            .then(response => response.json())
                            .then(data => {
                                let html = '';
                                if (data.products.length === 0 && data.categories.length === 0) {
                                    html = '<p class="text-center text-muted py-4">No matching products or categories found.</p>';
                                } else {
                                    if (data.categories.length > 0) {
                                        html += '<h6 class="text-info text-uppercase fw-bold fs-7 mb-2">Categories</h6>';
                                        data.categories.forEach(cat => {
                                            html += `<a href="${cat.url}" class="d-block text-decoration-none text-dark search-result-item rounded mb-1">
                                                <i class="bi bi-folder-fill text-warning me-2"></i><strong>${cat.name}</strong>
                                            </a>`;
                                        });
                                    }

                                    if (data.products.length > 0) {
                                        html += '<h6 class="text-info text-uppercase fw-bold fs-7 mt-3 mb-2">Products</h6>';
                                        data.products.forEach(prod => {
                                            html += `<a href="${prod.url}" class="d-flex justify-content-between align-items-center text-decoration-none text-dark search-result-item rounded mb-1">
                                                <div>
                                                    <i class="bi bi-capsule text-primary me-2"></i><strong>${prod.name}</strong>
                                                    <small class="text-muted ms-2">(${prod.category})</small>
                                                </div>
                                                <span class="badge bg-light text-dark border">${prod.dosage_form || 'Standard'}</span>
                                            </a>`;
                                        });
                                    }
                                }
                                searchResults.innerHTML = html;
                            })
                            .catch(err => {
                                searchResults.innerHTML = '<p class="text-center text-danger py-3">Error fetching search results.</p>';
                            });
                    }, 300);
                });
            }
        });
    </script>
    @yield('scripts')
</body>
</html>
