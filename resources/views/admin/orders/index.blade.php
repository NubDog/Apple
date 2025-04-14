@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
<div class="orders-container">
    <div class="card">
        <div class="card-title">
            Orders Management
        </div>
        
        <div class="filters-container">
            <div class="row">
                <div class="col-md-4">
                    <div class="search-container">
                        <input type="text" id="search-orders" class="search-input" placeholder="Search orders...">
                        <i class="bi bi-search search-icon"></i>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="filters-right">
                        <div class="filter-item">
                            <label>Status:</label>
                            <select id="status-filter" class="filter-select">
                                <option value="">All Statuses</option>
                                <option value="new">New</option>
                                <option value="processing">Processing</option>
                                <option value="shipped">Shipped</option>
                                <option value="delivered">Delivered</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="filter-item">
                            <label>Sort:</label>
                            <select id="sort-filter" class="filter-select">
                                <option value="newest">Newest First</option>
                                <option value="oldest">Oldest First</option>
                                <option value="total_high">Amount (High to Low)</option>
                                <option value="total_low">Amount (Low to High)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="orders-stats">
            <div class="stat-item">
                <div class="stat-value">{{ $orders->total() }}</div>
                <div class="stat-label">Total Orders</div>
            </div>
            <div class="stat-item new-orders">
                <div class="stat-value">{{ $orders->where('status', 'new')->count() }}</div>
                <div class="stat-label">New Orders</div>
            </div>
            <div class="stat-item processing-orders">
                <div class="stat-value">{{ $orders->where('status', 'processing')->count() }}</div>
                <div class="stat-label">Processing</div>
            </div>
            <div class="stat-item delivered-orders">
                <div class="stat-value">{{ $orders->where('status', 'delivered')->count() }}</div>
                <div class="stat-label">Delivered</div>
            </div>
        </div>
        
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        
        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        
        <div class="table-responsive">
            <table class="table orders-table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>
                            <div class="order-number">#{{ $order->id }}</div>
                        </td>
                        <td>
                            <div class="customer-name">{{ $order->shipping_name }}</div>
                            <div class="customer-email">{{ $order->shipping_email }}</div>
                        </td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="order-total">${{ number_format($order->total, 2) }}</div>
                        </td>
                        <td>
                            <div class="status-badge {{ $order->status }}">
                                {{ ucfirst($order->status) }}
                            </div>
                        </td>
                        <td>
                            <div class="payment-method">
                                {{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Bank Transfer' }}
                            </div>
                        </td>
                        <td>
                            <div class="actions-container">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn-action view" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn-action edit" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn-action status" title="Change Status" onclick="openStatusModal({{ $order->id }}, '{{ $order->status }}')">
                                    <i class="bi bi-arrow-repeat"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="pagination-container">
            {{ $orders->links() }}
        </div>
    </div>
</div>

<!-- Status Change Modal -->
<div class="modal" id="statusModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Order Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeStatusModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="status-form" action="" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status-select" class="form-control">
                            <option value="new">New</option>
                            <option value="processing">Processing</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeStatusModal()">Close</button>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .orders-container {
        width: 100%;
    }
    
    .filters-container {
        margin: 20px 0;
    }
    
    .search-container {
        position: relative;
    }
    
    .search-input {
        width: 100%;
        padding: 10px 15px 10px 40px;
        border: 1px solid #eee;
        border-radius: 5px;
        font-size: 14px;
    }
    
    .search-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #666;
    }
    
    .filters-right {
        display: flex;
        justify-content: flex-end;
    }
    
    .filter-item {
        margin-left: 15px;
        display: flex;
        align-items: center;
    }
    
    .filter-item label {
        margin-right: 5px;
        font-weight: 500;
    }
    
    .filter-select {
        padding: 8px 15px;
        border: 1px solid #eee;
        border-radius: 5px;
        font-size: 14px;
    }
    
    .orders-stats {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }
    
    .stat-item {
        flex: 1;
        min-width: 150px;
        text-align: center;
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 5px;
        margin-right: 10px;
        margin-bottom: 10px;
    }
    
    .stat-item:last-child {
        margin-right: 0;
    }
    
    .stat-value {
        font-size: 24px;
        font-weight: 600;
        color: var(--primary);
    }
    
    .stat-label {
        font-size: 14px;
        color: #666;
        margin-top: 5px;
    }
    
    .new-orders .stat-value {
        color: #dc3545;
    }
    
    .processing-orders .stat-value {
        color: #ffc107;
    }
    
    .delivered-orders .stat-value {
        color: #28a745;
    }
    
    .alert {
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    
    .alert-success {
        background-color: rgba(40, 167, 69, 0.1);
        border: 1px solid rgba(40, 167, 69, 0.2);
        color: #28a745;
    }
    
    .alert-danger {
        background-color: rgba(220, 53, 69, 0.1);
        border: 1px solid rgba(220, 53, 69, 0.2);
        color: #dc3545;
    }
    
    .table-responsive {
        overflow-x: auto;
    }
    
    .orders-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .orders-table th {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #eee;
        font-weight: 600;
    }
    
    .orders-table td {
        padding: 15px;
        border-bottom: 1px solid #eee;
        vertical-align: middle;
    }
    
    .order-number {
        font-weight: 500;
    }
    
    .customer-name {
        font-weight: 500;
        margin-bottom: 5px;
    }
    
    .customer-email {
        font-size: 12px;
        color: #999;
    }
    
    .order-total {
        font-weight: 500;
        color: var(--primary);
    }
    
    .status-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .status-badge.new {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }
    
    .status-badge.processing {
        background-color: rgba(255, 193, 7, 0.1);
        color: #ffc107;
    }
    
    .status-badge.shipped {
        background-color: rgba(23, 162, 184, 0.1);
        color: #17a2b8;
    }
    
    .status-badge.delivered {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }
    
    .status-badge.cancelled {
        background-color: rgba(108, 117, 125, 0.1);
        color: #6c757d;
    }
    
    .payment-method {
        font-size: 13px;
    }
    
    .actions-container {
        display: flex;
        align-items: center;
    }
    
    .btn-action {
        width: 30px;
        height: 30px;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 5px;
        border: none;
        cursor: pointer;
        color: white;
    }
    
    .btn-action:last-child {
        margin-right: 0;
    }
    
    .btn-action.view {
        background-color: #17a2b8;
    }
    
    .btn-action.edit {
        background-color: #7262fd;
    }
    
    .btn-action.status {
        background-color: #ffc107;
    }
    
    .pagination-container {
        margin-top: 20px;
    }
    
    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
    }
    
    .modal.show {
        display: block;
    }
    
    .modal-dialog {
        margin: 100px auto;
        max-width: 500px;
    }
    
    .modal-content {
        background-color: #fff;
        border-radius: 5px;
        overflow: hidden;
    }
    
    .modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px 20px;
        border-bottom: 1px solid #eee;
    }
    
    .modal-title {
        font-weight: 600;
        margin: 0;
    }
    
    .modal-body {
        padding: 20px;
    }
    
    .modal-footer {
        padding: 15px 20px;
        border-top: 1px solid #eee;
        display: flex;
        justify-content: flex-end;
    }
    
    .form-group {
        margin-bottom: 15px;
    }
    
    .form-control {
        display: block;
        width: 100%;
        padding: 10px 15px;
        font-size: 14px;
        border: 1px solid #eee;
        border-radius: 5px;
    }
    
    .btn {
        padding: 8px 15px;
        border-radius: 5px;
        font-size: 14px;
        cursor: pointer;
        border: none;
    }
    
    .btn-primary {
        background-color: var(--primary);
        color: white;
    }
    
    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }
    
    @media (max-width: 768px) {
        .filters-right {
            justify-content: flex-start;
            margin-top: 15px;
        }
        
        .filter-item {
            margin-left: 0;
            margin-right: 15px;
        }
        
        .stat-item {
            min-width: calc(50% - 10px);
        }
    }
    
    @media (max-width: 576px) {
        .stat-item {
            min-width: 100%;
            margin-right: 0;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Status change modal functions
    function openStatusModal(orderId, currentStatus) {
        document.getElementById('status-form').action = `/admin/orders/${orderId}/status`;
        document.getElementById('status-select').value = currentStatus;
        document.getElementById('statusModal').classList.add('show');
    }
    
    function closeStatusModal() {
        document.getElementById('statusModal').classList.remove('show');
    }
    
    $(document).ready(function() {
        // Search functionality
        $('#search-orders').on('keyup', function() {
            const searchTerm = $(this).val().toLowerCase();
            
            $('.orders-table tbody tr').each(function() {
                const orderNumber = $(this).find('.order-number').text().toLowerCase();
                const customerName = $(this).find('.customer-name').text().toLowerCase();
                const customerEmail = $(this).find('.customer-email').text().toLowerCase();
                
                if (orderNumber.includes(searchTerm) || 
                    customerName.includes(searchTerm) || 
                    customerEmail.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
        
        // Status filter
        $('#status-filter').on('change', function() {
            const status = $(this).val().toLowerCase();
            
            if (status === '') {
                $('.orders-table tbody tr').show();
                return;
            }
            
            $('.orders-table tbody tr').each(function() {
                const orderStatus = $(this).find('.status-badge').text().trim().toLowerCase();
                
                if (orderStatus === status) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
        
        // Sort filter
        $('#sort-filter').on('change', function() {
            const sortBy = $(this).val();
            let rows = $('.orders-table tbody tr').get();
            
            rows.sort(function(a, b) {
                let A, B;
                
                switch (sortBy) {
                    case 'newest':
                        A = new Date($(a).find('td:nth-child(3)').text());
                        B = new Date($(b).find('td:nth-child(3)').text());
                        return B - A;
                    
                    case 'oldest':
                        A = new Date($(a).find('td:nth-child(3)').text());
                        B = new Date($(b).find('td:nth-child(3)').text());
                        return A - B;
                    
                    case 'total_high':
                        A = parseFloat($(a).find('.order-total').text().replace('$', '').replace(',', ''));
                        B = parseFloat($(b).find('.order-total').text().replace('$', '').replace(',', ''));
                        return B - A;
                    
                    case 'total_low':
                        A = parseFloat($(a).find('.order-total').text().replace('$', '').replace(',', ''));
                        B = parseFloat($(b).find('.order-total').text().replace('$', '').replace(',', ''));
                        return A - B;
                    
                    default:
                        return 0;
                }
            });
            
            $.each(rows, function(index, row) {
                $('.orders-table tbody').append(row);
            });
        });
    });
</script>
@endpush
@endsection 