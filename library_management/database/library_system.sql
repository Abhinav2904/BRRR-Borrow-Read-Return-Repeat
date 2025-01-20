-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2025 at 07:43 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `author` varchar(255) NOT NULL,
  `genre` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `trending` int(11) NOT NULL DEFAULT 0 COMMENT '''0'' - Not Trending, ''1'' - Trending',
  `quantity` int(11) DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '''0'' - Visible, ''1'' - Archived',
  `modified_on` datetime NOT NULL DEFAULT current_timestamp(),
  `modified_by` int(11) NOT NULL,
  `created_on` datetime DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `name`, `image`, `author`, `genre`, `description`, `trending`, `quantity`, `status`, `modified_on`, `modified_by`, `created_on`, `created_by`) VALUES
(1, 'The Alchemist', '1737293591_the_alchemist.jpg', 'Paulo Coelho', 'Fiction,Adventure', 'A story about following your dreams and the journey to self-discovery.', 0, 5, 0, '2025-01-19 19:03:11', 2, '2025-01-19 19:02:11', 2),
(2, '1984', '1737293761_1984.jpg', 'George Orwell', 'Fantasy,Science Fiction', 'A dystopian novel about totalitarianism and surveillance.', 0, 4, 0, '2025-01-19 19:06:01', 2, '2025-01-19 19:02:11', 2),
(3, 'To Kill a Mockingbird', '1737293808_to_kill_a_mockingbird.jpg', 'Harper Lee', 'Fiction,Historical', 'A novel about racial injustice in the Deep South.', 0, 5, 0, '2025-01-19 19:06:48', 2, '2025-01-19 19:02:11', 2),
(4, 'The Great Gatsby', '1737293861_the_great_gatsby.jpg', 'F. Scott Fitzgerald', 'Fiction', 'A story about the American dream and moral decay.', 0, 5, 0, '2025-01-19 19:07:41', 2, '2025-01-19 19:02:11', 2),
(5, 'Pride and Prejudice', '1737293916_pride_and_prejudice.jfif', 'Jane Austen', 'Romance', 'A classic romance novel that critiques social class and marriage.', 0, 5, 0, '2025-01-19 19:08:36', 2, '2025-01-19 19:02:11', 2),
(6, 'Harry Potter and the Sorcerers Stone', '1737293955_harry_potter_and_the_sorcerers_stone.jpg', 'J.K. Rowling', 'Fantasy,Young Adult', 'The first book in the Harry Potter series.', 0, 4, 0, '2025-01-19 19:09:15', 2, '2025-01-19 19:02:11', 2),
(7, 'The Catcher in the Rye', '1737294213_the_catcher_in_the_rye.jpg', 'J.D. Salinger', 'Fiction', 'A story of teenage alienation and rebellion.', 0, 5, 0, '2025-01-19 19:13:33', 2, '2025-01-19 19:02:11', 2),
(8, 'The Lord of the Rings The Fellowship of the Ring', '1737294272_the_lord_of_the_rings_the_fellowship_of_the_ring.jpg', 'J.R.R. Tolkien', 'Fantasy,Adventure', 'The first book in the Lord of the Rings trilogy.', 0, 5, 0, '2025-01-19 19:14:32', 2, '2025-01-19 19:02:11', 2),
(9, 'The Hunger Games', '1737294379_the_hunger_games.jpg', 'Suzanne Collins', 'Fiction,Science Fiction,Young Adult,Dystopian', 'A post-apocalyptic story of survival and rebellion.', 0, 5, 0, '2025-01-19 19:16:19', 2, '2025-01-19 19:02:11', 2),
(10, 'The Hobbit', '1737294913_the_hobbit.jpg', 'J.R.R. Tolkien', 'Fantasy,Adventure', 'A fantasy adventure about Bilbo Baggins and his unexpected journey.', 0, 5, 0, '2025-01-19 19:25:13', 2, '2025-01-19 19:02:11', 2),
(11, 'The Road', '1737294986_the_road.jpg', 'Cormac McCarthy', 'Thriller,Dystopian', 'A post-apocalyptic novel about survival and father-son love.', 0, 5, 0, '2025-01-19 19:26:26', 2, '2025-01-19 19:02:11', 2),
(12, 'Moby Dick', '1737297335_moby_dick.jpg', 'Herman Melville', 'Fiction,Adventure', 'The epic story of Captain Ahab’s obsession with hunting the white whale.', 0, 5, 0, '2025-01-19 20:05:35', 2, '2025-01-19 19:02:11', 2),
(13, 'The Shining', '1737297388_the_shining.jpg', 'Stephen King', 'Thriller,Horror', 'A psychological horror novel about a family’s descent into madness.', 0, 4, 0, '2025-01-19 20:06:28', 2, '2025-01-19 19:02:11', 2),
(14, 'The Diary of a Young Girl', '1737297417_the_diary_of_a_young_girl.jpg', 'Anne Frank', 'Historical,Biography', 'The Diary of a Young Girl is Anne Frank\'s poignant and insightful account of her life hiding from the Nazis during World War II.', 0, 5, 0, '2025-01-19 22:37:52', 2, '2025-01-19 19:02:11', 2),
(15, 'The Picture of Dorian Gray', '1737297453_the_picture_of_dorian_gray.jpg', 'Oscar Wilde', 'Fiction', 'A story about vanity, corruption, and the pursuit of eternal youth.', 0, 5, 0, '2025-01-19 20:07:33', 2, '2025-01-19 19:02:11', 2);

-- --------------------------------------------------------

--
-- Table structure for table `borrowed_books`
--

CREATE TABLE `borrowed_books` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL,
  `action_on` timestamp NULL DEFAULT NULL,
  `action_by` int(11) DEFAULT NULL,
  `returned_on` datetime DEFAULT NULL,
  `returned_by` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '''0'' - Pending, ''1'' - Approved, ''2'' - Rejected, ''3'' - Return Requested, ''4'' - Returned'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrowed_books`
--

INSERT INTO `borrowed_books` (`id`, `user_id`, `book_id`, `created_on`, `created_by`, `action_on`, `action_by`, `returned_on`, `returned_by`, `status`) VALUES
(1, 4, 9, '2025-01-19 17:03:07', 4, '2025-01-19 17:08:10', 2, '2025-01-19 22:48:10', 0, 4),
(2, 4, 14, '2025-01-19 17:03:07', 4, '2025-01-19 17:08:14', 2, NULL, 0, 2),
(3, 4, 13, '2025-01-19 17:03:07', 4, '2025-01-19 17:08:12', 2, NULL, 0, 1),
(4, 1, 13, '2025-01-19 17:22:05', 1, '2025-01-19 17:29:24', 2, '2025-01-19 23:01:36', 0, 4),
(5, 1, 15, '2025-01-19 17:22:05', 1, '2025-01-19 17:29:36', 2, NULL, 0, 2),
(6, 1, 9, '2025-01-19 17:22:05', 1, '2025-01-19 17:29:28', 2, NULL, 0, 2),
(7, 1, 7, '2025-01-19 17:22:05', 1, '2025-01-19 17:29:35', 2, '2025-01-19 23:01:35', 0, 4),
(8, 1, 6, '2025-01-19 17:22:05', 1, '2025-01-19 17:23:06', 2, NULL, 0, 1),
(9, 1, 2, '2025-01-19 17:22:05', 1, '2025-01-19 17:29:34', 2, NULL, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_on` datetime DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `id` int(11) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `modified_on` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`id`, `genre`, `modified_on`, `modified_by`, `created_on`, `created_by`) VALUES
(1, 'Fiction', NULL, NULL, '2025-01-19 18:52:12', 2),
(2, 'Non-Fiction', NULL, NULL, '2025-01-19 18:52:12', 2),
(3, 'Mystery', NULL, NULL, '2025-01-19 18:52:12', 2),
(4, 'Fantasy', NULL, NULL, '2025-01-19 18:52:12', 2),
(5, 'Romance', NULL, NULL, '2025-01-19 18:52:12', 2),
(6, 'Science Fiction', NULL, NULL, '2025-01-19 18:52:12', 2),
(7, 'Thriller', NULL, NULL, '2025-01-19 18:52:12', 2),
(8, 'Historical', NULL, NULL, '2025-01-19 18:52:12', 2),
(9, 'Biography', NULL, NULL, '2025-01-19 18:52:12', 2),
(10, 'Horror', NULL, NULL, '2025-01-19 18:52:12', 2),
(11, 'Adventure', NULL, NULL, '2025-01-19 18:52:12', 2),
(12, 'Children', NULL, NULL, '2025-01-19 18:52:12', 2),
(13, 'Self-Help', NULL, NULL, '2025-01-19 18:52:12', 2),
(14, 'Poetry', NULL, NULL, '2025-01-19 18:52:12', 2),
(15, 'Young Adult', NULL, NULL, '2025-01-19 18:52:12', 2),
(16, 'Dystopian', NULL, NULL, '2025-01-19 19:15:35', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(100) NOT NULL,
  `dob` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` int(11) DEFAULT 1 COMMENT '''0'' - Admin, ''1'' - User',
  `CREATED_ON` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `phone`, `dob`, `email`, `password`, `role`, `CREATED_ON`) VALUES
(1, 'Abhinav Srivastava', '8874571490', '1998-12-17', 'abhinav@gmail.com', '$2y$10$2GC89LtOOnuxYKCSRatG8.BhtgkiIOqKp9TC.UV4uIc6eP8M6USfO', 1, '2025-01-17 21:23:59'),
(2, 'Admin', '9898989898', '1990-05-15', 'admin@admin.com', '$2y$10$DG0sqwHR4tmv9xJq6FQ9bOJQa4kGLIM6ff5y7pJZIA18yKj0PoaBi', 0, '2025-01-17 23:52:08'),
(3, 'Rakesh Singh', '1212121212', '1986-05-13', 'rakesh@yahoomail.com', '$2y$10$6igOHEsGO5Fvs52qEJRW/OCOflmxdS0xeBw.ZSQ5OfekZvvQTYXOO', 1, '2025-01-19 04:30:31'),
(4, 'Shruti Singh', '3434343434', '1997-01-14', 'shruti@gmail.com', '$2y$10$BqD6AbOQB66gD1U7u8hOMuYxAvFwiQd66pTGb/r.cM1iPAyG6oqPC', 1, '2025-01-19 22:26:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `borrowed_books`
--
ALTER TABLE `borrowed_books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `borrowed_books`
--
ALTER TABLE `borrowed_books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
