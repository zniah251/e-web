<?php
session_start();
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['uid']) || $_SESSION['uid'] <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Vui lòng đăng nhập để thực hiện thao tác này.'
    ]);
    exit;
}

// Include database connection
include $_SERVER['DOCUMENT_ROOT'] . "/e-web/connect.php";

// Get JSON data from request
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!isset($data['order_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Thiếu thông tin đơn hàng.'
    ]);
    exit;
}

$orderId = intval($data['order_id']);
$userId = $_SESSION['uid'];

$response = ['success' => false];

try {
    // First check if the order belongs to the user and is in Pending status
    $checkQuery = "SELECT destatus FROM orders WHERE oid = ? AND uid = ? AND destatus = 'Pending' LIMIT 1";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ii", $orderId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Không thể hủy đơn hàng này. Đơn hàng không tồn tại hoặc không ở trạng thái chờ xác nhận.'
        ]);
        exit;
    }

    // Update the order status to Cancelled
    $updateQuery = "UPDATE orders SET destatus = 'Cancelled' WHERE oid = ? AND uid = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ii", $orderId, $userId);
    $success = $stmt->execute();
    $stmt->close();

    // Get vid of the order (if any)
    $stmt = $conn->prepare("SELECT vid FROM orders WHERE oid = ? AND uid = ?");
    $stmt->bind_param("ii", $orderId, $userId);
    $stmt->execute();
    $stmt->bind_result($vid);
    $stmt->fetch();
    $stmt->close();

    // If the order used a voucher, update user_voucher.status to 'unused'
    if ($success && $vid) {
        $stmt = $conn->prepare("UPDATE user_voucher SET status = 'unused' WHERE uid = ? AND vid = ?");
        $stmt->bind_param("ii", $userId, $vid);
        $stmt->execute();
        $stmt->close();
    }

    $response['success'] = $success;
    $response['message'] = $success ? 'Đơn hàng đã được hủy thành công.' : 'Có lỗi xảy ra khi hủy đơn hàng.';
} catch (Exception $e) {
    $response['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
}

echo json_encode($response);

$conn->close();