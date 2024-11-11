-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2024 at 04:56 AM
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
-- Database: `airline`
--

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `B_id` int(11) NOT NULL,
  `Amount` double NOT NULL,
  `booking_id` int(255) NOT NULL,
  `payment_status` enum('pending','completed','failed') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`B_id`, `Amount`, `booking_id`, `payment_status`) VALUES
(1, 0, 0, 'pending'),
(2, 0, 0, 'pending'),
(3, 0, 0, 'pending'),
(4, 0, 0, 'pending'),
(5, 0, 0, 'pending'),
(6, 0, 0, 'pending'),
(7, 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `booking_id` int(11) NOT NULL,
  `pnr_number` varchar(5) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `flight_id` int(11) DEFAULT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`booking_id`, `pnr_number`, `user_id`, `flight_id`, `booking_date`, `total_amount`, `status`) VALUES
(12, '', 1, 1, '2024-11-10 20:34:50', 0.00, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `flight`
--

CREATE TABLE `flight` (
  `F_id` int(11) NOT NULL,
  `F_no` varchar(255) NOT NULL,
  `status` enum('on-time','delayed','cancelled') NOT NULL,
  `From_location` varchar(255) NOT NULL,
  `To_location` varchar(255) NOT NULL,
  `Arrival_time` time NOT NULL,
  `Departure_time` time NOT NULL,
  `P_eco` int(255) NOT NULL,
  `P_bus` int(11) NOT NULL,
  `capacity` int(11) NOT NULL DEFAULT 60,
  `Departure_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flight`
--

INSERT INTO `flight` (`F_id`, `F_no`, `status`, `From_location`, `To_location`, `Arrival_time`, `Departure_time`, `P_eco`, `P_bus`, `capacity`, `Departure_date`) VALUES
(2, '12345', '', 'goa', 'mumbai', '15:59:00', '15:59:00', 9000, 0, 0, NULL),
(4, '123', '', 'dubai', 'goa', '13:14:00', '18:13:00', 12000, 0, 0, NULL),
(6, '345', '', 'goa', 'mumbai', '03:03:00', '02:05:00', 3400, 0, 0, NULL),
(7, '123456788', 'on-time', 'goa', 'mumbai', '04:27:25', '09:27:25', 2300, 4500, 60, '2024-11-27');

-- --------------------------------------------------------

--
-- Table structure for table `passenger`
--

CREATE TABLE `passenger` (
  `P_id` int(11) NOT NULL,
  `pnr` varchar(5) NOT NULL,
  `Lname` varchar(100) NOT NULL,
  `Fname` varchar(100) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Passport_no` varchar(100) NOT NULL,
  `DOB` date NOT NULL,
  `Phone` int(10) DEFAULT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `class` enum('Economy','Business') NOT NULL,
  `F_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `passenger`
--

INSERT INTO `passenger` (`P_id`, `pnr`, `Lname`, `Fname`, `Email`, `Passport_no`, `DOB`, `Phone`, `gender`, `class`, `F_id`) VALUES
(2, 'R', 'dfsfsd', 'dsfsd', 'e', '', '2024-11-04', 2, '', 'Economy', 2),
(4, 'D', 'hjghg', 'oiouiuo', 'e', '', '2024-11-02', 2, 'Female', 'Economy', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(25) DEFAULT NULL,
  `last_name` varchar(25) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` enum('Male','Female','Others') DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `username` varchar(15) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `signup_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `age`, `gender`, `email`, `phone`, `username`, `password`, `signup_date`) VALUES
(1, 'yuthika', 'parab', 24, 'Male', 'pewe@gmail.com', '1234567890', 'poniti', 'password', '2024-11-10 22:38:16'),
(2, 'pan', 'peter', 23, 'Female', 'yuthika@gmail.com', '1234567899', 'ffdfd', '12345', '2024-11-11 03:54:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`B_id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `booking_ibfk_2` (`flight_id`);

--
-- Indexes for table `flight`
--
ALTER TABLE `flight`
  ADD PRIMARY KEY (`F_id`);

--
-- Indexes for table `passenger`
--
ALTER TABLE `passenger`
  ADD PRIMARY KEY (`P_id`),
  ADD KEY `F_id` (`F_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `B_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `flight`
--
ALTER TABLE `flight`
  MODIFY `F_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `passenger`
--
ALTER TABLE `passenger`
  MODIFY `P_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `passenger`
--
ALTER TABLE `passenger`
  ADD CONSTRAINT `passenger_ibfk_1` FOREIGN KEY (`F_id`) REFERENCES `flight` (`F_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
