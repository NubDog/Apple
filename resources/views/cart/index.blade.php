@extends('layouts.main')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Giỏ hàng của bạn</h1>
    
    @if(count($cart) > 0)
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <form action="{{ route('cart.update') }}" method="POST">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 100px">Ảnh</th>
                                            <th>Sản phẩm</th>
                                            <th>Giá</th>
                                            <th>Số lượng</th>
                                            <th>Tổng</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cart as $id => $item)
                                            <tr>
                                                <td>
                                                    <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="img-fluid" style="max-height: 80px; object-fit: cover;" onerror="this.src='/images/no-image.jpg'">
                                                </td>
                                                <td>
                                                    <a href="{{ route('products.show', $id) }}" class="text-decoration-none text-dark fw-bold">
                                                        {{ $item['name'] }}
                                                    </a>
                                                </td>
                                                <td>{{ number_format($item['price'], 0, ',', '.') }} đ</td>
                                                <td style="width: 150px">
                                                    <div class="input-group">
                                                        <button type="button" class="btn btn-outline-secondary quantity-btn" data-action="decrease">-</button>
                                                        <input type="number" name="quantity[{{ $id }}]" value="{{ $item['quantity'] }}" min="1" class="form-control text-center quantity-input">
                                                        <button type="button" class="btn btn-outline-secondary quantity-btn" data-action="increase">+</button>
                                                    </div>
                                                </td>
                                                <td>{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} đ</td>
                                                <td>
                                                    <a href="{{ route('cart.remove', $id) }}" class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-arrow-left me-2"></i>Tiếp tục mua sắm
                                </a>
                                <div>
                                    <a href="{{ route('cart.clear') }}" class="btn btn-outline-danger me-2">
                                        <i class="fas fa-trash me-2"></i>Xóa giỏ hàng
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-sync-alt me-2"></i>Cập nhật giỏ hàng
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Tóm tắt đơn hàng</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tạm tính:</span>
                            <span class="fw-bold">{{ number_format($totals['subtotal'], 0, ',', '.') }} đ</span>
                        </div>
                        
                        @if($totals['discount'] > 0)
                            <div class="d-flex justify-content-between mb-2 text-success">
                                <span>Giảm giá:</span>
                                <span class="fw-bold">-{{ number_format($totals['discount'], 0, ',', '.') }} đ</span>
                            </div>
                        @endif
                        
                        @if($totals['shipping'] > 0)
                            <div class="d-flex justify-content-between mb-2">
                                <span>Phí vận chuyển:</span>
                                <span class="fw-bold">{{ number_format($totals['shipping'], 0, ',', '.') }} đ</span>
                            </div>
                        @endif
                        
                        @if($totals['tax'] > 0)
                            <div class="d-flex justify-content-between mb-2">
                                <span>Thuế:</span>
                                <span class="fw-bold">{{ number_format($totals['tax'], 0, ',', '.') }} đ</span>
                            </div>
                        @endif
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold">Tổng cộng:</span>
                            <span class="fw-bold fs-5 text-primary">{{ number_format($totals['total'], 0, ',', '.') }} đ</span>
                        </div>
                        
                        <a href="{{ route('checkout.index') }}" class="btn btn-success w-100">
                            <i class="fas fa-credit-card me-2"></i>Tiến hành thanh toán
                        </a>
                    </div>
                </div>
                
                <!-- Coupon Section -->
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Mã giảm giá</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('cart.apply.coupon') }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="code" class="form-control" placeholder="Nhập mã giảm giá">
                                <button type="submit" class="btn btn-primary">Áp dụng</button>
                            </div>
                        </form>
                        
                        @if(Session::has('coupon'))
                            <div class="alert alert-success mt-3 mb-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <small class="d-block">Mã đang áp dụng:</small>
                                        <strong>{{ Session::get('coupon')['code'] }}</strong>
                                    </div>
                                    <a href="{{ route('cart.remove-coupon') }}" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5 my-5">
            <div class="mb-4">
                <i class="fas fa-shopping-cart fa-4x text-muted"></i>
            </div>
            <h2 class="mb-3">Giỏ hàng của bạn đang trống</h2>
            <p class="text-muted mb-4">Bạn chưa thêm sản phẩm nào vào giỏ hàng</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-shopping-bag me-2"></i>Khám phá các sản phẩm
            </a>
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Quantity buttons functionality
        const quantityBtns = document.querySelectorAll('.quantity-btn');
        
        quantityBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const action = this.getAttribute('data-action');
                const input = this.closest('.input-group').querySelector('.quantity-input');
                let value = parseInt(input.value);
                
                if (action === 'increase') {
                    value++;
                } else if (action === 'decrease' && value > 1) {
                    value--;
                }
                
                input.value = value;
            });
        });
    });
</script>
@endpush
@endsection 