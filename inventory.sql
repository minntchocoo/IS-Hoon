-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Dec 19, 2023 at 01:34 AM
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetOneDaySalesReport` (IN `targetDate` DATE)  BEGIN
    SELECT 
        sales_id,
        product_num,
        quantity,
        total,
        sale_date
    FROM 
        sales
    WHERE 
        DATE(sale_date) = targetDate;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetOneDaySalesReport-Total` (IN `targetDate` DATE)  BEGIN
    SELECT 
        MIN(sales_id) as sales_id,
        product_num,
        SUM(quantity) as total_quantity,
        SUM(total) as total_amount,
        MIN(sale_date) as sale_date
    FROM 
        sales
    WHERE 
        DATE(sale_date) = targetDate
    GROUP BY
        product_num;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetOneMonthSalesReport` (IN `targetMonth` INT(7), IN `targetYear` INT)  BEGIN
    DECLARE startDate DATE;
    DECLARE endDate DATE;
    
    SET startDate = CONCAT(targetYear, '-', targetMonth, '-01');
    SET endDate = LAST_DAY(startDate);

    SELECT 
        sales_id,
        product_num,
        quantity,
        total,
        sale_date
    FROM 
        sales
    WHERE 
        sale_date BETWEEN startDate AND endDate;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetOneMonthSalesReportTotal` (IN `targetMonth` VARCHAR(7), IN `targetYear` INT)  BEGIN
    DECLARE startDate DATE;
    DECLARE endDate DATE;
    
    SET startDate = CONCAT(targetYear, '-', targetMonth, '-01');
    SET endDate = LAST_DAY(startDate);

    SELECT 
        MIN(sales_id) as sales_id,
        product_num,
        SUM(quantity) as total_quantity,
        SUM(total) as total_amount,
        MIN(sale_date) as sale_date
    FROM 
        sales
    WHERE 
        sale_date BETWEEN startDate AND endDate
    GROUP BY
        product_num;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetOneWeekSalesReport` (IN `startDate` DATE)  BEGIN
    DECLARE endDate DATE;
    SET endDate = DATE_ADD(startDate, INTERVAL 6 DAY);

    SELECT 
        sales_id,
        product_num,
        quantity,
        total,
        sale_date
    FROM 
        sales
    WHERE 
        sale_date BETWEEN startDate AND endDate;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetOneWeekSalesReportTotal` (IN `startDate` DATE)  BEGIN
    DECLARE endDate DATE;
    SET endDate = DATE_ADD(startDate, INTERVAL 6 DAY);

    SELECT 
        MIN(sales_id) as sales_id,
        product_num,
        SUM(quantity) as total_quantity,
        SUM(total) as total_amount,
        MIN(sale_date) as sale_date
    FROM 
        sales
    WHERE 
        sale_date BETWEEN startDate AND endDate
    GROUP BY
        product_num;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertCategory` (IN `p_category` VARCHAR(255), IN `p_description` VARCHAR(255))  BEGIN
    INSERT INTO category (category, description) VALUES (p_category, p_description);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertFlavor` (IN `p_flavor` VARCHAR(255), IN `p_description` VARCHAR(255))  BEGIN
    INSERT INTO flavor (flavor, description) VALUES (p_flavor, p_description);
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `GetTotalQuantityByProductNum` (`targetProductNum` INT) RETURNS INT(11) BEGIN
    DECLARE totalQuantity INT;

    SELECT SUM(quantity) INTO totalQuantity
    FROM sales
    WHERE product_num = targetProductNum;

    IF totalQuantity IS NULL THEN
        SET totalQuantity = 0;
    END IF;

    RETURN totalQuantity;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `GetTotalSalesByProductNum` (`targetProductNum` INT) RETURNS DECIMAL(10,2) BEGIN
    DECLARE totalSales DECIMAL(10, 2);

    SELECT SUM(total) INTO totalSales
    FROM sales
    WHERE product_num = targetProductNum;

    IF totalSales IS NULL THEN
        SET totalSales = 0.00;
    END IF;

    RETURN totalSales;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `GetWeeklySalesData` (`startDate` DATE) RETURNS LONGTEXT CHARSET utf8mb4 COLLATE utf8mb4_bin BEGIN
    DECLARE jsonData JSON;

    SELECT JSON_ARRAYAGG(
        JSON_OBJECT(
            'sales_day', DATE(sale_date),
            'total_sales', SUM(total),
            'total_quantity', SUM(quantity)
        )
    )
    INTO jsonData
    FROM sales
    WHERE sale_date >= startDate
    GROUP BY DATE(sale_date)
    ORDER BY DATE(sale_date);

    RETURN jsonData;
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
(5, 'Flaked Pastry', 'small pieces'),
(7, 'Cake', 'fluffy'),
(10, 'sweetened pastry', 'pastry');

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
  `sales_id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_num`, `product_name`, `product_price`, `product_stock`, `exp_date`, `man_date`, `Category_ID`, `flavor_ID`, `Supplier_ID`, `sales_id`, `image_url`) VALUES
(4, 'Banana Cake', 50, '29', '2023-12-17 00:00:00', '2023-12-07 00:00:00', 3, 3, 2, 0, 'https://sallysbakingaddiction.com/wp-content/uploads/2018/10/moist-banana-bread.jpg'),
(11, 'Cookies', 25, '29', '2023-12-14 00:00:00', '2023-12-01 00:00:00', 3, 5, 2, 0, 'https://sallysbakingaddiction.com/wp-content/uploads/2013/05/classic-chocolate-chip-cookies.jpg'),
(13, 'Macarons', 35, '30', '2023-12-20 00:00:00', '2023-12-05 00:00:00', 10, 5, 4, 0, 'https://sallysbakingaddiction.com/wp-content/uploads/2021/02/french-macarons.jpg');

--
-- Triggers `product`
--
DELIMITER $$
CREATE TRIGGER `before_update_product` BEFORE UPDATE ON `product` FOR EACH ROW BEGIN
    -- Check if stock is below 10 after the update
    IF (NEW.product_stock) < 5 THEN
        -- You can add additional logic here, such as raising an error, logging, or taking some action
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Transaction failed, quantity exceeded ';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `product_archive`
--

CREATE TABLE `product_archive` (
  `archive_id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_price` decimal(10,2) DEFAULT NULL,
  `product_stock` int(11) DEFAULT NULL,
  `exp_date` date DEFAULT NULL,
  `man_date` date DEFAULT NULL,
  `Category_ID` int(11) DEFAULT NULL,
  `flavor_ID` int(11) DEFAULT NULL,
  `Supplier_ID` int(11) DEFAULT NULL,
  `archived_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_archive`
--

INSERT INTO `product_archive` (`archive_id`, `product_name`, `product_price`, `product_stock`, `exp_date`, `man_date`, `Category_ID`, `flavor_ID`, `Supplier_ID`, `archived_at`) VALUES
(1, 'biscuit', '25.00', 30, '2023-11-23', '2023-11-09', 5, 4, 3, '2023-11-17 15:00:36'),
(2, 'buscuit', '25.00', 30, '2023-11-30', '2023-11-22', 5, 8, 2, '2023-11-29 08:21:13');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sales_id` int(11) NOT NULL,
  `product_num` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `total` decimal(10,0) DEFAULT NULL,
  `sale_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sales_id`, `product_num`, `quantity`, `total`, `sale_date`) VALUES
(55, 4, 1, '55', '2023-10-23 21:25:53'),
(56, NULL, 1, '30', '2023-10-23 21:25:53'),
(57, NULL, 1, '80', '2023-10-23 21:25:53'),
(58, NULL, 1, '30', '2023-10-23 21:26:46'),
(59, 4, 2, '110', '2023-10-23 21:26:46'),
(60, NULL, 2, '60', '2023-10-23 22:09:27'),
(61, NULL, 4, '320', '2023-10-23 22:10:13'),
(62, NULL, 5, '150', '2023-10-24 00:11:48'),
(63, NULL, 10, '300', '2023-10-24 00:28:46'),
(64, NULL, 25, '750', '2023-10-24 00:29:17'),
(65, NULL, 2, '60', '2023-11-17 07:33:59'),
(67, NULL, 13, '390', '2023-11-17 07:46:10'),
(73, NULL, 4, '120', '2023-11-29 01:30:28'),
(78, 4, 1, '50', '2023-12-18 17:04:56'),
(79, 11, 1, '25', '2023-12-18 17:05:02'),
(80, NULL, 2, '10', '2023-12-14 16:00:00'),
(81, NULL, 3, '15', '2023-12-15 16:00:00'),
(82, NULL, 4, '20', '2023-12-16 16:00:00'),
(83, NULL, 5, '25', '2023-12-17 16:00:00'),
(84, NULL, 6, '30', '2023-12-18 16:00:00'),
(85, NULL, 7, '35', '2023-12-19 16:00:00'),
(86, NULL, 8, '40', '2023-12-20 16:00:00');

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
  ADD KEY `Supplier_ID` (`Supplier_ID`),
  ADD KEY `flavor_ID` (`flavor_ID`),
  ADD KEY `Category_ID` (`Category_ID`),
  ADD KEY `sales_id` (`sales_id`);

--
-- Indexes for table `product_archive`
--
ALTER TABLE `product_archive`
  ADD PRIMARY KEY (`archive_id`);

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
  MODIFY `Category_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `flavor`
--
ALTER TABLE `flavor`
  MODIFY `flavor_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_num` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `product_archive`
--
ALTER TABLE `product_archive`
  MODIFY `archive_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sales_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

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
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`Supplier_ID`) REFERENCES `supplier` (`Supplier_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`Category_ID`) REFERENCES `category` (`Category_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ibfk_3` FOREIGN KEY (`flavor_ID`) REFERENCES `flavor` (`flavor_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`product_num`) REFERENCES `product` (`product_num`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
