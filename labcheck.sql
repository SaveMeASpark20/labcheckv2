-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2023 at 04:18 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `labcheck`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_year`
--

CREATE TABLE `academic_year` (
  `school_year` varchar(20) NOT NULL,
  `semester` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `academic_year`
--

INSERT INTO `academic_year` (`school_year`, `semester`, `status`) VALUES
('2020-2021', 'First Semester', 0),
('2020-2021', 'Second Semester', 1),
('2021-2022', 'Second Semester', 1),
('2022-2023', 'First Semester', 1),
('2022-2023', 'Second Semester', 1),
('2023-2024', 'First Semester', 0),
('2024-2025', 'Second Semester', 0),
('2025-2026', 'First Semester', 0);

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `announcement_id` int(11) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `school_year` varchar(20) NOT NULL,
  `semester` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`announcement_id`, `user_id`, `name`, `subject`, `description`, `created_at`, `school_year`, `semester`) VALUES
(1, '20-22-5526', 'christian alemania leguiz', 'announcement test 1', 'this only test noob only pls understand me', '2023-10-12 07:01:36', '2023-2024', 'First Semester'),
(2, '20-22-5526', 'christian alemania leguiz', 'announcement test 1', 'test 1', '2023-10-12 07:01:36', '2023-2024', 'First Semester'),
(3, '20-22-5526', 'christian alemania leguiz', 'announcement test 1', 'test 1', '2023-10-12 07:01:36', '2023-2024', 'First Semester'),
(4, '20-22-5526', 'christian alemania leguiz', 'announcement test 1', 'test 1', '2023-10-12 07:01:36', '2023-2024', 'First Semester'),
(5, '20-22-5526', 'christian alemania leguiz', 'announcement test 1', 'test 1 uli', '2023-10-12 07:01:36', '2023-2024', 'First Semester'),
(6, '20-22-5526', 'christian alemania leguiz', 'networking', 'down line ko ', '2023-10-12 07:01:36', '2023-2024', 'First Semester'),
(7, '20-22-5526', 'christian alemania leguiz', 'networking', '>wala na po tayong networking\r\n>kailangan na po natin\r\n>wala na po ako pera', '2023-10-12 07:01:36', '2023-2024', 'First Semester'),
(8, '20-22-5526', 'christian alemania leguiz', 'networking', '1. bawal kayo mag tanggal dyan sa computer kapag natrace kayo OSA\r\n\r\n2. Saan ba ako nagkulang?', '2023-10-12 07:01:36', '2023-2024', 'First Semester'),
(9, '20-22-5526', 'christian alemania leguiz', 'jogging tayo', 'sa luneta lang kung gusto nyo lang naman bahala kayo\r\n>ey\r\n>ey ey', '2023-10-12 07:01:36', '2023-2024', 'First Semester'),
(10, '20-22-5526', 'christian alemania leguiz', 'Truth Table', 'sabi ni Dr Aler<br />\r\n<br />\r\nT  T  T<br />\r\nT  F  T', '2023-10-12 07:01:36', '2023-2024', 'First Semester'),
(18, '20-22-5526', 'christian alemania leguiz', 'Truth Table', 'test 1<br />\r\ntest 2<br />\r\ntest 3', '2023-10-12 07:53:27', '2023-2024', 'First Semester'),
(19, '20-22-5526', 'christian alemania leguiz', 'test ', 'test <br />\r\ntest<br />\r\ntest', '2023-10-12 14:13:34', '2023-2024', 'First Semester'),
(20, '20-22-5526', 'christian alemania leguiz', 'request description', 'your description of the request should be:<br />\r\n1. precise and make it readable<br />\r\n2. Make sure the time is correct that will be used for approving and rejecting', '2023-10-19 15:17:16', '2023-2024', 'First Semester'),
(21, '20-22-5526', 'christian alemania leguiz', 'for equipment', 'make sure na gagamitin nyo ng maayos ahhh kasi kapag sira ito magbabayad kayo', '2023-10-19 15:31:13', '2023-2024', 'First Semester'),
(22, '20-22-5526', 'christian alemania leguiz', 'hehehe try only', 'try', '2023-11-18 10:57:35', '2020-2021', 'Second Semester'),
(23, '20-22-5526', 'christian alemania leguiz', 'hehehe try only', 'try', '2023-11-18 11:36:19', '2020-2021', 'Second Semester'),
(24, '20-22-5526', 'christian alemania leguiz', 'hehehe try only', 'try', '2023-11-18 11:37:10', '2020-2021', 'Second Semester');

-- --------------------------------------------------------

--
-- Table structure for table `complab_schedules`
--

CREATE TABLE `complab_schedules` (
  `schedule_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `start_event` datetime NOT NULL,
  `end_event` datetime NOT NULL,
  `room_id` int(10) NOT NULL,
  `school_year` varchar(20) NOT NULL,
  `semester` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complab_schedules`
--

INSERT INTO `complab_schedules` (`schedule_id`, `title`, `start_event`, `end_event`, `room_id`, `school_year`, `semester`) VALUES
(1, 'coach aler', '2023-10-27 21:19:42', '2023-10-27 22:19:43', 205, '2020-2021', 'Second Semester'),
(7, 'wala lang naman', '2023-10-25 06:00:00', '2023-10-25 12:30:00', 205, '2020-2021', 'Second Semester'),
(8, 'hehehee', '2023-10-12 07:00:00', '2023-10-12 11:30:00', 206, '2020-2021', 'Second Semester'),
(9, 'hehehehehe', '2023-10-23 06:30:00', '2023-10-23 08:00:00', 206, '2020-2021', 'Second Semester'),
(10, 'hehehehehe', '2023-10-23 08:30:00', '2023-10-23 13:00:00', 205, '2020-2021', 'Second Semester'),
(11, 'bakit ganun nagloloko', '2023-10-27 07:30:00', '2023-10-27 12:30:00', 206, '2020-2021', 'Second Semester'),
(13, 'holy week', '2023-10-27 06:30:00', '2023-10-27 12:00:00', 205, '2020-2021', 'Second Semester'),
(14, 'try kung gumana yung refetchagain', '2023-10-26 09:30:00', '2023-10-26 14:30:00', 205, '2020-2021', 'Second Semester'),
(15, 'hatdog', '2023-10-23 13:00:00', '2023-10-23 16:00:00', 205, '2020-2021', 'Second Semester'),
(16, 'hehehe', '2023-10-24 12:00:00', '2023-10-24 15:30:00', 205, '2020-2021', 'Second Semester'),
(17, 'hehehe', '2023-10-24 16:00:00', '2023-10-24 19:00:00', 205, '2020-2021', 'Second Semester'),
(18, 'sana gumana pls', '2023-10-17 08:00:00', '2023-10-17 12:00:00', 206, '2020-2021', 'Second Semester'),
(19, 'hehehehe', '2023-10-25 15:00:00', '2023-10-25 18:30:00', 205, '2020-2021', 'Second Semester'),
(20, 'nayssss', '2023-10-24 06:00:00', '2023-10-24 10:00:00', 205, '2020-2021', 'Second Semester'),
(21, 'nays', '2023-10-23 05:30:00', '2023-10-23 08:00:00', 205, '2020-2021', 'Second Semester'),
(22, 'eyyyyy', '2023-10-26 00:00:00', '2023-10-26 05:00:00', 205, '2020-2021', 'Second Semester'),
(23, 'try lang', '2023-10-28 10:00:00', '2023-10-28 12:00:00', 206, '2020-2021', 'Second Semester'),
(24, 'sana gumana', '2023-10-26 12:00:00', '2023-10-26 15:30:00', 206, '2020-2021', 'Second Semester'),
(25, 'gumana kana pls', '2023-10-30 09:00:00', '2023-10-30 13:00:00', 206, '2020-2021', 'Second Semester'),
(27, 'hays', '2023-10-17 12:30:00', '2023-10-17 16:00:00', 206, '2020-2021', 'Second Semester'),
(28, 'hehehee', '2023-10-26 06:30:00', '2023-10-26 09:00:00', 205, '2020-2021', 'Second Semester'),
(29, 'try again', '2023-10-22 00:00:00', '2023-10-22 04:30:00', 206, '2020-2021', 'Second Semester'),
(31, 'hey', '2023-10-23 00:00:00', '2023-10-23 04:00:00', 205, '2020-2021', 'Second Semester'),
(32, 'yey', '2023-10-01 03:00:00', '2023-10-01 07:00:00', 205, '2020-2021', 'Second Semester'),
(33, 'yey', '2023-10-04 00:00:00', '2023-10-04 05:00:00', 205, '2020-2021', 'Second Semester'),
(34, 'try again', '2023-10-28 01:00:00', '2023-10-28 05:00:00', 205, '2020-2021', 'Second Semester'),
(35, 'try again', '2023-10-28 06:30:00', '2023-10-28 10:30:00', 205, '2020-2021', 'Second Semester'),
(36, 'try', '2023-10-25 00:30:00', '2023-10-25 04:30:00', 205, '2020-2021', 'Second Semester'),
(37, 'try', '2023-10-27 00:30:00', '2023-10-27 04:30:00', 205, '2020-2021', 'Second Semester'),
(39, 'yeah', '2023-10-22 04:30:00', '2023-10-22 08:30:00', 205, '2020-2021', 'Second Semester'),
(40, 'hayss', '2023-10-31 06:00:00', '2023-10-31 09:00:00', 206, '2020-2021', 'Second Semester'),
(41, 'peram lab', '2023-11-01 00:00:00', '2023-11-02 00:00:00', 206, '2020-2021', 'Second Semester');

-- --------------------------------------------------------

--
-- Table structure for table `labrooms`
--

CREATE TABLE `labrooms` (
  `room_id` int(10) NOT NULL,
  `room_name` varchar(50) NOT NULL,
  `capacity` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `labrooms`
--

INSERT INTO `labrooms` (`room_id`, `room_name`, `capacity`) VALUES
(1, 'Room 1', 40),
(202, 'Room 202', 40),
(203, 'Room 203', 40),
(205, 'room 205', 40),
(206, 'room 206', 40);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `noti_user_uniqueid` varchar(100) NOT NULL,
  `noti_status` varchar(100) NOT NULL,
  `noti_date` varchar(100) NOT NULL,
  `noti_type` varchar(100) NOT NULL,
  `noti_uri` varchar(1000) NOT NULL,
  `noti_uniqueid` varchar(100) NOT NULL,
  `noti_table` varchar(100) NOT NULL,
  `noti_seen` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `noti_user_uniqueid`, `noti_status`, `noti_date`, `noti_type`, `noti_uri`, `noti_uniqueid`, `noti_table`, `noti_seen`) VALUES
(1, 'afadfas', 'afafas', 'asfsa', 'asfasfs', 'afsa', 'asdfa', 'asfa', 'aadafafa');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `request_id` int(11) NOT NULL,
  `ticket_no` varchar(6) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(250) NOT NULL,
  `time` time NOT NULL,
  `time_end` time DEFAULT NULL,
  `date` date NOT NULL,
  `room_id` int(11) NOT NULL,
  `request_type` enum('comlab usage','repair','equipment') NOT NULL,
  `status` enum('pending','approve','reject','resolved') NOT NULL DEFAULT 'pending',
  `feedback` varchar(250) DEFAULT NULL,
  `school_year` varchar(20) NOT NULL,
  `semester` varchar(20) NOT NULL,
  `notify` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`request_id`, `ticket_no`, `user_id`, `name`, `description`, `time`, `time_end`, `date`, `room_id`, `request_type`, `status`, `feedback`, `school_year`, `semester`, `notify`) VALUES
(57, '626787', '20-22-5527', 'christian alemania leguiz', 'peram computer for research po', '11:00:00', '12:00:00', '2023-11-15', 202, 'comlab usage', 'pending', 'DONE', '2020-2021', 'Second Semester', 1),
(58, '027576', '20-22-5527', 'christian alemania leguiz', 'parepair po', '11:00:00', '09:03:09', '2023-11-14', 202, 'repair', 'resolved', NULL, '2020-2021', 'Second Semester', 1),
(59, '083648', '20-22-5527', 'christian alemania leguiz', 'peram po hdmi kung meron po', '11:00:00', '12:00:00', '2023-11-14', 202, 'equipment', 'approve', 'DONE', '2020-2021', 'Second Semester', 1),
(60, '029891', '20-22-5527', 'christian alemania leguiz', 'peram comlab', '03:34:00', '03:34:00', '2023-11-16', 202, 'comlab usage', 'pending', 'DONE', '2020-2021', 'Second Semester', 1),
(61, '122346', '20-22-5527', 'christian alemania leguiz', 'sira po yung computer dito sa pc 1 paayos po urgent', '13:00:00', NULL, '2023-11-15', 205, 'repair', 'pending', NULL, '2021-2022', 'Second Semester', 0),
(62, '112346', '20-22-5527', 'christian alemania leguiz', 'sira po yung computer dito sa pc 2 paayos po urgent', '13:00:00', NULL, '2023-11-15', 205, 'repair', 'pending', NULL, '2021-2022', 'Second Semester', 0),
(63, '112346', '20-22-5527', 'christian alemania leguiz', 'sira po yung computer dito sa pc 3 paayos po urgent', '13:00:00', NULL, '2023-11-15', 205, 'repair', 'resolved', 'DONE', '2021-2022', 'Second Semester', 0),
(64, '113346', '20-22-5527', 'christian alemania leguiz', 'peram computer  po urgent', '13:00:00', NULL, '2023-11-15', 205, 'comlab usage', 'pending', NULL, '2021-2022', 'Second Semester', 0),
(65, '113316', '20-22-5527', 'christian alemania leguiz', 'peram computer  po urgent', '13:00:00', NULL, '2023-11-15', 205, 'comlab usage', 'approve', 'DONE', '2021-2022', 'Second Semester', 0),
(66, '113316', '20-22-5527', 'christian alemania leguiz', 'peram computer  po urgent', '13:00:00', NULL, '2023-11-15', 205, 'comlab usage', 'approve', 'DONE', '2022-2023', 'Second Semester', 1),
(67, '113316', '20-22-5527', 'christian alemania leguiz', 'peram computer  po urgent', '13:00:00', NULL, '2023-11-15', 205, 'comlab usage', 'approve', 'DONE', '2022-2023', 'Second Semester', 1),
(68, '335027', '20-22-5527', 'christian alemania leguiz', 'pare repair idol sira ata utak ko', '12:17:00', '08:58:39', '2023-11-16', 202, 'repair', 'resolved', 'DONE', '2020-2021', 'Second Semester', 1),
(69, '161638', '20-22-5527', 'christian alemania leguiz', 'hehehehe test', '10:00:00', '12:00:00', '2023-11-22', 202, 'comlab usage', 'pending', 'DONE', '2020-2021', 'Second Semester', 1),
(70, '202414', '20-22-5527', 'christian alemania leguiz', 'test 2', '12:51:00', '12:51:00', '2023-11-22', 202, 'comlab usage', 'approve', 'DONE', '2020-2021', 'Second Semester', 1),
(71, '866878', '20-22-5527', 'christian alemania leguiz', 'peram pong computer', '10:40:00', '11:40:00', '2023-11-17', 205, 'comlab usage', 'approve', 'DONE', '2020-2021', 'Second Semester', 1),
(72, '332695', '20-22-5527', 'christian alemania leguiz', 'peram computer po', '11:24:00', '12:24:00', '2023-11-17', 205, 'comlab usage', 'approve', 'DONE', '2020-2021', 'Second Semester', 1),
(73, '830157', '20-22-5527', 'christian alemania leguiz', 'eram', '11:26:00', '12:26:00', '2023-11-17', 205, 'comlab usage', 'approve', 'DONE', '2020-2021', 'Second Semester', 1),
(74, '943396', '20-22-5527', 'christian alemania leguiz', 'eram', '00:11:00', '00:13:00', '2023-12-13', 205, 'comlab usage', 'approve', 'DONE', '2020-2021', 'Second Semester', 1),
(75, '087189', '20-22-5527', 'christian alemania leguiz', 'make a request 1', '11:36:00', '12:36:00', '2023-11-17', 205, 'comlab usage', 'approve', 'DONE', '2020-2021', 'Second Semester', 1),
(76, '157309', '20-22-5527', 'christian alemania leguiz', 'make a request 1', '10:36:00', '11:36:00', '2023-11-16', 205, 'equipment', 'approve', 'DONE', '2020-2021', 'Second Semester', 1),
(77, '911903', '20-22-5527', 'christian alemania leguiz', 'eram', '12:02:00', '02:02:00', '2023-11-29', 205, 'comlab usage', 'reject', 'wala bakante', '2020-2021', 'Second Semester', 1),
(78, '664462', '20-22-5527', 'christian alemania leguiz', 'sira', '00:03:00', '09:03:23', '2023-11-24', 206, 'repair', 'resolved', NULL, '2020-2021', 'Second Semester', 1),
(79, '993891', '20-22-5527', 'christian alemania leguiz', 'peram com', '00:12:00', '12:12:00', '2023-11-18', 205, 'comlab usage', 'approve', 'DONE', '2020-2021', 'Second Semester', 1),
(80, '060025', '20-22-5527', 'christian alemania leguiz', 'peram', '12:21:00', '00:12:00', '2023-12-12', 205, 'comlab usage', 'approve', NULL, '2020-2021', 'Second Semester', 1);

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `schedule_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `day_of_week` enum('monday','tuesday','wednesday','thursday','friday','saturday','sunday') NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `date` date NOT NULL,
  `professor` varchar(50) NOT NULL,
  `section` varchar(20) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `school_year` varchar(20) NOT NULL,
  `semester` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`schedule_id`, `room_id`, `user_id`, `day_of_week`, `start_time`, `end_time`, `date`, `professor`, `section`, `subject`, `school_year`, `semester`) VALUES
(1, 1, '20-22-5526', 'monday', '06:30:00', '09:00:00', '2023-09-21', 'Dr. Diosdado Aler', 'BSIT-41', 'SysAdmin', '2023-2024', 'First Semester'),
(2, 1, '20-22-5526', 'tuesday', '07:00:00', '09:30:00', '2023-09-21', 'Dr. Christian A. Leguiz', 'BSIT-41', 'Web development', '2023-2024', 'First Semester'),
(12, 1, '20-22-5526', 'monday', '10:00:00', '11:00:00', '2023-09-21', 'dr antonio', 'BSIT-41', 'networking', '2023-2024', 'First Semester'),
(13, 1, '20-22-5526', 'wednesday', '10:00:00', '01:00:00', '2023-09-24', 'dr antonio', 'BSIT-41', 'networking', '2023-2024', 'First Semester'),
(14, 1, '20-22-5526', 'thursday', '10:00:00', '00:00:00', '2023-09-24', 'dr antonio', 'BSIT-41', 'networking', '2023-2024', 'First Semester'),
(15, 1, '20-22-5526', 'thursday', '13:00:00', '15:30:00', '2023-09-24', 'dr antonio', 'BSIT-41', 'networking', '2023-2024', 'First Semester'),
(17, 1, '20-22-5526', 'monday', '01:00:00', '04:00:00', '2023-09-28', 'dr antonio', 'BSIT-41', 'networking', '2023-2024', 'First Semester'),
(18, 1, '20-22-5526', 'friday', '07:00:00', '07:00:00', '2023-09-28', 'dr antonio', 'BSIT-41', 'networking', '2023-2024', 'First Semester'),
(19, 1, '20-22-5526', 'tuesday', '01:00:00', '05:00:00', '2023-09-28', 'dr antonio', 'BSIT-41', 'announcement test 1', '2023-2024', 'First Semester'),
(20, 1, '20-22-5526', 'tuesday', '10:00:00', '00:00:00', '2023-09-28', 'dr antonio', 'BSIT-41', 'networking', '2023-2024', 'First Semester'),
(22, 1, '20-22-5526', 'thursday', '13:00:00', '16:00:00', '2023-09-28', 'dr antonio', 'BSIT-41', 'announcement test 1', '2023-2024', 'First Semester'),
(23, 1, '20-22-5526', 'sunday', '08:00:00', '10:00:00', '2023-09-28', 'dr antonio', 'BSIT-41', 'networking', '2023-2024', 'First Semester'),
(24, 1, '20-22-5526', 'monday', '14:00:00', '17:00:00', '2023-09-28', 'dr antonio', 'BSIT-41', 'networking', '2023-2024', 'First Semester'),
(25, 1, '20-22-5526', 'friday', '11:00:00', '16:00:00', '2023-09-29', 'dr antonio', 'BSIT-41', 'networking', '2023-2024', 'First Semester'),
(26, 1, '20-22-5526', 'saturday', '08:00:00', '11:00:00', '2023-09-30', 'dr antonio', 'BSIT-41', 'networking', '2023-2024', 'First Semester'),
(27, 1, '20-22-5526', 'wednesday', '10:00:00', '11:00:00', '2023-09-30', 'dr antonio', 'BSIT-41', 'networking', '2023-2024', 'First Semester'),
(28, 1, '20-22-5526', 'wednesday', '06:00:00', '09:00:00', '2023-09-30', 'dr antonio', 'BSIT-41', 'networking', '2023-2024', 'First Semester'),
(29, 202, '20-22-5526', 'thursday', '08:00:00', '10:00:00', '2023-10-06', 'Dr. Aler', 'CYB-31', 'Truth Table', '2023-2024', 'First Semester'),
(30, 202, '20-22-5526', 'monday', '11:00:00', '12:00:00', '2023-10-12', 'Dr. Aler', 'BSIT-41', 'Truth Table', '2023-2024', 'First Semester');

-- --------------------------------------------------------

--
-- Table structure for table `system_logs`
--

CREATE TABLE `system_logs` (
  `log_id` int(11) NOT NULL,
  `event_type` varchar(255) NOT NULL,
  `event_description` text DEFAULT NULL,
  `admin_id` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `school_year` varchar(20) NOT NULL,
  `semester` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_logs`
--

INSERT INTO `system_logs` (`log_id`, `event_type`, `event_description`, `admin_id`, `created_at`, `school_year`, `semester`) VALUES
(74, 'Comlab Usage', 'Ticket No 626787 status updated to approve by Admin: Christian Alemania Leguiz', '20-22-5526', '2023-11-24 14:59:25', '2020-2021', 'Second Semester'),
(75, 'Comlab Usage', 'Ticket No 202414 status updated to approve by Admin: Christian Alemania Leguiz', '20-22-5526', '2023-11-24 15:08:19', '2020-2021', 'Second Semester'),
(76, 'Comlab Usage', 'Ticket No 113316 status updated to approve by Admin: Christian Alemania Leguiz', '20-22-5526', '2023-11-24 15:08:21', '2020-2021', 'Second Semester'),
(77, 'Comlab Usage', 'Ticket No 113316 status updated to approve by Admin: Christian Alemania Leguiz', '20-22-5526', '2023-11-24 15:11:25', '2020-2021', 'Second Semester'),
(78, 'Comlab Usage', 'Ticket No 113316 status updated to approve by Admin: Christian Alemania Leguiz', '20-22-5526', '2023-11-24 15:11:36', '2020-2021', 'Second Semester'),
(79, 'Comlab Usage', 'Ticket No 113316 status updated to approve by Admin: Christian Alemania Leguiz', '20-22-5526', '2023-11-24 15:13:48', '2022-2023', 'Second Semester'),
(80, 'Repair Request', 'Ticket No 112346 status updated to resolved by Admin: Christian Alemania Leguiz ', '20-22-5526', '2023-11-24 15:17:07', '2022-2023', 'Second Semester'),
(81, 'Equipment Request', 'Ticket No 083648 status updated to approve by Admin: Christian Alemania Leguiz ', '20-22-5526', '2023-11-24 15:17:22', '2022-2023', 'Second Semester');

-- --------------------------------------------------------

--
-- Table structure for table `user_registration`
--

CREATE TABLE `user_registration` (
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `id` varchar(20) NOT NULL,
  `section` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL DEFAULT '$2y$10$fkdPOwDrX6RdwOC2Ox3KQO2W.veh2bGWfQi6XtepYRVblYyafi6Wy',
  `user_type` varchar(50) NOT NULL,
  `school_year` varchar(20) NOT NULL,
  `semester` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_registration`
--

INSERT INTO `user_registration` (`firstname`, `lastname`, `middlename`, `id`, `section`, `password`, `user_type`, `school_year`, `semester`, `created_at`) VALUES
('adrian', 'motios', 'luyas', '12-23-9999', 'BSIT-41', '$2y$10$itq1mlbwNpvFS3zbPKVBaeefLLKD19feW38izx4GHRO55DmTWJ14.', 'student', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('adrian', 'motios', 'luyas', '20-22-0011', 'bsit-41', '$2y$10$7Lmeiw8O/C7icwMQiGZBl.D8JaV11RXHLGi2Ivb2G5jmocezreQfS', 'student', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('jansen jefferson', 'navarra', NULL, '20-22-1112', 'BSIT-41', '$2y$10$AplpLvy47v88zcWLfagwoewADNOyFuUk/nN3wMJQdxE/46SkANLny', 'student', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('christian', 'leguiz', 'alemania', '20-22-1115', 'BSIT-41', '$2y$10$dRGw.ROg098/YS3nn6f/1OhEFl5.maCMsPPAA2.68iLuT6acW1.n.', 'student', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('adrian', 'luyas', 'motios', '20-22-1116', 'BSIT-41', '$2y$10$qWhy/dV07YJf/mN76W969u6nazdB2GxKscn7DYI7/PrztYL3lieH6', 'student', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('irene', 'leguiz', 'alemania', '20-22-1118', 'BSIT-41', '!adminPassword', 'student', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('christian', 'leguiz', 'alemania', '20-22-1121', 'BSIT-41', '$2y$10$mjiA0J1fx0SogW4uiJhXOO.KktRaNsj/HkqLCOYoOfyfTK8McyUle', 'student', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('wews', 'leguiz', 'motios', '20-22-1125', NULL, '$2y$10$VeqjftRD53zTnmt6wQ91Wu.EpmKNKs7onMHubryH1GcsCTyjHYbjG', 'faculty', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('christian', 'leguiz', 'alemania', '20-22-1212', '', '12345678', 'admin', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('david', 'rebancos', 'motios', '20-22-1234', 'BSIT-41', 'youarethereason', 'student', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('wews', 'leguiz', 'alemania', '20-22-1290', '', 'batganito', 'admin', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('wews', 'rebancos', 'alemania', '20-22-1512', 'BSIT-41', '$2y$10$PsPmsMHN18j7n9URALJYT.IkzpU8QfycycK.mc78Djn4ijaBipTmC', 'student', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('david', 'rebancos', 'motios', '20-22-1999', 'BSIT-41', '!adminPassword', 'student', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('adrian', 'motios', 'luyas', '20-22-2211', 'BSIT-41', '$2y$10$BtJLlaH4RAsgJJVWCZj.5.P7iDD3Mt8YJ0YJrVbficE4lyHIdl5da', 'student', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('david', 'rebancos', 'motios', '20-22-2222', 'BSIT-41', 'youarethereason', 'faculty', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('dudobg', 'pogi', 'ba ako', '20-22-2929', 'bsit41', '$2y$10$qNasMYxmv.5v6tLEKVtxnOvDjtsmlaydAe3i8mPCrI0lTuGxtpKNO', 'student', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('david', 'rebancos', 'motios', '20-22-4512', 'BSIT-41', '$2y$10$bo3GYUeDd/JreavK2GGih.K.FL1qAtg.SHQDtKhbKOpl2RUc3778q', 'student', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('david', 'rebancos', 'motios', '20-22-5020', 'bsit-41', '$2y$10$RPg32nxs5iZ4nr1lwZ/tG.AXKFg8qawrBfFRwvjSvxIM1dE0eGDP6', 'student', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('adrian', 'motios', 'luyas', '20-22-5111', 'BSIT-41', '$2y$10$YTp4SPU9kXn3Fp1sSvFH5u3L/eqPdG4FETUEun4L3gEgU3LZjETO2', 'student', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('adrian', 'motios', 'luyas', '20-22-5112', 'BSIT-41', '$2y$10$pBKfVGPNOcrzHlcR1TEPQurgpi3Tg4ZE1njWcRaI.8MQQlBnRS.UC', 'student', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('adrian', 'motios', 'luyas', '20-22-5115', 'BSIT-41', '$2y$10$M0EIUnvPTckWjHvVMC9EwOEEQ20fqmgPJ7jOhdpGBKvHlHa.ALGgW', 'student', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('adrian', 'motios', 'luyas', '20-22-5123', 'BSIT-41', '$2y$10$1wmrni/oHbAo5369TnXiQ.u4ihCRTPXuP8pdPqzfv7P5hH6G74XVS', 'student', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('adrian', 'motios', 'luyas', '20-22-5131', 'BSIT-41', '$2y$10$szd4Yex43gUq1mJP69bFOOV3HXE3HVhO3CrETYRbCx7J/d5b9HU2y', 'student', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('david', 'leguiz', 'alemania', '20-22-5151', 'BSIT-41', '$2y$10$Y.KdkmYdbYRYyFJI4aHTQO6eEJYSamzuQ8wRH1VQZ5KmCo/ZL2GUm', 'student', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('adrian', 'motios', 'luyas', '20-22-5156', 'BSIT-41', '$2y$10$RSGFZUWGa1o78LK3KTPFg.AdChc/zHwIeVlNkn3mj/ZOcZCDC/OYG', 'student', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('adrian', 'motios', 'luyas', '20-22-5222', 'BSIT-41', '$2y$10$ptqAedraq2WMJXX7HXBxt.OaYBZWIvuXsZqpYWj8dxmGppK8BNz7e', 'student', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('adrian', 'motios', 'luyas', '20-22-5231', 'BSIT-41', '$2y$10$AAylcHaYoYqYnRqpBTxERuQwVu2.0KbdHzhbamCBn2hhwNLCDNrbm', 'student', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('adrian', 'motios', 'luyas', '20-22-5511', 'BSIT-41', '$2y$10$PfX.ZCHk7tHNVAMeBOBmCOZ5DS5jSUTHeh92TQ0BENVKXB2BsxRtC', 'student', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('adrian', 'motios', 'luyas', '20-22-5512', 'BSIT-41', '$2y$10$PJqrqJ7DLlPaR8vuuziKFuKPPd6VaOfM2zILXWrFb1xnXl10JHd4O', 'student', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('adrian', 'motios', 'luyas', '20-22-5514', 'BSIT-41', '$2y$10$b0Ly5t8Y9mfNqm6EgjE6BO1nH/YjXCOKTqxy0lwttFzHT.j18Pnam', 'student', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('adrian', 'motios', 'luyas', '20-22-5515', 'bsit-41', '$2y$10$aJISj.JeAVFXdYCzo50HuOsc9q95PQm2mlbiK9cbJObHMb5BlOW4u', 'student', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('adrian', 'motios', 'luyas', '20-22-5516', 'bsi', '$2y$10$jrcNiitjexDeSPSj2AbQTeLOZjN0L2DjbS6qw5l2EyEseOrvtq40C', 'student', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('christian', 'leguiz', 'alemania', '20-22-5526', NULL, '$2y$10$H2KMIfpDloVVpVcUzayqr.QPHRqBb/izVj/JvuY1hiifmLxL7PFDm', 'admin', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('christian', 'leguiz', 'alemania', '20-22-5527', 'BSIT-41', '$2y$10$F3UxBfRD/5u4q5w6yQrNtOUh/DiaaD3YjCxvfjbGv/3oVN7DFitxq', 'student', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('adrian', 'motios', NULL, '20-22-5528', 'BSIT-41', '$2y$10$cQs2uZupczzQIa923LMwmuKLsEbLsAY7qBZsZlzSDpSvVVEFPc5Ua', 'student', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('adrian', 'motios', 'luyas', '20-22-55513', 'bsit-41', '$2y$10$qaUrRF.bgrDHU97PR2XKCej.zL/tlHMPdEVnjKBUNQTbYUhT9MRH6', 'student', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('adrian', 'motios', 'luyas', '20-22-5591', 'BSIT-41', '$2y$10$/XvvikOiKjqw7EHSiTv2ReFmWHpBTvjkQ6BlIzkk4Hdm8qorqQKtW', 'student', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('david', 'rebancos', 'motios', '20-22-5920', 'bsit-41', '$2y$10$RG8suqUqfeNjtCgzMw/N0utnICJ5DfsPcDvM/Y0s8Qq7xerh0H.Sm', 'student', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('ria cristy', 'santos', 'guiterrez', '20-22-6821', NULL, '$2y$10$3f3pyk7ZQuDZvW3KRhO9Ue6cJQjJn/NhTyPflQ85MxJ.SUsBU1OQK', 'admin', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('ria', 'leguiz', NULL, '20-22-6826', NULL, '$2y$10$OiWx/nqCTrldji3TjuFvtOIX81lFRbAv42WEGiQ9h/0VESwJKwtBa', 'admin', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('adrian', 'motios', 'luyas', '20-22-9101', 'BSIT-41', '$2y$10$AKYrL8HybzZB1QPFLqxD7OMbmw4V3g/8pCIMNoBX7g4bCvJpFwd32', 'student', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('adrian', 'motios', 'luyas', '20-22-9911', 'BSIT-41', '$2y$10$2cFOtLFe50UMJ.JA//KSRemstEn/.UfmHiOv5cH8/SHoOX0fGhMxe', 'student', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('adrian', 'motios', 'luyas', '20-22-9991', 'BSIT-41', '$2y$10$eD9I.mW0lmXGCYX0RHQAOuuh2TA7avasvuEHN5T8SjTie5dAjn8wS', 'student', '2022-2023', 'Second Semester', '2023-11-24 15:10:54'),
('ria', 'leguiz', 'alemania', '20-22-9999', NULL, '$2y$10$oMjb7fXLwt76E/q6UXXTNuuqO6ktRRgzFDMwaF2mu4QybYLCAsbp2', 'admin', '2022-2023', 'Second Semester', '2023-11-24 15:10:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_year`
--
ALTER TABLE `academic_year`
  ADD PRIMARY KEY (`school_year`,`semester`);

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`announcement_id`),
  ADD KEY `fk_userid` (`user_id`),
  ADD KEY `fk_announcement_acadyear` (`school_year`,`semester`);

--
-- Indexes for table `complab_schedules`
--
ALTER TABLE `complab_schedules`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `fk_request_id` (`room_id`),
  ADD KEY `fk_school_year_semester` (`school_year`,`semester`);

--
-- Indexes for table `labrooms`
--
ALTER TABLE `labrooms`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `fk_request_user` (`user_id`),
  ADD KEY `fk_request_room` (`room_id`),
  ADD KEY `fk_request_acadyear` (`school_year`,`semester`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `schedule_ibfk_3` (`room_id`),
  ADD KEY `fk_sched_acadyear` (`school_year`,`semester`);

--
-- Indexes for table `system_logs`
--
ALTER TABLE `system_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `s.log_constraintfk_id` (`admin_id`),
  ADD KEY `s.log_constraintfk_acadyear` (`school_year`,`semester`);

--
-- Indexes for table `user_registration`
--
ALTER TABLE `user_registration`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_userregs_acadyear` (`school_year`,`semester`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `complab_schedules`
--
ALTER TABLE `complab_schedules`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `system_logs`
--
ALTER TABLE `system_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcement`
--
ALTER TABLE `announcement`
  ADD CONSTRAINT `fk_announcement_acadyear` FOREIGN KEY (`school_year`,`semester`) REFERENCES `academic_year` (`school_year`, `semester`),
  ADD CONSTRAINT `fk_userid` FOREIGN KEY (`user_id`) REFERENCES `user_registration` (`id`);

--
-- Constraints for table `complab_schedules`
--
ALTER TABLE `complab_schedules`
  ADD CONSTRAINT `fk_request_id` FOREIGN KEY (`room_id`) REFERENCES `labrooms` (`room_id`),
  ADD CONSTRAINT `fk_school_year_semester` FOREIGN KEY (`school_year`,`semester`) REFERENCES `academic_year` (`school_year`, `semester`);

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `fk_request_acadyear` FOREIGN KEY (`school_year`,`semester`) REFERENCES `academic_year` (`school_year`, `semester`),
  ADD CONSTRAINT `fk_request_room` FOREIGN KEY (`room_id`) REFERENCES `labrooms` (`room_id`),
  ADD CONSTRAINT `fk_request_user` FOREIGN KEY (`user_id`) REFERENCES `user_registration` (`id`);

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `fk_sched_acadyear` FOREIGN KEY (`school_year`,`semester`) REFERENCES `academic_year` (`school_year`, `semester`),
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `labrooms` (`room_id`),
  ADD CONSTRAINT `schedule_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user_registration` (`id`);

--
-- Constraints for table `system_logs`
--
ALTER TABLE `system_logs`
  ADD CONSTRAINT `s.log_constraintfk_acadyear` FOREIGN KEY (`school_year`,`semester`) REFERENCES `academic_year` (`school_year`, `semester`),
  ADD CONSTRAINT `s.log_constraintfk_id` FOREIGN KEY (`admin_id`) REFERENCES `user_registration` (`id`);

--
-- Constraints for table `user_registration`
--
ALTER TABLE `user_registration`
  ADD CONSTRAINT `fk_userregs_acadyear` FOREIGN KEY (`school_year`,`semester`) REFERENCES `academic_year` (`school_year`, `semester`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
