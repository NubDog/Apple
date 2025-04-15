@extends('layouts.admin')

@section('title', 'Create New Order')

@section('content')
<div class="create-order-container">
    <div class="card">
        <div class="card-title">
            Create New Order
            <div class="actions">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Orders
                </a>
            </div>
        </div>
        
        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        
        <form action="{{ route('admin.orders.store') }}" method="POST" id="create-order-form">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-section">
                        <h3 class="section-title">Customer Information</h3>
                        
                        <div class="form-group">
                            <label for="user_id">Select Customer <span class="required">*</span></label>
                            <select name="user_id" id="user_id" class="form-control" required>
                                <option value="">-- Select Customer --</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="shipping_name">Shipping Name <span class="required">*</span></label>
                            <input type="text" name="shipping_name" id="shipping_name" class="form-control" value="{{ old('shipping_name') }}" required>
                            @error('shipping_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="shipping_email">Shipping Email <span class="required">*</span></label>
                            <input type="email" name="shipping_email" id="shipping_email" class="form-control" value="{{ old('shipping_email') }}" required>
                            @error('shipping_email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="shipping_phone">Shipping Phone <span class="required">*</span></label>
                            <input type="text" name="shipping_phone" id="shipping_phone" class="form-control" value="{{ old('shipping_phone') }}" required>
                            @error('shipping_phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="shipping_address">Shipping Address <span class="required">*</span></label>
                            <textarea name="shipping_address" id="shipping_address" class="form-control" rows="3" required>{{ old('shipping_address') }}</textarea>
                            @error('shipping_address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-section">
                        <h3 class="section-title">Order Information</h3>
                        
                        <div class="form-group">
                            <label for="status">Order Status <span class="required">*</span></label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="new" {{ old('status') == 'new' ? 'selected' : '' }}>New</option>
                                <option value="processing" {{ old('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ old('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ old('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="payment_method">Payment Method <span class="required">*</span></label>
                            <select name="payment_method" id="payment_method" class="form-control" required>
                                <option value="cod" {{ old('payment_method') == 'cod' ? 'selected' : '' }}>Cash on Delivery</option>
                                <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            </select>
                            @error('payment_method')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="shipping_cost">Shipping Cost</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="number" name="shipping_cost" id="shipping_cost" class="form-control" value="{{ old('shipping_cost', 0) }}" min="0" step="0.01">
                            </div>
                            @error('shipping_cost')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="discount">Discount</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="number" name="discount" id="discount" class="form-control" value="{{ old('discount', 0) }}" min="0" step="0.01">
                            </div>
                            @error('discount')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="notes">Order Notes</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-section mt-4">
                <h3 class="section-title">Order Items</h3>
                
                <div class="table-responsive">
                    <table class="table" id="order-items-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th width="120">Quantity</th>
                                <th width="120">Price</th>
                                <th width="120">Total</th>
                                <th width="50">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="item-row" id="item-row-1">
                                <td>
                                    <select name="products[0][id]" class="form-control product-select" required>
                                        <option value="">-- Select Product --</option>
                                        @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->on_sale && $product->sale_price ? $product->sale_price : $product->price }}">
                                            {{ $product->name }} (Stock: {{ $product->quantity }})
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="products[0][quantity]" class="form-control item-quantity" min="1" value="1" required>
                                </td>
                                <td class="item-price">$0.00</td>
                                <td class="item-total">$0.00</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-danger remove-item" disabled>
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5">
                                    <button type="button" class="btn btn-sm btn-secondary" id="add-item">
                                        <i class="bi bi-plus-circle"></i> Add Product
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right">Subtotal:</td>
                                <td colspan="2" id="subtotal">$0.00</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right">Shipping:</td>
                                <td colspan="2" id="shipping-display">$0.00</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right">Discount:</td>
                                <td colspan="2" id="discount-display">$0.00</td>
                            </tr>
                            <tr class="total-row">
                                <td colspan="3" class="text-right">Total:</td>
                                <td colspan="2" id="total">$0.00</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                @error('products')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Create Order
                </button>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    .create-order-container {
        width: 100%;
    }
    
    .actions {
        display: flex;
        gap: 10px;
    }
    
    .form-section {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    
    .section-title {
        margin-top: 0;
        margin-bottom: 15px;
        font-size: 18px;
        font-weight: 600;
    }
    
    .form-group {
        margin-bottom: 15px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
    }
    
    .form-control {
        display: block;
        width: 100%;
        padding: 10px 15px;
        font-size: 14px;
        border: 1px solid #eee;
        border-radius: 5px;
    }
    
    .required {
        color: #dc3545;
    }
    
    .text-danger {
        color: #dc3545;
        font-size: 12px;
        margin-top: 5px;
    }
    
    .table {
        width: 100%;
        margin-bottom: 20px;
        border-collapse: collapse;
    }
    
    .table th {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #eee;
        font-weight: 600;
    }
    
    .table td {
        padding: 15px;
        border-bottom: 1px solid #eee;
        vertical-align: middle;
    }
    
    .table tfoot td {
        padding: 10px 15px;
    }
    
    .table tfoot .total-row {
        font-weight: 600;
        font-size: 16px;
    }
    
    .text-right {
        text-align: right;
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
        border: none;
    }
    
    .btn i {
        margin-right: 5px;
    }
    
    .btn-sm {
        padding: 5px 10px;
        font-size: 12px;
    }
    
    .btn-primary {
        background-color: var(--primary);
        color: white;
    }
    
    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }
    
    .btn-danger {
        background-color: #dc3545;
        color: white;
    }
    
    .form-actions {
        margin-top: 30px;
        display: flex;
        gap: 10px;
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
    
    .input-group {
        display: flex;
    }
    
    .input-group-prepend {
        display: flex;
    }
    
    .input-group-text {
        display: flex;
        align-items: center;
        padding: 10px 15px;
        font-size: 14px;
        font-weight: 400;
        color: #495057;
        text-align: center;
        white-space: nowrap;
        background-color: #e9ecef;
        border: 1px solid #eee;
        border-radius: 5px 0 0 5px;
    }
    
    .input-group .form-control {
        border-radius: 0 5px 5px 0;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let rowCount = 1;
        const itemsTable = document.getElementById('order-items-table');
        const addItemButton = document.getElementById('add-item');
        const subtotalDisplay = document.getElementById('subtotal');
        const shippingDisplay = document.getElementById('shipping-display');
        const discountDisplay = document.getElementById('discount-display');
        const totalDisplay = document.getElementById('total');
        
        // Fill shipping details from selected user
        document.getElementById('user_id').addEventListener('change', function() {
            const userId = this.value;
            if (!userId) return;
            
            // Send AJAX request to get user details
            fetch(`/admin/users/${userId}/details`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('shipping_name').value = data.name;
                    document.getElementById('shipping_email').value = data.email;
                    document.getElementById('shipping_phone').value = data.phone || '';
                    document.getElementById('shipping_address').value = data.address || '';
                })
                .catch(error => {
                    console.error('Error fetching user details:', error);
                });
        });
        
        // Add new item row
        addItemButton.addEventListener('click', function() {
            rowCount++;
            const newRow = document.createElement('tr');
            newRow.className = 'item-row';
            newRow.id = `item-row-${rowCount}`;
            
            newRow.innerHTML = `
                <td>
                    <select name="products[${rowCount-1}][id]" class="form-control product-select" required>
                        <option value="">-- Select Product --</option>
                        @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->on_sale && $product->sale_price ? $product->sale_price : $product->price }}">
                            {{ $product->name }} (Stock: {{ $product->quantity }})
                        </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" name="products[${rowCount-1}][quantity]" class="form-control item-quantity" min="1" value="1" required>
                </td>
                <td class="item-price">$0.00</td>
                <td class="item-total">$0.00</td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger remove-item">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            `;
            
            itemsTable.querySelector('tbody').appendChild(newRow);
            
            // Enable remove button for the first row if we have more than one row
            if (rowCount === 2) {
                document.querySelector('#item-row-1 .remove-item').removeAttribute('disabled');
            }
            
            // Add event listeners to the new row
            attachRowEventListeners(newRow);
            
            // Recalculate totals
            calculateTotals();
        });
        
        // Attach event listeners to initial row
        attachRowEventListeners(document.getElementById('item-row-1'));
        
        // Handle shipping cost and discount changes
        document.getElementById('shipping_cost').addEventListener('input', calculateTotals);
        document.getElementById('discount').addEventListener('input', calculateTotals);
        
        // Function to attach event listeners to a row
        function attachRowEventListeners(row) {
            const productSelect = row.querySelector('.product-select');
            const quantityInput = row.querySelector('.item-quantity');
            const removeButton = row.querySelector('.remove-item');
            
            // Product selection change
            productSelect.addEventListener('change', function() {
                updateRowPrices(row);
                calculateTotals();
            });
            
            // Quantity change
            quantityInput.addEventListener('input', function() {
                updateRowPrices(row);
                calculateTotals();
            });
            
            // Remove item
            removeButton.addEventListener('click', function() {
                if (document.querySelectorAll('.item-row').length > 1) {
                    row.remove();
                    
                    // If only one row left, disable its remove button
                    if (document.querySelectorAll('.item-row').length === 1) {
                        document.querySelector('.item-row .remove-item').setAttribute('disabled', 'disabled');
                    }
                    
                    // Recalculate totals
                    calculateTotals();
                    
                    // Reindex the remaining rows
                    reindexRows();
                }
            });
        }
        
        // Update item price and total in a row
        function updateRowPrices(row) {
            const productSelect = row.querySelector('.product-select');
            const quantityInput = row.querySelector('.item-quantity');
            const priceCell = row.querySelector('.item-price');
            const totalCell = row.querySelector('.item-total');
            
            if (productSelect.value) {
                const option = productSelect.options[productSelect.selectedIndex];
                const price = parseFloat(option.getAttribute('data-price'));
                const quantity = parseInt(quantityInput.value) || 0;
                
                priceCell.textContent = '$' + price.toFixed(2);
                totalCell.textContent = '$' + (price * quantity).toFixed(2);
            } else {
                priceCell.textContent = '$0.00';
                totalCell.textContent = '$0.00';
            }
        }
        
        // Calculate subtotal and total
        function calculateTotals() {
            let subtotal = 0;
            
            // Sum up all item totals
            document.querySelectorAll('.item-total').forEach(cell => {
                subtotal += parseFloat(cell.textContent.replace('$', '')) || 0;
            });
            
            // Get shipping cost and discount
            const shippingCost = parseFloat(document.getElementById('shipping_cost').value) || 0;
            const discount = parseFloat(document.getElementById('discount').value) || 0;
            
            // Calculate total
            const total = subtotal + shippingCost - discount;
            
            // Update displays
            subtotalDisplay.textContent = '$' + subtotal.toFixed(2);
            shippingDisplay.textContent = '$' + shippingCost.toFixed(2);
            discountDisplay.textContent = '$' + discount.toFixed(2);
            totalDisplay.textContent = '$' + total.toFixed(2);
        }
        
        // Reindex rows for proper form submission
        function reindexRows() {
            document.querySelectorAll('.item-row').forEach((row, index) => {
                row.querySelector('.product-select').name = `products[${index}][id]`;
                row.querySelector('.item-quantity').name = `products[${index}][quantity]`;
            });
        }
        
        // Initial calculation
        calculateTotals();
    });
</script>
@endpush
@endsection 