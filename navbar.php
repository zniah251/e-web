<?php
$is_logged_in = isset($_SESSION['uid']) && $_SESSION['uid'] > 0;
$user_name = $is_logged_in ? htmlspecialchars($_SESSION['uname']) : '';
$user_icon_svg = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/e-web/user/icon/icon.svg");
?>
<style>
  .login-button {
    display: inline-flex;
    align-items: center;
    background-color: #333;
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 14px;
    text-decoration: none;
    gap: 6px;
    transition: background-color 0.3s ease;
  }

  .login-button:hover {
    background-color: #555;
  }

  .login-button i {
    font-size: 16px;
  }

  .align-items-center,
  .page-header,
  .loader-demo-box,
  .list-wrapper ul li,
  .navbar .navbar-menu-wrapper .navbar-nav .nav-item.dropdown .dropdown-menu.navbar-dropdown .dropdown-item {
    align-items: center !important;
  }

  /* Dropdown submenu styles */
  .dropdown-submenu {
    position: relative;
  }

  .dropdown-submenu .dropdown-menu {
    top: 0;
    left: 100%;
    margin-top: -1px;
    display: none;
  }

  .dropdown-submenu:hover > .dropdown-menu {
    display: block;
  }

  .dropdown-submenu > a:after {
    display: block;
    content: " ";
    float: right;
    width: 0;
    height: 0;
    border-color: transparent;
    border-style: solid;
    border-width: 5px 0 5px 5px;
    border-left-color: #cccccc;
    margin-top: 5px;
    margin-right: -10px;
  }

  /* Main dropdown hover state */
  .dropdown:hover > .dropdown-menu {
    display: block;
  }

  /* Ensure dropdowns are above other content */
  .dropdown-menu {
    z-index: 1000;
  }
</style>
<nav class="navbar navbar-expand-lg bg-light text-uppercase fs-6 p-3 border-bottom align-items-center">
  <div class="container-fluid">
    <div class="row justify-content-between align-items-center w-100">

      <div class="col-auto">
        <a class="navbar-brand text-white" href="./user/index.html">
          <!-- Logo SVG -->
          <svg width="112" height="45" viewBox="0 0 112 45" xmlns="http://www.w3.org/2000/svg" fill="#111">
            <path
              d="M2.51367 34.9297C2.58398 34.6836 2.64844 34.3789 2.70703 34.0156C2.77734 33.6523 2.83594 33.2012 2.88281 32.6621C2.92969 32.123 2.96484 31.4844 2.98828 30.7461C3.01172 29.9961 3.02344 29.123 3.02344 28.127V16.6836C3.02344 15.6875 3.01172 14.8203 2.98828 14.082C2.96484 13.332 2.92969 12.6875 2.88281 12.1484C2.83594 11.5977 2.77734 11.1406 2.70703 10.7773C2.64844 10.4141 2.58398 10.1094 2.51367 9.86328V9.79297H6.73242V9.86328C6.66211 10.1094 6.5918 10.4141 6.52148 10.7773C6.46289 11.1406 6.41016 11.5977 6.36328 12.1484C6.32812 12.6875 6.29297 13.332 6.25781 14.082C6.23438 14.8203 6.22266 15.6875 6.22266 16.6836V20.6035L16.4883 12.2188C17.6367 11.2813 18.2109 10.4727 18.2109 9.79297H23.1504V9.86328C22.459 10.0273 21.7559 10.3437 21.041 10.8125C20.3379 11.2695 19.5879 11.832 18.791 12.5L9.7207 20.0938L20.6367 32.082C21.0938 32.5508 21.4805 32.9434 21.7969 33.2598C22.125 33.5645 22.4121 33.8223 22.6582 34.0332C22.9043 34.2324 23.127 34.4023 23.3262 34.543C23.5371 34.6719 23.7539 34.8008 23.9766 34.9297V35H18.8262C18.7793 34.8945 18.6973 34.7598 18.5801 34.5957C18.4746 34.4316 18.3457 34.2617 18.1934 34.0859C18.0527 33.9102 17.8945 33.7285 17.7188 33.541C17.5547 33.3535 17.3965 33.1777 17.2441 33.0137L6.22266 20.9199V28.127C6.22266 29.123 6.23438 29.9961 6.25781 30.7461C6.29297 31.4844 6.32812 32.123 6.36328 32.6621C6.41016 33.2012 6.46289 33.6523 6.52148 34.0156C6.5918 34.3789 6.66211 34.6836 6.73242 34.9297V35H2.51367V34.9297ZM45.3846 35V34.9297C45.408 34.8711 45.4256 34.7832 45.4373 34.666C45.4491 34.5488 45.4549 34.4434 45.4549 34.3496C45.4549 33.9863 45.4022 33.5879 45.2967 33.1543C45.203 32.709 45.0155 32.1582 44.7342 31.502L42.6073 26.7207C41.951 26.6973 41.078 26.6855 39.9881 26.6855C38.8983 26.6855 37.7205 26.6855 36.4549 26.6855C35.5291 26.6855 34.6327 26.6855 33.7655 26.6855C32.91 26.6855 32.1366 26.6973 31.4452 26.7207L29.4237 31.3613C29.2479 31.7949 29.0604 32.2695 28.8612 32.7852C28.662 33.3008 28.5623 33.8223 28.5623 34.3496C28.5623 34.502 28.5741 34.6309 28.5975 34.7363C28.6209 34.8301 28.6444 34.8945 28.6678 34.9297V35H25.0819V34.9297C25.2928 34.707 25.5565 34.3145 25.8729 33.752C26.1893 33.1777 26.535 32.4629 26.91 31.6074L36.9823 9.26562H38.3885L47.9334 30.7461C48.1561 31.25 48.3846 31.7422 48.619 32.2227C48.8651 32.6914 49.0936 33.1133 49.3045 33.4883C49.5155 33.8633 49.703 34.1797 49.867 34.4375C50.0311 34.6953 50.1424 34.8594 50.201 34.9297V35H45.3846ZM33.994 25.1738C34.6737 25.1738 35.3709 25.1738 36.0858 25.1738C36.8006 25.1621 37.4979 25.1562 38.1776 25.1562C38.869 25.1445 39.5311 25.1387 40.1639 25.1387C40.7967 25.127 41.3709 25.1152 41.8866 25.1035L36.9471 13.9414L32.0955 25.1738H33.994ZM54.6989 34.9297C54.7692 34.6836 54.8337 34.3789 54.8923 34.0156C54.9509 33.6523 55.0036 33.2012 55.0505 32.6621C55.0973 32.123 55.1325 31.4844 55.1559 30.7461C55.1794 29.9961 55.1911 29.123 55.1911 28.127V16.6836C55.1911 15.6875 55.1794 14.8203 55.1559 14.082C55.1325 13.332 55.0973 12.6875 55.0505 12.1484C55.0036 11.5977 54.9509 11.1406 54.8923 10.7773C54.8337 10.4141 54.7692 10.1094 54.6989 9.86328V9.79297H58.9001V9.86328C58.8298 10.1094 58.7595 10.4141 58.6891 10.7773C58.6305 11.1406 58.5778 11.5977 58.5309 12.1484C58.4958 12.6875 58.4606 13.332 58.4255 14.082C58.402 14.8203 58.3903 15.6875 58.3903 16.6836V28.127C58.3903 29.123 58.402 29.9961 58.4255 30.7461C58.4606 31.4844 58.4958 32.123 58.5309 32.6621C58.5778 33.2012 58.6305 33.6523 58.6891 34.0156C58.7595 34.3789 58.8298 34.6836 58.9001 34.9297V35H54.6989V34.9297ZM69.9722 28.127C69.9722 29.123 69.9839 29.9961 70.0073 30.7461C70.0425 31.4844 70.0777 32.123 70.1128 32.6621C70.1597 33.2012 70.2124 33.6523 70.271 34.0156C70.3413 34.3789 70.4116 34.6836 70.482 34.9297V35H66.2632V34.9297C66.3335 34.6836 66.398 34.3789 66.4566 34.0156C66.5269 33.6523 66.5796 33.2012 66.6148 32.6621C66.6616 32.123 66.6968 31.4844 66.7202 30.7461C66.7554 30.0078 66.773 29.1348 66.773 28.127V16.6836C66.773 15.6875 66.7554 14.8203 66.7202 14.082C66.6968 13.332 66.6616 12.6875 66.6148 12.1484C66.5796 11.6094 66.5269 11.1582 66.4566 10.7949C66.398 10.4199 66.3335 10.1094 66.2632 9.86328V9.79297L67.0015 9.86328C67.2241 9.88672 67.4702 9.9043 67.7398 9.91602C68.021 9.91602 68.3081 9.91602 68.6011 9.91602C69.0581 9.91602 69.6734 9.86328 70.4468 9.75781C71.232 9.64062 72.228 9.58203 73.4351 9.58203C74.5601 9.58203 75.5972 9.73438 76.5464 10.0391C77.5073 10.3437 78.3394 10.7891 79.0425 11.375C79.7456 11.9609 80.2905 12.6816 80.6773 13.5371C81.0757 14.3809 81.2749 15.3418 81.2749 16.4199C81.2749 17.2637 81.1636 18.0488 80.9409 18.7754C80.73 19.4902 80.4253 20.1406 80.0269 20.7266C79.6402 21.3125 79.1714 21.834 78.6206 22.291C78.0698 22.7363 77.4546 23.1113 76.7749 23.416L82.9448 32.082C83.2495 32.5156 83.5308 32.8906 83.7886 33.207C84.0581 33.5234 84.3101 33.7988 84.5445 34.0332C84.7905 34.2559 85.0249 34.4434 85.2476 34.5957C85.4702 34.7363 85.6987 34.8477 85.9331 34.9297V35H80.853C80.8179 34.7773 80.7007 34.4844 80.5015 34.1211C80.314 33.7461 80.0913 33.377 79.8335 33.0137L73.6109 24.2422C73.3413 24.2656 73.0718 24.2891 72.8023 24.3125C72.5327 24.3242 72.2573 24.3301 71.9761 24.3301C71.648 24.3301 71.314 24.3184 70.9741 24.2949C70.646 24.2715 70.312 24.2305 69.9722 24.1719V28.127ZM69.9722 22.8008C70.2886 22.8711 70.6109 22.9238 70.939 22.959C71.2671 22.9824 71.5835 22.9941 71.8882 22.9941C72.7671 22.9941 73.5698 22.8652 74.2964 22.6074C75.023 22.3379 75.6382 21.9336 76.1421 21.3945C76.6577 20.8555 77.0562 20.1875 77.3374 19.3906C77.6187 18.582 77.7593 17.6387 77.7593 16.5605C77.7593 15.6816 77.6597 14.8848 77.4605 14.1699C77.2612 13.4551 76.9624 12.8516 76.564 12.3594C76.1773 11.8555 75.6851 11.4687 75.0874 11.1992C74.4898 10.918 73.7925 10.7773 72.9956 10.7773C72.187 10.7773 71.5425 10.8184 71.062 10.9004C70.5816 10.9824 70.2183 11.0703 69.9722 11.1641V22.8008ZM107.13 35V34.9297C107.154 34.8711 107.171 34.7832 107.183 34.666C107.195 34.5488 107.201 34.4434 107.201 34.3496C107.201 33.9863 107.148 33.5879 107.042 33.1543C106.949 32.709 106.761 32.1582 106.48 31.502L104.353 26.7207C103.697 26.6973 102.824 26.6855 101.734 26.6855C100.644 26.6855 99.4662 26.6855 98.2005 26.6855C97.2748 26.6855 96.3783 26.6855 95.5111 26.6855C94.6556 26.6855 93.8822 26.6973 93.1908 26.7207L91.1693 31.3613C90.9935 31.7949 90.806 32.2695 90.6068 32.7852C90.4076 33.3008 90.308 33.8223 90.308 34.3496C90.308 34.502 90.3197 34.6309 90.3431 34.7363C90.3666 34.8301 90.39 34.8945 90.4134 34.9297V35H86.8275V34.9297C87.0384 34.707 87.3021 34.3145 87.6185 33.752C87.9349 33.1777 88.2806 32.4629 88.6556 31.6074L98.7279 9.26562H100.134L109.679 30.7461C109.902 31.25 110.13 31.7422 110.365 32.2227C110.611 32.6914 110.839 33.1133 111.05 33.4883C111.261 33.8633 111.449 34.1797 111.613 34.4375C111.777 34.6953 111.888 34.8594 111.947 34.9297V35H107.13ZM95.7396 25.1738C96.4193 25.1738 97.1166 25.1738 97.8314 25.1738C98.5462 25.1621 99.2435 25.1562 99.9232 25.1562C100.615 25.1445 101.277 25.1387 101.91 25.1387C102.542 25.127 103.117 25.1152 103.632 25.1035L98.6927 13.9414L93.8412 25.1738H95.7396Z" />
          </svg>
        </a>
      </div>

      <div class="col-auto">
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
          aria-controls="offcanvasNavbar">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
          aria-labelledby="offcanvasNavbarLabel">
          <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
              aria-label="Close"></button>
          </div>

          <div class="offcanvas-body">
            <ul class="navbar-nav justify-content-end flex-grow-1 gap-1 gap-md-5 pe-3">
              <li class="nav-item">
                <a class="nav-link" href="/e-web/user/index.php" id="Home">Home</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdownCollection" data-bs-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">Collection</a>
                <ul class="dropdown-menu list-unstyled" aria-labelledby="dropdownCollection">
                  <li><a href="/e-web/user/page/collection/summer-collection-2025.php" class="dropdown-item">Collection 1</a></li>
                  <li><a href="collection2.html" class="dropdown-item">Collection 2</a></li>
                  <li><a href="collection3.html" class="dropdown-item">Collection 3</a></li>
                </ul>
              </li>

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdownShop" data-bs-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">Shop</a>
                <ul class="dropdown-menu list-unstyled" aria-labelledby="dropdownShop">
                  <li class="dropdown-submenu">
                    <a class="dropdown-item dropdown-toggle" href="#">Shop for Men</a>
                    <ul class="dropdown-menu">
                      <li><a href="/e-web/user/page/man/shorts.php" class="dropdown-item">Shorts</a></li>
                      <li><a href="/e-web/user/page/man/trousers.php" class="dropdown-item">Trousers</a></li>
                      <li><a href="/e-web/user/page/man/shirts.php" class="dropdown-item">Shirts</a></li>
                      <li><a href="/e-web/user/page/man/t-shirts.php" class="dropdown-item">T-Shirts</a></li>
                    </ul>
                  </li>
                  <li class="dropdown-submenu">
                    <a class="dropdown-item dropdown-toggle" href="#">Shop for Women</a>
                    <ul class="dropdown-menu">
                      <li><a href="/e-web/user/page/woman/tops.php" class="dropdown-item">Tops</a></li>
                      <li><a href="/e-web/user/page/woman/dresses.php" class="dropdown-item">Dresses</a></li>
                      <li><a href="/e-web/user/page/woman/pants.php" class="dropdown-item">Pants</a></li>
                      <li><a href="/e-web/user/page/woman/skirt.php" class="dropdown-item">Skirts</a></li>
                    </ul>
                  </li>
                </ul>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="#" id="OnSale">On Sale</a>
              </li>

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdownBlog" data-bs-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">Introduction</a>
                <ul class="dropdown-menu list-unstyled" aria-labelledby="dropdownBlog">
                  <li><a href="/e-web/user/page/aboutus/aboutus.html" class="dropdown-item">About Us</a></li>
                  <li><a href="/e-web/user/page/member/member.php" class="dropdown-item">Membership</a></li>
                  <li><a href="/e-web/user/page/recruitment/recruit.php" class="dropdown-item">Recruitment</a></li>
                  <li><a href="/e-web/user/page/faq/faq.html" class="dropdown-item">Contact</a></li>
                </ul>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="/e-web/user/blog.php">Blog</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-3 col-lg-auto">
        <ul class="list-unstyled d-flex m-0">
          <li class="d-none d-lg-block">
            <a href="/e-web/user/page/users/wishlist.php" class="text-uppercase mx-3">Wishlist <span class="wishlist-count">(0)</span>
            </a>
          </li>
          <li class="d-none d-lg-block">
            <a href="cart.php" class="text-uppercase mx-3" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart"
              aria-controls="offcanvasCart">Cart <span class="cart-count">(0)</span>
            </a>
          </li>
          <li class="d-lg-none">
            <a href="#" class="mx-2">
              <svg width="24" height="24" viewBox="0 0 24 24">
                <use xlink:href="#heart"></use>
              </svg>
            </a>
          </li>
          <li class="d-lg-none">
            <a href="#" class="mx-2" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart"
              aria-controls="offcanvasCart">
              <svg width="24" height="24" viewBox="0 0 24 24">
                <use xlink:href="#cart"></use>
              </svg>
            </a>
          </li>
          <li class="search-box" class="mx-2">
            <a href="#search" class="search-button">
              <svg width="24" height="24" viewBox="0 0 24 24">
                <use xlink:href="#search"></use>
              </svg>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="dropdown">
      <?php if ($is_logged_in): ?>
        <a href="#" class="login-button dropdown-toggle" id="loginDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fas fa-user"></i>
          <span><?php echo $user_name; ?></span> </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="loginDropdown">
          <li><a class="dropdown-item" href="/e-web/user/page/users/info.php">My Profile</a></li>
          <li><a class="dropdown-item" href="/e-web/user/page/users/manage_orders.php">My Orders</a></li>
          <li><a class="dropdown-item" href="/e-web/user/page/users/wishlist.php">Wishlist</a></li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li><a class="dropdown-item" href="/e-web/user/page/sign-in/logout.php">Log out</a></li>
        </ul>
      <?php else: ?>
        <a href="/e-web/user/page/sign-in/login2.php" class="login-button">
          <i class="fas fa-user"></i>
          <span></span> </a>
      <?php endif; ?>
    </div>
  </div>
</nav>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all dropdowns
    var dropdowns = document.querySelectorAll('.dropdown-toggle');
    dropdowns.forEach(function(dropdown) {
        dropdown.addEventListener('click', function(e) {
            e.preventDefault();
            var menu = this.nextElementSibling;
            if (menu.style.display === 'block') {
                menu.style.display = 'none';
            } else {
                menu.style.display = 'block';
            }
        });
    });

    // Handle submenu dropdowns
    var submenuDropdowns = document.querySelectorAll('.dropdown-submenu > a');
    submenuDropdowns.forEach(function(submenu) {
        submenu.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var menu = this.nextElementSibling;
            if (menu.style.display === 'block') {
                menu.style.display = 'none';
            } else {
                menu.style.display = 'block';
            }
        });
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                menu.style.display = 'none';
            });
        }
    });
});
</script>