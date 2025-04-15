<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Phản hồi từ {{ config('app.name') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid #eee;
        }
        .message-container {
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .original-message {
            margin-top: 30px;
            padding: 15px;
            background-color: #f0f0f0;
            border-left: 4px solid #ccc;
            border-radius: 3px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #777;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Phản hồi từ {{ config('app.name') }}</h1>
        </div>
        
        <p>Xin chào {{ $contact->name }},</p>
        
        <p>Cảm ơn bạn đã liên hệ với chúng tôi. Dưới đây là phản hồi cho tin nhắn của bạn:</p>
        
        <div class="message-container">
            <p>{!! nl2br(e($replyMessage)) !!}</p>
        </div>
        
        <div class="original-message">
            <h3>Tin nhắn gốc:</h3>
            <p><strong>Chủ đề:</strong> {{ $contact->subject ?: 'Không có chủ đề' }}</p>
            <p><strong>Ngày gửi:</strong> {{ $contact->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Nội dung:</strong></p>
            <p>{!! nl2br(e($contact->message)) !!}</p>
        </div>
        
        <p>Nếu bạn có bất kỳ câu hỏi nào khác, vui lòng liên hệ lại với chúng tôi.</p>
        
        <p>Trân trọng,<br>Đội ngũ {{ config('app.name') }}</p>
        
        <div class="footer">
            <p>© {{ date('Y') }} {{ config('app.name') }}. Tất cả các quyền được bảo lưu.</p>
        </div>
    </div>
</body>
</html> 