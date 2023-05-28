-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2023 at 06:15 PM
-- Server version: 10.3.13-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lending_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `agent_commision`
--

CREATE TABLE `agent_commision` (
  `id` int(7) NOT NULL,
  `agent_account_number` int(8) NOT NULL,
  `unique_code` varchar(8) NOT NULL,
  `commision` float NOT NULL,
  `lender_id` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `agent_commision`
--

INSERT INTO `agent_commision` (`id`, `agent_account_number`, `unique_code`, `commision`, `lender_id`) VALUES
(9, 15573764, 'bRaPtY33', 0.03, 1),
(10, 15573764, 'bRaPtY33', 0.03, 1);

-- --------------------------------------------------------

--
-- Table structure for table `agent_reg`
--

CREATE TABLE `agent_reg` (
  `id` int(7) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phonenumber` int(12) NOT NULL,
  `ID_Number` int(8) NOT NULL,
  `password` varchar(15) NOT NULL,
  `confirmpassword` varchar(15) NOT NULL,
  `account_number` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `agent_reg`
--

INSERT INTO `agent_reg` (`id`, `username`, `email`, `phonenumber`, `ID_Number`, `password`, `confirmpassword`, `account_number`) VALUES
(2, 'Gaudencia', 'gaudenciaotara@gmail.com', 791958185, 12345678, '1234', '1234', 15573764),
(3, 'Rita', 'rita@gmail.com', 783946274, 12345698, '1234', '1234', 27847326),
(4, 'tony', 'tony@gmail.com', 733121212, 12345, '1234', '1234', 35372487),
(5, 'Alex', 'alex@gmail.com', 742441412, 12340987, '1234', '1234', 21701801);

-- --------------------------------------------------------

--
-- Table structure for table `agent_returns`
--

CREATE TABLE `agent_returns` (
  `id` int(7) NOT NULL,
  `unique_code` varchar(8) NOT NULL,
  `lender_id` int(8) NOT NULL,
  `agent_account_number` int(8) NOT NULL,
  `total_amount` float NOT NULL,
  `expected_commision` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `agent_returns`
--

INSERT INTO `agent_returns` (`id`, `unique_code`, `lender_id`, `agent_account_number`, `total_amount`, `expected_commision`) VALUES
(1, 'bRaPtY33', 1, 15573764, 1.12, 0.03),
(2, 'bRaPtY33', 1, 15573764, 1.12, 0.03),
(3, 'bRaPtY33', 1, 15573764, 1.12, 0.03),
(4, 'zLCpxlK8', 1, 15573764, 0.56, 0.02);

-- --------------------------------------------------------

--
-- Table structure for table `agent_transaction`
--

CREATE TABLE `agent_transaction` (
  `id` int(11) NOT NULL COMMENT 'Primary Key',
  `transaction_time` datetime DEFAULT current_timestamp() COMMENT 'Create Time',
  `transaction_name` varchar(55) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `amount` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `customer_money`
--

CREATE TABLE `customer_money` (
  `id` int(7) NOT NULL,
  `customer_number` int(11) NOT NULL DEFAULT 0,
  `amount_lent` float NOT NULL,
  `unique_code` varchar(8) NOT NULL,
  `expected_interest` float NOT NULL,
  `total_amount` float NOT NULL,
  `agent_id` int(11) NOT NULL DEFAULT 0,
  `time_allocated` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_money`
--

INSERT INTO `customer_money` (`id`, `customer_number`, `amount_lent`, `unique_code`, `expected_interest`, `total_amount`, `agent_id`, `time_allocated`) VALUES
(5, 791958185, 1, 'bRaPtY33', 0, 1, 2, '12:48:32'),
(6, 791958185, 0, 'bRaPtY33', 0, 0, 2, '13:27:35'),
(7, 791958185, 0, 'bRaPtY33', 0.06, 1, 2, '13:33:14'),
(8, 791958185, 0, 'bRaPtY33', 0.01, 0, 2, '13:33:52'),
(9, 791958185, 0, 'bRaPtY33', 0.05, 0.45, 2, '13:35:29'),
(10, 791958185, 0.5, 'bRaPtY33', 0.06, 0.56, 2, '13:36:56'),
(11, 791958185, 0.5, 'bRaPtY33', 0.06, 0.56, 2, '13:41:52'),
(12, 791958185, 0.5, 'bRaPtY33', 0.06, 0.56, 2, '13:42:35'),
(13, 791958185, 0.6, '5fjvZk7b', 0, 0, 2, '13:59:08'),
(14, 791958185, 1, 'bRaPtY33', 0.12, 1.12, 2, '14:04:42'),
(15, 791958185, 1, 'bRaPtY33', 0.12, 1.12, 2, '14:18:29'),
(16, 791958185, 1, 'bRaPtY33', 0, 0, 2, '15:54:31'),
(17, 791958185, 0.7, 'QgL4fuaV', 0.08, 0.78, 2, '18:08:00'),
(18, 791958185, 0.5, 'zLCpxlK8', 0.06, 0.56, 2, '08:45:57'),
(19, 791958185, 1, 'SH5h3ZIo', 0.12, 1.12, 2, '08:50:01'),
(20, 791958185, 8, '5fjvZk7b', 0.96, 8.96, 2, '08:55:03'),
(21, 705910408, 2, 'SH5h3ZIo', 0.24, 2.24, 2, '11:05:11'),
(22, 705910408, 2, 'QgL4fuaV', 0.24, 2.24, 2, '11:06:45'),
(23, 791958185, 0.3, 'bRaPtY33', 0.04, 0.34, 2, '15:27:11');

-- --------------------------------------------------------

--
-- Table structure for table `customer_reg`
--

CREATE TABLE `customer_reg` (
  `id` int(7) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phonenumber` int(12) NOT NULL,
  `ID_Number` int(8) NOT NULL,
  `password` varchar(15) NOT NULL,
  `confirmpassword` varchar(15) NOT NULL,
  `account_number` int(7) NOT NULL,
  `updated_balance` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_reg`
--

INSERT INTO `customer_reg` (`id`, `username`, `email`, `phonenumber`, `ID_Number`, `password`, `confirmpassword`, `account_number`, `updated_balance`) VALUES
(2, 'Gaudencia ', 'gaudenciaotara@gmail.com', 791958185, 12345678, '1234', '1234', 41533800, 0),
(3, 'Mary', 'mary@gmail.com', 783946273, 12345683, '1234', '1234', 56038027, 0);

-- --------------------------------------------------------

--
-- Table structure for table `customer_returns`
--

CREATE TABLE `customer_returns` (
  `id` int(7) NOT NULL,
  `agent_id` int(7) NOT NULL,
  `amount_sent` float NOT NULL,
  `unique_code` varchar(8) NOT NULL,
  `expected_interest` float NOT NULL,
  `customer_id` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_returns`
--

INSERT INTO `customer_returns` (`id`, `agent_id`, `amount_sent`, `unique_code`, `expected_interest`, `customer_id`) VALUES
(7, 2, 1.12, 'bRaPtY33', 0.12, 2),
(8, 2, 0.56, 'zLCpxlK8', 0.06, 2),
(9, 2, 0.78, 'QgL4fuaV', 0.08, 2),
(10, 2, 0.78, 'QgL4fuaV', 0.08, 2),
(11, 2, 0.45, 'bRaPtY33', 0.05, 2);

-- --------------------------------------------------------

--
-- Table structure for table `customer_top_up`
--

CREATE TABLE `customer_top_up` (
  `id` int(7) NOT NULL,
  `transaction_id` varchar(50) NOT NULL,
  `amount` float NOT NULL,
  `phonenumber` varchar(15) NOT NULL,
  `customer_id` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_top_up`
--

INSERT INTO `customer_top_up` (`id`, `transaction_id`, `amount`, `phonenumber`, `customer_id`) VALUES
(1, 'ws_CO_28052023115236517791958185', 1, '254791958185', 2),
(2, 'ws_CO_28052023115406598791958185', 1, '254791958185', 2);

-- --------------------------------------------------------

--
-- Table structure for table `lender_reg`
--

CREATE TABLE `lender_reg` (
  `id` int(7) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phonenumber` int(12) NOT NULL,
  `ID_Number` int(8) NOT NULL,
  `password` varchar(15) NOT NULL,
  `confirmpassword` varchar(15) NOT NULL,
  `updated_balance` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lender_reg`
--

INSERT INTO `lender_reg` (`id`, `username`, `email`, `phonenumber`, `ID_Number`, `password`, `confirmpassword`, `updated_balance`) VALUES
(1, 'Gaudencia', 'oranyabura@gmail.com', 791958185, 12345678, '1234', '1234', 44.66),
(2, 'lloyd', 'lloydkatila@gmail.com', 742441412, 1212, '1234', '1234', 6),
(3, 'Alex', 'alex@gmail.com', 709876543, 12348974, '1234', '1234', 6),
(4, 'Lorna', 'lorna@gmail.com', 791978965, 12983748, '1234', '1234', 6),
(5, 'Gee', 'gee@gmail.com', 783946272, 12863819, '1234', '1234', 5);

-- --------------------------------------------------------

--
-- Table structure for table `lender_transactions`
--

CREATE TABLE `lender_transactions` (
  `id` int(7) NOT NULL,
  `account_balance` int(7) DEFAULT 0,
  `agent_account_number` int(8) NOT NULL,
  `lent_amount` float NOT NULL,
  `lender_id` int(7) NOT NULL,
  `time_allocated` varchar(20) NOT NULL DEFAULT current_timestamp(),
  `unique_code` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lender_transactions`
--

INSERT INTO `lender_transactions` (`id`, `account_balance`, `agent_account_number`, `lent_amount`, `lender_id`, `time_allocated`, `unique_code`) VALUES
(36, 44, 15573764, 6.7, 1, '09:46:17', 'bRaPtY33'),
(37, 44, 15573764, 0.5, 1, '11:00:10', 'zLCpxlK8'),
(38, 44, 15573764, 5, 1, '11:37:13', '5fjvZk7b'),
(39, 44, 15573764, 4, 1, '13:10:19', 'QgL4fuaV'),
(40, 44, 15573764, 0, 1, '08:49:34', 'SH5h3ZIo'),
(41, 44, 15573764, 1, 1, '16:55:51', 'vTgpzk51'),
(42, 44, 15573764, 4, 1, '17:16:26', 'WoDiPjR6'),
(43, 44, 15573764, 3, 1, '17:24:12', 'Mi2smjfp'),
(44, 2, 15573764, 1, 3, '17:25:41', '7OoYHGcB'),
(45, 0, 15573764, 1, 3, '17:26:31', 'u6ygV2wi'),
(46, 0, 15573764, 1, 4, '17:28:05', 'sDp9WX62'),
(47, 0, 15573764, 1, 5, '17:31:32', 'DQdNwIud'),
(48, 0, 15573764, 1, 1, '17:42:50', 'aarqUAAz');

-- --------------------------------------------------------

--
-- Table structure for table `top_up`
--

CREATE TABLE `top_up` (
  `id` int(7) NOT NULL,
  `transaction_id` varchar(70) NOT NULL,
  `amount` double NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `lender_id` int(7) NOT NULL,
  `transaction_status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `top_up`
--

INSERT INTO `top_up` (`id`, `transaction_id`, `amount`, `phone_number`, `lender_id`, `transaction_status`) VALUES
(1, 'ws_CO_27052023123755361791958185', 1, '0', 0, ''),
(2, 'ws_CO_27052023124015305791958185', 1, '254791958185', 0, ''),
(3, 'ws_CO_27052023124110647791958185', 1, '254791958185', 0, ''),
(4, 'ws_CO_27052023130456807791958185', 1, '254791958185', 0, NULL),
(5, 'ws_CO_27052023130620945720226889', 1, '254720226889', 0, NULL),
(6, 'ws_CO_27052023130718849791958185', 1, '254791958185', 0, NULL),
(7, 'ws_CO_27052023132235282791958185', 1, '254791958185', 0, NULL),
(8, 'ws_CO_27052023155202951720226889', 1, '254720226889', 0, NULL),
(9, 'ws_CO_27052023173137013720226889', 1, '254720226889', 0, NULL),
(10, 'ws_CO_27052023173832276791958185', 1, '254791958185', 1, NULL),
(11, 'ws_CO_27052023175548171791958185', 1, '254791958185', 1, NULL),
(12, 'ws_CO_27052023175632386791958185', 3, '254791958185', 1, NULL),
(13, 'ws_CO_27052023181647778791958185', 60, '254791958185', 1, NULL),
(14, 'ws_CO_27052023182526736791958185', 1, '254791958185', 1, NULL),
(15, 'ws_CO_27052023182549278791958185', 3, '254791958185', 3, NULL),
(16, 'ws_CO_27052023182815219791958185', 3, '254791958185', 4, NULL),
(17, 'ws_CO_27052023183206507791958185', 6, '254791958185', 5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `updated_values`
--

CREATE TABLE `updated_values` (
  `id` int(7) NOT NULL,
  `agent_id` int(8) NOT NULL,
  `updated_balance` int(8) NOT NULL,
  `unique_code` varchar(8) NOT NULL,
  `expected_interest` float NOT NULL,
  `total_amount` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `updated_values`
--

INSERT INTO `updated_values` (`id`, `agent_id`, `updated_balance`, `unique_code`, `expected_interest`, `total_amount`) VALUES
(1, 2, 0, 'bRaPtY33', 0, 0),
(2, 2, 0, 'bRaPtY33', 0.06, 0),
(3, 2, 0, 'bRaPtY33', 0.01, 0),
(4, 2, 0, 'bRaPtY33', 0.05, 0),
(5, 2, 0, 'bRaPtY33', 0.06, 0),
(6, 2, 0, 'bRaPtY33', 0.06, 0),
(7, 2, 0, 'bRaPtY33', 0.06, 0),
(8, 2, 2, '5fjvZk7b', 0, 0),
(9, 2, 0, 'bRaPtY33', 0.12, 1),
(10, 2, -2, 'bRaPtY33', 0.12, 1),
(11, 2, -2, 'bRaPtY33', 0, 0),
(12, 2, 2, 'QgL4fuaV', 0.08, 0),
(13, 2, 0, 'zLCpxlK8', 0.06, 0),
(14, 2, 2, 'SH5h3ZIo', 0.12, 1),
(15, 2, -6, '5fjvZk7b', 0.96, 8),
(16, 2, 0, 'SH5h3ZIo', 0.24, 2),
(17, 2, 4, 'QgL4fuaV', 0.24, 2),
(18, 2, 7, 'bRaPtY33', 0.04, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agent_commision`
--
ALTER TABLE `agent_commision`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agent_reg`
--
ALTER TABLE `agent_reg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agent_returns`
--
ALTER TABLE `agent_returns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agent_transaction`
--
ALTER TABLE `agent_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_money`
--
ALTER TABLE `customer_money`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_reg`
--
ALTER TABLE `customer_reg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_returns`
--
ALTER TABLE `customer_returns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_top_up`
--
ALTER TABLE `customer_top_up`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lender_reg`
--
ALTER TABLE `lender_reg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lender_transactions`
--
ALTER TABLE `lender_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `top_up`
--
ALTER TABLE `top_up`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `updated_values`
--
ALTER TABLE `updated_values`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agent_commision`
--
ALTER TABLE `agent_commision`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `agent_reg`
--
ALTER TABLE `agent_reg`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `agent_returns`
--
ALTER TABLE `agent_returns`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `agent_transaction`
--
ALTER TABLE `agent_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key';

--
-- AUTO_INCREMENT for table `customer_money`
--
ALTER TABLE `customer_money`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `customer_reg`
--
ALTER TABLE `customer_reg`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customer_returns`
--
ALTER TABLE `customer_returns`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `customer_top_up`
--
ALTER TABLE `customer_top_up`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lender_reg`
--
ALTER TABLE `lender_reg`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lender_transactions`
--
ALTER TABLE `lender_transactions`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `top_up`
--
ALTER TABLE `top_up`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `updated_values`
--
ALTER TABLE `updated_values`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
