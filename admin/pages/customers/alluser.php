<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . "/e-web/connect.php";

if (isset($_POST['add_user'])) {
    $uname = $_POST['uname'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phonenumber'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (uname, email, address, phonenumber, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $uname, $email, $address, $phone, $password);
    $stmt->execute();
}
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $uid = intval($_GET['delete']);
    $conn->query("DELETE FROM users WHERE uid = $uid");
    header("Location: ".$_SERVER['PHP_SELF']); // Tránh lỗi refresh xóa tiếp
    exit();
}
if (isset($_POST['update_user'])) {
    $uid = $_POST['uid'];
    $uname = $_POST['uname'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phonenumber'];
    $rid = intval($_POST['rid']);

    $stmt = $conn->prepare("UPDATE users SET uname=?, email=?, address=?, phonenumber=?, rid=? WHERE uid=?");
    $stmt->bind_param("ssssii", $uname, $email, $address, $phone, $rid, $uid);
    $stmt->execute();
}


// 1. Xử lý tham số phân trang
$allowed_limits = [10, 25, 50, 100];
$limit = 25;
if (isset($_GET['limit']) && is_numeric($_GET['limit']) && in_array(intval($_GET['limit']), $allowed_limits)) {
    $limit = intval($_GET['limit']);
}
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Corona Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../../../admin/template/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../../admin/template/assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="../../template/assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="../../template/assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../../template/assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="../../template/assets/vendors/owl-carousel-2/owl.theme.default.min.css">
    <!-- End plugin css for this page -->
    <!-- Layout styles -->

    <link rel="stylesheet" href="/e-web/admin/template/assets/css/style.css">

    <!-- End layout styles -->
    <link rel="shortcut icon" href="../../../admin/template/assets/images/favicon.png" />
    <!-- Sử dụng liên kết CDN mới nhất của Font Awesome -->

    <!-- Thêm vào trước thẻ </body> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.7.0/jspdf.plugin.autotable.min.js"></script>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            /* Thêm fallback font */
        }

        /* Đặt sau Bootstrap, hoặc trong file riêng cuối trang */
        .btn-link.custom-purple {
            color: #7c3aed !important;
            /* Màu tím */
            background: none !important;
            box-shadow: none !important;
            border: none !important;
            text-decoration: none !important;
        }

        .btn-link.custom-gray {
            color: #9ca3af !important;
            /* Màu xám */
            background: none !important;
            box-shadow: none !important;
            border: none !important;
            text-decoration: none !important;
        }

        /* Đảm bảo form không bị block */
        .d-flex form {
            display: inline-block;
            margin: 0;
        }
        /* Toàn màn hình overlay */
.overlay-form {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100vh;
  background: rgba(0, 0, 0, 0.7);
  z-index: 9999;
  display: none;
  justify-content: center;
  align-items: center;
}

/* Khi bật form */
.overlay-form.active {
  display: flex;
}

/* Hộp form giữa màn hình */
.form-popup {
  background-color: #111;
  padding: 30px;
  border-radius: 12px;
  width: 100%;
  max-width: 400px;
  color: white;
  box-shadow: 0 0 10px #000;
  animation: slideDown 0.4s ease;
}

/* Hiệu ứng trượt xuống */
@keyframes slideDown {
  from {
    transform: translateY(-100px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

/* Ô input đen, chữ trắng */
.form-popup input.form-control {
  background-color: #222;
  color: #fff;
  border: 1px solid #444;
}

.form-popup input.form-control::placeholder {
  color: #bbb;
}
/* Làm trắng chữ trong input tìm kiếm */
input.form-control {
  background-color: #222 !important;   /* Nền tối */
  color: #fff !important;              /* Chữ trắng */
  border: 1px solid #444 !important;   /* Viền tối */
}

/* Placeholder màu sáng hơn */
input.form-control::placeholder {
  color: #bbb !important;
}

    </style>
</head>

<body>
    <div class="container-scroller">
        <?php include('../../template/sidebar.php'); ?>
        <div class="container-fluid page-body-wrapper">
            <?php include('../../template/navbar.php'); ?>
            <div class="main-panel">
                <div class="content-wrapper">
    <div class="row">
        <!-- Card thống kê -->
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <?php
                                $user_count_sql = "SELECT COUNT(*) as total_users FROM users";
                                $user_result = $conn->query($user_count_sql);
                                $user_row = $user_result->fetch_assoc();
                                ?>
                                <h3 class="mb-0"><?php echo $user_row['total_users']; ?></h3>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-success">
                                <span class="mdi mdi-account-multiple icon-item"></span>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Tổng số người dùng</h6>
                </div>
            </div>
        </div>
    </div>

    <!-- Bảng người dùng -->
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <!-- Tìm kiếm & export -->
                    <div class="row align-items-center mb-4">
                        <div class="col-md-6">
                            <form method="GET" class="d-flex w-100">
                                <input type="text" name="search" class="form-control me-2" placeholder="Tìm theo tên hoặc số điện thoại" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                                <button type="submit" class="btn btn-light ms-2">Tìm</button>
                            </form>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-logout"></i> Export
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                    <a class="dropdown-item" href="#" onclick="openPrintTab(event)"><span class="mdi mdi-printer"></span> Print</a>
                                    <a class="dropdown-item" href="#" onclick="exportTableToExcel('users.xls')"><span class="mdi mdi-file-excel"></span> Excel</a>
                                    <a class="dropdown-item" href="#" onclick="exportTableToPDF()"><span class="mdi mdi-file-pdf"></span> PDF</a>
                                    <a class="dropdown-item" href="#"><span class="mdi mdi-content-copy"></span> Copy</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Bảng dữ liệu -->
                    <div class="table-responsive">
                        <?php
$edit_mode = false;
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $edit_mode = true;
    $edit_uid = intval($_GET['edit']);
    $edit_user = $conn->query("SELECT * FROM users WHERE uid = $edit_uid")->fetch_assoc();
}
?>
<?php if ($edit_mode): ?>
<form method="POST" class="row g-3 mb-4" action="">
    <input type="hidden" name="uid" value="<?= $edit_user['uid'] ?>">
    <div class="col-md-2"><input name="uname" value="<?= $edit_user['uname'] ?>" class="form-control" required></div>
    <div class="col-md-2"><input name="email" value="<?= $edit_user['email'] ?>" class="form-control" required></div>
    <div class="col-md-2"><input name="address" value="<?= $edit_user['address'] ?>" class="form-control"></div>
    <div class="col-md-2"><input name="phonenumber" value="<?= $edit_user['phonenumber'] ?>" class="form-control"></div>
    <div class="col-md-2"><input name="rid" type="number" value="<?= $edit_user['rid'] ?>" class="form-control" required></div>
    <div class="col-md-2">
        <button type="submit" name="update_user" class="btn btn-primary w-100">Cập nhật</button>
    </div>
</form>
<?php endif; ?>

<!-- Nút mở form -->
<button class="btn btn-success mb-3" onclick="toggleAddForm()">+ Thêm người dùng</button>

<!-- Overlay Form -->
<div id="addUserOverlay" class="overlay-form">
  <div class="form-popup">
    <h4 class="text-white mb-4">Thêm người dùng</h4>
    <form method="POST" action="" onsubmit="return confirm('Xác nhận thêm người dùng mới?')">
      <input name="uname" type="text" class="form-control mb-3" placeholder="Tên khách hàng" required>
      <input name="email" type="email" class="form-control mb-3" placeholder="Email" required>
      <input name="address" type="text" class="form-control mb-3" placeholder="Địa chỉ">
      <input name="phonenumber" type="text" class="form-control mb-3" placeholder="Số điện thoại">
      <input name="password" type="password" class="form-control mb-3" placeholder="Mật khẩu" required>
      <input name="rid" type="number" class="form-control mb-3" placeholder="Role ID" required>
      <div class="d-flex justify-content-between">
        <button type="submit" name="add_user" class="btn btn-light">Thêm</button>
        <button type="button" class="btn btn-secondary" onclick="toggleAddForm()">Hủy</button>
      </div>
    </form>
  </div>
</div>

                        <table class="table">
                            <thead>
  <tr>
    <th><input type="checkbox" class="form-check-input"></th>
    <th>USER ID</th>
    <th>Tên Khách Hàng</th>
    <th>Email</th>
    <th>Địa chỉ</th>
    <th>Số điện thoại</th>
    <th>Role ID</th>
    <th>Ngày tạo</th>
    <th>Hành động</th>
  </tr>
</thead>
                            <tbody>
                                <?php
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$search_sql = '';
if ($search !== '') {
    $search_escaped = $conn->real_escape_string($search);
    $search_sql = "WHERE uname LIKE '%$search_escaped%' OR phonenumber LIKE '%$search_escaped%'";
}

// Đếm tổng số người dùng (để phân trang)
$count_sql = "SELECT COUNT(*) as total FROM users $search_sql";
$total_result = $conn->query($count_sql);
$total_row = $total_result->fetch_assoc();
$total_users = $total_row['total'];
$total_pages = max(1, ceil($total_users / $limit));

// Lấy dữ liệu người dùng theo trang
$user_sql = "SELECT uid, uname, email, address, phonenumber, rid, created_at FROM users $search_sql LIMIT $limit OFFSET $offset";
$user_result = $conn->query($user_sql);

// Hiển thị từng dòng
if ($user_result->num_rows > 0) {
    while ($row = $user_result->fetch_assoc()) {
        echo "<tr>
    <td>
        <div class='form-check form-check-muted m-0'>
            <label class='form-check-label'><input type='checkbox' class='form-check-input'></label>
        </div>
    </td>
    <td>{$row['uid']}</td>
    <td>{$row['uname']}</td>
    <td>{$row['email']}</td>
    <td>{$row['address']}</td>
    <td>{$row['phonenumber']}</td>
    <td>{$row['rid']}</td>
    <td>{$row['created_at']}</td>
    <td>
        <a href='?edit={$row['uid']}' class='btn btn-sm btn-warning me-1'>Sửa</a>
        <a href='?delete={$row['uid']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Xóa người dùng này?\")'>Xóa</a>
    </td>
</tr>";
    }
} else {
    echo "<tr><td colspan='6' class='text-center'>Không có người dùng nào</td></tr>";
}
?>

                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end mt-3">
    <nav aria-label="Phân trang người dùng">
        <ul class="pagination mb-0">
            <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                <a class="page-link" href="?page=<?php echo $page - 1; ?>&limit=<?php echo $limit; ?>&search=<?php echo urlencode($search); ?>">«</a>
            </li>
            <?php
            for ($i = 1; $i <= $total_pages; $i++) {
                $active = ($i == $page) ? 'active' : '';
                echo "<li class='page-item $active'><a class='page-link' href='?page=$i&limit=$limit&search=" . urlencode($search) . "'>$i</a></li>";
            }
            ?>
            <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                <a class="page-link" href="?page=<?php echo $page + 1; ?>&limit=<?php echo $limit; ?>&search=<?php echo urlencode($search); ?>">»</a>
            </li>
        </ul>
    </nav>
</div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- end content-wrapper -->
                                 
    <script>
        document.getElementById('productPerPage').addEventListener('change', function() {
            const limit = this.value;
            // Lấy lại tham số page hiện tại (nếu có)
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('limit', limit);
            urlParams.set('page', 1); // Reset về trang 1 khi đổi limit
            window.location.search = urlParams.toString();
        });
    </script>
    <script>
        function openPrintTab(e) {
            e.preventDefault();
            // Lấy HTML phần bảng
            var printContents = document.querySelector('.table-responsive').outerHTML;
            // Tạo cửa sổ/tab mới
            var printWindow = window.open('', '_blank');
            // Ghi nội dung vào tab mới
            printWindow.document.write(`
        <html>
        <head>
            <title>Print</title>
            <link rel="stylesheet" href="/e-web/admin/template/assets/css/style.css">
            <link rel="stylesheet" href="/e-web/admin/template/assets/vendors/mdi/css/materialdesignicons.min.css">
            <link rel="stylesheet" href="/e-web/admin/template/assets/vendors/css/vendor.bundle.base.css">
            <style>
                body { background: #fff; margin: 40px; }
                .table { width: 100%; }
            </style>
        </head>
        <body>
            ${printContents}
            <script>
                window.onload = function() { window.print(); }
            <\/script>
        </body>
        </html>
    `);
            printWindow.document.close();
        }
    </script>
    <!-- Thêm nút in vào trang -->
    <script>
        function exportTableToExcel(filename) {
            var dataType = 'application/vnd.ms-excel';
            var tableSelect = document.querySelector('.table');
            var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
            var downloadLink = document.createElement("a");
            document.body.appendChild(downloadLink);
            downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
            downloadLink.download = filename;
            downloadLink.click();
            document.body.removeChild(downloadLink);
        }
    </script>
    <script>
        function exportTableToPDF() {
            var {
                jsPDF
            } = window.jspdf;
            var doc = new jsPDF();
            doc.autoTable({
                html: '.table'
            });
            doc.save('orders.pdf');
        }
    </script>
    <!-- filter order status -->
    <script>
        document.getElementById('orderStatusFilter').addEventListener('change', function() {
            filterOrders();
        });

        document.getElementById('paymentStatusFilter').addEventListener('change', function() {
            filterOrders();
        });

        function filterOrders() {
            var orderStatus = document.getElementById('orderStatusFilter').value;
            var paymentStatus = document.getElementById('paymentStatusFilter').value;
            var table = document.querySelector('.table');
            var trs = table.getElementsByTagName('tr');

            // Bắt đầu từ 1 để bỏ qua header
            for (var i = 1; i < trs.length; i++) {
                var orderStatusCell = trs[i].querySelector('td:nth-child(6)'); // Cột Order Status
                var paymentStatusCell = trs[i].querySelector('td:nth-child(7)'); // Cột Payment Status

                if (orderStatusCell && paymentStatusCell) {
                    var orderStatusText = orderStatusCell.textContent.trim();
                    var paymentStatusText = paymentStatusCell.textContent.trim();

                    var orderMatch = orderStatus === '' || orderStatusText === orderStatus;
                    var paymentMatch = paymentStatus === '' || paymentStatusText === paymentStatus;

                    if (orderMatch && paymentMatch) {
                        trs[i].style.display = '';
                    } else {
                        trs[i].style.display = 'none';
                    }
                }
            }
        }
    </script>

    <!-- Confirm Delete Function -->
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this order? This action cannot be undone.');
        }
    </script>
</body>
<?php
// Đóng kết nối ở đây, sau khi đã sử dụng xong
$conn->close();
?>
<script src="../../template/assets/vendors/js/vendor.bundle.base.js"></script>
<script src="../../template/assets/vendors/chart.js/Chart.min.js"></script>
<script src="../../template/assets/js/jquery.cookie.js" type="text/javascript"></script>
<script src="../../template/assets/js/misc.js"></script>
<!-- search order -->
<script>
    document.getElementById('searchOrder').addEventListener('input', function() {
        var filter = this.value.trim().toUpperCase();
        var table = document.querySelector('.table');
        var trs = table.getElementsByTagName('tr');
        // Bắt đầu từ 1 để bỏ qua header
        for (var i = 1; i < trs.length; i++) {
            var td = trs[i].getElementsByTagName('td')[1]; // cột ORDER (thường là cột thứ 2)
            if (td) {
                var txtValue = td.textContent.trim() || td.innerText.trim();
                trs[i].style.display = txtValue.toUpperCase().indexOf(filter) > -1 ? "" : "none";
            }
        }
    });
</script>
<script>
function toggleAddForm() {
    const overlay = document.getElementById('addUserOverlay');
    overlay.classList.toggle('active');
}

// Đóng form khi click ra ngoài
document.getElementById('addUserOverlay').addEventListener('click', function (e) {
    if (e.target === this) {
        this.classList.remove('active');
    }
});

// Đóng form bằng phím ESC
document.addEventListener('keydown', function (e) {
    if (e.key === "Escape") {
        document.getElementById('addUserOverlay').classList.remove('active');
    }
});
</script>
