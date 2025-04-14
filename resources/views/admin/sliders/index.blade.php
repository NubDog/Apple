@extends('layouts.admin')

@section('title', 'Sliders')

@section('content')
<div class="sliders-container">
    <div class="card">
        <div class="card-title">
            Sliders Management
            <div class="actions">
                <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add New Slider
                </a>
            </div>
        </div>
        
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-title">Total Sliders</div>
                <div class="stat-value">{{ $sliders->count() }}</div>
                <div class="stat-description">Currently active on your homepage</div>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table sliders-table">
                <thead>
                    <tr>
                        <th width="80">#</th>
                        <th width="150">Image</th>
                        <th>Title</th>
                        <th>Subtitle</th>
                        <th>Link</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sliders as $slider)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="slider-image">
                                <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}">
                            </div>
                        </td>
                        <td>{{ $slider->title }}</td>
                        <td>{{ $slider->subtitle }}</td>
                        <td>
                            <a href="{{ $slider->link }}" target="_blank" class="link-url">
                                {{ \Illuminate\Support\Str::limit($slider->link, 30) }}
                            </a>
                        </td>
                        <td>{{ $slider->order }}</td>
                        <td>
                            <div class="status-badge {{ $slider->status ? 'active' : 'inactive' }}">
                                {{ $slider->status ? 'Active' : 'Inactive' }}
                            </div>
                        </td>
                        <td>
                            <div class="actions-container">
                                <a href="{{ route('admin.sliders.edit', $slider->id) }}" class="btn-action edit" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.sliders.destroy', $slider->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action delete" title="Delete" onclick="return confirm('Are you sure you want to delete this slider?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No sliders found. <a href="{{ route('admin.sliders.create') }}">Create your first slider</a>.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('styles')
<style>
    .sliders-container {
        width: 100%;
    }
    
    .btn-primary {
        background-color: var(--primary);
        color: white;
        border: none;
        border-radius: 20px;
        padding: 8px 20px;
        font-weight: 500;
        display: flex;
        align-items: center;
        text-decoration: none;
    }
    
    .btn-primary i {
        margin-right: 5px;
    }
    
    .alert {
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    
    .alert-success {
        background-color: rgba(40, 167, 69, 0.1);
        border: 1px solid rgba(40, 167, 69, 0.2);
        color: #28a745;
    }
    
    .stats-container {
        display: flex;
        margin-bottom: 20px;
    }
    
    .stat-card {
        flex: 1;
        background-color: #f8f9fa;
        border-radius: var(--card-border-radius);
        padding: 20px;
    }
    
    .stat-title {
        font-size: 14px;
        color: #666;
        margin-bottom: 10px;
    }
    
    .stat-value {
        font-size: 32px;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 5px;
    }
    
    .stat-description {
        font-size: 14px;
        color: #999;
    }
    
    .sliders-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .sliders-table th {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #eee;
        font-weight: 600;
    }
    
    .sliders-table td {
        padding: 15px;
        border-bottom: 1px solid #eee;
        vertical-align: middle;
    }
    
    .slider-image {
        width: 120px;
        height: 60px;
        border-radius: 5px;
        overflow: hidden;
        background-color: #f8f9fa;
    }
    
    .slider-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .status-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .active {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }
    
    .inactive {
        background-color: rgba(108, 117, 125, 0.1);
        color: #6c757d;
    }
    
    .actions-container {
        display: flex;
        align-items: center;
    }
    
    .btn-action {
        width: 30px;
        height: 30px;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 5px;
        border: none;
        cursor: pointer;
        color: white;
    }
    
    .btn-action.edit {
        background-color: #7262fd;
    }
    
    .btn-action.delete {
        background-color: #dc3545;
    }
    
    .link-url {
        color: var(--primary);
        text-decoration: none;
    }
    
    .link-url:hover {
        text-decoration: underline;
    }
    
    .text-center {
        text-align: center;
    }
    
    .d-inline {
        display: inline;
    }
</style>
@endpush
@endsection 