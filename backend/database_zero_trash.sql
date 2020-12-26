-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 26, 2020 at 08:14 PM
-- Server version: 5.7.32-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zero_trash`
--

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE `area` (
  `areaId` int(6) NOT NULL,
  `areaName` text NOT NULL,
  `collectingPointId` int(4) NOT NULL,
  `notes` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `branchId` int(5) NOT NULL,
  `lat` float NOT NULL,
  `lon` float NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `collected_materials`
--

CREATE TABLE `collected_materials` (
  `id` int(11) NOT NULL,
  `collectedOn` datetime NOT NULL,
  `materialId` int(5) NOT NULL,
  `pickupId` int(5) NOT NULL,
  `amount` float NOT NULL,
  `notes` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `collector`
--

CREATE TABLE `collector` (
  `collectorId` int(5) UNSIGNED NOT NULL,
  `phoneNo` varchar(10) NOT NULL,
  `name` text NOT NULL,
  `rateCount` int(4) UNSIGNED NOT NULL,
  `rateScore` float NOT NULL,
  `lastCollectionAttempt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `collector_area`
--

CREATE TABLE `collector_area` (
  `id` int(11) NOT NULL,
  `collectorId` int(6) NOT NULL,
  `areaId` int(6) NOT NULL,
  `experienceScore` float NOT NULL,
  `availibility` enum('AVAILABLE','NOT_VERIFIED','NOT_AVAILABLE') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customerId` int(6) UNSIGNED NOT NULL,
  `phoneNo` varchar(10) NOT NULL,
  `email` char(50) NOT NULL,
  `address1` char(64) DEFAULT NULL,
  `address2` char(64) DEFAULT NULL,
  `areaId` int(6) DEFAULT NULL,
  `city` char(32) DEFAULT NULL,
  `regDate` date NOT NULL,
  `regStatus` enum('ACTIVE','PENDING') NOT NULL,
  `password` char(64) NOT NULL,
  `loyality` int(4) UNSIGNED DEFAULT NULL,
  `customerType` char(20) NOT NULL,
  `language` enum('english','sinhala') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dashboard_data`
--

CREATE TABLE `dashboard_data` (
  `id` int(11) NOT NULL,
  `dKey` text NOT NULL,
  `dValue` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dashboard_data`
--

INSERT INTO `dashboard_data` (`id`, `dKey`, `dValue`) VALUES
(1, 'serverIP', ''),
(2, 'baseURL', 'http://localhost/dashboard/');

-- --------------------------------------------------------

--
-- Table structure for table `dashboard_services`
--

CREATE TABLE `dashboard_services` (
  `id` int(6) NOT NULL,
  `serviceCode` varchar(16) NOT NULL,
  `serviceName` text NOT NULL,
  `serviceIcon` text NOT NULL,
  `serviceURL` text NOT NULL,
  `servicePermission` int(3) NOT NULL,
  `serviceData` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dashboard_services`
--

INSERT INTO `dashboard_services` (`id`, `serviceCode`, `serviceName`, `serviceIcon`, `serviceURL`, `servicePermission`, `serviceData`) VALUES
(1001, 'admin', 'Admin', '', './', 2, ''),
(1002, 'dev', 'Developer', '', './', 2, ''),
(1003, 'betaTest', 'Beta Tester', '', './', 1, ''),
(1000, 'sudo', 'Super Admin', '', './', 2, ''),
(1004, 'category', 'Categorization', '', './', 0, ''),
(1005, 'material', 'Manage Material ', '', './', 0, ''),
(1006, 'analyze', 'Analyze', '', './', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `dashboard_users`
--

CREATE TABLE `dashboard_users` (
  `id` int(6) NOT NULL,
  `email` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `userStatus` enum('ACTIVE','PENDING','REJECTED') NOT NULL DEFAULT 'PENDING',
  `honorific` int(1) NOT NULL,
  `firstName` text NOT NULL,
  `lastName` text NOT NULL,
  `role` int(1) NOT NULL,
  `loginType` int(1) NOT NULL,
  `lastAccess` datetime NOT NULL,
  `imageURL` text,
  `profilePage` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dashboard_user_services`
--

CREATE TABLE `dashboard_user_services` (
  `id` int(8) NOT NULL,
  `userId` int(5) NOT NULL,
  `serviceCode` varchar(16) NOT NULL,
  `enabledOn` date NOT NULL,
  `enabledBy` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `materialId` int(5) NOT NULL,
  `materialName` varchar(128) NOT NULL,
  `materialDescription` text NOT NULL,
  `materialValue` float NOT NULL,
  `materialNotes` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`materialId`, `materialName`, `materialDescription`, `materialValue`, `materialNotes`) VALUES
(100, 'Glass Bottles', 'Test', 30, '1'),
(101, 'Plastics', 'Test2', 45, 'No '),
(102, 'Paper', 'Recyclable', 65, ''),
(103, 'Electronic', 'Re usable', 40, ''),
(104, 'Leather', 'Re usable', 90, ''),
(105, 'Cardboard', 'Cardboard - from Old boxes\r\nUpdated', 75, '');

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `offerId` int(5) UNSIGNED NOT NULL,
  `description` text,
  `caption` char(50) NOT NULL,
  `category` char(20) NOT NULL,
  `branchId` int(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE `organization` (
  `customerId` int(6) NOT NULL,
  `name` char(20) NOT NULL,
  `type` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pickups`
--

CREATE TABLE `pickups` (
  `pickupId` int(10) NOT NULL,
  `timeSlot` int(2) NOT NULL,
  `placedOn` datetime NOT NULL,
  `state` enum('PENDING','CONFIRMED','COMPLETED','INCOMPLETED','CANCLED') NOT NULL,
  `rating` int(1) DEFAULT NULL,
  `notes` text,
  `customerId` int(6) UNSIGNED NOT NULL,
  `collectorId` int(5) DEFAULT NULL,
  `address` text NOT NULL,
  `userPhone` varchar(10) NOT NULL,
  `geoLocation` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `regular_customer`
--

CREATE TABLE `regular_customer` (
  `customerId` int(6) UNSIGNED NOT NULL,
  `firstName` char(20) NOT NULL,
  `lastName` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`areaId`);

--
-- Indexes for table `collected_materials`
--
ALTER TABLE `collected_materials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `collector`
--
ALTER TABLE `collector`
  ADD PRIMARY KEY (`collectorId`);

--
-- Indexes for table `collector_area`
--
ALTER TABLE `collector_area`
  ADD PRIMARY KEY (`id`),
  ADD KEY `areaId` (`areaId`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customerId`),
  ADD UNIQUE KEY `customerId` (`customerId`),
  ADD UNIQUE KEY `phoneNo` (`phoneNo`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `dashboard_data`
--
ALTER TABLE `dashboard_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dashboard_services`
--
ALTER TABLE `dashboard_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dashboard_users`
--
ALTER TABLE `dashboard_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dashboard_user_services`
--
ALTER TABLE `dashboard_user_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`materialId`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`offerId`),
  ADD UNIQUE KEY `offerId` (`offerId`),
  ADD KEY `branchId` (`branchId`);

--
-- Indexes for table `organization`
--
ALTER TABLE `organization`
  ADD PRIMARY KEY (`customerId`);

--
-- Indexes for table `pickups`
--
ALTER TABLE `pickups`
  ADD PRIMARY KEY (`pickupId`);

--
-- Indexes for table `regular_customer`
--
ALTER TABLE `regular_customer`
  ADD PRIMARY KEY (`customerId`),
  ADD UNIQUE KEY `customerId` (`customerId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `areaId` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;
--
-- AUTO_INCREMENT for table `collected_materials`
--
ALTER TABLE `collected_materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `collector`
--
ALTER TABLE `collector`
  MODIFY `collectorId` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;
--
-- AUTO_INCREMENT for table `collector_area`
--
ALTER TABLE `collector_area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customerId` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10027;
--
-- AUTO_INCREMENT for table `dashboard_data`
--
ALTER TABLE `dashboard_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `dashboard_services`
--
ALTER TABLE `dashboard_services`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1007;
--
-- AUTO_INCREMENT for table `dashboard_users`
--
ALTER TABLE `dashboard_users`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100004;
--
-- AUTO_INCREMENT for table `dashboard_user_services`
--
ALTER TABLE `dashboard_user_services`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10023;
--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `materialId` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;
--
-- AUTO_INCREMENT for table `organization`
--
ALTER TABLE `organization`
  MODIFY `customerId` int(6) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pickups`
--
ALTER TABLE `pickups`
  MODIFY `pickupId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12253;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
