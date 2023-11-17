-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Nov 17, 2023 at 02:46 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertCategory` (IN `p_category` VARCHAR(255), IN `p_description` VARCHAR(255))  BEGIN
    INSERT INTO category (category, description) VALUES (p_category, p_description);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertFlavor` (IN `p_flavor` VARCHAR(255), IN `p_description` VARCHAR(255))  BEGIN
    INSERT INTO flavor (flavor, description) VALUES (p_flavor, p_description);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `Category_ID` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`Category_ID`, `category`, `description`) VALUES
(3, 'Cake', 'dough'),
(4, 'Sweetened Pastry', 'sugars'),
(5, 'Flaked Pastry', 'small pieces');

-- --------------------------------------------------------

--
-- Table structure for table `flavor`
--

CREATE TABLE `flavor` (
  `flavor_ID` int(11) NOT NULL,
  `flavor` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `flavor`
--

INSERT INTO `flavor` (`flavor_ID`, `flavor`, `description`) VALUES
(3, 'Cinnamon', 'sweet roll'),
(4, 'Chocolate', 'all milk'),
(5, 'Buttered', 'diacetyl'),
(7, 'Blueberry', 'berries');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_num` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_stock` varchar(255) NOT NULL,
  `exp_date` datetime NOT NULL,
  `man_date` datetime NOT NULL,
  `Category_ID` int(11) NOT NULL,
  `flavor_ID` int(11) NOT NULL,
  `Supplier_ID` int(11) NOT NULL,
  `sales_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_num`, `product_name`, `product_price`, `product_stock`, `exp_date`, `man_date`, `Category_ID`, `flavor_ID`, `Supplier_ID`, `sales_id`) VALUES
(3, 'Mini Donuts', 30, '15', '2023-10-26 00:00:00', '2023-10-20 00:00:00', 4, 4, 4, 0),
(4, 'Banana Cake', 55, '30', '2023-10-27 00:00:00', '2023-10-21 00:00:00', 3, 3, 2, 0),
(5, 'Crossiant', 80, '30', '2023-10-21 00:00:00', '2023-10-27 00:00:00', 5, 5, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sales_id` int(11) NOT NULL,
  `product_num` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `total` decimal(10,0) DEFAULT NULL,
  `sale_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sales_id`, `product_num`, `quantity`, `total`, `sale_date`) VALUES
(55, 4, 1, '55', '2023-10-23 21:25:53'),
(56, 3, 1, '30', '2023-10-23 21:25:53'),
(57, 5, 1, '80', '2023-10-23 21:25:53'),
(58, 3, 1, '30', '2023-10-23 21:26:46'),
(59, 4, 2, '110', '2023-10-23 21:26:46'),
(60, 3, 2, '60', '2023-10-23 22:09:27'),
(61, 5, 4, '320', '2023-10-23 22:10:13'),
(62, 3, 5, '150', '2023-10-24 00:11:48'),
(63, 3, 10, '300', '2023-10-24 00:28:46'),
(64, 3, 25, '750', '2023-10-24 00:29:17');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `Supplier_ID` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `contact_num` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`Supplier_ID`, `company_name`, `contact_num`, `email`) VALUES
(2, 'Supermoon Bakehouse', '', 'gwyngert@ims.com'),
(3, 'Cafe In The Sky', '', 'cafeitsky@yahoo.com'),
(4, 'Patisserie Kyo', '', 'patisseriekyo@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(25) NOT NULL,
  `password` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Sunghoon', 'Park', 'iceprince@gmail.com', 'iceprince', '2023-05-21 14:44:55', '2023-05-21 14:44:55'),
(2, 'Hid', 'Cuevas', 'hcuevas@yahoo.com', 'bgcboy', '2023-05-21 14:46:07', '2023-05-21 14:46:07'),
(3, 'meanhoe', 'dae', 'josegertrude172gmail.com', '1bigbass', '2023-05-23 18:55:57', '2023-05-23 18:55:57'),
(4, 'gwyn', 'gertrude', 'gwyngert@ims.com', '1bigboss', '2023-05-23 19:05:25', '2023-05-23 19:05:25'),
(5, 'Kitty', 'Covey', 'xokitty@gmail.com', 'xokitty', '2023-05-24 20:21:41', '2023-05-24 20:21:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`Category_ID`),
  ADD KEY `Category_ID` (`Category_ID`,`category`,`description`);

--
-- Indexes for table `flavor`
--
ALTER TABLE `flavor`
  ADD PRIMARY KEY (`flavor_ID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_num`),
  ADD KEY `product_num` (`product_num`,`product_name`,`product_price`,`product_stock`,`exp_date`,`man_date`,`Category_ID`,`flavor_ID`,`Supplier_ID`),
  ADD KEY `Supplier_ID` (`Supplier_ID`),
  ADD KEY `flavor_ID` (`flavor_ID`),
  ADD KEY `Category_ID` (`Category_ID`),
  ADD KEY `sales_id` (`sales_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sales_id`),
  ADD KEY `product_num` (`product_num`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`Supplier_ID`),
  ADD KEY `Supplier_ID` (`Supplier_ID`,`company_name`,`contact_num`,`email`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `Category_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `flavor`
--
ALTER TABLE `flavor`
  MODIFY `flavor_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_num` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sales_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `Supplier_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`Supplier_ID`) REFERENCES `supplier` (`Supplier_ID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`flavor_ID`) REFERENCES `flavor` (`flavor_ID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ibfk_3` FOREIGN KEY (`Category_ID`) REFERENCES `category` (`Category_ID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`product_num`) REFERENCES `product` (`product_num`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
