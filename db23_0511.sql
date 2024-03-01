-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 01, 2024 at 05:13 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db23_0511`
--

-- --------------------------------------------------------

--
-- Table structure for table `checkcon`
--

CREATE TABLE `checkcon` (
  `idCheckCon` int(11) NOT NULL,
  `continuousHoliday` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `checkcon`
--

INSERT INTO `checkcon` (`idCheckCon`, `continuousHoliday`) VALUES
(0, 'no'),
(1, 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `checkrest`
--

CREATE TABLE `checkrest` (
  `idCheckRest` int(11) NOT NULL,
  `checkHoliday` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `checkrest`
--

INSERT INTO `checkrest` (`idCheckRest`, `checkHoliday`) VALUES
(0, 'not holiday'),
(1, 'holiday');

-- --------------------------------------------------------

--
-- Table structure for table `date`
--

CREATE TABLE `date` (
  `idDate` int(11) NOT NULL,
  `date` date NOT NULL,
  `idNoWeek` int(11) NOT NULL,
  `idName` int(11) DEFAULT NULL,
  `idCheckCon` int(11) NOT NULL,
  `idDay` int(11) NOT NULL,
  `idCheckRest` int(11) NOT NULL,
  `idType` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dayofweek`
--

CREATE TABLE `dayofweek` (
  `idDay` int(11) NOT NULL,
  `nameDay` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dayofweek`
--

INSERT INTO `dayofweek` (`idDay`, `nameDay`) VALUES
(1, 'Sunday'),
(2, 'Monday'),
(3, 'Tuesday'),
(4, 'Wednesday'),
(5, 'Thursday'),
(6, 'Friday'),
(7, 'Saturday');

-- --------------------------------------------------------

--
-- Table structure for table `nameof`
--

CREATE TABLE `nameof` (
  `idName` int(11) NOT NULL,
  `nameOf` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `nameof`
--

INSERT INTO `nameof` (`idName`, `nameOf`) VALUES
(0, 'Normal Day'),
(1, 'New Year\'s Day'),
(2, 'Makha Bucha Day'),
(3, 'Chakri Memorial Day'),
(4, 'Labour Day'),
(5, 'Coronation Day'),
(6, 'Vesak Day'),
(7, 'Royal Ploughing Ceremony'),
(8, 'H.M. The Queen Suthida\'s Birthday'),
(9, 'Asalha Puja Day'),
(10, 'Buddhist Lent Day'),
(11, 'Songkran Festival'),
(12, 'H.M.King Maha Vajiralongkorn\'s Birthday'),
(13, 'Mother\'s Day'),
(14, 'H.M. King Bhumibol Adulyadej Memorial Day'),
(15, 'Chulalongkorn Day'),
(16, 'Special Holidays'),
(17, 'Father\'s Day'),
(18, 'Constitution Day'),
(19, 'Compensatory Holiday'),
(20, 'New Year\'s Eve'),
(21, 'The End of Buddhist Lent Day');

-- --------------------------------------------------------

--
-- Table structure for table `noweek`
--

CREATE TABLE `noweek` (
  `idNoWeek` int(11) NOT NULL,
  `numWeek` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `noweek`
--

INSERT INTO `noweek` (`idNoWeek`, `numWeek`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(12, 12),
(13, 13),
(14, 14),
(15, 15),
(16, 16),
(17, 17),
(18, 18),
(19, 19),
(20, 20),
(21, 21),
(22, 22),
(23, 23),
(24, 24),
(25, 25),
(26, 26),
(27, 27),
(28, 28),
(29, 29),
(30, 30),
(31, 31),
(32, 32),
(33, 33),
(34, 34),
(35, 35),
(36, 36),
(37, 37),
(38, 38),
(39, 39),
(40, 40),
(41, 41),
(42, 42),
(43, 43),
(44, 44),
(45, 45),
(46, 46),
(47, 47),
(48, 48),
(49, 49),
(50, 50),
(51, 51),
(52, 52),
(53, 53);

-- --------------------------------------------------------

--
-- Table structure for table `typerest`
--

CREATE TABLE `typerest` (
  `idType` int(11) NOT NULL,
  `nameType` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `typerest`
--

INSERT INTO `typerest` (`idType`, `nameType`) VALUES
(1, 'weekEnd'),
(2, 'weekDay'),
(3, 'Spacial');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `checkcon`
--
ALTER TABLE `checkcon`
  ADD PRIMARY KEY (`idCheckCon`);

--
-- Indexes for table `checkrest`
--
ALTER TABLE `checkrest`
  ADD PRIMARY KEY (`idCheckRest`);

--
-- Indexes for table `date`
--
ALTER TABLE `date`
  ADD PRIMARY KEY (`idDate`),
  ADD KEY `id_week` (`idNoWeek`),
  ADD KEY `idName` (`idName`),
  ADD KEY `idCon` (`idCheckCon`),
  ADD KEY `idDay` (`idDay`),
  ADD KEY `idCheckRest` (`idCheckRest`),
  ADD KEY `idType` (`idType`);

--
-- Indexes for table `dayofweek`
--
ALTER TABLE `dayofweek`
  ADD PRIMARY KEY (`idDay`);

--
-- Indexes for table `nameof`
--
ALTER TABLE `nameof`
  ADD PRIMARY KEY (`idName`);

--
-- Indexes for table `noweek`
--
ALTER TABLE `noweek`
  ADD PRIMARY KEY (`idNoWeek`);

--
-- Indexes for table `typerest`
--
ALTER TABLE `typerest`
  ADD PRIMARY KEY (`idType`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `checkcon`
--
ALTER TABLE `checkcon`
  MODIFY `idCheckCon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `checkrest`
--
ALTER TABLE `checkrest`
  MODIFY `idCheckRest` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dayofweek`
--
ALTER TABLE `dayofweek`
  MODIFY `idDay` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `nameof`
--
ALTER TABLE `nameof`
  MODIFY `idName` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `noweek`
--
ALTER TABLE `noweek`
  MODIFY `idNoWeek` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `typerest`
--
ALTER TABLE `typerest`
  MODIFY `idType` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `date`
--
ALTER TABLE `date`
  ADD CONSTRAINT `Date_ibfk_1` FOREIGN KEY (`idNoWeek`) REFERENCES `noweek` (`idNoWeek`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Date_ibfk_2` FOREIGN KEY (`idName`) REFERENCES `nameof` (`idName`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Date_ibfk_3` FOREIGN KEY (`idCheckCon`) REFERENCES `checkcon` (`idCheckCon`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Date_ibfk_4` FOREIGN KEY (`idDay`) REFERENCES `dayofweek` (`idDay`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Date_ibfk_5` FOREIGN KEY (`idCheckRest`) REFERENCES `checkrest` (`idCheckRest`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Date_ibfk_6` FOREIGN KEY (`idType`) REFERENCES `typerest` (`idType`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
