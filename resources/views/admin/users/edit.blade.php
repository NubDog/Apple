@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="admin-container">
    <div class="dashboard-header">
        <div class="breadcrumb">
            <span>Dashboard</span> <i class="bi bi-chevron-right"></i> <span>Users</span> <i class="bi bi-chevron-right"></i> <span>Edit User</span>
        </div>
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

    <div class="edit-user-container">
        <div class="card">
            <div class="card-title">
                Edit User: {{ $user->name }}
                <div class="actions">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back to Users
                    </a>
                </div>
            </div>
            
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="profile_image">Profile Image</label>
                        <div class="image-upload-container">
                            @if($user->profile_image)
                                <div class="current-image">
                                    <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}" class="preview-image">
                                </div>
                            @endif
                            <input type="file" name="profile_image" id="profile_image" class="form-control-file" accept="image/*">
                            <div class="image-preview" id="imagePreview"></div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password (leave blank to keep current)</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                    </div>
                    
                    <div class="form-check">
                        <input type="checkbox" name="is_admin" id="is_admin" class="form-check-input" value="1" {{ $user->isAdmin() ? 'checked' : '' }}>
                        <label for="is_admin" class="form-check-label">Administrator</label>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .admin-container {
        display: flex;
        flex-direction: column;
        width: 100%;
        min-height: 100vh;
        position: relative;
        z-index: 10;
    }
    
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 24px;
        background-color: #fff;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
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

    .edit-user-container {
        width: 100%;
        max-width: 800px;
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
    
    .btn-secondary i {
        margin-right: 5px;
    }
    
    .card-body {
        padding: 20px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
    }
    
    .form-control {
        width: 100%;
        padding: 10px 15px;
        border-radius: 4px;
        border: 1px solid #ced4da;
        font-size: 14px;
    }
    
    .form-check {
        margin: 20px 0;
    }
    
    .form-check-input {
        margin-right: 8px;
    }
    
    .form-actions {
        margin-top: 30px;
    }
    
    .btn-primary {
        background-color: var(--primary);
        color: white;
        border: none;
        border-radius: 4px;
        padding: 10px 20px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
    }
    
    .btn-primary i {
        margin-right: 5px;
    }
    
    .alert {
        padding: 15px 20px;
        margin-bottom: 20px;
        border-radius: 4px;
    }
    
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    
    .image-upload-container {
        margin-bottom: 15px;
    }
    
    .current-image {
        margin-bottom: 10px;
    }
    
    .preview-image {
        max-width: 150px;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    .image-preview {
        margin-top: 10px;
        max-width: 150px;
    }
    
    .image-preview img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('profile_image');
        const imagePreview = document.getElementById('imagePreview');
        
        imageInput.addEventListener('change', function() {
            imagePreview.innerHTML = '';
            
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = 'Preview';
                    imagePreview.appendChild(img);
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>
@endpush 