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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
