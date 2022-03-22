-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 18, 2022 at 02:02 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `whatstore`
--
CREATE DATABASE IF NOT EXISTS `whatstore` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `whatstore`;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `IDN` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(80) NOT NULL,
  PRIMARY KEY (`IDN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

DROP TABLE IF EXISTS `discounts`;
CREATE TABLE IF NOT EXISTS `discounts` (
  `code` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `operator` char(1) NOT NULL,
  `factor` double NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE IF NOT EXISTS `employees` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `nickname` varchar(80) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `employee_roles`
--

DROP TABLE IF EXISTS `employee_roles`;
CREATE TABLE IF NOT EXISTS `employee_roles` (
  `code` int(11) NOT NULL AUTO_INCREMENT,
  `code_role` int(11) NOT NULL,
  `ID_employee` int(11) NOT NULL,
  PRIMARY KEY (`code`),
  KEY `code_role` (`code_role`),
  KEY `ID_employee` (`ID_employee`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
CREATE TABLE IF NOT EXISTS `inventory` (
  `code_product` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `maximum` int(11) NOT NULL,
  `minimum` int(11) NOT NULL,
  `reserved` int(11) NOT NULL,
  KEY `code_product` (`code_product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `code_order` int(11) NOT NULL,
  `code_product` int(11) NOT NULL,
  `price` float NOT NULL,
  `amount` int(11) NOT NULL,
  PRIMARY KEY (`code_order`,`code_product`),
  KEY `code_product` (`code_product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `code` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `price` double NOT NULL,
  `code_discount` int(11) NOT NULL,
  PRIMARY KEY (`code`),
  KEY `code_discount` (`code_discount`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

DROP TABLE IF EXISTS `purchase_orders`;
CREATE TABLE IF NOT EXISTS `purchase_orders` (
  `code` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `status` smallint(6) NOT NULL,
  `IDN` int(11) NOT NULL,
  PRIMARY KEY (`code`),
  KEY `IDN` (`IDN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

DROP TABLE IF EXISTS `resources`;
CREATE TABLE IF NOT EXISTS `resources` (
  `code` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `method` varchar(80) NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `resources_role`
--

DROP TABLE IF EXISTS `resources_role`;
CREATE TABLE IF NOT EXISTS `resources_role` (
  `code` int(11) NOT NULL AUTO_INCREMENT,
  `code_role` int(11) NOT NULL,
  `code_resource` int(11) NOT NULL,
  PRIMARY KEY (`code`),
  KEY `code_role` (`code_role`),
  KEY `code_resource` (`code_resource`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `code` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `code` int(11) NOT NULL AUTO_INCREMENT,
  `code_product` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `date` date NOT NULL,
  `type` char(1) NOT NULL,
  PRIMARY KEY (`code`),
  KEY `code_product` (`code_product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employee_roles`
--
ALTER TABLE `employee_roles`
  ADD CONSTRAINT `employee_roles_ibfk_2` FOREIGN KEY (`code_role`) REFERENCES `roles` (`code`),
  ADD CONSTRAINT `employee_roles_ibfk_3` FOREIGN KEY (`ID_employee`) REFERENCES `employees` (`ID`);

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`code_product`) REFERENCES `products` (`code`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`code_product`) REFERENCES `products` (`code`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`code_order`) REFERENCES `purchase_orders` (`code`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`code_discount`) REFERENCES `discounts` (`code`);

--
-- Constraints for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD CONSTRAINT `purchase_orders_ibfk_1` FOREIGN KEY (`IDN`) REFERENCES `customers` (`IDN`);

--
-- Constraints for table `resources_role`
--
ALTER TABLE `resources_role`
  ADD CONSTRAINT `resources_role_ibfk_1` FOREIGN KEY (`code_role`) REFERENCES `roles` (`code`),
  ADD CONSTRAINT `resources_role_ibfk_2` FOREIGN KEY (`code_resource`) REFERENCES `resources` (`code`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`code_product`) REFERENCES `products` (`code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
