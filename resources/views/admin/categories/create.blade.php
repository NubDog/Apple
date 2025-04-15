@extends('layouts.admin')

@section('title', 'Create Category')

@section('content')
<div class="admin-container">
    <div class="categories-dashboard">
        <!-- Header Section -->
        <div class="dashboard-header">
            <div class="breadcrumb">
                <span>Dashboard</span> <i class="bi bi-chevron-right"></i> 
                <span>Categories</span> <i class="bi bi-chevron-right"></i> 
                <span>Create</span>
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

        <!-- Create Category Form -->
        <div class="section-container">
            <div class="section-header">
                <h2 class="section-title">Create New Category</h2>
                <div class="section-actions">
                    <a href="{{ route('admin.categories.index') }}" class="btn-back">
                        <i class="bi bi-arrow-left"></i> Back to Categories
                    </a>
                </div>
            </div>
            
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="category-form">
                @csrf
                
                <div class="form-grid">
                    <div class="form-column">
                        <div class="form-group">
                            <label for="name">Category Name <span class="required">*</span></label>
                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="5">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label>Generated Slug</label>
                            <div class="slug-preview">
                                <span id="slug-preview">category-slug</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-column">
                        <div class="form-group">
                            <label for="image">Category Image</label>
                            <div class="image-upload-container">
                                <div class="image-preview" id="imagePreview">
                                    <img src="{{ asset('images/upload-placeholder.jpg') }}" alt="Image Preview" id="preview-image">
                                    <div class="upload-text">
                                        <i class="bi bi-cloud-arrow-up"></i>
                                        <span>Click or drag to upload image</span>
                                    </div>
                                </div>
                                <input type="file" id="image" name="image" class="image-upload @error('image') is-invalid @enderror" accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="upload-hint">Recommended size: 800x600px. Max 2MB. Formats: JPG, PNG, GIF.</div>
                        </div>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="reset" class="btn-secondary">Reset</button>
                    <button type="submit" class="btn-primary">
                        <i class="bi bi-check-lg"></i> Create Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Admin Container */
    .admin-container {
        display: flex;
        width: 100%;
        min-height: 100vh;
        position: relative;
        z-index: 10;
    }
    
    /* Main layout */
    .categories-dashboard {
        width: 100%;
        padding: 20px;
        background-color: #f8f9fa;
        overflow-x: hidden;
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
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    /* Section Header */
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    
    .section-title {
        font-size: 20px;
        font-weight: 600;
        color: #212529;
        margin: 0;
    }
    
    .btn-back {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #4361ee;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
    }
    
    .btn-back:hover {
        text-decoration: underline;
    }
    
    /* Form Styles */
    .category-form {
        width: 100%;
    }
    
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin-bottom: 24px;
    }
    
    .form-column {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    
    .form-group {
        margin-bottom: 10px;
    }
    
    label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #212529;
    }
    
    .required {
        color: #dc3545;
    }
    
    .form-control {
        width: 100%;
        padding: 12px 16px;
        font-size: 14px;
        border: 1px solid #ced4da;
        border-radius: 8px;
        transition: all 0.3s;
    }
    
    .form-control:focus {
        border-color: #4361ee;
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        outline: none;
    }
    
    textarea.form-control {
        resize: vertical;
        min-height: 120px;
    }
    
    .is-invalid {
        border-color: #dc3545;
    }
    
    .invalid-feedback {
        color: #dc3545;
        font-size: 13px;
        margin-top: 6px;
    }
    
    /* Image Upload */
    .image-upload-container {
        position: relative;
        margin-bottom: 8px;
    }
    
    .image-preview {
        width: 100%;
        height: 250px;
        border: 2px dashed #ced4da;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        transition: all 0.3s;
    }
    
    .image-preview:hover {
        border-color: #4361ee;
    }
    
    .image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute;
        top: 0;
        left: 0;
        z-index: 1;
        display: none;
    }
    
    .upload-text {
        display: flex;
        flex-direction: column;
        align-items: center;
        color: #6c757d;
        z-index: 2;
    }
    
    .upload-text i {
        font-size: 32px;
        margin-bottom: 12px;
    }
    
    .image-upload {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
        z-index: 3;
    }
    
    .upload-hint {
        font-size: 12px;
        color: #6c757d;
        margin-top: 8px;
    }
    
    /* Slug Preview */
    .slug-preview {
        padding: 12px 16px;
        background-color: #f8f9fa;
        border-radius: 8px;
        border: 1px solid #ced4da;
        color: #6c757d;
        font-family: monospace;
        font-size: 14px;
    }
    
    /* Form Actions */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        padding-top: 16px;
        border-top: 1px solid #e9ecef;
    }
    
    .btn-primary, .btn-secondary {
        padding: 12px 24px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.3s;
        border: none;
    }
    
    .btn-primary {
        background-color: #4361ee;
        color: white;
    }
    
    .btn-primary:hover {
        background-color: #3a56d4;
    }
    
    .btn-secondary {
        background-color: #f8f9fa;
        color: #495057;
        border: 1px solid #ced4da;
    }
    
    .btn-secondary:hover {
        background-color: #e9ecef;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .btn-primary, .btn-secondary {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.getElementById('name');
        const slugPreview = document.getElementById('slug-preview');
        const imageInput = document.getElementById('image');
        const previewImage = document.getElementById('preview-image');
        const imagePreview = document.getElementById('imagePreview');
        const uploadText = document.querySelector('.upload-text');
        
        // Generate slug from name
        nameInput.addEventListener('input', function() {
            const name = this.value.trim();
            if (name) {
                // Simple slug generation
                const slug = name
                    .toLowerCase()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/[\s_-]+/g, '-')
                    .replace(/^-+|-+$/g, '');
                
                slugPreview.textContent = slug;
            } else {
                slugPreview.textContent = 'category-slug';
            }
        });
        
        // Image preview
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'block';
                    uploadText.style.display = 'none';
                }
                
                reader.readAsDataURL(file);
            } else {
                previewImage.style.display = 'none';
                uploadText.style.display = 'flex';
            }
        });
        
        // Drag and drop for image upload
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            imagePreview.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            imagePreview.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            imagePreview.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight() {
            imagePreview.style.borderColor = '#4361ee';
            imagePreview.style.backgroundColor = 'rgba(67, 97, 238, 0.05)';
        }
        
        function unhighlight() {
            imagePreview.style.borderColor = '#ced4da';
            imagePreview.style.backgroundColor = '';
        }
        
        imagePreview.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            if (files.length) {
                imageInput.files = files;
                const event = new Event('change');
                imageInput.dispatchEvent(event);
            }
        }
    });
</script>
@endpush 