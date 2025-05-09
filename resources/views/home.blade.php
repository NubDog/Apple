<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Shark Car - Trang chủ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        /* Custom styles */
        :root {
            --primary-color: #1a237e;
            --secondary-color: #f44336;
            --light-bg: #f5f5f5;
            --badge-new: #4169e1;
            --badge-sale: #e74c3c;
            --badge-featured: #27ae60;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-bg);
        }
        
        .navbar {
            background-color: var(--primary-color);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 24px;
            color: white !important;
        }
        
        .nav-link {
            color: rgba(255,255,255,0.8) !important;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .nav-link:hover {
            color: white !important;
        }
        
        .hero-slider {
            position: relative;
            margin-bottom: 3rem;
        }
        
        .carousel-item {
            height: 80vh;
            background-color: #000;
        }
        
        .carousel-item img {
            height: 100%;
            object-fit: cover;
            opacity: 0.7;
        }
        
        .carousel-caption.slide-content {
            text-align: left;
            left: 10%;
            right: 10%;
            top: 50%;
            bottom: auto;
            transform: translateY(-50%);
            max-width: 600px;
        }
        
        .slide-content h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        
        .slide-content p {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
        }
        
        .carousel-indicators {
            margin-bottom: 2rem;
        }
        
        .carousel-indicators button {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin: 0 6px;
            background-color: rgba(255,255,255,0.5);
            border: none;
            transition: all 0.3s ease;
        }
        
        .carousel-indicators button.active {
            width: 30px;
            border-radius: 6px;
            background-color: var(--primary-color);
        }
        
        .carousel-control-prev,
        .carousel-control-next {
            width: 5%;
            opacity: 0;
            transition: all 0.3s ease;
        }
        
        .hero-slider:hover .carousel-control-prev,
        .hero-slider:hover .carousel-control-next {
            opacity: 1;
        }
        
        .carousel-item .btn-primary {
            padding: 12px 30px;
            font-size: 1.1rem;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 1px;
            background-color: var(--primary-color);
            border: none;
            transition: all 0.3s ease;
        }
        
        .carousel-item .btn-primary:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        
        /* Animation classes */
        .carousel-item h1,
        .carousel-item p,
        .carousel-item .btn {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.8s ease;
        }
        
        .carousel-item.active h1 {
            opacity: 1;
            transform: translateY(0);
            transition-delay: 0.3s;
        }
        
        .carousel-item.active p {
            opacity: 1;
            transform: translateY(0);
            transition-delay: 0.6s;
        }
        
        .carousel-item.active .btn {
            opacity: 1;
            transform: translateY(0);
            transition-delay: 0.9s;
        }
        
        /* Fade transition */
        .carousel-fade .carousel-item {
            opacity: 0;
            transition: opacity 0.6s ease-in-out;
        }
        
        .carousel-fade .carousel-item.active {
            opacity: 1;
        }
        
        @media (max-width: 768px) {
            .carousel-item {
                height: 60vh;
            }
            
            .slide-content h1 {
                font-size: 2.5rem;
            }
            
            .slide-content p {
                font-size: 1.2rem;
            }
        }
        
        .section-title {
            text-align: center;
            margin: 50px 0 30px;
            font-weight: 700;
            color: var(--primary-color);
            position: relative;
            padding-bottom: 15px;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            height: 4px;
            width: 100px;
            background-color: var(--secondary-color);
        }
        
        .card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        }
        
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        
        .price {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .sale-price {
            color: var(--secondary-color);
        }
        
        .original-price {
            text-decoration: line-through;
            color: #888;
            font-size: 18px;
            margin-left: 10px;
        }
        
        .badge {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 14px;
            padding: 8px 15px;
            border-radius: 20px;
        }
        
        .badge-new {
            background-color: var(--primary-color);
        }
        
        .badge-sale {
            background-color: var(--secondary-color);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 10px 20px;
            font-weight: 600;
        }
        
        .btn-secondary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            padding: 10px 20px;
            font-weight: 600;
        }
        
        .btn-outline-primary {
            border-color: var(--primary-color);
            color: var(--primary-color);
            padding: 10px 20px;
            font-weight: 600;
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        .category-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: var(--primary-color);
        }
        
        footer {
            background-color: var(--primary-color);
            color: white;
            padding: 50px 0 20px;
        }
        
        footer h5 {
            font-weight: 700;
            margin-bottom: 20px;
        }
        
        footer ul {
            list-style: none;
            padding-left: 0;
        }
        
        footer a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
        }
        
        footer a:hover {
            color: white;
            text-decoration: none;
        }
        
        .social-icons a {
            font-size: 24px;
            margin-right: 15px;
        }
        
        .category-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s;
            margin-bottom: 20px;
        }
        
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        /* Animation for products */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .product-card {
            animation: fadeIn 0.5s ease-out forwards;
            opacity: 0;
        }
        
        .product-card:nth-child(1) { animation-delay: 0.1s; }
        .product-card:nth-child(2) { animation-delay: 0.2s; }
        .product-card:nth-child(3) { animation-delay: 0.3s; }
        .product-card:nth-child(4) { animation-delay: 0.4s; }
        
        /* Product Card New Styles */
        .product-card {
            transition: all 0.3s ease;
        }
        
        .product-card .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            overflow: hidden;
            height: 100%;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .product-card .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px rgba(0,0,0,0.15);
        }
        
        .product-card .card-img-top {
            height: 180px;
            object-fit: cover;
        }
        
        .product-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            padding: 5px 10px;
            color: white;
            font-size: 12px;
            font-weight: 600;
            border-radius: 4px;
            z-index: 1;
        }
        
        .badge-new {
            background-color: var(--badge-new);
        }
        
        .badge-sale {
            background-color: var(--badge-sale);
        }
        
        .badge-featured {
            background-color: var(--badge-featured);
        }
        
        .wishlist-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 35px;
            height: 35px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            z-index: 5;
            border: none;
        }
        
        .wishlist-btn:hover {
            background-color: #fff;
            transform: scale(1.1);
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .wishlist-btn i {
            color: #dc3545;
            font-size: 18px;
            transition: all 0.3s;
        }
        
        .wishlist-btn:hover i {
            transform: scale(1.1);
        }
        
        .wishlist-btn.active i {
            color: #dc3545;
        }
        
        .product-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 5px;
            color: #333;
        }
        
        .product-specs {
            font-size: 13px;
            color: #666;
            margin-bottom: 12px;
        }
        
        .product-features {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }
        
        .feature {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        
        .feature i {
            font-size: 18px;
            color: #666;
            margin-bottom: 5px;
        }
        
        .feature span {
            font-size: 12px;
            color: #333;
            font-weight: 500;
        }
        
        .product-price {
            font-size: 20px;
            font-weight: 700;
            color: #333;
            margin-bottom: 12px;
        }
        
        .view-details {
            display: block;
            color: var(--primary-color);
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }
        
        .view-details:hover {
            color: var(--secondary-color);
        }
        
        .view-details i {
            margin-left: 5px;
            transition: transform 0.2s;
        }
        
        .view-details:hover i {
            transform: translateX(3px);
        }
        
        .toast-notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            align-items: center;
            background: white;
            border-radius: 8px;
            padding: 12px 15px;
            margin-top: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.15);
            transform: translateX(100%);
            opacity: 0;
            transition: all 0.3s;
            max-width: 300px;
        }
        
        .toast-notification.show {
            transform: translateX(0);
            opacity: 1;
        }
        
        .toast-icon {
            margin-right: 10px;
            font-size: 20px;
        }
        
        .toast-success .toast-icon {
            color: #4caf50;
        }
        
        .toast-error .toast-icon {
            color: #f44336;
        }
        
        .toast-info .toast-icon {
            color: #2196f3;
        }
        
        .toast-message {
            font-size: 14px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/">Shark Car</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="/">Trang chủ</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            Danh mục xe
                        </a>
                        <ul class="dropdown-menu">
                            @foreach($categories as $category)
                                <li><a class="dropdown-item" href="{{ route('category.products', $category->slug) }}">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">Tất cả xe</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact.index') }}">Liên hệ</a>
                    </li>
                </ul>
                <form class="d-flex me-2" id="searchForm">
                    <input class="form-control me-2" type="search" id="searchInput" name="query" placeholder="Tìm kiếm xe..." required>
                    <button class="btn btn-secondary" type="submit"><i class="fas fa-search"></i></button>
                </form>
                <div class="d-flex">
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-light me-2">
                        <i class="fas fa-shopping-cart"></i> <span id="cart-count">0</span>
                    </a>
                    @auth
                        <div class="dropdown">
                            <button class="btn btn-outline-light dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> {{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('user.account') }}">Tài khoản</a></li>
                                <li><a class="dropdown-item" href="{{ route('user.orders') }}">Đơn hàng</a></li>
                                <li><a class="dropdown-item" href="{{ route('favorites.index') }}">Yêu thích</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item" type="submit">Đăng xuất</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Đăng nhập</a>
                        <a href="{{ route('register') }}" class="btn btn-secondary">Đăng ký</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Slider -->
    <div class="hero-slider">
        <div id="mainCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-indicators">
                @foreach($sliders as $index => $slider)
                    <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}" aria-current="{{ $index == 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"></button>
                @endforeach
            </div>
            <div class="carousel-inner">
                @foreach($sliders as $index => $slider)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <img src="{{ asset('storage/' . $slider->image) }}" class="d-block w-100" alt="{{ $slider->title }}">
                        <div class="carousel-caption slide-content">
                            <h1 class="animate__animated animate__fadeInDown">{{ $slider->title }}</h1>
                            <p class="animate__animated animate__fadeInUp">{{ $slider->subtitle }}</p>
                            <a href="{{ $slider->link }}" class="btn btn-primary btn-lg animate__animated animate__fadeInUp">Khám phá ngay</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <!-- Search Results Section -->
    <div class="container mt-5" id="searchResultsContainer" style="display: none;">
        <h2 class="section-title">Xe tìm kiếm</h2>
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Bộ lọc tìm kiếm</h5>
                    </div>
                    <div class="card-body">
                        <form id="searchFilterForm">
                            <div class="mb-3">
                                <label for="categoryFilter" class="form-label">Danh mục</label>
                                <select class="form-select" id="categoryFilter" name="category">
                                    <option value="">Tất cả danh mục</option>
                                    <!-- Filled by JavaScript -->
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Khoảng giá</label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="number" class="form-control" id="minPriceFilter" name="min_price" placeholder="Từ">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" class="form-control" id="maxPriceFilter" name="max_price" placeholder="Đến">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Lọc kết quả</button>
                        </form>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Tìm kiếm</h5>
                    </div>
                    <div class="card-body">
                        <form id="searchSidebarForm">
                            <div class="input-group">
                                <input type="text" class="form-control" id="searchSidebarInput" placeholder="Tìm kiếm xe..." required>
                                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div id="searchResultSummary" class="mb-3"></div>
                <div class="row" id="searchResults"></div>
            </div>
        </div>
        <div class="text-center mt-4 mb-5">
            <button id="backToHomeBtn" class="btn btn-outline-primary">Xem tất cả xe</button>
        </div>
    </div>

    <!-- Featured Products -->
    <div class="container mt-5">
        <h2 class="section-title">Xe gợi ý cho bạn</h2>
        <div class="row">
            @foreach($featuredProducts as $product)
                <div class="col-md-6 col-lg-3 mb-4 product-card">
                    <div class="card h-100 position-relative">
                        @if($product->is_new)
                            <div class="product-badge badge-new">New</div>
                        @elseif($product->on_sale)
                            <div class="product-badge badge-sale">Sale</div>
                        @else
                            <div class="product-badge badge-featured">Great Price</div>
                        @endif
                        
                        <div class="wishlist-btn" data-product-id="{{ $product->id }}">
                            <i class="far fa-heart"></i>
                        </div>
                        
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        
                        <div class="card-body p-3">
                            <h5 class="product-title">{{ $product->name }}</h5>
                            <p class="product-specs">{{ $product->details ?? '4.0 DS PowerPulse Momentum 5dr AWD Auto' }}</p>
                            
                            <div class="product-features">
                                <div class="feature">
                                    <i class="fas fa-tachometer-alt"></i>
                                    <span>{{ rand(20, 2500) }} Miles</span>
                                </div>
                                <div class="feature">
                                    <i class="fas fa-gas-pump"></i>
                                    <span>{{ ['Petrol', 'Diesel', 'Hybrid', 'Electric'][rand(0, 3)] }}</span>
                                </div>
                                <div class="feature">
                                    <i class="fas fa-cog"></i>
                                    <span>{{ ['Automatic', 'Manual'][rand(0, 1)] }}</span>
                                </div>
                            </div>
                            
                            <div class="product-price">${{ number_format($product->on_sale && $product->sale_price ? $product->sale_price : $product->price) }}</div>
                            
                            <div class="d-flex mt-3">
                                <a href="{{ route('products.show', $product->slug) }}" class="view-details me-2">
                                    View Details <i class="fas fa-arrow-right"></i>
                                </a>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-cart-plus"></i> Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('products.index') }}" class="btn btn-outline-primary">Xem tất cả xe</a>
        </div>
    </div>

    <!-- New Products -->
    <div class="container mt-5">
        <h2 class="section-title">Xe mới nhất</h2>
        <div class="row">
            @foreach($newProducts as $product)
                <div class="col-md-6 col-lg-3 mb-4 product-card">
                    <div class="card h-100 position-relative">
                        @if($product->is_new)
                            <div class="product-badge badge-new">New</div>
                        @elseif($product->on_sale)
                            <div class="product-badge badge-sale">Sale</div>
                        @else
                            <div class="product-badge badge-featured">Great Price</div>
                        @endif
                        
                        <div class="wishlist-btn" data-product-id="{{ $product->id }}">
                            <i class="far fa-heart"></i>
                        </div>
                        
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        
                        <div class="card-body p-3">
                            <h5 class="product-title">{{ $product->name }}</h5>
                            <p class="product-specs">{{ $product->details ?? '4.0 DS PowerPulse Momentum 5dr AWD Auto' }}</p>
                            
                            <div class="product-features">
                                <div class="feature">
                                    <i class="fas fa-tachometer-alt"></i>
                                    <span>{{ rand(20, 2500) }} Miles</span>
                                </div>
                                <div class="feature">
                                    <i class="fas fa-gas-pump"></i>
                                    <span>{{ ['Petrol', 'Diesel', 'Hybrid', 'Electric'][rand(0, 3)] }}</span>
                                </div>
                                <div class="feature">
                                    <i class="fas fa-cog"></i>
                                    <span>{{ ['Automatic', 'Manual'][rand(0, 1)] }}</span>
                                </div>
                            </div>
                            
                            <div class="product-price">${{ number_format($product->on_sale && $product->sale_price ? $product->sale_price : $product->price) }}</div>
                            
                            <div class="d-flex mt-3">
                                <a href="{{ route('products.show', $product->slug) }}" class="view-details me-2">
                                    View Details <i class="fas fa-arrow-right"></i>
                                </a>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-cart-plus"></i> Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Sale Products -->
    <div class="container mt-5">
        <h2 class="section-title">Xe đang giảm giá</h2>
        <div class="row">
            @foreach($saleProducts as $product)
                <div class="col-md-6 col-lg-3 mb-4 product-card">
                    <div class="card h-100 position-relative">
                        <div class="product-badge badge-sale">Sale</div>
                        
                        <div class="wishlist-btn" data-product-id="{{ $product->id }}">
                            <i class="far fa-heart"></i>
                        </div>
                        
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        
                        <div class="card-body p-3">
                            <h5 class="product-title">{{ $product->name }}</h5>
                            <p class="product-specs">{{ $product->details ?? '4.0 DS PowerPulse Momentum 5dr AWD Auto' }}</p>
                            
                            <div class="product-features">
                                <div class="feature">
                                    <i class="fas fa-tachometer-alt"></i>
                                    <span>{{ rand(20, 2500) }} Miles</span>
                                </div>
                                <div class="feature">
                                    <i class="fas fa-gas-pump"></i>
                                    <span>{{ ['Petrol', 'Diesel', 'Hybrid', 'Electric'][rand(0, 3)] }}</span>
                                </div>
                                <div class="feature">
                                    <i class="fas fa-cog"></i>
                                    <span>{{ ['Automatic', 'Manual'][rand(0, 1)] }}</span>
                                </div>
                            </div>
                            
                            <div class="product-price">${{ number_format($product->sale_price) }}</div>
                            
                            <div class="d-flex mt-3">
                                <a href="{{ route('products.show', $product->slug) }}" class="view-details me-2">
                                    View Details <i class="fas fa-arrow-right"></i>
                                </a>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-cart-plus"></i> Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-primary text-white py-5 mt-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2>Sẵn sàng để sở hữu xe mơ ước của bạn?</h2>
                    <p class="lead">Chúng tôi cung cấp nhiều tùy chọn tài chính và tư vấn miễn phí để giúp bạn lựa chọn xe phù hợp.</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('contact.index') }}" class="btn btn-light btn-lg">Liên hệ ngay</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5>Shark Car</h5>
                    <p>Chúng tôi cung cấp những mẫu xe tốt nhất với giá cả cạnh tranh và dịch vụ chăm sóc khách hàng tuyệt vời.</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-4">
                    <h5>Danh mục</h5>
                    <ul>
                        @foreach($categories as $category)
                            <li class="mb-2"><a href="{{ route('category.products', $category->slug) }}">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 mb-4">
                    <h5>Tài khoản</h5>
                    <ul>
                        <li class="mb-2"><a href="{{ route('login') }}">Đăng nhập</a></li>
                        <li class="mb-2"><a href="{{ route('register') }}">Đăng ký</a></li>
                        <li class="mb-2"><a href="{{ route('user.orders') }}">Đơn hàng</a></li>
                        <li class="mb-2"><a href="{{ route('favorites.index') }}">Yêu thích</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-4">
                    <h5>Liên hệ</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> 123 Đường Xe, Quận 1, TP.HCM</li>
                        <li class="mb-2"><i class="fas fa-phone me-2"></i> (84) 28 1234 5678</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> info@sharkcar.com</li>
                        <li class="mb-2"><i class="fas fa-clock me-2"></i> Thứ 2 - Thứ 7: 8:00 - 18:00</li>
                    </ul>
                </div>
            </div>
            <hr class="mt-4 mb-3" style="border-color: rgba(255,255,255,0.1);">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">&copy; 2023 Shark Car. Tất cả quyền được bảo lưu.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0">Thiết kế bởi Shark Car Team</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Toast Notification Container -->
    <div id="toast-container"></div>

    <!-- Messenger Chat Plugin -->
    <div id="fb-root"></div>
    <div id="fb-customer-chat" class="fb-customerchat"></div>

    <!-- jQuery - Load First -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap Bundle with Popper - Load Second -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Wishlist functionality -->
    <script>
        $(document).ready(function() {
            // Set up variables from PHP
            const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};
            const loginUrl = "{{ route('login') }}";
            const toggleUrl = "{{ route('favorites.toggle') }}";
            const checkUrl = "{{ route('favorites.check') }}";
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            
            // Initialize wishlist buttons
            loadWishlistStatus();
            
            // Handle wishlist button clicks
            $(document).on('click', '.wishlist-btn', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const button = $(this);
                const productId = button.data('product-id');
                
                if (!isLoggedIn) {
                    window.location.href = loginUrl;
                    return;
                }
                
                // Disable button temporarily and add loading effect
                button.css('pointer-events', 'none');
                button.find('i').removeClass('far fas').addClass('fa-spinner fa-spin');
                
                // Send AJAX request using form data
                $.ajax({
                    url: toggleUrl,
                    type: 'POST',
                    data: {
                        _token: csrfToken,
                        product_id: productId
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log('Wishlist response:', response);
                        
                        // Update button appearance
                        if (response.status === 'added') {
                            button.addClass('active');
                            button.find('i').removeClass('fa-spinner fa-spin').addClass('fas fa-heart');
                            showToast('Đã thêm vào danh sách yêu thích', 'success');
                        } else {
                            button.removeClass('active');
                            button.find('i').removeClass('fa-spinner fa-spin').addClass('far fa-heart');
                            showToast('Đã xóa khỏi danh sách yêu thích', 'info');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Wishlist error:', error);
                        console.error('Response:', xhr.responseText);
                        button.find('i').removeClass('fa-spinner fa-spin').addClass('far fa-heart');
                        showToast('Đã xảy ra lỗi khi cập nhật yêu thích', 'error');
                    },
                    complete: function() {
                        // Re-enable button
                        button.css('pointer-events', 'auto');
                    }
                });
            });
            
            // Function to load wishlist status
            function loadWishlistStatus() {
                if (!isLoggedIn) return;
                
                // Extract product IDs from wishlist buttons
                var productIds = [];
                $('.wishlist-btn').each(function() {
                    productIds.push($(this).data('product-id'));
                });
                
                if (productIds.length === 0) return;
                
                console.log('Checking wishlist status for products:', productIds);
                
                // Get wishlist status for all products
                $.ajax({
                    url: checkUrl,
                    type: 'POST',
                    data: {
                        _token: csrfToken,
                        product_id: productIds
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log('Wishlist status response:', response);
                        
                        if (response.favorites && response.favorites.length > 0) {
                            // Update buttons for favorited products
                            $.each(response.favorites, function(index, productId) {
                                $('.wishlist-btn[data-product-id="' + productId + '"]').each(function() {
                                    $(this).addClass('active');
                                    $(this).find('i').removeClass('far').addClass('fas');
                                });
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading wishlist status:', error);
                        console.error('Response:', xhr.responseText);
                    }
                });
            }
            
            // Function to show toast notifications
            function showToast(message, type = 'success') {
                // Create toast container if it doesn't exist
                if (!$('#toast-container').length) {
                    $('body').append('<div id="toast-container"></div>');
                }
                
                // Create toast element
                var toast = $('<div class="toast-notification toast-' + type + '">' +
                    '<div class="toast-icon"><i class="fas fa-' + 
                    (type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle') + 
                    '"></i></div>' +
                    '<div class="toast-message">' + message + '</div>' +
                    '</div>');
                
                // Add to container
                $('#toast-container').append(toast);
                
                // Trigger animation
                setTimeout(function() {
                    toast.addClass('show');
                }, 10);
                
                // Remove after delay
                setTimeout(function() {
                    toast.removeClass('show');
                    setTimeout(function() {
                        toast.remove();
                    }, 300);
                }, 3000);
            }
        });
    </script>

    <script>
        // Messenger chat plugin code
        var chatbox = document.getElementById('fb-customer-chat');
        chatbox.setAttribute("page_id", "100000000000000"); // Replace with your page ID
        chatbox.setAttribute("attribution", "biz_inbox");

        window.fbAsyncInit = function() {
            FB.init({
                xfbml: true,
                version: 'v18.0'
            });
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    
    <!-- Custom JavaScript -->
    <script>
        $(document).ready(function() {
            // Product card animation
            const productCards = document.querySelectorAll('.product-card');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });
            
            productCards.forEach(card => {
                observer.observe(card);
            });
            
            // Update cart count from session
            fetch('/cart/count')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('cart-count').textContent = data.count;
                });
            
            // Search functionality
            const searchForm = document.getElementById('searchForm');
            const searchInput = document.getElementById('searchInput');
            const searchSidebarForm = document.getElementById('searchSidebarForm');
            const searchSidebarInput = document.getElementById('searchSidebarInput');
            const searchFilterForm = document.getElementById('searchFilterForm');
            const categoryFilter = document.getElementById('categoryFilter');
            const minPriceFilter = document.getElementById('minPriceFilter');
            const maxPriceFilter = document.getElementById('maxPriceFilter');
            const searchResultsContainer = document.getElementById('searchResultsContainer');
            const searchResultSummary = document.getElementById('searchResultSummary');
            const searchResults = document.getElementById('searchResults');
            const backToHomeBtn = document.getElementById('backToHomeBtn');
            
            // All content sections to hide/show
            const mainContentSections = document.querySelectorAll('.container.mt-5:not(#searchResultsContainer)');
            const ctaSection = document.querySelector('.bg-primary');
            
            // Store current search query and filters
            let currentSearchParams = {
                query: '',
                category: '',
                min_price: '',
                max_price: ''
            };
            
            // Function to perform search with all parameters
            function performSearch(params = {}) {
                // Merge new params with current params
                currentSearchParams = {...currentSearchParams, ...params};
                
                // Build query string
                const queryParams = new URLSearchParams();
                for (const [key, value] of Object.entries(currentSearchParams)) {
                    if (value) queryParams.append(key, value);
                }
                
                // Display loading indicator
                searchResults.innerHTML = '<div class="col-12 text-center my-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Đang tìm kiếm...</span></div></div>';
                
                // Hide regular content, show search results
                mainContentSections.forEach(section => {
                    section.style.display = 'none';
                });
                if (ctaSection) ctaSection.style.display = 'none';
                searchResultsContainer.style.display = 'block';
                
                // Fetch search results
                fetch(`/search?${queryParams.toString()}`)
                    .then(response => {
                        console.log('Response status:', response.status);
                        if (!response.ok) {
                            throw new Error('Network response was not ok: ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Search response:', data);
                        if (data.success === false) {
                            searchResults.innerHTML = `<div class="col-12 text-center"><p>${data.message || 'Đã xảy ra lỗi khi tìm kiếm.'}</p></div>`;
                            return;
                        }
                        
                        // Update category filter options if not already populated
                        if (data.categories && categoryFilter.options.length <= 1) {
                            data.categories.forEach(category => {
                                const option = document.createElement('option');
                                option.value = category.slug;
                                option.textContent = category.name;
                                if (currentSearchParams.category === category.slug) {
                                    option.selected = true;
                                }
                                categoryFilter.appendChild(option);
                            });
                        }
                        
                        // Update current filter values
                        if (data.filters) {
                            categoryFilter.value = data.filters.category || '';
                            minPriceFilter.value = data.filters.min_price || '';
                            maxPriceFilter.value = data.filters.max_price || '';
                        }
                        
                        // Update search result summary
                        const queryText = currentSearchParams.query ? ` cho "${currentSearchParams.query}"` : '';
                        searchResultSummary.innerHTML = `
                            <div class="alert alert-info">
                                <strong>Tìm thấy ${data.count} kết quả${queryText}</strong>
                                ${currentSearchParams.category ? `<br><span class="badge bg-secondary me-1">Danh mục: ${currentSearchParams.category}</span>` : ''}
                                ${currentSearchParams.min_price ? `<span class="badge bg-secondary me-1">Giá từ: $${currentSearchParams.min_price}</span>` : ''}
                                ${currentSearchParams.max_price ? `<span class="badge bg-secondary me-1">Giá đến: $${currentSearchParams.max_price}</span>` : ''}
                                ${Object.values(currentSearchParams).some(v => v) ? `<button id="clearFiltersBtn" class="btn btn-sm btn-outline-secondary float-end">Xóa bộ lọc</button>` : ''}
                            </div>
                        `;
                        
                        // Add event listener to clear filters button
                        const clearFiltersBtn = document.getElementById('clearFiltersBtn');
                        if (clearFiltersBtn) {
                            clearFiltersBtn.addEventListener('click', () => {
                                currentSearchParams = {
                                    query: '',
                                    category: '',
                                    min_price: '',
                                    max_price: ''
                                };
                                categoryFilter.value = '';
                                minPriceFilter.value = '';
                                maxPriceFilter.value = '';
                                searchInput.value = '';
                                searchSidebarInput.value = '';
                                performSearch();
                            });
                        }
                        
                        if (data.products && data.products.length > 0) {
                            // Clear results container
                            searchResults.innerHTML = '';
                            
                            // Add each product to results
                            data.products.forEach(product => {
                                // Safely access properties with null checks
                                const productName = product.name || 'Unknown';
                                const productSlug = product.slug || 'unknown';
                                const productImage = product.image ? `/storage/${product.image}` : '/images/no-image.jpg';
                                const productDetails = product.details || 'No details available';
                                const productPrice = product.price || 0;
                                const productSalePrice = product.sale_price || 0;
                                const finalPrice = product.on_sale && productSalePrice > 0 ? productSalePrice : productPrice;
                                const categoryName = product.category_name || 'Uncategorized';
                                
                                // Determine which badge to show
                                let badgeHtml = '';
                                if (product.is_new) {
                                    badgeHtml = '<div class="product-badge badge-new">New</div>';
                                } else if (product.on_sale) {
                                    badgeHtml = '<div class="product-badge badge-sale">Sale</div>';
                                } else if (product.featured) {
                                    badgeHtml = '<div class="product-badge badge-featured">Featured</div>';
                                }
                                
                                const productEl = document.createElement('div');
                                productEl.className = 'col-md-6 col-lg-4 mb-4 product-card';
                                
                                productEl.innerHTML = `
                                    <div class="card h-100 position-relative">
                                        ${badgeHtml}
                                        
                                        <div class="wishlist-btn" data-product-id="${product.id}">
                                            <i class="far fa-heart"></i>
                                        </div>
                                        
                                        <img src="${productImage}" class="card-img-top" alt="${productName}" onerror="this.src='/images/no-image.jpg'">
                                        
                                        <div class="card-body p-3">
                                            <span class="badge bg-secondary mb-2">${categoryName}</span>
                                            <h5 class="product-title">${productName}</h5>
                                            <p class="product-specs">${productDetails}</p>
                                            
                                            <div class="product-features">
                                                <div class="feature">
                                                    <i class="fas fa-tachometer-alt"></i>
                                                    <span>${Math.floor(Math.random() * 2480) + 20} Miles</span>
                                                </div>
                                                <div class="feature">
                                                    <i class="fas fa-gas-pump"></i>
                                                    <span>${['Petrol', 'Diesel', 'Hybrid', 'Electric'][Math.floor(Math.random() * 4)]}</span>
                                                </div>
                                                <div class="feature">
                                                    <i class="fas fa-cog"></i>
                                                    <span>${['Automatic', 'Manual'][Math.floor(Math.random() * 2)]}</span>
                                                </div>
                                            </div>
                                            
                                            <div class="product-price">
                                                $${finalPrice.toLocaleString()}
                                                ${product.on_sale && productSalePrice > 0 ? 
                                                    `<small class="text-muted text-decoration-line-through ms-2">$${productPrice.toLocaleString()}</small>` : ''}
                                            </div>
                                            
                                            <div class="d-flex mt-3">
                                                <a href="/products/${productSlug}" class="view-details me-2">
                                                    View Details <i class="fas fa-arrow-right"></i>
                                                </a>
                                                <form action="/cart/add" method="POST">
                                                    <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                                                    <input type="hidden" name="product_id" value="${product.id}">
                                                    <input type="hidden" name="quantity" value="1">
                                                    <button type="submit" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-cart-plus"></i> Add to Cart
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                searchResults.appendChild(productEl);
                            });
                        } else {
                            searchResults.innerHTML = '<div class="col-12 text-center"><p>Không tìm thấy xe nào phù hợp với tiêu chí tìm kiếm.</p></div>';
                        }
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                        searchResults.innerHTML = '<div class="col-12 text-center"><p>Đã xảy ra lỗi khi tìm kiếm. Vui lòng thử lại sau.</p><p class="text-muted small">Chi tiết lỗi: ' + error.message + '</p></div>';
                    });
            }
            
            // Search form submission (main navbar)
            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const query = searchInput.value.trim();
                
                if (query.length > 0) {
                    searchSidebarInput.value = query;
                    performSearch({ query });
                }
            });
            
            // Search form in sidebar
            searchSidebarForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const query = searchSidebarInput.value.trim();
                
                if (query.length > 0) {
                    searchInput.value = query;
                    performSearch({ query });
                }
            });
            
            // Filter form submission
            searchFilterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                performSearch({
                    category: categoryFilter.value,
                    min_price: minPriceFilter.value,
                    max_price: maxPriceFilter.value
                });
            });
            
            // Back to home button
            backToHomeBtn.addEventListener('click', function() {
                // Hide search results, show regular content
                searchResultsContainer.style.display = 'none';
                mainContentSections.forEach(section => {
                    section.style.display = 'block';
                });
                if (ctaSection) ctaSection.style.display = 'block';
                
                // Clear search parameters
                currentSearchParams = {
                    query: '',
                    category: '',
                    min_price: '',
                    max_price: ''
                };
                
                // Clear search inputs
                searchInput.value = '';
                searchSidebarInput.value = '';
                categoryFilter.value = '';
                minPriceFilter.value = '';
                maxPriceFilter.value = '';
            });
        });
    </script>
</body>
</html> 