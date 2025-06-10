<?php
require_once "../../../connect.php";
session_start();

// Check if user is logged in
if (!isset($_SESSION['uid'])) {
    header("Location: /e-web/user/page/sign-in/login2.php");
    exit();
}

// Get user ID from session
$uid = $_SESSION['uid'];

// Get cart items from session
$products = $_SESSION['cart'] ?? [];

// Get form data
$fullname = $_POST['fullname'] ?? '';
$address  = $_POST['address'] ?? '';
$phone    = $_POST['phone'] ?? '';
$method   = $_POST['payment_method'] ?? 'MOMO'; // MOMO | BANK | COD
$voucher  = trim($_POST['voucher'] ?? '');

// Default values
$vid = null;
$discount = 0;
$shipping = 30000;
$voucher_minprice = 0;

// Get voucher information if provided
if ($voucher !== '') {
    $stmt = $conn->prepare("SELECT vid, discount, minprice, name FROM voucher WHERE name = ?");
    $stmt->bind_param("s", $voucher);
    $stmt->execute();
    $stmt->bind_result($vidFound, $discountPercent, $minprice, $vname);
    if ($stmt->fetch()) {
        $vid = $vidFound;
        $voucher_minprice = $minprice;
        
        // Calculate discount based on voucher type
        if (strtolower(trim($vname)) === 'free shipping') {
            $shipping = 0;
        } else {
            $discount = $total * ($discountPercent / 100);
        }
    }
    $stmt->close();
}

// Calculate total price from cart items
$total = 0;
foreach ($products as $p) {
    $total += $p['price'] * $p['quantity'];
}

// Calculate final total
$totalfinal = $total + $shipping - $discount;

// Begin transaction
$conn->begin_transaction();

try {
    // Insert into orders table
    $stmt = $conn->prepare("INSERT INTO orders (uid, totalfinal, price, destatus, paymethod, paystatus, create_at, vid) VALUES (?, ?, ?, 'Pending', ?, 'Pending', NOW(), ?)");
    $stmt->bind_param("iddsi", $uid, $totalfinal, $total, $method, $vid);
    $stmt->execute();
    
    // Get the order ID
    $oid = $stmt->insert_id;
    
    // Insert order details
    $stmt = $conn->prepare("INSERT INTO order_detail (oid, pid, quantity, size, color, price) VALUES (?, ?, ?, ?, ?, ?)");
    
    foreach ($products as $product) {
        $stmt->bind_param("iiissd", 
            $oid,
            $product['pid'],
            $product['quantity'],
            $product['size'],
            $product['color'],
            $product['price']
        );
        $stmt->execute();
    }
    
    // Commit transaction
    $conn->commit();
    
    // Clear cart after successful order
    unset($_SESSION['cart']);
    
    // Redirect based on payment method
    switch ($method) {
        case 'MOMO':
            header("Location: momo_payment_info.php?orderId=$oid");
            break;
        case 'BANK':
            header("Location: bank_payment_info.php?orderId=$oid");
            break;
        case 'COD':
            header("Location: confirm_shipping.php?orderId=$oid&fullname=$fullname&address=$address&phone=$phone");
            break;
        default:
            header("Location: confirm_shipping.php?orderId=$oid&fullname=$fullname&address=$address&phone=$phone");
    }
    exit();
    
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    echo "Error: " . $e->getMessage();
    exit();
}
?>
