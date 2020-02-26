-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 26, 2020 at 02:49 AM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bikinibottombuddies`
--

-- --------------------------------------------------------

--
-- Table structure for table `gender`
--

CREATE TABLE IF NOT EXISTS `gender` (
  `gender_id` tinyint(1) NOT NULL,
  `sex` varchar(6) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gender`
--

INSERT INTO `gender` (`gender_id`, `sex`) VALUES
(2, 'female');

-- --------------------------------------------------------

--
-- Table structure for table `months`
--

CREATE TABLE IF NOT EXISTS `months` (
  `month_id` tinyint(2) NOT NULL,
  `month` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `months`
--

INSERT INTO `months` (`month_id`, `month`) VALUES
(1, 'january'),
(2, 'february'),
(3, 'march'),
(4, 'april'),
(5, 'may'),
(6, 'june'),
(7, 'july'),
(8, 'august'),
(9, 'september'),
(10, 'october'),
(11, 'november'),
(12, 'december');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE IF NOT EXISTS `profile` (
  `user_id` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `first_name` varchar(40) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `month` tinyint(2) NOT NULL,
  `day` int(2) NOT NULL,
  `year` int(4) NOT NULL,
  `password` varchar(40) NOT NULL,
  `picture` varchar(164) NOT NULL DEFAULT '0',
  `IG_AccessToken` varchar(250) NOT NULL,
  `IG_Private` tinyint(1) NOT NULL DEFAULT '1',
  `hash` varchar(32) NOT NULL,
  `temp_pwd` varchar(8) NOT NULL DEFAULT '0',
  `active` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`user_id`, `email`, `gender`, `first_name`, `last_name`, `month`, `day`, `year`, `password`, `picture`, `IG_AccessToken`, `IG_Private`, `hash`, `temp_pwd`, `active`) VALUES
(1, 'bxbnelson@gmail.com', 2, 'Spongebob', 'Squarepants', 7, 17, 1999, '11a11fa0eeee9c6c2f40f3922083b45320ffed6f', 'bikinibottom.jpg', 'IGQVJVaGZAoRENpQWtXOWU3bk1lb01hZAmtBR2pVZA0E3WTJsczhVV0NobmJMNnRzYjhrZA2ZAhYjh1NE52WW5ndDh3MnV2TzlvdW9NeVlYeWZAiV1pEVkpFSVI2RTBxekRUVkxGeGwwUXBR', 0, '2b24d495052a8ce66358eb576b8912c8', '0', 1),
(2, 'texastornado@gmail.com', 2, 'Sandy', 'Cheeks', 7, 17, 1999, '5673041ad99da73cfefa170a7081c0daed5d97b6', 'sandycheeks.jpeg', '', 1, '', '0', 0),
(3, '', 1, 'Patrick', 'Star', 7, 17, 1999, '', 'patrickstar.jpeg', '', 1, '', '0', 0),
(4, '', 1, 'Squidward', 'Squid', 7, 17, 1999, '', 'squidward.jpeg', '', 1, '', '0', 0),
(5, '', 1, 'Mr. King', 'Krabs', 7, 17, 1999, '', 'krabs.jpeg', '', 1, '', '0', 0),
(6, '', 2, 'Pearl', 'Krabs', 7, 17, 1999, '', 'pearl.jpeg', '', 1, '', '0', 0),
(7, '', 2, 'Mrs. Puff', 'Pufferfish', 7, 17, 1999, '', 'mrspuff.jpeg', '', 1, '', '0', 0),
(8, '', 1, 'Gary', 'Snail', 7, 17, 1999, '', 'gary.jpeg', '', 1, '', '0', 0),
(9, 'bxbearfield@gmail.com', 1, 'Diona', 'Morganson', 6, 15, 1989, '9d90557d86a93d64cd54505c230854dcffe77bcf', '0', 'IGQVJYdWZAjNjJ5dXpwT1hOODVPc0pzSFVTcW1naUVIdU5Vbzc1cXR3bEZAfSnNjYlBjaHkyUEx5LXRyT0R6RFdHd2ZAqcEZAUMEZAaZAEg0SVlVWkdNX2ZAVcHlMaWxGeUpUSzhLS0FELTNn', 0, '872488f88d1b2db54d55bc8bba2fad1b', 'MW9qwVN4', 1),
(10, 'xbearfield@gmail.com', 1, 'Briana', 'Bearfield', 10, 18, 1989, 'a9c836f8f1fe8923b5ec45204f083bda874a867e', '0', '', 1, 'd2ed45a52bc0edfa11c2064e9edee8bf', '0', 1),
(13, 'xavierbearfield@gmail.com', 1, 'Briana', 'Bearfield', 10, 18, 1989, 'a9c836f8f1fe8923b5ec45204f083bda874a867e', '0', '', 1, 'cee631121c2ec9232f3a2f028ad5c89b', '0', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gender`
--
ALTER TABLE `gender`
  ADD PRIMARY KEY (`gender_id`);

--
-- Indexes for table `months`
--
ALTER TABLE `months`
  ADD PRIMARY KEY (`month_id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `fk_gender_id` (`gender`) USING BTREE,
  ADD KEY `fk_month_id` (`month`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gender`
--
ALTER TABLE `gender`
  MODIFY `gender_id` tinyint(1) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `months`
--
ALTER TABLE `months`
  MODIFY `month_id` tinyint(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `gender`
--
ALTER TABLE `gender`
  ADD CONSTRAINT `fk_gender_id` FOREIGN KEY (`gender_id`) REFERENCES `profile` (`gender`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `fk_month_id` FOREIGN KEY (`month`) REFERENCES `months` (`month_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
