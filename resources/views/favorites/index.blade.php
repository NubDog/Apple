@extends('layouts.main')

@section('content')
<div class="favorites-container py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="favorites-title animate__animated animate__fadeIn">
                    <i class="fas fa-heart text-danger me-2"></i>Xe yêu thích của bạn
                </h1>
                
                @if($favorites->isEmpty())
                    <div class="empty-favorites animate__animated animate__fadeIn">
                        <div class="empty-icon">
                            <i class="far fa-heart"></i>
                        </div>
                        <h3>Danh sách xe yêu thích của bạn đang trống</h3>
                        <p>Bạn chưa có xe nào trong danh sách yêu thích. Hãy khám phá các xe và thêm vào danh sách yêu thích của bạn.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-car me-2"></i>Khám phá các xe
                        </a>
                    </div>
                @else
                    <div class="row">
                        @foreach($favorites as $favorite)
                            <div class="col-md-6 col-lg-4 mb-4 product-card animate__animated animate__fadeInUp" style="animation-delay: {{ $loop->iteration * 0.1 }}s">
                                <div class="favorite-item">
                                    <div class="position-relative">
                                        <div class="favorite-date">
                                            <i class="far fa-clock me-1"></i> 
                                            {{ $favorite->created_at->diffForHumans() }}
                                        </div>
                                        
                                        <button class="remove-favorite" data-product-id="{{ $favorite->product_id }}">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        
                                        <img src="{{ asset('storage/' . $favorite->product->image) }}" 
                                            class="favorite-image" 
                                            alt="{{ $favorite->product->name }}" 
                                            onerror="this.src='/images/no-image.jpg'">
                                            
                                        @if($favorite->product->on_sale)
                                            <div class="sale-badge">Giảm giá</div>
                                        @endif
                                        
                                        @if($favorite->product->is_new)
                                            <div class="new-badge">Mới</div>
                                        @endif
                                    </div>
                                    
                                    <div class="favorite-details">
                                        <h3 class="favorite-name">{{ $favorite->product->name }}</h3>
                                        <p class="favorite-specs">{{ $favorite->product->details ?? '4.0 DS PowerPulse Momentum 5dr AWD Auto' }}</p>
                                        
                                        <div class="product-features">
                                            <div class="feature">
                                                <i class="fas fa-tachometer-alt"></i>
                                                <span>{{ rand(20, 2500) }} Miles</span>
                                            </div>
                                            <div class="feature">
                                                <i class="fas fa-gas-pump"></i>
                                                <span>{{ ['Xăng', 'Dầu', 'Hybrid', 'Điện'][rand(0, 3)] }}</span>
                                            </div>
                                            <div class="feature">
                                                <i class="fas fa-cog"></i>
                                                <span>{{ ['Tự động', 'Số sàn'][rand(0, 1)] }}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="favorite-price">
                                            @if($favorite->product->on_sale)
                                                <span class="old-price">{{ number_format($favorite->product->price) }} ₫</span>
                                                <span class="current-price">{{ number_format($favorite->product->sale_price) }} ₫</span>
                                            @else
                                                <span class="current-price">{{ number_format($favorite->product->price) }} ₫</span>
                                            @endif
                                        </div>
                                        
                                        <div class="favorite-actions">
                                            <a href="{{ route('products.show', $favorite->product->slug) }}" class="btn btn-outline-primary">
                                                <i class="fas fa-eye me-2"></i>Chi tiết
                                            </a>
                                            
                                            <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $favorite->product_id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-shopping-cart me-2"></i>Đặt hàng
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $favorites->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    .favorites-container {
        background-color: #f8f9fa;
        min-height: 70vh;
    }
    
    .favorites-title {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 2rem;
        color: #333;
        position: relative;
        padding-bottom: 15px;
    }
    
    .favorites-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 4px;
        background: linear-gradient(to right, #ff7e5f, #feb47b);
        border-radius: 2px;
    }
    
    .empty-favorites {
        text-align: center;
        padding: 3rem;
        background-color: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }
    
    .empty-icon {
        font-size: 5rem;
        color: #ddd;
        margin-bottom: 1.5rem;
    }
    
    .empty-favorites h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: #333;
    }
    
    .empty-favorites p {
        color: #777;
        max-width: 500px;
        margin: 0 auto 1.5rem;
        line-height: 1.6;
    }
    
    .favorite-item {
        background-color: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .favorite-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }
    
    .favorite-image {
        height: 220px;
        width: 100%;
        object-fit: cover;
        transition: all 0.5s ease;
    }
    
    .favorite-item:hover .favorite-image {
        transform: scale(1.05);
    }
    
    .favorite-date {
        position: absolute;
        top: 15px;
        left: 15px;
        background-color: rgba(255, 255, 255, 0.9);
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        color: #666;
    }
    
    .remove-favorite {
        position: absolute;
        top: 15px;
        right: 15px;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.9);
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 2;
    }
    
    .remove-favorite:hover {
        background-color: #ff5757;
        transform: rotate(90deg);
    }
    
    .remove-favorite:hover i {
        color: white;
    }
    
    .sale-badge, .new-badge {
        position: absolute;
        bottom: 15px;
        left: 15px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .sale-badge {
        background-color: #ff5757;
        color: white;
    }
    
    .new-badge {
        background-color: #4ade80;
        color: white;
    }
    
    .favorite-details {
        padding: 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    
    .favorite-name {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 8px;
        color: #333;
    }
    
    .favorite-specs {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 15px;
    }
    
    .product-features {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 15px;
    }
    
    .feature {
        display: flex;
        align-items: center;
        font-size: 0.85rem;
        color: #666;
    }
    
    .feature i {
        margin-right: 5px;
        color: #4070f4;
    }
    
    .favorite-price {
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .current-price {
        font-size: 1.3rem;
        font-weight: 700;
        color: #ff5757;
    }
    
    .old-price {
        text-decoration: line-through;
        color: #999;
        font-size: 1rem;
    }
    
    .favorite-actions {
        margin-top: auto;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }
    
    .favorite-actions .btn {
        padding: 8px 15px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .favorite-actions .btn:hover {
        transform: translateY(-3px);
    }
    
    .favorite-actions .btn-primary {
        background-color: #4070f4;
        border-color: #4070f4;
    }
    
    .favorite-actions .btn-primary:hover {
        background-color: #3060e0;
        border-color: #3060e0;
    }
    
    .favorite-actions .btn-outline-primary {
        color: #4070f4;
        border-color: #4070f4;
    }
    
    .favorite-actions .btn-outline-primary:hover {
        background-color: #4070f4;
        color: white;
    }
    
    @media (max-width: 992px) {
        .favorite-actions {
            grid-template-columns: 1fr;
        }
    }
    
    /* Animation classes */
    .animate__fadeInUp {
        animation-duration: 0.6s;
    }
    
    .animate__fadeIn {
        animation-duration: 1s;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle remove favorite buttons
        document.querySelectorAll('.remove-favorite').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.dataset.productId;
                const card = this.closest('.product-card');
                
                // Confirm before removing
                if (confirm('Bạn có chắc muốn xóa xe này khỏi danh sách yêu thích?')) {
                    removeFavorite(productId, card);
                }
            });
        });
        
        function removeFavorite(productId, card) {
            fetch('{{ route("favorites.toggle") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ product_id: productId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'removed') {
                    // Add animation before removing
                    card.classList.add('animate__animated', 'animate__fadeOutRight');
                    
                    // Remove the card after animation completes
                    setTimeout(() => {
                        card.remove();
                        
                        // Check if there are no more favorites
                        if (document.querySelectorAll('.product-card').length === 0) {
                            location.reload(); // Reload to show empty state
                        }
                    }, 500);
                    
                    // Show notification
                    showNotification('Đã xóa khỏi danh sách yêu thích', 'success');
                }
            })
            .catch(error => {
                console.error('Error removing favorite:', error);
                showNotification('Đã xảy ra lỗi. Vui lòng thử lại.', 'error');
            });
        }
        
        function showNotification(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `toast-notification toast-${type}`;
            toast.innerHTML = `
                <div class="toast-icon">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'}"></i>
                </div>
                <div class="toast-message">${message}</div>
            `;
            
            document.body.appendChild(toast);
            
            // Trigger animation
            setTimeout(() => {
                toast.classList.add('show');
            }, 10);
            
            // Remove after 3 seconds
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            }, 3000);
        }
    });
</script>

<style>
    .toast-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        min-width: 300px;
        background-color: white;
        color: #333;
        padding: 15px 20px;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: center;
        z-index: 9999;
        transform: translateY(-20px);
        opacity: 0;
        transition: all 0.3s ease;
    }
    
    .toast-notification.show {
        transform: translateY(0);
        opacity: 1;
    }
    
    .toast-success {
        border-left: 4px solid #4caf50;
    }
    
    .toast-error {
        border-left: 4px solid #f44336;
    }
    
    .toast-info {
        border-left: 4px solid #2196f3;
    }
    
    .toast-icon {
        margin-right: 15px;
        font-size: 22px;
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
        font-weight: 500;
    }
</style>
@endpush 