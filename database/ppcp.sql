-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 04, 2023 at 06:36 PM
-- Server version: 8.0.31
-- PHP Version: 7.4.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ppcp`
--

-- --------------------------------------------------------

--
-- Table structure for table `application`
--

CREATE TABLE `application` (
  `id` int NOT NULL,
  `fullname` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `age` int NOT NULL,
  `institute` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `course` int NOT NULL,
  `phone` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `social_network` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_room` int NOT NULL,
  `booking_date` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `booking_end` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `booking_start` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `application_date` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `approved` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `application`
--

INSERT INTO `application` (`id`, `fullname`, `age`, `institute`, `course`, `phone`, `social_network`, `id_room`, `booking_date`, `booking_end`, `booking_start`, `application_date`, `approved`) VALUES
(1, 'Иван Юрьевич Махнёв', 21, 'ИТ', 3, '+7978110629', 'ВК', 1, '', '', '0', '', 0),
(21, 'ааа', 1, 'ит', 2, '+7978000000', 'ааа', 1, '', '', '0', '', 0),
(22, 'Кудин В. Э.', 13, 'ИТ', 3, '+7978110293', 'ВК', 3, '04.06.2023', '19-00', '18-00', '03.06.2023 20-00', 1),
(23, 'Кудин В. Э.', 13, 'ИТ', 3, '+7978110623', 'ВК', 3, '05.06.2023', '18-00', '17-00', '03.06.2023 20-00', 1),
(24, 'Кудин В. Э.', 13, 'ИТ', 3, '+7978106293', 'ВК', 3, '09.06.2023', '20-00', '19-00', '03.06.2023 20-00', 1),
(25, 'Кудин В. Э.', 13, 'ИТ', 3, '+7978106293', 'ВК', 3, '07.06.2023', '15-00', '14-00', '03.06.2023 20-00', 1),
(26, 'Кудин В. Э.', 13, 'ИТ', 3, '+7978116293', 'ВК', 3, '07.06.2023', '20-00', '19-00', '03.06.2023 20-00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `id` int NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `info` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `id` int NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`id`, `address`, `name`, `description`, `image`) VALUES
(1, 'Гоголя', '', 'Аудитория №1', 'img/room1.jpg'),
(3, 'Курчатова', 'Аудитория №2', 'Площадь: 20', 'img/room2.jpg'),
(4, 'Курчатова', 'Аудитория №3', 'Площадь: 40', 'img/room2.jpg'),
(5, 'Голандия', 'Аудитория №4', 'Площадь: 20', 'img/room1.jpg'),
(6, 'Голандия', 'Аудитория №5', 'Площадь: 30', 'img/room2.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `application`
--
ALTER TABLE `application`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `application`
--
ALTER TABLE `application`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
