@extends('layouts.main')

@section('content')
<div class="success-container py-5 animate__animated animate__fadeIn">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="success-card">
                    <div class="success-header">
                        <div class="success-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h1 class="success-title">Cảm ơn bạn đã đặt hàng!</h1>
                        <p class="success-subtitle">Đơn hàng #{{ $order->id }} của bạn đã được xác nhận</p>
                    </div>
                    
                    <div class="success-body">
                        <div class="order-info">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <h5 class="info-title"><i class="fas fa-user me-2"></i>Thông tin khách hàng</h5>
                                    <div class="info-content">
                                        <p><strong>Họ tên:</strong> {{ $order->shipping_name }}</p>
                                        <p><strong>Email:</strong> {{ $order->shipping_email }}</p>
                                        <p><strong>Số điện thoại:</strong> {{ $order->shipping_phone }}</p>
                                        <p><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-4">
                                    <h5 class="info-title"><i class="fas fa-truck me-2"></i>Thông tin giao hàng</h5>
                                    <div class="info-content">
                                        <p><strong>Phương thức vận chuyển:</strong> 
                                            @switch($order->shipping_method)
                                                @case('viettel_post')
                                                    Viettel Post
                                                    @break
                                                @case('shopee_express')
                                                    Shopee Express
                                                    @break
                                                @case('self_transport')
                                                    Giao hàng hỏa tốc
                                                    @break
                                                @case('self_pickup')
                                                    Nhận tại cửa hàng
                                                    @break
                                                @default
                                                    {{ $order->shipping_method }}
                                            @endswitch
                                        </p>
                                        <p><strong>Phương thức thanh toán:</strong> 
                                            @switch($order->payment_method)
                                                @case('cod')
                                                    Thanh toán khi nhận hàng (COD)
                                                    @break
                                                @case('momo')
                                                    Ví MoMo
                                                    @break
                                                @case('zalopay')
                                                    Ví ZaloPay
                                                    @break
                                                @case('vnpay')
                                                    VNPAY-QR
                                                    @break
                                                @case('bank_transfer')
                                                    Chuyển khoản ngân hàng
                                                    @break
                                                @case('credit_card')
                                                    Thẻ tín dụng / Ghi nợ
                                                    @break
                                                @default
                                                    {{ $order->payment_method }}
                                            @endswitch
                                        </p>
                                        <p><strong>Trạng thái đơn hàng:</strong> <span class="badge bg-success">Đã xác nhận</span></p>
                                        <p><strong>Ngày đặt hàng:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <h5 class="info-title mb-3"><i class="fas fa-box-open me-2"></i>Chi tiết đơn hàng</h5>
                            <div class="order-items">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Sản phẩm</th>
                                                <th class="text-center">Số lượng</th>
                                                <th class="text-end">Đơn giá</th>
                                                <th class="text-end">Thành tiền</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($order->orderItems as $item)
                                                <tr>
                                                    <td>{{ $item->product_name }}</td>
                                                    <td class="text-center">{{ $item->quantity }}</td>
                                                    <td class="text-end">{{ number_format($item->price, 0, ',', '.') }} ₫</td>
                                                    <td class="text-end">{{ number_format($item->subtotal, 0, ',', '.') }} ₫</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" class="text-end"><strong>Tạm tính:</strong></td>
                                                <td class="text-end">{{ number_format($order->subtotal, 0, ',', '.') }} ₫</td>
                                            </tr>
                                            @if($order->discount > 0)
                                                <tr>
                                                    <td colspan="3" class="text-end"><strong>Giảm giá:</strong></td>
                                                    <td class="text-end text-success">-{{ number_format($order->discount, 0, ',', '.') }} ₫</td>
                                                </tr>
                                            @endif
                                            @if($order->shipping_cost > 0)
                                                <tr>
                                                    <td colspan="3" class="text-end"><strong>Phí vận chuyển:</strong></td>
                                                    <td class="text-end">{{ number_format($order->shipping_cost, 0, ',', '.') }} ₫</td>
                                                </tr>
                                            @endif
                                            @if($order->tax > 0)
                                                <tr>
                                                    <td colspan="3" class="text-end"><strong>Thuế (VAT):</strong></td>
                                                    <td class="text-end">{{ number_format($order->tax, 0, ',', '.') }} ₫</td>
                                                </tr>
                                            @endif
                                            <tr class="total-row">
                                                <td colspan="3" class="text-end"><strong>Tổng cộng:</strong></td>
                                                <td class="text-end total-amount">{{ number_format($order->total, 0, ',', '.') }} ₫</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            
                            <div class="shipping-status">
                                <h5 class="info-title mb-3"><i class="fas fa-shipping-fast me-2"></i>Trạng thái vận chuyển</h5>
                                <div class="status-timeline">
                                    <div class="status-item active">
                                        <div class="status-icon">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <div class="status-content">
                                            <h6>Đơn hàng đã đặt</h6>
                                            <p>{{ $order->created_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>
                                    <div class="status-item">
                                        <div class="status-icon">
                                            <i class="fas fa-box"></i>
                                        </div>
                                        <div class="status-content">
                                            <h6>Đang chuẩn bị hàng</h6>
                                            <p>Dự kiến: {{ $order->created_at->addDay()->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="status-item">
                                        <div class="status-icon">
                                            <i class="fas fa-truck"></i>
                                        </div>
                                        <div class="status-content">
                                            <h6>Đang vận chuyển</h6>
                                            <p>Dự kiến: {{ $order->created_at->addDays(2)->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="status-item">
                                        <div class="status-icon">
                                            <i class="fas fa-home"></i>
                                        </div>
                                        <div class="status-content">
                                            <h6>Đã giao hàng</h6>
                                            <p>Dự kiến: {{ $order->created_at->addDays(3)->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="success-footer">
                        <div class="row">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <a href="{{ route('user.orders') }}" class="btn btn-outline-primary rounded-pill w-100">
                                    <i class="fas fa-file-alt me-2"></i>Xem đơn hàng của tôi
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('products.index') }}" class="btn btn-primary rounded-pill w-100">
                                    <i class="fas fa-shopping-bag me-2"></i>Tiếp tục mua sắm
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    .success-container {
        background-color: #f8f9fa;
        min-height: 80vh;
        display: flex;
        align-items: center;
    }
    
    .success-card {
        background-color: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-bottom: 30px;
    }
    
    .success-header {
        text-align: center;
        padding: 40px 30px;
        background-color: #f1f9ff;
        position: relative;
    }
    
    .success-icon {
        width: 80px;
        height: 80px;
        background-color: #28a745;
        color: white;
        font-size: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }
    
    .success-title {
        color: #333;
        font-size: 2rem;
        margin-bottom: 10px;
    }
    
    .success-subtitle {
        color: #666;
        font-size: 1.25rem;
    }
    
    .success-body {
        padding: 30px;
    }
    
    .info-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
    }
    
    .info-title i {
        color: var(--primary-color);
    }
    
    .info-content {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 15px;
    }
    
    .info-content p {
        margin-bottom: 8px;
    }
    
    .info-content p:last-child {
        margin-bottom: 0;
    }
    
    .order-items {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 30px;
    }
    
    .table {
        margin-bottom: 0;
    }
    
    .table th, .table td {
        padding: 15px 10px;
        vertical-align: middle;
    }
    
    .table thead th {
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
    }
    
    .table tfoot {
        border-top: 2px solid #dee2e6;
    }
    
    .total-row {
        font-size: 1.1rem;
    }
    
    .total-amount {
        color: var(--primary-color);
        font-weight: 700;
        font-size: 1.2rem;
    }
    
    .status-timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .status-timeline::before {
        content: '';
        position: absolute;
        top: 0;
        left: 15px;
        width: 2px;
        height: 100%;
        background-color: #dee2e6;
        transform: translateX(-50%);
    }
    
    .status-item {
        position: relative;
        padding-bottom: 30px;
        display: flex;
    }
    
    .status-item:last-child {
        padding-bottom: 0;
    }
    
    .status-icon {
        width: 30px;
        height: 30px;
        background-color: #dee2e6;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: absolute;
        left: 0;
        transform: translateX(-50%);
        font-size: 12px;
        z-index: 1;
    }
    
    .status-item.active .status-icon {
        background-color: #28a745;
    }
    
    .status-content {
        padding-left: 20px;
    }
    
    .status-content h6 {
        font-weight: 600;
        margin-bottom: 5px;
    }
    
    .status-content p {
        color: #666;
        margin-bottom: 0;
        font-size: 0.9rem;
    }
    
    .success-footer {
        padding: 30px;
        border-top: 1px solid #f1f1f1;
    }
    
    .badge {
        font-weight: 500;
        padding: 6px 10px;
        border-radius: 30px;
    }
    
    .rounded-pill {
        border-radius: 50rem !important;
    }
    
    /* Animations */
    .success-icon {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
        100% {
            transform: scale(1);
        }
    }
</style>
@endpush
@endsection 