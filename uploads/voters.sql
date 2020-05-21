-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 21, 2020 at 02:21 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `voters`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ID` int(11) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `IsAdmin` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ID`, `Email`, `Password`, `IsAdmin`) VALUES
(1, 'admin@admin.com', 'donkabaccha', 1);

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `CID` int(11) NOT NULL,
  `CandidateName` varchar(255) NOT NULL,
  `Photo` varchar(255) DEFAULT NULL,
  `PositionID` int(11) NOT NULL,
  `PositionName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`CID`, `CandidateName`, `Photo`, `PositionID`, `PositionName`) VALUES
(1, 'Gopal Shah', 'img/gopal.jpg', 1, 'District Governor'),
(2, 'Sandip Bhagat', 'img/sandip.jpg', 2, '1st Vice District Governor'),
(3, 'Dipak Paswan', 'img/dipak.jpg', 3, '2nd Vice District Governor'),
(4, 'Dinesh Gartaula', 'img/dinesh.jpg', 3, '2nd Vice District Governor');

-- --------------------------------------------------------

--
-- Table structure for table `poll`
--

CREATE TABLE `poll` (
  `PollID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `PositionID` int(11) NOT NULL,
  `CandidateID` int(11) NOT NULL,
  `PollRemarks` varchar(3) NOT NULL DEFAULT 'No',
  `IsLocked` tinyint(1) NOT NULL DEFAULT '1',
  `PollTime` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `PID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `AllowMulti` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`PID`, `Name`, `AllowMulti`) VALUES
(1, 'District Governor', 0),
(2, '1st Vice District Governor', 0),
(3, '2nd Vice District Governor', 1);

-- --------------------------------------------------------

--
-- Table structure for table `voterslist`
--

CREATE TABLE `voterslist` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(20) DEFAULT NULL,
  `Pass` varchar(255) DEFAULT NULL,
  `Mobile` varchar(10) DEFAULT NULL,
  `Club` varchar(255) DEFAULT 'LEO',
  `Status` tinyint(1) NOT NULL DEFAULT '0',
  `IsAdmin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `voterslist`
--

INSERT INTO `voterslist` (`ID`, `Name`, `Email`, `Password`, `Pass`, `Mobile`, `Club`, `Status`, `IsAdmin`) VALUES
(7, 'Gopal Shah', 'gopal@yopmail.com', '4000', '1bd69c7df3112fb9a584fbd9edfc6c90', '9804341835', 'LEO', 0, 0),
(8, 'Kashi Shah', 'kashi@yopmail.com', '6818', 'a3842ed7b3d0fe3ac263bcabd2999790', '9802714703', 'LEO', 0, 0),
(9, 'Sandip Bhagat', 'sandip@yopmail.com', '7382', 'c9dd73f5cb96486f5e1e0680e841a550', '9802746202', 'LEO', 0, 0),
(10, 'Dinesh Gartaula', 'dg@yopmail.com', '2708', '03fa2f7502f5f6b9169e67d17cbf51bb', '9802796290', 'LEO', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`CID`);

--
-- Indexes for table `poll`
--
ALTER TABLE `poll`
  ADD PRIMARY KEY (`PollID`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`PID`);

--
-- Indexes for table `voterslist`
--
ALTER TABLE `voterslist`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `CID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `poll`
--
ALTER TABLE `poll`
  MODIFY `PollID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `PID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `voterslist`
--
ALTER TABLE `voterslist`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
