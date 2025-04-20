<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        
        .cart-dropdown:hover .dropdown-menu {
            display: block;
        }
        .cart-dropdown-menu {
            margin-top: 0;
        }
        .cart-item {
            display: flex;
            margin-bottom: 10px;
        }
        .cart-item-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            margin-right: 10px;
        }
        .cart-item-details {
            flex-grow: 1;
        }
        .cart-item-price {
            font-weight: bold;
        }
        .cart-item-remove {
            color: #dc3545;
            cursor: pointer;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Đảm bảo jQuery được tải đầu tiên -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="/">Trang chủ</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            Danh mục xe
                        </a>
                        <ul class="dropdown-menu">
                            @foreach($categories ?? [] as $category)
                                <li><a class="dropdown-item" href="{{ route('category.products', $category->slug) }}">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}" href="{{ route('products.index') }}">Tất cả xe</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact.index') ? 'active' : '' }}" href="{{ route('contact.index') }}">Liên hệ</a>
                    </li>
                </ul>
                <form class="d-flex me-2" action="{{ route('search') }}" method="GET">
                    <input class="form-control me-2" type="search" name="query" placeholder="Tìm kiếm xe..." required>
                    <button class="btn btn-secondary" type="submit"><i class="fas fa-search"></i></button>
                </form>
                <div class="d-flex">
                    <div class="cart-dropdown dropdown">
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-light me-2 cart-btn" id="cartDropdown">
                            <i class="fas fa-shopping-cart"></i> <span id="cart-count">0</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end cart-dropdown-menu p-3" style="width: 320px; max-height: 450px; overflow-y: auto;">
                            <div class="cart-dropdown-header d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Giỏ hàng của bạn</h6>
                                <span class="badge bg-primary rounded-pill" id="cart-dropdown-count">0</span>
                            </div>
                            <div class="cart-items">
                                <!-- Cart items will be loaded here via JavaScript -->
                            </div>
                            <div class="dropdown-divider my-3"></div>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('cart.index') }}" class="btn btn-primary btn-sm">Xem giỏ hàng</a>
                                <a href="{{ route('checkout.index') }}" class="btn btn-success btn-sm">Thanh toán</a>
                            </div>
                        </div>
                    </div>
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

    <!-- Flash Messages -->
    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    @yield('content')

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
                        @foreach($categories ?? [] as $category)
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

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Update cart count and dropdown contents
            function updateCart() {
                fetch('/api/cart')
                    .then(response => response.json())
                    .then(data => {
                        // Update cart count
                        const cartCount = document.getElementById('cart-count');
                        const dropdownCount = document.getElementById('cart-dropdown-count');
                        if (cartCount && dropdownCount) {
                            const count = data.items ? data.items.length : 0;
                            cartCount.textContent = count;
                            dropdownCount.textContent = count;
                        }

                        // Update dropdown contents
                        const cartItems = document.querySelector('.cart-items');
                        if (cartItems) {
                            if (data.items && data.items.length > 0) {
                                let html = '';
                                data.items.forEach(item => {
                                    html += `
                                        <div class="cart-item">
                                            <img src="${item.image}" alt="${item.name}" class="cart-item-image" onerror="this.src='/images/no-image.jpg'">
                                            <div class="cart-item-details">
                                                <div class="cart-item-name">${item.name}</div>
                                                <div class="d-flex justify-content-between">
                                                    <div class="cart-item-quantity">SL: ${item.quantity}</div>
                                                    <div class="cart-item-price">${item.price} đ</div>
                                                </div>
                                            </div>
                                            <div class="cart-item-remove" data-id="${item.id}">
                                                <i class="fas fa-times"></i>
                                            </div>
                                        </div>
                                    `;
                                });
                                cartItems.innerHTML = html;

                                // Add event listeners for remove buttons
                                document.querySelectorAll('.cart-item-remove').forEach(btn => {
                                    btn.addEventListener('click', function(e) {
                                        e.preventDefault();
                                        const id = this.getAttribute('data-id');
                                        removeFromCart(id);
                                    });
                                });
                            } else {
                                cartItems.innerHTML = '<p class="text-center text-muted">Giỏ hàng trống</p>';
                            }
                        }
                    })
                    .catch(error => console.error('Error updating cart:', error));
            }

            // Remove item from cart
            function removeFromCart(id) {
                fetch(`/api/cart/remove/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    updateCart();
                })
                .catch(error => console.error('Error removing item:', error));
            }

            // Initial cart update
            updateCart();
        });
    </script>
    
    <!-- Include Telegram Chat -->
    <x-telegram-chat />
    
    <!-- WOW.js for scroll animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    <script>
        new WOW().init();
    </script>
    
    @stack('scripts')
</body>
</html> 