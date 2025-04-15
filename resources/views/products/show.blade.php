@extends('layouts.main')

@section('title', $product->name)

@section('content')
<div class="container my-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            @if($product->category)
            <li class="breadcrumb-item"><a href="{{ route('category.products', $product->category->slug) }}">{{ $product->category->name }}</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Images -->
        <div class="col-lg-6 mb-4">
            <div class="product-gallery">
                <div class="main-image mb-3">
                    @if($product->main_image)
                    <img src="{{ asset('storage/' . $product->main_image) }}" class="img-fluid rounded" alt="{{ $product->name }}">
                    @else
                    <img src="{{ asset('images/no-image.jpg') }}" class="img-fluid rounded" alt="No image available">
                    @endif
                </div>
                @if($product->images && count($product->images) > 0)
                <div class="row thumbnails">
                    @foreach($product->images ?? collect() as $image)
                    <div class="col-3 mb-3">
                        <img src="{{ asset('storage/' . $image->path) }}" class="img-fluid rounded thumbnail" alt="{{ $product->name }}">
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-lg-6">
            <h1 class="mb-2">{{ $product->name }}</h1>
            
            <div class="mb-3">
                @if($product->status == 'new')
                <span class="badge bg-primary">Xe mới</span>
                @elseif($product->status == 'sale')
                <span class="badge bg-danger">Giảm giá</span>
                @elseif($product->status == 'featured')
                <span class="badge bg-success">Nổi bật</span>
                @endif
                
                <span class="ms-2 text-muted">SKU: {{ $product->sku }}</span>
            </div>
            
            <div class="price-section mb-4">
                @if($product->old_price)
                <del class="text-muted me-2">${{ number_format($product->old_price, 2) }}</del>
                @endif
                <span class="current-price fs-3 fw-bold text-primary">${{ number_format($product->price, 2) }}</span>
            </div>
            
            <div class="availability mb-4">
                <p>
                    <i class="fas fa-check-circle text-success me-2"></i>
                    <span>Tình trạng:</span>
                    <strong>{{ $product->quantity > 0 ? 'Còn hàng' : 'Hết hàng' }}</strong>
                    @if($product->quantity > 0)
                    <span class="ms-2 text-muted">({{ $product->quantity }} xe available)</span>
                    @endif
                </p>
            </div>
            
            <div class="short-description mb-4">
                <h5>Mô tả ngắn:</h5>
                <p>{{ $product->short_description }}</p>
            </div>
            
            <div class="features mb-4">
                <h5>Tính năng nổi bật:</h5>
                <ul>
                    @forelse($product->features ?? [] as $feature)
                    <li><i class="fas fa-check text-success me-2"></i> {{ $feature->name }}: {{ $feature->value }}</li>
                    @empty
                    <li>Không có tính năng nổi bật</li>
                    @endforelse
                </ul>
            </div>
            
            <form action="{{ route('cart.add') }}" method="POST" class="d-flex mb-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="input-group me-3" style="width: 130px;">
                    <button class="btn btn-outline-secondary" type="button" id="decrease-qty">-</button>
                    <input type="number" name="quantity" class="form-control text-center" value="1" min="1" max="{{ $product->quantity }}" id="qty-input">
                    <button class="btn btn-outline-secondary" type="button" id="increase-qty">+</button>
                </div>
                <button type="submit" class="btn btn-primary flex-grow-1"><i class="fas fa-shopping-cart me-2"></i>Thêm vào giỏ hàng</button>
            </form>
            
            <div class="d-flex mb-4">
                <form action="{{ route('favorites.toggle') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="btn btn-outline-danger me-2">
                        <i class="fas fa-heart me-1"></i> 
                        {{ auth()->check() && auth()->user()->favorites->contains($product->id) ? 'Đã yêu thích' : 'Yêu thích' }}
                    </button>
                </form>
                <a href="https://wa.me/?text={{ urlencode(route('products.show', $product->slug)) }}" class="btn btn-outline-primary me-2" target="_blank">
                    <i class="fab fa-whatsapp me-1"></i> Chia sẻ
                </a>
            </div>
            
            <div class="product-meta">
                @if($product->category)
                <p><span>Danh mục:</span> <a href="{{ route('category.products', $product->category->slug) }}">{{ $product->category->name }}</a></p>
                @endif
                <p><span>Tags:</span> 
                    @forelse($product->tags ?? [] as $tag)
                    <a href="{{ route('tag.products', $tag->slug) }}" class="badge rounded-pill bg-light text-dark text-decoration-none me-1">{{ $tag->name }}</a>
                    @empty
                    <span class="text-muted">Không có tags</span>
                    @endforelse
                </p>
            </div>
        </div>
    </div>
    
    <!-- Product Details Tabs -->
    <div class="row mt-5">
        <div class="col-12">
            <ul class="nav nav-tabs" id="productTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">Mô tả chi tiết</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs" type="button" role="tab">Thông số kỹ thuật</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">Đánh giá ({{ isset($product->reviews) ? $product->reviews->count() : 0 }})</button>
                </li>
            </ul>
            <div class="tab-content p-4 border border-top-0 rounded-bottom" id="productTabsContent">
                <div class="tab-pane fade show active" id="description" role="tabpanel">
                    {!! $product->description !!}
                </div>
                <div class="tab-pane fade" id="specs" role="tabpanel">
                    <table class="table table-striped">
                        <tbody>
                            @forelse($product->features ?? [] as $feature)
                            <tr>
                                <th style="width: 30%">{{ $feature->name }}</th>
                                <td>{{ $feature->value }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center">Không có thông số kỹ thuật</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                    <div class="reviews-container">
                        @if(isset($product->reviews) && $product->reviews->count() > 0)
                            @foreach($product->reviews as $review)
                                <div class="review-item">
                                    <div class="review-header">
                                        <div class="reviewer-info">
                                            <div class="reviewer-name">{{ $review->user->name }}</div>
                                            <div class="review-date">{{ $review->created_at->format('d/m/Y') }}</div>
                                        </div>
                                        <div class="rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="bi bi-star-fill {{ $i <= $review->rating ? 'filled' : '' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="review-content">
                                        {{ $review->content }}
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>Chưa có đánh giá nào. Hãy để lại đánh giá đầu tiên!</p>
                        @endif
                        
                        @auth
                        <h4 class="mt-4">Viết đánh giá</h4>
                        <form action="{{ route('reviews.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="mb-3">
                                <label class="form-label">Đánh giá của bạn</label>
                                <div class="rating-input">
                                    <div class="stars">
                                        <i class="star-rating-input far fa-star" data-value="1"></i>
                                        <i class="star-rating-input far fa-star" data-value="2"></i>
                                        <i class="star-rating-input far fa-star" data-value="3"></i>
                                        <i class="star-rating-input far fa-star" data-value="4"></i>
                                        <i class="star-rating-input far fa-star" data-value="5"></i>
                                    </div>
                                    <input type="hidden" name="rating" id="rating-value" value="0">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="comment" class="form-label">Nhận xét của bạn</label>
                                <textarea class="form-control" name="comment" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                        </form>
                        @else
                        <div class="alert alert-info mt-4">
                            <p>Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để viết đánh giá.</p>
                        </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
    <div class="related-products mt-5">
        <h3 class="mb-4">Sản phẩm liên quan</h3>
        <div class="row">
            @foreach($relatedProducts as $relatedProduct)
            <div class="col-md-3 mb-4">
                <div class="card product-card h-100">
                    <div class="position-relative">
                        @if($relatedProduct->status == 'new')
                        <span class="badge bg-primary position-absolute top-0 start-0 m-2">Mới</span>
                        @elseif($relatedProduct->status == 'sale')
                        <span class="badge bg-danger position-absolute top-0 start-0 m-2">Giảm giá</span>
                        @endif
                        @if($relatedProduct->main_image)
                        <img src="{{ asset('storage/' . $relatedProduct->main_image) }}" class="card-img-top" alt="{{ $relatedProduct->name }}">
                        @else
                        <img src="{{ asset('images/no-image.jpg') }}" class="card-img-top" alt="No image available">
                        @endif
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $relatedProduct->name }}</h5>
                        <div class="price-section mb-3">
                            @if($relatedProduct->old_price)
                            <del class="text-muted me-2">${{ number_format($relatedProduct->old_price, 2) }}</del>
                            @endif
                            <span class="current-price fw-bold text-primary">${{ number_format($relatedProduct->price, 2) }}</span>
                        </div>
                        <a href="{{ route('products.show', $relatedProduct->slug) }}" class="btn btn-outline-primary btn-sm">Chi tiết</a>
                        <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $relatedProduct->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-shopping-cart"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .product-gallery .thumbnail {
        cursor: pointer;
        transition: all 0.3s;
        border: 2px solid transparent;
    }
    
    .product-gallery .thumbnail:hover {
        border-color: var(--primary-color);
    }
    
    .rating .fas, .rating .far {
        color: #ffc107;
    }
    
    .rating-input .stars {
        display: flex;
        font-size: 24px;
    }
    
    .rating-input .star-rating-input {
        color: #ffc107;
        cursor: pointer;
        margin-right: 5px;
    }
    
    .product-card {
        transition: all 0.3s;
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
</style>
@endpush

@push('scripts')
<script>
    // Quantity input handlers
    const qtyInput = document.getElementById('qty-input');
    const decreaseBtn = document.getElementById('decrease-qty');
    const increaseBtn = document.getElementById('increase-qty');
    const maxQty = parseInt('{{ $product->quantity }}');
    
    decreaseBtn.addEventListener('click', () => {
        let currentValue = parseInt(qtyInput.value);
        if (currentValue > 1) {
            qtyInput.value = currentValue - 1;
        }
    });
    
    increaseBtn.addEventListener('click', () => {
        let currentValue = parseInt(qtyInput.value);
        if (currentValue < maxQty) {
            qtyInput.value = currentValue + 1;
        }
    });
    
    // Image gallery
    const thumbnails = document.querySelectorAll('.thumbnail');
    const mainImage = document.querySelector('.main-image img');
    
    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', () => {
            mainImage.src = thumbnail.src;
        });
    });
    
    // Rating input
    const stars = document.querySelectorAll('.star-rating-input');
    const ratingInput = document.getElementById('rating-value');
    
    stars.forEach(star => {
        star.addEventListener('click', () => {
            const value = parseInt(star.getAttribute('data-value'));
            ratingInput.value = value;
            
            // Update stars visually
            stars.forEach((s, index) => {
                if (index < value) {
                    s.classList.remove('far');
                    s.classList.add('fas');
                } else {
                    s.classList.remove('fas');
                    s.classList.add('far');
                }
            });
        });
        
        star.addEventListener('mouseover', () => {
            const value = parseInt(star.getAttribute('data-value'));
            
            // Highlight stars up to the hovered one
            stars.forEach((s, index) => {
                if (index < value) {
                    s.classList.remove('far');
                    s.classList.add('fas');
                } else {
                    s.classList.remove('fas');
                    s.classList.add('far');
                }
            });
        });
        
        star.addEventListener('mouseout', () => {
            const currentRating = parseInt(ratingInput.value);
            
            // Restore current rating
            stars.forEach((s, index) => {
                if (index < currentRating) {
                    s.classList.remove('far');
                    s.classList.add('fas');
                } else {
                    s.classList.remove('fas');
                    s.classList.add('far');
                }
            });
        });
    });
</script>
@endpush 