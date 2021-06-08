-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.3.24-MariaDB - MariaDB Server
-- Server OS:                    Linux
-- HeidiSQL Version:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for u7590166_ice_gentong
CREATE DATABASE IF NOT EXISTS `u7590166_ice_gentong` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `u7590166_ice_gentong`;

-- Dumping structure for table u7590166_ice_gentong.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Berisi nama file image tanpa path',
  `create_by` int(11) NOT NULL,
  `update_by` int(11) DEFAULT NULL,
  `delete_by` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table u7590166_ice_gentong.categories: ~4 rows (approximately)
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`id`, `name`, `slug`, `image_category`, `create_by`, `update_by`, `delete_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 'Deluxe (400ml)', 'deluxe-400ml', 'category_images/dZlKLPJywRf77gTP1AxzNmFrNlfpoZMGjAnsy031.jpeg', 2, 3, NULL, NULL, '2020-10-02 08:54:06', '2020-10-14 07:27:23'),
	(2, 'Special Package', 'special-package', 'category_images/wNiuWa4un9kMz7RuHXrcQVxpwSZEqtbl9IK0kL2v.jpeg', 2, 3, NULL, NULL, '2020-10-02 08:54:29', '2020-10-14 07:28:21'),
	(3, 'Family cup (400ml)', 'family-cup-400ml', 'category_images/tINmnDWii36AcsTvF4OTc04Ewl59yAcecuKvbriz.jpeg', 2, 3, NULL, NULL, '2020-10-02 08:54:58', '2020-10-14 07:29:23'),
	(4, 'Party Cup (60ml)', 'party-cup-60ml', 'category_images/8DWbPZbJhwPMyjAPvaqvFGIPZHJAs1FL2dkaSBJM.jpeg', 2, 3, NULL, NULL, '2020-10-02 08:55:21', '2020-10-14 07:30:39');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

-- Dumping structure for table u7590166_ice_gentong.category_product
CREATE TABLE IF NOT EXISTS `category_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned DEFAULT NULL,
  `category_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_product_product_id_foreign` (`product_id`),
  KEY `category_product_category_id_foreign` (`category_id`),
  CONSTRAINT `category_product_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `category_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table u7590166_ice_gentong.category_product: ~20 rows (approximately)
/*!40000 ALTER TABLE `category_product` DISABLE KEYS */;
INSERT INTO `category_product` (`id`, `product_id`, `category_id`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, NULL, NULL),
	(7, 2, 1, NULL, NULL),
	(8, 3, 1, NULL, NULL),
	(9, 4, 1, NULL, NULL),
	(10, 5, 1, NULL, NULL),
	(11, 6, 1, NULL, NULL),
	(12, 7, 1, NULL, NULL),
	(13, 8, 2, NULL, NULL),
	(14, 9, 2, NULL, NULL),
	(15, 10, 3, NULL, NULL),
	(16, 11, 3, NULL, NULL),
	(17, 12, 3, NULL, NULL),
	(18, 13, 3, NULL, NULL),
	(19, 14, 3, NULL, NULL),
	(20, 15, 3, NULL, NULL),
	(21, 16, 3, NULL, NULL),
	(22, 17, 3, NULL, NULL),
	(23, 18, 3, NULL, NULL),
	(24, 19, 3, NULL, NULL),
	(26, 20, 4, NULL, NULL),
	(27, 21, 4, NULL, NULL),
	(28, 22, 4, NULL, NULL),
	(29, 23, 4, NULL, NULL),
	(30, 24, 4, NULL, NULL),
	(31, 25, 4, NULL, NULL),
	(32, 26, 4, NULL, NULL),
	(33, 27, 4, NULL, NULL),
	(34, 28, 4, NULL, NULL),
	(35, 29, 4, NULL, NULL);
/*!40000 ALTER TABLE `category_product` ENABLE KEYS */;

-- Dumping structure for table u7590166_ice_gentong.customers
CREATE TABLE IF NOT EXISTS `customers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `session` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customers_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table u7590166_ice_gentong.customers: ~0 rows (approximately)
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;

-- Dumping structure for table u7590166_ice_gentong.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table u7590166_ice_gentong.failed_jobs: ~0 rows (approximately)
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

-- Dumping structure for table u7590166_ice_gentong.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table u7590166_ice_gentong.migrations: ~11 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(38, '2014_10_12_000000_create_users_table', 1),
	(39, '2014_10_12_100000_create_password_resets_table', 1),
	(40, '2019_08_19_000000_create_failed_jobs_table', 1),
	(41, '2020_07_04_140929_penyesuaian_table_users', 1),
	(42, '2020_07_15_063013_create_categories_table', 1),
	(43, '2020_09_25_175720_create_products_table', 1),
	(44, '2020_09_26_080203_penyesuaian_table_products', 1),
	(45, '2020_09_26_164807_create_category_product_table', 1),
	(55, '2020_10_09_093227_create_sessions_table', 6),
	(62, '2020_09_28_042214_create_orders_table', 7),
	(63, '2020_09_28_042951_create_order_product_table', 8);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table u7590166_ice_gentong.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `session_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_price` double(11,2) unsigned NOT NULL,
  `invoice_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('SUBMIT','PROCESS','FINISH','CANCEL') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table u7590166_ice_gentong.orders: ~9 rows (approximately)
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` (`id`, `session_id`, `username`, `email`, `address`, `phone`, `total_price`, `invoice_number`, `status`, `created_at`, `updated_at`) VALUES
	(3, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.75 Safari/537.36', 'zuki', 'setyawanzuky@gmail.com', 'solear', '082113464465', 16000.00, '20201012074950', 'SUBMIT', '2020-10-12 07:49:50', '2020-10-12 07:50:42'),
	(4, 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.121 Safari/537.36', 'nadia', 'Nadia.rahmaningtyas@gmail.com', 'wira', '081398269717', 238000.00, '20201012093516', 'SUBMIT', '2020-10-12 09:35:16', '2020-10-12 09:39:12'),
	(5, 'Mozilla/5.0 (Linux; Android 10; SM-A515F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.75 Mobile Safari/537.36', 'Nadia', 'Nadia.Rahmaningtyas@gmail.com', 'Vila Mutiara Jl.Merpati Raya 03/01 No.100, Sawah Baru, Ciputat', '08139826717', 139000.00, '20201012094137', 'SUBMIT', '2020-10-12 09:41:37', '2020-10-12 10:08:45'),
	(6, 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.121 Safari/537.36', NULL, NULL, NULL, NULL, 139000.00, '20201012095930', 'SUBMIT', '2020-10-12 09:59:30', '2020-10-12 09:59:30'),
	(7, 'Mozilla/5.0 (Linux; Android 10; SM-A515F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.75 Mobile Safari/537.36', NULL, NULL, NULL, NULL, 139000.00, '20201012100946', 'SUBMIT', '2020-10-12 10:09:46', '2020-10-12 10:10:04'),
	(11, 'Mozilla/5.0 (Linux; Android 10; SM-P205) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.75 Safari/537.36', 'Yardi', 'yardizhen@gmail.com', 'Sunter Paradise Thp 2 Paradise 13 Blok Q no 26', '0811945891', 278000.00, '20201013090752', 'SUBMIT', '2020-10-13 09:07:52', '2020-10-13 09:08:42'),
	(12, 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_0_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0 Mobile/15E148 Safari/604.1', 'Yardi', 'yardizhen@gmail.com', 'Sunter Paradise', '0811945891', 615000.00, '20201013092923', 'SUBMIT', '2020-10-13 09:29:23', '2020-10-14 06:42:22'),
	(13, 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:81.0) Gecko/20100101 Firefox/81.0', NULL, NULL, NULL, NULL, 139000.00, '20201014064403', 'SUBMIT', '2020-10-14 06:44:03', '2020-10-14 06:44:03'),
	(14, 'Mozilla/5.0 (Linux; Android 9; SM-G950F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.127 Mobile Safari/537.36', 'Test', 'd@k.com', 'Dhdj', '081237472', 139000.00, '20201016104204', 'SUBMIT', '2020-10-16 10:42:04', '2020-10-16 10:42:46'),
	(16, 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.1.2 Mobile/15E148 Safari/604.1', NULL, NULL, NULL, NULL, 278000.00, '20201019015216', 'SUBMIT', '2020-10-19 01:52:16', '2020-10-19 01:52:21'),
	(17, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.75 Safari/537.36', NULL, NULL, NULL, NULL, 556000.00, '20201019061635', 'SUBMIT', '2020-10-19 06:16:35', '2020-10-19 06:49:22');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;

-- Dumping structure for table u7590166_ice_gentong.order_product
CREATE TABLE IF NOT EXISTS `order_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_product_order_id_foreign` (`order_id`),
  KEY `order_product_product_id_foreign` (`product_id`),
  CONSTRAINT `order_product_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `order_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table u7590166_ice_gentong.order_product: ~14 rows (approximately)
/*!40000 ALTER TABLE `order_product` DISABLE KEYS */;
INSERT INTO `order_product` (`id`, `order_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
	(4, 3, 5, 1, '2020-10-12 07:49:50', '2020-10-12 07:49:50'),
	(5, 4, 6, 1, '2020-10-12 09:35:16', '2020-10-12 09:35:16'),
	(6, 4, 1, 1, '2020-10-12 09:35:29', '2020-10-12 09:35:29'),
	(8, 5, 1, 1, '2020-10-12 09:41:46', '2020-10-12 09:41:46'),
	(9, 6, 1, 1, '2020-10-12 09:59:30', '2020-10-12 09:59:30'),
	(11, 7, 1, 1, '2020-10-12 10:09:49', '2020-10-12 10:09:49'),
	(15, 11, 1, 2, '2020-10-13 09:07:52', '2020-10-13 09:08:08'),
	(16, 12, 1, 3, '2020-10-13 09:29:23', '2020-10-13 09:30:13'),
	(17, 12, 3, 2, '2020-10-13 09:29:31', '2020-10-13 09:29:32'),
	(18, 13, 2, 1, '2020-10-14 06:44:03', '2020-10-14 06:44:03'),
	(19, 14, 1, 1, '2020-10-16 10:42:04', '2020-10-16 10:42:04'),
	(21, 16, 1, 2, '2020-10-19 01:52:16', '2020-10-19 01:52:21'),
	(22, 17, 2, 1, '2020-10-19 06:16:35', '2020-10-19 06:49:15'),
	(23, 17, 3, 3, '2020-10-19 06:49:21', '2020-10-19 06:49:22');
/*!40000 ALTER TABLE `order_product` ENABLE KEYS */;

-- Dumping structure for table u7590166_ice_gentong.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table u7590166_ice_gentong.password_resets: ~0 rows (approximately)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Dumping structure for table u7590166_ice_gentong.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(8,2) NOT NULL,
  `stock` int(10) unsigned NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` enum('PUBLISH','DRAFT') COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table u7590166_ice_gentong.products: ~18 rows (approximately)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `Product_name`, `slug`, `description`, `image`, `price`, `stock`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`, `status`) VALUES
	(1, 'Strawberry Marmalade', 'Strawberry Marmalade', 'Deluxe Strawberry Marmalade', 'products-images/T9bqMZHW5kgv15k2gYcFzv0zXefYPJDysmfLz459.jpeg', 139000.00, 10, 2, 3, NULL, '2020-10-02 08:57:20', '2020-10-15 08:53:00', NULL, 'PUBLISH'),
	(2, 'Pistachio with sauce', 'Pistachio with sauce', 'Deluxe Pistachio with sauce', 'products-images/oJl0j92gUlhtxVhfShDNkfLnnLBEyDJD0YhnU7bT.jpeg', 139000.00, 10, 2, 3, NULL, '2020-10-02 08:58:12', '2020-10-15 08:53:55', NULL, 'PUBLISH'),
	(3, 'Soklat Series', 'Soklat Series', 'Soklat Series : Ruby Chocolate', 'products-images/qbIQCbJzNR1ZkwHDiU0SlKpGz2Q4T0oRIyTniGZP.jpeg', 139000.00, 10, 2, 3, NULL, '2020-10-02 08:59:32', '2020-10-15 08:45:43', NULL, 'PUBLISH'),
	(4, 'Soklat Series', 'Soklat Series : White Chocolate', 'Soklat Series : White Chocolate', 'products-images/xuJGeUmrAy4FGB6Jh5yArCLd1sq79oy2x0up47UP.jpeg', 139000.00, 10, 2, 3, NULL, '2020-10-02 09:00:21', '2020-10-15 08:48:28', NULL, 'PUBLISH'),
	(5, 'Soklat Series', 'Soklat Series : Mint Chocolate', 'Soklat Series : Mint Chocolate', 'products-images/lF4kVrMlTqkLeWw7HmkcOQ33haSlZJhkZ5r1C13F.jpeg', 139000.00, 10, 2, 3, NULL, '2020-10-02 09:01:16', '2020-10-15 08:50:15', NULL, 'PUBLISH'),
	(6, 'Soklat Series', 'Soklat Series : Haleznut Heaven', 'Soklat Series : Haleznut Heaven', 'products-images/DfBcN9GAFzP3CoITcO0NNXHa0oG0LdIHtszOKTDT.jpeg', 139000.00, 10, 2, 3, NULL, '2020-10-02 09:02:04', '2020-10-15 08:50:59', NULL, 'PUBLISH'),
	(7, 'Soklat Series', 'soklat-series', 'Soklat Series : Dark Chocolate', 'products-images/H2xLzdEBo3OdS8qHb2sYG67lTCT0M9BB1ChPuKtx.jpeg', 139000.00, 10, 3, 3, NULL, '2020-10-14 08:03:40', '2020-10-15 08:51:40', NULL, 'PUBLISH'),
	(8, 'Special Package', 'special-package', 'Special Package buy 2 get 5', 'products-images/oFN8I7QThoOvG2D1V6KlWC3O5tdlG8QxYjgcoz80.jpeg', 198000.00, 10, 3, NULL, NULL, '2020-10-14 08:05:55', '2020-10-14 08:05:55', NULL, 'PUBLISH'),
	(9, 'Special Package', 'special-package', 'Special Package Double Happiness', 'products-images/0b1rd5oTJ30TtzOKjPp8Wwdsk0ycDWMie7N2m523.jpeg', 199000.00, 10, 3, NULL, NULL, '2020-10-14 08:06:46', '2020-10-14 08:06:46', NULL, 'PUBLISH'),
	(10, 'Avocado', 'avocado', 'Family cup Avocado (400ml)', 'products-images/K5TL3FJVeqN8Ae5d4ZTJ7benWLbT2SfDV9lbHGje.jpeg', 99000.00, 10, 3, 3, NULL, '2020-10-14 08:09:02', '2020-10-15 08:55:44', NULL, 'PUBLISH'),
	(11, 'Chocolate', 'chocolate', 'Family Cup Chocolate (400ml)', 'products-images/7uAMiaT2UJmx4mIacu357psdkFn7T6c8hpCc2lUa.jpeg', 99000.00, 10, 3, 3, NULL, '2020-10-14 08:11:02', '2020-10-15 08:57:17', NULL, 'PUBLISH'),
	(12, 'Coffee', 'coffee', 'Coffee Family Cup Coffee (400ml)', 'products-images/FFEsRN40VXb1D5AsEAt03zHQFsXwrssn6HOOoDK5.jpeg', 99000.00, 10, 3, 3, NULL, '2020-10-14 08:12:03', '2020-10-15 08:58:16', NULL, 'PUBLISH'),
	(13, 'Coconut', 'coconut', 'Family Cup Coconut (400ml)', 'products-images/cWDr2we0iGylw5GHQD6U363NeErElf7VWqUXUe6z.jpeg', 99000.00, 10, 3, 3, NULL, '2020-10-14 08:12:52', '2020-10-15 08:59:08', NULL, 'PUBLISH'),
	(14, 'Cream and cookies', 'cream-and-cookies', 'Family Cup Cream and cookies (400ml)', 'products-images/R0s6LSM4FZtbqrnvrCW1Bgf6hyCzHYW2Csvdz4LV.jpeg', 99000.00, 10, 3, 3, NULL, '2020-10-14 08:24:13', '2020-10-15 08:59:54', NULL, 'PUBLISH'),
	(15, 'Durian', 'durian', 'Family Cup Durian (400ml)', 'products-images/wxx3zcqOG9JmYksoQk7zgwUcDQwVY7eM3wzxEcyC.jpeg', 99000.00, 10, 3, 3, NULL, '2020-10-14 08:24:58', '2020-10-15 09:00:48', NULL, 'PUBLISH'),
	(16, 'Jackfruit (Nangka)', 'jackfruit-nangka', 'Family Cup Jackfruit (Nangka) 400ml', 'products-images/sKrNliA8Lkd5UvZ7kvVhYiHDeAq3BI1dG25d93B0.jpeg', 99000.00, 10, 3, 3, NULL, '2020-10-14 08:26:28', '2020-10-15 09:01:38', NULL, 'PUBLISH'),
	(17, 'Green tea', 'green-tea', 'Family Cup Green tea (400ml)', 'products-images/Er22iBaKy2NpsK63ELxTNLLYaSAlnNVptkuO6AKm.jpeg', 99000.00, 10, 3, 3, NULL, '2020-10-14 08:27:19', '2020-10-15 09:02:52', NULL, 'PUBLISH'),
	(18, 'Strawberry', 'strawberry', 'Family Cup Strawberry (400ml)', 'products-images/IOAfPIr3t4eujD65oe2Nyuen9BIEeYB5WBtyh3oK.jpeg', 99000.00, 10, 3, 3, NULL, '2020-10-14 08:28:07', '2020-10-15 09:03:47', NULL, 'PUBLISH'),
	(19, 'Vanilla', 'vanilla', 'Family Cup Vanilla (400ml)', 'products-images/YtZajqzQenTUdwyryz2wkMLlcYzJuB9PB6fjOjlN.jpeg', 99000.00, 10, 3, 3, NULL, '2020-10-14 08:29:17', '2020-10-15 09:04:34', NULL, 'PUBLISH'),
	(20, 'Avocado', 'avocado', 'Party Cup Avocado (60ml)', 'products-images/QOptEQZ74X9JzSJOA3VfUp5CxTGXN9IYaUEBpCVo.jpeg', 16000.00, 10, 3, 3, NULL, '2020-10-14 08:33:01', '2020-10-15 09:06:05', NULL, 'PUBLISH'),
	(21, 'Chocolate', 'chocolate', 'Party Cup Chocolate (60ml)', 'products-images/FbzWjCgaDhpCxJdfaOSCaFShBJuUJfYXnRrXr2WG.jpeg', 16000.00, 10, 3, 3, NULL, '2020-10-14 08:34:35', '2020-10-15 09:07:22', NULL, 'PUBLISH'),
	(22, 'Coffee', 'coffee', 'Party Cup Coffee (60ml)', 'products-images/Hwe5XaRegjuw4Ve9b6NizmWE7QKIeRaFI0G3Kmne.jpeg', 16000.00, 10, 3, 3, NULL, '2020-10-14 08:35:32', '2020-10-15 09:08:23', NULL, 'PUBLISH'),
	(23, 'Coconut', 'coconut', 'Party Cup Coconut (60ml)', 'products-images/zPGJXYkkHGEBm3NiTecPJGmckQLTegqjTmnSfMXU.jpeg', 16000.00, 10, 3, 3, NULL, '2020-10-14 08:36:19', '2020-10-15 09:09:22', NULL, 'PUBLISH'),
	(24, 'Cream and cookies', 'cream-and-cookies', 'Party Cup Cream and cookies (60ml)', 'products-images/QRJ4iruebRMgUzPN22jcdG7YJ3JjFp3fEzWjS9OJ.jpeg', 16000.00, 10, 3, 3, NULL, '2020-10-14 08:37:24', '2020-10-15 09:10:20', NULL, 'PUBLISH'),
	(25, 'Durian', 'durian', 'Party Cup Durian (60ml)', 'products-images/DjAfYHCyjVuYp5anw83KfzUN8nBU1RBmwa3YvuE8.jpeg', 16000.00, 10, 3, 3, NULL, '2020-10-14 08:38:26', '2020-10-15 09:11:15', NULL, 'PUBLISH'),
	(26, 'Jackfruit (Nangka)', 'jackfruit-nangka', 'Party Cup Jackfruit (Nangka) 60ml', 'products-images/0jHutumq08iNl9swPGSy6Kgvx43zI8kU1H01Omfh.jpeg', 16000.00, 10, 3, 3, NULL, '2020-10-14 08:39:14', '2020-10-15 09:12:03', NULL, 'PUBLISH'),
	(27, 'Green tea', 'green-tea', 'Party Cup Green tea (60ml)', 'products-images/0Bx5SaBzCy95YVyATZfHISYp4PlElrrlUlrhrio0.jpeg', 16000.00, 10, 3, 3, NULL, '2020-10-14 08:40:01', '2020-10-15 09:12:52', NULL, 'PUBLISH'),
	(28, 'Strawberry', 'strawberry', 'Party Cup  Strawberry (60ml)', 'products-images/3chcbAOxtiDQVhpGD7lQes2rpWVrlWytp9mxroqz.jpeg', 16000.00, 10, 3, 3, NULL, '2020-10-14 08:40:46', '2020-10-15 09:13:34', NULL, 'PUBLISH'),
	(29, 'Vanilla', 'vanilla', 'Party Cup Vanilla (60ml)', 'products-images/Py47qdwgpCs98N26XXzLATBhIjVZEb8AztFTL7dS.jpeg', 16000.00, 10, 3, 3, NULL, '2020-10-14 08:41:36', '2020-10-15 09:14:17', NULL, 'PUBLISH');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

-- Dumping structure for table u7590166_ice_gentong.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  UNIQUE KEY `sessions_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table u7590166_ice_gentong.sessions: ~1 rows (approximately)
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('Dc7YoV1I9WfSDBWuz4GFu2vOFTJUCsWtocISVU8f', 3, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.75 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiN3ByRzl3SDE5V2pBc0p4OTdFZjZTd2xQeUJkTHpGR3ZIeDRoYnR5eCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODA4MC9pY2UtZ2VudG9uZy9vcmRlcnMiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozO30=', 1602486969);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;

-- Dumping structure for table u7590166_ice_gentong.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roles` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table u7590166_ice_gentong.users: ~0 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `username`, `roles`, `address`, `phone`, `avatar`, `status`) VALUES
	(3, 'Admin', 'administrator@admin.com', NULL, '$2y$10$XhqKkS/QcqKtlBmky6l5QOEQ7ICSHoF6ZQ9kpYgNq1KBh2t7C/azy', NULL, '2020-10-03 22:00:14', '2020-10-03 22:00:14', 'Admin', 'ADMIN', 'Jakarta', '082118282828', 'avatars/V9pmCpajJNxsBawF8mQWtVdOKccbojzSvc5PWqe8.png', 'ACTIVE');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
