@extends('layouts.admin')

@section('title', 'Add New Product')

@section('content')
<div class="products-container">
    <div class="card">
        <div class="card-title">
            Add New Product
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
        
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="product-form">
            @csrf
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="name">Product Name <span class="required">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                
                <div class="form-group col-md-6">
                    <label for="category_id">Category <span class="required">*</span></label>
                    <select name="category_id" id="category_id" class="form-control" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="price">Price <span class="required">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}" step="0.01" min="0" required>
                    </div>
                </div>
                
                <div class="form-group col-md-6">
                    <label for="sale_price">Sale Price (Optional)</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        <input type="number" name="sale_price" id="sale_price" class="form-control" value="{{ old('sale_price') }}" step="0.01" min="0">
                    </div>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="quantity">Quantity <span class="required">*</span></label>
                    <input type="number" name="quantity" id="quantity" class="form-control" value="{{ old('quantity', 1) }}" min="0" required>
                </div>
                
                <div class="form-group col-md-6">
                    <div class="checkbox-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="featured" id="featured" class="custom-control-input" {{ old('featured') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="featured">Featured Product</label>
                        </div>
                        
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="is_new" id="is_new" class="custom-control-input" {{ old('is_new') ? 'checked' : '' }} checked>
                            <label class="custom-control-label" for="is_new">New Product</label>
                        </div>
                        
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="on_sale" id="on_sale" class="custom-control-input" {{ old('on_sale') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="on_sale">On Sale</label>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="short_description">Short Description <span class="required">*</span></label>
                <textarea name="description" id="short_description" rows="4" class="form-control" required>{{ old('description') }}</textarea>
                <small class="form-text text-muted">A brief overview of the vehicle that will appear in product cards and listings.</small>
            </div>
            
            <div class="form-group">
                <label for="detailed_description">Detailed Information <span class="required">*</span></label>
                <textarea name="details" id="detailed_description" rows="8" class="form-control large-textarea">{{ old('details') }}</textarea>
                <small class="form-text text-muted">Full details about the vehicle including specifications, features, and other important information.</small>
            </div>
            
            <div class="form-group">
                <label>Main Product Image <span class="required">*</span></label>
                <input type="file" name="image" id="main-image" class="form-control-file" accept="image/*" required>
                <div id="main-image-preview" class="mt-2"></div>
            </div>
            
            <div class="form-group">
                <label>Additional Images</label>
                <input type="file" name="additional_images[]" id="additional-images" class="form-control-file" accept="image/*" multiple>
                <div id="additional-images-preview" class="image-preview-container"></div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary" id="save-product">
                    <i class="bi bi-check-circle"></i> Save Product
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
    
    .large-textarea {
        min-height: 200px;
        font-family: Arial, sans-serif;
    }
    
    .form-text {
        font-size: 12px;
        margin-top: 5px;
        display: block;
    }
    
    .form-control-file {
        display: block;
        width: 100%;
    }
    
    .required {
        color: #dc3545;
    }
    
    label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
    }
    
    .custom-control {
        margin-bottom: 10px;
    }
    
    .custom-control-label {
        cursor: pointer;
    }
    
    .checkbox-group {
        padding-top: 8px;
    }
    
    .input-group {
        display: flex;
    }
    
    .input-group-prepend,
    .input-group-append {
        display: flex;
    }
    
    .input-group-text {
        display: flex;
        align-items: center;
        padding: 10px 15px;
        font-size: 14px;
        background-color: #f8f9fa;
        border: 1px solid #eee;
    }
    
    .input-group-prepend .input-group-text {
        border-right: none;
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
    }
    
    .input-group-append .input-group-text {
        border-left: none;
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;
    }
    
    .input-group .form-control {
        flex: 1;
    }
    
    .input-group .form-control:not(:first-child) {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
    
    .input-group .form-control:not(:last-child) {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
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
    
    .image-preview-container {
        display: flex;
        flex-wrap: wrap;
        margin-top: 10px;
    }
    
    .image-preview {
        width: 100px;
        height: 100px;
        margin-right: 10px;
        margin-bottom: 10px;
        position: relative;
        border-radius: 5px;
        overflow: hidden;
    }
    
    .image-preview img {
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
    
    .mb-0 {
        margin-bottom: 0;
    }
    
    .mt-2 {
        margin-top: 10px;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Preview main image
        $('#main-image').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#main-image-preview').html(`
                        <div class="image-preview">
                            <img src="${e.target.result}" alt="Main Image Preview">
                        </div>
                    `);
                }
                reader.readAsDataURL(file);
            }
        });
        
        // Preview additional images
        $('#additional-images').change(function() {
            const files = this.files;
            $('#additional-images-preview').empty();
            
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    $('#additional-images-preview').append(`
                        <div class="image-preview">
                            <img src="${e.target.result}" alt="Additional Image Preview">
                        </div>
                    `);
                }
                
                reader.readAsDataURL(file);
            }
        });

        // Submit form
        $('#product-form').on('submit', function(e) {
            // Make sure the form is submitted
            return true;
        });
    });
</script>
@endpush
@endsection 