-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 15, 2025 lúc 01:53 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `apple`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Sedan', 'sedan', 'Four-door passenger cars with a separate trunk', 'categories/sedan.jpg', '2025-04-14 07:50:32', '2025-04-14 07:50:32'),
(2, 'SUV', 'suv', 'Sport Utility Vehicles with raised ground clearance', 'categories/suv.jpg', '2025-04-14 07:50:32', '2025-04-14 07:50:32'),
(3, 'Hatchback', 'hatchback', 'Compact cars with a rear door that opens upwards', 'categories/hatchback.jpg', '2025-04-14 07:50:32', '2025-04-14 07:50:32'),
(4, 'Luxury', 'luxury', 'High-end vehicles with premium features', 'categories/luxury.jpg', '2025-04-14 07:50:32', '2025-04-14 07:50:32'),
(5, 'Sports Car', 'sports-car', 'High-performance vehicles designed for speed', 'categories/sports.jpg', '2025-04-14 07:50:32', '2025-04-14 07:50:32'),
(6, 'Electric', 'electric', 'Vehicles powered by electric motors', 'categories/Nx6sLVGuHZe0uv5x4loI66ib3m3zZ7Zd2j95QBbd.jpg', '2025-04-14 07:50:32', '2025-04-14 22:57:39'),
(7, 'Tank', 'tank', 'A car that makes everyone who sees you on the street respect you, dogs don\'t dare bark at you, and ex-lovers insist on getting back together.', 'categories/b3Vnj7N0HZiWxNlMQxfXAutenyOS0DB48RwsY0yc.jpg', '2025-04-14 23:01:51', '2025-04-14 23:01:51');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `reply` text DEFAULT NULL,
  `replied_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `phone`, `subject`, `message`, `status`, `reply`, `replied_at`, `created_at`, `updated_at`) VALUES
(1, 'John Smith', 'john.smith@example.com', '1234567890', 'Inquiry about Toyota Camry', 'I would like to know more about the Toyota Camry. Is it available for a test drive this weekend?', 0, NULL, NULL, '2025-04-14 19:32:52', '2025-04-14 19:32:52'),
(2, 'Emily Johnson', 'emily.johnson@example.com', '9876543210', 'Financing Options', 'Hello, I am interested in the financing options available for your luxury vehicles. Could you please provide me with more information?', 0, NULL, NULL, '2025-04-14 19:32:52', '2025-04-14 19:32:52'),
(3, 'Michael Davis', 'michael.davis@example.com', '5551234567', 'Service Appointment', 'I need to schedule a service appointment for my Honda CR-V purchased from your dealership last year. What are your available dates?', 0, NULL, NULL, '2025-04-14 19:32:52', '2025-04-14 19:32:52'),
(4, 'Sarah Wilson', 'sarah.wilson@example.com', '7778889999', 'Trade-in Value Question', 'I am looking to trade in my current vehicle for a new one. How can I get an estimate of my car\'s trade-in value?', 0, NULL, NULL, '2025-04-14 19:32:52', '2025-04-14 19:32:52'),
(5, 'Robert Brown', 'robert.brown@example.com', '3332221111', 'Electric Vehicle Information', 'I am interested in learning more about your electric vehicle options. Do you offer any special incentives or rebates for EV purchases?', 0, NULL, NULL, '2025-04-14 19:32:52', '2025-04-14 19:32:52');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `type` enum('fixed','percent') NOT NULL DEFAULT 'fixed',
  `value` decimal(12,2) NOT NULL,
  `min_order_amount` decimal(12,2) DEFAULT NULL,
  `max_uses` int(11) DEFAULT NULL,
  `used_times` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `type`, `value`, `min_order_amount`, `max_uses`, `used_times`, `is_active`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'WELCOME10', 'percent', 10.00, 1000.00, 100, 0, 1, '2025-07-14 07:50:32', '2025-04-14 07:50:32', '2025-04-14 07:50:32'),
(2, 'SUMMER25', 'percent', 25.00, 5000.00, 50, 0, 1, '2025-06-14 07:50:32', '2025-04-14 07:50:32', '2025-04-14 07:50:32'),
(3, 'FLAT500', 'fixed', 500.00, 2000.00, 30, 0, 1, '2025-05-14 07:50:32', '2025-04-14 07:50:32', '2025-04-14 07:50:32'),
(4, 'VIP15', 'percent', 15.00, 3000.00, 100, 0, 1, '2025-10-14 07:50:32', '2025-04-14 07:50:32', '2025-04-14 07:50:32');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '2025-04-14 07:50:32', '2025-04-14 07:50:32'),
(2, 2, 10, '2025-04-14 07:50:32', '2025-04-14 07:50:32'),
(3, 2, 11, '2025-04-14 07:50:32', '2025-04-14 07:50:32'),
(4, 2, 12, '2025-04-14 07:50:33', '2025-04-14 07:50:33'),
(5, 3, 4, '2025-04-14 07:50:33', '2025-04-14 07:50:33'),
(6, 3, 14, '2025-04-14 07:50:33', '2025-04-14 07:50:33'),
(7, 3, 16, '2025-04-14 07:50:33', '2025-04-14 07:50:33'),
(8, 6, 1, '2025-04-14 07:50:33', '2025-04-14 07:50:33'),
(9, 6, 2, '2025-04-14 07:50:33', '2025-04-14 07:50:33'),
(10, 6, 3, '2025-04-14 07:50:33', '2025-04-14 07:50:33'),
(11, 6, 15, '2025-04-14 07:50:33', '2025-04-14 07:50:33'),
(12, 9, 2, '2025-04-14 07:50:33', '2025-04-14 07:50:33'),
(13, 9, 9, '2025-04-14 07:50:33', '2025-04-14 07:50:33'),
(14, 9, 12, '2025-04-14 07:50:33', '2025-04-14 07:50:33'),
(15, 11, 3, '2025-04-14 07:50:33', '2025-04-14 07:50:33');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2023_05_20_create_sliders_table', 1),
(5, '2025_04_14_141131_add_role_to_users_table', 1),
(6, '2025_04_14_141139_create_categories_table', 1),
(7, '2025_04_14_141144_create_products_table', 1),
(8, '2025_04_14_141150_create_orders_table', 1),
(9, '2025_04_14_141206_create_order_items_table', 1),
(10, '2025_04_15_045713_add_profile_image_to_users_table', 2),
(11, '2025_04_15_084319_add_shipping_method_to_orders_table', 3),
(12, '2025_04_15_084958_add_shipping_method_column_to_orders_table', 4),
(13, '2025_04_15_091315_add_favorites_to_users_table', 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `total` decimal(12,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `tax` decimal(12,2) NOT NULL DEFAULT 0.00,
  `shipping_cost` decimal(12,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `coupon_code` varchar(255) DEFAULT NULL,
  `shipping_name` varchar(255) NOT NULL,
  `shipping_email` varchar(255) NOT NULL,
  `shipping_phone` varchar(255) NOT NULL,
  `shipping_address` varchar(255) NOT NULL,
  `shipping_method` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `payment_method` varchar(255) NOT NULL DEFAULT 'cod',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `status`, `total`, `subtotal`, `tax`, `shipping_cost`, `discount`, `coupon_code`, `shipping_name`, `shipping_email`, `shipping_phone`, `shipping_address`, `shipping_method`, `notes`, `payment_method`, `created_at`, `updated_at`) VALUES
(1, 3, 'shipped', 57500.00, 56000.00, 0.00, 1500.00, 0.00, NULL, 'User 2', 'user2@example.com', '9876543212', '2 User Street, User City', NULL, NULL, 'cod', '2025-03-28 23:23:22', '2025-04-14 23:23:22'),
(2, 3, 'shipped', 48000.00, 48000.00, 0.00, 0.00, 0.00, NULL, 'User 2', 'user2@example.com', '9876543212', '2 User Street, User City', NULL, NULL, 'cod', '2025-04-05 23:23:22', '2025-04-14 23:23:22'),
(3, 4, 'delivered', 152500.00, 151000.00, 0.00, 1500.00, 0.00, NULL, 'User 3', 'user3@example.com', '9876543213', '3 User Street, User City', NULL, 'Please deliver during business hours.', 'bank_transfer', '2025-03-19 23:23:22', '2025-04-14 23:23:22'),
(4, 4, 'cancelled', 339500.00, 339500.00, 0.00, 0.00, 0.00, NULL, 'User 3', 'user3@example.com', '9876543213', '3 User Street, User City', NULL, NULL, 'cod', '2025-03-24 23:23:22', '2025-04-14 23:23:22'),
(5, 4, 'delivered', 390500.00, 389000.00, 0.00, 1500.00, 0.00, NULL, 'User 3', 'user3@example.com', '9876543213', '3 User Street, User City', NULL, 'Please deliver during business hours. Testttttttttttttt', 'bank_transfer', '2025-04-08 23:23:22', '2025-04-14 23:27:20'),
(6, 6, 'processing', 76500.00, 75000.00, 0.00, 1500.00, 0.00, NULL, 'User 5', 'user5@example.com', '9876543215', '5 User Street, User City', NULL, 'Please deliver during business hours.', 'bank_transfer', '2025-03-22 23:23:22', '2025-04-14 23:23:22'),
(7, 7, 'new', 93000.00, 91500.00, 0.00, 1500.00, 0.00, NULL, 'User 6', 'user6@example.com', '9876543216', '6 User Street, User City', NULL, 'Please deliver during business hours.', 'bank_transfer', '2025-03-15 23:23:22', '2025-04-14 23:23:22'),
(8, 7, 'delivered', 177500.00, 176000.00, 0.00, 1500.00, 0.00, NULL, 'User 6', 'user6@example.com', '9876543216', '6 User Street, User City', NULL, 'Please deliver during business hours.', 'cod', '2025-04-02 23:23:22', '2025-04-14 23:23:22'),
(9, 9, 'shipped', 148000.00, 148000.00, 0.00, 0.00, 0.00, NULL, 'Trần Hoàng Dịu Lan', 'user8@example.com', '9876543218', '8 User Street, User City', NULL, NULL, 'cod', '2025-03-30 23:23:22', '2025-04-14 23:23:22'),
(10, 9, 'delivered', 81000.00, 79500.00, 0.00, 1500.00, 0.00, NULL, 'Trần Hoàng Dịu Lan', 'user8@example.com', '9876543218', '8 User Street, User City', NULL, 'Please deliver during business hours.', 'cod', '2025-03-15 23:23:22', '2025-04-14 23:23:22'),
(11, 9, 'shipped', 82000.00, 82000.00, 0.00, 0.00, 0.00, NULL, 'Trần Hoàng Dịu Lan', 'user8@example.com', '9876543218', '8 User Street, User City', NULL, 'Please deliver during business hours.', 'cod', '2025-04-06 23:23:22', '2025-04-14 23:23:22'),
(12, 10, 'processing', 81000.00, 81000.00, 0.00, 0.00, 0.00, NULL, 'User 9', 'user9@example.com', '9876543219', '9 User Street, User City', NULL, NULL, 'cod', '2025-03-31 23:23:22', '2025-04-14 23:23:22'),
(13, 10, 'new', 76000.00, 76000.00, 0.00, 0.00, 0.00, NULL, 'User 9', 'user9@example.com', '9876543219', '9 User Street, User City', NULL, 'Please deliver during business hours.', 'bank_transfer', '2025-04-02 23:23:22', '2025-04-14 23:23:22'),
(14, 10, 'processing', 51000.00, 51000.00, 0.00, 0.00, 0.00, NULL, 'User 9', 'user9@example.com', '9876543219', '9 User Street, User City', NULL, NULL, 'bank_transfer', '2025-03-19 23:23:22', '2025-04-14 23:23:22'),
(15, 12, 'new', 105125.00, 116000.00, 0.00, 25000.00, 35875.00, 'SUMMER25', 'Admin', 'test@gmail.com', '123456789', 'gdsgdsgs', 'shopee_express', 'testzxij;zfjjjgxjigtij;gổiiewoowaokpawokawpkorfhujej;rưk[\r\nrưhjohwrjo[ửhoj[hrnr;hml', 'momo', '2025-04-15 01:59:18', '2025-04-15 01:59:18'),
(16, 12, 'new', 105125.00, 116000.00, 0.00, 25000.00, 35875.00, 'SUMMER25', 'Admin', 'test@gmail.com', '123456789', 'gdsgdsgs', 'shopee_express', 'testzxij;zfjjjgxjigtij;gổiiewoowaokpawokawpkorfhujej;rưk[\r\nrưhjohwrjo[ửhoj[hrnr;hml', 'momo', '2025-04-15 02:02:06', '2025-04-15 02:02:06'),
(17, 12, 'new', 161500.00, 131500.00, 0.00, 30000.00, 0.00, NULL, 'Admin', 'test@gmail.com', '654654456546456', 'jugjgjgjgfj', 'viettel_post', 'gsysrethjtsweEW', 'cod', '2025-04-15 02:03:14', '2025-04-15 02:03:14'),
(18, 12, 'new', 153000.00, 113000.00, 0.00, 40000.00, 0.00, NULL, 'Admin', 'test@gmail.com', '654654456546456', 'jugjgjgjgfj', 'self_transport', 'fgagrgGERGAE', 'momo', '2025-04-15 02:07:23', '2025-04-15 02:07:23'),
(19, 12, 'processing', 95500.00, 55500.00, 0.00, 40000.00, 0.00, NULL, 'Admin', 'nguyenquangson.270804@gmail.com', '0328762390', 'test', 'self_transport', 'đơn này dùng để test', 'vnpay', '2025-04-15 03:18:34', '2025-04-15 03:20:05');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `price`, `quantity`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Toyota Camry', 28000.00, 2, 56000.00, '2025-03-28 23:23:22', '2025-03-28 23:23:22'),
(2, 2, 14, 'Tesla Model 3', 48000.00, 1, 48000.00, '2025-04-05 23:23:22', '2025-04-05 23:23:22'),
(3, 3, 2, 'Honda Accord', 27500.00, 2, 55000.00, '2025-03-19 23:23:22', '2025-03-19 23:23:22'),
(4, 3, 14, 'Tesla Model 3', 48000.00, 2, 96000.00, '2025-03-19 23:23:22', '2025-03-19 23:23:22'),
(5, 4, 9, 'Mercedes-Benz S-Class', 110000.00, 2, 220000.00, '2025-03-24 23:23:22', '2025-03-24 23:23:22'),
(6, 4, 10, 'BMW 7 Series', 92000.00, 1, 92000.00, '2025-03-24 23:23:22', '2025-03-24 23:23:22'),
(7, 4, 2, 'Honda Accord', 27500.00, 1, 27500.00, '2025-03-24 23:23:22', '2025-03-24 23:23:22'),
(8, 5, 9, 'Mercedes-Benz S-Class', 110000.00, 2, 220000.00, '2025-04-08 23:23:22', '2025-04-08 23:23:22'),
(9, 5, 8, 'Mazda 3 Hatchback', 27000.00, 2, 54000.00, '2025-04-08 23:23:22', '2025-04-08 23:23:22'),
(10, 5, 12, 'Porsche 911', 115000.00, 1, 115000.00, '2025-04-08 23:23:22', '2025-04-08 23:23:22'),
(11, 6, 3, 'Nissan Altima', 24000.00, 2, 48000.00, '2025-03-22 23:23:22', '2025-03-22 23:23:22'),
(12, 6, 8, 'Mazda 3 Hatchback', 27000.00, 1, 27000.00, '2025-03-22 23:23:22', '2025-03-22 23:23:22'),
(13, 7, 5, 'Honda CR-V', 32000.00, 2, 64000.00, '2025-03-15 23:23:22', '2025-03-15 23:23:22'),
(14, 7, 2, 'Honda Accord', 27500.00, 1, 27500.00, '2025-03-15 23:23:22', '2025-03-15 23:23:22'),
(15, 8, 11, 'Audi A8', 88000.00, 2, 176000.00, '2025-04-02 23:23:22', '2025-04-02 23:23:22'),
(16, 9, 8, 'Mazda 3 Hatchback', 27000.00, 1, 27000.00, '2025-03-30 23:23:22', '2025-03-30 23:23:22'),
(17, 9, 4, 'Toyota RAV4', 29500.00, 2, 59000.00, '2025-03-30 23:23:22', '2025-03-30 23:23:22'),
(18, 9, 13, 'Chevrolet Corvette', 62000.00, 1, 62000.00, '2025-03-30 23:23:22', '2025-03-30 23:23:22'),
(19, 10, 2, 'Honda Accord', 27500.00, 1, 27500.00, '2025-03-15 23:23:22', '2025-03-15 23:23:22'),
(20, 10, 16, 'Ford Mustang Mach-E', 52000.00, 1, 52000.00, '2025-03-15 23:23:22', '2025-03-15 23:23:22'),
(21, 11, 15, 'Nissan Leaf', 30000.00, 1, 30000.00, '2025-04-06 23:23:22', '2025-04-06 23:23:22'),
(22, 11, 16, 'Ford Mustang Mach-E', 52000.00, 1, 52000.00, '2025-04-06 23:23:22', '2025-04-06 23:23:22'),
(23, 12, 8, 'Mazda 3 Hatchback', 27000.00, 1, 27000.00, '2025-03-31 23:23:22', '2025-03-31 23:23:22'),
(24, 12, 8, 'Mazda 3 Hatchback', 27000.00, 2, 54000.00, '2025-03-31 23:23:22', '2025-03-31 23:23:22'),
(25, 13, 6, 'Ford Explorer', 38000.00, 2, 76000.00, '2025-04-02 23:23:22', '2025-04-02 23:23:22'),
(26, 14, 7, 'Honda Civic Hatchback', 25500.00, 2, 51000.00, '2025-03-19 23:23:22', '2025-03-19 23:23:22'),
(27, 15, 11, 'Audi A8', 88000.00, 1, 88000.00, '2025-04-15 01:59:18', '2025-04-15 01:59:18'),
(28, 15, 1, 'Toyota Camry', 28000.00, 1, 28000.00, '2025-04-15 01:59:18', '2025-04-15 01:59:18'),
(29, 16, 11, 'Audi A8', 88000.00, 1, 88000.00, '2025-04-15 02:02:06', '2025-04-15 02:02:06'),
(30, 16, 1, 'Toyota Camry', 28000.00, 1, 28000.00, '2025-04-15 02:02:06', '2025-04-15 02:02:06'),
(31, 17, 1, 'Toyota Camry', 28000.00, 1, 28000.00, '2025-04-15 02:03:14', '2025-04-15 02:03:14'),
(32, 17, 2, 'Honda Accord', 27500.00, 1, 27500.00, '2025-04-15 02:03:14', '2025-04-15 02:03:14'),
(33, 17, 3, 'Nissan Altima', 24000.00, 1, 24000.00, '2025-04-15 02:03:14', '2025-04-15 02:03:14'),
(34, 17, 16, 'Ford Mustang Mach-E', 52000.00, 1, 52000.00, '2025-04-15 02:03:14', '2025-04-15 02:03:14'),
(35, 18, 4, 'Toyota RAV4', 29500.00, 2, 59000.00, '2025-04-15 02:07:23', '2025-04-15 02:07:23'),
(36, 18, 3, 'Nissan Altima', 24000.00, 1, 24000.00, '2025-04-15 02:07:23', '2025-04-15 02:07:23'),
(37, 18, 15, 'Nissan Leaf', 30000.00, 1, 30000.00, '2025-04-15 02:07:23', '2025-04-15 02:07:23'),
(38, 19, 2, 'Honda Accord', 27500.00, 1, 27500.00, '2025-04-15 03:18:34', '2025-04-15 03:18:34'),
(39, 19, 1, 'Toyota Camry', 28000.00, 1, 28000.00, '2025-04-15 03:18:34', '2025-04-15 03:18:34');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `details` text DEFAULT NULL,
  `price` decimal(12,2) NOT NULL,
  `sale_price` decimal(12,2) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `images` text DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_new` tinyint(1) NOT NULL DEFAULT 0,
  `on_sale` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `description`, `details`, `price`, `sale_price`, `quantity`, `image`, `images`, `featured`, `is_new`, `on_sale`, `created_at`, `updated_at`) VALUES
(1, 1, 'Toyota Camry', 'toyota-camry', 'The reliable and comfortable Toyota Camry sedan', 'Engine: 2.5L 4-cylinder, Transmission: 8-speed automatic, MPG: 29 city / 41 highway', 28000.00, 26500.00, 11, 'products/FLMcFXIGp33qmDHsWaX6ln1OlLNieyzjQ9V2ZDgT.jpg', NULL, 1, 0, 0, '2025-04-14 07:50:32', '2025-04-15 03:18:34'),
(2, 1, 'Honda Accord', 'honda-accord', 'The stylish and efficient Honda Accord sedan', 'Engine: 1.5L Turbo 4-cylinder, Transmission: CVT, MPG: 30 city / 38 highway', 27500.00, NULL, 10, 'products/vWDXn6ICFYFAIK4sjCpzlahrFss2J0SLGiAdDmVu.jpg', NULL, 1, 0, 0, '2025-04-14 07:50:32', '2025-04-15 03:18:34'),
(3, 1, 'Nissan Altima', 'nissan-altima', 'The comfortable and affordable Nissan Altima sedan', 'Engine: 2.5L 4-cylinder, Transmission: CVT, MPG: 28 city / 39 highway', 25500.00, 24000.00, 6, 'products/URMaJXf95NcvA9LL8VaC3cx97MPGqPpIxuFf4sQY.jpg', NULL, 1, 0, 1, '2025-04-14 07:50:32', '2025-04-15 02:07:23'),
(4, 2, 'Toyota RAV4', 'toyota-rav4', 'The versatile and capable Toyota RAV4 SUV', 'Engine: 2.5L 4-cylinder, Transmission: 8-speed automatic, MPG: 27 city / 35 highway', 31000.00, 29500.00, 8, 'products/CUEKBllC7zAroX0u00g6E2e0PYZKns1Hr3rGPihU.jpg', NULL, 1, 1, 1, '2025-04-14 07:50:32', '2025-04-15 02:07:23'),
(5, 2, 'Honda CR-V', 'honda-cr-v', 'The spacious and reliable Honda CR-V SUV', 'Engine: 1.5L Turbo 4-cylinder, Transmission: CVT, MPG: 28 city / 34 highway', 32000.00, NULL, 9, 'products/ZYgO626IvOjV09y2H8ydw3ygfQhyQvKYqrJdMqHy.jpg', NULL, 0, 1, 0, '2025-04-14 07:50:32', '2025-04-14 19:40:57'),
(6, 2, 'Ford Explorer', 'ford-explorer', 'The powerful and spacious Ford Explorer SUV', 'Engine: 2.3L EcoBoost, Transmission: 10-speed automatic, MPG: 21 city / 28 highway', 38000.00, 36000.00, 6, 'products/Drt4aWsxn3UK5gQkd2TzlWUfMGmpwrtjLdJLHOsh.jpg', NULL, 0, 1, 0, '2025-04-14 07:50:32', '2025-04-14 19:41:07'),
(7, 3, 'Honda Civic Hatchback', 'honda-civic-hatchback', 'The sporty and practical Honda Civic Hatchback', 'Engine: 1.5L Turbo 4-cylinder, Transmission: CVT, MPG: 31 city / 40 highway', 25500.00, NULL, 14, 'products/g3KmqgP9QsSofrEhWka8egCiBTBe2hNTQ1X0Oodc.jpg', NULL, 0, 1, 0, '2025-04-14 07:50:32', '2025-04-14 19:41:30'),
(8, 3, 'Mazda 3 Hatchback', 'mazda-3-hatchback', 'The elegant and fun-to-drive Mazda 3 Hatchback', 'Engine: 2.5L 4-cylinder, Transmission: 6-speed automatic, MPG: 26 city / 35 highway', 27000.00, 25500.00, 7, 'products/qlIzbavkKy1wWoqMgGgG3eMBOMtBE3sBkxVviBXb.jpg', NULL, 0, 1, 0, '2025-04-14 07:50:32', '2025-04-14 19:41:43'),
(9, 4, 'Mercedes-Benz S-Class', 'mercedes-benz-s-class', 'The pinnacle of luxury and technology', 'Engine: 3.0L Inline-6 Turbo, Transmission: 9-speed automatic, MPG: 22 city / 29 highway', 110000.00, NULL, 5, 'products/ZnzuAYFt3Z1Lz0e9KQfJWcH1czOXuNg0sFjP2hEn.jpg', NULL, 0, 0, 0, '2025-04-14 07:50:32', '2025-04-14 19:41:52'),
(10, 4, 'BMW 7 Series', 'bmw-7-series', 'The ultimate driving luxury sedan', 'Engine: 3.0L Twin-Turbo 6-cylinder, Transmission: 8-speed automatic, MPG: 22 city / 29 highway', 95000.00, 92000.00, 4, 'products/QTOwrWNEfsXmZEQBGlcu9UNd8hO1ae8fPirbAW9a.jpg', NULL, 0, 0, 1, '2025-04-14 07:50:32', '2025-04-14 19:42:01'),
(11, 4, 'Audi A8', 'audi-a8', 'The sophisticated and tech-forward luxury sedan', 'Engine: 3.0L V6 Turbo, Transmission: 8-speed automatic, MPG: 21 city / 29 highway', 88000.00, NULL, 1, 'products/fkIWDcEd6KndZLlCdUs2LZYpckkPyD4JUJK58BQ1.jpg', NULL, 0, 0, 1, '2025-04-14 07:50:32', '2025-04-15 02:02:06'),
(12, 5, 'Porsche 911', 'porsche-911', 'The iconic and exhilarating Porsche 911 sports car', 'Engine: 3.0L Twin-Turbo 6-cylinder, Transmission: 8-speed PDK, 0-60 mph: 3.5 seconds', 115000.00, NULL, 3, 'products/livHLvkTzq1RDXgBtZMLeFNh1jsAMgh2V3QRDhW4.jpg', '\"[\\\"products\\\\\\/cku5Mhc9h8BT0CaJZVZTUvoxXagE2myNIespgcIE.jpg\\\"]\"', 0, 0, 1, '2025-04-14 07:50:32', '2025-04-14 19:43:01'),
(13, 5, 'Chevrolet Corvette', 'chevrolet-corvette', 'The powerful American sports car', 'Engine: 6.2L V8, Transmission: 8-speed dual-clutch, 0-60 mph: 2.9 seconds', 65000.00, 62000.00, 5, 'products/N7KmgmiqeTvE9vCFCRpNlhLYnXpMKOKiFV1iiwYv.jpg', NULL, 0, 0, 1, '2025-04-14 07:50:32', '2025-04-14 19:43:14'),
(14, 6, 'Tesla Model 3', 'tesla-model-3', 'The popular and efficient Tesla Model 3 electric sedan', 'Range: 358 miles, 0-60 mph: 3.1 seconds, Dual Motor All-Wheel Drive', 48000.00, NULL, 10, 'products/ldudMVpvyniJQKl3Mxc6BaPWKfpSb2zMm0QVYTJd.jpg', NULL, 1, 1, 0, '2025-04-14 07:50:32', '2025-04-14 19:43:26'),
(15, 6, 'Nissan Leaf', 'nissan-leaf', 'The affordable and practical Nissan Leaf electric hatchback', 'Range: 226 miles, Motor: 147 hp electric, Battery: 62 kWh', 32000.00, 30000.00, 11, 'products/4gKQgNBzZws9KF741dlBii8TpVnJ0dHrBXcn259d.jpg', NULL, 0, 0, 1, '2025-04-14 07:50:32', '2025-04-15 02:07:23'),
(16, 6, 'Ford Mustang Mach-E', 'ford-mustang-mach-e', 'The exciting and capable Ford Mustang Mach-E electric SUV', 'Range: 314 miles, 0-60 mph: 3.5 seconds, Dual Motor All-Wheel Drive', 52000.00, NULL, 6, 'products/QpKf2ECiHGsUJetZRHtt92OmkVA5hP3VRbWJpZJz.jpg', '\"[\\\"products\\\\\\/bQNIfm3PeSJFrfUYT5ok84iifCdTVW8RW5HlFMsL.jpg\\\"]\"', 1, 1, 0, '2025-04-14 07:50:32', '2025-04-15 02:03:14');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `rating` int(11) NOT NULL DEFAULT 5,
  `comment` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('6FrchERdwlXjbEH3EH9rSaoe9FNLolZnH1BPB9rv', 12, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiRE14Qm9IVDJkb0tKU0Mzd3E5bHBFZ2IyUFVtb1QxSm9aZGY2dDhwMSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL3VzZXJzLzEzL2VkaXQiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0NDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3Byb2R1Y3RzL25pc3Nhbi1hbHRpbWEiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxMjtzOjQ6ImNhcnQiO2E6Mjp7aToyO2E6NTp7czoyOiJpZCI7aToyO3M6NDoibmFtZSI7czoxMjoiSG9uZGEgQWNjb3JkIjtzOjU6InByaWNlIjtzOjg6IjI3NTAwLjAwIjtzOjg6InF1YW50aXR5IjtzOjE6IjEiO3M6NToiaW1hZ2UiO3M6NjE6InN0b3JhZ2UvcHJvZHVjdHMvdldEWG42SUNGWUZBSUs0c2pDcHpsYWhyRnNzMkowU0xHaUFkRG1WdS5qcGciO31pOjM7YTo1OntzOjI6ImlkIjtpOjM7czo0OiJuYW1lIjtzOjEzOiJOaXNzYW4gQWx0aW1hIjtzOjU6InByaWNlIjtzOjg6IjI0MDAwLjAwIjtzOjg6InF1YW50aXR5IjtzOjE6IjEiO3M6NToiaW1hZ2UiO3M6NjE6InN0b3JhZ2UvcHJvZHVjdHMvVVJNYUpYZjk1TmN2QTlMTDhWYUMzY3g5N01QR3FQcEl4dUZmNHNRWS5qcGciO319fQ==', 1744717792);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `link_text` varchar(255) DEFAULT 'Learn More',
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sliders`
--

INSERT INTO `sliders` (`id`, `title`, `subtitle`, `image`, `link`, `link_text`, `status`, `order`, `created_at`, `updated_at`) VALUES
(1, 'Luxury Cars for Every Budget', 'Explore our premium collection with special financing', 'sliders/PXluHCUVgVxo5QnBLTM8gWecNgZ4PvJ0N7OjJ4bE.jpg', 'https://shop.vinfastauto.com/vn_vi/dat-coc-xe-vf9.html', 'VinFast VF 9', 1, 1, '2025-04-14 07:50:32', '2025-04-14 11:50:25'),
(2, 'New Electric Vehicles', 'Discover the future of driving with zero emissions', 'sliders/WxkqAHlSX5nnd5EVeBINnPojLGBd8ZRJbzhutiWL.jpg', 'https://en.wikipedia.org/wiki/T-90', 'Tank T-90', 1, 2, '2025-04-14 07:50:32', '2025-04-14 11:56:31'),
(3, 'Family SUVs on Sale', 'Find the perfect vehicle for your family adventures', 'sliders/nIXHMx6Lasrb2zq0s2QTsp4ysDpP4ztx8OI8qRRB.jpg', 'https://en.wikipedia.org/wiki/T-90', 'Tank T-90', 1, 3, '2025-04-14 07:50:32', '2025-04-14 11:59:40'),
(4, 'Sports Cars Special Offer', 'Experience the thrill of driving performance vehicles', 'sliders/MFHn4pjhefWM4iJZFAkh9jZNoQhIv06naId92QZT.jpg', 'https://shop.vinfastauto.com/vn_vi/dat-coc-xe-vf9.html', 'Lamborgini Urus', 1, 4, '2025-04-14 07:50:32', '2025-04-14 11:58:02');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `favorites` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`favorites`)),
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `profile_image`, `email_verified_at`, `password`, `favorites`, `remember_token`, `created_at`, `updated_at`, `role`, `phone`, `address`) VALUES
(1, 'Admin User', 'admin@example.com', 'profile-images/JE1WF77UJkY7MGYAhbGveXTwmvbgHwa8dPF3zZ3w.jpg', NULL, '$2y$12$AnJ4QLXDAalQ6UpiF9q3L.CST31jF8EnRU4gg18WLsgnczIj0I..2', NULL, NULL, '2025-04-14 07:50:30', '2025-04-14 22:25:28', 'admin', '1234567890', '123 Admin Street, Admin City'),
(2, 'User 1', 'user1@example.com', 'profile-images/1h5gukH3QiwPWSCeqnzByN0dw5H5fqyOVIPkN9L1.jpg', NULL, '$2y$12$pAhOEhh2GQ./iMln1asZG.EhYst.atmJrDFXEArU3YB9oMSuYb9ea', NULL, NULL, '2025-04-14 07:50:30', '2025-04-14 22:42:35', 'user', '9876543211', '1 User Street, User City'),
(3, 'User 2', 'user2@example.com', NULL, NULL, '$2y$12$iVqjUNblQuzqyhycblkNGeYSPmxiIC1EeuGYrb28KqLS1fzuuD7qG', NULL, NULL, '2025-04-14 07:50:30', '2025-04-14 07:50:30', 'user', '9876543212', '2 User Street, User City'),
(4, 'User 3', 'user3@example.com', NULL, NULL, '$2y$12$a3poVcgb/.vmBcxF1ZDP7eK1JYBwxGT3Vw6kcNPGbXAuuaveHTE0K', NULL, NULL, '2025-04-14 07:50:30', '2025-04-14 07:50:30', 'user', '9876543213', '3 User Street, User City'),
(5, 'User 4', 'user4@example.com', 'profile-images/vYY91JxVvQ28KWAiorRoMycnVjhaz5ivkzrdWcBu.jpg', NULL, '$2y$12$bfJA8CH4zcHGGfdoWAADJeDvi2Vdsh4jAIiGgalEx6y21xGz2Vzjy', NULL, NULL, '2025-04-14 07:50:31', '2025-04-14 22:23:22', 'user', '9876543214', '4 User Street, User City'),
(6, 'User 5', 'user5@example.com', 'profile-images/b9ryl3MxagBZlYXPwP5TQp8UVY88OjOKUzYq245B.jpg', NULL, '$2y$12$TXG2cnF6pdIHAUdvbvgSQO2VEMu4.MlGjaAF1qYf4svhz07hlov7S', NULL, NULL, '2025-04-14 07:50:31', '2025-04-14 22:23:33', 'user', '9876543215', '5 User Street, User City'),
(7, 'User 6', 'user6@example.com', 'profile-images/Vb8S0jPW86HPETt9vfrQyy9p9KYw4b0UC7UEAdCe.jpg', NULL, '$2y$12$qcgMXuWyQy8bqcXz9vN1N.6SmIfJflLQimRQ5R6Zu4bmXCbvA1uk2', NULL, NULL, '2025-04-14 07:50:31', '2025-04-14 22:24:31', 'user', '9876543216', '6 User Street, User City'),
(8, 'User 7', 'user7@example.com', 'profile-images/ozFhlXML3P2gAqvPFlswLUXmGC87RcvZ2yN0lyvS.jpg', NULL, '$2y$12$lsLfUu9c1RV1AcypTbMUju1/Goggo3.SV6OeJoDCBWkfb/0x/lZJ2', NULL, NULL, '2025-04-14 07:50:31', '2025-04-14 22:24:46', 'user', '9876543217', '7 User Street, User City'),
(9, 'Trần Hoàng Dịu Lan', 'user8@example.com', 'profile-images/wJOZYFnzXNCxEJ65qYtHgBjNzXjPEIFtbhhEtRKC.png', NULL, '$2y$12$8EezRPH1i2//hJbZacXdmunTyGcu7TKaSiRHK9XwfOk0LME0DC1g.', NULL, NULL, '2025-04-14 07:50:32', '2025-04-14 22:21:54', 'user', '9876543218', '8 User Street, User City'),
(10, 'User 9', 'user9@example.com', 'profile-images/K4rAHcOvwg8eluTPB1NU7Wkdkz8valr74U3hPn1e.jpg', NULL, '$2y$12$2SG/hyNdzQCQf4BhFxmF/.xkL.kN84YiRcobBzAMdQuDMx9q74D72', NULL, NULL, '2025-04-14 07:50:32', '2025-04-14 22:22:59', 'user', '9876543219', '9 User Street, User City'),
(12, 'Admin', 'test@gmail.com', 'profile-images/Hvl3TkRtyvPQ0uU9BcnaR3nPCZPGOFoLqo6M4jdI.png', NULL, '$2y$12$OScugcojzPxvJ44WASTukuO5.cVU/p1pF96mpSAaq3a2vJdSwuMXe', NULL, 'q5DC7IJMCTbl7DxAepVDdjYeCoNnh31LIUaqrsGW0JCW4MrAYEnnIN7dVSWH', '2025-04-14 10:02:19', '2025-04-14 22:21:26', 'admin', NULL, NULL),
(13, 'Nguyễn Trần Linh Hương', 'concactaone@gmail.com', 'profile-images/3L5LcB65zYU5gAJyO95wjoZjxOf22gbNBcnJRXYk.png', NULL, '$2y$12$eb7pZqQjgsMCrZ1Sak1b/utBDNoxJxVeFqIBETf0Al2vDV73gZrDa', NULL, 'j99JcKdKLgz6A4DE5ojdhvCQOmNWBxZwoUfIsBpRbqnsx7G3d1DGduQBZr3z', '2025-04-14 20:12:30', '2025-04-14 22:21:03', 'user', NULL, NULL),
(14, 'Linh Lộc Ngự Tiền', 'linhloc@gmail.com', 'profile-images/PpIrZKiOvhnS5e7RUl5fwLQCONFET0QjbjLOU3et.png', NULL, '$2y$12$QE0w5m2vaSBrMfbetzMB..FnGAjgh5bicdBKpPrLMgtSO9cLnoumu', NULL, NULL, '2025-04-14 22:45:13', '2025-04-14 22:45:13', 'user', NULL, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Chỉ mục cho bảng `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `favorites_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD KEY `favorites_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
