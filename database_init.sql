-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: May 10, 2025 at 08:10 PM
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
-- Database: `docksidedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `bkg_id` int(11) NOT NULL,
  `bkg_datein` date NOT NULL,
  `bkg_dateout` date NOT NULL,
  `bkg_totalpr` decimal(10,2) NOT NULL,
  `room_id` int(10) UNSIGNED NOT NULL,
  `pers_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `pers_id` int(5) UNSIGNED NOT NULL,
  `pers_fname` varchar(40) NOT NULL,
  `pers_lname` varchar(40) NOT NULL,
  `pers_address` varchar(255) NOT NULL,
  `pers_number` varchar(15) NOT NULL,
  `pers_birthdate` date NOT NULL,
  `pers_email` varchar(255) NOT NULL COMMENT 'should be unique. one account per email only.',
  `pers_pass` varchar(30) NOT NULL,
  `pers_role` varchar(4) NOT NULL DEFAULT 'CUST' COMMENT '"CUST" or "ADMN"'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`pers_id`, `pers_fname`, `pers_lname`, `pers_address`, `pers_number`, `pers_birthdate`, `pers_email`, `pers_pass`, `pers_role`) VALUES
(1, 'Lanz Alexander', 'Malto', 'Phase 1 Block 4 Lot 2 Aldea Homes, Brgy. Cangmating, Sibulan, Philippines', '1111-111-1111', '2002-11-23', 'lanzimalto@su.edu.ph', 'my_newpassword', 'CUST'),
(2, 'Gilbert', 'Malto', 'Phase 1 Block 4 Lot 2 Aldea Homes, Brgy. Cangmating, Sibulan, Philippines', '0000-000-0000', '1980-07-07', 'lanzbert@yahoo.com', 'adminlogin', 'CUST'),
(3, 'John', 'Doe', 'Makati City, NCR, Philippines', '0000-000-0000', '2001-01-01', 'jdoe12983@gmail.com', 'adminlogin', 'CUST'),
(4, 'Cheri', 'Mon', 'Secret St. Brgy. Secret', '0000-000-0000', '1900-01-01', 'abc@gmail.com', '123', 'CUST'),
(5, 'Admin', 'Account', 'Dockside Hotel, Dumaguete, City', '0000-000-0000', '2025-05-07', 'cdpo@dockstel.biz', 'adminlogin', 'ADMN'),
(6, 'Juan', 'Dela Cruz', '1000 M. Reyes St., Dumaguete City', '0000-000-0000', '2001-01-01', 'jdc8775_noypi@gmail.com', 'HelloWorld_!', 'CUST'),
(7, 'Ningning', 'Yuzhuo', 'Kwangya, Korea', '0000-000-0000', '2001-10-30', 'ningyuz320@gmail.com', 'butterfly_myae', 'CUST'),
(8, 'Test', 'History', '123 Booking History St., Dumaguete City', '9999-999-9999', '1990-05-15', 'admin@test.com', 'password123', 'CUST');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_id` int(11) UNSIGNED NOT NULL,
  `room_type` varchar(100) NOT NULL,
  `room_capacity` int(11) NOT NULL,
  `room_avail` enum('vacant','occupied','maintenance') NOT NULL DEFAULT 'vacant',
  `room_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_id`, `room_type`, `room_capacity`, `room_avail`, `room_price`) VALUES
(1, 'Presidential Suite', 4, 'occupied', 25000.00),
(2, 'Presidential Suite', 4, 'vacant', 25000.00),
(3, 'Executive Suite', 3, 'occupied', 18500.00),
(4, 'Executive Suite', 3, 'vacant', 18500.00),
(5, 'Executive Suite', 3, 'occupied', 18500.00),
(6, 'Deluxe Room', 2, 'vacant', 15000.00),
(7, 'Deluxe Room', 2, 'occupied', 15000.00),
(8, 'Deluxe Room', 2, 'vacant', 15000.00),
(9, 'Standard Room', 2, 'vacant', 11000.00),
(10, 'Standard Room', 2, 'occupied', 11000.00),
(11, 'Presidential Suite', 4, 'vacant', 25000.00),
(12, 'Executive Suite', 3, 'vacant', 18500.00),
(13, 'Executive Suite', 3, 'vacant', 18500.00),
(14, 'Executive Suite', 3, 'occupied', 18500.00),
(15, 'Deluxe Room', 2, 'vacant', 15000.00),
(16, 'Deluxe Room', 2, 'vacant', 15000.00),
(17, 'Deluxe Room', 2, 'occupied', 15000.00),
(18, 'Deluxe Room', 2, 'vacant', 15000.00),
(19, 'Standard Room', 2, 'occupied', 11000.00),
(20, 'Standard Room', 2, 'vacant', 11000.00);

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`bkg_id`, `bkg_datein`, `bkg_dateout`, `bkg_totalpr`, `room_id`, `pers_id`) VALUES
(1, '2025-05-09', '2025-05-12', 75000.00, 1, 3),
(2, '2025-05-10', '2025-05-15', 92500.00, 3, 1),
(3, '2025-05-08', '2025-05-13', 92500.00, 5, 6),
(4, '2025-05-07', '2025-05-11', 60000.00, 7, 4),
(5, '2025-05-10', '2025-05-12', 22000.00, 10, 2),
(6, '2025-04-25', '2025-04-30', 92500.00, 14, 7),
(7, '2025-06-01', '2025-06-05', 60000.00, 17, 1),
(8, '2025-06-15', '2025-06-20', 55000.00, 19, 6),
(9, '2025-03-15', '2025-03-20', 75000.00, 11, 2),
(10, '2025-07-01', '2025-07-10', 185000.00, 13, 3),
(11, '2024-12-20', '2024-12-25', 125000.00, 2, 8), 
(12, '2025-01-05', '2025-01-10', 92500.00, 4, 8),  
(13, '2025-02-14', '2025-02-16', 30000.00, 16, 8), 
(14, '2025-03-01', '2025-03-05', 44000.00, 9, 8),  
(15, '2025-04-10', '2025-04-15', 75000.00, 11, 8); 

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`bkg_id`),
  ADD KEY `fk_room` (`room_id`),
  ADD KEY `fk_person` (`pers_id`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`pers_id`),
  ADD UNIQUE KEY `pers_email` (`pers_email`),
  ADD UNIQUE KEY `pers_id` (`pers_id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`),
  ADD UNIQUE KEY `room_id` (`room_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `bkg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `pers_id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `fk_person` FOREIGN KEY (`pers_id`) REFERENCES `person` (`pers_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_room` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `room`
--
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
