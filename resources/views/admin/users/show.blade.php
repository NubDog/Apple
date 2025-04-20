@extends('layouts.admin')

@section('title', 'User Details')

@section('content')
<div class="user-details-container">
    <div class="card">
        <div class="card-title">
            User Details
            <div class="actions">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Users
                </a>
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">
                    <i class="bi bi-pencil"></i> Edit User
                </a>
            </div>
        </div>
        
        <div class="user-profile">
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-image">
                        <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('images/default-avatar.jpg') }}" alt="{{ $user->name }}">
                    </div>
                </div>
                
                <div class="col-md-8">
                    <div class="profile-info">
                        <h1 class="user-name">{{ $user->name }}</h1>
                        
                        <div class="role-badge {{ $user->isAdmin() ? 'admin' : 'user' }}">
                            {{ $user->isAdmin() ? 'Administrator' : 'User' }}
                        </div>
                        
                        <div class="user-meta">
                            <div class="meta-item">
                                <span class="meta-label">Email:</span>
                                <span class="meta-value">{{ $user->email }}</span>
                            </div>
                            
                            <div class="meta-item">
                                <span class="meta-label">Registered:</span>
                                <span class="meta-value">{{ $user->created_at->format('M d, Y') }}</span>
                            </div>
                            
                            <div class="meta-item">
                                <span class="meta-label">Last Updated:</span>
                                <span class="meta-value">{{ $user->updated_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="user-activity">
            <h3>Recent Activity</h3>
            
            <div class="activity-tabs">
                <div class="tab-nav">
                    <button class="tab-btn active" data-tab="orders">Orders</button>
                    <button class="tab-btn" data-tab="reviews">Reviews</button>
                    <button class="tab-btn" data-tab="favorites">Favorites</button>
                </div>
                
                <div class="tab-content">
                    <div class="tab-pane active" id="orders">
                        <div class="empty-state">
                            <i class="bi bi-cart3"></i>
                            <p>No orders yet.</p>
                        </div>
                    </div>
                    
                    <div class="tab-pane" id="reviews">
                        <div class="empty-state">
                            <i class="bi bi-star"></i>
                            <p>No reviews yet.</p>
                        </div>
                    </div>
                    
                    <div class="tab-pane" id="favorites">
                        <div class="empty-state">
                            <i class="bi bi-heart"></i>
                            <p>No favorites yet.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .user-details-container {
        width: 100%;
        max-width: 1000px;
        margin: 0 auto;
    }
    
    .card-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        background-color: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        font-size: 1.25rem;
        font-weight: 600;
    }
    
    .actions {
        display: flex;
        gap: 10px;
    }
    
    .btn-secondary {
        background-color: #6c757d;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 8px 16px;
        font-weight: 500;
        display: flex;
        align-items: center;
        text-decoration: none;
    }
    
    .btn-primary {
        background-color: var(--primary);
        color: white;
        border: none;
        border-radius: 4px;
        padding: 8px 16px;
        font-weight: 500;
        display: flex;
        align-items: center;
        text-decoration: none;
    }
    
    .btn-secondary i, .btn-primary i {
        margin-right: 5px;
    }
    
    .user-profile {
        padding: 30px;
        border-bottom: 1px solid #e9ecef;
    }
    
    .row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -15px;
    }
    
    .col-md-4 {
        width: 33.3333%;
        padding: 0 15px;
    }
    
    .col-md-8 {
        width: 66.6667%;
        padding: 0 15px;
    }
    
    @media (max-width: 768px) {
        .col-md-4, .col-md-8 {
            width: 100%;
            margin-bottom: 20px;
        }
    }
    
    .profile-image {
        width: 100%;
        height: 0;
        padding-bottom: 100%;
        border-radius: 8px;
        overflow: hidden;
        position: relative;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    
    .profile-image img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .profile-info {
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .user-name {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 10px;
    }
    
    .role-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 20px;
    }
    
    .role-badge.admin {
        background-color: #dc3545;
        color: white;
    }
    
    .role-badge.user {
        background-color: #17a2b8;
        color: white;
    }
    
    .user-meta {
        margin-top: 20px;
    }
    
    .meta-item {
        margin-bottom: 15px;
    }
    
    .meta-label {
        font-weight: 600;
        margin-right: 10px;
        min-width: 120px;
        display: inline-block;
    }
    
    .user-activity {
        padding: 30px;
    }
    
    .user-activity h3 {
        margin-bottom: 20px;
        font-size: 1.5rem;
        font-weight: 600;
    }
    
    .activity-tabs {
        border: 1px solid #e9ecef;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .tab-nav {
        display: flex;
        background-color: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
    }
    
    .tab-btn {
        padding: 15px 20px;
        background: none;
        border: none;
        border-right: 1px solid #e9ecef;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .tab-btn:last-child {
        border-right: none;
    }
    
    .tab-btn.active {
        background-color: white;
        border-bottom: 2px solid var(--primary);
    }
    
    .tab-content {
        padding: 20px;
    }
    
    .tab-pane {
        display: none;
    }
    
    .tab-pane.active {
        display: block;
    }
    
    .empty-state {
        text-align: center;
        padding: 50px 20px;
        color: #6c757d;
    }
    
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 10px;
        display: block;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabBtns = document.querySelectorAll('.tab-btn');
        const tabPanes = document.querySelectorAll('.tab-pane');
        
        tabBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const tabId = this.getAttribute('data-tab');
                
                // Remove active class from all buttons
                tabBtns.forEach(b => b.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Hide all tab panes
                tabPanes.forEach(pane => pane.classList.remove('active'));
                
                // Show the selected tab pane
                document.getElementById(tabId).classList.add('active');
            });
        });
    });
</script>
@endpush 