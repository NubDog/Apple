@extends('layouts.main')

@section('content')
<div class="checkout-container py-5">
    <div class="container">
        <h1 class="text-center mb-5 animate__animated animate__fadeIn">Thanh Toán</h1>
        
        <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
            @csrf
            
            <div class="row">
                <div class="col-lg-7 mb-4 mb-lg-0">
                    <div class="checkout-card animate__animated animate__fadeInLeft">
                        <div class="checkout-section">
                            <h3 class="checkout-title">
                                <span class="checkout-number">1</span> Thông tin giao hàng
                            </h3>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control rounded-pill" id="shipping_name" name="shipping_name" placeholder="Họ và tên" value="{{ $user->name ?? old('shipping_name') }}" required>
                                        <label for="shipping_name">Họ và tên</label>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="email" class="form-control rounded-pill" id="shipping_email" name="shipping_email" placeholder="Email" value="{{ $user->email ?? old('shipping_email') }}" required>
                                        <label for="shipping_email">Email</label>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="tel" class="form-control rounded-pill" id="shipping_phone" name="shipping_phone" placeholder="Số điện thoại" value="{{ old('shipping_phone') }}" required>
                                        <label for="shipping_phone">Số điện thoại</label>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control rounded-pill" id="shipping_address" name="shipping_address" placeholder="Địa chỉ giao hàng" value="{{ old('shipping_address') }}" required>
                                        <label for="shipping_address">Địa chỉ giao hàng</label>
                                    </div>
                                </div>
                                
                                <div class="col-12 mb-3">
                                    <div class="form-floating">
                                        <textarea class="form-control rounded-4" id="notes" name="notes" placeholder="Ghi chú" style="height: 100px">{{ old('notes') }}</textarea>
                                        <label for="notes">Ghi chú đơn hàng (tùy chọn)</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="checkout-section">
                            <h3 class="checkout-title">
                                <span class="checkout-number">2</span> Phương thức vận chuyển
                            </h3>
                            
                            <div class="shipping-options">
                                <div class="shipping-option">
                                    <input type="radio" class="btn-check" name="shipping_method" id="viettel_post" value="viettel_post" required checked>
                                    <label class="btn shipping-btn rounded-4" for="viettel_post">
                                        <div class="shipping-logo">
                                            <img src="https://upload.wikimedia.org/wikipedia/vi/1/1e/Viettel_logo_2021.svg" alt="Viettel Post">
                                        </div>
                                        <div class="shipping-info">
                                            <div class="shipping-name">Viettel Post</div>
                                            <div class="shipping-desc">Giao hàng sau 2-3 ngày</div>
                                        </div>
                                        <div class="shipping-price">30.000 ₫</div>
                                    </label>
                                </div>
                                
                                <div class="shipping-option">
                                    <input type="radio" class="btn-check" name="shipping_method" id="shopee_express" value="shopee_express">
                                    <label class="btn shipping-btn rounded-4" for="shopee_express">
                                        <div class="shipping-logo">
                                            <img src="https://logo.com/image-cdn/images/kts928pd/production/f19885fa0fb82cdbce172f4a0530ca6ee6e8bb8b-731x731.png?w=1080&q=72" alt="Shopee Express">
                                        </div>
                                        <div class="shipping-info">
                                            <div class="shipping-name">Shopee Express</div>
                                            <div class="shipping-desc">Giao hàng nhanh trong 2 ngày</div>
                                        </div>
                                        <div class="shipping-price">25.000 ₫</div>
                                    </label>
                                </div>
                                
                                <div class="shipping-option">
                                    <input type="radio" class="btn-check" name="shipping_method" id="self_transport" value="self_transport">
                                    <label class="btn shipping-btn rounded-4" for="self_transport">
                                        <div class="shipping-logo">
                                            <img src="https://cdn-icons-png.flaticon.com/512/3126/3126647.png" alt="Self Transport">
                                        </div>
                                        <div class="shipping-info">
                                            <div class="shipping-name">Giao hàng hỏa tốc</div>
                                            <div class="shipping-desc">Giao trong ngày</div>
                                        </div>
                                        <div class="shipping-price">40.000 ₫</div>
                                    </label>
                                </div>
                                
                                <div class="shipping-option">
                                    <input type="radio" class="btn-check" name="shipping_method" id="self_pickup" value="self_pickup">
                                    <label class="btn shipping-btn rounded-4" for="self_pickup">
                                        <div class="shipping-logo">
                                            <img src="https://cdn-icons-png.flaticon.com/512/3225/3225194.png" alt="Self Pickup">
                                        </div>
                                        <div class="shipping-info">
                                            <div class="shipping-name">Nhận tại cửa hàng</div>
                                            <div class="shipping-desc">Tại 123 Đường Xe, Quận 1, TP.HCM</div>
                                        </div>
                                        <div class="shipping-price">Miễn phí</div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="checkout-section">
                            <h3 class="checkout-title">
                                <span class="checkout-number">3</span> Phương thức thanh toán
                            </h3>
                            
                            <div class="payment-options">
                                <div class="payment-option">
                                    <input type="radio" class="btn-check" name="payment_method" id="cod" value="cod" required checked>
                                    <label class="btn payment-btn rounded-4" for="cod">
                                        <div class="payment-logo">
                                            <i class="fas fa-money-bill-wave"></i>
                                        </div>
                                        <div class="payment-name">Thanh toán khi nhận hàng (COD)</div>
                                    </label>
                                </div>
                                
                                <div class="payment-option">
                                    <input type="radio" class="btn-check" name="payment_method" id="momo" value="momo">
                                    <label class="btn payment-btn rounded-4" for="momo">
                                        <div class="payment-logo">
                                            <img src="https://upload.wikimedia.org/wikipedia/vi/f/fe/MoMo_Logo.png" alt="MoMo">
                                        </div>
                                        <div class="payment-name">Ví MoMo</div>
                                    </label>
                                </div>
                                
                                <div class="payment-option">
                                    <input type="radio" class="btn-check" name="payment_method" id="zalopay" value="zalopay">
                                    <label class="btn payment-btn rounded-4" for="zalopay">
                                        <div class="payment-logo">
                                            <img src="https://cdn.haitrieu.com/wp-content/uploads/2022/10/Logo-ZaloPay-Square.png" alt="ZaloPay">
                                        </div>
                                        <div class="payment-name">Ví ZaloPay</div>
                                    </label>
                                </div>
                                
                                <div class="payment-option">
                                    <input type="radio" class="btn-check" name="payment_method" id="vnpay" value="vnpay">
                                    <label class="btn payment-btn rounded-4" for="vnpay">
                                        <div class="payment-logo">
                                            <img src="https://cdn.haitrieu.com/wp-content/uploads/2022/10/Logo-VNPAY-QR-1.png" alt="VNPay">
                                        </div>
                                        <div class="payment-name">Thanh toán VNPAY-QR</div>
                                    </label>
                                </div>
                                
                                <div class="payment-option">
                                    <input type="radio" class="btn-check" name="payment_method" id="bank_transfer" value="bank_transfer">
                                    <label class="btn payment-btn rounded-4" for="bank_transfer">
                                        <div class="payment-logo">
                                            <i class="fas fa-university"></i>
                                        </div>
                                        <div class="payment-name">Chuyển khoản ngân hàng</div>
                                    </label>
                                </div>
                                
                                <div class="payment-option">
                                    <input type="radio" class="btn-check" name="payment_method" id="credit_card" value="credit_card">
                                    <label class="btn payment-btn rounded-4" for="credit_card">
                                        <div class="payment-logo">
                                            <i class="far fa-credit-card"></i>
                                        </div>
                                        <div class="payment-name">Thẻ tín dụng / Ghi nợ</div>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="mt-4 payment-details" id="bank_transfer_details" style="display: none;">
                                <div class="alert alert-info rounded-4">
                                    <p class="mb-1"><strong>Thông tin chuyển khoản:</strong></p>
                                    <p class="mb-1">Ngân hàng: Vietcombank</p>
                                    <p class="mb-1">Số tài khoản: 1234567890</p>
                                    <p class="mb-1">Chủ tài khoản: CÔNG TY SHARK CAR</p>
                                    <p class="mb-0">Nội dung: Thanh toán đơn hàng #[Mã đơn hàng]</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-5">
                    <div class="checkout-card animate__animated animate__fadeInRight">
                        <div class="checkout-section">
                            <h3 class="checkout-title">Đơn hàng của bạn</h3>
                            
                            <div class="order-items">
                                @foreach($cart as $id => $item)
                                    <div class="order-item">
                                        <div class="order-item-image">
                                            <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="img-fluid rounded-3" onerror="this.src='/images/no-image.jpg'">
                                            <span class="order-item-quantity">{{ $item['quantity'] }}</span>
                                        </div>
                                        <div class="order-item-details">
                                            <div class="order-item-name">{{ $item['name'] }}</div>
                                        </div>
                                        <div class="order-item-price">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} ₫</div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="coupon-section">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control rounded-pill-left" placeholder="Mã giảm giá" 
                                        value="{{ Session::has('coupon') ? Session::get('coupon')['code'] : '' }}" 
                                        {{ Session::has('coupon') ? 'disabled' : '' }}>
                                    @if(Session::has('coupon'))
                                        <a href="{{ route('cart.remove-coupon') }}" class="btn btn-outline-danger rounded-pill-right">Xóa</a>
                                    @else
                                        <button class="btn btn-primary rounded-pill-right" type="button">Áp dụng</button>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="order-totals">
                                <div class="d-flex justify-content-between mb-2">
                                    <div>Tạm tính</div>
                                    <div>{{ number_format($totals['subtotal'], 0, ',', '.') }} ₫</div>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <div>Phí vận chuyển</div>
                                    <div id="shipping-cost">0 ₫</div>
                                </div>
                                @if($totals['discount'] > 0)
                                    <div class="d-flex justify-content-between mb-2 text-success">
                                        <div>Giảm giá</div>
                                        <div>-{{ number_format($totals['discount'], 0, ',', '.') }} ₫</div>
                                    </div>
                                @endif
                                @if($totals['tax'] > 0)
                                    <div class="d-flex justify-content-between mb-2">
                                        <div>Thuế (VAT)</div>
                                        <div>{{ number_format($totals['tax'], 0, ',', '.') }} ₫</div>
                                    </div>
                                @endif
                                <hr>
                                <div class="d-flex justify-content-between total-row">
                                    <div class="fw-bold">Tổng thanh toán</div>
                                    <div class="checkout-total" id="final-total">{{ number_format($totals['total'], 0, ',', '.') }} ₫</div>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-lg btn-success w-100 rounded-pill order-submit mt-3">
                                <i class="fas fa-lock me-2"></i>Đặt hàng
                            </button>
                            
                            <div class="text-center mt-3">
                                <a href="{{ route('cart.index') }}" class="back-to-cart">
                                    <i class="fas fa-arrow-left me-2"></i>Quay lại giỏ hàng
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    .checkout-container {
        background-color: #f8f9fa;
    }
    
    .checkout-card {
        background-color: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-bottom: 30px;
        transition: all 0.3s ease;
    }
    
    .checkout-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
    }
    
    .checkout-section {
        padding: 25px;
        border-bottom: 1px solid #f1f1f1;
    }
    
    .checkout-section:last-child {
        border-bottom: none;
    }
    
    .checkout-title {
        font-size: 1.25rem;
        margin-bottom: 25px;
        color: #333;
        position: relative;
        font-weight: 600;
        display: flex;
        align-items: center;
    }
    
    .checkout-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        background-color: var(--primary-color);
        color: white;
        border-radius: 50%;
        margin-right: 10px;
        font-size: 1rem;
    }
    
    .form-floating .form-control {
        border: 2px solid #e0e0e0;
        transition: all 0.3s;
    }
    
    .form-floating .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(26, 35, 126, 0.1);
    }
    
    .rounded-pill {
        border-radius: 50rem !important;
    }
    
    .rounded-pill-left {
        border-top-left-radius: 50rem !important;
        border-bottom-left-radius: 50rem !important;
    }
    
    .rounded-pill-right {
        border-top-right-radius: 50rem !important;
        border-bottom-right-radius: 50rem !important;
    }
    
    .rounded-4 {
        border-radius: 1rem !important;
    }
    
    .shipping-options, .payment-options {
        display: grid;
        gap: 15px;
    }
    
    .shipping-option, .payment-option {
        position: relative;
    }
    
    .shipping-btn, .payment-btn {
        display: flex;
        align-items: center;
        padding: 15px 20px;
        text-align: left;
        border: 2px solid #e0e0e0;
        background-color: white;
        transition: all 0.2s;
        width: 100%;
    }
    
    .shipping-btn:hover, .payment-btn:hover {
        border-color: #c0c0c0;
    }
    
    .btn-check:checked + .shipping-btn, .btn-check:checked + .payment-btn {
        border-color: var(--primary-color);
        background-color: rgba(26, 35, 126, 0.05);
    }
    
    .btn-check:checked + .shipping-btn::after, .btn-check:checked + .payment-btn::after {
        content: '\f058';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        position: absolute;
        top: 10px;
        right: 15px;
        color: var(--primary-color);
        font-size: 1.2rem;
    }
    
    .shipping-logo, .payment-logo {
        width: 50px;
        height: 50px;
        margin-right: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .shipping-logo img, .payment-logo img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    
    .payment-logo i {
        font-size: 30px;
        color: var(--primary-color);
    }
    
    .shipping-info {
        flex-grow: 1;
    }
    
    .shipping-name, .payment-name {
        font-weight: 600;
        color: #333;
    }
    
    .shipping-desc {
        font-size: 0.875rem;
        color: #777;
    }
    
    .shipping-price {
        font-weight: 600;
        color: var(--primary-color);
    }
    
    .order-items {
        margin-bottom: 20px;
        max-height: 300px;
        overflow-y: auto;
        padding-right: 5px;
    }
    
    .order-items::-webkit-scrollbar {
        width: 6px;
    }
    
    .order-items::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .order-items::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }
    
    .order-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f1f1f1;
    }
    
    .order-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }
    
    .order-item-image {
        position: relative;
        width: 70px;
        height: 70px;
        margin-right: 15px;
    }
    
    .order-item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .order-item-quantity {
        position: absolute;
        top: -10px;
        right: -10px;
        background-color: var(--primary-color);
        color: white;
        width: 25px;
        height: 25px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .order-item-details {
        flex-grow: 1;
    }
    
    .order-item-name {
        font-weight: 600;
        color: #333;
    }
    
    .order-item-price {
        font-weight: 600;
        color: var(--primary-color);
    }
    
    .order-totals {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        margin-top: 20px;
    }
    
    .total-row {
        font-size: 1.25rem;
    }
    
    .checkout-total {
        color: var(--primary-color);
        font-weight: 700;
    }
    
    .order-submit {
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s;
    }
    
    .order-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }
    
    .back-to-cart {
        color: #777;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .back-to-cart:hover {
        color: var(--primary-color);
    }
    
    @media (min-width: 992px) {
        .shipping-options {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .payment-options {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 991px) {
        .shipping-options, .payment-options {
            grid-template-columns: 1fr;
        }
    }
    
    /* Animations */
    .order-submit, .shipping-btn, .payment-btn {
        position: relative;
        overflow: hidden;
    }
    
    .order-submit:after, .shipping-btn:after, .payment-btn:after {
        content: "";
        background: rgba(255, 255, 255, 0.2);
        display: block;
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 100%;
        opacity: 0;
        transition: all 0.3s;
    }
    
    .order-submit:active:after, .shipping-btn:active:after, .payment-btn:active:after {
        width: 100%;
        opacity: 1;
        transition: 0s;
    }
    
    .payment-btn:hover .payment-logo i, .btn-check:checked + .payment-btn .payment-logo i {
        animation: pulse 1s infinite;
    }
    
    @keyframes pulse {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
        100% {
            transform: scale(1);
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Update shipping cost and total when shipping method changes
        const shippingOptions = document.querySelectorAll('input[name="shipping_method"]');
        const shippingCostElement = document.getElementById('shipping-cost');
        const finalTotalElement = document.getElementById('final-total');
        const subtotal = {{ $totals['subtotal'] ?? 0 }};
        const discount = {{ $totals['discount'] ?? 0 }};
        const tax = {{ $totals['tax'] ?? 0 }};
        
        function updateTotal() {
            const selectedShipping = document.querySelector('input[name="shipping_method"]:checked');
            let shippingCost = 0;
            
            switch(selectedShipping.value) {
                case 'viettel_post':
                    shippingCost = 30000;
                    break;
                case 'shopee_express':
                    shippingCost = 25000;
                    break;
                case 'self_transport':
                    shippingCost = 40000;
                    break;
                case 'self_pickup':
                    shippingCost = 0;
                    break;
            }
            
            const total = subtotal + shippingCost + tax - discount;
            
            shippingCostElement.textContent = new Intl.NumberFormat('vi-VN').format(shippingCost) + ' ₫';
            finalTotalElement.textContent = new Intl.NumberFormat('vi-VN').format(total) + ' ₫';
        }
        
        shippingOptions.forEach(option => {
            option.addEventListener('change', updateTotal);
        });
        
        // Show/hide payment details
        const paymentOptions = document.querySelectorAll('input[name="payment_method"]');
        const bankDetails = document.getElementById('bank_transfer_details');
        
        paymentOptions.forEach(option => {
            option.addEventListener('change', function() {
                if (this.value === 'bank_transfer') {
                    bankDetails.style.display = 'block';
                } else {
                    bankDetails.style.display = 'none';
                }
            });
        });
        
        // Animation for checkout section
        const observerOptions = {
            threshold: 0.1
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate__animated', 'animate__fadeInUp');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);
        
        document.querySelectorAll('.checkout-section').forEach(section => {
            observer.observe(section);
        });
        
        // Initialize total
        updateTotal();
    });
</script>
@endpush
@endsection 