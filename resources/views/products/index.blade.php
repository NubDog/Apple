@extends('layouts.main')

@section('title', 'All Vehicles - Shark Car')

@section('content')
<div class="container mt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">All Vehicles</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3 border-bottom pb-2">Categories</h5>
                    <ul class="list-unstyled">
                        @foreach($categories as $category)
                            <li class="mb-2">
                                <a href="{{ route('category.products', $category->slug) }}" class="text-decoration-none {{ request('category') == $category->id ? 'fw-bold text-primary' : 'text-dark' }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <h5 class="mb-3 mt-4 border-bottom pb-2">Sort By</h5>
                    <form action="{{ route('products.index') }}" method="get">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <select name="sort" class="form-select mb-3" onchange="this.form.submit()">
                            <option value="newest" {{ request('sort') == 'newest' || !request('sort') ? 'selected' : '' }}>Newest</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">All Vehicles</h1>
                <span>Showing {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} of {{ $products->total() ?? 0 }} vehicles</span>
            </div>

            @if($products->isEmpty())
                <div class="alert alert-info">
                    No vehicles found matching your criteria.
                </div>
            @else
                <div class="row row-cols-1 row-cols-md-2 g-4">
                    @foreach($products as $product)
                        <div class="col">
                            <div class="card h-100 shadow-sm product-card">
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
                                
                                <!-- Product Image -->
                                <div class="product-image-container">
                                    <a href="{{ route('products.show', $product->slug) }}">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top product-image" alt="{{ $product->name }}">
                                        @else
                                            <div class="no-image-placeholder">No Image</div>
                                        @endif
                                    </a>
                                </div>
                                
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">
                                        <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none text-dark">
                                            {{ $product->name }}
                                        </a>
                                    </h5>
                                    
                                    <div class="mb-2">
                                        <small class="text-muted">{{ $product->category->name }}</small>
                                    </div>
                                    
                                    <!-- Price -->
                                    <div class="product-price mb-2">
                                        @if($product->on_sale && $product->sale_price)
                                            <span class="text-decoration-line-through text-muted me-2">${{ number_format($product->price, 2) }}</span>
                                            <span class="text-danger fw-bold">${{ number_format($product->sale_price, 2) }}</span>
                                        @else
                                            <span class="fw-bold">${{ number_format($product->price, 2) }}</span>
                                        @endif
                                    </div>
                                    
                                    <!-- Short description -->
                                    <p class="card-text flex-grow-1">
                                        {{ Str::limit($product->description, 100) }}
                                    </p>
                                    
                                    <!-- Actions -->
                                    <div class="d-flex mt-auto">
                                        <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary flex-grow-1 me-2">
                                            View Details
                                        </a>
                                        
                                        @if($product->quantity > 0)
                                            <form action="{{ route('cart.add') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn btn-outline-primary">
                                                    <i class="fas fa-cart-plus"></i>
                                                </button>
                                            </form>
                                        @else
                                            <button disabled class="btn btn-outline-secondary">
                                                <i class="fas fa-times"></i> Out of Stock
                                            </button>
                                        @endif
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
    .product-card {
        transition: transform 0.3s, box-shadow 0.3s;
        border: none;
        overflow: hidden;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .product-image-container {
        height: 280px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }

    .product-card:hover .product-image {
        transform: scale(1.05);
    }

    .no-image-placeholder {
        width: 100%;
        height: 280px;
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

    .product-price {
        font-size: 1.1rem;
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