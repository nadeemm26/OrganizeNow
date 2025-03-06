-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2025 at 05:14 AM
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
-- Database: `um`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`, `profile_image`) VALUES
(1, 'Nadeem Makwana', 'nadeem26', '1741121249_IMG_20230301_140730-01.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `booking2`
--

CREATE TABLE `booking2` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `service_name` varchar(200) NOT NULL,
  `service_type` text NOT NULL,
  `booking_date` date NOT NULL,
  `customer_name` varchar(200) NOT NULL,
  `customer_email` varchar(200) NOT NULL,
  `customer_mobile` varchar(200) NOT NULL,
  `guest_count` int(200) NOT NULL,
  `num_days` int(50) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('Pending','Accepted','Rejected') DEFAULT 'Pending',
  `payment_status` enum('Pending','Paid') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `merchant_id` int(11) NOT NULL,
  `event_image` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking2`
--

INSERT INTO `booking2` (`id`, `service_id`, `service_name`, `service_type`, `booking_date`, `customer_name`, `customer_email`, `customer_mobile`, `guest_count`, `num_days`, `total_price`, `status`, `payment_status`, `created_at`, `user_id`, `merchant_id`, `event_image`, `location`) VALUES
(17, 11, 'The Leela', 'venue_booking', '2025-03-12', 'Makwana Nadeem', 'makwananadeem0@gmail.com', '8849742758', 200, 2, 24600.00, 'Accepted', 'Paid', '2025-03-05 23:34:23', 52, 14, 'uploads/1741227384_Ven6.jpg', 'Gandhinagar');

-- --------------------------------------------------------

--
-- Table structure for table `catering_service`
--

CREATE TABLE `catering_service` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(100) NOT NULL,
  `service_type` varchar(100) NOT NULL,
  `menu_details` text NOT NULL,
  `service_capacity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `min_order` int(11) NOT NULL,
  `event_image` varchar(255) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `merchant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `catering_service`
--

INSERT INTO `catering_service` (`service_id`, `service_name`, `service_type`, `menu_details`, `service_capacity`, `price`, `min_order`, `event_image`, `added_on`, `merchant_id`) VALUES
(3, 'Cafevale King', 'Catering Service', 'Panjabi Full Items - Panir sabji , Butter Roti , Jira Rais , Dal, Sweetes ', 5000, 180.00, 50, 'uploads/1741227703_Cate7.jpg', '2025-03-06 02:21:43', 14);

-- --------------------------------------------------------

--
-- Table structure for table `decoration_service`
--

CREATE TABLE `decoration_service` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(100) NOT NULL,
  `service_type` text NOT NULL,
  `service_category` text NOT NULL,
  `description` text NOT NULL,
  `custom_decoration` enum('Yes','No') NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `event_image` varchar(255) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `merchant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `decoration_service`
--

INSERT INTO `decoration_service` (`service_id`, `service_name`, `service_type`, `service_category`, `description`, `custom_decoration`, `price`, `event_image`, `added_on`, `merchant_id`) VALUES
(7, 'Unique Decoration King', 'Decoration Service', 'Birthday', 'Fully Decorate Your Location Birthday Party For You', 'No', 15000.00, 'uploads/1741228338_B1.jpg', '2025-03-06 02:32:18', 14);

-- --------------------------------------------------------

--
-- Table structure for table `entertainment_service`
--

CREATE TABLE `entertainment_service` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(100) NOT NULL,
  `service_type` varchar(50) NOT NULL,
  `service_category` text NOT NULL,
  `performance_duration` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `event_image` varchar(255) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `merchant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `entertainment_service`
--

INSERT INTO `entertainment_service` (`service_id`, `service_name`, `service_type`, `service_category`, `performance_duration`, `price`, `event_image`, `added_on`, `merchant_id`) VALUES
(9, 'Hasi Majak Ke King', 'Entertainment Service', 'Comedy', 'Full Day', 20500.00, 'uploads/1741228403_Ent3.jpg', '2025-03-06 02:33:23', 14);

-- --------------------------------------------------------

--
-- Table structure for table `merchant`
--

CREATE TABLE `merchant` (
  `merchant_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `details` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `password` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `otp` varchar(6) DEFAULT NULL,
  `otp_expiry` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `merchant`
--

INSERT INTO `merchant` (`merchant_id`, `name`, `details`, `email`, `mobile`, `password`, `created_at`, `otp`, `otp_expiry`) VALUES
(7, 'nadeem enterprize new', 'no give', 'tigerking2323@gmail.com', '2147483647', 'tiger', '2025-02-26 18:35:57', NULL, NULL),
(13, 'booking game', 'i have many books', 'books@gmail.com', '1597538526', 'Book', '2025-02-26 18:35:57', NULL, NULL),
(14, 'Karnavati king', 'no give data', 'shreejiroadlines0082@gmail.com', '5687158268', '$2y$10$JigU8jDIit2p1jip1JCTHeUgKjimfqc0OrbPrFlRGjM9fQA0i0jiG', '2025-02-26 18:35:57', NULL, NULL),
(19, 'new', 'kuch bhi ho ', 'makwananadeem0@gmail.com', '5684752695', '$2y$10$jEpvt8XRV8GilI0n1Y7q7u38J25LOdrdkk805H63RB0MOhr3/a7BK', '2025-02-26 18:35:57', NULL, NULL),
(20, 'prakash papad enterprize', 'i make papad and selling through your website', 'prakash@gmail.com', '4565547592', '$2y$10$IymPXFS7pWWja4rH499jLOIvwgk.eVKDrdmkgsGR/P0/AHPa3vD0W', '2025-02-26 18:35:57', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `merchant_id` int(11) NOT NULL,
  `payment_id` varchar(255) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `payment_status` enum('Pending','Paid') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_gateway` varchar(50) NOT NULL DEFAULT 'Razorpay'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `booking_id`, `merchant_id`, `payment_id`, `order_id`, `amount_paid`, `payment_status`, `created_at`, `payment_gateway`) VALUES
(6, 52, 17, 14, 'pay_Q3MtJOpJ8Z7xw8', 'order_Q3Mt3sggc6Lf5p', 24600.00, 'Paid', '2025-03-06 04:11:46', 'Razorpay');

-- --------------------------------------------------------

--
-- Table structure for table `photography_service`
--

CREATE TABLE `photography_service` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(100) NOT NULL,
  `service_type` text NOT NULL,
  `service_category` text NOT NULL,
  `videography` enum('Yes','No') NOT NULL,
  `package_desc` text NOT NULL,
  `coverage_duration` varchar(50) NOT NULL,
  `num_photographers` int(11) NOT NULL,
  `editing` enum('Yes','No') NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `event_image` varchar(255) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `merchant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `photography_service`
--

INSERT INTO `photography_service` (`service_id`, `service_name`, `service_type`, `service_category`, `videography`, `package_desc`, `coverage_duration`, `num_photographers`, `editing`, `price`, `event_image`, `added_on`, `merchant_id`) VALUES
(3, 'Lucky PhotoShoot', 'Photography Service', 'Wedding', 'Yes', 'All Over Your Wedding Photoshot + Video Shoot', 'Full Day', 5, 'Yes', 30000.00, 'uploads/1741227856_Vid1.jpg', '2025-03-06 02:24:16', 14);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `password` varchar(200) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `otp` varchar(6) DEFAULT NULL,
  `otp_expiry` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `email`, `mobile`, `password`, `created_at`, `otp`, `otp_expiry`) VALUES
(39, 'Om Kadia', 'om@gmail.com', '8849742760', '$2y$10$oi8h0cA/XMklkPrDD5apSuDxj0N8vdryCnI9kyZhLTna/8Toqcm1.', '2025-02-26', NULL, NULL),
(42, 'Meghall', 'meghal@gmail.com', '4596178413', '$2y$10$LZTyK4VF.DDqIOk.tMbbvOYn7rmULPzxHhz3KLtWx8bnAIoJ9E4IO', '2025-02-26', NULL, NULL),
(44, 'Mihir', 'Mihir555@gmail.com', '4569852695', 'mihir', '2025-02-26', NULL, NULL),
(47, 'pathan', 'pathan@gmail.com', '4569874125', '$2y$10$8SZ1JdEIESti6Lt93W2xbekG29ordevql/.bpcMPoxcWYLrybz4sS', '2025-02-26', NULL, NULL),
(50, 'Akram', 'akram@gmail.com', '8965412689', '$2y$10$HMaEb1/TRyBAWpxdmJ2ezukyY0g7vbguVoUo1.zaWA/jPyg9wPcne', '2025-02-26', NULL, NULL),
(51, 'Makwana Nadeem king', 'nadeem123@gmail.com', '8849742758', '$2y$10$cZHCfqtADXz7qJTQ9DjBRuT3pZt0AiFLEr5Hy4Gl3XI6I./HS3eTq', '2025-02-26', NULL, NULL),
(52, 'Makwana Nadeem', 'makwananadeem0@gmail.com', '8849742758', '$2y$10$onriip3MGEdEjYITESI4X.JnF7TLbjqqUFACbVD251eYMuhaqQgd6', '2025-02-26', NULL, NULL),
(53, 'Prakash', 'prakash@gmail.com', '4785961236', '$2y$10$lW44e9KfuQZaddJ7JZiJsuiWpqT1xyO4yQT.OefYGx/GnVQHf2PhS', '2025-02-26', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `venue_booking`
--

CREATE TABLE `venue_booking` (
  `service_id` int(11) NOT NULL,
  `service_type` varchar(100) NOT NULL,
  `service_name` varchar(100) NOT NULL,
  `service_category` varchar(50) NOT NULL,
  `capacity` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `event_image` varchar(255) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `merchant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `venue_booking`
--

INSERT INTO `venue_booking` (`service_id`, `service_type`, `service_name`, `service_category`, `capacity`, `location`, `price`, `event_image`, `added_on`, `merchant_id`) VALUES
(11, 'venue booking', 'The Leela', 'Hotel', 5000, 'Gandhinagar', 12300.00, 'uploads/1741227384_Ven6.jpg', '2025-03-06 02:16:24', 14);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `booking2`
--
ALTER TABLE `booking2`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `merchant_id` (`merchant_id`);

--
-- Indexes for table `catering_service`
--
ALTER TABLE `catering_service`
  ADD PRIMARY KEY (`service_id`),
  ADD KEY `catering_service_ibfk_1` (`merchant_id`);

--
-- Indexes for table `decoration_service`
--
ALTER TABLE `decoration_service`
  ADD PRIMARY KEY (`service_id`),
  ADD KEY `decoration_service_ibfk_1` (`merchant_id`);

--
-- Indexes for table `entertainment_service`
--
ALTER TABLE `entertainment_service`
  ADD PRIMARY KEY (`service_id`),
  ADD KEY `entertainment_service_ibfk_1` (`merchant_id`);

--
-- Indexes for table `merchant`
--
ALTER TABLE `merchant`
  ADD PRIMARY KEY (`merchant_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_id` (`payment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `merchant_id` (`merchant_id`);

--
-- Indexes for table `photography_service`
--
ALTER TABLE `photography_service`
  ADD PRIMARY KEY (`service_id`),
  ADD KEY `photography_service_ibfk_1` (`merchant_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `venue_booking`
--
ALTER TABLE `venue_booking`
  ADD PRIMARY KEY (`service_id`),
  ADD KEY `venue_booking_ibfk_1` (`merchant_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `booking2`
--
ALTER TABLE `booking2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `catering_service`
--
ALTER TABLE `catering_service`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `decoration_service`
--
ALTER TABLE `decoration_service`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `entertainment_service`
--
ALTER TABLE `entertainment_service`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `merchant`
--
ALTER TABLE `merchant`
  MODIFY `merchant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `photography_service`
--
ALTER TABLE `photography_service`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `venue_booking`
--
ALTER TABLE `venue_booking`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking2`
--
ALTER TABLE `booking2`
  ADD CONSTRAINT `booking2_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking2_ibfk_2` FOREIGN KEY (`merchant_id`) REFERENCES `merchant` (`merchant_id`) ON DELETE CASCADE;

--
-- Constraints for table `catering_service`
--
ALTER TABLE `catering_service`
  ADD CONSTRAINT `catering_service_ibfk_1` FOREIGN KEY (`merchant_id`) REFERENCES `merchant` (`merchant_id`) ON DELETE CASCADE;

--
-- Constraints for table `decoration_service`
--
ALTER TABLE `decoration_service`
  ADD CONSTRAINT `decoration_service_ibfk_1` FOREIGN KEY (`merchant_id`) REFERENCES `merchant` (`merchant_id`) ON DELETE CASCADE;

--
-- Constraints for table `entertainment_service`
--
ALTER TABLE `entertainment_service`
  ADD CONSTRAINT `entertainment_service_ibfk_1` FOREIGN KEY (`merchant_id`) REFERENCES `merchant` (`merchant_id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`booking_id`) REFERENCES `booking2` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payments_ibfk_3` FOREIGN KEY (`merchant_id`) REFERENCES `merchant` (`merchant_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `photography_service`
--
ALTER TABLE `photography_service`
  ADD CONSTRAINT `photography_service_ibfk_1` FOREIGN KEY (`merchant_id`) REFERENCES `merchant` (`merchant_id`) ON DELETE CASCADE;

--
-- Constraints for table `venue_booking`
--
ALTER TABLE `venue_booking`
  ADD CONSTRAINT `venue_booking_ibfk_1` FOREIGN KEY (`merchant_id`) REFERENCES `merchant` (`merchant_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
