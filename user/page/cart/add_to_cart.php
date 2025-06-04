<?php
session_start(); // Bắt đầu session để lưu trữ giỏ hàng

header('Content-Type: application/json'); // Đảm bảo trả về JSON

// Kiểm tra xem yêu cầu có phải là POST không
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ $_POST (được gửi bởi FormData của JavaScript)
    $pid = filter_var($_POST['pid'] ?? null, FILTER_SANITIZE_NUMBER_INT);
    $title = htmlspecialchars(trim($_POST['title'] ?? ''));
    $price = filter_var($_POST['price'] ?? null, FILTER_VALIDATE_FLOAT);
    // Lưu ý: Giá trị thumbnail có thể là đường dẫn đầy đủ nếu bạn cập nhật trong JS
    $thumbnail = htmlspecialchars(trim($_POST['thumbnail'] ?? ''));
    // Lấy số lượng từ input ẩn, nếu không có thì mặc định là 1
    $quantity = filter_var($_POST['quantity'] ?? 1, FILTER_SANITIZE_NUMBER_INT); // Lấy từ input ẩn
    $size = htmlspecialchars(trim($_POST['size'] ?? ''));
    $color = htmlspecialchars(trim($_POST['color'] ?? ''));

    // Kiểm tra dữ liệu cơ bản
    if ($pid && $title && $price !== false && $quantity > 0) {
        // Khởi tạo giỏ hàng nếu chưa tồn tại
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $item_added_or_updated = false;

        // Tạo một "ID duy nhất" cho mỗi biến thể sản phẩm trong giỏ hàng
        // Bao gồm pid, size, color để phân biệt các biến thể khác nhau của cùng 1 sản phẩm
        $item_unique_key = $pid . '_' . ($size ?? 'nosize') . '_' . ($color ?? 'nocolor');

        // Kiểm tra nếu sản phẩm (biến thể) đã có trong giỏ hàng, thì tăng số lượng
        if (isset($_SESSION['cart'][$item_unique_key])) {
            $_SESSION['cart'][$item_unique_key]['quantity'] += $quantity;
            $item_added_or_updated = true;
        } else {
            // Nếu sản phẩm (biến thể) chưa có trong giỏ hàng, thêm mới
            $_SESSION['cart'][$item_unique_key] = [
                'pid' => $pid,
                'title' => $title,
                'price' => $price,
                'thumbnail' => $thumbnail,
                'quantity' => $quantity,
                'size' => $size, // Thêm size vào giỏ hàng
                'color' => $color // Thêm color vào giỏ hàng
            ];
            $item_added_or_updated = true;
        }

        if ($item_added_or_updated) {
            // Có thể tính tổng số lượng sản phẩm trong giỏ nếu muốn cập nhật UI
            $total_items_in_cart = 0;
            foreach ($_SESSION['cart'] as $item) {
                $total_items_in_cart += $item['quantity'];
            }

            echo json_encode([
                'success' => true,
                'message' => 'Đã thêm "' . $title . '" vào giỏ hàng!',
                'total_items_in_cart' => $total_items_in_cart // Trả về tổng số lượng để client có thể cập nhật icon giỏ hàng
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Không thể thêm sản phẩm vào giỏ hàng.'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Dữ liệu sản phẩm gửi lên không đầy đủ hoặc không hợp lệ.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Yêu cầu không hợp lệ. Chỉ chấp nhận phương thức POST.'
    ]);
}
