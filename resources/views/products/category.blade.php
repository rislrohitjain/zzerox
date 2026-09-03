@extends('layouts.app')

@section('title', $currentCategory->meta_title ?? $currentCategory->name . ' - Zerox Pharmaceuticals')
@section('meta_description', $currentCategory->meta_description ?? $currentCategory->description)

@section('content')
<div class="bg-dark text-white py-4 mb-4" style="background: linear-gradient(135deg, #091528, #0f2342);">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-2 text-muted">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-info text-decoration-none">Home</a></li>
                @if($currentCategory->parent)
                    <li class="breadcrumb-item"><a href="{{ route('category.show', $currentCategory->parent->slug) }}" class="text-info text-decoration-none">{{ $currentCategory->parent->name }}</a></li>
                @endif
                <li class="breadcrumb-item active text-white" aria-current="page">{{ $currentCategory->name }}</li>
            </ol>
        </nav>
        <h1 class="fw-bold mb-2">{{ $currentCategory->name }}</h1>
        <p class="text-secondary m-0 max-w-2xl">{{ $currentCategory->description }}</p>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-4">
        <!-- Sidebar Navigation Accordion -->
        <div class="col-lg-3">
            <div class="card card-zx border-0 shadow-sm p-3 sticky-top" style="top: 100px;">
                <h5 class="fw-bold mb-3 border-bottom pb-2"><i class="bi bi-list-nested text-info me-2"></i> Categories</h5>
                <div class="accordion accordion-flush" id="categoryAccordion">
                    @if(isset($categories))
                        @foreach($categories as $cat)
                            <div class="accordion-item border-0">
                                <h2 class="accordion-header" id="heading-{{ $cat->id }}">
                                    <button class="accordion-button px-2 py-2 fw-semibold text-dark {{ ($currentCategory->id === $cat->id || ($currentCategory->parent_id === $cat->id)) ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $cat->id }}" aria-expanded="{{ ($currentCategory->id === $cat->id || ($currentCategory->parent_id === $cat->id)) ? 'true' : 'false' }}">
                                        {{ $cat->name }}
                                    </button>
                                </h2>
                                <div id="collapse-{{ $cat->id }}" class="accordion-collapse collapse {{ ($currentCategory->id === $cat->id || ($currentCategory->parent_id === $cat->id)) ? 'show' : '' }}" aria-labelledby="heading-{{ $cat->id }}">
                                    <div class="accordion-body p-0 ps-3">
                                        <a href="{{ route('category.show', $cat->slug) }}" class="d-block py-1 text-decoration-none small {{ $currentCategory->id === $cat->id ? 'fw-bold text-info' : 'text-secondary' }}">
                                            All {{ $cat->name }}
                                        </a>
                                        @foreach($cat->children as $sub)
                                            <a href="{{ route('category.show', $sub->slug) }}" class="d-block py-1 text-decoration-none small {{ $currentCategory->id === $sub->id ? 'fw-bold text-info' : 'text-secondary' }}">
                                                <i class="bi bi-chevron-right me-1" style="font-size: 0.65rem;"></i> {{ $sub->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <!-- Products Listing Grid -->
        <div class="col-lg-9">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center bg-white p-3 rounded border mb-4">
                <div class="text-secondary small mb-2 mb-md-0">
                    Showing <strong>{{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }}</strong> of <strong>{{ $products->total() }}</strong> pharmaceutical formulations
                </div>
                <form action="{{ url()->current() }}" method="GET" class="d-flex align-items-center gap-2">
                    <label class="small text-muted text-nowrap">Sort By:</label>
                    <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="name_asc" {{ $sort === 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                        <option value="name_desc" {{ $sort === 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                        <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Newest Additions</option>
                    </select>
                </form>
            </div>

            <div class="row g-4">
                @forelse($products as $product)
                    <div class="col-md-4">
                        <div class="card card-zx h-100 p-3">
                            <div class="card-body p-2 d-flex flex-column">
                                <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 w-auto self-start mb-2">{{ $product->category->name }}</span>
                                <h5 class="fw-bold text-dark mb-1">{{ $product->name }}</h5>
                                <p class="text-muted small mb-2">SKU: {{ $product->sku }}</p>
                                <div class="bg-light p-2 rounded small text-secondary mb-3">
                                    <div><strong>Dosage:</strong> {{ $product->dosage_form ?? 'N/A' }}</div>
                                    <div><strong>Pack Size:</strong> {{ $product->pack_size ?? 'N/A' }}</div>
                                </div>
                                <p class="small text-muted flex-grow-1">{{ Str::limit($product->description, 80) }}</p>

                                <a href="{{ route('products.show', $product->slug) }}" class="btn btn-dark btn-sm w-100 mt-auto">
                                    <i class="bi bi-info-circle me-1"></i> Full Specifications
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-capsule text-muted fs-1 d-block mb-3"></i>
                        <h5>No products found in this category.</h5>
                        <p class="text-muted small">Please select another category from the sidebar accordion.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-5 d-flex justify-content-center">
                {{ $products->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection
