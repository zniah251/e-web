<?php
$orderId = $_GET['orderId'] ?? 'N/A';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Kaira - Chuyển khoản MOMO</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" />
  <style>
    body {
      font-family: 'Times New Roman', serif;
      background-color: #fff;
      color: #000;
    }

    .container-custom {
      max-width: 600px;
      margin: 60px auto;
      background-color: #fff;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      text-align: center;
    }

    h2 {
      font-weight: bold;
      margin-bottom: 25px;
      color: #000;
    }

    p {
      font-size: 17px;
      margin-bottom: 12px;
    }

    .note {
      background-color: #fdf6e3;
      padding: 10px 15px;
      font-weight: bold;
      font-size: 18px;
      color: #b71c1c;
      border-radius: 10px;
      display: inline-block;
      margin-top: 10px;
    }

    .btn-confirm {
      margin-top: 30px;
      padding: 12px 24px;
      font-size: 16px;
      font-weight: bold;
      background-color: #000;
      color: #fff;
      border-radius: 30px;
      border: none;
      text-decoration: none;
      transition: all 0.3s ease;
    }

    .btn-confirm:hover {
      background-color: #333;
    }

    .momo-logo {
      width: 280px;
      margin-bottom: 20px;
      border-radius: 8px;
    }
  </style>
</head>
<body>
<?php include('../../../navbar.php'); ?>

<div class="container-custom">
  <h2><i class="fas fa-mobile-alt me-2"></i>Chuyển khoản MOMO</h2>
  <img src="../../../blog/momo.jpg" alt="Momo" class="momo-logo">
  
  <p><i class="fas fa-user me-2 text-dark"></i><strong>Chủ tài khoản:</strong> Trương Huy Hoàng</p>
  <p><i class="fas fa-hashtag me-2 text-info"></i><strong>Số điện thoại:</strong> 0328 243 239</p>

  <p><i class="fas fa-sticky-note me-2 text-danger"></i><strong>Nội dung chuyển khoản:</strong><br>
    <span class="note">THANH_TOAN_ĐON_HANG_SO <?= htmlspecialchars($orderId) ?></span>
  </p>

  <p class="text-muted mt-3">💬 Kaira sẽ tiến hành giao hàng sau khi nhận thanh toán thành công. Xin cảm ơn quý khách!</p>

  <a href="../../index.php" class="btn btn-confirm">Xác nhận đã thanh toán</a>
</div>

<?php include('../../../footer.php'); ?>
</body>
</html>
