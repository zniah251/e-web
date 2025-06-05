<?php
include $_SERVER['DOCUMENT_ROOT'] . "/e-web/connect.php";
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
        body {}

        .product-card:hover .product-image-zoom {
            transform: scale(1.1);
        }
        
        .product-image-zoom {
            transform: scale(1.0);
            transition: all 0.3s ease-in-out;
            will-change: transform;
        }

        /* Thêm style cho nút wishlist */
        .btn-icon.btn-wishlist {
            position: absolute;
            top: 10px;
            right: 10px;
            background: white;
            border-radius: 50%;
            padding: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            opacity: 0; /* Ẩn ban đầu */
            transform: translateY(10px); /* Dịch xuống 10px */
            transition: all 0.3s ease;
            z-index: 10;
        }

        .product-card:hover .btn-wishlist {
            opacity: 1; /* Hiện khi hover */
            transform: translateY(0); /* Trở về vị trí gốc */
        }

        .btn-icon.btn-wishlist:hover {
            transform: scale(1.1);
            background: #f8f8f8;
        }

        .btn-icon.btn-wishlist svg {
            width: 24px;
            height: 24px;
            stroke: #ff4444;
            stroke-width: 2;
            fill: none;
            transition: fill 0.3s ease;
        }

        .btn-icon.btn-wishlist:hover svg {
            fill: #ff4444;
        }

        /* Custom CSS nếu cần, ví dụ cho ellipsis */
        .product-title-ellipsis {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Custom styles cho các nút (nếu Tailwind default không đủ) */
        .btn-primary {
            background-color: #434343;
            color: white;
            padding: 0.5rem;
            border-radius: 9999px;

        }

        .btn-primary:hover {
            background-color: #2f2f2f;
        }

    </style>
</head>

<body>
    <?php include('../../../navbar.php'); ?>
    <div class="flex min-h-screen py-8 px-4 sm:px-6 lg:px-8" style="background-color: #f1f1f0;">
        <?php include('../../../sidebar2.php'); ?>
        <div class="flex-1 bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-2xl font-semibold mb-6 text-gray-800" style="border-bottom: 1px solid rgba(0,0,0,0.1); padding-bottom: 15px;">Sản phẩm yêu thích</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <div class="product-card bg-gray-100 rounded-xl p-3 flex flex-col shadow-sm">
                    <div class="relative overflow-hidden rounded mb-3">
                        <a href="product_detail.php?pid=1" class="block">
                            <img src="" alt="Chân váy jean ngắn vạt lệch" class="h-72 object-cover w-full product-image-zoom" />
                        </a>
                        <a href="#" class="btn-icon btn-wishlist">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        </a>
                    </div>
                    <h3 class="font-medium text-base mb-1 product-title-ellipsis">Chân váy jean ngắn vạt lệch</h3>
                    <p class="font-bold text-lg mb-2">355.000₫</p>
                    <div class="mb-2">
                        <img src="" class="w-10 h-10 border rounded" />
                    </div>
                    <a href="product_detail.php?pid=1" class="btn-primary mb-2 text-center">Mua ngay</a>
                    <button class="border py-2 rounded-full hover:bg-gray-200">Thêm vào giỏ</button>
                </div>

                <div class="product-card bg-gray-100 rounded-xl p-3 flex flex-col shadow-sm">
                    <div class="relative overflow-hidden rounded mb-3">
                        <a href="product_detail.php?pid=1" class="block">
                            <img src=" " alt="Chân váy jean ngắn vạt lệch" class="h-72 object-cover w-full product-image-zoom" />
                        </a>
                        <a href="#" class="btn-icon btn-wishlist">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        </a>
                    </div>
                    <h3 class="font-medium text-base mb-1 product-title-ellipsis">Chân váy jean ngắn vạt lệch</h3>
                    <p class="font-bold text-lg mb-2 ">355.000₫</p>
                    <div class="mb-2">
                        <img src=" " class="w-10 h-10 border rounded" />
                    </div>
                    <a href="product_detail.php?pid=1" class="btn-primary mb-2 text-center">Mua ngay</a>
                    <button class="border py-2 rounded-full hover:bg-gray-200">Thêm vào giỏ</button>
    </div>
            </div>
        </div>
    </div>
    <?php include('../../../footer.php'); ?>

</body>