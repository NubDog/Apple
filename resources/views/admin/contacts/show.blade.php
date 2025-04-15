@extends('layouts.admin')

@section('title', 'Chi tiết liên hệ')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Chi tiết liên hệ #{{ $contact->id }}</h4>
                    <div class="actions">
                        <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Quay lại
                        </a>
                        <a href="{{ route('admin.contacts.reply', $contact->id) }}" class="btn btn-primary">
                            <i class="bi bi-reply"></i> Phản hồi
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                    
                    <div class="contact-info-container">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="contact-meta">
                                    <div class="meta-item">
                                        <span class="label">Người gửi:</span>
                                        <span class="value">{{ $contact->name }}</span>
                                    </div>
                                    <div class="meta-item">
                                        <span class="label">Email:</span>
                                        <span class="value">{{ $contact->email }}</span>
                                    </div>
                                    <div class="meta-item">
                                        <span class="label">Số điện thoại:</span>
                                        <span class="value">{{ $contact->phone ?? 'Không cung cấp' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="contact-meta">
                                    <div class="meta-item">
                                        <span class="label">Ngày gửi:</span>
                                        <span class="value">{{ $contact->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <div class="meta-item">
                                        <span class="label">Trạng thái:</span>
                                        <span class="value status-badge {{ $contact->status ? 'replied' : 'not-replied' }}">
                                            {{ $contact->status ? 'Đã phản hồi' : 'Chưa phản hồi' }}
                                        </span>
                                    </div>
                                    <div class="meta-item">
                                        <span class="label">Chủ đề:</span>
                                        <span class="value">{{ $contact->subject ?: 'Không có chủ đề' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="message-container">
                        <h5 class="section-title">Nội dung tin nhắn</h5>
                        <div class="message-content">
                            {!! nl2br(e($contact->message)) !!}
                        </div>
                    </div>
                    
                    @if($contact->status)
                    <div class="reply-history">
                        <h5 class="section-title">Lịch sử phản hồi</h5>
                        <div class="timeline">
                            @foreach($contact->replies ?? [] as $reply)
                            <div class="timeline-item">
                                <div class="timeline-icon">
                                    <i class="bi bi-reply-fill"></i>
                                </div>
                                <div class="timeline-content">
                                    <div class="timeline-header">
                                        <strong>{{ $reply->admin->name ?? 'Admin' }}</strong>
                                        <span class="date">{{ $reply->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <div class="timeline-body">
                                        {!! nl2br(e($reply->message)) !!}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <div class="actions-container mt-4">
                        <form method="POST" action="{{ route('admin.contacts.update-status', $contact->id) }}" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="{{ $contact->status ? '0' : '1' }}">
                            <button type="submit" class="btn {{ $contact->status ? 'btn-warning' : 'btn-success' }}">
                                <i class="bi {{ $contact->status ? 'bi-x-circle' : 'bi-check-circle' }}"></i>
                                {{ $contact->status ? 'Đánh dấu chưa phản hồi' : 'Đánh dấu đã phản hồi' }}
                            </button>
                        </form>
                        
                        <form method="POST" action="{{ route('admin.contacts.destroy', $contact->id) }}" class="d-inline delete-form" data-contact-id="{{ $contact->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $contact->id }})">
                                <i class="bi bi-trash"></i> Xóa liên hệ
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .actions {
        display: flex;
        gap: 10px;
    }
    
    .contact-info-container {
        background-color: #f8f9fa;
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .contact-meta {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    
    .meta-item {
        display: flex;
        align-items: flex-start;
    }
    
    .meta-item .label {
        min-width: 120px;
        font-weight: 600;
        color: #495057;
    }
    
    .status-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .status-badge.replied {
        background-color: #d4edda;
        color: #155724;
    }
    
    .status-badge.not-replied {
        background-color: #f8d7da;
        color: #721c24;
    }
    
    .section-title {
        margin-top: 25px;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #dee2e6;
        font-weight: 600;
    }
    
    .message-container {
        margin-bottom: 30px;
    }
    
    .message-content {
        background-color: white;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        padding: 20px;
        white-space: pre-line;
    }
    
    .reply-history {
        margin-bottom: 30px;
    }
    
    .timeline {
        position: relative;
        margin-left: 20px;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        left: 15px;
        width: 2px;
        background-color: #dee2e6;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 20px;
        padding-left: 40px;
    }
    
    .timeline-icon {
        position: absolute;
        left: 0;
        width: 32px;
        height: 32px;
        background-color: #6c757d;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        z-index: 1;
    }
    
    .timeline-content {
        background-color: white;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        padding: 15px;
    }
    
    .timeline-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        padding-bottom: 10px;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .timeline-header .date {
        font-size: 13px;
        color: #6c757d;
    }
    
    .timeline-body {
        white-space: pre-line;
    }
    
    .actions-container {
        display: flex;
        gap: 10px;
    }
    
    @media (max-width: 768px) {
        .meta-item {
            flex-direction: column;
            margin-bottom: 10px;
        }
        
        .meta-item .label {
            margin-bottom: 5px;
        }
        
        .actions-container {
            flex-direction: column;
            gap: 10px;
        }
        
        .actions-container form {
            width: 100%;
        }
        
        .actions-container button {
            width: 100%;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.confirmDelete = function(id) {
            if (confirm('Bạn có chắc chắn muốn xóa liên hệ này?')) {
                document.querySelector(`.delete-form[data-contact-id="${id}"]`).submit();
            }
        };
    });
</script>
@endpush
@endsection 