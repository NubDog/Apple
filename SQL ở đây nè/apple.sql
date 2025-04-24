-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 24, 2025 lúc 03:13 PM
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
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `name`, `slug`, `status`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Sedan', 'sedan', 1, 'Four-door passenger cars with a separate trunk', 'categories/sedan.jpg', '2025-04-14 07:50:32', '2025-04-14 07:50:32'),
(2, NULL, 'SUV', 'suv', 1, 'Sport Utility Vehicles with raised ground clearance', 'categories/suv.jpg', '2025-04-14 07:50:32', '2025-04-14 07:50:32'),
(3, NULL, 'Hatchback', 'hatchback', 1, 'Compact cars with a rear door that opens upwards', 'categories/hatchback.jpg', '2025-04-14 07:50:32', '2025-04-14 07:50:32'),
(4, NULL, 'Luxury', 'luxury', 1, 'High-end vehicles with premium features', 'categories/luxury.jpg', '2025-04-14 07:50:32', '2025-04-14 07:50:32'),
(5, NULL, 'Sports Car', 'sports-car', 1, 'High-performance vehicles designed for speed', 'categories/sports.jpg', '2025-04-14 07:50:32', '2025-04-14 07:50:32'),
(6, NULL, 'Electric', 'electric', 1, 'Vehicles powered by electric motors', 'categories/Nx6sLVGuHZe0uv5x4loI66ib3m3zZ7Zd2j95QBbd.jpg', '2025-04-14 07:50:32', '2025-04-14 22:57:39'),
(7, NULL, 'Tank', 'tank', 1, 'A car that makes everyone who sees you on the street respect you, dogs don\'t dare bark at you, and ex-lovers insist on getting back together.', 'categories/b3Vnj7N0HZiWxNlMQxfXAutenyOS0DB48RwsY0yc.jpg', '2025-04-14 23:01:51', '2025-04-14 23:01:51');

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
(5, 'Robert Brown', 'robert.brown@example.com', '3332221111', 'Electric Vehicle Information', 'I am interested in learning more about your electric vehicle options. Do you offer any special incentives or rebates for EV purchases?', 0, NULL, NULL, '2025-04-14 19:32:52', '2025-04-14 19:32:52'),
(6, 'Sơn nè', 'akhihithangngu@gmail.com', '0398329432', 'Nike Men\'s Air Max SC Leather Shoes White size 43', 'cac lon cihm buob', 1, NULL, NULL, '2025-04-15 05:32:07', '2025-04-15 05:53:42'),
(7, 'Test', 'test@gmail.com', '0398329432', 'Mua xe', 'test', 1, NULL, NULL, '2025-04-15 18:47:43', '2025-04-15 18:49:09'),
(8, 'Test', 'xunuamd@gmail.com', '0398329432', 'Mua xe', 'alooooafihslwj;hogahhkhkajghjkrag;jgaerl;444', 1, NULL, NULL, '2025-04-15 18:49:49', '2025-04-15 18:51:22'),
(9, 'Trâm Nè Đừng Sợ', 'akhihithangngu@gmail.com', '0866003676', 'Dân chơi công nghệ', 'Biết ông Thương không? Thương nào?', 1, NULL, NULL, '2025-04-20 19:35:14', '2025-04-20 19:38:33');

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
(15, 11, 3, '2025-04-14 07:50:33', '2025-04-14 07:50:33'),
(16, 18, 52, '2025-04-20 18:27:24', '2025-04-20 18:27:24'),
(17, 18, 39, '2025-04-20 19:18:36', '2025-04-20 19:18:36'),
(18, 18, 41, '2025-04-20 19:18:58', '2025-04-20 19:18:58'),
(19, 18, 38, '2025-04-20 19:19:23', '2025-04-20 19:19:23');

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
(13, '2025_04_15_091315_add_favorites_to_users_table', 5),
(14, '2025_04_15_122900_update_contacts_table_id_auto_increment', 6),
(15, '2025_04_20_114020_add_parent_id_to_categories_table', 7);

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
(19, 12, 'processing', 95500.00, 55500.00, 0.00, 40000.00, 0.00, NULL, 'Admin', 'nguyenquangson.270804@gmail.com', '0328762390', 'test', 'self_transport', 'đơn này dùng để test', 'vnpay', '2025-04-15 03:18:34', '2025-04-15 03:20:05'),
(21, 18, 'delivered', 1247000.00, 1217000.00, 0.00, 30000.00, 0.00, NULL, 'Ryzen', 'akhihithangngu@gmail.com', '123456789', 'gdsgdsgs', 'viettel_post', 'dsaasdas', 'cod', '2025-04-20 19:17:39', '2025-04-20 23:49:46'),
(22, 18, 'new', 390000.00, 400000.00, 0.00, 0.00, 40000.00, NULL, 'Ryzen', 'akhihithangngu@gmail.com', '123456789', '456f', NULL, NULL, 'cod', '2025-04-21 00:04:23', '2025-04-21 00:04:23'),
(23, 18, 'new', 430000.00, 400000.00, 0.00, 0.00, 0.00, NULL, 'Ryzen', 'akhihithangngu@gmail.com', '32131', '412dsa', NULL, NULL, 'cod', '2025-04-21 00:05:35', '2025-04-21 00:05:35'),
(24, 18, 'new', 390000.00, 400000.00, 0.00, 0.00, 40000.00, NULL, 'Ryzen', 'akhihithangngu@gmail.com', '654654456546456', 'sfaf', NULL, NULL, 'cod', '2025-04-21 00:07:31', '2025-04-21 00:07:31');

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
(44, 21, 52, 'Audi RS e-tron GT 2024', 139000.00, 1, 139000.00, '2025-04-20 19:17:39', '2025-04-20 19:17:39'),
(45, 21, 39, 'Lamborghini Revuelto 2024', 648000.00, 1, 648000.00, '2025-04-20 19:17:39', '2025-04-20 19:17:39'),
(46, 21, 40, 'Porsche 911 GT3 RS 2024', 215000.00, 2, 430000.00, '2025-04-20 19:17:39', '2025-04-20 19:17:39'),
(47, 24, 40, 'Porsche 911 GT3 RS 2024', 215000.00, 1, 215000.00, '2025-04-21 00:07:31', '2025-04-21 00:07:31'),
(48, 24, 46, 'Porsche Taycan Turbo S 2024', 185000.00, 1, 185000.00, '2025-04-21 00:07:31', '2025-04-21 00:07:31');

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
(38, 1, 'Ferrari SF90 Stradale 2024', 'ferrari-sf90-stradale-2024', 'Siêu xe hybrid mạnh mẽ nhất của Ferrari với công suất 986 mã lực', 'Động cơ V8 4.0L twin-turbo kết hợp 3 motor điện, 0-100km/h trong 2.5 giây, tốc độ tối đa 340km/h', 625000.00, 615000.00, 5, 'products/MfjJoAOwaOZzm155xkyPg4aVT1rlGHMj5NMw3hwj.jpg', '\"[\\\"products\\\\\\/ferrari-sf90-1.jpg\\\",\\\"products\\\\\\/ferrari-sf90-2.jpg\\\"]\"', 1, 0, 0, '2025-04-20 15:31:52', '2025-04-20 15:32:38'),
(39, 1, 'Lamborghini Revuelto 2024', 'lamborghini-revuelto-2024', 'Siêu xe hybrid đầu tiên của Lamborghini thay thế Aventador', 'Động cơ V12 6.5L kết hợp 3 motor điện, công suất 1001 mã lực, 0-100km/h trong 2.8 giây', 698000.00, 648000.00, 2, 'products/wpjiAFoK0VYFHYe6hx5TRwRcyZO5oP481RIiFLAH.jpg', '\"[\\\"products\\\\\\/lambo-revuelto-1.jpg\\\",\\\"products\\\\\\/lambo-revuelto-2.jpg\\\"]\"', 1, 0, 1, '2025-04-20 15:31:52', '2025-04-20 19:17:39'),
(40, 1, 'Porsche 911 GT3 RS 2024', 'porsche-911-gt3-rs-2024', 'Phiên bản hiệu suất cao nhất của dòng 911', 'Động cơ boxer 6 xy-lanh 4.0L, công suất 518 mã lực, hệ thống khí động học tiên tiến', 223000.00, 215000.00, 5, 'products/tVj00bJcQ0VWKSdyV3qmoSeqNwY9dX9rkujn2G0S.png', '\"[\\\"products\\\\\\/porsche-gt3rs-1.jpg\\\",\\\"products\\\\\\/porsche-gt3rs-2.jpg\\\"]\"', 1, 1, 1, '2025-04-20 15:31:52', '2025-04-21 00:07:31'),
(41, 1, 'McLaren 750S 2024', 'mclaren-750s-2024', 'Siêu xe thế hệ mới của McLaren thay thế 720S', 'Động cơ V8 twin-turbo 4.0L, công suất 750 mã lực, trọng lượng chỉ 1389kg', 450000.00, NULL, 6, 'products/515gxIay3tYrbnqLN8TkoL0gFZUFnNEtGkXqFWD9.jpg', '\"[\\\"products\\\\\\/mclaren-750s-1.jpg\\\",\\\"products\\\\\\/mclaren-750s-2.jpg\\\"]\"', 1, 1, 0, '2025-04-20 15:31:52', '2025-04-20 15:33:57'),
(42, 1, 'Bugatti Chiron Super Sport 300+ 2024', 'bugatti-chiron-super-sport-300-2024', 'Siêu xe nhanh nhất thế giới của Bugatti', 'Động cơ W16 8.0L quad-turbo, công suất 1578 mã lực, tốc độ tối đa 490.48 km/h', 4300000.00, NULL, 2, 'products/pfZ3o9RqfRQFVxLEbeNpedB6fiuEj67NLTL2u1Qi.jpg', '\"[\\\"products\\\\\\/bugatti-chiron-ss-1.jpg\\\",\\\"products\\\\\\/bugatti-chiron-ss-2.jpg\\\"]\"', 1, 1, 0, '2025-04-20 15:31:52', '2025-04-20 15:34:03'),
(43, 1, 'Aston Martin Valkyrie 2024', 'aston-martin-valkyrie-2024', 'Siêu xe đường phố với công nghệ F1', 'Động cơ V12 6.5L tự nhiên kết hợp motor điện, công suất 1160 mã lực, trọng lượng chỉ 1030kg', 3200000.00, NULL, 3, 'products/bSjH29wWattSezGQhl3GgdGJqSdfChIp2e0gk35O.jpg', '\"[\\\"products\\\\\\/aston-valkyrie-1.jpg\\\",\\\"products\\\\\\/aston-valkyrie-2.jpg\\\"]\"', 1, 1, 0, '2025-04-20 15:31:52', '2025-04-20 15:59:28'),
(44, 1, 'Mercedes-AMG GT 63 S E Performance 2024', 'mercedes-amg-gt-63-s-e-performance-2024', 'Sedan hiệu suất cao plug-in hybrid mạnh nhất của Mercedes', 'Động cơ V8 4.0L twin-turbo kết hợp motor điện, công suất 843 mã lực, mô-men xoắn 1400 Nm', 198000.00, 189000.00, 10, 'products/zVN6c2kF0AgHhdSD8EIzgMCKClQoE9cyyAguUcWJ.jpg', '\"[\\\"products\\\\\\/mercedes-gt63s-1.jpg\\\",\\\"products\\\\\\/mercedes-gt63s-2.jpg\\\"]\"', 1, 1, 1, '2025-04-20 15:31:52', '2025-04-20 15:34:21'),
(45, 1, 'BMW M5 CS 2024', 'bmw-m5-cs-2024', 'Sedan hiệu suất cao đầu bảng của BMW', 'Động cơ V8 4.4L twin-turbo, công suất 627 mã lực, 0-100km/h trong 3.0 giây', 142000.00, 135000.00, 12, 'products/7oLb2Goi23Cm5n016KD0q9Mx4i7FAXTo1HkYn9UR.jpg', '\"[\\\"products\\\\\\/bmw-m5cs-1.jpg\\\",\\\"products\\\\\\/bmw-m5cs-2.jpg\\\"]\"', 0, 1, 1, '2025-04-20 15:31:52', '2025-04-20 15:34:33'),
(46, 6, 'Porsche Taycan Turbo S 2024', 'porsche-taycan-turbo-s-2024', 'Sedan thể thao thuần điện hiệu suất caohttp://127.0.0.1:8000/admin/products', 'Hai motor điện, công suất 750 mã lực, 0-100km/h trong 2.8 giây, phạm vi hoạt động 405km', 185000.00, NULL, 14, 'products/LkhxdQZq40Qk4AmrYRrfVHuMDaEH8DFysdDVxQaa.jpg', '\"[\\\"products\\\\\\/porsche-taycan-1.jpg\\\",\\\"products\\\\\\/porsche-taycan-2.jpg\\\"]\"', 1, 1, 0, '2025-04-20 15:31:52', '2025-04-21 00:07:31'),
(47, 6, 'Rolls-Royce Spectre 2024', 'rolls-royce-spectre-2024', 'Xe điện siêu sang đầu tiên của Rolls-Royce', 'Hai motor điện, công suất 577 mã lực, nội thất sang trọng bậc nhất thế giới', 420000.00, NULL, 8, 'products/UFSaE1ht0vJTnjaO8938deO4dLyQrVl1NmsbtkpC.jpg', '\"[\\\"products\\\\\\/rolls-spectre-1.jpg\\\",\\\"products\\\\\\/rolls-spectre-2.jpg\\\"]\"', 1, 1, 0, '2025-04-20 15:31:52', '2025-04-20 17:44:47'),
(48, 1, 'Koenigsegg Jesko Absolut 2024', 'koenigsegg-jesko-absolut-2024', 'Siêu xe thương mại nhanh nhất thế giới', 'Động cơ V8 5.0L twin-turbo, công suất 1600 mã lực, tốc độ tối đa lý thuyết 531km/h', 3800000.00, NULL, 2, 'products/BhbhUoOvoYOBhCvU4S3sQR6sttfBaz5sJMGiHttn.jpg', '\"[\\\"products\\\\\\/koenigsegg-jesko-1.jpg\\\",\\\"products\\\\\\/koenigsegg-jesko-2.jpg\\\"]\"', 1, 1, 0, '2025-04-20 15:31:52', '2025-04-20 15:34:59'),
(49, 1, 'Pagani Utopia 2024', 'pagani-utopia-2024', 'Siêu xe thủ công của Pagani với số lượng giới hạn', 'Động cơ V12 6.0L twin-turbo, công suất 852 mã lực, hộp số sàn 7 cấp', 2200000.00, NULL, 3, 'products/h7Gxg844MkmVwA8Cls4Id5A0YYGOvEkq57E1Mf2C.jpg', '\"[\\\"products\\\\\\/pagani-utopia-1.jpg\\\",\\\"products\\\\\\/pagani-utopia-2.jpg\\\"]\"', 1, 1, 0, '2025-04-20 15:31:52', '2025-04-20 15:35:09'),
(50, 1, 'Rimac Nevera 2024', 'rimac-nevera-2024', 'Siêu xe điện nhanh nhất thế giới', 'Bốn motor điện, công suất 1914 mã lực, 0-100km/h trong 1.85 giây', 2400000.00, NULL, 4, 'products/R9PXZc1ChDxcIWn9KLj6tUZS8klhmyHvx3ILk6TW.jpg', '\"[\\\"products\\\\\\/rimac-nevera-1.jpg\\\",\\\"products\\\\\\/rimac-nevera-2.jpg\\\"]\"', 1, 1, 0, '2025-04-20 15:31:52', '2025-04-20 15:35:45'),
(51, 1, 'Bentley Batur 2024', 'bentley-batur-2024', 'Xe sang độc bản của Bentley', 'Động cơ W12 6.0L twin-turbo, công suất 740 mã lực, sản xuất giới hạn 18 chiếc', 1800000.00, NULL, 2, 'products/FZbaudB5IZwZBAYmaBfJkAcm7l7MBVpLpc4kzmdh.jpg', '\"[\\\"products\\\\\\/bentley-batur-1.jpg\\\",\\\"products\\\\\\/bentley-batur-2.jpg\\\"]\"', 1, 1, 0, '2025-04-20 15:31:52', '2025-04-20 15:35:50'),
(52, 1, 'Audi RS e-tron GT 2024', 'audi-rs-e-tron-gt-2024', 'Sedan thể thao điện cao cấp của Audi', 'Hai motor điện, công suất 637 mã lực, 0-100km/h trong 3.3 giây', 145000.00, 139000.00, 9, 'products/NCPWr3t8ELvKiH2BSryxdPipO18qqQ7vIER9gkf3.jpg', '\"[\\\"products\\\\\\/audi-rs-etron-1.jpg\\\",\\\"products\\\\\\/audi-rs-etron-2.jpg\\\"]\"', 0, 1, 1, '2025-04-20 15:31:52', '2025-04-20 19:17:39'),
(53, 1, 'Lucid Air Sapphire 2024', 'lucid-air-sapphire-2024', 'Sedan điện hiệu suất cao của Lucid', 'Ba motor điện, công suất 1200 mã lực, phạm vi hoạt động 640km', 249000.00, NULL, 8, 'products/S7d9gyEueVw4vKXoMBxGPrPyjFJJhjDhXbKSd2UG.jpg', '\"[\\\"products\\\\\\/lucid-sapphire-1.jpg\\\",\\\"products\\\\\\/lucid-sapphire-2.jpg\\\"]\"', 1, 1, 0, '2025-04-20 15:31:52', '2025-04-20 15:36:03'),
(54, 1, 'Maserati MC20 Cielo 2024', 'maserati-mc20-cielo-2024', 'Siêu xe mui trần của Maserati', 'Động cơ V6 3.0L twin-turbo, công suất 621 mã lực, mui cứng có thể gập', 260000.00, 250000.00, 7, 'products/9EoZ0C3KdLpQCZcNggnFJIErEKy5zbjTtfpitfpK.jpg', '\"[\\\"products\\\\\\/maserati-mc20-1.jpg\\\",\\\"products\\\\\\/maserati-mc20-2.jpg\\\"]\"', 1, 1, 1, '2025-04-20 15:31:52', '2025-04-20 15:36:10'),
(55, 1, 'Lotus Evija 2024', 'lotus-evija-2024', 'Siêu xe điện đầu tiên của Lotus', 'Bốn motor điện, công suất 2000 mã lực, phạm vi hoạt động 400km', 2100000.00, NULL, 3, 'products/qSuO1l91POH5My37GkgFQgNL0UPgJtlDbGnVKItr.jpg', '\"[\\\"products\\\\\\/lotus-evija-1.jpg\\\",\\\"products\\\\\\/lotus-evija-2.jpg\\\"]\"', 1, 1, 0, '2025-04-20 15:31:52', '2025-04-20 15:36:16'),
(56, 1, 'Gordon Murray T.50 2024', 'gordon-murray-t50-2024', 'Siêu xe với quạt khí động học độc đáo', 'Động cơ V12 4.0L tự nhiên, công suất 654 mã lực, trọng lượng chỉ 986kg', 3100000.00, NULL, 2, 'products/1TAE6fjugiOa8dckR0ccAsvFNRrYJ0quSXVjjFRk.jpg', '\"[\\\"products\\\\\\/gordon-t50-1.jpg\\\",\\\"products\\\\\\/gordon-t50-2.jpg\\\"]\"', 1, 1, 0, '2025-04-20 15:31:52', '2025-04-20 15:36:24'),
(57, 1, 'Pininfarina Battista 2024', 'pininfarina-battista-2024', 'Siêu xe điện của hãng thiết kế Ý', 'Bốn motor điện, công suất 1900 mã lực, 0-100km/h trong 1.9 giây', 2200000.00, NULL, 4, 'products/GUdOMXmBi83ZHAIEP6x0V5cgoi8xjagf3nuJlAMF.jpg', '\"[\\\"products\\\\\\/pininfarina-battista-1.jpg\\\",\\\"products\\\\\\/pininfarina-battista-2.jpg\\\"]\"', 1, 1, 0, '2025-04-20 15:31:52', '2025-04-20 15:59:28');

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
('0QI9EfAU7CotBMZ0OrsFQWpmyLb7z8WLSsP5xbfq', 18, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiemFNOVRBenhIbTFObm0ya3NHN0tKSmZaZW02amMyNmtXb1gxaTBISCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jYXJ0L2NvdW50Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTg7fQ==', 1745169374);

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
(1, 'Luxury Cars for Every Budget', 'Việc ngồi lên chiếc xe này không khác gì Vua chúa ngồi kiệu, ra đường chó không dám sủa', 'sliders/smgervIOFdzoKlL06D3ZnSl0RFXwKBeN7Va3o0qw.jpg', 'https://shop.vinfastauto.com/vn_vi/dat-coc-xe-vf9.html', 'VinFast VF 9', 1, 2, '2025-04-14 07:50:32', '2025-04-20 16:13:31'),
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
(6, 'User 5', 'user5@example.com', 'profile-images/b9ryl3MxagBZlYXPwP5TQp8UVY88OjOKUzYq245B.jpg', NULL, '$2y$12$TXG2cnF6pdIHAUdvbvgSQO2VEMu4.MlGjaAF1qYf4svhz07hlov7S', NULL, NULL, '2025-04-14 07:50:31', '2025-04-14 22:23:33', 'user', '9876543215', '5 User Street, User City'),
(7, 'User 6', 'user6@example.com', 'profile-images/Vb8S0jPW86HPETt9vfrQyy9p9KYw4b0UC7UEAdCe.jpg', NULL, '$2y$12$qcgMXuWyQy8bqcXz9vN1N.6SmIfJflLQimRQ5R6Zu4bmXCbvA1uk2', NULL, NULL, '2025-04-14 07:50:31', '2025-04-14 22:24:31', 'user', '9876543216', '6 User Street, User City'),
(8, 'User 7', 'user7@example.com', 'profile-images/ozFhlXML3P2gAqvPFlswLUXmGC87RcvZ2yN0lyvS.jpg', NULL, '$2y$12$lsLfUu9c1RV1AcypTbMUju1/Goggo3.SV6OeJoDCBWkfb/0x/lZJ2', NULL, NULL, '2025-04-14 07:50:31', '2025-04-14 22:24:46', 'user', '9876543217', '7 User Street, User City'),
(9, 'Trần Hoàng Dịu Lan', 'user8@example.com', 'profile-images/wJOZYFnzXNCxEJ65qYtHgBjNzXjPEIFtbhhEtRKC.png', NULL, '$2y$12$8EezRPH1i2//hJbZacXdmunTyGcu7TKaSiRHK9XwfOk0LME0DC1g.', NULL, NULL, '2025-04-14 07:50:32', '2025-04-14 22:21:54', 'user', '9876543218', '8 User Street, User City'),
(10, 'User 9', 'user9@example.com', 'profile-images/K4rAHcOvwg8eluTPB1NU7Wkdkz8valr74U3hPn1e.jpg', NULL, '$2y$12$2SG/hyNdzQCQf4BhFxmF/.xkL.kN84YiRcobBzAMdQuDMx9q74D72', NULL, NULL, '2025-04-14 07:50:32', '2025-04-14 22:22:59', 'user', '9876543219', '9 User Street, User City'),
(12, 'Admin', 'test@gmail.com', 'profile-images/Hvl3TkRtyvPQ0uU9BcnaR3nPCZPGOFoLqo6M4jdI.png', NULL, '$2y$12$OScugcojzPxvJ44WASTukuO5.cVU/p1pF96mpSAaq3a2vJdSwuMXe', NULL, 'NX1N1c6EFNFo3G0XLR3Z6LNSiXQGgVoAc5UhWS38DwKHHZzNbKMijXx6uY7B', '2025-04-14 10:02:19', '2025-04-14 22:21:26', 'admin', NULL, NULL),
(13, 'Nguyễn Trần Linh Hương', 'concactaone@gmail.com', 'profile-images/3L5LcB65zYU5gAJyO95wjoZjxOf22gbNBcnJRXYk.png', NULL, '$2y$12$eb7pZqQjgsMCrZ1Sak1b/utBDNoxJxVeFqIBETf0Al2vDV73gZrDa', NULL, 'j99JcKdKLgz6A4DE5ojdhvCQOmNWBxZwoUfIsBpRbqnsx7G3d1DGduQBZr3z', '2025-04-14 20:12:30', '2025-04-14 22:21:03', 'user', NULL, NULL),
(14, 'Linh Lộc Ngự Tiền', 'linhloc@gmail.com', 'profile-images/PpIrZKiOvhnS5e7RUl5fwLQCONFET0QjbjLOU3et.png', NULL, '$2y$12$QE0w5m2vaSBrMfbetzMB..FnGAjgh5bicdBKpPrLMgtSO9cLnoumu', NULL, NULL, '2025-04-14 22:45:13', '2025-04-14 22:45:13', 'user', NULL, NULL),
(16, 'Linh Hoa Nguyệt Huyễn', 'xunuamd@gmail.com', 'profile-images/mEKNVLTUgnZkLF6SxFdbEG4J633VOEWz06ARlqY0.png', NULL, '$2y$12$/Q9vY6Lx5alw7FN7BoqDo.lC5gULBv1.FYtmG01Iy/r6TRae3Xuxu', NULL, 'FVUxuiGga3tn960aEYQTkUlGcnd7Y9VEpRblHiBOKOf5nKLrkAhvONxSQPxi', '2025-04-15 11:13:58', '2025-04-15 18:20:28', 'user', NULL, NULL),
(17, 'Lý Chiêu Hoàng', 'Sukhoi57.244@gmail.com', 'profile-images/Se67zqfXNDNNMpzYIO1XtSoSCYbdtQLcp6IwBOyU.png', NULL, '$2y$12$uOBYZ.hpU6zOVCu5Xp5AWOPSqk/uyFS/3LMZ7EXI9Czc7yIh7Nm8y', NULL, NULL, '2025-04-19 03:45:25', '2025-04-19 03:45:25', 'user', NULL, NULL),
(18, 'Ryzen', 'akhihithangngu@gmail.com', 'avatars/CeJOR34FPnrEShAUAJzs3h5FiyRDARbgYtRMCUMt.png', NULL, '$2y$12$wKTFKFHKrU8SCt.n3TESa.hHbxcgLRoWvVkgJY6rtokcFlt75tce6', NULL, NULL, '2025-04-20 18:11:52', '2025-04-20 23:54:12', 'admin', '0987654321', 'Số 15, Đường Nguyễn Huệ, Phường Bến Nghé, Quận 1');

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
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

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
-- AUTO_INCREMENT cho bảng `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT cho bảng `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

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
