-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2025 at 09:55 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e-web`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `bid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `caid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `size` varchar(2) NOT NULL,
  `color` varchar(30) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cid` int(11) NOT NULL,
  `cname` varchar(50) NOT NULL,
  `parentid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cid`, `cname`, `parentid`) VALUES
(1, 'HOME', NULL),
(2, 'COLLECTIONS', NULL),
(3, 'SHOP', NULL),
(4, 'ON SALE', NULL),
(5, 'INTRODUCTION', NULL),
(6, 'BLOG', NULL),
(7, 'SHOP FOR MEN', 3),
(8, 'SHOP FOR WOMEN', 3),
(9, 'SHORTS', 7),
(10, 'TROUSERS', 7),
(11, 'SHIRTS', 7),
(12, 'T-SHIRTS', 7),
(13, 'TOPS', 8),
(14, 'DRESSES', 8),
(15, 'PANTS', 8),
(16, 'SKIRTS', 8),
(17, 'ABOUT US', 5),
(18, 'MEMBERSHIP', 5),
(19, 'RECRUITMENT', 5),
(20, 'CONTACT', 5);
-- --------------------------------------------------------

--
-- Table structure for table `galery`
--

CREATE TABLE `galery` (
  `gid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `thumbnail` varchar(500) NOT NULL,
  `subpic` varchar(500) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `mid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `oid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `totalfinal` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `vid` int(11) NOT NULL,
  `destatus` enum('Pending','Confirmed','Shipping','Cancelled','Return') NOT NULL DEFAULT 'Pending',
  `paymethod` enum('COD','MOMO','Bank','Smartbanking','Credit Card') DEFAULT NULL,
  `paystatus` enum('Pending','Paid', 'Awaiting refund', 'Refunded') NOT NULL DEFAULT 'Pending',
  `paytime` timestamp NOT NULL DEFAULT current_timestamp(),
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `did` int(11) NOT NULL,
  `oid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `size` varchar(2) NOT NULL,
  `color` varchar(20) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `pid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `title` varchar(350) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `thumbnail` varchar(500) NOT NULL,
  `description` longtext NOT NULL,
  `stock` int(11) NOT NULL,
  `size` varchar(2) NOT NULL,
  `rating` float NOT NULL,
  `sold` int(11) NOT NULL,
  `color` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `product`
--
DELIMITER $$
CREATE TRIGGER `before_insert_order_rating` BEFORE INSERT ON `product` FOR EACH ROW BEGIN
    IF NEW.rating < 1 OR NEW.rating > 5 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Rating must be between 1 and 5';
    END IF;
END
$$
DELIMITER ;


-- --------------------------------------------------------

--
-- Table structure for table `resetpass`
--

CREATE TABLE `resetpass` (
  `reserid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `resettime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `code` int(11) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `reid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `picture` varchar(255) NOT NULL,
  `subpic1` varchar(255) NOT NULL,
  `reid_parent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `rid` int(11) NOT NULL,
  `rname` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`rid`, `rname`) VALUES
(1, '[admin]'),
(2, '[user]');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `uname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phonenumber` varchar(20) NOT NULL,
  `address` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `voucher`
--

CREATE TABLE `voucher` (
  `vid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `minprice` decimal(10,2) NOT NULL,
  `expiry` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `voucher` (`name`, `discount`, `minprice`, `expiry`)
VALUES
  ('Free Shipping', 30.00, 300000.00, '2025-12-31'),
  ('Discount 10%', 50.00, 300000.00, '2025-12-31');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`bid`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`caid`),
  ADD KEY `p_FK` (`pid`),
  ADD KEY `u_FK` (`uid`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cid`),
  ADD KEY `parentid_FK` (`parentid`);

--
-- Indexes for table `galery`
--
ALTER TABLE `galery`
  ADD PRIMARY KEY (`gid`),
  ADD KEY `pid_FK` (`pid`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`mid`),
  ADD KEY `uidFK` (`uid`),
  ADD KEY `roleFK` (`role`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`oid`),
  ADD KEY `usFK` (`uid`),
  ADD KEY `voucherFK` (`vid`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`did`),
  ADD KEY `oidFK` (`oid`),
  ADD KEY `prFK` (`pid`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`pid`),
  ADD KEY `cid_FK` (`cid`);

--
-- Indexes for table `resetpass`
--
ALTER TABLE `resetpass`
  ADD PRIMARY KEY (`reserid`),
  ADD KEY `useridFK` (`uid`),
  ADD KEY `emailFK` (`email`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`reid`),
  ADD KEY `proFK` (`pid`),
  ADD KEY `userFK` (`uid`),
  ADD KEY `reid_parent` (`reid_parent`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`rid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `rid_fk` (`rid`);

--
-- Indexes for table `voucher`
--
ALTER TABLE `voucher`
  ADD PRIMARY KEY (`vid`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wid`),
  ADD KEY `pFK` (`pid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `bid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `caid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `galery`
--
ALTER TABLE `galery`
  MODIFY `gid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `oid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `did` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resetpass`
--
ALTER TABLE `resetpass`
  MODIFY `reserid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `reid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `voucher`
--
ALTER TABLE `voucher`
  MODIFY `vid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wid` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `p_FK` FOREIGN KEY (`pid`) REFERENCES `product` (`pid`),
  ADD CONSTRAINT `u_FK` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`);

--
-- Constraints for table `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `parentid_FK` FOREIGN KEY (`parentid`) REFERENCES `category` (`cid`);

--
-- Constraints for table `galery`
--
ALTER TABLE `galery`
  ADD CONSTRAINT `pid_FK` FOREIGN KEY (`pid`) REFERENCES `product` (`pid`);

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `roleFK` FOREIGN KEY (`role`) REFERENCES `users` (`rid`),
  ADD CONSTRAINT `uidFK` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `usFK` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`),
  ADD CONSTRAINT `voucherFK` FOREIGN KEY (`vid`) REFERENCES `voucher` (`vid`);

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `oidFK` FOREIGN KEY (`oid`) REFERENCES `order` (`oid`),
  ADD CONSTRAINT `prFK` FOREIGN KEY (`pid`) REFERENCES `product` (`pid`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `cid_FK` FOREIGN KEY (`cid`) REFERENCES `category` (`cid`);

--
-- Constraints for table `resetpass`
--
ALTER TABLE `resetpass`
  ADD CONSTRAINT `emailFK` FOREIGN KEY (`email`) REFERENCES `users` (`email`),
  ADD CONSTRAINT `useridFK` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `proFK` FOREIGN KEY (`pid`) REFERENCES `product` (`pid`),
  ADD CONSTRAINT `reid_parent` FOREIGN KEY (`reid_parent`) REFERENCES `review` (`reid`),
  ADD CONSTRAINT `userFK` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `rid_fk` FOREIGN KEY (`rid`) REFERENCES `role` (`rid`);

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `pFK` FOREIGN KEY (`pid`) REFERENCES `product` (`pid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Áo polo cổ bé tay ngắn in hoạ tiết chữ hiện đại', 199000, 159000, 'ao-polo-co-be-tay-ngan-in-hoa-tiet-chU-hien-ai.webp', 'Sản phẩm thời trang nam cao cấp.', 10, 'L', 5, 0, 'Đen');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Áo polo cổ bé tay ngắn in hoạ tiết chữ hiện đại', 210000, 180000, 'ao-polo-co-be-tay-ngan-in-hoa-tiet-chU-hien-ai.webp', 'Sản phẩm thời trang nam cao cấp.', 10, 'XL', 5, 0, 'Đen');


INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Áo polo nam cổ bé tay ngắn trẻ trung', 160000, 140000, 'ao-polo-nam-co-be-tay-ngan-tre-trung.webp', 'Sản phẩm thời trang nam cao cấp.', 10, 'L', 4.5, 0, 'Cam');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Áo polo nam cổ bé tay ngắn trẻ trung', 170000, 150000, 'ao-polo-nam-co-be-tay-ngan-tre-trung.webp', 'Sản phẩm thời trang nam cao cấp.', 10, 'XL', 4.5, 0, 'Cam');


INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Áo polo ngắn tay nam S.cafe phối cổ.fitted', 299000, 269000, 'ao-polo-ngan-tay-nam-S.Cafe-phoi-co.Fitted.webp', 'Sản phẩm thời trang nam cao cấp.', 10, 'L', 4.5, 0, 'Trắng');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Áo polo ngắn tay nam S.cafe phối cổ.fitted', 319000, 289000, 'ao-polo-ngan-tay-nam-S.Cafe-phoi-co.Fitted.webp', 'Sản phẩm thời trang nam cao cấp.', 10, 'XL', 4.5, 0, 'Trắng');


INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Áo polo cổ bé tay ngắn thời thượng', 249000, 239000, 'ao-polo-co-be-tay-ngan-thoi-thuong.webp', 'Sản phẩm thời trang nam cao cấp.', 10, 'L', 5, 0, 'Trắng');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Áo polo cổ bé tay ngắn thời thượng', 279000, 269000, 'ao-polo-co-be-tay-ngan-thoi-thuong.webp', 'Sản phẩm thời trang nam cao cấp.', 10, 'XL', 5, 0, 'Trắng');


INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Áo polo nam ngắn tay cotton', 199000, 159000, 'ao-polo-nam-ngan-tay-cotton.webp', 'Sản phẩm thời trang nam cao cấp.', 10, 'L', 4.5, 0, 'Đen');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Áo polo nam ngắn tay cotton', 219000, 179000, 'ao-polo-nam-ngan-tay-cotton.webp', 'Sản phẩm thời trang nam cao cấp.', 10, 'XL', 4.5, 0, 'Đen');


INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Áo polo nam premium 100% cotton phối sọc form fitt', 310000, 300000, 'ao-polo-nam-premium-100_-cotton-phoi-soc-form-fitt.webp', 'Sản phẩm thời trang nam cao cấp.', 20, 'L', 4.8, 0, 'Trắng');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Áo polo nam premium 100% cotton phối sọc form fitt', 330000, 310000, 'ao-polo-nam-premium-100_-cotton-phoi-soc-form-fitt.webp', 'Sản phẩm thời trang nam cao cấp.', 20, 'XL', 4.8, 0, 'Trắng');


INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Áo polo nam thời trang basic dễ phối đồ', 149000, 129000, 'ao-polo-nam-thoi-trang-basic-de-phoi-o.jpg', 'Sản phẩm thời trang nam cao cấp.', 15, 'L', 4.5, 0, 'Nâu');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Áo polo nam thời trang basic dễ phối đồ', 169000, 149000, 'ao-polo-nam-thoi-trang-basic-de-phoi-o.jpg', 'Sản phẩm thời trang nam cao cấp.', 15, 'XL', 4.5, 0, 'Nâu');


INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Áo polo nam trơn vải cotton polyester', 299000, 269000, 'ao-polo-nam-tron-vai-cotton-polyester.webp', 'Sản phẩm thời trang nam cao cấp.', 30, 'L', 4.6, 0, 'Trắng');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Áo polo nam trơn vải cotton polyester', 319000, 289000, 'ao-polo-nam-tron-vai-cotton-polyester.webp', 'Sản phẩm thời trang nam cao cấp.', 30, 'XL', 4.6, 0, 'Trắng');


INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Áo thun ngắn tay nam', 189000, 159000, 'ao-Thun-Ngan-Tay-Nam.webp', 'Sản phẩm thời trang nam cao cấp.', 10, 'L', 4.5, 0, 'Xanh');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Áo thun ngắn tay nam', 199000, 169000, 'ao-Thun-Ngan-Tay-Nam.webp', 'Sản phẩm thời trang nam cao cấp.', 10, 'XL', 4.5, 0, 'Xanh');


INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Áo sơ mi Linen nam tay ngắn xanh', 299000, 259000, 'ao-Thun-Ngan-Tay-Nam.webp', 'Sản phẩm thời trang nam cao cấp.', 10, 'L', 4.5, 0, 'Đen');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Áo sơ mi Linen nam tay ngắn xanh', 299000, 259000, 'ao-Thun-Ngan-Tay-Nam.webp', 'Sản phẩm thời trang nam cao cấp.', 10, 'XL', 4.5, 0, 'Đen');



INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Áo Sơ Mi Cuban Nam Họa Tiết Marvel Comic', 150000, 120000, 'ao-So-Mi-Cuban-Nam-Hoa-Tiet-Marvel-Comic.webp', 'Sản phẩm thời trang nam cao cấp.', 10, 'L', 5, 0, 'Trắng đen');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Áo Sơ Mi Cuban Nam Họa Tiết Marvel Comic', 170000, 130000, 'ao-So-Mi-Cuban-Nam-Hoa-Tiet-Marvel-Comic.webp', 'Sản phẩm thời trang nam cao cấp.', 10, 'XL', 5, 0, 'Trắng đen');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Áo Sơ Mi Cuban Nam Tay', 210000, 180000, 'ao-So-Mi-Cuban-Nam-Tay.webp', 'Sản phẩm thời trang nam cao cấp.', 10, 'L', 5, 0, 'Trắng');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Áo Sơ Mi Cuban Nam Tay', 225000, 190000, 'ao-So-Mi-Cuban-Nam-Tay.webp', 'Sản phẩm thời trang nam cao cấp.', 10, 'XL', 5, 0, 'Trắng');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Áo sơ mi dài tay nam kẻ caro cotton màu xanh da trời', 195000, 165000, 'ao-so-mi-dai-tay-nam-ke-caro-cotton-mau-xanh-da-troi.jpg', 'Sản phẩm thời trang nam cao cấp.', 10, 'L', 5, 0, 'Xanh da trời');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Áo sơ mi dài tay nam kẻ caro cotton màu xanh da trời', 210000, 170000, 'ao-so-mi-dai-tay-nam-ke-caro-cotton-mau-xanh-da-troi.jpg', 'Sản phẩm thời trang nam cao cấp.', 10, 'XL', 5, 0, 'Xanh da trời');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Áo sơ mi dài tay nam kẻ caro màu xanh dương', 220000, 185000, 'ao-so-mi-dai-tay-nam-ke-caro-mau-xanh-duong.jpg', 'Sản phẩm thời trang nam cao cấp.', 10, 'L', 5, 0, 'Xanh dương');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Áo sơ mi dài tay nam kẻ caro màu xanh dương', 230000, 195000, 'ao-so-mi-dai-tay-nam-ke-caro-mau-xanh-duong.jpg', 'Sản phẩm thời trang nam cao cấp.', 10, 'XL', 5, 0, 'Xanh dương');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Áo sơ mi dài tay nam màu đen trơn', 300000, 265000, 'ao-so-mi-dai-tay-nam-mau-den-tron.jpg', 'Sản phẩm thời trang nam cao cấp.', 10, 'L', 5, 0, 'Đen');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Áo sơ mi dài tay nam màu đen trơn', 320000, 280000, 'ao-so-mi-dai-tay-nam-mau-den-tron.jpg', 'Sản phẩm thời trang nam cao cấp.', 10, 'XL', 5, 0, 'Đen');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Áo sơ mi dài tay nam màu xanh', 250000, 220000, 'ao-so-mi-dai-tay-nam-mau-xanh.jpg', 'Sản phẩm thời trang nam cao cấp.', 10, 'L', 5, 0, 'Xanh');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Áo sơ mi dài tay nam màu xanh', 270000, 230000, 'ao-so-mi-dai-tay-nam-mau-xanh.jpg', 'Sản phẩm thời trang nam cao cấp.', 10, 'XL', 5, 0, 'Xanh');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Áo sơ mi dài tay nam tím than', 290000, 250000, 'ao-so-mi-dai-tay-nam-tim-than.jpg', 'Sản phẩm thời trang nam cao cấp.', 10, 'L', 5, 0, 'Tím than');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Áo sơ mi dài tay nam tím than', 310000, 270000, 'ao-so-mi-dai-tay-nam-tim-than.jpg', 'Sản phẩm thời trang nam cao cấp.', 10, 'XL', 5, 0, 'Tím than');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Áo Sơ Mi Linen Nam Tay Ngắn Xanh', 190000, 150000, 'ao-So-Mi-Linen-Nam-Tay-Ngan-Xanh.jpg', 'Sản phẩm thời trang nam cao cấp.', 10, 'L', 5, 0, 'Xanh rêu');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Áo Sơ Mi Linen Nam Tay Ngắn Xanh', 210000, 170000, 'ao-So-Mi-Linen-Nam-Tay-Ngan-Xanh.jpg', 'Sản phẩm thời trang nam cao cấp.', 10, 'XL', 5, 0, 'Xanh rêu');


INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Quần short thể thao nam phối viền polyester', 200000, 170000, 'Quan-short-the-thao-nam-phoi-vien-polyester.webp', 'Sản phẩm quần short nam thoải mái, năng động.', 10, 'L', 5, 0, 'Xám');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Quần short thể thao nam phối viền polyester', 210000, 180000, 'Quan-short-the-thao-nam-phoi-vien-polyester.webp', 'Sản phẩm quần short nam thoải mái, năng động.', 10, 'XL', 5, 0, 'Xám');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Quần short denim nam form straight', 250000, 220000, 'Quan-short-denim-nam-form-straight.webp', 'Chất liệu denim bền đẹp, kiểu dáng trẻ trung.', 10, 'L', 5, 0, 'Xanh dương');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Quần short denim nam form straight', 270000, 230000, 'Quan-short-denim-nam-form-straight.webp', 'Chất liệu denim bền đẹp, kiểu dáng trẻ trung.', 10, 'XL', 5, 0, 'Xanh dương');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Quần short nam nỉ gân French Terry form relax', 180000, 150000, 'Quan-short-nam-ni-gan-french-terry-form-relax.webp', 'Chất liệu nỉ cao cấp, thoáng mát, phù hợp tập luyện.', 10, 'L', 5, 0, 'Đen');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Quần short nam nỉ gân French Terry form relax', 190000, 160000, 'Quan-short-nam-ni-gan-french-terry-form-relax.webp', 'Chất liệu nỉ cao cấp, thoáng mát, phù hợp tập luyện.', 10, 'XL', 5, 0, 'Đen');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Quần short nam nylon form relax', 160000, 135000, 'Quan-short-nam-nylon-form-relax.webp', 'Kiểu dáng cơ bản, dễ phối đồ, chất liệu nhẹ.', 10, 'L', 5, 0, 'Kem');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Quần short nam nylon form relax', 180000, 150000, 'Quan-short-nam-nylon-form-relax.webp', 'Kiểu dáng cơ bản, dễ phối đồ, chất liệu nhẹ.', 10, 'XL', 5, 0, 'Kem');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Quần short nam trơn cotton form straight', 230000, 195000, 'Quan-short-nam-tron-cotton-form-straight.webp', 'Chất liệu cotton thấm hút, thiết kế đơn giản.', 10, 'L', 5, 0, 'Trắng');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Quần short nam trơn cotton form straight', 250000, 210000, 'Quan-short-nam-tron-cotton-form-straight.webp', 'Chất liệu cotton thấm hút, thiết kế đơn giản.', 10, 'XL', 5, 0, 'Trắng');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Quần short nỉ nam nhấn trang trí form relax', 200000, 170000, 'Quan-short-ni-nam-nhan-trang-tri-form-relax.webp', 'Thiết kế thời trang với điểm nhấn độc đáo.', 10, 'L', 5, 0, 'Xanh dương');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Quần short nỉ nam nhấn trang trí form relax', 210000, 180000, 'Quan-short-ni-nam-nhan-trang-tri-form-relax.webp', 'Thiết kế thời trang với điểm nhấn độc đáo.', 10, 'XL', 5, 0, 'Xanh dương');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Quần shorts thể thao nam dây kéo sau regular', 270000, 230000, 'Quan-shorts-the-thao-nam-day-keo-sau-regular.webp', 'Form regular thể thao, dễ di chuyển, năng động.', 10, 'L', 5, 0, 'Xanh dương');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Quần shorts thể thao nam dây kéo sau regular', 290000, 250000, 'Quan-shorts-the-thao-nam-day-keo-sau-regular.webp', 'Form regular thể thao, dễ di chuyển, năng động.', 10, 'XL', 5, 0, 'Xanh dương');



INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Quần dài nam điều gân form carrot', 260000, 230000, 'Quan-dai-nam-dieu-gan-form-carrot.webp', 'Chất vải điều gân thoải mái, form carrot trẻ trung.', 10, 'L', 5, 0, 'Đen');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Quần dài nam điều gân form carrot', 270000, 240000, 'Quan-dai-nam-dieu-gan-form-carrot.webp', 'Chất vải điều gân thoải mái, form carrot trẻ trung.', 10, 'XL', 5, 0, 'Đen');


INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Quần tây dài nam gấp ống form slim crop', 300000, 270000, 'Quan-tay-dai-nam-gap-ong-form-slimcrop-2.webp', 'Thiết kế gấp ống hiện đại, form ôm nhẹ.', 10, 'L', 5, 0, 'Đen');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Quần tây dài nam gấp ống form slim crop', 320000, 280000, 'Quan-tay-dai-nam-gap-ong-form-slimcrop-2.webp', 'Thiết kế gấp ống hiện đại, form ôm nhẹ.', 10, 'XL', 5, 0, 'Đen');


INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Quần tây nam dài lưng thun', 210000, 180000, 'Quan-tay-nam-dai-lung-thun.webp', 'Thiết kế thoải mái với lưng thun, dễ mặc.', 10, 'L', 5, 0, 'Xám');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Quần tây nam dài lưng thun', 220000, 190000, 'Quan-tay-nam-dai-lung-thun.webp', 'Thiết kế thoải mái với lưng thun, dễ mặc.', 10, 'XL', 5, 0, 'Xám');


INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Quần vải nam dài phối lót trơn form slim', 290000, 250000, 'Quan-vai-nam-dai-phoi-lot-tron-form-slim.webp', 'Lót trơn bên trong, sang trọng, lịch lãm.', 10, 'L', 5, 0, 'Trắng');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Quần vải nam dài phối lót trơn form slim', 310000, 270000, 'Quan-vai-nam-dai-phoi-lot-tron-form-slim.webp', 'Lót trơn bên trong, sang trọng, lịch lãm.', 10, 'XL', 5, 0, 'Trắng');


INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Quần denim nam ống rộng form loose', 270000, 235000, 'Quan-denim-nam-ong-rong-form-loose.webp', 'Phong cách trẻ trung, thoải mái vận động.', 10, 'L', 5, 0, 'Xanh jeans');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Quần denim nam ống rộng form loose', 290000, 250000, 'Quan-denim-nam-ong-rong-form-loose.webp', 'Phong cách trẻ trung, thoải mái vận động.', 10, 'XL', 5, 0, 'Xanh jeans');


INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Quần denim nam ống đứng form straight', 260000, 225000, 'Quan-denim-nam-ong-dung-form-straight.webp', 'Thiết kế cổ điển, bền đẹp theo thời gian.', 10, 'L', 5, 0, 'Xanh đậm');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Quần denim nam ống đứng form straight', 280000, 240000, 'Quan-denim-nam-ong-dung-form-straight.webp', 'Thiết kế cổ điển, bền đẹp theo thời gian.', 10, 'XL', 5, 0, 'Xanh đậm');


INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Quần jeans nam dài recycled form cocoon', 300000, 260000, 'Quan-jeans-nam-dai-recycled-form-cocoon.webp', 'Sử dụng chất liệu recycled thân thiện môi trường.', 10, 'L', 5, 0, 'Đen');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Quần jeans nam dài recycled form cocoon', 320000, 270000, 'Quan-jeans-nam-dai-recycled-form-cocoon.webp', 'Sử dụng chất liệu recycled thân thiện môi trường.', 10, 'XL', 5, 0, 'Đen');


INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Quần tây nam ôm Twill Texture form slim crop', 280000, 250000, 'Quan-tay-nam-om-Twill-Texture-form-slim-crop.webp', 'Twill Texture tạo điểm nhấn cho trang phục.', 10, 'L', 5, 0, 'Vàng cam');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (7, 'Quần tây nam ôm Twill Texture form slim crop', 295000, 260000, 'Quan-tay-nam-om-Twill-Texture-form-slim-crop.webp', 'Twill Texture tạo điểm nhấn cho trang phục.', 10, 'XL', 5, 0, 'Vàng cam');



INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (13, 'Áo Gile phối nơ cổ V DUO STYLE - Rebel Gile', 199000, 159000, 'admin/assets/images/Áo gile phối nơ cổ V DUO STYLE(3) - Rebel Gile.jpg', '...', 10, 'L', 5, 0, 'Đỏ');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (13, 'Áo Gile phối nơ cổ V DUO STYLE - Rebel Gile', 199000, 159000, 'admin/assets/images/Áo gile phối nơ cổ V DUO STYLE(3) - Rebel Gile.jpg', '...', 10, 'M', 5, 0, 'Đỏ');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (13, 'Áo Gile phối nơ cổ V DUO STYLE - Rebel Gile', 199000, 159000, 'admin/assets/images/Áo gile phối nơ cổ V DUO STYLE(3) - Rebel Gile.jpg', '...', 10, 'L', 5, 0, 'Trắng');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (13, 'Áo Gile phối nơ cổ V DUO STYLE - Rebel Gile', 199000, 159000, 'admin/assets/images/Áo gile phối nơ cổ V DUO STYLE(3) - Rebel Gile.jpg', '...', 10, 'M', 5, 0, 'Trắng');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (13, 'Áo kiểu Jamie shirt HYGGE - MS01', 210000, 180000, 'admin/assets/images/Áo kiểu Jamie shirt HYGGE - MS01.jpg', '...', 10, 'L', 5, 0, 'Trắng');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (13, 'Áo kiểu Jamie shirt HYGGE - MS01', 210000, 180000, 'admin/assets/images/Áo kiểu Jamie shirt HYGGE - MS01.jpg', '...', 10, 'M', 5, 0, 'Trắng');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (13, 'Áo kiểu Rebel gile DUO STYLE - MS01', 210000, 180000, 'admin/assets/images/Áo kiểu Rebel gile DUO STYLE - MS01.jpg', '...', 10, 'L', 5, 0, 'Trắng');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (13, 'Áo kiểu Rebel gile DUO STYLE - MS01', 210000, 180000, 'admin/assets/images/Áo kiểu Rebel gile DUO STYLE - MS01.jpg', '...', 10, 'M', 5, 0, 'Trắng');


INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (13, 'Áo kiểu tay dài hoa nổi DUO STYLE - Esther Top', 210000, 180000, 'admin/assets/images/Áo kiểu tay dài hoa nổi DUO STYLE - Esther Top.jpg', '...', 10, 'L', 5, 0, 'Trắng');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (13, 'Áo kiểu tay dài hoa nổi DUO STYLE - Esther Top', 210000, 180000, 'admin/assets/images/Áo kiểu tay dài hoa nổi DUO STYLE - Esther Top.jpg', '...', 10, 'M', 5, 0, 'Trắng');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (13, 'Áo kiểu tay phồng cột nơ HYGGE - Naomi Top', 210000, 180000, 'admin/assets/images/Áo kiểu tay phồng cột nơ HYGGE - Naomi Top.jpg', '...', 10, 'L', 5, 0, 'Trắng');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (13, 'Áo kiểu tay phồng cột nơ HYGGE - Naomi Top', 210000, 180000, 'admin/assets/images/Áo kiểu tay phồng cột nơ HYGGE - Naomi Top.jpg', '...', 10, 'M', 5, 0, 'Trắng');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (13, 'Áo tay ngắn cổ thủy thủ DUO STYLE - Ayako Top', 200000, 150000, 'admin/assets/images/Áo tay ngắn cổ thủy thủ DUO STYLE - Ayako Top.jpg', '...', 10, 'L', 5, 0, 'Trắng');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (13, 'Áo tay ngắn cổ thủy thủ DUO STYLE - Ayako Top', 200000, 150000, 'admin/assets/images/Áo tay ngắn cổ thủy thủ DUO STYLE - Ayako Top.jpg', '...', 10, 'M', 5, 0, 'Trắng');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (13, 'Betty Off-ShoulderTop', 220000, 200000, 'admin/assets/images/Betty Off-ShoulderTop.jpg', '...', 10, 'L', 5, 0, 'Trắng');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (13, 'Betty Off-ShoulderTop', 220000, 200000, 'admin/assets/images/Betty Off-ShoulderTop.jpg', '...', 10, 'M', 5, 0, 'Trắng');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (13, 'Icy Top', 220000, 200000, 'admin/assets/images/icy top.jpg', '...', 10, 'L', 5, 0, 'Trắng');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (13, 'Icy Top', 220000, 200000, 'admin/assets/images/icy top.jpg', '...', 10, 'M', 5, 0, 'Trắng');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (13, 'Icy Top', 220000, 200000, 'admin/assets/images/icy top.jpg', '...', 10, 'L', 5, 0, 'Vàng nhạt');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (13, 'Icy Top', 220000, 200000, 'admin/assets/images/icy top.jpg', '...', 10, 'M', 5, 0, 'Vàng nhạt');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (13, 'Kling Top', 200000, 180000, 'admin/assets/images/Kling Top.jpg', '...', 10, 'L', 5, 0, 'Caro nâu');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (13, 'Kling Top', 200000, 180000, 'admin/assets/images/Kling Top.jpg', '...', 10, 'M', 5, 0, 'Caro nâu');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (13, 'Marisa Top', 200000, 180000, 'admin/assets/images/Marisa Top.jpg', '...', 10, 'L', 5, 0, 'Trắng');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (13, 'Marisa Top', 200000, 180000, 'admin/assets/images/Marisa Top.jpg', '...', 10, 'M', 5, 0, 'Trắng');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (13, 'Riso Tube Top', 200000, 180000, 'admin/assets/images/Riso Tube Top.jpg', '...', 10, 'L', 5, 0, 'Caro xanh');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (13, 'Riso Tube Top', 200000, 180000, 'admin/assets/images/Riso Tube Top.jpg', '...', 10, 'M', 5, 0, 'Caro xanh');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (13, 'Romie Cami Top', 200000, 180000, 'admin/assets/images/Romie Cami Top.jpg', '...', 10, 'L', 5, 0, 'Be');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (13, 'Romie Cami Top', 200000, 180000, 'admin/assets/images/Romie Cami Top.jpg', '...', 10, 'M', 5, 0, 'Be');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (13, 'Timo Jacket', 250000, 220000, 'admin/assets/images/Timo Jacket.jpg', '...', 10, 'L', 5, 0, 'Be');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (13, 'Timo Jacket', 250000, 220000, 'admin/assets/images/Timo Jacket.jpg', '...', 10, 'M', 5, 0, 'Be');


INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (14, 'Chiara Dress', 299000, 279000, 'admin/assets/images/Chiara Dress.jpg', '...', 10, 'L', 5, 0, 'Trắng');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (14, 'Chiara Dress', 299000, 279000, 'admin/assets/images/Chiara Dress.jpg', '...', 10, 'M', 5, 0, 'Trắng');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (14, 'Đầm babydoll trễ vai tay dài phối nơ HYGGE - Peachy Dress', 299000, 280000, 'admin/assets/images/Đầm babydoll trễ vai tay dài phối nơ HYGGE - Peachy Dress.jpg', '...', 10, 'L', 5, 0, 'Hồng');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (14, 'Đầm babydoll trễ vai tay dài phối nơ HYGGE - Peachy Dress', 299000, 280000, 'admin/assets/images/Đầm babydoll trễ vai tay dài phối nơ HYGGE - Peachy Dress.jpg', '...', 10, 'M', 5, 0, 'Hồng');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (14, 'Đầm ngắn tay chuông cổ cao HYGGE - Pandora Dress', 299000, 280000, 'admin/assets/images/Đầm ngắn tay chuông cổ cao HYGGE - Pandora Dress.jpg', '...', 10, 'L', 5, 0, 'Xanh đậm');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (14, 'Đầm ngắn tay chuông cổ cao HYGGE - Pandora Dress', 200000, 180000, 'admin/assets/images/Đầm ngắn tay chuông cổ cao HYGGE - Pandora Dress.jpg', '...', 10, 'M', 5, 0, 'Xanh đậm');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (14, 'Đầm tơ tay ngắn hạ eo bo chun họa tiêt ren HYGGE - Samantha Dress', 299000, 269000, 'admin/assets/images/Đầm tơ tay ngắn hạ eo bo chun họa tiêt ren HYGGE - Samantha Dress.jpg', '...', 10, 'L', 5, 0, 'Be');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (14, 'Đầm tơ tay ngắn hạ eo bo chun họa tiêt ren HYGGE - Samantha Dress', 299000, 269000, 'admin/assets/images/Đầm tơ tay ngắn hạ eo bo chun họa tiêt ren HYGGE - Samantha Dress.jpg', '...', 10, 'M', 5, 0, 'Be');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (14, 'Flurry Dress', 250000, 220000, 'admin/assets/images/Flurry Dress.jpg', '...', 10, 'L', 5, 0, 'Caro');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (14, 'Flurry Dress', 250000, 220000, 'admin/assets/images/Flurry Dress.jpg', '...', 10, 'M', 5, 0, 'Caro');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (14, 'Liltee Dress', 299000, 279000, 'admin/assets/images/Liltee Dress.jpg', '...', 10, 'L', 5, 0, 'Be');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (14, 'Liltee Dress', 299000, 279000, 'admin/assets/images/Liltee Dress.jpg', '...', 10, 'M', 5, 0, 'Be');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (14, 'LINDA DRESS', 299000, 280000, 'admin/assets/images/LINDA DRESS.jpg', '...', 10, 'L', 5, 0, 'Xanh dương');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (14, 'LINDA DRESS', 299000, 280000, 'admin/assets/images/LINDA DRESS.jpg', '...', 10, 'M', 5, 0, 'Xanh dương');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (14, 'Oscar Midi Dress', 299000, 280000, 'admin/assets/images/Oscar Midi Dress.jpg', '...', 10, 'L', 5, 0, 'Trắng');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (14, 'Oscar Midi Dress', 200000, 280000, 'admin/assets/images/Oscar Midi Dress.jpg', '...', 10, 'M', 5, 0, 'Trắng');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (14, 'Polo Dress', 299000, 269000, 'admin/assets/images/polo dress.jpg', '...', 10, 'L', 5, 0, 'Tím nhạt');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (14, 'Polo Dress', 299000, 269000, 'admin/assets/images/polo dress.jpg', '...', 10, 'M', 5, 0, 'Tím nhạt');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (14, 'Prim Dress', 250000, 220000, 'admin/assets/images/prim dress.jpg', '...', 10, 'L', 5, 0, 'Caro');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (14, 'Prim Dress', 250000, 220000, 'admin/assets/images/prim dress.jpg', '...', 10, 'M', 5, 0, 'Caro');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (14, 'Rosie Dress', 299000, 269000, 'admin/assets/images/rosie dress.jpg', '...', 10, 'L', 5, 0, 'Hồng');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (14, 'Rosie Dress', 299000, 269000, 'admin/assets/images/rosie dress.jpg', '...', 10, 'M', 5, 0, 'Hồng');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (14, 'Venis Dress', 250000, 220000, 'admin/assets/images/venis dress.jpg', '...', 10, 'L', 5, 0, 'Caro xanh nhạt');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (14, 'Venis Dress', 250000, 220000, 'admin/assets/images/venis dress.jpg', '...', 10, 'M', 5, 0, 'Caro xanh nhạt');



INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (15, 'Bonew Parachute Short', 199000, 179000, 'admin/assets/images/Bonew Parachute Short.jpg', '...', 10, 'L', 5, 0, 'Be');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (15, 'Bonew Parachute Short', 199000, 179000, 'admin/assets/images/Bonew Parachute Short.jpg', '...', 10, 'M', 5, 0, 'Be');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (15, 'Fomos Jean Short dark blue', 299000, 280000, 'admin/assets/images/Fomos Jean Short dark blue.jpg', '...', 10, 'L', 5, 0, 'Jeans đậm');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (15, 'Fomos Jean Short dark blue', 299000, 280000, 'admin/assets/imagesFomos Jean Short dark blue.jpg', '...', 10, 'M', 5, 0, 'Jeans đậm');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (15, 'Fomos Jean Short dark blue', 299000, 280000, 'admin/assets/images/Fomos Jean Short dark blue.jpg', '...', 10, 'L', 5, 0, 'Jeans nhạt');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (15, 'Fomos Jean Short dark blue', 299000, 280000, 'admin/assets/imagesFomos Jean Short dark blue.jpg', '...', 10, 'M', 5, 0, 'Jeans nhạt');


INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (15, 'Hebe Jeans', 299000, 280000, 'admin/assets/images/hebe jeans.jpg', '...', 10, 'L', 5, 0, 'Trắng');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (15, 'Hebe Jeans', 200000, 280000, 'admin/assets/images/hebe jeans.jpg', '...', 10, 'M', 5, 0, 'Trắng');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (15, 'Pamin Pants', 250000, 220000, 'admin/assets/images/Pamin Pants.jpg', '...', 10, 'L', 5, 0, 'Xanh');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (15, 'Pamin Pants', 250000, 220000, 'admin/assets/images/Pamin Pants.jpg', '...', 10, 'M', 5, 0, 'Xanh');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (15, 'Pull Pants', 299000, 279000, 'admin/assets/images/pull pants.jpg', '...', 10, 'L', 5, 0, 'Xanh');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (15, 'Pull Pants', 299000, 279000, 'admin/assets/images/pull pants.jpg', '...', 10, 'M', 5, 0, 'Xanh');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (15, 'Strip Long Pants', 299000, 280000, 'admin/assets/images/Strip Long Pants.jpg', '...', 10, 'L', 5, 0, 'Caro');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (15, 'Strip Long Pants', 299000, 280000, 'admin/assets/images/Strip Long Pants.jpg', '...', 10, 'M', 5, 0, 'Caro');


INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (16, 'Bubble Skirt', 199000, 180000, 'admin/assets/images/bubble skirt.jpg', '...', 10, 'L', 5, 0, 'Tím');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (16, 'Bubble Skirt', 100000, 180000, 'admin/assets/images/bubble skirt.jpg', '...', 10, 'M', 5, 0, 'Tím');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (16, 'Doris Midi Skirt', 299000, 269000, 'admin/assets/images/Doris Midi Skirt.jpg', '...', 10, 'L', 5, 0, 'Trắng');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (16, 'Doris Midi Skirt', 299000, 269000, 'admin/assets/images/Doris Midi Skirt.jpg', '...', 10, 'M', 5, 0, 'Trắng');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (16, 'Ficus Skirt', 250000, 220000, 'admin/assets/images/ficus skirt.jpg', '...', 10, 'L', 5, 0, 'Xám');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (16, 'Ficus Skirt', 250000, 220000, 'admin/assets/images/ficus skirt.jpg', '...', 10, 'M', 5, 0, 'Xám');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (16, 'Hansy Mini Skirt', 199000, 169000, 'admin/assets/images/Hansy Mini Skirt.jpg', '...', 10, 'L', 5, 0, 'Be');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (16, 'Hansy Mini Skirt', 199000, 169000, 'admin/assets/images/Hansy Mini Skirt.jpg', '...', 10, 'M', 5, 0, 'Be');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (16, 'Hiba Skirt', 150000, 120000, 'admin/assets/images/Hiba Skirt.jpg', '...', 10, 'L', 5, 0, 'Caro đỏ');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (16, 'Hiba Skirt', 150000, 120000, 'admin/assets/images/Hiba Skirt.jpg', '...', 10, 'M', 5, 0, 'Caro đỏ');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (16, 'Nixie Pleated Skirt', 250000, 220000, 'admin/assets/images/Nixie Pleated Skirt.jpg', '...', 10, 'L', 5, 0, 'Be');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (16, 'Nixie Pleated Skirt', 250000, 220000, 'admin/assets/images/Nixie Pleated Skirt.jpg', '...', 10, 'M', 5, 0, 'Be');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (16, 'Rolly Bubble Skirt', 199000, 169000, 'admin/assets/images/Rolly Bubble Skirt.jpg', '...', 10, 'L', 5, 0, 'Đen');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (16, 'Rolly Bubble Skirt', 199000, 169000, 'admin/assets/images/Rolly Bubble Skirt.jpg', '...', 10, 'M', 5, 0, 'Đen');

INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (16, 'Tacha Bubble Skirt', 150000, 120000, 'admin/assets/images/Tacha Bubble Skirt.jpg', '...', 10, 'L', 5, 0, 'Caro');
INSERT INTO product (cid, title, price, discount, thumbnail, description, stock, size, rating, sold, color)
VALUES (16, 'Tacha Bubble Skirt', 150000, 120000, 'admin/assets/images/Tacha Bubble Skirt.jpg', '...', 10, 'M', 5, 0, 'Caro');
