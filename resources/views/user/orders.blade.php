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
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div>
                    <h2 class="page-title mb-0">Đơn hàng của tôi</h2>
                    <p class="text-muted mb-0">
                        <i class="far fa-clock me-1"></i> Quản lý và theo dõi đơn hàng
                    </p>
                </div>
            </div>
            
            <!-- Orders Card -->
            <div class="card orders-card shadow-lg mb-4 animate__animated animate__fadeInUp">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-list me-2"></i>Danh sách đơn hàng
                    </div>
                    <a href="{{ route('products.index') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus-circle me-1"></i> Mua sắm ngay
                    </a>
                </div>
                <div class="card-body p-0">
                    @if(count($orders) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-orders mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">#Mã</th>
                                        <th scope="col">Ngày đặt</th>
                                        <th scope="col">Tổng tiền</th>
                                        <th scope="col">Trạng thái</th>
                                        <th scope="col">Thanh toán</th>
                                        <th scope="col" class="text-end">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr class="order-row animate__animated animate__fadeIn" style="animation-delay: {{ $loop->index * 0.05 }}s">
                                            <td>
                                                <span class="order-id">#{{ $order->id }}</span>
                                            </td>
                                            <td>
                                                <div class="order-date">
                                                    <div class="date">{{ $order->created_at->format('d/m/Y') }}</div>
                                                    <div class="time text-muted">{{ $order->created_at->format('H:i') }}</div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="order-total">{{ number_format($order->total, 0, ',', '.') }}đ</span>
                                            </td>
                                            <td>
                                                @php
                                                    $statusClass = [
                                                        'Chờ xác nhận' => 'bg-warning',
                                                        'Đang xử lý' => 'bg-info',
                                                        'Đang vận chuyển' => 'bg-primary',
                                                        'Hoàn thành' => 'bg-success',
                                                        'Đã hủy' => 'bg-danger'
                                                    ][$order->status] ?? 'bg-secondary';
                                                @endphp
                                                <span class="order-status badge {{ $statusClass }}">
                                                    {{ $order->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="order-payment">{{ $order->payment_method }}</span>
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('user.orders.detail', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> Chi tiết
                                                </a>
                                                @if($order->status == 'Chờ xác nhận')
                                                    <button class="btn btn-sm btn-outline-danger ms-1 cancel-order-btn" data-bs-toggle="modal" data-bs-target="#cancelOrderModal" data-order-id="{{ $order->id }}">
                                                        <i class="fas fa-times-circle"></i> Hủy
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="pagination-container p-3">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="empty-orders text-center py-5">
                            <div class="empty-icon mb-3">
                                <i class="fas fa-shopping-basket fa-4x text-muted"></i>
                            </div>
                            <h3 class="empty-title">Chưa có đơn hàng nào</h3>
                            <p class="empty-description text-muted">Bạn chưa có đơn hàng nào. Hãy khám phá sản phẩm và đặt hàng ngay!</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-shopping-cart me-2"></i> Mua sắm ngay
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Order Stats -->
            <div class="row g-4 mb-4">
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card animate__animated animate__fadeInUp" style="animation-delay: 0.1s">
                        <div class="stat-card-body">
                            <div class="stat-card-icon pending">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="stat-card-info">
                                <div class="stat-card-value">{{ $orders->where('status', 'Chờ xác nhận')->count() }}</div>
                                <div class="stat-card-title">Chờ xác nhận</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card animate__animated animate__fadeInUp" style="animation-delay: 0.2s">
                        <div class="stat-card-body">
                            <div class="stat-card-icon processing">
                                <i class="fas fa-cogs"></i>
                            </div>
                            <div class="stat-card-info">
                                <div class="stat-card-value">{{ $orders->where('status', 'Đang xử lý')->count() }}</div>
                                <div class="stat-card-title">Đang xử lý</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card animate__animated animate__fadeInUp" style="animation-delay: 0.3s">
                        <div class="stat-card-body">
                            <div class="stat-card-icon shipping">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div class="stat-card-info">
                                <div class="stat-card-value">{{ $orders->where('status', 'Đang vận chuyển')->count() }}</div>
                                <div class="stat-card-title">Đang vận chuyển</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card animate__animated animate__fadeInUp" style="animation-delay: 0.4s">
                        <div class="stat-card-body">
                            <div class="stat-card-icon completed">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-card-info">
                                <div class="stat-card-value">{{ $orders->where('status', 'Hoàn thành')->count() }}</div>
                                <div class="stat-card-title">Hoàn thành</div>
                            </div>
                        </div>
                    </div>
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

<!-- Cancel Order Modal -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xác nhận hủy đơn hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn hủy đơn hàng này không?</p>
                <p class="text-danger"><i class="fas fa-exclamation-triangle me-2"></i> Lưu ý: Hành động này không thể hoàn tác.</p>
                
                <form action="{{ route('user.orders.cancel') }}" method="POST" id="cancelOrderForm">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="order_id" id="cancelOrderId">
                    
                    <div class="mb-3">
                        <label for="cancel_reason" class="form-label">Lý do hủy đơn</label>
                        <select class="form-select" id="cancel_reason" name="reason" required>
                            <option value="">-- Chọn lý do --</option>
                            <option value="Đổi ý không muốn mua nữa">Đổi ý không muốn mua nữa</option>
                            <option value="Muốn thay đổi sản phẩm">Muốn thay đổi sản phẩm</option>
                            <option value="Tìm thấy giá tốt hơn ở nơi khác">Tìm thấy giá tốt hơn ở nơi khác</option>
                            <option value="Thay đổi phương thức thanh toán">Thay đổi phương thức thanh toán</option>
                            <option value="Khác">Khác</option>
                        </select>
                    </div>
                    
                    <div class="mb-3" id="otherReasonContainer" style="display: none;">
                        <label for="other_reason" class="form-label">Lý do khác</label>
                        <textarea class="form-control" id="other_reason" name="other_reason" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-danger" onclick="document.getElementById('cancelOrderForm').submit()">
                    <i class="fas fa-times-circle me-1"></i> Hủy đơn hàng
                </button>
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
        --pending: #ffb703;
        --processing: #3a86ff;
        --shipping: #4895ef;
        --completed: #06d6a0;
        --canceled: #e63946;
        --gray-100: #f8f9fa;
        --gray-200: #e9ecef;
        --gray-300: #dee2e6;
        --gray-400: #ced4da;
        --gray-500: #adb5bd;
        --gray-600: #6c757d;
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
    
    /* Order Table */
    .table-orders {
        margin-bottom: 0;
    }
    
    .table-orders thead th {
        background-color: var(--gray-100);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 1rem 1.5rem;
        border: none;
    }
    
    .table-orders tbody td {
        padding: 1rem 1.5rem;
        vertical-align: middle;
        border-color: var(--gray-100);
    }
    
    .order-row {
        transition: all 0.2s ease;
    }
    
    .order-row:hover {
        background-color: rgba(var(--primary-rgb), 0.05);
        transform: translateX(5px);
    }
    
    .order-id {
        font-weight: 700;
        color: var(--primary);
    }
    
    .order-date {
        line-height: 1.2;
    }
    
    .order-date .date {
        font-weight: 600;
    }
    
    .order-date .time {
        font-size: 0.8rem;
    }
    
    .order-total {
        font-weight: 700;
        color: var(--dark);
    }
    
    .order-status {
        padding: 0.5rem 0.75rem;
        border-radius: 50px;
        font-weight: 500;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .pagination-container {
        display: flex;
        justify-content: center;
        border-top: 1px solid var(--gray-100);
    }
    
    /* Empty state */
    .empty-orders {
        padding: 3rem 1rem;
    }
    
    .empty-icon {
        color: var(--gray-300);
        animation: float 3s ease-in-out infinite;
    }
    
    .empty-title {
        margin-bottom: 0.5rem;
        font-weight: 600;
    }
    
    .empty-description {
        max-width: 450px;
        margin: 0 auto;
    }
    
    @keyframes float {
        0% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
        100% {
            transform: translateY(0);
        }
    }
    
    /* Stat Cards */
    .stat-card {
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        height: 100%;
        background-color: white;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    .stat-card-body {
        padding: 1.25rem;
        display: flex;
        align-items: center;
    }
    
    .stat-card-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        margin-right: 1rem;
        flex-shrink: 0;
    }
    
    .stat-card-icon.pending {
        background: linear-gradient(45deg, #ffb703, #fd9e02);
    }
    
    .stat-card-icon.processing {
        background: linear-gradient(45deg, #3a86ff, #4361ee);
    }
    
    .stat-card-icon.shipping {
        background: linear-gradient(45deg, #4895ef, #4cc9f0);
    }
    
    .stat-card-icon.completed {
        background: linear-gradient(45deg, #06d6a0, #06b89c);
    }
    
    .stat-card-info {
        display: flex;
        flex-direction: column;
    }
    
    .stat-card-value {
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 0.25rem;
    }
    
    .stat-card-title {
        font-size: 0.875rem;
        color: var(--gray-600);
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
    
    /* Buttons */
    .btn-primary {
        background: linear-gradient(45deg, var(--primary), var(--info));
        border: none;
        box-shadow: 0 5px 15px rgba(72, 149, 239, 0.2);
    }
    
    .btn-primary:hover {
        background: linear-gradient(45deg, var(--info), var(--primary));
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(72, 149, 239, 0.3);
    }
    
    .btn-outline-primary {
        border-color: var(--primary);
        color: var(--primary);
    }
    
    .btn-outline-primary:hover {
        background-color: var(--primary);
        color: white;
        transform: translateY(-2px);
    }
    
    .btn-outline-danger {
        border-color: var(--danger);
        color: var(--danger);
    }
    
    .btn-outline-danger:hover {
        background-color: var(--danger);
        color: white;
        transform: translateY(-2px);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .table-responsive {
            border-radius: var(--border-radius);
        }
        
        .order-status {
            white-space: nowrap;
        }
    }
    
    @media (max-width: 576px) {
        .stat-card-body {
            flex-direction: column;
            text-align: center;
        }
        
        .stat-card-icon {
            margin-right: 0;
            margin-bottom: 0.75rem;
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
        // Handle order cancellation
        const cancelOrderButtons = document.querySelectorAll('.cancel-order-btn');
        const cancelOrderIdInput = document.getElementById('cancelOrderId');
        const cancelReasonSelect = document.getElementById('cancel_reason');
        const otherReasonContainer = document.getElementById('otherReasonContainer');
        
        cancelOrderButtons.forEach(button => {
            button.addEventListener('click', function() {
                const orderId = this.getAttribute('data-order-id');
                cancelOrderIdInput.value = orderId;
            });
        });
        
        cancelReasonSelect.addEventListener('change', function() {
            if (this.value === 'Khác') {
                otherReasonContainer.style.display = 'block';
            } else {
                otherReasonContainer.style.display = 'none';
            }
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
        
        // Row hover animation
        const orderRows = document.querySelectorAll('.order-row');
        orderRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.classList.add('animate__pulse');
            });
            row.addEventListener('mouseleave', function() {
                this.classList.remove('animate__pulse');
            });
        });
    });
</script>
@endpush
@endsection