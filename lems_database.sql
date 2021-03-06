-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 01, 2013 at 07:43 AM
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
-- Table structure for table `Actions`
--

CREATE TABLE IF NOT EXISTS `Actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `resource_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `resource_id` (`resource_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `Actions`
--

INSERT INTO `Actions` (`id`, `name`, `resource_id`) VALUES
(1, 'auto', 1),
(2, 'index', 2),
(3, 'addUser', 2),
(4, 'editUser', 2),
(5, 'deleteUser', 2),
(6, 'index', 3),
(7, 'addPermission', 3),
(8, 'editPermission', 3),
(9, 'deletePermission', 3),
(10, 'index', 4),
(11, 'profile', 4),
(12, 'index', 5),
(13, 'checkIn', 5),
(14, 'checkOut', 5),
(15, 'applyLeave', 5),
(16, 'index', 6),
(17, 'about', 6),
(18, 'logout', 6),
(19, 'login', 6),
(20, 'index', 7),
(21, 'getlist', 3),
(22, 'history', 5),
(23, 'getUsers', 2),
(24, 'listProfile', 2),
(25, 'listLeave', 2),
(26, 'listProfile', 4),
(27, 'editProfile', 4),
(28, 'home', 2);

-- --------------------------------------------------------

--
-- Table structure for table `Attendance`
--

CREATE TABLE IF NOT EXISTS `Attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `checkin_time` time NOT NULL,
  `checkout_time` time DEFAULT NULL,
  `checkin_status` enum('On Time','Late') NOT NULL,
  `checkout_status` enum('Early','On Time') DEFAULT NULL,
  `checkin_comments` longtext,
  `checkout_comments` longtext,
  PRIMARY KEY (`id`),
  KEY `emp_id` (`emp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `Attendance`
--

INSERT INTO `Attendance` (`id`, `emp_id`, `date`, `checkin_time`, `checkout_time`, `checkin_status`, `checkout_status`, `checkin_comments`, `checkout_comments`) VALUES
(1, 1, '2013-04-25', '08:46:39', '15:46:44', 'On Time', 'Early', NULL, 'I have some work at home.');

-- --------------------------------------------------------

--
-- Table structure for table `CV_Info`
--

CREATE TABLE IF NOT EXISTS `CV_Info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `DOB` date NOT NULL,
  `info` longtext NOT NULL,
  `image_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `emp_id` (`emp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `CV_Info`
--

INSERT INTO `CV_Info` (`id`, `emp_id`, `address`, `DOB`, `info`, `image_name`) VALUES
(1, 1, 'fjasdljf', '1940-01-01', '<p>adlskfjsasdfkjf adsjlfdsajfdlf</p>\r\n', 'ashish.JPG');

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
  `role_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email_id` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `designation_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_id` (`email_id`),
  KEY `designation_id` (`designation_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `Employee`
--

INSERT INTO `Employee` (`id`, `role_id`, `full_name`, `email_id`, `password`, `contact`, `designation_id`) VALUES
(1, 1, 'ashish tamrakar', 'ashishtamrakar@gmail.com', '7b69ad8a8999d4ca7c42b8a729fb0ffd', '9841866792', 1),
(2, 3, 'ojash dahal', 'ojashdahal@lftechnology.com', 'a5b4c15152e100c43c6dfd97bb45dd3f', '9841023233', 1),
(3, 3, 'shiv kumar sah', 'shivkumarsha@lftechnology.com', '671fc86500ae5dd534f859e4483354fe', '9841123456', 1),
(4, 2, 'kiran regmi', 'kiranregmi@lftechnology.com', 'b1a5b64256e27fa5ae76d62b95209ab3', '9841123456', 2),
(6, 3, 'subash poudyal', 'subashpoudyal@lftechnology.com', 'b4caefa3d450d0e36e183160d17aba24', '9841784648', 1),
(7, 3, 'Alina Shakya', 'alinashakya@lftechnology.com', '914a23f72f590809d3fe431573ecb71f', '9841123456', 1),
(8, 3, 'Sudip Pudasaini', 'sudippudasaini@lftechnology.com', '550bbf0991fd493d1afaa2bdd246af6a', '9841123456', 1),
(10, 2, 'Raju Gautam', 'rajugautam@lftechnology.com', '03c017f682085142f3b60f56673e22dc', '9841123456', 4),
(11, 2, 'harry', 'harry@lftechnology.com', '3b87c97d15e8eb11e51aa25e9a5770e9', '9841123456', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Leave`
--

CREATE TABLE IF NOT EXISTS `Leave` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `reason` longtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `emp_id` (`emp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `Leave`
--

INSERT INTO `Leave` (`id`, `emp_id`, `from_date`, `to_date`, `reason`) VALUES
(1, 1, '2013-04-27', '2013-04-30', 'going into party'),
(2, 1, '2013-04-30', '2013-04-30', 'fsgfsdgs');

-- --------------------------------------------------------

--
-- Table structure for table `Permissions`
--

CREATE TABLE IF NOT EXISTS `Permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `action_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `resource_id` (`resource_id`),
  KEY `role_id` (`role_id`),
  KEY `action_id` (`action_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `Permissions`
--

INSERT INTO `Permissions` (`id`, `role_id`, `resource_id`, `action_id`) VALUES
(1, 3, 4, 10),
(2, 3, 5, 13),
(3, 3, 5, 14),
(4, 3, 5, 15),
(5, 2, 1, 1),
(7, 2, 2, 3),
(11, 3, 6, 18),
(12, 2, 3, 6),
(13, 2, 3, 8),
(14, 3, 5, 22),
(15, 2, 2, 5),
(17, 2, 4, 11),
(18, 2, 3, 7),
(19, 2, 5, 13),
(21, 3, 4, 11),
(22, 2, 3, 9),
(26, 2, 6, 16),
(28, 2, 6, 18),
(30, 2, 6, 17),
(31, 2, 6, 19);

-- --------------------------------------------------------

--
-- Table structure for table `Resources`
--

CREATE TABLE IF NOT EXISTS `Resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `Resources`
--

INSERT INTO `Resources` (`id`, `name`, `description`) VALUES
(1, 'admin_resources', 'Resources Controller - Admin Module'),
(2, 'admin_index', 'Index Controller - Admin Module'),
(3, 'admin_permission', 'Permission Controller - Admin Module'),
(4, 'employee_index', 'Index Controller - Employee Module'),
(5, 'employee_attendance', 'Attendance Controller - Employee Module'),
(6, 'front_index', 'Index Controller - Front Module'),
(7, 'front_error', 'Error Controller - Front Module');

-- --------------------------------------------------------

--
-- Table structure for table `Roles`
--

CREATE TABLE IF NOT EXISTS `Roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `Roles`
--

INSERT INTO `Roles` (`id`, `name`) VALUES
(1, 'Super Admin'),
(2, 'Admin'),
(3, 'Employee');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Actions`
--
ALTER TABLE `Actions`
  ADD CONSTRAINT `Actions_ibfk_1` FOREIGN KEY (`resource_id`) REFERENCES `Resources` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `Employee_ibfk_1` FOREIGN KEY (`designation_id`) REFERENCES `Designation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Employee_ibfk_4` FOREIGN KEY (`role_id`) REFERENCES `Roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `Permissions_ibfk_2` FOREIGN KEY (`resource_id`) REFERENCES `Resources` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Permissions_ibfk_3` FOREIGN KEY (`action_id`) REFERENCES `Actions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
