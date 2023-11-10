-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 10, 2023 at 09:34 AM
-- Server version: 8.0.34-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testing`
--

-- --------------------------------------------------------

--
-- Table structure for table `Auction`
--

CREATE TABLE `Auction` (
  `auctionID` int NOT NULL,
  `title` varchar(100) NOT NULL,
  `itemCondition` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` varchar(200) NOT NULL,
  `category` varchar(100) NOT NULL,
  `startDate` datetime NOT NULL,
  `startingPrice` float NOT NULL,
  `reservePrice` float NOT NULL,
  `endDate` datetime NOT NULL,
  `noBid` int NOT NULL,
  `winner` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `sellerName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Auction`
--

INSERT INTO `Auction` (`auctionID`, `title`, `itemCondition`, `description`, `category`, `startDate`, `startingPrice`, `reservePrice`, `endDate`, `noBid`, `winner`, `sellerName`) VALUES
(7, 'Tesla 3', 'New', 'sfasdf', 'business', '2023-11-01 20:44:39', 460000, 450000, '2023-11-15 20:44:00', 3, 'None', 'cmcjas'),
(8, 'rtx 4090', 'Used', 'best gpu ', 'electronic', '2023-11-01 20:48:14', 1125, 950, '2023-11-15 20:48:00', 7, 'None', 'cmcjas'),
(9, 'lawn mower', 'Others', 'cutting grass', 'home', '2023-11-01 21:02:38', 210, 200, '2023-11-14 21:02:00', 3, 'None', 'cmcjas'),
(10, 'coco cola', 'New', 'package of cans of cokes', 'food', '2023-11-01 21:09:03', 85, 9, '2023-11-10 21:09:00', 18, 'None', 'cmcjas'),
(11, 'facial cream', 'New', 'improve skin', 'health', '2023-11-01 23:39:58', 33, 20, '2023-11-19 23:39:00', 6, 'None', 'Hey'),
(12, 'Pikachu stickers', 'New', 'cute stickers!', 'miscellaneous', '2023-11-10 01:29:51', 8, 6, '2023-11-30 01:29:00', 3, 'None', 'cmcjas');

-- --------------------------------------------------------

--
-- Table structure for table `Bid`
--

CREATE TABLE `Bid` (
  `bidID` int NOT NULL,
  `price` float NOT NULL,
  `bidDate` datetime NOT NULL,
  `buyerName` varchar(100) NOT NULL,
  `auctionID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Bid`
--

INSERT INTO `Bid` (`bidID`, `price`, `bidDate`, `buyerName`, `auctionID`) VALUES
(4, 10, '2023-11-03 02:34:39', 'qiting', 10),
(5, 15, '2023-11-03 02:34:51', 'qiting', 10),
(6, 20, '2023-11-03 02:35:11', 'Jason ', 10),
(7, 30, '2023-11-03 02:48:23', 'qiting', 10),
(9, 320000, '2023-11-03 13:17:06', 'qiting', 7),
(10, 200, '2023-11-03 13:40:37', 'Jason ', 9),
(11, 35, '2023-11-03 13:40:49', 'Jason ', 10),
(12, 210, '2023-11-03 13:41:23', 'qiting', 9),
(13, 20, '2023-11-03 15:11:17', 'qiting', 11),
(14, 40, '2023-11-09 22:18:54', 'qiting', 10),
(15, 45, '2023-11-09 22:21:01', 'Jason ', 10),
(16, 50, '2023-11-10 00:44:47', 'qiting', 10),
(17, 51, '2023-11-10 00:46:01', 'qiting', 10),
(18, 52, '2023-11-10 00:47:16', 'qiting', 10),
(19, 53, '2023-11-10 00:49:22', 'Jason ', 10),
(20, 60, '2023-11-10 00:50:09', 'qiting', 10),
(21, 65, '2023-11-10 00:50:58', 'Jason ', 10),
(22, 70, '2023-11-10 00:53:32', 'qiting', 10),
(23, 75, '2023-11-10 00:57:32', 'qiting', 10),
(24, 460000, '2023-11-10 00:58:51', 'qiting', 7),
(25, 80, '2023-11-10 00:59:25', 'Jason ', 10),
(26, 85, '2023-11-10 00:59:35', 'Jason ', 10),
(27, 1000, '2023-11-10 01:02:47', 'Jason ', 8),
(28, 1100, '2023-11-10 01:03:10', 'Jason ', 8),
(29, 1105, '2023-11-10 01:04:54', 'Jason ', 8),
(30, 1110, '2023-11-10 01:07:52', 'Jason ', 8),
(31, 1120, '2023-11-10 01:13:25', 'Jason ', 8),
(32, 1125, '2023-11-10 01:18:55', 'Jason ', 8),
(33, 25, '2023-11-10 01:26:22', 'Jason ', 11),
(34, 30, '2023-11-10 01:26:39', 'Jason ', 11),
(39, 32, '2023-11-10 01:43:22', 'Jason ', 11),
(43, 33, '2023-11-10 02:14:01', 'Jason ', 11),
(45, 7, '2023-11-10 02:29:27', 'Jason ', 12),
(46, 8, '2023-11-10 02:29:45', 'Jason ', 12);

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `id` int NOT NULL,
  `type` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`id`, `type`, `email`, `name`, `password`) VALUES
(11, 'seller', 'cmcjas@example.com', 'cmcjas', '$2y$10$BqTASZYhIkeATnc6n66B..sChthX/HSu.SDg5Ql7YSo/wiCt2.OLq'),
(13, 'buyer', 'jason_chan_12@hotmail.com', 'Jason ', '$2y$10$4aiQeUBkcMi/fpPu6C1vUOVRkVSjyhCnbxu489ulItcn/vC2d.Hee'),
(16, 'buyer', 'qtingwu0806@gmail.com', 'qiting', '$2y$10$ZRPUrri9rTzQ8w35fgzFJeKBLSLrmMy9sU.I/D0QbYswR.oXD/Goi'),
(17, 'seller', 'Hey@example.com', 'Hey', '$2y$10$VUwMUNpYprV0ih7QXMop4O0tnjL2g7a8iV85LbQvibVfYwjK56po6'),
(18, 'buyer', 'brighton_hale@hotmail.co.uk', 'mr hale', '$2y$10$.TIWVaKXXkhiLP/JnlsV2OMAs5CiGroTuOJkDS6ZNn7sczA6YOR6C');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Auction`
--
ALTER TABLE `Auction`
  ADD PRIMARY KEY (`auctionID`),
  ADD KEY `sellerName` (`sellerName`);

--
-- Indexes for table `Bid`
--
ALTER TABLE `Bid`
  ADD PRIMARY KEY (`bidID`),
  ADD KEY `buyerName` (`buyerName`),
  ADD KEY `auctionID` (`auctionID`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Auction`
--
ALTER TABLE `Auction`
  MODIFY `auctionID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `Bid`
--
ALTER TABLE `Bid`
  MODIFY `bidID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
