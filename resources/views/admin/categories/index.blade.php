@extends('layouts.admin')

@section('title', 'Categories Management')

@section('content')
<div class="admin-container">
    <div class="categories-dashboard">
        <!-- Header Section -->
        <div class="dashboard-header">
            <div class="breadcrumb">
                <span>Dashboard</span> <i class="bi bi-chevron-right"></i> <span>Categories Management</span>
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

        <!-- Categories Section -->
        <div class="section-container">
            <div class="section-header">
                <h2 class="section-title">Categories</h2>
                <div class="section-actions">
                    <a href="{{ route('admin.categories.index') }}" class="btn-view-all">View All</a>
                </div>
            </div>
            
            <!-- Control Bar -->
            <div class="control-bar">
                <div class="search-container">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" id="search-categories" class="search-input" placeholder="Search by name...">
                </div>
                
                <div class="filters">
                    <a href="{{ route('admin.categories.create') }}" class="btn-primary">
                        <i class="bi bi-plus"></i> Add New Category
                    </a>
                </div>
            </div>
            
            <!-- Category Statistics -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon blue">
                        <i class="bi bi-grid-fill"></i>
                    </div>
                    <div class="stat-info">
                        <h3>{{ $categories->total() }}</h3>
                        <p>Total Categories</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon green">
                        <i class="bi bi-car-front-fill"></i>
                    </div>
                    <div class="stat-info">
                        @php
                            $totalProducts = 0;
                            foreach ($categories as $category) {
                                $totalProducts += $category->products()->count();
                            }
                        @endphp
                        <h3>{{ $totalProducts }}</h3>
                        <p>Total Products</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon purple">
                        <i class="bi bi-basket-fill"></i>
                    </div>
                    <div class="stat-info">
                        <h3>{{ $categories->count() }}</h3>
                        <p>Current Page</p>
                    </div>
                </div>
            </div>
            
            <!-- Categories Cards Grid -->
            <div class="categories-grid">
                @foreach($categories as $category)
                <div class="category-card">
                    <div class="card-header">
                        <div class="time-badge">
                            <i class="bi bi-clock"></i> Created: {{ $category->created_at->format('M d, Y') }}
                        </div>
                        <div class="product-count-badge">
                            {{ $category->products()->count() }} Products
                        </div>
                    </div>
                    
                    <div class="card-content">
                        <div class="category-image">
                            <img src="{{ $category->image ? asset('storage/' . $category->image) : asset('images/default-category.jpg') }}" alt="{{ $category->name }}">
                        </div>
                        
                        <h3 class="category-name">{{ $category->name }}</h3>
                        <p class="category-slug">{{ $category->slug }}</p>
                        
                        <div class="category-description">
                            {{ Str::limit($category->description, 100) ?? 'No description available' }}
                        </div>
                    </div>
                    
                    <div class="card-actions">
                        <a href="{{ route('admin.categories.show', $category->id) }}" class="btn-action view" title="View">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn-action edit" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        @if($category->products()->count() == 0)
                        <button class="btn-action delete" title="Delete" onclick="confirmDelete({{ $category->id }})">
                            <i class="bi bi-trash"></i>
                        </button>
                        
                        <form id="delete-form-{{ $category->id }}" action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                        @else
                        <button class="btn-action disabled" title="Cannot delete category with products" disabled>
                            <i class="bi bi-trash"></i>
                        </button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="pagination-container">
                <div class="pagination-info">
                    Showing {{ $categories->firstItem() ?? 0 }} to {{ $categories->lastItem() ?? 0 }} of {{ $categories->total() }} results
                </div>
                <nav aria-label="Category pagination">
                    <ul class="pagination">
                        @if ($categories->onFirstPage())
                            <li class="disabled"><span>&laquo;</span></li>
                        @else
                            <li><a href="{{ $categories->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                        @endif

                        @foreach(range(1, $categories->lastPage()) as $page)
                            @if($page == $categories->currentPage())
                                <li class="active"><span>{{ $page }}</span></li>
                            @else
                                <li><a href="{{ $categories->url($page) }}">{{ $page }}</a></li>
                            @endif
                        @endforeach

                        @if ($categories->hasMorePages())
                            <li><a href="{{ $categories->nextPageUrl() }}" rel="next">&raquo;</a></li>
                        @else
                            <li class="disabled"><span>&raquo;</span></li>
                        @endif
                    </ul>
                </nav>
            </div>
            
            @if(session('success'))
            <div class="alert alert-success alert-dismissible">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible">
                <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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
        margin-bottom: 20px;
    }
    
    .section-title {
        font-size: 20px;
        font-weight: 600;
        color: #212529;
        margin: 0;
    }
    
    .btn-view-all {
        color: #4361ee;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
    }
    
    /* Control Bar */
    .control-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    
    .search-container {
        position: relative;
        width: 300px;
    }
    
    .search-input {
        width: 100%;
        padding: 10px 15px 10px 40px;
        border-radius: 30px;
        border: 1px solid #ced4da;
        font-size: 14px;
        outline: none;
        transition: all 0.3s;
    }
    
    .search-input:focus {
        border-color: #4361ee;
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
    }
    
    .search-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
    }
    
    .filters {
        display: flex;
        align-items: center;
        gap: 16px;
    }
    
    .btn-primary {
        background-color: #4361ee;
        color: white;
        border: none;
        border-radius: 30px;
        padding: 10px 20px;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
    }
    
    .btn-primary:hover {
        background-color: #3a56d4;
    }
    
    /* Stats Container */
    .stats-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 24px;
        width: 100%;
    }
    
    .stat-card {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: row;
        padding: 16px;
        border-radius: 12px;
        background-color: #f8f9fa;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        min-width: 0;
    }
    
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 16px;
        font-size: 20px;
        color: white;
    }
    
    .stat-icon.blue {
        background-color: #4361ee;
    }
    
    .stat-icon.green {
        background-color: #10b981;
    }
    
    .stat-icon.purple {
        background-color: #8b5cf6;
    }
    
    .stat-info h3 {
        font-size: 24px;
        font-weight: 600;
        margin: 0 0 4px 0;
    }
    
    .stat-info p {
        font-size: 14px;
        color: #6c757d;
        margin: 0;
    }
    
    /* Categories Grid */
    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
        width: 100%;
    }
    
    .category-card {
        border-radius: 12px;
        background-color: #fff;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        overflow: hidden;
        transition: all 0.3s;
        width: 100%;
    }
    
    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .card-header {
        padding: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #f1f3f9;
    }
    
    .time-badge {
        font-size: 12px;
        color: #6c757d;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .product-count-badge {
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 500;
        background-color: #10b981;
        color: white;
    }
    
    .card-content {
        padding: 20px;
        text-align: center;
    }
    
    .category-image {
        width: 100%;
        height: 160px;
        border-radius: 8px;
        margin-bottom: 16px;
        overflow: hidden;
    }
    
    .category-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .category-name {
        font-size: 18px;
        font-weight: 600;
        margin: 0 0 4px 0;
        color: #212529;
    }
    
    .category-slug {
        font-size: 14px;
        color: #6c757d;
        margin: 0 0 16px 0;
    }
    
    .category-description {
        font-size: 14px;
        color: #495057;
        line-height: 1.5;
        max-height: 84px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }
    
    .card-actions {
        display: flex;
        border-top: 1px solid #f1f3f9;
    }
    
    .btn-action {
        flex: 1;
        padding: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        background: none;
        color: #6c757d;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
    }
    
    .btn-action:hover {
        background-color: #f8f9fa;
        color: #4361ee;
    }
    
    .btn-action.view:hover {
        color: #4361ee;
    }
    
    .btn-action.edit:hover {
        color: #ffc107;
    }
    
    .btn-action.delete:hover {
        color: #dc3545;
    }
    
    .btn-action.disabled {
        color: #adb5bd;
        cursor: not-allowed;
    }
    
    /* Pagination */
    .pagination-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        margin-top: 24px;
    }
    
    .pagination-info {
        font-size: 14px;
        color: #6c757d;
    }
    
    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        gap: 8px;
    }
    
    .pagination li {
        display: inline-block;
    }
    
    .pagination li a, .pagination li span {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        color: #495057;
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        transition: all 0.2s;
    }
    
    .pagination li.active span {
        background-color: #4361ee;
        color: white;
        border-color: #4361ee;
    }
    
    .pagination li.disabled span {
        color: #adb5bd;
        cursor: not-allowed;
    }
    
    .pagination li a:hover {
        background-color: #e9ecef;
    }
    
    /* Alerts */
    .alert {
        padding: 16px;
        border-radius: 8px;
        margin-top: 24px;
        display: flex;
        align-items: center;
        position: relative;
    }
    
    .alert i {
        margin-right: 12px;
        font-size: 18px;
    }
    
    .alert-success {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .alert-danger {
        background-color: #fee2e2;
        color: #b91c1c;
    }
    
    .btn-close {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        font-size: 16px;
        cursor: pointer;
        color: inherit;
        opacity: 0.7;
    }
    
    .btn-close:hover {
        opacity: 1;
    }

    /* Responsive styles */
    @media (max-width: 992px) {
        .categories-grid {
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        }
        
        .stats-container {
            flex-direction: column;
        }
    }
    
    @media (max-width: 768px) {
        .control-bar {
            flex-direction: column;
            align-items: stretch;
            gap: 16px;
        }
        
        .search-container {
            width: 100%;
        }
        
        .categories-grid {
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        }
    }
    
    @media (max-width: 480px) {
        .categories-grid {
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
        
        // Search functionality
        const searchInput = document.getElementById('search-categories');
        searchInput.addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const categoryCards = document.querySelectorAll('.category-card');
            
            categoryCards.forEach(card => {
                const categoryName = card.querySelector('.category-name').textContent.toLowerCase();
                const categoryDescription = card.querySelector('.category-description').textContent.toLowerCase();
                
                if (categoryName.includes(searchValue) || categoryDescription.includes(searchValue)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
        
        // Alert auto dismiss
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.opacity = '0';
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 300);
            }, 5000);
        });
    });
</script>
@endpush 