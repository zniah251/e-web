<?php
require_once "../../../connect.php";
session_start();

// Lấy giỏ hàng từ session
$products = $_SESSION['cart'] ?? [];

// Nhận dữ liệu từ form
$fullname = $_POST['fullname'] ?? '';
$address  = $_POST['address'] ?? '';
$phone    = $_POST['phone'] ?? '';
$method   = $_POST['payment_method'] ?? 'momo'; // momo | banking | cod
$voucher  = trim($_POST['voucher'] ?? '');

// Thiết lập mặc định
$vid = null;
$discount = 0;
$shipping = 30000;
$voucher_minprice = 0;

// Lấy thông tin voucher nếu có
if ($voucher !== '') {
    $stmt = $conn->prepare("SELECT vid, discount, minprice, name FROM voucher WHERE name = ?");
    $stmt->bind_param("s", $voucher);
    $stmt->execute();
    $stmt->bind_result($vidFound, $discountPercent, $minprice, $vname);
    if ($stmt->fetch()) {
        $vid = $vidFound;
        $voucher_minprice = $minprice;
    }
    $stmt->close();
}

// Tính tổng giá sản phẩm trong giỏ hàng
$total = 0;
foreach ($products as $p) {
    $total += $p['price'] * $p['quantity'];
}

// Áp dụng giảm giá nếu đủ điều kiện
if ($voucherData && $total >= $voucherData['minprice']) {
    if (strtolower(trim($voucherData['name'])) === 'free shipping') {
        $shipping = 0; // Miễn phí giao hàng
    } else {
        $discount = $total * ($voucherData['discount'] / 100); // Giảm giá %
    }
}


// Tổng cuối cùng
$totalfinal = $total + $shipping - $discount;

// Tạo mã đơn hàng
$orderId = uniqid("ORDER_");
$orderInfo = "Đơn hàng cho $fullname - $phone";


if ($method === 'MOMO') {
$paymethod = strtoupper($method);

    $stmt = $conn->prepare("INSERT INTO `order` (uid, totalfinal, price, destatus, paymethod, paystatus, create_at, vid) VALUES (2, ?, ?, 'Pending', ?, 'Pending', NOW(), ?)");
    $stmt->bind_param("ddsi", $totalfinal, $total, $paymethod, $vid);
    $stmt->execute();
    $oid = $stmt->insert_id;
        header("Location: momo_payment_info.php?orderId=$oid");
} else {
    // BANK hoặc COD
    $paymethod = strtoupper($method);

    $stmt = $conn->prepare("INSERT INTO `order` (uid, totalfinal, price, destatus, paymethod, paystatus, create_at, vid) VALUES (2, ?, ?, 'Pending', ?, 'Pending', NOW(), ?)");
    $stmt->bind_param("ddsi", $totalfinal, $total, $paymethod, $vid);
    $stmt->execute();
    $oid = $stmt->insert_id;

    // Chuyển trang theo phương thức
    if ($method === 'BANK') {
        header("Location: bank_payment_info.php?orderId=$oid");
    } else {
        header("Location: confirm_shipping.php?orderId=ORDER_$oid&fullname=$fullname&address=$address&phone=$phone");
    }
    exit;
}
?>
