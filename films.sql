-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2021 at 03:03 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `films`
--

-- --------------------------------------------------------

--
-- Table structure for table `film`
--

CREATE TABLE `film` (
  `id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `id_genre` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `cover` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `film`
--

INSERT INTO `film` (`id`, `name`, `id_genre`, `year`, `duration`, `cover`) VALUES
(1, 'Batman', 1, 2010, 110, 0x7265736f75726365732f66696c655f313631383430333531312e6a7067),
(3, 'Titanic', 11, 1997, 210, 0x7265736f75726365732f66696c655f313631383430343430372e6a7067),
(4, 'Moneyball', 7, 2011, 133, 0x7265736f75726365732f66696c655f313631383430343435302e6a7067),
(5, 'Avengers', 1, 2012, 143, 0x7265736f75726365732f66696c655f313631383430343438382e6a7067),
(6, 'Goodfellas', 7, 1990, 148, 0x7265736f75726365732f66696c655f313631383430343534382e6a7067),
(7, 'The Notebook', 11, 2004, 124, 0x7265736f75726365732f66696c655f313631383430343539352e6a7067),
(8, 'Godfather', 10, 1972, 178, 0x7265736f75726365732f66696c655f313631383430343635392e6a7067);

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`id`, `name`) VALUES
(1, 'action'),
(2, 'adventure'),
(3, 'apocalyptic'),
(4, 'art'),
(5, 'biographical'),
(6, 'comedy'),
(7, 'drama'),
(8, 'erotic'),
(9, 'historical'),
(10, 'political'),
(11, 'romance'),
(12, 'sports'),
(13, 'thriller'),
(14, 'war'),
(15, 'western');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `film`
--
ALTER TABLE `film`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_genre` (`id_genre`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `film`
--
ALTER TABLE `film`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `film`
--
ALTER TABLE `film`
  ADD CONSTRAINT `film_ibfk_1` FOREIGN KEY (`id_genre`) REFERENCES `genre` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
