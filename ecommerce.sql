-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 11, 2026 at 05:55 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `compare_price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `badge` varchar(100) DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT 0.0,
  `reviews` int(11) DEFAULT 0,
  `is_new` tinyint(1) DEFAULT 0,
  `is_best_seller` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `price`, `compare_price`, `image`, `badge`, `rating`, `reviews`, `is_new`, `is_best_seller`, `created_at`) VALUES
(1, 'Classic Overshirttytty', 'Apparel', 59.00, 79.00, 'overshirt.jpeg', 'New', 4.8, 124, 1, 1, '2026-08-08 11:27:42'),
(2, 'Canvas Tote', 'Accessories', 35.00, NULL, 'images.jpeg', 'Just In', 4.7, 89, 1, 0, '2026-08-08 11:27:42'),
(3, 'Everyday Jacket', 'Apparel', 89.00, 110.00, 'mugg.jpeg', 'Popular', 4.9, 210, 0, 1, '2026-08-08 11:27:42'),
(4, 'Daily Mug', 'Home Goods', 18.00, NULL, 'mug.jpeg', NULL, 4.6, 75, 0, 1, '2026-08-08 11:27:42'),
(5, 'enfjkdsj', 'Accessories', 200.00, 900.00, 'product_6a771a9254c9b9.90728595.png', 'popular', 4.0, 2, 1, 0, '2026-08-08 12:01:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Thaw Han', 'thaw@gmail.com', '$2a$12$/8QVlsnNc/VRgOznmTzzu./ea.qoYSu.UCqv8VItDoLz4iZQ4QJVi', 'admin', '2026-08-11 15:43:30'),
(2, 'user', 'user@gmail.com', '$2a$12$hDpykWAENdIHy6P6MpjKluHJA5Ko0OijFVLNSbgU.zc9WpnN6tZj.', 'user', '2026-08-11 15:48:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
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
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
