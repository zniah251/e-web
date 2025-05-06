<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Bài viết chi tiết</title>

  <!-- ✅ Gắn Google Fonts đúng cách -->
  <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- ✅ CSS để sử dụng font -->
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Be Vietnam Pro', sans-serif !important;
      margin: 0;
      padding: 0;
      background-color: #fff;
      color: #222;
      line-height: 1.6;
    }

    .post-container {
      max-width: 900px;
      margin: 40px auto;
      padding: 20px;
    }

    #title {
      font-size: 32px;
      font-weight: 700;
      margin-bottom: 20px;
      text-align: center;
      line-height: 1.4;
    }

    #meta {
      font-size: 14px;
      color: #888;
      margin-bottom: 30px;
      text-align: center;
    }

    .post-image {
      width: 100%;
      max-height: 450px;
      object-fit: cover;
      border-radius: 10px;
      margin-bottom: 25px;
    }

    #content h3 {
      font-size: 22px;
      font-weight: 600;
      margin-top: 30px;
      color: #333;
    }

    #content p {
      font-size: 16px;
      margin: 10px 0;
      color: #444;
    }
  </style>
</head>
<body>
  <div class="post-container">
    <h1 id="title">Đang tải...</h1>
    <p id="meta" class="post-meta"></p>
    <img id="image" class="post-image" src="" alt="Ảnh bài viết" />
    <div id="content"></div>
  </div>

  <!-- ✅ Đảm bảo đường dẫn đúng -->
  <script src="js/blog.js"></script>
</body>
</html>
