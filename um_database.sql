-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2025 at 08:42 PM
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
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`) VALUES
(1, 'Nadeem', 'nadeem26');

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
  `event_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking2`
--

INSERT INTO `booking2` (`id`, `service_id`, `service_name`, `service_type`, `booking_date`, `customer_name`, `customer_email`, `customer_mobile`, `guest_count`, `num_days`, `total_price`, `status`, `payment_status`, `created_at`, `user_id`, `merchant_id`, `event_image`) VALUES
(9, 1, 'Altimate', 'decoration_service', '2025-03-04', 'Makwana Nadeem', 'makwananadeem0@gmail.com', '6598784512', 20, 5, 25000.00, 'Accepted', 'Paid', '2025-02-19 19:50:22', 52, 14, 'uploads/1738857354_BrandAssets_Logos_02-NSymbol.jpg'),
(11, 2, 'def', 'entertainment_service', '2025-03-01', 'Makwana Nadeem', 'makwananadeem0@gmail.com', '5698742560', 300, 1, 3000.00, '', 'Pending', '2025-02-19 22:17:21', 52, 14, 'uploads/1738860502_image-10.png.webp');

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
(1, 'Nadeem Food Zone', 'Catering Service', 'Veg\r\nroti , dal,chaval,panir sabji\r\nnon - veg\r\nchiken ,roti,chaval', 1000, 200.00, 500, 'uploads/1738860019_image-12.png.webp', '2025-02-06 16:40:19', 14);

-- --------------------------------------------------------

--
-- Table structure for table `decoration_service`
--

CREATE TABLE `decoration_service` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(100) NOT NULL,
  `service_types` text NOT NULL,
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

INSERT INTO `decoration_service` (`service_id`, `service_name`, `service_types`, `service_category`, `description`, `custom_decoration`, `price`, `event_image`, `added_on`, `merchant_id`) VALUES
(1, 'Altimate', 'Decoration Service', 'Birthday', 'full birthday decoration on your place', 'No', 5000.00, 'uploads/1738857354_BrandAssets_Logos_02-NSymbol.jpg', '2025-02-06 15:55:54', 14),
(5, 'kjkjk', 'Decoration Service', 'Wedding', 'hjkhjk', 'No', 15000.00, 'uploads/1740003679_image-12.png.webp', '2025-02-19 22:21:19', 14);

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
(1, 'Abc', 'Entertainment Service', 'Music', 'Full Day', 10500.00, 'uploads/1738856903_image-12.png.webp', '2025-02-06 15:48:23', 14),
(2, 'def', 'Entertainment Service', 'Dance', 'Full Day', 3000.00, 'uploads/1738860502_image-10.png.webp', '2025-02-06 16:48:22', 14),
(4, 'ghi', 'Entertainment Service', 'Comedy', '1 hours', 5000.00, 'uploads/1738860725_image-10.png.webp', '2025-02-06 16:52:05', 14),
(6, 'jkl', 'Entertainment Service', 'Dance', '1 hours', 2000.00, 'uploads/1738863628_image-10.png.webp', '2025-02-06 17:40:28', 14),
(7, 'mno', 'Entertainment Service', 'Music', '1 hours', 5000.00, 'uploads/1738873646_image-11-1024x352.png.webp', '2025-02-06 20:27:26', 19),
(8, 'jhkkjhk', 'Entertainment Service', 'Music', 'Full Day', 15000.00, 'uploads/1740003962_image-12.png.webp', '2025-02-19 22:26:02', 14);

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
  `reset_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `merchant`
--

INSERT INTO `merchant` (`merchant_id`, `name`, `details`, `email`, `mobile`, `password`, `created_at`, `reset_token`) VALUES
(7, 'nadeem enterprize new', 'no give', 'tigerking2323@gmail.com', '2147483647', 'tiger', '2025-02-26 18:35:57', NULL),
(13, 'booking game', 'i have many books', 'books@gmail.com', '1597538526', 'Book', '2025-02-26 18:35:57', NULL),
(14, 'Karnavati king', 'no give data', 'shreejiroadlines0082@gmail.com', '5687158268', '$2y$10$JigU8jDIit2p1jip1JCTHeUgKjimfqc0OrbPrFlRGjM9fQA0i0jiG', '2025-02-26 18:35:57', NULL),
(19, 'new', 'kuch bhi ho ', 'makwananadeem0@gmail.com', '5684752695', '$2y$10$.WIxxMDJdYJyZa2tPQIMJ.QFe9sqUmaSSe7EQVwEyA0jMYZf3Rx5K', '2025-02-26 18:35:57', NULL),
(20, 'prakash papad enterprize', 'i make papad and selling through your website', 'prakash@gmail.com', '4565547592', '$2y$10$IymPXFS7pWWja4rH499jLOIvwgk.eVKDrdmkgsGR/P0/AHPa3vD0W', '2025-02-26 18:35:57', NULL);

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
(1, 52, 9, 14, 'pay_PxmWeZ6i0D7qIp', 'order_PxmVYJu1BGipsO', 25000.00, 'Paid', '2025-02-20 01:24:26', 'Razorpay'),
(2, 52, 11, 14, 'pay_Q00xoR8FdPT2x5', 'order_Q00w4eLpm9w7aP', 3000.00, 'Paid', '2025-02-25 16:55:13', 'Razorpay');

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
(1, 'Nadeem Photograpy', 'Photography Service', 'Birthday', 'Yes', 'no need any extra pay', 'Full Day', 3, 'No', 10000.00, 'uploads/1738860209_image-12.png.webp', '2025-02-06 16:43:29', 14),
(2, 'Nadeem Photograpy king', 'Photography Service', 'Wedding', 'Yes', 'ghghgjhjhj', 'Full Day', 5, 'Yes', 20020.00, 'uploads/1740002457_image-12.png.webp', '2025-02-19 22:00:57', 14);

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
  `reset_token` varchar(255) DEFAULT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `email`, `mobile`, `password`, `reset_token`, `created_at`) VALUES
(39, 'Om Kadia', 'om@gmail.com', '8849742760', '$2y$10$oi8h0cA/XMklkPrDD5apSuDxj0N8vdryCnI9kyZhLTna/8Toqcm1.', NULL, '2025-02-26'),
(42, 'Meghall', 'meghal@gmail.com', '4596178413', '$2y$10$LZTyK4VF.DDqIOk.tMbbvOYn7rmULPzxHhz3KLtWx8bnAIoJ9E4IO', 'aa4daa5933347924fae381720c192b05d83a99c4ab79efbfa5536327c945c5b5df03c8f78dcd029bf5382f356755e8072334', '2025-02-26'),
(44, 'Mihir', 'Mihir555@gmail.com', '4569852695', 'mihir', NULL, '2025-02-26'),
(47, 'pathan', 'pathan@gmail.com', '4569874125', '$2y$10$8SZ1JdEIESti6Lt93W2xbekG29ordevql/.bpcMPoxcWYLrybz4sS', NULL, '2025-02-26'),
(50, 'Akram', 'akram@gmail.com', '8965412689', '$2y$10$HMaEb1/TRyBAWpxdmJ2ezukyY0g7vbguVoUo1.zaWA/jPyg9wPcne', NULL, '2025-02-26'),
(51, 'Makwana Nadeem king', 'nadeem123@gmail.com', '8849742758', '$2y$10$cZHCfqtADXz7qJTQ9DjBRuT3pZt0AiFLEr5Hy4Gl3XI6I./HS3eTq', NULL, '2025-02-26'),
(52, 'Makwana Nadeem', 'makwananadeem0@gmail.com', '8849742758', '$2y$10$.Q8QIgEzhQVYsz28UQD4/edIH2LMj/7EBtFGJyRj1vI792xBGDlm6', NULL, '2025-02-26'),
(53, 'Prakash', 'prakash@gmail.com', '4785961236', '$2y$10$lW44e9KfuQZaddJ7JZiJsuiWpqT1xyO4yQT.OefYGx/GnVQHf2PhS', NULL, '2025-02-26');

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
  `address` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `pincode` varchar(10) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `event_image` varchar(255) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `merchant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `venue_booking`
--

INSERT INTO `venue_booking` (`service_id`, `service_type`, `service_name`, `service_category`, `capacity`, `address`, `city`, `pincode`, `price`, `event_image`, `added_on`, `merchant_id`) VALUES
(2, 'venue booking', 'Nadeem Sky', 'Lawn', 100, 'Uvarsad , Pandya Vas', 'Gandhinagar', '382422', 15000.00, 'uploads/1738853154_image-12.png.webp', '2025-02-06 14:45:54', 14),
(3, 'venue booking', 'Nadeem High', 'Resort', 5000, 'Uvarsad , Pandya Vas', 'Gandhinagar', '382422', 20000.00, 'uploads/1738853383_BrandAssets_Logos_02-NSymbol.jpg', '2025-02-06 14:49:44', 14),
(7, 'venue booking', 'Nadeem High', 'Hotel', 5000, 'Uvarsad , Pandya Vas', 'Gandhinagar', '382422', 25000.00, 'uploads/1739369331_image-12.png.webp', '2025-02-12 14:08:51', 14),
(8, 'venue booking', 'Nadeem Sky', 'Resort', 15000, 'Uvarsad , Pandya Vas', 'Gandhinagar', '382422', 50000.00, 'uploads/1739369466_image-13-1024x277.png.webp', '2025-02-12 14:11:06', 14),
(10, 'venue booking', 'abc sky', 'Hotel', 5000, 'Uvarsad , Pandya Vas', 'Gandhinagar', '382422', 15000.00, 'uploads/1740001453_image-11-1024x352.png.webp', '2025-02-19 21:44:13', 14);

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
  ADD KEY `merchant_id` (`merchant_id`);

--
-- Indexes for table `decoration_service`
--
ALTER TABLE `decoration_service`
  ADD PRIMARY KEY (`service_id`),
  ADD KEY `merchant_id` (`merchant_id`);

--
-- Indexes for table `entertainment_service`
--
ALTER TABLE `entertainment_service`
  ADD PRIMARY KEY (`service_id`),
  ADD KEY `merchant_id` (`merchant_id`);

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
  ADD KEY `merchant_id` (`merchant_id`);

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
  ADD KEY `merchant_id` (`merchant_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `catering_service`
--
ALTER TABLE `catering_service`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `decoration_service`
--
ALTER TABLE `decoration_service`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `entertainment_service`
--
ALTER TABLE `entertainment_service`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `merchant`
--
ALTER TABLE `merchant`
  MODIFY `merchant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `photography_service`
--
ALTER TABLE `photography_service`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `venue_booking`
--
ALTER TABLE `venue_booking`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
  ADD CONSTRAINT `catering_service_ibfk_1` FOREIGN KEY (`merchant_id`) REFERENCES `merchant` (`merchant_id`);

--
-- Constraints for table `decoration_service`
--
ALTER TABLE `decoration_service`
  ADD CONSTRAINT `decoration_service_ibfk_1` FOREIGN KEY (`merchant_id`) REFERENCES `merchant` (`merchant_id`);

--
-- Constraints for table `entertainment_service`
--
ALTER TABLE `entertainment_service`
  ADD CONSTRAINT `entertainment_service_ibfk_1` FOREIGN KEY (`merchant_id`) REFERENCES `merchant` (`merchant_id`);

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
  ADD CONSTRAINT `photography_service_ibfk_1` FOREIGN KEY (`merchant_id`) REFERENCES `merchant` (`merchant_id`);

--
-- Constraints for table `venue_booking`
--
ALTER TABLE `venue_booking`
  ADD CONSTRAINT `venue_booking_ibfk_1` FOREIGN KEY (`merchant_id`) REFERENCES `merchant` (`merchant_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
