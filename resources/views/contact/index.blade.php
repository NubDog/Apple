@extends('layouts.main')

@section('title', 'Liên hệ với chúng tôi')

@section('content')
<div class="contact-page-wrapper">
    <!-- Hero Section -->
    <div class="contact-hero">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2s">
                    <div class="contact-hero-content">
                        <h1 class="contact-title">Liên hệ với chúng tôi</h1>
                        <p class="contact-subtitle">Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn. Hãy để lại tin nhắn và chúng tôi sẽ phản hồi sớm nhất có thể.</p>
                        <div class="contact-cta">
                            <a href="#contact-form" class="btn btn-primary btn-lg pulse-button">
                                <i class="fas fa-paper-plane me-2"></i> Gửi tin nhắn ngay
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 wow fadeInRight" data-wow-delay="0.4s">
                    <div class="contact-hero-image">
                        <img src="{{ asset('images/contact-illustration.svg') }}" alt="Liên hệ với chúng tôi" class="img-fluid floating-animation">
                    </div>
                </div>
            </div>
        </div>
        <div class="contact-hero-shape">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#ffffff" fill-opacity="1" d="M0,128L48,133.3C96,139,192,149,288,154.7C384,160,480,160,576,138.7C672,117,768,75,864,69.3C960,64,1056,96,1152,106.7C1248,117,1344,107,1392,101.3L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>
    </div>

    <!-- Contact Info Cards -->
    <div class="contact-info-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="contact-info-card">
                        <div class="icon-wrapper blue-gradient">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h3>Địa chỉ</h3>
                        <p>123 Đường ABC, Quận 1<br>TP. Hồ Chí Minh, Việt Nam</p>
                        <div class="card-hover-effect"></div>
                    </div>
                </div>
                <div class="col-md-4 wow fadeInUp" data-wow-delay="0.4s">
                    <div class="contact-info-card">
                        <div class="icon-wrapper purple-gradient">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <h3>Điện thoại</h3>
                        <p>Hotline: (028) 1234 5678<br>Hỗ trợ: 0987 654 321</p>
                        <div class="card-hover-effect"></div>
                    </div>
                </div>
                <div class="col-md-4 wow fadeInUp" data-wow-delay="0.6s">
                    <div class="contact-info-card">
                        <div class="icon-wrapper orange-gradient">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h3>Email</h3>
                        <p>info@yourwebsite.com<br>support@yourwebsite.com</p>
                        <div class="card-hover-effect"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Form Section -->
    <div class="contact-form-section" id="contact-form">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="contact-form-container wow fadeInUp" data-wow-delay="0.3s">
                        <div class="form-header text-center">
                            <h2>Gửi tin nhắn cho chúng tôi</h2>
                            <p>Điền thông tin và tin nhắn của bạn vào form dưới đây</p>
                            
                            @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show animated bounceIn">
                                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif
                            
                            @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show animated shake">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif
                        </div>
                        
                        <form action="{{ route('contact.store') }}" method="POST" id="contactForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Họ tên" required value="{{ old('name') }}">
                                        <label for="name"><i class="fas fa-user me-2"></i>Họ tên</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required value="{{ old('email') }}">
                                        <label for="email"><i class="fas fa-envelope me-2"></i>Email</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Số điện thoại" value="{{ old('phone') }}">
                                        <label for="phone"><i class="fas fa-phone me-2"></i>Số điện thoại</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Chủ đề" value="{{ old('subject') }}">
                                        <label for="subject"><i class="fas fa-heading me-2"></i>Chủ đề</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-floating mb-3">
                                <textarea class="form-control" id="message" name="message" placeholder="Tin nhắn" style="height: 150px" required>{{ old('message') }}</textarea>
                                <label for="message"><i class="fas fa-comment-alt me-2"></i>Tin nhắn</label>
                            </div>
                            
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary btn-lg send-message-btn">
                                    <span class="btn-text"><i class="fas fa-paper-plane me-2"></i>Gửi tin nhắn</span>
                                    <span class="btn-icon"><i class="fas fa-spinner fa-spin"></i></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Section -->
    <div class="map-section wow fadeInUp" data-wow-delay="0.2s">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="map-container">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.5177580205587!2d106.69892867589634!3d10.771941989387625!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f385570472f%3A0x1787491df0ed8d6a!2zUGjDtSBOZ3V54buFbiBIdeG7hywgQuG6v24gTmdow6ksIFF14bqtbiAxLCBUaMOgbmggcGjhu5EgSOG7kyBDaMOtIE1pbmgsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1682072699428!5m2!1svi!2s" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Social Media Section -->
    <div class="social-media-section">
        <div class="container">
            <div class="row text-center">
                <div class="col-12">
                    <h3 class="section-title wow fadeInUp">Kết nối với chúng tôi</h3>
                    <div class="social-icons">
                        <a href="#" class="social-icon facebook wow bounceIn" data-wow-delay="0.1s"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon twitter wow bounceIn" data-wow-delay="0.2s"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon instagram wow bounceIn" data-wow-delay="0.3s"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon linkedin wow bounceIn" data-wow-delay="0.4s"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="social-icon youtube wow bounceIn" data-wow-delay="0.5s"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Contact Page Styling */
    .contact-page-wrapper {
        overflow: hidden;
    }
    
    /* Hero Section */
    .contact-hero {
        background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);
        color: white;
        padding: 100px 0 180px;
        position: relative;
    }
    
    .contact-title {
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 20px;
        position: relative;
    }
    
    .contact-title::after {
        content: '';
        width: 80px;
        height: 4px;
        background: #ff6b6b;
        position: absolute;
        bottom: -15px;
        left: 0;
        border-radius: 2px;
    }
    
    .contact-subtitle {
        font-size: 1.2rem;
        margin-bottom: 30px;
        opacity: 0.9;
    }
    
    .contact-hero-image {
        position: relative;
    }
    
    .contact-hero-image::before {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        top: -50px;
        right: -100px;
        z-index: -1;
    }
    
    .contact-hero-shape {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        overflow: hidden;
        line-height: 0;
    }
    
    .pulse-button {
        box-shadow: 0 0 0 0 rgba(255, 107, 107, 0.7);
        animation: pulse 1.5s infinite;
    }
    
    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(255, 107, 107, 0.7);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(255, 107, 107, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(255, 107, 107, 0);
        }
    }
    
    /* Contact Info Cards */
    .contact-info-section {
        margin-top: -80px;
        position: relative;
        z-index: 10;
        margin-bottom: 50px;
    }
    
    .contact-info-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        padding: 30px 20px;
        text-align: center;
        margin-bottom: 30px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .contact-info-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    }
    
    .icon-wrapper {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        color: white;
        font-size: 30px;
    }
    
    .blue-gradient {
        background: linear-gradient(135deg, #1e9afe 0%, #60dfcd 100%);
    }
    
    .purple-gradient {
        background: linear-gradient(135deg, #cb3066 0%, #16bffd 100%);
    }
    
    .orange-gradient {
        background: linear-gradient(135deg, #ff7e5f 0%, #feb47b 100%);
    }
    
    .contact-info-card h3 {
        font-size: 1.5rem;
        margin-bottom: 15px;
        color: #333;
    }
    
    .contact-info-card p {
        color: #666;
        line-height: 1.6;
    }
    
    .card-hover-effect {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(79, 172, 254, 0.1) 0%, rgba(0, 242, 254, 0.1) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .contact-info-card:hover .card-hover-effect {
        opacity: 1;
    }
    
    /* Contact Form Section */
    .contact-form-section {
        padding: 70px 0;
        background-color: #f9fafc;
        position: relative;
    }
    
    .contact-form-section::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23e0e7ff' fill-opacity='0.4'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    
    .contact-form-container {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        padding: 50px;
        position: relative;
        z-index: 1;
    }
    
    .form-header {
        margin-bottom: 40px;
    }
    
    .form-header h2 {
        color: #333;
        font-weight: 700;
        position: relative;
        display: inline-block;
        margin-bottom: 15px;
    }
    
    .form-header h2::after {
        content: '';
        position: absolute;
        width: 50%;
        height: 3px;
        background: linear-gradient(to right, #ff6b6b, #ffb347);
        bottom: -10px;
        left: 25%;
    }
    
    .form-header p {
        color: #666;
    }
    
    .form-floating label {
        font-weight: 500;
    }
    
    .form-floating > .form-control:focus ~ label,
    .form-floating > .form-control:not(:placeholder-shown) ~ label {
        color: #4b6cb7;
        opacity: 0.8;
    }
    
    .form-control:focus {
        border-color: #4b6cb7;
        box-shadow: 0 0 0 0.25rem rgba(75, 108, 183, 0.25);
    }
    
    .send-message-btn {
        padding: 12px 30px;
        font-weight: 600;
        letter-spacing: 0.5px;
        background: linear-gradient(45deg, #4b6cb7 0%, #182848 100%);
        border: none;
        border-radius: 50px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        z-index: 1;
    }
    
    .send-message-btn::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 0%;
        height: 100%;
        background: linear-gradient(45deg, #ff6b6b 0%, #ffb347 100%);
        transition: all 0.5s ease;
        z-index: -1;
    }
    
    .send-message-btn:hover::before {
        width: 100%;
    }
    
    .send-message-btn:hover {
        box-shadow: 0 5px 15px rgba(255, 107, 107, 0.4);
    }
    
    .send-message-btn .btn-icon {
        display: none;
    }
    
    .send-message-btn.sending .btn-text {
        display: none;
    }
    
    .send-message-btn.sending .btn-icon {
        display: inline-block;
    }
    
    /* Map Section */
    .map-section {
        padding: 70px 0;
    }
    
    .map-container {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    .map-container iframe {
        width: 100%;
        display: block;
    }
    
    /* Social Media Section */
    .social-media-section {
        padding: 50px 0 70px;
    }
    
    .section-title {
        margin-bottom: 30px;
        position: relative;
        display: inline-block;
    }
    
    .section-title::after {
        content: '';
        position: absolute;
        width: 60px;
        height: 3px;
        background: linear-gradient(to right, #ff6b6b, #ffb347);
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
    }
    
    .social-icons {
        display: flex;
        justify-content: center;
        gap: 15px;
    }
    
    .social-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: white;
        font-size: 24px;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .social-icon:hover {
        transform: translateY(-10px);
    }
    
    .facebook {
        background: #3b5998;
    }
    
    .twitter {
        background: #1da1f2;
    }
    
    .instagram {
        background: linear-gradient(45deg, #405de6, #5851db, #833ab4, #c13584, #e1306c, #fd1d1d);
    }
    
    .linkedin {
        background: #0077b5;
    }
    
    .youtube {
        background: #ff0000;
    }
    
    /* Animations */
    .floating-animation {
        animation: floating 3s ease-in-out infinite;
    }
    
    @keyframes floating {
        0% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-20px);
        }
        100% {
            transform: translateY(0px);
        }
    }
    
    /* Responsive */
    @media (max-width: 991px) {
        .contact-title {
            font-size: 2.8rem;
        }
        
        .contact-form-container {
            padding: 40px 30px;
        }
    }
    
    @media (max-width: 767px) {
        .contact-hero {
            padding: 80px 0 160px;
            text-align: center;
        }
        
        .contact-title {
            font-size: 2.5rem;
        }
        
        .contact-title::after {
            left: 50%;
            transform: translateX(-50%);
        }
        
        .contact-hero-content {
            margin-bottom: 40px;
        }
        
        .social-icon {
            width: 50px;
            height: 50px;
            font-size: 20px;
        }
    }
    
    /* Loading Animation for Form Submission */
    @keyframes shake {
        0%, 100% {transform: translateX(0);}
        10%, 30%, 50%, 70%, 90% {transform: translateX(-10px);}
        20%, 40%, 60%, 80% {transform: translateX(10px);}
    }
    
    @keyframes bounceIn {
        0%, 20%, 40%, 60%, 80%, 100% {
            transition-timing-function: cubic-bezier(0.215, 0.610, 0.355, 1.000);
        }
        0% {
            opacity: 0;
            transform: scale3d(.3, .3, .3);
        }
        20% {
            transform: scale3d(1.1, 1.1, 1.1);
        }
        40% {
            transform: scale3d(.9, .9, .9);
        }
        60% {
            opacity: 1;
            transform: scale3d(1.03, 1.03, 1.03);
        }
        80% {
            transform: scale3d(.97, .97, .97);
        }
        100% {
            opacity: 1;
            transform: scale3d(1, 1, 1);
        }
    }
    
    .animated {
        animation-duration: 1s;
        animation-fill-mode: both;
    }
    
    .shake {
        animation-name: shake;
    }
    
    .bounceIn {
        animation-name: bounceIn;
    }
</style>
@endpush

@push('scripts')
<script>
    // Initialize WOW.js for scroll animations
    document.addEventListener('DOMContentLoaded', function() {
        new WOW().init();
        
        // Form submission loading state
        const contactForm = document.getElementById('contactForm');
        if (contactForm) {
            contactForm.addEventListener('submit', function() {
                const submitBtn = this.querySelector('.send-message-btn');
                submitBtn.classList.add('sending');
                submitBtn.disabled = true;
            });
        }
        
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            });
        });
    });
</script>
@endpush 