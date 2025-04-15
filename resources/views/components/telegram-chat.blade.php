<!-- Telegram Chat Button and Modal -->
<div id="telegram-chat-button" style="position: fixed; bottom: 30px; right: 30px; z-index: 99999;">
    <button id="telegramChatBtn" style="border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; background-color: #0088cc; color: white; width: 70px; height: 70px; border-radius: 50%; text-align: center; box-shadow: 0 5px 15px rgba(0,0,0,0.3); transition: all 0.3s ease; text-decoration: none;">
        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" viewBox="0 0 16 16" style="vertical-align: middle;">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.287 5.906c-.778.324-2.334.994-4.666 2.01-.378.15-.577.298-.595.442-.03.243.275.339.69.47l.175.055c.408.133.958.288 1.243.294.26.006.549-.1.868-.32 2.179-1.471 3.304-2.214 3.374-2.23.05-.012.12-.026.166.016.047.041.042.12.037.141-.03.129-1.227 1.241-1.846 1.817-.193.18-.33.307-.358.336a8.154 8.154 0 0 1-.188.186c-.38.366-.664.64.015 1.088.327.216.589.393.85.571.284.194.568.387.936.629.093.06.183.125.27.187.331.236.63.448.997.414.214-.02.435-.22.547-.82.265-1.417.786-4.486.906-5.751a1.426 1.426 0 0 0-.013-.315.337.337 0 0 0-.114-.217.526.526 0 0 0-.31-.093c-.3.005-.763.166-2.984 1.09z"/>
        </svg>
    </button>
</div>

<!-- Chat Modal -->
<div id="telegram-chat-modal" style="display: none; position: fixed; bottom: 110px; right: 30px; width: 320px; background-color: white; border-radius: 12px; box-shadow: 0 5px 25px rgba(0,0,0,0.2); z-index: 99998; overflow: hidden;">
    <div style="background-color: #0088cc; color: white; padding: 15px; display: flex; justify-content: space-between; align-items: center;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.287 5.906c-.778.324-2.334.994-4.666 2.01-.378.15-.577.298-.595.442-.03.243.275.339.69.47l.175.055c.408.133.958.288 1.243.294.26.006.549-.1.868-.32 2.179-1.471 3.304-2.214 3.374-2.23.05-.012.12-.026.166.016.047.041.042.12.037.141-.03.129-1.227 1.241-1.846 1.817-.193.18-.33.307-.358.336a8.154 8.154 0 0 1-.188.186c-.38.366-.664.64.015 1.088.327.216.589.393.85.571.284.194.568.387.936.629.093.06.183.125.27.187.331.236.63.448.997.414.214-.02.435-.22.547-.82.265-1.417.786-4.486.906-5.751a1.426 1.426 0 0 0-.013-.315.337.337 0 0 0-.114-.217.526.526 0 0 0-.31-.093c-.3.005-.763.166-2.984 1.09z"/>
            </svg>
            <h3 style="margin: 0; font-size: 18px;">Chat với chúng tôi</h3>
        </div>
        <button id="telegramCloseBtn" style="background: none; border: none; color: white; cursor: pointer; font-size: 20px;">×</button>
    </div>
    
    <div style="padding: 15px;">
        <p style="margin-top: 0; color: #555;">Vui lòng điền thông tin để chúng tôi có thể hỗ trợ bạn.</p>
        
        <form id="telegram-chat-form" style="display: flex; flex-direction: column; gap: 12px;">
            <div>
                <label for="tg-name" style="display: block; margin-bottom: 5px; color: #444; font-weight: 500;">Họ tên</label>
                <input type="text" id="tg-name" placeholder="Nhập tên của bạn" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
            </div>
            
            <div>
                <label for="tg-email" style="display: block; margin-bottom: 5px; color: #444; font-weight: 500;">Email</label>
                <input type="email" id="tg-email" placeholder="Nhập email của bạn" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
            </div>
            
            <div>
                <label for="tg-message" style="display: block; margin-bottom: 5px; color: #444; font-weight: 500;">Tin nhắn</label>
                <textarea id="tg-message" rows="4" placeholder="Nhập nội dung tin nhắn" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; resize: none;"></textarea>
            </div>
            
            <button type="submit" id="tg-submit-btn" style="background-color: #0088cc; color: white; border: none; padding: 12px; border-radius: 6px; font-weight: 500; cursor: pointer; margin-top: 5px;">Gửi tin nhắn</button>
            
            <div style="text-align: center; margin-top: 5px; font-size: 13px; color: #666;">
                <span>hoặc chuyển đến</span>
                <a href="https://t.me/{{ config('services.telegram.username', 'SharkEatRice') }}" target="_blank" style="color: #0088cc; text-decoration: none; margin-left: 5px;">Telegram</a>
            </div>
        </form>
        
        <div id="telegram-success-message" style="display: none; text-align: center; padding: 20px 10px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="#28a745" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </svg>
            <h4 style="margin-top: 15px; color: #28a745;">Tin nhắn đã được gửi!</h4>
            <p style="color: #555;">Cảm ơn bạn đã liên hệ. Chúng tôi sẽ phản hồi sớm nhất có thể.</p>
            <button id="tg-close-success" style="background-color: #28a745; color: white; border: none; padding: 10px 15px; border-radius: 6px; margin-top: 10px; cursor: pointer;">Đóng</button>
        </div>
    </div>
</div>

<style>
    #telegram-chat-button {
        animation: float 3s ease-in-out infinite;
    }
    
    @keyframes float {
        0% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-10px);
        }
        100% {
            transform: translateY(0px);
        }
    }
    
    #telegram-chat-button button:hover {
        transform: scale(1.1);
        box-shadow: 0 8px 20px rgba(0,0,0,0.4);
    }
    
    /* Modal animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    #telegram-chat-modal.visible {
        display: block !important;
        animation: fadeIn 0.3s ease-out forwards;
    }
    
    /* Đảm bảo nút hiển thị trên tất cả các thiết bị */
    @media (max-width: 768px) {
        #telegram-chat-button {
            bottom: 20px;
            right: 20px;
        }
        
        #telegram-chat-button button {
            width: 60px;
            height: 60px;
        }
        
        #telegram-chat-button svg {
            width: 30px;
            height: 30px;
        }
        
        #telegram-chat-modal {
            bottom: 90px;
            right: 20px;
            width: 300px;
        }
    }
</style>

<script>
// Đảm bảo script chạy ngay khi load
(function() {
    console.log("Telegram Chat Script Loading...");
    
    // Thêm event listener sau khi DOM đã load
    window.addEventListener('load', function() {
        setupTelegramChat();
    });
    
    // Nếu DOM đã ready, setup ngay lập tức
    if (document.readyState === 'complete' || document.readyState === 'interactive') {
        setupTelegramChat();
    }
    
    function setupTelegramChat() {
        console.log("Setting up Telegram Chat...");
        
        // Lấy các elements
        const chatButton = document.getElementById('telegramChatBtn');
        const closeButton = document.getElementById('telegramCloseBtn');
        const closeSuccessButton = document.getElementById('tg-close-success');
        const chatModal = document.getElementById('telegram-chat-modal');
        const chatForm = document.getElementById('telegram-chat-form');
        const successMessage = document.getElementById('telegram-success-message');
        
        // Debug: Kiểm tra xem elements đã được tìm thấy chưa
        console.log("Chat Button:", chatButton);
        console.log("Close Button:", closeButton);
        console.log("Chat Modal:", chatModal);
        console.log("Chat Form:", chatForm);
        
        // Thêm event listeners
        if (chatButton) {
            chatButton.addEventListener('click', function(e) {
                console.log("Chat Button Clicked");
                e.preventDefault();
                chatModal.classList.add('visible');
            });
        }
        
        if (closeButton) {
            closeButton.addEventListener('click', function(e) {
                console.log("Close Button Clicked");
                e.preventDefault();
                closeTelegramChat();
            });
        }
        
        if (closeSuccessButton) {
            closeSuccessButton.addEventListener('click', function(e) {
                console.log("Success Close Button Clicked");
                e.preventDefault();
                closeTelegramChat();
            });
        }
        
        if (chatForm) {
            chatForm.addEventListener('submit', function(e) {
                console.log("Form Submitted");
                e.preventDefault();
                
                // Get form values
                const name = document.getElementById('tg-name').value;
                const email = document.getElementById('tg-email').value;
                const message = document.getElementById('tg-message').value;
                
                console.log("Form Data:", {name, email, message});
                
                // Send message to Telegram bot
                const telegramBotToken = '{{ env("TELEGRAM_BOT_TOKEN", "") }}';
                const telegramChatId = '{{ env("TELEGRAM_CHAT_ID", "") }}';
                
                console.log("Bot Token:", telegramBotToken ? (telegramBotToken.length > 10 ? telegramBotToken.substring(0, 10) + "..." : telegramBotToken) : "Not Set");
                console.log("Chat ID:", telegramChatId);
                
                if(telegramBotToken && telegramChatId) {
                    const text = `🔔 Tin nhắn mới!\n\n👤 Họ tên: ${name}\n📧 Email: ${email}\n\n💬 Nội dung: ${message}`;
                    
                    // Kiểm tra nếu chat ID là username (không bắt đầu bằng số)
                    const chatId = isNaN(telegramChatId.charAt(0)) ? `@${telegramChatId.replace('@', '')}` : telegramChatId;
                    
                    console.log("Sending message to:", chatId);
                    
                    // Send using Telegram Bot API
                    const apiUrl = `https://api.telegram.org/bot${telegramBotToken}/sendMessage?chat_id=${encodeURIComponent(chatId)}&text=${encodeURIComponent(text)}`;
                    console.log("API URL:", apiUrl);
                    
                    fetch(apiUrl, {
                        method: 'GET'
                    }).then(response => {
                        console.log("API Response Status:", response.status, response.statusText);
                        return response.json();
                    }).then(data => {
                        console.log("API Response Data:", JSON.stringify(data));
                        if (data.ok) {
                            // Show success message
                            chatForm.style.display = 'none';
                            successMessage.style.display = 'block';
                        } else {
                            console.error("Telegram API Error:", data.description);
                            alert(`Lỗi từ Telegram: ${data.description || 'Không xác định'}. Vui lòng thử lại sau.`);
                        }
                    }).catch(error => {
                        console.error('Error sending message:', error);
                        alert('Có lỗi xảy ra khi gửi tin nhắn. Vui lòng thử lại sau.\nLỗi: ' + error.message);
                    });
                } else {
                    console.log("Fallback: Opening Telegram directly");
                    // Fallback if Telegram bot is not configured
                    window.open(`https://t.me/{{ config('services.telegram.username', 'SharkEatRice') }}`, '_blank');
                    closeTelegramChat();
                }
            });
        }
    }
    
    // Hàm đóng chat
    function closeTelegramChat() {
        console.log("Closing Chat Modal");
        const chatModal = document.getElementById('telegram-chat-modal');
        const chatForm = document.getElementById('telegram-chat-form');
        const successMessage = document.getElementById('telegram-success-message');
        
        if (chatModal) chatModal.classList.remove('visible');
        
        // Reset form after a short delay
        setTimeout(() => {
            if (successMessage) successMessage.style.display = 'none';
            if (chatForm) {
                chatForm.style.display = 'flex';
                chatForm.reset();
            }
        }, 300);
    }
    
    // Thêm global function để có thể gọi từ bên ngoài
    window.openTelegramChat = function() {
        console.log("openTelegramChat called from global");
        const chatModal = document.getElementById('telegram-chat-modal');
        if (chatModal) chatModal.classList.add('visible');
    };
    
    window.closeTelegramChat = closeTelegramChat;
    
})();
</script> 