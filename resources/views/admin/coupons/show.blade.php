@extends('layouts.admin')

@section('title', 'Chi tiết mã giảm giá')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.coupons.index') }}">Mã giảm giá</a></li>
<li class="breadcrumb-item active">Chi tiết</li>
@endsection

@section('content')
<div class="coupon-detail-container animate__animated animate__fadeIn">
    <div class="card card-outline card-info shadow-lg">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-ticket-alt mr-2"></i>Chi tiết mã giảm giá
            </h3>
            <div class="card-tools">
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-default btn-sm mr-2">
                    <i class="fas fa-arrow-left mr-1"></i> Quay lại danh sách
                </a>
                <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="btn btn-info btn-sm">
                    <i class="fas fa-edit mr-1"></i> Chỉnh sửa
                </a>
            </div>
        </div>
        
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="coupon-preview-card animate__animated animate__zoomIn animate__delay-1s">
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
                                    <span class="badge {{ $coupon->is_active ? 'badge-success' : 'badge-danger' }} animate__animated animate__pulse animate__infinite">
                                        {{ $coupon->is_active ? 'Hoạt động' : 'Không hoạt động' }}
                                    </span>
                                </div>
                                <div class="coupon-body">
                                    <div class="coupon-value">
                                        <span>{{ $coupon->value }}</span>
                                        <span>{{ $coupon->type == 'fixed' ? 'VNĐ' : '%' }}</span>
                                    </div>
                                    <div class="coupon-code-display animate__animated animate__heartBeat animate__delay-2s">
                                        <span id="coupon-code">{{ $coupon->code }}</span>
                                        <button type="button" class="btn btn-sm btn-outline-secondary copy-btn" data-clipboard-target="#coupon-code">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                    <div class="coupon-details">
                                        <p class="mb-1">
                                            <small>
                                                <i class="fas fa-money-bill-wave mr-1"></i>
                                                Đơn hàng tối thiểu: 
                                                <span id="preview-min">
                                                    {{ $coupon->min_order_amount ? number_format($coupon->min_order_amount, 0, ',', '.') . ' VNĐ' : 'Không giới hạn' }}
                                                </span>
                                            </small>
                                        </p>
                                        <p class="mb-1">
                                            <small>
                                                <i class="fas fa-calendar-alt mr-1"></i>
                                                Hết hạn: 
                                                <span id="preview-expires">
                                                    {{ $coupon->expires_at ? $coupon->expires_at->format('d/m/Y') : 'Không giới hạn' }}
                                                </span>
                                            </small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="usage-stats p-3 bg-light rounded mt-4 animate__animated animate__fadeInUp animate__delay-1s">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="small-box bg-info h-100">
                                    <div class="inner">
                                        <h3>{{ $coupon->used_times ?? 0 }}</h3>
                                        <p>Đã sử dụng</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="small-box bg-success h-100">
                                    <div class="inner">
                                        <h3>{{ $coupon->max_uses ? $coupon->max_uses - $coupon->used_times : '∞' }}</h3>
                                        <p>Còn lại</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-ticket-alt"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="coupon-status mt-2">
                            <h5 class="text-center mb-3">Trạng thái mã giảm giá</h5>
                            <div class="status-indicators">
                                @if($coupon->isValid())
                                    <div class="status-item valid">
                                        <i class="fas fa-check-circle"></i>
                                        <span>Có thể sử dụng</span>
                                    </div>
                                @else
                                    <div class="status-item invalid">
                                        <i class="fas fa-times-circle"></i>
                                        <span>Không thể sử dụng</span>
                                    </div>
                                @endif
                                
                                @if($coupon->expires_at && $coupon->expires_at->isPast())
                                    <div class="status-item expired">
                                        <i class="fas fa-calendar-times"></i>
                                        <span>Đã hết hạn</span>
                                    </div>
                                @endif
                                
                                @if($coupon->max_uses && $coupon->used_times >= $coupon->max_uses)
                                    <div class="status-item depleted">
                                        <i class="fas fa-ticket-alt"></i>
                                        <span>Đã hết lượt sử dụng</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-8">
                    <div class="info-card bg-white p-4 rounded shadow-sm animate__animated animate__fadeInRight animate__delay-1s">
                        <h5 class="border-bottom pb-2 mb-3">
                            <i class="fas fa-info-circle mr-2"></i>Thông tin chi tiết
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-group mb-4">
                                    <label class="text-muted">ID</label>
                                    <div class="info-value">#{{ $coupon->id }}</div>
                                </div>
                                
                                <div class="info-group mb-4">
                                    <label class="text-muted">Mã giảm giá</label>
                                    <div class="info-value font-weight-bold">
                                        {{ $coupon->code }}
                                    </div>
                                </div>
                                
                                <div class="info-group mb-4">
                                    <label class="text-muted">Loại giảm giá</label>
                                    <div class="info-value">
                                        @if($coupon->type == 'fixed')
                                            <span class="badge badge-info">Giảm theo số tiền cố định</span>
                                        @else
                                            <span class="badge badge-warning">Giảm theo phần trăm (%)</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="info-group mb-4">
                                    <label class="text-muted">Giá trị</label>
                                    <div class="info-value">
                                        @if($coupon->type == 'fixed')
                                            <span class="text-primary font-weight-bold">{{ number_format($coupon->value) }} VNĐ</span>
                                        @else
                                            <span class="text-warning font-weight-bold">{{ $coupon->value }}%</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="info-group mb-4">
                                    <label class="text-muted">Giá trị đơn hàng tối thiểu</label>
                                    <div class="info-value">
                                        @if($coupon->min_order_amount)
                                            <span class="font-weight-bold">{{ number_format($coupon->min_order_amount) }} VNĐ</span>
                                        @else
                                            <span class="text-muted"><i class="fas fa-infinity"></i> Không giới hạn</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="info-group mb-4">
                                    <label class="text-muted">Số lần sử dụng tối đa</label>
                                    <div class="info-value">
                                        @if($coupon->max_uses)
                                            <span class="font-weight-bold">{{ $coupon->max_uses }}</span>
                                        @else
                                            <span class="text-muted"><i class="fas fa-infinity"></i> Không giới hạn</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="info-group mb-4">
                                    <label class="text-muted">Ngày hết hạn</label>
                                    <div class="info-value">
                                        @if($coupon->expires_at)
                                            <span class="{{ $coupon->expires_at->isPast() ? 'text-danger' : 'text-success' }}">
                                                {{ $coupon->expires_at->format('d/m/Y H:i') }}
                                            </span>
                                            @if($coupon->expires_at->isPast())
                                                <span class="badge badge-danger ml-2">Đã hết hạn</span>
                                            @else
                                                <span class="badge badge-success ml-2">Còn {{ now()->diffInDays($coupon->expires_at) }} ngày</span>
                                            @endif
                                        @else
                                            <span class="text-muted"><i class="fas fa-infinity"></i> Không giới hạn</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="timeline-section">
                                    <h5 class="border-bottom pb-2 mb-3">
                                        <i class="fas fa-history mr-2"></i>Lịch sử
                                    </h5>
                                    
                                    <div class="timeline">
                                        <div class="timeline-item">
                                            <div class="timeline-marker bg-success"></div>
                                            <div class="timeline-content">
                                                <h6 class="timeline-title">Tạo mã giảm giá</h6>
                                                <div class="timeline-date">{{ $coupon->created_at->format('d/m/Y H:i:s') }}</div>
                                            </div>
                                        </div>
                                        
                                        @if($coupon->created_at != $coupon->updated_at)
                                        <div class="timeline-item">
                                            <div class="timeline-marker bg-info"></div>
                                            <div class="timeline-content">
                                                <h6 class="timeline-title">Cập nhật gần nhất</h6>
                                                <div class="timeline-date">{{ $coupon->updated_at->format('d/m/Y H:i:s') }}</div>
                                            </div>
                                        </div>
                                        @endif
                                        
                                        @if($coupon->expires_at)
                                        <div class="timeline-item">
                                            <div class="timeline-marker {{ $coupon->expires_at->isPast() ? 'bg-danger' : 'bg-warning' }}"></div>
                                            <div class="timeline-content">
                                                <h6 class="timeline-title">Ngày hết hạn</h6>
                                                <div class="timeline-date">{{ $coupon->expires_at->format('d/m/Y H:i:s') }}</div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-footer">
            <div class="d-flex justify-content-between">
                <div>
                    <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="btn btn-info animate__animated animate__pulse animate__infinite animate__slower">
                        <i class="fas fa-edit mr-1"></i> Chỉnh sửa
                    </a>
                </div>
                <div>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                        <i class="fas fa-trash mr-1"></i> Xóa mã giảm giá
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal xác nhận xóa -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa mã giảm giá <strong>"{{ $coupon->code }}"</strong> không?</p> 
                    <p class="text-danger"><i class="fas fa-exclamation-triangle mr-1"></i> Hành động này không thể hoàn tác và sẽ xóa tất cả dữ liệu liên quan đến mã giảm giá này.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Xác nhận xóa</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    .coupon-detail-container {
        animation-duration: 0.6s;
    }
    
    /* Coupon preview styling */
    .coupon-preview-card {
        margin-bottom: 20px;
        animation-duration: 0.8s;
    }
    
    .coupon-container {
        display: flex;
        background-color: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%);
        padding: 10px;
    }

    .coupon-left {
        width: 40px;
        background-color: #f5f5f5;
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border-radius: 5px 0 0 5px;
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
        background-color: white;
        border-radius: 0 5px 5px 0;
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
        margin: 0;
    }
    
    .coupon-body {
        text-align: center;
    }

    .coupon-value {
        font-size: 32px;
        font-weight: 700;
        color: #17a2b8;
        margin-bottom: 10px;
    }

    .coupon-code-display {
        background-color: #f8f9fa;
        padding: 8px 15px;
        border-radius: 5px;
        display: inline-flex;
        align-items: center;
        margin-bottom: 10px;
        border: 1px dashed #999;
        font-family: 'Courier New', monospace;
        font-weight: 700;
        letter-spacing: 1px;
        animation-duration: 2s;
    }
    
    .coupon-code-display .copy-btn {
        margin-left: 10px;
        opacity: 0.6;
        transition: all 0.3s;
    }
    
    .coupon-code-display .copy-btn:hover {
        opacity: 1;
    }

    .coupon-details {
        text-align: left;
        margin-top: 10px;
        color: #666;
    }
    
    /* Usage stats */
    .usage-stats {
        animation-duration: 0.8s;
    }
    
    .usage-stats .small-box {
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
        transition: all 0.3s;
        overflow: hidden;
    }
    
    .usage-stats .small-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .usage-stats .small-box .inner {
        padding: 15px;
    }
    
    .usage-stats .small-box h3 {
        font-size: 28px;
        font-weight: 700;
        margin: 0;
        white-space: nowrap;
        padding: 0;
    }
    
    .usage-stats .small-box p {
        font-size: 14px;
        margin-bottom: 0;
    }
    
    .usage-stats .small-box .icon {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 0;
        font-size: 50px;
        color: rgba(255, 255, 255, 0.2);
    }
    
    /* Status indicators */
    .coupon-status {
        background-color: white;
        border-radius: 10px;
        padding: 15px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    
    .status-indicators {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    
    .status-item {
        display: flex;
        align-items: center;
        padding: 8px;
        border-radius: 5px;
        font-weight: 500;
    }
    
    .status-item i {
        margin-right: 10px;
        font-size: 18px;
    }
    
    .status-item.valid {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }
    
    .status-item.invalid {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }
    
    .status-item.expired {
        background-color: rgba(255, 193, 7, 0.1);
        color: #ffc107;
    }
    
    .status-item.depleted {
        background-color: rgba(108, 117, 125, 0.1);
        color: #6c757d;
    }
    
    /* Info card */
    .info-card {
        border-radius: 10px;
        height: 100%;
    }
    
    .info-group {
        margin-bottom: 15px;
    }
    
    .info-group label {
        display: block;
        margin-bottom: 5px;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .info-value {
        font-size: 16px;
    }
    
    /* Timeline section */
    .timeline-section {
        margin-top: 20px;
    }
    
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        top: 0;
        left: 8px;
        height: 100%;
        width: 2px;
        background-color: #e9ecef;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }
    
    .timeline-marker {
        position: absolute;
        top: 0;
        left: -30px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
    }
    
    .timeline-title {
        margin: 0;
        font-weight: 600;
    }
    
    .timeline-date {
        font-size: 12px;
        color: #6c757d;
    }
    
    /* Animation durations */
    .animate__fadeIn {
        animation-duration: 0.8s;
    }
    
    .animate__fadeInRight,
    .animate__fadeInUp {
        animation-duration: 1s;
    }
    
    .animate__pulse {
        animation-duration: 2s;
    }
    
    @media (max-width: 992px) {
        .info-card {
            margin-top: 20px;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<script src="{{ asset('js/admin/coupons.js') }}"></script>
@endpush 