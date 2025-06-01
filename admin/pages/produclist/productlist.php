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
        .switch {
            position: relative;
            display: inline-block;
            width: 32px;
            height: 18px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: gray;
            border-radius: 34px;
            box-shadow: 0 2px 8px 0 #7b7bff33;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 12px;
            width: 12px;
            left: 3px;
            bottom: 3px;
            background: #fff;
            border-radius: 50%;
            transition: .4s;
        }

        input:checked+.slider {
            background: #6366f1;
        }

        input:checked+.slider:before {
            transform: translateX(14px);
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
                        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-9">
                                            <div class="d-flex align-items-center align-self-start">
                                                <h3 class="mb-0 ">56</h3>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="icon icon-box-success ">
                                                <span class="mdi mdi-calendar-clock icon-item"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="text-muted font-weight-normal">Pending Payment</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-9">
                                            <div class="d-flex align-items-center align-self-start">
                                                <h3 class="mb-0 ">17</h3>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="icon icon-box-success">
                                                <span class="mdi mdi-check-all icon-item"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="text-muted font-weight-normal">Completed</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-9">
                                            <div class="d-flex align-items-center align-self-start">
                                                <h3 class="mb-0 ">12</h3>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="icon icon-box-danger">
                                                <span class="mdi mdi-credit-card icon-item"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="text-muted font-weight-normal">Refunded</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-9">
                                            <div class="d-flex align-items-center align-self-start">
                                                <h3 class="mb-0 ">3</h3>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="icon icon-box-success ">
                                                <span class="mdi mdi-alert icon-item"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="text-muted font-weight-normal">Failed</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">

                                        <div class="add-items">
                                            <input type="text" id="searchProduct" class="form-control todo-list-input w-75" placeholder="Search product" style="color:white;">
                                        </div>
                                        <div class="d-flex align-items-center gap-3">
                                            <!-- Select số lượng sản phẩm -->
                                            <select class="btn btn-secondary dropdown-toggle" id="productPerPage" style="text-align: center; text-align-last: center;">
                                                <option>10</option>
                                                <option>25</option>
                                                <option>50</option>
                                                <option>100</option>
                                            </select>

                                            <!-- Nút Export -->
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="mdi mdi-logout"></i> Export
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                                    <a class="dropdown-item" href="#"><span class="mdi mdi-printer"></span> Print</a>
                                                    <a class="dropdown-item" href="#" onclick="exportTableToExcel('orders.xls')">
                                                        <span class="mdi mdi-file-excel"></span> Excel
                                                    </a>
                                                    <a class="dropdown-item" href="#" onclick="exportTableToPDF()">
                                                        <span class="mdi mdi-file-pdf"></span> Pdf
                                                    </a>
                                                    <a class="dropdown-item" href="#"><span class="mdi mdi-content-copy"></span> Copy</a>
                                                </div>
                                            </div>
                                            <!-- Nút Add Product -->
                                            <a href="/e-web/admin/pages/add-product/product.php" class="btn" style="background:#6366f1;color:#fff;font-weight:500;box-shadow:0 2px 8px 0 #7b7bff33;">
                                                <i class="mdi mdi-plus"></i> Add Product
                                            </a>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <div class="form-check form-check-muted m-0">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" class="form-check-input">
                                                            </label>
                                                        </div>
                                                    </th>
                                                    <th> PRODUCT </th>
                                                    <th> CATEGORY </th>
                                                    <th> STOCK </th>
                                                    <th> SKU </th>
                                                    <th> PRICE </th>
                                                    <th> QTY </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="form-check form-check-muted m-0">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" class="form-check-input">
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <img src="/e-web/admin/template/assets/images/faces/face1.jpg" alt="image" style="width:40px;height:40px;object-fit:cover;border-radius:0;">
                                                        <span class="ps-2">Henry Klein</span>
                                                    </td>
                                                    <td> 02312 </td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox">
                                                            <span class="slider"></span>
                                                        </label>
                                                    </td>
                                                    <td> 02315 </td>
                                                    <td>
                                                        23
                                                    </td>
                                                    <td> 02312 </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-check form-check-muted m-0">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" class="form-check-input">
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <img src="/e-web/admin/template/assets/images/faces/face1.jpg" alt="image" style="width:40px;height:40px;object-fit:cover;border-radius:0;">
                                                        <span class="ps-2">Henry Klein</span>
                                                    </td>
                                                    <td> 02312 </td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox">
                                                            <span class="slider"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <span class="ps-2">Henry Klein</span>
                                                    </td>
                                                    <td>
                                                        12
                                                    </td>
                                                    <td>
                                                        34
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-check form-check-muted m-0">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" class="form-check-input">
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <img src="/e-web/admin/template/assets/images/faces/face1.jpg" alt="image" style="width:40px;height:40px;object-fit:cover;border-radius:0;">
                                                        <span class="ps-2">Henry Klein</span>
                                                    </td>
                                                    <td> 02312 </td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox">
                                                            <span class="slider"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        22
                                                    </td>
                                                    <td>
                                                        33
                                                    </td>
                                                    <td>
                                                        222
                                                    </td>

                                                </tr>

                                            </tbody>
                                        </table>
                                        <script>
                                            document.getElementById('searchProduct').addEventListener('input', function() {
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
</body>
<script src="../../template/assets/vendors/js/vendor.bundle.base.js"></script>
<script src="../../template/assets/vendors/chart.js/Chart.min.js"></script>
<script src="../../template/assets/js/jquery.cookie.js" type="text/javascript"></script>
<script src="../../template/assets/js/misc.js"></script>