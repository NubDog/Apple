@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
<div class="products-container">
    <div class="card">
        <div class="card-title">
            Edit Product
            <div class="actions">
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Products
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
        
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="name">Product Name <span class="required">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                </div>
                
                <div class="form-group col-md-6">
                    <label for="category_id">Category <span class="required">*</span></label>
                    <select name="category_id" id="category_id" class="form-control" required>
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="price">Price <span class="required">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $product->price) }}" step="0.01" min="0" required>
                    </div>
                </div>
                
                <div class="form-group col-md-4">
                    <label for="sale_price">Sale Price</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        <input type="number" name="sale_price" id="sale_price" class="form-control" value="{{ old('sale_price', $product->sale_price) }}" step="0.01" min="0">
                    </div>
                    <small class="form-text text-muted">Leave blank if there is no sale price</small>
                </div>
                
                <div class="form-group col-md-4">
                    <label for="quantity">Quantity <span class="required">*</span></label>
                    <input type="number" name="quantity" id="quantity" class="form-control" value="{{ old('quantity', $product->quantity) }}" min="0" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="description">Description <span class="required">*</span></label>
                <textarea name="description" id="description" class="form-control" rows="5" required>{{ old('description', $product->description) }}</textarea>
            </div>
            
            <div class="form-group">
                <label for="details">Technical Details</label>
                <textarea name="details" id="details" class="form-control" rows="3">{{ old('details', $product->details) }}</textarea>
                <small class="form-text text-muted">Enter specifications, dimensions, etc.</small>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-4">
                    <div class="form-check">
                        <input type="checkbox" name="featured" id="featured" class="form-check-input" value="1" {{ old('featured', $product->featured) ? 'checked' : '' }}>
                        <label for="featured" class="form-check-label">Featured Product</label>
                    </div>
                </div>
                
                <div class="form-group col-md-4">
                    <div class="form-check">
                        <input type="checkbox" name="is_new" id="is_new" class="form-check-input" value="1" {{ old('is_new', $product->is_new) ? 'checked' : '' }}>
                        <label for="is_new" class="form-check-label">Mark as New</label>
                    </div>
                </div>
                
                <div class="form-group col-md-4">
                    <div class="form-check">
                        <input type="checkbox" name="on_sale" id="on_sale" class="form-check-input" value="1" {{ old('on_sale', $product->on_sale) ? 'checked' : '' }}>
                        <label for="on_sale" class="form-check-label">On Sale</label>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="image">Main Product Image</label>
                <div class="custom-file-upload">
                    <input type="file" name="image" id="image" class="file-input" accept="image/*">
                    <label for="image" class="file-label">
                        <span class="file-icon"><i class="bi bi-cloud-arrow-up"></i></span>
                        <span class="file-text">Choose a new image</span>
                    </label>
                </div>
                <small class="form-text text-muted">Maximum size: 2MB. Recommended aspect ratio: 1:1. Leave empty to keep the current image.</small>
                
                <div class="current-image">
                    <p>Current Image:</p>
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="current-img">
                    @else
                        <p class="text-muted">No image currently set</p>
                    @endif
                </div>
            </div>
            
            <div class="form-group">
                <label for="additional_images">Additional Images</label>
                <div class="custom-file-upload">
                    <input type="file" name="additional_images[]" id="additional_images" class="file-input" accept="image/*" multiple>
                    <label for="additional_images" class="file-label">
                        <span class="file-icon"><i class="bi bi-cloud-arrow-up"></i></span>
                        <span class="file-text">Choose new additional images</span>
                    </label>
                </div>
                <small class="form-text text-muted">You can select multiple images. Maximum size: 2MB per image. Uploading new images will replace all current additional images.</small>
                
                <div class="current-additional-images">
                    <p>Current Additional Images:</p>
                    <div class="additional-images-container">
                        @if($product->images && count(json_decode($product->images)) > 0)
                            @foreach(json_decode($product->images) as $image)
                                <div class="additional-image">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Additional image">
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">No additional images currently set</p>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Update Product
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-light">Cancel</a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    .products-container {
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
    
    .col-md-4 {
        width: 33.3333%;
        padding: 0 15px;
    }
    
    .col-md-6 {
        width: 50%;
        padding: 0 15px;
    }
    
    @media (max-width: 768px) {
        .col-md-4, .col-md-6 {
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
    
    .input-group {
        display: flex;
    }
    
    .input-group-prepend {
        display: flex;
    }
    
    .input-group-text {
        display: flex;
        align-items: center;
        padding: 10px 15px;
        background-color: #f8f9fa;
        border: 1px solid #eee;
        border-right: none;
        border-radius: 5px 0 0 5px;
    }
    
    .input-group .form-control {
        border-radius: 0 5px 5px 0;
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
    
    .form-check {
        display: flex;
        align-items: center;
        margin-bottom: 0;
    }
    
    .form-check-input {
        margin-right: 8px;
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
    
    .current-image, .current-additional-images {
        margin: 15px 0;
    }
    
    .current-image p, .current-additional-images p {
        margin-bottom: 10px;
        font-weight: 500;
    }
    
    .current-img {
        max-width: 200px;
        height: auto;
        border-radius: 5px;
        border: 1px solid #eee;
    }
    
    .additional-images-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .additional-image {
        width: 100px;
        height: 100px;
        border-radius: 5px;
        overflow: hidden;
        border: 1px solid #eee;
    }
    
    .additional-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
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
    $(document).ready(function() {
        // Main image preview
        $('#image').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('.current-img').attr('src', e.target.result);
                    $('.current-img').show();
                    $('.current-image .text-muted').hide();
                }
                reader.readAsDataURL(file);
                
                // Update label text
                $('.file-text').text(file.name);
            }
        });
        
        // Initialize select2 for category dropdown
        if ($.fn.select2) {
            $('#category_id').select2({
                placeholder: 'Select a category',
                allowClear: true
            });
        }
    });
</script>
@endpush
@endsection 