<?php
// chat_api.php

// Bắt buộc phải có để sử dụng $_SESSION và kết nối DB
require_once $_SERVER['DOCUMENT_ROOT'] . "/e-web/connect.php";
session_start();

// Bảo mật: Đảm bảo chỉ admin mới có thể truy cập API này
if (!isset($_SESSION['uid']) || !isset($_SESSION['rid']) || $_SESSION['rid'] != 1) {
    header('Content-Type: application/json');
    http_response_code(403); // Forbidden
    echo json_encode(['status' => 'error', 'message' => 'Authentication failed.']);
    exit();
}

// Hàm timeAgo bạn đã có
function timeAgo($datetime) {
    if (!$datetime) return 'Không có';
    $time = strtotime($datetime);
    $diff = time() - $time;
    if ($diff < 60) return $diff . ' giây trước';
    if ($diff < 3600) return floor($diff/60) . ' phút trước';
    if ($diff < 86400) return floor($diff/3600) . ' giờ trước';
    return floor($diff/86400) . ' ngày trước';
}

// Lấy danh sách sessions từ database (sao chép từ file cũ)
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
    $sessions = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    
    // Thêm trường 'time_ago' vào kết quả để JS sử dụng
    foreach ($sessions as &$session) {
        $session['time_ago'] = timeAgo($session['last_message_time']);
    }
    
    return $sessions;
}

// Lấy tin nhắn theo chat_id (sao chép từ file cũ)
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

// Router cho các hành động của API
$action = $_REQUEST['action'] ?? '';
header('Content-Type: application/json'); // Luôn trả về dữ liệu dạng JSON

switch ($action) {
    case 'get_sessions':
        echo json_encode(getChatSessions($conn));
        break;

    case 'get_messages':
        $chat_id = isset($_GET['chat_id']) ? intval($_GET['chat_id']) : 0;
        if ($chat_id > 0) {
            echo json_encode(getChatMessages($conn, $chat_id));
        } else {
            echo json_encode([]);
        }
        break;

    case 'send_message':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
                    $customer_uid = $uid_result->fetch_assoc()['uid'];

                    $sql = "INSERT INTO user_chat (chat_id, uid, message, is_user_message) VALUES (?, ?, ?, 0)";
                    $stmt = $conn->prepare($sql);
                    
                    if ($stmt) {
                        $stmt->bind_param("iis", $chat_id, $customer_uid, $message);
                        if ($stmt->execute()) {
                            echo json_encode(['status' => 'success']);
                        } else {
                            echo json_encode(['status' => 'error', 'message' => 'Execute failed: ' . $stmt->error]);
                        }
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'Prepare failed: ' . $conn->error]);
                    }
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'User not found for this chat.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid message or chat ID.']);
            }
        }
        break;

    default:
        http_response_code(400); // Bad Request
        echo json_encode(['status' => 'error', 'message' => 'Invalid action.']);
        break;
}

exit();