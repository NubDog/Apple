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
        
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="name">Product Name <span class="required">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                
                <div class="form-group col-md-6">
                    <label for="sku">SKU <span class="required">*</span></label>
                    <input type="text" name="sku" id="sku" class="form-control" value="{{ old('sku') }}" required>
                </div>
            </div>
            
            <div class="form-row">
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
                
                <div class="form-group col-md-6">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status', 1) == 0 ? 'selected' : '' }}>Inactive</option>
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
                    <label for="old_price">Old Price (Optional)</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        <input type="number" name="old_price" id="old_price" class="form-control" value="{{ old('old_price') }}" step="0.01" min="0">
                    </div>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="quantity">Quantity <span class="required">*</span></label>
                    <input type="number" name="quantity" id="quantity" class="form-control" value="{{ old('quantity') }}" min="0" required>
                </div>
                
                <div class="form-group col-md-6">
                    <label for="year">Year</label>
                    <input type="number" name="year" id="year" class="form-control" value="{{ old('year') }}" min="1900" max="{{ date('Y') + 1 }}">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="mileage">Mileage</label>
                    <div class="input-group">
                        <input type="number" name="mileage" id="mileage" class="form-control" value="{{ old('mileage') }}" min="0">
                        <div class="input-group-append">
                            <span class="input-group-text">km</span>
                        </div>
                    </div>
                </div>
                
                <div class="form-group col-md-6">
                    <label for="transmission">Transmission</label>
                    <select name="transmission" id="transmission" class="form-control">
                        <option value="">Select Transmission</option>
                        <option value="automatic" {{ old('transmission') == 'automatic' ? 'selected' : '' }}>Automatic</option>
                        <option value="manual" {{ old('transmission') == 'manual' ? 'selected' : '' }}>Manual</option>
                        <option value="semi-automatic" {{ old('transmission') == 'semi-automatic' ? 'selected' : '' }}>Semi-Automatic</option>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="fuel_type">Fuel Type</label>
                    <select name="fuel_type" id="fuel_type" class="form-control">
                        <option value="">Select Fuel Type</option>
                        <option value="petrol" {{ old('fuel_type') == 'petrol' ? 'selected' : '' }}>Petrol</option>
                        <option value="diesel" {{ old('fuel_type') == 'diesel' ? 'selected' : '' }}>Diesel</option>
                        <option value="electric" {{ old('fuel_type') == 'electric' ? 'selected' : '' }}>Electric</option>
                        <option value="hybrid" {{ old('fuel_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                    </select>
                </div>
                
                <div class="form-group col-md-6">
                    <label for="engine_size">Engine Size</label>
                    <div class="input-group">
                        <input type="number" name="engine_size" id="engine_size" class="form-control" value="{{ old('engine_size') }}" step="0.1" min="0">
                        <div class="input-group-append">
                            <span class="input-group-text">L</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="short_description">Short Description <span class="required">*</span></label>
                <textarea name="short_description" id="short_description" rows="3" class="form-control" required>{{ old('short_description') }}</textarea>
            </div>
            
            <div class="form-group">
                <label for="description">Full Description <span class="required">*</span></label>
                <textarea name="description" id="description" rows="6" class="form-control" required>{{ old('description') }}</textarea>
            </div>
            
            <div class="form-group">
                <label>Product Images <span class="required">*</span></label>
                <div class="dropzone-container">
                    <div id="product-images-dropzone" class="dropzone"></div>
                    <div class="dropzone-message">Click or drag files to upload</div>
                </div>
                <div id="image-preview-container" class="image-preview-container"></div>
            </div>
            
            <div class="form-group">
                <label>Additional Features</label>
                <div class="features-container">
                    <div class="feature-row">
                        <div class="row">
                            <div class="col-md-5">
                                <input type="text" name="features[0][name]" class="form-control" placeholder="Feature name (e.g. Air Conditioning)">
                            </div>
                            <div class="col-md-5">
                                <input type="text" name="features[0][value]" class="form-control" placeholder="Feature value (e.g. Yes)">
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger remove-feature" disabled>
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" id="add-feature" class="btn btn-outline-primary mt-2">
                    <i class="bi bi-plus-circle"></i> Add Feature
                </button>
            </div>
            
            <div class="form-group">
                <label for="meta_title">Meta Title</label>
                <input type="text" name="meta_title" id="meta_title" class="form-control" value="{{ old('meta_title') }}">
            </div>
            
            <div class="form-group">
                <label for="meta_description">Meta Description</label>
                <textarea name="meta_description" id="meta_description" rows="2" class="form-control">{{ old('meta_description') }}</textarea>
            </div>
            
            <div class="form-group">
                <label for="meta_keywords">Meta Keywords</label>
                <input type="text" name="meta_keywords" id="meta_keywords" class="form-control" value="{{ old('meta_keywords') }}" placeholder="Separate keywords with commas">
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Save Product
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-light">Cancel</a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
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
    
    .required {
        color: #dc3545;
    }
    
    label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
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
    
    .btn-danger {
        background-color: #dc3545;
        color: white;
        border: 1px solid #dc3545;
    }
    
    .btn-light {
        background-color: #f8f9fa;
        color: #212529;
        border: 1px solid #ddd;
    }
    
    .btn-outline-primary {
        background-color: transparent;
        color: var(--primary);
        border: 1px solid var(--primary);
    }
    
    .btn-outline-primary:hover {
        background-color: var(--primary);
        color: white;
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
    
    .dropzone-container {
        position: relative;
        min-height: 150px;
        border: 2px dashed #ddd;
        border-radius: 5px;
        background-color: #f8f9fa;
    }
    
    .dropzone {
        min-height: 150px;
        border: none !important;
        padding: 0 !important;
        background: transparent !important;
    }
    
    .dropzone .dz-message {
        margin: 0 !important;
    }
    
    .dropzone-message {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #666;
        text-align: center;
        pointer-events: none;
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
    
    .image-remove {
        position: absolute;
        top: 5px;
        right: 5px;
        width: 20px;
        height: 20px;
        background-color: rgba(220, 53, 69, 0.8);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        cursor: pointer;
    }
    
    .features-container {
        margin-bottom: 10px;
    }
    
    .feature-row {
        margin-bottom: 10px;
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
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    // Initialize TinyMCE
    tinymce.init({
        selector: '#description',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });
    
    // Initialize Dropzone
    Dropzone.autoDiscover = false;
    
    $(document).ready(function() {
        // Product Images Dropzone
        const productDropzone = new Dropzone("#product-images-dropzone", {
            url: "{{ route('admin.products.upload-image') }}",
            paramName: "image",
            maxFilesize: 5, // MB
            maxFiles: 5,
            acceptedFiles: "image/*",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            addRemoveLinks: true,
            success: function(file, response) {
                // Create hidden input with the uploaded image path
                const input = document.createElement('input');
                input.setAttribute('type', 'hidden');
                input.setAttribute('name', 'images[]');
                input.setAttribute('value', response.path);
                file.previewElement.appendChild(input);
                
                // Store the path in the file object for later use
                file.path = response.path;
            }
        });
        
        // Add Feature button
        let featureIndex = 1;
        
        $('#add-feature').on('click', function() {
            const newFeature = `
                <div class="feature-row">
                    <div class="row">
                        <div class="col-md-5">
                            <input type="text" name="features[${featureIndex}][name]" class="form-control" placeholder="Feature name (e.g. Air Conditioning)">
                        </div>
                        <div class="col-md-5">
                            <input type="text" name="features[${featureIndex}][value]" class="form-control" placeholder="Feature value (e.g. Yes)">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger remove-feature">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            $('.features-container').append(newFeature);
            featureIndex++;
            
            // Enable the first remove button if we have more than one feature
            if ($('.feature-row').length > 1) {
                $('.remove-feature').prop('disabled', false);
            }
        });
        
        // Remove Feature button
        $(document).on('click', '.remove-feature', function() {
            $(this).closest('.feature-row').remove();
            
            // Disable the last remove button if we have only one feature
            if ($('.feature-row').length === 1) {
                $('.remove-feature').prop('disabled', true);
            }
        });
    });
</script>
@endpush
@endsection 