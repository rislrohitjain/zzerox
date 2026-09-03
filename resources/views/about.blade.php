@extends('layouts.app')

@section('title', 'About Us - Zerox Pharmaceuticals Quality & Standards')

@section('content')
<div class="bg-dark text-white py-5 mb-5" style="background: linear-gradient(135deg, #091528, #0f2342);">
    <div class="container text-center py-4">
        <h1 class="display-5 fw-bold mb-2">Corporate Quality & Manufacturing Standards</h1>
        <p class="lead text-info max-w-2xl mx-auto">Zerox Pharmaceuticals Ltd is committed to formulation purity, ISO certification, and anti-counterfeiting verification.</p>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-5 align-items-center mb-5">
        <div class="col-lg-6">
            <h6 class="text-info text-uppercase fw-bold brand-font">Our Heritage & Mission</h6>
            <h2 class="fw-bold text-dark mb-4">Precision Engineering in Bio-therapeutics</h2>
            <p class="text-secondary leading-relaxed">
                Founded with a relentless dedication to active pharmaceutical ingredient (API) excellence, Zerox Pharmaceuticals Ltd stands as a premier international manufacturer of anabolic oral tablets, sterile injectable ampoules and vials, recombinant Human Growth Hormone (rHGH), and synthetic peptides.
            </p>
            <p class="text-secondary leading-relaxed">
                Our automated manufacturing facilities incorporate cleanroom environments operating under ISO Class 5 air filtration, ensuring zero cross-contamination and sterile filling accuracy across all product batches.
            </p>
            <div class="row g-3 mt-3">
                <div class="col-6">
                    <div class="p-3 bg-light rounded border text-center">
                        <h3 class="fw-bold text-primary m-0">99.8%</h3>
                        <span class="small text-muted">HPLC Purity Standard</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-3 bg-light rounded border text-center">
                        <h3 class="fw-bold text-success m-0">100%</h3>
                        <span class="small text-muted">Scratch Code Verified</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-zx border-0 shadow-lg p-3 bg-dark text-white">
                <div class="card-body">
                    <h4 class="text-info fw-bold mb-3"><i class="bi bi-award-fill me-2"></i> Quality Assurance Protocols</h4>
                    <ul class="list-unstyled d-flex flex-column gap-3 small">
                        <li class="d-flex align-items-start gap-2">
                            <i class="bi bi-patch-check-fill text-success fs-5"></i>
                            <div>
                                <strong>WHO-GMP Compliance:</strong> All manufacturing runs strictly adhere to World Health Organization Good Manufacturing Practice guidelines.
                            </div>
                        </li>
                        <li class="d-flex align-items-start gap-2">
                            <i class="bi bi-patch-check-fill text-success fs-5"></i>
                            <div>
                                <strong>High-Performance Liquid Chromatography (HPLC):</strong> Every production lot undergoes rigorous multi-stage HPLC raw material and finished product assays.
                            </div>
                        </li>
                        <li class="d-flex align-items-start gap-2">
                            <i class="bi bi-patch-check-fill text-success fs-5"></i>
                            <div>
                                <strong>Bacteriostatic Sterile Packaging:</strong> Multi-dose 10 ml vials utilize USP grade carrier oils with benzyl alcohol preservation to guarantee stability.
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
