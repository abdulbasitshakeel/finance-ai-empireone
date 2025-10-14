-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 13, 2025 at 03:20 PM
-- Server version: 10.6.22-MariaDB-0ubuntu0.22.04.1
-- PHP Version: 8.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `finance_ai`
--

-- --------------------------------------------------------

--
-- Table structure for table `receipt_images`
--

CREATE TABLE `receipt_images` (
  `image_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `isFetched` tinyint(1) NOT NULL DEFAULT 0,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `receipt_images`
--

INSERT INTO `receipt_images` (`image_id`, `file_name`, `file_path`, `isFetched`, `uploaded_at`) VALUES
(113, '1758827291_C13.jpg', '../receipt_images/1758827291_C13.jpg', 1, '2025-09-25 19:08:11'),
(114, '1758828993_C3.jpg', '../receipt_images/1758828993_C3.jpg', 1, '2025-09-25 19:36:33'),
(115, '1758828993_E4.jpg', '../receipt_images/1758828993_E4.jpg', 1, '2025-09-25 19:36:33'),
(116, '1758828994_A3.jpg', '../receipt_images/1758828994_A3.jpg', 1, '2025-09-25 19:36:34'),
(118, '1758829037_F4.jpg', '../receipt_images/1758829037_F4.jpg', 1, '2025-09-25 19:37:17'),
(123, '1758886620_L20.jpg', '../receipt_images/1758886620_L20.jpg', 1, '2025-09-26 11:37:00'),
(125, '1759740852_A3.jpg', '../receipt_images/1759740852_A3.jpg', 1, '2025-10-06 08:54:12'),
(127, '1759840278_G5.jpg', '../receipt_images/1759840278_G5.jpg', 1, '2025-10-07 12:31:18'),
(128, '1759840722_M13.jpg', '../receipt_images/1759840722_M13.jpg', 1, '2025-10-07 12:38:42'),
(130, '1760004056_A3.jpg', '../receipt_images/1760004056_A3.jpg', 1, '2025-10-09 10:00:56');

-- --------------------------------------------------------

--
-- Table structure for table `reciepts_data`
--

CREATE TABLE `reciepts_data` (
  `id` int(11) NOT NULL,
  `image_id` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `order_or_reference_number` varchar(255) DEFAULT NULL,
  `supplier_name` varchar(255) DEFAULT NULL,
  `supplier_address` varchar(255) DEFAULT NULL,
  `supplier_register_name` varchar(255) DEFAULT NULL,
  `supplier_tin` varchar(255) DEFAULT NULL,
  `purchase_category` varchar(255) DEFAULT NULL,
  `expense_category` varchar(255) DEFAULT NULL,
  `gross_purchase_amount` varchar(255) DEFAULT NULL,
  `net_purchase_amount` varchar(255) DEFAULT NULL,
  `input_tax` varchar(255) DEFAULT NULL,
  `vat_exempt_purchases` varchar(255) DEFAULT NULL,
  `zero_rated_purchases` varchar(255) DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `reciepts_data`
--

INSERT INTO `reciepts_data` (`id`, `image_id`, `date`, `order_or_reference_number`, `supplier_name`, `supplier_address`, `supplier_register_name`, `supplier_tin`, `purchase_category`, `expense_category`, `gross_purchase_amount`, `net_purchase_amount`, `input_tax`, `vat_exempt_purchases`, `zero_rated_purchases`, `added_at`) VALUES
(95, '113', '', '', '', '', '', '', 'Services', NULL, '30', '30', '', '', '', '2025-09-25 19:08:22'),
(97, '115', '05/07/25', '0014', 'KHEENE WATER REFILLING STATION', 'Cañeso, Eco-Tourism Highway, Rovirih Heights, Rizal, San Carlos City, Negros Occidental', 'NILDA E. BARBON', '379-656-284-00000', 'Goods', NULL, '225', '', '', '', '', '2025-09-25 19:36:46'),
(98, '114', '05/07/25', '14-00124440', 'SAVEMORE MARKET MARKETING CORPORATION', 'SAN CARLOS, LOCSIN STREET CORNER V. GASTILIO STREET, BARANGAY IV (PO3.), PHILIPPINES 6127', '', '207-961-175-00173', 'Goods', NULL, '677.50', '604.91', '72.59', '0.00', '0.00', '2025-09-25 19:36:47'),
(99, '116', '05/01/25', '076AU20240000001489', 'YUJSTEL WATERSHOP CONSUMER GOODS RETAILING', 'Caballero, S. Carmona St, Brgy. 1(Pob.) 6127 San Carlos City, Negros Occidental, Phils.', '', '212-798-583-00001', 'Goods', NULL, '2684', '2684', '', '', '', '2025-09-25 19:36:53'),
(100, '117', '04/08/25', 'EMPIRE 1', 'JALCAN BUSINESS VENTURES CORPORATION', 'National Highway, Mabigo (Pob.) Canlaon City 6223, Neg Or Phil', 'Cristy Marie L. Buhisan', '260-496-600-002', 'Goods', NULL, '200', '', '', '', '', '2025-09-25 19:37:08'),
(101, '118', '04/08/25', 'EMPIRE 1', 'JALCAN BUSINESS VENTURES CORPORATION', 'National Highway, Mabigo (Pob.) Canlaon City 6223, Neg. Or. Phil.', '', '260-496-600-002', 'Goods', NULL, '200', '', '', '', '', '2025-09-25 19:37:32'),
(105, '123', '11/19/25', '64201', 'RIGPOINT PETROLEUM', 'Cor. Locsin St. Nat\'l Highway, Barangay II (Pob.) 6127 San Carlos City Negros Occidental, Philippines', '', '489-741-676-0000', 'Goods', NULL, '80', '71.43', '8.57', '', '', '2025-09-26 11:37:14'),
(106, '125', '05/31/25', '8217', 'JEAN. SORAYDA M. EMPIALES YUJSTEL WATERSHOP CONSUMER GOODS RETAILING', 'Caballero, S. Carmona St., Brgy. 1(Pob.) 6127 San Carlos City, Negros Occidental, Phils.', '', '212-798-583-00001', 'Goods', NULL, '2684', '2684', '', '', '', '2025-10-06 08:54:35'),
(107, '127', '05/09/25', '63904', 'RIGPOINT PETROLEUM CORP.', 'Cor. Locsin St. Nat\'l Highway, Barangay II (Pob.) 6127 San Carlos City Negros Occidental, Philippines', '', '489-741-676-00003', 'Goods', NULL, '70.00', '62.50', '7.50', '', '', '2025-10-07 12:31:47'),
(108, '128', '05/19/25', '9588008', 'CITY OF SAN CARLOS', 'PROVINCE OF NEROS OCCIDENTAL, CITY OF SAN CARLOS', 'NA', 'NA', 'Services', 'Transportation', '1500.00', 'NA', 'NA', 'NA', 'NA', '2025-10-07 12:38:55'),
(109, '127', '05/09/25', '63904', 'RIGPOINT PETROLEUM CORP.', 'Cor. Locsin St. Nat\'l Highway, Barangay II (Pob.) 6127 San Carlos City Negros Occidental, Philippines', 'test', '489-741-676-00003', 'services', 'test', '70.00', '62.50', '7.50', '12', 'NA', '2025-10-07 15:36:26'),
(111, '130', '05/31/25', '8217', 'YUJSTEL WATERSHOP CONSUMER GOODS RETAILING', 'Caballero, S. Carmona St., Brgy. 1(Pobl.) 6127 San Carlos City, Negros Occidental, Phils.', '', '212-798-583-00001', 'Goods', 'Beverages', '2684', '2684', '', '2684', '', '2025-10-09 10:01:29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin') NOT NULL DEFAULT 'admin',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `added_by` int(11) DEFAULT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `password`, `role`, `status`, `added_by`, `added_on`) VALUES
(1, 'Admin', 'Info@empireonetravel.com', '$2y$10$nF4UM1AeoOiywF3GLNJ/.u8PVJz7.NTqaI9vkLGbBmrBrhS.4j30C', 'admin', 0, 1, '2025-08-04 20:01:09'),
(2, 'Developer', 'admin@gmail.com', '$2y$10$rBGTy8IG/yOjbvFfGT6a7OPaPHjEkWahpiHarLgPdPOp2Gar57v..', 'admin', 1, 1, '2025-08-04 20:01:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `receipt_images`
--
ALTER TABLE `receipt_images`
  ADD PRIMARY KEY (`image_id`);

--
-- Indexes for table `reciepts_data`
--
ALTER TABLE `reciepts_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `receipt_images`
--
ALTER TABLE `receipt_images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `reciepts_data`
--
ALTER TABLE `reciepts_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
