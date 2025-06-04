<?php
// Bật báo lỗi PHP để dễ dàng debug trong môi trường phát triển
// Trong môi trường production, bạn nên tắt hoặc ghi lỗi vào log file
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Bao gồm file kết nối cơ sở dữ liệu
// Điều chỉnh đường dẫn cho phù hợp với cấu trúc dự án của bạn
// Ví dụ: nếu update_product_details.php nằm trong /e-web/admin/pages/product/
// và connect.php nằm trong /e-web/
// thì đường dẫn tương đối sẽ là '../../connect.php' hoặc đường dẫn tuyệt đối như dưới
include $_SERVER['DOCUMENT_ROOT'] . "/e-web/connect.php"; 

// Thiết lập header để trình duyệt biết đây là phản hồi JSON
header('Content-Type: application/json');

// Kiểm tra xem yêu cầu có phải là POST không (chỉ chấp nhận yêu cầu POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ POST request
    // Sử dụng isset() và toán tử ba ngôi để tránh lỗi undefined index
    // và đảm bảo kiểu dữ liệu phù hợp
    $pid = isset($_POST['pid']) ? intval($_POST['pid']) : 0;
    $title = isset($_POST['title']) ? trim($_POST['title']) : ''; // trim() để loại bỏ khoảng trắng thừa
    $thumbnail = isset($_POST['thumbnail']) ? trim($_POST['thumbnail']) : '';
    $price = isset($_POST['price']) ? floatval($_POST['price']) : 0.0;
    $stock = isset($_POST['stock']) ? intval($_POST['stock']) : 0;
    $size = isset($_POST['size']) ? trim($_POST['size']) : '';
    $size2 = isset($_POST['size2']) ? trim($_POST['size2']) : '';
    $size3 = isset($_POST['size3']) ? trim($_POST['size3']) : '';
    $color = isset($_POST['color']) ? trim($_POST['color']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $cid = isset($_POST['category_cid']) ? intval($_POST['category_cid']) : 0; // Category ID

    // Kiểm tra tính hợp lệ cơ bản của dữ liệu
    // Ví dụ: pid phải lớn hơn 0, title không được rỗng
    if ($pid <= 0 || empty($title) || $price < 0 || $stock < 0 || $cid <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid input data. Please check Product ID, Title, Price, Stock, or Category.']);
        $conn->close();
        exit(); // Dừng script nếu dữ liệu không hợp lệ
    }

    // Câu lệnh SQL UPDATE
    // Sử dụng Prepared Statements để ngăn chặn SQL Injection
    $sql = "UPDATE product SET 
                title = ?, 
                thumbnail = ?, 
                price = ?, 
                stock = ?, 
                size = ?, 
                size2 = ?, 
                size3 = ?, 
                color = ?, 
                description = ?, 
                cid = ? 
            WHERE pid = ?";
    
    // Chuẩn bị câu lệnh
    $stmt = $conn->prepare($sql);

    // Kiểm tra lỗi khi chuẩn bị câu lệnh
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Failed to prepare statement: ' . $conn->error]);
        $conn->close();
        exit();
    }
   $stmt->bind_param("ssdississii", 
                    $title, $thumbnail, $price, $stock, 
                    $size, $size2, $size3, $color, $description, $cid, $pid); 

    // Thực thi câu lệnh
    if ($stmt->execute()) {
        // Kiểm tra xem có hàng nào bị ảnh hưởng không
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Product updated successfully.']);
        } else {
            // Nếu affected_rows là 0, có thể query thành công nhưng không có gì thay đổi
            // (ví dụ: dữ liệu gửi lên giống hệt dữ liệu cũ)
            echo json_encode(['success' => true, 'message' => 'Product details are up to date (no changes made).']);
        }
    } else {
        // Xử lý lỗi khi thực thi câu lệnh
        echo json_encode(['success' => false, 'message' => 'Error updating product: ' . $stmt->error]);
    }
    
    // Đóng câu lệnh
    $stmt->close();

} else {
    // Trả về lỗi nếu yêu cầu không phải là POST (ví dụ: truy cập trực tiếp bằng URL)
    echo json_encode(['success' => false, 'message' => 'Invalid request method. Only POST requests are allowed.']);
}

// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>