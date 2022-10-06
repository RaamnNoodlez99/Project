-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 02, 2022 at 04:46 AM
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
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` varchar(10000) NOT NULL,
  `date` date NOT NULL,
  `location` varchar(255) NOT NULL,
  `hashtags` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `user_id`, `name`, `image`, `description`, `date`, `location`, `hashtags`) VALUES
(1, 2, 'Firefist Ace', 'two.jpeg', 'Portgas D. Ace, born as Gol D. Ace and nicknamed Fire Fist Ace, was the sworn older brother of Luffy and Sabo, and the biological son of the late Pirate King, Gol D. Roger,  and Portgas D. Rouge. Ace was adopted by Monkey D. Garp, as had been requested by Roger before his execution. Ace was the 2nd division commander of the Whitebeard Pirates and one-time captain of the Spade Pirates.', '2011-01-16', 'Atlanta', 'onePiece Luffy Ace Shiken!'),
(2, 2, 'I Don\'t Know', 'three.jpg', 'apparently something that makes sense', '2001-01-01', 'Wakanda', 'hashtag'),
(3, 2, 'Ace', 'one.jpeg', 'Portgas D. Ace, born as Gol D. Ace and nicknamed Fire Fist Ace, was the sworn older brother of Luffy and Sabo, and the biological son of the late Pirate King, Gol D. Roger, and Portgas D. Rouge. Ace was adopted by Monkey D. Garp, as had been requested by Roger before his execution. Ace was the 2nd division commander of the Whitebeard Pirates and one-time captain of the Spade Pirates.', '2022-02-02', 'South Africa', 'husbando'),
(4, 2, 'My cool artwork!', 'four.jpg', 'I made this myself, please support my insta: @me123', '2009-09-09', 'USA', 'cool great'),
(5, 2, 'YAYAYA', 'two.jpeg', 'yess!!', '2008-09-09', 'somewhere', 'jack');

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
  `birthday` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `surname`, `email`, `password`, `birthday`) VALUES
(2, 'ashir', 'butt', 'abutt@gmail.com', 'password1', '2001-01-01'),
(3, 'John', 'Cena', 'jc@gmail.com', 'password2', '2022-08-01'),
(4, 'Hako', 'Yamazaki', 'hako@gmail.com', 'kazaguruma', '1957-05-18'),
(5, 'idk', 'idk', 'idk@gmail.com', 'idkkkkkkk', '2022-08-01'),
(6, 'Daniel', 'Ricardio', 'DR@gmail.com', 'IwantToG0BackToR3dBu11', '2022-08-09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
