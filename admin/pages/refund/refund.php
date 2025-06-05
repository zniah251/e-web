<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Refund Management</title>
    <link rel="stylesheet" href="../../../admin/template/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../../admin/template/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="../../template/assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="../../template/assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../../template/assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="../../template/assets/vendors/owl-carousel-2/owl.theme.default.min.css">
    <link rel="stylesheet" href="/e-web/admin/template/assets/css/style.css">
    <link rel="shortcut icon" href="../../../admin/template/assets/images/favicon.png" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.7.0/jspdf.plugin.autotable.min.js"></script>
    <style>body { font-family: 'Times New Roman', serif; }</style>
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
                                            <h3 class="mb-0">8</h3>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="icon icon-box-warning">
                                            <span class="mdi mdi-timer-sand icon-item"></span>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="text-muted font-weight-normal">Processing</h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-9">
                                        <div class="d-flex align-items-center align-self-start">
                                            <h3 class="mb-0">5</h3>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="icon icon-box-info">
                                            <span class="mdi mdi-cash-refund icon-item"></span>
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
                                            <h3 class="mb-0">4</h3>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="icon icon-box-danger">
                                            <span class="mdi mdi-block-helper icon-item"></span>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="text-muted font-weight-normal">Refund Rejected</h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-9">
                                        <div class="d-flex align-items-center align-self-start">
                                            <h3 class="mb-0">10</h3>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="icon icon-box-primary">
                                            <span class="mdi mdi-format-list-bulleted icon-item"></span>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="text-muted font-weight-normal">All Orders</h6>
                            </div>
                        </div>
                    </div>
                </div>
                        <div class="col-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="add-items">
                                            <input type="text" id="searchOrder" class="form-control todo-list-input w-75" placeholder="Search refund" style="color:white;">
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="mdi mdi-logout"></i> Export
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                                <a class="dropdown-item" href="#"><span class="mdi mdi-printer"></span> Print</a>
                                                <a class="dropdown-item" href="#" onclick="exportTableToExcel('refunds.xls')">
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
                                                    <th>ORDER</th>
                                                    <th>AMOUNT</th>
                                                    <th>CUSTOMER</th>
                                                    <th>REASON</th>
                                                    <th>STATUS</th>
                                                    <th>DATE</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr><td>#10001</td><td>$89.99</td><td>John Smith</td><td>Damaged item</td><td><span class="badge badge-outline-danger">Pending</span></td><td>2024-06-01</td></tr>
                                                <tr><td>#10002</td><td>$45.50</td><td>Emily Davis</td><td>Wrong item</td><td><span class="badge badge-outline-success">Refunded</span></td><td>2024-06-02</td></tr>
                                                <tr><td>#10003</td><td>$112.00</td><td>Michael Johnson</td><td>Changed mind</td><td><span class="badge badge-outline-warning">In review</span></td><td>2024-06-03</td></tr>
                                                <tr><td>#10004</td><td>$15.75</td><td>Sarah Lee</td><td>Late delivery</td><td><span class="badge badge-outline-success">Refunded</span></td><td>2024-06-04</td></tr>
                                                <tr><td>#10005</td><td>$79.00</td><td>David Martínez</td><td>Item not as described</td><td><span class="badge badge-outline-danger">Pending</span></td><td>2024-06-05</td></tr>
                                                <tr><td>#10006</td><td>$59.95</td><td>Maria Schneider</td><td>Duplicate order</td><td><span class="badge badge-outline-success">Refunded</span></td><td>2024-06-06</td></tr>
                                                <tr><td>#10007</td><td>$22.10</td><td>Jean Dupont</td><td>Technical issue</td><td><span class="badge badge-outline-warning">In review</span></td><td>2024-06-06</td></tr>
                                                <tr><td>#10008</td><td>$105.40</td><td>Sofia Rossi</td><td>Unauthorized purchase</td><td><span class="badge badge-outline-danger">Pending</span></td><td>2024-06-07</td></tr>
                                                <tr><td>#10009</td><td>$37.00</td><td>Liam O'Connor</td><td>Product defective</td><td><span class="badge badge-outline-success">Refunded</span></td><td>2024-06-08</td></tr>
                                                <tr><td>#10010</td><td>$60.00</td><td>Chen Wei</td><td>Incorrect size</td><td><span class="badge badge-outline-warning">In review</span></td><td>2024-06-09</td></tr>
                                            </tbody>
                                        </table>
                                        <script>
                                            document.getElementById('searchOrder').addEventListener('input', function() {
                                                var filter = this.value.trim().toUpperCase();
                                                var table = document.querySelector('.table');
                                                var trs = table.getElementsByTagName('tr');
                                                for (var i = 1; i < trs.length; i++) {
                                                    var td = trs[i].getElementsByTagName('td')[0];
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
        function exportTableToPDF() {
            var { jsPDF } = window.jspdf;
            var doc = new jsPDF();
            doc.autoTable({ html: '.table' });
            doc.save('refunds.pdf');
        }
    </script>
    <script src="../../template/assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="../../template/assets/vendors/chart.js/Chart.min.js"></script>
    <script src="../../template/assets/js/jquery.cookie.js" type="text/javascript"></script>
    <script src="../../template/assets/js/misc.js"></script>
</body>

</html>
