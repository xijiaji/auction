-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 28, 2023 at 06:19 PM
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

--
-- Dumping data for table `Auction`
--

INSERT INTO `Auction` (`auctionID`, `title`, `itemCondition`, `description`, `category`, `startDate`, `startingPrice`, `reservePrice`, `winningPrice`, `endDate`, `mailSent`, `numBid`, `winnerID`, `imgFileName`, `sellerID`) VALUES
(44, 'LAVER CUP BLADE 98 (16X19) V8 TENNIS RACKET', 'New', 'Most popular Blade racket that features colors and design details from the 2023 Laver Cup. The Blade 98 (16x19) V8 is highlighted by FORTYFIVEª lay-up technology, which increases flex and stability to create a more connected-to-the-ball feel.', 'racket', '2023-11-27 20:03:27', 205, 280, 220, '2023-12-08 20:03:00', 'FALSE', 2, 'None', '6564f60fa59df4.31920427.png', 26),
(46, 'EARTH DAY BLADE 98 (16X19) V8 TENNIS RACKET', 'New', 'The Earth Day Blade 98 (16x19) v8 pairs eco-friendly design with a new layup to better accommodate the more modern, vertical swing path commonly used by competitive players. Equipped with water-based paint, Agiplast bumpers and grommets along with a biodegradable grip, this racket aims to take a step forward to a more sustainable future for the tennis industry.', 'racket', '2023-11-27 20:06:44', 230, 260, 230, '2023-12-10 20:06:00', 'FALSE', 1, 'None', '6564f6d4ce0471.13240816.png', 26),
(47, 'EARTH DAY CLASH 100 V2 TENNIS RACKET', 'Used - good', 'The hero model of the groundbreaking and immensely popular Clash line, the Earth Day Clash 100 v2 revises the recipe for more consistency within a more sustainable, eco-friendly design. An immediate appeal for its blend of flexibility and stability for a feeling unlike any other, this racket elevates playability thanks to a revised construction at the tip of the hoop that significantly enlarges the sweet spot.', 'racket', '2023-11-27 20:11:47', 210, 270, 210, '2023-12-07 20:11:00', 'FALSE', 1, 'None', '6564f80329c188.15962541.png', 26),
(48, 'ULTRA PRO (16X19) V4 TENNIS RACKET', 'Used - fair', 'One of two Ultra Pro frames developed for advanced players, the Ultra Pro (16x19) V4 stacks slick, alluring design with powerful performance fit for pro-caliber skills. Equipped with a thin beam and a notable head-light balance that prioritizes control and feel for the ball, this racket also offers up an open string pattern that enables more topspin and responsiveness off the string bed.', 'racket', '2023-11-27 20:13:34', 190, 235, 200, '2023-12-10 20:13:00', 'FALSE', 2, 'None', '6564f86e7a3827.79237776.png', 26),
(49, 'RF DNA 12 PACK', 'Used - fair', 'The latest evolution of the RF DNA 12 Pack embodies the premium, classic style of Roger collection with state-of-the-art design and functionality for tennis players.', 'ball', '2023-11-27 20:16:48', 100, 160, 125, '2023-12-08 20:16:00', 'FALSE', 3, 'None', '6564f9302ba2f1.20728537.png', 28),
(50, 'TEAM BACKPACK', 'Used - good', 'If you walk or bike to the tennis courts, a backpack can be a more comfortable (and versatile) option than a racket bag. Team Backpack is a great compact choice for players who need space for one-to-two tennis rackets, a change of clothes and a few other pieces of gear.', 'bag', '2023-11-27 20:20:16', 30, 45, 35, '2023-12-07 20:20:00', 'FALSE', 2, 'None', '6564fa00e28a23.49567105.png', 28),
(51, 'PRO STAFF V14 SUPER TOUR DUFFEL', 'New', 'One for the high-level tennis player. This Wilson duffel bag has all the clean appeal of our Pro Staff franchise with a simple, no-frills design. Pack gear like clothes and balls into the main compartment, and stash smaller items into the accessory pocket.', 'bag', '2023-11-27 20:25:31', 40, 60, 55, '2023-12-06 20:25:00', 'FALSE', 4, 'None', '6564fb3bbf48b0.53152056.png', 28),
(52, 'TRINITI 4 BALL SLEEVE', 'New', 'The first performance tennis ball designed with 100% recyclable packaging, Triniti pushes the limits of sustainable performance. Featuring a unique octagonal paper container, the Triniti sleeve is fully recyclable after use.', 'ball', '2023-11-27 20:27:28', 7, 10, 17, '2023-11-29 20:27:00', 'FALSE', 5, 'None', '6564fbb0ee0076.59326008.png', 27),
(53, 'ROLAND-GARROS MINI JUMBO BALL', 'Used - good', 'This Roland-Garros Mini Jumbo Ball doubles as a great display piece in your home or an excellent souvenir with autographs from tennis players.', 'ball', '2023-11-27 20:28:35', 15, 20, 16, '2023-12-08 20:28:00', 'FALSE', 2, 'None', '6564fbf3ce3843.99350457.png', 27),
(55, 'KAOS MIRAGE MEN TENNIS SHOE', 'New', 'Developed from jet fighter inspiration, the Kaos Mirage combines innovative Kaos Chassis Technology with an incredibly sleek, lightweight design for ultimate on-court acceleration and agility.', 'shoe', '2023-11-27 20:40:10', 110, 150, 135, '2023-12-08 20:40:00', 'FALSE', 4, 'None', '6564feaa657980.76578622.png', 27),
(56, 'RUSH PRO 4.0 CLAY PARIS EDITION WOMEN TENNIS SHOE', 'Used - good', 'Featuring a unique design crafted by French graffiti artist Hope, the Rush Pro 4.0 Clay Paris Edition combines head-turning style with awe-inspiring performance.', 'shoe', '2023-11-27 20:42:14', 110, 135, 120, '2023-12-07 20:42:00', 'FALSE', 2, 'None', '6564ff262ca549.56953588.png', 26),
(57, 'RUSH PRO 4.0 QL JUNIOR TENNIS SHOE', 'New', 'The Rush Pro 4.0 QL Jr makes it easier than ever to put your shoes on and take them off with Quicklace, a technology that applies one-pull tightening in place of traditional laces.', 'shoe', '2023-11-27 20:43:00', 50, 64, 55, '2023-12-06 20:42:00', 'FALSE', 2, 'None', '6564ff541e31d1.56581743.png', 26),
(58, 'TEAM II WOVEN JACKET MEN', 'New', 'The Team II Woven Jacket consists of a polyester fabric with mesh lining and a shaped hem for excellent movement from sideline to sideline. This relaxed full-zip warm up jacket will help elevate your game when the temperature drops.', 'appeal', '2023-11-27 20:44:04', 45, 60, 55, '2023-12-07 20:44:00', 'FALSE', 3, 'None', '6564ff94188dc1.09987563.png', 26),
(59, 'TEAM II POLO MEN', 'New', 'Take the court with confidence in this 3-button Team II Polo. Highlighted by knit contrast details at the sleeve cuffs and collar, this performance polyester top serves up a professional look with an emphasis on comfort and optimal movement.', 'appeal', '2023-11-27 20:45:09', 55, 65, 55, '2023-12-08 20:45:00', 'FALSE', 1, 'None', '6564ffd577a032.01711663.png', 28),
(60, 'TEAM II 3.5\" SHORT', 'New', 'Equipped with rib knit v-notch side vents and built-in compression shorts, the Team II 3.5\" Short provides ample breathability and stability for tennis practices and matches on game day.', 'appeal', '2023-11-27 20:45:55', 27, 30, 30, '2023-12-06 20:45:00', 'FALSE', 2, 'None', '65650003e80066.55717794.png', 28),
(61, '75 BALL PICK-UP HOPPER', 'Used - good', 'Equipped with rib knit v-notch side vents and built-in compression shorts, the Team II 3.5\" Short provides ample breathability and stability for tennis practices and matches on game day.', 'other', '2023-11-27 20:47:09', 28, 40, 30, '2023-12-09 20:47:00', 'FALSE', 3, 'None', '6565004d7861f3.39247696.png', 28),
(62, 'STARTER EZ TENNIS NET 10', 'New', 'The Starter EZ Tennis Net makes it possible to build a tennis court in your own backyard - no tools needed. Easy to set up and tear down within minutes, this net is 10 feet long and includes a carrying case for excellent portability.', 'other', '2023-11-27 20:49:02', 100, 120, 110, '2023-12-08 20:49:00', 'FALSE', 2, 'None', '656500bec19412.03985331.png', 27),
(63, 'MARKER SPOTS', 'Used - fair', 'A versatile tool for tennis players and coaches, Marker Spots are useful for drills and on-court games. Featuring an assorted color pack that all lay flat on the ground for minimal interference, these spots can be useful for footwork drills, target practice or a variety of games for players honing their craft.', 'other', '2023-11-27 20:50:07', 20, 35, 23, '2023-12-07 20:50:00', 'FALSE', 3, 'None', '656500ff846594.43266123.png', 27);

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

--
-- Dumping data for table `Bid`
--

INSERT INTO `Bid` (`bidID`, `price`, `bidDate`, `buyerID`, `auctionID`) VALUES
(154, 45, '2023-11-27 20:51:15', 24, 51),
(155, 30, '2023-11-27 20:51:51', 24, 60),
(156, 120, '2023-11-27 20:52:13', 24, 56),
(157, 10, '2023-11-27 20:52:59', 25, 52),
(158, 15, '2023-11-27 20:54:24', 25, 52),
(159, 35, '2023-11-27 20:54:38', 25, 50),
(160, 120, '2023-11-27 20:55:05', 25, 49),
(161, 110, '2023-11-27 21:06:20', 25, 62),
(162, 55, '2023-11-27 21:11:16', 31, 57),
(163, 50, '2023-11-27 21:12:39', 31, 58),
(164, 55, '2023-11-27 21:15:12', 31, 58),
(165, 50, '2023-11-27 21:15:26', 31, 51),
(166, 22, '2023-11-27 21:15:40', 31, 63),
(167, 16, '2023-11-27 21:17:47', 30, 52),
(168, 23, '2023-11-27 21:18:04', 30, 63),
(169, 220, '2023-11-27 21:18:19', 30, 44),
(170, 16, '2023-11-27 21:18:48', 30, 53),
(171, 125, '2023-11-27 21:20:48', 30, 49),
(172, 29, '2023-11-27 21:21:05', 30, 61),
(173, 30, '2023-11-27 21:21:36', 30, 61),
(174, 120, '2023-11-27 21:38:11', 25, 55),
(175, 17, '2023-11-27 23:12:36', 25, 52),
(176, 130, '2023-11-27 23:14:18', 25, 55),
(177, 135, '2023-11-27 23:15:22', 31, 55),
(178, 55, '2023-11-28 12:03:29', 25, 51),
(179, 200, '2023-11-28 12:22:54', 25, 48);

-- --------------------------------------------------------

--
-- Table structure for table `Transaction`
--

CREATE TABLE `Transaction` (
  `tID` int NOT NULL,
  `date` datetime NOT NULL,
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
(24, 'buyer', 'jason_chan_12@hotmail.com', 'buyer2', 'Jason', 'Chan', '$2y$10$6hhYdRROJAtAOVhLyDZPVONrAwcEcbSkjMnw2SpCkYMBo7QsAhG3e', '07786471235', 'University College London\r\nGower Street\r\nLondon WC1E 6BT\r\nUK'),
(25, 'buyer', 'cmcjas@example.com', 'buyer1', 'Jackson', 'Cheung', '$2y$10$KenZw23NAr5unZIhj0IKDOZpENSgdYZKSQrp8wPyPXdfhyq4bTRju', '07786471235', 'University College London\r\nGower Street\r\nLondon WC1E 6BT\r\nUK'),
(26, 'seller', 'Hey@example.com', 'seller1', 'Harry', 'White', '$2y$10$LQ.bowaCFPA5Lp/ToGPk9eKvGjwwyu86D7tftl2qIWLUn1uzfySnK', '07786471235', 'Torrington Pl, London WC1E 7JE'),
(27, 'seller', 'guy@testing.com', 'boy', 'Songyang', 'Chen', '$2y$10$DR/isrZtNx6oIDenKeStuOtNqte/0apw6lHE0keagaQ4ifqCf.wxW', '07786471235', 'Torrington Pl, London WC1E 7JE'),
(28, 'seller', 'lady@testing.com', 'girl', 'Yunxi', 'Huang', '$2y$10$L5bARQvve3McVwgTLjUgKeXFaPpcRYX2PhxPMH6wRCjmvGovdnsky', '07786471235', 'Torrington Pl, London WC1E 7JE'),
(30, 'buyer', 'distance@testing.com', 'd94', 'dean', 'grey', '$2y$10$ZjnBwjou0z1rRoe4OyXiCufKajQcMQKKKE.1V9pCWRNJgxlN6p.De', '07786471235', '74 Pelham Road'),
(31, 'buyer', 'dsy124@berkeley.edu', 'bear', 'Shuyi', 'Deng', '$2y$10$VodXlgebhHWNMh1llyyHf.UwfgF5oxHiNtuSbPZQVtQCpuPWbci4a', '07786471235', 'University College London Gower Street London WC1E 6BT UK');

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
-- Dumping data for table `Watchlist`
--

INSERT INTO `Watchlist` (`WID`, `buyerID`, `auctionID`) VALUES
(45, 24, '52'),
(46, 24, '44'),
(47, 25, '58'),
(49, 25, '47'),
(50, 31, '53'),
(51, 30, '56'),
(52, 30, '58'),
(53, 25, '56'),
(56, 24, '51');

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
  MODIFY `auctionID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `Bid`
--
ALTER TABLE `Bid`
  MODIFY `bidID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- AUTO_INCREMENT for table `Transaction`
--
ALTER TABLE `Transaction`
  MODIFY `tID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `Watchlist`
--
ALTER TABLE `Watchlist`
  MODIFY `WID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
