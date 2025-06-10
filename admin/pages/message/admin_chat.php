<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$currentPage = 'messages';
include $_SERVER['DOCUMENT_ROOT'] . "/e-web/connect.php";

// Lấy danh sách sessions từ database
function getChatSessions($conn) {
    $sql = "SELECT 
                uc.chat_id,
                u.uname as customer_name,
                u.uid,
                COUNT(uc.message_id) as message_count,
                MAX(uc.created_at) as last_message_time,
                (SELECT message FROM user_chat uc2 
                 WHERE uc2.chat_id = uc.chat_id 
                 ORDER BY created_at DESC LIMIT 1) as last_message,
                SUM(CASE WHEN uc.is_user_message = 1 AND uc.created_at > COALESCE(
                    (SELECT MAX(created_at) FROM user_chat uc3 
                     WHERE uc3.chat_id = uc.chat_id AND uc3.is_user_message = 0), '2000-01-01'
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
    $sql = "SELECT 
                uc.message_id,
                uc.message,
                uc.is_user_message,
                uc.created_at,
                u.uname as customer_name
            FROM user_chat uc
            LEFT JOIN users u ON uc.uid = u.uid
            WHERE uc.chat_id = ?
            ORDER BY uc.created_at ASC";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $chat_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

// Xử lý gửi tin nhắn admin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'send_message') {
    error_log("DEBUG: Admin message POST data: " . print_r($_POST, true));
    $chat_id = intval($_POST['chat_id']);
    $message = trim($_POST['message']);
    
    if (!empty($message) && $chat_id > 0) {
        // Lấy uid của khách hàng từ chat_id
        $get_uid_sql = "SELECT uid FROM user_chat WHERE chat_id = ? AND uid IS NOT NULL LIMIT 1";
        $get_uid_stmt = $conn->prepare($get_uid_sql);
        $get_uid_stmt->bind_param("i", $chat_id);
        $get_uid_stmt->execute();
        $uid_result = $get_uid_stmt->get_result();
        
        if ($uid_result->num_rows > 0) {
            $chat_info = $uid_result->fetch_assoc();
            $customer_uid = $chat_info['uid'];
            error_log("DEBUG: Found customer UID for chat_id " . $chat_id . ": " . $customer_uid);

            $sql = "INSERT INTO user_chat (chat_id, uid, message, is_user_message) VALUES (?, ?, ?, 0)";
            $stmt = $conn->prepare($sql);
            
            if ($stmt === false) {
                error_log("DEBUG: Prepare failed: " . $conn->error);
                echo "<div class=\"alert alert-danger\">Lỗi: Không thể chuẩn bị câu lệnh SQL.</div>";
                return;
            }
            error_log("DEBUG: Binding parameters: chat_id=" . $chat_id . ", uid=" . $customer_uid . ", message='" . $message . "'");
            $stmt->bind_param("iis", $chat_id, $customer_uid, $message);
            
            if ($stmt->execute()) {
                error_log("DEBUG: Message sent successfully.");
                header("Location: admin_chat.php?id=" . $chat_id . "&success=1");
                exit();
            } else {
                error_log("DEBUG: Execute failed: " . $stmt->error);
                echo "<div class=\"alert alert-danger\">Lỗi: Không thể gửi tin nhắn. " . htmlspecialchars($stmt->error) . "</div>";
                return;
            }
        } else {
            error_log("DEBUG: No valid UID found for chat_id: " . $chat_id);
            echo "<div class=\"alert alert-warning\">Lỗi: Không tìm thấy người dùng cho cuộc trò chuyện này.</div>";
            return;
        }
    } else {
        error_log("DEBUG: Message or chat_id is empty. Message: '" . $message . "', Chat ID: " . $chat_id);
        echo "<div class=\"alert alert-warning\">Tin nhắn hoặc Chat ID không hợp lệ.</div>";
        return;
    }
}

// Lấy dữ liệu
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

function timeAgo($datetime) {
    $time = strtotime($datetime);
    $diff = time() - $time;
    if ($diff < 60) return $diff . ' giây trước';
    if ($diff < 3600) return floor($diff/60) . ' phút trước';
    if ($diff < 86400) return floor($diff/3600) . ' giờ trước';
    return floor($diff/86400) . ' ngày trước';
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
                        <span class="badge bg-primary"><?= count($sessions) ?> cuộc trò chuyện</span>
                        <button class="btn btn-outline-primary btn-sm" onclick="refreshPage()">
                            <i class="fas fa-sync-alt"></i> Làm mới
                        </button>
                    </div>
                </div>
                
                <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check"></i> Tin nhắn đã được gửi thành công!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <div class="row flex-grow-1 h-100"> <div class="col-md-3 border-end chat-left-panel h-100 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0" style="color:#6c63ff; font-weight:700;">
                                <i class="fas fa-list"></i> Danh sách Chat
                            </h5>
                        </div>
                        
                        <div class="chat-session-list-container flex-grow-1 overflow-auto">
                            <?php if (empty($sessions)): ?>
                                <div class="text-center text-muted py-5">
                                    <i class="fas fa-comments fa-3x mb-3"></i>
                                    <p>Chưa có cuộc trò chuyện nào</p>
                                </div>
                            <?php else: ?>
                                <?php foreach($sessions as $session): ?>
                                <div class="session-item p-3 mb-2 rounded <?= $session['chat_id'] == $selected_id ? 'active' : '' ?>" 
                                    onclick="selectSession(<?= $session['chat_id'] ?>)" style="cursor: pointer;">
                                    <div class="d-flex align-items-start">
                                        <div class="session-avatar me-3">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                                style="width:45px;height:45px;background:linear-gradient(135deg, #667eea 0%, #764ba2 100%);color:white;font-weight:700;">
                                                <?= strtoupper(substr($session['customer_name'] ?? 'U', 0, 1)) ?>
                                            </div>
                                        </div>
                                        
                                        <div class="flex-grow-1 min-width-0">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <h6 class="mb-0 text-truncate" style="font-weight: 600;">
                                                    <?= htmlspecialchars($session['customer_name'] ?? 'Khách hàng') ?>
                                                </h6>
                                                <small class="text-muted"><?= timeAgo($session['last_message_time']) ?></small>
                                            </div>
                                            
                                            <p class="mb-1 text-muted small text-truncate">
                                                <?= htmlspecialchars(substr($session['last_message'], 0, 50)) ?><?= strlen($session['last_message']) > 50 ? '...' : '' ?>
                                            </p>
                                            
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-primary">
                                                    <i class="fas fa-hashtag"></i> <?= $session['chat_id'] ?>
                                                </small>
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
                                        <div class="text-center text-muted py-5">
                                            <i class="fas fa-inbox fa-3x mb-3"></i>
                                            <p>Chưa có tin nhắn nào trong cuộc trò chuyện này.</p>
                                        </div>
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
                                    <div class="text-center text-muted py-5">
                                        <i class="fas fa-comment-dots fa-3x mb-3"></i>
                                        <p>Vui lòng chọn một cuộc trò chuyện để bắt đầu.</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <form action="admin_chat.php" method="POST" class="chat-input p-3 border-top">
                                <input type="hidden" name="action" value="send_message">
                                <input type="hidden" name="chat_id" id="chat_id_input" value="<?= $selected_id ?>">
                                <div class="input-group">
                                    <input type="text" name="message" class="form-control" placeholder="Nhập tin nhắn..." autocomplete="off" required>
                                    <button class="btn btn-primary" type="submit" id="button-addon2"><i class="fas fa-paper-plane"></i> Gửi</button>
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
<script src="/e-web/admin/template/assets/vendors/js/vendor.bundle.base.js"></script>
<script src="/e-web/admin/template/assets/vendors/chart.js/Chart.min.js"></script>
<script src="/e-web/admin/template/assets/vendors/progressbar.js/progressbar.min.js"></script>
<script src="/e-web/admin/template/assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
<script src="/e-web/admin/template/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="/e-web/admin/template/assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
<script src="/e-web/admin/template/assets/js/off-canvas.js"></script>
<script src="/e-web/admin/template/assets/js/hoverable-collapse.js"></script>
<script src="/e-web/admin/template/assets/js/misc.js"></script>
<script src="/e-web/admin/template/assets/js/settings.js"></script>
<script src="/e-web/admin/template/assets/js/todolist.js"></script>
<script src="/e-web/admin/template/assets/js/dashboard.js"></script>
<script>
function selectSession(chatId) {
    window.location.href = `admin_chat.php?id=${chatId}`;
}

function refreshPage() {
    window.location.reload();
}

// Auto scroll to bottom of chat messages
document.addEventListener('DOMContentLoaded', function() {
    const chatMessages = document.querySelector('.chat-messages');
    if (chatMessages) {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    // Chỉ tự động reload nếu đúng là trang admin_chat.php
    if (window.location.pathname.endsWith('/admin/pages/message/admin_chat.php')) {
        setInterval(function() {
            window.location.reload();
        }, 5000);
    }
});
</script>

</body>
</html>