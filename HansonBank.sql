-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 14, 2017 at 05:56 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `HansonBank`
--

-- --------------------------------------------------------

--
-- Table structure for table `Beneficiary`
--

CREATE TABLE `Beneficiary` (
  `beneficiary_id` int(100) NOT NULL,
  `sender_id` varchar(100) NOT NULL,
  `sender_name` varchar(50) NOT NULL,
  `receiver_id` varchar(100) NOT NULL,
  `receiver_name` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Beneficiary`
--

INSERT INTO `Beneficiary` (`beneficiary_id`, `sender_id`, `sender_name`, `receiver_id`, `receiver_name`, `status`) VALUES
(1, '1', 'Rohan', '2', 'nivin', 'PENDING');

-- --------------------------------------------------------

--
-- Table structure for table `credit_nivin`
--

CREATE TABLE `credit_nivin` (
  `credittransactionid` int(10) NOT NULL,
  `credittransactiondate` date DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `debit` float(10,2) DEFAULT NULL,
  `credit` float(10,2) DEFAULT NULL,
  `balance` float(10,2) DEFAULT NULL,
  `narration` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `credit_nivin`
--

INSERT INTO `credit_nivin` (`credittransactionid`, `credittransactiondate`, `name`, `debit`, `credit`, `balance`, `narration`) VALUES
(1, '2017-08-13', 'nivin', 0.00, 1000.00, 1000.00, 'Account Open');

-- --------------------------------------------------------

--
-- Table structure for table `credit_Rohan`
--

CREATE TABLE `credit_Rohan` (
  `credittransactionid` int(10) NOT NULL,
  `credittransactiondate` date DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `debit` float(10,2) DEFAULT NULL,
  `credit` float(10,2) DEFAULT NULL,
  `balance` float(10,2) DEFAULT NULL,
  `narration` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `credit_Rohan`
--

INSERT INTO `credit_Rohan` (`credittransactionid`, `credittransactiondate`, `name`, `debit`, `credit`, `balance`, `narration`) VALUES
(1, '2017-08-12', 'Rohan', 0.00, 1000.00, 1000.00, 'Account Open'),
(4, '2017-08-13', 'Rohan', 100.00, 0.00, 900.00, 'Online Shopping(Nivin&Group)'),
(5, '2017-08-13', 'Rohan', 100.00, 0.00, 800.00, 'Online Shopping(Nivin&Group)'),
(6, '2017-08-13', 'Rohan', 100.00, 0.00, 700.00, 'Online Shopping(Nivin&Group)'),
(7, '2017-08-13', 'Rohan', 100.00, 0.00, 600.00, 'Online Shopping(Nivin&Group)'),
(8, '2017-08-13', 'Rohan', 100.00, 0.00, 500.00, 'Online Shopping(Nivin&Group)'),
(9, '2017-08-13', 'Rohan', 100.00, 0.00, 400.00, 'Online Shopping(Nivin&Group)'),
(10, '2017-08-13', 'Rohan', 100.00, 0.00, 300.00, 'Online Shopping(Nivin&Group)'),
(11, '2017-08-13', 'Rohan', 100.00, 0.00, 200.00, 'Online Shopping(Nivin&Group)'),
(12, '2017-08-13', 'Rohan', 100.00, 0.00, 100.00, 'Online Shopping(Nivin&Group)'),
(13, '2017-08-13', 'Rohan', 0.00, 1000.00, 1100.00, 'Paid'),
(14, '2017-08-13', 'Rohan', 0.00, 500.00, 1600.00, 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `hansonCustomer`
--

CREATE TABLE `hansonCustomer` (
  `customer_id` int(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `dob` date NOT NULL,
  `type` varchar(10) NOT NULL,
  `address` varchar(200) NOT NULL,
  `mobile` int(10) NOT NULL,
  `last_login` varchar(100) DEFAULT 'First time login Don''t forgot to change password...'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hansonCustomer`
--

INSERT INTO `hansonCustomer` (`customer_id`, `name`, `lastname`, `gender`, `dob`, `type`, `address`, `mobile`, `last_login`) VALUES
(1, 'Rohan', 'Patel', 'Male', '1995-04-17', 'Savings', '826 Brimorton dr.', 2147483647, 'Sunday 13th of August 2017 04:54:15 AM'),
(2, 'nivin', 'Bose', 'Male', '1995-04-01', 'Savings', '826 Brimorton dr.', 2147483647, 'Monday 14th of August 2017 12:29:04 AM');

-- --------------------------------------------------------

--
-- Table structure for table `hansonUsers`
--

CREATE TABLE `hansonUsers` (
  `user_id` int(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hansonUsers`
--

INSERT INTO `hansonUsers` (`user_id`, `name`, `email`, `username`, `password`) VALUES
(1, 'Rohan', 'rohanrockerspatel001@gmail.com', 'rohan', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5'),
(2, 'nivin', 'nivin@gmail.com', 'nivin', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5');

-- --------------------------------------------------------

--
-- Table structure for table `hansonUsersNumbers`
--

CREATE TABLE `hansonUsersNumbers` (
  `user_id` int(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `debitnumber` varchar(50) NOT NULL,
  `creditnumber` varchar(50) NOT NULL,
  `accountnumber` varchar(50) NOT NULL,
  `cvv` int(5) NOT NULL,
  `expdate` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hansonUsersNumbers`
--

INSERT INTO `hansonUsersNumbers` (`user_id`, `name`, `debitnumber`, `creditnumber`, `accountnumber`, `cvv`, `expdate`) VALUES
(1, 'Rohan', '7907618641987491', '1391585853366048', '3615949128', 668, '1/24'),
(2, 'nivin', '9595279523376889', '1299278230457977', '6255004568', 884, '01/24');

-- --------------------------------------------------------

--
-- Table structure for table `passbook_nivin`
--

CREATE TABLE `passbook_nivin` (
  `transactionid` int(10) NOT NULL,
  `transactiondate` date DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `withdrawl` float(10,2) DEFAULT NULL,
  `deposit` float(10,2) DEFAULT NULL,
  `balance` float(10,2) DEFAULT NULL,
  `narration` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `passbook_nivin`
--

INSERT INTO `passbook_nivin` (`transactionid`, `transactiondate`, `name`, `withdrawl`, `deposit`, `balance`, `narration`) VALUES
(1, '2017-08-13', 'nivin', 0.00, 20000.00, 20000.00, 'Account Open');

-- --------------------------------------------------------

--
-- Table structure for table `passbook_Rohan`
--

CREATE TABLE `passbook_Rohan` (
  `transactionid` int(10) NOT NULL,
  `transactiondate` date DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `withdrawl` float(10,2) DEFAULT NULL,
  `deposit` float(10,2) DEFAULT NULL,
  `balance` float(10,2) DEFAULT NULL,
  `narration` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `passbook_Rohan`
--

INSERT INTO `passbook_Rohan` (`transactionid`, `transactiondate`, `name`, `withdrawl`, `deposit`, `balance`, `narration`) VALUES
(1, '2017-08-12', 'Rohan', 0.00, 10000.00, 10000.00, 'Account Open'),
(2, '2017-08-13', 'Rohan', 100.00, 0.00, 9900.00, 'Online Shopping'),
(6, '2017-08-13', 'Rohan', 1000.00, 0.00, 8900.00, 'Paid in Credit'),
(7, '2017-08-13', 'Rohan', 300.00, 0.00, 8600.00, 'Online Shopping(Nivin&Group)'),
(8, '2017-08-13', 'Rohan', 500.00, 0.00, 8100.00, 'Paid in Credit'),
(9, '2017-08-14', 'Rohan', 0.00, 500.00, 8600.00, 'e-transfer(By )'),
(10, '2017-08-14', 'Rohan', 0.00, 500.00, 9100.00, 'e-transfer(By yernar)'),
(11, '2017-08-14', 'Rohan', 0.00, 500.00, 9600.00, 'e-transfer(By yernar)'),
(12, '2017-08-14', 'Rohan', 0.00, 500.00, 10100.00, 'e-transfer(By yernar)');

-- --------------------------------------------------------

--
-- Table structure for table `shoppingTrack`
--

CREATE TABLE `shoppingTrack` (
  `id` int(20) NOT NULL,
  `date` varchar(10) NOT NULL,
  `customername` varchar(50) NOT NULL,
  `cardnumber` varchar(50) NOT NULL,
  `amountpaid` varchar(50) NOT NULL,
  `narration` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shoppingTrack`
--

INSERT INTO `shoppingTrack` (`id`, `date`, `customername`, `cardnumber`, `amountpaid`, `narration`) VALUES
(1, '2017-08-13', 'Rohan', '1391585853366048', '100', 'Online Shopping(Nivin&Group)'),
(2, '2017-08-13', 'Rohan', '7907618641987491', '300', 'Online Shopping(Nivin&Group)');

-- --------------------------------------------------------

--
-- Table structure for table `tokenOnline`
--

CREATE TABLE `tokenOnline` (
  `token_id` int(20) NOT NULL,
  `token` varchar(50) NOT NULL,
  `customer_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `TransferFromOther`
--

CREATE TABLE `TransferFromOther` (
  `transfer_id` int(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `amount` varchar(50) NOT NULL,
  `securityquestion` varchar(100) NOT NULL,
  `securityanswer` varchar(100) NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `sendername` varchar(50) NOT NULL,
  `senderemail` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `TransferFromOther`
--

INSERT INTO `TransferFromOther` (`transfer_id`, `name`, `email`, `amount`, `securityquestion`, `securityanswer`, `status`, `sendername`, `senderemail`) VALUES
(1, 'Rohan', 'rohanrockerspatel001@gmail.com', '500', 'hosuse no?', '826', 'TRANSFER A', 'yernar', 'yernar@gmail.com'),
(2, 'Rohan', 'rohanrockerspatel001@gmail.com', '500', 'house no?', '826', 'REJECTED', 'nivin', 'nivin@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL,
  `last_login` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `username`, `password`, `last_login`) VALUES
(1, 'Rohan Patel', 'rohanrockerspatel001@gmail.com', 'rohan402', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 'Friday 11th of August 2017 06:53:23 AM');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Beneficiary`
--
ALTER TABLE `Beneficiary`
  ADD PRIMARY KEY (`beneficiary_id`);

--
-- Indexes for table `credit_nivin`
--
ALTER TABLE `credit_nivin`
  ADD PRIMARY KEY (`credittransactionid`);

--
-- Indexes for table `credit_Rohan`
--
ALTER TABLE `credit_Rohan`
  ADD PRIMARY KEY (`credittransactionid`);

--
-- Indexes for table `hansonCustomer`
--
ALTER TABLE `hansonCustomer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `hansonUsers`
--
ALTER TABLE `hansonUsers`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `hansonUsersNumbers`
--
ALTER TABLE `hansonUsersNumbers`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `passbook_nivin`
--
ALTER TABLE `passbook_nivin`
  ADD PRIMARY KEY (`transactionid`);

--
-- Indexes for table `passbook_Rohan`
--
ALTER TABLE `passbook_Rohan`
  ADD PRIMARY KEY (`transactionid`);

--
-- Indexes for table `shoppingTrack`
--
ALTER TABLE `shoppingTrack`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tokenOnline`
--
ALTER TABLE `tokenOnline`
  ADD PRIMARY KEY (`token_id`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Indexes for table `TransferFromOther`
--
ALTER TABLE `TransferFromOther`
  ADD PRIMARY KEY (`transfer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Beneficiary`
--
ALTER TABLE `Beneficiary`
  MODIFY `beneficiary_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `credit_nivin`
--
ALTER TABLE `credit_nivin`
  MODIFY `credittransactionid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `credit_Rohan`
--
ALTER TABLE `credit_Rohan`
  MODIFY `credittransactionid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `hansonCustomer`
--
ALTER TABLE `hansonCustomer`
  MODIFY `customer_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `hansonUsers`
--
ALTER TABLE `hansonUsers`
  MODIFY `user_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `hansonUsersNumbers`
--
ALTER TABLE `hansonUsersNumbers`
  MODIFY `user_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `passbook_nivin`
--
ALTER TABLE `passbook_nivin`
  MODIFY `transactionid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `passbook_Rohan`
--
ALTER TABLE `passbook_Rohan`
  MODIFY `transactionid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `shoppingTrack`
--
ALTER TABLE `shoppingTrack`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tokenOnline`
--
ALTER TABLE `tokenOnline`
  MODIFY `token_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `TransferFromOther`
--
ALTER TABLE `TransferFromOther`
  MODIFY `transfer_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
