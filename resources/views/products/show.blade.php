@extends('layouts.app')

@section('title', $product->name . ' - Zerox Pharmaceuticals')
@section('meta_description', Str::limit($product->description, 160))

@section('content')
<div class="bg-dark text-white py-4 mb-4" style="background: linear-gradient(135deg, #091528, #0f2342);">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-2 text-muted">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-info text-decoration-none">Home</a></li>
                @if($product->category && $product->category->parent)
                    <li class="breadcrumb-item"><a href="{{ route('category.show', $product->category->parent->slug) }}" class="text-info text-decoration-none">{{ $product->category->parent->name }}</a></li>
                @endif
                <li class="breadcrumb-item"><a href="{{ route('category.show', $product->category->slug) }}" class="text-info text-decoration-none">{{ $product->category->name }}</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>
        <h1 class="fw-bold mb-0">{{ $product->name }}</h1>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-5 mb-5">
        <!-- Product Image & Quick Info -->
        <div class="col-lg-5">
            <div class="card card-zx border-0 shadow-sm p-4 text-center bg-white">
                <div class="p-5 bg-light rounded-3 mb-4 d-flex align-items-center justify-content-center" style="min-height: 280px;">
                    <div class="text-center">
                        <i class="bi bi-capsule-fill text-info display-1 d-block mb-3"></i>
                        <span class="badge bg-dark font-monospace px-3 py-2">ORIGINAL PACKAGING</span>
                    </div>
                </div>

                <div class="d-flex justify-content-center gap-2">
                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2">
                        <i class="bi bi-shield-check me-1"></i> Anti-Counterfeit Scratch Code Protected
                    </span>
                </div>
            </div>
        </div>

        <!-- Product Summary Specs -->
        <div class="col-lg-7">
            <div class="card card-zx border-0 shadow-sm p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <span class="badge bg-primary bg-opacity-10 text-primary border mb-2">{{ $product->category->name }}</span>
                        <h2 class="fw-bold text-dark m-0">{{ $product->name }}</h2>
                    </div>
                    <span class="badge bg-dark font-monospace">SKU: {{ $product->sku }}</span>
                </div>

                <p class="text-secondary leading-relaxed mb-4">{{ $product->description }}</p>

                <div class="row g-3 mb-4">
                    <div class="col-sm-6">
                        <div class="p-3 bg-light rounded border">
                            <small class="text-muted d-block text-uppercase fw-bold">Dosage Form</small>
                            <strong class="text-dark fs-5">{{ $product->dosage_form ?? 'Standard Form' }}</strong>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 bg-light rounded border">
                            <small class="text-muted d-block text-uppercase fw-bold">Packaging & Size</small>
                            <strong class="text-dark fs-5">{{ $product->pack_size ?? 'Standard Box' }}</strong>
                        </div>
                    </div>
                </div>

                <div class="p-3 bg-dark text-white rounded border border-secondary d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-info fw-bold mb-1"><i class="bi bi-qr-code-scan me-1"></i> Have a product box?</h6>
                        <small class="text-secondary">Verify the security scratch code on your product box.</small>
                    </div>
                    <a href="{{ route('authenticity') }}" class="btn btn-auth-check btn-sm text-nowrap">Verify Code</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabbed Navigation: Chemical Characteristics, Side Effects, Administration & Uses -->
    <div class="card card-zx border-0 shadow-sm">
        <div class="card-header bg-white border-bottom-0 pt-4 px-4">
            <ul class="nav nav-tabs card-header-tabs fw-bold" id="productDetailTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-dark active" id="chemical-tab" data-bs-toggle="tab" data-bs-target="#chemical" type="button" role="tab" aria-controls="chemical" aria-selected="true">
                        <i class="bi bi-activity text-info me-2"></i> Chemical Characteristics
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-dark" id="side-effects-tab" data-bs-toggle="tab" data-bs-target="#side-effects" type="button" role="tab" aria-controls="side-effects" aria-selected="false">
                        <i class="bi bi-exclamation-triangle text-warning me-2"></i> Side Effects
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-dark" id="administration-tab" data-bs-toggle="tab" data-bs-target="#administration" type="button" role="tab" aria-controls="administration" aria-selected="false">
                        <i class="bi bi-journal-medical text-primary me-2"></i> Administration & Uses
                    </button>
                </li>
            </ul>
        </div>
        <div class="card-body p-4">
            <div class="tab-content" id="productDetailTabsContent">
                <!-- Tab 1: Chemical Characteristics -->
                <div class="tab-pane fade show active" id="chemical" role="tabpanel" aria-labelledby="chemical-tab">
                    <h5 class="fw-bold mb-3">Molecular Structure & Compound Data</h5>
                    <pre class="bg-light p-4 rounded border text-dark font-monospace" style="white-space: pre-wrap;">{{ $product->chemical_characteristics }}</pre>
                </div>

                <!-- Tab 2: Side Effects -->
                <div class="tab-pane fade" id="side-effects" role="tabpanel" aria-labelledby="side-effects-tab">
                    <h5 class="fw-bold mb-3">Pharmacological Safety Profile & Precautions</h5>
                    <div class="alert alert-warning border-warning">
                        <i class="bi bi-info-circle-fill me-2"></i> Information below is strictly for medical reference and research education.
                    </div>
                    <div class="p-3 bg-light rounded border text-secondary" style="white-space: pre-wrap;">{{ $product->side_effects }}</div>
                </div>

                <!-- Tab 3: Administration & Uses -->
                <div class="tab-pane fade" id="administration" role="tabpanel" aria-labelledby="administration-tab">
                    <h5 class="fw-bold mb-3">Administration & Storage Instructions</h5>
                    <div class="p-3 bg-light rounded border text-secondary" style="white-space: pre-wrap;">{{ $product->administration_uses }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if(isset($relatedProducts) && count($relatedProducts) > 0)
        <div class="mt-5">
            <h4 class="fw-bold mb-4">Related Formulations in {{ $product->category->name }}</h4>
            <div class="row g-4">
                @foreach($relatedProducts as $rel)
                    <div class="col-md-3">
                        <div class="card card-zx h-100 p-3">
                            <div class="card-body p-2 d-flex flex-column">
                                <h6 class="fw-bold text-dark mb-1">{{ $rel->name }}</h6>
                                <p class="text-muted small mb-3">SKU: {{ $rel->sku }}</p>
                                <a href="{{ route('products.show', $rel->slug) }}" class="btn btn-outline-dark btn-sm w-100 mt-auto">View Formulation</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
