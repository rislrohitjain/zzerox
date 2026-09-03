@extends('layouts.app')

@section('title', $product->name . ' | Zerox – Pharmaceuticals')
@section('meta_description', Str::limit($product->description, 160))

@section('content')
<section class="banner" style="min-height: 120px; background: #0f172a; color: #fff; padding: 40px 0;">
    <div class="container">
        <h1 style="font-size: 28px; font-weight: 700; color: #c9a227; margin-bottom: 5px;">{{ $product->name }}</h1>
        <p style="color: #aaa; margin: 0;">SKU: {{ $product->sku }} | Category: {{ $product->category->name }}</p>
    </div>
</section>

<div class="container" style="padding: 50px 15px;">
    <div class="row">
        <!-- Main Image & Interactive Image Gallery -->
        <div class="col-md-5 col-xs-12">
            <div style="background: #fff; border: 1px solid #eee; border-radius: 8px; padding: 20px; text-align: center;">
                <img id="mainProductImage" src="{{ asset($product->image_path ?? 'img/welcome-image.png') }}" alt="{{ $product->name }}" style="max-width: 100%; max-height: 350px; object-fit: contain; border-radius: 4px;">

                <!-- Product Gallery Thumbnails -->
                @if(isset($product->images) && count($product->images) > 0)
                    <div class="product-gallery-thumbs" style="justify-content: center; margin-top: 20px;">
                        <img src="{{ asset($product->image_path ?? 'img/welcome-image.png') }}" class="product-gallery-thumb active" onclick="switchMainImage(this.src, this)">
                        @foreach($product->images as $gImg)
                            <img src="{{ asset($gImg->image_path) }}" class="product-gallery-thumb" onclick="switchMainImage(this.src, this)">
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Product Specs & Summary -->
        <div class="col-md-7 col-xs-12">
            <h2 style="font-size: 26px; font-weight: 700; color: #111; margin-top: 0;">{{ $product->name }}</h2>
            <div style="display: flex; gap: 15px; margin: 15px 0;">
                <span style="background: #f0f4f8; color: #333; padding: 5px 12px; border-radius: 4px; font-size: 14px; font-weight: 600;">Dosage: {{ $product->dosage_form ?? 'N/A' }}</span>
                <span style="background: #f0f4f8; color: #333; padding: 5px 12px; border-radius: 4px; font-size: 14px; font-weight: 600;">Pack Size: {{ $product->pack_size ?? 'N/A' }}</span>
            </div>

            <p style="font-size: 15px; line-height: 1.6; color: #555; margin-bottom: 25px;">{{ $product->description }}</p>

            <div style="background: #fff8e6; border: 1px solid #ffeeba; border-radius: 6px; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <strong style="color: #856404; display: block;">Verify Scratch Code</strong>
                    <span style="font-size: 13px; color: #856404;">Check authenticity label on packaging box</span>
                </div>
                <a href="{{ route('authenticity') }}" style="background: #c9a227; color: #000; padding: 8px 18px; font-weight: 700; border-radius: 4px; text-decoration: none;">Verify Code</a>
            </div>
        </div>
    </div>

    <!-- Specifications Tabs -->
    <div style="margin-top: 50px;">
        <div style="border-bottom: 2px solid #eee; display: flex; gap: 20px; margin-bottom: 25px;">
            <button class="tab-btn active" onclick="openSpecTab(event, 'tab-chemical')" style="background: none; border: none; padding: 10px 20px; font-size: 16px; font-weight: 700; color: #c9a227; border-bottom: 3px solid #c9a227; cursor: pointer;">Chemical Characteristics</button>
            <button class="tab-btn" onclick="openSpecTab(event, 'tab-side-effects')" style="background: none; border: none; padding: 10px 20px; font-size: 16px; font-weight: 700; color: #666; cursor: pointer;">Side Effects</button>
            <button class="tab-btn" onclick="openSpecTab(event, 'tab-administration')" style="background: none; border: none; padding: 10px 20px; font-size: 16px; font-weight: 700; color: #666; cursor: pointer;">Administration & Uses</button>
        </div>

        <div id="tab-chemical" class="tab-content-item" style="display: block;">
            <pre style="background: #f8f9fa; padding: 20px; border-radius: 6px; font-family: monospace; white-space: pre-wrap; color: #333;">{{ $product->chemical_characteristics }}</pre>
        </div>

        <div id="tab-side-effects" class="tab-content-item" style="display: none;">
            <div style="background: #f8f9fa; padding: 20px; border-radius: 6px; color: #444; white-space: pre-wrap;">{{ $product->side_effects }}</div>
        </div>

        <div id="tab-administration" class="tab-content-item" style="display: none;">
            <div style="background: #f8f9fa; padding: 20px; border-radius: 6px; color: #444; white-space: pre-wrap;">{{ $product->administration_uses }}</div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function switchMainImage(src, element) {
        document.getElementById('mainProductImage').src = src;
        document.querySelectorAll('.product-gallery-thumb').forEach(thumb => thumb.classList.remove('active'));
        element.classList.add('active');
    }

    function openSpecTab(evt, tabName) {
        document.querySelectorAll('.tab-content-item').forEach(item => item.style.display = 'none');
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.style.color = '#666';
            btn.style.borderBottom = 'none';
        });
        document.getElementById(tabName).style.display = 'block';
        evt.currentTarget.style.color = '#c9a227';
        evt.currentTarget.style.borderBottom = '3px solid #c9a227';
    }
</script>
@endsection
