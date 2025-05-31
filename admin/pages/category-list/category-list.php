<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Product List</title>

    <!-- Plugins CSS from Corona Admin Template -->
    <link rel="stylesheet" href="../../../admin/template/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../../admin/template/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="../../template/assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="../../template/assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../../template/assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="../../template/assets/vendors/owl-carousel-2/owl.theme.default.min.css">
    
    <!-- Layout styles from Corona Admin Template -->
    <link rel="stylesheet" href="../../assets/product.css"> <!-- Kept as per Corona template -->
    <link rel="stylesheet" href="../../../admin/template/assets/css/style.css">
    <!-- <link rel="stylesheet" href="../../../admin/template/assets/css/maps/style.css.map"> -->

    <!-- Favicon from Corona Admin Template -->
    <link rel="shortcut icon" href="../../../admin/template/assets/images/favicon.png" />
    
    <!-- DataTables CSS (specific to Product List) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css ">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css ">

    <!-- Font Awesome (latest CDN, specific to Product List) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Tailwind CSS (Kept as per your Corona template, may cause conflicts if not intended) -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Custom Styles (Overrides for dark theme and specific elements for Product List) -->
    <style>
        /* General body and card styles for dark theme - MATCHING CORONA ADMIN */
        body {
            background-color: #191c24 !important; /* Changed to match Corona Admin primary background */
            color: #e0e0e0 !important;
            font-family: Arial, sans-serif;
        }
        .card {
            background-color: #191c24 !important; /* Changed to match Corona Admin primary background for cards */
            border: none;
            border-radius: 8px;
            color: #fff !important;
        }
        .card-title, .card-description {
            color: #fff !important;
        }
        .footer {
            background-color: #191c24 !important; /* Matches Corona Admin footer */
            color: #adb5bd;
        }
        .navbar {
            background-color: #191c24 !important;
        }
        .sidebar {
            background: #191c24 !important;
        }
        .nav-link, .menu-title, .menu-icon i {
            color: #e0e0e0 !important;
        }
        .nav-item.active > .nav-link {
            color: #fff !important;
            background-color: #23243a !important;
        }
        .nav-item.active .menu-icon i {
            color: #fff !important;
        }
        .nav-link:hover, .nav-link:hover .menu-icon i, .nav-link:hover .menu-title {
            color: #fff !important;
            background-color: #23243a !important;
        }
        /* Form controls specific to search input and select for page length */
        .form-control {
            background-color: #2A2F3D !important; /* Specific dark, purplish-gray from new image */
            color: #fff !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important; /* Lighter, more subtle border */
            border-radius: 4px; /* Ensure rounded corners */
            height: 38px; /* Standard Bootstrap height */
            padding: 6px 12px; /* Adjust padding for better look */
        }
        .form-control::placeholder {
            color: #adb5bd !important;
        }
        
        /* Specific style for the select element for page length (matching the white '10' in image) */
        #customLength {
            background-color: #fff !important;
            color: #333 !important; /* Dark text for light background */
            border: 1px solid #ccc !important;
            border-radius: 4px !important;
            padding-right: 25px !important; /* Ensure space for the dropdown arrow */
        }
        /* Ensure dropdown arrow is visible and styled for #customLength */
        #customLength::-ms-expand { /* For IE 11 */
            display: none;
        }
        #customLength {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url('data:image/svg+xml;charset=UTF-8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>');
            background-repeat: no-repeat;
            background-position: right 0.5rem center;
            background-size: 1em;
        }


        /* Table specific styles for Product List - KEPT ORIGINAL COLORS */
        .table,
        .table-responsive,
        #productTable {
            background-color: #191c24 !important; /* Changed to match Corona Admin primary background */
        }
        .table th,
        .table td {
            background-color: #191c24 !important; /* Changed to match Corona Admin primary background */
            border-color: transparent !important;
            color: #e0e0e0 !important;
            vertical-align: middle !important;
        }
        .table thead th {
            background-color: #2d3748 !important; /* Original dark header color */
            color: #fff !important;
            border-bottom: 2px solid #495057;
        }

        /* Badge styles for Product List status - KEPT ORIGINAL COLORS */
        .badge {
            font-weight: 700 !important;
            font-size: 0.95em !important;
            letter-spacing: 0.01em;
            padding: 0.45em 1em;
            border-radius: 6px;
            border: 1.5px solid transparent;
            display: inline-block;
            margin-right: 8px;
        }
        .badge-success, .badge-active {
            background-color: #00d25b !important;
            color: #fff !important;
            border-color: #00d25b !important;
        }
        .badge-danger, .badge-inactive {
            background-color: #fc424a !important;
            color: #fff !important;
            border-color: #fc424a !important;
        }
        .badge-scheduled, .badge-warning {
            background-color: #ffab00 !important;
            color: #fff !important;
            border-color: #ffab00 !important;
        }
        .badge-info {
            background-color: #248afd !important;
            color: #fff !important;
            border-color: #248afd !important;
        }
        
        /* Button styles (already mostly aligned, but ensure consistency) - KEPT ORIGINAL COLORS */
        .btn-primary {
            background-color: #0090e7 !important;
            border-color: #0090e7 !important;
            color: #fff !important;
        }
        .btn-primary:hover {
            background-color: #0069d9 !important;
            border-color: #0062cc !important;
        }
        .btn-danger {
            background-color: #fc424a !important;
            border-color: #fc424a !important;
            color: #fff !important;
        }
        .btn-danger:hover {
            background-color: #c82333 !important;
            border-color: #bd2130 !important;
        }
        .btn-secondary {
            background-color: #6c757d !important;
            border-color: #6c757d !important;
            color: #fff !important;
        }
        .btn-secondary:hover {
            background-color: #5a6268 !important;
            border-color: #545b62 !important;
        }

        /* Toggle switch specific to Product List - KEPT ORIGINAL COLORS */
        .toggle-switch { position: relative; display: inline-block; width: 34px; height: 20px; vertical-align: middle; }
        .toggle-switch input { opacity: 0; width: 0; height: 0; }
        .toggle-switch span { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: 0.4s; border-radius: 20px; }
        .toggle-switch span:before { position: absolute; content: ""; height: 14px; width: 14px; left: 3px; bottom: 3px; background-color: white; transition: 0.4s; border-radius: 50%; }
        .toggle-switch input:checked + span { background-color: #4caf50; }
        .toggle-switch input:checked + span:before { transform: translateX(14px); }
        
        /* DataTables Buttons (hide default) */
        .dt-buttons { display: none !important; }

        /* Dropdown menu styles (Bootstrap overrides) - KEPT ORIGINAL COLORS */
        .dropdown-menu { background-color: #23243a !important; border: 1px solid #444 !important; }
        .dropdown-item { color: #fff !important; }
        .dropdown-item:hover { background-color: #0090e7 !important; color: #fff !important; }
        div.dt-button-info { display: none !important; }

        /* Toast notifications (specific to Product List) */
        .toast-container { position: fixed; top: 20px; right: 20px; z-index: 1040; }
        .toast { background-color: #333; color: white; padding: 15px 25px; border-radius: 5px; margin-bottom: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); display: none; min-width: 250px; }
        .toast.show { display: block; animation: fadeInOut 3s forwards; }
        @keyframes fadeInOut {
            0% { opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { opacity: 0; }
        }

        /* Modal styles (Bootstrap overrides, specific to Product List) */
        .modal { display: none; position: fixed; z-index: 1050; left: 0; top: 0; width: 100%; height: 100%; overflow: hidden; outline: 0; background-color: rgba(0, 0, 0, 0.5); }
        .modal-dialog {
            position: relative; width: auto; margin: .5rem; pointer-events: none;
            display: flex;
            align-items: center;
            min-height: calc(100% - 1rem);
        }
        @media (min-width: 576px) { .modal-dialog { max-width: 500px; margin: auto; min-height: calc(100% - 3.5rem); } }
        .modal-content { 
            position: relative; display: flex; flex-direction: column; width: 100%; pointer-events: auto; 
            background-color: #191c24 !important; /* Changed to match Corona Admin primary background */ 
            background-clip: padding-box; border: 1px solid #444; border-radius: 8px; outline: 0; color: #fff !important; 
        }
        .modal-header { display: flex; align-items: flex-start; justify-content: space-between; padding: 1rem 1rem; border-bottom: 1px solid #444; border-top-left-radius: calc(.3rem - 1px); border-top-right-radius: calc(.3rem - 1px); }
        .modal-header .btn-close { padding: .5rem .5rem; margin: -.5rem -.5rem -.5rem auto; background: transparent; border: 0; color: #fff; opacity: .5; }
        .modal-title { margin-bottom: 0; line-height: 1.5; font-size: 1.25rem; }
        .modal-body { position: relative; flex: 1 1 auto; padding: 1rem; }
        .modal-footer { display: flex; flex-wrap: wrap; align-items: center; justify-content: flex-end; padding: .75rem; border-top: 1px solid #444; border-bottom-right-radius: calc(.3rem - 1px); border-bottom-left-radius: calc(.3rem - 1px); }
        .modal-footer > * { margin: .25rem; }

        /* Specific styles from Corona template (kept for consistency with the new template) */
        .edit-link {
            color: #6366F1; /* indigo-500 */
            text-decoration: none;
            font-size: 15px;
        }
        .edit-link:hover {
            text-decoration: underline;
        }
        .timeline {
            list-style: none;
            padding: 0;
            position: relative;
            margin: 0;
        }
        .timeline::before {
            content: '';
            position: absolute;
            left: 16px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #cbd5e0; /* light blue-gray line */
        }
        .timeline-item {
            position: relative;
            padding-left: 40px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .timeline-icon {
            position: absolute;
            left: 8px;
            top: 5px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #ccc;
        }
        .timeline-time {
            white-space: nowrap;
            font-size: 0.875rem;
        }

        /* New container for the search/export/length controls inside the card-body */
        .product-table-controls {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem; /* Space between elements */
            margin-bottom: 1rem; /* Space below the controls */
        }
        /* Ensure the search input takes up appropriate space */
        .product-table-controls #orderSearch {
            flex-grow: 1;
            max-width: 300px; /* Limit max width to avoid stretching too much on large screens */
        }
        /* Flex for export button and select */
        .product-table-controls .export-and-length-controls {
            display: flex;
            align-items: center;
            gap: 8px; /* Space between export button and select */
        }
    </style>
</head>
<body>
    <div class="container-scroller">
        <!-- Banner from Corona Admin Template (Optional, can be removed if not needed) -->
        <div class="row p-0 m-0 proBanner" id="proBanner">
            <div class="col-md-12 p-0 m-0">
                <!-- Banner content -->
            </div>
        </div>
        
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
                <a class="sidebar-brand brand-logo" href="index.html"><img src="../../template/assets/images/logo.svg" alt="logo" /></a>
                <a class="sidebar-brand brand-logo-mini" href="index.html"><img src="../../template/assets/images/logo-mini.svg" alt="logo" /></a>
            </div>
            <ul class="nav">
                <li class="nav-item profile">
                    <div class="profile-desc">
                        <div class="profile-pic">
                            <div class="count-indicator">
                                <img class="img-xs rounded-circle " src="../../template/assets/images/faces/face15.jpg" alt="">
                                <span class="count bg-success"></span>
                            </div>
                            <div class="profile-name">
                                <h5 class="mb-0 font-weight-normal">Henry Klein</h5>
                                <span>Gold Member</span>
                            </div>
                        </div>
                        <a href="#" id="profile-dropdown" data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
                        <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
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
                    <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                        <span class="menu-icon">
                            <i class="mdi mdi-laptop"></i>
                        </span>
                        <span class="menu-title">Basic UI Elements</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="ui-basic">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Buttons</a></li>
                            <li class="nav-item"> <a class="nav-link" href="pages/ui-features/dropdowns.html">Dropdowns</a></li>
                            <li class="nav-item"> <a class="nav-link" href="pages/ui-features/typography.html">Typography</a></li>
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
                <li class="nav-item menu-items active"> <!-- Marked active for Product List -->
                    <a class="nav-link" href="../product/product_list.html">
                        <span class="menu-icon">
                            <i class="mdi mdi-table-large"></i>
                        </span>
                        <span class="menu-title">Product List</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="../order-list/order_list.html">
                        <span class="menu-icon">
                            <i class="mdi mdi-cart"></i>
                        </span>
                        <span class="menu-title">Order List</span>
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
                    <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                        <span class="menu-icon">
                            <i class="mdi mdi-security"></i>
                        </span>
                        <span class="menu-title">User Pages</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="auth">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="pages/samples/blank-page.html"> Blank Page </a></li>
                            <li class="nav-item"> <a class="nav-link" href="pages/samples/error-404.html"> 404 </a></li>
                            <li class="nav-item"> <a class="nav-link" href="pages/samples/error-500.html"> 500 </a></li>
                            <li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> Login </a></li>
                            <li class="nav-item"> <a class="nav-link" href="pages/samples/register.html"> Register </a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="http://www.bootstrapdash.com/demo/corona-free/jquery/documentation/documentation.html">
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
                    <a class="navbar-brand brand-logo-mini" href="index.html"><img src="assets/images/logo-mini.svg" alt="logo" /></a>
                </div>
                <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                        <span class="mdi mdi-menu"></span>
                    </button>
                    <ul class="navbar-nav w-100">
                        <li class="nav-item w-100">
                            <!-- Only the general search form from Corona template remains here -->
                            <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search">
                                <input type="text" class="form-control" placeholder="Search products">
                            </form>
                        </li>
                    </ul>
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item dropdown d-none d-lg-block">
                            <a class="nav-link btn btn-success create-new-button" id="createbuttonDropdown" data-bs-toggle="dropdown" aria-expanded="false" href="#">+ Create New Project</a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="createbuttonDropdown">
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
                            <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-email"></i>
                                <span class="count bg-success"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                                <h6 class="p-3 mb-0">Messages</h6>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <img src="assets/images/faces/face4.jpg" alt="image" class="rounded-circle profile-pic">
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
                                <p class="p-3 mb-0 text-center">4 new messages</p>
                            </div>
                        </li>
                        <li class="nav-item dropdown border-left">
                            <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                                <i class="mdi mdi-bell"></i>
                                <span class="count bg-danger"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
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
                                    <img class="img-xs rounded-circle" src="assets/images/faces/face15.jpg" alt="">
                                    <p class="mb-0 d-none d-sm-block navbar-profile-name">Henry Klein</p>
                                    <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
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
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                        <span class="mdi mdi-format-line-spacing"></span>
                    </button>
                </div>
            </nav>
            <!-- partial -->

              <div class="container mt-5">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Category List</h4>
        <div class="table-responsive">
          <table id="categoryTable" class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Category Name</th>
                <th>Shipping</th>
                <th>Payment</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
  <script>
    const categories = [
      { id: 1, name: "Shirts", shipping: true, payment: true },
      { id: 2, name: "Pants", shipping: false, payment: true },
      { id: 3, name: "Shoes", shipping: true, payment: false },
    ];

    $(document).ready(function () {
      const table = $('#categoryTable').DataTable({
        data: categories,
        columns: [
          { data: 'id' },
          { data: 'name' },
          {
            data: 'shipping',
            render: function (data, type, row) {
              return `
                <label class="toggle-switch">
                  <input type="checkbox" class="toggle-shipping" data-id="${row.id}" ${data ? 'checked' : ''}>
                  <span></span>
                </label>`;
            }
          },
          {
            data: 'payment',
            render: function (data, type, row) {
              return `
                <label class="toggle-switch">
                  <input type="checkbox" class="toggle-payment" data-id="${row.id}" ${data ? 'checked' : ''}>
                  <span></span>
                </label>`;
            }
          },
          {
            data: null,
            render: function (data, type, row) {
              return `
                <button class="btn btn-primary btn-sm edit-btn" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger btn-sm delete-btn" data-id="${row.id}"><i class="fas fa-trash"></i></button>`;
            }
          }
        ]
      });

      $('#categoryTable tbody').on('change', '.toggle-shipping', function () {
        const id = $(this).data('id');
        const checked = $(this).is(':checked');
        const row = categories.find(c => c.id === id);
        row.shipping = checked;
        alert(`Shipping status updated for ${row.name}: ${checked}`);
      });

      $('#categoryTable tbody').on('change', '.toggle-payment', function () {
        const id = $(this).data('id');
        const checked = $(this).is(':checked');
        const row = categories.find(c => c.id === id);
        row.payment = checked;
        alert(`Payment status updated for ${row.name}: ${checked}`);
      });
    });
  </script>
</body>
</html>