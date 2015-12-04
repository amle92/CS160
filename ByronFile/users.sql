-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2015 at 04:40 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `youthcyb_cs160s2g4`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(5) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `username`, `password`, `email`) VALUES
(12, 'Andy', 'Le', 'andyle123', 'password', 'test@tets.test'),
(2, 'Sam', 'Sam', 'user1', 'password', 'bob@bob.edu'),
(3, 'Sam', 'Sam', 'sam', 'password', 'sam@sam.edu'),
(4, 'Sam', 'Sam', 'user2', 'password', 'sam@boobs.edu'),
(5, 'Ahmed', 'Syed', 'admin', 'password', 'sfhlasfl@hotmail.com'),
(6, 'Ahmed', 'Syed', 'admin1', 'password2', 'sfhlasdasfl@hotmail.com'),
(7, 'Ahmed', 'Syed', 'username', 'password', 'sahlfsafl@hotmail.com'),
(11, 'Byron', 'Custodio', 'byron123', 'password', 'test@test.test'),
(10, 'Anthony', 'Tsang', 'anthony123', 'password', 'test@test.tets');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
