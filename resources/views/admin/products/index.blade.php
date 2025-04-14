@extends('layouts.admin')

@section('title', 'Products')

@section('content')
<div class="products-container">
    <div class="card">
        <div class="card-title">
            Products Management
            <div class="actions">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add New Product
                </a>
            </div>
        </div>
        
        <div class="filters-container">
            <div class="row">
                <div class="col-md-4">
                    <div class="search-container">
                        <input type="text" id="search-products" class="search-input" placeholder="Search products...">
                        <i class="bi bi-search search-icon"></i>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="filters-right">
                        <div class="filter-item">
                            <label>Category:</label>
                            <select id="category-filter" class="filter-select">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="filter-item">
                            <label>Sort:</label>
                            <select id="sort-filter" class="filter-select">
                                <option value="name_asc">Name (A-Z)</option>
                                <option value="name_desc">Name (Z-A)</option>
                                <option value="price_asc">Price (Low to High)</option>
                                <option value="price_desc">Price (High to Low)</option>
                                <option value="newest">Newest First</option>
                                <option value="oldest">Oldest First</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="products-stats">
            <div class="stat-item">
                <div class="stat-value">{{ $totalProducts }}</div>
                <div class="stat-label">Total Products</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $activeProducts }}</div>
                <div class="stat-label">Active Products</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $lowStockProducts }}</div>
                <div class="stat-label">Low Stock</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $outOfStockProducts }}</div>
                <div class="stat-label">Out of Stock</div>
            </div>
        </div>
        
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        
        <div class="table-responsive">
            <table class="table products-table">
                <thead>
                    <tr>
                        <th width="80">Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>
                            <div class="product-image">
                            @php
                                $hasImage = false;
                                if($product->image) {
                                    echo '<img src="'.asset('storage/'.$product->image).'" alt="'.$product->name.'">';
                                    $hasImage = true;
                                } elseif($product->images) {
                                    $additionalImages = json_decode($product->images, true);
                                    if(is_array($additionalImages) && count($additionalImages) > 0) {
                                        echo '<img src="'.asset('storage/'.$additionalImages[0]).'" alt="'.$product->name.'">';
                                        $hasImage = true;
                                    }
                                }
                                
                                if(!$hasImage) {
                                    echo '<div class="no-image">No Image</div>';
                                }
                            @endphp
                            </div>
                        </td>
                        <td>
                            <div class="product-name">{{ $product->name }}</div>
                            <div class="product-sku">SKU: {{ $product->sku }}</div>
                        </td>
                        <td>{{ $product->category->name }}</td>
                        <td>
                            <div class="product-price">${{ number_format($product->price, 2) }}</div>
                            @if($product->old_price)
                            <div class="product-old-price">${{ number_format($product->old_price, 2) }}</div>
                            @endif
                        </td>
                        <td>
                            <div class="stock-badge {{ $product->quantity > 10 ? 'in-stock' : ($product->quantity > 0 ? 'low-stock' : 'out-of-stock') }}">
                                {{ $product->quantity > 10 ? 'In Stock' : ($product->quantity > 0 ? 'Low Stock' : 'Out of Stock') }}
                            </div>
                            <div class="stock-quantity">{{ $product->quantity }} units</div>
                        </td>
                        <td>
                            <div class="status-badge {{ $product->status ? 'active' : 'inactive' }}">
                                {{ $product->status ? 'Active' : 'Inactive' }}
                            </div>
                        </td>
                        <td>{{ $product->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="actions-container">
                                <a href="{{ route('admin.products.show', $product->id) }}" class="btn-action view" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-action edit" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button class="btn-action delete" title="Delete" onclick="confirmDelete({{ $product->id }})">
                                    <i class="bi bi-trash"></i>
                                </button>
                                
                                <form id="delete-form-{{ $product->id }}" action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="pagination-container">
            {{ $products->links() }}
        </div>
    </div>
</div>

@push('styles')
<style>
    .products-container {
        width: 100%;
    }
    
    .btn-primary {
        background-color: var(--primary);
        color: white;
        border: none;
        border-radius: 20px;
        padding: 8px 20px;
        font-weight: 500;
        display: flex;
        align-items: center;
        text-decoration: none;
    }
    
    .btn-primary i {
        margin-right: 5px;
    }
    
    .filters-container {
        margin: 20px 0;
    }
    
    .search-container {
        position: relative;
    }
    
    .search-input {
        width: 100%;
        padding: 10px 15px 10px 40px;
        border: 1px solid #eee;
        border-radius: 5px;
        font-size: 14px;
    }
    
    .search-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #666;
    }
    
    .filters-right {
        display: flex;
        justify-content: flex-end;
    }
    
    .filter-item {
        margin-left: 15px;
        display: flex;
        align-items: center;
    }
    
    .filter-item label {
        margin-right: 5px;
        font-weight: 500;
    }
    
    .filter-select {
        padding: 8px 15px;
        border: 1px solid #eee;
        border-radius: 5px;
        font-size: 14px;
    }
    
    .products-stats {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }
    
    .stat-item {
        flex: 1;
        min-width: 150px;
        text-align: center;
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 5px;
        margin-right: 10px;
        margin-bottom: 10px;
    }
    
    .stat-item:last-child {
        margin-right: 0;
    }
    
    .stat-value {
        font-size: 24px;
        font-weight: 600;
        color: var(--primary);
    }
    
    .stat-label {
        font-size: 14px;
        color: #666;
        margin-top: 5px;
    }
    
    .alert {
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    
    .alert-success {
        background-color: rgba(40, 167, 69, 0.1);
        border: 1px solid rgba(40, 167, 69, 0.2);
        color: #28a745;
    }
    
    .table-responsive {
        overflow-x: auto;
    }
    
    .products-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .products-table th {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #eee;
        font-weight: 600;
    }
    
    .products-table td {
        padding: 15px;
        border-bottom: 1px solid #eee;
        vertical-align: middle;
    }
    
    .product-image {
        width: 60px;
        height: 60px;
        border-radius: 5px;
        overflow: hidden;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .no-image {
        font-size: 12px;
        color: #999;
    }
    
    .product-name {
        font-weight: 500;
        margin-bottom: 5px;
    }
    
    .product-sku {
        font-size: 12px;
        color: #999;
    }
    
    .product-price {
        font-weight: 500;
        color: var(--primary);
    }
    
    .product-old-price {
        font-size: 12px;
        color: #999;
        text-decoration: line-through;
    }
    
    .stock-badge, .status-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        margin-bottom: 5px;
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
    
    .active {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }
    
    .inactive {
        background-color: rgba(108, 117, 125, 0.1);
        color: #6c757d;
    }
    
    .stock-quantity {
        font-size: 12px;
        color: #666;
    }
    
    .actions-container {
        display: flex;
        align-items: center;
    }
    
    .btn-action {
        width: 30px;
        height: 30px;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 5px;
        border: none;
        cursor: pointer;
        color: white;
    }
    
    .btn-action:last-child {
        margin-right: 0;
    }
    
    .btn-action.view {
        background-color: #17a2b8;
    }
    
    .btn-action.edit {
        background-color: #7262fd;
    }
    
    .btn-action.delete {
        background-color: #dc3545;
    }
    
    .pagination-container {
        margin-top: 20px;
    }
    
    @media (max-width: 768px) {
        .filters-right {
            justify-content: flex-start;
            margin-top: 15px;
        }
        
        .filter-item {
            margin-left: 0;
            margin-right: 15px;
        }
        
        .stat-item {
            min-width: calc(50% - 10px);
        }
    }
    
    @media (max-width: 576px) {
        .stat-item {
            min-width: 100%;
            margin-right: 0;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this product?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
    
    $(document).ready(function() {
        // Search functionality
        $('#search-products').on('keyup', function() {
            const searchTerm = $(this).val().toLowerCase();
            
            $('.products-table tbody tr').each(function() {
                const productName = $(this).find('.product-name').text().toLowerCase();
                const productSku = $(this).find('.product-sku').text().toLowerCase();
                
                if (productName.includes(searchTerm) || productSku.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
        
        // Category filter
        $('#category-filter').on('change', function() {
            const categoryId = $(this).val();
            
            if (categoryId === '') {
                $('.products-table tbody tr').show();
                return;
            }
            
            $('.products-table tbody tr').each(function() {
                const productCategory = $(this).find('td:nth-child(3)');
                const productCategoryId = productCategory.data('category-id');
                
                if (productCategoryId === categoryId) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
        
        // Sort filter
        $('#sort-filter').on('change', function() {
            const sortBy = $(this).val();
            let rows = $('.products-table tbody tr').get();
            
            rows.sort(function(a, b) {
                let A, B;
                
                switch (sortBy) {
                    case 'name_asc':
                        A = $(a).find('.product-name').text().toLowerCase();
                        B = $(b).find('.product-name').text().toLowerCase();
                        return A.localeCompare(B);
                    
                    case 'name_desc':
                        A = $(a).find('.product-name').text().toLowerCase();
                        B = $(b).find('.product-name').text().toLowerCase();
                        return B.localeCompare(A);
                    
                    case 'price_asc':
                        A = parseFloat($(a).find('.product-price').text().replace('$', '').replace(',', ''));
                        B = parseFloat($(b).find('.product-price').text().replace('$', '').replace(',', ''));
                        return A - B;
                    
                    case 'price_desc':
                        A = parseFloat($(a).find('.product-price').text().replace('$', '').replace(',', ''));
                        B = parseFloat($(b).find('.product-price').text().replace('$', '').replace(',', ''));
                        return B - A;
                    
                    case 'newest':
                        A = new Date($(a).find('td:nth-child(7)').text());
                        B = new Date($(b).find('td:nth-child(7)').text());
                        return B - A;
                    
                    case 'oldest':
                        A = new Date($(a).find('td:nth-child(7)').text());
                        B = new Date($(b).find('td:nth-child(7)').text());
                        return A - B;
                    
                    default:
                        return 0;
                }
            });
            
            $.each(rows, function(index, row) {
                $('.products-table tbody').append(row);
            });
        });
    });
</script>
@endpush
@endsection 