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
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="../../assets/product.css">
    <link rel="stylesheet" href="../../../admin/template/assets/css/style.css">
    <link rel="stylesheet" href="../../../admin/template/assets/css/maps/style.css.map">

    <!-- End layout styles -->
    <link rel="shortcut icon" href="../../../admin/template/assets/images/favicon.png" />
    <!-- Sử dụng liên kết CDN mới nhất của Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .custom-select-box {
            width: 100%;
            padding: 8px 12px;
            background-color: #111;
            color: #fff;
            border: 1px solid #555;
            border-radius: 4px;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        .custom-select-box option {
            background-color: #111;
            color: #fff;
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
                <div class="col-md-8 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><strong>Orders #</strong></h4>
                            <h6 class="mb-0">Customer ID :</h6>
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
                                            <th> PRODUCTS </th>
                                            <th> COLOR </th>
                                            <th> SIZE </th>
                                            <th> PRICE </th>
                                            <th> QUANTITY </th>
                                            <th> TOTAL </th>
                                            <th> Payment Status </th>
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
                                                <img src="assets/images/faces/face1.jpg" alt="image" />
                                                <span class="ps-2">Henry Klein</span>
                                            </td>
                                            <td> 02312 </td>
                                            <td> $14,500 </td>
                                            <td> Dashboard </td>
                                            <td> Credit card </td>
                                            <td> 04 Dec 2019 </td>
                                            <td>
                                                <div class="badge badge-outline-success">Approved</div>
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
                                                <img src="assets/images/faces/face2.jpg" alt="image" />
                                                <span class="ps-2">Estella Bryan</span>
                                            </td>
                                            <td> 02312 </td>
                                            <td> $14,500 </td>
                                            <td> Website </td>
                                            <td> Cash on delivered </td>
                                            <td> 04 Dec 2019 </td>
                                            <td>
                                                <div class="badge badge-outline-warning">Pending</div>
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
                                                <img src="assets/images/faces/face5.jpg" alt="image" />
                                                <span class="ps-2">Lucy Abbott</span>
                                            </td>
                                            <td> 02312 </td>
                                            <td> $14,500 </td>
                                            <td> App design </td>
                                            <td> Credit card </td>
                                            <td> 04 Dec 2019 </td>
                                            <td>
                                                <div class="badge badge-outline-danger">Rejected</div>
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
                                                <img src="assets/images/faces/face3.jpg" alt="image" />
                                                <span class="ps-2">Peter Gill</span>
                                            </td>
                                            <td> 02312 </td>
                                            <td> $14,500 </td>
                                            <td> Development </td>
                                            <td> Online Payment </td>
                                            <td> 04 Dec 2019 </td>
                                            <td>
                                                <div class="badge badge-outline-success">Approved</div>
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
                                                <img src="assets/images/faces/face4.jpg" alt="image" />
                                                <span class="ps-2">Sallie Reyes</span>
                                            </td>
                                            <td> 02312 </td>
                                            <td> $14,500 </td>
                                            <td> Website </td>
                                            <td> Credit card </td>
                                            <td> 04 Dec 2019 </td>
                                            <td>
                                                <div class="badge badge-outline-success">Approved</div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card custom-summary-card" style="min-height: auto; height: auto;">
                        <div class="card-body">
                            <h4 class="card-title"><strong>Summary</strong></h4>

                            <div class="bg-gray-dark d-flex justify-content-between py-2 px-4 rounded mt-2">
                                <h6 class="mb-0">Item subtotal :</h6>
                                <h6 class="font-weight-bold mb-0">$236</h6>
                            </div>

                            <div class="bg-gray-dark d-flex justify-content-between py-2 px-4 rounded mt-2">
                                <h6 class="mb-0">Discount :</h6>
                                <h6 class="font-weight-bold mb-0 text-danger">-$59</h6>
                            </div>

                            <div class="bg-gray-dark d-flex justify-content-between py-2 px-4 rounded mt-2">
                                <h6 class="mb-0">Tax :</h6>
                                <h6 class="font-weight-bold mb-0">$126.20</h6>
                            </div>

                            <div class="bg-gray-dark d-flex justify-content-between py-2 px-4 rounded mt-2">
                                <h6 class="mb-0">Subtotal :</h6>
                                <h6 class="font-weight-bold mb-0">$665</h6>
                            </div>

                            <div class="bg-gray-dark d-flex justify-content-between py-2 px-4 rounded mt-2">
                                <h6 class="mb-0">Shipping Cost :</h6>
                                <h6 class="font-weight-bold mb-0">$30</h6>
                            </div>

                            <!-- Đường gạch ngang -->
                            <hr class="my-2" style="border-top: 1px solid #ccc;" />

                            <!-- TOTAL -->
                            <div class="bg-gray-dark d-flex justify-content-between py-2 px-4 rounded mt-2">
                                <h5 class="mb-0">Total :</h5>
                                <h5 class="font-weight-bold mb-0">$695.20</h5>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-8 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row text-white">
                                <!-- Billing details -->
                                <div class="col-md-6">
                                    <h5 class="font-weight-bold mb-3">Billing details</h5>

                                    <div class="mb-2 d-flex align-items-start">
                                        <i class="mdi mdi-account-outline mr-2"></i>
                                        <div>
                                            <small class="font-weight-bold">Customer</small><br />
                                            <a href="#" class="text-blue-700">Shatinon Mekalan</a>
                                        </div>
                                    </div>

                                    <div class="mb-2 d-flex align-items-start">
                                        <i class="mdi mdi-email-outline mr-2"></i>
                                        <div>
                                            <small class="font-weight-bold">Email</small><br />
                                            <span class="text-blue-700">shatinon@jeemail.com</span>
                                        </div>
                                    </div>

                                    <div class="mb-2 d-flex align-items-start">
                                        <i class="mdi mdi-phone-outline mr-2"></i>
                                        <div>
                                            <small class="font-weight-bold">Phone</small><br />
                                            <span class="text-blue-700">+1234567890</span>
                                        </div>
                                    </div>

                                    <div class="mb-2 d-flex align-items-start">
                                        <i class="mdi mdi-home-outline mr-2"></i>
                                        <div>
                                            <small class="font-weight-bold">Address</small><br />
                                            <span class="text-white">Shatinon Mekalan<br />Vancouver, British
                                                Columbia,<br />Canada</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Shipping details -->
                                <div class="col-md-6">
                                    <h5 class="font-weight-bold mb-3">Shipping details</h5>

                                    <div class="mb-2 d-flex align-items-start">
                                        <i class="mdi mdi-email-outline mr-2"></i>
                                        <div>
                                            <small class="font-weight-bold">Email</small><br />
                                            <span class="text-blue-700">shatinon@jeemail.com</span>
                                        </div>
                                    </div>

                                    <div class="mb-2 d-flex align-items-start">
                                        <i class="mdi mdi-phone-outline mr-2"></i>
                                        <div>
                                            <small class="font-weight-bold">Phone</small><br />
                                            <span class="text-blue-700">+1234567890</span>
                                        </div>
                                    </div>

                                    <div class="mb-2 d-flex align-items-start">
                                        <i class="mdi mdi-calendar-blank-outline mr-2"></i>
                                        <div>
                                            <small class="font-weight-bold">Shipping Date</small><br />
                                            <span class="text-white">12 Nov, 2021</span>
                                        </div>
                                    </div>

                                    <div class="mb-2 d-flex align-items-start">
                                        <i class="mdi mdi-home-outline mr-2"></i>
                                        <div>
                                            <small class="font-weight-bold">Address</small><br />
                                            <span class="text-white">Shatinon Mekalan<br />Vancouver, British
                                                Columbia<br />Canada</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Other details -->
                            <div class="row mt-4 text-white">
                                <div class="col-12">
                                    <h5 class="font-weight-bold mb-3">Other details</h5>

                                    <div class="mb-2 d-flex align-items-start">
                                        <i class="mdi mdi-gift-outline mr-2"></i>
                                        <div>
                                            <small class="font-weight-bold">Gift order</small><br />
                                            <span class="text-white">Yes</span>
                                        </div>
                                    </div>

                                    <div class="mb-2 d-flex align-items-start">
                                        <i class="mdi mdi-package-variant-closed mr-2"></i>
                                        <div>
                                            <small class="font-weight-bold">Wrapping</small><br />
                                            <span class="text-white">Magic wrapper</span>
                                        </div>
                                    </div>

                                    <div class="mb-2 d-flex align-items-start">
                                        <i class="mdi mdi-account-box-outline mr-2"></i>
                                        <div>
                                            <small class="font-weight-bold">Recipient</small><br />
                                            <span class="text-white">Monjito Shiniga</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card custom-summary-card" style="min-height: auto; height: auto;">
                        <div class="card-body">
                            <h4 class="font-weight-bold card-title">Order status</h4>
                            <div class="form-group">
                                <label class="font-weight-bold">Payment status</label>
                                <select id="destatus" class="custom-select-box">
                                    <option value="processing">Processing</option>
                                    <option value="cancel">Cancel</option>
                                    <option value="completed">Completed</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Fulfillment status</label>
                                <select id="paystatus" class="custom-select-box">
                                    <option value="unfulfilled">Unfulfilled</option>
                                    <option value="fulfilled">Fulfilled</option>
                                    <option value="pending">Pending</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- content-wrapper ends -->
            <!-- partial:partials/_footer.html -->
            <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright
                        ©
                        bootstrapdash.com 2021</span>
                    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a
                            href="https://www.bootstrapdash.com/bootstrap-admin-template/"
                            target="_blank">Bootstrap
                            admin template</a> from Bootstrapdash.com</span>
                </div>
            </footer>
            <!-- partial -->

        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<script src="../../template/assets/vendors/js/vendor.bundle.base.js"></script>
<script src="../../template/assets/vendors/chart.js/Chart.min.js"></script>
<script src="../../template/assets/js/jquery.cookie.js" type="text/javascript"></script>
<script src="../../template/assets/js/misc.js"></script>

</body>
</html>