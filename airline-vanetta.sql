-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2024 at 09:33 AM
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
-- Database: `airline`
--

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `B_id` int(11) NOT NULL,
  `Amount` double NOT NULL,
  `B_name` varchar(255) NOT NULL,
  `Card_no` int(255) NOT NULL,
  `Expiry` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`B_id`, `Amount`, `B_name`, `Card_no`, `Expiry`) VALUES
(1, 0, 'jjohn doe', 1234, '0000-00-00'),
(2, 0, 'jjohn doe', 1234, '0000-00-00'),
(3, 0, 'jjohn doe', 1234, '0000-00-00'),
(4, 0, 'jjohn doe', 2147483647, '2024-11-28'),
(5, 0, 'jjohn doe', 2147483647, '2024-11-28'),
(6, 0, 'jjohn doe', 2147483647, '2024-11-16');

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
  `capacity` int(11) NOT NULL DEFAULT 60
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flight`
--

INSERT INTO `flight` (`F_id`, `F_no`, `status`, `From_location`, `To_location`, `Arrival_time`, `Departure_time`, `P_eco`, `P_bus`, `capacity`) VALUES
(2, '12345', '', 'goa', 'mumbai', '15:59:00', '15:59:00', 9000, 0, 0),
(4, '123', '', 'dubai', 'goa', '13:14:00', '18:13:00', 12000, 0, 0),
(6, '345', '', 'goa', 'mumbai', '03:03:00', '02:05:00', 3400, 0, 0);

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
  `class` enum('Economy','Business') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `passenger`
--
DELIMITER $$
CREATE TRIGGER `after_passenger_insert` AFTER INSERT ON `passenger` FOR EACH ROW BEGIN
    DECLARE seat_number INT;

    -- Generate a random seat number (assuming seat numbers range from 1 to 200)
    SET seat_number = FLOOR(1 + (RAND() * 200));

    -- Insert into Ticket table using the new Passenger ID and other relevant data
    INSERT INTO ticket (P_id, F_id, class, seat_no, T_date)
    VALUES (NEW.P_id, NEW.F_id, NEW.class, seat_number, NOW());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `seat`
--

CREATE TABLE `seat` (
  `seat_id` int(11) NOT NULL,
  `flight_id` int(11) DEFAULT NULL,
  `seat_number` varchar(5) DEFAULT NULL,
  `is_booked` tinyint(1) DEFAULT 0,
  `pnr_number` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `Fname` text NOT NULL,
  `Lname` text NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `age` int(2) UNSIGNED NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `phone_number` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  ADD UNIQUE KEY `pnr_number` (`pnr_number`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `flight_id` (`flight_id`);

--
-- Indexes for table `flight`
--
ALTER TABLE `flight`
  ADD PRIMARY KEY (`F_id`),
  ADD UNIQUE KEY `F_no` (`F_no`);

--
-- Indexes for table `passenger`
--
ALTER TABLE `passenger`
  ADD PRIMARY KEY (`P_id`),
  ADD UNIQUE KEY `Passport_no` (`Passport_no`),
  ADD UNIQUE KEY `pnr` (`pnr`);

--
-- Indexes for table `seat`
--
ALTER TABLE `seat`
  ADD PRIMARY KEY (`seat_id`),
  ADD KEY `flight_id` (`flight_id`),
  ADD KEY `pnr_number` (`pnr_number`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `password` (`password`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `B_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flight`
--
ALTER TABLE `flight`
  MODIFY `F_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `passenger`
--
ALTER TABLE `passenger`
  MODIFY `P_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `seat`
--
ALTER TABLE `seat`
  MODIFY `seat_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`flight_id`) REFERENCES `flight` (`F_id`);

--
-- Constraints for table `passenger`
--
ALTER TABLE `passenger`
  ADD CONSTRAINT `pnr` FOREIGN KEY (`pnr`) REFERENCES `booking` (`pnr_number`);

--
-- Constraints for table `seat`
--
ALTER TABLE `seat`
  ADD CONSTRAINT `seat_ibfk_1` FOREIGN KEY (`flight_id`) REFERENCES `flight` (`F_id`),
  ADD CONSTRAINT `seat_ibfk_2` FOREIGN KEY (`pnr_number`) REFERENCES `booking` (`pnr_number`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
