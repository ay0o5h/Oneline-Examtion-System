-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 21, 2021 at 04:31 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `examtest1`
--

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `email` varchar(50) NOT NULL,
  `quiz_id` text NOT NULL,
  `score` int(11) NOT NULL,
  `noOfQsn` int(11) NOT NULL,
  `right` int(11) NOT NULL,
  `wrong` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`email`, `quiz_id`, `score`, `noOfQsn`, `right`, `wrong`, `date`) VALUES
('test99@mail.ru', '60eb4426a9773', 0, 3, 0, 3, '2021-07-11 21:31:40'),
('ayo99@mail.ru', '60eb4426a9773', 10, 3, 2, 1, '2021-07-11 21:37:33'),
('ayo99@mail.ru', '60eb63c6e9130', 2, 3, 1, 2, '2021-07-11 21:46:12'),
('ayo99@mail.ru', '60ec19a3ede9f', 0, 3, 0, 3, '2021-07-12 14:17:25');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `quiz_id` text NOT NULL,
  `question_id` text NOT NULL,
  `question` text NOT NULL,
  `optionA` varchar(250) NOT NULL,
  `optionB` varchar(250) NOT NULL,
  `optionC` varchar(250) NOT NULL,
  `optionD` varchar(250) NOT NULL,
  `right_answer` varchar(250) NOT NULL,
  `question_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`quiz_id`, `question_id`, `question`, `optionA`, `optionB`, `optionC`, `optionD`, `right_answer`, `question_number`) VALUES
('60eb4426a9773', '60eb44b01794b ', 'Decision-Table is a way', 'Of representing multiple conditions ', 'Of representing the information flow ', 'To get an accurate picture of the system', 'All of these ', 'Of representing multiple conditions', 1),
('60eb4426a9773', '60eb44b01a4e9 ', 'Mistakes made in the system analyses stage show up in', 'System design ', 'System development ', 'Implementation', 'All of these ', 'Implementation', 2),
('60eb4426a9773', '60eb44b01b95b ', 'The document listing all procedure and regulations that generally govern an organization is the', 'Administrative policy manual ', 'Personal policy book ', 'Procedures log ', 'Organization manual', 'Procedures log ', 3),
('60eb63c6e9130', '60eb64297c138 ', ' Which of the following is not an operating system?', 'Windows ', 'Linux ', 'Oracle', 'DOS', 'Oracle', 1),
('60eb63c6e9130', '60eb64297d2b2 ', 'What is the maximum length of the filename in DOS?', '4 ', '5 ', '8', '12', '8', 2),
('60eb63c6e9130', '60eb64297e47b ', 'the first operating system developed in 1950', 'false', 'true', '', '', 'true', 3),
('60ec19a3ede9f', '60ec1a1f082b6 ', 'The binary relation S = Φ (empty set) on set A = {1, 2,3} is', 'neither reflexive nor symmetric wrong ', 'symmetric and reflexive ', 'transitive and reflexive', 'transitive and symmetric', 'transitive and symmetric', 1),
('60ec19a3ede9f', '60ec1a1f0d775 ', ' Number of subsets of a set of order three is', '3 ', '6 ', '8', '9', '8', 2),
('60ec19a3ede9f', '60ec1a1f0e3b7 ', '\"n/m\" means that n is a factor of m, then the relation T is', 'reflexive and symmetric ', 'transitive and symmetric ', 'reflexive, transitive and symmetric', 'reflexive, transitive and not symmetric', 'reflexive, transitive and not symmetric', 3);

-- --------------------------------------------------------

--
-- Table structure for table `quizs`
--

CREATE TABLE `quizs` (
  `quiz_id` text NOT NULL,
  `title` varchar(100) NOT NULL,
  `right` int(11) NOT NULL,
  `wrong` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `quizs`
--

INSERT INTO `quizs` (`quiz_id`, `title`, `right`, `wrong`, `total`, `date`) VALUES
('60eb4426a9773', 'Information System', 5, 5, 3, '2021-07-11 19:19:02'),
('60eb63c6e9130', 'Operating System', 2, 2, 3, '2021-07-11 21:33:58'),
('60ec19a3ede9f', 'Modren Alegbra', 1, 1, 3, '2021-07-12 10:29:55');

-- --------------------------------------------------------

--
-- Table structure for table `student_answers`
--

CREATE TABLE `student_answers` (
  `email` varchar(50) NOT NULL,
  `quiz_id` text NOT NULL,
  `answer` varchar(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `student_answers`
--

INSERT INTO `student_answers` (`email`, `quiz_id`, `answer`, `date`) VALUES
('test99@mail.ru', '60eb44b01794b', 'Of representing multiple conditions ', '2021-07-11 21:31:40'),
('test99@mail.ru', '60eb44b01a4e9', 'System development ', '2021-07-11 21:31:40'),
('test99@mail.ru', '60eb44b01b95b', 'Organization manual', '2021-07-11 21:31:40'),
('ayo99@mail.ru', '60eb44b01794b', 'All of these ', '2021-07-11 21:37:33'),
('ayo99@mail.ru', '60eb44b01a4e9', 'Implementation', '2021-07-11 21:37:33'),
('ayo99@mail.ru', '60eb44b01b95b', 'Procedures log ', '2021-07-11 21:37:33'),
('ayo99@mail.ru', '60eb64297c138', 'Linux ', '2021-07-11 21:46:12'),
('ayo99@mail.ru', '60eb64297d2b2', '8', '2021-07-11 21:46:12'),
('ayo99@mail.ru', '60eb64297e47b', 'false', '2021-07-11 21:46:12'),
('ayo99@mail.ru', '60ec1a1f082b6', 'symmetric and reflexive ', '2021-07-12 14:17:25'),
('ayo99@mail.ru', '60ec1a1f0d775', '3 ', '2021-07-12 14:17:25'),
('ayo99@mail.ru', '60ec1a1f0e3b7', 'transitive and symmetric ', '2021-07-12 14:17:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fname`, `lname`, `email`, `password`, `role`) VALUES
(1, 'aya', 'munadhil', 'ayo99@mail.ru', '25d55ad283aa400af464c76d713c07ad', 'student'),
(2, 'admin', 'admin', 'admin99@mail.ru', '25d55ad283aa400af464c76d713c07ad', 'admin'),
(3, 'test', 'test', 'test99@mail.ru', '30aef62e680e50ac2ef0f0bd2fb32f25', 'student');

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
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
