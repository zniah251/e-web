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

<<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Blog</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="../woman/woman.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

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
