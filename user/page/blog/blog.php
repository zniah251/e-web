<?php include('../../../connect.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>Blog</title>
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
