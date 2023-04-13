-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2023 at 12:02 PM
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
-- Table structure for table `template_master`
--

CREATE TABLE `template_master` (
  `id` int(11) NOT NULL,
  `S_No` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Policy_No` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Employee_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Insured_Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Relationship_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Date_of_Birth` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Age` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Sum_Insured` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Date_of_Joining` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Date_of_Leaving` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Date_of_Marriage` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Remarks_for_Corrections` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `First_Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Last_Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Mobile_No` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Endorsement_Effective_Date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Premium_including_GST` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Wrong_DETAILS` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `salary` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_id` int(11) NOT NULL,
  `policy_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `endorsement_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `template_master`
--

INSERT INTO `template_master` (`id`, `S_No`, `Policy_No`, `mode`, `Employee_no`, `Insured_Name`, `Relationship_type`, `Date_of_Birth`, `Age`, `Sum_Insured`, `Date_of_Joining`, `Date_of_Leaving`, `Date_of_Marriage`, `Remarks_for_Corrections`, `First_Name`, `Last_Name`, `Mobile_No`, `Email`, `Endorsement_Effective_Date`, `Premium_including_GST`, `Wrong_DETAILS`, `salary`, `company_id`, `policy_type`, `endorsement_type`) VALUES
(1, 'S_No', 'Policy_No', 'A_ Addition D_Deletion C_Change', 'Employee_no', 'Insured_Name', 'Relationship_type', 'Date_of_Birth', 'Age', 'Sum_Insured', 'Date_of_Joining', 'Date_of_Leaving', 'Date_of_Marriage', 'Remarks_for_Corrections', 'First_Name', 'Last_Name', 'Mobile_No', 'Email', 'Endorsement_Effective_Date', 'Premium_including_GST', 'Wrong_DETAILS', 'salary', 319, '107', 'addition_deletion');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
