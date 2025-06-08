<?php
// momo_config.php (dùng cho localhost, đồ án môn học)

return [
    'partnerCode' => 'MOMO',
    'accessKey' => 'F8BBA842ECF85',
    'secretKey' => 'K951B6PE1waDMi640xX08PD3vg6EkVlz',
    'endpoint' => 'https://test-payment.momo.vn/v2/gateway/api/create',
    'redirectUrl' => 'http://localhost:8080/E-WEB/user/page/checkout/payment_result.php',
    'ipnUrl' => 'http://localhost:8080/E-WEB/user/page/checkout/momo_callback.php'
];
