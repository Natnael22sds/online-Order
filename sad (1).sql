-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2025 at 06:43 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sad`
--

-- --------------------------------------------------------

--
-- Table structure for table `daily_reports`
--

CREATE TABLE `daily_reports` (
  `id` int(11) NOT NULL,
  `report_date` date DEFAULT NULL,
  `total_orders` int(11) DEFAULT NULL,
  `total_deliveries` int(11) DEFAULT NULL,
  `generated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `daily_reports`
--

INSERT INTO `daily_reports` (`id`, `report_date`, `total_orders`, `total_deliveries`, `generated_at`) VALUES
(1, '2025-04-13', 0, NULL, '2025-04-13 00:11:14');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `ingredient_name` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit` varchar(20) DEFAULT NULL,
  `restock_level` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `ingredient_name`, `quantity`, `unit`, `restock_level`) VALUES
(1, 'Flour', 5000, 'grams', 1000),
(2, 'Buttercream', 2000, 'grams', 500),
(3, 'Vanilla Essence', 500, 'ml', 200),
(4, 'Sprinkles', 101, 'grams', 100);

-- --------------------------------------------------------

--
-- Table structure for table `orderss`
--

CREATE TABLE `orderss` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_date` date NOT NULL,
  `pickup_or_delivery` enum('pickup','delivery') NOT NULL,
  `delivery_address` text DEFAULT NULL,
  `required_time` time DEFAULT NULL,
  `status` enum('pending','completed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orderss`
--

INSERT INTO `orderss` (`id`, `user_id`, `order_date`, `pickup_or_delivery`, `delivery_address`, `required_time`, `status`, `created_at`) VALUES
(1, 4, '2025-04-09', 'pickup', NULL, '02:49:00', 'completed', '2025-04-12 21:49:24'),
(2, 5, '2025-04-23', 'pickup', NULL, '03:27:00', 'pending', '2025-04-13 00:24:29'),
(3, 3, '2025-04-11', 'delivery', 'Around 4 killo', '10:11:00', 'completed', '2025-04-13 07:09:08'),
(4, 3, '2025-04-24', 'pickup', NULL, '10:15:00', 'pending', '2025-04-13 07:12:36'),
(5, 5, '2025-04-09', 'delivery', 'Around 4kilo', '10:18:00', 'completed', '2025-04-13 07:14:22'),
(6, 5, '2025-05-01', 'delivery', 'Around 4kilo', '10:02:00', '', '2025-04-13 07:59:01'),
(7, 9, '2025-04-25', 'pickup', NULL, '12:35:00', 'pending', '2025-04-13 09:31:50'),
(8, 9, '2025-04-24', 'pickup', NULL, '14:33:00', 'pending', '2025-04-13 09:33:12'),
(9, 9, '2025-04-24', 'delivery', 'Around 4kilo', '14:34:00', 'completed', '2025-04-13 09:34:32'),
(11, 5, '2025-04-24', 'pickup', NULL, '18:11:00', 'pending', '2025-04-13 13:12:07');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `flavor` varchar(100) DEFAULT NULL,
  `icing` varchar(100) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `decoration` varchar(100) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `flavor`, `icing`, `color`, `decoration`, `Quantity`) VALUES
(1, 1, 'Vanilla', 'Yes', 'Brown', 'Chocolate cream', NULL),
(2, 2, 'Vanilla', 'Chocolate', 'Brown', 'Chocolate cream', NULL),
(3, 3, 'Vanilla', 'Buttercream', 'Pink', 'Sprinkles', NULL),
(4, 4, 'Vanilla', 'Buttercream', 'Pink', 'Sprinkles', NULL),
(5, 5, 'Vanilla', 'Buttercream', 'Pink', 'Sprinkles', NULL),
(6, 6, 'Chocolate', 'Buttercream', 'Pink', 'Sprinkles', NULL),
(7, 7, 'Vanilla', 'Buttercream', 'Pink', 'Sprinkles', NULL),
(8, 8, 'Vanilla', 'Buttercream', 'Pink', 'Sprinkles', NULL),
(9, 9, 'Vanilla', 'Buttercream', 'Pink', 'Sprinkles', NULL),
(10, 11, 'Vanilla', 'Buttercream', 'Pink', 'Sprinkles', 6);

-- --------------------------------------------------------

--
-- Table structure for table `userss`
--

CREATE TABLE `userss` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer','delivery') DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `userss`
--

INSERT INTO `userss` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(2, 'Admin', 'admin@gmail.com', '$2y$10$OIsytRY4pDXHAsjBD8KVk.xDpQ7XB0g/7yDJIcZMjHYVXmDLYPwXC', 'admin', '2025-04-12 21:25:43'),
(3, 'Yohannes Wakuma', 'Yohannes@gmail.com', '$2y$10$LNDOA6VG6xojwN7jj4CzOu77FUArnXlj5F6v/bzgmqJD0E/Re5A02', 'customer', '2025-04-12 21:42:08'),
(4, 'Tewfik', 'Tewfik@gmail.com', '$2y$10$xS6OEhZ.j6qqTS6rWRsGxu8c7Gro0oCwU5WCnnhpf4jJDTmBfRIC.', 'customer', '2025-04-12 21:45:32'),
(5, 'Natnael Mitiku', 'mitikunathan@gmail.com', '$2y$10$srHBI915Z2/dFg5d5fbFPuTRWoieiyysgW./S0pvX34kND3og.D/2', 'customer', '2025-04-13 00:23:55'),
(6, 'Munir', 'Munir@gmail.com', '$2y$10$SjhBjtluvpH6VlwV4EAH2uAAX8zjjqV8uBdwtUX8/W7DT/Mks0Pzm', 'delivery', '2025-04-13 01:03:45'),
(7, 'Hasen', 'Hasen@gmail.com', '$2y$10$SxuSn1polardYKATDWOQq.V88QRG4jpxYWDhCv6fpKv8yeXe9Kq8y', 'customer', '2025-04-13 06:57:29'),
(9, 'Thomas Markos', 'Thomas@gmail.com', '$2y$10$ja5qLHQyEIb9lMTO25sWpeq0Xoy9BjgSiekuyRF06IJz9OZqLaN8a', 'customer', '2025-04-13 09:26:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `daily_reports`
--
ALTER TABLE `daily_reports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `report_date` (`report_date`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orderss`
--
ALTER TABLE `orderss`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `userss`
--
ALTER TABLE `userss`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `daily_reports`
--
ALTER TABLE `daily_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orderss`
--
ALTER TABLE `orderss`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `userss`
--
ALTER TABLE `userss`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orderss`
--
ALTER TABLE `orderss`
  ADD CONSTRAINT `orderss_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `userss` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orderss` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
