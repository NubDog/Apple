@extends('layouts.admin')

@section('title', 'Quản lý mã giảm giá')

@section('breadcrumb')
<li class="breadcrumb-item active">Mã giảm giá</li>
@endsection

@section('content')
<div class="coupons-container animate__animated animate__fadeIn">
    <div class="row mb-4">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-info">
                <div class="inner">
                    <h3>{{ $coupons->where('is_active', 1)->count() }}</h3>
                    <p>Mã đang hoạt động</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-success">
                <div class="inner">
                    <h3>{{ $coupons->where('type', 'fixed')->count() }}</h3>
                    <p>Mã giảm giá cố định</p>
                </div>
                <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-warning">
                <div class="inner">
                    <h3>{{ $coupons->where('type', 'percent')->count() }}</h3>
                    <p>Mã giảm giá phần trăm</p>
                </div>
                <div class="icon">
                    <i class="fas fa-percent"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-danger">
                <div class="inner">
                    <h3>{{ $coupons->where('expires_at', '<', now())->count() }}</h3>
                    <p>Mã đã hết hạn</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-times"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-outline card-primary shadow-lg">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-ticket-alt mr-2"></i>Danh sách mã giảm giá
            </h3>
            <div class="card-tools">
                <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus-circle mr-1"></i> Thêm mã giảm giá
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="filters-section mb-4">
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <div class="input-group">
                            <input type="text" id="search-coupon" class="form-control" placeholder="Tìm kiếm mã giảm giá...">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="d-flex justify-content-end">
                            <div class="btn-group mr-2">
                                <button type="button" class="btn btn-outline-primary filter-btn" data-filter="all">Tất cả</button>
                                <button type="button" class="btn btn-outline-success filter-btn" data-filter="active">Đang hoạt động</button>
                                <button type="button" class="btn btn-outline-danger filter-btn" data-filter="expired">Đã hết hạn</button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-outline-info filter-btn" data-filter="fixed">Cố định</button>
                                <button type="button" class="btn btn-outline-warning filter-btn" data-filter="percent">Phần trăm</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-bordered coupon-table">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center" width="60">#</th>
                            <th width="150">Mã giảm giá</th>
                            <th width="100">Loại</th>
                            <th>Giá trị</th>
                            <th>Đơn hàng tối thiểu</th>
                            <th>Giới hạn sử dụng</th>
                            <th>Đã sử dụng</th>
                            <th>Trạng thái</th>
                            <th>Ngày hết hạn</th>
                            <th class="text-center" width="120">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($coupons as $coupon)
                            <tr class="coupon-row animate__animated animate__fadeIn" 
                                data-type="{{ $coupon->type }}" 
                                data-status="{{ $coupon->is_active ? 'active' : 'inactive' }}" 
                                data-expired="{{ $coupon->expires_at && $coupon->expires_at->isPast() ? 'expired' : 'valid' }}">
                                <td class="text-center">{{ $coupon->id }}</td>
                                <td>
                                    <span class="coupon-code">{{ $coupon->code }}</span>
                                </td>
                                <td>
                                    @if($coupon->type == 'fixed')
                                        <span class="badge badge-info badge-pill">Cố định</span>
                                    @else
                                        <span class="badge badge-warning badge-pill">Phần trăm</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="value-display">
                                        @if($coupon->type == 'fixed')
                                            <span class="text-primary font-weight-bold">{{ number_format($coupon->value) }} VNĐ</span>
                                        @else
                                            <span class="text-warning font-weight-bold">{{ $coupon->value }}%</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($coupon->min_order_amount)
                                        <span class="font-weight-bold">{{ number_format($coupon->min_order_amount) }} VNĐ</span>
                                    @else
                                        <span class="text-muted"><i class="fas fa-infinity"></i> Không giới hạn</span>
                                    @endif
                                </td>
                                <td>
                                    @if($coupon->max_uses)
                                        <span class="font-weight-bold">{{ $coupon->max_uses }}</span>
                                    @else
                                        <span class="text-muted"><i class="fas fa-infinity"></i> Không giới hạn</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $coupon->used_times }}</span>
                                </td>
                                <td>
                                    <div class="status-display">
                                        @if($coupon->is_active)
                                            <span class="badge badge-success"><i class="fas fa-check-circle mr-1"></i> Hoạt động</span>
                                        @else
                                            <span class="badge badge-danger"><i class="fas fa-ban mr-1"></i> Không hoạt động</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($coupon->expires_at)
                                        <div class="expiry-display">
                                            <span class="{{ $coupon->expires_at->isPast() ? 'text-danger' : 'text-success' }}">
                                                {{ $coupon->expires_at->format('d/m/Y') }}
                                            </span>
                                            @if($coupon->expires_at->isPast())
                                                <span class="badge badge-danger badge-pill ml-1">Đã hết hạn</span>
                                            @elseif($coupon->expires_at->diffInDays(now()) <= 7)
                                                <span class="badge badge-warning badge-pill ml-1">Sắp hết hạn</span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-muted"><i class="fas fa-infinity"></i> Không giới hạn</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="btn btn-info btn-sm" data-toggle="tooltip" title="Chỉnh sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.coupons.show', $coupon->id) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Chi tiết">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm delete-btn" data-toggle="tooltip" title="Xóa" data-id="{{ $coupon->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <form id="delete-form-{{ $coupon->id }}" action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">
                                    <div class="empty-state">
                                        <img src="https://cdn.dribbble.com/users/888330/screenshots/2653750/media/b7459526aeb0786638a3405407d326f8.png" alt="No coupons" width="200">
                                        <p class="mt-3">Không có mã giảm giá nào</p>
                                        <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus-circle mr-1"></i> Tạo mã giảm giá đầu tiên
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4 d-flex justify-content-center">
                {{ $coupons->links() }}
            </div>
        </div>
    </div>

    <!-- Modal xác nhận xóa -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xóa mã giảm giá này không? Hành động này không thể hoàn tác.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Xác nhận xóa</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    .coupons-container {
        animation-duration: 0.6s;
    }

    .small-box {
        position: relative;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .small-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
    }

    .small-box > .inner {
        padding: 20px 15px;
    }

    .small-box h3 {
        font-size: 38px;
        font-weight: 700;
        margin: 0;
        white-space: nowrap;
        color: #fff;
    }

    .small-box p {
        font-size: 14px;
        color: #fff;
        opacity: 0.8;
    }

    .small-box .icon {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 70px;
        color: rgba(255, 255, 255, 0.15);
        transition: all 0.3s ease;
    }

    .small-box:hover .icon {
        font-size: 80px;
    }

    .card {
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .card-outline {
        border-top: 3px solid;
    }

    .card-primary.card-outline {
        border-top-color: #007bff;
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #f8f9fa;
        padding: 15px 20px;
    }

    .card-body {
        padding: 20px;
    }

    .filters-section {
        padding: 10px 0;
    }

    .coupon-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .coupon-table th {
        background-color: #f8f9fa;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.5px;
        padding: 12px 15px;
        border-bottom: 2px solid #dee2e6;
    }

    .coupon-table td {
        padding: 12px 15px;
        vertical-align: middle;
    }

    .coupon-row {
        transition: all 0.3s ease;
    }

    .coupon-row:hover {
        background-color: #f8f9fa;
    }

    .coupon-code {
        font-weight: 700;
        font-family: 'Courier New', monospace;
        background-color: #f1f1f1;
        padding: 4px 8px;
        border-radius: 4px;
        border: 1px dashed #ccc;
        font-size: 14px;
        letter-spacing: 1px;
        color: #333;
        transition: all 0.3s ease;
    }

    .coupon-code:hover {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
        cursor: pointer;
    }

    .badge-pill {
        padding: 5px 10px;
        font-weight: 500;
        border-radius: 30px;
    }

    .value-display, .status-display, .expiry-display {
        display: flex;
        align-items: center;
    }

    .btn-group .btn {
        border-radius: 4px;
        margin-right: 2px;
    }

    .filter-btn {
        font-size: 13px;
        padding: 6px 12px;
        border-radius: 30px !important;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .filter-btn.active {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 40px 0;
    }

    .empty-state p {
        font-size: 16px;
        color: #6c757d;
        margin-bottom: 20px;
    }

    /* Animation classes */
    .coupon-row {
        animation-duration: 0.5s;
    }

    .coupon-row.fade-out {
        animation: fadeOut 0.5s forwards;
    }

    .coupon-row.hidden {
        display: none;
    }

    /* Toast notification */
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
    }

    .toast {
        min-width: 250px;
        background-color: white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 10px;
        display: flex;
        animation: slideInRight 0.3s forwards;
    }

    .toast.hide {
        animation: slideOutRight 0.3s forwards;
    }

    .toast-body {
        padding: 12px 15px;
        flex-grow: 1;
    }

    .toast-icon {
        width: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .toast-success .toast-icon {
        background-color: #28a745;
        color: white;
    }

    .toast-error .toast-icon {
        background-color: #dc3545;
        color: white;
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('js/admin/coupons.js') }}"></script>
@endpush 