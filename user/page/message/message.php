<?php
include $_SERVER['DOCUMENT_ROOT'] . "/e-web/connect.php";
?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chat Bot Mini</title>
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
    }

    #chat-window {
      font-family: 'Times New Roman', Times, serif;
      position: fixed;
      bottom: 90px;
      right: 20px;
      width: 320px;
      height: 500px;
      background: #f5f5dc;
      /* beige */
      border-radius: 12px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
      display: none;
      flex-direction: column;
      overflow: hidden;
      z-index: 999;
      font-family: Arial, sans-serif;
    }

    #chat-header {
      background: #222;
      color: #fff;
      padding: 12px;
      text-align: center;
      font-weight: bold;
      font-size: 16px;
    }

    #chat-body {
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
    }

    .faq-list {
      display: flex;
      flex-direction: column;
      gap: 6px;
    }

    .faq-button {
      border: none;
      padding: 8px 12px;
      border-radius: 12px;
      cursor: pointer;
      text-align: left;
      font-size: 14px;
      color: #000;
    }

    .faq-button:hover {
      background-color: #bbb;
    }

    #chat-footer {
      display: flex;
      flex-direction: column;
      gap: 6px;
      padding: 10px;
      border-top: 1px solid #ccc;
      background-color: black;
    }

    #chat-footer input {
      padding: 8px;
      border: 1px solid #aaa;
      border-radius: 20px;
      outline: none;
      background-color: #fff;
      color: #000;
    }

    #chat-footer button.send-btn {
      margin-left: auto;
      background: none;
      border: none;
      font-size: 18px;
      cursor: pointer;
    }
  </style>
</head>

<body>

  <div id="chat-icon" onclick="toggleChat()">💬</div>

  <div id="chat-window">
    <div id="chat-header" style="font-family: 'Times New Roman', Times, serif;">Retail Chatbot</div>
    <div id="chat-body">
      <div class="faq-list" style="font-family: 'Times New Roman', Times, serif;"> Câu hỏi nhanh:
        <button class="faq-button" onclick="sendMessage('Có được kiểm tra sản phẩm trước khi nhận không?')">Có được kiểm tra sản phẩm trước khi nhận không?</button>
        <button class="faq-button" onclick="sendMessage('Chính sách đổi/trả như thế nào?')">Chính sách đổi/trả như thế nào?</button>
        <button class="faq-button" onclick="sendMessage('Bao lâu thì giao hàng?')">Bao lâu thì giao hàng?</button>
        <button class="faq-button" onclick="sendMessage('Phí ship là bao nhiêu?')">Phí ship là bao nhiêu?</button>
        <button class="faq-button" onclick="sendMessage('Liên hệ shop bằng cách nào?')">Liên hệ shop bằng cách nào?</button>
        <button class="faq-button" onclick="sendMessage('Đang có những chương trình khuyến mãi nào?')">Đang có những chương trình khuyến mãi nào?</button>
      </div>
    </div>
    <div id="chat-footer">
      <input type="text" id="userInput" placeholder="Nhập tin nhắn..." onkeypress="handleKey(event)" style="font-family: 'Times New Roman', Times, serif;">
    </div>
  </div>

  <script>
    function toggleChat() {
      const chat = document.getElementById('chat-window');
      chat.style.display = chat.style.display === 'flex' ? 'none' : 'flex';
      chat.style.flexDirection = 'column';
    }

    function sendMessage(text = null) {
      const input = document.getElementById('userInput');
      const message = text || input.value.trim();
      if (!message) return;

      appendMessage(message, 'user');
      respondBot(message);
      input.value = '';
    }

    function appendMessage(text, sender) {
      const div = document.createElement('div');
      div.className = sender === 'user' ? 'user-msg' : 'bot-msg';
      div.textContent = text;
      document.getElementById('chat-body').appendChild(div);
      document.getElementById('chat-body').scrollTop = 9999;
    }

    function respondBot(userText) {
      let response = 'Cảm ơn bạn đã nhắn tin, nhưng điều này nằm ngoài phạm vi trả lời của mình! Liên hệ fanpage, instagram, email contact@kairashop.com hoặc gọi hotline: 0901 234 567 để được giải đáp chi tiết nhé!';
      const lower = userText.toLowerCase();

      if (lower.includes('khuyến mãi') || lower.includes('ưu đãi') || lower.includes('giảm giá') || lower.includes('sale')) {
        response = 'Hiện tại shop chưa triển khai các chương trình khuyến mãi. Nhưng có sẵn các voucher freeship và discount 50k/đơn hàng từ 300k vô cùng hấp dẫn. \n Bạn có thể xem chi tiết ở trang chủ, lưu voucher và sử dụng ngay, đừng bỏ lỡ cơ hội này nhé!';
      } else if (lower.includes('giao hàng') || lower.includes('thời gian ship')) {
        response = 'Thời gian giao hàng sẽ dao động từ 2 - 5 ngày tùy khu vực trên toàn quốc nhé!';
      } else if (lower.includes('đổi') || lower.includes('trả') || lower.includes('giao nhầm') || lower.includes('bị lỗi') || lower.includes('sai sản phẩm')) {
        response = 'Bạn có thể liên hệ đổi/trả trong vòng 7 ngày với điều kiện sản phẩm có lỗi/giao nhầm. Nhớ quay video unbox giúp mình nhé!';
      } else if (lower.includes('liên hệ') || lower.includes('số điện thoại') || lower.includes('gmail')) {
        response = 'Bạn có thể liên hệ qua fanpage, instagram, email contact@kairashop.com hoặc gọi hotline: 0901 234 567. Thông tin liên hệ đầy đủ ở cuối trang web bạn nhé!';
      } else if (lower.includes('phí ship') || lower.includes('giao hàng tận nơi') || lower.includes('phí giao')) {
        response = 'Phí ship sẽ là 30.000đ/đơn hàng nha.';
      } else if (lower.includes('có sẵn') || lower.includes('màu') || lower.includes('size') || lower.includes('còn hàng') || lower.includes('sẵn hàng')) {
        response = 'Chào bạn, tất cả thông tin về số lượng sẵn có của sản phẩm, màu sắc và size đều hiển thị chi tiết trong phần "xem chi tiết sản phẩm". \n Nếu còn thắc mắc gì thêm hãy hỏi mình nhé!';
      } else if (lower.includes('kiểm tra trước khi nhận') || lower.includes('kiểm tra rồi mới nhận') || lower.includes('kiểm tra trước khi lấy') || lower.includes('kiểm tra rồi mới lấy') || lower.includes('kiểm tra sản phẩm')) {
        response = 'Được kiểm tra sản phẩm trước khi nhận, nếu có sai sót hay nhầm lẫn bạn có thể gửi lại cho shipper để thực hiện đổi/trả. Nhưng vui lòng không thử đồ (mặc vào) nhé, cảm ơn bạn!';
      }
      setTimeout(() => appendMessage(response, 'bot'), 500);
    }

    function handleKey(event) {
      if (event.key === 'Enter') sendMessage();
    }
  </script>

</body>

</html>