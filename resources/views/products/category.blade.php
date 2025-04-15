@extends('layouts.main')

@section('title', $category->name . ' - Shark Car')

@section('content')
<div class="container mt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Categories</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled category-list">
                        @foreach($categories as $cat)
                            <li class="mb-3 py-2 px-3 {{ $cat->id == $category->id ? 'active' : '' }}">
                                <a href="{{ route('category.products', $cat->slug) }}" class="text-decoration-none {{ $cat->id == $category->id ? 'text-white' : 'text-dark' }}">
                                    {{ $cat->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <h5 class="mb-3 mt-4 border-bottom pb-2">Price Range</h5>
                    <form action="{{ route('category.products', $category->slug) }}" method="get" id="priceFilterForm">
                        <div class="mb-3">
                            <div class="price-slider">
                                <div class="price-slider-track"></div>
                                <input type="range" min="0" max="1000000" value="{{ request('min_price', 0) }}" class="price-slider-input" id="min-price" name="min_price">
                                <input type="range" min="0" max="1000000" value="{{ request('max_price', 1000000) }}" class="price-slider-input" id="max-price" name="max_price">
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <span>$<span id="min-price-value">{{ number_format(request('min_price', 0)) }}</span></span>
                                <span>$<span id="max-price-value">{{ number_format(request('max_price', 1000000)) }}</span></span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm w-100">Apply Filter</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Products Display -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">{{ $category->name }} <span class="text-muted">({{ $products->total() }})</span></h1>
                <div class="d-flex align-items-center">
                    <span class="me-2">Sort By:</span>
                    <form action="{{ route('category.products', $category->slug) }}" method="get" id="sortForm">
                        @if(request('min_price'))
                            <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                        @endif
                        @if(request('max_price'))
                            <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                        @endif
                        <select name="sort" class="form-select form-select-sm" onchange="document.getElementById('sortForm').submit()">
                            <option value="newest" {{ request('sort') == 'newest' || !request('sort') ? 'selected' : '' }}>Latest</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                        </select>
                    </form>
                </div>
            </div>

            @if($products->isEmpty())
                <div class="alert alert-info">
                    No vehicles found in this category.
                </div>
            @else
                <!-- Display one product per row -->
                <div class="product-listing">
                    @foreach($products as $product)
                        <div class="product-card-large mb-4">
                            <div class="card shadow-sm h-100">
                                <div class="row g-0">
                                    <div class="col-md-5">
                                        <div class="product-image-container h-100">
                                            <a href="{{ route('products.show', $product->slug) }}">
                                                @if($product->image)
                                                    <img src="{{ asset('storage/' . $product->image) }}" class="product-image" alt="{{ $product->name }}">
                                                @else
                                                    <div class="no-image-placeholder">No Image</div>
                                                @endif
                                            </a>
                                            <!-- Badges -->
                                            <div class="product-badges">
                                                @if($product->is_new)
                                                    <span class="badge bg-primary">New</span>
                                                @endif
                                                @if($product->on_sale && $product->sale_price)
                                                    <span class="badge bg-danger">Sale</span>
                                                @endif
                                                @if($product->featured)
                                                    <span class="badge bg-success">Featured</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="card-body d-flex flex-column h-100">
                                            <h4 class="card-title">
                                                <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none text-dark">
                                                    {{ $product->name }}
                                                </a>
                                            </h4>
                                            
                                            <!-- Price -->
                                            <div class="product-price-large mb-3">
                                                @if($product->on_sale && $product->sale_price)
                                                    <span class="text-decoration-line-through text-muted me-2">${{ number_format($product->price) }}</span>
                                                    <span class="text-danger fw-bold">${{ number_format($product->sale_price) }}</span>
                                                @else
                                                    <span class="fw-bold">${{ number_format($product->price) }}</span>
                                                @endif
                                            </div>
                                            
                                            <!-- Product specs -->
                                            <div class="product-specs mb-3">
                                                <div class="row row-cols-2 row-cols-lg-3 g-2">
                                                    <div class="col">
                                                        <div class="spec-item">
                                                            <i class="fas fa-tachometer-alt text-primary"></i>
                                                            <span>{{ rand(100, 2000) }} Miles</span>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="spec-item">
                                                            <i class="fas fa-gas-pump text-primary"></i>
                                                            <span>{{ ['Petrol', 'Diesel', 'Hybrid', 'Electric'][rand(0, 3)] }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="spec-item">
                                                            <i class="fas fa-calendar-alt text-primary"></i>
                                                            <span>{{ rand(2018, 2023) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="spec-item">
                                                            <i class="fas fa-car text-primary"></i>
                                                            <span>{{ ['Automatic', 'Manual'][rand(0, 1)] }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="spec-item">
                                                            <i class="fas fa-palette text-primary"></i>
                                                            <span>{{ ['Black', 'White', 'Red', 'Blue', 'Silver'][rand(0, 4)] }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Description -->
                                            <p class="card-text flex-grow-1">
                                                {{ Str::limit($product->description ?? $product->details, 200) }}
                                            </p>
                                            
                                            <!-- Actions -->
                                            <div class="d-flex mt-auto">
                                                <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary flex-grow-1 me-2">
                                                    View Details
                                                </a>
                                                
                                                @if(isset($product->quantity) && $product->quantity > 0)
                                                    <form action="{{ route('cart.add') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                        <input type="hidden" name="quantity" value="1">
                                                        <button type="submit" class="btn btn-outline-primary">
                                                            <i class="fas fa-cart-plus"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <button class="btn btn-outline-secondary" disabled>
                                                        <i class="fas fa-times"></i> Out of Stock
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-5">
                    {{ $products->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Category sidebar styling */
    .category-list li {
        border-radius: 5px;
        transition: all 0.3s;
    }
    
    .category-list li:hover {
        background-color: rgba(26, 35, 126, 0.1);
    }
    
    .category-list li.active {
        background-color: var(--primary-color);
        color: white;
    }
    
    /* Price slider styling */
    .price-slider {
        position: relative;
        height: 30px;
        margin-bottom: 20px;
    }
    
    .price-slider-track {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 100%;
        height: 4px;
        background-color: #ddd;
        border-radius: 4px;
    }
    
    .price-slider-input {
        position: absolute;
        top: 0;
        width: 100%;
        -webkit-appearance: none;
        appearance: none;
        background: transparent;
        pointer-events: none;
        height: 30px;
        margin: 0;
    }
    
    .price-slider-input::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 18px;
        height: 18px;
        background: var(--primary-color);
        border-radius: 50%;
        cursor: pointer;
        pointer-events: auto;
    }
    
    /* Product card large styling */
    .product-card-large {
        transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .product-card-large:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
    
    .product-image-container {
        position: relative;
        overflow: hidden;
        height: 100%;
        min-height: 300px;
        background-color: #f8f9fa;
    }
    
    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    
    .product-card-large:hover .product-image {
        transform: scale(1.05);
    }
    
    .no-image-placeholder {
        width: 100%;
        height: 100%;
        min-height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #e9ecef;
        color: #6c757d;
        font-size: 1.2rem;
    }
    
    .product-badges {
        position: absolute;
        top: 10px;
        left: 10px;
        z-index: 2;
    }
    
    .product-badges .badge {
        margin-right: 5px;
        font-size: 0.75rem;
        padding: 5px 10px;
    }
    
    .product-price-large {
        font-size: 1.5rem;
    }
    
    .spec-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 5px 0;
    }
    
    .spec-item i {
        width: 16px;
    }
    
    /* Pagination styling */
    .pagination {
        gap: 5px;
    }
    
    .page-item.active .page-link {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
    
    .page-link {
        color: var(--primary-color);
        border-radius: 4px;
    }
</style>
@endpush

@push('scripts')
<script>
    // Price range slider functionality
    document.addEventListener('DOMContentLoaded', function() {
        const minPriceInput = document.getElementById('min-price');
        const maxPriceInput = document.getElementById('max-price');
        const minPriceValue = document.getElementById('min-price-value');
        const maxPriceValue = document.getElementById('max-price-value');
        
        function updateValues() {
            minPriceValue.textContent = new Intl.NumberFormat().format(minPriceInput.value);
            maxPriceValue.textContent = new Intl.NumberFormat().format(maxPriceInput.value);
        }
        
        minPriceInput.addEventListener('input', function() {
            if (parseInt(minPriceInput.value) > parseInt(maxPriceInput.value)) {
                minPriceInput.value = maxPriceInput.value;
            }
            updateValues();
        });
        
        maxPriceInput.addEventListener('input', function() {
            if (parseInt(maxPriceInput.value) < parseInt(minPriceInput.value)) {
                maxPriceInput.value = minPriceInput.value;
            }
            updateValues();
        });
        
        updateValues();
    });
</script>
@endpush 