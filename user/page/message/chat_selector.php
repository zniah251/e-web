<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . "/e-web/connect.php";

// Kiểm tra đăng nhập
if (!isset($_SESSION['uid'])) {
    // Nếu chưa đăng nhập, hiển thị thông báo yêu cầu đăng nhập
    echo '<script>alert("Vui lòng đăng nhập để sử dụng tính năng chat!");</script>';
    // Có thể redirect về trang đăng nhập
    // header("Location: /e-web/user/login.php");
    // exit();
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chat Selector</title>
  <style>
    body {
      font-family: 'Times New Roman', Times, serif; 
    }

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
      background: #f5f5dc;
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
      background: #4CAF50;
      color: white;
    }

    .admin-icon {
      background: #f222;
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

    /* Bot chat window styles */
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
      overflow: hidden;
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
    }

    #bot-chat-body {
      flex: 1;
      padding: 10px;
      overflow-y: auto;
      background: #eee;
      display: flex;
      flex-direction: column;
      gap: 10px;
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

    /* Admin chat window styles */
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
      overflow: hidden;
      z-index: 999;
      font-family: 'Times New Roman', Times, serif;
    }

    #admin-chat-header {
      background: #fff !important;
      color: #222 !important;
      border-bottom: 1px solid #eee !important;
      font-family: 'Times New Roman', Times, serif !important;
      font-size: 20px !important;
      font-weight: bold !important;
      text-align: center !important;
      padding: 16px 0 !important;
      box-shadow: none !important;
      position: relative;
    }

    #admin-chat-messages {
      flex: 1;
      padding: 10px;
      overflow-y: auto;
      background: #eee;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    #admin-chat-footer {
      background: #222 !important;
      border-top: none !important;
      box-shadow: none !important;
      padding: 12px 0 !important;
    }
    #admin-chat-footer input[type="text"] {
      background: #fff !important;
      color: #000 !important;
      border-radius: 20px !important;
      border: 1px solid #aaa !important;
      font-family: 'Times New Roman', Times, serif !important;
    }

    .admin-contact-info {
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      max-width: 100%;
    }

    .admin-contact-info h4 {
      color: #2196F3;
      margin-bottom: 15px;
    }

    .contact-item {
      display: flex;
      align-items: center;
      margin-bottom: 10px;
      padding: 8px;
      background: #f8f9fa;
      border-radius: 8px;
    }

    .contact-item i {
      margin-right: 10px;
      color: #2196F3;
      width: 20px;
    }

    .contact-item a {
      color: #333;
      text-decoration: none;
    }

    .contact-item a:hover {
      color: #2196F3;
    }
  </style>
</head>

<body>

  <div id="chat-icon" onclick="toggleChatSelector()">💬</div>

  <!-- Chat Selector -->
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

  <!-- Bot Chat Window -->
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

  <!-- Admin Chat Window -->
  <div id="admin-chat-window">
    <div id="admin-chat-header">
      Chat với Admin
      <button class="close-btn" onclick="closeAdminChat()">×</button>
    </div>
    <div id="admin-chat-messages" style="flex: 1; padding: 10px; overflow-y: auto; background: #eee; display: flex; flex-direction: column; gap: 10px;">
      <!-- Tin nhắn sẽ được hiển thị ở đây -->
    </div>
    <div id="admin-chat-footer" style="display: flex; flex-direction: column; gap: 6px; padding: 10px; border-top: 1px solid #ccc; background-color: #2196F3;">
      <div style="display: flex; gap: 5px; margin-bottom: 5px;">
        <button onclick="loadAdminMessages()" style="padding: 5px 10px; background: #fff; border: 1px solid #ccc; border-radius: 5px; cursor: pointer; font-size: 12px;">🔄 Refresh</button>
        <button onclick="testLoadMessages()" style="padding: 5px 10px; background: #fff; border: 1px solid #ccc; border-radius: 5px; cursor: pointer; font-size: 12px;">🧪 Test</button>
        <button onclick="forceRefreshMessages()" style="padding: 5px 10px; background: #fff; border: 1px solid #ccc; border-radius: 5px; cursor: pointer; font-size: 12px;">⚡ Force</button>
        <button onclick="testSpecificChat()" style="padding: 5px 10px; background: #fff; border: 1px solid #ccc; border-radius: 5px; cursor: pointer; font-size: 12px;">🎯 Test 958497692</button>
      </div>
      <div id="debug-info" style="font-size: 10px; color: #fff; margin-bottom: 5px;">
        Chat ID: <span id="current-chat-id">None</span> | Messages: <span id="message-count">0</span>
      </div>
      <input type="text" id="adminUserInput" placeholder="Nhập tin nhắn..." onkeypress="handleAdminKey(event)" style="padding: 8px; border: 1px solid #aaa; border-radius: 20px; outline: none; background-color: #fff; color: #000;">
    </div>
  </div>

  <script>
    function toggleChatSelector() {
      const selector = document.getElementById('chat-selector');
      const botChat = document.getElementById('bot-chat-window');
      const adminChat = document.getElementById('admin-chat-window');
      
      // Đóng tất cả cửa sổ chat khác
      botChat.style.display = 'none';
      adminChat.style.display = 'none';
      
      // Toggle selector
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
      
      // Bắt đầu auto-refresh
      startAdminAutoRefresh();
    }

    function closeAdminChat() {
      const adminChat = document.getElementById('admin-chat-window');
      adminChat.style.display = 'none';
      
      // Dừng auto-refresh
      stopAdminAutoRefresh();
    }

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
        // Gửi tin nhắn của người dùng đến backend
        const response = await fetch('http://localhost:3002/api/chat', {
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
        
        // Hiển thị câu trả lời từ Gemini
        appendBotMessage(botReply, 'bot');

      } catch (error) {
        console.error('Fetch error:', error);
        // Xử lý lỗi: hiển thị một tin nhắn mặc định
        const errorMessage = 'Xin lỗi, mình đang gặp chút sự cố. Bạn có thể liên hệ hotline: 0901 234 567 để được hỗ trợ ngay nhé!';
        appendBotMessage(errorMessage, 'bot');
      }
    }

    function handleBotKey(event) {
      if (event.key === 'Enter') sendBotMessage();
    }

    // Admin chat functions
    let currentChatId = null;
    let adminRefreshInterval = null;

    async function loadAdminMessages() {
      try {
        console.log('Loading admin messages...');
        
        // Kiểm tra session trước
        const sessionCheck = await fetch('/e-web/user/page/message/chat_admin.php?action=get_latest_session', {
          method: 'GET'
        });
        
        if (sessionCheck.status === 401) {
          console.error('User not logged in');
          const messagesContainer = document.getElementById('admin-chat-messages');
          messagesContainer.innerHTML = '<div class="text-center text-muted py-5"><i class="fas fa-lock fa-2x mb-3"></i><p>Vui lòng đăng nhập để sử dụng tính năng chat!</p></div>';
          updateDebugInfo();
          return;
        }
        
        if (sessionCheck.ok) {
          const data = await sessionCheck.json();
          console.log('Latest session response:', data);
          
          if (data.success && data.chat_id) {
            currentChatId = data.chat_id;
            console.log('Current chat ID:', currentChatId);
            // Load tin nhắn của session này
            await loadMessagesByChatId(data.chat_id);
          } else {
            // Nếu chưa có session, hiển thị thông báo "Chưa có tin nhắn nào"
            const messagesContainer = document.getElementById('admin-chat-messages');
            messagesContainer.innerHTML = '<div class="text-center text-muted py-5"><i class="fas fa-comment fa-2x mb-3"></i><p>Chưa có tin nhắn nào. Gửi tin nhắn đầu tiên để bắt đầu chat!</p></div>';
          }
          updateDebugInfo();
        } else {
          console.error('Failed to get latest session:', sessionCheck.status);
        }
      } catch (error) {
        console.error('Error loading admin messages:', error);
      }
    }

    async function loadMessagesByChatId(chatId) {
      try {
        console.log('Loading messages for chat ID:', chatId);
        const response = await fetch(`/e-web/user/page/message/chat_admin.php?action=get_messages&chat_id=${chatId}`, {
          method: 'GET'
        });
        
        if (response.status === 401) {
          console.error('User not logged in');
          const messagesContainer = document.getElementById('admin-chat-messages');
          messagesContainer.innerHTML = '<div class="text-center text-muted py-5"><i class="fas fa-lock fa-2x mb-3"></i><p>Vui lòng đăng nhập để sử dụng tính năng chat!</p></div>';
          return;
        }
        
        if (response.ok) {
          const data = await response.json();
          console.log('Messages response:', data);
          console.log('Number of messages:', data.messages ? data.messages.length : 0);
          
          if (data.success) {
            const messagesContainer = document.getElementById('admin-chat-messages');
            
            if (data.messages && data.messages.length > 0) {
              console.log('Processing messages...');
              
              // Xóa tin nhắn cũ chỉ khi có tin nhắn mới
              const currentMessageCount = messagesContainer.children.length;
              if (data.messages.length !== currentMessageCount) {
                console.log(`Updating messages: current=${currentMessageCount}, new=${data.messages.length}`);
                messagesContainer.innerHTML = ''; // Xóa tin nhắn cũ
                
                data.messages.forEach((msg, index) => {
                  console.log(`Message ${index + 1}:`, msg);
                  const isUserMessage = msg.sender === 'user' || msg.is_user_message === '1';
                  console.log(`Is user message: ${isUserMessage}, Sender: ${msg.sender}, is_user_message: ${msg.is_user_message}`);
                  appendAdminMessage(msg.text, isUserMessage ? 'user' : 'admin');
                });
              } else {
                console.log('No new messages to display');
              }
            } else {
              console.log('No messages found');
              if (messagesContainer.children.length === 0) {
                messagesContainer.innerHTML = '<div class="text-center text-muted py-5"><i class="fas fa-comment fa-2x mb-3"></i><p>Chưa có tin nhắn nào. Gửi tin nhắn đầu tiên để bắt đầu chat!</p></div>';
              }
            }
            messagesContainer.scrollTop = messagesContainer.scrollHeight; // Cuộn xuống cuối
          }
        } else {
          console.error('Failed to load messages:', response.status);
        }
      } catch (error) {
        console.error('Error loading messages by chat ID:', error);
      }
    }

    function sendAdminMessage(text = null) {
      const input = document.getElementById('adminUserInput');
      const message = text || input.value.trim();
      if (!message) return;
      
      appendAdminMessage(message, 'user'); // Hiển thị tin nhắn của người dùng ngay lập tức
      sendAdminMessageToServer(message);
      input.value = '';
    }

    function appendAdminMessage(text, sender) {
      console.log(`Appending message: "${text}" from ${sender}`);
      
      const div = document.createElement('div');
      div.className = `message-item mb-3 ${sender === 'user' ? 'text-end' : 'text-start'}`;
      
      const bubble = document.createElement('div');
      bubble.className = `d-inline-block p-3 rounded ${sender === 'user' ? 'user-msg' : 'bot-msg'}`; // Tái sử dụng user-msg/bot-msg
      bubble.textContent = text;
      
      // Thêm style để phân biệt rõ ràng
      if (sender === 'admin') {
        bubble.style.backgroundColor = '#e3f2fd';
        bubble.style.border = '1px solid #2196F3';
        bubble.style.color = '#000';
      } else {
        bubble.style.backgroundColor = '#f5f5f5';
        bubble.style.border = '1px solid #ddd';
        bubble.style.color = '#000';
      }
      
      div.appendChild(bubble);
      const messagesContainer = document.getElementById('admin-chat-messages');
      messagesContainer.appendChild(div);
      messagesContainer.scrollTop = messagesContainer.scrollHeight;
      
      console.log(`Message appended successfully. Total messages: ${messagesContainer.children.length}`);
      updateDebugInfo();
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

        if (response.status === 401) {
          console.error('User not logged in');
          appendAdminMessage('Vui lòng đăng nhập để sử dụng tính năng chat!', 'admin');
          return;
        }

        if (response.ok) {
          const data = await response.json();
          console.log('Send message response:', data);

          if (data.success) {
            currentChatId = data.chat_id;
            // Nếu là tin nhắn đầu tiên, có thể có auto_reply từ server
            if (data.auto_reply) {
              appendAdminMessage(data.auto_reply.message, 'admin');
            }
            // *** SỬA ĐOẠN NÀY ***
            // GỌI LẠI loadMessagesByChatId để lấy toàn bộ tin nhắn mới nhất (bao gồm cả tin nhắn admin vừa trả lời)
            await loadMessagesByChatId(currentChatId);
          }
        } else {
          console.error('Server responded with an error:', response.status);
          appendAdminMessage('Lỗi server: Không thể gửi tin nhắn. Vui lòng thử lại.', 'admin');
        }
      } catch (error) {
        console.error('Error sending admin message to server:', error);
        appendAdminMessage('Xin lỗi, có lỗi xảy ra khi gửi tin nhắn. Vui lòng thử lại sau.', 'admin');
      }
    }

    function handleAdminKey(event) {
      if (event.key === 'Enter') sendAdminMessage();
    }

    // Auto refresh tin nhắn admin mỗi 2 giây (nhanh hơn)
    function startAdminAutoRefresh() {
      if (adminRefreshInterval) {
        clearInterval(adminRefreshInterval);
      }
      adminRefreshInterval = setInterval(async () => {
        if (currentChatId) {
          console.log('Auto-refreshing messages for chat ID:', currentChatId);
          await loadMessagesByChatId(currentChatId);
        }
      }, 2000); // 2 giây
    }

    function stopAdminAutoRefresh() {
      if (adminRefreshInterval) {
        clearInterval(adminRefreshInterval);
        adminRefreshInterval = null;
      }
    }

    // Hàm test để debug
    async function testLoadMessages() {
      console.log('=== TEST LOAD MESSAGES ===');
      console.log('Current chat ID:', currentChatId);
      
      if (!currentChatId) {
        console.log('No current chat ID, trying to get latest session...');
        await loadAdminMessages();
        return;
      }
      
      console.log('Testing load messages for chat ID:', currentChatId);
      await loadMessagesByChatId(currentChatId);
    }

    // Hàm force refresh - tải lại hoàn toàn
    async function forceRefreshMessages() {
      console.log('=== FORCE REFRESH ===');
      if (currentChatId) {
        console.log('Force refreshing messages for chat ID:', currentChatId);
        await loadMessagesByChatId(currentChatId);
      } else {
        console.log('No current chat ID, loading admin messages...');
        await loadAdminMessages();
      }
    }

    // Cập nhật debug info
    function updateDebugInfo() {
      const chatIdSpan = document.getElementById('current-chat-id');
      const messageCountSpan = document.getElementById('message-count');
      
      if (chatIdSpan) {
        chatIdSpan.textContent = currentChatId || 'None';
      }
      
      if (messageCountSpan) {
        const messagesContainer = document.getElementById('admin-chat-messages');
        const count = messagesContainer ? messagesContainer.children.length : 0;
        messageCountSpan.textContent = count;
      }
    }

    // Thêm hàm để kiểm tra tin nhắn mới
    async function checkForNewMessages() {
      if (!currentChatId) return;
      
      try {
        const response = await fetch(`/e-web/user/page/message/chat_admin.php?action=get_messages&chat_id=${currentChatId}`, {
          method: 'GET'
        });
        
        if (response.ok) {
          const data = await response.json();
          if (data.success && data.messages) {
            const messagesContainer = document.getElementById('admin-chat-messages');
            const currentCount = messagesContainer.children.length;
            const newCount = data.messages.length;
            
            if (newCount > currentCount) {
              console.log(`Found ${newCount - currentCount} new messages!`);
              await loadMessagesByChatId(currentChatId);
            }
          }
        }
      } catch (error) {
        console.error('Error checking for new messages:', error);
      }
    }

    // Test trực tiếp với chat_id cụ thể
    async function testSpecificChat() {
      console.log('=== TESTING SPECIFIC CHAT 958497692 ===');
      currentChatId = 958497692;
      await loadMessagesByChatId(currentChatId);
      updateDebugInfo();
    }

    // Đóng chat khi click ra ngoài
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

</body>

</html>