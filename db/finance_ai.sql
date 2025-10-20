-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 20, 2025 at 07:40 PM
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
(113, '1758827291_C13.jpg', 'assets/receipt_images/1758827291_C13.jpg', 1, '2025-09-25 19:08:11'),
(114, '1758828993_C3.jpg', 'assets/receipt_images/1758828993_C3.jpg', 1, '2025-09-25 19:36:33'),
(115, '1758828993_E4.jpg', 'assets/receipt_images/1758828993_E4.jpg', 1, '2025-09-25 19:36:33'),
(116, '1758828994_A3.jpg', 'assets/receipt_images/1758828994_A3.jpg', 1, '2025-09-25 19:36:34'),
(118, '1758829037_F4.jpg', 'assets/receipt_images/1758829037_F4.jpg', 1, '2025-09-25 19:37:17'),
(123, '1758886620_L20.jpg', 'assets/receipt_images/1758886620_L20.jpg', 1, '2025-09-26 11:37:00'),
(125, '1759740852_A3.jpg', 'assets/receipt_images/1759740852_A3.jpg', 1, '2025-10-06 08:54:12'),
(127, '1759840278_G5.jpg', 'assets/receipt_images/1759840278_G5.jpg', 1, '2025-10-07 12:31:18'),
(128, '1759840722_M13.jpg', 'assets/receipt_images/1759840722_M13.jpg', 1, '2025-10-07 12:38:42'),
(130, '1760004056_A3.jpg', 'assets/receipt_images/1760004056_A3.jpg', 1, '2025-10-09 10:00:56'),
(131, '1760417869_264.jpg', 'assets/receipt_images/1760417869_264.jpg', 1, '2025-10-14 04:57:49'),
(133, '1760422023_1077.jpg', 'assets/receipt_images/1760422023_1077.jpg', 1, '2025-10-14 06:07:03'),
(134, '1760422351_175.jpg', 'assets/receipt_images/1760422351_175.jpg', 1, '2025-10-14 06:12:32'),
(135, '1760422725_yen 1,200 .jpg', 'assets/receipt_images/1760422725_yen 1,200.jpg', 1, '2025-10-14 06:18:45'),
(137, '1760488970_yen 589.jpg', 'assets/receipt_images/1760488970_yen 589.jpg', 1, '2025-10-15 00:42:50'),
(138, '1760490957_Screenshot 2025-10-15 091508.png', 'assets/receipt_images/1760490957_Screenshot 2025-10-15 091508.png', 1, '2025-10-15 01:15:57'),
(139, '1760491777_yy750.jpg', 'assets/receipt_images/1760491777_yy750.jpg', 1, '2025-10-15 01:29:37'),
(140, '1760492505_93ss.jpg', 'assets/receipt_images/1760492505_93ss.jpg', 1, '2025-10-15 01:41:45'),
(141, '1760492780_430((.jpg', 'assets/receipt_images/1760492780_430((.jpg', 1, '2025-10-15 01:46:20'),
(142, '1760493098_Screenshot 2025-10-15 095107.png', 'assets/receipt_images/1760493098_Screenshot 2025-10-15 095107.png', 1, '2025-10-15 01:51:38'),
(143, '1760493428_Screenshot 2025-10-15 095642.png', 'assets/receipt_images/1760493428_Screenshot 2025-10-15 095642.png', 1, '2025-10-15 01:57:08'),
(144, '1760493793_Screenshot 2025-10-15 100243.png', 'assets/receipt_images/1760493793_Screenshot 2025-10-15 100243.png', 1, '2025-10-15 02:03:13'),
(145, '1760494406_Screenshot 2025-10-15 101303.png', 'assets/receipt_images/1760494406_Screenshot 2025-10-15 101303.png', 1, '2025-10-15 02:13:26'),
(147, '1760494876_WhatsApp Image 2025-09-24 at 11.43.18 PM.jpeg', 'assets/receipt_images/1760494876_WhatsApp Image 2025-09-24 at 11.43.18 PM.jpeg', 1, '2025-10-15 02:21:16'),
(148, '1760494927_WhatsApp Image 2025-09-24 at 11.43.18 PM.jpeg', 'assets/receipt_images/1760494927_WhatsApp Image 2025-09-24 at 11.43.18 PM.jpeg', 1, '2025-10-15 02:22:07'),
(150, '1760498581_WhatsApp Image 2025-09-24 at 11.43.18 PM.jpeg', 'assets/receipt_images/1760498581_WhatsApp Image 2025-09-24 at 11.43.18 PM.jpeg', 1, '2025-10-15 03:23:01'),
(151, '1760498957_WhatsApp Image 2025-09-24 at 11.43.18 PM.jpeg', 'assets/receipt_images/1760498957_WhatsApp Image 2025-09-24 at 11.43.18 PM.jpeg', 1, '2025-10-15 03:29:17'),
(152, '1760499498_WhatsApp Image 2025-09-24 at 11.43.18 PM.jpeg', 'assets/receipt_images/1760499498_WhatsApp Image 2025-09-24 at 11.43.18 PM.jpeg', 1, '2025-10-15 03:38:18'),
(153, '1760499617_Screenshot 2025-10-15 113955.png', 'assets/receipt_images/1760499617_Screenshot 2025-10-15 113955.png', 1, '2025-10-15 03:40:17'),
(154, '1760500154_Screenshot 2025-10-15 114844.png', 'assets/receipt_images/1760500154_Screenshot 2025-10-15 114844.png', 1, '2025-10-15 03:49:14'),
(155, '1760500639_Screenshot 2025-10-15 115646.png', 'assets/receipt_images/1760500639_Screenshot 2025-10-15 115646.png', 1, '2025-10-15 03:57:19'),
(156, '1760503270_Screenshot 2025-10-15 124047.png', 'assets/receipt_images/1760503270_Screenshot 2025-10-15 124047.png', 1, '2025-10-15 04:41:10'),
(157, '1760503616_Screenshot 2025-10-15 124632.png', 'assets/receipt_images/1760503616_Screenshot 2025-10-15 124632.png', 1, '2025-10-15 04:46:56'),
(160, '1760504143_Screenshot 2025-10-15 125523.png', 'assets/receipt_images/1760504143_Screenshot 2025-10-15 125523.png', 1, '2025-10-15 04:55:43'),
(161, '1760504189_Screenshot 2025-10-15 125523.png', 'assets/receipt_images/1760504189_Screenshot 2025-10-15 125523.png', 1, '2025-10-15 04:56:29'),
(163, '1760504714_220ss.jpg', 'assets/receipt_images/1760504714_220ss.jpg', 1, '2025-10-15 05:05:14'),
(169, '1760505953_220ss.jpg', 'assets/receipt_images/1760505953_220ss.jpg', 1, '2025-10-15 05:25:53'),
(171, '1760600692_23.jpg', 'assets/receipt_images/1760600692_23.jpg', 1, '2025-10-16 07:44:52'),
(189, '1760606538_Screenshot 2025-10-16 172152.png', 'assets/receipt_images/1760606538_Screenshot 2025-10-16 172152.png', 1, '2025-10-16 09:22:18'),
(190, '1760606610_Screenshot 2025-10-16 172152.png', 'assets/receipt_images/1760606610_Screenshot 2025-10-16 172152.png', 1, '2025-10-16 09:23:30'),
(191, '1760607348_Screenshot 2025-10-16 173525.png', 'assets/receipt_images/1760607348_Screenshot 2025-10-16 173525.png', 1, '2025-10-16 09:35:48'),
(192, '1760608056_Screenshot 2025-10-16 174712.png', 'assets/receipt_images/1760608056_Screenshot 2025-10-16 174712.png', 1, '2025-10-16 09:47:36'),
(194, '1760628908_B1.jpg', 'assets/receipt_images/1760628908_B1.jpg', 1, '2025-10-16 15:35:08'),
(198, '1760687540_Screenshot 2025-10-17 155059.png', 'assets/receipt_images/1760687540_Screenshot 2025-10-17 155059.png', 1, '2025-10-17 07:52:20'),
(199, '1760688271_Screenshot 2025-10-17 160412.png', 'assets/receipt_images/1760688271_Screenshot 2025-10-17 160412.png', 1, '2025-10-17 08:04:31'),
(200, '1760688824_Screenshot 2025-10-17 161327.png', 'assets/receipt_images/1760688824_Screenshot 2025-10-17 161327.png', 1, '2025-10-17 08:13:44'),
(201, '1760689332_Screenshot 2025-10-17 162155.png', 'assets/receipt_images/1760689332_Screenshot 2025-10-17 162155.png', 1, '2025-10-17 08:22:12'),
(202, '1760690117_Screenshot 2025-10-17 162155.png', 'assets/receipt_images/1760690117_Screenshot 2025-10-17 162155.png', 1, '2025-10-17 08:35:17'),
(203, '1760690596_Screenshot 2025-10-17 162155.png', 'assets/receipt_images/1760690596_Screenshot 2025-10-17 162155.png', 1, '2025-10-17 08:43:16'),
(206, '1760691752_Screenshot 2025-10-17 170213.png', 'assets/receipt_images/1760691752_Screenshot 2025-10-17 170213.png', 1, '2025-10-17 09:02:32'),
(209, '1760692080_Screenshot 2025-10-17 170742.png', 'assets/receipt_images/1760692080_Screenshot 2025-10-17 170742.png', 1, '2025-10-17 09:08:00'),
(210, '1760692331_Screenshot 2025-10-17 171147.png', 'assets/receipt_images/1760692331_Screenshot 2025-10-17 171147.png', 1, '2025-10-17 09:12:11'),
(211, '1760692804_Screenshot 2025-10-17 171946.png', 'assets/receipt_images/1760692804_Screenshot 2025-10-17 171946.png', 1, '2025-10-17 09:20:04'),
(212, '1760693029_Screenshot 2025-10-17 172328.png', 'assets/receipt_images/1760693029_Screenshot 2025-10-17 172328.png', 1, '2025-10-17 09:23:49'),
(214, '1760693354_Screenshot 2025-10-17 172757.png', 'assets/receipt_images/1760693354_Screenshot 2025-10-17 172757.png', 1, '2025-10-17 09:29:14'),
(215, '1760693555_Screenshot 2025-10-17 173217.png', 'assets/receipt_images/1760693555_Screenshot 2025-10-17 173217.png', 1, '2025-10-17 09:32:35'),
(217, '1760694357_Screenshot 2025-10-17 174420.png', 'assets/receipt_images/1760694357_Screenshot 2025-10-17 174420.png', 1, '2025-10-17 09:45:57'),
(219, '1760699045_99ss.jpg', 'assets/receipt_images/1760699045_99ss.jpg', 1, '2025-10-17 11:04:05'),
(220, '1760699697_207ss.jpg', 'assets/receipt_images/1760699697_207ss.jpg', 1, '2025-10-17 11:14:57'),
(221, '1760791575_663ss.jpg', '../receipt_images/1760791575_663ss.jpg', 1, '2025-10-18 12:46:15'),
(222, '1760792070_285((.jpg', '../receipt_images/1760792070_285((.jpg', 1, '2025-10-18 12:54:30'),
(223, '1760865576_Screenshot 2025-10-18 231945.png', '../receipt_images/1760865576_Screenshot 2025-10-18 231945.png', 1, '2025-10-19 09:19:36'),
(224, '1760865655_Screenshot 2025-10-19 172013.png', '../receipt_images/1760865655_Screenshot 2025-10-19 172013.png', 1, '2025-10-19 09:20:55'),
(225, '1760920792_yen 1819.80 (1).jpg', '../receipt_images/1760920792_yen 1819.80 (1).jpg', 1, '2025-10-20 00:39:52');

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
(97, '115', '05/07/2025', '0014', 'KHEENE WATER REFILLING STATION', 'Cañeso, Eco-Tourism Highway, Rovirih Heights, Rizal, San Carlos City, Negros Occidental', 'NILDA E. BARBON', '379-656-284-00000', 'Goods', NULL, '225', '', '', '', '', '2025-09-25 19:36:46'),
(98, '114', '05/07/2025', '14-00124440', 'SAVEMORE MARKET MARKETING CORPORATION', 'SAN CARLOS, LOCSIN STREET CORNER V. GASTILIO STREET, BARANGAY IV (PO3.), PHILIPPINES 6127', '', '207-961-175-00173', 'Goods', NULL, '677.50', '604.91', '72.59', '0.00', '0.00', '2025-09-25 19:36:47'),
(99, '116', '05/01/2025', '076AU20240000001489', 'YUJSTEL WATERSHOP CONSUMER GOODS RETAILING', 'Caballero, S. Carmona St, Brgy. 1(Pob.) 6127 San Carlos City, Negros Occidental, Phils.', '', '212-798-583-00001', 'Goods', NULL, '2684', '2684', '', '', '', '2025-09-25 19:36:53'),
(100, '117', '04/08/2025', 'EMPIRE 1', 'JALCAN BUSINESS VENTURES CORPORATION', 'National Highway, Mabigo (Pob.) Canlaon City 6223, Neg Or Phil', 'Cristy Marie L. Buhisan', '260-496-600-002', 'Goods', NULL, '200', '', '', '', '', '2025-09-25 19:37:08'),
(101, '118', '04/08/2025', 'EMPIRE 1', 'JALCAN BUSINESS VENTURES CORPORATION', 'National Highway, Mabigo (Pob.) Canlaon City 6223, Neg. Or. Phil.', '', '260-496-600-002', 'Goods', NULL, '200', '', '', '', '', '2025-09-25 19:37:32'),
(105, '123', '11/19/2025', '64201', 'RIGPOINT PETROLEUM', 'Cor. Locsin St. Nat\'l Highway, Barangay II (Pob.) 6127 San Carlos City Negros Occidental, Philippines', '', '489-741-676-0000', 'Goods', NULL, '80', '71.43', '8.57', '', '', '2025-09-26 11:37:14'),
(106, '125', '05/31/2025', '8217', 'JEAN. SORAYDA M. EMPIALES YUJSTEL WATERSHOP CONSUMER GOODS RETAILING', 'Caballero, S. Carmona St., Brgy. 1(Pob.) 6127 San Carlos City, Negros Occidental, Phils.', '', '212-798-583-00001', 'Goods', NULL, '2684', '2684', '', '', '', '2025-10-06 08:54:35'),
(107, '127', '05/09/2025', '63904', 'RIGPOINT PETROLEUM CORP.', 'Cor. Locsin St. Nat\'l Highway, Barangay II (Pob.) 6127 San Carlos City Negros Occidental, Philippines', '', '489-741-676-00003', 'Goods', NULL, '70.00', '62.50', '7.50', '', '', '2025-10-07 12:31:47'),
(108, '128', '05/19/2025', '9588008', 'CITY OF SAN CARLOS', 'PROVINCE OF NEROS OCCIDENTAL, CITY OF SAN CARLOS', 'NA', 'NA', 'Services', 'Transportation', '1500.00', 'NA', 'NA', 'NA', 'NA', '2025-10-07 12:38:55'),
(109, '127', '05/09/2025', '63904', 'RIGPOINT PETROLEUM CORP.', 'Cor. Locsin St. Nat\'l Highway, Barangay II (Pob.) 6127 San Carlos City Negros Occidental, Philippines', 'test', '489-741-676-00003', 'services', 'test', '70.00', '62.50', '7.50', '12', 'NA', '2025-10-07 15:36:26'),
(111, '130', '05/31/2025', '8217', 'YUJSTEL WATERSHOP CONSUMER GOODS RETAILING', 'Caballero, S. Carmona St., Brgy. 1(Pobl.) 6127 San Carlos City, Negros Occidental, Phils.', '', '212-798-583-00001', 'Goods', 'Beverages', '2684', '2684', '', '2684', '', '2025-10-09 10:01:29'),
(112, '131', '09/01/2025', '00000000028416', '7777 SCHOOL, OFFICE SUPPLIES & EQUIPMENT TRADING', 'Yap Azcona Street Barangay IV San Carlos City Negros Occidental', 'NA', '434-468-141-00001', 'Goods', 'Supplies', '264.00', '235.71', '28.29', '0.00', '0.00', '2025-10-14 04:58:01'),
(113, '133', '06/25/24', '40729', 'NONOY & MALOU SARI-SARI STORE', 'Public Market, Brgy IV, San Carlos City Negros Occidental', 'ROMEO G. ABADIES', '175-549-592-00000', 'Goods', 'Supplies', '1077', '1077', '', '1077', '', '2025-10-14 06:07:14'),
(114, '134', '09/03/2025', '02185', 'CVVD MART', 'Broce St., Barangay IV (Pob.), San Carlos City, Neg. Occ.', 'VINCE MARSEN S. DE ASIS', '488-942-848-00000', 'Goods', 'Supplies', '175', '175', '', '', '', '2025-10-14 06:12:46'),
(115, '135', '09/03/2025', '00000000028719', '7777 SCHOOL, OFFICE SUPPLIES & EQUIPMENT TRADING', 'Yap Azcona Street Barangay IV San Carlos City Negros Occidental', '', '434-468-141-00001', 'Goods', 'Supplies', '1200.00', '1071.43', '128.57', '0.00', '0.00', '2025-10-14 06:19:07'),
(116, '132', '05/01/20', '4757', 'K C GAS STATION CORPORATION', 'National Highway Barangay V, San Carlos City, Negros Occidental', '', '660-582-229-00000', 'Goods', 'Fuel', '200', '178.57', '21.43', '', '', '2025-10-14 17:22:56'),
(117, '133', '05/01/2025', '4757', 'K C GAS STATION CORPORATION', 'National Highway Barangay V, San Carlos City, Negros Occidental', '', '660-582-229-00000', 'Goods', 'Fuel', '200', '178.57', '21.43', '', '', '2025-10-14 17:30:12'),
(118, '134', '05/01/2025', '4757', 'K C GAS STATION CORPORATION', 'National Highway Barangay V, San Carlos City, Negros Occidental', '', '660-582-229-00000', 'Goods', 'Fuel', '200', '178.57', '21.43', '', '', '2025-10-14 20:39:56'),
(119, '137', '09/03/2025', 'OR3002400001069477', 'UNITOP GENERAL MERCHANDISE INC', 'Cinema Complex U Gustilo St San Carlos City', 'NA', '246-347-154-004', 'Goods', 'Supplies', '589.00', '525.89', '63.11', '0.00', '0.00', '2025-10-15 00:43:07'),
(120, '138', '09/15/2025', '1043', 'CJEA PRINTING SERVICES', 'Locsin St., Brgy. IV, San Carlos City, Negros Occidental', 'CATHARD JOHN E. ANGANA', '647-446-008-00000', 'Services', 'Printing Services', '170', '170', 'NA', 'NA', 'NA', '2025-10-15 01:16:10'),
(121, '139', '09/11/2025', '2065', 'BATTLEFRONT COMPUTER TRADING', 'Camiona St. Barangay V San Carlos City, Negros Occidental', 'RALPH P. GONZAGA', '616-890-200-00000', 'Goods', 'Computer Supplies', '750', '750', 'NA', 'NA', 'NA', '2025-10-15 01:29:53'),
(122, '140', '09/12/2025', '0000000029722', '7777 SCHOOL, OFFICE SUPPLIES & EQUIPMENT TRADING', 'Yap Azcona Street Barangay IV San Carlos City Negros Occidental', 'NA', '434-468-141-00001', 'Goods', 'Supplies', '93.00', '83.04', '9.96', '0.00', '0.00', '2025-10-15 01:41:56'),
(123, '141', '09/15/2025', '0000000029908', '7777 SCHOOL, OFFICE SUPPLIES & EQUIPMENT TRADING', 'Yap Azcona Street Barangay IV San Carlos City Negros Occidental', 'NA', '434-468-141-00001', 'Goods', 'Supplies', '430.00', '383.93', '46.07', '0.00', '0.00', '2025-10-15 01:46:31'),
(124, '142', '06/25/24', '40772', 'NONOY & MALOU SARI-SARI STORE', 'Public Market, Brgy IV, San Carlos City, Negros Occidental', 'ROMEO G. ABADIES', '175-549-592-00000', 'Goods', 'Supplies', '395', '395', 'NA', 'NA', 'NA', '2025-10-15 01:52:02'),
(125, '143', '09/15/2025', '04-00277899', 'SANFORD MARKETING CORPORATION', 'LOCSIN STREET CORNER V. GUSTILLO STREET BARANGAY IV (PDB.), PHILIPPINES 6127', 'NA', '207-961-175-00173', 'Goods', 'Supplies', '180.00', '160.71', '19.29', '0.00', '0.00', '2025-10-15 01:57:25'),
(126, '144', '09/17/2025', '0000-0000196818', 'BRICOLAGE PHILIPPINES INC.', 'GATSANO MALL Carlos FC Ledesma HI Balsano Capital San Carlos FO Ledesma HI', 'NA', '010-057-617-096', 'Goods', 'Groceries', '135.00', '120.54', '14.46', '0.00', '0.00', '2025-10-15 02:03:24'),
(127, '145', '09/21/2025', '000000000009638', 'GAISANO CAPITAL SAN CARLOS', 'F.L.LEDESMA AVE. SAN CARLOS CITY', 'NA', '000070101013', 'Goods', 'Supplies', '34.00', '30.36', '3.64', '0.00', '0.00', '2025-10-15 02:13:38'),
(128, '147', '09/21/2025', '0000-0000197794', 'BRICOLAGE PLUS GAISANO CAPITAL', 'Gaisano Capital San Carlos Ledesma Hi', '', '010-057-617-096', 'Goods', 'Supplies', '394.00', '351.79', '42.21', '0.00', '0.00', '2025-10-15 02:21:25'),
(129, '148', '09/21/2025', '0000-0000197794', 'MR BRICOLAGE PHILS INC.', 'Gaisano Capital San Carlos Ledesma Hi', 'NA', '010-057-617-096', 'Goods', 'Supplies', '394.00', '351.79', '42.21', '0.00', '0.00', '2025-10-15 02:22:23'),
(130, '150', '09/21/2025', '0000-0000197794', 'BRICOLAGE PTY. LTD.', 'Gaisano Capital San Carlos Ledesma Hi', '', '010-057-617-096', 'Goods', 'Supplies', '394.00', '351.79', '42.21', '0.00', '0.00', '2025-10-15 03:23:13'),
(131, '151', '09/21/2025', '0000-0000197794', 'BRICOLAGE PLUS', 'Gaisano Capital San Carlos Ledesma Hi', '', '010-057-617-096', 'Goods', 'Supplies', '394.00', '351.79', '42.21', '0.00', '0.00', '2025-10-15 03:29:39'),
(132, '152', '09/21/2025', '0000-0000197794', 'Gaisano Capital San Carlos', 'Ledesma Hi', '', '010-057-617-096', 'Goods', 'Supplies', '394.00', '351.79', '42.21', '0.00', '0.00', '2025-10-15 03:38:37'),
(133, '153', '09/17/23', '10027306', 'MR. D.I.Y. PHILIPPINES INC.', 'GAISANO MALL, Brgy. San Carlos, FF Ledesma III', 'NA', '010-057-617-096', 'Goods', 'Household Supplies', '148.00', '132.14', '15.86', '0.00', '0.00', '2025-10-15 03:40:33'),
(134, '154', '03/24/2025', '0000-0000198269', 'BRICOLAGE PHILIPPINES INC.', 'GAISANO MALI Gaisano Capital San Carlos FC Ledesma HI', 'NA', '010-057-617-096', 'Goods', 'Supplies', '174.00', '155.36', '18.64', '0.00', '0.00', '2025-10-15 03:49:26'),
(135, '155', '09/26/2025', '2029', 'HAND-ON PRINTS AND ARTS SERVICES', 'Locsin St., Brgy. II, San Carlos City, Negros Occidental', 'Gilberta E. Caballero', '740-184-611-00000', 'Goods', 'Apparel', '9900', '9900', 'NA', 'NA', 'NA', '2025-10-15 03:57:47'),
(136, '156', '09/26/2025', '12-00310691', 'SANFORD MARKETING CORPORATION', 'SAVEMORE MARKET LOCSIN STREET CORNER V. GUSTILLO STREET BARANGAY IV (POB.), PHILIPPINES 6127', 'NA', '207-961-175-00173', 'Goods', 'Groceries', '559.25', '499.33', '59.92', '0.00', '0.00', '2025-10-15 04:41:23'),
(137, '157', '09/27/2025', '08236', 'JMB FOOTWEAR', 'Gastuslao Bldg., V. Gustilo St., Barangay V (Pob.), San Carlos City, Neg. Occ.', 'JOHN MAR.B. BARGO', '464-001-827-00002', 'Goods', 'Apparel', '40.00', '40.00', 'NA', '40.00', 'NA', '2025-10-15 04:47:27'),
(138, '160', '09/29/2025', '22928', 'J & A CELLPHONE ACCESSORIES SHOP', '2/F Space #44 South Town Centre 285 Cebu South Road, Bulacao, City of Talisay 6045 City of Talisay, Cebu, Philippines', 'Marittes V. Abadia', '743-846-725-00003', 'Goods', 'Electronics', '150', '150', '', '', '', '2025-10-15 04:56:08'),
(139, '161', '09/29/2025', '22928', 'J & A CELLPHONE ACCESSORIES SHOP', '2/F Space #44 South Town Centre 285 Cebu South Road, Bulacao, City of Talisay 6045 City of Talisay, Cebu, Philippines', 'Marittes V. Abadia', '743-846-725-00003', 'Goods', 'Electronics', '150', '150', 'NA', 'NA', 'NA', '2025-10-15 04:56:42'),
(140, '163', '06/13/24', '0000000031271', '7777 SCHOOL, OFFICE SUPPLIES & EQUIPMENT TRADING', 'Yap Azcona Street Barangay IV San Carlos City Negros Occidental', 'NA', '434-468-141-00001', 'Goods', 'Office Supplies', '220.00', '196.43', '23.57', '0.00', '0.00', '2025-10-15 05:05:53'),
(141, '169', '06/13/24', '000000031271', '7777 SCHOOL, OFFICE SUPPLIES & EQUIPMENT TRADING', 'Yap Azcona Street Barangay IV San Carlos City Negros Occidental', '', '434-468-141-00001', 'Goods', 'Office Supplies', '220.00', '196.43', '23.57', '0.00', '0.00', '2025-10-15 05:26:13'),
(142, '171', '09/02/2025', '00107', 'NENG\'S CATERING SERVICES', 'F.C. Ledesma Ave., Barangay II, San Carlos City, Neg. Occ.', 'MARIBEL L. CABALLERO', '284-694-493-00001', 'Services', 'Catering Services', '22000', '22000', 'NA', 'NA', 'NA', '2025-10-16 07:45:32'),
(143, '189', '09/04/2025', '0650', 'EAT & RESTAURANT CORPORATION', 'UGF, 01 One Montage Tower, Archbishop Reyes Ave., Camputhaw, 6000 City of Cebu, Cebu, Philippines', '', '653-129-949-00000', 'Services', 'Meals', '3976.50', '3976.50', '', '', '', '2025-10-16 09:22:48'),
(144, '190', '09/04/2025', '0650', 'EAT & RESTAURANT CORPORATION', 'UGF, 01 One Montage Tower, Archbishop Reyes Ave., Camputhaw, 6000 City of Cebu, Cebu, Philippines', 'NA', '653-129-949-00000', 'Services', 'Meals', '3976.50', '3976.50', 'NA', 'NA', 'NA', '2025-10-16 09:23:59'),
(145, '191', '04/09/2025', '000021896', 'FAYC RESTAURANT GROUP INC.', 'UNIT 1119-1120 UPPER G/F SM SEASIDE CITY CEBU SRP MAMBALING CITY OF CEBU', 'NA', '645-360-170-00001', 'Services', 'Meals', '3346.03', '2742.86', '329.14', '0.00', '0.00', '2025-10-16 09:35:58'),
(146, '192', '09/05/2025', '2379', 'CADZ FRESH BURGER CORPORATION', 'F.C. Ledesma Avenue, San Carlos City, Neg. Occ.', 'NA', '010-157-494-00002', 'Goods', 'Meals', '1155', 'NA', 'NA', 'NA', 'NA', '2025-10-16 09:48:05'),
(147, '194', '05/06/2025', '', 'CARMEL\'S RESTAURANT', 'C.L. Ledesma Ave. San Carlos City, Negros occidental', '', '', 'Goods', 'Meals', '835', '', '', '', '', '2025-10-16 15:35:19'),
(148, '197', '09/10/2025', 'JBO754', 'FREMONT FOODS CORPORATION', '101 ECC COMMERCIAL BLDG., POBLACION, TOLEDO CITY 6038, CEBU', '', '003-460-168-093', 'Goods', 'Meals', '297.00', '265.25', '31.75', '0.00', '0.00', '2025-10-17 07:52:04'),
(149, '198', '09/10/2025', 'JBO754', 'FREMONT FOODS CORPORATION', '101 EDD COMMERCIAL VILLA PUEBLACION TOLEDO CITY CEBU', 'NA', '003-460-168-093', 'Goods', 'Meals', '203.00', '181.25', '21.75', '0.00', '0.00', '2025-10-17 07:52:55'),
(150, '199', '04/10/2025', '1025', 'JS SILOGAN', 'GASANO GRAHO MALL CARCAR AWAYAN POBLACION III CITY OF CARCAR CEBU PHILIPPINES', 'JESSIE P. ALISON', '293-053-694-00003', 'Goods', 'Meals', '198', '198', 'NA', 'NA', 'NA', '2025-10-17 08:05:04'),
(151, '200', '09/13/2025', '1468', 'MR. C FOODS', 'Brgy. Palampas, San Carlos City, Neg. Occ.', 'CHRISTOPHER GIL T. COSAS', '932-774-581-00002', 'Goods', 'Groceries', '1465', '1308', '157', 'NA', 'NA', '2025-10-17 08:14:20'),
(152, '201', '', '1019486', 'BIAÑOS PIZZADERIA', '', '', '', 'Goods', 'Food and Beverages', '295', '', '', '', '', '2025-10-17 08:22:36'),
(153, '202', '', '1019486', 'BIAÑOS PIZZADERIA', '', '', '', 'Goods', 'Meals', '295', '', '', '', '', '2025-10-17 08:35:36'),
(154, '203', 'NA', '1019486', 'BIAÑOS PIZZADERIA', 'NA', 'NA', 'NA', 'Goods', 'Meals', '295', 'NA', 'NA', 'NA', 'NA', '2025-10-17 08:43:51'),
(155, '206', '09/15/2025', '0343', 'MR. B\'S RESTO BAR', 'TANGASAN ST. VALLADOLID 6019 CITY OF CARCAR CEBU PHILS.', 'LUZVIMINDA C. SOLON', '704-944-888-00000', 'Services', 'Meals', '2095.00', '2095.00', 'NA', 'NA', 'NA', '2025-10-17 09:03:02'),
(156, '209', '06/06/21', '92474', 'CQE 888 INC', 'Gaisano Grand Awayan Poblacion III Carcar City 2019 City of Carcar, Cebu Philippines', '', '467-494-313-004', 'Services', 'Printing Services', '140.00', '125.00', '15.00', '', '', '2025-10-17 09:09:01'),
(157, '210', '09/16/2025', '0000475', 'PANCAKE HOUSE - Ayala Cebu', '202 Lagoon Dev of Ayala Center Cebu Business Park Luz 6000 City of Cebu Cebu Philippines', 'NA', '205-357-210-00052', 'Services', 'Meals', '1310.76', '1178.53', '131.03', 'NA', '87.36', '2025-10-17 09:12:57'),
(158, '211', '09/18/2025', '00209', 'MAJEUR VAST FOOD CORP.', 'Ayala Malls Capitol, Central Gatuslao St., Barangay 8, Bacolod City, Neg. Occ.', 'NA', '009-606-987-00004', 'Services', 'Meals', '292.00', '260.71', '31.29', 'NA', 'NA', '2025-10-17 09:20:29'),
(159, '212', '09/18/2025', '00234', 'BUSH BUSH RESTAURANT', 'Eusebio St., Bantayanon, Calatrava, Neg. Occ.', 'MARIO NIÑO S. CARBAJOSA', '706-647-239-00000', 'Goods', 'Meals', '916', '916', 'NA', 'NA', 'NA', '2025-10-17 09:24:45'),
(160, '214', '09/19/2025', '10099', 'NAREDA SARI-SARI STORE', 'Stall No. K60 & K61, Public Market, V. Gustilo St., Barangay IV, San Carlos City, Neg. Occ.', 'JAKE EDCEEN L. CRUZ', '264-345-722-00000', 'Goods', 'Groceries', '152', '152', 'NA', 'NA', 'NA', '2025-10-17 09:29:41'),
(161, '215', '09/03/2025', '0041', 'CADZ FRESH BURGER CORPORATION', 'First Sugar Field - Realty, Cor. F.C. Ledesma C.L. Ledesma Sr. Ave., Brgy. Palampas, San Carlos City, Negros Occidental', 'NA', '010-157-494-00002', 'Goods', 'Meals', '1056.00', 'NA', 'NA', 'NA', 'NA', '2025-10-17 09:33:03'),
(162, '217', '09/21/2025', '1504', 'MR. C FOODS', 'Brgy. Palampas, San Carlos City, Neg. Occ.', 'CHRISTOPHER GIL T. COS AS', '932-774-581-00002', 'Goods', 'Meals', '830.00', '', '', '', '', '2025-10-17 09:46:41'),
(163, '219', '09/29/2025', '03202069', 'FREEMONT FOODS CORPORATION', 'TOLEDO COMMERCIAL VILL., POBLACION TOLEDO CITY CEBU', 'NA', '003-460-168-093', 'Goods', 'Meals', '99.00', '88.39', '10.61', '0.00', '0.00', '2025-10-17 11:04:53'),
(164, '220', '09/30/2025', '100089462', 'Philippine Seven Corporation', 'National Highway, Brgy. 1, San Carlos City, Negros Occidental, Philippines', 'NA', '000-390-189-03134', 'Goods', 'Beverages', '207.00', '184.82', '22.18', '0.00', '0.00', '2025-10-17 11:15:36');

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
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=226;

--
-- AUTO_INCREMENT for table `reciepts_data`
--
ALTER TABLE `reciepts_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
