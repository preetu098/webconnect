-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 12, 2023 at 11:49 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wellconnect`
--

-- --------------------------------------------------------

--
-- Table structure for table `template_rules`
--

CREATE TABLE `template_rules` (
  `id` int(11) NOT NULL,
  `company_id` varchar(255) NOT NULL,
  `policy_type` varchar(255) NOT NULL,
  `endorsement_type` varchar(255) NOT NULL,
  `A1` varchar(255) NOT NULL,
  `A1_data` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `template_rules`
--

INSERT INTO `template_rules` (`id`, `company_id`, `policy_type`, `endorsement_type`, `A1`, `A1_data`) VALUES
(1, '324', '110', 'addition_deletion', 'C1', 'C1'),
(2, '324', '110', 'addition_deletion', 'E1', 'E1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `template_rules`
--
ALTER TABLE `template_rules`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `template_rules`
--
ALTER TABLE `template_rules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
