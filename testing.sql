-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 15, 2023 at 04:53 PM
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
  `mailSent` varchar(100) NOT NULL,
  `noBid` int NOT NULL,
  `winner` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `imgFileName` varchar(200) NOT NULL,
  `sellerName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
-- Indexes for dumped tables
--

--
-- Indexes for table `Auction`
--
ALTER TABLE `Auction`
  ADD PRIMARY KEY (`auctionID`),
  ADD KEY `sellerName` (`sellerName`),
  ADD KEY `imgFileName` (`imgFileName`);

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
  MODIFY `auctionID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `Bid`
--
ALTER TABLE `Bid`
  MODIFY `bidID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
