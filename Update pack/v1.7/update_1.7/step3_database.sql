-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 23, 2025 at 06:55 AM
-- Server version: 5.7.24
-- PHP Version: 8.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `as1`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

DROP TABLE IF EXISTS `assignments`;
CREATE TABLE `assignments` (
  `id` bigint(255) NOT NULL,
  `course_id` bigint(255) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `questions` longtext COLLATE utf8mb4_unicode_ci,
  `question_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_marks` int(255) DEFAULT NULL,
  `deadline` datetime DEFAULT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ebooks`
--

DROP TABLE IF EXISTS `ebooks`;
CREATE TABLE `ebooks` (
  `id` int(255) NOT NULL,
  `user_id` int(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `category_id` int(255) DEFAULT NULL,
  `description` longtext,
  `publication_name` varchar(255) DEFAULT NULL,
  `edition` varchar(255) DEFAULT NULL,
  `is_paid` int(255) DEFAULT NULL,
  `price` double(10,2) DEFAULT NULL,
  `discount_flag` int(255) DEFAULT NULL,
  `discounted_price` double(10,2) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `published_date` int(255) DEFAULT NULL,
  `language_id` int(255) DEFAULT NULL,
  `summary` mediumtext,
  `preview` varchar(255) DEFAULT NULL,
  `complete` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `average_rating` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ebook_categories`
--

DROP TABLE IF EXISTS `ebook_categories`;
CREATE TABLE `ebook_categories` (
  `id` int(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ebook_purchases`
--

DROP TABLE IF EXISTS `ebook_purchases`;
CREATE TABLE `ebook_purchases` (
  `id` int(255) NOT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `transaction_id` longtext,
  `invoice` varchar(255) DEFAULT NULL,
  `ebook_id` int(255) DEFAULT NULL,
  `tax` varchar(255) DEFAULT NULL,
  `amount` double(10,2) DEFAULT NULL,
  `user_id` int(255) DEFAULT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `admin_revenue` float(10,2) DEFAULT NULL,
  `instructor_revenue` float(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ebook_reviews`
--

DROP TABLE IF EXISTS `ebook_reviews`;
CREATE TABLE `ebook_reviews` (
  `id` int(255) NOT NULL,
  `user_id` int(255) DEFAULT NULL,
  `ebook_id` int(255) DEFAULT NULL,
  `rating` int(255) DEFAULT NULL,
  `review` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `submitted_assignments`
--

DROP TABLE IF EXISTS `submitted_assignments`;
CREATE TABLE `submitted_assignments` (
  `id` bigint(255) NOT NULL,
  `user_id` bigint(255) DEFAULT NULL,
  `assignment_id` bigint(255) DEFAULT NULL,
  `answer` longtext COLLATE utf8mb4_unicode_ci,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marks` int(255) DEFAULT NULL,
  `remarks` longtext COLLATE utf8mb4_unicode_ci,
  `status` int(255) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ebooks`
--
ALTER TABLE `ebooks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ebook_categories`
--
ALTER TABLE `ebook_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ebook_purchases`
--
ALTER TABLE `ebook_purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ebook_reviews`
--
ALTER TABLE `ebook_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `submitted_assignments`
--
ALTER TABLE `submitted_assignments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ebooks`
--
ALTER TABLE `ebooks`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ebook_categories`
--
ALTER TABLE `ebook_categories`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ebook_purchases`
--
ALTER TABLE `ebook_purchases`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ebook_reviews`
--
ALTER TABLE `ebook_reviews`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `submitted_assignments`
--
ALTER TABLE `submitted_assignments`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
