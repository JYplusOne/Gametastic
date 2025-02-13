-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2023 at 05:08 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gametastic`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `friends` text NOT NULL,
  `profile_picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `first_name`, `last_name`, `phone_number`, `friends`, `profile_picture`) VALUES
(48, 'Mohammad Jamil', '$2y$10$3LtqOZCu5wOi4bqyPQHZruEBlGWcEYKJg1niONf100xni2oDZ/qH6', 'MohammadJamil12@gmail.com', 'Mohammad Jamil', 'Osman', '01123456789', 'Ryan, John, Ben, Cassandra, Alvin, Ali', './user_profile_picture/Mohammad Jamil.jpg'),
(49, 'Arya Devi', '$2y$10$J3O8NSiBxh91J5t9.UnLC.O68lICK5PZQOxZUzivZiWb8RI8au6T.', 'AryaDevi@gmail.com', 'Arya', 'Devi', '01223456789', 'Priya Rajan, Arjun Kumar, Anika Patel', './user_profile_picture/Arya Devi.jpg'),
(50, 'JessieL', '$2y$10$H4VTNaMObCxqKW0aD1JRkOulxryb064i5GJR3Ab8cday.QEhJggAu', 'jessiel@gmail.com', 'Jie See', 'Leong', '01523456789', 'Ryan, John, Ben, Cassandra', './user_profile_picture/Jie See Leong.jpg'),
(51, 'JGreen', '$2y$10$7QhxcdkRgF7R5AYT22WlTeyeZHhXKcQgDuAAuAJHV0OAP.b1aNhm2', 'johngreen@gmail.com', 'John ', 'Green', '01234567789', 'Tina Dean, Armaan Mahoney, Martin Louis ', './user_profile_picture/John Green.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
