-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 06, 2025 at 12:53 PM
-- Server version: 5.7.40
-- PHP Version: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci4demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `email`, `position`, `created_at`, `updated_at`) VALUES
(1, 'Unnati', 'test@test.com', 'Sr sofeware engineer p1', NULL, NULL),
(3, 'dfsfsdfsf', 'test@gmail.com', 'tetest', NULL, NULL),
(4, 'parth', 'parth@yopmail.com', 'engineer', NULL, NULL),
(5, 'parth', 'parth@gmail.com', 'testtest', NULL, NULL),
(6, 'parth', 'jik@test.com', 'testtest', NULL, NULL),
(7, 'dfdsfsdfdsf', 'gggg@ss.com', 'dfsfsdffd', NULL, NULL),
(8, 'dfdsfsdfdsf', 'gggg@sfgs.com', 'dfsfsdffd', NULL, NULL),
(11, 'parth', 'superadmin@grr.la', 'dfsfsdf', NULL, NULL),
(12, 'Unnati', 'moderator1@yopmail.com', 'dfsdfd', NULL, NULL),
(13, 'ddddddd', 'dd@sds.com', 'sdadsd', NULL, NULL),
(14, 'sddassad', 'xczcxczzxcxzczxc@df.com', 'zxcxzcxzc', NULL, NULL),
(15, 'sddassad', 'dfs@df.com', 'zxcxzcxzc', NULL, NULL),
(16, 'Unpop12', 'sdad@mdfjsd.com', 'zxcxzcxzc', NULL, NULL),
(17, 'Jhon', 'jhon@gmail.com', 'Sr. Product manager', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_images`
--

CREATE TABLE `employee_images` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee_images`
--

INSERT INTO `employee_images` (`id`, `employee_id`, `image`, `created_at`, `updated_at`) VALUES
(1, 16, '1759489161_a408f6a7fe33c6a8265b.png', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_properties`
--

CREATE TABLE `employee_properties` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `property_name` varchar(100) DEFAULT NULL,
  `property_value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee_properties`
--

INSERT INTO `employee_properties` (`id`, `employee_id`, `property_name`, `property_value`) VALUES
(8, 17, 'p1', 'v1');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2025-10-03-060333', 'App\\Database\\Migrations\\CreateEmployeesTable', 'default', 'App', 1759471466, 1),
(2, '2025-10-03-085746', 'App\\Database\\Migrations\\CreateEmployeeImages', 'default', 'App', 1759481978, 2),
(3, '2025-10-05-061716', 'App\\Database\\Migrations\\CreateUsersTable', 'default', 'App', 1759645204, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `verification_token` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `is_verified`, `verification_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '', 'superadmin@grr.la', '$2y$10$DGRWGXS/wODuPV0Y2S1bwOl5Dl69z9WyKlWPTnNfpejIET06iN.Fa', 0, NULL, NULL, NULL, NULL),
(4, 'Unnc', 'uncp@yopmail.com', 'fcea920f7412b5da7be0cf42b8c93759', 0, NULL, NULL, NULL, NULL),
(5, 'unnati.prajapati', 'unp@yopmail.com', '$2y$10$.6fDpQlmItesaqCXa3QEKuwfHf0pHKuTXNgsMdACr3bDPMajio5pO', 0, NULL, NULL, NULL, NULL),
(16, 'dffdfdsf', 'unnati4501@gmail.com', '$2y$10$bvnYiNPpAXO6R93SFDQ0uu6uymzTxcwEgxleHG.4brMUcyXd8T13O', 1, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_images`
--
ALTER TABLE `employee_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_properties`
--
ALTER TABLE `employee_properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `employee_images`
--
ALTER TABLE `employee_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employee_properties`
--
ALTER TABLE `employee_properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employee_properties`
--
ALTER TABLE `employee_properties`
  ADD CONSTRAINT `employee_properties_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
