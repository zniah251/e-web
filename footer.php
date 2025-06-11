<?php
include $_SERVER['DOCUMENT_ROOT'] . "/e-web/connect.php";
?>

<footer id="footer" class="footer-custom mt-5">
    <div class="container">
        <div class="row justify-content-between py-5">

            <div class="col-md-3 col-sm-6">
                <h4 class="fw-bold mb-3" style="font-family: 'Times New Roman', Times, serif;">KAIRA</h4>
                <p>Chúng tôi là cửa hàng thời trang phong cách hiện đại, mang đến trải nghiệm mua sắm tiện lợi và thân thiện.</p>
                <div class="social-icons mt-3">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <h5 class="fw-semibold mb-3" style="font-family: 'Times New Roman', Times, serif;">LIÊN KẾT NHANH</h5>
                <ul class="list-unstyled">
                    <li><a href="index.html">Trang chủ</a></li>
                    <li><a href="page/aboutus/aboutus.html">Giới thiệu</a></li>
                    <li><a href="page/faq/faq.html">Hỏi đáp</a></li>
                    <li><a href="page/recruitment/recruit.html">Tuyển dụng</a></li>
                    <li><a href="page/member/member.html">Membership</a></li>
                </ul>
            </div>

            <div class="col-md-3 col-sm-6">
                <h5 class="fw-semibold mb-3" style="font-family: 'Times New Roman', Times, serif;">THÔNG TIN LIÊN HỆ</h5>
                <p><i class="fas fa-map-marker-alt me-2"></i>123 Đường Lê Lợi, TP.HCM</p>
                <p><i class="fas fa-envelope me-2"></i>contact@kairashop.com</p>
                <p><i class="fas fa-phone me-2"></i>0901 234 567</p>
            </div>

            <div class="col-md-3 col-sm-6">
                <h5 class="fw-semibold mb-3" style="font-family: 'Times New Roman', Times, serif;">BẢN ĐỒ</h5>
                <div class="map-embed">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.726643481827!2d106.6901211153343!3d10.75666499233459!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f3b5f6a90ed%3A0xf7b2b4f40e527417!2zMTIzIMSQLiBMw6ogTOG7m2ksIFTDom4gVGjhu5FuZyBI4buTbmcsIFRow6BuaCBwaOG7kSBI4buTIENow60gTWluaCwgSOG7kyBDaMOidSwgVMOibiBwaOG7kSBIw7JhIE5haQ!5e0!3m2!1svi!2s!4v1614089999097!5m2!1svi!2s" width="100%" height="180" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>

        </div>
        <div class="text-center py-3 border-top small">
            © 2025 Kaira. Thiết kế bởi nhóm <strong>5 IS207</strong> | Dự án học phần Phát triển Web
        </div>
    </div>
</footer>

<style>
    #chat-icon {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background-color: #222;
      color: white;
      border-radius: 50%;
      width: 60px;
      height: 60px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 30px;
      cursor: pointer;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
      z-index: 1000;
      transition: all 0.3s ease;
    }
    #chat-icon:hover {
      transform: scale(1.1);
      background-color: #333;
    }
    #chat-selector {
      position: fixed;
      bottom: 90px;
      right: 20px;
      width: 280px;
      background: lightgray;
      border-radius: 12px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
      display: none;
      flex-direction: column;
      overflow: hidden;
      z-index: 999;
      font-family: 'Times New Roman', Times, serif;
    }
    #chat-selector-header {
      background: #222;
      color: #fff;
      padding: 15px;
      text-align: center;
      font-weight: bold;
      font-size: 16px;
    }
    #chat-options {
      padding: 20px;
      display: flex;
      flex-direction: column;
      gap: 15px;
    }
    .chat-option {
      display: flex;
      align-items: center;
      padding: 15px;
      background: #fff;
      border: 2px solid #ddd;
      border-radius: 10px;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      color: #333;
    }
    .chat-option:hover {
      border-color: #222;
      background: #f8f8f8;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .chat-option-icon {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 15px;
      font-size: 20px;
    }
    .bot-icon {
      background: black;
      color: white;
    }
    .admin-icon {
      background: black;
      color: white;
    }
    .chat-option-content {
      flex: 1;
    }
    .chat-option-title {
      font-weight: bold;
      font-size: 16px;
      margin-bottom: 5px;
    }
    .chat-option-description {
      font-size: 14px;
      color: #666;
    }
    .close-btn {
      position: absolute;
      top: 10px;
      right: 10px;
      background: none;
      border: none;
      color: white;
      font-size: 20px;
      cursor: pointer;
      padding: 5px;
    }
    .close-btn:hover {
      color: #ccc;
    }
    #bot-chat-window {
      position: fixed;
      bottom: 90px;
      right: 20px;
      width: 320px;
      height: 500px;
      background: #f5f5dc;
      border-radius: 12px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
      display: none;
      flex-direction: column;
      overflow: hidden; /* Added overflow: hidden to ensure content within is clipped and allows inner scrolling */
      z-index: 999;
      font-family: 'Times New Roman', Times, serif;
    }
    #bot-chat-header {
      background: #222;
      color: #fff;
      padding: 12px;
      text-align: center;
      font-weight: bold;
      font-size: 16px;
      position: relative;
      flex-shrink: 0; /* Ensure header doesn't shrink */
    }
    #bot-chat-body {
      flex: 1; /* Take up remaining space */
      padding: 10px;
      overflow-y: auto; /* This ensures the message area scrolls */
      background: white;
      display: flex;
      flex-direction: column;
      gap: 10px;
      min-height: 0; /* Crucial for flex items with overflow */
    }
    .user-msg,
    .bot-msg {
      max-width: 80%;
      padding: 10px 14px;
      border-radius: 16px;
      line-height: 1.4;
      font-size: 14px;
      white-space: pre-line;
      font-family: 'Times New Roman', Times, serif;
    }
    .user-msg {
      background: #ccc;
      color: #111;
      align-self: flex-end;
      border-radius: 16px;
      border-bottom-right-radius: 4px;
      padding: 10px 14px;
    }
    .bot-msg {
      background: #fff;
      color: #111;
      border: 1px solid #ccc;
    }
    .faq-button {
      background: #f0f0f0;
      color: #222;
      border: none;
      padding: 8px 12px;
      border-radius: 12px;
      cursor: pointer;
      text-align: left;
      font-size: 14px;
      color: #000;
      margin-bottom: 6px;
    }
    .faq-button:hover {
      background-color: #bbb;
    }
    #bot-chat-footer {
      display: flex;
      flex-direction: column;
      gap: 6px;
      padding: 10px;
      border-top: 1px solid #ccc;
      background-color: black;
      flex-shrink: 0; /* Ensure footer does not shrink */
    }
    #bot-chat-footer input {
      padding: 8px;
      border: 1px solid #aaa;
      border-radius: 20px;
      outline: none;
      background-color: #fff;
      color: #000;
    }
    #bot-chat-footer button.send-btn {
      margin-left: auto;
      background: none;
      border: none;
      font-size: 18px;
      cursor: pointer;
    }
    #admin-chat-window {
      position: fixed;
      bottom: 90px;
      right: 20px;
      width: 320px;
      height: 500px;
      background: #f5f5dc;
      border-radius: 12px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
      display: none;
      flex-direction: column;
      overflow: hidden; /* Added overflow: hidden to ensure content within is clipped and allows inner scrolling */
      z-index: 999;
      font-family: 'Times New Roman', Times, serif;
    }
    /* Ghi đè màu header admin chat */
    #admin-chat-header {
        background: #222 !important;   /* Đen */
        color: #fff !important;        /* Chữ trắng */
        border-bottom: 1px solid !important;
        font-family: 'Times New Roman', Times, serif !important;
        font-size: 20px !important;
        font-weight: bold !important;
        text-align: center !important;
        padding: 16px 0 !important;
        box-shadow: none !important;
        flex-shrink: 0; /* Ensure header doesn't shrink */
    }

    /* Ghi đè màu body chat admin */
    #admin-chat-body {
        background: #fff !important;   /* Nền trắng */
        padding: 0 !important; /* Changed from 20px to 0 as padding is now on admin-chat-messages */
        flex: 1; /* Take up remaining space */
        display: flex; /* Make it a flex container for its children */
        flex-direction: column; /* Stack children vertically */
        overflow: hidden; /* Contain scroll of its children */
    }

    #admin-chat-messages {
        flex: 1; /* This will make the messages section grow and take available space */
        overflow-y: auto; /* This will make the messages scroll */
        min-height: 0; /* Crucial for flex items with overflow */
        padding: 20px !important; /* Keep as is from override */
        background: #fff !important; /* Keep as is from override */
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    /* Ghi đè màu footer admin chat */
    #admin-chat-footer {
        background: #222 !important;
        padding: 10px !important;
        border-top: 1px solid #ccc !important;
        flex-shrink: 0; /* Ensures the footer doesn't shrink and stays fixed at the bottom */
        width: 100%;
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    /* Input trong footer admin chat */
    #admin-chat-footer input[type="text"] {
        background: #fff !important;
        color: #000 !important;
        border-radius: 20px !important;
        border: 1px solid #aaa !important;
        font-family: 'Times New Roman', Times, serif !important;
        padding: 8px !important;
    }

    /* Bong bóng tin nhắn user/admin */
    #admin-chat-messages .user-msg {
        background: #ccc !important;
        color: #111 !important;
        border-radius: 16px !important;
        border-bottom-right-radius: 4px !important;
        font-family: 'Times New Roman', Times, serif !important;
    }
    #admin-chat-messages .bot-msg {
        background: #fff !important;
        color: #111 !important;
        border: 1px solid #ccc !important;
        border-radius: 16px !important;
        font-family: 'Times New Roman', Times, serif !important;
    }
</style>

<div id="chat-icon" onclick="toggleChatSelector()">💬</div>
<div id="chat-selector">
  <div id="chat-selector-header">
    Chọn cách liên hệ
    <button class="close-btn" onclick="toggleChatSelector()">×</button>
  </div>
  <div id="chat-options">
    <div class="chat-option" onclick="openBotChat()">
      <div class="chat-option-icon bot-icon">🤖</div>
      <div class="chat-option-content">
        <div class="chat-option-title">Chat với Bot</div>
        <div class="chat-option-description">Hỏi đáp nhanh về sản phẩm, chính sách</div>
      </div>
    </div>
    <div class="chat-option" onclick="openAdminChat()">
      <div class="chat-option-icon admin-icon">👨‍💼</div>
      <div class="chat-option-content">
        <div class="chat-option-title">Chat với Admin</div>
        <div class="chat-option-description">Liên hệ trực tiếp với nhân viên hỗ trợ</div>
      </div>
    </div>
  </div>
</div>
<div id="bot-chat-window">
  <div id="bot-chat-header">
    Chat với Bot
    <button class="close-btn" onclick="closeBotChat()">×</button>
  </div>
  <div id="bot-chat-body">
    <div class="faq-list" style="font-family: 'Times New Roman', Times, serif;"> 
      Câu hỏi nhanh:
      <button class="faq-button" onclick="sendBotMessage('Có được kiểm tra sản phẩm trước khi nhận không?')">Có được kiểm tra sản phẩm trước khi nhận không?</button>
      <button class="faq-button" onclick="sendBotMessage('Chính sách đổi/trả như thế nào?')">Chính sách đổi/trả như thế nào?</button>
      <button class="faq-button" onclick="sendBotMessage('Bao lâu thì giao hàng?')">Bao lâu thì giao hàng?</button>
      <button class="faq-button" onclick="sendBotMessage('Phí ship là bao nhiêu?')">Phí ship là bao nhiêu?</button>
      <button class="faq-button" onclick="sendBotMessage('Liên hệ shop bằng cách nào?')">Liên hệ shop bằng cách nào?</button>
      <button class="faq-button" onclick="sendBotMessage('Đang có những chương trình khuyến mãi nào?')">Đang có những chương trình khuyến mãi nào?</button>
    </div>
  </div>
  <div id="bot-chat-footer">
    <input type="text" id="botUserInput" placeholder="Nhập tin nhắn..." onkeypress="handleBotKey(event)" style="font-family: 'Times New Roman', Times, serif;">
  </div>
</div>
<div id="admin-chat-window">
  <div id="admin-chat-header">
    Chat với Admin
    <button class="close-btn" onclick="closeAdminChat()">×</button>
  </div>
  <div id="admin-chat-body">
    <div id="admin-chat-messages">
      </div>
    <div id="admin-chat-footer">
      <input type="text" id="adminUserInput" placeholder="Nhập tin nhắn..." onkeypress="handleAdminKey(event)">
    </div>
  </div>
</div>
<script>
    let currentChatId = null;
    
    function toggleChatSelector() {
      const selector = document.getElementById('chat-selector');
      const botChat = document.getElementById('bot-chat-window');
      const adminChat = document.getElementById('admin-chat-window');
      botChat.style.display = 'none';
      adminChat.style.display = 'none';
      selector.style.display = selector.style.display === 'flex' ? 'none' : 'flex';
    }
    function openBotChat() {
      const selector = document.getElementById('chat-selector');
      const botChat = document.getElementById('bot-chat-window');
      selector.style.display = 'none';
      botChat.style.display = 'flex';
      botChat.style.flexDirection = 'column';
    }
    function closeBotChat() {
      const botChat = document.getElementById('bot-chat-window');
      botChat.style.display = 'none';
    }
    function openAdminChat() {
      const selector = document.getElementById('chat-selector');
      const adminChat = document.getElementById('admin-chat-window');
      selector.style.display = 'none';
      adminChat.style.display = 'flex';
      adminChat.style.flexDirection = 'column';
      
      // Load tin nhắn cũ nếu có
      loadAdminMessages();
    }
    function closeAdminChat() {
      const adminChat = document.getElementById('admin-chat-window');
      adminChat.style.display = 'none';
    }
    
    // Bot chat functions
    function sendBotMessage(text = null) {
      const input = document.getElementById('botUserInput');
      const message = text || input.value.trim();
      if (!message) return;
      appendBotMessage(message, 'user');
      respondBot(message);
      input.value = '';
    }
    function appendBotMessage(text, sender) {
      const div = document.createElement('div');
      div.className = sender === 'user' ? 'user-msg' : 'bot-msg';
      div.textContent = text;
      document.getElementById('bot-chat-body').appendChild(div);
      document.getElementById('bot-chat-body').scrollTop = 9999;
    }
    async function respondBot(userText) {
      try {
        const response = await fetch('http://localhost:3000/api/chat', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({ message: userText }),
        });
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        const botReply = data.reply;
        appendBotMessage(botReply, 'bot');
      } catch (error) {
        console.error('Fetch error:', error);
        const errorMessage = 'Xin lỗi, mình đang gặp chút sự cố. Bạn có thể liên hệ hotline: 0901 234 567 để được hỗ trợ ngay nhé!';
        appendBotMessage(errorMessage, 'bot');
      }
    }
    function handleBotKey(event) {
      if (event.key === 'Enter') sendBotMessage();
    }
    
    // Admin chat functions
    async function loadAdminMessages() {
      try {
        // Lấy session chat gần nhất
        const response = await fetch('/e-web/user/page/message/chat_admin.php?action=get_latest_session', {
          method: 'GET'
        });
        
        if (response.ok) {
          const data = await response.json();
          if (data.success && data.chat_id) {
            currentChatId = data.chat_id;
            // Load tin nhắn của session này
            await loadMessagesByChatId(data.chat_id);
          }
        }
      } catch (error) {
        console.error('Error loading admin messages:', error);
      }
    }
    
    async function loadMessagesByChatId(chatId) {
      try {
        const response = await fetch(`/e-web/user/page/message/chat_admin.php?action=get_messages&chat_id=${chatId}`, {
          method: 'GET'
        });
        
        if (response.ok) {
          const data = await response.json();
          if (data.success) {
            const messagesContainer = document.getElementById('admin-chat-messages');
            messagesContainer.innerHTML = '';
            
            data.messages.forEach(msg => {
              appendAdminMessage(msg.text, msg.sender);
            });
          }
        }
      } catch (error) {
        console.error('Error loading messages:', error);
      }
    }
    
    function sendAdminMessage(text = null) {
      const input = document.getElementById('adminUserInput');
      const message = text || input.value.trim();
      if (!message) return;
      
      appendAdminMessage(message, 'user');
      sendAdminMessageToServer(message);
      input.value = '';
    }
    
    function appendAdminMessage(text, sender) {
      const div = document.createElement('div');
      div.className = sender === 'user' ? 'user-msg' : 'bot-msg';
      div.textContent = text;
      document.getElementById('admin-chat-messages').appendChild(div);
      document.getElementById('admin-chat-messages').scrollTop = 9999;
    }
    
    async function sendAdminMessageToServer(message) {
      try {
        const formData = new FormData();
        formData.append('action', 'send_message');
        formData.append('message', message);
        if (currentChatId) {
          formData.append('chat_id', currentChatId);
        }
        
        const response = await fetch('/e-web/user/page/message/chat_admin.php', {
          method: 'POST',
          body: formData
        });
        
        if (response.ok) {
          const data = await response.json();
          if (data.success) {
            currentChatId = data.chat_id;
            
            // Hiển thị tin nhắn tự động nếu có
            if (data.auto_reply) {
              appendAdminMessage(data.auto_reply.message, 'admin');
            }
          }
        }
      } catch (error) {
        console.error('Error sending admin message:', error);
        appendAdminMessage('Xin lỗi, có lỗi xảy ra khi gửi tin nhắn. Vui lòng thử lại sau.', 'admin');
      }
    }
    
    function handleAdminKey(event) {
      if (event.key === 'Enter') sendAdminMessage();
    }
    
    document.addEventListener('click', function(event) {
      const chatIcon = document.getElementById('chat-icon');
      const selector = document.getElementById('chat-selector');
      const botChat = document.getElementById('bot-chat-window');
      const adminChat = document.getElementById('admin-chat-window');
      if (!chatIcon.contains(event.target) && 
          !selector.contains(event.target) && 
          !botChat.contains(event.target) && 
          !adminChat.contains(event.target)) {
        selector.style.display = 'none';
        botChat.style.display = 'none';
        adminChat.style.display = 'none';
      }
    });
</script>