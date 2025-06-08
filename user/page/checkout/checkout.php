<?php
// connect.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "e-web";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Thanh toán - KAIRA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    body {
      background: linear-gradient(to right, #fef9f4, #f1f7ff);
      font-family: 'Segoe UI', sans-serif;
    }
    .checkout-wrapper {
      max-width: 1200px;
      margin: 50px auto;
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.1);
      overflow: hidden;
      animation: fadeInUp 0.5s ease-in-out;
    }
    .checkout-left, .checkout-right {
      padding: 40px;
    }
    h2 {
      font-weight: 700;
      margin-bottom: 30px;
      position: relative;
      padding-left: 32px;
    }
    h2::before {
      content: "\f07a";
      font-family: 'Font Awesome 6 Free';
      font-weight: 900;
      position: absolute;
      left: 0;
      top: 0;
      font-size: 24px;
      color: orange;
    }
    .product-item {
      display: flex;
      justify-content: space-between;
      background: #f9f9f9;
      padding: 12px 20px;
      border-radius: 10px;
      margin-bottom: 15px;
      border: 1px solid #eee;
    }
    .summary .total {
      background: #fff4e5;
      border-radius: 10px;
      padding: 10px 15px;
      font-weight: bold;
      color: #d32f2f;
      font-size: 20px;
    }
    input, select {
      border-radius: 10px;
      border: 1px solid #ccc;
      transition: 0.3s;
    }
    input:focus {
      border-color: #007bff;
      box-shadow: 0 0 5px rgba(0,123,255,0.3);
    }
    input[type="radio"] + label img {
      border: 2px solid transparent;
      border-radius: 12px;
      cursor: pointer;
      transition: 0.3s ease;
      filter: grayscale(100%);
      opacity: 0.8;
    }
    input[type="radio"]:checked + label img {
      border: 2px solid orange;
      transform: scale(1.08);
      filter: none;
      opacity: 1;
      box-shadow: 0 0 10px rgba(255,165,0,0.3);
    }
    .btn-submit {
      background: linear-gradient(45deg, #ff9800, #ff5722);
      color: white;
      padding: 14px;
      font-size: 16px;
      font-weight: bold;
      border: none;
      width: 100%;
      border-radius: 30px;
      transition: 0.4s ease;
    }
    .btn-submit:hover {
      background: linear-gradient(45deg, #e65100, #bf360c);
      box-shadow: 0 8px 18px rgba(255, 87, 34, 0.4);
      transform: translateY(-2px);
    }
    @keyframes fadeInUp {
      from {opacity: 0; transform: translateY(30px);}
      to {opacity: 1; transform: translateY(0);}
    }
    /* Dropdown submenu support */
.dropdown-submenu {
  position: relative;
}

.dropdown-submenu > .dropdown-menu {
  top: 0;
  left: 100%;
  margin-top: -1px;
  display: none;
  position: absolute;
  z-index: 999;
}

.dropdown-submenu:hover > .dropdown-menu {
  display: block;
}
.footer-custom a {
    text-decoration: none;
    color: #333;
    }
    .footer-custom a:hover {
    color: #d00;
    text-decoration: underline;
    }
  </style>
</head>
<body>
  <?php include('../../../navbar.php'); ?>
  <div class="checkout-wrapper row m-0">
    <div class="col-md-6 checkout-left bg-light">
      <h2>Giỏ hàng</h2>
      <div class="product-item">
        <div>Áo sơ mi nam (x2)</div>
        <div><strong>400.000đ</strong></div>
      </div>
      <div class="product-item">
        <div>Quần jeans nam (x1)</div>
        <div><strong>300.000đ</strong></div>
      </div>
      <div class="summary mt-4">
        <div class="product-item">
          <span>Tạm tính</span>
          <span>700.000đ</span>
        </div>
        <div class="product-item">
          <span>Phí giao hàng</span>
          <span>30.000đ</span>
        </div>
        <div class="product-item total">
          <span>Tổng cộng</span>
          <span>730.000đ</span>
        </div>
      </div>
    </div>

    <div class="col-md-6 checkout-right">
      <h2>Thanh toán</h2>
      <form action="create_order.php" method="POST">
  <div class="mb-3">
    <label for="fullname" class="form-label">
      <i class="fa fa-user me-2"></i> Họ và tên
    </label>
    <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Nguyễn Văn A" required>
  </div>

  <div class="mb-3">
    <label for="address" class="form-label">
      <i class="fa fa-location-dot me-2"></i> Địa chỉ
    </label>
    <input type="text" class="form-control" id="address" name="address" placeholder="Số nhà, phường, quận, thành phố" required>
  </div>

  <div class="mb-3">
    <label for="phone" class="form-label">
      <i class="fa fa-phone me-2"></i> Số điện thoại
    </label>
    <input type="tel" class="form-control" id="phone" name="phone" placeholder="0909xxxxxx" required>
  </div>

  <div class="mb-3">
    <label for="voucher" class="form-label">
      <i class="fa fa-tag me-2"></i> Mã giảm giá
    </label>
    <div class="input-group">
      <input type="text" id="voucher" name="voucher" class="form-control" placeholder="Nhập mã giảm giá">
      <button class="btn btn-outline-secondary" type="button">Áp dụng</button>
    </div>
  </div>

  <div class="mb-3">
    <label class="form-label">
      <i class="fa fa-credit-card me-2"></i> Phương thức thanh toán
    </label>
    <div class="row text-center g-3 mb-3">
      <div class="col-4">
        <input type="radio" name="payment_method" id="momo" value="MOMO" hidden required>
        <label for="momo"><img src="https://upload.wikimedia.org/wikipedia/vi/f/fe/MoMo_Logo.png" width="60" alt="Momo"></label>
      </div>
      <div class="col-4">
        <input type="radio" name="payment_method" id="banking" value="BANK" hidden>
        <label for="banking"><img src="https://cdn-icons-png.flaticon.com/512/633/633611.png" width="60" alt="Banking"></label>
      </div>
      <div class="col-4">
        <input type="radio" name="payment_method" id="cod" value="COD" hidden>
        <label for="cod">
        <img src="https://cdn-icons-png.flaticon.com/512/25/25694.png" width="60" alt="Ship COD">
        </label>
</div>

    </div>
  </div>

  <button type="submit" class="btn-submit">Đặt hàng</button>
</form>

    </div>
  </div>
  <footer id="footer" class="footer-custom mt-5">
    <div class="container">
      <div class="row justify-content-between py-5">
        <div class="col-md-3 col-sm-6">
          <h4 class="fw-bold mb-3">KAIRA</h4>
          <p>Chúng tôi là cửa hàng thời trang phong cách hiện đại, mang đến trải nghiệm mua sắm tiện lợi và thân thiện.</p>
          <div class="social-icons mt-3">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-youtube"></i></a>
          </div>
        </div>

        <div class="col-md-3 col-sm-6">
          <h5 class="fw-semibold mb-3">LIÊN KẾT NHANH</h5>
          <ul class="list-unstyled">
            <li><a href="index.html">Trang chủ</a></li>
            <li><a href="page/aboutus/aboutus.html">Giới thiệu</a></li>
            <li><a href="page/faq/faq.html">Hỏi đáp</a></li>
            <li><a href="page/recruitment/recruit.php">Tuyển dụng</a></li>
            <li><a href="page/member/member.php">Membership</a></li>
          </ul>
        </div>

        <div class="col-md-3 col-sm-6">
          <h5 class="fw-semibold mb-3">THÔNG TIN LIÊN HỌ</h5>
          <p><i class="fas fa-map-marker-alt me-2"></i>123 Đường Lê Lợi, TP.HCM</p>
          <p><i class="fas fa-envelope me-2"></i>contact@kairashop.com</p>
          <p><i class="fas fa-phone me-2"></i>0901 234 567</p>
        </div>

        <!-- Bản đồ -->
        <div class="col-md-3 col-sm-6">
              <h5 class="fw-semibold mb-3">BẢN ĐỒ</h5>
              <div class="map-embed">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.726643481827!2d106.6901211153343!3d10.75666499233459!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f3b5f6a90ed%3A0xf7b2b4f40e527417!2zMTIzIMSQLiBMw6ogTOG7m2ksIFTDom4gVGjhu5FuZyBI4buTbmcsIFRow6BuaCBwaOG7kSBI4buTIENow60gTWluaCwgSOG7kyBDaMOidSwgVMOibiBwaOG7kSBIw7JhIE5haQ!5e0!3m2!1svi!2s!4v1614089999097!5m2!1svi!2s" width="100%" height="180" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
              </div>
            </div>
      </div>
      <div class="text-center py-3 border-top small">
        © 2025 Kaira. Thiết kế lại bởi nhóm <strong>5 IS207</strong> | Dự án học phần Phát triển Web
      </div>
    </div>
  </footer>
</body>
</html>
