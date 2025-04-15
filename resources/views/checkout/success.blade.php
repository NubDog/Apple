@extends('layouts.main')

@section('content')
<div class="checkout-success-container py-5">
    <div class="container">
        <div class="checkout-success-card animate__animated animate__fadeIn">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            
            <h1 class="success-title">Đặt hàng thành công!</h1>
            
            <p class="success-message">
                Cảm ơn bạn đã đặt hàng tại Apple Store. Chúng tôi đã nhận được đơn hàng của bạn và đang xử lý.
                <br>Bạn sẽ nhận được email xác nhận đơn hàng trong thời gian sớm nhất.
            </p>
            
            <div class="order-summary">
                <h4>Thông tin đơn hàng</h4>
                <p><strong>Mã đơn hàng:</strong> #{{ $order->id }}</p>
                <p><strong>Tổng thanh toán:</strong> {{ number_format($order->total, 0, ',', '.') }} ₫</p>
                <p><strong>Phương thức thanh toán:</strong> {{ $order->payment_method_text }}</p>
            </div>
            
            <div class="text-center mt-4">
                <a href="{{ route('home') }}" class="btn btn-primary btn-return-home">
                    <i class="fas fa-home me-2"></i>Quay lại trang chủ
                </a>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    .checkout-success-container {
        background-color: #f8f9fa;
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .checkout-success-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        padding: 60px;
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
    }
    
    .success-icon {
        font-size: 80px;
        color: #4caf50;
        margin-bottom: 30px;
    }
    
    .success-icon i {
        animation: pulse 2s infinite;
    }
    
    .success-title {
        color: #212529;
        margin-bottom: 20px;
        font-weight: 700;
    }
    
    .success-message {
        color: #6c757d;
        font-size: 1.1rem;
        line-height: 1.8;
        margin-bottom: 30px;
    }
    
    .order-summary {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 12px;
        margin: 20px 0;
        text-align: left;
    }
    
    .order-summary h4 {
        margin-bottom: 15px;
        color: #4070f4;
    }
    
    .btn-return-home {
        background: #4070f4;
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        font-size: 1.1rem;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(64, 112, 244, 0.3);
    }
    
    .btn-return-home:hover {
        background: #2c50c5;
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(64, 112, 244, 0.4);
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    @media (max-width: 768px) {
        .checkout-success-card {
            padding: 40px 20px;
        }
        
        .success-icon {
            font-size: 60px;
        }
    }
</style>
@endpush
@endsection 