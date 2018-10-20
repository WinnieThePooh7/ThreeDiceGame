-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2018 at 03:39 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `threedice`
--

-- --------------------------------------------------------

--
-- Table structure for table `bets`
--

CREATE TABLE IF NOT EXISTS `bets` (
  `BetID` int(11) NOT NULL AUTO_INCREMENT,
  `Date` datetime NOT NULL,
  `ClientID` int(11) NOT NULL,
  `Status` int(1) NOT NULL,
  `StakeAmount` float NOT NULL,
  `WinAmount` float NOT NULL,
  `Result` int(11) NOT NULL,
  PRIMARY KEY (`BetID`),
  KEY `fk_bets_client` (`ClientID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=114 ;

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `ClientID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Lastname` varchar(50) NOT NULL,
  `Balance` float NOT NULL,
  PRIMARY KEY (`ClientID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`ClientID`, `Name`, `Lastname`, `Balance`) VALUES
(1, 'Petar', 'Petrovic', 200),
(2, 'Marko', 'Markovic', 200),
(3, 'Djordje', 'Djordjevic', 200),
(4, 'Jovan', 'Jovanovic', 200),
(5, 'Mara', 'Maric', 200);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
  `TransactionID` int(11) NOT NULL AUTO_INCREMENT,
  `ClientID` int(11) NOT NULL,
  `Date` datetime NOT NULL,
  `Amount` float NOT NULL,
  `AmountDirection` float NOT NULL,
  PRIMARY KEY (`TransactionID`),
  KEY `fk_trans_client` (`ClientID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=125 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bets`
--
ALTER TABLE `bets`
  ADD CONSTRAINT `fk_bets_client` FOREIGN KEY (`ClientID`) REFERENCES `client` (`ClientID`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `fk_trans_client` FOREIGN KEY (`ClientID`) REFERENCES `client` (`ClientID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
