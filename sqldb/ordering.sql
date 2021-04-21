-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2021 at 09:58 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ordering`
--

-- --------------------------------------------------------

--
-- Table structure for table `y2021m04d02`
--

CREATE TABLE `y2021m04d02` (
  `member_id` varchar(255) NOT NULL,
  `member_name` varchar(255) DEFAULT NULL,
  `breakfast_flag` varchar(255) DEFAULT NULL,
  `lunch_flag` varchar(255) DEFAULT NULL,
  `dinner_flag` varchar(255) DEFAULT NULL,
  `extrameal_flag` varchar(255) DEFAULT NULL,
  `payment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `y2021m04d03`
--

CREATE TABLE `y2021m04d03` (
  `member_id` varchar(255) NOT NULL,
  `member_name` varchar(255) DEFAULT NULL,
  `breakfast_flag` varchar(255) DEFAULT NULL,
  `lunch_flag` varchar(255) DEFAULT NULL,
  `dinner_flag` varchar(255) DEFAULT NULL,
  `extrameal_flag` varchar(255) DEFAULT NULL,
  `payment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `y2021m04d03`
--

INSERT INTO `y2021m04d03` (`member_id`, `member_name`, `breakfast_flag`, `lunch_flag`, `dinner_flag`, `extrameal_flag`, `payment`) VALUES
('1', 'Christiano Ronaldo', 'no', 'yes', 'no', 'yes', '130');

-- --------------------------------------------------------

--
-- Table structure for table `y2021m04d10`
--

CREATE TABLE `y2021m04d10` (
  `member_id` varchar(255) NOT NULL,
  `member_name` varchar(255) DEFAULT NULL,
  `breakfast_flag` varchar(255) DEFAULT NULL,
  `lunch_flag` varchar(255) DEFAULT NULL,
  `dinner_flag` varchar(255) DEFAULT NULL,
  `extrameal_flag` varchar(255) DEFAULT NULL,
  `payment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `y2021m04d02`
--
ALTER TABLE `y2021m04d02`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `y2021m04d03`
--
ALTER TABLE `y2021m04d03`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `y2021m04d10`
--
ALTER TABLE `y2021m04d10`
  ADD PRIMARY KEY (`member_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
