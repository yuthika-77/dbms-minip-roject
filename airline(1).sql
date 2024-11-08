-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2024 at 07:22 PM
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
-- Table structure for table `flight`
--

CREATE TABLE `flight` (
  `F_id` int(11) NOT NULL,
  `Trip_type` varchar(100) NOT NULL,
  `F_no` varchar(255) NOT NULL,
  `Arrival_date` date NOT NULL,
  `Departure_date` date NOT NULL,
  `status` varchar(255) NOT NULL,
  `From_location` varchar(255) NOT NULL,
  `To_location` varchar(255) NOT NULL,
  `Arrival_time` time NOT NULL,
  `Departure_time` time NOT NULL,
  `Price` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flight`
--

INSERT INTO `flight` (`F_id`, `Trip_type`, `F_no`, `Arrival_date`, `Departure_date`, `status`, `From_location`, `To_location`, `Arrival_time`, `Departure_time`, `Price`) VALUES
(2, 'oneway', '12345', '2024-10-01', '2024-10-28', '', 'goa', 'mumbai', '15:59:00', '15:59:00', 9000),
(4, 'oneway', '123', '2024-10-28', '2024-10-19', '', 'dubai', 'goa', '13:14:00', '18:13:00', 12000),
(6, 'oneway', '345', '2024-11-07', '2024-10-28', '', 'goa', 'mumbai', '03:03:00', '02:05:00', 3400);

-- --------------------------------------------------------

--
-- Table structure for table `passenger`
--

CREATE TABLE `passenger` (
  `P_id` int(11) NOT NULL,
  `Lname` varchar(100) NOT NULL,
  `Fname` varchar(100) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Passport_no` varchar(100) NOT NULL,
  `DOB` date NOT NULL,
  `Phone` int(100) NOT NULL,
  `Category` varchar(100) NOT NULL,
  `Gender` varchar(5) NOT NULL,
  `F_id` int(11) NOT NULL,
  `class` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `passenger`
--

INSERT INTO `passenger` (`P_id`, `Lname`, `Fname`, `Email`, `Passport_no`, `DOB`, `Phone`, `Category`, `Gender`, `F_id`, `class`) VALUES
(1, 'specter', 'harvey', 'yutddfffffd@gmail.com', '', '0000-00-00', 2147483647, '', 'Male', 0, ''),
(2, 'dennison', 'kate', 'yuthika@gmail.com', '', '0000-00-00', 2147483647, '', 'Femal', 0, ''),
(3, 'wyler', 'hal', 'hika@gmail.com', '', '0000-00-00', 36748726, '', 'Male', 0, ''),
(4, 'specter', 'harvey', 'yutddfffffd@gmail.com', '', '0000-00-00', 2147483647, '', 'Male', 0, ''),
(5, 'dennison', 'kate', 'yuthika@gmail.com', '', '0000-00-00', 2147483647, '', 'Femal', 0, ''),
(6, 'wyler', 'hal', 'hika@gmail.com', '', '0000-00-00', 36748726, '', 'Male', 0, ''),
(7, 'specter', 'hal', 'yuthika@gmail.com', '', '0000-00-00', 2147483647, '', 'Femal', 2, 'B');

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
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `T_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `T_date` date NOT NULL,
  `seat_no` varchar(50) NOT NULL,
  `class` varchar(50) NOT NULL,
  `Total_fare` int(100) NOT NULL,
  `P_id` int(255) NOT NULL,
  `F_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`T_id`, `status`, `T_date`, `seat_no`, `class`, `Total_fare`, `P_id`, `F_id`) VALUES
(1, '', '2024-11-05', '184', 'B', 0, 7, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`B_id`);

--
-- Indexes for table `flight`
--
ALTER TABLE `flight`
  ADD PRIMARY KEY (`F_id`);

--
-- Indexes for table `passenger`
--
ALTER TABLE `passenger`
  ADD PRIMARY KEY (`P_id`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`T_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `B_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `T_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
