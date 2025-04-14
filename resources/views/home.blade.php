<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dream Cars - Trang chủ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Custom styles */
        :root {
            --primary-color: #1a237e;
            --secondary-color: #f44336;
            --light-bg: #f5f5f5;
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
            overflow: hidden;
            height: 500px;
        }
        
        .hero-slider img {
            width: 100%;
            height: 500px;
            object-fit: cover;
        }
        
        .hero-content {
            position: absolute;
            top: 50%;
            left: 50px;
            transform: translateY(-50%);
            max-width: 500px;
            color: white;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.6);
        }
        
        .hero-content h1 {
            font-size: 44px;
            font-weight: 800;
        }
        
        .hero-content p {
            font-size: 20px;
            margin-bottom: 30px;
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
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/">Dream Cars</a>
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
                <form class="d-flex me-2" action="{{ route('search') }}" method="GET">
                    <input class="form-control me-2" type="search" name="query" placeholder="Tìm kiếm xe..." required>
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
    <div id="heroSlider" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            @foreach($sliders as $index => $slider)
                <button type="button" data-bs-target="#heroSlider" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></button>
            @endforeach
        </div>
        <div class="carousel-inner">
            @foreach($sliders as $index => $slider)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <img src="{{ asset('storage/' . $slider->image) }}" class="d-block w-100" alt="{{ $slider->title }}">
                    <div class="carousel-caption hero-content text-start">
                        <h1>{{ $slider->title }}</h1>
                        <p>{{ $slider->subtitle }}</p>
                        <a href="{{ $slider->link }}" class="btn btn-primary">Khám phá ngay</a>
                    </div>
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroSlider" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroSlider" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Categories Section -->
    <div class="container mt-5">
        <h2 class="section-title">Danh mục xe</h2>
        <div class="row">
            @foreach($categories as $category)
                <div class="col-md-4 col-lg-2">
                    <a href="{{ route('category.products', $category->slug) }}" class="text-decoration-none">
                        <div class="category-card">
                            <div class="category-icon">
                                @if($category->name == 'Sedan')
                                    <i class="fas fa-car"></i>
                                @elseif($category->name == 'SUV')
                                    <i class="fas fa-truck-monster"></i>
                                @elseif($category->name == 'Hatchback')
                                    <i class="fas fa-car-side"></i>
                                @elseif($category->name == 'Luxury')
                                    <i class="fas fa-gem"></i>
                                @elseif($category->name == 'Sports Car')
                                    <i class="fas fa-tachometer-alt"></i>
                                @elseif($category->name == 'Electric')
                                    <i class="fas fa-bolt"></i>
                                @else
                                    <i class="fas fa-car-alt"></i>
                                @endif
                            </div>
                            <h5>{{ $category->name }}</h5>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Featured Products -->
    <div class="container mt-5">
        <h2 class="section-title">Xe nổi bật</h2>
        <div class="row">
            @foreach($featuredProducts as $product)
                <div class="col-md-6 col-lg-3 mb-4 product-card">
                    <div class="card h-100">
                        @if($product->is_new)
                            <span class="badge badge-new">Mới</span>
                        @elseif($product->on_sale)
                            <span class="badge badge-sale">Giảm giá</span>
                        @endif
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                            <div class="d-flex align-items-center mb-3">
                                @if($product->on_sale && $product->sale_price)
                                    <span class="price sale-price">${{ number_format($product->sale_price) }}</span>
                                    <span class="original-price">${{ number_format($product->price) }}</span>
                                @else
                                    <span class="price">${{ number_format($product->price) }}</span>
                                @endif
                            </div>
                            <div class="d-flex">
                                <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-primary me-2">Chi tiết</a>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-shopping-cart"></i> Thêm vào giỏ</button>
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
                    <div class="card h-100">
                        @if($product->is_new)
                            <span class="badge badge-new">Mới</span>
                        @elseif($product->on_sale)
                            <span class="badge badge-sale">Giảm giá</span>
                        @endif
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                            <div class="d-flex align-items-center mb-3">
                                @if($product->on_sale && $product->sale_price)
                                    <span class="price sale-price">${{ number_format($product->sale_price) }}</span>
                                    <span class="original-price">${{ number_format($product->price) }}</span>
                                @else
                                    <span class="price">${{ number_format($product->price) }}</span>
                                @endif
                            </div>
                            <div class="d-flex">
                                <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-primary me-2">Chi tiết</a>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-shopping-cart"></i> Thêm vào giỏ</button>
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
                    <div class="card h-100">
                        <span class="badge badge-sale">Giảm giá</span>
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                            <div class="d-flex align-items-center mb-3">
                                <span class="price sale-price">${{ number_format($product->sale_price) }}</span>
                                <span class="original-price">${{ number_format($product->price) }}</span>
                            </div>
                            <div class="d-flex">
                                <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-primary me-2">Chi tiết</a>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-shopping-cart"></i> Thêm vào giỏ</button>
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
                    <h5>Dream Cars</h5>
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
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> info@dreamcars.com</li>
                        <li class="mb-2"><i class="fas fa-clock me-2"></i> Thứ 2 - Thứ 7: 8:00 - 18:00</li>
                    </ul>
                </div>
            </div>
            <hr class="mt-4 mb-3" style="border-color: rgba(255,255,255,0.1);">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">&copy; 2023 Dream Cars. Tất cả quyền được bảo lưu.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0">Thiết kế bởi Dream Cars Team</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Messenger Chat Plugin -->
    <div id="fb-root"></div>
    <div id="fb-customer-chat" class="fb-customerchat"></div>

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

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Product card animation
        document.addEventListener('DOMContentLoaded', function() {
            const productCards = document.querySelectorAll('.product-card');
            
            // Intersection Observer for animation
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });
            
            productCards.forEach(card => {
                observer.observe(card);
            });
            
            // Update cart count from session
            fetch('/cart/count')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('cart-count').textContent = data.count;
                });
        });
    </script>
</body>
</html> 