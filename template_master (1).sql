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
-- Table structure for table `template_master`
--

CREATE TABLE `template_master` (
  `id` int(11) NOT NULL,
  `company` varchar(255) NOT NULL,
  `member` varchar(255) NOT NULL,
  `age` varchar(255) NOT NULL,
  `si` varchar(255) NOT NULL,
  `mode` varchar(255) NOT NULL,
  `doj` varchar(255) NOT NULL,
  `dol` varchar(255) NOT NULL,
  `edd` varchar(255) NOT NULL,
  `company_id` int(11) NOT NULL,
  `policy_type` varchar(255) NOT NULL,
  `endorsement_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `template_master`
--

INSERT INTO `template_master` (`id`, `company`, `member`, `age`, `si`, `mode`, `doj`, `dol`, `edd`, `company_id`, `policy_type`, `endorsement_type`) VALUES
(4, 'Corporate', 'employee', 'age', 'sum insured', 'A- AdditionD - DeletionC -Change', 'Date of joining', 'Date of Leaving', '', 324, '110', 'addition_deletion'),
(5, 'Corporate', 'member', 'age', 'sum insured', 'A- AdditionD - DeletionC -Change', 'Date of joining', 'Date of Leaving', '', 334, '110', 'deletion'),
(6, 'Corporate', 'employee', 'age', 'sum insured', 'A- AdditionD - DeletionC -Change', 'Date of joining', 'Date of Leaving', '', 323, '107', 'addition'),
(7, 'c1', 'e1', 'age1', 'si1', 'A- AdditionD - DeletionC -Change', 'doj1', 'dol1', 'edd1', 330, '113', 'addition');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `template_master`
--
ALTER TABLE `template_master`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `template_master`
--
ALTER TABLE `template_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
