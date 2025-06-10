<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . "/e-web/connect.php";



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
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" class="form-check-input"></th>
                                    <th>USER ID</th>
                                    <th>Tên Khách Hàng</th>
                                    <th>Email</th>
                                    <th>Địa chỉ</th>
                                    <th>Số điện thoại</th>
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
$user_sql = "SELECT uid, uname, email, address, phonenumber FROM users $search_sql LIMIT $limit OFFSET $offset";
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