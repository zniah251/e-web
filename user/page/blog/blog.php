<?php include('../../../connect.php'); ?>
<!DOCTYPE html>
<html lang="en">

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
            /* Thêm fallback font */
        }
    /* CSS giữ nguyên như bạn viết */
    #blog-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: start;
      gap: 30px;
    }
    h2.text-uppercase.mb-4 {
      font-size: 28px;
      font-weight: 600;
      margin-bottom: 30px;
      text-align: center;
    }
    .post-item {
      max-width: 360px;
      width: 100%;
      background-color: #fff;
      padding: 15px;
      border: 1px solid #eee;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      transition: all 0.3s ease;
    }
    .post-item:hover {
      box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    }
    .post-image {
      height: 180px;
      overflow: hidden;
      border-radius: 8px;
    }
    .post-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .post-title {
      margin-top: 10px;
      font-size: 20px;
      font-weight: 600;
      color: #333;
    }
    .post-title a {
      text-decoration: none;
      color: inherit;
    }
    .post-title a:hover {
      color: #7e57c2;
    }
    .post-meta {
      font-size: 14px;
      color: #888;
      margin-top: 10px;
    }
    .post-content p {
      font-size: 15px;
      color: #444;
      margin-top: 8px;
      line-height: 1.5;
    }
  </style>
</head>
<body>
  <?php include('../../../navbar.php'); ?>
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
