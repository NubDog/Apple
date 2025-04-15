@extends('layouts.main')

@section('content')
<div class="checkout-container py-5">
    <div class="container">
        <h1 class="text-center mb-5 animate__animated animate__fadeInDown">Thanh Toán</h1>
        
        <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
            @csrf
            
            <div class="row">
                <div class="col-lg-7 mb-4 mb-lg-0">
                    <div class="checkout-card animate__animated animate__fadeInLeft">
                        <div class="checkout-section">
                            <h3 class="checkout-title">
                                <div class="checkout-number"><i class="fas fa-user-alt"></i></div> Thông tin giao hàng
                            </h3>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="shipping_name" name="shipping_name" placeholder="Họ và tên" value="{{ $user->name ?? old('shipping_name') }}" required>
                                        <label for="shipping_name"><i class="fas fa-user-circle me-2"></i>Họ và tên</label>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="shipping_email" name="shipping_email" placeholder="Email" value="{{ $user->email ?? old('shipping_email') }}" required>
                                        <label for="shipping_email"><i class="fas fa-envelope me-2"></i>Email</label>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="tel" class="form-control" id="shipping_phone" name="shipping_phone" placeholder="Số điện thoại" value="{{ old('shipping_phone') }}" required>
                                        <label for="shipping_phone"><i class="fas fa-phone-alt me-2"></i>Số điện thoại</label>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="shipping_address" name="shipping_address" placeholder="Địa chỉ giao hàng" value="{{ old('shipping_address') }}" required>
                                        <label for="shipping_address"><i class="fas fa-map-marker-alt me-2"></i>Địa chỉ giao hàng</label>
                                    </div>
                                </div>
                                
                                <div class="col-12 mb-3">
                                    <div class="form-floating">
                                        <textarea class="form-control" id="notes" name="notes" placeholder="Ghi chú" style="height: 100px">{{ old('notes') }}</textarea>
                                        <label for="notes"><i class="fas fa-sticky-note me-2"></i>Ghi chú đơn hàng (tùy chọn)</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="checkout-section">
                            <h3 class="checkout-title">
                                <div class="checkout-number"><i class="fas fa-truck"></i></div> Phương thức vận chuyển
                            </h3>
                            
                            <div class="shipping-options">
                                <div class="shipping-option">
                                    <input type="radio" class="btn-check" name="shipping_method" id="viettel_post" value="viettel_post" required checked>
                                    <label class="shipping-btn" for="viettel_post">
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
                                    <label class="shipping-btn" for="shopee_express">
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
                                    <label class="shipping-btn" for="self_transport">
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
                                    <label class="shipping-btn" for="self_pickup">
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
                                <div class="checkout-number"><i class="fas fa-credit-card"></i></div> Phương thức thanh toán
                            </h3>
                            
                            <div class="payment-options">
                                <div class="payment-option">
                                    <input type="radio" class="btn-check" name="payment_method" id="cod" value="cod" required checked>
                                    <label class="payment-btn" for="cod">
                                        <div class="payment-logo">
                                            <i class="fas fa-money-bill-wave"></i>
                                        </div>
                                        <div class="payment-name">Thanh toán khi nhận hàng (COD)</div>
                                    </label>
                                </div>
                                
                                <div class="payment-option">
                                    <input type="radio" class="btn-check" name="payment_method" id="momo" value="momo">
                                    <label class="payment-btn" for="momo">
                                        <div class="payment-logo">
                                            <img src="https://upload.wikimedia.org/wikipedia/vi/f/fe/MoMo_Logo.png" alt="MoMo">
                                        </div>
                                        <div class="payment-name">Ví MoMo</div>
                                    </label>
                                </div>
                                
                                <div class="payment-option">
                                    <input type="radio" class="btn-check" name="payment_method" id="zalopay" value="zalopay">
                                    <label class="payment-btn" for="zalopay">
                                        <div class="payment-logo">
                                            <img src="https://cdn.haitrieu.com/wp-content/uploads/2022/10/Logo-ZaloPay-Square.png" alt="ZaloPay">
                                        </div>
                                        <div class="payment-name">Ví ZaloPay</div>
                                    </label>
                                </div>
                                
                                <div class="payment-option">
                                    <input type="radio" class="btn-check" name="payment_method" id="vnpay" value="vnpay">
                                    <label class="payment-btn" for="vnpay">
                                        <div class="payment-logo">
                                            <img src="https://cdn.haitrieu.com/wp-content/uploads/2022/10/Logo-VNPAY-QR-1.png" alt="VNPay">
                                        </div>
                                        <div class="payment-name">Thanh toán VNPAY-QR</div>
                                    </label>
                                </div>
                                
                                <div class="payment-option">
                                    <input type="radio" class="btn-check" name="payment_method" id="bank_transfer" value="bank_transfer">
                                    <label class="payment-btn" for="bank_transfer">
                                        <div class="payment-logo">
                                            <i class="fas fa-university"></i>
                                        </div>
                                        <div class="payment-name">Chuyển khoản ngân hàng</div>
                                    </label>
                                </div>
                                
                                <div class="payment-option">
                                    <input type="radio" class="btn-check" name="payment_method" id="credit_card" value="credit_card">
                                    <label class="payment-btn" for="credit_card">
                                        <div class="payment-logo">
                                            <i class="far fa-credit-card"></i>
                                        </div>
                                        <div class="payment-name">Thẻ tín dụng / Ghi nợ</div>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="mt-4 payment-details" id="bank_transfer_details" style="display: none;">
                                <div class="alert alert-info">
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
                            <h3 class="checkout-title mb-4">Đơn hàng của bạn</h3>
                            
                            <div class="order-items">
                                @foreach($cart as $id => $item)
                                    <div class="order-item">
                                        <div class="order-item-image">
                                            <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="img-fluid" onerror="this.src='/images/no-image.jpg'">
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
                                    <input type="text" class="form-control" placeholder="Mã giảm giá" 
                                        value="{{ Session::has('coupon') ? Session::get('coupon')['code'] : '' }}" 
                                        {{ Session::has('coupon') ? 'disabled' : '' }}>
                                    @if(Session::has('coupon'))
                                        <a href="{{ route('cart.remove-coupon') }}" class="btn btn-outline-danger">Xóa</a>
                                    @else
                                        <button class="btn btn-primary" type="button">Áp dụng</button>
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
                            
                            <button type="submit" class="btn btn-lg btn-checkout w-100 mt-3">
                                <span class="btn-text"><i class="fas fa-lock me-2"></i>Đặt hàng</span>
                                <span class="btn-icon"><i class="fas fa-angle-right"></i></span>
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
    :root {
        --primary-color: #4070f4;
        --primary-light: #5c8aff;
        --primary-dark: #2c50c5;
        --secondary-color: #fd5631;
        --light-bg: #f8f9fa;
        --dark-color: #212529;
        --text-color: #525252;
        --white-color: #ffffff;
        --shadow-sm: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.05);
        --shadow-md: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.07);
        --shadow-lg: 0 10px 30px rgba(0, 0, 0, 0.08);
        --gradient-primary: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        --transition-normal: all 0.3s ease;
        --border-radius-sm: 0.5rem;
        --border-radius-md: 1rem;
        --border-radius-lg: 1.5rem;
        --border-radius-xl: 2rem;
    }
    
    .checkout-container {
        background-color: var(--light-bg);
        padding-bottom: 4rem;
    }
    
    .checkout-card {
        background-color: var(--white-color);
        border-radius: var(--border-radius-md);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        margin-bottom: 30px;
        transition: var(--transition-normal);
        border: none;
    }
    
    .checkout-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(64, 112, 244, 0.1);
    }
    
    .checkout-section {
        padding: 30px;
        border-bottom: 1px solid rgba(0,0,0,0.04);
    }
    
    .checkout-section:last-child {
        border-bottom: none;
    }
    
    .checkout-title {
        font-size: 1.25rem;
        margin-bottom: 25px;
        color: var(--dark-color);
        position: relative;
        font-weight: 600;
        display: flex;
        align-items: center;
    }
    
    .checkout-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        background: var(--gradient-primary);
        color: var(--white-color);
        border-radius: 50%;
        margin-right: 15px;
        font-size: 1rem;
        box-shadow: 0 4px 15px rgba(64, 112, 244, 0.3);
    }
    
    .form-floating .form-control {
        border: 2px solid #e9ecef;
        border-radius: var(--border-radius-sm);
        padding: 1rem 1rem;
        height: calc(3.5rem + 2px);
        font-size: 1rem;
        transition: var(--transition-normal);
    }
    
    .form-floating textarea.form-control {
        height: 120px;
        border-radius: var(--border-radius-sm);
    }
    
    .form-floating .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(64, 112, 244, 0.15);
    }
    
    .form-floating label {
        padding: 1rem 1rem;
        color: #6c757d;
    }
    
    .form-floating label i {
        color: var(--primary-color);
    }
    
    .form-floating > .form-control:focus ~ label,
    .form-floating > .form-control:not(:placeholder-shown) ~ label {
        transform: scale(0.85) translateY(-0.85rem) translateX(0.15rem);
        color: var(--primary-color);
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
        padding: 20px;
        text-align: left;
        border: 2px solid #e9ecef;
        background-color: var(--white-color);
        transition: var(--transition-normal);
        width: 100%;
        border-radius: var(--border-radius-md);
    }
    
    .shipping-btn:hover, .payment-btn:hover {
        border-color: var(--primary-light);
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
    }
    
    .btn-check:checked + .shipping-btn, .btn-check:checked + .payment-btn {
        border-color: var(--primary-color);
        background-color: rgba(64, 112, 244, 0.05);
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
        animation: fadeIn 0.3s ease;
    }
    
    .shipping-logo, .payment-logo {
        width: 50px;
        height: 50px;
        margin-right: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        border-radius: 12px;
        padding: 10px;
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
        color: var(--dark-color);
    }
    
    .shipping-desc {
        font-size: 0.875rem;
        color: #6c757d;
        margin-top: 5px;
    }
    
    .shipping-price {
        font-weight: 600;
        color: var(--primary-color);
        text-align: right;
        margin-left: 15px;
        white-space: nowrap;
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
        animation: fadeIn 0.5s ease;
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
        border-radius: var(--border-radius-sm);
        overflow: hidden;
    }
    
    .order-item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .order-item-quantity {
        position: absolute;
        top: -8px;
        right: -8px;
        background: var(--gradient-primary);
        color: white;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 600;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .order-item-details {
        flex-grow: 1;
    }
    
    .order-item-name {
        font-weight: 600;
        color: var(--dark-color);
    }
    
    .order-item-price {
        font-weight: 600;
        color: var(--primary-color);
        white-space: nowrap;
        margin-left: 10px;
    }
    
    .coupon-section {
        margin: 20px 0;
    }
    
    .input-group {
        position: relative;
    }
    
    .input-group .form-control {
        border-top-left-radius: var(--border-radius-sm);
        border-bottom-left-radius: var(--border-radius-sm);
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        border: 2px solid #e9ecef;
        border-right: none;
        padding: 0.75rem 1rem;
    }
    
    .input-group .btn {
        border-top-right-radius: var(--border-radius-sm);
        border-bottom-right-radius: var(--border-radius-sm);
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        padding: 0.75rem 1.25rem;
    }
    
    .order-totals {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: var(--border-radius-sm);
        margin-top: 20px;
    }
    
    .total-row {
        font-size: 1.25rem;
        color: var(--dark-color);
    }
    
    .checkout-total {
        color: var(--primary-color);
        font-weight: 700;
        font-size: 1.35rem;
    }
    
    .btn-checkout {
        position: relative;
        background: var(--gradient-primary);
        color: white;
        border: none;
        padding: 15px 30px;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        border-radius: var(--border-radius-md);
        box-shadow: 0 5px 15px rgba(64, 112, 244, 0.3);
        transition: all 0.3s;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-checkout:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(64, 112, 244, 0.4);
    }
    
    .btn-checkout:active {
        transform: translateY(-1px);
    }
    
    .btn-checkout .btn-text {
        z-index: 2;
        display: inline-flex;
        align-items: center;
    }
    
    .btn-checkout .btn-icon {
        z-index: 2;
        position: absolute;
        right: 20px;
        opacity: 0;
        transform: translateX(-20px);
        transition: all 0.3s;
    }
    
    .btn-checkout:hover .btn-icon {
        opacity: 1;
        transform: translateX(0);
    }
    
    .btn-checkout:hover .btn-text {
        transform: translateX(-10px);
    }
    
    .btn-checkout::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to right, var(--primary-dark), var(--primary-color));
        opacity: 0;
        z-index: 1;
        transition: all 0.5s;
    }
    
    .btn-checkout:hover::before {
        opacity: 1;
    }
    
    .back-to-cart {
        color: #6c757d;
        text-decoration: none;
        font-weight: 500;
        transition: var(--transition-normal);
        display: inline-flex;
        align-items: center;
    }
    
    .back-to-cart:hover {
        color: var(--primary-color);
        transform: translateX(-3px);
    }
    
    .alert {
        border-radius: var(--border-radius-sm);
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
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    @keyframes slideInLeft {
        from { transform: translateX(-50px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    @keyframes slideInRight {
        from { transform: translateX(50px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    .animate-pulse {
        animation: pulse 2s infinite;
    }
    
    .checkout-title, .order-item, .shipping-btn, .payment-btn {
        animation: fadeIn 0.5s ease;
    }
    
    .shipping-btn:hover .shipping-logo,
    .payment-btn:hover .payment-logo,
    .btn-check:checked + .shipping-btn .shipping-logo,
    .btn-check:checked + .payment-btn .payment-logo {
        animation: pulse 1s infinite;
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
        
        // Get values from PHP using Blade variables
        const subtotal = Number('{{ $totals['subtotal'] ?? 0 }}');
        const discount = Number('{{ $totals['discount'] ?? 0 }}');
        const tax = Number('{{ $totals['tax'] ?? 0 }}');
        
        function updateTotal() {
            const selectedShipping = document.querySelector('input[name="shipping_method"]:checked');
            let shippingCost = 0;
            
            if (selectedShipping) {
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
        
        // Add scroll animation
        const animateOnScroll = function(entries, observer) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate__animated');
                    
                    if (entry.target.classList.contains('checkout-section')) {
                        entry.target.classList.add('animate__fadeInUp');
                    }
                    
                    observer.unobserve(entry.target);
                }
            });
        };
        
        const observer = new IntersectionObserver(animateOnScroll, {
            root: null,
            threshold: 0.1
        });
        
        document.querySelectorAll('.checkout-section').forEach(section => {
            observer.observe(section);
        });
        
        // Initialize total calculation
        updateTotal();
    });
</script>
@endpush
@endsection 