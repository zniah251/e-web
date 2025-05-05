<?php
session_start();

// Chặn trình duyệt cache lại các trang đã đăng nhập
if (isset($_SESSION['username']) && isset($_SESSION['role'])) {
    unset($_SESSION['username']);
    unset($_SESSION['role']);
    header('Location: /../admin/template/pages/samples/login.php');
}
?>