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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>Blog</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../../user/css/vendor.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
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
        }

        h1,
        h2,
        h3,
        h4,
        h5 {
            font-family: 'Times New Roman', Times, serif !important;
            /* Sử dụng font Times New Roman cho tiêu đề */
        }

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
        <a href="../../index.php">Trang chủ</a> <span class="breadcrumb-separator">&gt;</span> <span>Blog</span>
    </nav>
  <div class="container">
    <div class="row justify-content-center" id="blog-container">
      <?php
        $result = mysqli_query($conn, "SELECT * FROM blog ORDER BY created_at DESC");
        while ($row = mysqli_fetch_assoc($result)) {
          echo '<div class="post-item">';
          echo '<div class="post-image"><img src="/e-web/blog/' . htmlspecialchars($row['image']) . '" alt="Blog Image"></div>';
          echo '<div class="post-title"><a href="post.php?id=' . $row['bid'] . '">' . htmlspecialchars($row['title']) . '</a></div>';
          echo '<div class="post-meta">Ngày đăng: ' . date('d/m/Y', strtotime($row['created_at'])) . '</div>';
          echo '<div class="post-content"><p>' . mb_substr(strip_tags($row['content']), 0, 100) . '...</p></div>';
          echo '</div>';
        }
      ?>
    </div>
  </div>
</body>
      
    <?php include('../../../footer.php'); ?>
</html>
