-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 04, 2023 at 01:22 PM
-- Server version: 5.7.36
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `auction`
--

-- --------------------------------------------------------

--
-- Table structure for table `auction`
--

DROP TABLE IF EXISTS `auction`;
CREATE TABLE IF NOT EXISTS `auction` (
  `auc_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `auc_name` varchar(255) NOT NULL,
  `auc_desc` text NOT NULL,
  `auc_price` varchar(255) NOT NULL,
  `auc_status` int(11) NOT NULL DEFAULT '0',
  `auc_end_date` varchar(255) NOT NULL,
  `added_by` int(11) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `del` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`auc_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auction`
--

INSERT INTO `auction` (`auc_id`, `item_id`, `auc_name`, `auc_desc`, `auc_price`, `auc_status`, `auc_end_date`, `added_by`, `added_date`, `del`) VALUES
(1, 1, 'auction test II', 'auction test I', '900000', 1, '2023-04-03', 1, '2023-04-01 22:49:01', 0),
(2, 2, 'auction test II', 'auction test I', '900000', 1, '2023-04-10', 1, '2023-04-01 22:49:01', 0);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) NOT NULL,
  `cat_desc` text NOT NULL,
  `cat_img` varchar(255) NOT NULL,
  `added_by` int(11) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `del` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `cat_name`, `cat_desc`, `cat_img`, `added_by`, `added_date`, `del`) VALUES
(4, 'Cars', 'Cars', 'clipart1846415.png', 1, '2023-04-01 17:24:48', 0),
(5, 'Electronics ', 'Electronics ', 'elect.png', 1, '2023-04-01 17:26:57', 0),
(6, 'test', 'test', 'elect.png', 1, '2023-04-01 17:36:53', 0);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `cus_id` int(11) NOT NULL AUTO_INCREMENT,
  `cus_login_name` varchar(255) NOT NULL,
  `cus_pass` varchar(255) NOT NULL,
  `cus_full_name` varchar(255) NOT NULL,
  `cus_phone` varchar(30) NOT NULL,
  `cus_id_number` varchar(255) NOT NULL,
  `del` int(11) NOT NULL DEFAULT '0',
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cus_id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`cus_id`, `cus_login_name`, `cus_pass`, `cus_full_name`, `cus_phone`, `cus_id_number`, `del`, `added_date`) VALUES
(26, 'salih', '202cb962ac59075b964b07152d234b70', 'Salih Osman', '097356151', '646763463', 0, '2023-01-26 12:38:54'),
(24, 'ahmed', '202cb962ac59075b964b07152d234b70', 'Ahmed Ali', '0982736212', '074547623443', 0, '2023-01-24 11:23:58'),
(27, 'test', '202cb962ac59075b964b07152d234b70', 'test', '093847831', '59689689', 1, '2023-03-09 11:20:10'),
(28, 'sami141', '202cb962ac59075b964b07152d234b70', 'moahmmed ahmed', '098373671', '02389', 0, '2023-04-02 12:57:13');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `item_desc` text NOT NULL,
  `item_img` varchar(255) NOT NULL,
  `item_status` int(11) NOT NULL DEFAULT '0',
  `added_by` int(11) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `del` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `item_name`, `cat_id`, `item_desc`, `item_img`, `item_status`, `added_by`, `added_date`, `del`) VALUES
(1, 'car test', 4, 'none', 'clipart1846415.png', 0, 1, '2023-04-01 18:15:44', 0),
(2, 'car test', 11, 'none', 'clipart1846415.png', 0, 1, '2023-04-01 18:15:44', 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `auc_id` int(11) NOT NULL,
  `cus_id` int(11) NOT NULL,
  `order_price` varchar(255) NOT NULL,
  `order_status` int(11) NOT NULL DEFAULT '0',
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `del` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `auc_id`, `cus_id`, `order_price`, `order_status`, `added_date`, `del`) VALUES
(2, 1, 28, '960000', 1, '2023-04-03 13:12:48', 0),
(3, 1, 28, '950000', 2, '2023-04-03 20:49:21', 0),
(4, 1, 28, '950000', 2, '2023-04-03 20:59:06', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `user_full_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` int(11) NOT NULL DEFAULT '0',
  `user_phone` varchar(255) NOT NULL,
  `added_by` int(11) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `del` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `user_full_name`, `password`, `user_type`, `user_phone`, `added_by`, `added_date`, `del`) VALUES
(1, 'admin', 'admin', '202cb962ac59075b964b07152d234b70', 0, '0387445', 1, '2023-04-01 11:42:00', 0),
(2, 'mohammed', 'mohammed ali', '202cb962ac59075b964b07152d234b70', 1, '09843784732', 1, '2023-04-01 15:01:32', 0),
(3, 'test', 'test', '098f6bcd4621d373cade4e832627b4f6', 1, '4968658', 1, '2023-04-01 15:21:17', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
