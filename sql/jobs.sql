-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2026 at 07:12 PM
-- Server version: 10.11.16-MariaDB
-- PHP Version: 8.3.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `synapse_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `job_ref` varchar(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `salary_min` int(11) NOT NULL,
  `salary_max` int(11) NOT NULL,
  `reports_to` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `employment` varchar(30) NOT NULL,
  `responsibilities` text NOT NULL,
  `essential` text NOT NULL,
  `preferable` text NOT NULL,
  `closing_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`job_ref`, `title`, `description`, `salary_min`, `salary_max`, `reports_to`, `location`, `employment`, `responsibilities`, `essential`, `preferable`, `closing_date`) VALUES
('FE001', 'Front-End Web Developer', 'Develop responsive and accessible pages for patient booking and healthcare information platforms.', 85000, 100000, 'Head of Digital Engineering', 'Melbourne VIC (hybrid)', 'Full-time', 'Build responsive web pages.\nTest keyboard and screen-reader accessibility.\nValidate HTML and CSS.\nFollow secure coding practices.', 'Strong HTML5 and CSS3 knowledge.\nUnderstanding of web accessibility.\nExperience with Git and GitHub.', 'Healthcare technology experience.\nFamiliarity with Jira and Agile.', '2026-11-30'),
('UX002', 'UX Designer – Patient Experience', 'Design accessible experiences for patients booking appointments and accessing health information.', 90000, 105000, 'Design Lead, Patient Platforms', 'Melbourne VIC (hybrid)', 'Full-time', 'Research patient needs.\nCreate wireframes and prototypes.\nConduct usability testing.\nCheck colour contrast and readability.', 'Experience with Figma.\nUnderstanding of accessibility guidelines.\nExperience with user research.', 'Healthcare design experience.\nExperience working with Agile teams.', '2026-11-30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`job_ref`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
