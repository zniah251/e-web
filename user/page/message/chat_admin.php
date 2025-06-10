<?php
session_start();

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "e-web";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    error_log("Kết nối thất bại: " . $conn->connect_error); // Log the error
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Lỗi kết nối cơ sở dữ liệu.']);
    exit();
}

// Parse JSON body nếu Content-Type là application/json
if (isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] === 'application/json') {
    $json = file_get_contents('php://input');
    $_POST = json_decode($json, true) ?? [];
}

// Kiểm tra đăng nhập
if (!isset($_SESSION['uid'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập để sử dụng chat']);
    exit();
}

$user_id = $_SESSION['uid'];

// Lấy action từ request
$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'get_latest_session':
        getLatestSession($conn, $user_id);
        break;

    case 'send_message':
        sendMessage($conn, $user_id);
        break;

    case 'send_admin_message':
        sendAdminMessage($conn);
        break;

    case 'get_messages':
        getMessages($conn, $user_id);
        break;

    case 'get_sessions':
        getSessions($conn, $user_id);
        break;

    default:
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Action không hợp lệ']);
        break;
}

// Hàm lấy session chat gần nhất
function getLatestSession($conn, $user_id) {
    try {
        // Debug log
        error_log("DEBUG: Getting latest session for user_id: " . $user_id);
        
        // Tìm session chat gần nhất của user
        $sql = "SELECT DISTINCT chat_id, MAX(created_at) as last_message
                FROM user_chat 
                WHERE uid = ? 
                GROUP BY chat_id 
                ORDER BY last_message DESC 
                LIMIT 1";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $session = $result->fetch_assoc();
            error_log("DEBUG: Found latest session: chat_id=" . $session['chat_id']);
            echo json_encode([
                'success' => true, 
                'chat_id' => $session['chat_id']
            ]);
        } else {
            // Chưa có session nào
            error_log("DEBUG: No sessions found for user_id: " . $user_id);
            echo json_encode([
                'success' => true, 
                'chat_id' => null
            ]);
        }
        
    } catch (Exception $e) {
        error_log("DEBUG: Error in getLatestSession: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Lỗi server: ' . $e->getMessage()]);
    }
}

// Hàm tạo chat_id mới
function generateChatId($user_id) {
    // Tạo chat_id từ timestamp + random để đảm bảo tính duy nhất
    $timestamp = time();
    $random = rand(10, 99); // 2 chữ số random
    
    // Lấy 7 chữ số cuối của timestamp + 2 chữ số random = 9 chữ số
    $chat_id = intval(substr($timestamp, -7) . $random);
    
    // Đảm bảo chat_id không vượt quá giới hạn int(11)
    if ($chat_id > 2147483647) {
        $chat_id = intval(substr($timestamp, -8));
    }
    
    return $chat_id;
}

// Hàm gửi tin nhắn
function sendMessage($conn, $user_id) {
    try {
        $chat_id = $_POST['chat_id'] ?? null;
        $message = trim($_POST['message'] ?? '');
        
        if (empty($message)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Tin nhắn không được để trống']);
            return;
        }
        
        // Tạo chat_id mới nếu chưa có
        if (empty($chat_id)) {
            $chat_id = generateChatId($user_id);
        }
        
        // Thêm tin nhắn user vào database
        $sql = "INSERT INTO user_chat (chat_id, uid, message, is_user_message) 
                VALUES (?, ?, ?, 1)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $chat_id, $user_id, $message);
        
        if ($stmt->execute()) {
            $message_id = $conn->insert_id;
            
            // Kiểm tra xem đây có phải tin nhắn đầu tiên của session không
            $count_sql = "SELECT COUNT(*) as count FROM user_chat WHERE chat_id = ?";
            $count_stmt = $conn->prepare($count_sql);
            $count_stmt->bind_param("i", $chat_id);
            $count_stmt->execute();
            $count_result = $count_stmt->get_result();
            $count = $count_result->fetch_assoc()['count'];
            
            $response = [
                'success' => true,
                'message_id' => $message_id,
                'chat_id' => $chat_id,
                'message' => 'Tin nhắn đã được gửi',
                'is_first_message' => $count == 1
            ];
            
            // Nếu là tin nhắn đầu tiên, tự động gửi tin nhắn chào mừng
            if ($count == 1) {
                $welcome_message = "Cảm ơn bạn đã liên hệ với Kaira Shop! Chúng tôi đã nhận được tin nhắn và sẽ phản hồi sớm nhất. Vui lòng đợi trong giây lát.";
                
                $welcome_sql = "INSERT INTO user_chat (chat_id, message, is_user_message) 
                               VALUES (?, ?, 0)";
                
                $welcome_stmt = $conn->prepare($welcome_sql);
                $welcome_stmt->bind_param("is", $chat_id, $welcome_message);
                $welcome_stmt->execute();
                
                $response['auto_reply'] = [
                    'message_id' => $conn->insert_id,
                    'message' => $welcome_message,
                    'created_at' => date('Y-m-d H:i:s')
                ];
            }
            
            echo json_encode($response);
        } else {
            throw new Exception('Không thể gửi tin nhắn');
        }
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Lỗi server: ' . $e->getMessage()]);
    }
}

// Hàm gửi tin nhắn admin
function sendAdminMessage($conn) {
    try {
        $chat_id = $_POST['chat_id'] ?? null;
        $message = trim($_POST['message'] ?? '');

        if (empty($chat_id) || empty($message)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Thiếu chat_id hoặc message']);
            return;
        }

        // Lấy uid của user trong chat này (nếu cần)
        $get_uid_sql = "SELECT uid FROM user_chat WHERE chat_id = ? AND uid IS NOT NULL LIMIT 1";
        $get_uid_stmt = $conn->prepare($get_uid_sql);
        $get_uid_stmt->bind_param("i", $chat_id);
        $get_uid_stmt->execute();
        $uid_result = $get_uid_stmt->get_result();
        $uid = null;
        if ($uid_result->num_rows > 0) {
            $uid = $uid_result->fetch_assoc()['uid'];
        }

        $sql = "INSERT INTO user_chat (chat_id, uid, message, is_user_message) VALUES (?, ?, ?, 0)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $chat_id, $uid, $message);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Tin nhắn admin đã được gửi']);
        } else {
            throw new Exception('Không thể gửi tin nhắn admin');
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Lỗi server: ' . $e->getMessage()]);
    }
}

// Hàm lấy tin nhắn
function getMessages($conn, $user_id) {
    try {
        $chat_id = $_GET['chat_id'] ?? '';
        
        if (empty($chat_id)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Thiếu chat_id']);
            return;
        }
        
        // Debug log
        error_log("DEBUG: Getting messages for chat_id: " . $chat_id . ", user_id: " . $user_id);
        
        // Lấy tất cả tin nhắn của session này
        $sql = "SELECT message_id, message, is_user_message, uc.created_at,
                       CASE WHEN is_user_message = 1 THEN 'user' ELSE 'admin' END as sender,
                       u.uname as customer_name
                FROM user_chat uc
                LEFT JOIN users u ON uc.uid = u.uid
                WHERE uc.chat_id = ? 
                ORDER BY uc.created_at ASC";
        
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            error_log("SQL Prepare failed in getMessages: " . $conn->error);
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Lỗi SQL: ' . $conn->error]);
            exit();
        }
        $stmt->bind_param("i", $chat_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $messages = [];
        while ($row = $result->fetch_assoc()) {
            $messages[] = [
                'message_id' => $row['message_id'],
                'text' => $row['message'],
                'sender' => $row['sender'],
                'is_user_message' => $row['is_user_message'],
                'time' => date('H:i', strtotime($row['created_at'])),
                'created_at' => $row['created_at'],
                'customer_name' => $row['customer_name']
            ];
        }
        
        // Debug log
        error_log("DEBUG: Found " . count($messages) . " messages for chat_id: " . $chat_id);
        
        echo json_encode(['success' => true, 'messages' => $messages]);
        
    } catch (Exception $e) {
        error_log("DEBUG: Error in getMessages: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Lỗi server: ' . $e->getMessage()]);
    }
}

// Hàm lấy danh sách sessions
function getSessions($conn, $user_id) {
    try {
        $sql = "SELECT uc.chat_id, 
                       MIN(uc.created_at) as started_at,
                       MAX(uc.created_at) as last_message,
                       COUNT(*) as message_count,
                       (SELECT message FROM user_chat uc2 
                        WHERE uc2.chat_id = uc.chat_id 
                        ORDER BY created_at DESC LIMIT 1) as last_message_text,
                       u.uname as customer_name
                FROM user_chat uc
                LEFT JOIN users u ON uc.uid = u.uid
                WHERE uc.uid = ?
                GROUP BY uc.chat_id, u.uname
                ORDER BY last_message DESC
                LIMIT 10";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $sessions = [];
        while ($row = $result->fetch_assoc()) {
            $sessions[] = [
                'chat_id' => $row['chat_id'],
                'started_at' => date('d/m/Y H:i', strtotime($row['started_at'])),
                'last_message' => date('d/m/Y H:i', strtotime($row['last_message'])),
                'message_count' => $row['message_count'],
                'last_message_text' => substr($row['last_message_text'], 0, 50) . '...',
                'customer_name' => $row['customer_name']
            ];
        }
        
        echo json_encode(['success' => true, 'sessions' => $sessions]);
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Lỗi server: ' . $e->getMessage()]);
    }
}

$conn->close();
?>

