-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 02, 2025 at 09:26 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `robinhood`
--
CREATE DATABASE IF NOT EXISTS `robinhood` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `robinhood`;

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

DROP TABLE IF EXISTS `donations`;
CREATE TABLE `donations` (
  `donation_id` int(11) NOT NULL,
  `donor_id` int(11) NOT NULL,
  `robinId` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `donations_backup`
--

DROP TABLE IF EXISTS `donations_backup`;
CREATE TABLE `donations_backup` (
  `donation_id` int(11) NOT NULL,
  `donor_id` int(11) NOT NULL,
  `robinId` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `donors`
--

DROP TABLE IF EXISTS `donors`;
CREATE TABLE `donors` (
  `donor_id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `aadhaar` varchar(12) NOT NULL,
  `contact` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `pincode` varchar(6) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `donors`
--
DROP TRIGGER IF EXISTS `before_delete_donor`;
DELIMITER $$
CREATE TRIGGER `before_delete_donor` BEFORE DELETE ON `donors` FOR EACH ROW BEGIN
    -- Backup the row being deleted from the donors table
    INSERT INTO donors_backup (donor_id,name,contact,email,address,aadhaar,username,password,pincode )VALUES (OLD.donor_id, OLD.name, OLD.contact,OLD.email,OLD.address, OLD.aadhaar,OLD.username,OLD.password,OLD.pincode); -- Adjust column names as per your table structure

    -- Backup the corresponding row from the donations table
    INSERT INTO donations_backup SELECT * FROM donations WHERE donor_id = OLD.donor_id;

    -- Backup the corresponding rows from the food table
    INSERT INTO food_backup SELECT * FROM food WHERE donation_id IN (SELECT donation_id FROM donations WHERE donor_id = OLD.donor_id);

    -- Delete the corresponding rows from the food table
    DELETE FROM food WHERE donation_id IN (SELECT donation_id FROM donations WHERE donor_id = OLD.donor_id);

    -- Delete the corresponding rows from the donations table
    DELETE FROM donations WHERE donor_id = OLD.donor_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `donors_backup`
--

DROP TABLE IF EXISTS `donors_backup`;
CREATE TABLE `donors_backup` (
  `donor_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `aadhaar` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `pincode` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

DROP TABLE IF EXISTS `food`;
CREATE TABLE `food` (
  `food_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `prep_time` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `donation_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `food_backup`
--

DROP TABLE IF EXISTS `food_backup`;
CREATE TABLE `food_backup` (
  `food_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `prep_time` time NOT NULL,
  `date` date NOT NULL,
  `donation_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pocs`
--

DROP TABLE IF EXISTS `pocs`;
CREATE TABLE `pocs` (
  `poc_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact` varchar(10) NOT NULL,
  `pincode` varchar(6) NOT NULL,
  `address` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `aadhaar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `robins`
--

DROP TABLE IF EXISTS `robins`;
CREATE TABLE `robins` (
  `robinId` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contactNumber` varchar(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `residential_address` varchar(255) NOT NULL,
  `aadhaarNo` varchar(255) NOT NULL,
  `pincode` varchar(6) NOT NULL,
  `poc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`donation_id`),
  ADD KEY `fk` (`donor_id`),
  ADD KEY `fk2` (`robinId`);

--
-- Indexes for table `donations_backup`
--
ALTER TABLE `donations_backup`
  ADD PRIMARY KEY (`donation_id`),
  ADD KEY `donor_id` (`donor_id`),
  ADD KEY `robinId` (`robinId`);

--
-- Indexes for table `donors`
--
ALTER TABLE `donors`
  ADD PRIMARY KEY (`donor_id`),
  ADD UNIQUE KEY `password` (`password`);

--
-- Indexes for table `donors_backup`
--
ALTER TABLE `donors_backup`
  ADD PRIMARY KEY (`donor_id`);

--
-- Indexes for table `food_backup`
--
ALTER TABLE `food_backup`
  ADD KEY `donation_id` (`donation_id`);

--
-- Indexes for table `pocs`
--
ALTER TABLE `pocs`
  ADD PRIMARY KEY (`poc_id`);

--
-- Indexes for table `robins`
--
ALTER TABLE `robins`
  ADD PRIMARY KEY (`robinId`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `donation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `donations_backup`
--
ALTER TABLE `donations_backup`
  MODIFY `donation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `donors`
--
ALTER TABLE `donors`
  MODIFY `donor_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `donors_backup`
--
ALTER TABLE `donors_backup`
  MODIFY `donor_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pocs`
--
ALTER TABLE `pocs`
  MODIFY `poc_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `robins`
--
ALTER TABLE `robins`
  MODIFY `robinId` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `fk` FOREIGN KEY (`donor_id`) REFERENCES `donors` (`donor_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk2` FOREIGN KEY (`robinId`) REFERENCES `robins` (`robinId`) ON DELETE CASCADE;

--
-- Constraints for table `donations_backup`
--
ALTER TABLE `donations_backup`
  ADD CONSTRAINT `donor_id_fk` FOREIGN KEY (`donor_id`) REFERENCES `donors_backup` (`donor_id`),
  ADD CONSTRAINT `robinId_fk` FOREIGN KEY (`robinId`) REFERENCES `robins` (`robinId`);

--
-- Constraints for table `food_backup`
--
ALTER TABLE `food_backup`
  ADD CONSTRAINT `donation_id_fk` FOREIGN KEY (`donation_id`) REFERENCES `donations_backup` (`donation_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
