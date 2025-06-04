<?php
session_start(); // Bắt buộc phải có để truy cập session

// Kiểm tra xem giỏ hàng có dữ liệu không
$cart_items = [];
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
  $cart_items = $_SESSION['cart'];
}

// Xử lý xóa sản phẩm khỏi giỏ hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_key'])) {
  $removeKey = $_POST['remove_key'];
  if (isset($_SESSION['cart'][$removeKey])) {
    unset($_SESSION['cart'][$removeKey]);
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>Kaira Shopping Cart</title>
  <!-- MDB icon -->
  <link rel="icon" href="../../assets/img/mdb-favicon.ico" type="image/x-icon" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" />
  <!-- Google Fonts Roboto -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" />
  <!-- MDB -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.min.css" />
  <!-- Custom CSS -->
  <link rel="stylesheet" href="../../assets/css/style.css" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    @media (min-width: 1025px) {
      .h-custom {
        height: 100vh !important;
        font-family: 'Times New Roman', Times, serif;
      }
    }

    .card-registration .select-input.form-control[readonly]:not([disabled]) {
      font-size: 1rem;
      line-height: 2.15;
      padding-left: .75em;
      padding-right: .75em;
    }

    .card-registration .select-arrow {
      top: 13px;
    }

    .bg-grey {
      background-color: #eae8e8;
    }

    @media (min-width: 992px) {
      .card-registration-2 .bg-grey {
        border-top-right-radius: 16px;
        border-bottom-right-radius: 16px;
      }
    }

    @media (max-width: 991px) {
      .card-registration-2 .bg-grey {
        border-bottom-left-radius: 16px;
        border-bottom-right-radius: 16px;
      }
    }

    .tableproduct {
      width: 100% !important;
    }

    .tableproduct th,
    .tableproduct td {
      padding-left: 12px;
      padding-right: 12px;
    }

    .tableproduct thead th {
      border-bottom: 2px solid #dee2e6 !important;
    }

    .tableproduct tfoot th {
      border-top: 2px solid #dee2e6 !important;
    }

    /* Tăng khoảng cách giữa border thead và sản phẩm đầu tiên */
    .tableproduct tbody tr:first-child td {
      padding-top: 18px;
    }

    /* Tăng khoảng cách giữa border tfoot và sản phẩm cuối cùng */
    .tableproduct tbody tr:last-child td {
      padding-bottom: 18px;
    }
  </style>
</head>

<body>
  <?php include('../../../navbar.php'); ?>
  <!-- Start your project here-->
  <section class="h-100 h-custom" style="background-color: #F1F1F0;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12">
          <div class="card card-registration card-registration-2" style="border-radius: 15px;">
            <div class="card-body p-0">
              <div class="row g-0">
                <div class="col-lg-12">
                  <div class="p-5">
                    <div class="d-flex justify-content-between align-items-center mb-5">
                      <h1 class="fw-bold mb-0 text-black">Shopping Cart</h1>
                      <h6 class="mb-0 text-muted">
                        <?php echo count($cart_items); ?> items
                      </h6>
                    </div>

                    <div class="p-0">
                      <div class="table-responsive">
                        <table class="tableproduct w-100">
                          <thead>
                            <tr>
                              <th style="width: 40px;" class="text-center">
                                <input type="checkbox" id="select-all">
                              </th>
                              <th scope="col" class="col-2 fs-6">Product</th>
                              <th scope="col" class="col-2 fs-6">Name</th>
                              <th scope="col" class="col-1 fs-6">Size</th>
                              <th style="width: 100px;" class="text-center">Color</th>
                              <th style="width: 160px;" class="text-center">Quantity</th>
                              <th style="width: 120px;" class="text-center">Price</th>
                              <th scope="col" class="col-1 text-end fs-6"></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $total = 0;
                            $index = 0; // Khởi tạo biến đếm
                            if (!empty($cart_items)) {
                              foreach ($cart_items as $key => $item) {
                                // $item should have: image, name, size, color, quantity, price
                                $item_total = $item['price'] * $item['quantity'];
                                $total += $item_total;
                            ?>
                                <tr>
                                  <td class="text-center">
                                    <input type="checkbox" class="product-checkbox">
                                  </td>
                                  <td>
                                    <img src="<?php echo htmlspecialchars($item['thumbnail']); ?>"
                                      class="img-fluid rounded-3" alt="<?php echo htmlspecialchars($item['title']); ?>" style="width: 100px;">
                                  </td>
                                  <td>
                                    <h6 class="text-black mb-0"><?php echo htmlspecialchars($item['title']); ?></h6>
                                  </td>
                                  <td>
                                    <h6 class="text-black mb-0"><?php echo htmlspecialchars($item['size']); ?></h6>
                                  </td>
                                  <td class="text-center"><?php echo htmlspecialchars($item['color']); ?></td>
                                  <td class="text-center">
                                    <div class="d-inline-flex align-items-center">
                                      <button class="btn btn-link px-1 btn-qty-minus" type="button">
                                        <i class="fas fa-minus"></i>
                                      </button>
                                      <input min="1" name="quantity" value="<?php echo $item['quantity']; ?>" type="number"
                                        class="form-control form-control-sm mx-1 quantity-input" style="width: 50px;" 
                                        data-index="<?php echo $index; ?>"
                                        data-price="<?php echo $item['price']; ?>" />
                                      <button class="btn btn-link px-1 btn-qty-plus" type="button">
                                        <i class="fas fa-plus"></i>
                                      </button>
                                    </div>
                                  </td>
                                  <td class="text-center">
                                    <h6 class="mb-0 item-total" id="item-total-<?php echo $index; ?>">
                                      <span id="item-total-value-<?php echo $index; ?>" data-original-price="<?php echo $item['price']; ?>">
                                        <?php echo number_format($item['quantity'] * $item['price'], 0, ',', '.'); ?>
                                      </span>
                                      <span style="font-size: 20px; font-weight: 500; vertical-align: middle;">₫</span>
                                    </h6>
                                  </td>
                                  <td class="text-end">
                                    <form method="post" class="remove-item-form" data-key="<?php echo htmlspecialchars($key); ?>" style="display:inline;">
                                      <button type="button" class="btn btn-link text-muted p-0 remove-btn">
                                        <i class="fas fa-times"></i>
                                      </button>
                                    </form>
                                  </td>
                                </tr>
                            <?php
                              }
                            } else {
                              echo '<tr><td colspan="8" class="text-center py-4">Your cart is empty.</td></tr>';
                            }
                            ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th colspan="6" class="text-end" style="font-weight: bold; font-size: 1.5rem;">Total price</th>
                              <th class="text-center" style="font-weight: bold; font-size: 1.5rem;">
                                <span id="cart-total"><?php echo number_format($total, 0, ',', '.'); ?></span>
                                <span style="font-size: 2rem; font-weight: bold; vertical-align: middle;">₫</span>
                              </th>
                              <th></th>

                            </tr>
                          </tfoot>
                        </table>
                      </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between pt-5">
                      <a href="#!" class="text-body">
                        <i class="fas fa-long-arrow-alt-left me-2"></i>Back to shop
                      </a>
                      <button type="button" class="btn btn-dark" style="min-width: 120px;">Order</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </section>
  <footer id="footer" class="footer-custom mt-5">
    <div class="container">
      <div class="row justify-content-between py-5">

        <!-- Logo & mô tả -->
        <div class="col-md-3 col-sm-6">
          <h4 class="fw-bold mb-3">KAIRA</h4>
          <p>Chúng tôi là cửa hàng thời trang phong cách hiện đại, mang đến trải nghiệm mua sắm tiện lợi và thân thiện.</p>
          <div class="social-icons mt-3">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-youtube"></i></a>
          </div>
        </div>

        <!-- Liên kết nhanh -->
        <div class="col-md-3 col-sm-6">
          <h5 class="fw-semibold mb-3">LIÊN KẾT NHANH</h5>
          <ul class="list-unstyled">
            <li><a href="index.html">Trang chủ</a></li>
            <li><a href="page/aboutus/aboutus.html">Giới thiệu</a></li>
            <li><a href="page/faq/faq.html">Hỏi đáp</a></li>
            <li><a href="page/recruitment/recruit.html">Tuyển dụng</a></li>
            <li><a href="page/member/member.html">Membership</a></li>
          </ul>
        </div>

        <!-- Thông tin liên hệ -->
        <div class="col-md-3 col-sm-6">
          <h5 class="fw-semibold mb-3">THÔNG TIN LIÊN HỆ</h5>
          <p><i class="fas fa-map-marker-alt me-2"></i>123 Đường Lê Lợi, TP.HCM</p>
          <p><i class="fas fa-envelope me-2"></i>contact@kairashop.com</p>
          <p><i class="fas fa-phone me-2"></i>0901 234 567</p>
        </div>

        <!-- Bản đồ -->
        <div class="col-md-3 col-sm-6">
          <h5 class="fw-semibold mb-3">BẢN ĐỒ</h5>
          <div class="map-embed">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.726643481827!2d106.6901211153343!3d10.75666499233459!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f3b5f6a90ed%3A0xf7b2b4f40e527417!2zMTIzIMSQLiBMw6ogTOG7m2ksIFTDom4gVGjhu5FuZyBI4buTbmcsIFRow6BuaCBwaOG7kSBI4buTIENow60gTWluaCwgSOG7kyBDaMOidSwgVMOibiBwaOG7kSBIw7JhIE5haQ!5e0!3m2!1svi!2s!4v1614089999097!5m2!1svi!2s" width="100%" height="180" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
          </div>
        </div>

      </div>
      <div class="text-center py-3 border-top small">
        © 2025 Kaira. Thiết kế lại bởi nhóm <strong>5 IS207</strong> | Dự án học phần Phát triển Web
      </div>
    </div>
  </footer>

  <!-- End your project here-->

  <!-- MDB -->
  <script type="text/javascript" src="js/mdb.min.js"></script>
  <!-- Custom scripts -->
  <script type="text/javascript"></script>
</body>

</html>
<!-- Thêm đoạn script để xử lý cập nhật số lượng và tính toán tổng tiền-->


<!-- Thêm đoạn script để xử lý xóa sản phẩm trong giỏ hàng -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.remove-item-form .remove-btn').forEach(function(btn) {
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        if (!confirm('Remove this item from cart?')) return;
        const form = btn.closest('form');
        const key = form.getAttribute('data-key');
        fetch('', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'remove_key=' + encodeURIComponent(key)
          })
          .then(res => res.text())
          .then(() => {
            form.closest('tr').remove();
            if (typeof updateTotals === 'function') updateTotals();
          });
      });
    });
  });
</script>
<!-- Thêm đoạn script để xử lý chọn tất cả sản phẩm -->
<script>
  function updateTotals() {
  let total = 0;
  document.querySelectorAll('.product-checkbox').forEach(function(checkbox) { // Bỏ idx vì không dùng
    const row = checkbox.closest('tr');
    const input = row.querySelector('.quantity-input');

    const qty = parseInt(input.value, 10); // Lấy SỐ LƯỢNG HIỆN TẠI từ ô input
    const index = input.dataset.index;

    // LẤY GIÁ GỐC CỦA MỘT ĐƠN VỊ SẢN PHẨM từ data-price của input
    const originalPrice = parseFloat(input.dataset.price);

    // Tính TỔNG GIÁ CHO DÒNG SẢN PHẨM HIỆN TẠI: số lượng mới * giá gốc 1 đơn vị
    const itemTotal = qty * originalPrice;

    // Cập nhật hiển thị tổng giá của dòng sản phẩm (cột "Price")
    const itemTotalElem = document.getElementById('item-total-value-' + index);
    if (itemTotalElem) {
      itemTotalElem.innerHTML = itemTotal.toLocaleString('vi-VN'); // Hiển thị tổng giá mới
    }

    // Chỉ cộng vào tổng giỏ hàng nếu sản phẩm được chọn
    if (checkbox.checked) {
      total += itemTotal;
    }
  });

  // Cập nhật tổng giá toàn giỏ hàng
  document.getElementById('cart-total').innerText = total.toLocaleString('vi-VN');
}

document.addEventListener('DOMContentLoaded', function() {
  // Xử lý nút giảm số lượng
  document.querySelectorAll('.btn-qty-minus').forEach(function(btn) {
    btn.addEventListener('click', function() {
      const input = this.parentNode.querySelector('.quantity-input');
      if (parseInt(input.value, 10) > 1) {
        input.value = parseInt(input.value, 10) - 1;
        updateTotals(); // Gọi updateTotals để cập nhật cả itemTotal và total
      }
    });
  });

  // Xử lý nút tăng số lượng
  document.querySelectorAll('.btn-qty-plus').forEach(function(btn) {
    btn.addEventListener('click', function() {
      const input = this.parentNode.querySelector('.quantity-input');
      input.value = parseInt(input.value, 10) + 1;
      updateTotals(); // Gọi updateTotals để cập nhật cả itemTotal và total
    });
  });

  // Xử lý sự kiện khi người dùng gõ số lượng trực tiếp
  document.querySelectorAll('.quantity-input').forEach(function(inputElement) {
      inputElement.addEventListener('input', function() { // Sử dụng 'input' để cập nhật real-time
          let enteredQty = parseInt(this.value, 10);
          if (isNaN(enteredQty) || enteredQty < 1) {
              this.value = 1; // Đảm bảo số lượng không âm hoặc NaN
          }
          updateTotals(); // Gọi updateTotals để cập nhật cả itemTotal và total
      });
      // Tùy chọn: Xử lý khi người dùng nhấn Enter (có thể bỏ nếu input đã xử lý tốt)
      inputElement.addEventListener('keypress', function(e) {
          if (e.which === 13) {
              this.blur(); // Bỏ focus
              e.preventDefault(); // Ngăn hành vi mặc định của Enter
          }
      });
  });

  // Xử lý checkbox chọn/bỏ chọn sản phẩm
  document.querySelectorAll('.product-checkbox').forEach(function(checkbox) {
    checkbox.addEventListener('change', updateTotals);
  });

  // Xử lý checkbox chọn tất cả
  const selectAll = document.getElementById('select-all');
  if (selectAll) {
    selectAll.addEventListener('change', function() {
      document.querySelectorAll('.product-checkbox').forEach(function(checkbox) {
        checkbox.checked = selectAll.checked;
      });
      updateTotals();
    });
  }

  // Gọi updateTotals lần đầu khi trang tải xong để hiển thị đúng
  updateTotals();
});
</script> 