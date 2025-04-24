@extends('layouts.main')

@section('content')
<div class="container py-5 animate__animated animate__fadeIn">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Alerts -->
            @include('components.alert')
            
            <!-- Page Header -->
            <div class="page-header d-flex align-items-center mb-4">
                <div class="icon-circle bg-primary text-white me-3 animate__animated animate__bounceIn">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <div>
                    <h2 class="page-title mb-0">Chi tiết đơn hàng #{{ $order->id }}</h2>
                    <p class="text-muted mb-0">
                        <i class="far fa-calendar-alt me-1"></i> Đặt ngày {{ $order->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>
            </div>
            
            <!-- Order Status Timeline -->
            <div class="card status-card mb-4 shadow-lg animate__animated animate__fadeInUp">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-tasks me-2"></i>Trạng thái đơn hàng
                        <span class="current-status-badge">Hiện tại: <strong>{{ $order->status }}</strong></span>
                    </h5>
                    
                    <div class="order-timeline">
                        <div class="status-track">
                            @php
                                $statuses = ['Chờ xác nhận', 'Đang xử lý', 'Đang vận chuyển', 'Hoàn thành'];
                                $currentStatusIndex = array_search($order->status, $statuses);
                                if ($currentStatusIndex === false) $currentStatusIndex = -1;
                            @endphp
                            
                            @foreach($statuses as $index => $status)
                                <div class="status-step {{ $index <= $currentStatusIndex ? 'completed' : '' }} {{ $index == $currentStatusIndex ? 'current' : '' }}">
                                    <div class="status-icon {{ $index == $currentStatusIndex ? 'pulse' : '' }}">
                                        @if($index < $currentStatusIndex)
                                            <i class="fas fa-check"></i>
                                        @elseif($index == $currentStatusIndex)
                                            <i class="fas fa-clock"></i>
                                        @else
                                            <i class="fas fa-circle"></i>
                                        @endif
                                    </div>
                                    <div class="status-label">{{ $status }}</div>
                                    @if($index < count($statuses) - 1)
                                        <div class="status-line {{ $index < $currentStatusIndex ? 'completed' : '' }} {{ $index == $currentStatusIndex ? 'current-line' : '' }}"></div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="status-animation">
                            @if($order->status == 'Chờ xác nhận')
                                <div class="waiting-animation">
                                    <div class="waiting-circle"></div>
                                    <div class="waiting-circle"></div>
                                    <div class="waiting-circle"></div>
                                </div>
                            @elseif($order->status == 'Đang xử lý')
                                <div class="processing-animation">
                                    <i class="fas fa-cogs"></i>
                                </div>
                            @elseif($order->status == 'Đang vận chuyển')
                                <div class="shipping-animation">
                                    <i class="fas fa-truck"></i>
                                </div>
                            @elseif($order->status == 'Hoàn thành')
                                <div class="completed-animation">
                                    <div class="checkmark">
                                        <div class="checkmark-circle"></div>
                                        <div class="checkmark-stem"></div>
                                        <div class="checkmark-kick"></div>
                                    </div>
                                </div>
                            @elseif($order->status == 'Đã hủy')
                                <div class="canceled-animation">
                                    <i class="fas fa-times"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Order Information -->
            <div class="row g-4 mb-4">
                <!-- Order Details -->
                <div class="col-md-6 animate__animated animate__fadeInLeft">
                    <div class="card order-info-card h-100 shadow-sm">
                        <div class="card-header">
                            <i class="fas fa-info-circle me-2"></i>Thông tin đơn hàng
                        </div>
                        <div class="card-body">
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="info-content">
                                    <span class="info-label">Ngày đặt hàng</span>
                                    <span class="info-value">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                                <div class="info-content">
                                    <span class="info-label">Phương thức thanh toán</span>
                                    <span class="info-value">{{ $order->payment_method }}</span>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-coins"></i>
                                </div>
                                <div class="info-content">
                                    <span class="info-label">Tổng tiền</span>
                                    <span class="info-value text-primary fw-bold">{{ number_format($order->total, 0, ',', '.') }}đ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Shipping Information -->
                <div class="col-md-6 animate__animated animate__fadeInRight">
                    <div class="card shipping-info-card h-100 shadow-sm">
                        <div class="card-header">
                            <i class="fas fa-shipping-fast me-2"></i>Thông tin giao hàng
                        </div>
                        <div class="card-body">
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="info-content">
                                    <span class="info-label">Người nhận</span>
                                    <span class="info-value">{{ $order->shipping_name }}</span>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="info-content">
                                    <span class="info-label">Điện thoại</span>
                                    <span class="info-value">{{ $order->shipping_phone }}</span>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="info-content">
                                    <span class="info-label">Địa chỉ</span>
                                    <span class="info-value">{{ $order->shipping_address }}</span>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="info-content">
                                    <span class="info-label">Email</span>
                                    <span class="info-value">{{ $order->shipping_email }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Order Items -->
            <div class="card order-items-card mb-4 shadow-lg animate__animated animate__fadeInUp">
                <div class="card-header">
                    <i class="fas fa-shopping-basket me-2"></i>Sản phẩm đã đặt
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @foreach($order->items as $item)
                            <div class="product-item animate__animated animate__fadeIn" style="animation-delay: {{ $loop->index * 0.1 }}s">
                                <div class="product-item-image">
                                    @if($item->product && $item->product->image)
                                        <img src="{{ asset('storage/'.$item->product->image) }}" alt="{{ $item->product->name }}" class="img-fluid">
                                    @else
                                        <div class="no-image">
                                            <i class="fas fa-camera"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="product-item-details">
                                    <h5 class="product-item-name">{{ $item->product ? $item->product->name : 'Sản phẩm không tồn tại' }}</h5>
                                    <p class="product-item-price">{{ number_format($item->price, 0, ',', '.') }}đ</p>
                                </div>
                                <div class="product-item-quantity">
                                    <span class="quantity-label">SL:</span>
                                    <span class="quantity-value">{{ $item->quantity }}</span>
                                </div>
                                <div class="product-item-total">
                                    <span class="total-label">Thành tiền:</span>
                                    <span class="total-value">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}đ</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer">
                    <div class="order-summary">
                        <div class="summary-row">
                            <div class="summary-label">Tổng phụ:</div>
                            <div class="summary-value">{{ number_format($order->subtotal, 0, ',', '.') }}đ</div>
                        </div>
                        
                        @if($order->discount > 0)
                            <div class="summary-row discount">
                                <div class="summary-label">Giảm giá:</div>
                                <div class="summary-value">-{{ number_format($order->discount, 0, ',', '.') }}đ</div>
                            </div>
                        @endif
                        
                        <div class="summary-row">
                            <div class="summary-label">Phí vận chuyển:</div>
                            <div class="summary-value">{{ number_format($order->shipping_fee, 0, ',', '.') }}đ</div>
                        </div>
                        
                        <div class="summary-total">
                            <div class="summary-label">Tổng cộng:</div>
                            <div class="summary-value">{{ number_format($order->total, 0, ',', '.') }}đ</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Back Button -->
            <div class="mt-4 back-btn-container animate__animated animate__fadeInUp">
                <a href="{{ route('user.orders') }}" class="btn btn-back">
                    <i class="fas fa-arrow-left me-2"></i> Quay lại danh sách đơn hàng
                </a>
                
                @if($order->status == 'Chờ xác nhận')
                    <button class="btn btn-danger ms-2 cancel-btn">
                        <i class="fas fa-times-circle me-2"></i> Hủy đơn hàng
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    :root {
        --primary: #4361ee;
        --secondary: #3f37c9;
        --success: #4cc9f0;
        --info: #4895ef;
        --warning: #ffb703;
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
    
    /* Current Status Badge */
    .current-status-badge {
        float: right;
        background: linear-gradient(45deg, var(--primary), var(--info));
        color: white;
        padding: 0.3rem 0.8rem;
        border-radius: 50px;
        font-size: 0.85rem;
        box-shadow: 0 3px 10px rgba(67, 97, 238, 0.2);
        animation: fadeInRight 0.5s ease;
    }
    
    /* Pulse Animation for Current Status */
    .status-icon.pulse {
        animation: pulse 1.5s infinite;
    }
    
    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(67, 97, 238, 0.7);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(67, 97, 238, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(67, 97, 238, 0);
        }
    }
    
    /* Current Status Styling */
    .status-step.current .status-icon {
        background: linear-gradient(45deg, var(--primary), var(--info));
        color: white;
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.3);
        transform: scale(1.2);
    }
    
    .status-step.current .status-label {
        color: var(--primary);
        font-weight: 700;
        font-size: 1rem;
        transform: scale(1.05);
    }
    
    .status-line.current-line {
        background: linear-gradient(90deg, var(--primary), rgba(67, 97, 238, 0.3));
        height: 4px;
        animation: progressLine 1.5s ease-in-out infinite;
    }
    
    @keyframes progressLine {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
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
    .card {
        border: none;
        border-radius: var(--card-radius);
        overflow: hidden;
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1) !important;
    }
    
    .card-header {
        font-weight: 600;
        background-color: rgba(0, 0, 0, 0.03);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1rem 1.5rem;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .card-footer {
        background-color: rgba(0, 0, 0, 0.02);
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1rem 1.5rem;
    }
    
    /* Status Card & Timeline */
    .status-card {
        background: white;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }
    
    .order-timeline {
        position: relative;
        padding: 1rem 0;
    }
    
    .status-track {
        display: flex;
        justify-content: space-between;
        position: relative;
        padding: 0 2rem;
    }
    
    .status-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 1;
        flex: 1;
    }
    
    .status-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: var(--gray-200);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gray-500);
        margin-bottom: 0.5rem;
        border: 2px solid white;
        box-shadow: 0 0 0 3px var(--gray-200);
        transition: all 0.3s ease;
    }
    
    .status-step.completed .status-icon {
        background: linear-gradient(45deg, var(--primary), var(--secondary));
        color: white;
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.3);
    }
    
    .status-label {
        color: var(--gray-600);
        font-size: 0.875rem;
        font-weight: 500;
        white-space: nowrap;
        margin-top: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .status-step.completed .status-label {
        color: var(--primary);
        font-weight: 600;
    }
    
    .status-line {
        position: absolute;
        height: 3px;
        background-color: var(--gray-200);
        width: 100%;
        top: 20px;
        left: 50%;
        z-index: 0;
    }
    
    .status-line.completed {
        background: linear-gradient(90deg, var(--primary), var(--secondary));
    }
    
    /* Status Animations */
    .status-animation {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
        height: 100px;
    }
    
    /* Waiting Animation */
    .waiting-animation {
        display: flex;
        align-items: center;
    }
    
    .waiting-circle {
        width: 20px;
        height: 20px;
        background-color: var(--primary);
        border-radius: 50%;
        margin: 0 5px;
        animation: waiting 1.4s ease-in-out infinite;
    }
    
    .waiting-circle:nth-child(1) {
        animation-delay: 0s;
    }
    
    .waiting-circle:nth-child(2) {
        animation-delay: 0.2s;
    }
    
    .waiting-circle:nth-child(3) {
        animation-delay: 0.4s;
    }
    
    @keyframes waiting {
        0%, 100% {
            transform: scale(0.5);
            opacity: 0.3;
        }
        50% {
            transform: scale(1);
            opacity: 1;
        }
    }
    
    /* Processing Animation */
    .processing-animation {
        font-size: 3rem;
        color: var(--processing);
        animation: spin 2s linear infinite;
    }
    
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
    
    /* Shipping Animation */
    .shipping-animation {
        font-size: 3rem;
        color: var(--info);
        animation: drive 2s ease infinite alternate;
    }
    
    @keyframes drive {
        0% {
            transform: translateX(-50px);
        }
        100% {
            transform: translateX(50px);
        }
    }
    
    /* Completed Animation - Checkmark */
    .completed-animation {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .checkmark {
        width: 80px;
        height: 80px;
        position: relative;
    }
    
    .checkmark-circle {
        width: 80px;
        height: 80px;
        position: absolute;
        background-color: var(--completed);
        border-radius: 50%;
        left: 0;
        top: 0;
        animation: checkmark-circle 0.5s ease-in;
    }
    
    .checkmark-stem {
        position: absolute;
        width: 5px;
        height: 25px;
        background-color: white;
        left: 38px;
        top: 30px;
        transform: rotate(45deg);
        animation: checkmark-stem 0.5s ease-in 0.3s forwards;
        opacity: 0;
    }
    
    .checkmark-kick {
        position: absolute;
        width: 15px;
        height: 5px;
        background-color: white;
        left: 25px;
        top: 50px;
        transform: rotate(45deg);
        animation: checkmark-kick 0.5s ease-in 0.3s forwards;
        opacity: 0;
    }
    
    @keyframes checkmark-circle {
        0% {
            transform: scale(0);
            opacity: 0;
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }
    
    @keyframes checkmark-stem {
        0% {
            opacity: 0;
            height: 0;
        }
        100% {
            opacity: 1;
            height: 25px;
        }
    }
    
    @keyframes checkmark-kick {
        0% {
            opacity: 0;
            width: 0;
        }
        100% {
            opacity: 1;
            width: 15px;
        }
    }
    
    /* Canceled Animation */
    .canceled-animation {
        font-size: 3rem;
        color: var(--canceled);
        animation: shake 0.5s ease-in-out;
    }
    
    @keyframes shake {
        0%, 100% {
            transform: translateX(0);
        }
        20%, 60% {
            transform: translateX(-10px);
        }
        40%, 80% {
            transform: translateX(10px);
        }
    }
    
    /* Info Items */
    .info-item {
        display: flex;
        align-items: center;
        margin-bottom: 1.25rem;
        padding: 0.5rem;
        border-radius: var(--border-radius);
        transition: all 0.3s ease;
    }
    
    .info-item:last-child {
        margin-bottom: 0;
    }
    
    .info-item:hover {
        background-color: var(--gray-100);
        transform: translateX(5px);
    }
    
    .info-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(45deg, var(--primary), var(--secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-right: 1rem;
        font-size: 1rem;
        flex-shrink: 0;
    }
    
    .info-content {
        display: flex;
        flex-direction: column;
    }
    
    .info-label {
        font-size: 0.8rem;
        color: var(--gray-500);
        margin-bottom: 0.25rem;
    }
    
    .info-value {
        font-weight: 600;
        color: var(--dark);
    }
    
    /* Product Items */
    .product-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        border-bottom: 1px solid var(--gray-200);
        transition: all 0.3s ease;
    }
    
    .product-item:last-child {
        border-bottom: none;
    }
    
    .product-item:hover {
        background-color: var(--gray-100);
    }
    
    .product-item-image {
        width: 80px;
        height: 80px;
        background-color: var(--gray-200);
        border-radius: 0.5rem;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        flex-shrink: 0;
    }
    
    .product-item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .no-image {
        color: var(--gray-400);
        font-size: 1.5rem;
    }
    
    .product-item-details {
        flex: 1;
    }
    
    .product-item-name {
        font-weight: 600;
        margin-bottom: 0.25rem;
        font-size: 1rem;
    }
    
    .product-item-price {
        color: var(--gray-600);
        margin-bottom: 0;
        font-size: 0.9rem;
    }
    
    .product-item-quantity {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 0 1.5rem;
        min-width: 50px;
    }
    
    .quantity-label {
        font-size: 0.8rem;
        color: var(--gray-500);
    }
    
    .quantity-value {
        font-weight: 700;
        font-size: 1.25rem;
        color: var(--dark);
    }
    
    .product-item-total {
        text-align: right;
        min-width: 120px;
    }
    
    .total-label {
        font-size: 0.8rem;
        color: var(--gray-500);
    }
    
    .total-value {
        font-weight: 700;
        font-size: 1.1rem;
        color: var(--primary);
    }
    
    /* Order Summary */
    .order-summary {
        width: 100%;
    }
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px dashed var(--gray-200);
    }
    
    .summary-row.discount .summary-value {
        color: var(--danger);
    }
    
    .summary-total {
        display: flex;
        justify-content: space-between;
        padding: 1rem 0 0;
        margin-top: 0.5rem;
        border-top: 2px solid var(--gray-300);
    }
    
    .summary-label {
        font-weight: 500;
    }
    
    .summary-total .summary-label {
        font-weight: 700;
        font-size: 1.1rem;
    }
    
    .summary-total .summary-value {
        font-weight: 700;
        font-size: 1.2rem;
        color: var(--primary);
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
    
    /* Cancel Button */
    .cancel-btn {
        border-radius: 50px;
        padding: 0.6rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .cancel-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(230, 57, 70, 0.3);
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
    
    /* Responsive */
    @media (max-width: 768px) {
        .status-track {
            padding: 0;
        }
        
        .status-label {
            font-size: 0.75rem;
        }
        
        .product-item {
            flex-wrap: wrap;
        }
        
        .product-item-quantity, 
        .product-item-total {
            margin-top: 1rem;
            margin-left: 90px;
        }
        
        .product-item-total {
            margin-left: auto;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation for info items
        const infoItems = document.querySelectorAll('.info-item');
        infoItems.forEach((item, index) => {
            item.style.animation = `fadeInLeft ${0.3 + index * 0.1}s ease forwards`;
            item.style.opacity = '0';
        });
        
        // Animation for status steps
        const statusSteps = document.querySelectorAll('.status-step');
        statusSteps.forEach((step, index) => {
            setTimeout(() => {
                if (step.classList.contains('completed')) {
                    step.querySelector('.status-icon').classList.add('animate__animated', 'animate__bounceIn');
                }
            }, 500 + (index * 300));
        });
        
        // Animation for status lines
        const statusLines = document.querySelectorAll('.status-line.completed');
        statusLines.forEach((line, index) => {
            line.style.width = '0';
            setTimeout(() => {
                line.style.transition = 'width 0.5s ease-in-out';
                line.style.width = '100%';
            }, 1000 + (index * 300));
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
        
        // Continuously animate the status based on current status
        if (document.querySelector('.processing-animation')) {
            const gears = document.querySelector('.processing-animation i');
            setInterval(() => {
                gears.style.transform = 'rotate(0deg)';
                setTimeout(() => {
                    gears.style.transition = 'transform 2s linear';
                    gears.style.transform = 'rotate(360deg)';
                }, 100);
            }, 2100);
        }
    });
</script>
@endpush
@endsection 