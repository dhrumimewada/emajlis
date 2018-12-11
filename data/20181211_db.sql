-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 11, 2018 at 04:07 AM
-- Server version: 5.6.39-83.1
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `develope_emajlis`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(100) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1' COMMENT '(0-deactive,1-active)',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `username`, `password`, `role`, `status`, `created_date`) VALUES
(1, 'emajlis@admin.com', 'Emajlis Admin', 'e10adc3949ba59abbe56e057f20f883e', 'admin', 1, '2018-10-23 11:25:20');

-- --------------------------------------------------------

--
-- Table structure for table `advertise`
--

CREATE TABLE `advertise` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `url` varchar(100) NOT NULL,
  `impression_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `advertise`
--

INSERT INTO `advertise` (`id`, `title`, `description`, `image`, `url`, `impression_count`) VALUES
(4, 'Get flat discount', 'Get flat discount', '', 'https://google.com', 250),
(5, 'Upwork ', 'Operators are used to perform operations on variables and values.\r\n\r\nPHP divides the operators in the following groups:', 'assets/images/advertisements/14e385c3b11d75624361cb1b72b06cf9.jpg', 'https://www.w3schools.com/', 0),
(6, 'test add', 'The PHP arithmetic operators are used with numeric values to perform common arithmetical operations, such as addition, subtraction, multiplication etc.', 'advertisement_1542800937.png', 'https://www.w3schools.com/ph', 0),
(7, 'Upwork2', 'dsfdsdsdf', '', 'https://www.google.com/search?ei=0Dn1W6O3A4HRvgTvtJ6oBA&q=examples+of+good+adword', 0);

-- --------------------------------------------------------

--
-- Table structure for table `analytics`
--

CREATE TABLE `analytics` (
  `id` int(11) NOT NULL,
  `advertise_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `advertise_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_settings`
--

CREATE TABLE `app_settings` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `version` varchar(11) NOT NULL,
  `updated_status` int(1) NOT NULL DEFAULT '1' COMMENT '(0-inactive,1-active)'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_settings`
--

INSERT INTO `app_settings` (`id`, `name`, `version`, `updated_status`) VALUES
(1, 'Android', '1.0.0', 0),
(2, 'IOS', '2.0.0', 1),
(3, 'MaintenanceMode', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `authorization`
--

CREATE TABLE `authorization` (
  `Id` int(20) NOT NULL,
  `passwordfor` varchar(500) NOT NULL,
  `password` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `authorization`
--

INSERT INTO `authorization` (`Id`, `passwordfor`, `password`) VALUES
(1, 'app_setting', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `sender_id`, `receiver_id`, `message`, `created_date`) VALUES
(8, 110, 113, 'aGVsbG8=', '2018-12-04 13:44:42'),
(9, 113, 110, 'aGVsbG8=', '2018-12-04 13:44:51'),
(10, 110, 113, 'TWF5IHRoZSBjbG9zZW5lc3Mgb2YgZnJpZW5kcywgdGhlIGNvbWZvcnQgb2YgaG9tZSwgYW5kIHRoZSB1bml0eSBvZiBvdXIgbmF0aW9uLCByZW5ldyB5b3VyIHNwaXJpdHMgdGhpcyBmZXN0aXZlIHNlYXNvbi4gTWVycnkgQ2hyaXN0bWFzIHRvIHlvdXIgZmFtaWx5LiAnVGlzIHRoZSBzZWFzb24gdG8gd2lzaCBvbmUgYW5vdGhlciBqb3kgYW5kIGxvdmUgYW5kIHBlYWNlLiBUaGVzZSBhcmUgbXkgd2lzaGVzIGZvciB5b3UsIE1lcnJ5IENocmlzdG1hcyBvdXIgZGVhciBmcmllbmRzLCBtYXkgeW91IGZlZWwgdGhlIGxvdmUgdGhpcyBzcGVjaWFsIGRheS4=', '2018-12-04 13:45:04'),
(11, 113, 110, 'c2FtZSB0byB5b3UuLiBob3dzIHlvdT8=', '2018-12-04 13:45:35'),
(12, 110, 113, 'U28gZ29vZA==', '2018-12-04 13:45:46'),
(13, 110, 109, 'SGV5IGZyaWVuZA==', '2018-12-04 13:49:03'),
(14, 109, 110, 'SGV5IGhvd3MgeW91', '2018-12-04 13:50:47'),
(15, 110, 109, 'UHJldHR5IGdvb2Q=', '2018-12-04 13:51:04'),
(16, 109, 110, 'VGFsayB0byB5b3UgbGF0ZXI=', '2018-12-04 13:51:21'),
(17, 110, 27, 'aGkgaG93IGFyZSB5b3U/', '2018-12-05 04:50:28'),
(18, 110, 27, 'aGkgaG93IGFyZSB5b3U/', '2018-12-05 04:51:40'),
(19, 110, 27, 'aGkgaG93IGFyZSB5b3U/', '2018-12-05 04:53:49'),
(20, 110, 27, 'aGkgaG93IGFyZSB5b3U/', '2018-12-05 04:58:45'),
(21, 110, 27, 'aGkgaG93IGFyZSB5b3U/', '2018-12-05 04:59:14'),
(22, 110, 27, 'aGkgaG93IGFyZSB5b3U/', '2018-12-05 05:01:51'),
(23, 110, 27, 'aGkgaG93IGFyZSB5b3U/', '2018-12-05 05:09:01'),
(24, 27, 110, 'aGkgaG93IGFyZSB5b3U/', '2018-12-05 05:10:21'),
(25, 110, 27, 'aGkgaG93IGFyZSB5b3U/', '2018-12-05 05:10:37'),
(26, 27, 136, 'aGkgaG93IGFyZSB5b3U/', '2018-12-05 05:54:02'),
(27, 27, 136, 'aGkgaG93IGFyZSB5b3U/', '2018-12-05 06:08:43'),
(28, 27, 136, 'aGksIGhvdyBhcmUgeW91Pw==', '2018-12-05 06:12:24'),
(29, 136, 27, 'aGkh', '2018-12-05 06:16:02'),
(30, 136, 27, 'aGkh', '2018-12-05 06:58:27'),
(31, 27, 136, 'aGkh', '2018-12-05 06:58:45'),
(32, 27, 136, 'R29vZCBNb3JyaW5n', '2018-12-05 06:59:08'),
(33, 27, 136, 'R29vZCBNb3JyaW5n', '2018-12-05 06:59:25'),
(34, 27, 136, 'R29vZCBNb3JyaW5n', '2018-12-05 07:44:01'),
(35, 136, 27, 'R29vZCBNb3JyaW5n', '2018-12-05 07:44:21'),
(36, 27, 136, 'R29vZCBNb3JyaW5n', '2018-12-05 07:47:01'),
(37, 27, 136, 'R29vZCBNb3JyaW5n', '2018-12-05 07:49:28'),
(38, 136, 27, 'R29vZCBNb3JyaW5n', '2018-12-05 07:50:12'),
(39, 27, 136, 'aGk=', '2018-12-05 09:10:04'),
(40, 136, 27, 'R29vZCBNb3JyaW5n', '2018-12-05 09:11:22'),
(41, 27, 136, 'R29vZCBNb3JyaW5n', '2018-12-05 09:11:56'),
(42, 136, 27, 'R29vZCBNb3JyaW5n', '2018-12-05 09:12:38'),
(43, 136, 27, 'aGk=', '2018-12-05 09:20:15'),
(44, 27, 136, 'R29vZCBNb3JyaW5n', '2018-12-05 09:20:48'),
(45, 136, 27, 'R29vZCBNb3JyaW5n', '2018-12-05 09:31:53'),
(46, 136, 27, 'R29vZCBNb3JyaW5n', '2018-12-05 09:36:59'),
(47, 27, 136, 'R29vZCBNb3JyaW5n', '2018-12-05 09:37:15'),
(48, 27, 136, 'R29vZCBNb3JyaW5n', '2018-12-05 09:38:34'),
(49, 136, 27, 'R29vZCBNb3JyaW5n', '2018-12-05 09:38:42'),
(50, 27, 136, 'R29vZCBNb3JyaW5n', '2018-12-05 09:40:03'),
(51, 27, 136, 'R29vZCBNb3JyaW5n', '2018-12-05 09:40:39'),
(52, 27, 136, 'R29vZCBNb3JyaW5n', '2018-12-05 09:44:09'),
(53, 27, 136, 'MTM2', '2018-12-05 09:45:14'),
(54, 27, 136, 'MTM2', '2018-12-05 09:53:33'),
(55, 27, 136, 'aGVsbG8=', '2018-12-05 09:57:40'),
(56, 136, 27, 'R29vZCBhZnRlcm5vb24=', '2018-12-05 09:58:40'),
(57, 27, 136, 'aGk=', '2018-12-05 10:11:12'),
(58, 27, 136, 'aGk=', '2018-12-05 10:21:44'),
(59, 27, 136, 'Y3lpZGl5eWQ=', '2018-12-05 10:24:12'),
(60, 136, 27, 'R29vZCBhZnRlcm5vb24=', '2018-12-05 10:34:55'),
(61, 136, 27, 'R29vZCBhZnRlcm5vb24=', '2018-12-05 10:36:06'),
(62, 136, 27, 'R29vZCBhZnRlcm5vb24=', '2018-12-05 10:36:28'),
(63, 136, 27, 'R29vZCBhZnRlcm5vb24=', '2018-12-05 10:37:33'),
(64, 136, 27, 'aGk=', '2018-12-05 10:40:40'),
(65, 27, 136, 'aGk=', '2018-12-05 10:40:45'),
(66, 27, 136, 'aGk=', '2018-12-05 10:43:03'),
(67, 136, 27, 'aGk=', '2018-12-05 10:43:13'),
(68, 136, 27, 'aGVsbG8=', '2018-12-05 10:44:07'),
(69, 27, 136, 'aGVsbG8=', '2018-12-05 10:44:18'),
(70, 136, 27, 'aG93', '2018-12-05 10:44:34'),
(71, 27, 136, 'aGk=', '2018-12-05 10:49:54'),
(72, 136, 27, 'aGk=', '2018-12-05 10:50:42'),
(73, 136, 27, 'R29vZCBhZnRlcm5vb24=', '2018-12-05 10:50:54'),
(74, 27, 136, 'Zmhmag==', '2018-12-05 10:51:40'),
(75, 27, 136, 'eGhoeA==', '2018-12-05 11:01:16'),
(76, 136, 27, 'aG1tdQ==', '2018-12-05 11:01:35'),
(77, 27, 136, 'aGk=', '2018-12-05 11:04:40'),
(78, 27, 136, 'aGk=', '2018-12-05 11:10:38'),
(79, 27, 136, 'aGk=', '2018-12-05 11:46:50'),
(80, 136, 27, 'R29vZCBhZnRlcm5vb24=', '2018-12-05 11:47:54'),
(81, 136, 27, 'R29vZCBhZnRlcm5vb24=', '2018-12-05 11:48:14'),
(82, 136, 27, 'R29vZCBhZnRlcm5vb24=', '2018-12-05 11:48:46'),
(83, 27, 136, 'aGk=', '2018-12-05 11:49:19'),
(84, 136, 27, 'R29vZCBhZnRlcm5vb24=', '2018-12-05 11:50:01'),
(85, 27, 136, 'aGk=', '2018-12-05 11:50:55'),
(86, 27, 110, 'aGk=', '2018-12-05 11:55:14'),
(87, 27, 136, 'YXNkZmdo', '2018-12-05 11:55:39'),
(88, 27, 136, 'Zmhm', '2018-12-05 11:56:00'),
(89, 27, 110, 'aGk=', '2018-12-05 11:56:47'),
(90, 113, 110, 'dGhpcyBpcyBteSAwNToyNyBtZXNzYWdl', '2018-12-05 11:58:03'),
(91, 136, 27, 'aGk=', '2018-12-05 11:58:27'),
(92, 113, 110, 'dGhpcyBpcyBteSAwNToyOSBtZXNzYWdl', '2018-12-05 11:59:20'),
(93, 27, 136, 'aGk=', '2018-12-05 11:59:50'),
(94, 136, 27, 'aGkgdGhpcyBpcyB0aGUgZmlyc3QgbWVzc2FnZSBmcm9tIG15IHNpZGU=', '2018-12-05 12:00:03'),
(95, 27, 110, 'aGFkZ2g=', '2018-12-05 12:00:16'),
(96, 27, 136, 'aGk=', '2018-12-05 12:00:36'),
(97, 27, 136, 'aGk=', '2018-12-05 12:01:31'),
(98, 27, 136, 'bmV3IG1lc3NhZ2U=', '2018-12-05 12:01:44'),
(99, 27, 136, 'dGhpcyBpcyBteSAwNTozMyBtZXNzYWdl', '2018-12-05 12:03:39'),
(100, 27, 136, 'aGk=', '2018-12-05 12:04:28'),
(101, 136, 27, 'Z2pn', '2018-12-05 12:04:56'),
(102, 27, 136, 'aGFoc2g=', '2018-12-05 12:05:18'),
(103, 27, 134, 'aGk=', '2018-12-05 12:06:00'),
(104, 27, 136, 'dGhpcyBpcyBteSAwNTozNiBtZXNzYWdl', '2018-12-05 12:06:18'),
(105, 27, 136, 'dGhpcyBpcyBteSAwNTozNiBtZXNzYWdl', '2018-12-05 12:07:05'),
(106, 27, 136, 'dGhpcyBpcyBteSAwNTozNiBtZXNzYWdl', '2018-12-05 12:07:27'),
(107, 27, 134, 'aGk=', '2018-12-05 12:08:36'),
(108, 27, 137, 'aGk=', '2018-12-05 12:08:46'),
(109, 27, 114, 'aGk=', '2018-12-05 12:14:07'),
(110, 27, 107, 'aGk=', '2018-12-05 12:15:14'),
(111, 27, 136, 'aGk=', '2018-12-05 12:16:45'),
(112, 27, 136, 'aGk=', '2018-12-05 12:21:57'),
(113, 27, 136, 'aGk=', '2018-12-05 12:22:31'),
(114, 27, 136, 'aGk=', '2018-12-05 12:43:18'),
(115, 27, 136, 'aGk=', '2018-12-05 12:44:16'),
(116, 27, 136, 'aGk=', '2018-12-05 12:45:47'),
(117, 27, 136, 'aGk=', '2018-12-05 12:47:44'),
(118, 27, 136, 'aGk=', '2018-12-05 12:49:55'),
(119, 27, 136, 'aGk=', '2018-12-05 12:50:21'),
(120, 136, 110, 'aGk=', '2018-12-05 12:51:39'),
(121, 136, 113, 'aGk=', '2018-12-05 12:53:33'),
(122, 136, 134, 'aGk=', '2018-12-05 12:55:39'),
(123, 136, 135, 'aGk=', '2018-12-05 12:56:02'),
(124, 27, 136, 'aGk=', '2018-12-05 12:57:18'),
(125, 27, 136, 'aGk=', '2018-12-05 12:57:26'),
(126, 27, 136, 'aGk=', '2018-12-05 12:58:10'),
(127, 27, 136, 'aGk=', '2018-12-05 13:01:35'),
(128, 27, 136, 'aGk=', '2018-12-05 13:04:24'),
(129, 27, 136, 'aGk=', '2018-12-05 13:06:19'),
(130, 27, 136, 'aGk=', '2018-12-05 13:06:27'),
(131, 27, 136, 'aGk=', '2018-12-05 13:07:02'),
(132, 27, 136, 'aGk=', '2018-12-05 13:09:20'),
(133, 27, 136, 'aGk=', '2018-12-05 13:09:32'),
(134, 27, 136, 'aGk=', '2018-12-05 13:13:04'),
(135, 27, 136, 'SGk=', '2018-12-05 13:17:37'),
(136, 136, 27, 'aGk=', '2018-12-05 13:19:29'),
(137, 27, 110, 'aGk=', '2018-12-05 13:24:39'),
(138, 27, 136, 'aGk=', '2018-12-05 13:24:49'),
(139, 136, 27, 'aGk=', '2018-12-05 13:26:25'),
(140, 136, 27, 'aGk=', '2018-12-05 13:32:29'),
(141, 136, 27, 'aGk=', '2018-12-05 13:37:06'),
(142, 27, 136, 'aGk=', '2018-12-05 13:37:13'),
(143, 136, 27, 'eWZ1ZnVm', '2018-12-05 13:37:18'),
(144, 136, 27, 'VWJidWJ1c3huaXNjbmlzYw==', '2018-12-05 13:40:32'),
(145, 136, 27, 'aWhoaWhp', '2018-12-05 13:40:36'),
(146, 136, 27, 'aXMgbg==', '2018-12-05 13:40:47'),
(147, 136, 27, 'eWZnNw==', '2018-12-05 13:41:31'),
(148, 136, 27, 'YnVpaA==', '2018-12-05 13:41:42'),
(149, 139, 27, 'aGk=', '2018-12-05 13:46:43'),
(150, 139, 27, 'aGk=', '2018-12-05 13:46:51'),
(151, 139, 27, 'aGk=', '2018-12-05 13:47:13'),
(152, 139, 27, 'aGk=', '2018-12-05 13:49:56'),
(153, 139, 134, 'aGk=', '2018-12-05 13:52:24'),
(154, 140, 109, 'aGk=', '2018-12-05 13:54:52'),
(155, 140, 136, 'aGk=', '2018-12-05 13:55:01'),
(156, 140, 136, 'aG93IGFyZSB5b3U/', '2018-12-05 13:56:03'),
(157, 27, 136, 'aGk=', '2018-12-05 13:59:16'),
(158, 27, 136, 'aGk=', '2018-12-05 13:59:27'),
(159, 141, 137, 'aGk=', '2018-12-06 09:21:27'),
(160, 143, 141, 'aGk=', '2018-12-06 09:29:53'),
(161, 141, 143, 'YmNiaGo=', '2018-12-06 09:30:45'),
(162, 143, 141, 'aHZqdg==', '2018-12-06 09:30:48'),
(163, 143, 141, '8J+YgfCfmIHwn5iB', '2018-12-06 09:31:01'),
(164, 141, 143, '8J+YgfCfmIHwn5iB', '2018-12-06 09:31:08'),
(165, 143, 141, 'Z3hneGhmZ2pnamhr', '2018-12-06 09:33:47'),
(166, 143, 141, 'aGNoY2hn', '2018-12-06 09:34:02'),
(167, 143, 141, 'cXdlcmZmY2c=', '2018-12-06 09:34:07'),
(168, 141, 143, 'ZWNydnJieXk=', '2018-12-06 09:34:10'),
(169, 141, 143, 'Zmdo', '2018-12-06 09:34:12'),
(170, 141, 143, 'amprbA==', '2018-12-06 09:34:14'),
(171, 143, 141, 'YXNkZmc=', '2018-12-06 09:35:24'),
(172, 141, 143, 'eGd2eHhn', '2018-12-06 09:35:29'),
(173, 143, 141, 'Z3hoZmhm', '2018-12-06 09:40:29'),
(174, 143, 141, 'aGZmaGZq', '2018-12-06 09:40:29'),
(175, 143, 141, 'Zmhnamdq', '2018-12-06 09:40:30'),
(176, 143, 141, 'Z2pnag==', '2018-12-06 09:41:38'),
(177, 143, 141, 'ZnNkZ2Zo', '2018-12-06 09:41:59'),
(178, 143, 141, 'ZmhmaGdo', '2018-12-06 09:42:01'),
(179, 143, 141, 'dGVzdA==', '2018-12-06 09:42:53'),
(180, 143, 141, 'dGVzdCAy', '2018-12-06 09:43:01'),
(181, 143, 141, 'Z2pnamg=', '2018-12-06 09:47:15'),
(182, 143, 141, 'eXZ2eGJjY2g=', '2018-12-06 09:52:54'),
(183, 143, 141, 'eGdjaGhm', '2018-12-06 09:52:56'),
(184, 27, 110, 'aGlp', '2018-12-06 11:05:58'),
(185, 143, 144, 'aGZoZg==', '2018-12-06 11:36:28'),
(186, 145, 144, 'dnhiY2Jj', '2018-12-06 11:36:32'),
(187, 145, 144, 'Z3hjaA==', '2018-12-06 11:36:36'),
(188, 143, 144, 'ZGR5ZnlydQ==', '2018-12-06 11:36:40'),
(189, 143, 144, 'ZGdnZGZo', '2018-12-06 11:38:44'),
(190, 143, 144, 'ZmdmaGZo', '2018-12-06 11:38:44'),
(191, 145, 144, 'eGdneGhm', '2018-12-06 11:38:50'),
(192, 145, 144, 'Z2RnZmhm', '2018-12-06 11:38:51'),
(193, 145, 144, 'Y2Jodmpn', '2018-12-06 11:42:50'),
(194, 145, 144, 'Y2J2anZq', '2018-12-06 11:42:52'),
(195, 27, 136, 'R29vZCBhZnRlcm5vb24=', '2018-12-06 11:46:59'),
(196, 27, 136, 'R29vZCBhZnRlcm5vb24=', '2018-12-06 12:13:24'),
(197, 27, 136, 'dGhpcyBpcyBteSA2Nm1lc3NhZ2U=', '2018-12-06 13:18:06'),
(198, 27, 136, 'R29vZCBhZnRlcm5vb24=', '2018-12-06 13:26:24'),
(199, 27, 136, 'R29vZCBhZnRlcm5vb24=', '2018-12-06 13:53:31'),
(200, 27, 136, 'R29vZCBhZnRlcm5vb24=', '2018-12-06 13:55:33'),
(201, 27, 136, 'R29vZCBhZnRlcm5vb24=', '2018-12-06 13:56:12'),
(202, 27, 109, 'aGk=', '2018-12-06 17:16:02'),
(203, 27, 139, 'aGk=', '2018-12-07 05:58:11'),
(204, 27, 139, 'aGk=', '2018-12-07 05:58:20'),
(205, 27, 136, 'aGk=', '2018-12-07 06:02:00'),
(206, 27, 136, 'ZnVmdQ==', '2018-12-07 06:39:14'),
(207, 136, 27, 'R29vZCBhZnRlcm5vb24=', '2018-12-07 06:40:03'),
(208, 136, 27, 'R29vZCBhZnRlcm5vb24=', '2018-12-07 06:42:02'),
(209, 136, 27, 'R29vZCBhZnRlcm5vb24=', '2018-12-07 06:42:49'),
(210, 27, 136, 'aGk=', '2018-12-07 06:44:15'),
(211, 27, 136, 'aGk=', '2018-12-07 07:25:33'),
(212, 164, 153, 'dGhpcyBpcyBteSA2Nm1lc3NhZ2U=', '2018-12-07 10:22:20'),
(213, 167, 110, 'aGk=', '2018-12-07 11:58:27'),
(214, 167, 110, 'aGk=', '2018-12-07 11:58:44'),
(215, 178, 179, 'aGk=', '2018-12-07 15:38:54'),
(216, 179, 178, 'aGk=', '2018-12-07 15:39:11'),
(217, 179, 178, 'Y2hnaGpn', '2018-12-07 15:39:23'),
(218, 178, 179, 'aGk=', '2018-12-07 15:40:06'),
(219, 178, 179, 'aGVsbG8=', '2018-12-07 15:40:12'),
(220, 179, 178, 'aGk=', '2018-12-07 15:40:18'),
(221, 178, 179, 'dGVzdA==', '2018-12-07 15:42:08'),
(222, 179, 178, 'c2hkaGVo', '2018-12-07 15:42:17'),
(223, 178, 179, 'Ymh2Zmdn', '2018-12-07 15:45:17'),
(224, 178, 179, 'eGZnaA==', '2018-12-07 15:45:28'),
(225, 178, 179, 'ZmZm', '2018-12-07 15:45:40'),
(226, 178, 179, 'ZmZm', '2018-12-07 15:45:43'),
(227, 179, 178, 'Z3hoY2do', '2018-12-07 15:46:01'),
(228, 179, 178, 'amZqamY=', '2018-12-07 15:46:04'),
(229, 179, 178, 'aGdqZw==', '2018-12-07 15:46:20'),
(230, 179, 178, 'Z2pnaGg=', '2018-12-07 15:46:25'),
(231, 149, 150, 'aGk=', '2018-12-07 17:43:29'),
(232, 155, 182, 'R29vZCBhZnRlcm5vb24=', '2018-12-10 04:49:53'),
(233, 155, 182, 'R29vZCBhZnRlcm5vb24=', '2018-12-10 04:51:05'),
(234, 157, 182, 'R29vZCBhZnRlcm5vb24=', '2018-12-10 04:51:33'),
(235, 157, 182, 'R29vZCBhZnRlcm5vb24=', '2018-12-10 04:52:48'),
(236, 182, 157, 'aGk=', '2018-12-10 04:53:01'),
(237, 158, 182, 'R29vZCBhZnRlcm5vb24=', '2018-12-10 04:54:22'),
(238, 158, 182, 'R29vZCBhZnRlcm5vb24=', '2018-12-10 04:56:06'),
(239, 162, 182, 'R29vZCBhZnRlcm5vb24=', '2018-12-10 05:03:40'),
(240, 162, 182, 'R29vZCBNb3JyaW5n', '2018-12-10 05:03:51'),
(241, 182, 162, 'aGk=', '2018-12-10 05:04:03'),
(242, 164, 153, 'dGhpcyBpcyBteSA2Nm1lc3NhZ2U=', '2018-12-11 07:14:09'),
(243, 164, 153, 'dGhpcyBpcyBteSA2Nm1lc3NhZ2U=', '2018-12-11 07:15:51'),
(244, 164, 153, 'dGhpcyBpcyBteSA2Nm1lc3NhZ2U=', '2018-12-11 07:15:54'),
(245, 164, 153, 'dGhpcyBpcyBteSA2Nm1lc3NhZ2U=', '2018-12-11 07:17:21'),
(246, 164, 153, 'dGhpcyBpcyBteSA2Nm1lc3NhZ2U=', '2018-12-11 07:17:25'),
(247, 164, 153, 'MTI=', '2018-12-11 07:18:25'),
(248, 164, 153, 'MTI=', '2018-12-11 07:19:04'),
(249, 164, 153, 'MTI=', '2018-12-11 07:19:05'),
(250, 164, 153, 'b3A=', '2018-12-11 07:20:07'),
(251, 164, 107, 'b3AgdHN0', '2018-12-11 07:31:07'),
(252, 164, 107, 'b3AgdHN0', '2018-12-11 07:58:08');

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE `education` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `degree` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `school` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `education`
--

INSERT INTO `education` (`id`, `member_id`, `degree`, `school`) VALUES
(1, 181, 'Measuring and Forecasting Human Capital Investment', 'Bakrie University'),
(2, 181, 'Youth and Sustainable Development Strategies', 'Al Azhar Indonesia University'),
(4, 113, 'Measuring and Forecasting Human Capital Investment', 'Bakrie University'),
(5, 113, 'Youth and Sustainable Development Strategies', 'Al Azhar Indonesia University'),
(6, 156, 'Measuring and Forecasting Human Capital Investment', 'Bakrie University'),
(7, 156, 'Youth and Sustainable Development Strategies', 'Al Azhar Indonesia University'),
(8, 149, 'Degrees', 'Schools'),
(15, 109, 'degree', 'school'),
(16, 109, 'degree', 'school'),
(17, 109, 'degree', 'school'),
(18, 155, 'degree', 'school'),
(21, 184, 'e1', 's1'),
(22, 184, 'e2', 's2'),
(23, 170, 'degree', 'school'),
(24, 149, 'ટજટજઠ', 'જપઠજ'),
(25, 149, 'gdhs', 'zghdj');

-- --------------------------------------------------------

--
-- Table structure for table `hashtag`
--

CREATE TABLE `hashtag` (
  `id` int(11) NOT NULL,
  `tag_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `newsfeed_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hashtag`
--

INSERT INTO `hashtag` (`id`, `tag_name`, `description`, `newsfeed_url`) VALUES
(2, 'Android', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'https://abcnews.go.com/abcnews/technologyheadlines'),
(3, 'Racing', 'This is description text', 'https://abcnews.go.com/abcnews/sportsheadlines'),
(4, 'Entrepreneurship', 'This is description text', 'https://abcnews.go.com/abcnews/thisweekheadlines'),
(5, 'Startups', 'This is description text', 'https://abcnews.go.com/abcnews/moneyheadlines'),
(6, 'Technology', 'This is description text', 'https://abcnews.go.com/abcnews/technologyheadlines'),
(7, 'MentorShip', 'This is description text', 'https://abcnews.go.com/abcnews/sportsheadlines'),
(8, 'ProductDevelopment', 'This is description text', 'https://abcnews.go.com/abcnews/moneyheadlines'),
(9, 'SoftwareDevelopment', 'This is description text', 'https://abcnews.go.com/abcnews/sportsheadlines'),
(10, 'Coaching', 'This is description text', 'https://abcnews.go.com/abcnews/sportsheadlines'),
(11, 'Motivation', 'This is description text', 'https://abcnews.go.com/abcnews/sportsheadlines');

-- --------------------------------------------------------

--
-- Table structure for table `industry`
--

CREATE TABLE `industry` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `industry`
--

INSERT INTO `industry` (`id`, `name`) VALUES
(1, 'Advertising'),
(2, 'Engineering'),
(3, 'Oil and gas'),
(4, 'logistics'),
(17, 'Real Estate and Property'),
(18, 'Tourism');

-- --------------------------------------------------------

--
-- Table structure for table `keys`
--

CREATE TABLE `keys` (
  `id` int(11) NOT NULL,
  `key` varchar(40) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT '0',
  `is_private_key` tinyint(1) NOT NULL DEFAULT '0',
  `ip_addresses` text,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `keys`
--

INSERT INTO `keys` (`id`, `key`, `level`, `ignore_limits`, `is_private_key`, `ip_addresses`, `date_created`) VALUES
(1, 'Emajlis123*#*', 1, 0, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `looking_for`
--

CREATE TABLE `looking_for` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Goal';

--
-- Dumping data for table `looking_for`
--

INSERT INTO `looking_for` (`id`, `name`, `description`) VALUES
(2, 'Find a new job', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?'),
(3, 'Invest in project', 'description text'),
(4, 'Find investors', 'description test text '),
(5, 'Find mentors', 'description text'),
(6, 'Mentor others', 'description text'),
(7, 'Grow my business', 'description text'),
(8, 'Hire freelancers', 'description text'),
(9, 'Find freelance gigs', 'description text'),
(10, 'Explore a career change', 'description text'),
(11, 'Make new friends', 'description text1'),
(12, 'Get inspired', 'description text'),
(13, 'Find co-founders', 'description text');

-- --------------------------------------------------------

--
-- Table structure for table `meeting_preferences`
--

CREATE TABLE `meeting_preferences` (
  `id` int(11) NOT NULL,
  `preference_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `meeting_preferences`
--

INSERT INTO `meeting_preferences` (`id`, `preference_type`, `image_name`) VALUES
(1, 'Restaurant', 'meeting_pref_1543396755.png'),
(2, 'Breakfast', 'meeting_pref_1543396755.png'),
(3, 'Coffee Shop', 'meeting_pref_1543398006.png'),
(4, 'Public Library', 'meeting_pref_1543396751.png'),
(5, 'Club House', 'meeting_pref_1543396766.png'),
(6, 'On a walk', 'meeting_pref_1543396955.png'),
(7, 'Video Call', 'meeting_pref_1543396752.png'),
(8, 'Morning walk', 'meeting_pref_1543396955.png'),
(9, 'On facebook', 'meeting_pref_1543396756.png');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `gender` varchar(1) NOT NULL COMMENT '0 - male, 1- female',
  `address` text NOT NULL,
  `lat` varchar(255) NOT NULL,
  `lang` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '(0-inactive,1-active)',
  `current_organization` varchar(255) NOT NULL,
  `jobtitle` varchar(255) NOT NULL,
  `device_type` varchar(10) NOT NULL,
  `device_token` varchar(255) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `enable_email_notification` int(1) NOT NULL DEFAULT '1' COMMENT '(0-no,1-yes)',
  `enable_monthly_newsletter` int(1) NOT NULL DEFAULT '1' COMMENT '0 - off, 1 - on',
  `enable_push_notification` int(1) NOT NULL DEFAULT '1' COMMENT '(0-no,1-yes)',
  `enable_sms_notification` int(1) NOT NULL DEFAULT '1' COMMENT '(0-no,1-yes)',
  `subscription_plan` varchar(100) NOT NULL,
  `emirates_id` varchar(255) NOT NULL,
  `phone_no` varchar(12) NOT NULL,
  `social_id` varchar(255) NOT NULL,
  `goal_description` text NOT NULL,
  `remember_token` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id`, `fullname`, `email`, `password`, `image`, `gender`, `address`, `lat`, `lang`, `status`, `current_organization`, `jobtitle`, `device_type`, `device_token`, `created_date`, `enable_email_notification`, `enable_monthly_newsletter`, `enable_push_notification`, `enable_sms_notification`, `subscription_plan`, `emirates_id`, `phone_no`, `social_id`, `goal_description`, `remember_token`) VALUES
(107, 'Helen D McCarthy', 'tamara1996@gmail.com', '96e79218965eb72c92a549dd5a330112', 'member_1544176383.jpg', '1', 'Dubai - United Arab Emirates', '25.2048493', '55.270782800000006', 1, '', '', 'Android', 'caxFf5U2iuc:APA91bGog3Fb3vKbCrtpxZcweuZUPF6H6ve-btqHwDWOkXv2HWCrta-tjif4qwZ-HFqv7BoBqusDE8aOziE9ORjUcwurOIH5-H-WQa9JmnRZjNGWem5OPEx7hv0Z_KnGe4rDw3eXBgIM', '2018-12-04 07:18:53', 1, 0, 1, 1, '', '', '', '', ' Be realistic when setting goals. This can help you avoid missing deadlines and getting behind, as well as giving you a more accurate overview of how much time you have to invest in other tasks throughout the week.', ''),
(109, 'Donald S Blackwell', 'kirstin2001@yahoo.com', '96e79218965eb72c92a549dd5a330112', 'member_1544176400.jpg', '1', 'Dubai - United Arab Emirates', '25.2048493', '55.270782800000006', 1, '', '', '', '', '2018-12-04 07:18:53', 1, 0, 1, 1, '', '', '', '', ' Be realistic when setting goals. This can help you avoid missing deadlines and getting behind, as well as giving you a more accurate overview of how much time you have to invest in other tasks throughout the week.', ''),
(110, 'Kandice R Manz', 'hobart1984@hotmail.com', '96e79218965eb72c92a549dd5a330112', 'member_1544176410.jpg', '1', 'Tempe, Arizona', '25.2048493', '55.270782800000006', 1, '', '', '', '', '2018-12-04 07:18:53', 1, 0, 1, 1, '', '', '', '', ' Be realistic when setting goals. This can help you avoid missing deadlines and getting behind, as well as giving you a more accurate overview of how much time you have to invest in other tasks throughout the week.', ''),
(113, 'Christopher L Palmer', 'abdullaghurair@gmail.combuj', '96e79218965eb72c92a549dd5a330112', 'member_1544176419.jpg', '1', 'Tempe, Arizona', '23.07262175384203', '72.5163442885196', 1, '', '', 'ios', '123513', '2018-12-04 07:18:53', 0, 0, 1, 1, '', '', '', '', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?,description text', ''),
(114, 'Lisa R Eggen', 'rahul@gmail.com', '5b1b68a9abf4d2cd155c81a9225fd158', 'member_1544176441.jpg', '1', 'Gujarat, India', '22.258652', '71.19238050000001', 1, '', '', '365241', '123456', '2018-12-04 08:31:26', 1, 0, 1, 1, '', '', '5555555555', '', ' Be realistic when setting goals. This can help you avoid missing deadlines and getting behind, as well as giving you a more accurate overview of how much time you have to invest in other tasks throughout the week.', ''),
(149, 'abdulla gair', 'olivia@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'member_1544176214.jpg', '0', '208 Siya Info sundram arcate, Sola, Ahmedabad, Gujarat 380060, India', '23.072755', '72.516314', 1, '', '', 'Android', 'czDzP0GAZKQ:APA91bFGpja5MmmdBp9ncHykv6RQe9tPCZacMZ18fTD-ZGZITHMjTceXlY6ZRWRieHXIDdTeo2w9gdz4shTa0kBJY-BATWBADERUdFp-9d5bmLsG--RQLeAweWS6eBlKBP-AMJ1eMywB', '2018-12-07 03:45:43', 0, 1, 1, 1, '', '', '9856321470', '', ' Be realistic when setting goals. This can help you avoid missing deadlines and getting behind, as well as giving you a more accurate overview of how much time you have to invest in other tasks throughout the week.', ''),
(150, 'Brian A Palma', 'yadira1977@yahoo.com', '96e79218965eb72c92a549dd5a330112', 'member_1544176465.jpg', '0', 'Dubai - United Arab Emirates', '25.2048493', '55.270782800000006', 1, '', '', '', '', '2018-12-04 07:18:53', 1, 0, 1, 1, '', '', '', '', ' Be realistic when setting goals. This can help you avoid missing deadlines and getting behind, as well as giving you a more accurate overview of how much time you have to invest in other tasks throughout the week.', ''),
(151, 'Tharwae Munir', 'gielle2000@yahoo.com', '96e79218965eb72c92a549dd5a330112', 'member_1544176553.jpg', '1', 'Clifton, New Jersey', '25.2048493', '55.270782800000006', 1, '', '', '', '', '2018-12-04 07:18:53', 1, 0, 1, 1, '', '', '', '', ' Be realistic when setting goals. This can help you avoid missing deadlines and getting behind, as well as giving you a more accurate overview of how much time you have to invest in other tasks throughout the week.', ''),
(152, 'Mahboob', 'Momin@hotmail.com', '96e79218965eb72c92a549dd5a330112', 'member_1544176605.jpg', '0', 'Tempe, Arizona', '25.2048493', '55.270782800000006', 1, '', '', '', '', '2018-12-04 07:18:53', 1, 0, 1, 1, '', '', '', '', ' Be realistic when setting goals. This can help you avoid missing deadlines and getting behind, as well as giving you a more accurate overview of how much time you have to invest in other tasks throughout the week.', ''),
(153, 'Tulaiha', 'Azimi@hotmail.com', '96e79218965eb72c92a549dd5a330112', 'member_1544176625.jpg', '1', 'Tempe, Arizona', '23.07270994573772', '72.51636558214189', 1, '', '', 'ios', '123513', '2018-12-04 07:18:53', 0, 0, 1, 1, '', '', '', '', ' Be realistic when setting goals. This can help you avoid missing deadlines and getting behind, as well as giving you a more accurate overview of how much time you have to invest in other tasks throughout the week.', ''),
(154, 'Abdul Khaliq', 'Wali@gmail.com', '5b1b68a9abf4d2cd155c81a9225fd158', 'member_1544176694.jpg', '0', 'Gujarat, India', '22.258652', '71.19238050000001', 1, '', '', '365241', '123456', '2018-12-04 08:31:26', 1, 0, 1, 1, '', '', '5555555555', '', ' Be realistic when setting goals. This can help you avoid missing deadlines and getting behind, as well as giving you a more accurate overview of how much time you have to invest in other tasks throughout the week.', ''),
(155, 'Ruby', 'ruby@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'member_1544176338.jpg', '1', '208 Siya Info sundram arcate, Sola, Ahmedabad, Gujarat 380060, India', '23.072757', '72.516322', 1, '', '', 'Android', 'czDzP0GAZKQ:APA91bFGpja5MmmdBp9ncHykv6RQe9tPCZacMZ18fTD-ZGZITHMjTceXlY6ZRWRieHXIDdTeo2w9gdz4shTa0kBJY-BATWBADERUdFp-9d5bmLsG--RQLeAweWS6eBlKBP-AMJ1eMywB', '2018-12-07 03:51:59', 1, 0, 1, 1, '', '', '9754613289', '', ' Be realistic when setting goals. This can help you avoid missing deadlines and getting behind, as well as giving you a more accurate overview of how much time you have to invest in other tasks throughout the week.', ''),
(156, 'Tuhfaa Mahmoud', 'abdullaghurair@gmail.comth', '96e79218965eb72c92a549dd5a330112', 'member_1544176554.jpg', '1', '208 Siya Info sundram arcate, Sola, Ahmedabad, Gujarat 380060, India', '23.0727727', '72.51636739999999', 1, '', '', 'ios', '123513', '2018-12-07 03:55:33', 0, 1, 1, 1, '', '', '9658471230', '', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?,description text,description text,description test text ', ''),
(157, 'Grace', 'grace@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'member_1544176777.jpg', '1', '208 Siya Info sundram arcate, Sola, Ahmedabad, Gujarat 380060, India', '23.125', '26.125', 1, '', '', 'Android', '123456', '2018-12-07 03:58:21', 1, 0, 1, 1, '', '', '9658437218', '', ' Be realistic when setting goals. This can help you avoid missing deadlines and getting behind, as well as giving you a more accurate overview of how much time you have to invest in other tasks throughout the week.', ''),
(158, 'Jessica', 'jessica@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'member_1544176959.jpg', '', '208 Siya Info sundram arcate, Sola, Ahmedabad, Gujarat 380060, India', '23.125', '26.125', 1, '', '', 'Android', '123456', '2018-12-07 04:01:24', 1, 0, 1, 1, '', '', '6589734213', '', ' Be realistic when setting goals. This can help you avoid missing deadlines and getting behind, as well as giving you a more accurate overview of how much time you have to invest in other tasks throughout the week.', ''),
(159, 'Rafael M Loveday', 'Rafael@admin.com', '96e79218965eb72c92a549dd5a330112', 'member_1544176893.jpg', '1', 'Jalan Indragiri No.gg.30, Sumberejo, Batu City, East Java, Indonesia', '-7.8493112', '112.51800600000001', 1, '', '', '', '', '2018-12-07 04:01:33', 1, 0, 1, 1, '', '', '', '', ' Be realistic when setting goals. This can help you avoid missing deadlines and getting behind, as well as giving you a more accurate overview of how much time you have to invest in other tasks throughout the week.', ''),
(160, 'Sang N Zimmerman', 'Zimmerman@dayrep.com', '96e79218965eb72c92a549dd5a330112', 'member_1544176985.jpg', '0', 'HJ32, Rajarhat Road, Jyangra, Rajarhat, Kolkata, West Bengal, India', '22.6136983', '88.43070890000001', 1, '', '', '', '', '2018-12-07 04:03:05', 1, 0, 1, 1, '', '', '', '', ' Be realistic when setting goals. This can help you avoid missing deadlines and getting behind, as well as giving you a more accurate overview of how much time you have to invest in other tasks throughout the week.', ''),
(161, 'Abdullah', 'Srour@dayrep.com', '96e79218965eb72c92a549dd5a330112', 'member_1544177082.jpg', '0', 'Yuma, AZ, USA', '32.6926512', '-114.62769159999999', 1, '', '', '', '', '2018-12-07 04:04:42', 1, 0, 1, 1, '', '', '', '', ' Be realistic when setting goals. This can help you avoid missing deadlines and getting behind, as well as giving you a more accurate overview of how much time you have to invest in other tasks throughout the week.', ''),
(162, 'Mia', 'mia@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'member_1544177160.jpg', '', '208 Siya Info sundram arcate, Sola, Ahmedabad, Gujarat 380060, India', '23.125', '26.125', 1, '', '', 'Android', '123456', '2018-12-07 04:05:28', 1, 0, 1, 1, '', '', '9658741233', '', ' Be realistic when setting goals. This can help you avoid missing deadlines and getting behind, as well as giving you a more accurate overview of how much time you have to invest in other tasks throughout the week.', ''),
(163, 'Naasifa Sani', 'aurelia_ste@hotmail.com', '96e79218965eb72c92a549dd5a330112', 'member_1544177203.jpg', '1', 'Gjusta, Sunset Avenue, Venice, CA, USA', '33.99527380000001', '-118.47453610000002', 1, '', '', '', '', '2018-12-07 04:06:43', 1, 0, 1, 1, '', '', '', '', ' Be realistic when setting goals. This can help you avoid missing deadlines and getting behind, as well as giving you a more accurate overview of how much time you have to invest in other tasks throughout the week.', ''),
(164, 'Isabella', 'isabella@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'member_1544177389.jpg', '', '208 Siya Info sundram arcate, Sola, Ahmedabad, Gujarat 380060, India', '23.072761', '72.516322', 1, '', '', 'Android', 'czDzP0GAZKQ:APA91bFGpja5MmmdBp9ncHykv6RQe9tPCZacMZ18fTD-ZGZITHMjTceXlY6ZRWRieHXIDdTeo2w9gdz4shTa0kBJY-BATWBADERUdFp-9d5bmLsG--RQLeAweWS6eBlKBP-AMJ1eMywB', '2018-12-07 04:09:28', 1, 0, 1, 1, '', '', '9658741230', '', 'Hello', ''),
(165, 'Katie Ava', 'katie@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'member_1544178245.jpg', '', '208 Siya Info sundram arcate, Sola, Ahmedabad, Gujarat 380060, India', '23.072757', '72.516314', 1, '', '', 'Android', 'czDzP0GAZKQ:APA91bFGpja5MmmdBp9ncHykv6RQe9tPCZacMZ18fTD-ZGZITHMjTceXlY6ZRWRieHXIDdTeo2w9gdz4shTa0kBJY-BATWBADERUdFp-9d5bmLsG--RQLeAweWS6eBlKBP-AMJ1eMywB', '2018-12-07 04:23:43', 1, 0, 1, 1, '', '', '9658074123', '', 'Hello', ''),
(166, 'Holly', 'holly@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'member_1544179211.jpg', '', '208 Siya Info sundram arcate, Sola, Ahmedabad, Gujarat 380060, India', '23.030147', '72.508494', 1, '', '', 'Android', 'duH9kOr2UHg:APA91bG8VNt7AKoJhu7b319vFAfVRoEMJL-sy1wnR7-VR19CWHLXunp5dJOrRrxWAGju9AjsKdkKByR_07dI1GePrgXrrGG0m3ROaCHihA2YN3REbaDIMXgl809AgW0B7c6qjFUl_foC', '2018-12-07 04:39:23', 1, 0, 1, 1, '', '', '9658321470', '', 'Hello', ''),
(167, 'Isla', 'isla@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'member_1544180494.jpeg', '', '208 Siya Info sundram arcate, Sola, Ahmedabad, Gujarat 380060, India', '23.072756', '72.516314', 1, '', '', 'Android', 'czDzP0GAZKQ:APA91bFGpja5MmmdBp9ncHykv6RQe9tPCZacMZ18fTD-ZGZITHMjTceXlY6ZRWRieHXIDdTeo2w9gdz4shTa0kBJY-BATWBADERUdFp-9d5bmLsG--RQLeAweWS6eBlKBP-AMJ1eMywB', '2018-12-07 05:00:38', 1, 0, 1, 1, '', '', '9658471230', '', 'Hello', ''),
(168, 'Leah', 'leah@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'member_1544181157.jpg', '', '208 Siya Info sundram arcate, Sola, Ahmedabad, Gujarat 380060, India', '23.072757', '72.516316', 1, '', '', 'Android', 'czDzP0GAZKQ:APA91bFGpja5MmmdBp9ncHykv6RQe9tPCZacMZ18fTD-ZGZITHMjTceXlY6ZRWRieHXIDdTeo2w9gdz4shTa0kBJY-BATWBADERUdFp-9d5bmLsG--RQLeAweWS6eBlKBP-AMJ1eMywB', '2018-12-07 05:10:54', 1, 0, 1, 1, '', '', '9658741230', '', 'Hello', ''),
(169, 'Matilda', 'matilda@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'member_1544181228.jpg', '', '208 Siya Info sundram arcate, Sola, Ahmedabad, Gujarat 380060, India', '23.072757', '72.51632', 1, '', '', 'Android', 'czDzP0GAZKQ:APA91bFGpja5MmmdBp9ncHykv6RQe9tPCZacMZ18fTD-ZGZITHMjTceXlY6ZRWRieHXIDdTeo2w9gdz4shTa0kBJY-BATWBADERUdFp-9d5bmLsG--RQLeAweWS6eBlKBP-AMJ1eMywB', '2018-12-07 05:13:25', 1, 0, 1, 1, '', '', '9658741230', '', 'Hello', ''),
(170, 'Caitlin', 'caitlin@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'member_1544181404.jpg', '', '208 Siya Info sundram arcate, Sola, Ahmedabad, Gujarat 380060, India', '23.072756', '72.516317', 1, '', '', 'Android', 'czDzP0GAZKQ:APA91bFGpja5MmmdBp9ncHykv6RQe9tPCZacMZ18fTD-ZGZITHMjTceXlY6ZRWRieHXIDdTeo2w9gdz4shTa0kBJY-BATWBADERUdFp-9d5bmLsG--RQLeAweWS6eBlKBP-AMJ1eMywB', '2018-12-07 05:16:18', 1, 0, 1, 1, '', '', '1234567890', '', 'Hello', ''),
(171, 'Keira', 'keira@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'member_1544181748.jpg', '', '208 Siya Info sundram arcate, Sola, Ahmedabad, Gujarat 380060, India', '23.072756', '72.516314', 1, '', '', 'Android', 'czDzP0GAZKQ:APA91bFGpja5MmmdBp9ncHykv6RQe9tPCZacMZ18fTD-ZGZITHMjTceXlY6ZRWRieHXIDdTeo2w9gdz4shTa0kBJY-BATWBADERUdFp-9d5bmLsG--RQLeAweWS6eBlKBP-AMJ1eMywB', '2018-12-07 05:21:31', 1, 0, 1, 1, '', '', '9658231470', '', 'Hello', ''),
(172, 'Alice', 'alice@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'member_1544181933.jpg', '', '208 Siya Info sundram arcate, Sola, Ahmedabad, Gujarat 380060, India', '23.072756', '72.516314', 1, '', '', 'Android', 'czDzP0GAZKQ:APA91bFGpja5MmmdBp9ncHykv6RQe9tPCZacMZ18fTD-ZGZITHMjTceXlY6ZRWRieHXIDdTeo2w9gdz4shTa0kBJY-BATWBADERUdFp-9d5bmLsG--RQLeAweWS6eBlKBP-AMJ1eMywB', '2018-12-07 05:24:56', 1, 0, 1, 1, '', '', '9856432710', '', 'Hello', ''),
(173, 'Isabel', 'isabel@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'member_1544182109.jpg', '', '208 Siya Info sundram arcate, Sola, Ahmedabad, Gujarat 380060, India', '23.072756', '72.516314', 1, '', '', 'Android', 'czDzP0GAZKQ:APA91bFGpja5MmmdBp9ncHykv6RQe9tPCZacMZ18fTD-ZGZITHMjTceXlY6ZRWRieHXIDdTeo2w9gdz4shTa0kBJY-BATWBADERUdFp-9d5bmLsG--RQLeAweWS6eBlKBP-AMJ1eMywB', '2018-12-07 05:28:07', 1, 0, 1, 1, '', '', '9658741230', '', 'Hello', ''),
(174, 'Lauren', 'lauren@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'member_1544182325.jpg', '', '208 Siya Info sundram arcate, Sola, Ahmedabad, Gujarat 380060, India', '23.072756', '72.516314', 1, '', '', 'Android', 'czDzP0GAZKQ:APA91bFGpja5MmmdBp9ncHykv6RQe9tPCZacMZ18fTD-ZGZITHMjTceXlY6ZRWRieHXIDdTeo2w9gdz4shTa0kBJY-BATWBADERUdFp-9d5bmLsG--RQLeAweWS6eBlKBP-AMJ1eMywB', '2018-12-07 05:31:30', 1, 0, 1, 1, '', '', '9658741230', '', 'Hello', ''),
(175, 'Gracie', 'gracie@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'member_1544182519.jpeg', '', '208 Siya Info sundram arcate, Sola, Ahmedabad, Gujarat 380060, India', '23.072755', '72.516314', 1, '', '', 'Android', 'czDzP0GAZKQ:APA91bFGpja5MmmdBp9ncHykv6RQe9tPCZacMZ18fTD-ZGZITHMjTceXlY6ZRWRieHXIDdTeo2w9gdz4shTa0kBJY-BATWBADERUdFp-9d5bmLsG--RQLeAweWS6eBlKBP-AMJ1eMywB', '2018-12-07 05:34:57', 1, 0, 1, 1, '', '', '9856471230', '', 'Hello', ''),
(176, 'Eleanor', 'eleanor@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'member_1544182695.jpg', '', '208 Siya Info sundram arcate, Sola, Ahmedabad, Gujarat 380060, India', '23.072757', '72.516314', 1, '', '', 'Android', 'czDzP0GAZKQ:APA91bFGpja5MmmdBp9ncHykv6RQe9tPCZacMZ18fTD-ZGZITHMjTceXlY6ZRWRieHXIDdTeo2w9gdz4shTa0kBJY-BATWBADERUdFp-9d5bmLsG--RQLeAweWS6eBlKBP-AMJ1eMywB', '2018-12-07 05:37:29', 1, 0, 1, 1, '', '', '9658741230', '', 'Hello', ''),
(177, 'Sienn Anna', 'sienna@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'member_1544182865.jpg', '0', '208 Siya Info sundram arcate, Sola, Ahmedabad, Gujarat 380060, India', '23.072756', '72.516314', 1, '', '', 'Android', 'czDzP0GAZKQ:APA91bFGpja5MmmdBp9ncHykv6RQe9tPCZacMZ18fTD-ZGZITHMjTceXlY6ZRWRieHXIDdTeo2w9gdz4shTa0kBJY-BATWBADERUdFp-9d5bmLsG--RQLeAweWS6eBlKBP-AMJ1eMywB', '2018-12-07 05:40:35', 1, 0, 1, 1, '', '', '9658471230', '', 'Hello', ''),
(178, 'Maria Fredrick', 'maria@gmail.com', 'cc03e747a6afbbcbf8be7668acfebee5', 'member_1544246865.jpg', '1', '12 Luv-kush park Society, near labh subh society, Krushna Nagar Society, Sanand, Gujarat 382110, India', '21.92', '82.779998', 1, '', '', 'Android', 'd_MV83IvELg:APA91bFLMhDEQBUNQRuYW_AR9iTJJBPsYqCnCUqbo6WfZQBG2oGgXddXPPaqCF8fnoTowglLPHb_nu1LPZ-aFW1YnX__6SgazVZeCjWN82ULsev3BvDyP-vHDiTvhKj_ofoz7kQt-ssF', '2018-12-07 07:28:41', 1, 0, 1, 1, '', '', '9895963210', '', 'Hello', ''),
(179, 'Sara Ghurair', 'diana@gmail.com', 'cc03e747a6afbbcbf8be7668acfebee5', 'member_1544248741.jpeg', '1', 'Fattehpura, Gujarat 382165, India', '21.92', '82.779998', 1, '', '', 'Android', 'd_MV83IvELg:APA91bFLMhDEQBUNQRuYW_AR9iTJJBPsYqCnCUqbo6WfZQBG2oGgXddXPPaqCF8fnoTowglLPHb_nu1LPZ-aFW1YnX__6SgazVZeCjWN82ULsev3BvDyP-vHDiTvhKj_ofoz7kQt-ssF', '2018-12-07 09:13:04', 1, 0, 1, 1, '', '', '9596912333', '', '', ''),
(180, 'Joan', 'john@mailinator.com', '96e79218965eb72c92a549dd5a330112', '', '', '', '26.0225', '72.5713', 1, '', '', 'IOS', '987456321', '2018-12-07 23:22:41', 1, 0, 1, 1, '', '', '8856545879', '', '', ''),
(181, 'kid k', 'johnp@mailinator.com', '96e79218965eb72c92a549dd5a330112', '', '', 'Nimbakhera, Rajasthan 344026, India', '26.0225', '72.5713', 1, '', '', 'IOS', '987456321', '2018-12-07 23:27:51', 1, 0, 1, 1, '', '', '8856545879', '', '', ''),
(182, 'Namr Namr', 'namr@gmail.com', '25d55ad283aa400af464c76d713c07ad', '', '0', '208 Siya Info sundram arcate, Sola, Ahmedabad, Gujarat 380060, India', '23.072765', '72.516322', 1, '', '', 'Android', 'czDzP0GAZKQ:APA91bFGpja5MmmdBp9ncHykv6RQe9tPCZacMZ18fTD-ZGZITHMjTceXlY6ZRWRieHXIDdTeo2w9gdz4shTa0kBJY-BATWBADERUdFp-9d5bmLsG--RQLeAweWS6eBlKBP-AMJ1eMywB', '2018-12-08 02:17:05', 1, 1, 1, 1, '', '', '9658471230', '', '', ''),
(183, 'Jay', 'jay@gmail.com', '25d55ad283aa400af464c76d713c07ad', '', '', '208 Siya Info sundram arcate, Sola, Ahmedabad, Gujarat 380060, India', '23.072757', '72.516315', 1, '', '', 'Android', 'czDzP0GAZKQ:APA91bFGpja5MmmdBp9ncHykv6RQe9tPCZacMZ18fTD-ZGZITHMjTceXlY6ZRWRieHXIDdTeo2w9gdz4shTa0kBJY-BATWBADERUdFp-9d5bmLsG--RQLeAweWS6eBlKBP-AMJ1eMywB', '2018-12-10 01:04:03', 1, 1, 1, 1, '', '', '8596734210', '', 'Hello', ''),
(184, 'Dhrumiiii', 'dhrumi88@gmal.kk', '96e79218965eb72c92a549dd5a330112', '', '1', 'Gujarat, India', '22.258652', '71.19238050000001', 1, '', '', '', '', '2018-12-10 07:38:47', 1, 1, 1, 1, '', '', '', '', 'hhhhh', '');

-- --------------------------------------------------------

--
-- Table structure for table `member_extrainfo`
--

CREATE TABLE `member_extrainfo` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `social_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'linked_in_id',
  `social_type` int(2) NOT NULL COMMENT '1 = linked_in',
  `linkedin_link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `twitter_link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `instagram_link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `website_link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `about_goal` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `member_extrainfo`
--

INSERT INTO `member_extrainfo` (`id`, `member_id`, `social_id`, `social_type`, `linkedin_link`, `twitter_link`, `instagram_link`, `website_link`, `about_goal`) VALUES
(100, 107, '', 0, '', 'https://www.twitter.com', 'https://www.instagram.com', '', 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system'),
(102, 109, '', 0, 'https://www.linkedin.com', 'https://www.twitter.com', 'https://www.instagram.com', '', 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system'),
(103, 110, '', 0, 'https://www.linkedin.com', 'https://www.twitter.com', 'https://www.instagram.com', '', 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system'),
(105, 113, '', 0, 'https://www.linkedin.com', 'https://www.twitter.com', 'https://www.instagram.com', '', 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system'),
(106, 114, '', 0, 'https://www.linkedin.com', 'https://www.twitter.com', 'https://www.instagram.com', '', 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system'),
(141, 149, '', 0, 'https://www.linkedin.com', 'https://www.twitter.com', 'https://www.instagram.com', 'http://www.google.com', 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system'),
(142, 155, '', 0, 'https://www.linkedin.com', 'https://www.twitter.com', 'https://www.instagram.com', '', 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system'),
(143, 156, '', 0, 'https://www.linkedin.com', 'https://www.twitter.com', 'https://www.instagram.com', '', 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system'),
(144, 157, '', 0, 'https://www.linkedin.com', 'https://www.twitter.com', 'https://www.instagram.com', '', 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system'),
(145, 158, '', 0, 'https://www.linkedin.com', 'https://www.twitter.com', 'https://www.instagram.com', '', 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system'),
(146, 159, '', 0, 'https://www.linkedin.com', 'https://www.twitter.com', 'https://www.instagram.com', '', 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system'),
(147, 160, '', 0, 'https://www.linkedin.com', 'https://www.twitter.com', 'https://www.instagram.com', '', 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system'),
(148, 161, '', 0, 'https://www.linkedin.com', 'https://www.twitter.com', 'https://www.instagram.com', '', 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system'),
(149, 162, '', 0, 'https://www.linkedin.com', 'https://www.twitter.com', 'https://www.instagram.com', '', 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system'),
(150, 163, '', 0, 'https://www.linkedin.com', 'https://www.twitter.com', 'https://www.instagram.com', '', 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system'),
(151, 164, '', 0, 'https://www.linkedin.com', 'https://www.twitter.com', 'https://www.instagram.com', '', 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system'),
(152, 153, '', 0, 'https://www.linkedin.com', 'https://www.twitter.com', 'https://www.instagram.com', '', 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system'),
(153, 152, '', 0, 'https://www.linkedin.com', 'https://www.twitter.com', 'https://www.instagram.com', '', 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system'),
(154, 151, '', 0, 'https://www.linkedin.com', 'https://www.twitter.com', 'https://www.instagram.com', '', 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system'),
(155, 150, '', 0, 'https://www.linkedin.com', 'https://www.twitter.com', 'https://www.instagram.com', '', 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system'),
(156, 165, '', 0, 'https://www.linkedin.com', '', 'https://www.instagram.com', '', ''),
(157, 154, '', 0, 'https://www.linkedin.com', '', 'https://www.instagram.com', '', ''),
(158, 166, '', 0, 'http://www.linkedin.com', '', '', 'https://www.google.com', ''),
(159, 167, '', 0, 'http://www.linkedin.com', '', '', '', ''),
(160, 168, '', 0, 'http://www.linkedin.com', '', '', '', ''),
(161, 169, '', 0, 'http://www.linkedin.com', '', '', '', ''),
(162, 170, '', 0, 'http://www.linkedin.com', '', '', '', ''),
(163, 171, '', 0, 'http://www.google.com', '', '', '', ''),
(164, 172, '', 0, 'http://www.linkedin.com', '', '', '', ''),
(165, 173, '', 0, 'http://www.linkedin.com', '', '', '', ''),
(166, 174, '', 0, 'http://www.linkedin.com', '', '', '', ''),
(167, 175, '', 0, 'http://www.linkedin.com', '', '', '', ''),
(168, 176, '', 0, 'http://www.linkedin.com', '', '', '', ''),
(169, 177, '', 0, 'http://www.linkedin.com', '', '', '', ''),
(170, 178, '', 0, '', '', '', '', ''),
(171, 179, '', 0, '', '', '', '', ''),
(172, 180, '', 0, '', '', '', '', ''),
(173, 181, '', 0, '', '', '', '', ''),
(174, 182, '', 0, 'http://www.google.com', '', '', '', ''),
(175, 183, '', 0, '', '', '', '', ''),
(176, 184, '', 0, '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `member_goal`
--

CREATE TABLE `member_goal` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `lookingfor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `member_goal`
--

INSERT INTO `member_goal` (`id`, `member_id`, `lookingfor_id`) VALUES
(165, 107, 8),
(166, 109, 2),
(167, 109, 7),
(168, 110, 4),
(169, 110, 5),
(172, 114, 3),
(173, 149, 4),
(174, 149, 5),
(175, 149, 7),
(179, 151, 3),
(180, 152, 3),
(181, 153, 3),
(182, 150, 4),
(183, 154, 11),
(184, 154, 12),
(185, 154, 13),
(192, 155, 5),
(193, 155, 7),
(194, 155, 9),
(198, 157, 3),
(199, 157, 5),
(200, 157, 7),
(201, 159, 11),
(202, 158, 12),
(203, 158, 13),
(204, 158, 10),
(205, 160, 12),
(207, 161, 3),
(208, 162, 5),
(209, 162, 4),
(210, 162, 8),
(219, 163, 5),
(220, 163, 12),
(221, 164, 4),
(222, 164, 11),
(223, 164, 7),
(224, 165, 6),
(225, 165, 7),
(226, 165, 3),
(227, 166, 5),
(228, 166, 4),
(229, 166, 6),
(232, 167, 5),
(233, 167, 4),
(234, 167, 6),
(235, 168, 4),
(236, 168, 9),
(237, 168, 8),
(238, 169, 12),
(239, 169, 10),
(240, 169, 8),
(241, 170, 7),
(242, 170, 5),
(243, 170, 9),
(244, 171, 5),
(245, 171, 3),
(246, 171, 2),
(247, 172, 4),
(248, 172, 3),
(249, 172, 7),
(250, 173, 2),
(251, 173, 6),
(252, 173, 8),
(253, 174, 5),
(254, 174, 8),
(255, 174, 9),
(256, 175, 5),
(257, 175, 4),
(258, 175, 6),
(259, 176, 9),
(260, 176, 8),
(261, 176, 7),
(262, 177, 4),
(263, 177, 6),
(264, 177, 7),
(275, 178, 3),
(276, 178, 4),
(277, 178, 6),
(278, 178, 8),
(279, 178, 10),
(284, 113, 2),
(285, 113, 3),
(286, 183, 7),
(287, 183, 5),
(298, 156, 2),
(299, 156, 3),
(300, 156, 5),
(301, 156, 4);

-- --------------------------------------------------------

--
-- Table structure for table `member_industry`
--

CREATE TABLE `member_industry` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `industry_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `member_industry`
--

INSERT INTO `member_industry` (`id`, `member_id`, `industry_id`) VALUES
(231, 107, 2),
(232, 109, 17),
(233, 109, 18),
(234, 110, 17),
(235, 110, 18),
(238, 114, 1),
(241, 151, 3),
(242, 152, 3),
(243, 153, 2),
(244, 150, 17),
(245, 154, 18),
(248, 155, 2),
(249, 155, 17),
(251, 157, 3),
(252, 157, 18),
(253, 159, 2),
(254, 160, 18),
(255, 158, 3),
(257, 161, 2),
(258, 162, 3),
(262, 156, 4),
(263, 163, 2),
(264, 163, 4),
(265, 164, 3),
(266, 165, 2),
(271, 167, 2),
(272, 168, 3),
(273, 169, 3),
(274, 170, 3),
(275, 166, 3),
(276, 171, 3),
(277, 172, 3),
(278, 173, 3),
(279, 174, 2),
(280, 175, 3),
(281, 176, 3),
(282, 177, 4),
(293, 178, 18),
(304, 113, 4),
(305, 113, 3),
(306, 179, 17),
(309, 149, 17);

-- --------------------------------------------------------

--
-- Table structure for table `member_interests`
--

CREATE TABLE `member_interests` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `hashtag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='member hashtag';

--
-- Dumping data for table `member_interests`
--

INSERT INTO `member_interests` (`id`, `member_id`, `hashtag_id`) VALUES
(561, 107, 10),
(562, 109, 3),
(563, 110, 2),
(568, 114, 4),
(575, 151, 3),
(576, 152, 2),
(577, 153, 4),
(578, 150, 3),
(579, 154, 10),
(586, 155, 2),
(587, 155, 4),
(588, 155, 7),
(592, 157, 4),
(593, 157, 6),
(594, 157, 9),
(595, 158, 8),
(596, 158, 7),
(597, 158, 5),
(598, 159, 3),
(599, 160, 6),
(601, 161, 4),
(610, 156, 8),
(611, 156, 10),
(612, 156, 11),
(613, 163, 6),
(614, 163, 9),
(615, 162, 11),
(616, 162, 2),
(617, 162, 7),
(618, 162, 8),
(619, 162, 4),
(620, 164, 2),
(621, 164, 4),
(622, 164, 5),
(623, 165, 11),
(624, 165, 6),
(625, 165, 7),
(626, 165, 8),
(630, 149, 2),
(631, 149, 4),
(632, 149, 6),
(633, 167, 6),
(634, 167, 9),
(635, 167, 5),
(636, 168, 8),
(637, 168, 6),
(638, 168, 5),
(639, 169, 6),
(640, 169, 7),
(641, 169, 9),
(642, 170, 8),
(643, 170, 6),
(644, 170, 7),
(645, 171, 7),
(646, 171, 6),
(647, 171, 8),
(648, 171, 3),
(649, 172, 6),
(650, 172, 7),
(651, 172, 8),
(652, 173, 5),
(653, 173, 6),
(654, 173, 7),
(657, 174, 6),
(658, 174, 9),
(659, 174, 7),
(660, 175, 6),
(661, 175, 7),
(662, 175, 8),
(663, 176, 3),
(664, 176, 6),
(665, 176, 8),
(666, 177, 8),
(667, 177, 6),
(668, 177, 10),
(669, 177, 9),
(674, 166, 6),
(675, 166, 9),
(676, 166, 11),
(677, 166, 4),
(678, 166, 2),
(684, 179, 2),
(685, 179, 5),
(694, 178, 2),
(695, 178, 5),
(698, 113, 4),
(699, 113, 7),
(700, 113, 8),
(701, 182, 8),
(702, 182, 6),
(703, 182, 7),
(704, 183, 6),
(705, 183, 9);

-- --------------------------------------------------------

--
-- Table structure for table `member_meeting_preferences`
--

CREATE TABLE `member_meeting_preferences` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `meeting_preference_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `member_meeting_preferences`
--

INSERT INTO `member_meeting_preferences` (`id`, `member_id`, `meeting_preference_id`) VALUES
(329, 107, 7),
(330, 107, 9),
(331, 109, 4),
(332, 110, 7),
(333, 114, 3),
(342, 151, 3),
(343, 152, 2),
(344, 150, 2),
(352, 155, 1),
(353, 155, 2),
(354, 155, 4),
(355, 155, 5),
(360, 157, 2),
(361, 157, 7),
(362, 157, 8),
(363, 159, 3),
(364, 159, 7),
(365, 158, 6),
(366, 158, 9),
(367, 160, 2),
(369, 161, 2),
(370, 162, 4),
(371, 162, 9),
(380, 156, 1),
(381, 156, 4),
(382, 156, 6),
(383, 156, 8),
(384, 163, 2),
(385, 163, 7),
(386, 163, 8),
(387, 163, 9),
(388, 164, 2),
(389, 164, 5),
(390, 164, 8),
(391, 165, 2),
(392, 165, 4),
(393, 165, 6),
(411, 168, 1),
(412, 168, 2),
(413, 168, 6),
(414, 168, 7),
(415, 169, 2),
(416, 169, 4),
(417, 169, 5),
(418, 170, 2),
(419, 170, 3),
(420, 170, 6),
(421, 170, 7),
(422, 166, 1),
(423, 166, 4),
(424, 166, 7),
(425, 166, 8),
(426, 171, 2),
(427, 171, 8),
(428, 172, 2),
(429, 172, 4),
(430, 172, 6),
(431, 172, 8),
(432, 173, 1),
(433, 173, 2),
(434, 173, 3),
(435, 173, 7),
(436, 174, 1),
(437, 174, 4),
(438, 174, 5),
(439, 175, 1),
(440, 175, 4),
(441, 175, 5),
(442, 176, 1),
(443, 176, 2),
(444, 176, 4),
(445, 177, 2),
(446, 177, 3),
(465, 167, 2),
(466, 167, 7),
(467, 167, 8),
(468, 113, 1),
(469, 113, 2),
(470, 113, 3),
(471, 113, 4),
(472, 113, 5),
(473, 113, 6),
(474, 113, 7),
(475, 113, 8),
(476, 113, 9),
(477, 178, 1),
(478, 178, 2),
(479, 178, 3),
(480, 178, 4),
(481, 149, 2),
(485, 182, 3),
(486, 182, 4),
(487, 182, 5),
(488, 182, 6);

-- --------------------------------------------------------

--
-- Table structure for table `newsfeed`
--

CREATE TABLE `newsfeed` (
  `id` int(11) NOT NULL,
  `hashtag_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `link` varchar(255) NOT NULL,
  `fetch_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `image_link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `newsfeed`
--

INSERT INTO `newsfeed` (`id`, `hashtag_id`, `title`, `description`, `link`, `fetch_date`, `image_link`) VALUES
(1, 2, ' What does Martian wind sound like? Now we know', 'It\'s the first time humans can hear the wind on the Red Planet.', 'https://abcnews.go.com/Technology/martian-wind-sound-now/story?id=59682477', '2018-12-08 18:00:36', 'https://s.abcnews.com/images/Business/mars-insight-nasa-gty-jc-181127_hpMain_16x9_992.jpg'),
(2, 2, ' So you stayed at a Starwood hotel: Tips on data breach', 'If you stayed at one of Marriott\'s Starwood hotels in recent years, hackers might have information on your address, credit card and even your passport', 'https://abcnews.go.com/Technology/wireStory/stayed-starwood-hotel-tips-data-breach-59526048', '2018-11-30 23:50:47', 'https://s.abcnews.com/images/Technology/WireAP_fb54de842e7d48dcade213eba37aa62f_16x9_992.jpg'),
(3, 2, ' Scientists have discovered a hidden talent of geckos ', 'Geckos use a combination of techniques to race across water.', 'https://abcnews.go.com/Technology/scientists-discovered-hidden-talent-geckos/story?id=59662761', '2018-12-07 13:30:30', 'https://s.abcnews.com/images/Technology/gecko-01-ht-jc-181206_hpMain_16x9_992.jpg'),
(4, 2, ' Africa\'s solid waste is growing, posing a climate threat', 'Africa\'s solid waste is growing as population booms, posing a climate threat', 'https://abcnews.go.com/Technology/wireStory/africas-solid-waste-growing-posing-climate-threat-59695255', '2018-12-08 17:52:18', 'https://s.abcnews.com/images/Technology/WireAP_6ddfe8fe846944d49d46dc21bfc7f51b_16x9_992.jpg'),
(5, 2, ' Could anyone have stopped gene-edited babies experiment?', 'Scientific consensus and regulations in much of the world prohibit making genetic changes that could be passed to future generations. But nothing stopped the Chinese researcher from helping to make the world\'s first gene-edited babies.', 'https://abcnews.go.com/Technology/wireStory/stopped-gene-edited-babies-work-59557579', '2018-12-03 01:13:52', 'https://s.abcnews.com/images/Technology/WireAP_d416ea2bf5d745b28e78a2edcda8c982_16x9_992.jpg'),
(6, 2, ' Nation\'s largest police department puts its eyes in the skies with new drone program ', 'The adoption of drones by the NYPD could effect departments across the nation.', 'https://abcnews.go.com/Technology/nypd-nations-largest-police-department-puts-eyes-skies/story?id=59599207', '2018-12-05 16:07:23', 'https://s.abcnews.com/images/Technology/nypd-drones-rd-jc-181204_hpMain_16x9_992.jpg'),
(7, 2, ' How AI is changing the music industry ', 'Algorithms for mixing and mastering audio are having a growing impact.', 'https://abcnews.go.com/Technology/ai-changing-music-industry/story?id=59580886', '2018-12-03 19:44:51', 'https://s.abcnews.com/images/Technology/music-gty-jpo-181203_hpMain_16x9_992.jpg'),
(8, 2, ' SpaceX Christmas delivery arrives at space station', 'A SpaceX delivery full of Christmas goodies has arrived at the International Space Station', 'https://abcnews.go.com/Technology/wireStory/spacex-christmas-delivery-delayed-communication-problem-59696233', '2018-12-08 16:08:46', 'https://s.abcnews.com/images/Technology/WireAP_d578cd1ab2924b3689c0c23c90c0e64a_16x9_992.jpg'),
(9, 2, ' Climate talks pause as battle over key science report looms', 'A diplomatic standoff over a single word could set the stage for a bigger showdown during the second half of this year\'s U.N. climate summit', 'https://abcnews.go.com/Technology/wireStory/climate-talks-pause-battle-key-science-report-looms-59711181', '2018-12-09 16:44:42', 'https://s.abcnews.com/images/Technology/WireAP_02932d711da143c2944826382e88c1c6_16x9_992.jpg'),
(10, 2, ' A new way to measure vibrations may eventually help detect gravitational waves ', 'Phonons bring good vibrations to quantum physicists.', 'https://abcnews.go.com/Technology/measure-vibrations-eventually-detect-gravitational-waves/story?id=59653797', '2018-12-06 18:07:30', 'https://s.abcnews.com/images/Technology/sound-waves-ht-jpo-181206_hpMain_16x9_992.jpg'),
(11, 2, ' Big shareholder at Yelp wants a board reshuffle', 'Large shareholder at Yelp, citing missteps, wants seeks a board reshuffling', 'https://abcnews.go.com/Technology/wireStory/big-shareholder-yelp-board-reshuffle-59723661', '2018-12-10 14:42:03', 'https://s.abcnews.com/images/Technology/WireAP_5bdaa2ddb8b546e38de2db9b3026c8fb_16x9_992.jpg'),
(12, 2, 'WATCH:  Retailers set online sale prices for \'Green Monday\'', 'Shoppers prepare for one of the final online shopping sale days left in December.', 'https://abcnews.go.com/Technology/video/retailers-set-online-sale-prices-green-monday-59722439', '2018-12-10 12:48:38', 'https://s.abcnews.com/images/Technology/181210_atm_techbytes_hpMain_16x9_992.jpg'),
(13, 2, 'WATCH:  Martian wind heard for the 1st time', 'A highly-sensitive seismometer, meant to study marsquakes, picked up the sound of wind on Mars.', 'https://abcnews.go.com/Technology/video/martian-wind-heard-1st-time-59684684', '2018-12-07 19:45:54', 'https://s.abcnews.com/images/Technology/181207_vod_orig_marssounds_hpMain_16x9_992.jpg'),
(14, 2, 'WATCH:  Is your Android phone tracking you?  ', 'ABC News\' Rebecca Jarvis looks into how much information your cell phone is really collecting about you.', 'https://abcnews.go.com/GMA/News/video/android-phone-tracking-59676023', '2018-12-07 14:05:42', 'https://s.abcnews.com/images/GMA/181207_gma_jarvis_hpMain_16x9_992.jpg'),
(15, 2, 'WATCH:  Apple Watch adds irregular heart-rate feature', 'The latest Apple Watch software will monitor users for an irregular heart rhythm.', 'https://abcnews.go.com/Technology/video/apple-watch-adds-irregular-heart-rate-feature-59674319', '2018-12-07 13:29:54', 'https://s.abcnews.com/images/Technology/181207_atm_techbytes_hpMain_16x9_992.jpg'),
(16, 2, 'WATCH:  Uber tries again to put self-driving cars on the road', 'The ride sharing company has resumed testing of self-driving vehicles despite a fatal accident earlier this year.', 'https://abcnews.go.com/Technology/video/uber-put-driving-cars-road-59646802', '2018-12-06 12:43:42', 'https://s.abcnews.com/images/Technology/181206_atm_techbytes2_hpMain_16x9_992.jpg'),
(17, 2, 'WATCH:  Cuba lifts ban on cellphone internet access', 'Cuban citizens are now able to access the internet on their phones for the first time.', 'https://abcnews.go.com/Technology/video/cuba-lifts-ban-cellphone-internet-access-59619456', '2018-12-05 12:28:56', 'https://s.abcnews.com/images/Technology/181205_atm_techbytes_hpMain_16x9_992.jpg'),
(18, 2, 'WATCH:  Whale songs have changed over the last few decades', 'Songs have lowered in frequency, in part because of changes to ocean water.', 'https://abcnews.go.com/Technology/video/whale-songs-changed-decades-59611811', '2018-12-05 00:45:04', 'https://s.abcnews.com/images/Technology/181204_ugc_whale_songs_hpMain_16x9_992.jpg'),
(19, 2, 'WATCH:  Apple\'s most popular apps of 2018', 'Despite privacy issues, social media apps top the list.', 'https://abcnews.go.com/Technology/video/apples-popular-apps-2018-59593945', '2018-12-04 13:02:37', 'https://s.abcnews.com/images/Technology/181204_atm_techbytes_hpMain_16x9_992.jpg'),
(20, 2, 'WATCH:  First manned Soyuz rocket since October accident takes off', 'American astronaut Anne McClain joined Canada\'s David Saint-Jacques and Russia\'s Oleg Kononenko aboard the rocket that launched from the Baikonur spaceport in the desert in central Kazakhstan.', 'https://abcnews.go.com/Technology/video/manned-soyuz-rocket-october-accident-takes-off-59587607', '2018-12-04 00:57:37', 'https://s.abcnews.com/images/Technology/181203_vod_orig_russialauncheditMIX_hpMain_16x9_992.jpg'),
(21, 2, 'WATCH:  NASA\'s OSIRIS-REx spacecraft arrives at asteroid Bennu after long journey', 'The rocket will bring samples of the asteroid back to Earth if all goes well.', 'https://abcnews.go.com/Technology/video/nasas-osiris-rex-spacecraft-arrives-asteroid-bennu-long-59579568', '2018-12-03 18:34:37', 'https://s.abcnews.com/images/Technology/181203_abcnl_nasa_hpMain_16x9_992.jpg'),
(22, 2, 'WATCH:  Bigger stores without cashiers may be on the way', 'Amazon may try cashierless stores in larger spaces, the Wall Street Journal reported.', 'https://abcnews.go.com/Technology/video/bigger-stores-cashiers-59572605', '2018-12-03 13:32:55', 'https://s.abcnews.com/images/Technology/181203_atm_techbytes_hpMain_16x9_992.jpg'),
(23, 2, 'WATCH:  NASA is looking for contractors for the next moon mission', 'Plus, YouTube adds stories and the U.S. military is testing exoskeletons for its soldiers.', 'https://abcnews.go.com/Technology/video/nasa-contractors-moon-mission-59519172', '2018-11-30 15:29:22', 'https://s.abcnews.com/images/Technology/181130_atm_techbytes_hpMain_16x9_992.jpg'),
(24, 2, ' Big shareholder at Yelp wants a board reshuffle', 'Large shareholder at Yelp, citing missteps, wants seeks a board reshuffling', 'https://abcnews.go.com/Technology/wireStory/big-shareholder-yelp-board-reshuffle-59723661', '2018-12-10 14:42:03', 'https://s.abcnews.com/images/Technology/WireAP_5bdaa2ddb8b546e38de2db9b3026c8fb_16x9_992.jpg'),
(25, 2, ' How computers may eventually beat humans at their own games ', 'AIs have defeated humans at even more computationally difficult games.', 'https://abcnews.go.com/Technology/computer-program-taught-play-chess-shogi/story?id=59680544', '2018-12-10 14:41:05', 'https://s.abcnews.com/images/Technology/deepmind-alphazero-ht-jc-181207_hpMain_16x9_992.jpg'),
(26, 3, ' Lakers trying to add Suns\' Trevor Ariza in three-way trade', 'The         Los Angeles Lakers are engaged in talks to try to acquire         Phoenix Suns forward         Trevor Ariza, league sources told ESPN.     The teams have been working to reach an agreement with a third team that would take on Lakers guard         Kentavious Caldwell-Pope as part of a potentially larger deal, league sources said.     The Suns want to land a playmaking guard and a draft asset as the price of unloading Ariza, sources said. Phoenix and Los Angeles have made progress in third-team scenarios, although no agreements are close and both teams remain active in multiple trade discussions throughout the league, sources said.     No trade can be completed officially until Saturday, when players who, like Ariza, were signed in summer free agency become eligible to be traded.     Ariza is one of the most important trade assets for the Suns -- losers of 22 of 26 games -- and their best chance to bolster their backcourt and gain assets. Most contending teams are...', 'https://abcnews.go.com/Sports/lakers-add-suns-trevor-ariza-trade/story?id=59717784', '2018-12-10 02:06:38', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(27, 3, ' Warriors named Sports Illustrated\'s Sportsperson of Year', 'The three-time NBA champion Golden State Warriors are the fourth team that has been honored as Sports Illustrated\'s Sportsperson of the Year', 'https://abcnews.go.com/Sports/wireStory/warriors-named-sports-illustrateds-sportsperson-year-59722438', '2018-12-10 12:04:51', 'https://s.abcnews.com/images/Sports/WireAP_2b45ba9a67284e33b0bde167d89bbf6c_16x9_992.jpg'),
(28, 3, ' Goldman, dominant defense leads Bears over Rams 15-6', 'Eddie Goldman led a dominant effort by the defense, and the Chicago Bears shut down Jared Goff and Los Angeles\' high-powered offense in a 15-6 victory over the NFC West champion Rams on Sunday night', 'https://abcnews.go.com/Sports/wireStory/goldman-dominant-defense-leads-bears-rams-15-59719565', '2018-12-10 06:25:19', 'https://s.abcnews.com/images/Sports/WireAP_68304713fea14ee79cd85203abb1e7b3_16x9_992.jpg'),
(29, 3, ' Drake Escape: Miami\'s score on final play beats Pats 34-33', 'Kenyan Drake ran the last 52 yards as the Miami Dolphins scored on a pass and double lateral on the final play to beat the New England Patriots 34-33', 'https://abcnews.go.com/Sports/wireStory/drake-scores-wild-final-play-miami-beats-pats-59714662', '2018-12-10 03:32:17', 'https://s.abcnews.com/images/Sports/WireAP_eb1dce67724c4c128be0cf2fb2f08e5a_16x9_992.jpg'),
(30, 3, ' Column: Across USA, cheers. In New England, shocked silence', 'Column: Across USA, cheers. In New England, shocked silence', 'https://abcnews.go.com/Sports/wireStory/column-usa-cheers-england-shocked-silence-59720871', '2018-12-10 08:09:02', 'https://s.abcnews.com/images/Sports/WireAP_62b3b50955234b9b815b39445feafbf5_16x9_992.jpg'),
(31, 3, ' Prescott\'s 3rd TD to Cooper lifts Cowboys over Eagles in OT', 'Dak Prescott\'s third TD toss to Amari Cooper lifts Cowboys to 29-23 overtime win over Eagles, control of NFC East', 'https://abcnews.go.com/Sports/wireStory/prescotts-3rd-td-cooper-lifts-cowboys-eagles-ot-59718300', '2018-12-10 02:41:29', 'https://s.abcnews.com/images/Sports/WireAP_e79b9196fb0944619707291bea66ed70_16x9_992.jpg'),
(32, 3, ' Butker\'s OT field goal lifts Chiefs past Ravens, 27-24', 'Harrison Butker atoned for a 43-yard miss as time expired with a 36-yard field goal in overtime to give the Chiefs a 27-24 victory over the Ravens and clinch a playoff spot', 'https://abcnews.go.com/Sports/wireStory/butkers-ot-field-goal-lifts-chiefs-past-ravens-59715374', '2018-12-10 03:42:01', 'https://s.abcnews.com/images/Sports/WireAP_3c7adc5dffde44aab08e185a5e83f1dd_16x9_992.jpg'),
(33, 3, ' Baines surprised by Hall of Fame election _ many others, too', 'The election of Harold Baines to the Hall of Fame shocked him and many others in the baseball world, too', 'https://abcnews.go.com/Sports/wireStory/baines-surprised-hall-fame-election-59720939', '2018-12-10 08:11:48', 'https://s.abcnews.com/images/Sports/WireAP_223def1aa41149379452c7cd11dcd84d_16x9_992.jpg'),
(34, 3, ' Raptors go west, Kawhi back to Oracle where so much changed', 'So much changed for Kawhi Leonard and the Spurs last time he played at Golden State', 'https://abcnews.go.com/Sports/wireStory/raptors-west-kawhi-back-oracle-changed-59721006', '2018-12-10 12:10:31', 'https://s.abcnews.com/images/Sports/WireAP_1741dc3953704a31b112174c5fa8c7c3_16x9_992.jpg'),
(35, 3, ' Schofield\'s 3 lifts No. 7 Tennessee over No. 1 Gonzaga 76-73', 'Admiral Schofield hit a 3-pointer with 24 seconds left and scored 25 of his 30 points in the second half, helping No. 7 Tennessee knock off top-ranked Gonzaga 76-73 in the Colangelo Classic', 'https://abcnews.go.com/Sports/wireStory/schofields-lifts-tennessee-gonzaga-76-73-59715866', '2018-12-09 23:03:34', 'https://s.abcnews.com/images/Sports/WireAP_670c3f67e9f3457d859bffdff3ab6e52_16x9_992.jpg'),
(36, 3, ' Oregon\'s No. 3 ranking to dip after loss at Michigan State', 'Kelly Graves thought his Oregon Ducks hadn\'t really done anything to deserve the No. 3 ranking in the AP Top 25 _ the school\'s best ever', 'https://abcnews.go.com/Sports/wireStory/oregons-ranking-dip-loss-michigan-state-59721040', '2018-12-10 08:16:25', 'https://s.abcnews.com/images/Sports/WireAP_e4cab61807564d239d25747e24ea4392_16x9_992.jpg'),
(37, 3, ' National Football League (NFL)', '', 'http://abcnews.go.com/topics/sports/nfl.htm', '2013-11-26 16:47:40', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(38, 3, ' Major League Baseball (MLB)', '', 'http://abcnews.go.com/topics/sports/mlb.htm', '2013-11-26 16:48:16', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(39, 3, ' National Basketball Association (NBA)', '', 'http://abcnews.go.com/topics/sports/nba.htm', '2013-11-26 16:48:54', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(40, 3, ' National Hockey League (NHL)', '', 'http://abcnews.go.com/topics/sports/nhl.htm', '2013-11-26 16:49:31', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(41, 3, ' NCAA College Football', '', 'http://abcnews.go.com/topics/sports/ncaa-football.htm', '2013-11-26 16:50:43', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(42, 3, ' NCAA College Basketball', '', 'http://abcnews.go.com/topics/sports/ncaa-basketball.htm', '2013-11-26 16:51:23', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(43, 4, 'WATCH:  This Week: Dem Sen: Mueller Should \'Show His Cards Soon,\' Give Congress Findings', 'Rubio: Trump pardoning Manafort \'could trigger a debate about\' pardon power; Inside the Navy\'s flyover farewell for President George H.W. Bush', 'https://abcnews.go.com/ThisWeek/video/week-120918-dem-sen-mueller-show-cards-give-59713386', '2018-12-09 19:58:46', 'https://s.abcnews.com/images/ThisWeek/181209_tw_full_hpMain_16x9_992.jpg'),
(44, 4, 'WATCH:  This Week 12/02/18: James Baker Remembers George H.W. Bush\'s \'Consequential Presidency\'', 'H.W. Bush lived \'a life of quality, a life of honor, a life of honesty\': Colin Powell; Roger Stone: \'No evidence to support\' that I was link between WikiLeaks and Trump', 'https://abcnews.go.com/ThisWeek/video/week-120218-james-baker-remembers-george-hw-bushs-59558380', '2018-12-02 18:59:30', 'https://s.abcnews.com/images/ThisWeek/181202_tw_full_hpMain_16x9_992.jpg'),
(45, 4, 'WATCH:  This Week 11/25/18: Dershowitz: Mueller Report ‘Is Going to be Devastating\' for Trump', 'Guests: Amy Klobuchar, Alan Dershowitz, Dan Abrams, Gov. John Kasich, Sen. Sherrod Brown, Cokie Roberts, Amanda Carpenter, Jason Riley, Michelle Cottle', 'https://abcnews.go.com/ThisWeek/video/week-112518-dershowitz-mueller-report-devastating-trump-59405078', '2018-11-25 19:13:59', 'https://s.abcnews.com/images/ThisWeek/181125_tw_full_hpMain_16x9_992.jpg'),
(46, 4, 'WATCH:  This Week: Meet Five New Democratic Congresswomen Ready to Shake Up Washington', 'Butte County sheriff: \'Still trying to bring order to the chaos\' caused by Camp Fire; WaPo reporter: There\'s \'an enormous amount\' of new energy in the new Congress', 'https://abcnews.go.com/ThisWeek/video/week-111818-meet-democratic-congresswomen-ready-shake-washington-59280198', '2018-11-18 21:26:17', 'https://s.abcnews.com/images/ThisWeek/181118_tw_full3_hpMain_16x9_992.jpg'),
(47, 4, 'WATCH:  This Week 11/11/18: Top House Dem: \'I don\'t think\' Whitaker appointment is legal', 'Guests: Elijah Cummings, Jerrold Nadler, Kellyanne Conway, Mary Bruce, Chris Christie, Matthew Dowd, Sara Fagen, Rahm Emanuel', 'https://abcnews.go.com/ThisWeek/video/week-111118-top-house-dem-whitaker-appointment-legal-59122665', '2018-11-11 18:48:58', 'https://s.abcnews.com/images/ThisWeek/181111_tw_full_hpMain_16x9_992.jpg'),
(48, 4, 'WATCH:  TW 11/04/18: ABC/WaPo Poll: Dems Hold 8-Point Lead Over GOP Nationwide in House Races', 'Sen. Van Hollen: Dems have \'narrow path to a majority\' despite difficult Senate map; Matt Dowd: If O\'Rourke wins Texas, \'he becomes the biggest rock star in the country\'', 'https://abcnews.go.com/ThisWeek/video/tw-110418-abcwapo-poll-dems-hold-point-lead-58960157', '2018-11-04 19:41:23', 'https://s.abcnews.com/images/ThisWeek/181104_tw_full_hpMain_16x9_992.jpg'),
(49, 4, 'WATCH:   \'A horrific scene\': The latest from a mourning Pittsburgh community', 'Former FBI agent on soft targets: \'It\'s all just an excuse to harm people.\'; ADL head: \'We should not look away when anti-Semitism is on the rise\'', 'https://abcnews.go.com/ThisWeek/video/week-102818-horrific-scene-latest-mourning-pittsburgh-community-58807957', '2018-10-28 17:47:32', 'https://s.abcnews.com/images/ThisWeek/181028_tw_full_hpMain_16x9_992.jpg'),
(50, 4, 'WATCH:  This Week: Khashoggi\'s WaPo Editor: \'Human Life Should Not Have a Price Tag On It\'', 'Matt Gutman: Caravan is a \'Mass of Humanity\' heading toward U.S. border; On the trail: Does Beto O\'Rourke have a chance against Ted Cruz in Texas?', 'https://abcnews.go.com/ThisWeek/video/week-102118-khashoggis-wapo-editor-human-life-price-58649518', '2018-10-21 19:42:32', 'https://s.abcnews.com/images/ThisWeek/181021_tw_full_crop_hpMain_16x9_992.jpg'),
(51, 4, 'WATCH:  This Week 10/14/18: New Poll Shows Trump Approval up, But Dems Likely to Take House', 'Sen. Flake: \'Severe action needs to be taken\' if Saudi government killed journalist; Sen. Sanders: Democrats \'have to end one party rule\' by winning in midterms', 'https://abcnews.go.com/ThisWeek/video/week-101418-poll-shows-trump-approval-dems-house-58490711', '2018-10-14 17:59:14', 'https://s.abcnews.com/images/ThisWeek/181014_tw_full_hpMain_16x9_992.jpg'),
(52, 4, 'WATCH:  This Week 10/07/18: Kellyanne Conway: Justice Kavanaugh \'Should Not be Seen as Tainted\'', 'Senate Dem: Justice Kavanaugh will have \'a big asterisk after his name\'; Terry Moran: Kavanaugh brings \'poisonous political polarization\' to the Court', 'https://abcnews.go.com/ThisWeek/video/week-100718-kellyanne-conway-justice-kavanaugh-tainted-58342628', '2018-10-07 17:48:05', 'https://s.abcnews.com/images/ThisWeek/181007_tw_full_hpMain_16x9_992.jpg'),
(53, 4, 'WATCH:  This Week 09/30/18: Dem: Kavanaugh \'Only Person Who Didn\'t Want\' FBI Investigation', 'Guests: Lindsey Graham, Mazie Hirono, Jerry Nadler, Alex Castellanos, Amanda Carpenter, Karen Finney, Julie Pace', 'https://abcnews.go.com/ThisWeek/video/week-093018-dem-kavanaugh-person-fbi-investigation-58187770', '2018-09-30 18:53:04', 'https://s.abcnews.com/images/ThisWeek/180930_tw_full_hpMain_16x9_992.jpg'),
(54, 4, 'WATCH:  This Week 09/23/18: Top Dem: Ford\'s Decision To Come Forward \'Speaks To Her Credibility\'', 'Democratic whip on Supreme Court confirmation battle; 1-on-1 with Ambassador to the U.N. Nikki Haley', 'https://abcnews.go.com/ThisWeek/video/week-092318-top-dem-fords-decision-forward-speaks-58023088', '2018-09-23 17:49:25', 'https://s.abcnews.com/images/ThisWeek/180923_tw_full_hpMain_16x9_992.jpg'),
(55, 4, ' Chris Christie: Trump \'not totally clear\' until Mueller \'hands in the keys\'', '&quot;My view would be that you\'re not totally clear, nor is anyone, until Bob Mueller shuts down his office and hands in the keys,” Chris Chrstie said on &quot;This Week.&quot;', 'https://abcnews.go.com/Politics/chris-christie-president-trump-totally-clear-special-counsel/story?id=59702472', '2018-12-09 17:30:06', 'https://s.abcnews.com/images/Politics/robert-mueller-rtr-jc-180222_hpMain_3_16x9_992.jpg'),
(56, 4, ' Senate Dem: Mueller probe now \'beyond the stage\' of Clinton impeachment', 'Murphy said the publicly available facts from the special counsel’s probe indicate Trump’s actions are “beyond the stage” of what led to the impeachment of Clinton.', 'https://abcnews.go.com/Politics/sen-chris-murphy-mueller-probe-now-stage-clinton/story?id=59702470', '2018-12-09 16:43:02', 'https://s.abcnews.com/images/Politics/trump-3-gty-er-181208_hpMain_16x9_992.jpg'),
(57, 4, ' Pardoning Paul Manafort would be \'terrible mistake\': Sen. Marco Rubio', '“I don\'t believe that any pardons should be used with relation to these particular cases, frankly,” Sen. Marco Rubio told &quot;This Week&quot; Co-Anchor Martha Raddatz.', 'https://abcnews.go.com/Politics/pardoning-paul-manafort-terrible-mistake-trigger-debate-pardon/story?id=59702469', '2018-12-09 17:32:15', 'https://s.abcnews.com/images/Politics/manafort-ap-er-181130_hpMain_16x9_992.jpg'),
(58, 4, ' Sunday on \'This Week\': Sen. Marco Rubio and Sen. Chris Murphy', 'This is a listing for &amp;quot;This Week&amp;quot; airing Sunday, Dec. 9.', 'https://abcnews.go.com/Politics/sunday-week-sen-marco-rubio-sen-chris-murphy/story?id=59688116', '2018-12-10 12:29:25', 'https://s.abcnews.com/images/Politics/this-week-promo-abc-jef-180720_hpMain_16x9_992.jpg'),
(59, 4, ' Emails about WikiLeaks publisher Julian Assange being \'mischaracterized\': Roger Stone', 'Roger Stone said his emails about WikiLeaks publisher Julian Assange during the 2016 presidential election, are being &quot;mischaracterized.&quot;', 'https://abcnews.go.com/Politics/emails-wikileaks-publisher-julian-assange-mischaracterized-roger-stone/story?id=59547161', '2018-12-02 20:39:36', 'https://s.abcnews.com/images/Politics/roger-stone-capitol-gty-ps-181201_hpMain_16x9_992.jpg'),
(60, 4, ' \'This Week\' Transcript 12-9-18: Sen. Marco Rubio and Sen. Chris Murphy', 'This is a rush transcript for &amp;quot;This Week&amp;quot; airing Dec. 9, 2018.', 'https://abcnews.go.com/Politics/week-transcript-12-18-sen-marco-rubio-sen/story?id=59702985', '2018-12-09 17:05:24', 'https://s.abcnews.com/images/Politics/rubio-ap-er-180322_hpMain_4_16x9_992.jpg'),
(61, 4, ' \'This Week\' Transcript 12-2-18: James Baker, Colin Powell, Rep. Schiff, Roger Stone', 'This is a rush transcript for &amp;quot;This Week&amp;quot; on Dec. 2, 2018.', 'https://abcnews.go.com/Politics/week-transcript-12-18-james-baker-colin-powell/story?id=59543297', '2018-12-02 19:11:58', 'https://s.abcnews.com/images/Politics/adam-schiff-press-ap-ps-181201_hpMain_16x9_992.jpg'),
(62, 4, ' Archive: \'This Week\' Transcripts', '\'This Week\' Transcript Archive', 'https://abcnews.go.com/Politics/week-transcript-archive/story?id=16614108', '2018-12-05 20:05:35', 'https://s.abcnews.com/images/US/this-week-transcript-archive-abc-02-jpo-180420_hpMain_16x9_992.jpg'),
(63, 4, ' George Stephanopoulos\' biography', 'George Stephanopoulos is the anchor of &quot;GMA,&quot; ABC News\' chief political correspondent and host ABC\'s preeminent Sunday morning political affairs program, &quot;This Week', 'https://abcnews.go.com/GMA/george-stephanopoulos-good-morning-america-anchor-biography/story?id=133369', '2017-06-05 18:59:12', 'https://s.abcnews.com/images/Politics/abc_george_stephanopoulos_2_dm_120124_wmain.jpg'),
(64, 4, 'WATCH:  Congress reacts to memos implicating Trump in federal crime', 'A top House Democrat says the illegal payments made to Stormy Daniels and Karen McDougal during the campaign may be grounds for impeachment.', 'https://abcnews.go.com/GMA/News/video/congress-reacts-memos-implicating-trump-federal-crime-59722707', '2018-12-10 14:09:32', 'https://s.abcnews.com/images/GMA/181210_gma_bruce4_hpMain_16x9_992.jpg'),
(65, 4, 'WATCH:  Who will be new chief of staff as Trump says Kelly is out? ', 'White House officials say the president has a list of four potential replacements for John Kelly and contenders include Congressman Mark Meadows, acting Attorney General Matt Whitaker and David Bossie', 'https://abcnews.go.com/GMA/News/video/chief-staff-trump-kelly-59722704', '2018-12-10 13:29:00', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(66, 4, 'WATCH:  Trump in search of a new chief of staff to replace John Kelly', 'President Donald Trump is under pressure as a former prosecutor predicts Trump may be indicted by Robert Mueller\'s team. ABC News\' Kenneth Moton reports.', 'https://abcnews.go.com/Politics/video/trump-search-chief-staff-replace-john-kelly-59722387', '2018-12-10 12:49:38', 'https://s.abcnews.com/images/Politics/181210_atm_moton_pic_hpMain_16x9_992.jpg'),
(67, 4, ' Everything you need to know about John Kelly, Trump\'s chief of staff', 'Kelly was sworn-in as President Trump\'s new chief of staff to replace Reince Priebus in July of 2017.', 'https://abcnews.go.com/Politics/gen-john-kelly-trumps-expected-pick-homeland-security/story?id=44037123', '2018-12-07 17:14:36', 'https://s.abcnews.com/images/Politics/ap-John-Kelly-hb-161207_16x9_992.jpg'),
(68, 5, ' Ghosn, Kelly, Nissan charged with underreporting pay', 'Charges allege Ghosn\'s pay was underreported by 5 billion yen ($44 million).', 'https://abcnews.go.com/Business/wireStory/reports-ghosn-kelly-nissan-charged-underreported-pay-59720357', '2018-12-10 12:48:04', 'https://s.abcnews.com/images/Business/WireAP_098d1b78ec1c46ec83b8950ebd4698e0_16x9_992.jpg'),
(69, 5, ' Marlboro maker places $1.8 billion bet on marijuana', 'Marlboro maker dives into the cannabis market with a $1.8 billion buy-in', 'https://abcnews.go.com/Business/wireStory/marlboro-maker-leaps-cannabis-trade-24b-59675735', '2018-12-07 18:58:29', 'https://s.abcnews.com/images/Business/WireAP_8c259b4c4f5f4b8a8be1403f78d480ac_16x9_992.jpg'),
(70, 5, ' China pressures US, Canada ahead of Huawei hearing', 'China ups pressure on US, Canada for release of top Chinese technology executive', 'https://abcnews.go.com/Business/wireStory/china-pressures-us-canada-ahead-huawei-hearing-59720497', '2018-12-10 10:38:04', 'https://s.abcnews.com/images/Business/WireAP_576b7d5019964bd8a16150d343c9da1e_16x9_992.jpg'),
(71, 5, ' Stocks drop 4 percent in rocky week on trade, growth worries', 'Wall Street capped a turbulent week of trading Friday with the biggest weekly loss for the U.S. stock market in nearly nine months', 'https://abcnews.go.com/Business/wireStory/technology-companies-lead-slide-us-stocks-oil-rising-59678827', '2018-12-07 23:30:17', 'https://s.abcnews.com/images/Business/WireAP_90eb0df4440847faad7dea755a08a1f7_16x9_992.jpg'),
(72, 5, ' Shrinking Japan OKs divisive bill to get more foreign labor', 'Japan set to approve opening door to foreign workers for unskilled jobs', 'https://abcnews.go.com/Business/wireStory/shrinking-japan-oks-divisive-bill-foreign-labor-59672929', '2018-12-07 10:54:45', 'https://s.abcnews.com/images/Business/WireAP_57e83743c38a4a869604435f9c4405f9_16x9_992.jpg'),
(73, 5, ' Dow dives nearly 800 points on fears of economic slowdown', 'The Dow ended Tuesday 800 points lower on fears of an economic slowdown.', 'https://abcnews.go.com/Business/dow-dives-800-points-fears-economic-slowdown/story?id=59604052', '2018-12-05 12:39:47', 'https://s.abcnews.com/images/Business/stock-trader-file-ap-jef-181204_hpMain_16x9_992.jpg'),
(74, 5, 'WATCH:  Holiday spending breaking records', 'There are just 10 business shopping days left and this is one of the busiest days before Christmas Americans already spending a record $80 billion online this holiday season.', 'https://abcnews.go.com/GMA/Shop/video/holiday-spending-breaking-records-59724585', '2018-12-10 14:09:31', 'https://s.abcnews.com/images/GMA/181210_gma_worley1_hpMain_16x9_992.jpg'),
(75, 5, 'WATCH:  Dow down nearly 556 points, more than 4% lower for week', 'It\'s the worst start to December since 2008, and it\'s due to fears that the U.S. economy could face a slowdown in 2019.', 'https://abcnews.go.com/WNT/video/dow-556-points-lower-week-59689665', '2018-12-08 01:58:31', 'https://s.abcnews.com/images/WNT/181207_wn_jarvis_638_hpMain_16x9_992.jpg'),
(76, 5, 'WATCH:  General Motors under fire', 'Members of Congress from Ohio, Michigan and Maryland, met with GM and asked how they plan to protect the workers when layoffs are implemented.', 'https://abcnews.go.com/WNT/video/general-motors-fire-59666460', '2018-12-07 02:39:01', 'https://s.abcnews.com/images/WNT/181206_wn_bruce_hpMain_16x9_992.jpg'),
(77, 5, 'WATCH:  The best cars for new millionaires', 'Here are some of the best cars lucky lotto winners should buy with their newfound cash.', 'https://abcnews.go.com/Business/video/best-cars-millionaires-59656989', '2018-12-07 17:30:03', 'https://s.abcnews.com/images/Business/181205_vod_orig_mega_millions_cars_year_end_hpMain_16x9_992.jpg'),
(78, 5, 'WATCH:  Wells Fargo computer glitch led to foreclosures', 'An estimated 545 customers lost their homes when the bank incorrectly denied 870 loan modification requests due to calculation errors.', 'https://abcnews.go.com/Business/video/wells-fargo-computer-glitch-led-foreclosures-59623284', '2018-12-05 15:29:07', 'https://s.abcnews.com/images/Business/181205_wnn_wells_fargo_hpMain_16x9_992.jpg'),
(79, 5, 'WATCH:  Dow drops nearly 800 points -- a loss of more than 3%', 'There\'s been confusion on Wall Street about the prospects for a trade deal between the US and China.', 'https://abcnews.go.com/WNT/video/dow-drops-800-points-loss-59609958', '2018-12-05 01:04:33', 'https://s.abcnews.com/images/WNT/181204_wn_jarvis_635_hpMain_16x9_992.jpg'),
(80, 5, 'WATCH:  Marriott says data breach may affect up to 500 million Starwood hotel guests', 'It is one of the top five largest data breaches in history.', 'https://abcnews.go.com/Business/video/marriott-data-breach-affect-500-million-starwood-hotel-59530700', '2018-11-30 22:32:54', 'https://s.abcnews.com/images/Business/181130_nwo_marriott_data_breach_MIX_hpMain_16x9_992.jpg'),
(81, 5, 'WATCH:  Honda recalls 2018, 2019 Honda Odysseys', 'There are concerns the power sliding door can open while the car is moving; the automaker is offering a free fix.', 'https://abcnews.go.com/WNT/video/honda-recalls-2018-2019-honda-odysseys-59482596', '2018-11-29 00:56:58', 'https://s.abcnews.com/images/WNT/181128_wnt_index_honda_odyssey_recall_hpMain_16x9_992.jpg'),
(82, 5, 'WATCH:  What is the Fed?', 'The Federal Reserve System is the central bank of the U.S.', 'https://abcnews.go.com/Business/video/fed--59481101', '2018-11-28 23:16:15', 'https://s.abcnews.com/images/Business/181128_vod_orig_fed_hpMain_16x9_992.jpg'),
(83, 5, 'WATCH:  Has your boss ever taken your idea? Here are tips to survive the work bandit', 'Michael Strahan and Sara Haines have everything you need to know this afternoon.', 'https://abcnews.go.com/GMA/GMA_Day/video/boss-idea-tips-survive-work-bandit-59472779', '2018-11-28 19:56:27', 'https://s.abcnews.com/images/GMA/181128_gmaday_blka_work2_107_hpMain_16x9_992.jpg'),
(84, 5, 'WATCH:  GM workers seek answers amid shutdown plans', 'ABC News\' Eva Pilgrim spoke with GM employees, some of whom blame the president for the planned layoffs.', 'https://abcnews.go.com/GMA/News/video/general-motors-workers-seek-answers-amid-shutdown-plans-59465158', '2018-11-28 14:51:31', 'https://s.abcnews.com/images/GMA/181128_gma_pilgrim_0705_hpMain_16x9_992.jpg'),
(85, 5, 'WATCH:  GM workers respond to news of shutdown: \'Everyone is scared\'', 'President Trump lashed out at the U.S. automaker for eliminating nearly 15,000 jobs but GM said the move was forced by consumer demand.', 'https://abcnews.go.com/WNT/video/gm-workers-respond-news-shutdown-scared-59454214', '2018-11-28 01:09:43', 'https://s.abcnews.com/images/WNT/181127_wn_pilgrim4_hpMain_16x9_992.jpg'),
(86, 5, ' Head of India\'s central bank resigns amid government split', 'The head of India\'s central bank has resigned amid a growing split between the Indian government and the independent monetary authority', 'https://abcnews.go.com/Business/wireStory/head-indias-central-bank-resigns-amid-government-split-59723329', '2018-12-10 12:53:00', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(87, 5, ' Ghosn, Kelly, Nissan charged with underreporting pay', 'Charges allege Ghosn\'s pay was underreported by 5 billion yen ($44 million).', 'https://abcnews.go.com/Business/wireStory/reports-ghosn-kelly-nissan-charged-underreported-pay-59720357', '2018-12-10 12:48:04', 'https://s.abcnews.com/images/Business/WireAP_098d1b78ec1c46ec83b8950ebd4698e0_16x9_992.jpg'),
(88, 5, ' World stocks slip on China-US tensions, Brexit uncertainty', 'World stocks are down as tensions between the U.S. and China over the arrest of a senior telecoms executive raise concerns about talks on global trade', 'https://abcnews.go.com/Business/wireStory/asian-shares-fall-huawei-arrest-imperils-china-us-59720496', '2018-12-10 12:29:19', 'https://s.abcnews.com/images/Business/WireAP_3bdfb9aa8d774bd98b082dfb7c621764_16x9_992.jpg'),
(89, 5, ' Travel software company Travelport targeted in $4.4B deal', 'Travel software company Travelport to go private in $4.4 billion agreement with buyout firms', 'https://abcnews.go.com/Business/wireStory/travel-software-company-travelport-targeted-44b-deal-59722437', '2018-12-10 11:59:45', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(90, 5, ' The Latest: PM Abe says Japan-French ties unshakable', 'Abe says Japan-French ties unshakeable despite Nissan scandal', 'https://abcnews.go.com/Business/wireStory/latest-reports-detention-ghosn-extended-59720498', '2018-12-10 10:53:18', 'https://s.abcnews.com/images/Business/WireAP_098d1b78ec1c46ec83b8950ebd4698e0_16x9_992.jpg'),
(91, 5, ' China pressures US, Canada ahead of Huawei hearing', 'China ups pressure on US, Canada for release of top Chinese technology executive', 'https://abcnews.go.com/Business/wireStory/china-pressures-us-canada-ahead-huawei-hearing-59720497', '2018-12-10 10:38:04', 'https://s.abcnews.com/images/Business/WireAP_576b7d5019964bd8a16150d343c9da1e_16x9_992.jpg'),
(92, 5, ' SoftBank\'s mobile unit\'s share price set for Dec. 19 IPO', 'SoftBank Group Corp. mobile unit IPO price set at 1,500 yen ($13) a share', 'https://abcnews.go.com/Business/wireStory/softbanks-mobile-units-share-price-set-dec-19-59721383', '2018-12-10 10:30:27', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(93, 6, ' What does Martian wind sound like? Now we know', 'It\'s the first time humans can hear the wind on the Red Planet.', 'https://abcnews.go.com/Technology/martian-wind-sound-now/story?id=59682477', '2018-12-08 18:00:36', 'https://s.abcnews.com/images/Business/mars-insight-nasa-gty-jc-181127_hpMain_16x9_992.jpg'),
(94, 6, ' So you stayed at a Starwood hotel: Tips on data breach', 'If you stayed at one of Marriott\'s Starwood hotels in recent years, hackers might have information on your address, credit card and even your passport', 'https://abcnews.go.com/Technology/wireStory/stayed-starwood-hotel-tips-data-breach-59526048', '2018-11-30 23:50:47', 'https://s.abcnews.com/images/Technology/WireAP_fb54de842e7d48dcade213eba37aa62f_16x9_992.jpg'),
(95, 6, ' Scientists have discovered a hidden talent of geckos ', 'Geckos use a combination of techniques to race across water.', 'https://abcnews.go.com/Technology/scientists-discovered-hidden-talent-geckos/story?id=59662761', '2018-12-07 13:30:30', 'https://s.abcnews.com/images/Technology/gecko-01-ht-jc-181206_hpMain_16x9_992.jpg'),
(96, 6, ' Africa\'s solid waste is growing, posing a climate threat', 'Africa\'s solid waste is growing as population booms, posing a climate threat', 'https://abcnews.go.com/Technology/wireStory/africas-solid-waste-growing-posing-climate-threat-59695255', '2018-12-08 17:52:18', 'https://s.abcnews.com/images/Technology/WireAP_6ddfe8fe846944d49d46dc21bfc7f51b_16x9_992.jpg'),
(97, 6, ' Nation\'s largest police department puts its eyes in the skies with new drone program ', 'The adoption of drones by the NYPD could effect departments across the nation.', 'https://abcnews.go.com/Technology/nypd-nations-largest-police-department-puts-eyes-skies/story?id=59599207', '2018-12-05 16:07:23', 'https://s.abcnews.com/images/Technology/nypd-drones-rd-jc-181204_hpMain_16x9_992.jpg'),
(98, 6, ' How AI is changing the music industry ', 'Algorithms for mixing and mastering audio are having a growing impact.', 'https://abcnews.go.com/Technology/ai-changing-music-industry/story?id=59580886', '2018-12-03 19:44:51', 'https://s.abcnews.com/images/Technology/music-gty-jpo-181203_hpMain_16x9_992.jpg'),
(99, 6, ' SpaceX Christmas delivery arrives at space station', 'A SpaceX delivery full of Christmas goodies has arrived at the International Space Station', 'https://abcnews.go.com/Technology/wireStory/spacex-christmas-delivery-delayed-communication-problem-59696233', '2018-12-08 16:08:46', 'https://s.abcnews.com/images/Technology/WireAP_d578cd1ab2924b3689c0c23c90c0e64a_16x9_992.jpg'),
(100, 6, ' Climate talks pause as battle over key science report looms', 'A diplomatic standoff over a single word could set the stage for a bigger showdown during the second half of this year\'s U.N. climate summit', 'https://abcnews.go.com/Technology/wireStory/climate-talks-pause-battle-key-science-report-looms-59711181', '2018-12-09 16:44:42', 'https://s.abcnews.com/images/Technology/WireAP_02932d711da143c2944826382e88c1c6_16x9_992.jpg'),
(101, 6, ' Could anyone have stopped gene-edited babies experiment?', 'Scientific consensus and regulations in much of the world prohibit making genetic changes that could be passed to future generations. But nothing stopped the Chinese researcher from helping to make the world\'s first gene-edited babies.', 'https://abcnews.go.com/Technology/wireStory/stopped-gene-edited-babies-work-59557579', '2018-12-03 01:13:52', 'https://s.abcnews.com/images/Technology/WireAP_d416ea2bf5d745b28e78a2edcda8c982_16x9_992.jpg'),
(102, 6, ' Big shareholder at Yelp wants a board reshuffle', 'Large shareholder at Yelp, citing missteps, wants seeks a board reshuffling', 'https://abcnews.go.com/Technology/wireStory/big-shareholder-yelp-board-reshuffle-59723661', '2018-12-10 14:42:03', 'https://s.abcnews.com/images/Technology/WireAP_5bdaa2ddb8b546e38de2db9b3026c8fb_16x9_992.jpg'),
(103, 6, 'WATCH:  Retailers set online sale prices for \'Green Monday\'', 'Shoppers prepare for one of the final online shopping sale days left in December.', 'https://abcnews.go.com/Technology/video/retailers-set-online-sale-prices-green-monday-59722439', '2018-12-10 12:48:38', 'https://s.abcnews.com/images/Technology/181210_atm_techbytes_hpMain_16x9_992.jpg'),
(104, 6, 'WATCH:  Martian wind heard for the 1st time', 'A highly-sensitive seismometer, meant to study marsquakes, picked up the sound of wind on Mars.', 'https://abcnews.go.com/Technology/video/martian-wind-heard-1st-time-59684684', '2018-12-07 19:45:54', 'https://s.abcnews.com/images/Technology/181207_vod_orig_marssounds_hpMain_16x9_992.jpg'),
(105, 6, 'WATCH:  Is your Android phone tracking you?  ', 'ABC News\' Rebecca Jarvis looks into how much information your cell phone is really collecting about you.', 'https://abcnews.go.com/GMA/News/video/android-phone-tracking-59676023', '2018-12-07 14:05:42', 'https://s.abcnews.com/images/GMA/181207_gma_jarvis_hpMain_16x9_992.jpg'),
(106, 6, 'WATCH:  Apple Watch adds irregular heart-rate feature', 'The latest Apple Watch software will monitor users for an irregular heart rhythm.', 'https://abcnews.go.com/Technology/video/apple-watch-adds-irregular-heart-rate-feature-59674319', '2018-12-07 13:29:54', 'https://s.abcnews.com/images/Technology/181207_atm_techbytes_hpMain_16x9_992.jpg'),
(107, 6, 'WATCH:  Uber tries again to put self-driving cars on the road', 'The ride sharing company has resumed testing of self-driving vehicles despite a fatal accident earlier this year.', 'https://abcnews.go.com/Technology/video/uber-put-driving-cars-road-59646802', '2018-12-06 12:43:42', 'https://s.abcnews.com/images/Technology/181206_atm_techbytes2_hpMain_16x9_992.jpg'),
(108, 6, 'WATCH:  Cuba lifts ban on cellphone internet access', 'Cuban citizens are now able to access the internet on their phones for the first time.', 'https://abcnews.go.com/Technology/video/cuba-lifts-ban-cellphone-internet-access-59619456', '2018-12-05 12:28:56', 'https://s.abcnews.com/images/Technology/181205_atm_techbytes_hpMain_16x9_992.jpg'),
(109, 6, 'WATCH:  Whale songs have changed over the last few decades', 'Songs have lowered in frequency, in part because of changes to ocean water.', 'https://abcnews.go.com/Technology/video/whale-songs-changed-decades-59611811', '2018-12-05 00:45:04', 'https://s.abcnews.com/images/Technology/181204_ugc_whale_songs_hpMain_16x9_992.jpg'),
(110, 6, 'WATCH:  Apple\'s most popular apps of 2018', 'Despite privacy issues, social media apps top the list.', 'https://abcnews.go.com/Technology/video/apples-popular-apps-2018-59593945', '2018-12-04 13:02:37', 'https://s.abcnews.com/images/Technology/181204_atm_techbytes_hpMain_16x9_992.jpg'),
(111, 6, 'WATCH:  First manned Soyuz rocket since October accident takes off', 'American astronaut Anne McClain joined Canada\'s David Saint-Jacques and Russia\'s Oleg Kononenko aboard the rocket that launched from the Baikonur spaceport in the desert in central Kazakhstan.', 'https://abcnews.go.com/Technology/video/manned-soyuz-rocket-october-accident-takes-off-59587607', '2018-12-04 00:57:37', 'https://s.abcnews.com/images/Technology/181203_vod_orig_russialauncheditMIX_hpMain_16x9_992.jpg'),
(112, 6, 'WATCH:  NASA\'s OSIRIS-REx spacecraft arrives at asteroid Bennu after long journey', 'The rocket will bring samples of the asteroid back to Earth if all goes well.', 'https://abcnews.go.com/Technology/video/nasas-osiris-rex-spacecraft-arrives-asteroid-bennu-long-59579568', '2018-12-03 18:34:37', 'https://s.abcnews.com/images/Technology/181203_abcnl_nasa_hpMain_16x9_992.jpg'),
(113, 6, 'WATCH:  Bigger stores without cashiers may be on the way', 'Amazon may try cashierless stores in larger spaces, the Wall Street Journal reported.', 'https://abcnews.go.com/Technology/video/bigger-stores-cashiers-59572605', '2018-12-03 13:32:55', 'https://s.abcnews.com/images/Technology/181203_atm_techbytes_hpMain_16x9_992.jpg'),
(114, 6, 'WATCH:  NASA is looking for contractors for the next moon mission', 'Plus, YouTube adds stories and the U.S. military is testing exoskeletons for its soldiers.', 'https://abcnews.go.com/Technology/video/nasa-contractors-moon-mission-59519172', '2018-11-30 15:29:22', 'https://s.abcnews.com/images/Technology/181130_atm_techbytes_hpMain_16x9_992.jpg'),
(115, 6, ' Big shareholder at Yelp wants a board reshuffle', 'Large shareholder at Yelp, citing missteps, wants seeks a board reshuffling', 'https://abcnews.go.com/Technology/wireStory/big-shareholder-yelp-board-reshuffle-59723661', '2018-12-10 14:42:03', 'https://s.abcnews.com/images/Technology/WireAP_5bdaa2ddb8b546e38de2db9b3026c8fb_16x9_992.jpg'),
(116, 6, ' How computers may eventually beat humans at their own games ', 'AIs have defeated humans at even more computationally difficult games.', 'https://abcnews.go.com/Technology/computer-program-taught-play-chess-shogi/story?id=59680544', '2018-12-10 14:41:05', 'https://s.abcnews.com/images/Technology/deepmind-alphazero-ht-jc-181207_hpMain_16x9_992.jpg'),
(117, 6, ' Protesters disrupt US fossil fuel event at UN climate talks', 'Indigenous and youth groups have disrupted a U.S. government event at the U.N. climate talks, criticizing the Trump administration\'s policy of backing the extraction of fossil fuels', 'https://abcnews.go.com/Technology/wireStory/protesters-disrupt-us-fossil-fuel-event-climate-talks-59725098', '2018-12-10 14:06:56', 'https://s.abcnews.com/images/Technology/WireAP_7d089468f63f435f8a5abd294c18bee9_16x9_992.jpg'),
(118, 7, ' Lakers trying to add Suns\' Trevor Ariza in three-way trade', 'The         Los Angeles Lakers are engaged in talks to try to acquire         Phoenix Suns forward         Trevor Ariza, league sources told ESPN.     The teams have been working to reach an agreement with a third team that would take on Lakers guard         Kentavious Caldwell-Pope as part of a potentially larger deal, league sources said.     The Suns want to land a playmaking guard and a draft asset as the price of unloading Ariza, sources said. Phoenix and Los Angeles have made progress in third-team scenarios, although no agreements are close and both teams remain active in multiple trade discussions throughout the league, sources said.     No trade can be completed officially until Saturday, when players who, like Ariza, were signed in summer free agency become eligible to be traded.     Ariza is one of the most important trade assets for the Suns -- losers of 22 of 26 games -- and their best chance to bolster their backcourt and gain assets. Most contending teams are...', 'https://abcnews.go.com/Sports/lakers-add-suns-trevor-ariza-trade/story?id=59717784', '2018-12-10 02:06:38', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(119, 7, ' Warriors named Sports Illustrated\'s Sportsperson of Year', 'The three-time NBA champion Golden State Warriors are the fourth team that has been honored as Sports Illustrated\'s Sportsperson of the Year', 'https://abcnews.go.com/Sports/wireStory/warriors-named-sports-illustrateds-sportsperson-year-59722438', '2018-12-10 12:04:51', 'https://s.abcnews.com/images/Sports/WireAP_2b45ba9a67284e33b0bde167d89bbf6c_16x9_992.jpg'),
(120, 7, ' Goldman, dominant defense leads Bears over Rams 15-6', 'Eddie Goldman led a dominant effort by the defense, and the Chicago Bears shut down Jared Goff and Los Angeles\' high-powered offense in a 15-6 victory over the NFC West champion Rams on Sunday night', 'https://abcnews.go.com/Sports/wireStory/goldman-dominant-defense-leads-bears-rams-15-59719565', '2018-12-10 06:25:19', 'https://s.abcnews.com/images/Sports/WireAP_68304713fea14ee79cd85203abb1e7b3_16x9_992.jpg'),
(121, 7, ' Drake Escape: Miami\'s score on final play beats Pats 34-33', 'Kenyan Drake ran the last 52 yards as the Miami Dolphins scored on a pass and double lateral on the final play to beat the New England Patriots 34-33', 'https://abcnews.go.com/Sports/wireStory/drake-scores-wild-final-play-miami-beats-pats-59714662', '2018-12-10 03:32:17', 'https://s.abcnews.com/images/Sports/WireAP_eb1dce67724c4c128be0cf2fb2f08e5a_16x9_992.jpg'),
(122, 7, ' Column: Across USA, cheers. In New England, shocked silence', 'Column: Across USA, cheers. In New England, shocked silence', 'https://abcnews.go.com/Sports/wireStory/column-usa-cheers-england-shocked-silence-59720871', '2018-12-10 08:09:02', 'https://s.abcnews.com/images/Sports/WireAP_62b3b50955234b9b815b39445feafbf5_16x9_992.jpg'),
(123, 7, ' Prescott\'s 3rd TD to Cooper lifts Cowboys over Eagles in OT', 'Dak Prescott\'s third TD toss to Amari Cooper lifts Cowboys to 29-23 overtime win over Eagles, control of NFC East', 'https://abcnews.go.com/Sports/wireStory/prescotts-3rd-td-cooper-lifts-cowboys-eagles-ot-59718300', '2018-12-10 02:41:29', 'https://s.abcnews.com/images/Sports/WireAP_e79b9196fb0944619707291bea66ed70_16x9_992.jpg'),
(124, 7, ' Butker\'s OT field goal lifts Chiefs past Ravens, 27-24', 'Harrison Butker atoned for a 43-yard miss as time expired with a 36-yard field goal in overtime to give the Chiefs a 27-24 victory over the Ravens and clinch a playoff spot', 'https://abcnews.go.com/Sports/wireStory/butkers-ot-field-goal-lifts-chiefs-past-ravens-59715374', '2018-12-10 03:42:01', 'https://s.abcnews.com/images/Sports/WireAP_3c7adc5dffde44aab08e185a5e83f1dd_16x9_992.jpg'),
(125, 7, ' Baines surprised by Hall of Fame election _ many others, too', 'The election of Harold Baines to the Hall of Fame shocked him and many others in the baseball world, too', 'https://abcnews.go.com/Sports/wireStory/baines-surprised-hall-fame-election-59720939', '2018-12-10 08:11:48', 'https://s.abcnews.com/images/Sports/WireAP_223def1aa41149379452c7cd11dcd84d_16x9_992.jpg');
INSERT INTO `newsfeed` (`id`, `hashtag_id`, `title`, `description`, `link`, `fetch_date`, `image_link`) VALUES
(126, 7, ' Raptors go west, Kawhi back to Oracle where so much changed', 'So much changed for Kawhi Leonard and the Spurs last time he played at Golden State', 'https://abcnews.go.com/Sports/wireStory/raptors-west-kawhi-back-oracle-changed-59721006', '2018-12-10 12:10:31', 'https://s.abcnews.com/images/Sports/WireAP_1741dc3953704a31b112174c5fa8c7c3_16x9_992.jpg'),
(127, 7, ' Schofield\'s 3 lifts No. 7 Tennessee over No. 1 Gonzaga 76-73', 'Admiral Schofield hit a 3-pointer with 24 seconds left and scored 25 of his 30 points in the second half, helping No. 7 Tennessee knock off top-ranked Gonzaga 76-73 in the Colangelo Classic', 'https://abcnews.go.com/Sports/wireStory/schofields-lifts-tennessee-gonzaga-76-73-59715866', '2018-12-09 23:03:34', 'https://s.abcnews.com/images/Sports/WireAP_670c3f67e9f3457d859bffdff3ab6e52_16x9_992.jpg'),
(128, 7, ' Oregon\'s No. 3 ranking to dip after loss at Michigan State', 'Kelly Graves thought his Oregon Ducks hadn\'t really done anything to deserve the No. 3 ranking in the AP Top 25 _ the school\'s best ever', 'https://abcnews.go.com/Sports/wireStory/oregons-ranking-dip-loss-michigan-state-59721040', '2018-12-10 08:16:25', 'https://s.abcnews.com/images/Sports/WireAP_e4cab61807564d239d25747e24ea4392_16x9_992.jpg'),
(129, 7, ' National Football League (NFL)', '', 'http://abcnews.go.com/topics/sports/nfl.htm', '2013-11-26 16:47:40', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(130, 7, ' Major League Baseball (MLB)', '', 'http://abcnews.go.com/topics/sports/mlb.htm', '2013-11-26 16:48:16', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(131, 7, ' National Basketball Association (NBA)', '', 'http://abcnews.go.com/topics/sports/nba.htm', '2013-11-26 16:48:54', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(132, 7, ' National Hockey League (NHL)', '', 'http://abcnews.go.com/topics/sports/nhl.htm', '2013-11-26 16:49:31', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(133, 7, ' NCAA College Football', '', 'http://abcnews.go.com/topics/sports/ncaa-football.htm', '2013-11-26 16:50:43', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(134, 7, ' NCAA College Basketball', '', 'http://abcnews.go.com/topics/sports/ncaa-basketball.htm', '2013-11-26 16:51:23', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(135, 8, ' Ghosn, Kelly, Nissan charged with underreporting pay', 'Charges allege Ghosn\'s pay was underreported by 5 billion yen ($44 million).', 'https://abcnews.go.com/Business/wireStory/reports-ghosn-kelly-nissan-charged-underreported-pay-59720357', '2018-12-10 12:48:04', 'https://s.abcnews.com/images/Business/WireAP_098d1b78ec1c46ec83b8950ebd4698e0_16x9_992.jpg'),
(136, 8, ' Stocks drop 4 percent in rocky week on trade, growth worries', 'Wall Street capped a turbulent week of trading Friday with the biggest weekly loss for the U.S. stock market in nearly nine months', 'https://abcnews.go.com/Business/wireStory/technology-companies-lead-slide-us-stocks-oil-rising-59678827', '2018-12-07 23:30:17', 'https://s.abcnews.com/images/Business/WireAP_90eb0df4440847faad7dea755a08a1f7_16x9_992.jpg'),
(137, 8, ' Shrinking Japan OKs divisive bill to get more foreign labor', 'Japan set to approve opening door to foreign workers for unskilled jobs', 'https://abcnews.go.com/Business/wireStory/shrinking-japan-oks-divisive-bill-foreign-labor-59672929', '2018-12-07 10:54:45', 'https://s.abcnews.com/images/Business/WireAP_57e83743c38a4a869604435f9c4405f9_16x9_992.jpg'),
(138, 8, ' Dow dives nearly 800 points on fears of economic slowdown', 'The Dow ended Tuesday 800 points lower on fears of an economic slowdown.', 'https://abcnews.go.com/Business/dow-dives-800-points-fears-economic-slowdown/story?id=59604052', '2018-12-05 12:39:47', 'https://s.abcnews.com/images/Business/stock-trader-file-ap-jef-181204_hpMain_16x9_992.jpg'),
(139, 8, ' China pressures US, Canada ahead of Huawei hearing', 'China ups pressure on US, Canada for release of top Chinese technology executive', 'https://abcnews.go.com/Business/wireStory/china-pressures-us-canada-ahead-huawei-hearing-59720497', '2018-12-10 10:38:04', 'https://s.abcnews.com/images/Business/WireAP_576b7d5019964bd8a16150d343c9da1e_16x9_992.jpg'),
(140, 8, 'WATCH:  Holiday spending breaking records', 'There are just 10 business shopping days left and this is one of the busiest days before Christmas Americans already spending a record $80 billion online this holiday season.', 'https://abcnews.go.com/GMA/Shop/video/holiday-spending-breaking-records-59724585', '2018-12-10 14:09:31', 'https://s.abcnews.com/images/GMA/181210_gma_worley1_hpMain_16x9_992.jpg'),
(141, 8, 'WATCH:  Dow down nearly 556 points, more than 4% lower for week', 'It\'s the worst start to December since 2008, and it\'s due to fears that the U.S. economy could face a slowdown in 2019.', 'https://abcnews.go.com/WNT/video/dow-556-points-lower-week-59689665', '2018-12-08 01:58:31', 'https://s.abcnews.com/images/WNT/181207_wn_jarvis_638_hpMain_16x9_992.jpg'),
(142, 8, 'WATCH:  General Motors under fire', 'Members of Congress from Ohio, Michigan and Maryland, met with GM and asked how they plan to protect the workers when layoffs are implemented.', 'https://abcnews.go.com/WNT/video/general-motors-fire-59666460', '2018-12-07 02:39:01', 'https://s.abcnews.com/images/WNT/181206_wn_bruce_hpMain_16x9_992.jpg'),
(143, 8, 'WATCH:  The best cars for new millionaires', 'Here are some of the best cars lucky lotto winners should buy with their newfound cash.', 'https://abcnews.go.com/Business/video/best-cars-millionaires-59656989', '2018-12-07 17:30:03', 'https://s.abcnews.com/images/Business/181205_vod_orig_mega_millions_cars_year_end_hpMain_16x9_992.jpg'),
(144, 8, 'WATCH:  Wells Fargo computer glitch led to foreclosures', 'An estimated 545 customers lost their homes when the bank incorrectly denied 870 loan modification requests due to calculation errors.', 'https://abcnews.go.com/Business/video/wells-fargo-computer-glitch-led-foreclosures-59623284', '2018-12-05 15:29:07', 'https://s.abcnews.com/images/Business/181205_wnn_wells_fargo_hpMain_16x9_992.jpg'),
(145, 8, 'WATCH:  Dow drops nearly 800 points -- a loss of more than 3%', 'There\'s been confusion on Wall Street about the prospects for a trade deal between the US and China.', 'https://abcnews.go.com/WNT/video/dow-drops-800-points-loss-59609958', '2018-12-05 01:04:33', 'https://s.abcnews.com/images/WNT/181204_wn_jarvis_635_hpMain_16x9_992.jpg'),
(146, 8, 'WATCH:  Marriott says data breach may affect up to 500 million Starwood hotel guests', 'It is one of the top five largest data breaches in history.', 'https://abcnews.go.com/Business/video/marriott-data-breach-affect-500-million-starwood-hotel-59530700', '2018-11-30 22:32:54', 'https://s.abcnews.com/images/Business/181130_nwo_marriott_data_breach_MIX_hpMain_16x9_992.jpg'),
(147, 8, 'WATCH:  Honda recalls 2018, 2019 Honda Odysseys', 'There are concerns the power sliding door can open while the car is moving; the automaker is offering a free fix.', 'https://abcnews.go.com/WNT/video/honda-recalls-2018-2019-honda-odysseys-59482596', '2018-11-29 00:56:58', 'https://s.abcnews.com/images/WNT/181128_wnt_index_honda_odyssey_recall_hpMain_16x9_992.jpg'),
(148, 8, 'WATCH:  What is the Fed?', 'The Federal Reserve System is the central bank of the U.S.', 'https://abcnews.go.com/Business/video/fed--59481101', '2018-11-28 23:16:15', 'https://s.abcnews.com/images/Business/181128_vod_orig_fed_hpMain_16x9_992.jpg'),
(149, 8, 'WATCH:  Has your boss ever taken your idea? Here are tips to survive the work bandit', 'Michael Strahan and Sara Haines have everything you need to know this afternoon.', 'https://abcnews.go.com/GMA/GMA_Day/video/boss-idea-tips-survive-work-bandit-59472779', '2018-11-28 19:56:27', 'https://s.abcnews.com/images/GMA/181128_gmaday_blka_work2_107_hpMain_16x9_992.jpg'),
(150, 8, 'WATCH:  GM workers seek answers amid shutdown plans', 'ABC News\' Eva Pilgrim spoke with GM employees, some of whom blame the president for the planned layoffs.', 'https://abcnews.go.com/GMA/News/video/general-motors-workers-seek-answers-amid-shutdown-plans-59465158', '2018-11-28 14:51:31', 'https://s.abcnews.com/images/GMA/181128_gma_pilgrim_0705_hpMain_16x9_992.jpg'),
(151, 8, 'WATCH:  GM workers respond to news of shutdown: \'Everyone is scared\'', 'President Trump lashed out at the U.S. automaker for eliminating nearly 15,000 jobs but GM said the move was forced by consumer demand.', 'https://abcnews.go.com/WNT/video/gm-workers-respond-news-shutdown-scared-59454214', '2018-11-28 01:09:43', 'https://s.abcnews.com/images/WNT/181127_wn_pilgrim4_hpMain_16x9_992.jpg'),
(152, 8, ' Head of India\'s central bank resigns amid government split', 'The head of India\'s central bank has resigned amid a growing split between the Indian government and the independent monetary authority', 'https://abcnews.go.com/Business/wireStory/head-indias-central-bank-resigns-amid-government-split-59723329', '2018-12-10 12:53:00', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(153, 8, ' Ghosn, Kelly, Nissan charged with underreporting pay', 'Charges allege Ghosn\'s pay was underreported by 5 billion yen ($44 million).', 'https://abcnews.go.com/Business/wireStory/reports-ghosn-kelly-nissan-charged-underreported-pay-59720357', '2018-12-10 12:48:04', 'https://s.abcnews.com/images/Business/WireAP_098d1b78ec1c46ec83b8950ebd4698e0_16x9_992.jpg'),
(154, 8, ' World stocks slip on China-US tensions, Brexit uncertainty', 'World stocks are down as tensions between the U.S. and China over the arrest of a senior telecoms executive raise concerns about talks on global trade', 'https://abcnews.go.com/Business/wireStory/asian-shares-fall-huawei-arrest-imperils-china-us-59720496', '2018-12-10 12:29:19', 'https://s.abcnews.com/images/Business/WireAP_3bdfb9aa8d774bd98b082dfb7c621764_16x9_992.jpg'),
(155, 8, ' Travel software company Travelport targeted in $4.4B deal', 'Travel software company Travelport to go private in $4.4 billion agreement with buyout firms', 'https://abcnews.go.com/Business/wireStory/travel-software-company-travelport-targeted-44b-deal-59722437', '2018-12-10 11:59:45', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(156, 8, ' The Latest: PM Abe says Japan-French ties unshakable', 'Abe says Japan-French ties unshakeable despite Nissan scandal', 'https://abcnews.go.com/Business/wireStory/latest-reports-detention-ghosn-extended-59720498', '2018-12-10 10:53:18', 'https://s.abcnews.com/images/Business/WireAP_098d1b78ec1c46ec83b8950ebd4698e0_16x9_992.jpg'),
(157, 8, ' China pressures US, Canada ahead of Huawei hearing', 'China ups pressure on US, Canada for release of top Chinese technology executive', 'https://abcnews.go.com/Business/wireStory/china-pressures-us-canada-ahead-huawei-hearing-59720497', '2018-12-10 10:38:04', 'https://s.abcnews.com/images/Business/WireAP_576b7d5019964bd8a16150d343c9da1e_16x9_992.jpg'),
(158, 8, ' SoftBank\'s mobile unit\'s share price set for Dec. 19 IPO', 'SoftBank Group Corp. mobile unit IPO price set at 1,500 yen ($13) a share', 'https://abcnews.go.com/Business/wireStory/softbanks-mobile-units-share-price-set-dec-19-59721383', '2018-12-10 10:30:27', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(159, 8, ' Tokyo prosecutors say Nissan ex-chairman Carlos Ghosn, automaker and 2nd executive charged with underreporting pay', 'Tokyo prosecutors say Nissan ex-chairman Carlos Ghosn, automaker and 2nd executive charged with underreporting pay', 'https://abcnews.go.com/Business/wireStory/tokyo-prosecutors-nissan-chairman-carlos-ghosn-automaker-2nd-59720533', '2018-12-10 07:19:44', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(160, 9, ' Lakers trying to add Suns\' Trevor Ariza in three-way trade', 'The         Los Angeles Lakers are engaged in talks to try to acquire         Phoenix Suns forward         Trevor Ariza, league sources told ESPN.     The teams have been working to reach an agreement with a third team that would take on Lakers guard         Kentavious Caldwell-Pope as part of a potentially larger deal, league sources said.     The Suns want to land a playmaking guard and a draft asset as the price of unloading Ariza, sources said. Phoenix and Los Angeles have made progress in third-team scenarios, although no agreements are close and both teams remain active in multiple trade discussions throughout the league, sources said.     No trade can be completed officially until Saturday, when players who, like Ariza, were signed in summer free agency become eligible to be traded.     Ariza is one of the most important trade assets for the Suns -- losers of 22 of 26 games -- and their best chance to bolster their backcourt and gain assets. Most contending teams are...', 'https://abcnews.go.com/Sports/lakers-add-suns-trevor-ariza-trade/story?id=59717784', '2018-12-10 02:06:38', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(161, 9, ' Warriors named Sports Illustrated\'s Sportsperson of Year', 'The three-time NBA champion Golden State Warriors are the fourth team that has been honored as Sports Illustrated\'s Sportsperson of the Year', 'https://abcnews.go.com/Sports/wireStory/warriors-named-sports-illustrateds-sportsperson-year-59722438', '2018-12-10 12:04:51', 'https://s.abcnews.com/images/Sports/WireAP_2b45ba9a67284e33b0bde167d89bbf6c_16x9_992.jpg'),
(162, 9, ' Goldman, dominant defense leads Bears over Rams 15-6', 'Eddie Goldman led a dominant effort by the defense, and the Chicago Bears shut down Jared Goff and Los Angeles\' high-powered offense in a 15-6 victory over the NFC West champion Rams on Sunday night', 'https://abcnews.go.com/Sports/wireStory/goldman-dominant-defense-leads-bears-rams-15-59719565', '2018-12-10 06:25:19', 'https://s.abcnews.com/images/Sports/WireAP_68304713fea14ee79cd85203abb1e7b3_16x9_992.jpg'),
(163, 9, ' Drake Escape: Miami\'s score on final play beats Pats 34-33', 'Kenyan Drake ran the last 52 yards as the Miami Dolphins scored on a pass and double lateral on the final play to beat the New England Patriots 34-33', 'https://abcnews.go.com/Sports/wireStory/drake-scores-wild-final-play-miami-beats-pats-59714662', '2018-12-10 03:32:17', 'https://s.abcnews.com/images/Sports/WireAP_eb1dce67724c4c128be0cf2fb2f08e5a_16x9_992.jpg'),
(164, 9, ' Column: Across USA, cheers. In New England, shocked silence', 'Column: Across USA, cheers. In New England, shocked silence', 'https://abcnews.go.com/Sports/wireStory/column-usa-cheers-england-shocked-silence-59720871', '2018-12-10 08:09:02', 'https://s.abcnews.com/images/Sports/WireAP_62b3b50955234b9b815b39445feafbf5_16x9_992.jpg'),
(165, 9, ' Prescott\'s 3rd TD to Cooper lifts Cowboys over Eagles in OT', 'Dak Prescott\'s third TD toss to Amari Cooper lifts Cowboys to 29-23 overtime win over Eagles, control of NFC East', 'https://abcnews.go.com/Sports/wireStory/prescotts-3rd-td-cooper-lifts-cowboys-eagles-ot-59718300', '2018-12-10 02:41:29', 'https://s.abcnews.com/images/Sports/WireAP_e79b9196fb0944619707291bea66ed70_16x9_992.jpg'),
(166, 9, ' Butker\'s OT field goal lifts Chiefs past Ravens, 27-24', 'Harrison Butker atoned for a 43-yard miss as time expired with a 36-yard field goal in overtime to give the Chiefs a 27-24 victory over the Ravens and clinch a playoff spot', 'https://abcnews.go.com/Sports/wireStory/butkers-ot-field-goal-lifts-chiefs-past-ravens-59715374', '2018-12-10 03:42:01', 'https://s.abcnews.com/images/Sports/WireAP_3c7adc5dffde44aab08e185a5e83f1dd_16x9_992.jpg'),
(167, 9, ' Baines surprised by Hall of Fame election _ many others, too', 'The election of Harold Baines to the Hall of Fame shocked him and many others in the baseball world, too', 'https://abcnews.go.com/Sports/wireStory/baines-surprised-hall-fame-election-59720939', '2018-12-10 08:11:48', 'https://s.abcnews.com/images/Sports/WireAP_223def1aa41149379452c7cd11dcd84d_16x9_992.jpg'),
(168, 9, ' Raptors go west, Kawhi back to Oracle where so much changed', 'So much changed for Kawhi Leonard and the Spurs last time he played at Golden State', 'https://abcnews.go.com/Sports/wireStory/raptors-west-kawhi-back-oracle-changed-59721006', '2018-12-10 12:10:31', 'https://s.abcnews.com/images/Sports/WireAP_1741dc3953704a31b112174c5fa8c7c3_16x9_992.jpg'),
(169, 9, ' Schofield\'s 3 lifts No. 7 Tennessee over No. 1 Gonzaga 76-73', 'Admiral Schofield hit a 3-pointer with 24 seconds left and scored 25 of his 30 points in the second half, helping No. 7 Tennessee knock off top-ranked Gonzaga 76-73 in the Colangelo Classic', 'https://abcnews.go.com/Sports/wireStory/schofields-lifts-tennessee-gonzaga-76-73-59715866', '2018-12-09 23:03:34', 'https://s.abcnews.com/images/Sports/WireAP_670c3f67e9f3457d859bffdff3ab6e52_16x9_992.jpg'),
(170, 9, ' Oregon\'s No. 3 ranking to dip after loss at Michigan State', 'Kelly Graves thought his Oregon Ducks hadn\'t really done anything to deserve the No. 3 ranking in the AP Top 25 _ the school\'s best ever', 'https://abcnews.go.com/Sports/wireStory/oregons-ranking-dip-loss-michigan-state-59721040', '2018-12-10 08:16:25', 'https://s.abcnews.com/images/Sports/WireAP_e4cab61807564d239d25747e24ea4392_16x9_992.jpg'),
(171, 9, ' National Football League (NFL)', '', 'http://abcnews.go.com/topics/sports/nfl.htm', '2013-11-26 16:47:40', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(172, 9, ' Major League Baseball (MLB)', '', 'http://abcnews.go.com/topics/sports/mlb.htm', '2013-11-26 16:48:16', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(173, 9, ' National Basketball Association (NBA)', '', 'http://abcnews.go.com/topics/sports/nba.htm', '2013-11-26 16:48:54', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(174, 9, ' National Hockey League (NHL)', '', 'http://abcnews.go.com/topics/sports/nhl.htm', '2013-11-26 16:49:31', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(175, 9, ' NCAA College Football', '', 'http://abcnews.go.com/topics/sports/ncaa-football.htm', '2013-11-26 16:50:43', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(176, 9, ' NCAA College Basketball', '', 'http://abcnews.go.com/topics/sports/ncaa-basketball.htm', '2013-11-26 16:51:23', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(177, 10, ' Lakers trying to add Suns\' Trevor Ariza in three-way trade', 'The         Los Angeles Lakers are engaged in talks to try to acquire         Phoenix Suns forward         Trevor Ariza, league sources told ESPN.     The teams have been working to reach an agreement with a third team that would take on Lakers guard         Kentavious Caldwell-Pope as part of a potentially larger deal, league sources said.     The Suns want to land a playmaking guard and a draft asset as the price of unloading Ariza, sources said. Phoenix and Los Angeles have made progress in third-team scenarios, although no agreements are close and both teams remain active in multiple trade discussions throughout the league, sources said.     No trade can be completed officially until Saturday, when players who, like Ariza, were signed in summer free agency become eligible to be traded.     Ariza is one of the most important trade assets for the Suns -- losers of 22 of 26 games -- and their best chance to bolster their backcourt and gain assets. Most contending teams are...', 'https://abcnews.go.com/Sports/lakers-add-suns-trevor-ariza-trade/story?id=59717784', '2018-12-10 02:06:38', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(178, 10, ' Warriors named Sports Illustrated\'s Sportsperson of Year', 'The three-time NBA champion Golden State Warriors are the fourth team that has been honored as Sports Illustrated\'s Sportsperson of the Year', 'https://abcnews.go.com/Sports/wireStory/warriors-named-sports-illustrateds-sportsperson-year-59722438', '2018-12-10 12:04:51', 'https://s.abcnews.com/images/Sports/WireAP_2b45ba9a67284e33b0bde167d89bbf6c_16x9_992.jpg'),
(179, 10, ' Goldman, dominant defense leads Bears over Rams 15-6', 'Eddie Goldman led a dominant effort by the defense, and the Chicago Bears shut down Jared Goff and Los Angeles\' high-powered offense in a 15-6 victory over the NFC West champion Rams on Sunday night', 'https://abcnews.go.com/Sports/wireStory/goldman-dominant-defense-leads-bears-rams-15-59719565', '2018-12-10 06:25:19', 'https://s.abcnews.com/images/Sports/WireAP_68304713fea14ee79cd85203abb1e7b3_16x9_992.jpg'),
(180, 10, ' Drake Escape: Miami\'s score on final play beats Pats 34-33', 'Kenyan Drake ran the last 52 yards as the Miami Dolphins scored on a pass and double lateral on the final play to beat the New England Patriots 34-33', 'https://abcnews.go.com/Sports/wireStory/drake-scores-wild-final-play-miami-beats-pats-59714662', '2018-12-10 03:32:17', 'https://s.abcnews.com/images/Sports/WireAP_eb1dce67724c4c128be0cf2fb2f08e5a_16x9_992.jpg'),
(181, 10, ' Column: Across USA, cheers. In New England, shocked silence', 'Column: Across USA, cheers. In New England, shocked silence', 'https://abcnews.go.com/Sports/wireStory/column-usa-cheers-england-shocked-silence-59720871', '2018-12-10 08:09:02', 'https://s.abcnews.com/images/Sports/WireAP_62b3b50955234b9b815b39445feafbf5_16x9_992.jpg'),
(182, 10, ' Prescott\'s 3rd TD to Cooper lifts Cowboys over Eagles in OT', 'Dak Prescott\'s third TD toss to Amari Cooper lifts Cowboys to 29-23 overtime win over Eagles, control of NFC East', 'https://abcnews.go.com/Sports/wireStory/prescotts-3rd-td-cooper-lifts-cowboys-eagles-ot-59718300', '2018-12-10 02:41:29', 'https://s.abcnews.com/images/Sports/WireAP_e79b9196fb0944619707291bea66ed70_16x9_992.jpg'),
(183, 10, ' Butker\'s OT field goal lifts Chiefs past Ravens, 27-24', 'Harrison Butker atoned for a 43-yard miss as time expired with a 36-yard field goal in overtime to give the Chiefs a 27-24 victory over the Ravens and clinch a playoff spot', 'https://abcnews.go.com/Sports/wireStory/butkers-ot-field-goal-lifts-chiefs-past-ravens-59715374', '2018-12-10 03:42:01', 'https://s.abcnews.com/images/Sports/WireAP_3c7adc5dffde44aab08e185a5e83f1dd_16x9_992.jpg'),
(184, 10, ' Baines surprised by Hall of Fame election _ many others, too', 'The election of Harold Baines to the Hall of Fame shocked him and many others in the baseball world, too', 'https://abcnews.go.com/Sports/wireStory/baines-surprised-hall-fame-election-59720939', '2018-12-10 08:11:48', 'https://s.abcnews.com/images/Sports/WireAP_223def1aa41149379452c7cd11dcd84d_16x9_992.jpg'),
(185, 10, ' Raptors go west, Kawhi back to Oracle where so much changed', 'So much changed for Kawhi Leonard and the Spurs last time he played at Golden State', 'https://abcnews.go.com/Sports/wireStory/raptors-west-kawhi-back-oracle-changed-59721006', '2018-12-10 12:10:31', 'https://s.abcnews.com/images/Sports/WireAP_1741dc3953704a31b112174c5fa8c7c3_16x9_992.jpg'),
(186, 10, ' Schofield\'s 3 lifts No. 7 Tennessee over No. 1 Gonzaga 76-73', 'Admiral Schofield hit a 3-pointer with 24 seconds left and scored 25 of his 30 points in the second half, helping No. 7 Tennessee knock off top-ranked Gonzaga 76-73 in the Colangelo Classic', 'https://abcnews.go.com/Sports/wireStory/schofields-lifts-tennessee-gonzaga-76-73-59715866', '2018-12-09 23:03:34', 'https://s.abcnews.com/images/Sports/WireAP_670c3f67e9f3457d859bffdff3ab6e52_16x9_992.jpg'),
(187, 10, ' Oregon\'s No. 3 ranking to dip after loss at Michigan State', 'Kelly Graves thought his Oregon Ducks hadn\'t really done anything to deserve the No. 3 ranking in the AP Top 25 _ the school\'s best ever', 'https://abcnews.go.com/Sports/wireStory/oregons-ranking-dip-loss-michigan-state-59721040', '2018-12-10 08:16:25', 'https://s.abcnews.com/images/Sports/WireAP_e4cab61807564d239d25747e24ea4392_16x9_992.jpg'),
(188, 10, ' National Football League (NFL)', '', 'http://abcnews.go.com/topics/sports/nfl.htm', '2013-11-26 16:47:40', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(189, 10, ' Major League Baseball (MLB)', '', 'http://abcnews.go.com/topics/sports/mlb.htm', '2013-11-26 16:48:16', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(190, 10, ' National Basketball Association (NBA)', '', 'http://abcnews.go.com/topics/sports/nba.htm', '2013-11-26 16:48:54', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(191, 10, ' National Hockey League (NHL)', '', 'http://abcnews.go.com/topics/sports/nhl.htm', '2013-11-26 16:49:31', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(192, 10, ' NCAA College Football', '', 'http://abcnews.go.com/topics/sports/ncaa-football.htm', '2013-11-26 16:50:43', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(193, 10, ' NCAA College Basketball', '', 'http://abcnews.go.com/topics/sports/ncaa-basketball.htm', '2013-11-26 16:51:23', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(194, 11, ' Lakers trying to add Suns\' Trevor Ariza in three-way trade', 'The         Los Angeles Lakers are engaged in talks to try to acquire         Phoenix Suns forward         Trevor Ariza, league sources told ESPN.     The teams have been working to reach an agreement with a third team that would take on Lakers guard         Kentavious Caldwell-Pope as part of a potentially larger deal, league sources said.     The Suns want to land a playmaking guard and a draft asset as the price of unloading Ariza, sources said. Phoenix and Los Angeles have made progress in third-team scenarios, although no agreements are close and both teams remain active in multiple trade discussions throughout the league, sources said.     No trade can be completed officially until Saturday, when players who, like Ariza, were signed in summer free agency become eligible to be traded.     Ariza is one of the most important trade assets for the Suns -- losers of 22 of 26 games -- and their best chance to bolster their backcourt and gain assets. Most contending teams are...', 'https://abcnews.go.com/Sports/lakers-add-suns-trevor-ariza-trade/story?id=59717784', '2018-12-10 02:06:38', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(195, 11, ' Warriors named Sports Illustrated\'s Sportsperson of Year', 'The three-time NBA champion Golden State Warriors are the fourth team that has been honored as Sports Illustrated\'s Sportsperson of the Year', 'https://abcnews.go.com/Sports/wireStory/warriors-named-sports-illustrateds-sportsperson-year-59722438', '2018-12-10 12:04:51', 'https://s.abcnews.com/images/Sports/WireAP_2b45ba9a67284e33b0bde167d89bbf6c_16x9_992.jpg'),
(196, 11, ' Goldman, dominant defense leads Bears over Rams 15-6', 'Eddie Goldman led a dominant effort by the defense, and the Chicago Bears shut down Jared Goff and Los Angeles\' high-powered offense in a 15-6 victory over the NFC West champion Rams on Sunday night', 'https://abcnews.go.com/Sports/wireStory/goldman-dominant-defense-leads-bears-rams-15-59719565', '2018-12-10 06:25:19', 'https://s.abcnews.com/images/Sports/WireAP_68304713fea14ee79cd85203abb1e7b3_16x9_992.jpg'),
(197, 11, ' Drake Escape: Miami\'s score on final play beats Pats 34-33', 'Kenyan Drake ran the last 52 yards as the Miami Dolphins scored on a pass and double lateral on the final play to beat the New England Patriots 34-33', 'https://abcnews.go.com/Sports/wireStory/drake-scores-wild-final-play-miami-beats-pats-59714662', '2018-12-10 03:32:17', 'https://s.abcnews.com/images/Sports/WireAP_eb1dce67724c4c128be0cf2fb2f08e5a_16x9_992.jpg'),
(198, 11, ' Column: Across USA, cheers. In New England, shocked silence', 'Column: Across USA, cheers. In New England, shocked silence', 'https://abcnews.go.com/Sports/wireStory/column-usa-cheers-england-shocked-silence-59720871', '2018-12-10 08:09:02', 'https://s.abcnews.com/images/Sports/WireAP_62b3b50955234b9b815b39445feafbf5_16x9_992.jpg'),
(199, 11, ' Prescott\'s 3rd TD to Cooper lifts Cowboys over Eagles in OT', 'Dak Prescott\'s third TD toss to Amari Cooper lifts Cowboys to 29-23 overtime win over Eagles, control of NFC East', 'https://abcnews.go.com/Sports/wireStory/prescotts-3rd-td-cooper-lifts-cowboys-eagles-ot-59718300', '2018-12-10 02:41:29', 'https://s.abcnews.com/images/Sports/WireAP_e79b9196fb0944619707291bea66ed70_16x9_992.jpg'),
(200, 11, ' Butker\'s OT field goal lifts Chiefs past Ravens, 27-24', 'Harrison Butker atoned for a 43-yard miss as time expired with a 36-yard field goal in overtime to give the Chiefs a 27-24 victory over the Ravens and clinch a playoff spot', 'https://abcnews.go.com/Sports/wireStory/butkers-ot-field-goal-lifts-chiefs-past-ravens-59715374', '2018-12-10 03:42:01', 'https://s.abcnews.com/images/Sports/WireAP_3c7adc5dffde44aab08e185a5e83f1dd_16x9_992.jpg'),
(201, 11, ' Baines surprised by Hall of Fame election _ many others, too', 'The election of Harold Baines to the Hall of Fame shocked him and many others in the baseball world, too', 'https://abcnews.go.com/Sports/wireStory/baines-surprised-hall-fame-election-59720939', '2018-12-10 08:11:48', 'https://s.abcnews.com/images/Sports/WireAP_223def1aa41149379452c7cd11dcd84d_16x9_992.jpg'),
(202, 11, ' Raptors go west, Kawhi back to Oracle where so much changed', 'So much changed for Kawhi Leonard and the Spurs last time he played at Golden State', 'https://abcnews.go.com/Sports/wireStory/raptors-west-kawhi-back-oracle-changed-59721006', '2018-12-10 12:10:31', 'https://s.abcnews.com/images/Sports/WireAP_1741dc3953704a31b112174c5fa8c7c3_16x9_992.jpg'),
(203, 11, ' Schofield\'s 3 lifts No. 7 Tennessee over No. 1 Gonzaga 76-73', 'Admiral Schofield hit a 3-pointer with 24 seconds left and scored 25 of his 30 points in the second half, helping No. 7 Tennessee knock off top-ranked Gonzaga 76-73 in the Colangelo Classic', 'https://abcnews.go.com/Sports/wireStory/schofields-lifts-tennessee-gonzaga-76-73-59715866', '2018-12-09 23:03:34', 'https://s.abcnews.com/images/Sports/WireAP_670c3f67e9f3457d859bffdff3ab6e52_16x9_992.jpg'),
(204, 11, ' Oregon\'s No. 3 ranking to dip after loss at Michigan State', 'Kelly Graves thought his Oregon Ducks hadn\'t really done anything to deserve the No. 3 ranking in the AP Top 25 _ the school\'s best ever', 'https://abcnews.go.com/Sports/wireStory/oregons-ranking-dip-loss-michigan-state-59721040', '2018-12-10 08:16:25', 'https://s.abcnews.com/images/Sports/WireAP_e4cab61807564d239d25747e24ea4392_16x9_992.jpg'),
(205, 11, ' National Football League (NFL)', '', 'http://abcnews.go.com/topics/sports/nfl.htm', '2013-11-26 16:47:40', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(206, 11, ' Major League Baseball (MLB)', '', 'http://abcnews.go.com/topics/sports/mlb.htm', '2013-11-26 16:48:16', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(207, 11, ' National Basketball Association (NBA)', '', 'http://abcnews.go.com/topics/sports/nba.htm', '2013-11-26 16:48:54', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(208, 11, ' National Hockey League (NHL)', '', 'http://abcnews.go.com/topics/sports/nhl.htm', '2013-11-26 16:49:31', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(209, 11, ' NCAA College Football', '', 'http://abcnews.go.com/topics/sports/ncaa-football.htm', '2013-11-26 16:50:43', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg'),
(210, 11, ' NCAA College Basketball', '', 'http://abcnews.go.com/topics/sports/ncaa-basketball.htm', '2013-11-26 16:51:23', 'https://s.abcnews.com/images/US/abc_news_default_2000x2000_update_16x9_992.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `previous_organization`
--

CREATE TABLE `previous_organization` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `organization_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `designation` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `previous_organization`
--

INSERT INTO `previous_organization` (`id`, `member_id`, `organization_name`, `designation`) VALUES
(22, 109, 'Reliance Industries', 'Chief Legal Officer'),
(23, 107, 'HDFC Bank', 'Chief Executive Officer'),
(24, 110, 'Tata Motors', 'Chief Legal Officer'),
(37, 149, 'Receive-and-deliver clerk', 'Library media aide'),
(38, 155, 'Life Map', 'Doctor'),
(39, 156, 'Source Club', 'Library media aide'),
(40, 157, 'Starship Tapes & Records', 'Library media aide'),
(41, 158, 'Source Club', 'Library media aide'),
(42, 162, 'Source Club', 'Library media aide'),
(43, 164, 'Receive-and-deliver clerk', 'Library media aide'),
(44, 164, 'Reliance Industries', 'Chief Legal Officer'),
(45, 163, 'HDFC Bank', 'Chief Executive Officer'),
(46, 162, 'Tata Motors', 'Chief Legal Officer'),
(47, 149, 'Receive-and-deliver clerk', 'Library media aide'),
(48, 160, 'Life Map', 'Doctor'),
(49, 161, 'Source Club', 'Library media aide'),
(50, 160, 'Receive-and-deliver clerk', 'Library media aide'),
(51, 159, 'Organization Test', 'Automotive glass installer'),
(52, 158, 'Source Club', 'Library media aide'),
(53, 158, 'Reliance Industries', 'Chief Legal Officer'),
(54, 157, 'HDFC Bank', 'Chief Executive Officer'),
(55, 156, 'Tata Motors', 'Chief Legal Officer'),
(56, 155, 'Receive-and-deliver clerk', 'Library media aide'),
(57, 155, 'Life Map', 'Doctor'),
(58, 154, 'Source Club', 'Library media aide'),
(59, 153, 'Receive-and-deliver clerk', 'Library media aide'),
(60, 158, 'Source Club', 'Library media aide'),
(61, 162, 'Source Club', 'Library media aide'),
(62, 152, 'Receive-and-deliver clerk', 'Library media aide'),
(63, 151, 'Reliance Industries', 'Chief Legal Officer'),
(64, 163, 'HDFC Bank', 'Chief Executive Officer'),
(65, 150, 'Tata Motors', 'Chief Legal Officer'),
(66, 150, 'Receive-and-deliver clerk', 'Library media aide'),
(67, 160, 'Life Map', 'Doctor'),
(69, 114, 'Receive-and-deliver clerk', 'Library media aide'),
(70, 164, 'Organization Test', 'Occupation tet'),
(71, 155, 'Source Club', 'Library media aide'),
(72, 165, 'Source Club', 'Library media aide'),
(73, 166, 'Waccamaw', 'Uniformed police officer'),
(75, 166, 'Source Club', 'Library media aide'),
(76, 167, 'Receive-and-deliver clerk', 'Library media aide'),
(77, 168, 'Furrow', 'Food technologist'),
(78, 169, 'Receive-and-deliver clerk', 'Library media aide'),
(79, 170, 'Receive-and-deliver clerk', 'Food technologist'),
(80, 171, 'Receive-and-deliver clerk', 'Library media aide'),
(81, 172, 'Receive-and-deliver clerk', 'Library media aide'),
(82, 173, 'Receive-and-deliver clerk', 'Food technologist'),
(83, 174, 'Furrow', 'Food technologist'),
(84, 175, 'Waccamaw', 'Uniformed police officer'),
(85, 176, 'Source Club', 'Library media aide'),
(86, 177, 'Receive-and-deliver clerk', 'Library media aide'),
(87, 178, 'organizations', 'occupations'),
(88, 113, 'Source Club', 'Library media aide'),
(89, 113, 'Receive-and-deliver clerk', 'Library media aide'),
(90, 113, 'organizations', 'occupations'),
(92, 184, 'o1', 'oocc1');

-- --------------------------------------------------------

--
-- Table structure for table `vender_category`
--

CREATE TABLE `vender_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vender_category`
--

INSERT INTO `vender_category` (`id`, `name`, `created_at`) VALUES
(1, 'Barbecue', '2018-11-21 05:09:41'),
(2, 'Brasserie and bistro', '2018-11-21 05:09:41'),
(3, 'Buffet and smörgåsbord', '2018-11-21 05:09:59'),
(4, 'Cafe', '2018-11-21 05:09:59'),
(5, 'Cafeteria', '2018-11-21 05:10:21'),
(6, 'Coffee House', '2018-11-21 05:10:21'),
(7, 'Destination restaurant', '2018-11-21 05:10:42'),
(8, 'Greasy spoon', '2018-11-21 05:10:42'),
(9, 'Tabletop cooking', '2018-11-21 05:11:10'),
(10, 'Mongolian barbecue', '2018-11-21 05:11:10'),
(11, 'Pub', '2018-11-21 05:11:33'),
(12, '	Teppanyaki-style', '2018-11-21 05:11:33');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_partners`
--

CREATE TABLE `vendor_partners` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `lat` varchar(100) NOT NULL,
  `lang` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vendor_partners`
--

INSERT INTO `vendor_partners` (`id`, `name`, `address`, `lat`, `lang`, `mobile`, `email`, `category_id`, `created_date`) VALUES
(11, 'Lam\'ah Zaynab Essa', 'Dubai - United Arab Emirates', '25.2048493', '55.270782800000006', '97121236547', 'LamahZaynabEssa@jourrapide.com', 6, '2018-12-06 05:26:16'),
(12, 'Muhyi al Din Nasih Naifeh', 'Dubai - United Arab Emirates', '25.2048493', '55.270782800000006', '8432532114', 'MuhyialDinNasihNaifeh@dayrep.com', 1, '2018-11-21 14:31:23'),
(14, 'Majid al Din \'Ajib Shamoun', 'Denver, CO, USA', '39.7392358', '-104.990251', '7489563948', 'MajidalDinAjibShamoun@rhyta.com', 10, '2018-11-22 06:58:22');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_partner_vouchers`
--

CREATE TABLE `vendor_partner_vouchers` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `voucher_code` varchar(100) NOT NULL,
  `voucher_type` int(1) NOT NULL COMMENT '0- flat, 1 - perc',
  `voucher_amount` varchar(11) NOT NULL,
  `voucher_description` text NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vendor_partner_vouchers`
--

INSERT INTO `vendor_partner_vouchers` (`id`, `vendor_id`, `voucher_code`, `voucher_type`, `voucher_amount`, `voucher_description`, `created_date`) VALUES
(9, 12, 'Sunday60', 0, '60', 'Upgrade your Mailinator account to get privacy, storage, your own private domain, and API access!', '2018-11-21 13:34:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `advertise`
--
ALTER TABLE `advertise`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `analytics`
--
ALTER TABLE `analytics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_settings`
--
ALTER TABLE `app_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `authorization`
--
ALTER TABLE `authorization`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `hashtag`
--
ALTER TABLE `hashtag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `industry`
--
ALTER TABLE `industry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keys`
--
ALTER TABLE `keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `looking_for`
--
ALTER TABLE `looking_for`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meeting_preferences`
--
ALTER TABLE `meeting_preferences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member_extrainfo`
--
ALTER TABLE `member_extrainfo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `member_goal`
--
ALTER TABLE `member_goal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `lookingfor_id` (`lookingfor_id`);

--
-- Indexes for table `member_industry`
--
ALTER TABLE `member_industry`
  ADD PRIMARY KEY (`id`),
  ADD KEY `industry_id` (`industry_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `member_interests`
--
ALTER TABLE `member_interests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `hashtag_id` (`hashtag_id`);

--
-- Indexes for table `member_meeting_preferences`
--
ALTER TABLE `member_meeting_preferences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `meeting_preference_id` (`meeting_preference_id`);

--
-- Indexes for table `newsfeed`
--
ALTER TABLE `newsfeed`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hashtag_id` (`hashtag_id`);

--
-- Indexes for table `previous_organization`
--
ALTER TABLE `previous_organization`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `vender_category`
--
ALTER TABLE `vender_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor_partners`
--
ALTER TABLE `vendor_partners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor_partner_vouchers`
--
ALTER TABLE `vendor_partner_vouchers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `advertise`
--
ALTER TABLE `advertise`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `analytics`
--
ALTER TABLE `analytics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_settings`
--
ALTER TABLE `app_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `authorization`
--
ALTER TABLE `authorization`
  MODIFY `Id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=253;

--
-- AUTO_INCREMENT for table `education`
--
ALTER TABLE `education`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `hashtag`
--
ALTER TABLE `hashtag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `industry`
--
ALTER TABLE `industry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `keys`
--
ALTER TABLE `keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `looking_for`
--
ALTER TABLE `looking_for`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `meeting_preferences`
--
ALTER TABLE `meeting_preferences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT for table `member_extrainfo`
--
ALTER TABLE `member_extrainfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=177;

--
-- AUTO_INCREMENT for table `member_goal`
--
ALTER TABLE `member_goal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=302;

--
-- AUTO_INCREMENT for table `member_industry`
--
ALTER TABLE `member_industry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=310;

--
-- AUTO_INCREMENT for table `member_interests`
--
ALTER TABLE `member_interests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=706;

--
-- AUTO_INCREMENT for table `member_meeting_preferences`
--
ALTER TABLE `member_meeting_preferences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=489;

--
-- AUTO_INCREMENT for table `newsfeed`
--
ALTER TABLE `newsfeed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=211;

--
-- AUTO_INCREMENT for table `previous_organization`
--
ALTER TABLE `previous_organization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `vender_category`
--
ALTER TABLE `vender_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `vendor_partners`
--
ALTER TABLE `vendor_partners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `vendor_partner_vouchers`
--
ALTER TABLE `vendor_partner_vouchers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `education`
--
ALTER TABLE `education`
  ADD CONSTRAINT `delete_education` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `member_extrainfo`
--
ALTER TABLE `member_extrainfo`
  ADD CONSTRAINT `delete_member_extrainfo` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `member_goal`
--
ALTER TABLE `member_goal`
  ADD CONSTRAINT `delete_member_goal` FOREIGN KEY (`lookingfor_id`) REFERENCES `looking_for` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `delete_user_member_goal` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `member_industry`
--
ALTER TABLE `member_industry`
  ADD CONSTRAINT `delete_member_industry` FOREIGN KEY (`industry_id`) REFERENCES `industry` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `delete_user_member_industry` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `member_interests`
--
ALTER TABLE `member_interests`
  ADD CONSTRAINT `delete_member_interests` FOREIGN KEY (`hashtag_id`) REFERENCES `hashtag` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `delete_user_member_interests` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `member_meeting_preferences`
--
ALTER TABLE `member_meeting_preferences`
  ADD CONSTRAINT `delete_user_meeting_preferences` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `newsfeed`
--
ALTER TABLE `newsfeed`
  ADD CONSTRAINT `delete_newsfeed` FOREIGN KEY (`hashtag_id`) REFERENCES `hashtag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `previous_organization`
--
ALTER TABLE `previous_organization`
  ADD CONSTRAINT `delete_previous_organization` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vendor_partner_vouchers`
--
ALTER TABLE `vendor_partner_vouchers`
  ADD CONSTRAINT `delete_vouchers` FOREIGN KEY (`vendor_id`) REFERENCES `vendor_partners` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
