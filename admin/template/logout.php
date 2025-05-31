<?php
session_start();

// Chặn trình duyệt cache lại các trang đã đăng nhập
if (isset($_SESSION['username']) && isset($_SESSION['role'])) {
    unset($_SESSION['username']);
    unset($_SESSION['role']);
    header('Location: /e-web/admin/template/login.php');
}
?>