@extends('layouts.app')

@section('title', 'All Product Categories | Zerox – Pharmaceuticals')
@section('meta_description', 'Explore full pharmaceutical range across Tablets, Injectables, HGH, Peptides, and Vials.')

@section('content')
<!-- All Categories Hero Banner -->
<section class="banner" style="position: relative; background: #0f172a; min-height: 180px; display: flex; align-items: center;">
    <img src="{{ asset('img/home-banner.png') }}" alt="All Categories" style="width: 100%; height: 220px; object-fit: cover; opacity: 0.75;">
    <div class="container" style="position: absolute; left: 0; right: 0; margin: 0 auto; padding: 0 15px;">
        <h1 style="font-size: 32px; font-weight: 700; color: #c9a227; margin: 0 0 8px 0; text-transform: uppercase;">PRODUCT CATEGORIES CATALOG</h1>
        <div style="font-size: 14px; color: #ddd;">
            <a href="{{ route('home') }}" style="color: #fff; text-decoration: none;">Home</a> &nbsp;/&nbsp;
            <span style="color: #c9a227;">All Categories</span>
        </div>
    </div>
</section>

<div class="container" style="padding: 50px 15px;">
    <div style="margin-bottom: 40px; text-align: center;">
        <h2 style="font-size: 26px; font-weight: 700; color: #111; margin: 0 0 10px 0; position: relative; padding-bottom: 10px; border-bottom: 3px solid #c9a227; display: inline-block;">
            Explore Pharmaceutical Formulations
        </h2>
        <p style="color: #666; font-size: 15px; max-width: 700px; margin: 10px auto 0 auto;">
            Zerox Pharmaceuticals manufactures pharmaceutical grade oral anabolic tablets, 1ml glass ampoules, 10ml multi-dose vials, recombinant human growth hormone (HGH), and synthetic peptides.
        </p>
    </div>

    <!-- Parent Category Cards Grid -->
    <div class="row">
        @foreach($allParents as $parent)
            <div class="col-md-6 col-xs-12" style="margin-bottom: 30px;">
                <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); height: 100%; display: flex; flex-direction: column;">
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px;">
                        <div style="background: #fff8e6; padding: 12px; border-radius: 8px; border: 1px solid #ffeeba;">
                            <img src="{{ asset($parent->image_path ?? 'img/tablets-icon.png') }}" alt="{{ $parent->name }}" style="width: 45px; height: 45px; object-fit: contain;">
                        </div>
                        <div>
                            <h3 style="font-size: 22px; font-weight: 700; color: #111; margin: 0 0 4px 0;">
                                <a href="{{ route('category.show', $parent->slug) }}" style="color: #111; text-decoration: none;">{{ $parent->name }}</a>
                            </h3>
                            <span style="font-size: 12px; color: #c9a227; font-weight: 700; text-transform: uppercase;">
                                {{ count($parent->children) }} Subcategories
                            </span>
                        </div>
                    </div>

                    <p style="color: #666; font-size: 14px; line-height: 1.5; margin-bottom: 20px;">
                        {{ $parent->description }}
                    </p>

                    <!-- Subcategory List Pills -->
                    <div style="margin-top: auto; border-top: 1px solid #f0f4f8; padding-top: 15px;">
                        <strong style="font-size: 12px; color: #333; display: block; margin-bottom: 10px; text-transform: uppercase;">Subcategories:</strong>
                        <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                            @foreach($parent->children as $child)
                                <a href="{{ route('category.show', $child->slug) }}" style="background: #f8f9fa; border: 1px solid #ddd; color: #333; padding: 6px 14px; border-radius: 20px; font-size: 13px; font-weight: 600; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#c9a227'; this.style.color='#000'; this.style.borderColor='#c9a227';" onmouseout="this.style.background='#f8f9fa'; this.style.color='#333'; this.style.borderColor='#ddd';">
                                    {{ $child->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
