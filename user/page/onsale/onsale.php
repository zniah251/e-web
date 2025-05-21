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

<head>
    <title>Kaira</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../style.css">
    <link rel="stylesheet" type="text/css" href="../../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../../css/swiper-bundle.min.css">
    <link rel="stylesheet" type="text/css" href="../../index.html">
    <link rel="stylesheet" type="text/css" href="../faq/faqstyle.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&family=Marcellus&display=swap"
        rel="stylesheet">
    <style>
        .container_onsale {
            max-width: 1200px;
            margin: auto;
            padding: 40px 20px;
        }

        .onsale-header {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 32px;
            font-weight: bold;
        }

        .onsale-header span {
            display: inline-block;
            background-color: #d70018;
            color: white;
            font-size: 20px;
            padding: 5px 10px;
            border-radius: 6px;
        }

        .sort-filter {
            display: flex;
            align-items: center;
            margin: 30px 0;
        }

        .sort-filter label {
            margin-right: 10px;
            font-size: 16px;
            color: #333;
        }

        .sort-filter select {
            padding: 8px 12px;
            font-size: 16px;
            border-radius: 10px;
            border: 1px solid #ccc;
            outline: none;
        }

        .empty-sale {
            text-align: center;
            margin-top: 60px;
        }

        .empty-sale img {
            max-width: 250px;
            margin-bottom: 30px;
        }

        .empty-sale h3 {
            font-weight: bold;
            font-size: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .empty-sale p {
            font-size: 15px;
            color: #444;
        }
    </style>
</head>

<body>
    <?php include('../../../navbar.php'); ?>
    <nav class="breadcrumb">
        <a href="../../index.html">Trang chủ</a> <span class="breadcrumb-separator">&gt;</span> <span>ON SALE</span>
    </nav>

    <body>
        <div class="container_onsale">
            <div class="onsale-header">
                <span>%</span>
                On Sale
            </div>

            <div class="sort-filter">
                <label for="sort">Sắp xếp theo</label>
                <select id="sort">
                    <option value="low-high">Giá thấp nhất</option>
                    <option value="high-low">Giá cao nhất</option>
                    <option value="new">Mới nhất</option>
                </select>
            </div>

            <div class="empty-sale">
                <img src="../onsale/img-onsale/empty-sale.png" alt="Sale off sắp diễn ra">
                <h3>Chương trình Sale off sắp diễn ra!</h3>
                <p>Chương trình Sale off của KAIRA sẽ diễn ra trong thời gian sắp tới, bạn cùng theo dõi và đón mua nhé!</p>
            </div>
        </div>
        <footer id="footer" class="footer-custom mt-5">
            <div class="container">
                <div class="row justify-content-between py-5">

                    <!-- Logo & mô tả -->
                    <div class="col-md-3 col-sm-6">
                        <h4 class="fw-bold mb-3">KAIRA</h4>
                        <p>Chúng tôi là cửa hàng thời trang phong cách hiện đại, mang đến trải nghiệm mua sắm tiện lợi và thân thiện.</p>
                        <div class="social-icons mt-3">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>

                    <!-- Liên kết nhanh -->
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

                    <!-- Thông tin liên hệ -->
                    <div class="col-md-3 col-sm-6">
                        <h5 class="fw-semibold mb-3">THÔNG TIN LIÊN HỆ</h5>
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