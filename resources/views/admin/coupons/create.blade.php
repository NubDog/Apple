@extends('layouts.admin')

@section('title', 'Thêm mã giảm giá mới')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.coupons.index') }}">Mã giảm giá</a></li>
<li class="breadcrumb-item active">Thêm mới</li>
@endsection

@section('content')
<div class="create-coupon-container animate__animated animate__fadeIn">
    <div class="card card-outline card-primary shadow">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-plus-circle mr-2"></i>Thêm mã giảm giá mới
            </h3>
            <div class="card-tools">
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-default btn-sm">
                    <i class="fas fa-arrow-left mr-1"></i> Quay lại danh sách
                </a>
            </div>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5><i class="icon fas fa-exclamation-triangle"></i> Lỗi!</h5>
                    <ul class="mb-0 pl-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.coupons.store') }}" method="POST" id="coupon-form">
                @csrf
                <div class="row">
                    <div class="col-lg-8">
                        <div class="main-form-section">
                            <div class="form-group">
                                <label for="code" class="control-label">Mã giảm giá <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-ticket-alt"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="code" name="code" value="{{ old('code') }}" required placeholder="Nhập mã giảm giá (VD: SUMMER2023)" maxlength="50">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary" id="generate-coupon">
                                            <i class="fas fa-random"></i> Tạo mã
                                        </button>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Mã phải là duy nhất, không trùng với các mã đã có.</small>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type" class="control-label">Loại giảm giá <span class="text-danger">*</span></label>
                                        <div class="d-flex">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="fixed" name="type" value="fixed" class="custom-control-input" {{ old('type', 'fixed') == 'fixed' ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="fixed">
                                                    <i class="fas fa-dollar-sign text-success"></i> Số tiền cố định
                                                </label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="percent" name="type" value="percent" class="custom-control-input" {{ old('type') == 'percent' ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="percent">
                                                    <i class="fas fa-percent text-warning"></i> Phần trăm
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="value" class="control-label">Giá trị <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                            </div>
                                            <input type="number" class="form-control" id="value" name="value" value="{{ old('value') }}" required min="0" step="0.01">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="value-addon">VNĐ</span>
                                            </div>
                                        </div>
                                        <small class="form-text text-muted" id="value-help">Số tiền giảm trực tiếp trên đơn hàng.</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="min_order_amount" class="control-label">Giá trị đơn hàng tối thiểu</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-shopping-cart"></i></span>
                                    </div>
                                    <input type="number" class="form-control" id="min_order_amount" name="min_order_amount" value="{{ old('min_order_amount') }}" min="0" step="0.01">
                                    <div class="input-group-append">
                                        <span class="input-group-text">VNĐ</span>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Để trống nếu không có giá trị đơn hàng tối thiểu.</small>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="max_uses" class="control-label">Số lần sử dụng tối đa</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-clipboard-list"></i></span>
                                            </div>
                                            <input type="number" class="form-control" id="max_uses" name="max_uses" value="{{ old('max_uses') }}" min="0" step="1">
                                        </div>
                                        <small class="form-text text-muted">Để trống nếu không giới hạn số lần sử dụng.</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="expires_at" class="control-label">Ngày hết hạn</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="date" class="form-control" id="expires_at" name="expires_at" value="{{ old('expires_at') }}" min="{{ date('Y-m-d') }}">
                                        </div>
                                        <small class="form-text text-muted">Để trống nếu mã không có hạn sử dụng.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="card bg-light shadow-sm">
                            <div class="card-header">
                                <h3 class="card-title">Tùy chọn</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_active">Kích hoạt</label>
                                    </div>
                                    <small class="form-text text-muted">Bật để mã giảm giá có thể sử dụng ngay.</small>
                                </div>
                                
                                <div id="coupon-preview" class="mt-4">
                                    <h5 class="text-center">Xem trước mã giảm giá</h5>
                                    <div class="coupon-card">
                                        <div class="coupon-container">
                                            <div class="coupon-left">
                                                <div class="coupon-scissors-icon">
                                                    <i class="fas fa-cut"></i>
                                                </div>
                                                <div class="dotted-line"></div>
                                            </div>
                                            <div class="coupon-content">
                                                <div class="coupon-header">
                                                    <h4 class="mb-0">Shark Car</h4>
                                                    <span class="badge badge-success">Hoạt động</span>
                                                </div>
                                                <div class="coupon-body">
                                                    <div class="coupon-value">
                                                        <span id="preview-value">0</span>
                                                        <span id="preview-type">VNĐ</span>
                                                    </div>
                                                    <div class="coupon-code-display">
                                                        <span id="preview-code">COUPONCODE</span>
                                                    </div>
                                                    <div class="coupon-details">
                                                        <p class="mb-1">
                                                            <small>
                                                                <i class="fas fa-money-bill-wave mr-1"></i>
                                                                Đơn hàng tối thiểu: <span id="preview-min">Không giới hạn</span>
                                                            </small>
                                                        </p>
                                                        <p class="mb-1">
                                                            <small>
                                                                <i class="fas fa-calendar-alt mr-1"></i>
                                                                Hết hạn: <span id="preview-expires">Không giới hạn</span>
                                                            </small>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-actions mt-3">
                            <button type="submit" class="btn btn-primary btn-block save-button">
                                <i class="fas fa-save mr-1"></i> Lưu mã giảm giá
                            </button>
                            <a href="{{ route('admin.coupons.index') }}" class="btn btn-default btn-block mt-2">
                                <i class="fas fa-times mr-1"></i> Hủy
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    .create-coupon-container {
        animation-duration: 0.6s;
    }
    
    .main-form-section {
        background-color: #fff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
    }
    
    .form-group label {
        font-weight: 600;
        color: #333;
    }
    
    .custom-radio .custom-control-input:checked ~ .custom-control-label::before {
        background-color: #007bff;
        border-color: #007bff;
    }
    
    .custom-switch .custom-control-input:checked ~ .custom-control-label::before {
        background-color: #28a745;
        border-color: #28a745;
    }
    
    .save-button {
        font-weight: 600;
        padding: 10px;
        transition: all 0.3s;
    }
    
    .save-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    /* Coupon preview styling */
    .coupon-card {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        overflow: hidden;
        margin-top: 15px;
        position: relative;
    }
    
    .coupon-container {
        display: flex;
        background-color: #fff;
        margin: 10px;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .coupon-left {
        width: 40px;
        background-color: #f5f5f5;
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    
    .coupon-scissors-icon {
        position: absolute;
        top: 20px;
        color: #999;
        font-size: 14px;
    }
    
    .dotted-line {
        height: 100%;
        border-right: 2px dashed #ccc;
    }
    
    .coupon-content {
        flex-grow: 1;
        padding: 15px;
    }
    
    .coupon-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    
    .coupon-header h4 {
        color: #333;
        font-weight: 700;
    }
    
    .coupon-body {
        text-align: center;
    }
    
    .coupon-value {
        font-size: 32px;
        font-weight: 700;
        color: #007bff;
        margin-bottom: 10px;
    }
    
    .coupon-code-display {
        background-color: #f1f1f1;
        padding: 8px 15px;
        border-radius: 5px;
        display: inline-block;
        margin-bottom: 10px;
        border: 1px dashed #999;
        font-family: 'Courier New', monospace;
        font-weight: 700;
        letter-spacing: 1px;
    }
    
    .coupon-details {
        text-align: left;
        margin-top: 10px;
        color: #666;
    }
    
    /* Input animations */
    .form-control {
        transition: all 0.3s;
    }
    
    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        transform: translateY(-2px);
    }
    
    /* Responsive adjustments */
    @media (max-width: 992px) {
        .col-lg-4 {
            margin-top: 20px;
        }
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('js/admin/coupons.js') }}"></script>
@endpush 