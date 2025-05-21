<!DOCTYPE html>
<html lang="en">

<head>
    <title>Kaira</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../../user/css/vendor.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <link rel="stylesheet" type="text/css" href="../../style.css">
    <link rel="stylesheet" type="text/css" href="../../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../../css/swiper-bundle.min.css">
    <link rel="stylesheet" type="text/css" href="../../index.html">
    <link rel="stylesheet" type="text/css" href="../aboutus/abtus.css">
    <link rel="stylesheet" type="text/css" href="../faq/faqstyle.css">
    <link rel="stylesheet" type="text/css" href="./recruitstyle.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&family=Marcellus&display=swap"
        rel="stylesheet">
    <style>
      * {
            font-family: 'Times New Roman', Times, serif !important;
        }
        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu .dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: -1px;
        }

        .dropdown-submenu:hover .dropdown-menu {
            display: block;
        }

        .note-box {
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
            margin: auto;
            color: #000;
        }

        .note-box p {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .note-box ul {
            list-style-type: none;
            padding-left: 0;
        }

        .note-box li::before {
            content: "- ";
        }
    </style>
</head>

<body>
    <?php include('../../../navbar.php'); ?>
     <!-- PHẦN HEADER & THANH TÌM KIẾM -->
  <div class="hero">
    <h1>Tuyển dụng</h1>
    <p>Hãy gia nhập và trở thành người nhà của KAIRA ngay nhé!</p>

    <div class="search-bar">
      <input type="text" placeholder="Tìm kiếm công việc" />
      <select>
        <option>Tất cả công việc</option>
      </select>
      <button>Tìm kiếm</button>
    </div>
  </div>

  <!-- PHẦN VIỆC LÀM NỔI BẬT -->
  <div class="highlight-jobs">
    <h2>Việc làm nổi bật</h2>
    <p>Có <strong>0</strong> công việc đang mở</p>
    <p>Không có công việc nổi bật nào được tìm thấy.</p>
    <button class="explore-btn">Khám phá thêm →</button>
  </div>

  <!-- PHẦN QUY TRÌNH ỨNG TUYỂN -->
  <div class="process">
    <h2>Quy trình ứng tuyển</h2>
    <p>Quy trình ứng tuyển đơn giản, rõ ràng tại KAIRA</p>

    <div class="steps">

      <div class="step step-1">
        <div class="circle">1</div>
        <h3>Bước 1</h3>
        <p>Nộp CV</p>
      </div>

      <div class="step step-2">
        <div class="circle">2</div>
        <h3>Bước 2</h3>
        <p>Phỏng vấn online</p>
      </div>

      <div class="step step-3 active">
        <div class="circle">3</div>
        <h3>Bước 3</h3>
        <p>Phỏng vấn trực tiếp</p>
      </div>

      <div class="step step-4">
        <div class="circle">4</div>
        <h3>Bước 4</h3>
        <p>Thông báo kết quả</p>
      </div>

    </div>
  </div>

  <!-- PHẦN LÝ DO CHỌN KAIRA -->
  <div class="why-choose">
    <h2>Vì sao nên chọn KAIRA?</h2>
    <p>Lí do bạn nên gia nhập vào ngôi nhà KAIRA ngay</p>

    <div class="reasons">
      <ul>
        <li>🌟 Cùng KAIRA xây dựng một thương hiệu thời trang hiện đại, ứng dụng dẫn đầu xu hướng.</li>
        <li>💼 Được trải nghiệm không gian làm việc trẻ trung, chuyên nghiệp, định hướng phát triển rõ ràng.</li>
        <li>🚀 Thoả sức thể hiện bản thân trong môi trường luôn chuyển động, nhiều cơ hội học hỏi và thăng tiến.</li>
        <li>🎁 Được hưởng các đãi ngộ về lương, thưởng, phúc lợi tốt.</li>
      </ul>
    </div>
  </div>
  <!--footer-->
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
  <script src="js/jquery.min.js"></script>
  <script src="js/plugins.js"></script>
  <script src="js/SmoothScroll.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
      crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
  <script src="js/script.min.js"></script>
</body>

</html>