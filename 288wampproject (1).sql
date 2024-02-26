-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 15, 2022 at 04:54 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `288wampproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_courses`
--

CREATE TABLE `t_courses` (
  `ID_course` int(11) NOT NULL,
  `course_code` char(5) NOT NULL,
  `course_desc` char(60) NOT NULL,
  `course_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_courses`
--

INSERT INTO `t_courses` (`ID_course`, `course_code`, `course_desc`, `course_active`) VALUES
(1103, '42', 'Computer Science', 1),
(1104, '16', 'Math', 1),
(1108, '42', 'Geo', 0);

-- --------------------------------------------------------

--
-- Table structure for table `t_schedules`
--

CREATE TABLE `t_schedules` (
  `ID_schedule` int(11) NOT NULL,
  `ID_student` int(11) NOT NULL,
  `ID_course` int(11) NOT NULL,
  `sched_yr` int(4) NOT NULL COMMENT 'yyyy',
  `sched_sem` char(2) NOT NULL COMMENT 'FA, SP, S1, S2....',
  `grade_letter` char(2) NOT NULL COMMENT 'A+, A, A-, B+...'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_schedules`
--

INSERT INTO `t_schedules` (`ID_schedule`, `ID_student`, `ID_course`, `sched_yr`, `sched_sem`, `grade_letter`) VALUES
(13, 35, 1103, 2022, 'J1', 'A+'),
(15, 35, 1103, 2020, 'S1', 'F');

-- --------------------------------------------------------

--
-- Table structure for table `t_students`
--

CREATE TABLE `t_students` (
  `ID_student` int(11) NOT NULL,
  `fname` varchar(10) NOT NULL,
  `lname` varchar(15) NOT NULL,
  `phone` char(15) NOT NULL DEFAULT '0' COMMENT 'Format: (000)-000-0000',
  `email` char(30) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `start_dte` int(11) NOT NULL COMMENT 'Format: yyyy/mm/dd',
  `end_dte` int(11) NOT NULL COMMENT 'Format: yyyy/mm/dd'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_students`
--

INSERT INTO `t_students` (`ID_student`, `fname`, `lname`, `phone`, `email`, `status`, `start_dte`, `end_dte`) VALUES
(35, 'Sean', 'Escot', '0694', 'sde35@gmail.com', 1, 2020, 2024);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_courses`
--
ALTER TABLE `t_courses`
  ADD PRIMARY KEY (`ID_course`);

--
-- Indexes for table `t_schedules`
--
ALTER TABLE `t_schedules`
  ADD PRIMARY KEY (`ID_schedule`),
  ADD KEY `ID_student_fk` (`ID_student`),
  ADD KEY `ID_course_fk` (`ID_course`);

--
-- Indexes for table `t_students`
--
ALTER TABLE `t_students`
  ADD PRIMARY KEY (`ID_student`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_courses`
--
ALTER TABLE `t_courses`
  MODIFY `ID_course` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1109;

--
-- AUTO_INCREMENT for table `t_schedules`
--
ALTER TABLE `t_schedules`
  MODIFY `ID_schedule` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `t_students`
--
ALTER TABLE `t_students`
  MODIFY `ID_student` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `t_schedules`
--
ALTER TABLE `t_schedules`
  ADD CONSTRAINT `t_schedules_ibfk_1` FOREIGN KEY (`ID_student`) REFERENCES `t_students` (`ID_student`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_schedules_ibfk_2` FOREIGN KEY (`ID_course`) REFERENCES `t_courses` (`ID_course`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
