@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
<div class="order-details-container">
    <div class="card">
        <div class="card-title">
            Order #{{ $order->id }} Details
            <div class="actions">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Orders
                </a>
                <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-primary">
                    <i class="bi bi-pencil"></i> Edit Order
                </a>
            </div>
        </div>
        
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        
        <div class="order-status-bar">
            <div class="order-status-wrapper">
                <div class="order-status {{ $order->status }}">
                    <div class="status-badge">{{ ucfirst($order->status) }}</div>
                    <div class="status-date">{{ $order->updated_at->format('M d, Y H:i') }}</div>
                </div>
                
                <div class="status-actions">
                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="status-form">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="status-select">
                            <option value="new" {{ $order->status == 'new' ? 'selected' : '' }}>New</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary">Update Status</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="order-info-grid">
            <div class="order-info-section">
                <h3>Order Information</h3>
                <div class="info-row">
                    <div class="info-label">Order Date:</div>
                    <div class="info-value">{{ $order->created_at->format('M d, Y H:i') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Payment Method:</div>
                    <div class="info-value">{{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Bank Transfer' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Notes:</div>
                    <div class="info-value">{{ $order->notes ?? 'No notes' }}</div>
                </div>
            </div>
            
            <div class="order-info-section">
                <h3>Customer Information</h3>
                <div class="info-row">
                    <div class="info-label">Name:</div>
                    <div class="info-value">{{ $order->shipping_name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email:</div>
                    <div class="info-value">{{ $order->shipping_email }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Phone:</div>
                    <div class="info-value">{{ $order->shipping_phone }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Address:</div>
                    <div class="info-value">{{ $order->shipping_address }}</div>
                </div>
            </div>
        </div>
        
        <div class="order-items-section">
            <h3>Order Items</h3>
            <div class="table-responsive">
                <table class="table order-items-table">
                    <thead>
                        <tr>
                            <th width="80">Image</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                <div class="product-image">
                                @if($item->product && $item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product_name }}">
                                @elseif($item->product && $item->product->images)
                                    @php
                                        $images = json_decode($item->product->images, true);
                                        if(is_array($images) && count($images) > 0) {
                                            echo '<img src="'.asset('storage/'.$images[0]).'" alt="'.$item->product_name.'">';
                                        } else {
                                            echo '<div class="no-image">No Image</div>';
                                        }
                                    @endphp
                                @else
                                    <div class="no-image">No Image</div>
                                @endif
                                </div>
                            </td>
                            <td>
                                <div class="product-name">{{ $item->product_name }}</div>
                                @if($item->product)
                                <a href="{{ route('admin.products.edit', $item->product->id) }}" class="product-link">
                                    View Product
                                </a>
                                @endif
                            </td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-right">Subtotal:</td>
                            <td>${{ number_format($order->subtotal, 2) }}</td>
                        </tr>
                        @if($order->tax > 0)
                        <tr>
                            <td colspan="4" class="text-right">Tax:</td>
                            <td>${{ number_format($order->tax, 2) }}</td>
                        </tr>
                        @endif
                        @if($order->shipping_cost > 0)
                        <tr>
                            <td colspan="4" class="text-right">Shipping:</td>
                            <td>${{ number_format($order->shipping_cost, 2) }}</td>
                        </tr>
                        @endif
                        @if($order->discount > 0)
                        <tr>
                            <td colspan="4" class="text-right">Discount:</td>
                            <td>-${{ number_format($order->discount, 2) }}</td>
                        </tr>
                        @endif
                        <tr class="total-row">
                            <td colspan="4" class="text-right">Total:</td>
                            <td>${{ number_format($order->total, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .order-details-container {
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
    
    .btn-sm {
        padding: 5px 10px;
        font-size: 12px;
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
    
    .order-status-bar {
        margin: 20px 0;
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 5px;
    }
    
    .order-status-wrapper {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .order-status {
        display: flex;
        align-items: center;
    }
    
    .status-badge {
        display: inline-block;
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: 500;
        margin-right: 15px;
    }
    
    .order-status.new .status-badge {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }
    
    .order-status.processing .status-badge {
        background-color: rgba(255, 193, 7, 0.1);
        color: #ffc107;
    }
    
    .order-status.shipped .status-badge {
        background-color: rgba(23, 162, 184, 0.1);
        color: #17a2b8;
    }
    
    .order-status.delivered .status-badge {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }
    
    .order-status.cancelled .status-badge {
        background-color: rgba(108, 117, 125, 0.1);
        color: #6c757d;
    }
    
    .status-date {
        font-size: 14px;
        color: #6c757d;
    }
    
    .status-actions {
        display: flex;
        align-items: center;
    }
    
    .status-form {
        display: flex;
        align-items: center;
    }
    
    .status-select {
        padding: 8px 15px;
        border: 1px solid #eee;
        border-radius: 5px;
        font-size: 14px;
        margin-right: 10px;
    }
    
    .order-info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .order-info-section {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 5px;
    }
    
    .order-info-section h3 {
        margin-top: 0;
        margin-bottom: 15px;
        font-size: 18px;
        font-weight: 600;
    }
    
    .info-row {
        display: flex;
        margin-bottom: 10px;
    }
    
    .info-label {
        width: 120px;
        font-weight: 500;
    }
    
    .info-value {
        flex: 1;
    }
    
    .order-items-section {
        margin-top: 30px;
    }
    
    .order-items-section h3 {
        margin-bottom: 15px;
        font-size: 18px;
        font-weight: 600;
    }
    
    .table-responsive {
        overflow-x: auto;
    }
    
    .order-items-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .order-items-table th {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #eee;
        font-weight: 600;
    }
    
    .order-items-table td {
        padding: 15px;
        border-bottom: 1px solid #eee;
        vertical-align: middle;
    }
    
    .order-items-table tfoot td {
        padding: 10px 15px;
    }
    
    .order-items-table tfoot .total-row {
        font-weight: 600;
        font-size: 16px;
    }
    
    .text-right {
        text-align: right;
    }
    
    .product-image {
        width: 60px;
        height: 60px;
        border-radius: 5px;
        overflow: hidden;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .no-image {
        font-size: 12px;
        color: #999;
    }
    
    .product-name {
        font-weight: 500;
        margin-bottom: 5px;
    }
    
    .product-link {
        font-size: 13px;
        color: var(--primary);
        text-decoration: none;
    }
    
    @media (max-width: 768px) {
        .order-info-grid {
            grid-template-columns: 1fr;
        }
        
        .order-status-wrapper {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .status-actions {
            margin-top: 15px;
        }
    }
</style>
@endpush
@endsection 