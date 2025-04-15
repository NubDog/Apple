@extends('layouts.main')

@section('content')
<div class="container py-5 animate__animated animate__fadeIn">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Page Header -->
            <div class="page-header d-flex align-items-center mb-4">
                <div class="icon-circle bg-primary text-white me-3 animate__animated animate__bounceIn">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <h2 class="page-title mb-0">Đơn hàng của tôi</h2>
            </div>
            
            <!-- Orders Container -->
            <div class="card orders-card shadow-lg">
                <div class="card-body p-0">
                    <!-- Order Statistics -->
                    <div class="order-stats p-4 mb-4">
                        <div class="row g-4">
                            <div class="col-sm-4 animate__animated animate__fadeInUp">
                                <div class="stat-card stat-total">
                                    <div class="stat-icon">
                                        <i class="fas fa-receipt"></i>
                                    </div>
                                    <div class="stat-info">
                                        <h4>{{ $orders->total() }}</h4>
                                        <p>Tổng đơn hàng</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 animate__animated animate__fadeInUp" style="animation-delay: 0.1s">
                                <div class="stat-card stat-processing">
                                    <div class="stat-icon">
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </div>
                                    <div class="stat-info">
                                        <h4>{{ $orders->where('status', 'Đang xử lý')->count() }}</h4>
                                        <p>Đang xử lý</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 animate__animated animate__fadeInUp" style="animation-delay: 0.2s">
                                <div class="stat-card stat-completed">
                                    <div class="stat-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="stat-info">
                                        <h4>{{ $orders->where('status', 'Hoàn thành')->count() }}</h4>
                                        <p>Hoàn thành</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if($orders->count() > 0)
                        <!-- Orders List -->
                        <div class="orders-list px-4">
                            @foreach($orders as $order)
                                <div class="order-item animate__animated animate__fadeInUp" style="animation-delay: {{ $loop->index * 0.1 }}s">
                                    <div class="order-header">
                                        <div class="order-id">
                                            <i class="fas fa-hashtag"></i> Đơn hàng #{{ $order->id }}
                                        </div>
                                        <div class="order-date">
                                            <i class="far fa-calendar-alt"></i> {{ $order->created_at->format('d/m/Y H:i') }}
                                        </div>
                                    </div>
                                    <div class="order-body">
                                        <div class="order-status">
                                            <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $order->status)) }}">
                                                <i class="fas fa-circle status-dot"></i> {{ $order->status }}
                                            </span>
                                        </div>
                                        <div class="order-total">
                                            <span class="amount">{{ number_format($order->total, 0, ',', '.') }}đ</span>
                                        </div>
                                        <div class="order-action">
                                            <a href="{{ route('user.order.detail', $order->id) }}" class="btn btn-sm btn-view-detail">
                                                Xem chi tiết <i class="fas fa-chevron-right ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        <div class="pagination-container p-4 mt-3">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="empty-state text-center py-5 animate__animated animate__fadeIn">
                            <div class="empty-icon mb-4">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <h4 class="mb-3">Bạn chưa có đơn hàng nào</h4>
                            <p class="text-muted mb-4">Hãy khám phá các sản phẩm của chúng tôi và đặt hàng ngay!</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary btn-shop-now">
                                <i class="fas fa-shopping-basket me-2"></i> Mua sắm ngay
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Back Button -->
            <div class="mt-4 back-btn-container animate__animated animate__fadeInUp">
                <a href="{{ route('user.account') }}" class="btn btn-back">
                    <i class="fas fa-arrow-left me-2"></i> Quay lại tài khoản
                </a>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    /* Variables */
    :root {
        --primary: #4361ee;
        --secondary: #3f37c9;
        --success: #4cc9f0;
        --info: #4895ef;
        --warning: #f72585;
        --danger: #e63946;
        --light: #f8f9fa;
        --dark: #212529;
        --processing: #ffb703;
        --completed: #06d6a0;
        --canceled: #ef476f;
        --gray-100: #f8f9fa;
        --gray-200: #e9ecef;
        --gray-300: #dee2e6;
        --border-radius: 1rem;
        --card-radius: 1.5rem;
    }
    
    /* Page header */
    .page-header {
        margin-bottom: 2rem;
    }
    
    .page-title {
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 0.5rem;
    }
    
    .icon-circle {
        width: 54px;
        height: 54px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        box-shadow: 0 10px 15px -3px rgba(67, 97, 238, 0.2);
    }
    
    /* Cards */
    .orders-card {
        border: none;
        border-radius: var(--card-radius);
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        margin-bottom: 2rem;
    }
    
    .orders-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }
    
    /* Order Stats */
    .order-stats {
        background: linear-gradient(to right, var(--primary), var(--secondary));
        border-radius: var(--border-radius) var(--border-radius) 0 0;
    }
    
    .stat-card {
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    .stat-icon {
        flex-shrink: 0;
        width: 55px;
        height: 55px;
        background: linear-gradient(45deg, var(--primary), var(--info));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        margin-right: 1rem;
        box-shadow: 0 7px 15px -3px rgba(0, 0, 0, 0.1);
    }
    
    .stat-processing .stat-icon {
        background: linear-gradient(45deg, #ffb703, #fd9e02);
    }
    
    .stat-completed .stat-icon {
        background: linear-gradient(45deg, #06d6a0, #0ac28a);
    }
    
    .stat-info h4 {
        font-weight: 700;
        font-size: 1.5rem;
        margin-bottom: 0.25rem;
        color: var(--dark);
    }
    
    .stat-info p {
        color: #6c757d;
        margin-bottom: 0;
        font-size: 0.875rem;
    }
    
    /* Orders List */
    .orders-list {
        padding-bottom: 1rem;
    }
    
    .order-item {
        background-color: white;
        border-radius: var(--border-radius);
        margin-bottom: 1.25rem;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
        transition: all 0.3s ease;
        border: 1px solid var(--gray-200);
    }
    
    .order-item:hover {
        transform: translateX(5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.07);
        border-color: var(--gray-300);
    }
    
    .order-header {
        display: flex;
        justify-content: space-between;
        padding: 1rem 1.25rem;
        background-color: var(--gray-100);
        border-bottom: 1px solid var(--gray-200);
    }
    
    .order-id {
        font-weight: 600;
        color: var(--dark);
    }
    
    .order-date {
        color: #6c757d;
        font-size: 0.9rem;
    }
    
    .order-body {
        padding: 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    /* Status Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 500;
        font-size: 0.875rem;
    }
    
    .status-dot {
        font-size: 0.5rem;
        margin-right: 0.5rem;
    }
    
    .status-đang-xử-lý {
        background-color: rgba(255, 183, 3, 0.1);
        color: var(--processing);
    }
    
    .status-hoàn-thành {
        background-color: rgba(6, 214, 160, 0.1);
        color: var(--completed);
    }
    
    .status-đã-hủy {
        background-color: rgba(239, 71, 111, 0.1);
        color: var(--canceled);
    }
    
    /* Order Amount */
    .order-total .amount {
        font-weight: 700;
        font-size: 1.25rem;
        color: var(--dark);
    }
    
    /* Order Actions */
    .btn-view-detail {
        background: linear-gradient(to right, var(--primary), var(--secondary));
        color: white;
        border: none;
        border-radius: 50px;
        padding: 0.5rem 1.25rem;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(67, 97, 238, 0.15);
    }
    
    .btn-view-detail:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(67, 97, 238, 0.25);
        color: white;
    }
    
    /* Pagination */
    .pagination-container .pagination {
        justify-content: center;
    }
    
    .pagination-container .page-item.active .page-link {
        background-color: var(--primary);
        border-color: var(--primary);
    }
    
    .pagination-container .page-link {
        color: var(--primary);
        border-radius: 0.5rem;
        margin: 0 0.25rem;
    }
    
    /* Empty State */
    .empty-state {
        padding: 4rem 2rem;
    }
    
    .empty-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(to right, var(--primary), var(--secondary));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: white;
        margin: 0 auto;
        box-shadow: 0 10px 30px rgba(67, 97, 238, 0.2);
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(67, 97, 238, 0.4);
        }
        70% {
            box-shadow: 0 0 0 15px rgba(67, 97, 238, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(67, 97, 238, 0);
        }
    }
    
    .btn-shop-now {
        background: linear-gradient(to right, var(--primary), var(--secondary));
        border: none;
        border-radius: 50px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(67, 97, 238, 0.15);
    }
    
    .btn-shop-now:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 15px 30px rgba(67, 97, 238, 0.25);
    }
    
    /* Back Button */
    .btn-back {
        background-color: transparent;
        color: var(--primary);
        border: 2px solid var(--primary);
        border-radius: 50px;
        padding: 0.6rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-back:hover {
        background-color: var(--primary);
        color: white;
        transform: translateX(-5px);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .order-body {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .order-action {
            align-self: flex-end;
            margin-top: 1rem;
        }
    }
    
    /* Ripple effect */
    .ripple {
        position: absolute;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.6);
        transform: scale(0);
        animation: ripple-animation 0.6s ease-out;
        pointer-events: none;
    }
    
    @keyframes ripple-animation {
        to {
            transform: scale(3);
            opacity: 0;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add floating animation to stat cards
        const statCards = document.querySelectorAll('.stat-card');
        statCards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.2}s`;
            card.classList.add('animate__animated', 'animate__fadeInUp');
        });
        
        // Add hover effect to order items
        const orderItems = document.querySelectorAll('.order-item');
        orderItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.borderLeftWidth = '5px';
                this.style.borderLeftColor = 'var(--primary)';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.borderLeftWidth = '1px';
                this.style.borderLeftColor = 'var(--gray-200)';
            });
        });
        
        // Add ripple effect to buttons
        const buttons = document.querySelectorAll('.btn');
        buttons.forEach(button => {
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                ripple.classList.add('ripple');
                
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                
                ripple.style.width = ripple.style.height = `${size}px`;
                ripple.style.left = `${e.clientX - rect.left - size/2}px`;
                ripple.style.top = `${e.clientY - rect.top - size/2}px`;
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
    });
</script>
@endpush
@endsection