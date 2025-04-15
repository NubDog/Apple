@extends('layouts.admin')

@section('title', 'Phản hồi liên hệ')

@section('content')
<div class="container-fluid animate__animated animate__fadeIn">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="card contact-reply-card shadow-lg">
                <div class="card-header gradient-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title text-white mb-0">
                        <i class="bi bi-reply-fill me-2"></i>Phản hồi liên hệ #{{ $contact->id }}
                    </h4>
                    <div class="actions">
                        <a href="{{ route('admin.contacts.index') }}" class="btn btn-light btn-floating me-2 animate__animated animate__pulse animate__infinite animate__slower">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        <a href="{{ route('admin.contacts.show', $contact->id) }}" class="btn btn-info btn-floating">
                            <i class="bi bi-eye"></i>
                        </a>
                    </div>
                </div>
                
                <div class="card-body p-md-4">
                    @if(session('success'))
                    <div class="alert custom-alert-success animate__animated animate__fadeInDown">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert custom-alert-danger animate__animated animate__fadeInDown">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        {{ session('error') }}
                    </div>
                    @endif

                    <div class="customer-message-container animate__animated animate__fadeIn">
                        <h5 class="section-title">
                            <i class="bi bi-person-lines-fill me-2"></i>Thông tin người gửi
                        </h5>
                        
                        <div class="customer-info-card">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <div class="info-icon">
                                            <i class="bi bi-person-circle"></i>
                                        </div>
                                        <div class="info-content">
                                            <span class="label">Người gửi</span>
                                            <span class="value">{{ $contact->name }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="info-item">
                                        <div class="info-icon">
                                            <i class="bi bi-envelope"></i>
                                        </div>
                                        <div class="info-content">
                                            <span class="label">Email</span>
                                            <span class="value">{{ $contact->email }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="info-item">
                                        <div class="info-icon">
                                            <i class="bi bi-telephone"></i>
                                        </div>
                                        <div class="info-content">
                                            <span class="label">Số điện thoại</span>
                                            <span class="value">{{ $contact->phone ?? 'Không cung cấp' }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <div class="info-icon">
                                            <i class="bi bi-calendar-date"></i>
                                        </div>
                                        <div class="info-content">
                                            <span class="label">Ngày gửi</span>
                                            <span class="value">{{ $contact->created_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="info-item">
                                        <div class="info-icon">
                                            <i class="bi bi-check-circle"></i>
                                        </div>
                                        <div class="info-content">
                                            <span class="label">Trạng thái</span>
                                            <span class="value">
                                                <span class="status-badge {{ $contact->status ? 'replied' : 'not-replied' }}">
                                                    {{ $contact->status ? 'Đã phản hồi' : 'Chưa phản hồi' }}
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="info-item">
                                        <div class="info-icon">
                                            <i class="bi bi-tag"></i>
                                        </div>
                                        <div class="info-content">
                                            <span class="label">Chủ đề</span>
                                            <span class="value">{{ $contact->subject ?: 'Không có chủ đề' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h5 class="section-title">
                            <i class="bi bi-chat-left-text-fill me-2"></i>Tin nhắn từ khách hàng
                        </h5>
                        
                        <div class="customer-message-content">
                            <i class="message-quote-icon bi bi-quote"></i>
                            <div class="message-text">
                                {!! nl2br(e($contact->message)) !!}
                            </div>
                        </div>
                    </div>

                    <div class="reply-form-container animate__animated animate__fadeIn animate__delay-1s">
                        <h5 class="section-title">
                            <i class="bi bi-reply-fill me-2"></i>Phản hồi của bạn
                        </h5>
                        
                        <form action="{{ route('admin.contacts.send-reply', $contact->id) }}" method="POST" id="replyForm" class="reply-form">
                            @csrf
                            
                            <div class="floating-input-container mb-4 animate__animated animate__fadeInUp animate__delay-1s">
                                <div class="form-floating input-wrapper">
                                    <input type="text" class="form-control custom-input @error('subject') is-invalid @enderror" 
                                        id="subject" name="subject" placeholder="Chủ đề"
                                        value="{{ old('subject', 'Re: ' . ($contact->subject ?: 'Phản hồi liên hệ của bạn')) }}">
                                    <label for="subject">
                                        <i class="bi bi-tag me-2"></i>Chủ đề phản hồi
                                    </label>
                                </div>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-4 animate__animated animate__fadeInUp animate__delay-1s">
                                <label for="reply" class="form-label custom-label">
                                    <i class="bi bi-pencil-square me-2"></i>Nội dung phản hồi
                                </label>
                                <div class="textarea-wrapper">
                                    <textarea class="form-control custom-textarea @error('reply') is-invalid @enderror" 
                                        id="reply" name="reply" rows="6" placeholder="Nhập nội dung phản hồi tại đây...">{{ old('reply') }}</textarea>
                                    <div class="textarea-decoration top-left"></div>
                                    <div class="textarea-decoration top-right"></div>
                                    <div class="textarea-decoration bottom-left"></div>
                                    <div class="textarea-decoration bottom-right"></div>
                                </div>
                                @error('reply')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-check form-switch custom-switch mb-4 animate__animated animate__fadeInUp animate__delay-1s">
                                <input class="form-check-input" type="checkbox" role="switch" value="1" id="markAsReplied" name="mark_as_replied" checked>
                                <label class="form-check-label" for="markAsReplied">
                                    Đánh dấu liên hệ này là đã phản hồi
                                </label>
                            </div>
                            
                            <div class="d-flex justify-content-end mt-4 action-buttons animate__animated animate__fadeInUp animate__delay-2s">
                                <a href="{{ route('admin.contacts.show', $contact->id) }}" class="btn btn-light btn-lg me-3 hover-lift">
                                    <i class="bi bi-x-circle me-2"></i>Hủy bỏ
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg pulse-button glow-button" id="sendReplyBtn">
                                    <i class="bi bi-send me-2"></i>Gửi phản hồi
                                    <span class="btn-effect"></span>
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    /* Modern UI with animated effects, rounded corners, and elegant colors */
    :root {
        --primary-color: #4361ee;
        --primary-dark: #3a56d4;
        --secondary-color: #4cc9f0;
        --success-color: #40916c;
        --danger-color: #e63946;
        --warning-color: #ffb703;
        --dark-color: #2b2d42;
        --light-color: #f8f9fa;
        --gray-color: #adb5bd;
        --text-color: #2b2d42;
        --gradient-start: #4361ee;
        --gradient-end: #3a0ca3;
        --card-border-radius: 1.5rem;
        --element-border-radius: 1rem;
        --inner-element-radius: 0.8rem;
        --box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    
    /* Main Card */
    .contact-reply-card {
        border: none;
        border-radius: var(--card-border-radius);
        overflow: hidden;
        margin-bottom: 2rem;
        transition: all 0.3s ease;
        background-color: white;
    }
    
    .contact-reply-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }
    
    /* Gradient Header */
    .gradient-header {
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        padding: 1.5rem;
        border-bottom: none;
    }
    
    /* Floating Buttons */
    .btn-floating {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
    }
    
    .btn-floating:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }
    
    /* Custom Alerts */
    .custom-alert-success {
        background-color: rgba(64, 145, 108, 0.15);
        color: var(--success-color);
        border: none;
        border-radius: var(--element-border-radius);
        padding: 1rem;
        box-shadow: 0 4px 10px rgba(64, 145, 108, 0.1);
    }
    
    .custom-alert-danger {
        background-color: rgba(230, 57, 70, 0.15);
        color: var(--danger-color);
        border: none;
        border-radius: var(--element-border-radius);
        padding: 1rem;
        box-shadow: 0 4px 10px rgba(230, 57, 70, 0.1);
    }
    
    /* Section Titles */
    .section-title {
        margin-top: 2rem;
        margin-bottom: 1.5rem;
        padding-bottom: 0.8rem;
        border-bottom: 2px solid rgba(67, 97, 238, 0.2);
        font-weight: 600;
        color: var(--dark-color);
        position: relative;
        font-size: 1.25rem;
    }
    
    .section-title::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 100px;
        height: 2px;
        background: linear-gradient(to right, var(--gradient-start), var(--gradient-end));
    }
    
    /* Customer Info Card */
    .customer-info-card {
        background-color: rgba(248, 249, 250, 0.8);
        border-radius: var(--element-border-radius);
        padding: 1.5rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        transition: all 0.3s ease;
    }
    
    .customer-info-card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        transform: translateY(-3px);
    }
    
    /* Info Items */
    .info-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 1.2rem;
        padding: 0.8rem;
        background-color: white;
        border-radius: var(--inner-element-radius);
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.03);
        transition: all 0.3s ease;
    }
    
    .info-item:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .info-icon {
        flex-shrink: 0;
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-right: 1rem;
        font-size: 1.1rem;
    }
    
    .info-content {
        display: flex;
        flex-direction: column;
    }
    
    .info-content .label {
        font-size: 0.85rem;
        color: var(--gray-color);
        margin-bottom: 0.3rem;
    }
    
    .info-content .value {
        font-weight: 600;
        color: var(--text-color);
    }
    
    /* Status Badges */
    .status-badge {
        display: inline-block;
        padding: 0.4rem 1rem;
        border-radius: 30px;
        font-size: 0.8rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-badge.replied {
        background-color: rgba(64, 145, 108, 0.15);
        color: var(--success-color);
    }
    
    .status-badge.not-replied {
        background-color: rgba(230, 57, 70, 0.15);
        color: var(--danger-color);
    }
    
    /* Customer Message Content */
    .customer-message-content {
        background-color: white;
        border-radius: var(--element-border-radius);
        padding: 2rem;
        position: relative;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        border-left: 4px solid var(--primary-color);
        margin-bottom: 2rem;
        transition: all 0.3s ease;
    }
    
    .customer-message-content:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }
    
    .message-quote-icon {
        position: absolute;
        top: 1rem;
        right: 1rem;
        font-size: 2rem;
        color: rgba(67, 97, 238, 0.1);
    }
    
    .message-text {
        white-space: pre-line;
        color: var(--text-color);
        line-height: 1.7;
    }
    
    /* Reply Form Container */
    .reply-form-container {
        margin-top: 2rem;
        background-color: white;
        border-radius: var(--element-border-radius);
        padding: 2rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        border-top: 4px solid var(--primary-color);
        transition: all 0.3s ease;
    }
    
    .reply-form-container:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }
    
    /* Custom Form Elements */
    .custom-input, .custom-textarea {
        border: 2px solid rgba(173, 181, 189, 0.3);
        border-radius: var(--inner-element-radius);
        padding: 0.8rem 1rem;
        transition: all 0.3s ease;
    }
    
    .custom-input:focus, .custom-textarea:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.15);
    }
    
    .custom-label {
        font-weight: 500;
        color: var(--dark-color);
        margin-bottom: 0.8rem;
        display: inline-block;
        position: relative;
        padding-left: 0.5rem;
        border-left: 3px solid var(--primary-color);
        animation: labelPulse 2s infinite;
    }
    
    @keyframes labelPulse {
        0% { border-left-color: var(--primary-color); }
        50% { border-left-color: var(--secondary-color); }
        100% { border-left-color: var(--primary-color); }
    }
    
    .custom-textarea {
        resize: vertical;
        min-height: 150px;
        position: relative;
        z-index: 1;
        background-color: white;
    }
    
    /* Input and Textarea Wrappers */
    .input-wrapper, .textarea-wrapper {
        position: relative;
        border-radius: calc(var(--inner-element-radius) + 2px);
        overflow: hidden;
    }
    
    .input-wrapper::before, .textarea-wrapper::before {
        content: "";
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        z-index: -1;
        background: linear-gradient(45deg, 
            var(--primary-color), 
            var(--secondary-color), 
            #7209b7, 
            #3f37c9, 
            var(--primary-color));
        background-size: 400% 400%;
        border-radius: calc(var(--inner-element-radius) + 4px);
        animation: borderGradient 6s ease infinite;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .input-wrapper:hover::before, .textarea-wrapper:hover::before,
    .input-wrapper:focus-within::before, .textarea-wrapper:focus-within::before {
        opacity: 1;
    }
    
    @keyframes borderGradient {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    /* Textarea Decorations */
    .textarea-wrapper {
        position: relative;
        margin-bottom: 1rem;
    }
    
    .textarea-decoration {
        position: absolute;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        z-index: 2;
        transform: scale(0);
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .textarea-wrapper:hover .textarea-decoration,
    .textarea-wrapper:focus-within .textarea-decoration {
        transform: scale(1);
    }
    
    .top-left {
        top: -6px;
        left: -6px;
        transition-delay: 0s;
    }
    
    .top-right {
        top: -6px;
        right: -6px;
        transition-delay: 0.1s;
    }
    
    .bottom-left {
        bottom: -6px;
        left: -6px;
        transition-delay: 0.2s;
    }
    
    .bottom-right {
        bottom: -6px;
        right: -6px;
        transition-delay: 0.3s;
    }
    
    /* Form Floating */
    .floating-input-container .form-floating label {
        padding-left: 1rem;
        z-index: 3;
    }
    
    .floating-input-container .form-floating input {
        height: calc(3.5rem + 2px);
        padding: 1rem 0.75rem;
    }
    
    /* Custom Switch */
    .custom-switch {
        padding: 0.8rem 1.5rem;
        background-color: rgba(248, 249, 250, 0.8);
        border-radius: var(--inner-element-radius);
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.03);
        transition: all 0.3s ease;
        transform-origin: left;
    }
    
    .custom-switch:hover {
        transform: scale(1.03);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .custom-switch .form-check-input {
        width: 3rem;
        height: 1.5rem;
        margin-top: 0.25rem;
        background-color: rgba(173, 181, 189, 0.3);
        border: none;
        transition: all 0.3s cubic-bezier(0.68, -0.55, 0.27, 1.55);
    }
    
    .custom-switch .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
    
    .custom-switch .form-check-input:checked::before {
        transform: translateX(1.4rem);
    }
    
    .custom-switch .form-check-label {
        font-weight: 500;
        padding-left: 0.8rem;
        transition: all 0.3s ease;
    }
    
    .custom-switch:hover .form-check-label {
        color: var(--primary-color);
    }
    
    /* Action Buttons */
    .action-buttons {
        margin-top: 2rem;
    }
    
    .action-buttons .btn {
        padding: 0.75rem 1.5rem;
        border-radius: var(--inner-element-radius);
        font-weight: 600;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        overflow: hidden;
        position: relative;
        z-index: 1;
    }
    
    .action-buttons .btn-primary {
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        border: none;
        box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
    }
    
    .action-buttons .btn-primary:hover {
        box-shadow: 0 8px 25px rgba(67, 97, 238, 0.4);
        transform: translateY(-5px);
    }
    
    .action-buttons .btn-light {
        background-color: #f8f9fa;
        border: 1px solid rgba(0,0,0,0.1);
        color: var(--text-color);
    }
    
    .hover-lift:hover {
        transform: translateY(-5px) scale(1.03);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }
    
    /* Glow Button */
    .glow-button {
        position: relative;
        overflow: hidden;
    }
    
    .glow-button:hover {
        animation: glow 1.5s infinite alternate;
    }
    
    @keyframes glow {
        0% { box-shadow: 0 0 10px rgba(67, 97, 238, 0.5); }
        100% { box-shadow: 0 0 20px rgba(67, 97, 238, 0.8), 0 0 30px rgba(67, 97, 238, 0.5); }
    }
    
    .btn-effect {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        background: radial-gradient(circle, rgba(255,255,255,0.8) 0%, rgba(255,255,255,0) 70%);
        opacity: 0;
        transform: scale(0);
        transition: transform 0.5s, opacity 0.3s;
    }
    
    .glow-button:active .btn-effect {
        opacity: 0.6;
        transform: scale(2);
        transition: 0s;
    }
    
    /* Pulse Button Animation */
    .pulse-button {
        position: relative;
        overflow: hidden;
    }
    
    .pulse-button:after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 5px;
        height: 5px;
        background: rgba(255, 255, 255, 0.5);
        opacity: 0;
        border-radius: 100%;
        transform: scale(1, 1) translate(-50%);
        transform-origin: 50% 50%;
    }
    
    .pulse-button:hover:after {
        animation: pulse 2s ease-out infinite;
    }
    
    @keyframes pulse {
        0% {
            transform: scale(0.1, 0.1);
            opacity: 0;
        }
        50% {
            opacity: 1;
        }
        100% {
            transform: scale(10, 10);
            opacity: 0;
        }
    }
    
    /* Floating animation */
    @keyframes float {
        0% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
        100% { transform: translateY(0); }
    }
    
    /* Typing effect */
    .typing {
        border-color: var(--primary-color) !important;
        animation: typing 0.5s ease-in-out;
    }
    
    @keyframes typing {
        0% { box-shadow: 0 0 0 rgba(67, 97, 238, 0.4); }
        50% { box-shadow: 0 0 10px rgba(67, 97, 238, 0.6); }
        100% { box-shadow: 0 0 0 rgba(67, 97, 238, 0.4); }
    }
    
    /* Focus effect */
    .focused {
        transform: scale(1.02);
    }
    
    /* Error highlight effect */
    .error-highlight {
        border: 2px solid var(--danger-color) !important;
        box-shadow: 0 0 0 4px rgba(230, 57, 70, 0.15) !important;
        animation: shake 0.5s ease-in-out;
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
    
    /* Form sending animation */
    .form-sending {
        opacity: 0.8;
        transition: all 0.3s ease;
    }
    
    .sending {
        transform: scale(1.05);
        box-shadow: 0 10px 30px rgba(67, 97, 238, 0.5) !important;
    }
    
    /* Ripple effect */
    .ripple-effect {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.4);
        transform: scale(0);
        animation: ripple 0.6s linear;
        pointer-events: none;
    }
    
    @keyframes ripple {
        to {
            transform: scale(2.5);
            opacity: 0;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add animation to elements when they come into view
        const animateElements = () => {
            const elements = document.querySelectorAll('.info-item, .section-title');
            elements.forEach(element => {
                const position = element.getBoundingClientRect();
                // If the element is in the viewport
                if(position.top < window.innerHeight && position.bottom >= 0) {
                    if (!element.classList.contains('animate__animated')) {
                        element.classList.add('animate__animated', 'animate__fadeInUp');
                    }
                }
            });
        };
        
        // Run on scroll
        window.addEventListener('scroll', animateElements);
        // Run once on load
        animateElements();
        
        // Add ripple effect to buttons
        const buttons = document.querySelectorAll('.btn');
        buttons.forEach(button => {
            button.addEventListener('mousedown', function(e) {
                const x = e.clientX - this.getBoundingClientRect().left;
                const y = e.clientY - this.getBoundingClientRect().top;
                
                const ripple = document.createElement('span');
                ripple.className = 'ripple-effect';
                ripple.style.left = `${x}px`;
                ripple.style.top = `${y}px`;
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
        
        // Add floating effect to form elements
        const formElements = document.querySelectorAll('.textarea-wrapper, .input-wrapper, .custom-switch');
        
        const floatAnimation = () => {
            formElements.forEach((el, index) => {
                // Create a subtle floating animation for each element with different timing
                const delay = index * 0.2;
                el.style.animation = `float 3s ease-in-out ${delay}s infinite`;
            });
        };
        
        // Start floating animation after initial animations complete
        setTimeout(floatAnimation, 2000);
        
        // Form validation with enhanced animations
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
                
                // Add enhanced shake animation
                const textareaWrapper = document.querySelector('.textarea-wrapper');
                textareaWrapper.classList.add('animate__animated', 'animate__shakeX');
                
                // Add error highlight effect
                textareaWrapper.classList.add('error-highlight');
                
                // Remove animation class after animation ends
                textareaWrapper.addEventListener('animationend', () => {
                    textareaWrapper.classList.remove('animate__animated', 'animate__shakeX');
                    
                    // Keep highlighting for a bit longer then fade out
                    setTimeout(() => {
                        textareaWrapper.classList.remove('error-highlight');
                    }, 500);
                });
                
                replyTextarea.focus();
            } else {
                // Add button loading state with animation
                sendReplyBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Đang gửi...';
                sendReplyBtn.disabled = true;
                sendReplyBtn.classList.add('sending');
                
                // Add success animation to form
                replyForm.classList.add('form-sending');
            }
        });
        
        replyTextarea.addEventListener('input', function() {
            if (replyTextarea.value.trim()) {
                replyTextarea.classList.remove('is-invalid');
                document.querySelector('.textarea-wrapper').classList.remove('error-highlight');
            }
        });
        
        // Text area auto resize with animation
        replyTextarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
            
            // Add subtle typing animation to text area
            const textareaWrapper = document.querySelector('.textarea-wrapper');
            textareaWrapper.classList.add('typing');
            
            clearTimeout(textareaWrapper.typingTimeout);
            textareaWrapper.typingTimeout = setTimeout(() => {
                textareaWrapper.classList.remove('typing');
            }, 1000);
        });
        
        // Add focus animations
        const inputs = document.querySelectorAll('input, textarea');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.closest('.input-wrapper, .textarea-wrapper')?.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                this.closest('.input-wrapper, .textarea-wrapper')?.classList.remove('focused');
            });
        });
    });
</script>
@endpush
@endsection 