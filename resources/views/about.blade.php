@extends('layouts.app')

@section('title', 'About Us - Zerox Pharmaceuticals Quality & Standards')

@section('content')
<!-- Hero Title Banner -->
<section class="banner" style="min-height: 140px; background: #0f172a; color: #fff; padding: 45px 0;">
    <div class="container text-center">
        <h1 style="font-size: 32px; font-weight: 700; color: #c9a227; margin-bottom: 8px;">Corporate Quality & Manufacturing Standards</h1>
        <p style="color: #cbd5e1; font-size: 16px; margin: 0; max-width: 750px; display: inline-block;">Zerox Pharmaceuticals Ltd is committed to formulation purity, ISO certification, and anti-counterfeiting verification.</p>
    </div>
</section>

<!-- Main Corporate Heritage Content -->
<div class="container" style="padding: 60px 15px;">
    <div class="row" style="display: flex; flex-wrap: wrap; align-items: center;">
        <div class="col-md-6 col-xs-12" style="margin-bottom: 30px;">
            <h6 style="color: #c9a227; text-transform: uppercase; font-weight: 700; letter-spacing: 1px; margin-bottom: 8px;">Our Heritage & Mission</h6>
            <h2 style="font-size: 28px; font-weight: 700; color: #111; margin-top: 0; margin-bottom: 20px;">Precision Engineering in Bio-therapeutics</h2>
            <p style="font-size: 15px; line-height: 1.7; color: #475569; margin-bottom: 15px;">
                Founded with a relentless dedication to active pharmaceutical ingredient (API) excellence, Zerox Pharmaceuticals Ltd stands as a premier international manufacturer of anabolic oral tablets, sterile injectable ampoules and vials, recombinant Human Growth Hormone (rHGH), and synthetic peptides.
            </p>
            <p style="font-size: 15px; line-height: 1.7; color: #475569; margin-bottom: 25px;">
                Our automated manufacturing facilities incorporate cleanroom environments operating under ISO Class 5 air filtration, ensuring zero cross-contamination and sterile filling accuracy across all product batches.
            </p>

            <div class="row" style="display: flex; gap: 15px;">
                <div style="flex: 1; background: #f8fafc; padding: 18px; border-radius: 8px; border: 1px solid #e2e8f0; text-align: center;">
                    <h3 style="font-size: 26px; font-weight: 700; color: #0284c7; margin: 0;">99.8%</h3>
                    <span style="font-size: 13px; color: #64748b; font-weight: 600;">HPLC Purity Standard</span>
                </div>
                <div style="flex: 1; background: #f8fafc; padding: 18px; border-radius: 8px; border: 1px solid #e2e8f0; text-align: center;">
                    <h3 style="font-size: 26px; font-weight: 700; color: #16a34a; margin: 0;">100%</h3>
                    <span style="font-size: 13px; color: #64748b; font-weight: 600;">Scratch Code Verified</span>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xs-12">
            <div style="background: #0f172a; color: #fff; border-radius: 10px; padding: 30px; box-shadow: 0 10px 25px rgba(0,0,0,0.15);">
                <h3 style="color: #c9a227; font-size: 22px; font-weight: 700; margin-top: 0; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                    <i class="bi bi-award-fill"></i> Quality Assurance Protocols
                </h3>

                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <div style="display: flex; gap: 15px; align-items: flex-start;">
                        <i class="bi bi-patch-check-fill text-success" style="font-size: 22px; color: #22c55e;"></i>
                        <div>
                            <strong style="color: #f8fafc; display: block; margin-bottom: 4px; font-size: 15px;">WHO-GMP Compliance</strong>
                            <p style="color: #94a3b8; font-size: 14px; margin: 0; line-height: 1.5;">All manufacturing runs strictly adhere to World Health Organization Good Manufacturing Practice guidelines.</p>
                        </div>
                    </div>

                    <div style="display: flex; gap: 15px; align-items: flex-start;">
                        <i class="bi bi-patch-check-fill text-success" style="font-size: 22px; color: #22c55e;"></i>
                        <div>
                            <strong style="color: #f8fafc; display: block; margin-bottom: 4px; font-size: 15px;">High-Performance Liquid Chromatography (HPLC)</strong>
                            <p style="color: #94a3b8; font-size: 14px; margin: 0; line-height: 1.5;">Every production lot undergoes rigorous multi-stage HPLC raw material and finished product assays.</p>
                        </div>
                    </div>

                    <div style="display: flex; gap: 15px; align-items: flex-start;">
                        <i class="bi bi-patch-check-fill text-success" style="font-size: 22px; color: #22c55e;"></i>
                        <div>
                            <strong style="color: #f8fafc; display: block; margin-bottom: 4px; font-size: 15px;">Bacteriostatic Sterile Packaging</strong>
                            <p style="color: #94a3b8; font-size: 14px; margin: 0; line-height: 1.5;">Multi-dose 10 ml vials utilize USP grade carrier oils with benzyl alcohol preservation to guarantee stability.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
