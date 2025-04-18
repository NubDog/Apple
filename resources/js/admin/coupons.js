/**
 * Shark Car - Admin Coupon Management
 * JavaScript để quản lý mã giảm giá trong trang quản trị
 */

$(function() {
    // ===============================================================
    // Thiết lập chung
    // ===============================================================
    
    // Tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Animation cho các phần tử khi trang tải
    function animateElements() {
        $('.small-box').each(function(index) {
            $(this).addClass('animate__animated animate__fadeInUp');
            $(this).css('animation-delay', (index * 0.1) + 's');
        });
        
        $('.card').addClass('animate__animated animate__fadeIn');
    }
    
    animateElements();
    
    // ===============================================================
    // Trang Index - Danh sách mã giảm giá
    // ===============================================================
    
    // Copy coupon code
    $('.coupon-code').click(function() {
        const code = $(this).text();
        
        // Tạo một input tạm thời để copy
        const tempInput = $('<input>');
        $('body').append(tempInput);
        tempInput.val(code).select();
        document.execCommand('copy');
        tempInput.remove();
        
        showToast('Đã sao chép mã: ' + code, 'success');
    });
    
    // Filter functionality
    $('.filter-btn').click(function() {
        const filter = $(this).data('filter');
        
        // Thêm class active cho nút đang chọn
        $(this).addClass('active').siblings().removeClass('active');
        
        // Hiển thị tất cả dòng trước khi áp dụng filter
        $('.coupon-row').removeClass('hidden').show();
        
        // Nếu filter là "all" thì hiển thị tất cả
        if (filter === 'all') return;
        
        // Lọc các dòng theo điều kiện
        $('.coupon-row').each(function() {
            const row = $(this);
            let match = false;
            
            switch(filter) {
                case 'active':
                    match = row.data('status') === 'active' && row.data('expired') !== 'expired';
                    break;
                case 'expired':
                    match = row.data('expired') === 'expired';
                    break;
                case 'fixed':
                    match = row.data('type') === 'fixed';
                    break;
                case 'percent':
                    match = row.data('type') === 'percent';
                    break;
            }
            
            if (match) {
                row.fadeIn(300);
            } else {
                row.fadeOut(300).addClass('hidden');
            }
        });
    });
    
    // Search functionality
    $('#search-coupon').on('keyup', function() {
        const value = $(this).val().toLowerCase();
        
        $('.coupon-row').each(function() {
            const rowText = $(this).text().toLowerCase();
            const display = rowText.indexOf(value) > -1 ? '' : 'none';
            $(this).toggle(display !== 'none');
        });
    });
    
    // Delete confirmation
    var deleteId = null;
    
    $('.delete-btn').click(function() {
        deleteId = $(this).data('id');
        $('#deleteModal').modal('show');
    });
    
    $('#confirmDelete').click(function() {
        if (deleteId) {
            document.getElementById('delete-form-' + deleteId).submit();
        }
        $('#deleteModal').modal('hide');
    });
    
    // ===============================================================
    // Trang Create/Edit - Form mã giảm giá
    // ===============================================================
    
    // Handle value field display based on coupon type
    $('input[name="type"]').change(function() {
        if ($(this).val() === 'fixed') {
            $('#value-addon').text('VNĐ');
            $('#value-help').text('Số tiền giảm trực tiếp trên đơn hàng.');
        } else {
            $('#value-addon').text('%');
            $('#value-help').text('Phần trăm giảm giá trên tổng đơn hàng. Tối đa là 100%.');
            if (parseFloat($('#value').val()) > 100) {
                $('#value').val(100);
            }
        }
        updatePreview();
    });
    
    // Validate percent value
    $('#value').on('input', function() {
        if ($('input[name="type"]:checked').val() === 'percent' && parseFloat($(this).val()) > 100) {
            $(this).val(100);
        }
        updatePreview();
    });
    
    // Generate random coupon code
    $('#generate-coupon').click(function() {
        const prefix = 'SHARK';
        const length = 6;
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let result = prefix;
        
        for (let i = 0; i < length; i++) {
            result += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        
        $('#code').val(result);
        updatePreview();
    });
    
    // Update preview when inputs change
    $('#code, #value, #min_order_amount, #expires_at').on('input', function() {
        updatePreview();
    });
    
    // Handle status switch for preview
    $('#is_active').change(function() {
        if ($(this).is(':checked')) {
            $('.coupon-header .badge').removeClass('badge-danger').addClass('badge-success').text('Hoạt động');
        } else {
            $('.coupon-header .badge').removeClass('badge-success').addClass('badge-danger').text('Không hoạt động');
        }
    });
    
    // Form submission with validation
    $('#coupon-form').on('submit', function(e) {
        // Hiển thị loading
        $('.save-button').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Đang lưu...');
        
        // Cơ bản đã có validation bên server, đây chỉ là check đơn giản
        if (!$('#code').val().trim()) {
            e.preventDefault();
            showToast('Vui lòng nhập mã giảm giá', 'error');
            $('#code').focus();
            $('.save-button').prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Lưu mã giảm giá');
            return false;
        }
        
        if (!$('#value').val() || parseFloat($('#value').val()) <= 0) {
            e.preventDefault();
            showToast('Giá trị giảm giá phải lớn hơn 0', 'error');
            $('#value').focus();
            $('.save-button').prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Lưu mã giảm giá');
            return false;
        }
    });
    
    // ===============================================================
    // Trang Show - Chi tiết mã giảm giá
    // ===============================================================
    
    // Copy to clipboard
    if (typeof ClipboardJS !== 'undefined') {
        var clipboard = new ClipboardJS('.copy-btn');
        
        clipboard.on('success', function(e) {
            showToast('Đã sao chép mã: ' + e.text, 'success');
            e.clearSelection();
        });
        
        clipboard.on('error', function(e) {
            showToast('Không thể sao chép mã', 'error');
        });
    }
    
    // ===============================================================
    // Preview coupon function
    // ===============================================================
    
    // Cập nhật preview
    function updatePreview() {
        if (!$('#preview-code').length) return;
        
        const code = $('#code').val() || 'COUPONCODE';
        const value = $('#value').val() || '0';
        const type = $('input[name="type"]:checked').val();
        const min = $('#min_order_amount').val();
        const expires = $('#expires_at').val();
        
        $('#preview-code').text(code);
        $('#preview-value').text(value);
        
        if (type === 'fixed') {
            $('#preview-type').text('VNĐ');
        } else {
            $('#preview-type').text('%');
        }
        
        if (min) {
            $('#preview-min').text(new Intl.NumberFormat('vi-VN').format(min) + ' VNĐ');
        } else {
            $('#preview-min').text('Không giới hạn');
        }
        
        if (expires) {
            const date = new Date(expires);
            const formattedDate = new Intl.DateTimeFormat('vi-VN', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            }).format(date);
            $('#preview-expires').text(formattedDate);
        } else {
            $('#preview-expires').text('Không giới hạn');
        }
    }
    
    // Gọi lần đầu nếu đang ở trang có preview
    if ($('#preview-code').length) {
        updatePreview();
    }
    
    // ===============================================================
    // Toast notifications
    // ===============================================================
    
    // Hiển thị thông báo toast
    function showToast(message, type = 'success') {
        var toastContainer = $('.toast-container');
        
        if (toastContainer.length === 0) {
            toastContainer = $('<div class="toast-container"></div>');
            $('body').append(toastContainer);
            
            // Add CSS nếu chưa có
            if ($('#toast-styles').length === 0) {
                $('head').append(`
                    <style id="toast-styles">
                        .toast-container {
                            position: fixed;
                            top: 20px;
                            right: 20px;
                            z-index: 9999;
                        }
                        
                        .toast {
                            min-width: 250px;
                            background-color: white;
                            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
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
                `);
            }
        }
        
        var icon = type === 'success' ? 'check-circle' : 'exclamation-circle';
        
        var toast = $(`
            <div class="toast toast-${type}">
                <div class="toast-icon">
                    <i class="fas fa-${icon}"></i>
                </div>
                <div class="toast-body">
                    ${message}
                </div>
            </div>
        `);
        
        toastContainer.append(toast);
        
        setTimeout(function() {
            toast.addClass('hide');
            setTimeout(function() {
                toast.remove();
            }, 300);
        }, 3000);
    }
}); 