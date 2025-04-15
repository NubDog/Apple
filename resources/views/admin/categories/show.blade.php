@extends('layouts.admin')

@section('title', 'Category Details')

@section('content')
<div class="admin-container">
    <div class="categories-dashboard">
        <!-- Header Section -->
        <div class="dashboard-header">
            <div class="breadcrumb">
                <span>Dashboard</span> <i class="bi bi-chevron-right"></i> 
                <span>Categories</span> <i class="bi bi-chevron-right"></i> 
                <span>{{ $category->name }}</span>
            </div>
            <div class="header-actions">
                <button class="btn-notification">
                    <i class="bi bi-bell"></i>
                    <span class="notification-badge">3</span>
                </button>
                <button class="btn-settings">
                    <i class="bi bi-gear"></i>
                </button>
            </div>
        </div>

        <!-- Category Details -->
        <div class="section-container">
            <div class="section-header">
                <h2 class="section-title">Category Details</h2>
                <div class="section-actions">
                    <a href="{{ route('admin.categories.index') }}" class="btn-back">
                        <i class="bi bi-arrow-left"></i> Back to Categories
                    </a>
                </div>
            </div>
            
            <div class="category-details">
                <div class="category-header">
                    <div class="category-title">
                        <h1>{{ $category->name }}</h1>
                        <div class="category-meta">
                            <span class="category-slug">{{ $category->slug }}</span>
                            <span class="category-date">Created: {{ $category->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                    <div class="category-actions">
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn-primary">
                            <i class="bi bi-pencil"></i> Edit Category
                        </a>
                        @if($category->products()->count() == 0)
                        <button onclick="confirmDelete({{ $category->id }})" class="btn-danger">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                        
                        <form id="delete-form-{{ $category->id }}" action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                        @endif
                    </div>
                </div>
                
                <div class="category-grid">
                    <div class="category-image-container">
                        <div class="category-image">
                            <img src="{{ $category->image ? asset('storage/' . $category->image) : asset('images/default-category.jpg') }}" alt="{{ $category->name }}">
                        </div>
                        
                        <div class="image-info">
                            <div class="info-item">
                                <span class="info-label">Image:</span>
                                <span class="info-value">{{ $category->image ? basename($category->image) : 'Default Image' }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="category-info">
                        <div class="info-section">
                            <h3 class="info-title">Details</h3>
                            
                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="info-label">ID</div>
                                    <div class="info-value">{{ $category->id }}</div>
                                </div>
                                
                                <div class="info-item">
                                    <div class="info-label">Name</div>
                                    <div class="info-value">{{ $category->name }}</div>
                                </div>
                                
                                <div class="info-item">
                                    <div class="info-label">Slug</div>
                                    <div class="info-value">{{ $category->slug }}</div>
                                </div>
                                
                                <div class="info-item">
                                    <div class="info-label">Created At</div>
                                    <div class="info-value">{{ $category->created_at->format('M d, Y H:i') }}</div>
                                </div>
                                
                                <div class="info-item">
                                    <div class="info-label">Updated At</div>
                                    <div class="info-value">{{ $category->updated_at->format('M d, Y H:i') }}</div>
                                </div>
                                
                                <div class="info-item">
                                    <div class="info-label">Products Count</div>
                                    <div class="info-value">{{ $category->products()->count() }}</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="info-section">
                            <h3 class="info-title">Description</h3>
                            <div class="description-content">
                                {{ $category->description ?? 'No description available' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Associated Products -->
        <div class="section-container">
            <div class="section-header">
                <h2 class="section-title">Products in this Category</h2>
                <div class="section-actions">
                    <a href="{{ route('admin.products.create') }}" class="btn-primary btn-sm">
                        <i class="bi bi-plus"></i> Add New Product
                    </a>
                </div>
            </div>
            
            @if($category->products()->count() > 0)
            <div class="products-table-container">
                <table class="products-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($category->products as $product)
                        <tr>
                            <td class="product-image">
                                <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/default-product.jpg') }}" alt="{{ $product->name }}">
                            </td>
                            <td class="product-name">{{ $product->name }}</td>
                            <td>${{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>
                                <span class="status-badge {{ $product->quantity > 0 ? 'in-stock' : 'out-of-stock' }}">
                                    {{ $product->quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                                </span>
                            </td>
                            <td class="product-actions">
                                <a href="{{ route('admin.products.show', $product->id) }}" class="btn-action" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-action" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="no-products">
                <div class="no-items-icon">
                    <i class="bi bi-cart-x"></i>
                </div>
                <p>No products in this category yet.</p>
                <a href="{{ route('admin.products.create') }}" class="btn-primary">
                    <i class="bi bi-plus"></i> Add New Product
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Admin Container */
    .admin-container {
        display: flex;
        width: 100%;
        min-height: 100vh;
        position: relative;
        z-index: 10;
    }
    
    /* Main layout */
    .categories-dashboard {
        width: 100%;
        padding: 20px;
        background-color: #f8f9fa;
        overflow-x: hidden;
    }
    
    /* Header Styles */
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    
    .breadcrumb {
        font-size: 14px;
        color: #6c757d;
    }
    
    .breadcrumb i {
        margin: 0 8px;
        font-size: 12px;
    }
    
    .header-actions {
        display: flex;
        gap: 12px;
    }
    
    .btn-notification, .btn-settings {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: none;
        background-color: #fff;
        color: #495057;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        cursor: pointer;
    }
    
    .notification-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: #dc3545;
        color: white;
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Section Container */
    .section-container {
        background-color: #fff;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    /* Section Header */
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    
    .section-title {
        font-size: 20px;
        font-weight: 600;
        color: #212529;
        margin: 0;
    }
    
    .btn-back {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #4361ee;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
    }
    
    .btn-back:hover {
        text-decoration: underline;
    }
    
    /* Buttons */
    .btn-primary, .btn-danger, .btn-secondary {
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.3s;
        border: none;
        text-decoration: none;
    }
    
    .btn-sm {
        padding: 8px 16px;
        font-size: 13px;
    }
    
    .btn-primary {
        background-color: #4361ee;
        color: white;
    }
    
    .btn-primary:hover {
        background-color: #3a56d4;
    }
    
    .btn-danger {
        background-color: #dc3545;
        color: white;
    }
    
    .btn-danger:hover {
        background-color: #c82333;
    }
    
    .btn-secondary {
        background-color: #f8f9fa;
        color: #495057;
        border: 1px solid #ced4da;
    }
    
    .btn-secondary:hover {
        background-color: #e9ecef;
    }
    
    /* Category Details */
    .category-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 24px;
    }
    
    .category-title h1 {
        font-size: 24px;
        font-weight: 700;
        color: #212529;
        margin: 0 0 8px 0;
    }
    
    .category-meta {
        display: flex;
        align-items: center;
        gap: 16px;
    }
    
    .category-slug {
        font-size: 14px;
        color: #6c757d;
        font-family: monospace;
        background-color: #f8f9fa;
        padding: 4px 8px;
        border-radius: 4px;
    }
    
    .category-date {
        font-size: 14px;
        color: #6c757d;
    }
    
    .category-actions {
        display: flex;
        gap: 12px;
    }
    
    /* Category Grid */
    .category-grid {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 24px;
    }
    
    .category-image-container {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    
    .category-image {
        width: 100%;
        height: 250px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .category-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .image-info {
        padding: 12px;
        background-color: #f8f9fa;
        border-radius: 8px;
    }
    
    .category-info {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }
    
    .info-section {
        margin-bottom: 20px;
    }
    
    .info-title {
        font-size: 18px;
        font-weight: 600;
        color: #212529;
        margin: 0 0 16px 0;
        padding-bottom: 8px;
        border-bottom: 1px solid #f1f3f9;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 16px;
    }
    
    .info-item {
        margin-bottom: 12px;
    }
    
    .info-label {
        font-size: 13px;
        font-weight: 500;
        color: #6c757d;
        margin-bottom: 4px;
    }
    
    .info-value {
        font-size: 15px;
        color: #212529;
    }
    
    .description-content {
        font-size: 15px;
        color: #495057;
        line-height: 1.6;
        background-color: #f8f9fa;
        padding: 16px;
        border-radius: 8px;
        min-height: 120px;
    }
    
    /* Products Table */
    .products-table-container {
        overflow-x: auto;
    }
    
    .products-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .products-table th {
        text-align: left;
        padding: 12px 16px;
        font-size: 14px;
        font-weight: 600;
        color: #495057;
        border-bottom: 2px solid #f1f3f9;
    }
    
    .products-table td {
        padding: 12px 16px;
        font-size: 14px;
        border-bottom: 1px solid #f1f3f9;
        vertical-align: middle;
    }
    
    .product-image {
        width: 80px;
    }
    
    .product-image img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 6px;
    }
    
    .product-name {
        font-weight: 500;
        color: #212529;
    }
    
    .status-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .status-badge.in-stock {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .status-badge.out-of-stock {
        background-color: #fee2e2;
        color: #b91c1c;
    }
    
    .product-actions {
        display: flex;
        gap: 8px;
    }
    
    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #495057;
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        transition: all 0.2s;
        text-decoration: none;
    }
    
    .btn-action:hover {
        background-color: #4361ee;
        color: white;
        border-color: #4361ee;
    }
    
    /* No Products */
    .no-products {
        padding: 40px;
        text-align: center;
        background-color: #f8f9fa;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 16px;
    }
    
    .no-items-icon {
        font-size: 48px;
        color: #adb5bd;
    }
    
    .no-products p {
        font-size: 16px;
        color: #6c757d;
        margin: 0;
    }
    
    /* Responsive styles */
    @media (max-width: 992px) {
        .category-grid {
            grid-template-columns: 1fr;
        }
        
        .category-image-container {
            max-width: 400px;
            margin: 0 auto;
        }
        
        .category-actions {
            flex-direction: column;
        }
    }
    
    @media (max-width: 768px) {
        .category-header {
            flex-direction: column;
            gap: 16px;
        }
        
        .info-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Confirm delete function
        window.confirmDelete = function(categoryId) {
            if(confirm('Are you sure you want to delete this category?')) {
                document.getElementById('delete-form-' + categoryId).submit();
            }
        };
    });
</script>
@endpush 