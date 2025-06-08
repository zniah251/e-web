<?php
require_once "../../../connect.php";

// Nhận dữ liệu JSON từ MoMo gửi về
$data = json_decode(file_get_contents('php://input'), true);

// Nếu test thủ công, bạn cũng có thể debug log bằng:
// file_put_contents("log.txt", json_encode($data, JSON_PRETTY_PRINT));

$orderId = $data['orderId'] ?? '';
$resultCode = $data['resultCode'] ?? -1; // 0 là thanh toán thành công

if (!$orderId) {
    // Nếu không có mã đơn hàng, redirect về failed
    header("Location: payment_result.php?status=failed");
    exit;
}

if ($resultCode == 0) {
    // Thanh toán thành công → cập nhật DB
    $stmt = $conn->prepare("UPDATE `order` SET paystatus='Paid', paytime=NOW() WHERE oid = ?");
    $stmt->bind_param("s", $orderId);
    $success = $stmt->execute();

    // Redirect tới trang kết quả
    if ($success) {
        header("Location: payment_result.php?status=success&orderId=$orderId");
    } else {
        header("Location: payment_result.php?status=failed");
    }
    exit;
} else {
    // Nếu thanh toán thất bại (bị huỷ hoặc lỗi)
    header("Location: payment_result.php?status=failed");
    exit;
}
