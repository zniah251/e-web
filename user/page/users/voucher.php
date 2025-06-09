<?php
session_start(); // Bắt đầu session ở đầu file
// Kiểm tra xem người dùng đã đăng nhập chưa
// Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
if (!isset($_SESSION['uid']) || $_SESSION['uid'] <= 0) {
    // Điều chỉnh đường dẫn đến trang đăng nhập của bạn
    header("Location: /e-web/user/page/sign-in/login2.php");
    exit();
}
include $_SERVER['DOCUMENT_ROOT'] . "/e-web/connect.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Kaira Shopping Cart</title>
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../../user/css/vendor.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <link rel="stylesheet" type="text/css" href="abtus.css">
    <link rel="stylesheet" type="text/css" href="../../style.css">
    <link rel="stylesheet" type="text/css" href="../../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../../css/swiper-bundle.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" />
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" />
    <!-- MDB -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&family=Marcellus&display=swap"
        rel="stylesheet">
    <link href="/e-web/user/css/tailwind-replacement.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Times New Roman', serif;
            color: black;
            /* Thêm fallback font */
        }
        h1, h2, h3, h4, h5 {
            font-family: 'Times New Roman', Times, serif !important;
            /* Sử dụng font Times New Roman cho tiêu đề */
        }

        /* Layout styles */
        .flex { display: flex; }
        .flex-col { flex-direction: column; }
        .flex-1 { flex: 1 1 0%; }
        .grid { display: grid; }
        .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
        .gap-6 { gap: 1.5rem; }
        .gap-x-6 { column-gap: 1.5rem; }
        .gap-y-4 { row-gap: 1rem; }
        
        /* Responsive Grid */
        @media (min-width: 640px) {
            .sm\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
/* Spacing */
        .p-6 { padding: 1.5rem; }
        .p-3 { padding: 0.75rem; }
        .mb-6 { margin-bottom: 1.5rem; }
        .mb-3 { margin-bottom: 0.75rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-1 { margin-bottom: 0.25rem; }
        /* Typography */
        .text-2xl { font-size: 1.5rem; }
        .text-lg { font-size: 1.125rem; }
        .text-sm { font-size: 0.875rem; }
        .font-semibold { font-weight: 600; }
    </style>
</head>
<body>
    <?php include('../../../navbar.php'); ?>
   <div class="flex min-h-screen py-8 px-4 sm:px-6 lg:px-8" style="background-color: #f1f1f0;">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/e-web/sidebar2.php'; ?>
        <div class="flex-1 bg-white p-6 rounded-lg shadow-md" style="margin: 20px 0;">
            <h3 class="text-2xl font-semibold mb-6 text-gray-800" style="border-bottom: 1px solid rgba(0,0,0,0.1); padding-bottom: 15px;">Voucher</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            </div>
        </div>

    </div>
     <?php include('../../../footer.php'); ?>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>
</html>
    