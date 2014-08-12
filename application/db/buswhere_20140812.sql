-- phpMyAdmin SQL Dump
-- version 4.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 12, 2014 at 01:25 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `buswhere`
--

-- --------------------------------------------------------

--
-- Table structure for table `bus_schedules`
--

CREATE TABLE IF NOT EXISTS `bus_schedules` (
`bus_scheduleID` int(11) NOT NULL,
  `bus_StopServiceID` int(11) NOT NULL,
  `arrivalTime` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `bus_schedules`
--

INSERT INTO `bus_schedules` (`bus_scheduleID`, `bus_StopServiceID`, `arrivalTime`, `timestamp`) VALUES
(1, 19, '2014-08-12 19:45:22', '2014-08-12 08:23:22'),
(2, 29, '2014-08-12 16:47:26', '2014-08-12 08:23:22'),
(3, 13, '2014-08-12 13:30:36', '2014-08-12 08:23:37'),
(4, 19, '2014-08-12 17:00:00', '2014-08-12 09:02:20'),
(5, 19, '2014-08-12 17:05:00', '2014-08-12 09:02:20'),
(6, 19, '2014-08-12 17:10:00', '2014-08-12 09:02:20');

-- --------------------------------------------------------

--
-- Table structure for table `bus_services`
--

CREATE TABLE IF NOT EXISTS `bus_services` (
  `bus_serviceID` char(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bus_services`
--

INSERT INTO `bus_services` (`bus_serviceID`) VALUES
('106'),
('111'),
('12'),
('124'),
('128'),
('130'),
('133'),
('14'),
('145'),
('14e'),
('16'),
('162'),
('162M'),
('167'),
('171'),
('174'),
('174e'),
('175'),
('190'),
('197'),
('1N'),
('2'),
('2N'),
('32'),
('33'),
('36'),
('3N'),
('48'),
('4N'),
('502'),
('502A'),
('51'),
('518'),
('518A'),
('57'),
('5N'),
('61'),
('63'),
('65'),
('6N'),
('7'),
('700'),
('700A'),
('77'),
('80'),
('850E'),
('851'),
('951E'),
('960'),
('971E'),
('972'),
('980'),
('NR6'),
('NR7');

-- --------------------------------------------------------

--
-- Table structure for table `bus_stops`
--

CREATE TABLE IF NOT EXISTS `bus_stops` (
  `bus_stopID` char(11) NOT NULL,
  `name` char(50) NOT NULL,
  `add_street` char(100) NOT NULL,
  `lat` text NOT NULL,
  `lon` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bus_stops`
--

INSERT INTO `bus_stops` (`bus_stopID`, `name`, `add_street`, `lat`, `lon`) VALUES
('01039', 'Nth Bridge Commercial Cplx', 'North Bridge Road', '1.298217', '103.855475'),
('01112', 'Opp Bugis Junction', 'Victoria St', '1.300153', '103.855237'),
('01119', 'Bugis Junction', 'Victoria St', '1.299600', '103.855121'),
('01541', 'Aft Beach Rd', 'Rochor Rd', '1.299032', '103.857246'),
('08031', 'Dhoby Ghaut Stn', 'Penang Rd', '1.298285', '103.845237'),
('08057', 'Dhoby Ghaut Stn', 'Orchard Rd', '1.299326', '103.845312');

-- --------------------------------------------------------

--
-- Table structure for table `bus_StopsServices`
--

CREATE TABLE IF NOT EXISTS `bus_StopsServices` (
`bus_StopServiceID` int(11) NOT NULL,
  `bus_stopID` char(5) NOT NULL,
  `bus_serviceID` char(5) NOT NULL,
  `from_placeID` int(11) NOT NULL,
  `to_placeID` int(11) NOT NULL,
  `time_firstBus` time NOT NULL,
  `time_lastBus` time NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=90 ;

--
-- Dumping data for table `bus_StopsServices`
--

INSERT INTO `bus_StopsServices` (`bus_StopServiceID`, `bus_stopID`, `bus_serviceID`, `from_placeID`, `to_placeID`, `time_firstBus`, `time_lastBus`) VALUES
(1, '01541', '48', 3, 4, '05:00:00', '23:00:00'),
(2, '01541', '57', 3, 4, '05:00:00', '23:00:00'),
(3, '01039', '7', 3, 4, '05:00:00', '23:00:00'),
(4, '01039', '32', 3, 4, '05:00:00', '23:00:00'),
(5, '01039', '51', 3, 4, '05:00:00', '23:00:00'),
(6, '01039', '61', 3, 4, '05:00:00', '23:00:00'),
(7, '01039', '63', 4, 3, '05:00:00', '23:00:00'),
(8, '01039', '80', 3, 4, '05:00:00', '23:00:00'),
(9, '01039', '145', 3, 4, '05:00:00', '23:00:00'),
(10, '01039', '175', 3, 4, '05:00:00', '23:00:00'),
(11, '01039', '197', 3, 4, '05:00:00', '23:00:00'),
(12, '01039', '851', 3, 4, '05:00:00', '23:00:00'),
(13, '01119', '2', 3, 4, '05:00:00', '23:00:00'),
(14, '01119', '12', 4, 3, '05:00:00', '23:00:00'),
(15, '01119', '33', 3, 4, '05:00:00', '23:00:00'),
(16, '01119', '130', 3, 4, '05:00:00', '23:00:00'),
(17, '01119', '133', 3, 4, '05:00:00', '23:00:00'),
(18, '01119', '960', 3, 4, '05:00:00', '23:00:00'),
(19, '01119', 'NR7', 3, 4, '05:00:00', '23:00:00'),
(20, '01112', '7', 3, 4, '05:00:00', '23:00:00'),
(21, '01112', '12', 3, 4, '05:00:00', '23:00:00'),
(22, '01112', '63', 3, 4, '05:00:00', '23:00:00'),
(23, '01112', '80', 3, 4, '05:00:00', '23:00:00'),
(24, '01112', '175', 3, 4, '05:00:00', '23:00:00'),
(25, '01112', '197', 4, 3, '05:00:00', '23:00:00'),
(26, '01112', '851', 3, 4, '05:00:00', '23:00:00'),
(27, '01112', '960', 3, 4, '05:00:00', '23:00:00'),
(28, '01112', '980', 3, 4, '05:00:00', '23:00:00'),
(29, '01112', 'NR7', 3, 4, '05:00:00', '23:00:00'),
(30, '08031', '7', 3, 4, '05:00:00', '23:00:00'),
(31, '08031', '14', 4, 3, '05:00:00', '23:00:00'),
(32, '08031', '14e', 3, 4, '05:00:00', '23:00:00'),
(33, '08031', '16', 3, 4, '05:00:00', '23:00:00'),
(34, '08031', '36', 3, 4, '05:00:00', '23:00:00'),
(35, '08031', '65', 3, 4, '05:00:00', '23:00:00'),
(36, '08031', '77', 3, 4, '05:00:00', '23:00:00'),
(37, '08031', '106', 3, 4, '05:00:00', '23:00:00'),
(38, '08031', '111', 3, 4, '05:00:00', '23:00:00'),
(39, '08031', '124', 3, 4, '05:00:00', '23:00:00'),
(40, '08031', '128', 4, 3, '05:00:00', '23:00:00'),
(41, '08031', '162', 3, 4, '05:00:00', '23:00:00'),
(42, '08031', '162M', 3, 4, '05:00:00', '23:00:00'),
(43, '08031', '167', 3, 4, '05:00:00', '23:00:00'),
(44, '08031', '171', 4, 3, '05:00:00', '23:00:00'),
(45, '08031', '174', 4, 3, '05:00:00', '23:00:00'),
(46, '08031', '174e', 4, 3, '05:00:00', '23:00:00'),
(47, '08031', '175', 3, 4, '05:00:00', '23:00:00'),
(48, '08031', '190', 4, 3, '05:00:00', '23:00:00'),
(49, '08031', '700', 3, 4, '05:00:00', '23:00:00'),
(50, '08031', '700A', 3, 4, '05:00:00', '23:00:00'),
(51, '08031', '850E', 3, 4, '05:00:00', '23:00:00'),
(52, '08031', '951E', 3, 4, '05:00:00', '23:00:00'),
(53, '08031', '971E', 3, 4, '05:00:00', '23:00:00'),
(54, '08031', '972', 3, 4, '05:00:00', '23:00:00'),
(55, '08057', '1N', 3, 4, '05:00:00', '23:00:00'),
(56, '08057', '2N', 3, 4, '05:00:00', '23:00:00'),
(57, '08057', '3N', 3, 4, '05:00:00', '23:00:00'),
(58, '08057', '4N', 3, 4, '05:00:00', '23:00:00'),
(59, '08057', '5N', 3, 4, '05:00:00', '23:00:00'),
(60, '08057', '6N', 3, 4, '05:00:00', '23:00:00'),
(61, '08057', '7', 3, 4, '05:00:00', '23:00:00'),
(62, '08057', '14', 3, 4, '05:00:00', '23:00:00'),
(63, '08057', '14e', 4, 3, '05:00:00', '23:00:00'),
(64, '08057', '16', 4, 3, '05:00:00', '23:00:00'),
(65, '08057', '36', 4, 3, '05:00:00', '23:00:00'),
(66, '08057', '77', 3, 4, '05:00:00', '23:00:00'),
(67, '08057', '106', 4, 3, '05:00:00', '23:00:00'),
(68, '08057', '111', 4, 3, '05:00:00', '23:00:00'),
(69, '08057', '124', 4, 3, '05:00:00', '23:00:00'),
(70, '08057', '128', 3, 4, '05:00:00', '23:00:00'),
(71, '08057', '162', 3, 4, '05:00:00', '23:00:00'),
(72, '08057', '162M', 4, 3, '05:00:00', '23:00:00'),
(73, '08057', '167', 4, 3, '05:00:00', '23:00:00'),
(74, '08057', '171', 3, 4, '05:00:00', '23:00:00'),
(75, '08057', '174', 3, 4, '05:00:00', '23:00:00'),
(76, '08057', '174e', 3, 4, '05:00:00', '23:00:00'),
(77, '08057', '175', 4, 3, '05:00:00', '23:00:00'),
(78, '08057', '190', 3, 4, '05:00:00', '23:00:00'),
(79, '08057', '502', 3, 4, '05:00:00', '23:00:00'),
(80, '08057', '502A', 3, 4, '05:00:00', '23:00:00'),
(81, '08057', '518', 3, 4, '05:00:00', '23:00:00'),
(82, '08057', '518A', 3, 4, '05:00:00', '23:00:00'),
(83, '08057', '700', 3, 4, '05:00:00', '23:00:00'),
(84, '08057', '700A', 3, 4, '05:00:00', '23:00:00'),
(85, '08057', '850E', 3, 4, '05:00:00', '23:00:00'),
(86, '08057', '951E', 3, 4, '05:00:00', '23:00:00'),
(87, '08057', '972', 3, 4, '05:00:00', '23:00:00'),
(88, '08057', 'NR6', 3, 4, '05:00:00', '23:00:00'),
(89, '08057', 'NR7', 3, 4, '05:00:00', '23:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `developer_accounts`
--

CREATE TABLE IF NOT EXISTS `developer_accounts` (
`accountID` int(11) NOT NULL,
  `access_key` blob NOT NULL,
  `secret_key` blob NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `developer_accounts`
--

INSERT INTO `developer_accounts` (`accountID`, `access_key`, `secret_key`, `is_active`) VALUES
(1, 0x7a38654a45384d636176384d49394c7952485446667766616137335656345452, 0x467271686f556d644662425157462b4158462b4f3470517575564673355164776a752b6a2f75416f6d6b6e3871326f485955507773724462304131414239515a5542322f39304f64342b2b39583238463065576c4c576764396f576f454a46793136537a39694f546a7a655075514b6b38494451646c622b7554686d79484859, 1);

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE IF NOT EXISTS `places` (
`placeID` int(11) NOT NULL,
  `name` char(100) NOT NULL,
  `add_street` char(100) DEFAULT NULL,
  `add_block` char(5) DEFAULT NULL,
  `add_building` char(100) DEFAULT NULL,
  `add_postal` int(6) NOT NULL,
  `lat` text NOT NULL,
  `lon` text NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `places`
--

INSERT INTO `places` (`placeID`, `name`, `add_street`, `add_block`, `add_building`, `add_postal`, `lat`, `lon`) VALUES
(1, 'Bugis Junction', '200 Victoria St', NULL, 'Bugis Junction', 188021, '1.299476', '103.855773'),
(2, 'Plaza Singapura', '68 Orchard Rd', NULL, 'Plaza Singapura', 238839, '1.300797', '103.845058'),
(3, 'Jurong East Temp Int', '10 Jurong East Street 12', NULL, NULL, 609690, '1.333370', '103.741563'),
(4, 'Woodlands Reg Int', '1 Woodlands Square', NULL, NULL, 738099, '1.436605', '103.785861');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bus_schedules`
--
ALTER TABLE `bus_schedules`
 ADD PRIMARY KEY (`bus_scheduleID`);

--
-- Indexes for table `bus_services`
--
ALTER TABLE `bus_services`
 ADD PRIMARY KEY (`bus_serviceID`);

--
-- Indexes for table `bus_stops`
--
ALTER TABLE `bus_stops`
 ADD PRIMARY KEY (`bus_stopID`);

--
-- Indexes for table `bus_StopsServices`
--
ALTER TABLE `bus_StopsServices`
 ADD PRIMARY KEY (`bus_StopServiceID`), ADD UNIQUE KEY `bus_stopID` (`bus_stopID`,`bus_serviceID`);

--
-- Indexes for table `developer_accounts`
--
ALTER TABLE `developer_accounts`
 ADD PRIMARY KEY (`accountID`);

--
-- Indexes for table `places`
--
ALTER TABLE `places`
 ADD PRIMARY KEY (`placeID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bus_schedules`
--
ALTER TABLE `bus_schedules`
MODIFY `bus_scheduleID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `bus_StopsServices`
--
ALTER TABLE `bus_StopsServices`
MODIFY `bus_StopServiceID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=90;
--
-- AUTO_INCREMENT for table `developer_accounts`
--
ALTER TABLE `developer_accounts`
MODIFY `accountID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `places`
--
ALTER TABLE `places`
MODIFY `placeID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
