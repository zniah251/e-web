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
    // If it's an AJAX request, send JSON error; otherwise, display friendly message
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Lỗi kết nối cơ sở dữ liệu.']);
    } else {
        die("Không thể kết nối đến cơ sở dữ liệu. Vui lòng thử lại sau.");
    }
    exit();
}

// Parse JSON body if Content-Type is application/json
if (isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] === 'application/json') {
    $json = file_get_contents('php://input');
    $_POST = json_decode($json, true) ?? [];
}

// Determine if it's an AJAX request or a page load
$is_ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
$action = $_POST['action'] ?? $_GET['action'] ?? '';

// If it's an AJAX request, process the action and exit
if ($is_ajax || !empty($action)) { // Added !empty($action) to catch explicit action requests even without X-Requested-With header
    // Kiểm tra đăng nhập chỉ khi xử lý AJAX actions
    if (!isset($_SESSION['uid'])) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập để sử dụng chat']);
        exit();
    }

    $user_id = $_SESSION['uid']; // Assume $_SESSION['uid'] is set from a prior login

    switch ($action) {
        case 'get_latest_session':
            getLatestSession($conn, $user_id);
            break;

        case 'send_message':
            sendMessage($conn, $user_id);
            break;

        case 'send_admin_message': // This would typically be for an admin panel
            sendAdminMessage($conn);
            break;

        case 'get_messages':
            getMessages($conn, $user_id);
            break;

        case 'get_sessions': // This would typically be for an admin panel
            getSessions($conn, $user_id);
            break;

        default:
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Action không hợp lệ']);
            break;
    }
    $conn->close();
    exit(); // Important: exit after handling AJAX request
}

// --- Functions (remain the same as in your original PHP file) ---

// Hàm lấy session chat gần nhất
function getLatestSession($conn, $user_id) {
    try {
        error_log("DEBUG: Getting latest session for user_id: " . $user_id);
        
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
    $timestamp = time();
    $random = rand(10, 99);
    
    $chat_id = intval(substr($timestamp, -7) . $random);
    
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
        
        if (empty($chat_id)) {
            $chat_id = generateChatId($user_id);
        }
        
        $sql = "INSERT INTO user_chat (chat_id, uid, message, is_user_message) 
                VALUES (?, ?, ?, 1)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $chat_id, $user_id, $message);
        
        if ($stmt->execute()) {
            $message_id = $conn->insert_id;
            
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
        
        error_log("DEBUG: Getting messages for chat_id: " . $chat_id . ", user_id: " . $user_id);
        
        // First, verify that this user has access to this chat_id
        $verify_sql = "SELECT COUNT(*) as count FROM user_chat WHERE chat_id = ? AND uid = ?";
        $verify_stmt = $conn->prepare($verify_sql);
        $verify_stmt->bind_param("ii", $chat_id, $user_id);
        $verify_stmt->execute();
        $verify_result = $verify_stmt->get_result();
        $verify_count = $verify_result->fetch_assoc()['count'];
        
        if ($verify_count == 0) {
            error_log("DEBUG: User " . $user_id . " does not have access to chat_id: " . $chat_id);
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Không có quyền truy cập vào cuộc trò chuyện này']);
            return;
        }
        
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

$conn->close(); // Close connection after processing AJAX or before rendering HTML

// --- HTML and JavaScript for the chat interface ---
// This part will only execute if it's NOT an AJAX request
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kaira Shop Chat</title>
    <style>
        /* Your CSS from the previous example */
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; display: flex; justify-content: center; align-items: center; min-height: 100vh; background-color: #f4f4f4; }
        .chat-container { width: 400px; background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); display: flex; flex-direction: column; height: 600px; overflow: hidden; }
        .chat-header { background-color: #007bff; color: white; padding: 15px; text-align: center; font-size: 1.2em; border-top-left-radius: 8px; border-top-right-radius: 8px; }
        .chat-messages { flex-grow: 1; padding: 15px; overflow-y: auto; border-bottom: 1px solid #eee; }
        .message-bubble { padding: 8px 12px; border-radius: 20px; margin-bottom: 10px; max-width: 70%; word-wrap: break-word; }
        .message-bubble.user { background-color: #dcf8c6; float: right; clear: both; }
        .message-bubble.admin { background-color: #e2e2e2; float: left; clear: both; }
        .message-time { font-size: 0.75em; color: #888; margin-top: 5px; text-align: right; }
        .message-bubble.admin .message-time { text-align: left; }
        .chat-input { display: flex; padding: 15px; border-top: 1px solid #eee; }
        .chat-input input[type="text"] { flex-grow: 1; padding: 10px; border: 1px solid #ddd; border-radius: 20px; outline: none; }
        .chat-input button { background-color: #007bff; color: white; border: none; padding: 10px 15px; border-radius: 20px; margin-left: 10px; cursor: pointer; transition: background-color 0.3s ease; }
        .chat-input button:hover { background-color: #0056b3; }
        .system-message { text-align: center; font-style: italic; color: #666; margin-bottom: 10px; font-size: 0.9em; }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">Kaira Shop Chat</div>
        <div class="chat-messages" id="chat-messages">
            </div>
        <div class="chat-input">
            <input type="text" id="message-input" placeholder="Nhập tin nhắn...">
            <button id="send-button">Gửi</button>
        </div>
    </div>

    <script>
        const chatMessagesDiv = document.getElementById('chat-messages');
        const messageInput = document.getElementById('message-input');
        const sendButton = document.getElementById('send-button');

        let currentChatId = null;
        let lastMessageId = 0; // To track the last message loaded and only fetch new ones
        let isInitialLoad = true; // Flag to track if this is the first load
        let pollingInterval = null; // Store the polling interval
        let lastPollTime = 0; // Track last poll time to avoid too frequent requests
        let isSendingMessage = false; // Flag to prevent polling while sending message

        function scrollToBottom() {
            chatMessagesDiv.scrollTop = chatMessagesDiv.scrollHeight;
        }

        async function getLatestSession() {
            try {
                // Fetch from the same PHP file, but specify the action
                const response = await fetch('<?php echo basename(__FILE__); ?>?action=get_latest_session');
                const data = await response.json();

                if (data.success) {
                    currentChatId = data.chat_id;
                    console.log('Current Chat ID:', currentChatId);
                    if (currentChatId) {
                        fetchMessages();
                    } else {
                        console.log('No existing chat sessions.');
                    }
                } else {
                    console.error('Error getting latest session:', data.message);
                    alert(data.message);
                }
            } catch (error) {
                console.error('Network error fetching latest session:', error);
                alert('Lỗi kết nối đến server.');
            }
        }

        async function fetchMessages() {
            if (!currentChatId || isSendingMessage) {
                console.log("No chat ID to fetch messages for yet or currently sending message.");
                return;
            }

            // Avoid too frequent polling (minimum 2 seconds between requests)
            const now = Date.now();
            if (now - lastPollTime < 2000) {
                return;
            }
            lastPollTime = now;

            try {
                // Fetch from the same PHP file, but specify the action
                const response = await fetch(`<?php echo basename(__FILE__); ?>?action=get_messages&chat_id=${currentChatId}`);
                
                // Check if response is ok before parsing JSON
                if (!response.ok) {
                    console.error('HTTP error:', response.status, response.statusText);
                    if (response.status === 403) {
                        clearInterval(pollingInterval);
                        alert('Không có quyền truy cập vào cuộc trò chuyện này');
                    }
                    return;
                }
                
                const data = await response.json();

                if (data.success) {
                    // Clear messages only on initial load
                    if (isInitialLoad) {
                        chatMessagesDiv.innerHTML = '';
                        lastMessageId = 0;
                        isInitialLoad = false;
                    }

                    // Process new messages
                    let hasNewMessages = false;
                    if (data.messages && Array.isArray(data.messages)) {
                        data.messages.forEach(msg => {
                            if (msg.message_id > lastMessageId) {
                                const messageBubble = document.createElement('div');
                                messageBubble.classList.add('message-bubble');
                                messageBubble.classList.add(msg.sender); // 'user' or 'admin'

                                messageBubble.innerHTML = `
                                    <div>${msg.text}</div>
                                    <div class="message-time">${msg.time}</div>
                                `;
                                chatMessagesDiv.appendChild(messageBubble);
                                lastMessageId = Math.max(lastMessageId, msg.message_id); // Update last message ID
                                hasNewMessages = true;
                            }
                        });
                    }

                    // Only scroll to bottom if there are new messages
                    if (hasNewMessages) {
                        scrollToBottom();
                        console.log('New messages received, scrolling to bottom');
                    }
                } else {
                    console.error('Error fetching messages:', data.message);
                }
            } catch (error) {
                console.error('Network error fetching messages:', error);
                // Don't show alert for network errors during polling to avoid spam
            }
        }

        async function sendMessage() {
            const message = messageInput.value.trim();
            if (message === '') {
                alert('Tin nhắn không được để trống.');
                return;
            }

            // Set flag to prevent polling while sending
            isSendingMessage = true;
            
            // Disable send button to prevent double sending
            sendButton.disabled = true;

            const formData = new FormData();
            formData.append('action', 'send_message');
            if (currentChatId) {
                formData.append('chat_id', currentChatId);
            }
            formData.append('message', message);

            try {
                // Send to the same PHP file
                const response = await fetch('<?php echo basename(__FILE__); ?>', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest' // Add this header to identify AJAX requests
                    }
                });
                
                // Check if response is ok before parsing JSON
                if (!response.ok) {
                    throw new Error(`HTTP error: ${response.status}`);
                }
                
                const data = await response.json();

                if (data.success) {
                    messageInput.value = ''; // Clear input
                    currentChatId = data.chat_id; // Update chat_id in case it was newly generated
                    
                    // If this is a new chat session, reset the initial load flag
                    if (data.is_first_message) {
                        isInitialLoad = true;
                        lastMessageId = 0;
                    }
                    
                    // Wait a bit before fetching messages to ensure server has processed the message
                    setTimeout(() => {
                        fetchMessages(); // Refresh messages to show the sent message and auto-reply
                        isSendingMessage = false; // Reset flag
                        sendButton.disabled = false; // Re-enable send button
                    }, 500);
                } else {
                    console.error('Error sending message:', data.message);
                    alert(data.message);
                    isSendingMessage = false; // Reset flag on error
                    sendButton.disabled = false; // Re-enable send button
                }
            } catch (error) {
                console.error('Network error sending message:', error);
                alert('Lỗi kết nối khi gửi tin nhắn.');
                isSendingMessage = false; // Reset flag on error
                sendButton.disabled = false; // Re-enable send button
            }
        }

        // Event listeners
        sendButton.addEventListener('click', sendMessage);
        messageInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

        // Initial load
        getLatestSession();

        // Start polling for new messages (every 3 seconds)
        pollingInterval = setInterval(fetchMessages, 3000);

        // Clean up interval when page is unloaded
        window.addEventListener('beforeunload', () => {
            if (pollingInterval) {
                clearInterval(pollingInterval);
            }
        });
    </script>
</body>
</html>