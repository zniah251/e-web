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
        <div class="row p-0 m-0 proBanner" id="proBanner">
            <div class="col-md-12 p-0 m-0">
            </div>
        </div>
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
                <a class="sidebar-brand brand-logo" href="index.html"><img src="../../template/assets/images/logo.svg"
                        alt="logo" /></a>
                <a class="sidebar-brand brand-logo-mini" href="index.html"><img
                        src="../../template/assets/images/logo-mini.svg" alt="logo" /></a>
            </div>
            <ul class="nav">
                <li class="nav-item profile">
                    <div class="profile-desc">
                        <div class="profile-pic">
                            <div class="count-indicator">
                                <img class="img-xs rounded-circle " src="../../template/assets/images/faces/face15.jpg"
                                    alt="">
                                <span class="count bg-success"></span>
                            </div>
                            <div class="profile-name">
                                <h5 class="mb-0 font-weight-normal">Henry Klein</h5>
                                <span>Gold Member</span>
                            </div>
                        </div>
                        <a href="#" id="profile-dropdown" data-bs-toggle="dropdown"><i
                                class="mdi mdi-dots-vertical"></i></a>
                        <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list"
                            aria-labelledby="profile-dropdown">
                            <a href="#" class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-dark rounded-circle">
                                        <i class="mdi mdi-settings text-primary"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <p class="preview-subject ellipsis mb-1 text-small">Account settings</p>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-dark rounded-circle">
                                        <i class="mdi mdi-onepassword  text-info"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <p class="preview-subject ellipsis mb-1 text-small">Change Password</p>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-dark rounded-circle">
                                        <i class="mdi mdi-calendar-today text-success"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <p class="preview-subject ellipsis mb-1 text-small">To-do list</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </li>
                <li class="nav-item nav-category">
                    <span class="nav-link">Navigation</span>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="index.html">
                        <span class="menu-icon">
                            <i class="mdi mdi-speedometer"></i>
                        </span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false"
                        aria-controls="ui-basic">
                        <span class="menu-icon">
                            <i class="mdi mdi-laptop"></i>
                        </span>
                        <span class="menu-title">Basic UI Elements</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="ui-basic">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Buttons</a>
                            </li>
                            <li class="nav-item"> <a class="nav-link"
                                    href="pages/ui-features/dropdowns.html">Dropdowns</a></li>
                            <li class="nav-item"> <a class="nav-link"
                                    href="pages/ui-features/typography.html">Typography</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="pages/forms/basic_elements.html">
                        <span class="menu-icon">
                            <i class="mdi mdi-playlist-play"></i>
                        </span>
                        <span class="menu-title">Form Elements</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="pages/tables/basic-table.html">
                        <span class="menu-icon">
                            <i class="mdi mdi-table-large"></i>
                        </span>
                        <span class="menu-title">Tables</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="pages/charts/chartjs.html">
                        <span class="menu-icon">
                            <i class="mdi mdi-chart-bar"></i>
                        </span>
                        <span class="menu-title">Charts</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="pages/icons/mdi.html">
                        <span class="menu-icon">
                            <i class="mdi mdi-contacts"></i>
                        </span>
                        <span class="menu-title">Icons</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false"
                        aria-controls="auth">
                        <span class="menu-icon">
                            <i class="mdi mdi-security"></i>
                        </span>
                        <span class="menu-title">User Pages</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="auth">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="pages/samples/blank-page.html"> Blank Page
                                </a></li>
                            <li class="nav-item"> <a class="nav-link" href="pages/samples/error-404.html"> 404 </a></li>
                            <li class="nav-item"> <a class="nav-link" href="pages/samples/error-500.html"> 500 </a></li>
                            <li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> Login </a></li>
                            <li class="nav-item"> <a class="nav-link" href="pages/samples/register.html"> Register </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link"
                        href="http://www.bootstrapdash.com/demo/corona-free/jquery/documentation/documentation.html">
                        <span class="menu-icon">
                            <i class="mdi mdi-file-document-box"></i>
                        </span>
                        <span class="menu-title">Documentation</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_navbar.html -->
            <nav class="navbar p-0 fixed-top d-flex flex-row">
                <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
                    <a class="navbar-brand brand-logo-mini" href="index.html"><img src="assets/images/logo-mini.svg"
                            alt="logo" /></a>
                </div>
                <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button"
                        data-toggle="minimize">
                        <span class="mdi mdi-menu"></span>
                    </button>
                    <ul class="navbar-nav w-100">
                        <li class="nav-item w-100">
                            <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search">
                                <input type="text" class="form-control" placeholder="Search products">
                            </form>
                        </li>
                    </ul>
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item dropdown d-none d-lg-block">
                            <a class="nav-link btn btn-success create-new-button" id="createbuttonDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false" href="#">+ Create New Project</a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                                aria-labelledby="createbuttonDropdown">
                                <h6 class="p-3 mb-0">Projects</h6>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle">
                                            <i class="mdi mdi-file-outline text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject ellipsis mb-1">Software Development</p>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle">
                                            <i class="mdi mdi-web text-info"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject ellipsis mb-1">UI Development</p>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle">
                                            <i class="mdi mdi-layers text-danger"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject ellipsis mb-1">Software Testing</p>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <p class="p-3 mb-0 text-center">See all projects</p>
                            </div>
                        </li>
                        <li class="nav-item nav-settings d-none d-lg-block">
                            <a class="nav-link" href="#">
                                <i class="mdi mdi-view-grid"></i>
                            </a>
                        </li>
                        <li class="nav-item dropdown border-left">
                            <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-email"></i>
                                <span class="count bg-success"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                                aria-labelledby="messageDropdown">
                                <h6 class="p-3 mb-0">Messages</h6>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <img src="assets/images/faces/face4.jpg" alt="image"
                                            class="rounded-circle profile-pic">
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject ellipsis mb-1">Mark send you a message</p>
                                        <p class="text-muted mb-0"> 1 Minutes ago </p>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <img src="assets/images/faces/face2.jpg" alt="image"
                                            class="rounded-circle profile-pic">
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject ellipsis mb-1">Cregh send you a message</p>
                                        <p class="text-muted mb-0"> 15 Minutes ago </p>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <img src="assets/images/faces/face3.jpg" alt="image"
                                            class="rounded-circle profile-pic">
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject ellipsis mb-1">Profile picture updated</p>
                                        <p class="text-muted mb-0"> 18 Minutes ago </p>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <p class="p-3 mb-0 text-center">4 new messages</p>
                            </div>
                        </li>
                        <li class="nav-item dropdown border-left">
                            <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#"
                                data-bs-toggle="dropdown">
                                <i class="mdi mdi-bell"></i>
                                <span class="count bg-danger"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                                aria-labelledby="notificationDropdown">
                                <h6 class="p-3 mb-0">Notifications</h6>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle">
                                            <i class="mdi mdi-calendar text-success"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">Event today</p>
                                        <p class="text-muted ellipsis mb-0"> Just a reminder that you have an event
                                            today </p>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle">
                                            <i class="mdi mdi-settings text-danger"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">Settings</p>
                                        <p class="text-muted ellipsis mb-0"> Update dashboard </p>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle">
                                            <i class="mdi mdi-link-variant text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">Launch Admin</p>
                                        <p class="text-muted ellipsis mb-0"> New admin wow! </p>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <p class="p-3 mb-0 text-center">See all notifications</p>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" id="profileDropdown" href="#" data-bs-toggle="dropdown">
                                <div class="navbar-profile">
                                    <img class="img-xs rounded-circle" src="assets/images/faces/face15.jpg" alt="">
                                    <p class="mb-0 d-none d-sm-block navbar-profile-name">Henry Klein</p>
                                    <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                                aria-labelledby="profileDropdown">
                                <h6 class="p-3 mb-0">Profile</h6>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle">
                                            <i class="mdi mdi-settings text-success"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">Settings</p>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle">
                                            <i class="mdi mdi-logout text-danger"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">Log out</p>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <p class="p-3 mb-0 text-center">Advanced settings</p>
                            </div>
                        </li>
                    </ul>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                        data-toggle="offcanvas">
                        <span class="mdi mdi-format-line-spacing"></span>
                    </button>
                </div>
            </nav>
            <!-- partial -->

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

</html>