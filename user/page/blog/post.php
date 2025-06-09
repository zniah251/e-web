<?php
include('../../../connect.php');

if (!isset($_GET['id'])) {
    echo "Bài viết không tồn tại.";
    exit;
}

$bid = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM blog WHERE bid = $bid");

if (!$result || mysqli_num_rows($result) === 0) {
    echo "Không tìm thấy bài viết.";
    exit;
}

$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Blog</title>
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
<style>
       body {
            font-family: 'Times New Roman', serif;
  
            /* Thêm fallback font */
        }
        h1, h2, h3, h4, h5,h6 {
            font-family: 'Times New Roman', Times, serif !important;
            color: black;
            /* Sử dụng font Times New Roman cho tiêu đề */
        }
</style>
</head>
<body>
    <?php include('../../../navbar.php'); ?>
    <div class="container py-5">
        <h1><?= htmlspecialchars($row['title']) ?></h1>
        <p><em>Ngày đăng: <?= date('d/m/Y', strtotime($row['created_at'])) ?></em></p>
        <img src="/e-web/blog/<?= htmlspecialchars($row['image']) ?>" alt="Blog Image" style="max-width:100%; height:auto;">
        <div style="margin-top:20px;">
            <?= $row['content'] ?>
        </div>
    </div>
    <?php include('../../../footer.php'); ?>
</body>
</html>
