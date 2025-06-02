<?php
include("../../../connect.php");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Áo Sơ Mi Nam</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    * { font-family: 'Times New Roman', Times, serif !important; }
    body { background-color: #f9f9f9; font-size: 17px; }

    .product-card {
      border-radius: 16px;
      padding: 15px;
      text-align: center;
      background-color: #f0f0f0;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      transition: 0.3s;
      height: 100%;
    }

    .product-card:hover {
      box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    }

    .main-img {
      width: 100%;
      aspect-ratio: 3/4;
      object-fit: cover;
      border-radius: 10px;
      background-color: #eee;
      display: block;
    }

    .thumbnail-preview {
      display: flex;
      justify-content: flex-start;
      gap: 5px;
      margin-top: 8px;
    }

    .thumb-img {
      width: 40px;
      height: 60px;
      object-fit: cover;
      border-radius: 5px;
      border: 1px solid #ccc;
      cursor: pointer;
      transition: border-color 0.3s;
    }

    .thumb-img:hover {
      border-color: #000;
    }

    .price-new {
      color: #000 !important;
      font-weight: bold;
      font-size: 20px;
      margin-bottom: 10px;
    }

    .product-card h6 {
      margin-top: 10px;
      font-size: 15px;
      height: 42px;
      overflow: hidden;
    }

    .btn-buy {
      background-color: #444;
      color: #fff;
      border-radius: 999px;
      width: 100%;
      padding: 10px 0;
      font-weight: bold;
      border: none;
      transition: 0.3s;
    }

    .btn-buy:hover {
      background-color: #000;
    }

    .btn-cart {
      background-color: #f9f9f9;
      color: #000;
      border-radius: 999px;
      width: 100%;
      padding: 10px 0;
      border: 1px solid #ddd;
      margin-top: 10px;
      font-weight: normal;
      transition: 0.3s;
    }

    .btn-cart:hover {
      background-color: #eee;
    }

    select.form-select {
      width: 220px;
    }

    .footer-custom a {
      text-decoration: none;
      color: #333;
    }

    .footer-custom a:hover {
      color: #d00;
      text-decoration: underline;
    }

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

    .navbar-nav .nav-link {
      color: #000 !important;
      text-decoration: none !important;
      font-weight: 500;
      padding: 0 12px;
    }

    .navbar-nav .nav-link:hover {
      color: #d00 !important;
    }
  </style>
</head>
<body>

<?php include('../../../navbar.php'); ?>

<div class="container my-5">
  <h2 class="text-center mb-4">Áo Sơ Mi Nam</h2>
  <div class="d-flex justify-content-between align-items-center mb-4">
    <label for="sort-options" class="form-label mb-0 me-2">Sắp xếp theo:</label>
    <select id="sort-options" class="form-select" onchange="sortBy(this.value)">
      <option value="price-asc">Giá từ thấp đến cao</option>
      <option value="price-desc">Giá từ cao xuống thấp</option>
    </select>
  </div>

  <div class="row g-4" id="product-list">
    <?php
    $sql = "SELECT * FROM product WHERE cid = 12";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $img = "/e-web/admin/assets/images/" . urlencode($row['thumbnail']);
            echo '<div class="col-md-3 product" data-price="' . $row['price'] . '">
                    <div class="product-card">
                      <img src="' . $img . '" alt="' . htmlspecialchars($row['title']) . '" 
                           onerror="this.src=\'/e-web/admin/assets/images/default.jpg\'" class="main-img">
                      <div class="thumbnail-preview">
                        <img src="' . $img . '" class="thumb-img" onclick="swapImage(this)">
                      </div>
                      <h6>' . htmlspecialchars($row['title']) . '</h6>
                      <p class="price-new">' . number_format($row['price']) . 'đ</p>
                      <button class="btn btn-buy">Mua ngay</button>
                      <button class="btn btn-cart">Thêm vào giỏ</button>
                    </div>
                  </div>';
        }
    } else {
        echo '<p>Chưa có sản phẩm.</p>';
    }
    $conn->close();
    ?>
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
          <li><a href="page/recruitment/recruit.html">Tuyển dụng</a></li>
          <li><a href="page/member/member.html">Membership</a></li>
        </ul>
      </div>

      <div class="col-md-3 col-sm-6">
        <h5 class="fw-semibold mb-3">THÔNG TIN LIÊN HỆ</h5>
        <p><i class="fas fa-map-marker-alt me-2"></i>123 Đường Lê Lợi, TP.HCM</p>
        <p><i class="fas fa-envelope me-2"></i>contact@kairashop.com</p>
        <p><i class="fas fa-phone me-2"></i>0901 234 567</p>
      </div>

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

<script>
  function sortBy(option) {
    const container = document.getElementById('product-list');
    const products = Array.from(container.getElementsByClassName('product'));
    products.sort((a, b) => {
      const priceA = parseFloat(a.getAttribute('data-price'));
      const priceB = parseFloat(b.getAttribute('data-price'));
      return option === 'price-asc' ? priceA - priceB : priceB - priceA;
    });
    products.forEach(p => container.appendChild(p));
  }

  function swapImage(thumb) {
    const mainImg = thumb.closest('.product-card').querySelector('.main-img');
    mainImg.src = thumb.src;
  }
</script>
</body>
</html>
