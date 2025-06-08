<?php
$orderId = $_GET['orderId'] ?? 'N/A';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>Cảm ơn bạn đã đặt hàng</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #f3f9ff, #fffef9);
      font-family: 'Segoe UI', sans-serif;
    }
    .thank-box {
      max-width: 600px;
      margin: 100px auto;
      padding: 40px;
      background: white;
      border-radius: 20px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
      text-align: center;
      animation: fadeIn 0.4s ease;
    }
    .thank-box h2 {
      color: #2e7d32;
      margin-bottom: 20px;
    }
    .thank-box p {
      font-size: 17px;
      color: #555;
    }
    .thank-box .order-id {
      font-weight: bold;
      color: #ff5722;
    }
    .btn-home {
      margin-top: 30px;
      background: #2e7d32;
      color: white;
      padding: 12px 28px;
      border: none;
      border-radius: 25px;
      font-weight: bold;
      font-size: 16px;
    }
    .btn-home:hover {
      background: #1b5e20;
    }
    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(30px);}
      to {opacity: 1; transform: translateY(0);}
    }
  </style>
</head>
<body>
  <div class="thank-box">
    <h2>🎉 Cảm ơn bạn đã đặt hàng!</h2>
    <p>Mã đơn hàng của bạn là: <span class="order-id"><?= htmlspecialchars($orderId) ?></span></p>
    <p>Đơn hàng sẽ được giao trong vòng <strong>2 - 4 ngày làm việc</strong>.</p>
    <p>Kaira sẽ liên hệ nếu cần thêm thông tin.</p>
    <p class="mt-3">Hãy theo dõi email hoặc số điện thoại để nhận thông báo vận chuyển.</p>
    <a href="../../index.php" class="btn-home">🏠 Về trang chủ</a>
  </div>
</body>
</html>
