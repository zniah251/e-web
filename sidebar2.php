<head>
    <style>
         /* Styling cho sidebar để khớp với hình ảnh */
        .sidebar {
            width: 250px;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-right: 20px;
            /* Space between sidebar and content */
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }

        .sidebar-header img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
            object-fit: cover;
            border: 2px solid #eee;
        }

        .sidebar-menu .list-group-item {
            border: none;
            padding: 12px 15px;
            font-size: 1rem;
            color: #495057;
            transition: background-color 0.2s ease;
        }

        .sidebar-menu .list-group-item.active {
            background-color: #f1f1f0;
            /* Primary color */
            color: #2f2f2f;
            border-radius: 5px;
        }

        .sidebar-menu .list-group-item:hover:not(.active) {
            background-color: #e9ecef;
            border-radius: 5px;
        }

        .sidebar-menu .list-group-item i {
            margin-right: 10px;
            width: 20px;
            /* Align icons */
            text-align: center;
        }
    </style>
</head>
<div class="sidebar">
    <div class="sidebar-header" style="border-bottom: 1px solid rgba(0,0,0,0.1); padding-bottom: 15px; margin-bottom: 15px;">
        <img src="https://via.placeholder.com/50/696cff/FFFFFF?text=TN" alt="User Avatar">
        <div>
            <h6 class="mb-0">Tien Nguyen</h6>
        </div>
    </div>
    <div class="sidebar-menu list-group list-group-flush">
        <a href="#" class="list-group-item list-group-item-action">
            <i class="fas fa-file-invoice"></i> Quản lý đơn hàng
        </a>
        <a href="#" class="list-group-item list-group-item-action">
            <i class="fas fa-bell"></i> Thông báo
        </a>
        <a href="#" class="list-group-item list-group-item-action active">
            <i class="fas fa-heart"></i> Sản phẩm yêu thích
        </a>
        <a href="#" class="list-group-item list-group-item-action">
            <i class="fas fa-user"></i> Thông tin tài khoản
        </a>
        <a href="#" class="list-group-item list-group-item-action">
            <i class="fas fa-map-marker-alt"></i> Sổ địa chỉ
        </a>
        <a href="#" class="list-group-item list-group-item-action">
            <i class="fas fa-ticket-alt"></i> Ví voucher
        </a>
        <a href="#" class="list-group-item list-group-item-action">
            <i class="fas fa-sign-out-alt"></i> Đăng xuất
        </a>
    </div>
</div>