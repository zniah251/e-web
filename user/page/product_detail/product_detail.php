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
       
  * {
    font-family: 'Times New Roman', Times, serif !important;
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
            <span>Áo kiểu layer hai dây...</span>
        </nav>
        <div class="flex flex-col lg:flex-row gap-6 lg:gap-10 items-start">
            <!-- Cột trái: ảnh sản phẩm -->
            <div class="flex flex-col sm:flex-row">
                <!-- Ảnh chính -->
                <img id="mainImage" src="./img-product/aokieuhaiday.jpg" alt="Ảnh chính" class="w-full max-w-sm h-auto rounded-xl shadow" />

                <!-- Ảnh phụ bên phải ảnh chính -->
                <div class="flex flex-col gap-3 ml-4 scale-90 sm:scale-100 origin-top-left">
                    <img src="./img-product/aokieuhaiday1.jpg" class="w-16 md:w-20 h-24 object-cover border rounded cursor-pointer thumb" />
                    <img src="./img-product/aokieuhaiday2.jpg" class="w-16 md:w-20 h-24 object-cover border rounded cursor-pointer thumb" />
                    <img src="./img-product/aokieuhaiday3.jpg" class="w-16 md:w-20 h-24 object-cover border rounded cursor-pointer thumb" />
                </div>
            </div>

            <!-- Cột phải: thông tin sản phẩm -->
            <div class="w-full lg:max-w-xl">
                <h1 class="text-2xl font-bold mb-3">Áo kiểu layer hai dây trơn dáng ôm KAIRA – Betty Tank Top</h1>
                <p class="mb-3 text-gray-600">Thiết kế tối giản nhưng tinh tế, Betty Tank Top là item không thể thiếu trong tủ đồ nàng yêu thời trang hiện đại. Áo dáng ôm nhẹ, tôn đường cong cơ thể, kết hợp phần dây mảnh nữ tính tạo hiệu ứng layer thời thượng khi phối cùng sơ mi, blazer hoặc cardigan</p>
                <p class="text-red-600 text-xl font-semibold mb-3">175.000₫</p>

                <div class="mb-3">
                    <p class="font-semibold">Màu sắc: <span id="selectedColor" class="font-normal"></span></p>
                    <!-- Màu sắc -->
                    <div class="flex gap-2 mt-2">
                        <img src="./img-product/mauden.jpg" data-color="Black" class="w-10 h-10 border rounded cursor-pointer color-option  ring-1 ring-black" />
                        <img src="./img-product/mautrang.jpg" data-color="White" class="w-10 h-10 border rounded cursor-pointer color-option" />
                    </div>
                </div>
                <!-- Chọn Size -->
                <div class="mb-3">
                    <p class="font-semibold">Size:</p>
                    <div class="flex gap-2 mt-2 size-options">
                        <button class="size-btn selected" data-size="S">S</button>
                        <button class="size-btn" data-size="M">M</button>
                        <button class="size-btn" data-size="L">L</button>
                    </div>
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


                <p class="mb-2">Tồn kho: <span class="font-semibold">4</span></p>

                <!-- Số lượng -->
                <div class="flex items-center gap-2 mb-4">
                    <p>Số lượng:</p>
                    <button id="decrease" class="px-2 border rounded">-</button>
                    <input type="text" id="quantity" value="1" class="w-10 text-center border rounded" readonly />
                    <button id="increase" class="px-2 border rounded">+</button>
                </div>

                <!-- Nút -->
                <div class="flex gap-4 mb-3">
                    <button class="px-4 py-2 border rounded">Thêm vào giỏ</button>
                    <button class="px-4 py-2 bg-gray-800 text-white rounded">Mua ngay</button>
                </div>

                <!-- Địa chỉ -->
                <div class="text-sm text-purple-600 flex items-center gap-1">
                    <span>📍</span> <span>Địa chỉ còn hàng</span>
                </div>
            </div>
        </div>
        <!-- Danh sách yêu thích -->
        <div class="flex items-center gap-3 mb-8">
            <button class="text-xl p-1 rounded-full hover:bg-gray-100 transition">
                🤍
            </button>
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
                <p>Thiết kế tối giản nhưng tinh tế, Betty Tank Top là item không thể thiếu trong tủ đồ nàng yêu thời trang hiện đại. Áo dáng ôm nhẹ, tôn đường cong cơ thể, kết hợp phần dây mảnh nữ tính tạo hiệu ứng layer thời thượng khi phối cùng sơ mi, blazer hoặc cardigan.</p>
            </div>
            <div class="tab-content hidden" id="additional">
                <img style="aspect-ratio:1000/1142;" src="./img-product/thongtinbosung.jpg" width="1000" height="1142" />
            </div>
            <div class="tab-content hidden" id="shipping">
                <p>Giao hàng toàn quốc từ 2 - 5 ngày làm việc. Hỗ trợ đổi trả trong 7 ngày nếu sản phẩm bị lỗi từ nhà sản xuất hoặc giao sai.</p>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-8">
            <!-- Card sản phẩm -->
            <div class="bg-gray-100 rounded-xl p-3 flex flex-col">
                <img src="./img-product/icytop(4).jpg" alt="Irene Top - White" class="rounded mb-3 h-72 object-cover w-full" />
                <h3 class="font-medium text-sm line-clamp-2 mb-1">Áo kiểu form ngắn tay phồng...</h3>
                <p class="font-bold text-lg mb-2">295.000₫</p>
                <div class="mb-2">
                    <img src="./img-product/icytop(4).jpg" class="w-10 h-10 border rounded" />
                </div>
                <button class="btn-primary mb-2">Mua ngay</button>
                <button class="border py-2 rounded-full hover:bg-gray-200">Thêm vào giỏ</button>
            </div>

            <!-- Card sản phẩm -->
            <div class="bg-gray-100 rounded-xl p-3 flex flex-col">
                <img src="./img-product/naomitop.jpg" alt="Ivy Top - Black" class="rounded mb-3 h-72 object-cover w-full" />
                <h3 class="font-medium text-sm line-clamp-2 mb-1">Áo kiểu tay phồng phối bèo dáng...</h3>
                <p class="font-bold text-lg mb-2">295.000₫</p>
                <div class="mb-2">
                    <img src="./img-product/naomitop.jpg" class="w-10 h-10 border rounded" />
                </div>
                <button class="btn-primary mb-2">Mua ngay</button>
                <button class="border py-2 rounded-full hover:bg-gray-200">Thêm vào giỏ</button>
            </div>

            <!-- Card sản phẩm -->
            <div class="bg-gray-100 rounded-xl p-3 flex flex-col relative">
                <!-- Nhãn NEW -->
                <img src="./img-product/RisoTubeTop2.jpg" alt="Gigi Top - Cream" class="rounded mb-3 h-72 object-cover w-full" />
                <h3 class="font-medium text-sm line-clamp-2 mb-1">Áo babydoll cổ sen tay phồng ...</h3>
                <p class="font-bold text-lg mb-2">295.000₫</p>
                <div class="mb-2">
                    <img src="./img-product/RisoTubeTop2.jpg" class="w-10 h-10 border rounded" />
                </div>
                <button class="btn-primary mb-2">Mua ngay</button>
                <button class="border py-2 rounded-full hover:bg-gray-200">Thêm vào giỏ</button>
            </div>

            <!-- Card sản phẩm -->
            <div class="bg-gray-100 rounded-xl p-3 flex flex-col">
                <img src="./img-product/aogile.jpg" alt="Áo thun polo" class="rounded mb-3 h-72 object-cover w-full" />
                <h3 class="font-medium text-sm line-clamp-2 mb-1">Áo thun polo tay dài dáng ôm ...</h3>
                <p class="font-bold text-lg mb-2">335.000₫</p>
                <div class="mb-2">
                    <img src="./img-product/aogile.jpg" class="w-10 h-10 border rounded" />
                </div>
                <button class="btn-primary mb-2">Mua ngay</button>
                <button class="border py-2 rounded-full hover:bg-gray-200">Thêm vào giỏ</button>
            </div>
        </div>

        <!-- Nút xem thêm -->
        <div class="text-center mt-8">
            <button class="border px-6 py-2 rounded-full flex items-center gap-2 mx-auto hover:bg-gray-100 transition">
                Xem thêm
                <span>→</span>
            </button>

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
        document.getElementById("increase")?.addEventListener("click", () =>
            quantityInput.value = +quantityInput.value + 1
        );
        document.getElementById("decrease")?.addEventListener("click", () => {
            if (+quantityInput.value > 1) quantityInput.value--;
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