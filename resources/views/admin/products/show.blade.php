@extends('layouts.admin')

@section('title', 'Product Details')

@section('content')
<div class="products-container">
    <div class="card">
        <div class="card-title">
            Product Details
            <div class="actions">
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Products
                </a>
                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary">
                    <i class="bi bi-pencil"></i> Edit Product
                </a>
            </div>
        </div>
        
        <div class="product-details">
            <div class="row">
                <div class="col-md-5">
                    <div class="product-images">
                        <div class="main-image">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-main">
                            @else
                                <div class="no-image">No Main Image</div>
                            @endif
                        </div>
                        
                        @if($product->images && count(json_decode($product->images)) > 0)
                            <div class="additional-images">
                                @foreach(json_decode($product->images) as $image)
                                    <div class="additional-image">
                                        <img src="{{ asset('storage/' . $image) }}" alt="Additional image" class="img-thumbnail">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="col-md-7">
                    <div class="product-info">
                        <h1 class="product-title">{{ $product->name }}</h1>
                        
                        <div class="product-meta">
                            <div class="meta-item">
                                <span class="meta-label">Category:</span>
                                <span class="meta-value">{{ $product->category->name }}</span>
                            </div>
                            
                            <div class="meta-item">
                                <span class="meta-label">SKU:</span>
                                <span class="meta-value">{{ $product->sku ?? 'N/A' }}</span>
                            </div>
                            
                            <div class="meta-item">
                                <span class="meta-label">Created:</span>
                                <span class="meta-value">{{ $product->created_at->format('M d, Y') }}</span>
                            </div>
                            
                            <div class="meta-item">
                                <span class="meta-label">Last Updated:</span>
                                <span class="meta-value">{{ $product->updated_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                        
                        <div class="product-pricing">
                            <div class="price-item">
                                <span class="price-label">Regular Price:</span>
                                <span class="price-value">${{ number_format($product->price, 2) }}</span>
                            </div>
                            
                            @if($product->sale_price)
                            <div class="price-item">
                                <span class="price-label">Sale Price:</span>
                                <span class="price-value sale-price">${{ number_format($product->sale_price, 2) }}</span>
                            </div>
                            @endif
                        </div>
                        
                        <div class="product-inventory">
                            <div class="inventory-item">
                                <span class="inventory-label">Quantity in Stock:</span>
                                <span class="inventory-value">{{ $product->quantity }} units</span>
                            </div>
                            
                            <div class="inventory-status">
                                <span class="status-badge {{ $product->quantity > 10 ? 'in-stock' : ($product->quantity > 0 ? 'low-stock' : 'out-of-stock') }}">
                                    {{ $product->quantity > 10 ? 'In Stock' : ($product->quantity > 0 ? 'Low Stock' : 'Out of Stock') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="product-flags">
                            @if($product->featured)
                                <span class="flag featured">Featured</span>
                            @endif
                            
                            @if($product->is_new)
                                <span class="flag new">New</span>
                            @endif
                            
                            @if($product->on_sale)
                                <span class="flag sale">On Sale</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="product-description">
                <h3>Description</h3>
                <div class="description-content">
                    {!! nl2br(e($product->description)) !!}
                </div>
            </div>
            
            @if($product->details)
                <div class="product-technical-details">
                    <h3>Technical Details</h3>
                    <div class="details-content">
                        {!! nl2br(e($product->details)) !!}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .products-container {
        width: 100%;
    }
    
    .card-title .actions {
        display: flex;
        gap: 10px;
    }
    
    .product-details {
        padding: 20px 0;
    }
    
    .row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -15px;
    }
    
    .col-md-5 {
        width: 41.6667%;
        padding: 0 15px;
    }
    
    .col-md-7 {
        width: 58.3333%;
        padding: 0 15px;
    }
    
    @media (max-width: 768px) {
        .col-md-5, .col-md-7 {
            width: 100%;
        }
    }
    
    .product-images {
        margin-bottom: 20px;
    }
    
    .main-image {
        margin-bottom: 15px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .img-main {
        width: 100%;
        height: auto;
        display: block;
    }
    
    .no-image {
        background-color: #f8f9fa;
        height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        font-weight: 500;
        border-radius: 8px;
    }
    
    .additional-images {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .additional-image {
        width: 80px;
        height: 80px;
        border-radius: 5px;
        overflow: hidden;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.2s;
    }
    
    .additional-image:hover {
        border-color: var(--primary);
    }
    
    .img-thumbnail {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .product-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 15px;
        color: #333;
    }
    
    .product-meta {
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }
    
    .meta-item {
        margin-bottom: 8px;
        display: flex;
    }
    
    .meta-label {
        width: 120px;
        font-weight: 600;
        color: #555;
    }
    
    .meta-value {
        flex: 1;
        color: #333;
    }
    
    .product-pricing {
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }
    
    .price-item {
        margin-bottom: 8px;
        display: flex;
    }
    
    .price-label {
        width: 120px;
        font-weight: 600;
        color: #555;
    }
    
    .price-value {
        flex: 1;
        font-weight: 700;
        font-size: 18px;
        color: #333;
    }
    
    .sale-price {
        color: #dc3545;
    }
    
    .product-inventory {
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
    }
    
    .inventory-item {
        margin-right: 30px;
        margin-bottom: 8px;
    }
    
    .inventory-label {
        font-weight: 600;
        color: #555;
        margin-right: 5px;
    }
    
    .inventory-value {
        color: #333;
    }
    
    .status-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .in-stock {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }
    
    .low-stock {
        background-color: rgba(255, 193, 7, 0.1);
        color: #ffc107;
    }
    
    .out-of-stock {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }
    
    .product-flags {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 20px;
    }
    
    .flag {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .flag.featured {
        background-color: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
    }
    
    .flag.new {
        background-color: rgba(32, 201, 151, 0.1);
        color: #20c997;
    }
    
    .flag.sale {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }
    
    .product-description, .product-technical-details {
        margin-top: 30px;
    }
    
    .product-description h3, .product-technical-details h3 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }
    
    .description-content, .details-content {
        color: #555;
        line-height: 1.6;
    }
    
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 20px;
        font-size: 14px;
        font-weight: 500;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn i {
        margin-right: 5px;
    }
    
    .btn-primary {
        background-color: var(--primary);
        color: white;
        border: 1px solid var(--primary);
    }
    
    .btn-secondary {
        background-color: #6c757d;
        color: white;
        border: 1px solid #6c757d;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Click on additional image to show in main image area
        $('.additional-image img').on('click', function() {
            const newSrc = $(this).attr('src');
            $('.img-main').attr('src', newSrc);
        });
    });
</script>
@endpush
@endsection 