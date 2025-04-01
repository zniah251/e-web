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
(1, 'TRANG CHỦ', NULL),
(2, 'COLLECTIONS', NULL),
(3, 'SẢN PHẨM', NULL),
(4, 'ON SALE', NULL),
(5, 'GIỚI THIỆU', NULL),
(6, 'BLOG', NULL),
(7, 'NAM', 3),
(8, 'NỮ', 3);

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
  `code` int(11) NOT NULL
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
  `code` varchar(50) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `minprice` decimal(10,2) NOT NULL,
  `expiry` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
