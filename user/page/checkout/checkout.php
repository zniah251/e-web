<?php
session_start();
$cart_items = $_SESSION['cart'] ?? [];
?>
<?php
require_once("../../../connect.php");
$voucherData = null;

// Load danh sách voucher
$voucherList = [];
$sql = "SELECT vid, name, discount, minprice, expiry FROM voucher WHERE expiry >= CURDATE()";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $voucherList[] = $row;
  }
}

// Tính toán giá giỏ hàng
$total = 0;
foreach ($cart_items as $item) {
  $total += $item['price'] * $item['quantity'];
}

$voucherName = $_POST['voucher'] ?? $_GET['voucher'] ?? '';
$shipping = 30000;
$discount = 0;

$voucherMessage = '';

if ($voucherName !== '') {
  $stmt = $conn->prepare("SELECT * FROM voucher WHERE name = ?");
  $stmt->bind_param("s", $voucherName);
  $stmt->execute();
  $voucherData = $stmt->get_result()->fetch_assoc();
  $stmt->close();

if ($voucherData) {
    if ($total >= $voucherData['minprice']) {
      if (strtolower(trim($voucherData['name'])) === 'free shipping') {
          $shipping = 0;
      } else {
          $discount = $total * ($voucherData['discount'] / 100);
      }
    } else {
      $voucherMessage = "Đơn hàng của bạn chưa đạt tối thiểu " 
        . number_format($voucherData['minprice'], 0, ',', '.') 
        . "đ để áp dụng mã <strong>" . htmlspecialchars($voucherData['name']) . "</strong>.";
      $voucherName = ''; // Huỷ mã không hợp lệ
    }
  }
}


$total_final = $total + $shipping - $discount;

?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Thanh toán - KAIRA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <style>
    body {
      font-family: 'Times New Roman', serif;
      background-color: #fff;
      color: #000;
    }
    .container-custom {
      max-width: 1400px;
      margin: 40px auto;
      display: flex;
      gap: 40px;
    }
    .payment-left {
      flex: 2;
    }
    .cart-right {
      flex: 1;
      background: #fff;
      padding: 20px;
      border-radius: 0;
    }
    .cart-right .product-item {
      display: flex;
      justify-content: space-between;
      border-bottom: 1px solid #ddd;
      padding: 10px 0;
    }
    .cart-right .total {
      font-weight: bold;
      font-size: 18px;
      margin-top: 10px;
    }
    .form-section {
      margin-bottom: 25px;
    }
    .form-section h5 {
      margin-bottom: 15px;
      font-weight: bold;
    }
    .form-control {
      font-family: 'Times New Roman', serif;
    }
    .btn-primary {
      font-weight: bold;
      font-family: 'Times New Roman', serif;
      background-color: #000;
      border: none;
      transition: 0.3s;
    }
    .btn-primary:hover {
      background-color: #333;
    }
    label input[type="radio"] {
      margin-right: 5px;
    }
    input[type="radio"] + label img {
  border: 2px solid transparent;
  border-radius: 12px;
  cursor: pointer;
  transition: 0.3s ease;
  filter: grayscale(100%);
  opacity: 0.8;
}
input[type="radio"]:checked + label img {
  border: 2px solid #000;
  filter: none;
  opacity: 1;
  transform: scale(1.05);
}

  </style>
</head>
<body>
<?php include('../../../navbar.php'); ?>
<div class="container-custom">
  <!-- Thanh toán -->
  <div class="payment-left">
    <h2 class="mb-4">Thanh toán</h2>
    <form action="create_order.php" method="POST">
      <div class="form-section">
        <h5>Thông tin giao hàng</h5>
        <input type="text" name="fullname" placeholder="Họ và tên" class="form-control mb-3" required value="<?= htmlspecialchars($_GET['fullname'] ?? '') ?>">
        <input type="text" name="address" placeholder="Địa chỉ" class="form-control mb-3" required value="<?= htmlspecialchars($_GET['address'] ?? '') ?>">
        <input type="tel" name="phone" placeholder="Số điện thoại" class="form-control" required value="<?= htmlspecialchars($_GET['phone'] ?? '') ?>">
      </div>
      <div class="form-section">
  <h5>Mã giảm giá</h5>
  <button type="button" class="btn btn-outline-secondary mb-2" id="btn-choose-voucher">Chọn mã giảm giá</button>
 <?php if (!empty($voucherMessage)): ?>
  <div class="alert alert-warning mt-2">
    <?= $voucherMessage ?>
  </div>
<?php endif; ?>


  <div id="selected-voucher" class="mb-2 text-success fw-bold"></div>
  <input type="hidden" name="voucher" id="voucher-hidden" value="<?= htmlspecialchars($voucherName) ?>">
  <div id="voucher-list" class="border p-3 rounded bg-light" style="display: none;">
   <?php foreach ($voucherList as $v): ?>
  <div class="form-check mb-2 bg-white p-3 rounded shadow-sm">
    <input class="form-check-input" type="radio" name="voucher_select" value="<?= htmlspecialchars($v['name']) ?>" id="voucher_<?= $v['vid'] ?>">
    <label class="form-check-label" for="voucher_<?= $v['vid'] ?>">
      <strong><?= htmlspecialchars($v['name']) ?></strong><br>
      Đơn hàng từ <?= number_format($v['minprice'], 0, ',', '.') ?>đ<br>
      <?php if (strtolower(trim($v['name'])) === 'free shipping'): ?>
       Giảm <strong>không giới hạn</strong><br>
      <?php else: ?>
        Giảm <?= number_format($v['discount'], 0) ?>%<br>
      <?php endif; ?>
      <em class="text-muted">HSD đến: <?= date('d-m-Y', strtotime($v['expiry'])) ?></em>
    </label>
  </div>
<?php endforeach; ?>

    <button type="button" class="btn btn-primary mt-2" id="confirm-voucher">Xác nhận</button>
  </div>
</div>



      <div class="mb-3">
  <label class="form-label">
    <i class="fa fa-credit-card me-2"></i> Phương thức thanh toán
  </label>
  <div class="row text-center g-3 mb-3">
    <div class="col-4">
      <input type="radio" name="payment_method" id="momo" value="MOMO" hidden required>
      <label for="momo">
        <img src="https://upload.wikimedia.org/wikipedia/vi/f/fe/MoMo_Logo.png" width="60" alt="Momo">
      </label>
    </div>
    <div class="col-4">
      <input type="radio" name="payment_method" id="banking" value="BANK" hidden>
      <label for="banking">
        <img src="https://cdn-icons-png.flaticon.com/512/633/633611.png" width="60" alt="Banking">
      </label>
    </div>
    <div class="col-4">
      <input type="radio" name="payment_method" id="cod" value="COD" hidden>
      <label for="cod">
        <img src="https://cdn-icons-png.flaticon.com/512/25/25694.png" width="60" alt="Ship COD">
      </label>
    </div>
  </div>
</div>

      <button type="submit" class="btn btn-primary w-100">Đặt hàng</button>
    </form>
  </div>

  <div class="cart-right">
  <h5 class="fw-bold">Giỏ hàng</h5>
  <p>Có <strong><?= count($cart_items) ?></strong> sản phẩm trong giỏ hàng</p>
  <?php
    $total = 0;
    foreach ($cart_items as $item):
      $line_total = $item['price'] * $item['quantity'];
      $total += $line_total;
  ?>
    <div class="product-item">
  <div style="display: flex; gap: 10px;">
    <img src="<?= htmlspecialchars($item['thumbnail']) ?>" width="60" height="60" style="object-fit: cover; border: 1px solid #ccc;">
    <div>
      <div><strong><?= htmlspecialchars($item['title']) ?></strong> (x<?= $item['quantity'] ?>)</div>
      <div>Size: <?= htmlspecialchars($item['size']) ?> | Màu: <?= htmlspecialchars($item['color']) ?></div>
    </div>
  </div>
  <div><strong><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>đ</strong></div>
</div>


  <?php endforeach; ?>
 <div class="product-item">
  <span>Phí giao hàng</span>
  <span><?= number_format($shipping, 0, ',', '.') ?>đ</span>
</div>

<?php if ($discount > 0): ?>
<div class="product-item text-success">
  <span>Giảm giá</span>
  <span>-<?= number_format($discount, 0, ',', '.') ?>đ</span>
</div>
<?php endif; ?>

<div class="product-item total">
  <span>Tổng cộng</span>
  <span><?= number_format($total_final, 0, ',', '.') ?>đ</span>
</div>

</div>

</div>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const btnToggle = document.getElementById('btn-choose-voucher');
    const voucherList = document.getElementById('voucher-list');
    const confirmBtn = document.getElementById('confirm-voucher');
    const hiddenInput = document.getElementById('voucher-hidden');
    const selectedText = document.getElementById('selected-voucher');

    btnToggle.addEventListener('click', function () {
      voucherList.style.display = voucherList.style.display === 'none' ? 'block' : 'none';
    });
confirmBtn.addEventListener('click', function () {
  const checked = document.querySelector('input[name="voucher_select"]:checked');
  if (checked) {
    const voucher = checked.value;
    // Gửi lại trang để server tính toán giảm giá
    const fullname = document.querySelector('input[name="fullname"]').value;
const address = document.querySelector('input[name="address"]').value;
const phone = document.querySelector('input[name="phone"]').value;

const params = new URLSearchParams();
params.set('voucher', voucher);
params.set('fullname', fullname);
params.set('address', address);
params.set('phone', phone);

window.location.href = window.location.pathname + '?' + params.toString();

  } else {
    alert('Vui lòng chọn 1 mã giảm giá.');
  }
});

  });
</script>



<?php include('../../../footer.php'); ?>
</body>
</html>
