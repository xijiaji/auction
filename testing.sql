-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 02, 2023 at 02:53 PM
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
  `auctionStatus` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `sellerName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Auction`
--

INSERT INTO `Auction` (`auctionID`, `title`, `itemCondition`, `description`, `category`, `startDate`, `startingPrice`, `reservePrice`, `endDate`, `noBid`, `auctionStatus`, `sellerName`) VALUES
(7, 'Tesla 3', 'New', 'sfasdf', 'business', '2023-11-01 20:44:39', 30000, 45000, '2023-11-15 20:44:00', 0, 'Opened', 'cmcjas'),
(8, 'rtx 4090', 'Used', 'best gpu ', 'electronic', '2023-11-01 20:48:14', 800, 950, '2023-11-15 20:48:00', 0, 'Opened', 'cmcjas'),
(9, 'lawn mower', 'Others', 'cutting grass', 'home', '2023-11-01 21:02:38', 150, 200, '2023-11-14 21:02:00', 0, 'Opened', 'cmcjas'),
(10, 'coco cola', 'New', 'package of cans of cokes', 'food', '2023-11-01 21:09:03', 5, 9, '2023-11-10 21:09:00', 0, 'Opened', 'cmcjas'),
(11, 'facial cream', 'New', 'improve skin', 'health', '2023-11-01 23:39:58', 15, 20, '2023-11-19 23:39:00', 0, 'Opened', 'Hey');

-- --------------------------------------------------------

--
-- Table structure for table `Bid`
--

CREATE TABLE `Bid` (
  `bidID` int NOT NULL,
  `price` float NOT NULL,
  `bidDate` date NOT NULL,
  `status` varchar(100) NOT NULL,
  `buyerName` varchar(100) NOT NULL,
  `auctionID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(17, 'seller', 'Hey@example.com', 'Hey', '$2y$10$VUwMUNpYprV0ih7QXMop4O0tnjL2g7a8iV85LbQvibVfYwjK56po6');

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
  MODIFY `auctionID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `Bid`
--
ALTER TABLE `Bid`
  MODIFY `bidID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
