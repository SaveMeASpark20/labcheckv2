-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2023 at 02:31 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

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
('2020-2021', 'Second Semester', 0),
('2021-2022', 'First Semester', 1),
('2021-2022', 'Second Semester', 0),
('2022-2023', 'First Semester', 0),
('2022-2023', 'Second Semester', 0),
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
(25, '20-22-5526', 'christian alemania leguiz', 'Computer Laboratories Under Maintenance', 'Computer Laboratories wouldn\'t be available until further notice.', '2023-11-27 06:55:13', '2022-2023', 'Second Semester'),
(26, '20-22-5526', 'christian alemania leguiz', 'Upcoming Midterm Week', 'Good luck everyone! May the correct answers be with you :)', '2023-11-27 06:56:28', '2022-2023', 'Second Semester');

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
(42, 'Holiday', '2023-11-27 00:00:00', '2023-11-28 00:00:00', 206, '2021-2022', 'First Semester'),
(43, 'Holiday', '2023-11-27 00:00:00', '2023-11-28 00:00:00', 205, '2021-2022', 'First Semester'),
(44, 'OCCUPIED', '2023-11-18 00:00:00', '2023-11-19 00:00:00', 206, '2021-2022', 'First Semester'),
(45, 'OCCUPIED', '2023-11-25 00:00:00', '2023-11-26 00:00:00', 205, '2021-2022', 'First Semester'),
(46, 'OCCUPIED', '2023-11-16 00:00:00', '2023-11-17 00:00:00', 206, '2021-2022', 'First Semester'),
(47, 'OCCUPIED', '2023-11-18 00:00:00', '2023-11-19 00:00:00', 205, '2021-2022', 'First Semester');

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
(85, '480800', '20-22-9085', 'Jia Mae Arboleda Inosanto', 'Pahiram po ng Room 205 for Manual Laboratory. Thanks', '07:00:00', '22:30:00', '2023-11-30', 205, 'comlab usage', 'pending', NULL, '2022-2023', 'Second Semester', 1),
(86, '589679', '20-22-9085', 'Jia Mae Arboleda Inosanto', 'Sira po yung outlet sa 2nd row ng mga pc', '19:00:00', '22:30:00', '2023-11-30', 205, 'repair', 'pending', NULL, '2022-2023', 'Second Semester', 1),
(87, '887050', '20-22-9085', 'Jia Mae Arboleda Inosanto', 'Need po ng projector sa room 205, thanks', '07:00:00', '10:30:00', '2023-11-30', 205, 'equipment', 'approve', 'DONE', '2022-2023', 'Second Semester', 1),
(88, '333431', '20-04-8126', 'Glennzoe Balingit Carabbacan', 'Need ni sir Gamit yung room 206 for networking simulation', '09:00:00', '12:00:00', '2023-11-29', 206, 'comlab usage', 'pending', NULL, '2022-2023', 'Second Semester', 1),
(89, '284200', '20-04-8126', 'Glennzoe Balingit Carabbacan', 'Durog po yung monitor sa pc16 and pc9', '09:00:00', '12:00:00', '2023-11-29', 206, 'repair', 'pending', 'I could only visit it on Nov 30, dont use it for the moment.. ', '2022-2023', 'Second Semester', 1),
(90, '263302', '20-04-8126', 'Glennzoe Balingit Carabbacan', 'Pahiram po ng HDMI yung existing HDMI po sa room 206 is putol. thanks', '09:00:00', '12:00:00', '2023-11-29', 206, 'equipment', 'pending', NULL, '2022-2023', 'Second Semester', 1),
(91, '955296', '20-22-5199', 'Carrie Abelaine Recto Duterte', 'We need room 206 for hands-on po', '15:00:00', '19:00:00', '2023-11-28', 206, 'comlab usage', 'approve', 'DONE', '2022-2023', 'Second Semester', 1),
(92, '867110', '20-22-5199', 'Carrie Abelaine Recto Duterte', 'Pa-repair po ng pc13 to pc20, they are all missing hdd\'s', '15:00:00', '19:00:00', '2023-11-28', 205, 'repair', 'pending', NULL, '2022-2023', 'Second Semester', 1),
(93, '148461', '20-22-5199', 'Carrie Abelaine Recto Duterte', 'IT41 wants to request projector. Tnx', '15:00:00', '19:00:00', '2023-11-28', 206, 'equipment', 'approve', 'DONE', '2022-2023', 'Second Semester', 1),
(94, '775446', '20-22-1329', 'Cris Lorenz  Gamit', 'Need to use Room 205', '06:30:00', '09:30:00', '2023-11-27', 205, 'comlab usage', 'approve', 'DONE', '2022-2023', 'Second Semester', 1),
(95, '532164', '20-22-1329', 'Cris Lorenz  Gamit', 'Need a repair for pc23, no visuals', '06:30:00', '09:30:00', '2023-11-27', 205, 'repair', 'reject', 'No available projectors.. 11/27/23 03:13pm', '2022-2023', 'Second Semester', 1),
(96, '319500', '20-22-1329', 'Cris Lorenz  Gamit', 'We would like to request projector and long hdmi', '06:30:00', '09:30:00', '2023-11-27', 205, 'equipment', 'pending', NULL, '2022-2023', 'Second Semester', 1),
(97, '795571', '20-04-8126', 'Glennzoe Balingit Carabbacan', 'Pahiram po ng room', '15:00:00', '17:30:00', '2023-11-25', 205, 'comlab usage', 'approve', 'DONE', '2021-2022', 'First Semester', 1),
(98, '582092', '20-04-8126', 'Glennzoe Balingit Carabbacan', 'Need po ng repair ng AC, walang lamig', '15:00:00', '17:30:00', '2023-11-25', 205, 'repair', 'resolved', 'DONE(11/27/23 03:23pm)', '2021-2022', 'First Semester', 1),
(99, '238253', '20-04-8126', 'Glennzoe Balingit Carabbacan', 'Pahiram po ng crimping tool tnx.', '15:00:00', '17:30:00', '2023-11-25', 205, 'equipment', 'approve', 'DONE', '2021-2022', 'First Semester', 1),
(100, '373220', '20-22-9085', 'Jia Mae Arboleda Inosanto', 'pahiram po ng room 206', '03:21:00', '06:21:00', '2023-11-18', 206, 'comlab usage', 'approve', 'DONE', '2021-2022', 'First Semester', 1),
(101, '133298', '20-22-9085', 'Jia Mae Arboleda Inosanto', 'Parepair po ng teacher', '15:21:00', '18:21:00', '2023-11-18', 206, 'repair', 'reject', 'Hahaha. 11/27/23 03:24pm', '2021-2022', 'First Semester', 1),
(102, '014751', '20-22-9085', 'Jia Mae Arboleda Inosanto', 'pahiram po lan cables 100 meters', '15:22:00', '18:22:00', '2023-11-18', 206, 'equipment', 'reject', 'Not available at the moment.', '2021-2022', 'First Semester', 1),
(103, '519846', '20-22-9085', 'Jia Mae Arboleda Inosanto', 'Pahiram po ulit on tomorrow', '15:27:00', '20:26:00', '2023-11-28', 205, 'comlab usage', 'pending', NULL, '2021-2022', 'First Semester', 1),
(104, '405405', '20-22-9085', 'Jia Mae Arboleda Inosanto', 'Need po ni Mr. Aw ng comlab', '15:30:00', '15:31:00', '2023-11-18', 205, 'comlab usage', 'approve', 'DONE', '2021-2022', 'First Semester', 1),
(105, '316512', '20-22-9085', 'christian alemania leguiz', 'Make it available on Nov 30. tnx', '09:30:00', '12:30:00', '2023-11-30', 206, 'comlab usage', 'pending', NULL, '2021-2022', 'First Semester', 1),
(106, '339835', '20-22-9085', 'christian alemania leguiz', 'Please make it available on Thursday', '10:30:00', '17:30:00', '2023-11-16', 206, 'comlab usage', 'approve', 'DONE', '2021-2022', 'First Semester', 1),
(107, '586872', '20-22-9085', 'christian alemania leguiz', 'Need repair on pc 12', '03:30:00', '07:30:00', '2023-11-11', 205, 'repair', 'resolved', 'DONE(11/27/23 03:38pm)', '2021-2022', 'First Semester', 1),
(108, '085926', '20-22-9085', 'christian alemania leguiz', 'Need repair po on pc13', '06:30:00', '21:30:00', '2023-11-11', 206, 'comlab usage', 'reject', 'Dont request here', '2021-2022', 'First Semester', 1),
(109, '298922', '20-22-9085', 'christian alemania leguiz', 'PAHIRAM NAMAN PO NG PROJECTOR THANK YOU', '15:38:00', '19:36:00', '2023-11-13', 205, 'equipment', 'approve', 'DONE', '2021-2022', 'First Semester', 1),
(110, '137983', '20-22-9085', 'christian alemania leguiz', 'PAHIRAM PO NG CRIMPRING TOOL AT CUTTER', '17:30:00', '19:30:00', '2023-11-21', 206, 'comlab usage', 'reject', 'Dont request here.', '2021-2022', 'First Semester', 1),
(111, '366125', '20-22-9085', 'christian alemania leguiz', 'PAHIRAM PO NG CRIMPING TOOL AT CUTTER', '15:40:00', '20:40:00', '2023-11-05', 205, 'equipment', 'pending', NULL, '2021-2022', 'First Semester', 1),
(112, '626490', '20-22-9085', 'christian alemania leguiz', 'PAHIRAM NAMAN PO NG PROJECTOR AND EXTENSION', '09:40:00', '11:40:00', '2023-11-07', 205, 'repair', 'pending', NULL, '2021-2022', 'First Semester', 1),
(113, '594038', '20-22-9085', 'christian alemania leguiz', 'We would like to borrow extra extension. tnx', '15:45:00', '12:41:00', '2023-11-22', 205, 'equipment', 'pending', NULL, '2021-2022', 'First Semester', 1),
(114, '741535', '20-22-0123', 'Rose Mary Jane Molina Icban', 'ako to si natoy', '11:23:00', '13:23:00', '2023-11-27', 205, 'comlab usage', 'pending', NULL, '2021-2022', 'First Semester', 1);

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
(92, 'User Registration', 'User registration for Agati Lisette (ID: 20-22-6901) created by 20-22-5526', '20-22-5526', '2023-11-27 06:12:22', '2022-2023', 'Second Semester'),
(93, 'User Registration', 'User registration for Lisette Agati (ID: 20-22-6901) created by 20-22-5526', '20-22-5526', '2023-11-27 06:13:33', '2022-2023', 'Second Semester'),
(94, 'User Registration', 'User registration for Yna Agulto (ID: 20-22-6486) created by 20-22-5526', '20-22-5526', '2023-11-27 06:13:57', '2022-2023', 'Second Semester'),
(95, 'User Registration', 'User registration for Shadrach Messach Alviza (ID: 20-22-6522) created by 20-22-5526', '20-22-5526', '2023-11-27 06:14:28', '2022-2023', 'Second Semester'),
(96, 'User Registration', 'User registration for Agati Lisette (ID: 20-22-6901) created by 20-22-5526', '20-22-5526', '2023-11-27 06:19:52', '2022-2023', 'Second Semester'),
(97, 'User Registration', 'User registration for Lisette Agati (ID: 20-22-6901) created by 20-22-5526', '20-22-5526', '2023-11-27 06:20:24', '2022-2023', 'Second Semester'),
(98, 'User Registration', 'User registration for Yna Agulto (ID: 20-22-6486) created by 20-22-5526', '20-22-5526', '2023-11-27 06:21:48', '2022-2023', 'Second Semester'),
(99, 'User Registration', 'User registration for Shadrach Messach Alviza (ID: 20-22-6522) created by 20-22-5526', '20-22-5526', '2023-11-27 06:22:09', '2022-2023', 'Second Semester'),
(100, 'User Registration', 'User registration for Robert Andres (ID: 20-22-3002) created by 20-22-5526', '20-22-5526', '2023-11-27 06:25:21', '2022-2023', 'Second Semester'),
(101, 'User Registration', 'User registration for Jomari Bacolod (ID: 20-22-6430) created by 20-22-5526', '20-22-5526', '2023-11-27 06:27:04', '2022-2023', 'Second Semester'),
(102, 'User Registration', 'User registration for Bryan Baldo (ID: 20-23-8895) created by 20-22-5526', '20-22-5526', '2023-11-27 06:27:51', '2022-2023', 'Second Semester'),
(103, 'User Registration', 'User registration for John Patrick Bautista (ID: 20-04-1905) created by 20-22-5526', '20-22-5526', '2023-11-27 06:28:24', '2022-2023', 'Second Semester'),
(104, 'User Registration', 'User registration for Wilfred Belmonte (ID: 20-04-8810) created by 20-22-5526', '20-22-5526', '2023-11-27 06:31:32', '2022-2023', 'Second Semester'),
(105, 'User Registration', 'User registration for Mark James Bihay (ID: 20-22-3034) created by 20-22-5526', '20-22-5526', '2023-11-27 06:32:08', '2022-2023', 'Second Semester'),
(106, 'User Registration', 'User registration for Sharmaine Bonifacio (ID: 20-22-0331) created by 20-22-5526', '20-22-5526', '2023-11-27 06:33:00', '2022-2023', 'Second Semester'),
(107, 'User Registration', 'User registration for Russel Campillo (ID: 20-22-9206) created by 20-22-5526', '20-22-5526', '2023-11-27 06:33:45', '2022-2023', 'Second Semester'),
(108, 'User Registration', 'User registration for Glennzoe Carabbacan (ID: 20-04-8126) created by 20-22-5526', '20-22-5526', '2023-11-27 06:34:32', '2022-2023', 'Second Semester'),
(109, 'User Registration', 'User registration for Kaizen Castillo (ID: 20-22-2313) created by 20-22-5526', '20-22-5526', '2023-11-27 06:35:11', '2022-2023', 'Second Semester'),
(110, 'User Registration', 'User registration for Maria Erlyn Crisostomo (ID: 20-22-0651) created by 20-22-5526', '20-22-5526', '2023-11-27 06:35:40', '2022-2023', 'Second Semester'),
(111, 'User Registration', 'User registration for Jose Marie De Vera (ID: 20-22-5170) created by 20-22-5526', '20-22-5526', '2023-11-27 06:36:23', '2022-2023', 'Second Semester'),
(112, 'User Registration', 'User registration for Glory Ann Del Rosario (ID: 20-22-1058) created by 20-22-5526', '20-22-5526', '2023-11-27 06:36:47', '2022-2023', 'Second Semester'),
(113, 'User Registration', 'User registration for Jason Delumen (ID: 20-22-5550) created by 20-22-5526', '20-22-5526', '2023-11-27 06:37:19', '2022-2023', 'Second Semester'),
(114, 'User Registration', 'User registration for Jian Yuri Diocales (ID: 20-22-4421) created by 20-22-5526', '20-22-5526', '2023-11-27 06:37:54', '2022-2023', 'Second Semester'),
(115, 'User Registration', 'User registration for Kim Cyrel Doble (ID: 20-22-6860) created by 20-22-5526', '20-22-5526', '2023-11-27 06:38:31', '2022-2023', 'Second Semester'),
(116, 'User Registration', 'User registration for Carrie Abelaine Duterte (ID: 20-22-5199) created by 20-22-5526', '20-22-5526', '2023-11-27 06:39:04', '2022-2023', 'Second Semester'),
(117, 'User Registration', 'User registration for Kian Lance Estrada (ID: 20-22-3611) created by 20-22-5526', '20-22-5526', '2023-11-27 06:41:16', '2022-2023', 'Second Semester'),
(118, 'User Registration', 'User registration for Cris Lorenz Gamit (ID: 20-22-1329) created by 20-22-5526', '20-22-5526', '2023-11-27 06:43:07', '2022-2023', 'Second Semester'),
(119, 'User Registration', 'User registration for Crizzelle Jhoy Gonong (ID: 20-22-2992) created by 20-22-5526', '20-22-5526', '2023-11-27 06:43:45', '2022-2023', 'Second Semester'),
(120, 'User Registration', 'User registration for Rose Mary Jane Icban (ID: 20-22-0123) created by 20-22-5526', '20-22-5526', '2023-11-27 06:44:28', '2022-2023', 'Second Semester'),
(121, 'User Registration', 'User registration for Jia Mae Inosanto (ID: 20-22-9085) created by 20-22-5526', '20-22-5526', '2023-11-27 06:44:59', '2022-2023', 'Second Semester'),
(122, 'Comlab Usage', 'Ticket No 775446 status updated to approve by Admin: Christian Alemania Leguiz', '20-22-5526', '2023-11-27 07:12:28', '2022-2023', 'Second Semester'),
(123, 'Equipment Request', 'Ticket No 148461 status updated to approve by Admin: Christian Alemania Leguiz ', '20-22-5526', '2023-11-27 07:12:35', '2022-2023', 'Second Semester'),
(124, 'Repair Request', 'Ticket No 532164 status updated to reject with reason: No available projectors.. 11/27/23 03:13pm by Admin: Christian Alemania Leguiz', '20-22-5526', '2023-11-27 07:13:36', '2022-2023', 'Second Semester'),
(125, 'Comlab Usage', 'Ticket No 955296 status updated to approve by Admin: Christian Alemania Leguiz', '20-22-5526', '2023-11-27 07:14:01', '2022-2023', 'Second Semester'),
(126, 'Equipment Request', 'Ticket No 887050 status updated to approve by Admin: Christian Alemania Leguiz ', '20-22-5526', '2023-11-27 07:14:08', '2022-2023', 'Second Semester'),
(127, 'Repair Request Feedback', 'Ticket No 284200 feedback send: I could only visit it on Nov 30, dont use it for the moment..  by Admin: Christian Alemania Leguiz', '20-22-5526', '2023-11-27 07:15:14', '2022-2023', 'Second Semester'),
(128, 'Comlab Usage', 'Ticket No 373220 status updated to approve by Admin: Christian Alemania Leguiz', '20-22-5526', '2023-11-27 07:23:17', '2021-2022', 'First Semester'),
(129, 'Repair Request', 'Ticket No 582092 status updated to resolved by Admin: Christian Alemania Leguiz ', '20-22-5526', '2023-11-27 07:23:26', '2021-2022', 'First Semester'),
(130, 'Equipment Request', 'Ticket No 014751 status updated to reject with reason: Not available at the moment. by Admin: Christian Alemania Leguiz', '20-22-5526', '2023-11-27 07:23:45', '2021-2022', 'First Semester'),
(131, 'Comlab Usage', 'Ticket No 795571 status updated to approve by Admin: Christian Alemania Leguiz', '20-22-5526', '2023-11-27 07:24:11', '2021-2022', 'First Semester'),
(132, 'Equipment Request', 'Ticket No 238253 status updated to approve by Admin: Christian Alemania Leguiz ', '20-22-5526', '2023-11-27 07:24:15', '2021-2022', 'First Semester'),
(133, 'Repair Request', 'Ticket No 133298 status updated to reject with reason: Hahaha. 11/27/23 03:24pm by Admin: Christian Alemania Leguiz', '20-22-5526', '2023-11-27 07:24:34', '2021-2022', 'First Semester'),
(134, 'Add Schedules', 'Add Schedule for Holiday from 11/27/23 12:00am, to 11/28/23 12:00am by: christian alemania leguiz', '20-22-5526', '2023-11-27 07:25:50', '2021-2022', 'First Semester'),
(135, 'Add Schedules', 'Add Schedule for Holiday from 11/27/23 12:00am, to 11/28/23 12:00am by: christian alemania leguiz', '20-22-5526', '2023-11-27 07:31:44', '2021-2022', 'First Semester'),
(136, 'Add Schedules', 'Add Schedule for OCCUPIED from 11/18/23 12:00am, to 11/19/23 12:00am by: christian alemania leguiz', '20-22-5526', '2023-11-27 07:32:30', '2021-2022', 'First Semester'),
(137, 'Add Schedules', 'Add Schedule for OCCUPIED from 11/25/23 12:00am, to 11/26/23 12:00am by: christian alemania leguiz', '20-22-5526', '2023-11-27 07:32:49', '2021-2022', 'First Semester'),
(138, 'Comlab Usage', 'Ticket No 085926 status updated to reject with reason: Dont request here by Admin: Christian Alemania Leguiz ', '20-22-5526', '2023-11-27 07:34:56', '2021-2022', 'First Semester'),
(139, 'Comlab Usage', 'Ticket No 339835 status updated to approve by Admin: Christian Alemania Leguiz', '20-22-5526', '2023-11-27 07:35:05', '2021-2022', 'First Semester'),
(140, 'Comlab Usage', 'Ticket No 405405 status updated to approve by Admin: Christian Alemania Leguiz', '20-22-5526', '2023-11-27 07:35:07', '2021-2022', 'First Semester'),
(141, 'Add Schedules', 'Add Schedule for OCCUPIED from 11/16/23 12:00am, to 11/17/23 12:00am by: christian alemania leguiz', '20-22-5526', '2023-11-27 07:35:30', '2021-2022', 'First Semester'),
(142, 'Add Schedules', 'Add Schedule for OCCUPIED from 11/18/23 12:00am, to 11/19/23 12:00am by: christian alemania leguiz', '20-22-5526', '2023-11-27 07:35:56', '2021-2022', 'First Semester'),
(143, 'Equipment Request', 'Ticket No 298922 status updated to approve by Admin: Christian Alemania Leguiz ', '20-22-5526', '2023-11-27 07:38:22', '2021-2022', 'First Semester'),
(144, 'Repair Request', 'Ticket No 586872 status updated to resolved by Admin: Christian Alemania Leguiz ', '20-22-5526', '2023-11-27 07:38:53', '2021-2022', 'First Semester'),
(145, 'Comlab Usage', 'Ticket No 137983 status updated to reject with reason: Dont request here. by Admin: Christian Alemania Leguiz ', '20-22-5526', '2023-11-27 07:39:53', '2021-2022', 'First Semester');

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
('John Patrick', 'Bautista', 'Bumagat', '20-04-1905', 'IT41', '$2y$10$m.rG8m23WaNThom6HzURBODUQxfvWqIC0NYU0ijghMj6QhjRZ9KB2', 'student', '2021-2022', 'First Semester', '2023-11-27 07:16:44'),
('Glennzoe', 'Carabbacan', 'Balingit', '20-04-8126', 'IT41', '$2y$10$svy8TI3psBk86P6m5fxFSeBx6SEGXvLp1xwzbctcfVo9SWjXFxpSu', 'student', '2021-2022', 'First Semester', '2023-11-27 07:16:44'),
('Wilfred', 'Belmonte', NULL, '20-04-8810', 'IT41', '$2y$10$H84HWhkGFROFCzzcXFBcfupPo/gNVjtL/iKzFH8pHxRgIknQ4Hd32', 'student', '2021-2022', 'First Semester', '2023-11-27 07:16:44'),
('Rose Mary Jane', 'Icban', 'Molina', '20-22-0123', 'IT41', '$2y$10$pBSNzn5W8YhUdfPluFms4ehIA.SM.bbrD3DzcUurBeO4gd/hAMZcS', 'student', '2021-2022', 'First Semester', '2023-11-27 14:22:10'),
('Sharmaine', 'Bonifacio', 'Gatchalian', '20-22-0331', 'IT41', '$2y$10$8bvDOXGdNoAkARadIes4texrC47TR9yOblPyvDX7dmszZSC.xniTm', 'student', '2021-2022', 'First Semester', '2023-11-27 07:16:44'),
('Maria Erlyn', 'Crisostomo', 'Oliveros', '20-22-0651', 'IT41', '$2y$10$oYy.aqZHiE5gGIp4rTSZNei6KORqO75NZyTqiYMRMCfKoX06wRc6i', 'student', '2021-2022', 'First Semester', '2023-11-27 07:16:44'),
('Glory Ann', 'Del Rosario', 'Soriano', '20-22-1058', 'IT41', '$2y$10$A8yppTudC5HB5L4sMoBjLOHFjiPVoPyju6RG4P38JMXjcBNFBLTx6', 'student', '2021-2022', 'First Semester', '2023-11-27 07:16:44'),
('Cris Lorenz', 'Gamit', NULL, '20-22-1329', 'IT41', '$2y$10$3FQRaFSYufExD83NNttwWuZEci0eNwWTzk87YfcoLopb4Nz2y3STe', 'student', '2021-2022', 'First Semester', '2023-11-27 07:16:44'),
('Kaizen', 'Castillo', 'Malaluan', '20-22-2313', 'IT41', '$2y$10$G9tsubuUQC3cwCWAWdzt9.G.raaXAe4gqSvaVgBqAkAFiXKS9Kf1C', 'student', '2021-2022', 'First Semester', '2023-11-27 07:16:44'),
('Crizzelle Jhoy', 'Gonong', NULL, '20-22-2992', 'IT41', '$2y$10$KRrzsSv3ePKplcTTaEoOlOMAh.pcGlvofG44nbcZ0Z47rDhhrQHB6', 'student', '2021-2022', 'First Semester', '2023-11-27 07:16:44'),
('Robert', 'Andres', 'Andres', '20-22-3002', 'IT41', '$2y$10$G68OPhO.BYoERbOQDA4f3OCH79hKaGaeHIaYVabH0wIqitkmJY3b.', 'student', '2021-2022', 'First Semester', '2023-11-27 07:16:44'),
('Mark James', 'Bihay', 'Zamudio', '20-22-3034', 'IT41', '$2y$10$oSz7DQ0cXqnY1pqs10TdyOSJFz623ZVnEStFClpt/x7uWdnXOVy0G', 'student', '2021-2022', 'First Semester', '2023-11-27 07:16:44'),
('Kian Lance', 'Estrada', NULL, '20-22-3611', 'IT41', '$2y$10$9YHkPbYBVKNEWD530VM5lu5z/O7u1oELP6buh7wvpOCxQpd7qPt6S', 'student', '2021-2022', 'First Semester', '2023-11-27 07:16:44'),
('Jian Yuri', 'Diocales', 'Lisondra', '20-22-4421', 'IT41', '$2y$10$WpJiTrXZQEOMFXnPqhScJeQcLQp5d2CTdbkWao7RFbImhHbYvll.G', 'student', '2021-2022', 'First Semester', '2023-11-27 07:16:44'),
('Jose Marie', 'De Vera', 'Ruiz', '20-22-5170', 'IT41', '$2y$10$yDlD9GrnfsyfHl9bjiXwwudAS4Kp5bIrvQmpva4nW5zsSaafbls1u', 'student', '2021-2022', 'First Semester', '2023-11-27 07:16:44'),
('Carrie Abelaine', 'Duterte', 'Recto', '20-22-5199', 'IT41', '$2y$10$xczFVPYdaiytDQxj.jPp0O9IVEWvnBU07PWgyJp9biMsenMLezZQK', 'student', '2021-2022', 'First Semester', '2023-11-27 07:16:44'),
('christian', 'leguiz', 'alemania', '20-22-5526', NULL, '$2y$10$H2KMIfpDloVVpVcUzayqr.QPHRqBb/izVj/JvuY1hiifmLxL7PFDm', 'admin', '2021-2022', 'First Semester', '2023-11-27 07:16:44'),
('Jason', 'Delumen', 'Broquista', '20-22-5550', 'IT41', '$2y$10$KWNYPWtaHcI//8KqT135/.y0YjK5pp2UqALuLXLfKN/e9VnZpBY2G', 'student', '2021-2022', 'First Semester', '2023-11-27 07:16:44'),
('Jomari', 'Bacolod', 'Gonzales', '20-22-6430', 'IT41', '$2y$10$ub5uZXWh3w.bC74DsRIUUOpN3uq/b0mOkBHU0nP7stNdfE6DNZ/uW', 'student', '2021-2022', 'First Semester', '2023-11-27 07:16:44'),
('Yna', 'Agulto', 'Tacbalan', '20-22-6486', 'IT41', '$2y$10$zzWtncFbjTuXAQAUwWbVyOUYEHARx7WOUWdBf.qurZv0iaMOC0CzW', 'student', '2021-2022', 'First Semester', '2023-11-27 07:16:44'),
('Shadrach Messach', 'Alviza', 'Aler', '20-22-6522', 'IT41', '$2y$10$48kxGbFlK/8caZ7KA1AiiO0Q7E0emzWiydLIq.zYMfSmkaaoj1IxS', 'student', '2021-2022', 'First Semester', '2023-11-27 07:16:44'),
('Kim Cyrel', 'Doble', 'Clarin', '20-22-6860', 'IT41', '$2y$10$C/lHbeBwA8lO/snRVSnFN.N3Uh5CCs/W3S.RUeET1Dwi69UScypfW', 'student', '2021-2022', 'First Semester', '2023-11-27 07:16:44'),
('Lisette', 'Agati', 'De Leon', '20-22-6901', 'IT41', '$2y$10$Q1VhIIsdJ9BymNASnenxW.fllTMap54R0PqMGFA/ls2tHn2P/gYG.', 'student', '2021-2022', 'First Semester', '2023-11-27 07:16:44'),
('Jia Mae', 'Inosanto', 'Arboleda', '20-22-9085', 'IT41', '$2y$10$AqrSGWVRIOV/YfeC508wFuG6bC.X/MxIxS3sWptooR/nETnp3obl2', 'student', '2021-2022', 'First Semester', '2023-11-27 07:16:44'),
('Russel', 'Campillo', 'Gabilan', '20-22-9206', 'IT41', '$2y$10$.2prNtsqid201Y5t7hUFzOdZmjARb862lJ0aEcfux7E2/Tr2jfC0a', 'student', '2021-2022', 'First Semester', '2023-11-27 07:16:44'),
('Bryan', 'Baldo', 'Magaso', '20-23-8895', 'IT41', '$2y$10$083uPobUTkwars7rrkqIhOUx/oFVb5ExqhXYSEe/MmFO5JeT1srHe', 'student', '2021-2022', 'First Semester', '2023-11-27 07:16:44');

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
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `complab_schedules`
--
ALTER TABLE `complab_schedules`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `system_logs`
--
ALTER TABLE `system_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

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
