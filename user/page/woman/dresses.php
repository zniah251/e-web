<?php
include $_SERVER['DOCUMENT_ROOT'] . "/e-web/connect.php";
// Lấy tên file hiện tại
$current_file = basename($_SERVER['PHP_SELF']);
// Lấy category hiện tại theo cfile
$sql_cat = "SELECT cname FROM category WHERE cfile = ?";
$stmt_cat = $conn->prepare($sql_cat);
$stmt_cat->bind_param("s", $current_file);
$stmt_cat->execute();
$stmt_cat->bind_result($category_name);
$stmt_cat->fetch();
$stmt_cat->close();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Đầm Nữ</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="./woman.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>

    <?php include('../../../navbar.php'); ?>

    <div class="w-full max-w-[1200px] mx-auto px-6">
        <nav class="text-sm text-gray-600 mb-4 me-2 pt-3">
            <a href="../../index.html" class="hover:underline">Trang chủ</a> &gt;
            <a href="" class="hover:underline">Sản phẩm</a> &gt;
            <a href="" class="hover:underline"><?= htmlspecialchars($category_name ?? "Danh mục") ?></a>
        </nav>
        <div class="w-full border-b border-gray-300 mb-6">
            <div class="flex justify-center space-x-8 text-sm font-medium">
                <?php
                // Lấy slug của danh mục hiện tại từ query string
                $current_category_slug = isset($_GET['category']) ? $_GET['category'] : '';

                // Lấy dữ liệu từ bảng category
                $sql = "SELECT * FROM category WHERE parentid = 8";
                $result = $conn->query($sql);

                // Kiểm tra xem có dữ liệu trả về hay không
                if ($result->num_rows > 0) {
                    // Lặp qua các dòng dữ liệu
                    while ($row = $result->fetch_assoc()) {
                        $link_class = "py-3 border-b-2 text-gray-700 hover:text-black hover:border-black flex-1 text-center";
                        // Nếu slug của category hiện tại khớp với slug của category trong vòng lặp, áp dụng class active
                        // Kiểm tra nếu cfile của category hiện tại trùng với tên file đang xem thì active
                        $current_file = basename($_SERVER['PHP_SELF']);
                        if ($row['cfile'] === $current_file) {
                            $link_class = "py-3 border-b-2 border-black text-black"; // Active state
                        }

                        // Xây dựng đường dẫn
                        $base_path = dirname($_SERVER['PHP_SELF']) . '/';// Lấy đường dẫn thư mục cha động
                        $href = $base_path . htmlspecialchars($row['cfile']);
                ?>
                        <a href="<?= $href ?>" class="<?= $link_class ?>">
                            <?= htmlspecialchars($row['cname']) ?>
                        </a>
                <?php
                    }
                } else {
                    echo "Không có dữ liệu.";
                }
                ?>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <label for="sort-options" class="form-label mb-0 me-2">Sắp xếp theo:</label>
            <select id="sort-options" class="form-select" onchange="sortBy(this.value)">
                <option value="price-asc">Giá từ thấp đến cao</option>
                <option value="price-desc">Giá từ cao xuống thấp</option>
            </select>
        </div>

        <div class="row g-4" id="product-list">
            <?php
            $sql = "SELECT * FROM product WHERE cid = 14";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $img_url = "/e-web/admin/assets/images/" . rawurlencode($row['thumbnail']);
            ?>
                    <div class="col-md-3 product" data-price="<?= htmlspecialchars($row['price']) ?>">
                        <div class="bg-gray-100 rounded-xl p-3 flex flex-col">
                            <a href="/e-web/user/page/product_detail/product_detail.php?pid=<?= htmlspecialchars($row['pid']) ?>">
                                <img src="<?= $img_url ?>" alt="<?= htmlspecialchars($row['title']) ?>" class="rounded mb-3 h-72 object-cover w-full"
                                    onerror="this.src='/e-web/admin/assets/images/default.jpg'" />
                            </a>
                            <h3 class="font-medium text-sm mb-1 product-title-ellipsis"><?= htmlspecialchars($row['title']) ?></h3>
                            <p class="font-bold text-lg mb-2"><?= number_format($row['price'], 0, ',', '.') ?>₫</p>
                            <div class="mb-2">
                                <img src="<?= $img_url ?>" class="w-10 h-10 border rounded object-cover" />
                            </div>
                            <a href="/e-web/user/page/product_detail/product_detail.php?pid=<?= htmlspecialchars($row['pid']) ?>" class="btn-primary mb-2 text-center">Mua ngay</a>
                            <button class="border py-2 rounded-full hover:bg-gray-200">Thêm vào giỏ</button>
                        </div>
                    </div>
            <?php
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
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.726643481827!2d106.6901211153343!3d10.75666499233459!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f3b5f6a90ed%3A0xf7b2b4f40e527417!2zMTIzIMSQLiBMw6ogTOG7m2ksIFTDom4gVGjhu5FuZyBI4buTbmcsIFRow6BuaCBwaOG7kSBI4buTIENow60gTWluaCwgSOG7kyBDaMOidSwgVMOibiBwaOG7kSBIw7JhIE5haQ!5e0!3m2!1svi!2s" width="100%" height="180" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
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