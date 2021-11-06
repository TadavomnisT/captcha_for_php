-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 27, 2021 at 08:02 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `captcha`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(30) COLLATE utf8_persian_ci NOT NULL,
  `password` varchar(32) COLLATE utf8_persian_ci NOT NULL,
  `firstname` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `lastname` varchar(50) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `firstname`, `lastname`) VALUES
(1, 'admin', '827ccb0eea8a706c4c34a16891f84e7b', 'Behrad', 'Babaei');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `captcha_type` tinyint(4) NOT NULL,
  `selected_table` varchar(20) COLLATE utf8_persian_ci NOT NULL,
  `table_list` text COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`captcha_type`, `selected_table`, `table_list`) VALUES
(5, 'words1', '{\"words1\":\"100\"}');

-- --------------------------------------------------------

--
-- Table structure for table `words1`
--

CREATE TABLE `words1` (
  `id` int(11) NOT NULL,
  `word` varchar(10) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `words1`
--

INSERT INTO `words1` (`id`, `word`) VALUES
(1, 'خداوند'),
(2, 'توحید'),
(3, 'ایمان'),
(4, 'حقیقت'),
(5, 'پاکی'),
(6, 'تعالی'),
(7, 'گذشت'),
(8, 'عشق'),
(9, 'تنفر'),
(10, 'هوس'),
(11, 'خشم'),
(12, 'ترس'),
(13, 'کار'),
(14, 'طمع'),
(15, 'صبر'),
(16, 'امید'),
(17, 'حسرت'),
(18, 'دانش'),
(19, 'پشتکار'),
(20, 'غرور'),
(21, 'شانس'),
(22, 'شهرت'),
(23, 'لبخند'),
(24, 'حسادت'),
(25, 'تفاهم'),
(26, 'سلامتی'),
(27, 'اطمینان'),
(28, 'رفاقت'),
(29, 'راستی'),
(30, 'احترام'),
(31, 'آرامش'),
(32, 'حیات'),
(33, 'آغوش'),
(34, 'آینه'),
(35, 'ابد'),
(36, 'اجابت'),
(37, 'اشاره'),
(38, 'امتحان'),
(39, 'باده'),
(40, 'صبا'),
(41, 'امانت'),
(42, 'باران'),
(43, 'باغ'),
(44, 'بحر'),
(45, 'پرده'),
(46, 'پیمانه'),
(47, 'تسلیم'),
(48, 'تجلی'),
(49, 'توفیق'),
(50, 'توکل'),
(51, 'جان'),
(52, 'جذبه'),
(53, 'جرعه'),
(54, 'جلال'),
(55, 'جلوه'),
(56, 'جمال'),
(57, 'جهالت'),
(58, 'چراغ'),
(59, 'چشم'),
(60, 'جادو'),
(61, 'چهره'),
(62, 'حجاب'),
(63, 'حرم'),
(64, 'حریف'),
(65, 'حضور'),
(66, 'حق'),
(67, 'حقیقت'),
(68, 'حیرت'),
(69, 'حلقه'),
(70, 'خاطر'),
(71, 'خرقه'),
(72, 'خشوع'),
(73, 'خلوت'),
(74, 'درد'),
(75, 'خوف'),
(76, 'ذکر'),
(77, 'رباب'),
(78, 'رنج'),
(79, 'ریاضت'),
(80, 'زلف'),
(81, 'ساغر'),
(82, 'سالک'),
(83, 'ساقی'),
(84, 'سلوک'),
(85, 'شهود'),
(86, 'صنم'),
(87, 'طریقت'),
(88, 'عیش'),
(89, 'غفلت'),
(90, 'فقر'),
(91, 'قدح'),
(92, 'قناعت'),
(93, 'کشف'),
(94, 'گیسو'),
(95, 'محاسبه'),
(96, 'مقام'),
(97, 'مکاشفه'),
(98, 'نفس'),
(99, 'وقت'),
(100, 'هشیاری');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
