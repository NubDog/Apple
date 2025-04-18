@extends('layouts.admin')

@section('title', 'Coupons Management')

@section('content')
<div class="coupons-container">
    <div class="card">
        <div class="card-title">
            Coupons Management
            <div class="actions">
                <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add New Coupon
                </a>
            </div>
        </div>
        
        <div class="filters-container">
            <div class="row">
                <div class="col-md-4">
                    <div class="search-container">
                        <input type="text" id="search-coupons" class="search-input" placeholder="Search coupons...">
                        <i class="bi bi-search search-icon"></i>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="filters-right">
                        <div class="filter-item">
                            <label>Type:</label>
                            <select id="type-filter" class="filter-select">
                                <option value="">All Types</option>
                                <option value="fixed">Fixed Amount</option>
                                <option value="percent">Percentage</option>
                            </select>
                        </div>
                        <div class="filter-item">
                            <label>Status:</label>
                            <select id="status-filter" class="filter-select">
                                <option value="">All Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="filter-item">
                            <label>Sort:</label>
                            <select id="sort-filter" class="filter-select">
                                <option value="code_asc">Code (A-Z)</option>
                                <option value="code_desc">Code (Z-A)</option>
                                <option value="value_asc">Value (Low to High)</option>
                                <option value="value_desc">Value (High to Low)</option>
                                <option value="newest">Newest First</option>
                                <option value="oldest">Oldest First</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="coupons-stats">
            <div class="stat-item">
                <div class="stat-value">{{ $totalCoupons ?? 0 }}</div>
                <div class="stat-label">Total Coupons</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $activeCoupons ?? 0 }}</div>
                <div class="stat-label">Active Coupons</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $expiredCoupons ?? 0 }}</div>
                <div class="stat-label">Expired</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $percentCoupons ?? 0 }}</div>
                <div class="stat-label">Percentage Type</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $fixedCoupons ?? 0 }}</div>
                <div class="stat-label">Fixed Amount</div>
            </div>
        </div>
        
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        
        <div class="table-responsive">
            <table class="table coupons-table">
                <thead>
                    <tr>
                        <th width="50"><input type="checkbox" id="select-all"></th>
                        <th>Code</th>
                        <th>Type</th>
                        <th>Value</th>
                        <th>Min Order</th>
                        <th>Usage</th>
                        <th>Expiry</th>
                        <th>Status</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($coupons ?? [] as $coupon)
                    <tr class="coupon-row">
                        <td><input type="checkbox" class="coupon-checkbox"></td>
                        <td>
                            <div class="coupon-code">{{ $coupon->code }}</div>
                        </td>
                        <td>
                            @if($coupon->type == 'fixed')
                                <div class="type-badge fixed">Fixed Amount</div>
                            @else
                                <div class="type-badge percent">Percentage</div>
                            @endif
                        </td>
                        <td>
                            @if($coupon->type == 'fixed')
                                <div class="coupon-value">${{ number_format($coupon->value, 2) }}</div>
                            @else
                                <div class="coupon-value">{{ $coupon->value }}%</div>
                            @endif
                        </td>
                        <td>
                            @if($coupon->min_order_amount)
                                ${{ number_format($coupon->min_order_amount, 2) }}
                            @else
                                <span class="text-muted">None</span>
                            @endif
                        </td>
                        <td>
                            <div class="usage-info">
                                <div class="usage-count">{{ $coupon->used_times }} / {{ $coupon->max_uses ?: '∞' }}</div>
                                @if($coupon->max_uses)
                                    <div class="usage-bar">
                                        <div class="usage-progress" style="width: {{ min(100, ($coupon->used_times / $coupon->max_uses) * 100) }}%"></div>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td>
                            @if($coupon->expires_at)
                                <div class="expiry-date {{ now() > $coupon->expires_at ? 'expired' : '' }}">
                                    {{ $coupon->expires_at->format('M d, Y') }}
                                </div>
                                @if(now() > $coupon->expires_at)
                                    <div class="expiry-status">Expired</div>
                                @elseif(now()->diffInDays($coupon->expires_at) < 7)
                                    <div class="expiry-status expiring-soon">Expiring soon</div>
                                @endif
                            @else
                                <span class="text-muted">Never</span>
                            @endif
                        </td>
                        <td>
                            <label class="switch">
                                <input type="checkbox" {{ $coupon->is_active ? 'checked' : '' }} 
                                       onchange="updateStatus({{ $coupon->id }}, this.checked)">
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td>
                            <div class="actions-container">
                                <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="btn-action edit" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button class="btn-action delete" title="Delete" onclick="confirmDelete({{ $coupon->id }})">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <a href="#" class="btn-action clone" title="Clone" onclick="cloneCoupon({{ $coupon->id }})">
                                    <i class="bi bi-copy"></i>
                                </a>
                                
                                <form id="delete-form-{{ $coupon->id }}" action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="bi bi-ticket-perforated"></i>
                                </div>
                                <h3>No coupons found</h3>
                                <p>Create your first coupon by clicking the "Add New Coupon" button above.</p>
                                <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle"></i> Add New Coupon
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="pagination-container">
            {{ $coupons->links() ?? '' }}
        </div>
        
        <div class="bulk-actions">
            <div class="selected-count">0 selected</div>
            <div class="actions">
                <button class="btn-bulk" onclick="bulkActivate()">Activate</button>
                <button class="btn-bulk" onclick="bulkDeactivate()">Deactivate</button>
                <button class="btn-bulk" onclick="bulkDelete()">Delete</button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .coupons-container {
        width: 100%;
    }
    
    .btn-primary {
        background-color: var(--primary);
        color: white;
        border: none;
        border-radius: 20px;
        padding: 8px 20px;
        font-weight: 500;
        display: flex;
        align-items: center;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        background-color: #5a4dfd;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(114, 98, 253, 0.3);
    }
    
    .btn-primary i {
        margin-right: 5px;
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
        border: 1px solid #e1e1e1;
        border-radius: 30px;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    
    .search-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(114, 98, 253, 0.1);
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
        gap: 15px;
    }
    
    .filter-item {
        display: flex;
        align-items: center;
    }
    
    .filter-item label {
        margin-right: 8px;
        font-size: 14px;
        color: #666;
    }
    
    .filter-select {
        padding: 8px 12px;
        border: 1px solid #e1e1e1;
        border-radius: 20px;
        font-size: 14px;
        color: #333;
        background-color: white;
        cursor: pointer;
    }
    
    .coupons-stats {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 15px;
        margin-bottom: 25px;
    }
    
    .stat-item {
        background: linear-gradient(135deg, #ffffff 0%, #f5f7ff 100%);
        border-radius: 15px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .stat-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(114, 98, 253, 0.1);
    }
    
    .stat-value {
        font-size: 24px;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 5px;
    }
    
    .stat-label {
        font-size: 14px;
        color: #666;
    }
    
    .coupons-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 10px;
    }
    
    .coupons-table thead th {
        background-color: #f5f7ff;
        padding: 12px 15px;
        text-transform: uppercase;
        font-size: 12px;
        font-weight: 600;
        color: #666;
        border: none;
    }
    
    .coupons-table thead th:first-child {
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }
    
    .coupons-table thead th:last-child {
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
    }
    
    .coupon-row {
        background-color: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        transition: all 0.3s ease;
    }
    
    .coupon-row:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .coupon-row td {
        padding: 15px;
        border-top: none;
        vertical-align: middle;
    }
    
    .coupon-row td:first-child {
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }
    
    .coupon-row td:last-child {
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
    }
    
    .coupon-code {
        font-family: 'Courier New', monospace;
        font-weight: 600;
        font-size: 14px;
        color: #333;
        padding: 5px 10px;
        background-color: #f0f2f9;
        border-radius: 5px;
        display: inline-block;
        letter-spacing: 1px;
    }
    
    .type-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        display: inline-block;
    }
    
    .type-badge.fixed {
        background-color: #e1f5fe;
        color: #0288d1;
    }
    
    .type-badge.percent {
        background-color: #e8f5e9;
        color: #388e3c;
    }
    
    .coupon-value {
        font-weight: 600;
        font-size: 16px;
        color: #333;
    }
    
    .usage-info {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    
    .usage-count {
        font-size: 14px;
        font-weight: 500;
    }
    
    .usage-bar {
        width: 100%;
        height: 6px;
        background-color: #e1e1e1;
        border-radius: 3px;
        overflow: hidden;
    }
    
    .usage-progress {
        height: 100%;
        background: linear-gradient(90deg, #7262fd, #a594ff);
        border-radius: 3px;
        transition: width 0.5s ease;
    }
    
    .expiry-date {
        font-size: 14px;
    }
    
    .expiry-date.expired {
        color: #e53935;
    }
    
    .expiry-status {
        font-size: 12px;
        color: #e53935;
        margin-top: 3px;
    }
    
    .expiry-status.expiring-soon {
        color: #ff9800;
    }
    
    /* Toggle Switch */
    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
    }
    
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
    }
    
    .slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
    }
    
    input:checked + .slider {
        background-color: var(--primary);
    }
    
    input:focus + .slider {
        box-shadow: 0 0 1px var(--primary);
    }
    
    input:checked + .slider:before {
        transform: translateX(26px);
    }
    
    .slider.round {
        border-radius: 34px;
    }
    
    .slider.round:before {
        border-radius: 50%;
    }
    
    .actions-container {
        display: flex;
        gap: 8px;
    }
    
    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        cursor: pointer;
        border: none;
        transition: all 0.2s ease;
    }
    
    .btn-action:hover {
        transform: scale(1.1);
    }
    
    .btn-action.edit {
        background-color: #7262fd;
    }
    
    .btn-action.delete {
        background-color: #e53935;
    }
    
    .btn-action.clone {
        background-color: #00897b;
    }
    
    .empty-state {
        padding: 40px 20px;
        text-align: center;
    }
    
    .empty-state-icon {
        font-size: 64px;
        color: #e1e1e1;
        margin-bottom: 15px;
    }
    
    .empty-state h3 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
    }
    
    .empty-state p {
        font-size: 14px;
        color: #666;
        margin-bottom: 20px;
    }
    
    .pagination-container {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }
    
    .bulk-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
        padding: 10px 15px;
        background-color: #f5f7ff;
        border-radius: 10px;
        display: none;
    }
    
    .bulk-actions.visible {
        display: flex;
        animation: slideUp 0.3s ease;
    }
    
    .selected-count {
        font-weight: 500;
        color: #333;
    }
    
    .btn-bulk {
        padding: 8px 15px;
        border-radius: 20px;
        background-color: white;
        border: 1px solid #e1e1e1;
        color: #333;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        margin-left: 10px;
    }
    
    .btn-bulk:hover {
        background-color: var(--primary);
        color: white;
        border-color: var(--primary);
    }
    
    /* Animations */
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(114, 98, 253, 0.4);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(114, 98, 253, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(114, 98, 253, 0);
        }
    }
    
    .coupon-row.new-item {
        animation: pulse 2s infinite;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select all functionality
        const selectAllCheckbox = document.getElementById('select-all');
        const couponCheckboxes = document.querySelectorAll('.coupon-checkbox');
        const bulkActions = document.querySelector('.bulk-actions');
        const selectedCount = document.querySelector('.selected-count');
        
        selectAllCheckbox.addEventListener('change', function() {
            const isChecked = this.checked;
            
            couponCheckboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
            });
            
            updateBulkActions();
        });
        
        couponCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateBulkActions();
                
                // Check if all checkboxes are checked
                const allChecked = Array.from(couponCheckboxes).every(cb => cb.checked);
                selectAllCheckbox.checked = allChecked;
            });
        });
        
        function updateBulkActions() {
            const checkedCount = document.querySelectorAll('.coupon-checkbox:checked').length;
            
            if (checkedCount > 0) {
                bulkActions.classList.add('visible');
                selectedCount.textContent = checkedCount + ' selected';
            } else {
                bulkActions.classList.remove('visible');
            }
        }
        
        // Search functionality
        const searchInput = document.getElementById('search-coupons');
        
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const couponRows = document.querySelectorAll('.coupon-row');
            
            couponRows.forEach(row => {
                const code = row.querySelector('.coupon-code').textContent.toLowerCase();
                
                if (code.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
        
        // Add animation effects on hover for stats items
        const statItems = document.querySelectorAll('.stat-item');
        
        statItems.forEach(item => {
            item.addEventListener('mouseover', function() {
                this.style.background = 'linear-gradient(135deg, #f5f7ff 0%, #ffffff 100%)';
            });
            
            item.addEventListener('mouseout', function() {
                this.style.background = 'linear-gradient(135deg, #ffffff 0%, #f5f7ff 100%)';
            });
        });
    });
    
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this coupon?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
    
    function updateStatus(id, status) {
        // Send AJAX request to update status
        fetch(`/admin/coupons/${id}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ is_active: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show notification
                const notification = document.createElement('div');
                notification.className = 'notification';
                notification.textContent = data.message;
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.classList.add('show');
                }, 10);
                
                setTimeout(() => {
                    notification.classList.remove('show');
                    setTimeout(() => {
                        notification.remove();
                    }, 300);
                }, 3000);
            }
        });
    }
    
    function cloneCoupon(id) {
        if (confirm('Are you sure you want to clone this coupon?')) {
            fetch(`/admin/coupons/${id}/clone`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                }
            });
        }
    }
    
    function bulkActivate() {
        const selectedIds = getSelectedCouponIds();
        updateBulkStatus(selectedIds, true);
    }
    
    function bulkDeactivate() {
        const selectedIds = getSelectedCouponIds();
        updateBulkStatus(selectedIds, false);
    }
    
    function bulkDelete() {
        const selectedIds = getSelectedCouponIds();
        
        if (confirm(`Are you sure you want to delete ${selectedIds.length} coupon(s)?`)) {
            fetch('/admin/coupons/bulk-delete', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ ids: selectedIds })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                }
            });
        }
    }
    
    function updateBulkStatus(ids, status) {
        fetch('/admin/coupons/bulk-status', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ ids: ids, is_active: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            }
        });
    }
    
    function getSelectedCouponIds() {
        const checkboxes = document.querySelectorAll('.coupon-checkbox:checked');
        const ids = [];
        
        checkboxes.forEach(checkbox => {
            const row = checkbox.closest('tr');
            const id = row.querySelector('.btn-action.delete').getAttribute('onclick').match(/\d+/)[0];
            ids.push(parseInt(id));
        });
        
        return ids;
    }
</script>
@endpush
@endsection 