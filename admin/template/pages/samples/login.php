<!DOCTYPE html>
<html lang="en">
<?php
session_start();

// Kiểm tra nếu đã đăng nhập và role hợp lệ
if (isset($_SESSION['username']) && isset($_SESSION['role'])) {
  if ($_SESSION['role'] == 1) {
    header('Location: /../admin/template/index.php');
   
  } else if ($_SESSION['role'] == 2) {
    header('Location: /../user/index.html');
    
  }
}

?>


<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Corona Admin</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../assets/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <!-- endinject -->
  <!-- Layout styles -->
  <link rel="stylesheet" href="../../assets/css/style.css">
  <link rel="stylesheet" href="../../../assets/product.css">

  <!-- End layout styles -->
  <link rel="shortcut icon" href="../../assets/images/favicon.png" />
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Toastr CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

  <!-- Toastr JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  
  
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="row w-100 m-0">
        <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
          <div class="card col-lg-4 mx-auto">
            <div class="card-body px-5 py-5">
              <h3 class="card-title text-left mb-3">Login</h3>

              <form method="POST">
                <div class="form-group">
                  <label>Username or email *</label>
                  <input name="username" type="text" class="form-control p_input">
                </div>
                <div class="form-group">
                  <label>Password *</label>
                  <input name="password" type="text" class="form-control p_input">
                </div>
                <div class="form-group d-flex align-items-center justify-content-between">
                  <div class="form-check">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input"> Remember me </label>
                  </div>
                  <a href="#" class="forgot-pass">Forgot password</a>
                </div>
                <div class="text-center">
                  <button type="submit" name="btn_login" class="btn btn-primary btn-block enter-btn">Login</button>
                </div>
                <div class="d-flex">
                  <button class="btn btn-facebook me-2 col">
                    <i class="mdi mdi-facebook"></i> Facebook </button>
                  <button class="btn btn-google col">
                    <i class="mdi mdi-google-plus"></i> Google plus </button>
                </div>
                <p class="sign-up">Don't have an Account?<a href="#"> Sign Up</a></p>
              </form>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- row ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <?php
  include "/e-web/connect.php";

  // Kiểm tra nếu người dùng đã ân nút đăng nhập thì mới xử lý
  if (isset($_POST["btn_login"])) {
    // lấy thông tin người dùng
    $username = $_POST["username"];
    $password = $_POST["password"];
    //làm sạch thông tin, xóa bỏ các tag html, ký tự đặc biệt 
    //mà người dùng cố tình thêm vào để tấn công theo phương thức sql injection
    $username = strip_tags($username);
    $username = addslashes($username);

    $password = strip_tags($password);
    $password = addslashes($password);
    if ($username == "" || $password == "") {
      //echo "username hoặc password bạn không được để trống!";
      echo "<script>
      $(document).ready(function() {
        toastr.error('Không để trống thông tin đăng nhập!', 'Lỗi');
      });
    </script>";
    exit;
    } else {
      $sql = "select * from users where uid = '$username' and password = '$password' ";
      $query = mysqli_query($conn, $sql);
      $num_rows = mysqli_num_rows($query);

      if ($num_rows == 0) {
        echo "<script>
        $(document).ready(function() {
          toastr.error('Sai thông tin đăng nhập!', 'Lỗi');
        });
    </script>";
        //echo "tên đăng nhập hoặc mật khẩu không đúng !";
        exit;
      }

      while ($row = $query->fetch_row()) {
        if ($row[6] == 1) {
          $_SESSION['username'] = $username;  // lưu username vào session
          $_SESSION['role'] = 1;        // nếu muốn phân quyền
          header('Location: /../admin/template/index.php');
          echo "Username: " . htmlspecialchars($username) . "<br>";
          exit;
        } else {
          $_SESSION['username'] = $username;
          $_SESSION['role'] = 2;
          header('Location: /../user/index.html');
          exit;
        }
      }
    }
  }
  ?>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="../../assets/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="../../assets/js/off-canvas.js"></script>
  <script src="../../assets/js/hoverable-collapse.js"></script>
  <script src="../../assets/js/misc.js"></script>
  <script src="../../assets/js/settings.js"></script>
  <script src="../../assets/js/todolist.js"></script>
  <script>
    window.addEventListener('pageshow', function(event) {
      if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
        window.location.reload();
      }
    });
  </script>

  <!-- endinject -->
</body>

</html>