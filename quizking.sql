-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2022 at 06:25 AM
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
-- Database: `quizking`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `answer_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer_answer` varchar(255) NOT NULL,
  `answer_correct` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`answer_id`, `question_id`, `answer_answer`, `answer_correct`) VALUES
(1, 1, 'Při posouzení vhodnosti modelu u regresních funkcí', 0),
(2, 1, 'Při určování parametrů regresních funkcí', 1),
(3, 1, 'Při posouzení rozdílnosti rozptylů v ANOVA testu', 0),
(4, 2, 'Dobra', 1),
(5, 2, 'aag', 0),
(6, 1, 'Ahoj', 0),
(7, 1, 'Ahoj', 0),
(8, 6, 'Odpoved 1', 1),
(9, 6, 'odpoved 2', 0),
(10, 6, 'aefa', 0),
(11, 3, 'hghg', 0),
(12, 3, 'vhvh', 1),
(13, 6, 'fsag', 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) DEFAULT NULL,
  `category_name` varchar(15) NOT NULL,
  `category_custom` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `category_custom`) VALUES
(1, 'Statistika', 0),
(2, 'Právo', 0);

-- --------------------------------------------------------

--
-- Table structure for table `done_quiz`
--

CREATE TABLE `done_quiz` (
  `quiz_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `question_quiz_id` int(11) NOT NULL,
  `question_question` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `question_quiz_id`, `question_question`) VALUES
(1, 1, 'Kde se používá metoda nejmenších čtverců?'),
(2, 1, 'aaaaaagge'),
(3, 1, 'sgseagaseg'),
(4, 0, 'afwaga'),
(5, 2, 'Dalsi ot'),
(6, 9, 'aegaeg');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `quiz_id` int(11) NOT NULL,
  `quiz_category_id` int(11) NOT NULL,
  `quiz_user_id` int(11) NOT NULL,
  `quiz_price` int(11) NOT NULL,
  `quiz_verified` tinyint(1) NOT NULL,
  `quiz_title` varchar(50) NOT NULL,
  `quiz_created` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`quiz_id`, `quiz_category_id`, `quiz_user_id`, `quiz_price`, `quiz_verified`, `quiz_title`, `quiz_created`) VALUES
(1, 1, 1, 0, 1, 'Statistika lehce', '2022-06-04'),
(2, 2, 0, 0, 1, 'Právo (Zkušební)', '2022-06-04'),
(4, 2, 3, 0, 0, 'test', '2022-06-05'),
(5, 2, 4, 0, 0, 'test', '2022-06-05'),
(9, 2, 1, 0, 0, 'gaegg', '2022-06-05');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `report_id` int(11) NOT NULL,
  `report_subject` varchar(50) NOT NULL,
  `report_comment` varchar(255) NOT NULL,
  `report_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_pwd` varchar(50) NOT NULL,
  `user_admin` tinyint(1) NOT NULL,
  `user_exp` int(11) NOT NULL,
  `user_coins` int(11) NOT NULL,
  `user_quiz_submited` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_pwd`, `user_admin`, `user_exp`, `user_coins`, `user_quiz_submited`) VALUES
(1, 'xx', 'xx@xx.xx', 'heslo', 0, 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`answer_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`quiz_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
