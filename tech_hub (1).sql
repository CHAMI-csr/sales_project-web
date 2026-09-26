-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2025 at 05:41 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tech_hub`
--

-- --------------------------------------------------------

--
-- Table structure for table `businessregistration`
--

CREATE TABLE `businessregistration` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `bname` varchar(30) NOT NULL,
  `date` date NOT NULL,
  `bnumber` int(15) NOT NULL,
  `bregid` varchar(15) NOT NULL,
  `btype` varchar(255) NOT NULL,
  `bcertificate` varchar(255) NOT NULL,
  `blogo` varchar(255) DEFAULT NULL,
  `approve` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `businessregistration`
--

INSERT INTO `businessregistration` (`id`, `user_id`, `bname`, `date`, `bnumber`, `bregid`, `btype`, `bcertificate`, `blogo`, `approve`) VALUES
(7, 'user_1841', 'Chiki_officel01', '2025-09-02', 761042162, '8687687969876', 'Phones, Back Covers, Headphones, Chargers', 'techub-wireframe-storyboard.pdf', '20250903_1110_image (3).png', 1),
(8, 'user_9517', 'LOCANA_Store', '2025-02-05', 761042162, '8687687969876', 'Phones, Back Covers, Headphones, Chargers', 'techub-wireframe-storyboard.pdf', '20250903_1110_image.png', 1),
(9, 'user_5559', 'Tec_Store', '2025-02-05', 761042162, '8687687969876', 'Phones, Back Covers, Headphones, Chargers', 'Untitled.pdf', '20250903_1110_image (2).png', 1),
(10, 'user_9651', 'NADE_STORE', '2021-01-16', 761042162, '8687687969876', 'Phones, Back Covers, Headphones, Chargers', 'techub-wireframe-storyboard.pdf', '20250903_1209_image.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orderhistory`
--

CREATE TABLE `orderhistory` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `pid` varchar(50) NOT NULL,
  `totalprice` decimal(20,2) NOT NULL,
  `date` datetime NOT NULL,
  `orderid` varchar(50) NOT NULL,
  `pnames` varchar(255) NOT NULL,
  `qty` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderhistory`
--

INSERT INTO `orderhistory` (`id`, `user_id`, `pid`, `totalprice`, `date`, `orderid`, `pnames`, `qty`) VALUES
(23, 'user_0001', 'item_5650', 30500.00, '2025-09-16 12:45:19', '68c90e6c559e9', 'POCO X2', '1');

-- --------------------------------------------------------

--
-- Table structure for table `ordertable`
--

CREATE TABLE `ordertable` (
  `id` int(10) UNSIGNED NOT NULL,
  `orderid` varchar(30) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `pid` varchar(20) NOT NULL,
  `qty` int(11) NOT NULL,
  `orderdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pname` varchar(50) NOT NULL,
  `categories` varchar(30) NOT NULL,
  `discription` varchar(50) NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `production`
--

CREATE TABLE `production` (
  `id` int(10) UNSIGNED NOT NULL,
  `pid` varchar(20) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `pname` varchar(50) NOT NULL,
  `categories` varchar(255) NOT NULL,
  `discription` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `image` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `Add_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `approve` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `production`
--

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
(30, 'item_2202', 'user_5559', 'luxury XS Backcover', 'Phones', 'luxury X Brand', 3000, 'Bb (13).png', 20, '2025-09-16 09:45:42', 0),
(31, 'item_1607', 'user_5559', 'POCO X2 Backcover', 'Backcovers', 'luxury X Brand', 3000, 'Bb (14).png', 15, '2025-09-16 09:46:33', 0),
(32, 'item_5025', 'user_5559', '15 pro max Backcover ', 'Backcovers', 'luxury X Brand', 2500, 'Bb (12).png', 20, '2025-09-16 09:47:39', 0),
(33, 'item_1430', 'user_9651', 'JBL X0456', 'Headphones', 'Ultra Base', 3000, 'h1 (1).jpg', 15, '2025-09-16 09:52:53', 0),
(34, 'item_5469', 'user_9651', 'MBL X0456', 'Headphones', 'Studio Format Brand', 5500, 'h1 (1).png', 15, '2025-09-16 09:54:04', 0),
(35, 'item_1765', 'user_9651', 'HBL X6969', 'Headphones', 'NADE_STORE Brand', 2500, 'h1 (2).jpg', 15, '2025-09-16 09:54:58', 0),
(36, 'item_5091', 'user_9651', 'GXF Gaming X5', 'Headphones', 'GFX Orginal Brand', 3500, 'h1 (3).jpg', 15, '2025-09-16 09:56:12', 0),
(37, 'item_3240', 'user_9651', 'Boom X5', 'Headphones', 'Boom Orginal Brand UK', 2100, 'h1 (4).jpg', 15, '2025-09-16 09:57:05', 0),
(38, 'item_3541', 'user_9651', 'OBJ C456', 'Headphones', 'OBJ Orginal Brand', 1500, 'h1 (5).jpg', 20, '2025-09-16 09:58:11', 0),
(39, 'item_2368', 'user_9651', 'CFX S001', 'Headphones', 'Fully customize Brand', 1500, 'h1 (6).jpg', 20, '2025-09-16 10:00:18', 0),
(40, 'item_1173', 'user_9651', 'CFX S002', 'Headphones', 'Fully customize Brand', 3500, 'h1 (7).jpg', 20, '2025-09-16 10:00:59', 0),
(41, 'item_2369', 'user_9651', 'CFX S003', 'Headphones', 'Fully customize Brand', 4500, 'h1 (8).jpg', 15, '2025-09-16 10:01:44', 0),
(42, 'item_9478', 'user_9651', 'CFX S003', 'Headphones', 'Fully customize Brand', 2000, 'h1 (9).jpg', 15, '2025-09-16 10:02:30', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `type` varchar(20) NOT NULL,
  `approve` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `firstname`, `lastname`, `username`, `email`, `password`, `image`, `type`, `approve`) VALUES
(7, 'user_0001', 'Chamika', 'Sandeepa', 'Chamika', 'infor.chamika@gmail.com', '705c2e1e924c2382e71e96a75d16f286', 'backcover.jpg', 'admin', 0),
(20, 'user_8674', 'Chamika', 'Sandeepa', 'Chami1', 'infor.chamika12@gmail.com', '705c2e1e924c2382e71e96a75d16f286', 'headphone.png', 'customer', 0),
(21, 'user_1841', 'Chamika', 'Sandeepa', 'Chami2006', 'infor.chamika2006@gmail.com', '705c2e1e924c2382e71e96a75d16f286', 'profile.jpg', 'supplier', 0),
(22, 'user_9517', 'Lochana', 'Nimana', 'Lochana', 'lochananimana@gmail.com', '41920f85e1c763d7facd963915d884b2', 'profile1.jpg', 'supplier', 0),
(23, 'user_5559', 'Parami', 'Apsara', 'Parami', 'ParamiApsara@gmail.com', 'b70d263c00efdb4a5f1d978bda775959', 'a (48).jpg', 'supplier', 0),
(24, 'user_9651', 'nadeesh', 'Nuwantha', 'nadeesh', 'infor.nadeesh@gmail.com', '5f9395ec92327002dd368375c74f5a3a', 'profile2.png', 'supplier', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `businessregistration`
--
ALTER TABLE `businessregistration`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_user` (`user_id`);

--
-- Indexes for table `orderhistory`
--
ALTER TABLE `orderhistory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_oh_user` (`user_id`);

--
-- Indexes for table `ordertable`
--
ALTER TABLE `ordertable`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ot_user` (`user_id`),
  ADD KEY `idx_ot_pid` (`pid`),
  ADD KEY `idx_ot_orderid` (`orderid`);

--
-- Indexes for table `production`
--
ALTER TABLE `production`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_production_pid` (`pid`),
  ADD KEY `idx_production_user` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_users_user_id` (`user_id`),
  ADD UNIQUE KEY `uq_users_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `businessregistration`
--
ALTER TABLE `businessregistration`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orderhistory`
--
ALTER TABLE `orderhistory`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `ordertable`
--
ALTER TABLE `ordertable`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `production`
--
ALTER TABLE `production`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `businessregistration`
--
ALTER TABLE `businessregistration`
  ADD CONSTRAINT `fk_business_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orderhistory`
--
ALTER TABLE `orderhistory`
  ADD CONSTRAINT `fk_oh_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `ordertable`
--
ALTER TABLE `ordertable`
  ADD CONSTRAINT `fk_ot_product` FOREIGN KEY (`pid`) REFERENCES `production` (`pid`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ot_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `production`
--
ALTER TABLE `production`
  ADD CONSTRAINT `fk_production_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
