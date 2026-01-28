-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2026 at 03:34 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL,
  `shelf_id` int(11) DEFAULT NULL,
  `publication_year` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `status`, `shelf_id`, `publication_year`) VALUES
(8, 'Laskar Pelangi', 'Andrea Hirata', '', 1, 2005),
(9, 'Sang Pemimpi', 'Andrea Hirata', '', 7, 2008),
(10, 'Suara dari dilan', 'Pidi Baiq', '', 7, 2016),
(11, 'Hujan Kepagian', 'Nugroho Notosusanto', '', 7, 2011),
(12, 'Sangkuriang', 'Yuliadi Soekardi', '', 7, 2002);

-- --------------------------------------------------------

--
-- Table structure for table `borrowers`
--

CREATE TABLE `borrowers` (
  `id` int(11) NOT NULL,
  `user_id` int(20) NOT NULL,
  `book_id` int(20) NOT NULL,
  `borrow_date` date NOT NULL DEFAULT current_timestamp(),
  `return_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `borrowers`
--

INSERT INTO `borrowers` (`id`, `user_id`, `book_id`, `borrow_date`, `return_date`) VALUES
(2, 2, 2, '2024-10-02', '0000-00-00'),
(3, 3, 4, '2024-10-03', '2024-10-17'),
(5, 5, 3, '2024-10-03', '2024-10-17'),
(7, 6, 2, '2024-10-05', '2024-10-19'),
(16, 17, 8, '2024-10-09', '2024-10-16'),
(17, 19, 10, '2024-10-09', '2024-10-16'),
(20, 29, 3, '2026-01-28', '2026-02-04'),
(21, 29, 3, '2026-01-28', '2026-02-04'),
(22, 29, 5, '2026-01-28', '2026-02-04'),
(23, 29, 7, '2026-01-28', '2026-02-04'),
(24, 29, 4, '2026-01-28', '2026-02-04'),
(25, 29, 8, '2026-01-28', '2026-02-04'),
(26, 29, 1, '2026-01-28', '2026-02-04');

-- --------------------------------------------------------

--
-- Table structure for table `shelves`
--

CREATE TABLE `shelves` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shelves`
--

INSERT INTO `shelves` (`id`, `name`, `location`) VALUES
(1, 'ipa', '1'),
(3, 'fisika', '3'),
(4, 'pai', '4'),
(5, 'biologi fisika', '5'),
(6, 'fiksii', '6'),
(7, 'novel', '7');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `password`) VALUES
(1, 'maraa', 'maranata5585@gmail.com', 'user', ''),
(2, 'seli', 'seli@gmail.com', 'user', ''),
(3, 'seli', 'seli@gmail.com', 'user', ''),
(4, 'hepa', 'hepa@gmail', 'user', ''),
(5, 'adik', 'adik@gmail', 'admin', '$2y$10$Kk8nP9/wT.0HVFTKOVc39.BtDqib8VbkjdMgdJJyMf3QAo/fK/aMW'),
(6, 'araaa', 'mara@gmail', 'admin', '$2y$10$Kk8nP9/wT.0HVFTKOVc39.BtDqib8VbkjdMgdJJyMf3QAo/fK/aMW'),
(7, 'ara', 'ara@gmail', 'admin', '$2y$10$Kk8nP9/wT.0HVFTKOVc39.BtDqib8VbkjdMgdJJyMf3QAo/fK/aMW'),
(11, 'risna', 'risna@gmail.com', 'user', ''),
(12, 'zara', 'zara@gmail.com', 'user', ''),
(16, 'hepa', 'hepa@gmail.com', 'admin', '$2y$10$Kk8nP9/wT.0HVFTKOVc39.BtDqib8VbkjdMgdJJyMf3QAo/fK/aMW'),
(17, 'jaja', 'jaja@gmail.com', 'user', '$2y$10$ifdtwj6WqeqoLMSABBW5K.pB7t7TDg.vu7mF3docNQgvuCKvpWl.S'),
(18, 'admin', 'admin@gmail.com', 'admin', '$2y$10$Kk8nP9/wT.0HVFTKOVc39.BtDqib8VbkjdMgdJJyMf3QAo/fK/aMW'),
(19, 'user', 'user@gmail.com', 'user', '$2y$10$f.bpSKk1rPY1CIEpD3/pTe1Sxj5ISlf96WQ50MsiyvtFlkpt6U.pq'),
(20, 'raraaa', 'admin@gmail.com', 'admin', '$2y$10$Kk8nP9/wT.0HVFTKOVc39.BtDqib8VbkjdMgdJJyMf3QAo/fK/aMW'),
(21, 'rara', 'rara@gmail.com', 'user', '$2y$10$jjsq8YEnciAyyGNdzrfDjeLOOy5XOLIdp3lqBZQ25FcXEAyQjQTaW'),
(22, 'rara', 'rara@gmail.com', 'user', '$2y$10$zPgc0.tpSaf/FXm8JHZGru53I89IYjpbXbeJq72HGDwowKs6P0FqC'),
(23, 'raraaa', 'ara@gmail.com', 'user', '$2y$10$7oZL/h2DVBkULLcz4SkuHuhNiKifGl34f2rV80efr6ItZY9aC4RXi'),
(24, 'ra', 'ra@gmail.com', 'user', '$2y$10$bxvKcz.o5eIUQJEBjokGB.LY/XriDGwVKb.3aWqwmAeey4KmmCUGq'),
(25, 'ra', 'ra@gmail.com', 'user', '$2y$10$.EnqujenI.52Omb8TeWu7uDLO.jbNMQw4bN.ERv9YaEPaT0Ar8g3q'),
(26, 'araaa', 'araaa@gmail.com', 'user', '$2y$10$Qnd5uV4kFKaLyvFBrrZHI.LltlD0Fbtsvh1PO45c65lluvFgIYVIq'),
(27, 'zahra', 'zahra@gmail.com', 'user', '$2y$10$WvsqrpIkni6cNnW4ZYQZRuk38/CbncSRVHl5ySXZvHKll2L.EQ79m'),
(28, 'admin', 'admin@gmail.com', 'admin', '$2y$10$G0N2137CA7jU/iw0I4Y2DuQQIZFb9udX7VNqEPkDkGQH5HzuWZi06'),
(29, '12345', '12345@gmail.com', 'user', '$2y$10$UiTrYXIKHOdXPdsJbIdpteqFB0EamWn1GAtsY2fMULqtAG46MoEAC'),
(30, 'admin1', 'admin1@gmail.com', 'admin', '$2y$10$.CFF8mEzb.RqP/PGLHF20.GhyabGb1c5.RTyxRTRLy08yuE6li3fC');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `borrowers`
--
ALTER TABLE `borrowers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shelves`
--
ALTER TABLE `shelves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `borrowers`
--
ALTER TABLE `borrowers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `shelves`
--
ALTER TABLE `shelves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
