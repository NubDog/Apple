@extends('layouts.admin')

@section('title', 'Users Management')

@section('content')
<div class="users-dashboard">
    <!-- Header Section -->
    <div class="dashboard-header">
        <!-- Phần này bị lỗi hiển thị mà lười fix quá -->
        <!-- <div class="breadcrumb">
            <span>Dashboard</span> <i class="bi bi-chevron-right"></i> <span>Users Management</span>
        </div> -->
        <div class="header-actions">
            <button class="btn-notification">
                <i class="bi bi-bell"></i>
                <span class="notification-badge">3</span>
            </button>
            <button class="btn-settings">
                <i class="bi bi-gear"></i>
            </button>
        </div>
    </div>

    <!-- Users Section -->
    <div class="section-container">
        <div class="section-header">
            <h2 class="section-title">Users</h2>
            <div class="section-actions">
                <a href="{{ route('admin.users.index') }}" class="btn-view-all">View All</a>
            </div>
        </div>
        
        <!-- Control Bar -->
        <div class="control-bar">
            <div class="search-container">
                <i class="bi bi-search search-icon"></i>
                <input type="text" id="search-users" class="search-input" placeholder="Search by name...">
            </div>
            
            <div class="filters">
                <a href="{{ route('admin.users.create') }}" class="btn-primary">
                    <i class="bi bi-plus"></i> Add New User
                </a>
                
                <div class="filter-buttons">
                    <button class="btn-filter active">All</button>
                    <button class="btn-filter">Admin</button>
                    <button class="btn-filter">Regular</button>
                </div>
            </div>
        </div>
        
        <!-- User Statistics -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $totalUsers }}</h3>
                    <p>Total Users</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="bi bi-person-check-fill"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $activeUsers }}</h3>
                    <p>Active Users</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $adminUsers }}</h3>
                    <p>Admin Users</p>
                </div>
            </div>
        </div>
        
        <!-- Users Cards Grid -->
        <div class="users-grid">
            @foreach($users as $user)
            <div class="user-card" data-role="{{ $user->isAdmin() ? 'admin' : 'user' }}">
                <div class="card-header">
                    <div class="time-badge">
                        <i class="bi bi-clock"></i> Registered: {{ $user->created_at->format('M d, Y') }}
                    </div>
                    <div class="status-badge {{ $user->isAdmin() ? 'admin' : 'regular' }}">
                        {{ $user->isAdmin() ? 'Admin' : 'Regular User' }}
                    </div>
                </div>
                
                <div class="card-content">
                    <div class="user-avatar">
                        <img src="{{ $user->profile_photo_url ?? asset('images/default-avatar.jpg') }}" alt="{{ $user->name }}">
                    </div>
                    
                    <h3 class="user-name">{{ $user->name }}</h3>
                    <p class="user-specialty">{{ $user->email }}</p>
                    
                    <div class="user-details">
                        <div class="detail-item">
                            <i class="bi bi-telephone"></i>
                            <span>{{ $user->phone ?? 'No phone number' }}</span>
                        </div>
                        <div class="detail-item">
                            <i class="bi bi-geo-alt"></i>
                            <span>{{ $user->address ?? 'No address' }}</span>
                        </div>
                    </div>
                    
                    <div class="patients-counter">
                        <div class="counter-label">
                            <i class="bi bi-activity"></i>
                            <span>Activity</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress" style="width: {!! $user->isAdmin() ? '100%' : '60%' !!}"></div>
                        </div>
                        <div class="counter-value">
                            {!! $user->isAdmin() ? 'Admin Access' : 'Regular Access' !!}
                        </div>
                    </div>
                </div>
                
                <div class="card-actions">
                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn-action view" title="View">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-action edit" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <button class="btn-action message" title="Message">
                        <i class="bi bi-chat"></i>
                    </button>
                    @if($user->id != auth()->id())
                    <button class="btn-action delete" title="Delete" onclick="confirmDelete({!! $user->id !!})">
                        <i class="bi bi-trash"></i>
                    </button>
                    
                    <form id="delete-form-{!! $user->id !!}" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="pagination-container">
            <div class="pagination-info">
                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} results
            </div>
            <nav aria-label="User pagination">
                <ul class="pagination">
                    @if ($users->onFirstPage())
                        <li class="disabled"><span>&laquo;</span></li>
                    @else
                        <li><a href="{{ $users->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                    @endif

                    @foreach(range(1, $users->lastPage()) as $page)
                        @if($page == $users->currentPage())
                            <li class="active"><span>{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $users->url($page) }}">{{ $page }}</a></li>
                        @endif
                    @endforeach

                    @if ($users->hasMorePages())
                        <li><a href="{{ $users->nextPageUrl() }}" rel="next">&raquo;</a></li>
                    @else
                        <li class="disabled"><span>&raquo;</span></li>
                    @endif
                </ul>
            </nav>
        </div>
        
        @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible">
            <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
    </div>
    
    <!-- User Roles Section -->
    <div class="section-container">
        <div class="section-header">
            <h2 class="section-title">User Roles</h2>
            <div class="section-actions">
                <button class="btn-view-all">View All</button>
            </div>
        </div>
        
        <div class="roles-control-bar">
            <button class="btn-primary">
                <i class="bi bi-plus"></i> Add New Role
            </button>
            
            <div class="filter-buttons">
                <button class="btn-filter active">All</button>
                <button class="btn-filter">System</button>
                <button class="btn-filter">Custom</button>
            </div>
        </div>
        
        <div class="roles-grid">
            <div class="role-card">
                <div class="role-icon admin">
                    <i class="bi bi-shield-lock"></i>
                </div>
                <div class="role-info">
                    <h3>Administrator</h3>
                    <p>Full system access</p>
                </div>
                <div class="role-actions">
                    <button class="btn-role-action"><i class="bi bi-pencil"></i></button>
                    <button class="btn-role-action"><i class="bi bi-info-circle"></i></button>
                </div>
            </div>
            
            <div class="role-card">
                <div class="role-icon manager">
                    <i class="bi bi-briefcase"></i>
                </div>
                <div class="role-info">
                    <h3>Manager</h3>
                    <p>Product management</p>
                </div>
                <div class="role-actions">
                    <button class="btn-role-action"><i class="bi bi-pencil"></i></button>
                    <button class="btn-role-action"><i class="bi bi-info-circle"></i></button>
                </div>
            </div>
            
            <div class="role-card">
                <div class="role-icon user">
                    <i class="bi bi-person"></i>
                </div>
                <div class="role-info">
                    <h3>User</h3>
                    <p>Regular user access</p>
                </div>
                <div class="role-actions">
                    <button class="btn-role-action"><i class="bi bi-pencil"></i></button>
                    <button class="btn-role-action"><i class="bi bi-info-circle"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Main layout */
    .users-page {
        padding: 24px;
        max-width: 100%;
        overflow-x: hidden;
    }

    /* Dashboard Layout */
    .users-dashboard {
        width: 100%;
        padding: 20px;
        background-color: #f8f9fa;
    }
    
    /* Header Styles */
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    
    .breadcrumb {
        font-size: 14px;
        color: #6c757d;
    }
    
    .breadcrumb i {
        margin: 0 8px;
        font-size: 12px;
    }
    
    .header-actions {
        display: flex;
        gap: 12px;
    }
    
    .btn-notification, .btn-settings {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: none;
        background-color: #fff;
        color: #495057;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        cursor: pointer;
    }
    
    .notification-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: #dc3545;
        color: white;
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Section Container */
    .section-container {
        background-color: #fff;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
        margin-left: 250px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    /* Section Header */
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .section-title {
        font-size: 20px;
        font-weight: 600;
        color: #212529;
        margin: 0;
    }
    
    .btn-view-all {
        color: #4361ee;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
    }
    
    /* Control Bar */
    .control-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    
    .search-container {
        position: relative;
        width: 300px;
    }
    
    .search-input {
        width: 100%;
        padding: 10px 15px 10px 40px;
        border-radius: 30px;
        border: 1px solid #ced4da;
        font-size: 14px;
        outline: none;
        transition: all 0.3s;
    }
    
    .search-input:focus {
        border-color: #4361ee;
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
    }
    
    .search-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
    }
    
    .filters {
        display: flex;
        align-items: center;
        gap: 16px;
    }
    
    .btn-primary {
        background-color: #4361ee;
        color: white;
        border: none;
        border-radius: 30px;
        padding: 10px 20px;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
    }
    
    .btn-primary:hover {
        background-color: #3a56d4;
    }
    
    .filter-buttons {
        display: flex;
        background-color: #f1f3f9;
        border-radius: 30px;
        padding: 4px;
    }
    
    .btn-filter {
        padding: 8px 16px;
        border-radius: 30px;
        border: none;
        background: none;
        font-size: 14px;
        color: #6c757d;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-filter.active {
        background-color: #fff;
        color: #4361ee;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    /* Stats Container */
    .stats-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 24px;
        width: 100%;
    }
    
    .stat-card {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: row;
        padding: 16px;
        border-radius: 12px;
        background-color: #f8f9fa;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        min-width: 0;
    }
    
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 16px;
        font-size: 20px;
        color: white;
    }
    
    .stat-icon.blue {
        background-color: #4361ee;
    }
    
    .stat-icon.green {
        background-color: #10b981;
    }
    
    .stat-icon.purple {
        background-color: #8b5cf6;
    }
    
    .stat-info h3 {
        font-size: 24px;
        font-weight: 600;
        margin: 0 0 4px 0;
    }
    
    .stat-info p {
        font-size: 14px;
        color: #6c757d;
        margin: 0;
    }
    
    /* Users Grid */
    .users-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
        width: 100%;
    }
    
    .user-card {
        border-radius: 12px;
        background-color: #fff;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        overflow: hidden;
        transition: all 0.3s;
        width: 100%;
    }
    
    .user-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .card-header {
        padding: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #f1f3f9;
    }
    
    .time-badge {
        font-size: 12px;
        color: #6c757d;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .status-badge {
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .status-badge.admin {
        background-color: #8b5cf6;
        color: white;
    }
    
    .status-badge.regular {
        background-color: #10b981;
        color: white;
    }
    
    .card-content {
        padding: 20px;
        text-align: center;
    }
    
    .user-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin: 0 auto 16px;
        overflow: hidden;
        border: 3px solid #f1f3f9;
    }
    
    .user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .user-name {
        font-size: 18px;
        font-weight: 600;
        margin: 0 0 4px 0;
        color: #212529;
    }
    
    .user-specialty {
        font-size: 14px;
        color: #6c757d;
        margin: 0 0 16px 0;
    }
    
    .user-details {
        margin-bottom: 16px;
    }
    
    .detail-item {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
        font-size: 13px;
        color: #495057;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        max-width: 100%;
    }
    
    .patients-counter {
        padding: 12px;
        background-color: #f8f9fa;
        border-radius: 8px;
    }
    
    .counter-label {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 8px;
        font-size: 14px;
        color: #6c757d;
    }
    
    .progress-bar {
        height: 8px;
        border-radius: 4px;
        background-color: #e9ecef;
        margin-bottom: 8px;
        overflow: hidden;
    }
    
    .progress {
        height: 100%;
        border-radius: 4px;
        background-color: #4361ee;
    }
    
    .counter-value {
        font-size: 14px;
        font-weight: 500;
        color: #4361ee;
        text-align: right;
    }
    
    .card-actions {
        display: flex;
        border-top: 1px solid #f1f3f9;
    }
    
    .btn-action {
        flex: 1;
        padding: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        background: none;
        color: #6c757d;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
    }
    
    .btn-action:hover {
        background-color: #f8f9fa;
        color: #4361ee;
    }
    
    .btn-action.view:hover {
        color: #4361ee;
    }
    
    .btn-action.edit:hover {
        color: #ffc107;
    }
    
    .btn-action.message:hover {
        color: #10b981;
    }
    
    .btn-action.delete:hover {
        color: #dc3545;
    }
    
    /* Roles Grid */
    .roles-control-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    
    .roles-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }
    
    .role-card {
        padding: 20px;
        border-radius: 12px;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    
    .role-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 16px;
        font-size: 20px;
        color: white;
    }
    
    .role-icon.admin {
        background-color: #8b5cf6;
    }
    
    .role-icon.manager {
        background-color: #4361ee;
    }
    
    .role-icon.user {
        background-color: #10b981;
    }
    
    .role-info {
        flex: 1;
    }
    
    .role-info h3 {
        font-size: 16px;
        font-weight: 600;
        margin: 0 0 4px 0;
        color: #212529;
    }
    
    .role-info p {
        font-size: 13px;
        color: #6c757d;
        margin: 0;
    }
    
    .role-actions {
        display: flex;
        gap: 8px;
    }
    
    .btn-role-action {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        background-color: #fff;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-role-action:hover {
        background-color: #4361ee;
        color: #fff;
    }
    
    /* Pagination */
    .pagination-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        margin-top: 24px;
    }
    
    .pagination-info {
        font-size: 14px;
        color: #6c757d;
    }
    
    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        gap: 8px;
    }
    
    .pagination li {
        display: inline-block;
    }
    
    .pagination li a, .pagination li span {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        color: #495057;
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        transition: all 0.2s;
    }
    
    .pagination li.active span {
        background-color: #4361ee;
        color: white;
        border-color: #4361ee;
    }
    
    .pagination li.disabled span {
        color: #adb5bd;
        cursor: not-allowed;
    }
    
    .pagination li a:hover {
        background-color: #e9ecef;
    }
    
    /* Alerts */
    .alert {
        padding: 16px;
        border-radius: 8px;
        margin-top: 24px;
        display: flex;
        align-items: center;
        position: relative;
    }
    
    .alert i {
        margin-right: 12px;
        font-size: 18px;
    }
    
    .alert-success {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .alert-danger {
        background-color: #fee2e2;
        color: #b91c1c;
    }
    
    .btn-close {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        font-size: 16px;
        cursor: pointer;
        color: inherit;
        opacity: 0.7;
    }
    
    .btn-close:hover {
        opacity: 1;
    }

    /* Responsive styles */
    @media (max-width: 992px) {
        .users-grid {
            grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
        }
        
        .roles-grid {
            grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
        }
        
        .stats-container {
            flex-direction: column;
        }
    }
    
    @media (max-width: 768px) {
        .control-bar, .roles-control-bar {
            flex-direction: column;
            align-items: stretch;
            gap: 16px;
        }
        
        .search-container {
            width: 100%;
        }
        
        .users-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        }
    }
    
    @media (max-width: 480px) {
        .users-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Confirm delete function
        window.confirmDelete = function(userId) {
            if(confirm('Are you sure you want to delete this user?')) {
                document.getElementById('delete-form-' + userId).submit();
            }
        };
        
        // Filter buttons functionality
        const filterButtons = document.querySelectorAll('.filter-buttons .btn-filter');
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Filter cards based on clicked filter
                const filter = this.textContent.trim().toLowerCase();
                const userCards = document.querySelectorAll('.user-card');
                
                userCards.forEach(card => {
                    const cardRole = card.getAttribute('data-role');
                    
                    if (filter === 'all' || filter === cardRole) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
        
        // Search functionality
        const searchInput = document.getElementById('search-users');
        searchInput.addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const userCards = document.querySelectorAll('.user-card');
            
            userCards.forEach(card => {
                const userName = card.querySelector('.user-name').textContent.toLowerCase();
                const userEmail = card.querySelector('.user-specialty').textContent.toLowerCase();
                
                if (userName.includes(searchValue) || userEmail.includes(searchValue)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
        
        // Alert auto dismiss
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.opacity = '0';
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 300);
            }, 5000);
        });
    });
</script>
@endpush 