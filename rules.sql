-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2023 at 02:13 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
  `company_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `policy_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `endorsement_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `A1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `B1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `C1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `D1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `E1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `F1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `G1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `H1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `I1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `J1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `K1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `L1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `M1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `N1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `O1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `P1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Q1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `R1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `S1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `T1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `U1` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `template_rules`
--

INSERT INTO `template_rules` (`id`, `company_id`, `policy_type`, `endorsement_type`, `A1`, `B1`, `C1`, `D1`, `E1`, `F1`, `G1`, `H1`, `I1`, `J1`, `K1`, `L1`, `M1`, `N1`, `O1`, `P1`, `Q1`, `R1`, `S1`, `T1`, `U1`) VALUES
(3, '319', '107', 'addition_deletion', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(4, '327', '108', 'addition_deletion', '', '', 'L1', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
