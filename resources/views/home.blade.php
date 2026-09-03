@extends('layouts.app')

@section('title', \App\Models\SiteSetting::get('hero_title', 'Zerox Pharmaceuticals Ltd - Global Precision Bio-therapeutics'))

@section('content')

<!-- Hero Section -->
<section class="hero-banner text-center text-md-start">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <span class="badge bg-info text-dark font-monospace fw-bold mb-3 px-3 py-2 text-uppercase"><i class="bi bi-shield-lock-fill me-1"></i> Scratch Code Authentication Enabled</span>
                <h1 class="display-4 fw-extrabold mb-3 text-white">
                    {{ \App\Models\SiteSetting::get('hero_title', 'Precision Engineering in Pharmaceutical Innovation') }}
                </h1>
                <p class="lead mb-4 text-light opacity-90">
                    {{ \App\Models\SiteSetting::get('hero_subtitle', 'World-Class Anabolic Steroids, Peptides, and rDNA Human Growth Hormone Certified Under Global GMP Standards.') }}
                </p>
                <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-md-start">
                    <a href="{{ route('authenticity') }}" class="btn btn-auth-check btn-lg">
                        <i class="bi bi-qr-code-scan me-2"></i> Verify Product Authenticity
                    </a>
                    <a href="#featured-products" class="btn btn-outline-light btn-lg">
                        Explore Catalog <i class="bi bi-arrow-down-short ms-1"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card card-zx bg-dark text-white border-secondary p-4 shadow-lg">
                    <div class="card-body">
                        <h4 class="card-title text-info fw-bold mb-3"><i class="bi bi-shield-check me-2"></i> Instant Product Authenticity Check</h4>
                        <p class="small text-secondary mb-3">Enter the unique 12-character security scratch code printed on your Zerox packaging.</p>
                        <form action="{{ route('authenticity.verify') }}" method="POST" id="quickVerifyForm">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="text" name="security_code" class="form-control form-control-lg bg-black text-white border-secondary" placeholder="e.g. ZX-8829-AB41" required autocomplete="off">
                                <button type="submit" class="btn btn-info text-dark fw-bold">Verify</button>
                            </div>
                        </form>
                        <div id="quickVerifyResult" class="mt-2 small"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Grid Section -->
<section class="py-5 bg-white border-bottom">
    <div class="container">
        <div class="text-center max-w-2xl mx-auto mb-5">
            <h6 class="text-info text-uppercase fw-bold brand-font">Product Families</h6>
            <h2 class="fw-bold text-dark">Explore Our Certified Categories</h2>
            <p class="text-muted">Formulated under strict Good Manufacturing Practice (GMP) specifications with HPLC purity testing.</p>
        </div>

        <div class="row g-4">
            @if(isset($categories))
                @foreach($categories as $cat)
                    <div class="col-lg-4 col-md-6">
                        <div class="card card-zx h-100 p-3">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="p-3 bg-info bg-opacity-10 text-info rounded-3">
                                        @if(Str::contains(strtolower($cat->name), 'tablets')) <i class="bi bi-capsule fs-2"></i>
                                        @elseif(Str::contains(strtolower($cat->name), 'hgh')) <i class="bi bi-prescription2 fs-2"></i>
                                        @elseif(Str::contains(strtolower($cat->name), 'peptides')) <i class="bi bi-diagram-3 fs-2"></i>
                                        @else <i class="bi bi-segmented-nav fs-2"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="card-title fw-bold m-0 text-dark">{{ $cat->name }}</h4>
                                        <span class="small text-muted">{{ $cat->children->count() }} Sub-categories</span>
                                    </div>
                                </div>
                                <p class="card-text text-secondary small flex-grow-1">{{ $cat->description }}</p>
                                <div class="pt-3 border-top d-flex justify-content-between align-items-center">
                                    <a href="{{ route('category.show', $cat->slug) }}" class="text-info fw-bold text-decoration-none small">
                                        Browse {{ $cat->name }} <i class="bi bi-chevron-right ms-1"></i>
                                    </a>
                                    <span class="badge bg-light text-dark border">Certified Grade</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section id="featured-products" class="py-5 bg-light">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4">
            <div>
                <h6 class="text-info text-uppercase fw-bold brand-font">Pharmaceutical Grade</h6>
                <h2 class="fw-bold text-dark m-0">Featured Products</h2>
            </div>
            <a href="{{ route('category.show', 'tablets') }}" class="btn btn-outline-dark btn-sm mt-3 mt-md-0">View Full Catalog <i class="bi bi-arrow-right ms-1"></i></a>
        </div>

        <div class="row g-4">
            @if(isset($featuredProducts))
                @foreach($featuredProducts as $prod)
                    <div class="col-lg-3 col-md-6">
                        <div class="card card-zx h-100">
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">{{ $prod->category->name ?? 'General' }}</span>
                                    <span class="badge-verified"><i class="bi bi-check-circle-fill me-1"></i> Verified Batch</span>
                                </div>
                                <h5 class="card-title fw-bold text-dark mb-1">{{ $prod->name }}</h5>
                                <p class="text-muted small mb-3">SKU: {{ $prod->sku }} | Dosage: {{ $prod->dosage_form }}</p>
                                <p class="card-text text-secondary small flex-grow-1 mb-4">{{ Str::limit($prod->description, 90) }}</p>

                                <a href="{{ route('products.show', $prod->slug) }}" class="btn btn-dark w-100 mt-auto">
                                    <i class="bi bi-eye me-1"></i> View Specifications
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    document.getElementById('quickVerifyForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const resultDiv = document.getElementById('quickVerifyResult');
        resultDiv.innerHTML = '<div class="spinner-border spinner-border-sm text-info me-2"></div> Verifying security code...';

        const formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json().then(data => ({ status: response.status, body: data })))
        .then(res => {
            const data = res.body;
            if (res.status === 200) {
                if (data.status === 'authentic') {
                    resultDiv.innerHTML = `<div class="alert alert-success mt-2 mb-0 p-2 text-start"><i class="bi bi-shield-check me-1"></i> <strong>AUTHENTIC!</strong> Batch: ${data.batch_number} - ${data.product ? data.product.name : 'Genuine Zerox Product'}.</div>`;
                } else if (data.status === 'previously_verified') {
                    resultDiv.innerHTML = `<div class="alert alert-warning mt-2 mb-0 p-2 text-start"><i class="bi bi-exclamation-triangle me-1"></i> <strong>PREVIOUSLY VERIFIED:</strong> Code was already checked on ${data.verified_at || 'an earlier date'}.</div>`;
                }
            } else {
                resultDiv.innerHTML = `<div class="alert alert-danger mt-2 mb-0 p-2 text-start"><i class="bi bi-x-circle me-1"></i> <strong>INVALID CODE:</strong> Counterfeit Warning. Code not found in database.</div>`;
            }
        })
        .catch(err => {
            resultDiv.innerHTML = '<div class="alert alert-danger mt-2 mb-0 p-2 text-start">Error connecting to verification server.</div>';
        });
    });
</script>
@endsection
