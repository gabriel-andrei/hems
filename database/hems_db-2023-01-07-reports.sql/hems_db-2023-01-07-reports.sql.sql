-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.19-log - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping structure for table hems_db.bank_list
CREATE TABLE IF NOT EXISTS `bank_list` (
  `id` varchar(50) NOT NULL DEFAULT '',
  `bank_name` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table hems_db.bank_list: ~4 rows (approximately)
INSERT INTO `bank_list` (`id`, `bank_name`) VALUES
	('BPI', 'BPI'),
	('METROBANK', 'Metrobank'),
	('PNB', 'Philippine National Bank'),
	('UB', 'Union Bank');

-- Dumping structure for table hems_db.clients_record
CREATE TABLE IF NOT EXISTS `clients_record` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `date_created` datetime NOT NULL,
  `trans_ref` int(11) DEFAULT NULL,
  `client_name` varchar(250) NOT NULL,
  `contact` varchar(250) NOT NULL,
  `email` text NOT NULL,
  `tin_number` text,
  `address` varchar(250) NOT NULL,
  `engine_model` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table hems_db.clients_record: ~2 rows (approximately)
INSERT INTO `clients_record` (`id`, `date_created`, `trans_ref`, `client_name`, `contact`, `email`, `tin_number`, `address`, `engine_model`) VALUES
	(13, '2023-01-06 22:25:35', 32, 'Gabriel Abarintos', '09873678266', 'gabriel@abarintos.com', '000-123-456-001', 'Calapan City, Ilaya', '4D32'),
	(14, '2023-01-07 00:29:53', 33, 'John Doe', '09613074699', 'john@doe.com', '000-123-456-002', 'Calapan City, Ibaba', '4D33');

-- Dumping structure for table hems_db.inventory_damaged
CREATE TABLE IF NOT EXISTS `inventory_damaged` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `inventory_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit` varchar(50) CHARACTER SET utf8mb4 DEFAULT '',
  `user_id` int(11) DEFAULT NULL,
  `date_encoded` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- Dumping data for table hems_db.inventory_damaged: 2 rows
/*!40000 ALTER TABLE `inventory_damaged` DISABLE KEYS */;
INSERT INTO `inventory_damaged` (`id`, `product_id`, `inventory_id`, `quantity`, `unit`, `user_id`, `date_encoded`) VALUES
	(1, 35, 35, 12, 'pcs', 1, '2023-01-05 20:42:34'),
	(2, 59, 36, 1, 'pcs', 1, '2023-01-05 20:58:51');
/*!40000 ALTER TABLE `inventory_damaged` ENABLE KEYS */;

-- Dumping structure for table hems_db.inventory_list
CREATE TABLE IF NOT EXISTS `inventory_list` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `product_id` int(30) NOT NULL,
  `quantity` int(30) NOT NULL DEFAULT '0',
  `unit` varchar(50) NOT NULL DEFAULT '',
  `stock_date` date NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table hems_db.inventory_list: ~35 rows (approximately)
INSERT INTO `inventory_list` (`id`, `product_id`, `quantity`, `unit`, `stock_date`, `date_created`, `date_updated`) VALUES
	(28, 51, 5, 'pcs', '2022-10-03', '2022-10-03 00:13:12', '2022-11-17 21:45:29'),
	(29, 50, 10, 'pcs', '2022-10-05', '2022-10-05 15:27:58', '2022-11-17 21:45:31'),
	(30, 51, 15, 'pcs', '2022-10-31', '2022-11-02 21:36:28', '2022-11-17 21:45:31'),
	(31, 33, 20, 'pcs', '2022-11-06', '2022-11-06 18:34:06', '2022-11-17 21:45:31'),
	(32, 32, 12, 'pcs', '2022-11-06', '2022-11-06 18:38:54', '2022-11-17 21:45:31'),
	(33, 35, 1, 'pcs', '2022-11-17', '2022-11-17 22:31:00', '2022-11-17 22:31:00'),
	(34, 51, 3, 'pcs', '2022-11-18', '2022-11-18 20:36:21', '2022-11-18 20:36:21'),
	(35, 35, 20, 'pcs', '2022-12-04', '2022-12-05 00:25:19', '2022-12-05 00:25:19'),
	(36, 59, 123, 'pcs', '2023-01-05', '2023-01-05 20:58:02', '2023-01-05 20:58:02'),
	(37, 58, 15, 'pcs', '2023-01-06', '2023-01-06 07:26:02', '2023-01-06 07:26:02'),
	(38, 36, 5, 'pcs', '2023-01-06', '2023-01-06 07:26:20', '2023-01-06 07:26:20'),
	(39, 28, 10, 'pcs', '2023-01-06', '2023-01-06 07:26:34', '2023-01-06 07:26:34'),
	(40, 43, 15, 'pcs', '2023-01-06', '2023-01-06 07:26:49', '2023-01-06 07:26:49'),
	(41, 55, 25, 'pcs', '2023-01-06', '2023-01-06 07:27:01', '2023-01-06 07:27:01'),
	(42, 34, 60, 'pcs', '0000-00-00', '2023-01-06 07:27:10', '2023-01-06 07:27:10'),
	(43, 56, 15, 'pcs', '2023-01-06', '2023-01-06 07:27:50', '2023-01-06 07:27:50'),
	(44, 44, 50, 'pcs', '2023-01-06', '2023-01-06 07:28:20', '2023-01-06 07:28:20'),
	(45, 54, 70, 'pcs', '2023-01-06', '2023-01-06 07:28:45', '2023-01-06 07:28:45'),
	(46, 57, 80, 'pcs', '2023-01-06', '2023-01-06 07:28:54', '2023-01-06 07:28:54'),
	(47, 53, 60, 'pcs', '2023-01-06', '2023-01-06 07:29:02', '2023-01-06 07:29:02'),
	(48, 45, 50, 'pcs', '2023-01-06', '2023-01-06 07:29:11', '2023-01-06 07:29:11'),
	(49, 27, 70, 'pcs', '2023-01-06', '2023-01-06 07:29:21', '2023-01-06 07:29:21'),
	(50, 42, 47, 'pcs', '2023-01-06', '2023-01-06 07:29:29', '2023-01-06 07:29:29'),
	(51, 52, 36, 'pcs', '2023-01-06', '2023-01-06 07:29:37', '2023-01-06 07:29:37'),
	(52, 26, 26, 'pcs', '2023-01-06', '2023-01-06 07:29:45', '2023-01-06 07:29:45'),
	(53, 30, 69, 'pcs', '2023-01-06', '2023-01-06 07:29:53', '2023-01-06 07:29:53'),
	(54, 46, 58, 'pcs', '2023-01-06', '2023-01-06 07:30:00', '2023-01-06 07:30:00'),
	(55, 47, 89, 'pcs', '2023-01-06', '2023-01-06 07:30:08', '2023-01-06 07:30:08'),
	(56, 31, 65, 'pcs', '0000-00-00', '2023-01-06 07:30:16', '2023-01-06 07:30:16'),
	(57, 49, 36, 'pcs', '2023-01-06', '2023-01-06 07:30:24', '2023-01-06 07:30:24'),
	(58, 48, 26, 'pcs', '2023-01-06', '2023-01-06 07:30:33', '2023-01-06 07:30:33'),
	(59, 60, 36, 'pcs', '2023-01-06', '2023-01-06 07:30:42', '2023-01-06 07:30:42'),
	(60, 37, 70, 'pcs', '2023-01-06', '2023-01-06 07:30:54', '2023-01-06 07:30:54'),
	(61, 41, 25, 'pcs', '2023-01-06', '2023-01-06 07:31:01', '2023-01-06 07:31:01'),
	(62, 40, 74, 'pcs', '2023-01-06', '2023-01-06 07:31:11', '2023-01-06 07:31:11');

-- Dumping structure for table hems_db.mechanic_list
CREATE TABLE IF NOT EXISTS `mechanic_list` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(250) NOT NULL,
  `middlename` text,
  `lastname` varchar(250) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table hems_db.mechanic_list: ~22 rows (approximately)
INSERT INTO `mechanic_list` (`id`, `firstname`, `middlename`, `lastname`, `status`, `delete_flag`, `date_added`, `date_updated`) VALUES
	(3, 'Alexis', '', 'Del Mundo', 1, 0, '2022-09-30 23:48:09', '2022-09-30 23:48:09'),
	(4, 'Alfie', '', 'Del Mundo', 1, 0, '2022-09-30 23:48:25', '2022-09-30 23:48:25'),
	(5, 'Joseph', '', 'Ribon', 1, 0, '2022-09-30 23:48:42', '2022-09-30 23:48:42'),
	(6, 'Arnel', '', 'Malaluan', 1, 0, '2022-09-30 23:48:58', '2022-09-30 23:48:58'),
	(7, 'Joey', '', ' Marasigan', 1, 0, '2022-09-30 23:49:16', '2022-09-30 23:49:16'),
	(8, 'Jeztrill', '', 'Tumamak', 1, 0, '2022-09-30 23:49:32', '2022-09-30 23:49:32'),
	(9, 'Aljon', '', 'Del Mundo', 1, 0, '2022-09-30 23:49:49', '2022-09-30 23:49:49'),
	(10, 'Ruperto ', '', 'Baliton', 1, 0, '2022-09-30 23:50:10', '2022-09-30 23:50:10'),
	(11, 'John Patrick', '', 'Hatulan', 1, 0, '2022-09-30 23:50:27', '2022-09-30 23:50:27'),
	(12, 'Edbert ', '', 'Hatulan', 1, 0, '2022-09-30 23:50:44', '2022-09-30 23:50:44'),
	(13, 'Jerry', '', 'Albo', 1, 0, '2022-09-30 23:50:55', '2022-09-30 23:50:55'),
	(14, 'Michael', '', 'Mores', 1, 0, '2022-09-30 23:51:05', '2022-09-30 23:51:05'),
	(15, 'Jerry', '', 'Roles', 1, 0, '2022-09-30 23:51:15', '2022-09-30 23:51:15'),
	(16, 'Royland', '', 'Malaluan', 1, 0, '2022-09-30 23:51:27', '2022-09-30 23:51:27'),
	(17, 'Allan', '', 'Garma', 1, 0, '2022-09-30 23:51:35', '2022-09-30 23:51:35'),
	(18, 'Jojimar', '', 'Robles', 1, 0, '2022-09-30 23:51:46', '2022-09-30 23:51:46'),
	(19, 'Christian', '', 'Ninal', 1, 0, '2022-09-30 23:51:59', '2022-09-30 23:51:59'),
	(20, 'Ronal', '', 'Lualhati', 1, 0, '2022-09-30 23:52:15', '2022-09-30 23:52:15'),
	(21, 'Jerome', '', 'Cleofe', 1, 0, '2022-09-30 23:52:25', '2022-09-30 23:52:25'),
	(22, 'Henry', '', 'Patulot', 1, 0, '2022-09-30 23:52:41', '2022-09-30 23:52:41'),
	(23, 'Ronald', '', 'Gozar', 1, 0, '2022-09-30 23:52:57', '2022-09-30 23:52:57'),
	(24, 'John ', '', 'Well', 1, 1, '2023-01-07 00:36:04', '2023-01-07 00:36:19');

-- Dumping structure for table hems_db.payment_list
CREATE TABLE IF NOT EXISTS `payment_list` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `transaction_id` int(11) NOT NULL DEFAULT '0',
  `ornumber` varchar(250) DEFAULT NULL,
  `payment_type` varchar(250) DEFAULT NULL,
  `payment_method` varchar(250) DEFAULT NULL,
  `bank_id` varchar(250) DEFAULT NULL,
  `cheque_number` varchar(250) DEFAULT NULL,
  `client_name` varchar(250) DEFAULT NULL,
  `balance` float(15,2) DEFAULT NULL,
  `total_amount` float(15,2) DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1' COMMENT '1 active; 0 cancelled',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table hems_db.payment_list: ~1 rows (approximately)
INSERT INTO `payment_list` (`id`, `date_created`, `transaction_id`, `ornumber`, `payment_type`, `payment_method`, `bank_id`, `cheque_number`, `client_name`, `balance`, `total_amount`, `status`) VALUES
	(21, '2023-01-06 23:39:04', 32, '', 'Full Payment', 'Cash on hand', NULL, '', 'Gabriel Abarintos', 0.00, 7650.00, 1),
	(22, '2023-01-07 23:06:05', 33, '1234', 'Full Payment', 'Cash on hand', NULL, '', 'John Doe', 0.00, 7400.00, 1);

-- Dumping structure for table hems_db.product_list
CREATE TABLE IF NOT EXISTS `product_list` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `engine_model` varchar(250) NOT NULL,
  `description` text,
  `price` float(15,2) NOT NULL DEFAULT '0.00',
  `base_price` float(15,2) DEFAULT '0.00',
  `percentage` float(15,2) DEFAULT '0.00',
  `unit` varchar(50) NOT NULL DEFAULT '0.00',
  `lowstock` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table hems_db.product_list: ~35 rows (approximately)
INSERT INTO `product_list` (`id`, `name`, `engine_model`, `description`, `price`, `base_price`, `percentage`, `unit`, `lowstock`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
	(26, 'Overhauling Gasket', '4D56', '', 1900.00, 0.00, 0.00, 'pcs', 0, 1, 0, '2022-10-02 23:18:03', '2022-11-17 21:46:08'),
	(27, 'Main Bearing', '4D56', '', 1500.00, 0.00, 0.00, 'pcs', 0, 1, 0, '2022-10-02 23:18:35', '2022-11-17 21:46:08'),
	(28, 'Conn Bearing	', '4D56', '', 850.00, 0.00, 0.00, 'pcs', 0, 1, 0, '2022-10-02 23:19:11', '2022-11-17 21:46:08'),
	(29, 'Trust Washer', '4D32', '', 232.00, 200.00, 16.00, 'pcs', 0, 1, 0, '2022-10-02 23:19:29', '2023-01-07 22:13:53'),
	(30, 'Piston Assembly	', '4D56', '', 4500.00, 0.00, 0.00, 'pcs', 0, 1, 0, '2022-10-02 23:19:51', '2022-11-17 21:46:08'),
	(31, 'Piston Ring ', '4D56', '', 1800.00, 0.00, 0.00, 'pcs', 0, 1, 0, '2022-10-02 23:20:16', '2022-11-17 21:46:08'),
	(32, 'Oil Filter	', '4D56', '', 450.00, 0.00, 0.00, 'pcs', 0, 1, 0, '2022-10-02 23:23:06', '2022-11-17 21:46:08'),
	(33, 'Heater Plug', '4D56', '', 300.00, 0.00, 0.00, 'pcs', 0, 1, 0, '2022-10-02 23:23:27', '2022-11-17 21:46:08'),
	(34, 'Fuel Filter', '4D56', '', 850.00, 0.00, 0.00, 'pcs', 0, 1, 0, '2022-10-02 23:23:40', '2022-11-17 21:46:08'),
	(35, 'Clutch Disc ', '4D56', '', 1600.00, 0.00, 0.00, 'pcs', 0, 1, 0, '2022-10-02 23:26:45', '2022-11-17 21:46:08'),
	(36, 'Con Rod Arm	', '4D32', '', 850.00, 700.00, 0.00, 'pcs', 1, 1, 0, '2022-10-02 23:27:03', '2023-01-05 20:00:44'),
	(37, 'Pressure Plate	', '4D56', '', 1700.00, 0.00, 0.00, 'pcs', 0, 1, 0, '2022-10-02 23:27:25', '2022-11-17 21:46:08'),
	(38, 'Timing Belt 	', '4D56', '', 1500.00, 0.00, 0.00, 'pcs', 0, 1, 0, '2022-10-02 23:27:42', '2022-11-17 21:46:08'),
	(39, 'Tensioner B', '4D56', '', 1600.00, 0.00, 0.00, 'pcs', 0, 1, 0, '2022-10-02 23:27:58', '2022-11-17 21:46:08'),
	(40, 'Tensioner S', '4D56', '', 750.00, 0.00, 0.00, 'pcs', 0, 1, 0, '2022-10-02 23:28:13', '2022-11-17 21:46:08'),
	(41, 'Rocker Arm Shaft', '4D56', '', 1600.00, 0.00, 0.00, 'pcs', 0, 1, 0, '2022-10-02 23:28:31', '2022-11-17 21:46:08'),
	(42, 'Main Bearing', '4D33', '', 1800.00, 0.00, 0.00, 'pcs', 0, 1, 0, '2022-10-02 23:30:10', '2022-11-17 21:46:08'),
	(43, 'Conn Bearing ', '4D33', '', 2100.00, 0.00, 0.00, 'pcs', 0, 1, 0, '2022-10-02 23:30:41', '2022-11-17 21:46:08'),
	(44, 'Trust Washer ', '4D33', '', 600.00, 0.00, 0.00, 'pcs', 0, 1, 0, '2022-10-02 23:31:04', '2023-01-06 07:35:22'),
	(45, 'Liner', '4D33', '', 6000.00, 0.00, 0.00, 'pcs', 0, 1, 0, '2022-10-02 23:31:50', '2022-11-17 21:46:08'),
	(46, 'Piston Assembly	', '4D33', '', 6500.00, 0.00, 0.00, 'pcs', 0, 1, 0, '2022-10-02 23:32:26', '2022-11-17 21:46:08'),
	(47, 'Piston Pin', '4D33', '', 375.00, 0.00, 0.00, 'pcs', 0, 1, 0, '2022-10-02 23:32:42', '2022-11-17 21:46:08'),
	(48, 'PistonPin Bushing ', '4D33', '', 1600.00, 0.00, 0.00, 'pcs', 0, 1, 0, '2022-10-02 23:33:02', '2022-11-17 21:46:08'),
	(49, 'Piston Ring', '4D33', '', 2900.00, 0.00, 0.00, 'pcs', 0, 1, 0, '2022-10-02 23:33:42', '2022-11-17 21:46:08'),
	(50, 'Camshaft Bushing ', '4D32', 'std', 4500.00, 0.00, 0.00, 'pcs', 12, 1, 0, '2022-10-02 23:34:44', '2022-11-17 22:15:29'),
	(51, 'Balancer Bushing', '4D32', '', 270.00, 0.00, 0.00, 'pcs', 0, 1, 0, '2022-10-02 23:35:57', '2022-11-18 14:11:47'),
	(52, 'Oil Filter ', '4D32', '', 3500.00, 0.00, 0.00, 'pcs', 0, 1, 0, '2022-10-02 23:36:16', '2022-11-17 21:46:08'),
	(53, 'Heater Plug', '4D33', '', 3800.00, 0.00, 0.00, 'pcs', 0, 1, 0, '2022-10-02 23:38:41', '2022-11-17 21:46:08'),
	(54, 'Fuel Filter', '4D32', '', 170.00, 150.00, 0.00, 'pcs', 0, 1, 0, '2022-10-02 23:39:39', '2023-01-06 07:28:34'),
	(55, 'Engine Valve	', '4D33', '', 3800.00, 0.00, 0.00, 'pcs', 0, 1, 0, '2022-10-02 23:40:08', '2022-11-17 21:46:08'),
	(56, 'Valve Guide 	', '4D33', '', 750.00, 0.00, 0.00, 'pcs', 0, 1, 0, '2022-10-02 23:40:32', '2022-11-17 21:46:08'),
	(57, 'Head Gasket', '4D33', '', 950.00, 0.00, 0.00, 'pcs', 0, 1, 0, '2022-10-02 23:41:16', '2022-11-17 21:46:08'),
	(58, 'Valve Seal', '4D33', '', 650.00, 0.00, 0.00, 'pcs', 0, 1, 0, '2022-10-02 23:41:46', '2022-11-17 21:46:08'),
	(59, 'Clutch Disc', '4D33', '', 2600.00, 0.00, 0.00, 'pcs', 0, 1, 0, '2022-10-02 23:42:07', '2022-11-17 21:46:08'),
	(60, 'Pressure Plate', '4D33', '', 0.00, 0.00, 0.00, 'pcs', 0, 1, 0, '2022-10-02 23:42:26', '2022-11-17 21:46:08');

-- Dumping structure for table hems_db.service_list
CREATE TABLE IF NOT EXISTS `service_list` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `service` varchar(250) NOT NULL,
  `service_sub` varchar(250) NOT NULL,
  `cylinder` varchar(250) NOT NULL,
  `description` text,
  `price` float(15,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=268 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table hems_db.service_list: ~253 rows (approximately)
INSERT INTO `service_list` (`id`, `service`, `service_sub`, `cylinder`, `description`, `price`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
	(9, 'Cylinder Head', 'Valve Seat Ring Insert', '1 Cylinder', '', 500.00, 1, 0, '2022-09-29 23:53:14', '2022-11-09 21:16:01'),
	(16, 'Engine Block', 'Rebore', '1 Cylinder', '', 1000.00, 1, 0, '2022-09-29 23:57:45', '2022-09-29 23:57:45'),
	(17, 'Cylinder Head', 'Valve Seat Ring Insert', '1 Cylinder', '', 500.00, 1, 0, '2022-09-30 21:21:39', '2022-09-30 21:21:39'),
	(18, 'Cylinder Head', 'Valve Seat Replace/ Lapping', '1 Cylinder', '', 300.00, 1, 0, '2022-09-30 21:22:08', '2022-09-30 21:22:08'),
	(19, 'Cylinder Head', 'Valve Guide Replace', '1 Cylinder', '', 300.00, 1, 0, '2022-09-30 21:22:49', '2022-09-30 21:22:49'),
	(20, 'Cylinder Head', 'Resurface', '1 Cylinder', '', 600.00, 1, 0, '2022-09-30 21:23:05', '2022-09-30 21:23:05'),
	(21, 'Cylinder Head', 'Valve Reface', '1 Cylinder', '', 300.00, 1, 0, '2022-09-30 21:23:49', '2022-09-30 21:29:49'),
	(22, 'Cylinder Head', 'Cold Welding', '1 Cylinder', '', 250.00, 1, 0, '2022-09-30 21:24:07', '2022-09-30 21:24:07'),
	(23, 'Cylinder Head', 'Hydrotest', '1 Cylinder', '', 500.00, 1, 0, '2022-09-30 21:24:26', '2022-09-30 21:24:26'),
	(24, 'Cylinder Head', 'Tappet Clearance Setting and Assembling', '1 Cylinder', '', 300.00, 1, 0, '2022-09-30 21:24:59', '2022-09-30 21:24:59'),
	(25, 'Cylinder Head', 'Line Boring of Camshaft Housing', '1 Cylinder', '', 1000.00, 1, 0, '2022-09-30 21:25:42', '2022-09-30 21:25:42'),
	(26, 'Cylinder Head', 'Valve Seat Ring Insert', '2 Cylinder', '', 800.00, 1, 0, '2022-09-30 21:26:21', '2022-09-30 21:26:21'),
	(27, 'Cylinder Head', 'Valve Seat Replace/ Lapping', '2 Cylinder', '', 400.00, 1, 0, '2022-09-30 21:27:04', '2022-09-30 21:27:04'),
	(28, 'Cylinder Head', 'Valve Guide Replace', '2 Cylinder', '', 600.00, 1, 0, '2022-09-30 21:27:30', '2022-09-30 21:27:30'),
	(29, 'Cylinder Head', 'Resurface', '2 Cylinder', '', 750.00, 1, 0, '2022-09-30 21:28:02', '2022-09-30 21:28:02'),
	(30, 'Cylinder Head', 'Valve Reface', '2 Cylinder', '', 600.00, 1, 0, '2022-09-30 21:28:34', '2022-09-30 21:28:34'),
	(31, 'Cylinder Head', 'Cold Welding', '2 Cylinder', '', 250.00, 1, 0, '2022-09-30 21:30:34', '2022-09-30 21:30:34'),
	(32, 'Cylinder Head', 'Hydrotest', '2 Cylinder', '', 750.00, 1, 0, '2022-09-30 21:31:00', '2022-09-30 21:31:00'),
	(33, 'Cylinder Head', 'Tappet Clearance Setting and Assembling', '2 Cylinder', '', 600.00, 1, 0, '2022-09-30 21:31:25', '2022-09-30 21:31:25'),
	(34, 'Cylinder Head', 'Line Boring of Camshaft Housing', '2 Cylinder', '', 1500.00, 1, 0, '2022-09-30 21:31:50', '2022-09-30 21:31:50'),
	(35, 'Cylinder Head', 'Valve Seat Ring Insert', '3 Cylinder', '', 1500.00, 1, 0, '2022-09-30 21:32:13', '2022-09-30 21:32:13'),
	(36, 'Cylinder Head', 'Valve Seat Replace/ Lapping', '3 Cylinder', '', 1200.00, 1, 0, '2022-09-30 21:32:29', '2022-11-06 16:36:49'),
	(37, 'Cylinder Head', 'Valve Guide Replace', '3 Cylinder', '', 1000.00, 1, 0, '2022-09-30 21:34:48', '2022-09-30 21:34:48'),
	(38, 'Cylinder Head', 'Resurface', '3 Cylinder', '', 1000.00, 1, 0, '2022-09-30 21:35:19', '2022-09-30 21:35:19'),
	(39, 'Cylinder Head', 'Valve Reface', '3 Cylinder', '', 900.00, 1, 0, '2022-09-30 21:35:45', '2022-09-30 21:35:45'),
	(40, 'Cylinder Head', 'Cold Welding', '3 Cylinder', '', 250.00, 1, 0, '2022-09-30 21:37:05', '2022-11-06 16:36:49'),
	(41, 'Cylinder Head', 'Hydrotest', '3 Cylinder', '', 1000.00, 1, 0, '2022-09-30 21:37:43', '2022-09-30 21:37:43'),
	(42, 'Cylinder Head', 'Tappet Clearance Setting and Assembling', '3 Cylinder', '', 900.00, 1, 0, '2022-09-30 21:38:07', '2022-09-30 21:38:07'),
	(43, 'Cylinder Head', 'Line Boring of Camshaft Housing', '3 Cylinder', '', 2000.00, 1, 0, '2022-09-30 21:38:34', '2022-09-30 21:38:34'),
	(44, 'Cylinder Head', 'Valve Seat Ring Insert', '4 Small', '', 2000.00, 1, 0, '2022-09-30 21:39:00', '2022-09-30 21:39:00'),
	(45, 'Cylinder Head', 'Valve Seat Replace/ Lapping', '4 Small', '', 800.00, 1, 0, '2022-09-30 21:39:50', '2022-09-30 21:39:50'),
	(46, 'Cylinder Head', 'Valve Guide Replace', '4 Small', '', 800.00, 1, 0, '2022-09-30 21:40:14', '2022-09-30 21:40:14'),
	(47, 'Cylinder Head', 'Resurface', '4 Small', '', 1500.00, 1, 0, '2022-09-30 21:41:05', '2022-09-30 21:41:05'),
	(48, 'Cylinder Head', 'Valve Reface', '4 Small', '', 1200.00, 1, 0, '2022-09-30 21:41:29', '2022-09-30 21:41:29'),
	(49, 'Cylinder Head', 'Cold Welding', '4 Small', '', 350.00, 1, 0, '2022-09-30 21:41:45', '2022-09-30 21:41:45'),
	(50, 'Cylinder Head', 'Hydrotest', '4 Small', '', 1200.00, 1, 0, '2022-09-30 21:42:03', '2022-09-30 21:42:03'),
	(51, 'Cylinder Head', 'Tappet Clearance Setting and Assembling', '4 Small', '', 1500.00, 1, 0, '2022-09-30 21:42:43', '2022-09-30 21:42:43'),
	(52, 'Cylinder Head', 'Line Boring of Camshaft Housing', '4 Small', '', 2500.00, 1, 0, '2022-09-30 21:42:59', '2022-09-30 21:42:59'),
	(53, 'Cylinder Head', 'Valve Seat Ring Insert', '4 Big', '', 2400.00, 1, 0, '2022-09-30 21:43:48', '2022-09-30 21:43:48'),
	(54, 'Cylinder Head', 'Valve Seat Replace/ Lapping', '4 Big', '', 800.00, 1, 0, '2022-09-30 21:44:05', '2022-09-30 21:44:05'),
	(55, 'Cylinder Head', 'Valve Guide Replace', '4 Big', '', 1200.00, 1, 0, '2022-09-30 21:44:24', '2022-09-30 21:44:24'),
	(56, 'Cylinder Head', 'Resurface', '4 Big', '', 1800.00, 1, 0, '2022-09-30 21:46:02', '2022-09-30 21:46:02'),
	(57, 'Cylinder Head', 'Valve Reface', '4 Big', '', 1500.00, 1, 0, '2022-09-30 21:46:29', '2022-09-30 21:46:29'),
	(58, 'Cylinder Head', 'Cold Welding', '4 Big', '', 350.00, 1, 0, '2022-09-30 21:46:51', '2022-09-30 21:46:51'),
	(59, 'Cylinder Head', 'Hydrotest', '4 Big', '', 1500.00, 1, 0, '2022-09-30 21:47:21', '2022-09-30 21:47:21'),
	(60, 'Cylinder Head', 'Tappet Clearance Setting and Assembling', '4 Big', '', 1500.00, 1, 0, '2022-09-30 21:47:49', '2022-09-30 21:47:49'),
	(61, 'Cylinder Head', 'Line Boring of Camshaft Housing', '4 Big', '', 3500.00, 1, 0, '2022-09-30 21:48:05', '2022-09-30 21:48:05'),
	(62, 'Cylinder Head', 'Valve Seat Ring Insert', '6 Cylinder', '', 4200.00, 1, 0, '2022-09-30 21:48:30', '2022-09-30 21:48:30'),
	(63, 'Cylinder Head', 'Valve Seat Replace/ Lapping', '6 Cylinder', '', 1800.00, 1, 0, '2022-09-30 21:48:51', '2022-09-30 21:48:51'),
	(64, 'Cylinder Head', 'Valve Guide Replace', '6 Cylinder', '', 2400.00, 1, 0, '2022-09-30 21:49:06', '2022-11-06 16:36:49'),
	(65, 'Cylinder Head', 'Resurface', '6 Cylinder', '', 2500.00, 1, 0, '2022-09-30 21:49:22', '2022-09-30 21:49:22'),
	(66, 'Cylinder Head', 'Valve Reface', '6 Cylinder', '', 1800.00, 1, 0, '2022-09-30 21:49:45', '2022-09-30 21:49:45'),
	(67, 'Cylinder Head', 'Cold Welding', '6 Cylinder', '', 450.00, 1, 0, '2022-09-30 21:50:04', '2022-09-30 21:50:04'),
	(68, 'Cylinder Head', 'Hydrotest', '6 Cylinder', '', 2500.00, 1, 0, '2022-09-30 21:50:34', '2022-09-30 21:50:34'),
	(69, 'Cylinder Head', 'Tappet Clearance Setting and Assembling', '6 Cylinder', '', 4500.00, 1, 0, '2022-09-30 21:50:53', '2022-09-30 21:50:53'),
	(70, 'Cylinder Head', 'Line Boring of Camshaft Housing', '6 Cylinder', '', 5000.00, 1, 0, '2022-09-30 21:51:14', '2022-09-30 21:51:14'),
	(71, 'Cylinder Head', 'Valve Seat Ring Insert', 'Heavy', 'Per Valve', 450.00, 1, 0, '2022-09-30 21:52:06', '2022-09-30 21:52:06'),
	(72, 'Cylinder Head', 'Valve Seat Replace/ Lapping', 'Heavy', 'Per Valve', 200.00, 1, 0, '2022-09-30 21:53:19', '2022-09-30 21:53:19'),
	(73, 'Cylinder Head', 'Valve Guide Replace', 'Heavy', 'Per Valve', 300.00, 1, 0, '2022-09-30 21:53:52', '2022-09-30 21:53:52'),
	(74, 'Cylinder Head', 'Resurface', 'Heavy', '', 3500.00, 1, 0, '2022-09-30 21:54:54', '2022-09-30 21:57:07'),
	(75, 'Cylinder Head', 'Valve Reface', 'Heavy', '', 300.00, 1, 0, '2022-09-30 21:55:16', '2022-09-30 21:58:15'),
	(76, 'Cylinder Head', 'Cold Welding', 'Heavy', '', 600.00, 1, 0, '2022-09-30 21:55:50', '2022-09-30 21:55:50'),
	(77, 'Cylinder Head', 'Hydrotest', 'Heavy', '', 2500.00, 1, 0, '2022-09-30 21:59:19', '2022-09-30 21:59:19'),
	(78, 'Cylinder Head', 'Tappet Clearance Setting and Assembling', 'Heavy', '', 6000.00, 1, 0, '2022-09-30 21:59:59', '2022-09-30 21:59:59'),
	(79, 'Cylinder Head', 'Line Boring of Camshaft Housing', 'Heavy', '', 6500.00, 1, 0, '2022-09-30 22:00:19', '2022-09-30 22:00:19'),
	(80, 'Engine Block', 'Rebore', '1 Cylinder', '', 1000.00, 1, 0, '2022-09-30 22:00:56', '2022-09-30 22:00:56'),
	(81, 'Engine Block', 'Sleeve Rebore', '1 Cylinder', '', 1500.00, 1, 0, '2022-09-30 22:01:23', '2022-09-30 22:01:23'),
	(82, 'Engine Block', 'Counterbore', '1 Cylinder', '', 850.00, 1, 0, '2022-09-30 22:02:01', '2022-09-30 22:02:01'),
	(83, 'Engine Block', 'Liner Replace', '1 Cylinder', '', 600.00, 1, 0, '2022-09-30 22:02:27', '2022-09-30 22:02:27'),
	(84, 'Engine Block', 'Block Reface', '1 Cylinder', '', 6000.00, 1, 0, '2022-09-30 22:05:03', '2022-09-30 22:05:03'),
	(85, 'Engine Block', 'Camshaft Bushing Replace', '1 Cylinder', '', 500.00, 1, 0, '2022-09-30 22:07:50', '2022-09-30 22:07:50'),
	(86, 'Engine Block', 'Line Boring of Main Housing', '1 Cylinder', '', 2500.00, 1, 0, '2022-09-30 22:08:17', '2022-09-30 22:08:17'),
	(87, 'Engine Block', 'Build up of Main Saddle', '1 Cylinder', '', 1000.00, 1, 0, '2022-09-30 22:08:45', '2022-09-30 22:08:45'),
	(88, 'Engine Block', 'Build of Trust Side', '1 Cylinder', '', 500.00, 1, 0, '2022-09-30 22:09:15', '2022-09-30 22:09:15'),
	(89, 'Engine Block', 'Washing', '1 Cylinder', '', 250.00, 1, 0, '2022-09-30 22:09:36', '2022-09-30 22:09:36'),
	(90, 'Engine Block', 'Rebore', '2 Cylinder', '', 2000.00, 1, 0, '2022-09-30 22:10:18', '2022-09-30 22:10:18'),
	(91, 'Engine Block', 'Sleeve Rebore', '2 Cylinder', '', 2500.00, 1, 0, '2022-09-30 22:10:43', '2022-09-30 22:10:43'),
	(92, 'Engine Block', 'Counterbore', '2 Cylinder', '', 850.00, 1, 0, '2022-09-30 22:11:29', '2022-09-30 22:11:29'),
	(93, 'Engine Block', 'Liner Replace', '2 Cylinder', '', 900.00, 1, 0, '2022-09-30 22:12:24', '2022-09-30 22:23:07'),
	(94, 'Engine Block', 'Block Reface', '2 Cylinder', '', 1500.00, 1, 0, '2022-09-30 22:13:01', '2022-09-30 22:13:01'),
	(95, 'Engine Block', 'Camshaft Bushing Replace', '2 Cylinder', '', 650.00, 1, 0, '2022-09-30 22:13:59', '2022-09-30 22:13:59'),
	(96, 'Engine Block', 'Line Boring of Main Housing', '2 Cylinder', '', 3500.00, 1, 0, '2022-09-30 22:14:37', '2022-09-30 22:14:37'),
	(97, 'Engine Block', 'Build up of Main Saddle', '2 Cylinder', '', 3500.00, 1, 0, '2022-09-30 22:15:35', '2022-09-30 22:23:24'),
	(98, 'Engine Block', 'Build of Trust Side', '2 Cylinder', '', 1500.00, 1, 0, '2022-09-30 22:16:01', '2022-09-30 22:16:01'),
	(99, 'Engine Block', 'Washing', '2 Cylinder', '', 250.00, 1, 0, '2022-09-30 22:16:37', '2022-09-30 22:16:37'),
	(100, 'Engine Block', 'Rebore', '3 Cylinder', '', 3500.00, 1, 0, '2022-09-30 22:18:44', '2022-09-30 22:18:44'),
	(101, 'Engine Block', 'Sleeve Rebore', '3 Cylinder', '', 3500.00, 1, 0, '2022-09-30 22:19:08', '2022-09-30 22:19:08'),
	(102, 'Engine Block', 'Counterbore', '3 Cylinder', '', 1000.00, 1, 0, '2022-09-30 22:19:28', '2022-09-30 22:19:28'),
	(103, 'Engine Block', 'Liner Replace', '3 Cylinder', '', 1200.00, 1, 0, '2022-09-30 22:19:50', '2022-09-30 22:19:50'),
	(104, 'Engine Block', 'Block Reface', '3 Cylinder', '', 2000.00, 1, 0, '2022-09-30 22:20:40', '2022-09-30 22:20:40'),
	(105, 'Engine Block', 'Camshaft Bushing Replace', '3 Cylinder', '', 800.00, 1, 0, '2022-09-30 22:21:02', '2022-09-30 22:21:02'),
	(106, 'Engine Block', 'Build up of Main Saddle', '3 Cylinder', '', 1500.00, 1, 0, '2022-09-30 22:24:02', '2022-09-30 22:24:02'),
	(107, 'Engine Block', 'Build of Trust Side', '3 Cylinder', '', 650.00, 1, 0, '2022-09-30 22:24:29', '2022-09-30 22:24:29'),
	(108, 'Engine Block', 'Washing', '3 Cylinder', '', 250.00, 1, 0, '2022-09-30 22:24:53', '2022-09-30 22:24:53'),
	(109, 'Engine Block', 'Rebore', '4 Small', '', 4000.00, 1, 0, '2022-09-30 22:25:24', '2022-09-30 22:25:24'),
	(110, 'Engine Block', 'Sleeve Rebore', '4 Small', '', 4500.00, 1, 0, '2022-09-30 22:25:47', '2022-09-30 22:25:47'),
	(111, 'Engine Block', 'Counterbore', '4 Small', '', 1200.00, 1, 0, '2022-09-30 22:26:05', '2022-09-30 22:29:21'),
	(112, 'Engine Block', 'Liner Replace', '4 Small', '', 1500.00, 1, 0, '2022-09-30 22:26:24', '2022-09-30 22:26:24'),
	(113, 'Engine Block', 'Block Reface', '4 Small', '', 2500.00, 1, 0, '2022-09-30 22:26:54', '2022-09-30 22:26:54'),
	(114, 'Engine Block', 'Camshaft Bushing Replace', '4 Small', '', 900.00, 1, 0, '2022-09-30 22:30:19', '2022-09-30 22:30:19'),
	(115, 'Engine Block', 'Line Boring of Main Housing', '4 Small', '', 4500.00, 1, 0, '2022-09-30 22:30:59', '2022-09-30 22:30:59'),
	(116, 'Engine Block', 'Build up of Main Saddle', '4 Small', 'Per Journal', 1500.00, 1, 0, '2022-09-30 22:31:25', '2022-09-30 22:31:25'),
	(117, 'Engine Block', 'Build of Trust Side', '4 Small', '', 650.00, 1, 0, '2022-09-30 22:31:59', '2022-09-30 22:31:59'),
	(118, 'Engine Block', 'Washing', '4 Small', '', 300.00, 1, 0, '2022-09-30 22:32:25', '2022-09-30 22:32:25'),
	(119, 'Engine Block', 'Rebore', '4 Big', '', 4500.00, 1, 0, '2022-09-30 22:34:06', '2022-09-30 22:34:06'),
	(120, 'Engine Block', 'Sleeve Rebore', '4 Big', '', 5000.00, 1, 0, '2022-09-30 22:34:25', '2022-09-30 22:34:25'),
	(121, 'Engine Block', 'Counterbore', '4 Big', '', 1500.00, 1, 0, '2022-09-30 22:34:45', '2022-09-30 22:34:45'),
	(122, 'Engine Block', 'Liner Replace', '4 Big', '', 1500.00, 1, 0, '2022-09-30 22:35:03', '2022-09-30 22:35:03'),
	(123, 'Engine Block', 'Block Reface', '4 Big', '', 2500.00, 1, 0, '2022-09-30 22:35:26', '2022-09-30 22:35:26'),
	(124, 'Engine Block', 'Camshaft Bushing Replace', '4 Big', '', 1200.00, 1, 0, '2022-09-30 22:36:11', '2022-09-30 22:36:11'),
	(125, 'Engine Block', 'Line Boring of Main Housing', '4 Big', '', 4500.00, 1, 0, '2022-09-30 22:36:50', '2022-09-30 22:36:50'),
	(126, 'Engine Block', 'Build up of Main Saddle', '4 Big', 'Per Journal', 2500.00, 1, 0, '2022-09-30 22:37:16', '2022-09-30 22:37:16'),
	(127, 'Engine Block', 'Build of Trust Side', '4 Big', '', 1200.00, 1, 0, '2022-09-30 22:37:38', '2022-09-30 22:37:38'),
	(128, 'Engine Block', 'Washing', '4 Big', '', 500.00, 1, 0, '2022-09-30 22:37:59', '2022-09-30 22:37:59'),
	(129, 'Engine Block', 'Rebore', '6 Cylinder', '', 6000.00, 1, 0, '2022-09-30 22:38:58', '2022-09-30 22:38:58'),
	(130, 'Engine Block', 'Sleeve Rebore', '6 Cylinder', '', 7000.00, 1, 0, '2022-09-30 22:39:20', '2022-09-30 22:39:20'),
	(131, 'Engine Block', 'Counterbore', '6 Cylinder', '', 2500.00, 1, 0, '2022-09-30 22:39:42', '2022-09-30 22:39:42'),
	(132, 'Engine Block', 'Liner Replace', '6 Cylinder', '', 2500.00, 1, 0, '2022-09-30 22:40:05', '2022-09-30 22:40:05'),
	(133, 'Engine Block', 'Block Reface', '6 Cylinder', '', 4500.00, 1, 0, '2022-09-30 22:40:37', '2022-09-30 22:40:37'),
	(134, 'Engine Block', 'Camshaft Bushing Replace', '6 Cylinder', '', 1800.00, 1, 0, '2022-09-30 22:41:11', '2022-09-30 22:41:11'),
	(135, 'Engine Block', 'Line Boring of Main Housing', '6 Cylinder', '', 6500.00, 1, 0, '2022-09-30 22:41:32', '2022-09-30 22:41:32'),
	(136, 'Engine Block', 'Build up of Main Saddle', '6 Cylinder', 'Per Journal', 2500.00, 1, 0, '2022-09-30 22:41:59', '2022-09-30 22:41:59'),
	(137, 'Engine Block', 'Build of Trust Side', '6 Cylinder', '', 1500.00, 1, 0, '2022-09-30 22:42:29', '2022-09-30 22:42:29'),
	(138, 'Engine Block', 'Washing', '6 Cylinder', '', 800.00, 1, 0, '2022-09-30 22:42:51', '2022-09-30 22:42:51'),
	(139, 'Engine Block', 'Rebore', 'Heavy', '', 7500.00, 1, 0, '2022-09-30 22:43:16', '2022-09-30 22:43:16'),
	(140, 'Engine Block', 'Sleeve Rebore', 'Heavy', '', 8500.00, 1, 0, '2022-09-30 22:43:35', '2022-09-30 22:43:35'),
	(141, 'Engine Block', 'Counterbore', 'Heavy', '', 4500.00, 1, 0, '2022-09-30 22:44:05', '2022-09-30 22:44:05'),
	(142, 'Engine Block', 'Liner Replace', 'Heavy', '', 4500.00, 1, 0, '2022-09-30 22:44:30', '2022-09-30 22:44:30'),
	(143, 'Engine Block', 'Block Reface', 'Heavy', '', 4500.00, 1, 0, '2022-09-30 22:44:48', '2022-09-30 22:44:48'),
	(144, 'Engine Block', 'Camshaft Bushing Replace', 'Heavy', '', 2500.00, 1, 0, '2022-09-30 22:45:05', '2022-09-30 22:45:05'),
	(145, 'Engine Block', 'Line Boring of Main Housing', 'Heavy', '', 7500.00, 1, 0, '2022-09-30 22:45:25', '2022-09-30 22:45:25'),
	(146, 'Engine Block', 'Build up of Main Saddle', 'Heavy', 'Per Journal', 3500.00, 1, 0, '2022-09-30 22:45:50', '2022-09-30 22:45:50'),
	(147, 'Engine Block', 'Build of Trust Side', 'Heavy', '', 3000.00, 1, 0, '2022-09-30 22:46:14', '2022-09-30 22:46:14'),
	(148, 'Engine Block', 'Washing', 'Heavy', '', 1000.00, 1, 0, '2022-09-30 22:46:45', '2022-09-30 22:46:45'),
	(149, 'Crankshaft', 'Polished', '1 Cylinder', '', 500.00, 1, 0, '2022-09-30 22:49:43', '2022-09-30 22:49:43'),
	(150, 'Crankshaft', 'Regrind of Main and Con journal', '1 Cylinder', '', 800.00, 1, 0, '2022-09-30 22:50:01', '2022-09-30 22:50:01'),
	(151, 'Crankshaft', 'Trust Side Machining', '1 Cylinder', '', 250.00, 1, 0, '2022-09-30 22:50:19', '2022-11-09 21:38:41'),
	(152, 'Crankshaft', 'Build Up of Thrust Side', '1 Cylinder', '', 600.00, 1, 0, '2022-09-30 22:50:40', '2022-11-09 21:39:23'),
	(153, 'Crankshaft', 'Oil Seal Build Up', '1 Cylinder', '', 500.00, 1, 0, '2022-09-30 22:50:56', '2022-09-30 22:50:56'),
	(154, 'Crankshaft', 'Fitting of Main and Con', '1 Cylinder', '', 850.00, 1, 0, '2022-09-30 22:51:13', '2022-09-30 22:51:13'),
	(155, 'Crankshaft', 'Alignment', '1 Cylinder', '', 850.00, 1, 0, '2022-09-30 22:51:28', '2022-09-30 22:51:28'),
	(156, 'Crankshaft', 'Rebabbit of Thrust Washer', '1 Cylinder', '', 850.00, 1, 0, '2022-09-30 22:51:48', '2022-09-30 22:51:48'),
	(157, 'Crankshaft', 'Balancer Bushing Replace', '1 Cylinder', '', 500.00, 1, 0, '2022-09-30 22:52:08', '2022-09-30 22:52:08'),
	(158, 'Crankshaft', 'Polished', '2 Cylinder', '', 500.00, 1, 0, '2022-09-30 22:52:35', '2022-09-30 22:52:35'),
	(159, 'Crankshaft', 'Regrind of Main and Con journal', '2 Cylinder', '', 1500.00, 1, 0, '2022-09-30 22:52:57', '2022-09-30 22:52:57'),
	(160, 'Crankshaft', 'Trust side machining', '2 Cylinder', '', 300.00, 1, 0, '2022-09-30 22:53:34', '2022-09-30 22:53:34'),
	(161, 'Crankshaft', 'Build up of Thrust side', '2 Cylinder', '', 900.00, 1, 0, '2022-09-30 22:53:55', '2022-09-30 22:53:55'),
	(162, 'Crankshaft', 'Oil Seal Build Up', '2 Cylinder', '', 600.00, 1, 0, '2022-09-30 22:54:12', '2022-09-30 22:54:12'),
	(163, 'Crankshaft', 'Fitting of Main and Con', '2 Cylinder', '', 1000.00, 1, 0, '2022-09-30 22:54:44', '2022-09-30 22:58:04'),
	(164, 'Crankshaft', 'Alignment', '2 Cylinder', '', 1000.00, 1, 0, '2022-09-30 22:56:43', '2022-09-30 22:58:25'),
	(165, 'Crankshaft', 'Rebabbit of Thrust Washer', '2 Cylinder', '', 1000.00, 1, 0, '2022-09-30 22:56:58', '2022-09-30 22:56:58'),
	(166, 'Crankshaft', 'Balancer Bushing Replace', '2 Cylinder', '', 600.00, 1, 0, '2022-09-30 22:57:20', '2022-09-30 22:58:48'),
	(167, 'Crankshaft', 'Polished', '3 Cylinder', '', 800.00, 1, 0, '2022-09-30 22:59:28', '2022-09-30 22:59:28'),
	(168, 'Crankshaft', 'Regrind of Main and Con journal', '3 Cylinder', '', 1750.00, 1, 0, '2022-09-30 22:59:46', '2022-09-30 22:59:46'),
	(169, 'Crankshaft', 'Trust side machining', '3 Cylinder', '', 450.00, 1, 0, '2022-09-30 23:00:02', '2022-09-30 23:00:02'),
	(170, 'Crankshaft', 'Build up of Thrust side', '3 Cylinder', '', 1200.00, 1, 0, '2022-09-30 23:00:23', '2022-09-30 23:00:23'),
	(171, 'Crankshaft', 'Oil Seal Build Up', '3 Cylinder', '', 600.00, 1, 0, '2022-09-30 23:00:51', '2022-09-30 23:00:51'),
	(172, 'Crankshaft', 'Fitting of Main and Con', '3 Cylinder', '', 1500.00, 1, 0, '2022-09-30 23:01:07', '2022-09-30 23:01:07'),
	(173, 'Crankshaft', 'Alignment', '3 Cylinder', '', 1200.00, 1, 0, '2022-09-30 23:01:22', '2022-09-30 23:01:22'),
	(174, 'Crankshaft', 'Rebabbit of Thrust Washer', '3 Cylinder', '', 1000.00, 1, 0, '2022-09-30 23:01:39', '2022-09-30 23:01:39'),
	(175, 'Connecting Rod', 'Balancer Bushing Replace', '3 Cylinder', '', 900.00, 1, 0, '2022-09-30 23:01:53', '2023-01-07 00:34:32'),
	(176, 'Crankshaft', 'Polished', '4 Small', '', 900.00, 1, 0, '2022-09-30 23:02:18', '2022-09-30 23:02:18'),
	(177, 'Crankshaft', 'Regrind of Main and Con journal', '4 Small', '', 2250.00, 1, 0, '2022-09-30 23:02:38', '2022-09-30 23:02:38'),
	(178, 'Crankshaft', 'Trust side machining', '4 Small', '', 650.00, 1, 0, '2022-09-30 23:02:54', '2022-09-30 23:02:54'),
	(179, 'Crankshaft', 'Build up of Thrust side', '4 Small', '', 1500.00, 1, 0, '2022-09-30 23:03:16', '2022-09-30 23:03:16'),
	(180, 'Crankshaft', 'Oil Seal Build Up', '4 Small', '', 650.00, 1, 0, '2022-09-30 23:03:32', '2022-09-30 23:03:32'),
	(181, 'Crankshaft', 'Fitting of Main and Con', '4 Small', '', 1500.00, 1, 0, '2022-09-30 23:03:48', '2022-09-30 23:03:48'),
	(182, 'Crankshaft', 'Alignment', '4 Small', '', 1500.00, 1, 0, '2022-09-30 23:04:04', '2022-09-30 23:04:04'),
	(183, 'Crankshaft', 'Rebabbit of Thrust Washer', '4 Small', '', 1000.00, 1, 0, '2022-09-30 23:04:20', '2022-09-30 23:04:20'),
	(184, 'Crankshaft', 'Balancer Bushing Replace', '4 Small', '', 1200.00, 1, 0, '2022-09-30 23:04:34', '2022-11-06 17:20:11'),
	(185, 'Crankshaft', 'Polished', '4 Big', '', 1200.00, 1, 0, '2022-09-30 23:04:55', '2022-09-30 23:04:55'),
	(186, 'Crankshaft', 'Regrind of Main and Con journal', '4 Big', '', 2700.00, 1, 0, '2022-09-30 23:05:10', '2022-09-30 23:05:10'),
	(187, 'Crankshaft', 'Trust side machining', '4 Big', '', 750.00, 1, 0, '2022-09-30 23:05:24', '2022-09-30 23:05:24'),
	(188, 'Crankshaft', 'Build up of Thrust side', '4 Big', '', 1500.00, 1, 0, '2022-09-30 23:05:39', '2022-09-30 23:05:39'),
	(189, 'Crankshaft', 'Oil Seal Build Up', '4 Big', '', 1200.00, 1, 0, '2022-09-30 23:05:55', '2022-09-30 23:05:55'),
	(190, 'Crankshaft', 'Fitting of Main and Con', '4 Big', '', 1800.00, 1, 0, '2022-09-30 23:06:12', '2022-09-30 23:06:12'),
	(191, 'Crankshaft', 'Alignment', '4 Big', '', 2500.00, 1, 0, '2022-09-30 23:06:29', '2022-09-30 23:06:29'),
	(192, 'Crankshaft', 'Rebabbit of Thrust Washer', '4 Big', '', 1500.00, 1, 0, '2022-09-30 23:06:45', '2022-09-30 23:06:45'),
	(193, 'Crankshaft', 'Balancer Bushing Replace', '4 Big', '', 1200.00, 1, 0, '2022-09-30 23:07:00', '2022-09-30 23:07:00'),
	(194, 'Crankshaft', 'Polished', '6 Cylinder', '', 1600.00, 1, 0, '2022-09-30 23:07:23', '2022-09-30 23:07:23'),
	(195, 'Crankshaft', 'Regrind of Main and Con journal', '6 Cylinder', '', 4550.00, 1, 0, '2022-09-30 23:07:40', '2022-09-30 23:07:40'),
	(196, 'Crankshaft', 'Trust side machining', '6 Cylinder', '', 1200.00, 1, 0, '2022-09-30 23:08:03', '2022-09-30 23:08:03'),
	(197, 'Crankshaft', 'Build up of Thrust side', '6 Cylinder', '', 1800.00, 1, 0, '2022-09-30 23:08:20', '2022-09-30 23:08:20'),
	(198, 'Crankshaft', 'Oil Seal Build Up', '6 Cylinder', '', 1500.00, 1, 0, '2022-09-30 23:08:38', '2022-09-30 23:08:38'),
	(199, 'Crankshaft', 'Fitting of Main and Con', '6 Cylinder', '', 2500.00, 1, 0, '2022-09-30 23:08:54', '2022-09-30 23:08:54'),
	(200, 'Crankshaft', 'Alignment', '6 Cylinder', '', 3500.00, 1, 0, '2022-09-30 23:09:10', '2022-09-30 23:09:10'),
	(201, 'Crankshaft', 'Rebabbit of Thrust Washer', '6 Cylinder', '', 1800.00, 1, 0, '2022-09-30 23:09:26', '2022-09-30 23:09:26'),
	(202, 'Crankshaft', 'Balancer Bushing Replace', '6 Cylinder', '', 1500.00, 1, 0, '2022-09-30 23:09:43', '2022-09-30 23:09:43'),
	(203, 'Crankshaft', 'Polished', 'Heavy', '', 2000.00, 1, 0, '2022-09-30 23:10:05', '2022-09-30 23:10:05'),
	(204, 'Crankshaft', 'Regrind of Main and Con journal', 'Heavy', '', 6500.00, 1, 0, '2022-09-30 23:10:22', '2022-09-30 23:10:22'),
	(205, 'Crankshaft', 'Trust Side Machining', 'Heavy', '', 1800.00, 1, 0, '2022-09-30 23:10:38', '2022-09-30 23:10:38'),
	(206, 'Crankshaft', 'Build up of Thrust side', 'Heavy', '', 2500.00, 1, 0, '2022-09-30 23:10:59', '2022-09-30 23:10:59'),
	(207, 'Crankshaft', 'Oil Seal Build Up', 'Heavy', '', 2500.00, 1, 0, '2022-09-30 23:11:17', '2022-09-30 23:11:17'),
	(208, 'Crankshaft', 'Fitting of Main and Con', 'Heavy', '', 4500.00, 1, 0, '2022-09-30 23:11:37', '2022-09-30 23:11:37'),
	(209, 'Crankshaft', 'Alignment', 'Heavy', '', 5000.00, 1, 0, '2022-09-30 23:11:53', '2022-09-30 23:11:53'),
	(210, 'Crankshaft', 'Rebabbit of Thrust Washer', 'Heavy', '', 2500.00, 1, 0, '2022-09-30 23:12:09', '2022-09-30 23:12:09'),
	(211, 'Crankshaft', 'Balancer Bushing Replace', 'Heavy', '', 2500.00, 1, 0, '2022-09-30 23:12:29', '2022-09-30 23:12:29'),
	(212, 'Connecting Rod', 'Alignment', '1 Cylinder', '', 300.00, 1, 0, '2022-09-30 23:15:01', '2022-09-30 23:15:01'),
	(213, 'Connecting Rod', 'Piston Pin Bushing Replace', '1 Cylinder', '', 200.00, 1, 0, '2022-09-30 23:22:53', '2022-09-30 23:22:53'),
	(214, 'Connecting Rod', 'Sleeving of Piston Pin Bushing Housing', '1 Cylinder', '', 300.00, 1, 0, '2022-09-30 23:23:18', '2022-09-30 23:23:18'),
	(215, 'Connecting Rod', 'Resizing', '1 Cylinder', '', 300.00, 1, 0, '2022-09-30 23:23:35', '2022-09-30 23:23:35'),
	(216, 'Connecting Rod', 'Build up of Bearing Housing', '1 Cylinder', '', 300.00, 1, 0, '2022-09-30 23:23:53', '2022-09-30 23:23:53'),
	(217, 'Connecting Rod', 'Fitting of Piston', '1 Cylinder', '', 900.00, 1, 0, '2022-09-30 23:24:16', '2022-09-30 23:24:16'),
	(218, 'Connecting Rod', 'Conversion', '1 Cylinder', '', 1000.00, 1, 0, '2022-09-30 23:24:32', '2022-09-30 23:24:32'),
	(219, 'Connecting Rod', 'Press of Piston', '1 Cylinder', '', 650.00, 1, 0, '2022-09-30 23:24:47', '2022-09-30 23:24:47'),
	(220, 'Connecting Rod', 'Alignment', '2 Cylinder', '', 355.00, 1, 0, '2022-09-30 23:25:25', '2023-01-04 22:53:10'),
	(221, 'Connecting Rod', 'Piston Pin Bushing Replace', '2 Cylinder', '', 500.00, 1, 0, '2022-09-30 23:25:42', '2022-09-30 23:25:42'),
	(222, 'Connecting Rod', 'Sleeving of Piston Pin Bushing Housing', '2 Cylinder', '', 350.00, 1, 0, '2022-09-30 23:26:06', '2022-09-30 23:26:06'),
	(223, 'Connecting Rod', 'Resizing', '2 Cylinder', '', 350.00, 1, 0, '2022-09-30 23:26:21', '2022-09-30 23:26:21'),
	(224, 'Connecting Rod', 'Build up of Bearing Housing', '2 Cylinder', '', 350.00, 1, 0, '2022-09-30 23:26:37', '2022-09-30 23:26:37'),
	(225, 'Connecting Rod', 'Fitting of Piston', '2 Cylinder', '', 1200.00, 1, 0, '2022-09-30 23:26:53', '2022-09-30 23:26:53'),
	(226, 'Connecting Rod', 'Conversion', '2 Cylinder', '', 1500.00, 1, 0, '2022-09-30 23:27:15', '2022-09-30 23:27:15'),
	(227, 'Connecting Rod', 'Press of Piston', '2 Cylinder', '', 900.00, 1, 0, '2022-09-30 23:27:30', '2022-09-30 23:27:30'),
	(228, 'Connecting Rod', 'Alignment', '3 Cylinder', '', 500.00, 1, 0, '2022-09-30 23:27:54', '2022-09-30 23:27:54'),
	(229, 'Connecting Rod', 'Piston Pin Bushing Replace', '3 Cylinder', '', 700.00, 1, 0, '2022-09-30 23:28:10', '2022-09-30 23:28:10'),
	(230, 'Connecting Rod', 'Sleeving of Piston Pin Bushing Housing', '3 Cylinder', '', 500.00, 1, 0, '2022-09-30 23:28:27', '2022-09-30 23:28:27'),
	(231, 'Connecting Rod', 'Resizing', '3 Cylinder', '', 400.00, 1, 0, '2022-09-30 23:28:44', '2022-09-30 23:28:44'),
	(232, 'Connecting Rod', 'Build up of Bearing Housing', '3 Cylinder', '', 400.00, 1, 0, '2022-09-30 23:29:00', '2022-09-30 23:29:00'),
	(233, 'Connecting Rod', 'Fitting of Piston', '3 Cylinder', '', 1500.00, 1, 0, '2022-09-30 23:29:19', '2022-09-30 23:29:19'),
	(234, 'Connecting Rod', 'Conversion', '3 Cylinder', '', 1500.00, 1, 0, '2022-09-30 23:29:37', '2022-09-30 23:29:37'),
	(235, 'Connecting Rod', 'Press of Piston', '3 Cylinder', '', 1200.00, 1, 0, '2022-09-30 23:29:55', '2022-09-30 23:29:55'),
	(236, 'Connecting Rod', 'Alignment', '4 Small', '', 500.00, 1, 0, '2022-09-30 23:30:33', '2022-09-30 23:30:33'),
	(237, 'Connecting Rod', 'Piston Pin Bushing Replace', '4 Small', '', 900.00, 1, 0, '2022-09-30 23:30:55', '2022-09-30 23:30:55'),
	(238, 'Connecting Rod', 'Sleeving of Piston Pin Bushing Housing', '4 Small', '', 500.00, 1, 0, '2022-09-30 23:31:21', '2022-09-30 23:31:21'),
	(239, 'Connecting Rod', 'Resizing', '4 Small', '', 450.00, 1, 0, '2022-09-30 23:31:36', '2022-09-30 23:31:36'),
	(240, 'Connecting Rod', 'Build up of Bearing Housing', '4 Small', '', 450.00, 1, 0, '2022-09-30 23:31:50', '2022-09-30 23:31:50'),
	(241, 'Connecting Rod', 'Fitting of Piston', '4 Small', '', 2500.00, 1, 0, '2022-09-30 23:32:05', '2022-09-30 23:32:05'),
	(242, 'Connecting Rod', 'Conversion', '4 Small', '', 1500.00, 1, 0, '2022-09-30 23:32:21', '2022-09-30 23:32:21'),
	(243, 'Connecting Rod', 'Press of Piston', '4 Small', '', 1200.00, 1, 0, '2022-09-30 23:32:36', '2022-09-30 23:32:36'),
	(244, 'Connecting Rod', 'Alignment', '4 Big', '', 600.00, 1, 0, '2022-09-30 23:32:55', '2022-09-30 23:32:55'),
	(245, 'Connecting Rod', 'Piston Pin Bushing Replace', '4 Big', '', 1200.00, 1, 0, '2022-09-30 23:33:10', '2022-09-30 23:33:10'),
	(246, 'Connecting Rod', 'Sleeving of Piston Pin Bushing Housing', '4 Big', '', 500.00, 1, 0, '2022-09-30 23:33:30', '2022-09-30 23:33:30'),
	(247, 'Connecting Rod', 'Resizing', '4 Big', '', 600.00, 1, 0, '2022-09-30 23:33:42', '2022-09-30 23:33:42'),
	(248, 'Connecting Rod', 'Build up of Bearing Housing', '4 Big', '', 650.00, 1, 0, '2022-09-30 23:34:00', '2022-09-30 23:34:00'),
	(249, 'Connecting Rod', 'Fitting of Piston', '4 Big', '', 3500.00, 1, 0, '2022-09-30 23:34:20', '2022-09-30 23:34:20'),
	(250, 'Connecting Rod', 'Conversion', '4 Big', '', 1500.00, 1, 0, '2022-09-30 23:34:41', '2022-09-30 23:34:41'),
	(251, 'Connecting Rod', 'Press of Piston', '4 Big', '', 1500.00, 1, 0, '2022-09-30 23:35:20', '2022-09-30 23:35:20'),
	(252, 'Connecting Rod', 'Alignment', '6 Cylinder', '', 800.00, 1, 0, '2022-09-30 23:35:42', '2022-11-09 21:15:43'),
	(253, 'Connecting Rod', 'Piston Pin Bushing Replace', '6 Cylinder', '', 1600.00, 1, 0, '2022-09-30 23:36:01', '2022-09-30 23:36:01'),
	(254, 'Connecting Rod', 'Sleeving of Piston Pin Bushing Housing', '6 Cylinder', '', 800.00, 1, 0, '2022-09-30 23:36:19', '2022-09-30 23:36:19'),
	(255, 'Connecting Rod', 'Resizing', '6 Cylinder', '', 900.00, 1, 0, '2022-09-30 23:36:35', '2022-09-30 23:36:35'),
	(256, 'Connecting Rod', 'Build up of Bearing Housing', '6 Cylinder', '', 900.00, 1, 0, '2022-09-30 23:36:51', '2022-09-30 23:36:51'),
	(257, 'Connecting Rod', 'Fitting of Piston', '6 Cylinder', '', 4500.00, 1, 0, '2022-09-30 23:37:09', '2022-09-30 23:37:09'),
	(258, 'Connecting Rod', 'Conversion', '6 Cylinder', '', 2500.00, 1, 0, '2022-09-30 23:37:23', '2022-09-30 23:37:23'),
	(259, 'Connecting Rod', 'Press of Piston', '6 Cylinder', '', 2500.00, 1, 0, '2022-09-30 23:37:41', '2022-09-30 23:37:41'),
	(260, 'Connecting Rod', 'Alignment', 'Heavy', '', 1200.00, 1, 0, '2022-09-30 23:38:01', '2022-09-30 23:38:01'),
	(261, 'Connecting Rod', 'Piston Pin Bushing Replace', 'Heavy', '', 2500.00, 1, 0, '2022-09-30 23:38:19', '2022-09-30 23:38:19'),
	(262, 'Connecting Rod', 'Sleeving of Piston Pin Bushing Housing', 'Heavy', '', 1000.00, 1, 0, '2022-09-30 23:38:35', '2022-09-30 23:38:35'),
	(263, 'Connecting Rod', 'Resizing', 'Heavy', '', 1500.00, 1, 0, '2022-09-30 23:38:51', '2022-09-30 23:38:51'),
	(264, 'Connecting Rod', 'Build up of Bearing Housing', 'Heavy', '', 1500.00, 1, 0, '2022-09-30 23:39:07', '2022-09-30 23:39:07'),
	(265, 'Connecting Rod', 'Fitting of Piston', 'Heavy', '', 8500.00, 1, 0, '2022-09-30 23:39:26', '2022-09-30 23:39:26'),
	(266, 'Connecting Rod', 'Conversion', 'Heavy', '', 4500.00, 1, 0, '2022-09-30 23:39:41', '2022-09-30 23:39:41'),
	(267, 'Connecting Rod', 'Press of Piston', 'Heavy', '', 4000.00, 1, 0, '2022-09-30 23:39:58', '2022-09-30 23:39:58');

-- Dumping structure for table hems_db.service_price_logs
CREATE TABLE IF NOT EXISTS `service_price_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serv_id` int(11) DEFAULT NULL,
  `new_price` float DEFAULT NULL,
  `from_price` float DEFAULT NULL,
  `date_effect` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_changed` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Dumping data for table hems_db.service_price_logs: 1 rows
/*!40000 ALTER TABLE `service_price_logs` DISABLE KEYS */;
INSERT INTO `service_price_logs` (`id`, `serv_id`, `new_price`, `from_price`, `date_effect`, `user_id`, `date_changed`) VALUES
	(6, 220, 355, 350, '2023-01-04 22:51:00', 1, '2023-01-04 22:53:10');
/*!40000 ALTER TABLE `service_price_logs` ENABLE KEYS */;

-- Dumping structure for table hems_db.system_info
CREATE TABLE IF NOT EXISTS `system_info` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table hems_db.system_info: ~5 rows (approximately)
INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
	(1, 'name', 'HEMS'),
	(6, 'short_name', 'HEMS Management System'),
	(11, 'logo', 'uploads/logo.png?v=1663865016'),
	(13, 'user_avatar', 'uploads/user_avatar.jpg'),
	(14, 'cover', 'uploads/cover.png?v=1651626884');

-- Dumping structure for table hems_db.tbl_status
CREATE TABLE IF NOT EXISTS `tbl_status` (
  `status_id` int(11) NOT NULL,
  `status_desc` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table hems_db.tbl_status: 4 rows
/*!40000 ALTER TABLE `tbl_status` DISABLE KEYS */;
INSERT INTO `tbl_status` (`status_id`, `status_desc`) VALUES
	(0, 'Pending'),
	(1, 'On-Progress'),
	(2, 'Done'),
	(3, 'Cancelled');
/*!40000 ALTER TABLE `tbl_status` ENABLE KEYS */;

-- Dumping structure for table hems_db.transaction_list
CREATE TABLE IF NOT EXISTS `transaction_list` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `user_id` int(30) NOT NULL,
  `mechanic_id` int(30) DEFAULT NULL,
  `client_id` int(30) DEFAULT NULL,
  `code` varchar(10) NOT NULL,
  `client_name` text NOT NULL,
  `contact` text NOT NULL,
  `email` text NOT NULL,
  `tin_number` text,
  `address` text NOT NULL,
  `engine_model` varchar(250) NOT NULL,
  `vehicle_type` varchar(250) NOT NULL,
  `job_order` varchar(20) NOT NULL DEFAULT '',
  `amount` float(15,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '\r\n0=Pending,\r\n1=On-Progress,\r\n2=Done,\r\n3=Paid,\r\n4=Cancelled',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `mechanic_id` (`mechanic_id`),
  KEY `client_id_fk_tl` (`client_id`),
  CONSTRAINT `client_id_fk_tl` FOREIGN KEY (`client_id`) REFERENCES `clients_record` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `mechanic_id_fk_tl` FOREIGN KEY (`mechanic_id`) REFERENCES `mechanic_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `user_id_fk_tl` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table hems_db.transaction_list: ~2 rows (approximately)
INSERT INTO `transaction_list` (`id`, `user_id`, `mechanic_id`, `client_id`, `code`, `client_name`, `contact`, `email`, `tin_number`, `address`, `engine_model`, `vehicle_type`, `job_order`, `amount`, `status`, `date_created`, `date_updated`) VALUES
	(32, 1, 8, 13, '23010001', 'Gabriel Abarintos', '09873678266', 'gabriel@abarintos.com', '000-123-456-001', 'Calapan City, Ilaya', '4D32', 'Truck', '', 7650.00, 2, '2023-01-06 22:25:35', '2023-01-06 23:43:29'),
	(33, 1, 19, 14, '23010002', 'John Doe', '09613074699', 'john@doe.com', '000-123-456-002', 'Calapan City, Ibaba', '4D33', 'Sedan', '', 7400.00, 1, '2023-01-07 00:29:53', '2023-01-07 23:05:51');

-- Dumping structure for table hems_db.transaction_products
CREATE TABLE IF NOT EXISTS `transaction_products` (
  `transaction_id` int(30) NOT NULL,
  `product_id` int(30) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT '0',
  `price` float(15,2) NOT NULL DEFAULT '0.00',
  KEY `transaction_id` (`transaction_id`),
  KEY `service_id` (`product_id`),
  CONSTRAINT `product_id_fk_tp` FOREIGN KEY (`product_id`) REFERENCES `product_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `transaction_id_fk_tp` FOREIGN KEY (`transaction_id`) REFERENCES `transaction_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table hems_db.transaction_products: ~3 rows (approximately)
INSERT INTO `transaction_products` (`transaction_id`, `product_id`, `qty`, `price`) VALUES
	(32, 31, 2, 1800.00),
	(32, 43, 1, 2100.00),
	(33, 45, 1, 6000.00);

-- Dumping structure for table hems_db.transaction_services
CREATE TABLE IF NOT EXISTS `transaction_services` (
  `transaction_id` int(30) NOT NULL,
  `service_id` int(30) NOT NULL,
  `price` float(15,2) NOT NULL DEFAULT '0.00',
  KEY `transaction_id` (`transaction_id`),
  KEY `service_id` (`service_id`),
  CONSTRAINT `service_id_fk_ts` FOREIGN KEY (`service_id`) REFERENCES `service_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `transaction_id_fk_ts` FOREIGN KEY (`transaction_id`) REFERENCES `transaction_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table hems_db.transaction_services: ~4 rows (approximately)
INSERT INTO `transaction_services` (`transaction_id`, `service_id`, `price`) VALUES
	(32, 184, 1200.00),
	(32, 29, 750.00),
	(33, 237, 900.00),
	(33, 23, 500.00);

-- Dumping structure for table hems_db.trans_status_logs
CREATE TABLE IF NOT EXISTS `trans_status_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_id` int(11) DEFAULT NULL,
  `new_status` int(11) DEFAULT NULL,
  `from_status` int(11) DEFAULT NULL,
  `date_effect` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_changed` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- Dumping data for table hems_db.trans_status_logs: 2 rows
/*!40000 ALTER TABLE `trans_status_logs` DISABLE KEYS */;
INSERT INTO `trans_status_logs` (`id`, `trans_id`, `new_status`, `from_status`, `date_effect`, `user_id`, `date_changed`) VALUES
	(19, 32, 2, 1, '2023-01-06 23:43:00', 1, '2023-01-06 23:43:29'),
	(18, 32, 1, 0, '2023-01-06 23:38:00', 1, '2023-01-06 23:38:54'),
	(20, 33, 1, 0, '2023-01-07 23:05:00', 1, '2023-01-07 23:05:51');
/*!40000 ALTER TABLE `trans_status_logs` ENABLE KEYS */;

-- Dumping structure for table hems_db.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table hems_db.users: ~2 rows (approximately)
INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`) VALUES
	(1, 'Gabriel', 'Andrei', 'admin', '0192023a7bbd73250516f069df18b500', 'uploads/avatars/1.png?v=1663858090', NULL, 1, '2021-01-20 14:02:37', '2022-09-22 22:48:27'),
	(3, 'Bob', 'Ross', 'bobross', '3501b641108f9f32d9b10d340935ee07', 'uploads/avatars/3.png?v=1663862108', NULL, 2, '2022-04-21 15:45:49', '2022-09-22 23:55:08');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
