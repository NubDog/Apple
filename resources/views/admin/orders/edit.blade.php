@extends('layouts.admin')

@section('title', 'Edit Order')

@section('content')
<div class="order-edit-container">
    <div class="card">
        <div class="card-title">
            Edit Order #{{ $order->id }}
            <div class="actions">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Orders
                </a>
                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-info">
                    <i class="bi bi-eye"></i> View Order
                </a>
            </div>
        </div>
        
        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        
        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" id="order-form">
            @csrf
            @method('PUT')
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="status">Order Status <span class="required">*</span></label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="new" {{ $order->status == 'new' ? 'selected' : '' }}>New</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                
                <div class="form-group col-md-6">
                    <label for="payment_method">Payment Method <span class="required">*</span></label>
                    <select name="payment_method" id="payment_method" class="form-control" required>
                        <option value="cod" {{ $order->payment_method == 'cod' ? 'selected' : '' }}>Cash on Delivery</option>
                        <option value="bank_transfer" {{ $order->payment_method == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                    </select>
                </div>
            </div>
            
            <h3 class="section-title">Customer Information</h3>
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="shipping_name">Name <span class="required">*</span></label>
                    <input type="text" name="shipping_name" id="shipping_name" class="form-control" value="{{ old('shipping_name', $order->shipping_name) }}" required>
                </div>
                
                <div class="form-group col-md-6">
                    <label for="shipping_email">Email <span class="required">*</span></label>
                    <input type="email" name="shipping_email" id="shipping_email" class="form-control" value="{{ old('shipping_email', $order->shipping_email) }}" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="shipping_phone">Phone <span class="required">*</span></label>
                    <input type="text" name="shipping_phone" id="shipping_phone" class="form-control" value="{{ old('shipping_phone', $order->shipping_phone) }}" required>
                </div>
                
                <div class="form-group col-md-6">
                    <label for="shipping_address">Address <span class="required">*</span></label>
                    <input type="text" name="shipping_address" id="shipping_address" class="form-control" value="{{ old('shipping_address', $order->shipping_address) }}" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="notes">Order Notes</label>
                <textarea name="notes" id="notes" rows="3" class="form-control">{{ old('notes', $order->notes) }}</textarea>
            </div>
            
            <h3 class="section-title">Order Items</h3>
            
            <div class="order-items">
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
                                        Edit Product
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
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Update Order
                </button>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-light">Cancel</a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    .order-edit-container {
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
    
    .btn-info {
        background-color: #17a2b8;
        color: white;
        border: 1px solid #17a2b8;
    }
    
    .btn-light {
        background-color: #f8f9fa;
        color: #212529;
        border: 1px solid #ddd;
    }
    
    .alert {
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    
    .alert-danger {
        background-color: rgba(220, 53, 69, 0.1);
        border: 1px solid rgba(220, 53, 69, 0.2);
        color: #dc3545;
    }
    
    .required {
        color: #dc3545;
    }
    
    .form-row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -15px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .col-md-6 {
        width: 50%;
        padding: 0 15px;
    }
    
    @media (max-width: 768px) {
        .col-md-6 {
            width: 100%;
        }
    }
    
    .form-control {
        display: block;
        width: 100%;
        padding: 10px 15px;
        font-size: 14px;
        border: 1px solid #eee;
        border-radius: 5px;
        background-color: #fff;
    }
    
    .form-control:focus {
        border-color: var(--primary);
        outline: none;
    }
    
    .section-title {
        margin: 30px 0 15px;
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
    
    .form-actions {
        margin-top: 30px;
        display: flex;
        align-items: center;
    }
    
    .form-actions .btn {
        margin-right: 10px;
    }
    
    .mb-0 {
        margin-bottom: 0;
    }
</style>
@endpush
@endsection 