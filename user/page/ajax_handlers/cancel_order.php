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
    
    if ($stmt->execute()) {
        // Get all products from the cancelled order
        $getProductsQuery = "SELECT od.pid, od.quantity, p.stock, p.sold 
                            FROM order_detail od 
                            JOIN product p ON od.pid = p.pid 
                            WHERE od.oid = ?";
        $stmt = $conn->prepare($getProductsQuery);
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $productsResult = $stmt->get_result();

        // Update stock and sold for each product
        while ($product = $productsResult->fetch_assoc()) {
            $newStock = $product['stock'] + $product['quantity'];
            $newSold = $product['sold'] - $product['quantity'];
            
            $updateProductQuery = "UPDATE product 
                                 SET stock = ?, sold = ? 
                                 WHERE pid = ?";
            $stmt = $conn->prepare($updateProductQuery);
            $stmt->bind_param("iii", $newStock, $newSold, $product['pid']);
            $stmt->execute();
        }

        echo json_encode([
            'success' => true,
            'message' => 'Đơn hàng đã được hủy thành công.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Có lỗi xảy ra khi hủy đơn hàng.'
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
    ]);
}

$conn->close(); 