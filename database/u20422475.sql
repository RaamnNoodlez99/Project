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
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int NOT NULL,
  `user_id` int NOT NULL,
  `event_id` int NOT NULL,
  `comment` varchar(10000) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `user_id`, `event_id`, `comment`, `date`) VALUES
(1, 1, 1, 'First!', '2022-10-07');

-- --------------------------------------------------------

--
-- Table structure for table `eventInfo`
--

CREATE TABLE `eventInfo` (
  `event_info_id` int NOT NULL,
  `event_id` int NOT NULL,
  `user_id` int NOT NULL,
  `rating` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `eventInfo`
--

INSERT INTO `eventInfo` (`event_info_id`, `event_id`, `user_id`, `rating`) VALUES
(1, 1, 1, 'like');

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
(1, 1, 'Firefist Ace!', 'two.jpeg', 'Portgas D. Ace, born as Gol D. Ace and nicknamed Fire Fist Ace, was the sworn older brother of Luffy and Sabo, and the biological son of the late Pirate King, Gol D. Roger, and Portgas D. Rouge. Ace was adopted by Monkey D. Garp, as had been requested by Roger before his execution. Ace was the 2nd division commander of the Whitebeard Pirates and one-time captain of the Spade Pirates. Something new', '2011-01-11', 'New York', 'onePiece Luffy John Shiken! '),
(2, 1, 'From Akira', '409058.jpg', 'Akira was a turning point for anime', '1946-04-06', 'Japan', 'anime akira awesome'),
(3, 2, 'Ace', 'one.jpeg', 'Portgas D. Ace, born as Gol D. Ace and nicknamed Fire Fist Ace, was the sworn older brother of Luffy and Sabo, and the biological son of the late Pirate King, Gol D. Roger, and Portgas D. Rouge. Ace was adopted by Monkey D. Garp, as had been requested by Roger before his execution. Ace was the 2nd division commander of the Whitebeard Pirates and one-time captain of the Spade Pirates.', '2022-02-02', 'South Africa', ''),
(4, 2, 'My cool artwork!', 'four.jpg', 'I made this myself, please support my insta: @me123', '2009-01-01', 'USA', 'cool great'),
(5, 1, 'cool ship', '4108258.jpg', 'this is a pretty drawing with a really cool ship!', '2008-09-09', 'somewhere', 'ship cool'),
(6, 2, 'pretty eyes', 'image_processing20220912-135670-1itfhee.jpeg', 'Some of the best anime eyes out there! p.s. why does global protect not work! >:(', '2022-09-09', 'IDK', 'idk why yes'),
(8, 1, 'New event', '4108258.jpg', 'test test', '2022-10-03', 'Somewhere', 'something ');

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
  `profile_image` varchar(10000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `friends` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `about_me` text,
  `requests` varchar(1000) DEFAULT NULL,
  `work` text,
  `relationship` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `eventInfo`
--
ALTER TABLE `eventInfo`
  ADD PRIMARY KEY (`event_info_id`);

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
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `eventInfo`
--
ALTER TABLE `eventInfo`
  MODIFY `event_info_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
