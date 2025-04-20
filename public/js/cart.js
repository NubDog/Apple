// Cập nhật số lượng sản phẩm trong giỏ hàng
function updateCartCount() {
    fetch('/cart/count')
        .then(response => response.json())
        .then(data => {
            document.getElementById('cart-count').textContent = data.count;
        })
        .catch(error => console.error('Error updating cart count:', error));
}

// Khởi chạy khi trang đã tải xong
document.addEventListener('DOMContentLoaded', function() {
    // Cập nhật số lượng trong giỏ hàng khi trang tải
    updateCartCount();
    
    // Thiết lập cập nhật định kỳ mỗi 30 giây (tùy chọn)
    setInterval(updateCartCount, 30000);
}); 