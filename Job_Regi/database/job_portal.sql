-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2025 at 07:10 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `job_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$s5mtGDZ/vn8/x.fX4p5TNOavbYDwqygDWyuzvvEDYUpHpyfDBRoQ6');

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(50) NOT NULL COMMENT 'Unique identifier for each application',
  `full_name` varchar(100) NOT NULL COMMENT 'Applicant''s full name',
  `email` varchar(50) NOT NULL COMMENT 'Applicant''s email address',
  `phone` varchar(15) NOT NULL COMMENT 'Applicant''s phone number',
  `gender` enum('Male','Female','Other') NOT NULL COMMENT 'Applicant''s gender',
  `position` varchar(50) NOT NULL COMMENT 'Applicant''s phone number',
  `expected_salary` decimal(10,2) DEFAULT NULL COMMENT 'Expected Salary(optional)',
  `start_date` date DEFAULT NULL COMMENT 'Availability to start(optional)',
  `resume_path` varchar(255) DEFAULT NULL COMMENT 'path to upload resume file',
  `cover_letter` text DEFAULT NULL COMMENT 'Applicant''s cover letter',
  `linkedin_profile` varchar(255) DEFAULT NULL COMMENT 'URL to LinkedIn profile',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Date and time of submission',
  `experience_type` enum('Fresher','Experienced') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `full_name`, `email`, `phone`, `gender`, `position`, `expected_salary`, `start_date`, `resume_path`, `cover_letter`, `linkedin_profile`, `created_at`, `experience_type`) VALUES
(32, 'Prathmesh38', 'prathmesh.bagal38@gmail.com', '9325124971', 'Male', 'PHP/Wordpress Developer', 55200.00, '2025-01-01', '../uploads/My Resume_1736326859.pdf', '', '', '2025-01-08 09:00:59', 'Fresher'),
(33, 'Prathmesh39', 'prathmesh.bagal39@gmail.com', '9876543282', 'Male', 'PHP/Wordpress Developer', 15222.00, '2025-01-01', '../uploads/My Resume_1736327347.pdf', '', '', '2025-01-08 09:09:07', 'Fresher'),
(35, 'Prathmesh42', 'prathmesh.bagal42@gmail.com', '9874563220', 'Male', 'PHP/Wordpress Developer', 12000.00, '2025-01-24', '../uploads/My Resume 2_1736407731.pdf', '', '', '2025-01-09 07:28:51', 'Fresher'),
(36, 'Prathmesh43', 'prathmesh.bagal43@gmail.com', '+919876543245', 'Male', 'UI/UX Designer', 1500.00, '2025-01-01', '../uploads/My Resume_1736413948.pdf', '', '', '2025-01-09 09:12:28', 'Fresher'),
(37, 'Prathmesh44', 'prathmesh.bagal44@gmail.com', '+558546321745', 'Male', 'React/React Native Developer', 15000.00, '2025-01-02', '../uploads/My Resume 2_1736416462.pdf', '', '', '2025-01-09 09:54:22', 'Fresher'),
(38, 'Prathmesh46', 'prathmesh.bagal46@gmail.com', '+558521369852', 'Female', 'UI/UX Designer', 8552.00, '2025-01-30', '../uploads/My Resume 2_1736416647.pdf', '', '', '2025-01-09 09:57:27', 'Experienced');

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE `education` (
  `id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  `institute_name` varchar(255) NOT NULL,
  `degree` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `from_date` date NOT NULL,
  `to_date` date DEFAULT NULL,
  `currently_attending` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `education`
--

INSERT INTO `education` (`id`, `application_id`, `institute_name`, `degree`, `location`, `description`, `from_date`, `to_date`, `currently_attending`) VALUES
(24, 32, 'kkw', 'mca', 'nashik', '', '2025-01-01', '0000-00-00', 1),
(28, 35, 'kkw', 'mca', 'nashik', '', '2025-01-07', NULL, 1),
(29, 36, 'kkw', 'mca', 'nashik', '', '2025-01-01', NULL, 1),
(30, 37, 'kkw', 'mca', 'nashik', '', '2025-01-02', NULL, 1),
(31, 38, 'kkw', 'mca', 'nashik', '', '2025-01-08', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `experience`
--

CREATE TABLE `experience` (
  `id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `experience`
--

INSERT INTO `experience` (`id`, `application_id`, `title`, `company`, `location`, `description`, `from_date`, `to_date`) VALUES
(14, 32, '', '', '', '', '0000-00-00', '0000-00-00'),
(17, 38, 'junior dev', 'Google', 'Nashik', '', '2024-12-01', '2024-12-31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_id` (`application_id`);

--
-- Indexes for table `experience`
--
ALTER TABLE `experience`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_id` (`application_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for each application', AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `education`
--
ALTER TABLE `education`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `experience`
--
ALTER TABLE `experience`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `education`
--
ALTER TABLE `education`
  ADD CONSTRAINT `education_ibfk_1` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`);

--
-- Constraints for table `experience`
--
ALTER TABLE `experience`
  ADD CONSTRAINT `experience_ibfk_1` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
