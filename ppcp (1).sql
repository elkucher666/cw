-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20230522.9b5d151d63
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: May 23 2023 г., 16:47
-- Версия сервера: 10.4.24-MariaDB
-- Версия PHP: 8.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `ppcp`
--

-- --------------------------------------------------------

--
-- Структура таблицы `application`
--

CREATE TABLE `application` (
  `id` int(11) NOT NULL,
  `fullname` text NOT NULL,
  `age` int(11) NOT NULL,
  `institute` text NOT NULL,
  `course` int(11) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `social_network` text NOT NULL,
  `id_room` int(11) NOT NULL,
  `booking_date` text NOT NULL,
  `booking_end` text NOT NULL,
  `booking_start` int(11) NOT NULL,
  `application_date` text NOT NULL,
  `approved` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `application`
--

INSERT INTO `application` (`id`, `fullname`, `age`, `institute`, `course`, `phone`, `social_network`, `id_room`, `booking_date`, `booking_end`, `booking_start`, `application_date`, `approved`) VALUES
(1, 'Иван Юрьевич Махнёв', 21, 'ИТ', 3, '+7978110629', 'ВК', 1, '', '', 0, '', 0),
(21, 'ааа', 1, 'ит', 2, '+7978000000', 'ааа', 1, '', '', 0, '', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `equipment`
--

CREATE TABLE `equipment` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `info` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`info`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `room`
--

CREATE TABLE `room` (
  `id` int(11) NOT NULL,
  `address` text NOT NULL,
  `info` text NOT NULL,
  `photo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `room`
--

INSERT INTO `room` (`id`, `address`, `info`, `photo`) VALUES
(1, 'Гоголя', 'Аудитория №1', 'img/room1.jpg');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `application`
--
ALTER TABLE `application`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `application`
--
ALTER TABLE `application`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT для таблицы `room`
--
ALTER TABLE `room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
