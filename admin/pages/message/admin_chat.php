<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Kiểm tra đăng nhập và quyền admin
if (!isset($_SESSION['uid']) || $_SESSION['uid'] <= 0) {
    header("Location: /e-web/user/page/sign-in/login2.php");
    exit();
}
if (!isset($_SESSION['rid']) || $_SESSION['rid'] != 1) {
    header("Location: /e-web/user/index.php");
    exit();
}

$currentPage = 'messages';
include $_SERVER['DOCUMENT_ROOT'] . "/e-web/connect.php";

// Lấy dữ liệu ban đầu để trang không bị trống lúc tải
// Hàm getChatSessions và getChatMessages vẫn có thể giữ lại để tải lần đầu
// hoặc có thể bỏ đi và để JS tải hoàn toàn. Ở đây chúng ta giữ lại để tải lần đầu.

// Lấy danh sách sessions từ database
function getChatSessions($conn) {
    $sql = "SELECT 
                uc.chat_id, u.uname as customer_name, u.uid, COUNT(uc.message_id) as message_count,
                MAX(uc.created_at) as last_message_time,
                (SELECT message FROM user_chat uc2 WHERE uc2.chat_id = uc.chat_id ORDER BY created_at DESC LIMIT 1) as last_message,
                SUM(CASE WHEN uc.is_user_message = 1 AND uc.created_at > COALESCE(
                    (SELECT MAX(created_at) FROM user_chat uc3 WHERE uc3.chat_id = uc.chat_id AND uc3.is_user_message = 0), '2000-01-01'
                ) THEN 1 ELSE 0 END) as unread_count
            FROM user_chat uc
            LEFT JOIN users u ON uc.uid = u.uid
            WHERE uc.uid IS NOT NULL
            GROUP BY uc.chat_id, u.uname, u.uid
            ORDER BY last_message_time DESC";
    $result = $conn->query($sql);
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

// Lấy tin nhắn theo chat_id
function getChatMessages($conn, $chat_id) {
    $sql = "SELECT uc.message_id, uc.message, uc.is_user_message, uc.created_at, u.uname as customer_name
            FROM user_chat uc
            LEFT JOIN users u ON uc.uid = u.uid
            WHERE uc.chat_id = ? ORDER BY uc.created_at ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $chat_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

function timeAgo($datetime) {
    if (!$datetime) return 'Không có';
    $time = strtotime($datetime);
    $diff = time() - $time;
    if ($diff < 60) return $diff . ' giây trước';
    if ($diff < 3600) return floor($diff/60) . ' phút trước';
    if ($diff < 86400) return floor($diff/3600) . ' giờ trước';
    return floor($diff/86400) . ' ngày trước';
}

// BỎ ĐI TOÀN BỘ PHẦN XỬ LÝ `if ($_SERVER['REQUEST_METHOD'] === 'POST' ...)` Ở ĐÂY
// VÌ NÓ ĐÃ ĐƯỢC CHUYỂN SANG `chat_api.php`

// Lấy dữ liệu cho lần tải trang đầu tiên
$sessions = getChatSessions($conn);
$selected_id = isset($_GET['id']) ? intval($_GET['id']) : ($sessions[0]['chat_id'] ?? 0);
$current_messages = $selected_id ? getChatMessages($conn, $selected_id) : [];
$current_session = null;
foreach ($sessions as $session) {
    if ($session['chat_id'] == $selected_id) {
        $current_session = $session;
        break;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Chat Support - Kaira Shop</title>
    <link href="/e-web/admin/template/assets/images/favicon.png" rel="icon">
    <link rel="stylesheet" href="/e-web/admin/template/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/e-web/admin/template/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css">
    <link rel="stylesheet" href="/e-web/admin/template/assets/css/style.css">
    <link rel="stylesheet" href="admin_chat.css">
</head>
<body>
<div class="container-fluid position-relative d-flex p-0 vh-100">
    <?php include __DIR__.'/../../template/sidebar.php'; ?>

    <div class="content d-flex flex-column flex-grow-1">
        <?php include __DIR__.'/../../template/navbar.php'; ?>

        <div class="container-fluid pt-4 px-4 flex-grow-1 d-flex flex-column">
            <div class="bg-white rounded p-4 mb-4 shadow-sm flex-grow-1 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0"><i class="fas fa-comments text-primary"></i> Quản lý Chat Support</h4>
                    <div class="d-flex align-items-center gap-3">
                        <span class="badge bg-primary" id="session-count"><?= count($sessions) ?> cuộc trò chuyện</span>
                        <button class="btn btn-outline-primary btn-sm" onclick="window.location.reload()">
                            <i class="fas fa-sync-alt"></i> Làm mới
                        </button>
                    </div>
                </div>
                
                <div class="row flex-grow-1 h-100">
                    <div class="col-md-3 border-end chat-left-panel h-100 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0" style="color:#6c63ff; font-weight:700;">
                                <i class="fas fa-list"></i> Danh sách Chat
                            </h5>
                        </div>
                        
                        <div class="chat-session-list-container flex-grow-1 overflow-auto">
                            <?php if (empty($sessions)): ?>
                                <div class="text-center text-muted py-5"><i class="fas fa-comments fa-3x mb-3"></i><p>Chưa có cuộc trò chuyện nào</p></div>
                            <?php else: ?>
                                <?php foreach($sessions as $session): ?>
                                <div class="session-item p-3 mb-2 rounded <?= $session['chat_id'] == $selected_id ? 'active' : '' ?>" 
                                     onclick="selectSession(<?= $session['chat_id'] ?>)" style="cursor: pointer;" data-chat-id="<?= $session['chat_id'] ?>">
                                    <div class="d-flex align-items-start">
                                        <div class="session-avatar me-3">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:45px;height:45px;background:linear-gradient(135deg, #667eea 0%, #764ba2 100%);color:white;font-weight:700;">
                                                <?= strtoupper(substr($session['customer_name'] ?? 'U', 0, 1)) ?>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 min-width-0">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <h6 class="mb-0 text-truncate" style="font-weight: 600;"><?= htmlspecialchars($session['customer_name'] ?? 'Khách hàng') ?></h6>
                                                <small class="text-muted"><?= timeAgo($session['last_message_time']) ?></small>
                                            </div>
                                            <p class="mb-1 text-muted small text-truncate"><?= htmlspecialchars(substr($session['last_message'], 0, 50)) ?><?= strlen($session['last_message']) > 50 ? '...' : '' ?></p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-primary"><i class="fas fa-hashtag"></i> <?= $session['chat_id'] ?></small>
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="badge bg-light text-dark"><?= $session['message_count'] ?> tin nhắn</span>
                                                    <?php if ($session['unread_count'] > 0): ?>
                                                    <span class="badge bg-danger rounded-pill float-end"><?= $session['unread_count'] ?> mới</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-9 chat-right-panel h-100">
                        <div class="bg-light rounded h-100 d-flex flex-column chat-main-content">
                            <div class="chat-header p-3 mb-2">
                                <?php if ($current_session): ?>
                                    <h6 class="mb-0 text-truncate"><?= htmlspecialchars($current_session['customer_name'] ?? 'Khách hàng') ?></h6>
                                    <small class="text-muted">Chat ID: <?= $current_session['chat_id'] ?> - <?= $current_session['unread_count'] > 0 ? 'Đang chờ' : 'Đã phản hồi' ?></small>
                                <?php else: ?>
                                    <h6 class="mb-0">Chọn một cuộc trò chuyện</h6>
                                <?php endif; ?>
                            </div>
                            
                            <div class="p-3 chat-messages flex-grow-1 overflow-auto" id="chat-box">
                                <?php if ($current_session): ?>
                                    <?php if (empty($current_messages)): ?>
                                        <div class="text-center text-muted py-5"><i class="fas fa-inbox fa-3x mb-3"></i><p>Chưa có tin nhắn nào trong cuộc trò chuyện này.</p></div>
                                    <?php else: ?>
                                        <?php foreach ($current_messages as $msg): ?>
                                        <div class="d-flex <?= $msg['is_user_message'] == 1 ? 'justify-content-end' : 'justify-content-start' ?> mb-2 message-item">
                                            <div class="message-bubble <?= $msg['is_user_message'] == 1 ? 'customer-message' : 'admin-message' ?>">
                                                <?= htmlspecialchars($msg['message']) ?>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <div class="text-center text-muted py-5"><i class="fas fa-comment-dots fa-3x mb-3"></i><p>Vui lòng chọn một cuộc trò chuyện để bắt đầu.</p></div>
                                <?php endif; ?>
                            </div>
                            
                            <form id="send-message-form" class="chat-input p-3 border-top">
                                <input type="hidden" name="action" value="send_message">
                                <input type="hidden" name="chat_id" id="chat_id_input" value="<?= $selected_id ?>">
                                <div class="input-group">
                                    <input type="text" name="message" id="message-input" class="form-control" placeholder="Nhập tin nhắn..." autocomplete="off" required <?= $selected_id == 0 ? 'disabled' : '' ?>>
                                    <button class="btn btn-primary" type="submit" id="button-addon2" <?= $selected_id == 0 ? 'disabled' : '' ?>><i class="fas fa-paper-plane"></i> Gửi</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
const currentChatId = <?= $selected_id ?>;
const chatBox = document.getElementById('chat-box');
const sessionListContainer = document.querySelector('.chat-session-list-container');
const sendMessageForm = document.getElementById('send-message-form');
const messageInput = document.getElementById('message-input');

// Hàm chuyển đến session khác
function selectSession(chatId) {
    window.location.href = `admin_chat.php?id=${chatId}`;
}

// Hàm cuộn xuống cuối khung chat
function scrollToBottom() {
    if (chatBox) {
        chatBox.scrollTop = chatBox.scrollHeight;
    }
}

// Hàm fetch và render lại danh sách tin nhắn
async function fetchMessages(chatId) {
    if (!chatId || chatId === 0) return;

    try {
        const response = await fetch(`chat_api.php?action=get_messages&chat_id=${chatId}`);
        const messages = await response.json();
        
        // Chỉ render lại nếu nội dung có thay đổi để tránh giật màn hình
        const currentMessageCount = chatBox.querySelectorAll('.message-item').length;
        if (messages.length === currentMessageCount) {
            return;
        }

        chatBox.innerHTML = ''; // Xóa tin nhắn cũ

        if (messages.length === 0) {
            chatBox.innerHTML = `<div class="text-center text-muted py-5"><i class="fas fa-inbox fa-3x mb-3"></i><p>Chưa có tin nhắn nào.</p></div>`;
        } else {
            messages.forEach(msg => {
                const messageItem = document.createElement('div');
                messageItem.className = `d-flex ${msg.is_user_message == 1 ? 'justify-content-end' : 'justify-content-start'} mb-2 message-item`;
                
                const messageBubble = document.createElement('div');
                messageBubble.className = `message-bubble ${msg.is_user_message == 1 ? 'customer-message' : 'admin-message'}`;
                messageBubble.textContent = msg.message;
                
                messageItem.appendChild(messageBubble);
                chatBox.appendChild(messageItem);
            });
        }
        scrollToBottom();
    } catch (error) {
        console.error('Lỗi khi tải tin nhắn:', error);
    }
}

// Hàm fetch và render lại danh sách các cuộc trò chuyện
async function fetchSessions() {
    try {
        const response = await fetch(`chat_api.php?action=get_sessions`);
        const sessions = await response.json();

        document.getElementById('session-count').textContent = `${sessions.length} cuộc trò chuyện`;
        sessionListContainer.innerHTML = ''; // Xóa list cũ

        if (sessions.length === 0) {
            sessionListContainer.innerHTML = `<div class="text-center text-muted py-5"><i class="fas fa-comments fa-3x mb-3"></i><p>Chưa có cuộc trò chuyện nào</p></div>`;
        } else {
            sessions.forEach(session => {
                const isActive = session.chat_id == currentChatId ? 'active' : '';
                const unreadBadge = session.unread_count > 0 ? `<span class="badge bg-danger rounded-pill float-end">${session.unread_count} mới</span>` : '';
                const lastMessage = session.last_message ? (session.last_message.length > 50 ? session.last_message.substring(0, 50) + '...' : session.last_message) : '';
                
                const sessionHTML = `
                <div class="session-item p-3 mb-2 rounded ${isActive}" onclick="selectSession(${session.chat_id})" style="cursor: pointer;" data-chat-id="${session.chat_id}">
                    <div class="d-flex align-items-start">
                        <div class="session-avatar me-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:45px;height:45px;background:linear-gradient(135deg, #667eea 0%, #764ba2 100%);color:white;font-weight:700;">
                                ${session.customer_name ? session.customer_name.charAt(0).toUpperCase() : 'U'}
                            </div>
                        </div>
                        <div class="flex-grow-1 min-width-0">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h6 class="mb-0 text-truncate" style="font-weight: 600;">${session.customer_name || 'Khách hàng'}</h6>
                                <small class="text-muted">${session.time_ago}</small>
                            </div>
                            <p class="mb-1 text-muted small text-truncate">${lastMessage}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-primary"><i class="fas fa-hashtag"></i> ${session.chat_id}</small>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-light text-dark">${session.message_count} tin nhắn</span>
                                    ${unreadBadge}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
                sessionListContainer.innerHTML += sessionHTML;
            });
        }
    } catch (error) {
        console.error('Lỗi khi tải danh sách chat:', error);
    }
}


// Xử lý gửi tin nhắn qua AJAX
sendMessageForm.addEventListener('submit', async function(event) {
    event.preventDefault(); // Ngăn form reload lại trang

    const formData = new FormData(sendMessageForm);
    const messageText = messageInput.value.trim();
    
    if (messageText === '' || currentChatId === 0) return;
    
    // Tạm thời vô hiệu hóa form để tránh gửi nhiều lần
    messageInput.disabled = true;
    sendMessageForm.querySelector('button').disabled = true;
    
    try {
        const response = await fetch('chat_api.php', {
            method: 'POST',
            body: formData
        });
        const result = await response.json();

        if (result.status === 'success') {
            messageInput.value = ''; // Xóa nội dung trong ô nhập
            await fetchMessages(currentChatId); // Tải lại tin nhắn ngay lập tức
            await fetchSessions(); // Cập nhật lại list bên trái (vì tin nhắn mới đã được gửi)
        } else {
            alert('Lỗi: ' + result.message); // Hiển thị lỗi nếu có
        }
    } catch (error) {
        console.error('Lỗi khi gửi tin nhắn:', error);
        alert('Đã xảy ra lỗi kết nối. Vui lòng thử lại.');
    } finally {
        // Bật lại form
        messageInput.disabled = false;
        sendMessageForm.querySelector('button').disabled = false;
        messageInput.focus();
    }
});


// Tự động cập nhật và cuộn xuống dưới
document.addEventListener('DOMContentLoaded', function() {
    scrollToBottom();

    // BỎ ĐI CÁI SETINTERVAL RELOAD CŨ
    // Thay vào đó, chúng ta sẽ gọi fetch định kỳ
    
    // Cập nhật danh sách chat (cột trái) mỗi 10 giây
    setInterval(fetchSessions, 10000); 

    // Cập nhật tin nhắn (khung chat chính) mỗi 3 giây
    setInterval(() => {
        fetchMessages(currentChatId);
    }, 3000);
});
</script>

</body>
</html>