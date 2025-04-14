@extends('layouts.admin')

@section('title', ucfirst($status) . ' Orders')

@section('content')
<div class="orders-container">
    <div class="card">
        <div class="card-title">
            {{ ucfirst($status) }} Orders
            <div class="actions">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> All Orders
                </a>
            </div>
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
                                <option value="new" {{ $status == 'new' ? 'selected' : '' }}>New</option>
                                <option value="processing" {{ $status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
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
        
        <div class="status-info-banner {{ $status }}">
            <div class="status-icon">
                @if($status == 'new')
                <i class="bi bi-bell"></i>
                @elseif($status == 'processing')
                <i class="bi bi-gear"></i>
                @elseif($status == 'shipped')
                <i class="bi bi-truck"></i>
                @elseif($status == 'delivered')
                <i class="bi bi-check-circle"></i>
                @elseif($status == 'cancelled')
                <i class="bi bi-x-circle"></i>
                @endif
            </div>
            <div class="status-info">
                <h3>{{ ucfirst($status) }} Orders</h3>
                <p>
                    @if($status == 'new')
                    These orders are newly placed and waiting to be processed.
                    @elseif($status == 'processing')
                    These orders are currently being processed and prepared for shipping.
                    @elseif($status == 'shipped')
                    These orders have been shipped and are on their way to customers.
                    @elseif($status == 'delivered')
                    These orders have been successfully delivered to customers.
                    @elseif($status == 'cancelled')
                    These orders have been cancelled and will not be processed.
                    @endif
                </p>
            </div>
            <div class="status-count">
                <div class="count">{{ $orders->total() }}</div>
                <div class="count-label">Orders</div>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table orders-table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Total</th>
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
        
        @if($orders->count() == 0)
        <div class="no-records">
            <div class="no-records-icon">
                <i class="bi bi-inbox"></i>
            </div>
            <h3>No {{ ucfirst($status) }} Orders</h3>
            <p>There are currently no orders with the {{ $status }} status.</p>
        </div>
        @endif
        
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
    
    .actions {
        display: flex;
        gap: 10px;
    }
    
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 15px;
        border-radius: 5px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
    }
    
    .btn i {
        margin-right: 5px;
    }
    
    .btn-primary {
        background-color: var(--primary);
        color: white;
        border: 1px solid var(--primary);
    }
    
    .btn-secondary {
        background-color: #6c757d;
        color: white;
        border: 1px solid #6c757d;
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
    
    .status-info-banner {
        display: flex;
        align-items: center;
        padding: 20px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    
    .status-info-banner.new {
        background-color: rgba(220, 53, 69, 0.1);
    }
    
    .status-info-banner.processing {
        background-color: rgba(255, 193, 7, 0.1);
    }
    
    .status-info-banner.shipped {
        background-color: rgba(23, 162, 184, 0.1);
    }
    
    .status-info-banner.delivered {
        background-color: rgba(40, 167, 69, 0.1);
    }
    
    .status-info-banner.cancelled {
        background-color: rgba(108, 117, 125, 0.1);
    }
    
    .status-icon {
        font-size: 32px;
        margin-right: 20px;
    }
    
    .status-info-banner.new .status-icon {
        color: #dc3545;
    }
    
    .status-info-banner.processing .status-icon {
        color: #ffc107;
    }
    
    .status-info-banner.shipped .status-icon {
        color: #17a2b8;
    }
    
    .status-info-banner.delivered .status-icon {
        color: #28a745;
    }
    
    .status-info-banner.cancelled .status-icon {
        color: #6c757d;
    }
    
    .status-info {
        flex: 1;
    }
    
    .status-info h3 {
        margin: 0 0 5px;
        font-size: 18px;
        font-weight: 600;
    }
    
    .status-info p {
        margin: 0;
        font-size: 14px;
        color: #666;
    }
    
    .status-count {
        text-align: center;
        margin-left: 20px;
    }
    
    .count {
        font-size: 24px;
        font-weight: 600;
    }
    
    .status-info-banner.new .count {
        color: #dc3545;
    }
    
    .status-info-banner.processing .count {
        color: #ffc107;
    }
    
    .status-info-banner.shipped .count {
        color: #17a2b8;
    }
    
    .status-info-banner.delivered .count {
        color: #28a745;
    }
    
    .status-info-banner.cancelled .count {
        color: #6c757d;
    }
    
    .count-label {
        font-size: 14px;
        color: #666;
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
    
    .no-records {
        text-align: center;
        padding: 50px 20px;
    }
    
    .no-records-icon {
        font-size: 40px;
        color: #ddd;
        margin-bottom: 15px;
    }
    
    .no-records h3 {
        margin: 0 0 10px;
        font-size: 18px;
        font-weight: 600;
    }
    
    .no-records p {
        margin: 0;
        color: #666;
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
    
    @media (max-width: 768px) {
        .filters-right {
            justify-content: flex-start;
            margin-top: 15px;
        }
        
        .filter-item {
            margin-left: 0;
            margin-right: 15px;
        }
        
        .status-info-banner {
            flex-direction: column;
            text-align: center;
        }
        
        .status-icon {
            margin-right: 0;
            margin-bottom: 15px;
        }
        
        .status-count {
            margin-left: 0;
            margin-top: 15px;
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
        // Status filter change
        $('#status-filter').on('change', function() {
            const status = $(this).val();
            if (status === '') {
                window.location.href = "{{ route('admin.orders.index') }}";
            } else {
                window.location.href = "{{ url('admin/orders/status') }}/" + status;
            }
        });
        
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