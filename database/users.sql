-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 07, 2022 at 04:59 AM
-- Server version: 8.0.30-0ubuntu0.20.04.2
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u20422475`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `profile_image` varchar(10000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `friends` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about_me` text,
  `requests` varchar(1000) DEFAULT NULL,
  `work` text,
  `relationship` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `surname`, `email`, `password`, `birthday`, `profile_image`, `friends`, `about_me`, `requests`, `work`, `relationship`) VALUES
(1, 'ashir', 'butt', 'abutt@gmail.com', 'password1', '2001-01-01', 'images/profiles/633dc63419aa8.png', '2 3', 'I love playing games and watching soccer\r\n                        ', '2 3', 'I work at a grocery store and stuff\n                                ', 'Rather not say'),
(2, 'John', 'Cena', 'jc@gmail.com', 'password2', '2022-08-01', 'images/profiles/633a2b893e4ab.png', 'none', 'Click here to add information!', 'none', 'Click here to add information!', 'Rather not say'),
(3, 'Hako', 'Yamazaki', 'hako@gmail.com', 'kazaguruma', '1957-05-18', 'images/profiles/633e7ecad6b4e.png', '4 5', 'Click here to add information!', 'none', 'Click here to add information!', 'Rather not say'),
(4, 'idk', 'idk', 'idk@gmail.com', 'idkkkkkkk', '2022-08-01', 'none', 'none', 'Click here to add information!', 'none', 'Click here to add information!', 'Rather not say'),
(5, 'Daniel', 'Ricardio', 'DR@gmail.com', 'IwantToG0BackToR3dBu11', '2022-08-09', 'images/profiles/633eea50867f4.png', 'none', 'Click here to add information!', 'none', 'Click here to add information!', 'Rather not say'),
(6, 'john', 'doe', 'johndoe@example.com', 'password1', '2001-01-01', 'none', '1 2', 'Click here to add information!', '1 2', 'Click here to add information!', 'Rather not say');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
