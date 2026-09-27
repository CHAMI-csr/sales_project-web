-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.46 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.21.0.7344
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for tech_hub
CREATE DATABASE IF NOT EXISTS `tech_hub` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `tech_hub`;

-- Dumping structure for table tech_hub.businessregistration
CREATE TABLE IF NOT EXISTS `businessregistration` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `bname` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `date` date NOT NULL,
  `bnumber` int NOT NULL,
  `bregid` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `btype` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `bcertificate` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `blogo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `approve` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_business_user` (`user_id`),
  CONSTRAINT `fk_business_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table tech_hub.businessregistration: ~4 rows (approximately)
INSERT INTO `businessregistration` (`id`, `user_id`, `bname`, `date`, `bnumber`, `bregid`, `btype`, `bcertificate`, `blogo`, `approve`) VALUES
	(7, 'user_1841', 'Chiki_officel01', '2025-09-02', 761042162, '8687687969876', 'Phones, Back Covers, Headphones, Chargers', 'techub-wireframe-storyboard.pdf', '20250903_1110_image (3).png', 1),
	(8, 'user_9517', 'LOCANA_Store', '2025-02-05', 761042162, '8687687969876', 'Phones, Back Covers, Headphones, Chargers', 'techub-wireframe-storyboard.pdf', '20250903_1110_image.png', 1),
	(9, 'user_5559', 'Tec_Store', '2025-02-05', 761042162, '8687687969876', 'Phones, Back Covers, Headphones, Chargers', 'Untitled.pdf', '20250903_1110_image (2).png', 1),
	(10, 'user_9651', 'NADE_STORE', '2021-01-16', 761042162, '8687687969876', 'Phones, Back Covers, Headphones, Chargers', 'techub-wireframe-storyboard.pdf', '20250903_1209_image.png', 1),
	(11, 'user_6717', 'Apex live', '2026-09-01', 761042162, 'PV565676', 'Phones, Headphones, Back Covers, Chargers', 'Complaint_Management_System_Documentation.md.pdf', 'WhatsApp Image 2026-09-25 at 6.51.53 PM.jpeg', 1);

-- Dumping structure for table tech_hub.orderhistory
CREATE TABLE IF NOT EXISTS `orderhistory` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `pid` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `totalprice` decimal(20,2) NOT NULL,
  `date` datetime NOT NULL,
  `orderid` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `pnames` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `qty` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_oh_user` (`user_id`),
  CONSTRAINT `fk_oh_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table tech_hub.orderhistory: ~3 rows (approximately)
INSERT INTO `orderhistory` (`id`, `user_id`, `pid`, `totalprice`, `date`, `orderid`, `pnames`, `qty`) VALUES
	(23, 'user_0001', 'item_5650', 30500.00, '2025-09-16 12:45:19', '68c90e6c559e9', 'POCO X2', '1'),
	(24, 'user_9753', 'item_9478', 2000.00, '2026-09-26 17:02:31', 'ORD20260926113036774', 'CFX S003', '1'),
	(25, 'user_9753', 'item_3240', 2100.00, '2026-09-26 17:02:31', 'ORD20260926113036774', 'Boom X5', '1');

-- Dumping structure for table tech_hub.ordertable
CREATE TABLE IF NOT EXISTS `ordertable` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `orderid` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `pid` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `qty` int NOT NULL,
  `orderdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pname` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `categories` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `discription` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `price` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_ot_user` (`user_id`),
  KEY `idx_ot_pid` (`pid`),
  KEY `idx_ot_orderid` (`orderid`),
  CONSTRAINT `fk_ot_product` FOREIGN KEY (`pid`) REFERENCES `production` (`pid`) ON UPDATE CASCADE,
  CONSTRAINT `fk_ot_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table tech_hub.ordertable: ~2 rows (approximately)
INSERT INTO `ordertable` (`id`, `orderid`, `user_id`, `pid`, `qty`, `orderdate`, `pname`, `categories`, `discription`, `price`) VALUES
	(49, 'Order_20863', 'user_6717', 'item_5006', 1, '2026-09-26 15:40:48', 'gh', 'Phones', 'asadasdsad', 45000),
	(50, 'Order_62679', 'user_9753', 'item_5006', 1, '2026-09-26 21:28:16', 'gh', 'Phones', 'asadasdsad', 45000),
	(51, 'Order_62679', 'user_9753', 'item_2202', 1, '2026-09-26 21:28:22', 'luxury XS Backcover', 'Phones', 'luxury X Brand', 3000),
	(52, 'Order_55534', 'user_6874', 'item_5006', 1, '2026-09-27 04:22:34', 'gh', 'Phones', 'asadasdsad', 45000);

-- Dumping structure for table tech_hub.production
CREATE TABLE IF NOT EXISTS `production` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `pid` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `pname` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `categories` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `discription` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `price` double NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `qty` int NOT NULL,
  `Add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `approve` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_production_pid` (`pid`),
  KEY `idx_production_user` (`user_id`),
  CONSTRAINT `fk_production_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table tech_hub.production: ~33 rows (approximately)
INSERT INTO `production` (`id`, `pid`, `user_id`, `pname`, `categories`, `discription`, `price`, `image`, `qty`, `Add_date`, `approve`) VALUES
	(10, 'item_9076', 'user_1841', 'POCO M2S', 'Phones', '128 GB', 12000, 'Lucid_Origin_create_a_simple_themed_image_of_mobile_phones_wit_3.jpg', 30, '2025-09-16 07:31:21', 0),
	(11, 'item_2474', 'user_1841', 'Samsung A56', 'Phones', '8GB Ram/64 Rom', 25000, 'a 1 (1).jpg', 10, '2025-09-16 08:14:24', 0),
	(12, 'item_7564', 'user_1841', 'Samsung A36', 'Phones', '8GB Ram/32 Rom', 30000, 'a 1 (2).jpg', 5, '2025-09-16 08:15:12', 0),
	(13, 'item_7549', 'user_1841', 'Samsung S24', 'Phones', '128 GB', 50499, 'a 1 (3).jpg', 10, '2025-09-16 08:16:03', 0),
	(14, 'item_4106', 'user_1841', 'OPPO X32', 'Phones', '6GB Ram/32 Rom', 35000, 'a 1 (4).jpg', 10, '2025-09-16 08:17:17', 0),
	(15, 'item_2762', 'user_1841', 'OPPO SE1', 'Phones', '4GB Ram/32 Rom', 40499, 'a 1 (5).jpg', 10, '2025-09-16 08:18:33', 0),
	(16, 'item_6027', 'user_1841', 'ZTE M02', 'Phones', '8GB Ram/64 Rom', 49999, 'a 1 (6).jpg', 10, '2025-09-16 08:19:20', 0),
	(17, 'item_3760', 'user_1841', 'ZTE PRO X3', 'Phones', '16GB Ram/64 Rom', 30500, 'a 1 (8).jpg', 10, '2025-09-16 08:57:47', 0),
	(18, 'item_2082', 'user_1841', 'ZTE PRO X2', 'Phones', '4GB Ram/32 Rom', 30000, 'a 1 (10).jpg', 10, '2025-09-16 08:58:42', 0),
	(19, 'item_7251', 'user_9517', 'POVA 50W', 'Chargers', 'Fast Charging', 500, 'Bb (1).png', 10, '2025-09-16 09:18:32', 0),
	(20, 'item_4091', 'user_9517', 'SHOWA 50W Charger', 'Chargers', '50W speed', 900, 'Bb (2).png', 10, '2025-09-16 09:20:03', 0),
	(21, 'item_9348', 'user_9517', 'ZETA 100W Charger', 'Chargers', '100w speed charger ', 600, 'Bb (3).png', 25, '2025-09-16 09:21:29', 0),
	(22, 'item_2286', 'user_9517', 'CT 200w', 'Chargers', '200w laptop charger', 1500, 'Bb (4).png', 56, '2025-09-16 09:24:20', 0),
	(23, 'item_6016', 'user_9517', 'Szuki 100w charger', 'Chargers', '100w hi-quality charger', 2500, 'Bb (5).png', 12, '2025-09-16 09:26:04', 0),
	(24, 'item_5966', 'user_9517', 'samhung', 'Chargers', 'SamHung 100w Phone charger', 2400, 'Bb (6).png', 15, '2025-09-16 09:27:14', 0),
	(25, 'item_3118', 'user_5559', 'Transparent Backcover se2', 'Backcovers', 'Hiht tec', 600, 'Bb (1).jpg', 20, '2025-09-16 09:40:03', 0),
	(26, 'item_4701', 'user_5559', 'iphone 14 Pro backcover', 'Backcovers', 'NIM tec Brand', 1200, 'Bb (7).png', 20, '2025-09-16 09:41:07', 0),
	(27, 'item_3089', 'user_5559', 'IPHONE XS backcover', 'Backcovers', 'Tec_Store Brand', 1200, 'Bb (8).png', 20, '2025-09-16 09:42:42', 0),
	(28, 'item_5473', 'user_5559', 'POVA X3 backcover', 'Backcovers', 'Tec_Store Brand', 1300, 'Bb (9).png', 15, '2025-09-16 09:43:43', 0),
	(29, 'item_1270', 'user_5559', 'POCO M2S Backcover', 'Backcovers', 'Tec_Store Brand', 2000, 'Bb (10).png', 20, '2025-09-16 09:44:32', 0),
	(30, 'item_2202', 'user_5559', 'luxury XS Backcover', 'Phones', 'luxury X Brand', 3000, 'Bb (13).png', 19, '2026-09-26 21:28:22', 0),
	(31, 'item_1607', 'user_5559', 'POCO X2 Backcover', 'Backcovers', 'luxury X Brand', 3000, 'Bb (14).png', 15, '2025-09-16 09:46:33', 0),
	(32, 'item_5025', 'user_5559', '15 pro max Backcover ', 'Backcovers', 'luxury X Brand', 2500, 'Bb (12).png', 20, '2025-09-16 09:47:39', 0),
	(33, 'item_1430', 'user_9651', 'JBL X0456', 'Headphones', 'Ultra Base', 3000, 'h1 (1).jpg', 15, '2025-09-16 09:52:53', 0),
	(34, 'item_5469', 'user_9651', 'MBL X0456', 'Headphones', 'Studio Format Brand', 5500, 'h1 (1).png', 15, '2025-09-16 09:54:04', 0),
	(35, 'item_1765', 'user_9651', 'HBL X6969', 'Headphones', 'NADE_STORE Brand', 2500, 'h1 (2).jpg', 15, '2025-09-16 09:54:58', 0),
	(36, 'item_5091', 'user_9651', 'GXF Gaming X5', 'Headphones', 'GFX Orginal Brand', 3500, 'h1 (3).jpg', 15, '2025-09-16 09:56:12', 0),
	(37, 'item_3240', 'user_9651', 'Boom X5', 'Headphones', 'Boom Orginal Brand UK', 2100, 'h1 (4).jpg', 14, '2026-09-26 11:21:02', 0),
	(38, 'item_3541', 'user_9651', 'OBJ C456', 'Headphones', 'OBJ Orginal Brand', 1500, 'h1 (5).jpg', 20, '2025-09-16 09:58:11', 0),
	(39, 'item_2368', 'user_9651', 'CFX S001', 'Headphones', 'Fully customize Brand', 1500, 'h1 (6).jpg', 20, '2025-09-16 10:00:18', 0),
	(40, 'item_1173', 'user_9651', 'CFX S002', 'Headphones', 'Fully customize Brand', 3500, 'h1 (7).jpg', 20, '2025-09-16 10:00:59', 0),
	(41, 'item_2369', 'user_9651', 'CFX S003', 'Headphones', 'Fully customize Brand', 4500, 'h1 (8).jpg', 15, '2025-09-16 10:01:44', 0),
	(42, 'item_9478', 'user_9651', 'CFX S003', 'Headphones', 'Fully customize Brand', 2000, 'h1 (9).jpg', 14, '2026-09-26 08:23:40', 0),
	(43, 'item_5006', 'user_6717', 'gh', 'Phones', 'asadasdsad', 45000, 'Gemini_Generated_Image_uc04g8uc04g8uc04.jpg', 7, '2026-09-27 04:22:34', 0);

-- Dumping structure for table tech_hub.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `firstname` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `lastname` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `type` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `approve` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_users_user_id` (`user_id`),
  UNIQUE KEY `uq_users_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table tech_hub.users: ~8 rows (approximately)
INSERT INTO `users` (`id`, `user_id`, `firstname`, `lastname`, `username`, `email`, `password`, `image`, `type`, `approve`) VALUES
	(7, 'user_0001', 'Chamika', 'Sandeepa', 'Chamika', 'infor.chamika@gmail.com', '705c2e1e924c2382e71e96a75d16f286', 'backcover.jpg', 'admin', 0),
	(20, 'user_8674', 'Chamika', 'Sandeepa', 'Chami1', 'infor.chamika12@gmail.com', '705c2e1e924c2382e71e96a75d16f286', 'headphone.png', 'customer', 0),
	(21, 'user_1841', 'Chamika', 'Sandeepa', 'Chami2006', 'infor.chamika2006@gmail.com', '705c2e1e924c2382e71e96a75d16f286', 'profile.jpg', 'supplier', 0),
	(22, 'user_9517', 'Lochana', 'Nimana', 'Lochana', 'lochananimana@gmail.com', '41920f85e1c763d7facd963915d884b2', 'profile1.jpg', 'supplier', 0),
	(23, 'user_5559', 'Parami', 'Apsara', 'Parami', 'ParamiApsara@gmail.com', 'b70d263c00efdb4a5f1d978bda775959', 'a (48).jpg', 'supplier', 0),
	(24, 'user_9651', 'nadeesh', 'Nuwantha', 'nadeesh', 'infor.nadeesh@gmail.com', '5f9395ec92327002dd368375c74f5a3a', 'profile2.png', 'supplier', 0),
	(25, 'user_9999', 'Test', 'User', 'testuser', 'testuser@gmail.com', 'f925916e2754e5e03f75dd58a5733251', 'default.png', 'customer', 0),
	(26, 'user_9753', 'C.S', 'RANASINHA', 'ChamikaGG', 'chamikasandeepa@gmail.com', '99659b80a91a2e6cb1171e96a075f3a6', 'IMG_3711.JPG', 'customer', 0),
	(27, 'user_6717', 'C.S', 'RANASINHA', 'Dev_chamika', 'chamikasandeepa40@gmail.com', 'dc5dd29eeb44edf855826a1699df74b1', 'IMG_3649.JPG', 'supplier', 0),
	(28, 'user_6874', 'dama', 'dew', 'dama', 'dama@gmail.com', '9650f217911378259c091d4b19031c64', 'Gemini_Generated_Image_uc04g8uc04g8uc04.jpg', 'customer', 0);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
