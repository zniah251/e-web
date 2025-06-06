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
// 2. Lấy product ID từ URL
$pid = isset($_GET['pid']) ? (int)$_GET['pid'] : 0;
if ($pid <= 0) {
    die('ID sản phẩm không hợp lệ');
}

// 3. Truy vấn sản phẩm
$sql = "SELECT * FROM product WHERE pid = $pid LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die('Không tìm thấy sản phẩm');
}

$product = $result->fetch_assoc();
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
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .btn-primary {
            background-color: #434343;
            color: white;
            padding: 0.5rem;
            border-radius: 9999px;

        }

        .btn-primary:hover {
            background-color: #2f2f2f;
        }

        .custom-paragraph {
            font-family: SVN-Poppins, -apple-system, "Segoe UI", Roboto, sans-serif;
        }

        .size-btn {
            padding: 8px 16px;
            border: 1px solid transparent;
            border-radius: 9999px;
            /* bo tròn */
            background-color: #f9f9f9;
            font-weight: 500;
            cursor: pointer;
            transition: border 0.2s;
        }

        .size-btn.selected {
            border: 1px solid black;
            background-color: white;
        }

        .size-btn:hover {
            border-color: #666;
        }

        /* Modal */
        .size-modal {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        body {
            font-family: 'Times New Roman', serif;
        }
        h1, h2, h3, h4, h5 {
            font-family: 'Times New Roman', Times, serif !important;
            /* Sử dụng font Times New Roman cho tiêu đề */
        }
        .product-title-ellipsis {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: block;
            max-width: 100%;
        }
    </style>


</head>

<body class="bg-white">
    <?php include('../../../navbar.php'); ?>

    <div class="w-full max-w-[1200px] mx-auto px-6">
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-600 p-4">
            <a href="../../index.html" class="hover:underline">Trang chủ</a> &gt;
            <a href="../woman/tops.php" class="hover:underline">Sản phẩm</a> &gt;
            <span><?= htmlspecialchars($product['title']) ?></span>
        </nav>
        <div class="flex flex-col lg:flex-row gap-6 lg:gap-10 items-start">
            <!-- Cột trái: ảnh sản phẩm -->
            <div class="flex flex-col sm:flex-row">
                <!-- Ảnh chính -->
                <?php
                // Lấy đường dẫn ảnh từ CSDL
                $thumbnail = $product['thumbnail'];

                // Nếu đường dẫn bắt đầu bằng 'admin/assets/images/', loại bỏ phần đó
                if (strpos($thumbnail, 'admin/assets/images/') === 0) {
                    $thumbnail = substr($thumbnail, strlen('admin/assets/images/'));
                }

                // Đảm bảo đường dẫn đúng và encode lại cho URL (đặc biệt với tên file có dấu tiếng Việt, khoảng trắng)
                $thumbnail_url = '/e-web/admin/assets/images/' . rawurlencode($thumbnail);
                ?>
                <div class="relative group" style="width:fit-content;">
                    <img id="mainImage" src="<?= $thumbnail_url ?>" alt="<?= htmlspecialchars($product['title']) ?>" class="w-full max-w-sm h-auto rounded-xl shadow" style="display:block;" />

                </div>

                <!-- Ảnh phụ bên phải ảnh chính -->
                <?php
                // Lấy các ảnh phụ (thumbnail, thumbnail2, thumbnail3) của các sản phẩm cùng title
                $images = [];
                $stmt = $conn->prepare("SELECT thumbnail, thumbnail2, thumbnail3 FROM product WHERE title = ? ORDER BY pid ASC");
                $stmt->bind_param("s", $product['title']);
                $stmt->execute();
                $res = $stmt->get_result();
                while ($row = $res->fetch_assoc()) {
                    foreach (['thumbnail', 'thumbnail2', 'thumbnail3'] as $field) {
                        if (!empty($row[$field])) {
                            $img = $row[$field];
                            if (strpos($img, 'admin/assets/images/') === 0) {
                                $img = substr($img, strlen('admin/assets/images/'));
                            }
                            $img = trim($img);
                            $url = '/e-web/admin/assets/images/' . rawurlencode($img);
                            if (!in_array($url, $images)) {
                                $images[] = $url;
                            }
                        }
                    }
                }
                $stmt->close();
                ?>

                <?php if (!empty($images)): ?>
                    <div class="flex flex-col gap-3 ml-4 scale-90 sm:scale-100 origin-top-left">
                        <?php foreach ($images as $img): ?>
                            <img src="<?= $img ?>" class="w-16 md:w-20 h-24 object-cover border rounded cursor-pointer thumb" onerror="this.style.display='none'" />
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Cột phải: thông tin sản phẩm -->
            <div class="w-full lg:max-w-xl">
                <h1 class="text-2xl font-bold mb-3"><?= htmlspecialchars($product['title']) ?></h1>
                <p class="mb-3 text-gray-600"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                <p class="text-red-600 text-xl font-semibold mb-3"><?= number_format($product['price'], 0, ',', '.') ?>₫</p>
                <!--Chọn màu sắc-->
                <div class="mb-3">
                    <p class="font-semibold">Màu sắc:
                        <span id="selectedColor" class="font-normal">
                            <?= htmlspecialchars($product['color']) ?>
                        </span>
                    </p>
                    <!-- Màu sắc động từ CSDL -->
                    <div class="flex gap-2 mt-2">
                        <?php
                        // Lấy tất cả màu sắc (color, color2) và thumbnail của sản phẩm cùng title
                        $colors = [];
                        $stmt = $conn->prepare("SELECT color, color2, thumbnail FROM product WHERE title = ? ORDER BY pid ASC");
                        $stmt->bind_param("s", $product['title']);
                        $stmt->execute();
                        $res = $stmt->get_result();
                        while ($row = $res->fetch_assoc()) {
                            foreach (['color', 'color2'] as $colorField) {
                                $color = $row[$colorField];
                                if (!empty($color) && !in_array($color, $colors)) {
                                    $img = $row['thumbnail'];
                                    if (strpos($img, 'admin/assets/images/') === 0) {
                                        $img = substr($img, strlen('admin/assets/images/'));
                                    }
                                    $img = trim($img);
                                    $img_url = '/e-web/admin/assets/images/' . rawurlencode($img);
                                    $selected = ($product['color'] == $color) ? 'ring-1 ring-black' : '';
                                    echo '<img src="' . $img_url . '" data-color="' . htmlspecialchars($color) . '" class="w-10 h-10 border rounded cursor-pointer color-option ' . $selected . '" />';
                                    $colors[] = $color;
                                }
                            }
                        }
                        $stmt->close();
                        ?>
                    </div>
                </div>
                <!-- Chọn Size -->
                <div class="mb-3">
                    <?php
                    // Lấy tất cả các size (size, size2, size3) có cùng title với sản phẩm hiện tại
                    $sizes = [];
                    $stmt = $conn->prepare("SELECT size, size2, size3 FROM product WHERE title = ?");
                    $stmt->bind_param("s", $product['title']);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    while ($row = $res->fetch_assoc()) {
                        foreach (['size', 'size2', 'size3'] as $field) {
                            $sz = $row[$field];
                            if (!empty($sz) && !in_array($sz, $sizes)) {
                                $sizes[] = $sz;
                            }
                        }
                    }
                    $stmt->close();

                    // Sắp xếp size theo thứ tự S, M, L, XL, XXL, XXXL...
                    $size_order = ['S', 'M', 'L', 'XL', 'XXL', 'XXXL', '4XL', '5XL'];
                    usort($sizes, function ($a, $b) use ($size_order) {
                        $posA = array_search(strtoupper($a), $size_order);
                        $posB = array_search(strtoupper($b), $size_order);
                        if ($posA === false) $posA = 100;
                        if ($posB === false) $posB = 100;
                        return $posA - $posB;
                    });
                    ?>
                    <p class="font-semibold">Size:
                        <span id="selectedSize"><?= htmlspecialchars($product['size']) ?></span>
                    </p>
                    <div class="flex gap-2 mt-2 size-options">
                        <?php foreach ($sizes as $size): ?>
                            <button class="size-btn <?= $product['size'] == $size ? 'selected' : '' ?>" data-size="<?= htmlspecialchars($size) ?>">
                                <?= htmlspecialchars($size) ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            document.querySelectorAll(".size-btn").forEach(btn =>
                                btn.addEventListener("click", function() {
                                    document.getElementById("selectedSize").textContent = btn.getAttribute("data-size");
                                })
                            );
                        });
                    </script>
                    <div class="mt-2 flex items-center gap-1">
                        <a href="#" id="openSizeGuide" class="text-black underline font-medium hover:opacity-80">
                            Hướng dẫn chọn size
                        </a>
                        <span>></span>
                    </div>
                </div>
                <!-- Modal bảng chọn size -->

                <div id="sizeGuideModal" class="fixed inset-0 z-50 bg-black/30 bg-opacity-40 hidden flex items-center justify-center overflow-auto p-4">
                    <div class="bg-white rounded-2xl w-[90%] max-w-xl shadow-xl overflow-hidden mx-auto my-auto pt-6">

                        <!-- Header: Tiêu đề + nút đóng -->
                        <div class="flex justify-between items-center p-4 border-b">
                            <h2 class="text-lg font-semibold">Hướng dẫn chọn size</h2>
                            <button id="closeSizeGuide" class="text-gray-500 hover:text-black transition">
                                <!-- Nút đóng (X) -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 8.586l5.657-5.657a1 1 0 111.414 1.414L11.414 10l5.657 5.657a1 1 0 01-1.414 1.414L10 11.414l-5.657 5.657a1 1 0 01-1.414-1.414L8.586 10 2.93 4.343a1 1 0 011.414-1.414L10 8.586z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>

                        <!-- Nội dung ảnh -->
                        <div class="p-4">
                            <img src="https://minio.theciu.vn/theciu-beta/1000/images/wtRpXsYKGg0RjnuENqvVqjLQEPzhTYrxW5vSuoUB.jpg" alt="Size chart" class="w-full rounded-lg">
                        </div>

                    </div>
                </div>


                <p class="mb-2">Tồn kho: <span class="font-semibold"><?= $product['stock'] ?></span></p>

                <!-- Số lượng -->
                <div class="flex items-center gap-2 mb-4">
                    <p>Số lượng:</p>
                    <button id="decrease" class="px-2 border rounded">-</button>
                    <input type="text" id="quantity" value="1" class="w-10 text-center border rounded" readonly />
                    <button id="increase" class="px-2 border rounded">+</button>
                </div>

                <!-- Nút -->
                <form id="addToCartForm" method="post" action="/e-web/user/page/cart/cart.php" class="flex gap-4 mb-3">
                    <input type="hidden" name="pid" value="<?= $product['pid'] ?>">
                    <input type="hidden" name="thumbnail" id="cartThumbnail" value="<?= htmlspecialchars($thumbnail_url) ?>">
                    <input type="hidden" name="title" value="<?= htmlspecialchars($product['title']) ?>">
                    <input type="hidden" name="size" id="cartSize" value="<?= htmlspecialchars($product['size']) ?>">
                    <input type="hidden" name="color" id="cartColor" value="<?= htmlspecialchars($product['color']) ?>">
                    <input type="hidden" name="quantity" id="cartQuantity" value="1">
                    <input type="hidden" name="price" value="<?= $product['price'] ?>">

                    <button type="submit" name="add_to_cart" class="px-4 py-2 border rounded">Thêm vào giỏ</button>
                    <button type="submit" name="buy_now" class="px-4 py-2 bg-gray-800 text-white rounded">Mua ngay</button>
                </form>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        // Cập nhật size khi chọn
                        document.querySelectorAll(".size-btn").forEach(btn =>
                            btn.addEventListener("click", function() {
                                document.getElementById("cartSize").value = btn.getAttribute("data-size");
                            })
                        );
                        // Cập nhật color khi chọn
                        document.querySelectorAll(".color-option").forEach(img =>
                            img.addEventListener("click", function() {
                                document.getElementById("cartColor").value = img.getAttribute("data-color");
                                document.getElementById("cartThumbnail").value = img.src;
                            })
                        );
                        // Cập nhật quantity khi thay đổi
                        document.getElementById("increase")?.addEventListener("click", function() {
                            setTimeout(function() {
                                document.getElementById("cartQuantity").value = document.getElementById("quantity").value;
                            }, 10);
                        });
                        document.getElementById("decrease")?.addEventListener("click", function() {
                            setTimeout(function() {
                                document.getElementById("cartQuantity").value = document.getElementById("quantity").value;
                            }, 10);
                        });
                        // Xử lý thêm vào giỏ hàng bằng AJAX
                        const form = document.getElementById("addToCartForm");
                        form.addEventListener("submit", function(e) {
                            e.preventDefault();
                            const formData = new FormData(form);
                            fetch('/e-web/user/page/cart/add_to_cart.php', {
                                    method: "POST",
                                    body: formData
                                })
                                .then(res => res.text())
                                .then(() => {
                                    // Hiện thông báo thành công
                                    const toast = document.getElementById("cart-success-toast");
                                    toast.style.display = "block";
                                    setTimeout(() => {
                                        toast.style.display = "none";
                                    }, 2000);
                                });
                        });
                    });
                </script>
                <!-- Thông báo thêm vào giỏ hàng -->
                <div id="cart-success-toast" style="display:none;position:fixed;top:32px;right:32px;z-index:9999;">
                    <div style="display:flex;align-items:center;gap:12px;background:#fff;padding:16px 24px;border-radius:16px;box-shadow:0 2px 8px rgba(0,0,0,0.08);font-size:1.2rem;font-weight:500;">
                        <span style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;background:#4ade80;border-radius:50%;">
                            <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <span>Đã thêm vào giỏ hàng!</span>
                    </div>
                </div>
                <!-- Địa chỉ -->
                <div class="text-sm text-purple-600 flex items-center gap-1">
                    <span>📍</span> <span>Địa chỉ còn hàng</span>
                </div>
            </div>
        </div>
        <!-- Danh sách yêu thích -->
        <div class="flex items-center gap-3 mb-8">
            <button id="favoriteBtn" class="text-xl p-1 rounded-full hover:bg-gray-100 transition">
                <span id="heartIcon" style="color: #aaa; transition: color 0.2s;">&#10084;</span>
            </button>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const btn = document.getElementById("favoriteBtn");
                    const icon = document.getElementById("heartIcon");
                    btn.addEventListener("click", function() {
                        if (icon.style.color === "red") {
                            icon.style.color = "#aaa";
                        } else {
                            icon.style.color = "red";
                        }
                    });
                });
            </script>
            <div class="text-gray-700">
                Thêm vào danh sách yêu thích
            </div>
        </div>

        <!-- Tabs -->
        <div class="border-b border-gray-300 flex gap-8 text-gray-500 mb-4">
            <button class="tab-btn font-semibold text-black border-b-2 border-black pb-2 active" data-tab="details">Chi tiết sản phẩm</button>
            <button class="tab-btn pb-2" data-tab="additional">Thông tin bổ sung</button>
            <button class="tab-btn pb-2" data-tab="shipping">Vận chuyển & Đổi trả</button>
        </div>

        <!-- Nội dung của tab -->
        <div id="tab-contents">
            <div class="tab-content" id="details">
                <p>Sản phẩm được thiết kế theo phong cách hiện đại, dễ dàng phối đồ và phù hợp với nhiều hoàn cảnh sử dụng như đi chơi, đi học, đi làm hoặc dạo phố. Chất liệu vải mềm mại, co giãn nhẹ và thoáng mát, mang lại cảm giác thoải mái khi mặc trong thời gian dài. Đường may tỉ mỉ, form dáng chuẩn giúp tôn lên vóc dáng người mặc. Màu sắc trang nhã, dễ kết hợp với phụ kiện và các item thời trang khác. Đây là lựa chọn lý tưởng cho những ai yêu thích sự đơn giản nhưng vẫn muốn nổi bật và cuốn hút.</p>
            </div>
            <div class="tab-content hidden" id="additional">
                <img style="aspect-ratio:1000/1142;" src="./img-product/thongtinbosung.jpg" width="1000" height="1142" />
            </div>
            <div class="tab-content hidden" id="shipping">
                <p>Giao hàng toàn quốc từ 2 - 5 ngày làm việc. Hỗ trợ đổi trả trong 7 ngày nếu sản phẩm bị lỗi từ nhà sản xuất hoặc giao sai.</p>
            </div>
        </div>
        <?php
        // Lấy cid của sản phẩm hiện tại
        $cid = $product['cid'];

        // Lấy ngẫu nhiên 4 sản phẩm cùng cid, loại trừ sản phẩm hiện tại và loại trừ các title đã hiển thị
        $displayed_pids = [$pid];
        $displayed_titles = [mb_strtolower(trim($product['title']))];

        // Lấy các sản phẩm cùng cid, loại trừ sản phẩm hiện tại
        $stmt = $conn->prepare("SELECT pid, title, price, thumbnail FROM product WHERE cid = ? AND pid != ? ORDER BY RAND()");
        $stmt->bind_param("ii", $cid, $pid);
        $stmt->execute();
        $related = $stmt->get_result();

        $shown = 0;
        $max_show = 4;
        $shown_pids = [];
        $shown_titles = [];

        if ($related->num_rows > 0): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-8">
                <?php while ($row = $related->fetch_assoc()):
                    $row_title = mb_strtolower(trim($row['title']));
                    if (
                        in_array($row['pid'], $displayed_pids) ||
                        in_array($row['pid'], $shown_pids) ||
                        in_array($row_title, $displayed_titles) ||
                        in_array($row_title, $shown_titles)
                    ) continue;
                    $shown_pids[] = $row['pid'];
                    $shown_titles[] = $row_title;
                    // Xử lý đường dẫn ảnh
                    $img = $row['thumbnail'];
                    if (strpos($img, 'admin/assets/images/') === 0) {
                        $img = substr($img, strlen('admin/assets/images/'));
                    }
                    $img_url = '/e-web/admin/assets/images/' . rawurlencode(trim($img));
                ?>
                    <div class="bg-gray-100 rounded-xl p-3 flex flex-col">
                        <a href="product_detail.php?pid=<?= $row['pid'] ?>">
                            <img src="<?= $img_url ?>" alt="<?= htmlspecialchars($row['title']) ?>" class="rounded mb-3 h-72 object-cover w-full" />
                        </a>
                        <h3 class="font-medium text-sm mb-1 product-title-ellipsis"><?= htmlspecialchars($row['title']) ?></h3>
                        <p class="font-bold text-lg mb-2"><?= number_format($row['price'], 0, ',', '.') ?>₫</p>
                        <div class="mb-2">
                            <img src="<?= $img_url ?>" class="w-10 h-10 border rounded" />
                        </div>
                        <a href="product_detail.php?pid=<?= $row['pid'] ?>" class="btn-primary mb-2 text-center">Mua ngay</a>
                        <button class="border py-2 rounded-full hover:bg-gray-200">Thêm vào giỏ</button>
                    </div>

                <?php
                    $shown++;
                    if ($shown >= $max_show) break;
                endwhile; ?>
            </div>
        <?php endif;
        $stmt->close(); ?>

        <!-- Nút xem thêm -->
        <div class="text-center mt-8">
            <button class="border px-6 py-2 rounded-full flex items-center gap-2 mx-auto hover:bg-gray-100 transition">
                Xem thêm
                <span>→</span>
            </button>

        </div>

        <!--footer-->
        <footer id="footer" class="footer-custom mt-5">
            <?php include('../../page/message/message.php'); ?>
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
    </div>
</body>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // 1. Ảnh phụ => ảnh chính
        document.querySelectorAll(".thumb").forEach(img =>
            img.addEventListener("click", () => {
                document.getElementById("mainImage").src = img.src;
            })
        );

        // 2. Chọn màu
        const selectedColorText = document.getElementById("selectedColor");
        document.querySelectorAll(".color-option").forEach(img =>
            img.addEventListener("click", () => {
                document.querySelectorAll(".color-option").forEach(i =>
                    i.classList.remove("ring-1", "ring-black")
                );
                img.classList.add("ring-1", "ring-black");
                selectedColorText.textContent = img.getAttribute("data-color");
            })
        );

        // 3. Tăng/giảm số lượng
        const quantityInput = document.getElementById("quantity");
        const cartQuantityInput = document.getElementById("cartQuantity");

        document.getElementById("increase")?.addEventListener("click", function() {
            quantityInput.value = +quantityInput.value + 1;
            cartQuantityInput.value = quantityInput.value;
        });
        document.getElementById("decrease")?.addEventListener("click", function() {
            if (+quantityInput.value > 1) {
                quantityInput.value = +quantityInput.value - 1;
                cartQuantityInput.value = quantityInput.value;
            }
        });

        // 4. Tab chuyển nội dung
        const tabButtons = document.querySelectorAll(".tab-btn");
        const tabContents = document.querySelectorAll(".tab-content");

        tabButtons.forEach(btn =>
            btn.addEventListener("click", () => {
                tabButtons.forEach(b =>
                    b.classList.remove("text-black", "border-black", "font-semibold", "border-b-2", "text-gray-500")
                );
                btn.classList.add("text-black", "border-b-2", "border-black", "font-semibold");

                tabContents.forEach(content => content.classList.add("hidden"));
                document.getElementById(btn.dataset.tab).classList.remove("hidden");
            })
        );

        // 5. Chọn size
        document.querySelectorAll(".size-btn").forEach(btn =>
            btn.addEventListener("click", () => {
                document.querySelectorAll(".size-btn").forEach(b => b.classList.remove("selected"));
                btn.classList.add("selected");
            })
        );

        // 6. Mở/đóng modal
        const modal = document.getElementById("sizeGuideModal");
        document.getElementById("openSizeGuide")?.addEventListener("click", e => {
            e.preventDefault();
            modal.classList.remove("hidden");
        });
        document.getElementById("closeSizeGuide")?.addEventListener("click", () =>
            modal.classList.add("hidden")
        );
        modal.addEventListener("click", e => {
            if (e.target === modal) modal.classList.add("hidden");
        });
    });
</script>