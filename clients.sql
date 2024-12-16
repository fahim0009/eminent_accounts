-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2024 at 10:40 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eminenti_accounts`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `clientid` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `passport_number` varchar(255) DEFAULT NULL,
  `passport_name` varchar(255) DEFAULT NULL,
  `passport_image` varchar(255) DEFAULT NULL,
  `client_image` varchar(255) DEFAULT NULL,
  `visa` varchar(255) DEFAULT NULL,
  `manpower_image` varchar(255) DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `package_cost` double(10,2) NOT NULL DEFAULT 0.00,
  `passport_rcv_date` varchar(255) DEFAULT NULL,
  `refund` double(10,2) NOT NULL DEFAULT 0.00,
  `description` varchar(255) DEFAULT NULL,
  `medical_exp_date` varchar(255) DEFAULT NULL,
  `mofa_trade` bigint(20) UNSIGNED DEFAULT NULL,
  `job_company` varchar(255) DEFAULT NULL,
  `joining_date` varchar(255) DEFAULT NULL,
  `salary` double(10,2) DEFAULT NULL,
  `flight_date` varchar(255) DEFAULT NULL,
  `visa_exp_date` varchar(255) DEFAULT NULL,
  `is_job` tinyint(1) DEFAULT NULL,
  `is_ticket` tinyint(1) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT '0',
  `updated_by` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clients_user_id_foreign` (`user_id`),
  ADD KEY `clients_country_id_foreign` (`country_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `code_masters` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `clients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
