<?php
// Lấy thông tin từ URL hoặc session (tùy bạn)
$orderId = $_GET['orderId'] ?? 'N/A';
$fullname = $_GET['fullname'] ?? 'Khách hàng';
$address = $_GET['address'] ?? 'Không rõ';
$phone = $_GET['phone'] ?? 'Chưa có';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Xác nhận giao hàng</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #fdfbfb, #ebedee);
      font-family: 'Segoe UI', sans-serif;
    }
    .container-box {
      max-width: 600px;
      margin: 80px auto;
      background: white;
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
      animation: slideUp 0.4s ease;
    }
    .btn-confirm {
      background: linear-gradient(to right, #00b09b, #96c93d);
      color: white;
      font-weight: bold;
      padding: 12px;
      border: none;
      border-radius: 30px;
      width: 100%;
      font-size: 16px;
    }
    .btn-confirm:hover {
      background: linear-gradient(to right, #43cea2, #185a9d);
    }
    @keyframes slideUp {
      from {opacity: 0; transform: translateY(30px);}
      to {opacity: 1; transform: translateY(0);}
    }
  </style>
</head>
<body>
  <div class="container-box text-center">
    <h3 class="mb-4">📦 Xác nhận địa chỉ giao hàng</h3>
    <p><strong>Họ tên:</strong> <?= htmlspecialchars($fullname) ?></p>
    <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($phone) ?></p>
    <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($address) ?></p>
    <form method="GET" action="thankyou.php">
        <input type="hidden" name="orderId" value="<?= htmlspecialchars($orderId) ?>">
        <button type="submit" class="btn-confirm mt-4">✅ Xác nhận giao hàng</button>
    </form>
  </div>
</body>
</html>
