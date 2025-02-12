-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 12, 2025 at 10:22 PM
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
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `booking_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `booking_date` date NOT NULL,
  `guest_count` int(11) DEFAULT NULL,
  `num_days` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('Pending','Accepted','Rejected') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `merchant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `service_id`, `category`, `booking_date`, `guest_count`, `num_days`, `total_price`, `status`, `created_at`, `merchant_id`) VALUES
(7, 50, 1, 'catering_service', '2025-02-28', 500, 1, 100000.00, 'Rejected', '2025-02-12 20:03:51', 14),
(8, 50, 1, 'catering_service', '2025-03-01', 1000, 1, 200000.00, 'Accepted', '2025-02-12 20:06:03', 14),
(9, 50, 2, 'venue_booking', '2025-02-20', 500, 2, 30000.00, 'Accepted', '2025-02-12 20:07:07', 14);

-- --------------------------------------------------------

--
-- Table structure for table `bookingss`
--

CREATE TABLE `bookingss` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `merchant_id` int(11) NOT NULL,
  `service_type` varchar(50) NOT NULL,
  `service_id` int(11) NOT NULL,
  `event_date` date NOT NULL,
  `contact_name` varchar(100) NOT NULL,
  `contact_email` varchar(100) NOT NULL,
  `contact_phone` varchar(20) NOT NULL,
  `status` enum('Pending','Accepted','Rejected') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `catering_service`
--

CREATE TABLE `catering_service` (
  `catering_id` int(11) NOT NULL,
  `catering_name` varchar(100) NOT NULL,
  `menu_details` text NOT NULL,
  `capacity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `min_order` int(11) NOT NULL,
  `event_image` varchar(255) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `merchant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `catering_service`
--

INSERT INTO `catering_service` (`catering_id`, `catering_name`, `menu_details`, `capacity`, `price`, `min_order`, `event_image`, `added_on`, `merchant_id`) VALUES
(1, 'Nadeem Food Zone', 'Veg\r\nroti , dal,chaval,panir sabji\r\nnon - veg\r\nchiken ,roti,chaval', 1000, 200.00, 500, 'uploads/1738860019_image-12.png.webp', '2025-02-06 16:40:19', 14);

-- --------------------------------------------------------

--
-- Table structure for table `decoration_service`
--

CREATE TABLE `decoration_service` (
  `decoration_id` int(11) NOT NULL,
  `decoration_types` text NOT NULL,
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

INSERT INTO `decoration_service` (`decoration_id`, `decoration_types`, `description`, `custom_decoration`, `price`, `event_image`, `added_on`, `merchant_id`) VALUES
(1, 'Birthday', 'full birthday decoration on your place', 'No', 5000.00, 'uploads/1738857354_BrandAssets_Logos_02-NSymbol.jpg', '2025-02-06 15:55:54', 14),
(3, 'Festival', 'ifj djfh slksd vjierf sjf', 'Yes', 50000.00, 'uploads/1738871875_image-11-1024x352.png.webp', '2025-02-06 19:57:55', 14);

-- --------------------------------------------------------

--
-- Table structure for table `entertainment_service`
--

CREATE TABLE `entertainment_service` (
  `entertainment_id` int(11) NOT NULL,
  `service_type` varchar(50) NOT NULL,
  `performance_duration` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `event_image` varchar(255) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `merchant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `entertainment_service`
--

INSERT INTO `entertainment_service` (`entertainment_id`, `service_type`, `performance_duration`, `price`, `event_image`, `added_on`, `merchant_id`) VALUES
(1, 'Music', 'Full Day', 10500.00, 'uploads/1738856903_image-12.png.webp', '2025-02-06 15:48:23', 14),
(2, 'Dance', 'Full Day', 3000.00, 'uploads/1738860502_image-10.png.webp', '2025-02-06 16:48:22', 14),
(3, 'Magic Show', '1 hours', 3000.00, 'uploads/1738860573_image-10.png.webp', '2025-02-06 16:49:33', 14),
(4, 'Comedy', '1 hours', 5000.00, 'uploads/1738860725_image-10.png.webp', '2025-02-06 16:52:05', 14),
(6, 'Dance', '1 hours', 2000.00, 'uploads/1738863628_image-10.png.webp', '2025-02-06 17:40:28', 14),
(7, 'Music', '1 hours', 5000.00, 'uploads/1738873646_image-11-1024x352.png.webp', '2025-02-06 20:27:26', 19);

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `event_id` int(11) NOT NULL,
  `event_name` varchar(200) NOT NULL,
  `event_description` varchar(200) NOT NULL,
  `event_price` int(11) NOT NULL,
  `merchant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`event_id`, `event_name`, `event_description`, `event_price`, `merchant_id`) VALUES
(1, 'birthaday', 'ytghgg', 2000, 14),
(2, 'birthaday', 'ytghgg', 2000, 14),
(3, 'birthaday', 'ytghgg', 2000, 14);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `eventname` varchar(255) NOT NULL,
  `type` varchar(200) NOT NULL,
  `price` decimal(50,0) NOT NULL,
  `eventdescription` text NOT NULL,
  `location` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `event_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `merchant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `merchant_id` int(11) NOT NULL,
  `comments` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `merchant`
--

INSERT INTO `merchant` (`merchant_id`, `name`, `details`, `email`, `mobile`, `password`) VALUES
(7, 'nadeem enterprize new', 'no give', 'tigerking2323@gmail.com', '2147483647', 'tiger'),
(12, 'nadeem enterprize', 'no give', 'nnnng@gmail.com', '2147483647', '12345'),
(13, 'booking game', 'i have many books', 'books@gmail.com', '1597538526', 'Book'),
(14, 'Karnavati ', 'no give data', 'shreejiroadlines0082@gmail.com', '5687158268', '$2y$10$JigU8jDIit2p1jip1JCTHeUgKjimfqc0OrbPrFlRGjM9fQA0i0jiG'),
(19, 'new', 'kuch bhi ho ', 'new123@gmail.com', '5684752695', '$2y$10$MWcIEtUZFvXLdGWErgOkHOMxjSzrV5DHncNYkQiuPJmwgCMxUcl5G');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `order_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `merchant_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` enum('Card','UPI','Net Banking') NOT NULL,
  `status` enum('Pending','Completed','Failed') NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `booking_id`, `user_id`, `merchant_id`, `amount`, `payment_method`, `status`, `transaction_id`, `created_at`) VALUES
(1, 8, 50, 14, 200000.00, 'UPI', 'Completed', '', '2025-02-12 21:13:37');

-- --------------------------------------------------------

--
-- Table structure for table `photography_service`
--

CREATE TABLE `photography_service` (
  `photography_id` int(11) NOT NULL,
  `service_name` varchar(100) NOT NULL,
  `photography_types` text NOT NULL,
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

INSERT INTO `photography_service` (`photography_id`, `service_name`, `photography_types`, `videography`, `package_desc`, `coverage_duration`, `num_photographers`, `editing`, `price`, `event_image`, `added_on`, `merchant_id`) VALUES
(1, 'Nadeem Photograpy', 'Birthday', 'Yes', 'no need any extra pay', 'Full Day', 3, 'No', 10000.00, 'uploads/1738860209_image-12.png.webp', '2025-02-06 16:43:29', 14);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `review_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `rating` tinyint(10) NOT NULL,
  `comments` varchar(200) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(200) NOT NULL,
  `service_price` int(11) NOT NULL,
  `merchant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `email`, `mobile`, `password`) VALUES
(38, 'Nasir Makwanaa', 'nasir@gmail.com', '8849742758', '$2y$10$iWxa1CgwKyqLwWHL0wOM4.ElaCiswmf.aWmJvsteibdKrGuUanVwO'),
(39, 'Om Kadia', 'om@gmail.com', '8849742760', '$2y$10$oi8h0cA/XMklkPrDD5apSuDxj0N8vdryCnI9kyZhLTna/8Toqcm1.'),
(41, 'nadeem', 'nad@gmail.com', '8859678420', '$2y$10$9Tbot19G.SCV2PQn8LYIp.aYgtgCftXwRtauMfouLxMtBQsaDC5QO'),
(42, 'Meghal', 'meghal@gmail.com', '4596178413', '$2y$10$LZTyK4VF.DDqIOk.tMbbvOYn7rmULPzxHhz3KLtWx8bnAIoJ9E4IO'),
(44, 'Mihir', 'Mihir555@gmail.com', '4569852695', 'mihir'),
(47, 'pathan', 'pathan@gmail.com', '4569874125', '$2y$10$8SZ1JdEIESti6Lt93W2xbekG29ordevql/.bpcMPoxcWYLrybz4sS'),
(50, 'Akram', 'akram@gmail.com', '8965412689', '$2y$10$HMaEb1/TRyBAWpxdmJ2ezukyY0g7vbguVoUo1.zaWA/jPyg9wPcne'),
(51, 'Makwana Nadeem', 'nadeem123@gmail.com', '8849742758', '$2y$10$cZHCfqtADXz7qJTQ9DjBRuT3pZt0AiFLEr5Hy4Gl3XI6I./HS3eTq');

-- --------------------------------------------------------

--
-- Table structure for table `venue_booking`
--

CREATE TABLE `venue_booking` (
  `venue_id` int(11) NOT NULL,
  `service_type` varchar(100) NOT NULL,
  `venue_name` varchar(100) NOT NULL,
  `venue_type` varchar(50) NOT NULL,
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

INSERT INTO `venue_booking` (`venue_id`, `service_type`, `venue_name`, `venue_type`, `capacity`, `address`, `city`, `pincode`, `price`, `event_image`, `added_on`, `merchant_id`) VALUES
(2, 'venue booking', 'Nadeem Sky', 'Lawn', 100, 'Uvarsad , Pandya Vas', 'Gandhinagar', '382422', 15000.00, 'uploads/1738853154_image-12.png.webp', '2025-02-06 14:45:54', 14),
(3, 'venue booking', 'Nadeem High', 'Resort', 5000, 'Uvarsad , Pandya Vas', 'Gandhinagar', '382422', 20000.00, 'uploads/1738853383_BrandAssets_Logos_02-NSymbol.jpg', '2025-02-06 14:49:44', 14),
(4, 'venue booking', 'taj', 'Hotel', 2000, 'Uvarsad , Pandya Vas', 'Gandhinagar', '382422', 40000.00, 'uploads/1738860275_image-12.png.webp', '2025-02-06 16:44:35', 14),
(6, 'venue booking', 'taj king', 'Resort', 1000, 'Uvarsad , Pandya Vas', 'Gandhinagar', '382422', 15000.00, 'uploads/1738863520_image-10.png.webp', '2025-02-06 17:38:40', 14),
(7, 'venue booking', 'Nadeem High', 'Hotel', 5000, 'Uvarsad , Pandya Vas', 'Gandhinagar', '382422', 25000.00, 'uploads/1739369331_image-12.png.webp', '2025-02-12 14:08:51', 14),
(8, 'venue booking', 'Nadeem Sky', 'Resort', 15000, 'Uvarsad , Pandya Vas', 'Gandhinagar', '382422', 50000.00, 'uploads/1739369466_image-13-1024x277.png.webp', '2025-02-12 14:11:06', 14);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `merchant_id` (`merchant_id`);

--
-- Indexes for table `bookingss`
--
ALTER TABLE `bookingss`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `merchant_id` (`merchant_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `catering_service`
--
ALTER TABLE `catering_service`
  ADD PRIMARY KEY (`catering_id`),
  ADD KEY `merchant_id` (`merchant_id`);

--
-- Indexes for table `decoration_service`
--
ALTER TABLE `decoration_service`
  ADD PRIMARY KEY (`decoration_id`),
  ADD KEY `merchant_id` (`merchant_id`);

--
-- Indexes for table `entertainment_service`
--
ALTER TABLE `entertainment_service`
  ADD PRIMARY KEY (`entertainment_id`),
  ADD KEY `merchant_id` (`merchant_id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `merchant_id` (`merchant_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `merchant_id` (`merchant_id`);

--
-- Indexes for table `merchant`
--
ALTER TABLE `merchant`
  ADD PRIMARY KEY (`merchant_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `payment_ibfk_1` (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `merchant_id` (`merchant_id`);

--
-- Indexes for table `photography_service`
--
ALTER TABLE `photography_service`
  ADD PRIMARY KEY (`photography_id`),
  ADD KEY `merchant_id` (`merchant_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
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
  ADD PRIMARY KEY (`venue_id`),
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
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `bookingss`
--
ALTER TABLE `bookingss`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `catering_service`
--
ALTER TABLE `catering_service`
  MODIFY `catering_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `decoration_service`
--
ALTER TABLE `decoration_service`
  MODIFY `decoration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `entertainment_service`
--
ALTER TABLE `entertainment_service`
  MODIFY `entertainment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `merchant`
--
ALTER TABLE `merchant`
  MODIFY `merchant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `photography_service`
--
ALTER TABLE `photography_service`
  MODIFY `photography_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `venue_booking`
--
ALTER TABLE `venue_booking`
  MODIFY `venue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`merchant_id`) REFERENCES `merchant` (`merchant_id`);

--
-- Constraints for table `bookingss`
--
ALTER TABLE `bookingss`
  ADD CONSTRAINT `bookingss_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `bookingss_ibfk_2` FOREIGN KEY (`merchant_id`) REFERENCES `merchant` (`merchant_id`);

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `user` (`user_id`);

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
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`merchant_id`) REFERENCES `merchant` (`merchant_id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`merchant_id`) REFERENCES `merchant` (`merchant_id`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`booking_id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`),
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `payment_ibfk_3` FOREIGN KEY (`merchant_id`) REFERENCES `merchant` (`merchant_id`);

--
-- Constraints for table `photography_service`
--
ALTER TABLE `photography_service`
  ADD CONSTRAINT `photography_service_ibfk_1` FOREIGN KEY (`merchant_id`) REFERENCES `merchant` (`merchant_id`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`);

--
-- Constraints for table `service`
--
ALTER TABLE `service`
  ADD CONSTRAINT `service_ibfk_1` FOREIGN KEY (`merchant_id`) REFERENCES `merchant` (`merchant_id`);

--
-- Constraints for table `venue_booking`
--
ALTER TABLE `venue_booking`
  ADD CONSTRAINT `venue_booking_ibfk_1` FOREIGN KEY (`merchant_id`) REFERENCES `merchant` (`merchant_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
