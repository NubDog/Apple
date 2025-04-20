@extends('layouts.main')

@section('content')
<div class="container py-5 animate__animated animate__fadeIn">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Alerts -->
            @include('components.alert')
            
            <!-- Page Header -->
            <div class="page-header d-flex align-items-center mb-4">
                <div class="icon-circle bg-primary text-white me-3 animate__animated animate__bounceIn">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div>
                    <h2 class="page-title mb-0">Thông tin tài khoản</h2>
                    <p class="text-muted mb-0">
                        <i class="far fa-calendar-alt me-1"></i> Tham gia từ {{ auth()->user()->created_at->format('d/m/Y') }}
                    </p>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="row g-4">
                <!-- Profile Card -->
                <div class="col-md-4 animate__animated animate__fadeInLeft">
                    <div class="card profile-card shadow-lg h-100">
                        <div class="card-body text-center">
                            <div class="profile-picture-container">
                                @if(auth()->user()->profile_image)
                                    <img src="{{ auth()->user()->profile_photo_url }}" alt="Profile Picture" class="profile-picture">
                                @else
                                    <div class="profile-picture profile-initial">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="profile-picture-edit" data-bs-toggle="modal" data-bs-target="#profilePictureModal">
                                    <i class="fas fa-camera"></i>
                                </div>
                            </div>
                            
                            <h4 class="profile-name mt-3">{{ auth()->user()->name }}</h4>
                            <p class="profile-email">{{ auth()->user()->email }}</p>
                            
                            <div class="account-badges">
                                @if(auth()->user()->email_verified_at)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i> Email đã xác thực
                                    </span>
                                @else
                                    <span class="badge bg-warning">
                                        <i class="fas fa-exclamation-circle me-1"></i> Email chưa xác thực
                                    </span>
                                @endif
                                <span class="badge bg-info mt-2">
                                    <i class="fas fa-user me-1"></i> {{ auth()->user()->role }}
                                </span>
                            </div>
                            
                            <div class="profile-actions mt-4">
                                <button class="btn btn-outline-primary btn-sm btn-with-icon" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                    <i class="fas fa-key"></i> Đổi mật khẩu
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Account Info Card -->
                <div class="col-md-8 animate__animated animate__fadeInRight">
                    <div class="card account-info-card shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-info-circle me-2"></i>Thông tin chi tiết
                            </div>
                            <button class="btn btn-sm btn-edit-toggle" id="toggleEditMode">
                                <i class="fas fa-pen"></i> Chỉnh sửa
                            </button>
                        </div>
                        
                        <div class="card-body">
                            <!-- View Mode -->
                            <div id="viewMode">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="info-content">
                                        <span class="info-label">Họ và tên</span>
                                        <span class="info-value">{{ auth()->user()->name }}</span>
                                    </div>
                                </div>
                                
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="info-content">
                                        <span class="info-label">Email</span>
                                        <span class="info-value">{{ auth()->user()->email }}</span>
                                    </div>
                                </div>
                                
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div class="info-content">
                                        <span class="info-label">Số điện thoại</span>
                                        <span class="info-value">{{ auth()->user()->phone ?? 'Chưa cập nhật' }}</span>
                                    </div>
                                </div>
                                
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="info-content">
                                        <span class="info-label">Địa chỉ</span>
                                        <span class="info-value">{{ auth()->user()->address ?? 'Chưa cập nhật' }}</span>
                                    </div>
                                </div>
                                
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-heart"></i>
                                    </div>
                                    <div class="info-content">
                                        <span class="info-label">Sản phẩm yêu thích</span>
                                        <span class="info-value">{{ auth()->user()->favorites ? count(json_decode(auth()->user()->favorites)) : 0 }} sản phẩm</span>
                                    </div>
                                </div>
                                
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    <div class="info-content">
                                        <span class="info-label">Ngày tạo tài khoản</span>
                                        <span class="info-value">{{ auth()->user()->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                </div>
                                
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div class="info-content">
                                        <span class="info-label">Lần cập nhật cuối</span>
                                        <span class="info-value">{{ auth()->user()->updated_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Edit Mode -->
                            <div id="editMode" style="display: none;">
                                <form action="{{ route('user.update-profile') }}" method="POST" id="updateProfileForm">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Họ và tên</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->name }}" required>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}" required>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Số điện thoại</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            <input type="text" class="form-control" id="phone" name="phone" value="{{ auth()->user()->phone }}">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Địa chỉ</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                            <input type="text" class="form-control" id="address" name="address" value="{{ auth()->user()->address }}">
                                        </div>
                                    </div>
                                    
                                    <div class="text-end">
                                        <button type="button" class="btn btn-secondary me-2" id="cancelEdit">Hủy</button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-1"></i> Lưu thay đổi
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Activity Summary Card -->
                    <div class="card activity-card shadow-sm mt-4 animate__animated animate__fadeInUp">
                        <div class="card-header">
                            <i class="fas fa-chart-line me-2"></i>Hoạt động gần đây
                        </div>
                        <div class="card-body">
                            <div class="stats-container">
                                <div class="stat-item">
                                    <div class="stat-icon orders">
                                        <i class="fas fa-shopping-bag"></i>
                                    </div>
                                    <div class="stat-details">
                                        <span class="stat-value">{{ auth()->user()->orders_count ?? 0 }}</span>
                                        <span class="stat-label">Đơn hàng</span>
                                    </div>
                                </div>
                                
                                <div class="stat-item">
                                    <div class="stat-icon reviews">
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <div class="stat-details">
                                        <span class="stat-value">{{ auth()->user()->reviews_count ?? 0 }}</span>
                                        <span class="stat-label">Đánh giá</span>
                                    </div>
                                </div>
                                
                                <div class="stat-item">
                                    <div class="stat-icon favorites">
                                        <i class="fas fa-heart"></i>
                                    </div>
                                    <div class="stat-details">
                                        <span class="stat-value">{{ auth()->user()->favorites ? count(json_decode(auth()->user()->favorites)) : 0 }}</span>
                                        <span class="stat-label">Yêu thích</span>
                                    </div>
                                </div>
                                
                                <div class="stat-item">
                                    <div class="stat-icon logins">
                                        <i class="fas fa-sign-in-alt"></i>
                                    </div>
                                    <div class="stat-details">
                                        <span class="stat-value">{{ auth()->user()->login_count ?? 0 }}</span>
                                        <span class="stat-label">Đăng nhập</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="activity-cta mt-4 text-center">
                                <a href="{{ route('user.orders') }}" class="btn btn-outline-primary btn-sm me-2">
                                    <i class="fas fa-shopping-bag me-1"></i> Xem đơn hàng
                                </a>
                                <a href="{{ route('products.index') }}" class="btn btn-outline-success btn-sm">
                                    <i class="fas fa-store me-1"></i> Tiếp tục mua sắm
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Đổi mật khẩu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user.change-password') }}" method="POST" id="changePasswordForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="current_password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Mật khẩu mới</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="new_password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="new_password_confirmation">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('changePasswordForm').submit()">
                    <i class="fas fa-save me-1"></i> Lưu thay đổi
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Profile Picture Modal -->
<div class="modal fade" id="profilePictureModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cập nhật ảnh đại diện</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user.update-avatar') }}" method="POST" enctype="multipart/form-data" id="updateAvatarForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="text-center mb-4">
                        <div class="avatar-preview-container">
                            <img id="avatarPreview" src="{{ auth()->user()->profile_photo_url }}" alt="Preview">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="profile_image" class="form-label">Chọn ảnh mới</label>
                        <input class="form-control" type="file" id="profile_image" name="profile_image" accept="image/*" onchange="previewImage()">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger me-2" id="removeAvatar">
                    <i class="fas fa-trash-alt me-1"></i> Xóa ảnh
                </button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('updateAvatarForm').submit()">
                    <i class="fas fa-save me-1"></i> Lưu thay đổi
                </button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    :root {
        --primary: #4361ee;
        --secondary: #3f37c9;
        --success: #4cc9f0;
        --info: #4895ef;
        --warning: #ffb703;
        --danger: #e63946;
        --light: #f8f9fa;
        --dark: #212529;
        --gray-100: #f8f9fa;
        --gray-200: #e9ecef;
        --gray-300: #dee2e6;
        --gray-400: #ced4da;
        --gray-500: #adb5bd;
        --gray-600: #6c757d;
        --border-radius: 1rem;
        --card-radius: 1.5rem;
    }
    
    /* Page header */
    .page-header {
        margin-bottom: 2rem;
    }
    
    .page-title {
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 0.5rem;
    }
    
    .icon-circle {
        width: 54px;
        height: 54px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        box-shadow: 0 10px 15px -3px rgba(67, 97, 238, 0.2);
    }
    
    /* Cards */
    .card {
        border: none;
        border-radius: var(--card-radius);
        overflow: hidden;
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1) !important;
    }
    
    .card-header {
        font-weight: 600;
        background-color: rgba(0, 0, 0, 0.03);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1rem 1.5rem;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    /* Profile Card */
    .profile-card {
        position: relative;
        overflow: visible;
    }
    
    .profile-picture-container {
        position: relative;
        width: 150px;
        height: 150px;
        margin: 0 auto 1rem;
    }
    
    .profile-picture {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid white;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        background-color: var(--gray-200);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: 700;
        color: var(--gray-600);
    }
    
    .profile-initial {
        background: linear-gradient(45deg, var(--primary), var(--secondary));
        color: white;
    }
    
    .profile-picture-edit {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 40px;
        height: 40px;
        background: var(--primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        cursor: pointer;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }
    
    .profile-picture-edit:hover {
        transform: scale(1.1);
    }
    
    .profile-name {
        font-weight: 700;
        margin-bottom: 0.25rem;
        color: var(--dark);
    }
    
    .profile-email {
        color: var(--gray-600);
        margin-bottom: 1rem;
    }
    
    .account-badges {
        margin-bottom: 1.5rem;
    }
    
    .badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 500;
        margin-right: 0.5rem;
        display: inline-block;
    }
    
    /* Info Items */
    .info-item {
        display: flex;
        align-items: center;
        margin-bottom: 1.25rem;
        padding: 0.5rem;
        border-radius: var(--border-radius);
        transition: all 0.3s ease;
    }
    
    .info-item:last-child {
        margin-bottom: 0;
    }
    
    .info-item:hover {
        background-color: var(--gray-100);
        transform: translateX(5px);
    }
    
    .info-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(45deg, var(--primary), var(--info));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-right: 1rem;
        font-size: 1rem;
        flex-shrink: 0;
    }
    
    .info-content {
        display: flex;
        flex-direction: column;
    }
    
    .info-label {
        font-size: 0.8rem;
        color: var(--gray-500);
        margin-bottom: 0.25rem;
    }
    
    .info-value {
        font-weight: 600;
        color: var(--dark);
    }
    
    /* Activity Stats */
    .stats-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }
    
    .stat-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        border-radius: var(--border-radius);
        background-color: var(--gray-100);
        margin-bottom: 1rem;
        width: calc(50% - 0.5rem);
        transition: all 0.3s ease;
    }
    
    .stat-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: white;
        margin-right: 1rem;
    }
    
    .stat-icon.orders {
        background: linear-gradient(45deg, #4361ee, #4895ef);
    }
    
    .stat-icon.reviews {
        background: linear-gradient(45deg, #f72585, #b5179e);
    }
    
    .stat-icon.favorites {
        background: linear-gradient(45deg, #e63946, #ff5d8f);
    }
    
    .stat-icon.logins {
        background: linear-gradient(45deg, #4cc9f0, #4895ef);
    }
    
    .stat-details {
        display: flex;
        flex-direction: column;
    }
    
    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--dark);
        line-height: 1;
    }
    
    .stat-label {
        font-size: 0.8rem;
        color: var(--gray-600);
    }
    
    /* Edit Mode */
    .btn-edit-toggle {
        background-color: var(--gray-100);
        color: var(--primary);
        border: none;
        border-radius: 30px;
        transition: all 0.3s ease;
    }
    
    .btn-edit-toggle:hover {
        background-color: var(--primary);
        color: white;
    }
    
    .input-group-text {
        background-color: var(--gray-100);
        border-color: var(--gray-300);
    }
    
    /* Modal customization */
    .modal-content {
        border: none;
        border-radius: var(--card-radius);
        overflow: hidden;
    }
    
    .modal-header {
        background-color: var(--gray-100);
        border-bottom: 1px solid var(--gray-200);
    }
    
    .modal-footer {
        background-color: var(--gray-100);
        border-top: 1px solid var(--gray-200);
    }
    
    /* Avatar Preview */
    .avatar-preview-container {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        overflow: hidden;
        margin: 0 auto;
        border: 5px solid white;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .avatar-preview-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    /* Activity CTA */
    .activity-cta {
        padding-top: 1rem;
        border-top: 1px dashed var(--gray-300);
    }
    
    /* Buttons */
    .btn-with-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        border-radius: 50px;
        padding: 0.5rem 1rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-primary {
        background: linear-gradient(45deg, var(--primary), var(--info));
        border: none;
        box-shadow: 0 5px 15px rgba(72, 149, 239, 0.2);
    }
    
    .btn-primary:hover {
        background: linear-gradient(45deg, var(--info), var(--primary));
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(72, 149, 239, 0.3);
    }
    
    .btn-outline-primary {
        border-color: var(--primary);
        color: var(--primary);
    }
    
    .btn-outline-primary:hover {
        background-color: var(--primary);
        transform: translateY(-2px);
    }
    
    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .stat-item {
            width: 100%;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle edit mode
        const toggleEditMode = document.getElementById('toggleEditMode');
        const viewMode = document.getElementById('viewMode');
        const editMode = document.getElementById('editMode');
        const cancelEdit = document.getElementById('cancelEdit');
        
        toggleEditMode.addEventListener('click', function() {
            viewMode.style.display = 'none';
            editMode.style.display = 'block';
            editMode.classList.add('animate__animated', 'animate__fadeIn');
        });
        
        cancelEdit.addEventListener('click', function() {
            editMode.style.display = 'none';
            viewMode.style.display = 'block';
            viewMode.classList.add('animate__animated', 'animate__fadeIn');
        });
        
        // Password visibility toggle
        const togglePasswordButtons = document.querySelectorAll('.toggle-password');
        togglePasswordButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const inputField = document.getElementById(targetId);
                
                if (inputField.type === 'password') {
                    inputField.type = 'text';
                    this.innerHTML = '<i class="fas fa-eye-slash"></i>';
                } else {
                    inputField.type = 'password';
                    this.innerHTML = '<i class="fas fa-eye"></i>';
                }
            });
        });
        
        // Animation for info items
        const infoItems = document.querySelectorAll('.info-item');
        infoItems.forEach((item, index) => {
            item.style.animation = `fadeInLeft ${0.3 + index * 0.1}s ease forwards`;
            item.style.opacity = '0';
        });
        
        // Animation for stat items
        const statItems = document.querySelectorAll('.stat-item');
        statItems.forEach((item, index) => {
            setTimeout(() => {
                item.classList.add('animate__animated', 'animate__fadeInUp');
            }, 500 + (index * 100));
        });
        
        // Add ripple effect to buttons
        const buttons = document.querySelectorAll('.btn');
        buttons.forEach(button => {
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                ripple.classList.add('ripple');
                
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                
                ripple.style.width = ripple.style.height = `${size}px`;
                ripple.style.left = `${e.clientX - rect.left - size/2}px`;
                ripple.style.top = `${e.clientY - rect.top - size/2}px`;
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
        
        // Remove avatar functionality
        const removeAvatar = document.getElementById('removeAvatar');
        removeAvatar.addEventListener('click', function() {
            // You would implement this with an AJAX call to remove the avatar
            // For now, let's just update the preview
            const avatarPreview = document.getElementById('avatarPreview');
            avatarPreview.src = '/images/default-avatar.png';
            
            // Create hidden input to signal removal
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'remove_avatar';
            hiddenInput.value = '1';
            document.getElementById('updateAvatarForm').appendChild(hiddenInput);
        });
    });
    
    // Preview image before upload
    function previewImage() {
        const preview = document.getElementById('avatarPreview');
        const file = document.getElementById('profile_image').files[0];
        const reader = new FileReader();
        
        reader.onloadend = function() {
            preview.src = reader.result;
        }
        
        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "{{ auth()->user()->profile_photo_url }}";
        }
    }
</script>
@endpush
@endsection 