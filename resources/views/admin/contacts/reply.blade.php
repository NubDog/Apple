@extends('layouts.admin')

@section('title', 'Phản hồi liên hệ')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Phản hồi liên hệ #{{ $contact->id }}</h4>
                    <div class="actions">
                        <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Quay lại
                        </a>
                        <a href="{{ route('admin.contacts.show', $contact->id) }}" class="btn btn-info">
                            <i class="bi bi-eye"></i> Xem chi tiết
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    <div class="customer-message-container">
                        <h5 class="section-title">Thông tin người gửi</h5>
                        <div class="customer-message-info">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <span class="label">Người gửi:</span>
                                        <span class="value">{{ $contact->name }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="label">Email:</span>
                                        <span class="value">{{ $contact->email }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="label">Số điện thoại:</span>
                                        <span class="value">{{ $contact->phone ?? 'Không cung cấp' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <span class="label">Ngày gửi:</span>
                                        <span class="value">{{ $contact->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="label">Trạng thái:</span>
                                        <span class="value status-badge {{ $contact->status ? 'replied' : 'not-replied' }}">
                                            {{ $contact->status ? 'Đã phản hồi' : 'Chưa phản hồi' }}
                                        </span>
                                    </div>
                                    <div class="info-item">
                                        <span class="label">Chủ đề:</span>
                                        <span class="value">{{ $contact->subject ?: 'Không có chủ đề' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h5 class="section-title">Tin nhắn từ khách hàng</h5>
                        <div class="customer-message-content">
                            {!! nl2br(e($contact->message)) !!}
                        </div>
                    </div>

                    <div class="reply-form-container">
                        <h5 class="section-title">Phản hồi của bạn</h5>
                        <form action="{{ route('admin.contacts.send-reply', $contact->id) }}" method="POST" id="replyForm">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="subject" class="form-label">Chủ đề phản hồi</label>
                                <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                                    id="subject" name="subject" 
                                    value="{{ old('subject', 'Re: ' . ($contact->subject ?: 'Phản hồi liên hệ của bạn')) }}">
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="reply" class="form-label">Nội dung phản hồi</label>
                                <textarea class="form-control @error('reply') is-invalid @enderror" 
                                    id="reply" name="reply" rows="6">{{ old('reply') }}</textarea>
                                @error('reply')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" value="1" id="markAsReplied" name="mark_as_replied" checked>
                                <label class="form-check-label" for="markAsReplied">
                                    Đánh dấu liên hệ này là đã phản hồi
                                </label>
                            </div>
                            
                            <div class="d-flex justify-content-end mt-4">
                                <a href="{{ route('admin.contacts.show', $contact->id) }}" class="btn btn-secondary me-2">
                                    Hủy bỏ
                                </a>
                                <button type="submit" class="btn btn-primary" id="sendReplyBtn">
                                    <i class="bi bi-send"></i> Gửi phản hồi
                                </button>
                            </div>
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
    
    .section-title {
        margin-top: 25px;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #dee2e6;
        font-weight: 600;
    }
    
    .customer-message-container {
        margin-bottom: 30px;
    }
    
    .customer-message-info {
        background-color: #f8f9fa;
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .info-item {
        margin-bottom: 10px;
    }
    
    .info-item .label {
        font-weight: 600;
        color: #495057;
        min-width: 120px;
        display: inline-block;
    }
    
    .customer-message-content {
        background-color: white;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        padding: 20px;
        white-space: pre-line;
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
    
    .reply-form-container {
        margin-top: 30px;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const replyForm = document.getElementById('replyForm');
        const replyTextarea = document.getElementById('reply');
        const sendReplyBtn = document.getElementById('sendReplyBtn');
        
        replyForm.addEventListener('submit', function(e) {
            if (!replyTextarea.value.trim()) {
                e.preventDefault();
                replyTextarea.classList.add('is-invalid');
                
                // Add error message if it doesn't exist
                if (!document.querySelector('.invalid-feedback')) {
                    const invalidFeedback = document.createElement('div');
                    invalidFeedback.classList.add('invalid-feedback');
                    invalidFeedback.textContent = 'Vui lòng nhập nội dung phản hồi';
                    replyTextarea.parentNode.appendChild(invalidFeedback);
                }
                
                replyTextarea.focus();
            }
        });
        
        replyTextarea.addEventListener('input', function() {
            if (replyTextarea.value.trim()) {
                replyTextarea.classList.remove('is-invalid');
            }
        });
    });
</script>
@endpush
@endsection 