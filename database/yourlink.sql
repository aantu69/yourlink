-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 04, 2015 at 06:52 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `yourlink`
--

-- --------------------------------------------------------

--
-- Table structure for table `appusersappusers`
--

CREATE TABLE IF NOT EXISTS `appusersappusers` (
  `appusersappusers_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_user_id` int(11) NOT NULL,
  `second_user_id` int(11) NOT NULL,
  `second_user_email` varchar(100) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`appusersappusers_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `appuserssps`
--

CREATE TABLE IF NOT EXISTS `appuserssps` (
  `appuserssp_id` int(11) NOT NULL AUTO_INCREMENT,
  `app_user_id` int(11) NOT NULL,
  `sp_id` int(11) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`appuserssp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_name` varchar(50) NOT NULL,
  `updated_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`country_id`, `country_name`, `updated_on`, `updated_by`) VALUES
(1, 'Australia', '2014-07-08 16:55:18', 1),
(2, 'Bangladesh', '2014-12-17 10:40:57', 1),
(3, 'United State', '2014-12-17 11:14:14', 1),
(4, 'Germany', '2014-12-17 11:26:13', 1);

-- --------------------------------------------------------

--
-- Table structure for table `level_one_classes`
--

CREATE TABLE IF NOT EXISTS `level_one_classes` (
  `level_one_class_id` int(11) NOT NULL AUTO_INCREMENT,
  `level_one_class_name` varchar(100) NOT NULL,
  `level_one_class_order` int(11) NOT NULL,
  `level_one_class_contain_level_two` varchar(10) NOT NULL,
  `user_role` int(11) NOT NULL,
  `updated_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`level_one_class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `level_one_classes`
--

INSERT INTO `level_one_classes` (`level_one_class_id`, `level_one_class_name`, `level_one_class_order`, `level_one_class_contain_level_two`, `user_role`, `updated_on`, `updated_by`) VALUES
(1, 'Relationships (Family/Friends)', 0, 'true', 0, '2014-12-17 10:44:39', 1),
(2, 'Aged & Disability Services', 1, 'true', 0, '2014-08-08 14:08:17', 1),
(3, 'Spiritual', 2, 'true', 0, '2014-08-08 13:56:14', 1),
(4, 'Residence', 3, 'true', 0, '2014-08-08 13:56:34', 1),
(5, 'Emergency & Support', 4, 'false', 0, '2014-08-08 13:56:52', 1),
(6, 'Government (Local)', 5, 'false', 0, '2014-08-08 13:57:09', 1),
(7, 'Government (Other)', 6, 'false', 0, '2014-08-08 13:57:25', 1),
(8, 'Employment & Volunteering', 7, 'false', 0, '2014-08-08 13:57:43', 1),
(9, 'Non Profit & Charity', 8, 'true', 0, '2014-08-08 13:57:59', 1),
(10, 'Education', 9, 'true', 0, '2014-08-08 13:58:17', 1),
(11, 'Health (Public)', 10, 'false', 0, '2014-08-08 13:58:34', 1),
(12, 'Service Providers  Health & Wellbeing', 11, 'true', 0, '2014-08-08 13:58:55', 1),
(13, 'Service Providers Financial', 12, 'true', 0, '2014-08-08 13:59:13', 1),
(14, 'Service Providers Technology & Communications', 13, 'true', 0, '2014-08-08 13:59:38', 1),
(15, 'Service Providers Commercial Other', 14, 'true', 0, '2014-08-08 13:59:59', 1),
(16, 'Craft', 15, 'false', 0, '2014-08-08 14:00:14', 1),
(17, 'Motor', 16, 'false', 0, '2014-08-08 14:00:44', 1),
(18, 'Gardening', 17, 'false', 0, '2014-08-08 14:01:15', 1),
(19, 'Interests  Other', 18, 'false', 0, '2014-08-08 14:01:33', 1),
(20, 'Collecting', 19, 'false', 0, '2014-08-08 14:01:59', 1),
(21, 'Cook & Baking', 20, 'false', 0, '2014-08-08 14:02:15', 1),
(22, 'Travel', 21, 'false', 0, '2014-08-08 14:02:30', 1),
(23, 'Sports', 22, 'false', 0, '2014-08-08 14:02:45', 1),
(24, 'Arts & Culture', 23, 'false', 0, '2014-08-08 14:03:03', 1),
(25, 'Clubs & Associations', 24, 'false', 0, '2014-08-08 14:03:20', 1),
(26, 'Pet & Environment', 25, 'false', 0, '2014-08-08 14:03:38', 1),
(27, 'YourLink', 26, 'false', 0, '2014-08-08 14:03:56', 1);

-- --------------------------------------------------------

--
-- Table structure for table `level_two_classes`
--

CREATE TABLE IF NOT EXISTS `level_two_classes` (
  `level_two_class_id` int(11) NOT NULL AUTO_INCREMENT,
  `level_two_class_name` varchar(100) NOT NULL,
  `updated_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`level_two_class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `sender_role` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `receiver_role` int(11) NOT NULL,
  `message_title` varchar(100) NOT NULL,
  `description` varchar(2000) NOT NULL,
  `event` int(11) NOT NULL,
  `sent_time` datetime NOT NULL,
  `event_start_date` datetime NOT NULL,
  `event_start_time` varchar(10) NOT NULL,
  `event_end_date` datetime NOT NULL,
  `event_end_time` varchar(10) NOT NULL,
  `attachment_url` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `sender_id`, `sender_role`, `receiver_id`, `receiver_role`, `message_title`, `description`, `event`, `sent_time`, `event_start_date`, `event_start_time`, `event_end_date`, `event_end_time`, `attachment_url`, `status`) VALUES
(1, 3, 2, 0, 3, 'First Notice', 'This is first notice from sp softtech', 0, '2014-08-14 11:09:53', '2014-08-13 18:00:00', '', '2014-08-13 18:00:00', '', 'event.jpg', 'Sent'),
(2, 3, 2, 4, 3, 'Message From Sp', 'this is first message from sp softtech for Dream Home residence', 0, '2014-08-14 11:11:37', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', 'indivisual.jpg', 'Sent'),
(3, 2, 1, 4, 3, 'Message From Individual', 'This is the first message from individual sagor@gmail.com for residence Dream Home', 0, '2014-08-15 00:00:00', '2014-08-15 00:00:00', '', '2014-08-15 00:00:00', '', '', 'Sent'),
(4, 4, 3, 2, 1, 'Message From Residence For Individual', 'this is the first message from residence Dream Home for individual sagor@gmail.com, this is the first message from residence Dream Home for individual sagor@gmail.com, this is the first message from residence Dream Home for individual sagor@gmail.com', 0, '2014-08-14 19:11:53', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', 'indivisual.jpg', 'Sent'),
(5, 4, 3, 3, 2, 'Message From Residence For Sp', 'this is the first message from residence Dream Home for sp softtech', 0, '2014-08-14 19:14:38', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', 'indivisual.jpg', 'Sent'),
(6, 4, 3, 2, 0, 'Message From Residence For Individual', 'this is the second message from residence Dream Home for individual sagor@gmail.com', 0, '2014-08-15 09:37:31', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', 'indivisual.jpg', 'Sent'),
(7, 4, 3, 2, 0, 'Message From Residence For Individual', 'this is the third message from residence Dream Home for individual sagor@gmail.com', 0, '2014-08-18 15:16:17', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', 'indivisual.jpg', 'Sent'),
(8, 4, 3, 2, 0, 'Message From Residence For Individual', 'this is the fourth message from residence Dream Home for individual sagor@gmail.com', 0, '2014-08-18 15:32:07', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', 'indivisual.jpg', 'Sent'),
(9, 4, 3, 2, 0, 'Message From Residence For Individual', 'this is the fourth message from residence Dream Home for individual sagor@gmail.com', 0, '2014-08-18 15:32:30', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', 'indivisual.jpg', 'Sent'),
(10, 4, 3, 2, 0, 'Message From Residence For Individual', 'this is the sixth message from residence Dream Home for individual sagor@gmail.com', 0, '2014-08-18 15:32:47', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', 'indivisual.jpg', 'Sent'),
(11, 4, 3, 2, 0, 'Message From Residence For Individual', 'this is the another message from residence Dream Home for individual sagor@gmail.com', 0, '2014-08-18 15:36:07', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', 'indivisual.jpg', 'Sent'),
(12, 4, 3, 2, 0, 'Message From Residence For Individual', 'this is the another message from residence Dream Home for individual sagor@gmail.com', 0, '2014-08-18 15:39:05', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', 'indivisual.jpg', 'Sent'),
(13, 4, 3, 3, 0, 'Message From Residence For Sp', 'this is the second message from residence Dream Home for sp softtech', 0, '2014-08-18 15:48:54', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', 'indivisual.jpg', 'Sent'),
(14, 4, 3, 2, 0, 'Message From Residence For Individual', 'this is the another message from residence Dream Home for individual sagor@gmail.com', 0, '2014-08-19 08:19:15', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', 'indivisual.jpg', 'Sent'),
(15, 3, 2, 0, 0, 'First Event', 'This is first event from sp softtech', 1, '2014-08-19 09:38:14', '2014-08-19 00:00:00', '', '2014-08-20 07:00:00', '', 'event.jpg', 'Sent'),
(16, 4, 3, 0, 0, 'Broadcast From Residence', 'This is the first broadcast fro residence Dream Home', 0, '2014-08-19 09:42:25', '2014-01-01 00:00:00', '', '2014-01-01 00:00:00', '', 'event.jpg', 'Sent'),
(17, 3, 2, 0, 0, 'Second Notice', 'This is second notice from sp softtech', 0, '2014-08-19 10:48:58', '2014-08-19 00:00:00', '', '2014-08-19 00:00:00', '', 'event.jpg', 'Sent'),
(18, 3, 2, 0, 0, 'Third Notice', 'This is third notice from sp softtech', 0, '2014-08-19 10:50:47', '2014-08-19 00:00:00', '', '2014-08-19 00:00:00', '', 'event.jpg', 'Sent'),
(19, 3, 2, 0, 0, 'Fourth Notice', 'This is fourth notice from sp softtech', 0, '2014-08-19 11:00:42', '2014-08-19 00:00:00', '', '2014-08-19 00:00:00', '', 'event.jpg', 'Sent'),
(20, 3, 2, 0, 0, 'Fifth Notice', 'This is fifth notice from sp softtech', 0, '2014-08-19 11:02:43', '2014-08-19 00:00:00', '', '2014-08-19 00:00:00', '', 'event.jpg', 'Sent'),
(21, 3, 2, 0, 0, 'Sixth Notice', 'This is sixth notice from sp softtech', 0, '2014-08-19 11:04:16', '2014-08-19 00:00:00', '', '2014-08-19 00:00:00', '', 'event.jpg', 'Sent'),
(22, 3, 2, 0, 0, 'Seventh Notice', 'This is seventh notice from sp softtech', 0, '2014-08-19 11:17:24', '2014-08-19 00:00:00', '', '2014-08-19 00:00:00', '', 'event.jpg', 'Sent'),
(23, 3, 2, 0, 0, 'Eighth Notice', 'This is eighth notice from sp softtech', 0, '2014-08-19 11:20:40', '2014-08-19 00:00:00', '', '2014-08-19 00:00:00', '', 'event.jpg', 'Sent'),
(24, 3, 2, 0, 0, 'Ninth Notice', 'This is ninth notice from sp softtech', 0, '2014-08-19 13:54:47', '2014-08-19 00:00:00', '', '2014-08-19 00:00:00', '', 'event.jpg', 'Sent'),
(25, 3, 2, 0, 0, 'test', 'test notice', 0, '2014-08-19 14:09:01', '2014-08-19 00:00:00', '', '2014-08-19 00:00:00', '', 'event.jpg', 'Sent'),
(26, 3, 2, 0, 0, 'another test', 'another test notice', 0, '2014-08-19 14:12:00', '2014-08-19 00:00:00', '', '2014-08-19 00:00:00', '', 'event.jpg', 'Sent'),
(27, 3, 2, 0, 0, 'Notice-1', 'This is another notice', 0, '2014-12-13 08:41:40', '2014-12-12 18:00:00', '', '2014-12-12 18:00:00', '', 'event.jpg', 'Sent'),
(28, 11, 2, 0, 0, 'First Notice', 'This is the first notice from Rural Fire. This is the first notice from Rural Fire. This is the first notice from Rural Fire. This is the first notice from Rural Fire. This is the first notice from Rural Fire. This is the first notice from Rural Fire. This is the first notice from Rural Fire. This is the first notice from Rural Fire. This is the first notice from Rural Fire. This is the first notice from Rural Fire. This is the first notice from Rural Fire. This is the first notice from Rural Fire. ', 0, '2014-12-14 10:00:55', '2014-12-13 18:00:00', '', '2014-12-13 18:00:00', '', 'event.jpg', 'Sent'),
(29, 11, 2, 4, 0, 'Message from Rural Fire', 'This is first message from Rural Fire to Dream Home', 0, '2014-12-13 00:00:00', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', '', 'sent'),
(30, 4, 3, 11, 0, 'First message from Dream Home to Rural Fire', 'This first message from Dream Home to Rural Fire', 0, '2014-12-14 00:00:00', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', '', 'sent'),
(31, 4, 3, 11, 0, 'Message From Residence', 'this is another message from Dream Home to Rural Fire', 0, '2014-12-14 13:39:20', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', 'indivisual.jpg', 'Sent'),
(32, 4, 3, 11, 0, 'Message From Residence', 'Hi', 0, '2014-12-14 13:48:24', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', 'indivisual.jpg', 'Sent'),
(33, 4, 3, 11, 0, 'Message From Residence', 'Hello', 0, '2014-12-14 13:48:32', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', 'indivisual.jpg', 'Sent'),
(34, 4, 3, 11, 0, 'Message From Residence', 'Hello dear', 0, '2014-12-14 13:48:43', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', 'indivisual.jpg', 'Sent'),
(35, 4, 3, 11, 0, 'Message From Residence', 'r u there?', 0, '2014-12-14 13:48:55', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', 'indivisual.jpg', 'Sent'),
(36, 4, 3, 11, 0, 'Message From Residence', 'yah, I am here', 0, '2014-12-14 13:58:39', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', 'indivisual.jpg', 'Sent'),
(37, 4, 3, 11, 0, 'Message From Residence', 'r u there?', 0, '2014-12-14 14:00:29', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', 'indivisual.jpg', 'Sent'),
(38, 4, 3, 11, 0, 'Message From Residence', 'Hello', 0, '2014-12-14 15:51:46', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', 'indivisual.jpg', 'Sent'),
(39, 4, 3, 11, 0, 'Message From Residence', 'Hello', 0, '2014-12-14 15:54:32', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', 'indivisual.jpg', 'Sent'),
(40, 4, 3, 11, 0, 'Message From Residence', 'Hello', 0, '2014-12-14 16:07:39', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', 'indivisual.jpg', 'Sent'),
(41, 4, 3, 11, 0, 'Message From Residence', 'Hi', 0, '2014-12-14 16:11:30', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', 'indivisual.jpg', 'Sent'),
(42, 4, 3, 11, 0, 'Message From Residence', 'Hello', 0, '2014-12-15 17:33:22', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', 'indivisual.jpg', 'Sent'),
(43, 4, 3, 0, 12, 'Notice with receiver role', 'this is the first notice with receiver role', 0, '2014-12-18 09:47:15', '2014-12-17 18:00:00', '', '2014-12-17 18:00:00', '', 'event.jpg', 'Sent'),
(44, 1, 0, 0, 123, 'First notice from YourLink for all user type', 'this is the first notice from YourLink for all user type', 0, '2014-12-18 09:58:39', '1905-05-05 12:35:44', '', '1905-05-05 12:35:44', '', 'event.jpg', 'Sent'),
(45, 3, 2, 4, 0, 'Message From Residence', 'Hello', 0, '2014-12-23 10:39:15', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', 'indivisual.jpg', 'Sent'),
(46, 3, 2, 0, 13, 'Another notice ', 'This is ', 0, '2014-12-23 11:09:00', '1905-05-05 12:35:44', '', '1905-05-05 12:35:44', '', 'event.jpg', 'Sent'),
(47, 3, 2, 0, 13, 'Hello', 'This is hello', 0, '2014-12-24 10:16:24', '1905-05-05 12:35:44', '', '1905-05-05 12:35:44', '', 'event.jpg', 'Sent'),
(48, 3, 2, 0, 13, 'Hello', '', 0, '2014-12-24 10:54:53', '1905-05-05 12:35:44', '', '1905-05-05 12:35:44', '', 'event.jpg', 'Sent'),
(49, 3, 2, 0, 13, 'Hello', 'Hello', 0, '2014-12-24 10:55:07', '1905-05-05 12:35:44', '', '1905-05-05 12:35:44', '', 'event.jpg', 'Sent'),
(50, 3, 2, 0, 13, 'Hi', 'Hi', 0, '2014-12-24 10:56:12', '1905-05-05 12:35:44', '', '1905-05-05 12:35:44', '', 'event.jpg', 'Sent'),
(51, 3, 2, 0, 13, 'Hello', 'Hello.........', 0, '2014-12-24 10:58:00', '1905-05-05 12:35:44', '', '1905-05-05 12:35:44', '', 'event.jpg', 'Sent'),
(52, 3, 2, 0, 13, 'Hi', 'Hi.........', 0, '2014-12-24 10:59:27', '1905-05-05 12:35:44', '', '1905-05-05 12:35:44', '', 'event.jpg', 'Sent'),
(53, 3, 2, 0, 13, 'Hello', 'Hello', 0, '2014-12-24 11:00:32', '1905-05-05 12:35:44', '', '1905-05-05 12:35:44', '', 'event.jpg', 'Sent'),
(54, 3, 2, 0, 13, 'Hi', 'Hi..........', 0, '2014-12-24 11:02:36', '1905-05-05 12:35:44', '', '1905-05-05 12:35:44', '', 'event.jpg', 'Sent'),
(55, 3, 2, 0, 13, 'Hello', 'Hello..........', 0, '2014-12-24 11:05:29', '1905-05-05 12:35:44', '', '1905-05-05 12:35:44', '', 'event.jpg', 'Sent'),
(56, 4, 3, 0, 12, 'Hello', 'Hello', 0, '2014-12-24 11:27:33', '1905-05-05 12:35:44', '', '1905-05-05 12:35:44', '', 'event.jpg', 'Sent'),
(57, 4, 3, 0, 12, 'Hello', 'Hello', 0, '2014-12-24 11:27:47', '1905-05-05 12:35:44', '', '1905-05-05 12:35:44', '', 'event.jpg', 'Sent'),
(58, 3, 2, 4, 0, 'Message From Residence', 'Hi', 0, '2014-12-24 11:35:29', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', 'indivisual.jpg', 'Sent');

-- --------------------------------------------------------

--
-- Table structure for table `postcodes`
--

CREATE TABLE IF NOT EXISTS `postcodes` (
  `postcode_id` int(11) NOT NULL AUTO_INCREMENT,
  `state_id` int(11) NOT NULL,
  `postcode_name` varchar(50) NOT NULL,
  `updated_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`postcode_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `postcodes`
--

INSERT INTO `postcodes` (`postcode_id`, `state_id`, `postcode_name`, `updated_on`, `updated_by`) VALUES
(1, 1, '2365', '2014-12-17 10:43:11', 1),
(2, 2, '2000', '2014-07-22 00:24:14', 1),
(3, 2, '2795', '2014-07-22 00:24:41', 0),
(4, 2, '2800', '2014-07-22 00:24:41', 0),
(5, 9, '1000', '2014-12-17 11:18:39', 1);

-- --------------------------------------------------------

--
-- Table structure for table `residencesindividuals`
--

CREATE TABLE IF NOT EXISTS `residencesindividuals` (
  `residencesindividual_id` int(11) NOT NULL AUTO_INCREMENT,
  `residence_id` int(11) NOT NULL,
  `individual_id` int(11) NOT NULL,
  `individual_email` varchar(100) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`residencesindividual_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `residencesindividuals`
--

INSERT INTO `residencesindividuals` (`residencesindividual_id`, `residence_id`, `individual_id`, `individual_email`, `active`) VALUES
(1, 4, 2, 'sagor@gmail.com', 1),
(2, 4, 0, 'sohrab@yahoo.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `residencessps`
--

CREATE TABLE IF NOT EXISTS `residencessps` (
  `residencessp_id` int(11) NOT NULL AUTO_INCREMENT,
  `res_user_id` int(11) NOT NULL,
  `sp_id` int(11) NOT NULL,
  `send_receive` int(11) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`residencessp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `residencessps`
--

INSERT INTO `residencessps` (`residencessp_id`, `res_user_id`, `sp_id`, `send_receive`, `active`) VALUES
(1, 4, 3, 1, 1),
(2, 4, 5, 0, 1),
(3, 4, 8, 1, 1),
(4, 4, 7, 0, 1),
(5, 4, 11, 1, 1),
(6, 4, 6, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `salutations`
--

CREATE TABLE IF NOT EXISTS `salutations` (
  `salutation_id` int(11) NOT NULL AUTO_INCREMENT,
  `salutation_name` varchar(20) NOT NULL,
  `updated_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`salutation_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `salutations`
--

INSERT INTO `salutations` (`salutation_id`, `salutation_name`, `updated_on`, `updated_by`) VALUES
(1, 'Mr.', '2014-12-17 10:27:39', 1),
(3, 'Ms.', '2014-07-05 15:50:02', 1),
(4, 'Mrs.', '2014-12-17 11:06:18', 1),
(5, 'Mss.', '2014-12-17 11:06:46', 1);

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE IF NOT EXISTS `states` (
  `state_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `state_name` varchar(100) NOT NULL,
  `updated_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`state_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`state_id`, `country_id`, `state_name`, `updated_on`, `updated_by`) VALUES
(1, 1, 'Australian Capital Territory', '2014-12-17 10:42:31', 1),
(2, 1, 'New South Wales', '2014-07-22 00:19:11', 1),
(3, 1, 'Victoria', '2014-07-22 00:19:22', 1),
(4, 1, 'Queensland', '2014-07-22 00:20:35', 0),
(5, 1, 'South Australia', '2014-07-22 00:20:42', 0),
(6, 1, 'Western Australia', '2014-07-22 00:21:15', 0),
(7, 1, 'Tasmania', '2014-07-22 00:21:15', 0),
(8, 1, 'Northern Territory', '2014-07-22 00:22:39', 0),
(9, 2, 'Dhaka', '2014-12-17 11:17:49', 1);

-- --------------------------------------------------------

--
-- Table structure for table `suburbs`
--

CREATE TABLE IF NOT EXISTS `suburbs` (
  `suburb_id` int(11) NOT NULL AUTO_INCREMENT,
  `postcode_id` int(11) NOT NULL,
  `suburb_name` varchar(50) NOT NULL,
  `updated_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`suburb_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `suburbs`
--

INSERT INTO `suburbs` (`suburb_id`, `postcode_id`, `suburb_name`, `updated_on`, `updated_by`) VALUES
(1, 1, 'Blacktown', '2014-12-17 10:44:00', 1),
(2, 2, 'Sydney', '2014-07-22 00:26:49', 1),
(3, 3, 'Bathurst', '2014-07-22 00:27:15', 0),
(4, 4, 'Orange', '2014-07-22 00:27:15', 0),
(5, 5, 'Banglamotor', '2014-12-17 11:19:22', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_role` int(11) NOT NULL,
  `user_status` int(11) NOT NULL,
  `user_status_update_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `salutation` varchar(20) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL DEFAULT 'Male',
  `date_of_birth_month` varchar(10) NOT NULL,
  `date_of_birth_year` varchar(10) NOT NULL,
  `organisation_name` varchar(100) NOT NULL,
  `organisation_description` varchar(1000) NOT NULL,
  `address` varchar(500) NOT NULL,
  `country` varchar(50) NOT NULL,
  `suburb` varchar(50) NOT NULL,
  `postcode` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `residence` int(11) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `image_url` varchar(50) NOT NULL,
  `primary_contact` varchar(100) NOT NULL,
  `primary_contact_last` varchar(100) NOT NULL,
  `category` int(11) NOT NULL,
  `password` varchar(100) NOT NULL,
  `api_key` varchar(100) NOT NULL,
  `created_on` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `last_login_on` datetime NOT NULL,
  `suspend_account` int(11) NOT NULL,
  `star` int(11) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_role`, `user_status`, `user_status_update_date`, `salutation`, `first_name`, `last_name`, `gender`, `date_of_birth_month`, `date_of_birth_year`, `organisation_name`, `organisation_description`, `address`, `country`, `suburb`, `postcode`, `state`, `residence`, `phone`, `email`, `image_url`, `primary_contact`, `primary_contact_last`, `category`, `password`, `api_key`, `created_on`, `created_by`, `updated_on`, `updated_by`, `last_login_on`, `suspend_account`, `star`) VALUES
(1, 0, 1, '0000-00-00 00:00:00', '', 'Sohrab', 'Hossan', 'Male', '', '', '', '', '', '', '', '', '', 0, '', 'aantu69@gmail.com', '', '', '', 0, '$2a$10$f24933239a295a166a6c0udFC6ANRTSAuxunByI0hr0IyltUNA7Mm', '66e0a5dd6e178695bc93f5f548a43274', '2014-07-03 11:33:52', 1, '2014-12-17 20:31:51', 1, '0000-00-00 00:00:00', 0, 0),
(2, 1, 1, '0000-00-00 00:00:00', 'Mr.', 'Sagor', 'Mahmud', 'Male', '', '', '', '', '', 'Bangladesh', 'Banglamotor', '2365', 'Dhaka', 1, '01670256365', 'sagor@gmail.com', 'app.png', '', '', 1, '$2a$10$093904224fba669c20d8euA48GitqvBYsAOOmdXYwtZTNc9yM/pM6', 'eed91e97f6bc17f5fb26543b8fa6ee7b', '2014-07-16 00:28:35', 1, '2014-07-16 00:28:35', 1, '0000-00-00 00:00:00', 0, 0),
(3, 2, 1, '0000-00-00 00:00:00', '', '', '', 'Male', '', '', 'softtech', 'this is special', 'dhaka, bangladesh', 'Bangladesh', 'Banglamotor', '2365', 'Dhaka', 0, '+8801817580884', 'aantu69@yahoo.com', 'sp.png', '+88028829755', '', 2, '$2a$10$2b565e66f8469ac82bb82erHzKvqkSbYUKD0pstpB.P1ic.QuHT3a', '6b90fbbeaab0233737b5701aa51ee610', '2014-07-16 04:57:05', 0, '2014-12-22 18:13:47', 3, '0000-00-00 00:00:00', 0, 0),
(4, 3, 1, '0000-00-00 00:00:00', '', '', '', 'Male', '', '', 'Dream Homes', 'this is an event manager organisation', 'Banglamotors', 'Australia', 'Blacktown', '2365', 'Australian Capital Territory', 1, '+8801670233170', 'aantu69@hotmail.com', 'residence.png', '+88028829755', '', 3, '$2a$10$ddacf71c6971fbfd1ea85u/6zq4XppJ7KKOER.VPW/Dd/T0ynTydy', 'c4a42df7e876b3a0461b02509e0a781f', '2014-07-16 05:46:03', 0, '2014-12-22 18:16:58', 4, '0000-00-00 00:00:00', 0, 0),
(5, 3, 1, '0000-00-00 00:00:00', '', '', '', 'Male', '', '', 'Meals on Wheels', 'The Commonwealth HACC Program provides services that support older people to stay at home and be more independent in the community.', 'Sydney', 'Australia', 'Blacktown', '2365', 'Australian', 0, '01670233170', 'mealsonwheels@gmail.com', '1408026566.jpg', '028829755', '', 2, '$2a$10$8461aef79bbc29a7847c8uRJMjBuBSqSsf8LYaPwFUGuJgm03afLG', '7dd07ce3d39eb7078c8a8e204121b249', '2014-08-14 14:29:26', 0, '2014-08-14 14:29:26', 0, '0000-00-00 00:00:00', 0, 0),
(6, 2, 1, '0000-00-00 00:00:00', '', '', '', 'Male', '', '', 'Carewest', 'The Commonwealth HACC Program provides services that support older people to stay at home and be more independent in the community.', 'Sydney', 'Australia', 'Blacktown', '2365', 'Australian', 0, '01670233170', 'carewest@gmail.com', '1408026633.jpg', '028829755', '', 2, '$2a$10$39ba1f8d373c638a1a9a7ucDudRaRIEH7tkJQkZfmy9GVd2PyZoE.', '5bbb891442ecdbafc9c5be521d20bea4', '2014-08-14 14:30:33', 0, '2014-08-14 14:30:33', 0, '0000-00-00 00:00:00', 0, 0),
(7, 2, 1, '0000-00-00 00:00:00', '', '', '', 'Male', '', '', 'Uniting Church', 'The Commonwealth HACC Program provides services that support older people to stay at home and be more independent in the community.', 'Sydney', 'Australia', 'Blacktown', '2365', 'Australian', 0, '01670233170', 'unitingchurch@gmail.com', '1408026696.jpg', '028829755', '', 3, '$2a$10$7352a545126a497ce469aezLkdGi7IVT.93cZ7NIhyHHQ4qieiUQm', '785f8dd8e5073b82ab0cf3ee89e36d07', '2014-08-14 14:31:36', 0, '2014-08-14 14:31:36', 0, '0000-00-00 00:00:00', 0, 0),
(8, 3, 1, '0000-00-00 00:00:00', '', '', '', 'Male', '', '', 'Catholic Orange', 'The Commonwealth HACC Program provides services that support older people to stay at home and be more independent in the community.', 'Sydney', 'Australia', 'Blacktown', '2365', 'Australian', 0, '01670233170', 'catholicorange@gmail.com', '1408026761.jpg', '028829755', '', 3, '$2a$10$6c802bd1e05a868b505c1OAM5KtxDMmBH6OWKD5uEVNwVpYj510va', '2308373feb4ac11cd0176c58ec973c76', '2014-08-14 14:32:41', 0, '2014-08-14 14:32:41', 0, '0000-00-00 00:00:00', 0, 0),
(9, 2, 1, '0000-00-00 00:00:00', '', '', '', 'Male', '', '', 'Parkwood Orange', 'The Commonwealth HACC Program provides services that support older people to stay at home and be more independent in the community.', 'Sydney', 'Australia', 'Blacktown', '2365', 'Australian Capital Territory', 0, '+8801670233170', 'parkwoodorange@gmail.com', 'sp.png', '+88028829755', '', 4, '$2a$10$42bbc6effc48afdc08a8au0gEh5N41YXs7sbiQQOpaJRys.SPBM5O', '083931f1e50cfdc44361d444bd7c1913', '2014-08-14 14:33:43', 0, '2014-12-17 18:21:00', 9, '0000-00-00 00:00:00', 0, 0),
(10, 3, 1, '0000-00-00 00:00:00', '', '', '', 'Male', '', '', 'Bathurst Aged Care', 'The Commonwealth HACC Program provides services that support older people to stay at home and be more independent in the community.', 'Sydney', 'Australia', 'Blacktown', '2365', 'Australian', 0, '01670233170', 'bathurstagedcare@gmail.com', '1408026870.jpg', '028829755', '', 4, '$2a$10$641cf8839ea0584255a08usRSRIwUiAiyxS3QAv0pObGKljdny9wG', 'b718995c7ad1359c8d2b7e026d147e36', '2014-08-14 14:34:30', 0, '2014-08-14 14:34:30', 0, '0000-00-00 00:00:00', 0, 0),
(11, 3, 1, '0000-00-00 00:00:00', '', '', '', 'Male', '', '', 'Rural Fire', 'The Commonwealth HACC Program provides services that support older people to stay at home and be more independent in the community.', 'Sydney', 'Australia', 'Blacktown', '2365', 'Australian', 0, '01670233170', 'ruralfire@gmail.com', '1408026938.jpg', '028829755', '', 5, '$2a$10$a004cbaab977271bfa148uB8gNAFfSLlOekfuSbWkY6XRakHENX6q', '4c2d8d363a9821082125e8a30e5be809', '2014-08-14 14:35:38', 0, '2014-08-14 14:35:38', 0, '0000-00-00 00:00:00', 0, 0),
(12, 2, 1, '0000-00-00 00:00:00', '', '', '', 'Male', '', '', 'SES', 'The Commonwealth HACC Program provides services that support older people to stay at home and be more independent in the community.', 'Sydney', 'Australia', 'Orange', '2800', 'New', 0, '01670233170', 'ses@gmail.com', '1408027000.jpg', '028829755', '', 5, '$2a$10$20866289ec4a6d560a8b3u7uzU8x4ETx7qRvFQnIfDmvU/FxyCaP6', '3acb87502ea93c6dd5758b66bfa73e39', '2014-08-14 14:36:40', 0, '2014-08-14 14:36:40', 0, '0000-00-00 00:00:00', 0, 0),
(13, 3, 1, '0000-00-00 00:00:00', '', '', '', 'Male', '', '', 'Orange Council', 'The Commonwealth HACC Program provides services that support older people to stay at home and be more independent in the community.', 'Sydney', 'Australia', 'Orange', '2800', 'New', 0, '01670233170', 'orangecouncil@gmail.com', '1408027046.jpg', '028829755', '', 6, '$2a$10$c71b1e24b534c933c6b71eSSipomP2n/wnjaGJQu.6Mn5dxtOZJOe', 'bc68e06ad8aaa03d83a96bbbfba0bf24', '2014-08-14 14:37:26', 0, '2014-08-14 14:37:26', 0, '0000-00-00 00:00:00', 0, 0),
(14, 3, 1, '0000-00-00 00:00:00', '', '', '', 'Male', '', '', 'Rural Women', 'The Commonwealth HACC Program provides services that support older people to stay at home and be more independent in the community.', 'Sydney', 'Australia', 'Orange', '2800', 'New', 0, '01670233170', 'ruralwomen@gmail.com', '1408027097.jpg', '028829755', '', 7, '$2a$10$94e9b4d690cfc2d400241uftV2vU0f0yOfuKzW7i/6Cm19f7wnnMu', '09b6f071fbf99a591b945a6065c70930', '2014-08-14 14:38:17', 0, '2014-08-14 14:38:17', 0, '0000-00-00 00:00:00', 0, 0),
(15, 2, 1, '0000-00-00 00:00:00', '', '', '', 'Male', '', '', 'Conservation ', 'The Commonwealth HACC Program provides services that support older people to stay at home and be more independent in the community.', 'Sydney', 'Australia', 'Orange', '2800', 'New', 0, '01670233170', 'conservation@gmail.com', '1408027179.jpg', '028829755', '', 8, '$2a$10$491c30620d6d2c2288a39OCtIUSPJ9BF8.9RvJY0bDp2tVPoLrZF2', '32bb8e6df0dfa457c5b13ec0a4583f6f', '2014-08-14 14:39:39', 0, '2014-08-14 14:39:39', 0, '0000-00-00 00:00:00', 0, 0),
(16, 3, 1, '0000-00-00 00:00:00', '', '', '', 'Male', '', '', 'Salvation Army', 'The Commonwealth HACC Program provides services that support older people to stay at home and be more independent in the community.', 'Sydney', 'Australia', 'Orange', '2800', 'New', 0, '01670233170', 'salvationarmy@gmail.com', '1408027259.jpg', '028829755', '', 9, '$2a$10$52ff904a7236f7a412925uoZPKns6xRhumwWw67nIBobTxckCuyn2', 'cb52af7663f4c3617a99f7a511a66f5e', '2014-08-14 14:40:59', 0, '2014-08-14 14:40:59', 0, '0000-00-00 00:00:00', 0, 0),
(17, 3, 1, '0000-00-00 00:00:00', '', '', '', 'Male', '', '', 'University 3rd Age', 'The Commonwealth HACC Program provides services that support older people to stay at home and be more independent in the community.', 'Sydney', 'Australia', 'Orange', '2800', 'New', 0, '01670233170', 'university3rdage@gmail.com', '1408027318.jpg', '028829755', '', 10, '$2a$10$1c904df4830b3b2ed841eedeHmfAQCuLnnBXrl6RApM5mBtj2G.jy', 'ab91911839b8a97b7113ad21748f2fe7', '2014-08-14 14:41:58', 0, '2014-08-14 14:41:58', 0, '0000-00-00 00:00:00', 0, 0),
(18, 3, 1, '0000-00-00 00:00:00', '', '', '', 'Male', '', '', 'Mobility Orange', 'The Commonwealth HACC Program provides services that support older people to stay at home and be more independent in the community.', 'Sydney', 'Australia', 'Orange', '2800', 'New', 0, '01670233170', 'mobilityorange@gmail.com', '1408027396.jpg', '028829755', '', 12, '$2a$10$6f5edbbd96f83db5b8c15u0yTJbrg/QLztbR0UdJLzpdmgXwC9UIq', '86f98d75da033777115131e5cb77ca28', '2014-08-14 14:43:16', 0, '2014-08-14 14:43:16', 0, '0000-00-00 00:00:00', 0, 0),
(19, 1, 1, '0000-00-00 00:00:00', 'Mr.', 'Sakib', 'Hasan', 'Male', '', '', '', '', '', 'Bangladesh', 'Gulshan', '1212', 'Dhaka', 1, '01670233170', 'sakib@yahoo.com', 'app.png', '', '', 0, '$2a$10$9d576e19ab5fa69af9247OTEw5Dqu7Q.17URSmRIDMSbskqeMNbKC', '30ec5c7373e6c5237636983a4a9169a3', '2014-08-19 21:26:11', 1, '2014-08-19 21:26:11', 1, '0000-00-00 00:00:00', 0, 0),
(36, 0, 1, '0000-00-00 00:00:00', '', 'Enamul', 'Haq', 'Male', '', '', '', '', '', '', '', '', '', 0, '', 'enam@yahoo.com', '', '', '', 0, '$2a$10$3698218897e40f44ab36fOXsXvx8.saGWuXsYF2mSiTpQvh62rpae', '90d1245757e86315bfe76a0596dd67c0', '2014-12-17 20:16:33', 1, '2014-12-17 20:16:33', 1, '0000-00-00 00:00:00', 0, 0),
(37, 2, 1, '0000-00-00 00:00:00', '', '', '', 'Male', '', '', 'okapia', 'this is aged & dssability service provide', '', 'Australia', 'Sydney', '2000', 'New South Wales', 0, '+8801670233170', 'okapia@gmail.com', '1419225925.jpg', '+8802889569', '', 2, '$2a$10$d692113581428efa00cedulDhXSygXm4T/mpyRwUX1p2mtop7Dzea', '65717217a0f56e369b3c52fb874d721a', '2014-12-22 05:25:25', 0, '2014-12-22 05:25:25', 0, '0000-00-00 00:00:00', 0, 0);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_sps_broadcast`
--
CREATE TABLE IF NOT EXISTS `view_sps_broadcast` (
`user_id` int(11)
,`user_role` int(11)
,`user_status` int(11)
,`user_status_update_date` timestamp
,`salutation` varchar(20)
,`first_name` varchar(50)
,`last_name` varchar(50)
,`organisation_name` varchar(100)
,`organisation_description` varchar(1000)
,`address` varchar(500)
,`country` varchar(50)
,`suburb` varchar(50)
,`postcode` varchar(50)
,`state` varchar(50)
,`residence` int(11)
,`phone` varchar(50)
,`email` varchar(50)
,`image_url` varchar(50)
,`primary_contact` varchar(100)
,`primary_contact_last` varchar(100)
,`category` int(11)
,`password` varchar(100)
,`api_key` varchar(100)
,`created_on` datetime
,`created_by` int(11)
,`updated_on` datetime
,`updated_by` int(11)
,`last_login_on` datetime
,`suspend_account` int(11)
,`star` int(11)
,`message_id` int(11)
,`sender_id` int(11)
,`sender_role` int(11)
,`receiver_id` int(11)
,`message_title` varchar(100)
,`description` varchar(2000)
,`event` int(11)
,`sent_time` datetime
,`event_start_date` datetime
,`event_start_time` varchar(10)
,`event_end_date` datetime
,`event_end_time` varchar(10)
,`attachment_url` varchar(100)
,`status` varchar(10)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `view_sp_res`
--
CREATE TABLE IF NOT EXISTS `view_sp_res` (
`category_id` int(11)
,`category_name` varchar(100)
,`order_level` int(11)
,`second_level` varchar(10)
,`user_id` int(11)
,`user_role` int(11)
,`user_status` int(11)
,`user_status_update_date` timestamp
,`salutation` varchar(20)
,`first_name` varchar(50)
,`last_name` varchar(50)
,`organisation_name` varchar(100)
,`organisation_description` varchar(1000)
,`address` varchar(500)
,`country` varchar(50)
,`suburb` varchar(50)
,`postcode` varchar(50)
,`state` varchar(50)
,`residence` int(11)
,`phone` varchar(50)
,`email` varchar(50)
,`image_url` varchar(50)
,`primary_contact` varchar(100)
,`primary_contact_last` varchar(100)
,`category` int(11)
,`password` varchar(100)
,`api_key` varchar(100)
,`created_on` datetime
,`created_by` int(11)
,`updated_on` datetime
,`updated_by` int(11)
,`last_login_on` datetime
,`suspend_account` int(11)
,`star` int(11)
);
-- --------------------------------------------------------

--
-- Structure for view `view_sps_broadcast`
--
DROP TABLE IF EXISTS `view_sps_broadcast`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_sps_broadcast` AS select `u`.`user_id` AS `user_id`,`u`.`user_role` AS `user_role`,`u`.`user_status` AS `user_status`,`u`.`user_status_update_date` AS `user_status_update_date`,`u`.`salutation` AS `salutation`,`u`.`first_name` AS `first_name`,`u`.`last_name` AS `last_name`,`u`.`organisation_name` AS `organisation_name`,`u`.`organisation_description` AS `organisation_description`,`u`.`address` AS `address`,`u`.`country` AS `country`,`u`.`suburb` AS `suburb`,`u`.`postcode` AS `postcode`,`u`.`state` AS `state`,`u`.`residence` AS `residence`,`u`.`phone` AS `phone`,`u`.`email` AS `email`,`u`.`image_url` AS `image_url`,`u`.`primary_contact` AS `primary_contact`,`u`.`primary_contact_last` AS `primary_contact_last`,`u`.`category` AS `category`,`u`.`password` AS `password`,`u`.`api_key` AS `api_key`,`u`.`created_on` AS `created_on`,`u`.`created_by` AS `created_by`,`u`.`updated_on` AS `updated_on`,`u`.`updated_by` AS `updated_by`,`u`.`last_login_on` AS `last_login_on`,`u`.`suspend_account` AS `suspend_account`,`u`.`star` AS `star`,`m`.`message_id` AS `message_id`,`m`.`sender_id` AS `sender_id`,`m`.`sender_role` AS `sender_role`,`m`.`receiver_id` AS `receiver_id`,`m`.`message_title` AS `message_title`,`m`.`description` AS `description`,`m`.`event` AS `event`,`m`.`sent_time` AS `sent_time`,`m`.`event_start_date` AS `event_start_date`,`m`.`event_start_time` AS `event_start_time`,`m`.`event_end_date` AS `event_end_date`,`m`.`event_end_time` AS `event_end_time`,`m`.`attachment_url` AS `attachment_url`,`m`.`status` AS `status` from ((`users` `u` join `messages` `m` on((`u`.`user_id` = `m`.`sender_id`))) join `residencessps` `r` on((`m`.`sender_id` = `r`.`sp_id`))) order by `m`.`sent_time` desc;

-- --------------------------------------------------------

--
-- Structure for view `view_sp_res`
--
DROP TABLE IF EXISTS `view_sp_res`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_sp_res` AS select `c`.`level_one_class_id` AS `category_id`,`c`.`level_one_class_name` AS `category_name`,`c`.`level_one_class_order` AS `order_level`,`c`.`level_one_class_contain_level_two` AS `second_level`,`u`.`user_id` AS `user_id`,`u`.`user_role` AS `user_role`,`u`.`user_status` AS `user_status`,`u`.`user_status_update_date` AS `user_status_update_date`,`u`.`salutation` AS `salutation`,`u`.`first_name` AS `first_name`,`u`.`last_name` AS `last_name`,`u`.`organisation_name` AS `organisation_name`,`u`.`organisation_description` AS `organisation_description`,`u`.`address` AS `address`,`u`.`country` AS `country`,`u`.`suburb` AS `suburb`,`u`.`postcode` AS `postcode`,`u`.`state` AS `state`,`u`.`residence` AS `residence`,`u`.`phone` AS `phone`,`u`.`email` AS `email`,`u`.`image_url` AS `image_url`,`u`.`primary_contact` AS `primary_contact`,`u`.`primary_contact_last` AS `primary_contact_last`,`u`.`category` AS `category`,`u`.`password` AS `password`,`u`.`api_key` AS `api_key`,`u`.`created_on` AS `created_on`,`u`.`created_by` AS `created_by`,`u`.`updated_on` AS `updated_on`,`u`.`updated_by` AS `updated_by`,`u`.`last_login_on` AS `last_login_on`,`u`.`suspend_account` AS `suspend_account`,`u`.`star` AS `star` from (`level_one_classes` `c` join `users` `u` on((`c`.`level_one_class_id` = `u`.`category`))) order by `c`.`level_one_class_order` limit 0,30;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
