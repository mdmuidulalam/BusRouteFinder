-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2016 at 09:22 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ai-busroute`
--

-- --------------------------------------------------------

--
-- Table structure for table `bus`
--

CREATE TABLE IF NOT EXISTS `bus` (
  `bus_id` int(11) NOT NULL AUTO_INCREMENT,
  `edge_id` int(11) NOT NULL,
  `bus_title` varchar(120) NOT NULL,
  `cost` float NOT NULL,
  `time` time NOT NULL,
  PRIMARY KEY (`bus_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `bus`
--

INSERT INTO `bus` (`bus_id`, `edge_id`, `bus_title`, `cost`, `time`) VALUES
(20, 8, 'hanif', 300, '00:03:50'),
(21, 8, 'tr', 400, '00:07:00'),
(22, 8, 'sr', 500, '00:06:00'),
(23, 8, 'bolaka', 600, '00:08:00'),
(24, 8, 'bolaka', 800, '00:09:00'),
(25, 3, 'hanif', 300, '00:03:00'),
(26, 3, 'bolaka', 400, '00:08:00'),
(27, 3, 'brtc', 700, '00:09:00'),
(28, 6, 'hanif', 200, '00:02:00'),
(29, 6, 'shohag', 700, '00:08:00'),
(30, 6, 'salsabil', 450, '00:03:00');

-- --------------------------------------------------------

--
-- Table structure for table `edges`
--

CREATE TABLE IF NOT EXISTS `edges` (
  `edge_id` int(11) NOT NULL AUTO_INCREMENT,
  `from_node` int(11) NOT NULL,
  `to_node` int(11) NOT NULL,
  `distance` float NOT NULL,
  `best_cost` float NOT NULL,
  `best_time` time NOT NULL,
  PRIMARY KEY (`edge_id`),
  KEY `from_node` (`from_node`,`to_node`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `edges`
--

INSERT INTO `edges` (`edge_id`, `from_node`, `to_node`, `distance`, `best_cost`, `best_time`) VALUES
(2, 1, 2, 5, 0, '00:00:00'),
(3, 1, 4, 7, 300, '00:03:00'),
(6, 4, 3, 15, 200, '00:02:00'),
(7, 5, 1, 8, 0, '00:00:00'),
(8, 1, 5, 8, 300, '00:03:50');

-- --------------------------------------------------------

--
-- Table structure for table `nodes`
--

CREATE TABLE IF NOT EXISTS `nodes` (
  `node_id` int(11) NOT NULL AUTO_INCREMENT,
  `node_title` varchar(120) NOT NULL,
  PRIMARY KEY (`node_id`),
  KEY `node_id` (`node_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `nodes`
--

INSERT INTO `nodes` (`node_id`, `node_title`) VALUES
(1, 'Dhaka'),
(2, 'Comilla'),
(3, 'Chittagong'),
(4, 'Sylhet'),
(5, 'Bogra'),
(8, 'Rajshahi'),
(9, 'Rangpur'),
(10, 'Mymensingh');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
