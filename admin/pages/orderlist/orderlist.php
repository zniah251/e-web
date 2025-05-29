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

    </style>
    <!-- Thêm vào trước thẻ </body> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.7.0/jspdf.plugin.autotable.min.js"></script>
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
                                                <span class="mdi mdi-arrow-top-right icon-item"></span>
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
                                                <span class="mdi mdi-arrow-top-right icon-item"></span>
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
                                                <span class="mdi mdi-arrow-bottom-left icon-item"></span>
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
                                                <span class="mdi mdi-arrow-top-right icon-item"></span>
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
                                            <input type="text" class="form-control todo-list-input w-75" placeholder="Search order" style="color:white;">
                                        </div>
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
                                                    <th> ORDER </th>
                                                    <th> TOTAL </th>
                                                    <th> CUSTOMERS </th>
                                                    <th> PAYMENT STATUS </th>
                                                    <th> STATUS </th>
                                                    <th> DATE </th>
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

                                                    <td> 02312 </td>
                                                    <td> $14,500 </td>
                                                    <td>
                                                        <span class="ps-2">Henry Klein</span>
                                                    </td>
                                                    <td>
                                                        <div class="badge badge-outline-success">Paid</div>
                                                    </td>
                                                    <td>
                                                        <div class="badge badge-outline-success">Delivered</div>
                                                    </td>
                                                    <td> 04 Dec 2019 </td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-check form-check-muted m-0">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" class="form-check-input">
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td> 02312 </td>
                                                    <td> $14,500 </td>
                                                    <td>
                                                        <span class="ps-2">Henry Klein</span>
                                                    </td>
                                                    <td>
                                                        <div class="badge badge-outline-warning">Pending</div>
                                                    </td>
                                                    <td>
                                                        <div class="badge badge-outline-info">Out of delivery</div>
                                                    </td>
                                                    <td> 04 Dec 2019 </td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-check form-check-muted m-0">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" class="form-check-input">
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td> 02312 </td>
                                                    <td> $14,500 </td>
                                                    <td>
                                                        <span class="ps-2">Henry Klein</span>
                                                    </td>
                                                    <td>
                                                        <div class="badge badge-outline-danger">Refuned</div>
                                                    </td>
                                                    <td>
                                                        <div class="badge badge-outline-warning">Dispatched</div>
                                                    </td>
                                                    <td> 04 Dec 2019 </td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-check form-check-muted m-0">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" class="form-check-input">
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td> 02312 </td>
                                                    <td> $14,500 </td>
                                                    <td>
                                                        <span class="ps-2">Henry Klein</span>
                                                    </td>
                                                    <td>
                                                        <div class="badge badge-outline-success">Paid</div>
                                                    </td>
                                                    <td>
                                                        <div class="badge badge-outline-secondary">New</div>
                                                    </td>
                                                    <td> 04 Dec 2019 </td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-check form-check-muted m-0">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" class="form-check-input">
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td> 02312 </td>
                                                    <td> $14,500 </td>
                                                    <td>
                                                        <span class="ps-2">Henry Klein</span>
                                                    </td>
                                                    <td>
                                                        <div class="badge badge-outline-success">Paid</div>
                                                    </td>
                                                    <td>
                                                        <div class="badge badge-outline-primary">Confirm</div>
                                                    </td>
                                                    <td> 04 Dec 2019 </td>
                                                </tr>
                                            </tbody>
                                        </table>
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
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../../template/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="../../template/assets/vendors/chart.js/Chart.min.js"></script>
    <script src="../../template/assets/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="../../template/assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="../../template/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="../../template/assets/vendors/owl-carousel-2/owl.carousel.min.css"></script>
    <script src="../../template/assets/js/jquery.cookie.js" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../../template/assets/js/off-canvas.js"></script>
    <script src="../../template/assets/js/hoverable-collapse.js"></script>
    <script src="../../template/assets/js/misc.js"></script>
    <script src="../../template/assets/js/settings.js"></script>
    <script src="../../template/assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="../../template/assets/js/dashboard.js"></script>
    <!-- End custom js for this page -->
</body>