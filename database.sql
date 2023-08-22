-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2023 at 01:28 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `course-selection`
--

CREATE TABLE `course-selection` (
  `instructorid` int(12) NOT NULL,
  `subjectname` varchar(222) NOT NULL,
  `instructor` varchar(222) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course-selection`
--

INSERT INTO `course-selection` (`instructorid`, `subjectname`, `instructor`) VALUES
(31, 'physics', 'Saud Khan'),
(32, 'chemistry', 'Sherjil Gillani'),
(33, 'math', 'Shuja Pasha'),
(35, 'urdu', 'Hafeez Akhter'),
(36, 'math', 'hasnat'),
(40, 'english', 'waleed');

-- --------------------------------------------------------

--
-- Table structure for table `persons`
--

CREATE TABLE `persons` (
  `id` int(233) NOT NULL,
  `fullname` varchar(233) NOT NULL,
  `username` varchar(233) NOT NULL,
  `email` varchar(233) NOT NULL,
  `password` varchar(233) NOT NULL,
  `profession` varchar(233) NOT NULL,
  `age` int(233) NOT NULL,
  `address` varchar(233) NOT NULL,
  `phonenumber` varchar(233) NOT NULL,
  `pictureurl` varchar(233) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `persons`
--

INSERT INTO `persons` (`id`, `fullname`, `username`, `email`, `password`, `profession`, `age`, `address`, `phonenumber`, `pictureurl`) VALUES
(27, 'Hassan Ali', 'hassanali', 'hassanali@gmail.com', '$2y$10$TrIa2hpAZxp9cXpUk5fH5ufEYE3yGEeNSXHXstcZTjKYg7cjs.Elq', 'student', 0, '', '', ''),
(28, 'Abdul Wasey', 'wasey', 'wasey@gmail.com', '$2y$10$rSG47k/E5cI/WBfOLLmZz.AxQfe4fYSYDdk3xtd8LbmwrAN1/QQz6', 'student', 18, 'Pir Mehar Ali Shah Town', '03259511211', 'DSC_4476.JPG'),
(29, 'Kashan Hamayun', 'kashan', 'kashan@gmail.com', '$2y$10$5d0Vb7rnIJZ82bR57XJLSOOGIfvJCPw2Bo4QifDesj.Y44xc3T1W2', 'student', 0, '', '', ''),
(30, 'Hanzala Ahmed', 'hanzala', 'hanzala@gmail.com', '$2y$10$PepwZu9sG4pCG6NrEaimrOhkVn8Ot8WxjaqWZvl9nxhXqUgeKXhke', 'student', 0, '', '', ''),
(31, 'Saud Khan', 'saud', 'saud@gmail.com', '$2y$10$XPlJL8vhribUef1d4yDVze2TCTLjsCMKZkx1Cd7wT8jkKQuK3vpRG', 'teacher', 0, '', '', ''),
(32, 'Sherjil Gillani', 'sherjil', 'sherjil@gmail.com', '$2y$10$JHLj6VFgBAwxNNMS8dfRkO4eUjYtU8Lc72cyae9fWeJqK8UNM26Fm', 'teacher', 12, 'Pir Mehar Ali Shah Town', '03259511211', ''),
(33, 'Shuja Pasha', 'shuja', 'shuja@gmail.com', '$2y$10$rbZYqrVv/QZcvKSOlvVgtO8XN1T5VAFg7R9Ah/9eJvTDjjoKpaE9C', 'teacher', 0, '', '', ''),
(35, 'Hafeez Akhter', 'hafeez', 'hafeez@gmail.com', '$2y$10$SeFj1mDH2X/lIJUgri0vz.9.3Ey5ZUKcqcl9hsQ79YoK.M3A/a/X2', 'teacher', 0, '', '', ''),
(36, 'hasnat', 'hasnat', 'hasnat@gmail.com', '$2y$10$/TIdCXpnTBIZRWQ4wIlIne6i.PxEzpa9EMfxa6T8IYpIiX1/BA6je', 'teacher', 0, '', '', ''),
(37, 'faizan', 'faizan', 'faizan@gmail.com', '$2y$10$FHU4VhHKEgAsQZO7cDY7g.ji510pfJD1RYJgbdWQ1wbLDgBxTigAK', 'student', 20, 'I-14', '03158293924', ''),
(38, 'fahad', 'fahad', 'fahad@gmail.com', '$2y$10$gcXOfIeKoFhPFAMEg6XKouTryFEXtydQbxAfTOKdpm5ToYOcM/sNq', 'student', 15, 'Pir Mehar Ali Shah Town', '03158293924', 'FB_IMG_1591362806064.jpg'),
(39, 'usama', 'usama', 'usama@gmail.com', '$2y$10$Sl/GqKNVKRP5h4OBTQWZUOfKRyJz8HY5ErQNhBvvFbn8w4jYKJ4v6', 'student', 0, '', '', ''),
(40, 'waleed', 'waleed', 'waleed@gmail.com', '$2y$10$lQ1vdPP/VBIkRRca.RJE..Nuy9Dob2KFOxgm1LYAG1Wamjq9obbWa', 'teacher', 0, '', '', ''),
(41, 'akmal', 'akmal', 'akmal@gmail.com', '$2y$10$KPcgw9m9mY5l9SNGODQX9ugPP2EJ2o9JXvIeYrI3pFwty21dRXRVq', 'student', 0, '', '', ''),
(42, 'hasan123', 'hasan123', 'HASAN@GMAIL.COM', '$2y$10$pOGpwPtxl59o4XXMxQfuneGOCmUxrGpt04aJWqa68LVHDOu.eWmMG', 'student', 0, '', '', ''),
(43, 'soudan', 'soudan', 'soudan@gmail.com', '$2y$10$2VcplyHDwUAZBQkFVSux3ePHNS7T2yWW9CbRmQmScSvpE7VZfHfoS', 'student', 0, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `student_id` int(12) NOT NULL,
  `chemistry` int(12) NOT NULL,
  `physics` int(12) NOT NULL,
  `math` int(12) NOT NULL,
  `english` int(12) NOT NULL,
  `urdu` int(12) NOT NULL,
  `chemistry_instr_id` int(12) NOT NULL,
  `physics_instr_id` int(12) NOT NULL,
  `math_instr_id` int(12) NOT NULL,
  `english_instr_id` int(12) NOT NULL,
  `urdu_instr_id` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`student_id`, `chemistry`, `physics`, `math`, `english`, `urdu`, `chemistry_instr_id`, `physics_instr_id`, `math_instr_id`, `english_instr_id`, `urdu_instr_id`) VALUES
(28, 50, 45, 19, 100, 19, 32, 31, 33, 40, 35),
(41, 89, 78, 66, 46, 67, 32, 31, 33, 40, 35);

-- --------------------------------------------------------

--
-- Table structure for table `teacher-selection`
--

CREATE TABLE `teacher-selection` (
  `id` int(233) NOT NULL,
  `stname` varchar(233) NOT NULL,
  `physics` int(233) NOT NULL,
  `chemistry` int(233) NOT NULL,
  `math` int(233) NOT NULL,
  `urdu` int(233) NOT NULL,
  `english` int(233) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher-selection`
--

INSERT INTO `teacher-selection` (`id`, `stname`, `physics`, `chemistry`, `math`, `urdu`, `english`) VALUES
(28, 'Abdul Wasey', 31, 32, 33, 35, 40),
(37, 'faizan', 31, 32, 36, 35, 34),
(39, 'usama', 31, 32, 33, 35, 40),
(41, 'akmal', 31, 32, 33, 35, 40);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course-selection`
--
ALTER TABLE `course-selection`
  ADD PRIMARY KEY (`instructorid`);

--
-- Indexes for table `persons`
--
ALTER TABLE `persons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `teacher-selection`
--
ALTER TABLE `teacher-selection`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `persons`
--
ALTER TABLE `persons`
  MODIFY `id` int(233) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `student_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course-selection`
--
ALTER TABLE `course-selection`
  ADD CONSTRAINT `course-selection_ibfk_1` FOREIGN KEY (`instructorid`) REFERENCES `persons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_6` FOREIGN KEY (`student_id`) REFERENCES `teacher-selection` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `teacher-selection`
--
ALTER TABLE `teacher-selection`
  ADD CONSTRAINT `teacher-selection_ibfk_1` FOREIGN KEY (`id`) REFERENCES `persons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
