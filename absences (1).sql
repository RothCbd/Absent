-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2022 at 05:42 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absences`
--

-- --------------------------------------------------------

--
-- Table structure for table `absents`
--

CREATE TABLE `absents` (
  `id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(10) UNSIGNED NOT NULL,
  `absent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `absent_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number` double(8,2) NOT NULL,
  `day` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year_month` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `absents`
--

INSERT INTO `absents` (`id`, `employee_id`, `absent`, `absent_time`, `number`, `day`, `date`, `year_month`, `description`, `created_at`, `updated_at`) VALUES
(2, 4, 'halfday', 'morning', 0.50, 'Friday', '2022-06-10', '2022-06', NULL, '2022-06-10 02:53:11', '2022-06-10 02:53:11'),
(3, 1, 'fullday', NULL, 1.00, 'Tuesday', '2022-05-31', '2022-05', NULL, '2022-06-10 02:53:36', '2022-06-10 02:53:36'),
(4, 5, 'fullday', NULL, 1.00, 'Thursday', '2022-06-02', '2022-06', NULL, '2022-06-10 02:54:05', '2022-06-10 02:54:05'),
(5, 7, 'fullday', NULL, 1.00, 'Thursday', '2022-05-05', '2022-05', 'ជាប់សសៃជើង', '2022-06-10 02:54:20', '2022-06-16 04:04:17'),
(6, 5, 'halfday', 'afternoon', 0.50, 'Wednesday', '2022-05-11', '2022-05', NULL, '2022-06-10 02:54:36', '2022-06-10 02:54:36'),
(7, 4, 'halfday', 'morning', 0.50, 'Tuesday', '2022-05-17', '2022-05', NULL, '2022-06-10 02:54:47', '2022-06-10 02:54:47'),
(8, 1, 'halfday', 'morning', 0.50, 'Friday', '2022-05-27', '2022-05', NULL, '2022-06-10 02:55:15', '2022-06-10 02:55:15'),
(9, 1, 'fullday', NULL, 1.00, 'Friday', '2022-04-01', '2022-04', NULL, '2022-06-10 02:55:30', '2022-06-10 02:55:30'),
(10, 3, 'fullday', NULL, 1.00, 'Wednesday', '2022-04-20', '2022-04', NULL, '2022-06-10 02:55:42', '2022-06-10 02:55:42'),
(11, 7, 'fullday', NULL, 1.00, 'Tuesday', '2022-04-19', '2022-04', NULL, '2022-06-10 02:56:07', '2022-06-10 02:56:07'),
(12, 3, 'halfday', 'morning', 0.50, 'Wednesday', '2022-05-18', '2022-05', NULL, '2022-06-10 02:56:35', '2022-06-10 02:56:35'),
(13, 5, 'halfday', 'afternoon', 0.50, 'Thursday', '2022-04-21', '2022-04', NULL, '2022-06-10 02:59:58', '2022-06-10 02:59:58'),
(14, 1, 'halfday', 'morning', 0.50, 'Thursday', '2022-06-16', '2022-06', NULL, '2022-06-10 03:59:24', '2022-06-10 03:59:24'),
(20, 7, 'fullday', NULL, 1.00, 'Tuesday', '2022-02-01', '2022-02', NULL, '2022-06-15 20:26:52', '2022-06-15 20:26:52'),
(21, 5, 'halfday', 'afternoon', 0.50, 'Wednesday', '2022-03-02', '2022-03', NULL, '2022-06-15 20:27:05', '2022-06-15 20:27:05'),
(28, 7, 'fullday', NULL, 1.00, 'Friday', '2021-12-17', '2021-12', NULL, '2022-06-15 20:39:14', '2022-06-15 20:47:00'),
(29, 4, 'fullday', NULL, 1.00, 'Wednesday', '2021-05-05', '2021-05', NULL, '2022-06-15 20:40:15', '2022-06-15 20:40:15'),
(30, 5, 'halfday', 'morning', 0.50, 'Wednesday', '2021-02-03', '2021-02', NULL, '2022-06-15 20:42:05', '2022-06-15 20:42:05'),
(35, 5, 'halfday', 'morning', 0.50, 'Tuesday', '2022-06-21', '2022-06', NULL, '2022-06-20 21:36:25', '2022-06-20 21:36:25'),
(36, 3, 'fullday', NULL, 1.00, 'Wednesday', '2022-06-08', '2022-06', NULL, '2022-06-20 21:41:38', '2022-06-20 21:41:38'),
(37, 2, 'fullday', NULL, 1.00, 'Friday', '2022-06-10', '2022-06', NULL, '2022-06-20 21:42:00', '2022-06-20 21:42:00'),
(39, 4, 'fullday', NULL, 1.00, 'Tuesday', '2022-06-21', '2022-06', NULL, '2022-06-20 21:49:02', '2022-06-20 21:49:02');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postion_id` int(10) UNSIGNED NOT NULL,
  `start_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`phone_number`)),
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default.png',
  `profile_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_inactive` tinyint(1) NOT NULL DEFAULT 0,
  `leave_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `email`, `gender`, `postion_id`, `start_date`, `phone_number`, `pic`, `profile_color`, `is_inactive`, `leave_date`, `created_at`, `updated_at`) VALUES
(1, 'Poav Saroth', 'saroth@gmail.com', 'male', 3, '2022-01-04', '[{\"phone\":\"092-342-3434\"},{\"phone\":\"012-735-374\"}]', 'default.png', '44bce8', 0, '2022-06-01', '2022-06-07 02:53:24', '2022-06-16 21:35:20'),
(2, 'Ky Money', 'money@gmail.com', 'male', 2, '2022-06-01', '[{\"phone\":null}]', 'default.png', '659296', 0, NULL, '2022-06-07 02:53:58', '2022-06-07 03:33:45'),
(3, 'Sok Seng', 'seng@gmail.com', 'male', 2, '2021-02-01', '[{\"phone\":\"091-263-8123\"}]', 'sok-seng-1655197780-32.jpg', '7b1acc', 0, NULL, '2022-06-07 20:55:51', '2022-06-14 02:09:40'),
(4, 'Chork Nirath', 'nirothcbd@gmail.com', 'male', 1, '2021-03-01', '[{\"phone\":\"081-810-076\"}]', 'default.png', '8610eb', 0, NULL, '2022-06-07 20:56:40', '2022-06-07 20:56:40'),
(5, 'Ouk Dom', 'oukdom@gmail.com', 'male', 2, '2021-06-01', '[{\"phone\":null}]', 'default.png', 'cace6a', 0, NULL, '2022-06-07 20:59:40', '2022-06-07 20:59:40'),
(7, 'Key Sokheng', 'sokheng@gmail.com', 'male', 2, '2021-09-01', '[{\"phone\":null}]', 'default.png', '6c45d2', 0, NULL, '2022-06-07 21:01:42', '2022-06-07 21:01:42'),
(8, 'Do Sokho', 'sokho@gmail.com', 'male', 2, '2019-01-01', '[{\"phone\":null}]', 'default.png', '0236e3', 1, '2022-02-01', '2022-06-07 21:02:24', '2022-06-07 21:02:49');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` int(10) UNSIGNED NOT NULL,
  `day` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `holiday` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `holidays`
--

INSERT INTO `holidays` (`id`, `day`, `date`, `holiday`, `created_at`, `updated_at`) VALUES
(5, 'Saturday', '2022-06-18', 'King\'s mother birthday', '2022-06-09 00:52:53', '2022-06-09 01:29:09'),
(6, 'Monday', '2022-01-31', 'First Chines New year day', '2022-06-09 00:57:10', '2022-06-09 00:57:10'),
(8, 'Thursday', '2022-04-14', 'Khmer new year', '2022-06-09 00:59:21', '2022-06-09 00:59:21'),
(9, 'Friday', '2022-04-15', 'Khmer new year', '2022-06-09 00:59:38', '2022-06-09 02:16:34'),
(10, 'Saturday', '2022-04-16', 'Khmer new year', '2022-06-09 01:00:04', '2022-06-09 01:00:04'),
(11, 'Sunday', '2022-05-01', 'International Labor Day', '2022-06-09 01:00:45', '2022-06-09 01:00:45'),
(12, 'Saturday', '2022-09-24', 'Ancestors Day (Pchum Ben)', '2022-06-09 01:31:32', '2022-06-09 01:31:32'),
(13, 'Sunday', '2022-09-25', 'Ancestors Day (Pchum Ben)', '2022-06-09 01:31:50', '2022-06-09 01:31:50'),
(14, 'Monday', '2022-09-26', 'Ancestors Day (Pchum Ben)', '2022-06-09 01:32:01', '2022-06-09 01:32:01'),
(15, 'Saturday', '2022-10-29', 'King\'s Coronation day', '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(16, 'Monday', '2022-11-07', 'Water festival (Oum Touk)', '2022-06-09 01:33:23', '2022-06-09 01:33:23'),
(17, 'Tuesday', '2022-11-08', 'Water festival (Oum Touk)', '2022-06-09 01:33:32', '2022-06-09 01:33:32'),
(18, 'Wednesday', '2022-11-09', 'Water festival (Oum Touk)', '2022-06-09 01:33:42', '2022-06-09 01:33:42'),
(19, 'Saturday', '2022-01-01', 'International new year', '2022-06-09 01:34:26', '2022-06-09 01:34:26'),
(20, 'Tuesday', '2022-03-08', 'International woman day', '2022-06-09 01:35:13', '2022-06-09 01:35:13'),
(23, 'Monday', '2021-02-01', 'saasa', '2022-06-09 23:25:58', '2022-06-09 23:25:58'),
(24, 'Wednesday', '2021-02-03', 'aaaaa', '2022-06-12 21:38:39', '2022-06-12 21:38:39'),
(25, 'Thursday', '2023-03-02', 'mmj', '2022-06-12 21:40:44', '2022-06-12 21:40:44'),
(26, 'Tuesday', '2021-06-01', 'King\'s mother birthday', '2022-06-14 02:15:10', '2022-06-14 02:15:10');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(16, '2013_02_09_062153_create_roles_table', 1),
(17, '2014_10_12_000000_create_users_table', 1),
(18, '2014_10_12_100000_create_password_resets_table', 1),
(19, '2019_08_19_000000_create_failed_jobs_table', 1),
(20, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(21, '2022_02_08_081314_create_positions_table', 1),
(24, '2022_02_09_081315_create_employees_table', 2),
(25, '2022_06_07_094836_add_leave_date_to_employees_table', 2),
(26, '2022_06_09_041612_create_holidays_table', 3),
(28, '2022_02_09_084016_create_absents_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(22, 'App\\Models\\User', 1, 'myapptoken', '2ae8a3c9b50ebec6028ea4c71db38db68b64068078f339306d7d6fcf5e593b99', '[\"*\"]', '2022-06-24 02:41:14', '2022-06-24 02:38:24', '2022-06-24 02:41:14');

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'junior software developer', NULL, NULL),
(2, 'senior software developer', '2022-06-06 20:06:50', '2022-06-06 21:13:40'),
(3, 'supervisor', '2022-06-06 20:22:21', '2022-06-06 20:22:21'),
(4, 'manager', '2022-06-06 20:23:25', '2022-06-06 20:23:25');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `slug`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', NULL, NULL),
(2, 'user', 'user', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT 2,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default.png',
  `phone_number` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`phone_number`)),
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `email_verified_at`, `password`, `profile`, `phone_number`, `is_approved`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'admin', 'admin@admin.com', NULL, '$2y$10$oCiFvi3JzRn2lbNn.NUBEevHk0dknM0kP3YcywLIf1iGj9ofCiBTq', '1-62ac41ff473ce.png', NULL, 0, NULL, NULL, '2022-06-20 23:58:10'),
(2, 2, 'User', 'user@gmail.com', NULL, '$2y$10$AI4qn8jVjT39YEe9exoJcOFJ8M1LNV55XUM1rPKgNb5ztxuIDssWK', 'user-1655091426-32.jpg', '[{\"phone\":\"098-121-212\"}]', 0, NULL, '2022-06-12 20:37:06', '2022-06-12 20:37:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absents`
--
ALTER TABLE `absents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `absents_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_email_unique` (`email`),
  ADD KEY `employees_postion_id_foreign` (`postion_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absents`
--
ALTER TABLE `absents`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absents`
--
ALTER TABLE `absents`
  ADD CONSTRAINT `absents_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_postion_id_foreign` FOREIGN KEY (`postion_id`) REFERENCES `positions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
