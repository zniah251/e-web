<!DOCTYPE html>
<html lang="en">
<?php

session_start();

$_SESSION['admin_logged_in'] = true;
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: /../admin/template/pages/samples/login.php");
    exit();
}

include "/e-web/connect.php";
// Biến stock mặc định
$stock = 0;

// --- BƯỚC 1: Nếu nhấn "Confirm"
if (isset($_POST['confirm_stock'])) {
    $stock_input = isset($_POST['stock_input']) ? intval($_POST['stock_input']) : 0;
    $stock = $stock_input;
}

if (isset($_POST['public_product'])) {
    $thumbnail = '';
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === 0) {
        $uploadDir = '../add-products/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        // Đường dẫn đầy đủ đến file upload
        $fileName = basename($_FILES['thumbnail']['name']);
        $thumbnail = $uploadDir . $fileName;

        // Di chuyển file từ thư mục tạm vào thư mục upload
        if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $thumbnail)) {
            // Thành công → $thumbnail đã chứa đường dẫn hình ảnh
            // Ví dụ: uploads/hinh.jpg
        } else {
            echo "Upload ảnh thất bại.";
            $thumbnail = ''; // Xoá đường dẫn nếu upload thất bại
        }
    }


    $title = isset($_POST['title']) ? $_POST['title'] : '';

    $price = isset($_POST['price']) ? $_POST['price'] : '';
    $discount = isset($_POST['discount']) ? $_POST['discount'] : '';

    $description = isset($_POST['description']) ? $_POST['description'] : '';


    //$stock = isset($_POST['stock']) ? $_POST['stock'] : '';
    $stock = isset($_SESSION['stock']) ? $_SESSION['stock'] : 0;

    echo "<script>
        alert('Username: $stock');
      </script>";
    $size = isset($_POST['size']) ? $_POST['size'] : '';
    $rating = isset($_POST['rating']) ? $_POST['rating'] : '1';
    $sold = isset($_POST['sold']) ? $_POST['sold'] : '';
    $color = isset($_POST['color']) ? $_POST['color'] : '';
    $cid = isset($_POST['cid']) ? $_POST['cid'] : '';

    // Chèn dữ liệu
    $sql = "INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt = $conn->prepare($sql)) {
        die("❌ Prepare failed: " . $conn->error);
    }


    $stmt->bind_param("isddssisdis", $cid, $title, $price, $discount, $thumbnail, $description, $stock, $size, $rating, $sold, $color);

    if (!$stmt->execute()) {
        echo "❌ Lỗi: " . $stmt->error;
    }
    // else {
    //     echo "✅ Thêm sản phẩm thành công!";
    // }

    $stmt->close();
}
$conn->close();
?>

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
    <link rel="stylesheet" href="../../../admin/template/assets/vendors/select2/select2.min.css">
    <link rel="stylesheet"
        href="../../../admin/template/assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">

    <link rel="stylesheet" href="../../template/assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../../template/assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="../../template/assets/vendors/owl-carousel-2/owl.theme.default.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="../../assets/product.css">

    <link rel="stylesheet" href="../../../admin/template/assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="../../../admin/template/assets/images/favicon.png" />
    <!-- Sử dụng liên kết CDN mới nhất của Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar p-0 fixed-top d-flex flex-row">
        <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
            <a class="navbar-brand brand-logo-mini" href="index.html"><img src="assets/images/logo-mini.svg"
                    alt="logo" /></a>
        </div>
        <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
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
                                <img src="../../../assets/images/faces/face15.jpg" alt="image"
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
                                <img src="assets/images/faces/face2.jpg" alt="image" class="rounded-circle profile-pic">
                            </div>
                            <div class="preview-item-content">
                                <p class="preview-subject ellipsis mb-1">Cregh send you a message</p>
                                <p class="text-muted mb-0"> 15 Minutes ago </p>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <img src="../../../assets/images/faces/face15.jpg" alt="image"
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
                                <p class="text-muted ellipsis mb-0"> Just a reminder that you have an event today </p>
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
                            <img class="img-xs rounded-circle"
                                src="../../../admin/template/assets/images/faces/face15.jpg" alt="">
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
    <div class="container-scroller" style="padding-top: 0;">
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
                <a class="sidebar-brand brand-logo" href="../../index.html"><img
                        src="../../template/assets/images/logo.svg" alt="logo" /></a>
                <a class="sidebar-brand brand-logo-mini" href="../../index.html"><img
                        src="../../template/assets/images/logo-mini.svg" alt="logo" /></a>
            </div>

            <ul class="nav">
                <li class="nav-item profile">
                    <div class="profile-desc">
                        <div class="profile-pic">
                            <div class="count-indicator">
                                <img class="img-xs rounded-circle "
                                    src="../../../admin/template/assets/images/faces/face15.jpg""
                                    alt="">
                                <span class=" count bg-success"></span>
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
                                    <div class="preview-icon bg-light rounded-circle">
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
                                    <div class="preview-icon bg-light rounded-circle">
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
                                    <div class="preview-icon bg-light rounded-circle">
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
                    <a class="nav-link" href="../../index.html">
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
                            <li class="nav-item"> <a class="nav-link"
                                    href="../../pages/ui-features/buttons.html">Buttons</a></li>
                            <li class="nav-item"> <a class="nav-link"
                                    href="../../pages/ui-features/dropdowns.html">Dropdowns</a></li>
                            <li class="nav-item"> <a class="nav-link"
                                    href="../../pages/ui-features/typography.html">Typography</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="../../pages/forms/basic_elements.html">
                        <span class="menu-icon">
                            <i class="mdi mdi-playlist-play"></i>
                        </span>
                        <span class="menu-title">Form Elements</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="../../pages/tables/basic-table.html">
                        <span class="menu-icon">
                            <i class="mdi mdi-table-large"></i>
                        </span>
                        <span class="menu-title">Tables</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="../../pages/charts/chartjs.html">
                        <span class="menu-icon">
                            <i class="mdi mdi-chart-bar"></i>
                        </span>
                        <span class="menu-title">Charts</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="../../pages/icons/mdi.html">
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
                            <li class="nav-item"> <a class="nav-link" href="../../pages/samples/blank-page.html"> Blank
                                    Page </a></li>
                            <li class="nav-item"> <a class="nav-link" href="../../pages/samples/error-404.html"> 404
                                </a></li>
                            <li class="nav-item"> <a class="nav-link" href="../../pages/samples/error-500.html"> 500
                                </a></li>
                            <li class="nav-item"> <a class="nav-link" href="../../pages/samples/login.html"> Login </a>
                            </li>
                            <li class="nav-item"> <a class="nav-link" href="../../pages/samples/register.html"> Register
                                </a></li>
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
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Add a product</h4>
                            <p class="card-description"> Orders placed across your store </p>
                            <form action="product.php" method="POST" enctype="multipart/form-data">

                                <div class="action-buttons">
                                    <button type="submit" name="discard" class="discard-btn" style="color: #ffffff;">Discard</button>
                                    <button type="submit" name="save_draft" class="save-draft-btn" style="color: #ffffff;">Save draft</button>
                                    <button type="submit" name="public_product" class="publish-btn" style="color: #ffffff;">Publish product</button>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <form class="forms-sample">
                                            <div class="form-group">
                                                <label for="exampleInputName1">Product Title</label>
                                                <input type="text" class="form-control" id="exampleInputName1" name="title"
                                                    placeholder="Write title here...">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputName1">Product Description</label>
                                                <div class="toolbar">
                                                    <button title="Undo"><i class="fa-solid fa-rotate-left"></i></button>
                                                    <button title="Redo"><i class="fa-solid fa-rotate-right"></i></button>
                                                    <button title="Bold"><i class="fa-solid fa-bold"></i></button>
                                                    <button title="Italic"><i class="fa-solid fa-italic"></i></button>
                                                    <button title="Underline"><i class="fa-solid fa-underline"></i></button>
                                                    <button title="Strikethrough"><i
                                                            class="fa-solid fa-strikethrough"></i></button>
                                                    <button title="Align Left"><i
                                                            class="fa-solid fa-align-left"></i></button>
                                                    <button title="Align Center"><i
                                                            class="fa-solid fa-align-center"></i></button>
                                                    <button title="Align Right"><i
                                                            class="fa-solid fa-align-right"></i></button>
                                                    <button title="Justify"><i
                                                            class="fa-solid fa-align-justify"></i></button>
                                                    <button title="Link"><i class="fa-solid fa-link"></i></button>
                                                </div>
                                                <textarea class="form-control" id="exampleTextarea1" rows="4" name="description"></textarea>
                                            </div>

                                            <form method="post" enctype="multipart/form-data">
                                                <div class="form-group">
                                                    <label>File upload</label>
                                                    <input type="file" name="thumbnail" class="file-upload-default">
                                                    <div class="input-group col-xs-12">
                                                        <input type="text" class="form-control file-upload-info"
                                                            name="thumbnail" placeholder="Upload Image">
                                                        <span class="input-group-append">
                                                            <button class="file-upload-browse btn btn-primary"
                                                                type="button">Upload</button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </form>

                                            <div class="form-group">
                                                <label for="exampleInputPassword4">Inventory</label>
                                            </div>
                                            <div class="container mt-4">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="list-group" id="list-tab" role="tablist">
                                                            <a class="list-group-item list-group-item-action active"
                                                                id="list-pricing-list" data-bs-toggle="list"
                                                                href="#list-pricing" role="tab"
                                                                style="background-color: #191c24; color: #ffffff; border-color: grey;">Pricing</a>
                                                            <a class="list-group-item list-group-item-action"
                                                                id="list-restock-list" data-bs-toggle="list"
                                                                href="#list-restock" role="tab"
                                                                style="background-color: #191c24; color: #ffffff; border-color: grey;">Restock</a>
                                                            <a class="list-group-item list-group-item-action"
                                                                id="list-shipping-list" data-bs-toggle="list"
                                                                href="#list-shipping" role="tab"
                                                                style="background-color: #191c24; color: #ffffff; border-color: grey;">Shipping</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="tab-content" id="nav-tabContent"
                                                            style="background-color: #191c24; border-top: 1px;">
                                                            <div class="tab-pane fade show active" id="list-pricing"
                                                                role="tabpanel" style="background-color: #191c24;">
                                                                <label>Regular price: <input type="number"
                                                                        class="form-control" name="price"></label>
                                                                <label>Sale price: <input type="number"
                                                                        class="form-control" name="discount"></label>
                                                            </div>
                                                            <div class="tab-pane fade" id="list-restock" role="tabpanel">

                                                                <form method="POST" action="">
                                                                    <label>Quantity:
                                                                        <input type="number" class="form-control" name="stock_input">
                                                                        <button type="submit" name="confirm_stock" class="btn btn-primary mt-2">Confirm</button>
                                                                    </label>
                                                                </form>
                                                                <p>Product in stock now: <?php echo $stock; ?></p>


                                                            </div>

                                                            <div class="tab-pane fade" id="list-shipping" role="tabpanel">
                                                                <label class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="shipping"> Fulfilled by Seller
                                                                </label>
                                                                <label class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="shipping" checked> Fulfilled by Phoenix
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                    <div class="col-sm-4" style="padding: 20px;">
                                        <div>
                                            <h3>Organize</h3>
                                            <div class="organize-section">
                                                <label for="category" style="color: #ffffff;">Category <a href="#"
                                                        class="add-new">Add new
                                                        category</a></label>
                                                <select id="category" name="category">
                                                    <option value="mens-clothing">Men's Clothing</option>
                                                    <option value="womens-clothing">Women's Clothing</option>
                                                    <option value="accessories">Accessories</option>
                                                </select>
                                            </div>
                                            <div class="organize-section">
                                                <label for="vendor" style="color: #ffffff;">Vendor <a href="#"
                                                        class="add-new">Add new
                                                        vendor</a></label>
                                                <select id="vendor" name="vendor">
                                                    <option value="mens-clothing">Men's Clothing</option>
                                                    <option value="vendor2">Vendor 2</option>
                                                    <option value="vendor3">Vendor 3</option>
                                                </select>
                                            </div>
                                            <div class="organize-section">
                                                <label for="collection" style="color: #ffffff;">Collection</label>
                                                <select id="collection" name="collection">
                                                    <option value="" disabled selected>Select a collection</option>
                                                    <option value="collection1">Collection 1</option>
                                                    <option value="collection2">Collection 2</option>
                                                </select>
                                            </div>
                                            <div class="organize-section">
                                                <label for="tags" style="color: #ffffff;">Tags <a href="#"
                                                        class="view-all">View
                                                        all tags</a></label>
                                                <select id="tags" name="tags">
                                                    <option value="mens-clothing">Men's Clothing</option>
                                                    <option value="tag2">Tag 2</option>
                                                    <option value="tag3">Tag 3</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div>
                                            <h3><strong>Variants</strong></h3>
                                            <div id="variant-container">
                                                <div class="variant-group">
                                                    <label>Options <a href="#" class="remove-option"
                                                            onclick="removeOption(this)">Remove</a></label>
                                                    <select class="form-select">
                                                        <option value="size">Size</option>
                                                        <option value="color">Color</option>
                                                        <option value="weight">Weight</option>
                                                    </select>
                                                    <textarea placeholder="Enter values..."
                                                        style="width: 100%; padding: 10px; color: black;"></textarea>
                                                </div>
                                            </div>

                                            <button type="button" onclick="addOption()" style="margin-top: 10px;"
                                                class="btn btn-primary">
                                                + Add another option
                                            </button>

                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright ©
                            bootstrapdash.com 2021</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a
                                href="https://www.bootstrapdash.com/bootstrap-admin-template/" target="_blank">Bootstrap
                                admin template</a> from Bootstrapdash.com</span>
                    </div>
                </footer>

                <!-- partial -->

            </div>
        </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../../template/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="../../template/assets/vendors/chart.js/Chart.min.js"></script>
    <script src="../../template/assets/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="../../template/assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="../../template/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="../../template/assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
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
    <script src="../../template/assets/js/file-upload.js"></script>
    <script src="../../template/assets/js/typeahead.js"></script>
    <script src="../../template/assets/js/select2.js"></script>
    <!-- End custom js for this page -->
    <script>
        function addOption() {
            const container = document.getElementById('variant-container');

            const group = document.createElement('div');
            group.className = 'variant-group';
            group.innerHTML = `
            <label>Options <a href="#" class="remove-option" onclick="removeOption(this)">Remove</a></label>
            <select class="form-select">
              <option value="size">Size</option>
              <option value="color">Color</option>
              <option value="weight">Weight</option>
            </select>
            <textarea placeholder="Enter values..." style="width: 100%; padding: 10px; color: black;"></textarea>
          `;

            container.appendChild(group);
        }

        function removeOption(link) {
            const group = link.closest('.variant-group');
            group.remove();
        }
    </script>
    <script>
        function execCommand(command, value = null) {
            document.execCommand(command, false, value);
        }

        document.querySelectorAll('.toolbar button').forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault(); // Ngăn form submit nếu có
                const command = button.getAttribute('title').toLowerCase();

                switch (command) {
                    case 'undo':
                    case 'redo':
                    case 'bold':
                    case 'italic':
                    case 'underline':
                    case 'strikethrough':
                        execCommand(command);
                        break;
                    case 'align left':
                        execCommand('justifyLeft');
                        break;
                    case 'align center':
                        execCommand('justifyCenter');
                        break;
                    case 'align right':
                        execCommand('justifyRight');
                        break;
                    case 'justify':
                        execCommand('justifyFull');
                        break;
                    case 'link':
                        const url = prompt('Enter the URL:');
                        if (url) {
                            execCommand('createLink', url);
                        }
                        break;
                }
            });
        });
    </script>


</body>

</html>