@extends('layouts.app')

@section('title', ($currentCategory->meta_title ?? $currentCategory->name) . ' | Zerox – Pharmaceuticals')
@section('meta_description', $currentCategory->meta_description ?? $currentCategory->description)

@section('content')
<!-- Category Hero Banner -->
<section class="banner" style="position: relative; overflow: hidden; background: #0f172a; min-height: 180px; display: flex; align-items: center;">
    @if($currentCategory->image_path)
        <img src="{{ asset($currentCategory->image_path) }}" alt="{{ $currentCategory->name }}" style="width: 100%; height: 220px; object-fit: cover; opacity: 0.7;">
    @else
        <img src="{{ asset('img/home-banner.png') }}" alt="{{ $currentCategory->name }}" style="width: 100%; height: 220px; object-fit: cover; opacity: 0.7;">
    @endif
    <div class="container" style="position: absolute; left: 0; right: 0; margin: 0 auto; padding: 0 15px;">
        <h1 style="font-size: 32px; font-weight: 700; color: #c9a227; margin: 0 0 8px 0; text-transform: uppercase;">{{ $currentCategory->name }}</h1>
        <div style="font-size: 14px; color: #ddd;">
            <a href="{{ route('home') }}" style="color: #fff; text-decoration: none;">Home</a> &nbsp;/&nbsp;
            @if($currentCategory->parent)
                <a href="{{ route('category.show', $currentCategory->parent->slug) }}" style="color: #fff; text-decoration: none;">{{ $currentCategory->parent->name }}</a> &nbsp;/&nbsp;
            @endif
            <span style="color: #c9a227;">{{ $currentCategory->name }}</span>
        </div>
    </div>
</section>

<div class="container" style="padding: 50px 15px;">
    <div class="row">
        <!-- Sidebar Navigation matching Zerox.com styling -->
        <div class="col-md-3 col-xs-12" style="margin-bottom: 30px;">
            <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
                <h4 style="font-size: 18px; font-weight: 700; color: #111; border-bottom: 2px solid #c9a227; padding-bottom: 10px; margin-top: 0; margin-bottom: 15px;">
                    PRODUCT CATEGORIES
                </h4>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    @if(isset($categories))
                        @foreach($categories as $cat)
                            <li style="margin-bottom: 8px;">
                                <a href="{{ route('category.show', $cat->slug) }}" style="display: block; padding: 8px 12px; font-weight: 600; color: {{ ($currentCategory->id === $cat->id || $currentCategory->parent_id === $cat->id) ? '#c9a227' : '#333' }}; background: {{ ($currentCategory->id === $cat->id || $currentCategory->parent_id === $cat->id) ? '#fff8e6' : '#f8f9fa' }}; border-radius: 4px; text-decoration: none; border-left: 3px solid {{ ($currentCategory->id === $cat->id || $currentCategory->parent_id === $cat->id) ? '#c9a227' : 'transparent' }};">
                                    {{ $cat->name }}
                                </a>
                                @if(count($cat->children) > 0 && ($currentCategory->id === $cat->id || $currentCategory->parent_id === $cat->id))
                                    <ul style="list-style: none; padding-left: 15px; margin: 6px 0 0 0;">
                                        @foreach($cat->children as $sub)
                                            <li style="margin-bottom: 4px;">
                                                <a href="{{ route('category.show', $sub->slug) }}" style="display: block; padding: 5px 10px; font-size: 13px; color: {{ $currentCategory->id === $sub->id ? '#c9a227' : '#666' }}; font-weight: {{ $currentCategory->id === $sub->id ? '700' : '400' }}; text-decoration: none;">
                                                    &bull; {{ $sub->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>

        <!-- Products Grid Layout -->
        <div class="col-md-9 col-xs-12">
            <!-- Header Sorting Bar -->
            <div style="background: #f8f9fa; border: 1px solid #e2e8f0; border-radius: 6px; padding: 12px 20px; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                <div style="font-size: 14px; color: #555;">
                    Showing <strong>{{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }}</strong> of <strong>{{ $products->total() }}</strong> products
                </div>
                <form action="{{ url()->current() }}" method="GET" style="display: flex; align-items: center; gap: 10px;">
                    <label style="font-size: 13px; color: #666; margin: 0;">Sort By:</label>
                    <select name="sort" onchange="this.form.submit()" style="padding: 6px 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff;">
                        <option value="name_asc" {{ $sort === 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                        <option value="name_desc" {{ $sort === 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                        <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Newest</option>
                    </select>
                </form>
            </div>

            <!-- Product Cards Grid -->
            <div class="row">
                @forelse($products as $product)
                    <div class="col-md-4 col-sm-6 col-xs-12" style="margin-bottom: 30px;">
                        <div style="background: #fff; border: 1px solid #eee; border-radius: 8px; padding: 15px; height: 100%; display: flex; flex-direction: column; transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 2px 8px rgba(0,0,0,0.04);" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.08)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.04)';">

                            <div style="text-align: center; background: #fdfdfd; padding: 15px; border-radius: 6px; margin-bottom: 15px; min-height: 180px; display: flex; align-items: center; justify-content: center;">
                                <img src="{{ asset($product->image_path ?? 'img/welcome-image.png') }}" alt="{{ $product->name }}" style="max-height: 150px; max-width: 100%; object-fit: contain;">
                            </div>

                            <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #c9a227; letter-spacing: 0.5px; margin-bottom: 4px;">{{ $product->category->name }}</span>

                            <h3 style="font-size: 18px; font-weight: 700; color: #111; margin: 0 0 8px 0; line-height: 1.3;">
                                <a href="{{ route('products.show', $product->slug) }}" style="color: #111; text-decoration: none;">{{ $product->name }}</a>
                            </h3>

                            <div style="background: #f8f9fa; padding: 8px 12px; border-radius: 4px; font-size: 12px; color: #444; margin-bottom: 12px;">
                                <div><strong>Dosage:</strong> {{ $product->dosage_form ?? 'N/A' }}</div>
                                <div><strong>Pack Size:</strong> {{ $product->pack_size ?? 'N/A' }}</div>
                            </div>

                            <p style="font-size: 13px; color: #666; line-height: 1.5; margin-bottom: 15px; flex-grow: 1;">
                                {{ Str::limit($product->description, 75) }}
                            </p>

                            <a href="{{ route('products.show', $product->slug) }}" style="display: block; text-align: center; background: #c9a227; color: #000; font-weight: 700; font-size: 13px; padding: 10px 15px; border-radius: 4px; text-decoration: none; margin-top: auto; transition: background 0.2s;" onmouseover="this.style.background='#b89320';" onmouseout="this.style.background='#c9a227';">
                                View Details & Spec
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-12" style="text-align: center; padding: 50px 15px;">
                        <i class="bi bi-box-seam" style="font-size: 48px; color: #ccc; display: block; margin-bottom: 15px;"></i>
                        <h3 style="color: #555;">No products available in this category</h3>
                        <p style="color: #888;">Please check another category from the left menu.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination Links -->
            <div style="margin-top: 30px; text-align: center;">
                {{ $products->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection
