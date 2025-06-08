<?php
$orderId = $_GET['orderId'] ?? 'N/A';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>Kaira Shopping Cart</title>
  <!-- MDB icon -->
  <link rel="icon" href="../../assets/img/mdb-favicon.ico" type="image/x-icon" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" />
  <!-- Google Fonts Roboto -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" />
  <!-- MDB -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.min.css" />
  <!-- Custom CSS -->
  <link rel="stylesheet" href="../../assets/css/style.css" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
   body {
      background: linear-gradient(to right, #f5f7fa, #e4ecf7);
      font-family: 'Segoe UI', sans-serif;
    }

    .bank-container {
      max-width: 600px;
      margin: 60px auto;
      background-color: white;
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
      text-align: center;
      animation: fadeIn 0.5s ease-in-out;
    }

    .bank-container h2 {
      font-weight: 700;
      color: #2e7d32;
      margin-bottom: 25px;
    }

    .info {
      font-size: 18px;
      margin-bottom: 15px;
      text-align: left;
    }

    .info span {
      font-weight: bold;
      color: #2c3e50;
    }

    .highlight {
      background-color: #fff8e1;
      padding: 10px 15px;
      border-radius: 8px;
      font-weight: bold;
      font-size: 18px;
      color: #d84315;
      display: inline-block;
      margin-top: 10px;
    }

    .btn-custom {
      margin-top: 30px;
      background: linear-gradient(to right, #43cea2, #185a9d);
      color: white;
      border: none;
      border-radius: 30px;
      padding: 12px 24px;
      font-weight: bold;
      transition: 0.3s ease;
      text-decoration: none;
    }

    .btn-custom:hover {
      background: linear-gradient(to right, #2b5876, #4e4376);
      transform: translateY(-2px);
      box-shadow: 0 8px 16px rgba(72, 85, 99, 0.2);
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>

<body>
  <?php include('../../../navbar.php'); ?>
  <<div class="container py-5">
  <div class="bg-white rounded shadow p-4 text-center" style="max-width: 600px; margin: auto;">
    <h2 class="text-success mb-4"><i class="fas fa-money-check-alt me-2"></i>Chuyển khoản ngân hàng</h2>

    <p class="mb-2"><i class="fas fa-university text-primary me-2"></i><strong>Ngân hàng:</strong> Vietcombank</p>
    <p class="mb-2"><i class="fas fa-user text-dark me-2"></i><strong>Chủ tài khoản:</strong> Trương Huy Hoàng</p>
    <p class="mb-2"><i class="fas fa-hashtag text-info me-2"></i><strong>Số tài khoản:</strong> 0123456789</p>

    <p class="mb-3"><i class="fas fa-sticky-note text-danger me-2"></i><strong>Nội dung chuyển khoản:</strong><br>
      <span class="bg-warning-subtle px-3 py-2 rounded d-inline-block mt-2 fw-bold text-danger">THANH_TOAN_ĐON_HANG_SO <?= htmlspecialchars($orderId) ?></span>
    </p>

    <p class="text-muted mt-3">💬 Vui lòng liên hệ fanpage hoặc hotline sau khi chuyển khoản để xác nhận đơn hàng.</p>
    <a href="../../index.php" class="btn btn-success btn-lg px-5 mt-3">Về trang chủ</a>
  </div>
</div>

</body>
<?php include('../../../footer.php'); ?>

</html>
