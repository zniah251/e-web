<?php
require_once "../../../connect.php";
$config = require "momo_config.php";

// --- Nhận dữ liệu từ form ---
$fullname = $_POST['fullname'] ?? '';
$address  = $_POST['address'] ?? '';
$phone    = $_POST['phone'] ?? '';
$method   = $_POST['payment_method'] ?? 'momo'; // momo | banking | cod
$voucher  = trim($_POST['voucher'] ?? '');

// --- Xử lý voucher ---
$vid = null;
if ($voucher !== '') {
    $stmt = $conn->prepare("SELECT vid FROM voucher WHERE name = ?");
    $stmt->bind_param("s", $voucher);
    $stmt->execute();
    $stmt->bind_result($vidFound);
    if ($stmt->fetch()) {
        $vid = $vidFound;
    }
    $stmt->close();
}

// --- Sản phẩm mẫu ---
$products = [
    ['title' => 'Áo sơ mi nam', 'quantity' => 2, 'price' => 200000],
    ['title' => 'Quần jeans nam', 'quantity' => 1, 'price' => 300000]
];
$total = 0;
foreach ($products as $p) {
    $total += $p['price'] * $p['quantity'];
}
$shipping = 30000;
$total += $shipping;

$orderId = uniqid("ORDER_");
$orderInfo = "Đơn hàng cho $fullname - $phone";

// --- XỬ LÝ TÙY THEO PHƯƠNG THỨC ---
if ($method === 'MOMO') {
    // 🟣 MOMO REDIRECT
    $data = [
        'partnerCode' => $config['partnerCode'],
        'accessKey' => $config['accessKey'],
        'requestId' => time() . "",
        'amount' => $total,
        'orderId' => $orderId,
        'orderInfo' => $orderInfo,
        'redirectUrl' => $config['redirectUrl'],
        'ipnUrl' => $config['ipnUrl'],
        'extraData' => '',
        'requestType' => 'captureWallet'
    ];

    $signatureBase = "accessKey={$data['accessKey']}&amount={$data['amount']}&extraData={$data['extraData']}&ipnUrl={$data['ipnUrl']}&orderId={$data['orderId']}&orderInfo={$data['orderInfo']}&partnerCode={$data['partnerCode']}&redirectUrl={$data['redirectUrl']}&requestId={$data['requestId']}&requestType=captureWallet";
    $data['signature'] = hash_hmac("sha256", $signatureBase, $config['secretKey']);

    $ch = curl_init($config['endpoint']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);
    if (!empty($result['payUrl'])) {
        header("Location: " . $result['payUrl']);
        exit;
    } else {
        echo "Không tạo được thanh toán MOMO.";
    }

} else {
    // 📦 BANKING hoặc COD

    $paymethod = strtoupper($method); // BANK hoặc COD

    $stmt = $conn->prepare("INSERT INTO `order` (uid, totalfinal, price, destatus, paymethod, paystatus, create_at, vid) VALUES (2, ?, ?, 'Pending', ?, 'Pending', NOW(), ?)");
    $stmt->bind_param("ddsi", $total, $total, $paymethod, $vid);
    $stmt->execute();
    $oid = $stmt->insert_id;

    if ($method === 'BANK') {
        header("Location: bank_payment_info.php?orderId=$oid");
        exit;
    } else {
        header("Location: confirm_shipping.php?orderId=ORDER_$oid&fullname=$fullname&address=$address&phone=$phone");
        exit;
    }
}
