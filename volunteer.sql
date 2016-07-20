-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 14, 2015 at 07:15 AM
-- Server version: 5.6.25
-- PHP Version: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `volunteer`
--

-- --------------------------------------------------------

--
-- Table structure for table `organizers`
--
CREATE TABLE IF NOT EXISTS `logs` (
  `log_id` primary key int(30) NOT NULL,
  `log_time` timestamp NOT NULL,
  `log_action` varchar(100) NOT NULL,
  `log_details` varchar(250) NOT NULL
);
CREATE TABLE IF NOT EXISTS `messages` (
  `username` varchar(30) NOT NULL,
  `emailAddress` varchar(50) NOT NULL,
  `date` timestamp NOT NULL,
  `message` varchar(250) NOT NULL,
  `volunteer_response` varchar(250) NULL
);

CREATE TABLE IF NOT EXISTS `organizers` (
  `firstname` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Event Logging
-- 1. Create the logs table
-- 2. Create a function to "log" an event
--      INSERT a record in the logs table
--      pass "log action" as a parameter
--      pass "log details" as a parameter

-- log_action( "signup", "user signed up" );

--
-- Dumping data for table `organizers`
--

INSERT INTO `organizers` (`firstname`, `surname`, `username`, `password`) VALUES
('Kevin', 'Wilson', 'kevwil', 'superman'),
('Lauren', 'Walker', 'lauwal', 'wonderwoman'),
('Paul', 'Scott', 'pausco', 'batman');

-- --------------------------------------------------------

--
-- Table structure for table `tasks_table`
--

CREATE TABLE IF NOT EXISTS `tasks_table` (
  `task_id` int(30) unsigned NOT NULL,
  `task_name` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tasks_table`
--

INSERT INTO `tasks_table` (`task_id`, `task_name`) VALUES
(2, 'Admissions'),
(28, 'Catering'),
(27, 'Certificate Preparation'),
(3, 'Cleaning'),
(4, 'Crowd Control'),
(29, 'Decoration'),
(26, 'Games Organization'),
(31, 'Gifts Purchasing & Packing'),
(30, 'Set Up (Presentation, Mic, Speakers)');

-- --------------------------------------------------------

--
-- Table structure for table `time_slots`
--

CREATE TABLE IF NOT EXISTS `time_slots` (
  `timeslot_id` int(11) NOT NULL,
  `timeslot_name` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `time_slots`
--

INSERT INTO `time_slots` (`timeslot_id`, `timeslot_name`) VALUES
(1, 'Day 1, Morning'),
(2, 'Day 1, Afternoon'),
(3, 'Day 1, Night'),
(4, 'Day 2, Morning'),
(5, 'Day 2, Afternoon'),
(6, 'Day 2, Night');

-- --------------------------------------------------------

--
-- Table structure for table `volunteer_details`
--

CREATE TABLE IF NOT EXISTS `volunteer_details` (
  `volunteer_id` int(11) NOT NULL,
  `email_Address` varchar(50) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `homeaddress_line1` varchar(30) NOT NULL,
  `homeaddress_line2` varchar(30) NOT NULL,
  `suburb` varchar(30) NOT NULL,
  `postcode` int(11) NOT NULL,
  `phone_number` int(11) NOT NULL,
  `DOB` varchar(10) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `volunteer_details`
--

INSERT INTO `volunteer_details` (`volunteer_id`, `email_Address`, `first_name`, `surname`, `homeaddress_line1`, `homeaddress_line2`, `suburb`, `postcode`, `phone_number`, `DOB`, `password`) VALUES
(6, 'lydiastuff@skeenan.net', 'Lydia', 'Keenan', '334 La Paz Ct', 'Av', 'San Ramon', 94583, 2147483647, '1234/12/12', 'asdfjk'),
(17, 'charlesp@yahoo.com', 'Charles', 'Pearson', '10 Smith Street', 'North NSW', 'NEUTRAL BAY NSW', 20550, 2147483647, '1982/02/02', 'captainamerica'),
(18, 'michealj@gmail.com', 'Micheal', 'James', '5 Wattle Gr', 'South', 'YUNDERUP WA', 62080, 2147483647, '1990/05/20', '1thor1'),
(19, 'jannetm@hotmail.com', 'Jannet', 'Miller', '5 Wattle Gr', '', 'Sydney NS', 20000, 2147483647, '1975/10/10', 'wonderwoman');

-- --------------------------------------------------------

--
-- Table structure for table `volunteer_times`
--

CREATE TABLE IF NOT EXISTS `volunteer_times` (
  `vol_time_id` int(11) NOT NULL,
  `timeslot_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `details` varchar(150) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `volunteer_times`
--

INSERT INTO `volunteer_times` (`vol_time_id`, `timeslot_id`, `task_id`, `email`, `details`) VALUES
(28, 2, 4, 'hi@hi.com', 'Corral the kids'),
(29, 6, 0, 'hi@hi.com', ''),
(30, 1, 0, 'lkeenan@skeenan.net', ''),
(32, 5, 5, 'lkeenan@skeenan.net', 'Awards'),
(34, 2, 2, 'lkeenan@skeenan.net', 'Registration'),
(37, 4, 0, 'lydiastuff@skeenan.net', ''),
(38, 2, 2, 'lydiastuff@skeenan.net', 'At the main entrance'),
(39, 5, 28, 'lydiastuff@skeenan.net', 'Set the tables for serving'),
(42, 6, 1, 'lkeenan@skeenan.net', 'Clean Up'),
(44, 1, 27, 'charlesp@yahoo.com', ''),
(45, 3, 4, 'charlesp@yahoo.com', '1-4 rows'),
(46, 5, 26, 'charlesp@yahoo.com', 'Ages 10-16'),
(48, 2, 31, 'michealj@gmail.com', 'Ages 10-16 Books'),
(49, 4, 4, 'michealj@gmail.com', '4-8 rows'),
(50, 6, 0, 'michealj@gmail.com', ''),
(51, 1, 30, 'jannetm@hotmail.com', 'Computers for presentation'),
(52, 6, 26, 'jannetm@hotmail.com', 'Ages 6-10'),
(53, 4, 0, 'jannetm@hotmail.com', 'Ages 6-10 - Toys');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `organizers`
--
ALTER TABLE `organizers`
  ADD PRIMARY KEY (`firstname`);

--
-- Indexes for table `tasks_table`
--
ALTER TABLE `tasks_table`
  ADD PRIMARY KEY (`task_id`),
  ADD UNIQUE KEY `task_name` (`task_name`);

--
-- Indexes for table `time_slots`
--
ALTER TABLE `time_slots`
  ADD PRIMARY KEY (`timeslot_id`);

--
-- Indexes for table `volunteer_details`
--
ALTER TABLE `volunteer_details`
  ADD PRIMARY KEY (`volunteer_id`),
  ADD UNIQUE KEY `email_Address` (`email_Address`);

--
-- Indexes for table `volunteer_times`
--
ALTER TABLE `volunteer_times`
  ADD PRIMARY KEY (`vol_time_id`),
  ADD UNIQUE KEY `useremail_timeslot` (`timeslot_id`,`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tasks_table`
--
ALTER TABLE `tasks_table`
  MODIFY `task_id` int(30) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `time_slots`
--
ALTER TABLE `time_slots`
  MODIFY `timeslot_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `volunteer_details`
--
ALTER TABLE `volunteer_details`
  MODIFY `volunteer_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `volunteer_times`
--
ALTER TABLE `volunteer_times`
  MODIFY `vol_time_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=54;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

  INSERT INTO `event_duration` (`duration_id`, `duration_name`) VALUES
  (1, '1 day'),
  (2, '2 days'),
  (3, '3 days'),
  (4, '4 days'),
  (5, '5 days'),
  (6, '6 days'),
  (7, '7 days'),
  (8, '8 days'),
  (9, '9 days'),
  (10, '10 days'),
  (11, '11 days'),
  (12, '12 days'),
  (13, '13 days'),
  (14, '14 days'),;