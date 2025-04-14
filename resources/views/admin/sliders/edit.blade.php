@extends('layouts.admin')

@section('title', 'Edit Slider')

@section('content')
<div class="sliders-container">
    <div class="card">
        <div class="card-title">
            Edit Slider
            <div class="actions">
                <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Sliders
                </a>
            </div>
        </div>
        
        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        
        <form action="{{ route('admin.sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="title">Title <span class="required">*</span></label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $slider->title) }}" required>
                </div>
                
                <div class="form-group col-md-6">
                    <label for="subtitle">Subtitle</label>
                    <input type="text" name="subtitle" id="subtitle" class="form-control" value="{{ old('subtitle', $slider->subtitle) }}">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="link">Button Link</label>
                    <input type="url" name="link" id="link" class="form-control" value="{{ old('link', $slider->link) }}" placeholder="https://example.com">
                    <small class="form-text text-muted">URL where users will be directed when they click the button</small>
                </div>
                
                <div class="form-group col-md-6">
                    <label for="link_text">Button Text</label>
                    <input type="text" name="link_text" id="link_text" class="form-control" value="{{ old('link_text', $slider->link_text) }}">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="1" {{ old('status', $slider->status) == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status', $slider->status) == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                
                <div class="form-group col-md-6">
                    <label for="order">Display Order</label>
                    <input type="number" name="order" id="order" class="form-control" value="{{ old('order', $slider->order) }}" min="0">
                    <small class="form-text text-muted">Lower numbers will display first</small>
                </div>
            </div>
            
            <div class="form-group">
                <label for="image">Slider Image</label>
                <div class="custom-file-upload">
                    <input type="file" name="image" id="image" class="file-input" accept="image/*">
                    <label for="image" class="file-label">
                        <span class="file-icon"><i class="bi bi-cloud-arrow-up"></i></span>
                        <span class="file-text">Choose a new image</span>
                    </label>
                </div>
                <small class="form-text text-muted">Recommended size: 1920x700 pixels. Maximum size: 2MB. Leave empty to keep the current image.</small>
                
                <div class="current-image">
                    <p>Current Image:</p>
                    @if($slider->image)
                        <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}" class="current-img" onerror="imageError(this)">
                        <p class="image-path">Path: {{ $slider->image }}</p>
                    @else
                        <p class="text-muted">No image currently set</p>
                    @endif
                </div>
                
                <div class="image-preview" id="imagePreview">
                    <img src="#" alt="Image Preview" class="preview-img">
                    <span class="preview-text">No new image selected</span>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Update Slider
                </button>
                <a href="{{ route('admin.sliders.index') }}" class="btn btn-light">Cancel</a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    .sliders-container {
        width: 100%;
    }
    
    .form-row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -15px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .col-md-6 {
        width: 50%;
        padding: 0 15px;
    }
    
    @media (max-width: 768px) {
        .col-md-6 {
            width: 100%;
        }
    }
    
    .form-control {
        display: block;
        width: 100%;
        padding: 10px 15px;
        font-size: 14px;
        border: 1px solid #eee;
        border-radius: 5px;
        background-color: #fff;
    }
    
    .form-control:focus {
        border-color: var(--primary);
        outline: none;
    }
    
    .form-text {
        display: block;
        margin-top: 5px;
        font-size: 12px;
    }
    
    .text-muted {
        color: #6c757d;
    }
    
    .required {
        color: #dc3545;
    }
    
    label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
    }
    
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 20px;
        font-size: 14px;
        font-weight: 500;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn i {
        margin-right: 5px;
    }
    
    .btn-primary {
        background-color: var(--primary);
        color: white;
        border: 1px solid var(--primary);
    }
    
    .btn-secondary {
        background-color: #6c757d;
        color: white;
        border: 1px solid #6c757d;
    }
    
    .btn-light {
        background-color: #f8f9fa;
        color: #212529;
        border: 1px solid #ddd;
    }
    
    .alert {
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    
    .alert-danger {
        background-color: rgba(220, 53, 69, 0.1);
        border: 1px solid rgba(220, 53, 69, 0.2);
        color: #dc3545;
    }
    
    .mb-0 {
        margin-bottom: 0;
    }
    
    .custom-file-upload {
        position: relative;
        display: block;
        width: 100%;
        margin-bottom: 10px;
    }
    
    .file-input {
        position: absolute;
        left: -9999px;
    }
    
    .file-label {
        display: flex;
        align-items: center;
        padding: 10px 15px;
        background-color: #f8f9fa;
        border: 1px dashed #ddd;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .file-label:hover {
        border-color: var(--primary);
    }
    
    .file-icon {
        margin-right: 10px;
        font-size: 18px;
        color: var(--primary);
    }
    
    .current-image {
        margin: 15px 0;
    }
    
    .current-image p {
        margin-bottom: 10px;
        font-weight: 500;
    }
    
    .current-img {
        max-width: 100%;
        height: auto;
        max-height: 200px;
        border-radius: 5px;
        border: 1px solid #eee;
    }
    
    .image-preview {
        margin-top: 15px;
        width: 100%;
        height: 200px;
        border: 1px solid #eee;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
    }
    
    .preview-img {
        display: none;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .preview-text {
        color: #999;
    }
    
    .form-actions {
        margin-top: 30px;
        display: flex;
        align-items: center;
    }
    
    .form-actions .btn {
        margin-right: 10px;
    }
</style>
@endpush

@push('scripts')
<script>
    function imageError(img) {
        console.error('Error loading image:', img.src);
        img.src = '{{ asset('images/no-image.jpg') }}';
        img.alt = 'Image not found';
        document.querySelector('.image-path').style.color = 'red';
        document.querySelector('.image-path').textContent += ' (Error loading image)';
    }

    $(document).ready(function() {
        // Image preview
        $('#image').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                
                $('.preview-text').hide();
                $('.preview-img').show();
                
                reader.onload = function(e) {
                    $('.preview-img').attr('src', e.target.result);
                }
                
                reader.readAsDataURL(file);
                
                // Update label text
                $('.file-text').text(file.name);
            } else {
                $('.preview-img').hide();
                $('.preview-text').show();
                $('.file-text').text('Choose a new image');
            }
        });
    });
</script>
@endpush
@endsection 