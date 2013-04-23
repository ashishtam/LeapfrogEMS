-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 23, 2013 at 07:54 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lems`
--
CREATE DATABASE `lems` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `lems`;

-- --------------------------------------------------------

--
-- Table structure for table `Attendance`
--

CREATE TABLE IF NOT EXISTS `Attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `checkin_time` time NOT NULL,
  `checkout_time` time NOT NULL,
  `status` enum('ontime','late','','') NOT NULL,
  `commments` longtext,
  PRIMARY KEY (`id`),
  KEY `emp_id` (`emp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `CV_Info`
--

CREATE TABLE IF NOT EXISTS `CV_Info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `DOB` date NOT NULL,
  `skills` longtext,
  `academics` longtext,
  `achievements` longtext,
  `training` longtext,
  PRIMARY KEY (`id`),
  KEY `emp_id` (`emp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Designation`
--

CREATE TABLE IF NOT EXISTS `Designation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `Designation`
--

INSERT INTO `Designation` (`id`, `name`) VALUES
(1, 'Trainee'),
(2, 'Co-ordinator'),
(3, 'Project Manager'),
(4, 'Solution Architect');

-- --------------------------------------------------------

--
-- Table structure for table `Employee`
--

CREATE TABLE IF NOT EXISTS `Employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) NOT NULL,
  `email_id` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `designation_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_id` (`email_id`),
  KEY `designation_id` (`designation_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `Employee`
--

INSERT INTO `Employee` (`id`, `full_name`, `email_id`, `password`, `contact`, `designation_id`) VALUES
(1, 'ashish tamrakar', 'ashishtamrakar@gmail.com', '7b69ad8a8999d4ca7c42b8a729fb0ffd', '9841866792', 1),
(2, 'ojash dahal', 'ojashdahal@lftechnology.com', 'a5b4c15152e100c43c6dfd97bb45dd3f', '9841023233', 1),
(3, 'shiv kumar sah', 'shivkumarsha@lftechnology.com', '671fc86500ae5dd534f859e4483354fe', '9841123456', 1),
(4, 'kiran regmi', 'kiranregmi@lftechnology.com', 'b1a5b64256e27fa5ae76d62b95209ab3', '9841123456', 2),
(6, 'subash poudyal', 'subashpoudyal@lftechnology.com', 'b4caefa3d450d0e36e183160d17aba24', '9841123456', 1),
(7, 'Alina Shakya', 'alinashakya@lftechnology.com', '914a23f72f590809d3fe431573ecb71f', '9841123456', 1),
(8, 'Sudip Pudasaini', 'sudippudasaini@lftechnology.com', '550bbf0991fd493d1afaa2bdd246af6a', '9841123456', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Leave`
--

CREATE TABLE IF NOT EXISTS `Leave` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL,
  `leave_date` date NOT NULL,
  `reason` longtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `emp_id` (`emp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Permissions`
--

CREATE TABLE IF NOT EXISTS `Permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `permitted_action` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `resource_id` (`resource_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Resources`
--

CREATE TABLE IF NOT EXISTS `Resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Roles`
--

CREATE TABLE IF NOT EXISTS `Roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `emp_id` (`emp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Attendance`
--
ALTER TABLE `Attendance`
  ADD CONSTRAINT `Attendance_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `Employee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `CV_Info`
--
ALTER TABLE `CV_Info`
  ADD CONSTRAINT `CV_Info_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `Employee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Employee`
--
ALTER TABLE `Employee`
  ADD CONSTRAINT `Employee_ibfk_1` FOREIGN KEY (`designation_id`) REFERENCES `Designation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Leave`
--
ALTER TABLE `Leave`
  ADD CONSTRAINT `Leave_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `Employee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Permissions`
--
ALTER TABLE `Permissions`
  ADD CONSTRAINT `Permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `Roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Permissions_ibfk_2` FOREIGN KEY (`resource_id`) REFERENCES `Resources` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Roles`
--
ALTER TABLE `Roles`
  ADD CONSTRAINT `Roles_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `Employee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
