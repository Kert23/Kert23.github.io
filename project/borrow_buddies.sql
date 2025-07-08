-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2025 at 04:30 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `borrow_buddies`
--
CREATE DATABASE IF NOT EXISTS `borrow_buddies` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `borrow_buddies`;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--
-- Creation: Jul 07, 2025 at 01:34 PM
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `admins`:
--

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `password`) VALUES
(1, 'admin', '240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--
-- Creation: Jul 07, 2025 at 05:05 PM
-- Last update: Jul 08, 2025 at 12:46 PM
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'available',
  `quantity` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `items`:
--

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `item_name`, `description`, `status`, `quantity`) VALUES
(1, 'Mac Keyboard', 'Apple keyboard for lab use', 'available', 100),
(2, 'Mac Mouse', 'Apple magic mouse for Mac units', 'available', 100),
(3, 'HDMI Cable', 'Standard HDMI for presentations', 'available', 100),
(4, 'USB-C Adapter', 'Used for connecting USB-C to USB-A', 'available', 100),
(5, 'VGA Adapter', 'Used to connect older monitors', 'available', 100),
(6, 'Power Cable', 'Standard power cable for laptops', 'available', 100),
(7, 'External Hard Drive', 'Used for backing up student files', 'available', 100),
(8, 'Audio Headset', 'Noise-canceling headset for multimedia', 'available', 100),
(9, 'Scientific Calculator', 'Used during math/science lab', 'available', 100),
(10, 'Ethernet Cable', 'LAN cable for stable internet connection', 'available', 100);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--
-- Creation: Jul 07, 2025 at 01:34 PM
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `student_id` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `course` varchar(50) DEFAULT NULL,
  `year_level` int(11) DEFAULT NULL,
  PRIMARY KEY (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `students`:
--

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `name`, `course`, `year_level`) VALUES
('202212054', 'Khurt Ghenesys M. Vasquez', 'BSITWMA', 2);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--
-- Creation: Jul 07, 2025 at 05:14 PM
-- Last update: Jul 08, 2025 at 12:46 PM
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` varchar(20) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `borrow_date` datetime NOT NULL,
  `return_date` datetime DEFAULT NULL,
  `status` enum('borrowed','returned') DEFAULT 'borrowed',
  `quantity` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`transaction_id`),
  KEY `student_id` (`student_id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `transactions`:
--   `student_id`
--       `students` -> `student_id`
--   `item_id`
--       `items` -> `item_id`
--

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`);
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
