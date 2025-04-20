<!-- Footer -->
<footer class="mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <h5>Shark Car</h5>
                <p>Chúng tôi cung cấp những mẫu xe tốt nhất với giá cả cạnh tranh và dịch vụ chăm sóc khách hàng tuyệt vời.</p>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 mb-4">
                <h5>Liên kết nhanh</h5>
                <ul>
                    <li><a href="/">Trang chủ</a></li>
                    <li><a href="{{ route('products.index') }}">Sản phẩm</a></li>
                    <li><a href="{{ route('about') }}">Về chúng tôi</a></li>
                    <li><a href="{{ route('contact.index') }}">Liên hệ</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <h5>Hỗ trợ khách hàng</h5>
                <ul>
                    <li><a href="{{ route('shipping-policy') }}">Chính sách vận chuyển</a></li>
                    <li><a href="{{ route('return-policy') }}">Chính sách đổi trả</a></li>
                    <li><a href="{{ route('warranty-policy') }}">Chính sách bảo hành</a></li>
                    <li><a href="{{ route('faq') }}">Câu hỏi thường gặp</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <h5>Liên hệ với chúng tôi</h5>
                <ul>
                    <li><i class="fas fa-map-marker-alt me-2"></i> 123 Đường Lê Lợi, Q.1, TP.HCM</li>
                    <li><i class="fas fa-phone me-2"></i> (028) 3823 5766</li>
                    <li><i class="fas fa-envelope me-2"></i> info@sharkcar.vn</li>
                    <li><i class="fas fa-clock me-2"></i> 8:00 - 17:30, Thứ 2 - Thứ 7</li>
                </ul>
            </div>
        </div>
        <hr class="mt-4 mb-3">
        <div class="row">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0">&copy; {{ date('Y') }} Shark Car. Tất cả quyền được bảo lưu.</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <p class="mb-0">
                    <a href="{{ route('privacy-policy') }}" class="text-decoration-none me-3">Chính sách bảo mật</a>
                    <a href="{{ route('terms-of-service') }}" class="text-decoration-none">Điều khoản sử dụng</a>
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap Scripts -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
<!-- App Script -->
<script src="{{ asset('js/app.js') }}"></script>

<script>
    // Load cart count on page load
    $(document).ready(function() {
        loadCartCount();
        
        // Set up cart hover functionality
        $('.cart-btn').hover(function() {
            loadCartItems();
        });
    });
    
    // Function to load cart items for dropdown
    function loadCartItems() {
        $.ajax({
            url: '{{ route("cart.mini") }}',
            method: 'GET',
            success: function(response) {
                $('.cart-items').html(response.html);
                $('#cart-dropdown-count').text(response.count);
            }
        });
    }
    
    // Function to update cart count
    function loadCartCount() {
        $.ajax({
            url: '{{ route("cart.count") }}',
            method: 'GET',
            success: function(response) {
                $('#cart-count').text(response.count);
            }
        });
    }
</script>

@stack('scripts') 