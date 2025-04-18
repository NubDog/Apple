@extends('layouts.admin')

@section('title', 'Edit Coupon')

@section('content')
<div class="coupons-container">
    <div class="card">
        <div class="card-title">
            Edit Coupon: {{ $coupon->code }}
            <div class="actions">
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-light">
                    <i class="bi bi-arrow-left"></i> Back to Coupons
                </a>
            </div>
        </div>
        
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        
        <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST" class="coupon-form">
            @csrf
            @method('PUT')
            
            <div class="form-container">
                <div class="form-section">
                    <h3 class="section-title">Basic Information</h3>
                    
                    <div class="form-group">
                        <label for="code">Coupon Code <span class="required">*</span></label>
                        <div class="input-group code-input-group">
                            <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $coupon->code) }}" required placeholder="e.g., SUMMER2023">
                            <button type="button" class="btn-generate" id="generateCode">
                                <i class="bi bi-shuffle"></i> Generate
                            </button>
                        </div>
                        <small class="form-text">Unique code for this coupon. Will be displayed to customers.</small>
                        @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="type">Discount Type <span class="required">*</span></label>
                        <div class="radio-group">
                            <label class="radio-container">
                                <input type="radio" name="type" value="fixed" {{ old('type', $coupon->type) == 'fixed' ? 'checked' : '' }}>
                                <span class="radio-custom"></span>
                                <span class="radio-label">Fixed Amount ($)</span>
                            </label>
                            <label class="radio-container">
                                <input type="radio" name="type" value="percent" {{ old('type', $coupon->type) == 'percent' ? 'checked' : '' }}>
                                <span class="radio-custom"></span>
                                <span class="radio-label">Percentage (%)</span>
                            </label>
                        </div>
                        @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="value">Discount Value <span class="required">*</span></label>
                        <div class="input-with-icon">
                            <input type="number" name="value" id="value" class="form-control @error('value') is-invalid @enderror" value="{{ old('value', $coupon->value) }}" step="0.01" min="0" required>
                            <span class="input-icon" id="valueIcon">{{ $coupon->type == 'fixed' ? '$' : '%' }}</span>
                        </div>
                        <small class="form-text" id="valueHelp">
                            {{ $coupon->type == 'fixed' ? 'Amount to deduct from the order total' : 'Percentage to deduct from the order total' }}
                        </small>
                        @error('value')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="min_order_amount">Minimum Order Amount</label>
                        <div class="input-with-icon">
                            <input type="number" name="min_order_amount" id="min_order_amount" class="form-control @error('min_order_amount') is-invalid @enderror" value="{{ old('min_order_amount', $coupon->min_order_amount) }}" step="0.01" min="0">
                            <span class="input-icon">$</span>
                        </div>
                        <small class="form-text">Minimum order amount required to use this coupon (leave empty for no minimum)</small>
                        @error('min_order_amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-section">
                    <h3 class="section-title">Usage Restrictions</h3>
                    
                    <div class="form-group">
                        <label for="max_uses">Maximum Uses</label>
                        <input type="number" name="max_uses" id="max_uses" class="form-control @error('max_uses') is-invalid @enderror" value="{{ old('max_uses', $coupon->max_uses) }}" min="0">
                        <small class="form-text">Maximum number of times this coupon can be used (leave empty for unlimited)</small>
                        <div class="usage-info">
                            <div class="used-count">Current usage: {{ $coupon->used_times }} {{ $coupon->max_uses ? 'of ' . $coupon->max_uses : '' }}</div>
                            @if($coupon->max_uses)
                                <div class="usage-bar">
                                    <div class="usage-progress" style="width: {{ min(100, ($coupon->used_times / $coupon->max_uses) * 100) }}%"></div>
                                </div>
                            @endif
                        </div>
                        @error('max_uses')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="expires_at">Expiry Date</label>
                        <input type="datetime-local" name="expires_at" id="expires_at" class="form-control @error('expires_at') is-invalid @enderror" value="{{ old('expires_at', $coupon->expires_at ? date('Y-m-d\TH:i', strtotime($coupon->expires_at)) : '') }}">
                        <small class="form-text">When this coupon expires (leave empty for never)</small>
                        @error('expires_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="custom-switch-label">Status</label>
                        <label class="switch">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $coupon->is_active) ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                        <span class="switch-text">{{ $coupon->is_active ? 'Active' : 'Inactive' }}</span>
                        <small class="form-text">Whether this coupon is active and can be used</small>
                    </div>
                    
                    <div class="form-group">
                        <div class="coupon-meta">
                            <div class="meta-item">
                                <i class="bi bi-calendar-check"></i>
                                <span>Created: {{ $coupon->created_at->format('M d, Y H:i') }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="bi bi-calendar-plus"></i>
                                <span>Last Updated: {{ $coupon->updated_at->format('M d, Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="preview-section">
                <h3 class="section-title">Preview</h3>
                <div class="coupon-preview">
                    <div class="coupon-card">
                        <div class="coupon-content">
                            <div class="discount">
                                <span class="discount-value" id="previewValue">
                                    {{ $coupon->type == 'fixed' ? '$'.number_format($coupon->value, 2) : $coupon->value.'%' }}
                                </span>
                                <span class="discount-label" id="previewType">OFF</span>
                            </div>
                            <div class="coupon-details">
                                <div class="coupon-code-display" id="previewCode">{{ $coupon->code }}</div>
                                <div class="coupon-expiry" id="previewExpiry">
                                    Valid until: {{ $coupon->expires_at ? $coupon->expires_at->format('M d, Y') : 'No Expiry' }}
                                </div>
                            </div>
                        </div>
                        <div class="coupon-scissors">
                            <div class="scissors-line">
                                <i class="bi bi-scissors"></i>
                                <span>- - - - - - - - - - - - - - -</span>
                            </div>
                        </div>
                        <div class="coupon-restrictions">
                            <div class="restriction-item" id="previewMinimum">
                                Minimum order: {{ $coupon->min_order_amount ? '$'.number_format($coupon->min_order_amount, 2) : 'None' }}
                            </div>
                            <div class="restriction-item" id="previewUsage">
                                Usage: {{ $coupon->max_uses ? 'Limited to '.$coupon->max_uses.' uses' : 'Unlimited' }}
                                {{ $coupon->used_times > 0 ? ' ('.$coupon->used_times.' used)' : '' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Update Coupon
                </button>
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-light">Cancel</a>
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                    <i class="bi bi-trash"></i> Delete Coupon
                </button>
            </div>
            
            <form id="delete-form" action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </form>
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
    
    .btn-light {
        background-color: #f5f7ff;
        color: #333;
        border: none;
        border-radius: 20px;
        padding: 8px 20px;
        font-weight: 500;
        display: flex;
        align-items: center;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .btn-light:hover {
        background-color: #e1e4f2;
    }
    
    .btn-light i {
        margin-right: 5px;
    }
    
    .btn-danger {
        background-color: #fff1f0;
        color: #e53935;
        border: 1px solid #e53935;
        border-radius: 20px;
        padding: 8px 20px;
        font-weight: 500;
        display: flex;
        align-items: center;
        margin-left: auto;
        transition: all 0.3s ease;
    }
    
    .btn-danger:hover {
        background-color: #e53935;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(229, 57, 53, 0.3);
    }
    
    .btn-danger i {
        margin-right: 5px;
    }
    
    .coupon-form {
        margin-top: 20px;
    }
    
    .form-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
    }
    
    .form-section {
        background: linear-gradient(135deg, #ffffff 0%, #f5f7ff 100%);
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
        transition: all 0.3s ease;
    }
    
    .form-section:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(114, 98, 253, 0.1);
    }
    
    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: #333;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid rgba(114, 98, 253, 0.2);
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #333;
    }
    
    .form-group .required {
        color: #e53935;
    }
    
    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e1e1e1;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(114, 98, 253, 0.1);
    }
    
    .input-with-icon {
        position: relative;
    }
    
    .input-with-icon .form-control {
        padding-right: 40px;
    }
    
    .input-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #666;
        font-weight: 500;
    }
    
    .code-input-group {
        display: flex;
    }
    
    .code-input-group .form-control {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        flex: 1;
    }
    
    .btn-generate {
        background-color: #7262fd;
        color: white;
        border: none;
        border-radius: 0 10px 10px 0;
        padding: 0 15px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
    }
    
    .btn-generate:hover {
        background-color: #5a4dfd;
    }
    
    .btn-generate i {
        margin-right: 5px;
    }
    
    .form-text {
        display: block;
        margin-top: 5px;
        font-size: 12px;
        color: #666;
    }
    
    .invalid-feedback {
        display: block;
        margin-top: 5px;
        font-size: 12px;
        color: #e53935;
    }
    
    /* Usage info */
    .usage-info {
        margin-top: 10px;
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 10px;
    }
    
    .used-count {
        font-size: 13px;
        font-weight: 500;
        color: #666;
        margin-bottom: 5px;
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
    }
    
    /* Radio buttons */
    .radio-group {
        display: flex;
        gap: 20px;
    }
    
    .radio-container {
        display: flex;
        align-items: center;
        cursor: pointer;
        user-select: none;
    }
    
    .radio-container input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }
    
    .radio-custom {
        height: 20px;
        width: 20px;
        border-radius: 50%;
        border: 2px solid #e1e1e1;
        display: inline-block;
        position: relative;
        margin-right: 10px;
        transition: all 0.3s ease;
    }
    
    .radio-container:hover .radio-custom {
        border-color: #7262fd;
    }
    
    .radio-container input:checked ~ .radio-custom {
        border-color: #7262fd;
    }
    
    .radio-custom:after {
        content: '';
        position: absolute;
        display: none;
        top: 3px;
        left: 3px;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #7262fd;
    }
    
    .radio-container input:checked ~ .radio-custom:after {
        display: block;
        animation: pulse 0.3s;
    }
    
    .radio-label {
        font-size: 14px;
        color: #333;
    }
    
    /* Coupon meta */
    .coupon-meta {
        margin-top: 20px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    
    .meta-item {
        display: flex;
        align-items: center;
        color: #666;
        font-size: 13px;
    }
    
    .meta-item i {
        margin-right: 8px;
        color: #7262fd;
    }
    
    /* Switch */
    .custom-switch-label {
        display: block;
        margin-bottom: 10px;
    }
    
    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
        margin-right: 10px;
        vertical-align: middle;
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
        background-color: #7262fd;
    }
    
    input:focus + .slider {
        box-shadow: 0 0 1px #7262fd;
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
    
    .switch-text {
        font-size: 14px;
        font-weight: 500;
        vertical-align: middle;
    }
    
    /* Preview Section */
    .preview-section {
        margin-top: 30px;
    }
    
    .coupon-preview {
        display: flex;
        justify-content: center;
        margin-top: 15px;
    }
    
    .coupon-card {
        width: 100%;
        max-width: 400px;
        background: linear-gradient(135deg, #7262fd 0%, #a594ff 100%);
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(114, 98, 253, 0.3);
        overflow: hidden;
        position: relative;
        transform-style: preserve-3d;
        perspective: 1000px;
        transition: all 0.5s ease;
    }
    
    .coupon-card:hover {
        transform: translateY(-10px) rotateY(5deg);
        box-shadow: 0 15px 35px rgba(114, 98, 253, 0.4);
    }
    
    .coupon-content {
        padding: 25px;
        display: flex;
        justify-content: space-between;
        color: white;
    }
    
    .discount {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }
    
    .discount-value {
        font-size: 32px;
        font-weight: 700;
        line-height: 1;
    }
    
    .discount-label {
        font-size: 16px;
        font-weight: 500;
        text-transform: uppercase;
    }
    
    .coupon-details {
        text-align: right;
    }
    
    .coupon-code-display {
        font-family: 'Courier New', monospace;
        font-size: 20px;
        font-weight: 700;
        background-color: rgba(255, 255, 255, 0.2);
        padding: 5px 10px;
        border-radius: 8px;
        margin-bottom: 10px;
    }
    
    .coupon-expiry {
        font-size: 12px;
        opacity: 0.8;
    }
    
    .coupon-scissors {
        padding: 5px 0;
        background-color: white;
    }
    
    .scissors-line {
        display: flex;
        align-items: center;
        justify-content: center;
        color: #7262fd;
        font-size: 14px;
    }
    
    .scissors-line i {
        margin-right: 10px;
        animation: snip 2s infinite;
    }
    
    .coupon-restrictions {
        background-color: white;
        color: #333;
        padding: 15px 25px;
        font-size: 12px;
    }
    
    .restriction-item {
        margin-bottom: 5px;
    }
    
    .form-actions {
        display: flex;
        justify-content: flex-start;
        gap: 15px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e1e1e1;
    }
    
    /* Animations */
    @keyframes pulse {
        0% {
            transform: scale(0.5);
            opacity: 0;
        }
        50% {
            transform: scale(1.2);
            opacity: 1;
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }
    
    @keyframes snip {
        0% {
            transform: scale(1);
        }
        10% {
            transform: scale(0.9);
        }
        20% {
            transform: scale(1);
        }
        100% {
            transform: scale(1);
        }
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .form-container {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elements
        const codeInput = document.getElementById('code');
        const typeRadios = document.querySelectorAll('input[name="type"]');
        const valueInput = document.getElementById('value');
        const valueIcon = document.getElementById('valueIcon');
        const valueHelp = document.getElementById('valueHelp');
        const minOrderInput = document.getElementById('min_order_amount');
        const maxUsesInput = document.getElementById('max_uses');
        const expiryInput = document.getElementById('expires_at');
        const generateBtn = document.getElementById('generateCode');
        const activeSwitch = document.querySelector('input[name="is_active"]');
        const switchText = document.querySelector('.switch-text');
        
        // Preview elements
        const previewCode = document.getElementById('previewCode');
        const previewValue = document.getElementById('previewValue');
        const previewType = document.getElementById('previewType');
        const previewExpiry = document.getElementById('previewExpiry');
        const previewMinimum = document.getElementById('previewMinimum');
        const previewUsage = document.getElementById('previewUsage');
        
        // Generate random code
        generateBtn.addEventListener('click', function() {
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let result = '';
            for (let i = 0; i < 8; i++) {
                result += characters.charAt(Math.floor(Math.random() * characters.length));
            }
            codeInput.value = result;
            updatePreview();
        });
        
        // Toggle between fixed and percentage
        typeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'fixed') {
                    valueIcon.textContent = '$';
                    valueHelp.textContent = 'Amount to deduct from the order total';
                } else {
                    valueIcon.textContent = '%';
                    valueHelp.textContent = 'Percentage to deduct from the order total';
                }
                updatePreview();
            });
        });
        
        // Update switch text
        activeSwitch.addEventListener('change', function() {
            switchText.textContent = this.checked ? 'Active' : 'Inactive';
        });
        
        // Update preview on input changes
        [codeInput, valueInput, minOrderInput, maxUsesInput, expiryInput, activeSwitch].forEach(input => {
            input.addEventListener('input', updatePreview);
        });
        
        // Initial preview update
        updatePreview();
        
        // Preview update function
        function updatePreview() {
            // Update code
            previewCode.textContent = codeInput.value;
            
            // Update value and type
            const type = document.querySelector('input[name="type"]:checked').value;
            const value = valueInput.value || '0';
            
            if (type === 'fixed') {
                previewValue.textContent = '$' + parseFloat(value).toFixed(2);
                previewType.textContent = 'OFF';
            } else {
                previewValue.textContent = parseFloat(value).toFixed(0) + '%';
                previewType.textContent = 'OFF';
            }
            
            // Update expiry
            if (expiryInput.value) {
                const expiryDate = new Date(expiryInput.value);
                previewExpiry.textContent = 'Valid until: ' + expiryDate.toLocaleDateString();
            } else {
                previewExpiry.textContent = 'Valid until: No Expiry';
            }
            
            // Update minimum order
            if (minOrderInput.value && parseFloat(minOrderInput.value) > 0) {
                previewMinimum.textContent = 'Minimum order: $' + parseFloat(minOrderInput.value).toFixed(2);
            } else {
                previewMinimum.textContent = 'Minimum order: None';
            }
            
            // Update usage limit
            const usedCount = {{ $coupon->used_times }};
            if (maxUsesInput.value && parseInt(maxUsesInput.value) > 0) {
                previewUsage.textContent = 'Usage: Limited to ' + parseInt(maxUsesInput.value) + ' uses';
                if (usedCount > 0) {
                    previewUsage.textContent += ` (${usedCount} used)`;
                }
            } else {
                previewUsage.textContent = 'Usage: Unlimited';
                if (usedCount > 0) {
                    previewUsage.textContent += ` (${usedCount} used)`;
                }
            }
            
            // Add animation effect
            const couponCard = document.querySelector('.coupon-card');
            couponCard.classList.add('animate');
            setTimeout(() => {
                couponCard.classList.remove('animate');
            }, 500);
        }
        
        // Add 3D effect to coupon card
        const couponCard = document.querySelector('.coupon-card');
        document.addEventListener('mousemove', function(e) {
            const card = couponCard.getBoundingClientRect();
            const centerX = card.left + card.width / 2;
            const centerY = card.top + card.height / 2;
            const posX = e.clientX - centerX;
            const posY = e.clientY - centerY;
            
            const rotateX = posY / -20;
            const rotateY = posX / 20;
            
            couponCard.style.transform = `rotateY(${rotateY}deg) rotateX(${rotateX}deg)`;
        });
        
        couponCard.addEventListener('mouseleave', function() {
            couponCard.style.transform = 'rotateY(0) rotateX(0)';
        });
    });
    
    function confirmDelete() {
        if (confirm('Are you sure you want to delete this coupon? This action cannot be undone.')) {
            document.getElementById('delete-form').submit();
        }
    }
</script>
@endpush
@endsection 