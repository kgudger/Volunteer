-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 14, 2018 at 04:19 PM
-- Server version: 10.1.29-MariaDB-6
-- PHP Version: 7.0.27-1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `www-data_Volunteer`
--

-- --------------------------------------------------------

--
-- Table structure for table `Jobs`
--

CREATE TABLE `Jobs` (
  `JobID` int(20) NOT NULL,
  `StartDate` date DEFAULT NULL,
  `StartTime` time DEFAULT NULL,
  `Description` varchar(50) DEFAULT NULL,
  `NPID` int(20) DEFAULT NULL,
  `HowMany` int(20) DEFAULT NULL,
  `TypeID` int(20) DEFAULT NULL,
  `StopDate` date DEFAULT NULL,
  `StopTime` time DEFAULT NULL,
  `PostTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `JobTypes`
--

CREATE TABLE `JobTypes` (
  `PrefID` int(20) NOT NULL,
  `Preference` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `NonProfits`
--

CREATE TABLE `NonProfits` (
  `NPID` int(20) NOT NULL,
  `Name` varchar(30) DEFAULT NULL,
  `ContLName` varchar(30) DEFAULT NULL,
  `ContFName` varchar(30) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `phash` varchar(65) DEFAULT NULL,
  `Address1` varchar(30) DEFAULT NULL,
  `Address2` varchar(30) DEFAULT NULL,
  `City` varchar(30) DEFAULT NULL,
  `State` varchar(20) DEFAULT NULL,
  `Zip` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Status`
--

CREATE TABLE `Status` (
  `JID` int(20) UNSIGNED DEFAULT NULL,
  `VID` int(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Volunteers`
--

CREATE TABLE `Volunteers` (
  `VID` int(20) NOT NULL,
  `FName` varchar(30) DEFAULT NULL,
  `Lname` varchar(30) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `phash` varchar(65) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `VPrefs`
--

CREATE TABLE `VPrefs` (
  `VID` int(20) UNSIGNED DEFAULT NULL,
  `TypeID` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Jobs`
--
ALTER TABLE `Jobs`
  ADD PRIMARY KEY (`JobID`);

--
-- Indexes for table `JobTypes`
--
ALTER TABLE `JobTypes`
  ADD PRIMARY KEY (`PrefID`);

--
-- Indexes for table `NonProfits`
--
ALTER TABLE `NonProfits`
  ADD PRIMARY KEY (`NPID`);

--
-- Indexes for table `Volunteers`
--
ALTER TABLE `Volunteers`
  ADD PRIMARY KEY (`VID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Jobs`
--
ALTER TABLE `Jobs`
  MODIFY `JobID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `JobTypes`
--
ALTER TABLE `JobTypes`
  MODIFY `PrefID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `NonProfits`
--
ALTER TABLE `NonProfits`
  MODIFY `NPID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `Volunteers`
--
ALTER TABLE `Volunteers`
  MODIFY `VID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
