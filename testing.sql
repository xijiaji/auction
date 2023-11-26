-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 26, 2023 at 03:04 PM
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
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `category` varchar(100) NOT NULL,
  `startDate` datetime NOT NULL,
  `startingPrice` float NOT NULL,
  `reservePrice` float NOT NULL,
  `winningPrice` float NOT NULL,
  `endDate` datetime NOT NULL,
  `mailSent` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'FALSE',
  `numBid` int NOT NULL,
  `winnerID` varchar(100) NOT NULL,
  `imgFileName` varchar(200) NOT NULL,
  `sellerID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Bid`
--

CREATE TABLE `Bid` (
  `bidID` int NOT NULL,
  `price` float NOT NULL,
  `bidDate` datetime NOT NULL,
  `buyerID` int NOT NULL,
  `auctionID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Transaction`
--

CREATE TABLE `Transaction` (
  `tID` int NOT NULL,
  `date` datetime NOT NULL,
  `amount` float NOT NULL,
  `status` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
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
  `userName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `phone` varchar(100) NOT NULL,
  `shippingAddress` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`id`, `type`, `email`, `userName`, `firstName`, `lastName`, `password`, `phone`, `shippingAddress`) VALUES
(1, 'buyer', 'dsy124@berkeley.edu', 'bear', 'Shuyi', 'Deng', '12345678', '07786471235', 'University College London\r\nGower Street\r\nLondon WC1E 6BT\r\nUK'),
(24, 'buyer', 'jason_chan_12@hotmail.com', 'jason94', 'Jason', 'Chan', '$2y$10$6hhYdRROJAtAOVhLyDZPVONrAwcEcbSkjMnw2SpCkYMBo7QsAhG3e', '07786471235', 'University College London\r\nGower Street\r\nLondon WC1E 6BT\r\nUK'),
(25, 'buyer', 'cmcjas@example.com', 'cmcjas', 'Jackson', 'Cheung', '$2y$10$KenZw23NAr5unZIhj0IKDOZpENSgdYZKSQrp8wPyPXdfhyq4bTRju', '07786471235', 'University College London\r\nGower Street\r\nLondon WC1E 6BT\r\nUK'),
(26, 'seller', 'Hey@example.com', 'hey', 'Harry', 'White', '$2y$10$LQ.bowaCFPA5Lp/ToGPk9eKvGjwwyu86D7tftl2qIWLUn1uzfySnK', '07786471235', 'Torrington Pl, London WC1E 7JE'),
(27, 'buyer', 'guy@testing.com', 'boy', 'Songyang', 'Chen', '$2y$10$DR/isrZtNx6oIDenKeStuOtNqte/0apw6lHE0keagaQ4ifqCf.wxW', '07786471235', 'University College London\r\nGower Street\r\nLondon WC1E 6BT\r\nUK'),
(28, 'seller', 'lady@testing.com', 'girl', 'Yunxi', 'Huang', '$2y$10$L5bARQvve3McVwgTLjUgKeXFaPpcRYX2PhxPMH6wRCjmvGovdnsky', '07786471235', 'Torrington Pl, London WC1E 7JE'),
(30, 'buyer', 'distance@testing.com', 'd94', 'dean', 'grey', '$2y$10$ZjnBwjou0z1rRoe4OyXiCufKajQcMQKKKE.1V9pCWRNJgxlN6p.De', '07786471235', '74 Pelham Road');

-- --------------------------------------------------------

--
-- Table structure for table `Watchlist`
--

CREATE TABLE `Watchlist` (
  `WID` int NOT NULL,
  `buyerID` int NOT NULL,
  `auctionID` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Auction`
--
ALTER TABLE `Auction`
  ADD PRIMARY KEY (`auctionID`),
  ADD UNIQUE KEY `imgFileName` (`imgFileName`),
  ADD KEY `winnerID` (`winnerID`),
  ADD KEY `sellerID` (`sellerID`);

--
-- Indexes for table `Bid`
--
ALTER TABLE `Bid`
  ADD PRIMARY KEY (`bidID`),
  ADD KEY `buyerID` (`buyerID`),
  ADD KEY `auctionID` (`auctionID`);

--
-- Indexes for table `Transaction`
--
ALTER TABLE `Transaction`
  ADD PRIMARY KEY (`tID`),
  ADD KEY `auctionID` (`auctionID`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `userName` (`userName`);

--
-- Indexes for table `Watchlist`
--
ALTER TABLE `Watchlist`
  ADD PRIMARY KEY (`WID`),
  ADD KEY `buyerID` (`buyerID`),
  ADD KEY `auctionID` (`auctionID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Auction`
--
ALTER TABLE `Auction`
  MODIFY `auctionID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `Bid`
--
ALTER TABLE `Bid`
  MODIFY `bidID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT for table `Transaction`
--
ALTER TABLE `Transaction`
  MODIFY `tID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `Watchlist`
--
ALTER TABLE `Watchlist`
  MODIFY `WID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
