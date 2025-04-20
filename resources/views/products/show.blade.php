@extends('layouts.main')

@section('title', $product->name)

@section('content')
<div class="container mt-4">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Sản phẩm</a></li>
            @if($product->category)
            <li class="breadcrumb-item"><a href="{{ route('category.products', $product->category->slug) }}">{{ $product->category->name }}</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row mb-4">
        <div class="col-md-8">
            <h1>{{ $product->name }} {{ isset($product->year) ? $product->year : '' }}</h1>
            <div class="d-flex align-items-center mt-2">
                <div class="me-3">
                    @if(isset($avgRating))
                    <div class="rating">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= round($avgRating) ? 'text-warning' : 'text-muted' }}"></i>
                        @endfor
                        <span class="ms-2">{{ number_format($avgRating, 1) }} ({{ $reviewsCount }} đánh giá)</span>
                    </div>
                    @endif
                </div>
                <div class="ms-auto">
                    <button class="btn btn-sm btn-outline-primary me-2">
                        <i class="fas fa-share-alt"></i> Chia sẻ
                    </button>
                    <button class="btn btn-sm btn-outline-danger wishlist-btn" data-product-id="{{ $product->id }}">
                        <i class="far fa-heart"></i> Yêu thích
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <div class="price-tag">
                <div class="text-muted small">Giá</div>
                <div class="fs-2 fw-bold text-primary">${{ number_format($product->price, 0) }}</div>
                @if($product->on_sale && $product->sale_price)
                    <div class="text-decoration-line-through text-muted">
                        ${{ number_format($product->sale_price, 0) }}
                    </div>
                @endif
                
                <div class="mt-3">
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <div class="d-flex align-items-center mb-3">
                            <label for="quantity" class="me-3">Số lượng:</label>
                            <div class="input-group" style="width: 120px;">
                                <button type="button" class="btn btn-outline-secondary qty-btn" data-action="decrease">-</button>
                                <input type="number" class="form-control text-center" id="quantity" name="quantity" value="1" min="1" max="{{ $product->quantity ?? 99 }}">
                                <button type="button" class="btn btn-outline-secondary qty-btn" data-action="increase">+</button>
                            </div>
                        </div>
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-cart-plus me-2"></i>Thêm vào giỏ hàng
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-md-8">
            <!-- Main Gallery -->
            <div class="product-gallery-main mb-3">
                @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid w-100" alt="{{ $product->name }}" id="main-product-image">
                @else
                <img src="{{ asset('images/no-image.jpg') }}" class="img-fluid w-100" alt="No image available" id="main-product-image">
                @endif
                <button class="btn btn-sm btn-outline-primary position-absolute bottom-0 start-0 m-3">
                    <i class="fas fa-images"></i> Xem tất cả ảnh
                </button>
            </div>

            <!-- Thumbnails -->
            <div class="row product-gallery-thumbs">
                @if($product->image)
                <div class="col-3 mb-3">
                    <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded cursor-pointer product-thumbnail active" data-src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                </div>
                @endif
                
                @if($product->images && is_array($product->images))
                    @foreach($product->images as $image)
                    <div class="col-3 mb-3">
                        <img src="{{ asset('storage/' . $image) }}" class="img-fluid rounded cursor-pointer product-thumbnail" data-src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}">
                    </div>
                    @endforeach
                @endif
            </div>
        </div>

        <div class="col-md-4">
            <div class="card contact-seller-card p-3 mb-3">
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar me-3">
                        <img src="{{ asset('storage/3aae9c20-e837-4e83-8e2f-f4e2f5e9a6c2.png') }}" class="rounded-circle" width="50" height="50" alt="Seller">
                    </div>
                    <div>
                        <h5 class="mb-0">{{ isset($product->seller) ? $product->seller->name : 'Admin' }}</h5>
                        <div class="text-muted small">Tư vấn viên</div>
                    </div>
                </div>
                <button class="btn btn-primary mb-2">
                    <i class="fas fa-phone-alt"></i> Liên hệ ngay
                </button>
                <button class="btn btn-outline-primary">
                    <i class="fas fa-comment"></i> Gửi tin nhắn
                </button>
            </div>
        </div>
    </div>

    <!-- Car Overview -->
    <div class="car-overview mb-5">
        <h3 class="section-title mb-4">Tổng quan</h3>
        <div class="row g-4">
            <div class="col-md-3 col-6">
                <div class="overview-item d-flex align-items-center">
                    <i class="fas fa-car-side text-primary me-3 fa-2x"></i>
                    <div>
                        <div class="text-muted small">Hãng xe</div>
                        <div class="fw-bold">{{ $product->category ? $product->category->name : 'N/A' }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="overview-item d-flex align-items-center">
                    <i class="fas fa-calendar-alt text-primary me-3 fa-2x"></i>
                    <div>
                        <div class="text-muted small">Năm sản xuất</div>
                        <div class="fw-bold">{{ isset($product->year) ? $product->year : 'N/A' }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="overview-item d-flex align-items-center">
                    <i class="fas fa-tachometer-alt text-primary me-3 fa-2x"></i>
                    <div>
                        <div class="text-muted small">Số Km</div>
                        <div class="fw-bold">{{ isset($product->mileage) ? number_format($product->mileage) . ' km' : 'N/A' }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="overview-item d-flex align-items-center">
                    <i class="fas fa-gas-pump text-primary me-3 fa-2x"></i>
                    <div>
                        <div class="text-muted small">Nhiên liệu</div>
                        <div class="fw-bold">{{ isset($product->fuel_type) ? $product->fuel_type : 'N/A' }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="overview-item d-flex align-items-center">
                    <i class="fas fa-cogs text-primary me-3 fa-2x"></i>
                    <div>
                        <div class="text-muted small">Hộp số</div>
                        <div class="fw-bold">{{ isset($product->transmission) ? $product->transmission : 'N/A' }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="overview-item d-flex align-items-center">
                    <i class="fas fa-car text-primary me-3 fa-2x"></i>
                    <div>
                        <div class="text-muted small">Động cơ</div>
                        <div class="fw-bold">{{ isset($product->engine) ? $product->engine : 'N/A' }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="overview-item d-flex align-items-center">
                    <i class="fas fa-palette text-primary me-3 fa-2x"></i>
                    <div>
                        <div class="text-muted small">Màu sắc</div>
                        <div class="fw-bold">{{ isset($product->color) ? $product->color : 'N/A' }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="overview-item d-flex align-items-center">
                    <i class="fas fa-user-friends text-primary me-3 fa-2x"></i>
                    <div>
                        <div class="text-muted small">Số chỗ</div>
                        <div class="fw-bold">{{ isset($product->seats) ? $product->seats . ' chỗ' : 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Description -->
    <div class="description mb-5">
        <h3 class="section-title mb-4">Mô tả</h3>
        <div class="card">
            <div class="card-body">
                {!! $product->description !!}
            </div>
        </div>
    </div>

    <!-- Features -->
    <div class="features mb-5">
        <h3 class="section-title mb-4">Tính năng</h3>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <h5>Ngoại thất</h5>
                        <ul class="list-unstyled feature-list">
                            <li><i class="fas fa-check-circle text-success me-2"></i> Đèn LED</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i> Gương kính điện</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i> Mâm xe hợp kim</li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h5>Nội thất</h5>
                        <ul class="list-unstyled feature-list">
                            <li><i class="fas fa-check-circle text-success me-2"></i> Ghế da cao cấp</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i> Vô lăng bọc da</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i> Điều hòa tự động</li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h5>An toàn</h5>
                        <ul class="list-unstyled feature-list">
                            <li><i class="fas fa-check-circle text-success me-2"></i> Chống bó cứng phanh ABS</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i> Cân bằng điện tử ESC</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i> Túi khí an toàn</li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h5>Tiện nghi</h5>
                        <ul class="list-unstyled feature-list">
                            <li><i class="fas fa-check-circle text-success me-2"></i> Màn hình cảm ứng</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i> Kết nối bluetooth</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i> Camera lùi</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dimensions & Capacity -->
    <div class="dimensions mb-5">
        <h3 class="section-title mb-4">Kích thước & Dung tích</h3>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Chiều dài</td>
                                    <td class="text-end">{{ isset($product->length) ? $product->length . ' mm' : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>Chiều rộng</td>
                                    <td class="text-end">{{ isset($product->width) ? $product->width . ' mm' : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>Chiều cao</td>
                                    <td class="text-end">{{ isset($product->height) ? $product->height . ' mm' : 'N/A' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-4">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Chiều dài cơ sở</td>
                                    <td class="text-end">{{ isset($product->wheelbase) ? $product->wheelbase . ' mm' : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>Khoảng sáng gầm</td>
                                    <td class="text-end">{{ isset($product->ground_clearance) ? $product->ground_clearance . ' mm' : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>Trọng lượng</td>
                                    <td class="text-end">{{ isset($product->weight) ? $product->weight . ' kg' : 'N/A' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-4">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Dung tích nhiên liệu</td>
                                    <td class="text-end">{{ isset($product->fuel_capacity) ? $product->fuel_capacity . ' lít' : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>Dung tích khoang hành lý</td>
                                    <td class="text-end">{{ isset($product->boot_space) ? $product->boot_space . ' lít' : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>Số chỗ ngồi</td>
                                    <td class="text-end">{{ isset($product->seats) ? $product->seats . ' chỗ' : 'N/A' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Engine and Transmission -->
    <div class="engine mb-5">
        <h3 class="section-title mb-4">Động cơ & Hộp số</h3>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Loại động cơ</td>
                                    <td class="text-end">{{ isset($product->engine_type) ? $product->engine_type : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>Dung tích động cơ</td>
                                    <td class="text-end">{{ isset($product->engine_capacity) ? $product->engine_capacity . ' cc' : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>Công suất cực đại</td>
                                    <td class="text-end">{{ isset($product->max_power) ? $product->max_power . ' hp' : 'N/A' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Mô-men xoắn cực đại</td>
                                    <td class="text-end">{{ isset($product->max_torque) ? $product->max_torque . ' Nm' : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>Loại hộp số</td>
                                    <td class="text-end">{{ isset($product->transmission) ? $product->transmission : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>Hệ thống dẫn động</td>
                                    <td class="text-end">{{ isset($product->drive_type) ? $product->drive_type : 'N/A' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Location -->
    <div class="location mb-5">
        <h3 class="section-title mb-4">Vị trí</h3>
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <i class="fas fa-map-marker-alt text-danger me-2"></i> {{ isset($product->location) ? $product->location : 'Hồ Chí Minh' }}
                </div>
                <div class="map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.5177580035945!2d106.69891121471824!3d10.771607992323746!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f40a3b49e59%3A0xa1bd14e483a602db!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBLaG9hIGjhu41jIFThu7Egbmhpw6puIFRQLkhDTQ!5e0!3m2!1svi!2s!4v1650593770995!5m2!1svi!2s" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- Financing Calculator -->
    <div class="financing mb-5">
        <h3 class="section-title mb-4">Tính toán tài chính</h3>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="loan-amount" class="form-label">Giá xe</label>
                            <input type="number" class="form-control" id="loan-amount" value="{{ $product->price }}">
                        </div>
                        <div class="mb-3">
                            <label for="down-payment" class="form-label">Số tiền trả trước</label>
                            <input type="number" class="form-control" id="down-payment" value="{{ round($product->price * 0.2) }}">
                        </div>
                        <div class="mb-3">
                            <label for="interest-rate" class="form-label">Lãi suất (%)</label>
                            <input type="number" class="form-control" id="interest-rate" value="7.5">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="loan-term" class="form-label">Thời hạn vay (tháng)</label>
                            <input type="range" class="form-range" id="loan-term" min="12" max="84" step="12" value="60">
                            <div class="d-flex justify-content-between">
                                <span>12 tháng</span>
                                <span id="term-value">60 tháng</span>
                                <span>84 tháng</span>
                            </div>
                        </div>
                        <div class="result-container p-3 bg-light rounded mt-4">
                            <div class="row">
                                <div class="col-6">
                                    <div class="text-muted mb-1">Trả hàng tháng</div>
                                    <div class="fs-4 fw-bold text-primary">$1,250</div>
                                </div>
                                <div class="col-6">
                                    <div class="text-muted mb-1">Tổng tiền trả</div>
                                    <div class="fs-4 fw-bold">$75,000</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <button class="btn btn-primary" id="calculate-loan">Tính toán</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews -->
    <div class="reviews mb-5">
        <h3 class="section-title mb-4">Đánh giá ({{ $reviewsCount }})</h3>
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center mb-4">
                    <div class="col-md-3 text-center">
                        <div class="display-4 fw-bold text-primary">{{ number_format($avgRating, 1) }}</div>
                        <div class="rating">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= round($avgRating) ? 'text-warning' : 'text-muted' }}"></i>
                            @endfor
                        </div>
                        <div class="mt-2">{{ $reviewsCount }} đánh giá</div>
                    </div>
                    <div class="col-md-9">
                        @if(isset($product->reviews) && $product->reviews->count() > 0)
                            <div class="review-list">
                                @foreach($product->reviews as $review)
                                <div class="review-item p-3 border-bottom">
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="{{ asset('images/default-avatar.jpg') }}" class="rounded-circle me-3" width="40" height="40" alt="User">
                                        <div>
                                            <div class="fw-bold">{{ $review->user->name }}</div>
                                            <div class="text-muted small">{{ $review->created_at->format('d/m/Y') }}</div>
                                        </div>
                                        <div class="ms-auto">
                                            <div class="rating">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        {{ $review->comment }}
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center">Chưa có đánh giá nào. Hãy để lại đánh giá đầu tiên!</p>
                        @endif
                    </div>
                </div>

                <div class="add-review mt-4">
                    <h4>Thêm đánh giá</h4>
                    @auth
                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="mb-3">
                            <label class="form-label d-block">Đánh giá của bạn</label>
                            <div class="rating-input">
                                <div class="rating-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                    <i class="far fa-star rating-star" data-value="{{ $i }}"></i>
                                    @endfor
                                </div>
                                <input type="hidden" name="rating" id="rating-value" value="0">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="comment" class="form-label">Nhận xét của bạn</label>
                            <textarea class="form-control" name="comment" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                    </form>
                    @else
                    <div class="alert alert-info">
                        <p>Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để viết đánh giá.</p>
                    </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <div class="related-products mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="section-title mb-0">Sản phẩm liên quan</h3>
            <a href="#" class="btn btn-link">Xem thêm</a>
        </div>
        
        <div class="row">
            @foreach($relatedProducts as $relatedProduct)
            <div class="col-md-3 mb-4">
                <div class="card product-card h-100">
                    <div class="position-relative product-image-container">
                        <a href="{{ route('products.show', $relatedProduct->slug) }}">
                            @if($relatedProduct->image)
                            <img src="{{ asset('storage/' . $relatedProduct->image) }}" class="card-img-top product-image" alt="{{ $relatedProduct->name }}">
                            @else
                            <img src="{{ asset('images/no-image.jpg') }}" class="card-img-top product-image" alt="No image available">
                            @endif
                        </a>
                        <button class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2 rounded-circle wishlist-btn" data-product-id="{{ $relatedProduct->id }}">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('products.show', $relatedProduct->slug) }}" class="text-decoration-none text-dark">{{ $relatedProduct->name }}</a>
                        </h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-bold text-primary">${{ number_format($relatedProduct->price, 0) }}</span>
                            <span class="text-muted">{{ isset($relatedProduct->year) ? $relatedProduct->year : '' }}</span>
                        </div>
                        <div class="product-features small text-muted">
                            <div class="row g-2">
                                <div class="col-6">
                                    <i class="fas fa-tachometer-alt me-1"></i> {{ isset($relatedProduct->mileage) ? number_format($relatedProduct->mileage) . ' km' : 'N/A' }}
                                </div>
                                <div class="col-6">
                                    <i class="fas fa-gas-pump me-1"></i> {{ isset($relatedProduct->fuel_type) ? $relatedProduct->fuel_type : 'N/A' }}
                                </div>
                                <div class="col-6">
                                    <i class="fas fa-cogs me-1"></i> {{ isset($relatedProduct->transmission) ? $relatedProduct->transmission : 'N/A' }}
                                </div>
                                <div class="col-6">
                                    <i class="fas fa-map-marker-alt me-1"></i> {{ isset($relatedProduct->location) ? $relatedProduct->location : 'N/A' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .cursor-pointer {
        cursor: pointer;
    }
    
    .product-gallery-main {
        position: relative;
        height: 400px;
        overflow: hidden;
        border-radius: 8px;
    }
    
    .product-gallery-main img {
        object-fit: cover;
        height: 100%;
        width: 100%;
    }
    
    .product-thumbnail {
        border: 2px solid transparent;
        transition: all 0.3s;
    }
    
    .product-thumbnail:hover, .product-thumbnail.active {
        border-color: #0d6efd;
    }
    
    .section-title {
        position: relative;
        padding-bottom: 10px;
    }
    
    .section-title:after {
        content: '';
        display: block;
        width: 50px;
        height: 3px;
        background-color: #0d6efd;
        position: absolute;
        bottom: 0;
        left: 0;
    }
    
    .rating-stars {
        display: inline-block;
        font-size: 1.5rem;
    }
    
    .rating-star {
        cursor: pointer;
        color: #ccc;
        transition: color 0.2s;
    }
    
    .rating-star:hover, .rating-star.active {
        color: #ffc107;
    }
    
    .contact-seller-card {
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    
    .overview-item {
        padding: 15px;
        border-radius: 8px;
        background-color: #f8f9fa;
        height: 100%;
    }
    
    .feature-list li {
        margin-bottom: 8px;
    }
    
    .product-card {
        transition: all 0.3s;
        border: none;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .map-container {
        border-radius: 8px;
        overflow: hidden;
    }
    
    .product-image-container {
        height: 200px;
        overflow: hidden;
    }
    
    .product-image {
        object-fit: cover;
        height: 100%;
        width: 100%;
    }
    
    .wishlist-btn {
        z-index: 5;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        border-color: #dc3545;
    }

    .wishlist-btn:hover {
        background-color: #dc3545;
        color: white;
    }

    .wishlist-btn i {
        transition: all 0.3s;
    }

    .wishlist-btn:hover i {
        color: white;
    }

    .wishlist-btn.active i {
        color: #dc3545;
    }
    
    .wishlist-btn.active {
        background-color: rgba(220, 53, 69, 0.1);
    }
    
    /* Toast notifications */
    #toast-container {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999;
    }

    .toast-notification {
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
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Quantity button handling
        const qtyBtns = document.querySelectorAll('.qty-btn');
        const qtyInput = document.getElementById('quantity');
        
        qtyBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const action = this.getAttribute('data-action');
                const currentValue = parseInt(qtyInput.value);
                const maxValue = parseInt(qtyInput.getAttribute('max'));
                
                if (action === 'increase' && currentValue < maxValue) {
                    qtyInput.value = currentValue + 1;
                } else if (action === 'decrease' && currentValue > 1) {
                    qtyInput.value = currentValue - 1;
                }
            });
        });
        
        // Product gallery
        const mainImage = document.getElementById('main-product-image');
        const thumbnails = document.querySelectorAll('.product-thumbnail');
        
        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function() {
                // Remove active class from all thumbnails
                thumbnails.forEach(t => t.classList.remove('active'));
                
                // Add active class to clicked thumbnail
                this.classList.add('active');
                
                // Update main image
                mainImage.src = this.getAttribute('data-src');
            });
        });
        
        // Review stars interactivity
        const reviewStars = document.querySelectorAll('.review-form-stars i');
        const ratingInput = document.getElementById('rating-input');
        
        if (reviewStars.length) {
            reviewStars.forEach((star, index) => {
                star.addEventListener('mouseover', function() {
                    resetStars();
                    highlightStars(index);
                });
                
                star.addEventListener('click', function() {
                    ratingInput.value = index + 1;
                });
            });
            
            document.querySelector('.review-form-stars').addEventListener('mouseout', function() {
                resetStars();
                if (ratingInput.value) {
                    highlightStars(parseInt(ratingInput.value) - 1);
                }
            });
        }
        
        function highlightStars(index) {
            reviewStars.forEach((star, i) => {
                if (i <= index) {
                    star.classList.remove('far');
                    star.classList.add('fas');
                    star.classList.add('text-warning');
                }
            });
        }
        
        function resetStars() {
            reviewStars.forEach(star => {
                star.classList.remove('fas');
                star.classList.remove('text-warning');
                star.classList.add('far');
            });
        }
        
        // Xử lý calculator
        const loanTerm = document.getElementById('loan-term');
        const termValue = document.getElementById('term-value');
        
        loanTerm.addEventListener('input', function() {
            termValue.textContent = this.value + ' tháng';
        });
        
        const calculateBtn = document.getElementById('calculate-loan');
        calculateBtn.addEventListener('click', calculateLoan);
        
        function calculateLoan() {
            const loanAmount = document.getElementById('loan-amount').value;
            const downPayment = document.getElementById('down-payment').value;
            const interestRate = document.getElementById('interest-rate').value;
            const term = document.getElementById('loan-term').value;
            
            const principal = loanAmount - downPayment;
            const monthlyRate = interestRate / 100 / 12;
            const numberOfPayments = term;
            
            const x = Math.pow(1 + monthlyRate, numberOfPayments);
            const monthly = (principal * x * monthlyRate) / (x - 1);
            
            const monthlyPayment = monthly.toFixed(2);
            const totalPayment = (monthly * numberOfPayments).toFixed(2);
            
            const resultContainer = document.querySelector('.result-container');
            resultContainer.innerHTML = `
                <div class="row">
                    <div class="col-6">
                        <div class="text-muted mb-1">Trả hàng tháng</div>
                        <div class="fs-4 fw-bold text-primary">$${numberWithCommas(monthlyPayment)}</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted mb-1">Tổng tiền trả</div>
                        <div class="fs-4 fw-bold">$${numberWithCommas(totalPayment)}</div>
                    </div>
                </div>
            `;
        }
        
        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
        
        // Wishlist functionality
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
            
            if (isLoggedIn) {
                var button = $(this);
                var productId = button.data('product-id');
                
                // Disable button temporarily
                button.css('pointer-events', 'none');
                
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
                        // Update button appearance
                        if (response.status === 'added') {
                            button.addClass('active');
                            button.find('i').removeClass('far').addClass('fas');
                            showToast('Đã thêm vào danh sách yêu thích', 'success');
                        } else {
                            button.removeClass('active');
                            button.find('i').removeClass('fas').addClass('far');
                            showToast('Đã xóa khỏi danh sách yêu thích', 'info');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Wishlist error:', error);
                        showToast('Đã xảy ra lỗi khi cập nhật yêu thích', 'error');
                    },
                    complete: function() {
                        // Re-enable button
                        button.css('pointer-events', 'auto');
                    }
                });
            } else {
                window.location.href = loginUrl;
            }
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
@endpush 