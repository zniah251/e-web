<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "e-web";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
    echo "<script>
    alert('Kết nối thất bại ');
  </script>";
}
?>
