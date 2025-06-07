<?php
// test_callback.php
$url = 'http://localhost:8080/e-web/user/page/checkout/momo_callback.php';

$data = [
    'partnerCode' => 'MOMO',
    'orderId' => 'ORDER_12345678',   // Trùng với mã đơn bạn tạo trước
    'requestId' => time(),
    'amount' => 730000,
    'orderInfo' => 'Đơn hàng test demo',
    'orderType' => 'momo_wallet',
    'transId' => 987654321,
    'resultCode' => 0,
    'message' => 'Thanh toán thành công',
    'payType' => 'qr',
    'responseTime' => time(),
    'extraData' => '',
    'signature' => 'DUMMY_SIGNATURE'
];

$options = [
    'http' => [
        'header'  => "Content-type: application/json\r\n",
        'method'  => 'POST',
        'content' => json_encode($data),
    ]
];
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
echo $result;
