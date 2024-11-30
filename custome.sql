-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.33 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for custome
CREATE DATABASE IF NOT EXISTS `custome` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `custome`;

-- Dumping structure for table custome.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categories_parent_id_foreign` (`parent_id`),
  CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table custome.categories: ~2 rows (approximately)
DELETE FROM `categories`;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`id`, `name`, `image`, `parent_id`, `created_at`, `updated_at`) VALUES
	(10, 'Shirt', 'categories/iiSjTJ0jznsZoSwFMc3VEVlu4Z454NC3hVBIO6ET.png', NULL, '2024-09-19 10:30:59', '2024-09-19 10:40:31'),
	(11, 't-shirt', 'categories/J0weBLAa9pXuItGmktqJux8FupNO1sB7CAKVymON.jpg', 10, '2024-09-19 10:44:19', '2024-09-19 10:48:34'),
	(12, 'Sweet', 'categories/3VYwTdViwyDdQgHqIofnimgfTbbTnJBLOMV4MU81.png', 10, '2024-09-19 10:51:19', '2024-09-19 10:51:19');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

-- Dumping structure for table custome.category
CREATE TABLE IF NOT EXISTS `category` (
  `id_category` int(5) NOT NULL AUTO_INCREMENT,
  `name_category` varchar(50) NOT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table custome.category: ~3 rows (approximately)
DELETE FROM `category`;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` (`id_category`, `name_category`) VALUES
	(1, 'Men'),
	(2, 'Women'),
	(3, 'Kids');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;

-- Dumping structure for table custome.category_types
CREATE TABLE IF NOT EXISTS `category_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sub_category_id` bigint(20) unsigned DEFAULT NULL,
  `type_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_types_sub_category_id_foreign` (`sub_category_id`),
  KEY `category_types_type_id_foreign` (`type_id`),
  CONSTRAINT `category_types_sub_category_id_foreign` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `category_types_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `type_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table custome.category_types: ~4 rows (approximately)
DELETE FROM `category_types`;
/*!40000 ALTER TABLE `category_types` DISABLE KEYS */;
INSERT INTO `category_types` (`id`, `sub_category_id`, `type_id`, `created_at`, `updated_at`) VALUES
	(4, 2, 1, '2024-09-20 18:58:39', '2024-09-20 18:58:39'),
	(6, 3, 1, '2024-09-21 14:51:39', '2024-09-21 14:51:39'),
	(7, 3, 2, '2024-09-21 14:51:39', '2024-09-21 14:51:39'),
	(8, 1, 2, '2024-09-25 11:47:38', '2024-09-25 11:47:38');
/*!40000 ALTER TABLE `category_types` ENABLE KEYS */;

-- Dumping structure for table custome.clients
CREATE TABLE IF NOT EXISTS `clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DOB` date DEFAULT NULL,
  `gender` int(11) DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clients_email_unique` (`email`),
  UNIQUE KEY `clients_phone_unique` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table custome.clients: ~3 rows (approximately)
DELETE FROM `clients`;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` (`id`, `first_name`, `last_name`, `email`, `password`, `DOB`, `gender`, `phone`, `created_at`, `updated_at`) VALUES
	(9, 'islam', 'shublaqq', 'islamshu12@gmail.com', '$2y$12$uIFs38UKoB2sLe3xs1eNUO5raG.I1hfqcgfx2oZB5VqZj12X2Vp8C', '2024-10-16', 1, '+970592722789', '2024-10-08 14:03:40', '2024-10-16 11:04:35'),
	(10, 'محمد', 'شبلاق', 'islamsasashu12@gmail.com', '$2y$12$xFm9FNGQSGesNh8TFc//BesXXAWmS9AMLRO.WbGJYzCFtOU6owZ92', NULL, NULL, '445455445', '2024-10-17 00:24:44', '2024-10-17 00:24:44');
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;

-- Dumping structure for table custome.colors
CREATE TABLE IF NOT EXISTS `colors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table custome.colors: ~2 rows (approximately)
DELETE FROM `colors`;
/*!40000 ALTER TABLE `colors` DISABLE KEYS */;
INSERT INTO `colors` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
	(1, 'Black', '#000000', NULL, '2024-09-12 12:46:34'),
	(5, 'Green', '#0af526', '2024-09-12 12:14:23', '2024-09-12 12:46:57'),
	(6, 'White', '#efebeb', '2024-09-14 11:02:08', '2024-09-14 11:02:08'),
	(7, 'Pink', '#ff00bb', '2024-09-17 10:47:19', '2024-09-17 10:47:19');
/*!40000 ALTER TABLE `colors` ENABLE KEYS */;

-- Dumping structure for table custome.color_product
CREATE TABLE IF NOT EXISTS `color_product` (
  `id_color_product` int(20) NOT NULL AUTO_INCREMENT,
  `item_color` varchar(50) NOT NULL,
  `color_hexa` varchar(6) NOT NULL,
  `cost` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `id_product` int(20) NOT NULL,
  PRIMARY KEY (`id_color_product`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- Dumping data for table custome.color_product: ~15 rows (approximately)
DELETE FROM `color_product`;
/*!40000 ALTER TABLE `color_product` DISABLE KEYS */;
INSERT INTO `color_product` (`id_color_product`, `item_color`, `color_hexa`, `cost`, `title`, `id_product`) VALUES
	(1, '04632', 'ccc', '40000', 'Gray', 1),
	(2, '04601', '35e744', '40000', 'Green', 1),
	(3, '04620', '4534a7', '40000', 'Blue', 1),
	(4, '04639', 'a73443', '40000', 'Red', 1),
	(5, '04600', 'fff', '40000', 'White', 1),
	(6, '06100', 'fff', '45000', 'White', 2),
	(7, '06102', 'eee', '45000', 'Gray', 2),
	(8, '06103', '45e734', '45000', 'Green', 2),
	(9, '06105', '9f2332', '45000', 'Red', 2),
	(10, '06114', '23329f', '45000', 'Blue', 2),
	(11, '119900', 'fff', '80000', 'White', 3),
	(12, '119902', '000', '80000', 'Black', 3),
	(13, '119904', 'd4d4d4', '80000', 'Gray', 3),
	(14, '119906', '9f2332', '80000', 'Red', 3),
	(15, '119918', '67ef11', '80000', 'Lime', 3);
/*!40000 ALTER TABLE `color_product` ENABLE KEYS */;

-- Dumping structure for table custome.discount_codes
CREATE TABLE IF NOT EXISTS `discount_codes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_at` date NOT NULL,
  `end_at` date NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table custome.discount_codes: ~0 rows (approximately)
DELETE FROM `discount_codes`;
/*!40000 ALTER TABLE `discount_codes` DISABLE KEYS */;
INSERT INTO `discount_codes` (`id`, `title`, `start_at`, `end_at`, `code`, `discount_type`, `discount_value`, `created_at`, `updated_at`) VALUES
	(1, 'تجربة', '2024-09-27', '2024-10-29', '89452', 'fixed', '15', '2024-09-27 11:26:30', '2024-09-27 11:37:08');
/*!40000 ALTER TABLE `discount_codes` ENABLE KEYS */;

-- Dumping structure for table custome.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table custome.failed_jobs: ~0 rows (approximately)
DELETE FROM `failed_jobs`;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

-- Dumping structure for table custome.favorites
CREATE TABLE IF NOT EXISTS `favorites` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `favorites_client_id_foreign` (`client_id`),
  KEY `favorites_product_id_foreign` (`product_id`),
  CONSTRAINT `favorites_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `favorites_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table custome.favorites: ~1 rows (approximately)
DELETE FROM `favorites`;
/*!40000 ALTER TABLE `favorites` DISABLE KEYS */;
INSERT INTO `favorites` (`id`, `client_id`, `product_id`, `created_at`, `updated_at`) VALUES
	(6, 9, 30, '2024-10-16 13:58:40', '2024-10-16 13:58:40');
/*!40000 ALTER TABLE `favorites` ENABLE KEYS */;

-- Dumping structure for table custome.font
CREATE TABLE IF NOT EXISTS `font` (
  `id_font` int(20) NOT NULL AUTO_INCREMENT,
  `name_font` varchar(50) NOT NULL,
  `name_style` varchar(50) NOT NULL,
  PRIMARY KEY (`id_font`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table custome.font: ~3 rows (approximately)
DELETE FROM `font`;
/*!40000 ALTER TABLE `font` DISABLE KEYS */;
INSERT INTO `font` (`id_font`, `name_font`, `name_style`) VALUES
	(1, 'Arial', 'Arial'),
	(2, 'Friday Night', 'friday_night_lightsregular'),
	(3, 'Verdana', 'Verdana');
/*!40000 ALTER TABLE `font` ENABLE KEYS */;

-- Dumping structure for table custome.gambar
CREATE TABLE IF NOT EXISTS `gambar` (
  `id_gambar` int(20) NOT NULL AUTO_INCREMENT,
  `folder` varchar(50) NOT NULL,
  `name_gambar` varchar(255) NOT NULL,
  `cost` varchar(50) NOT NULL,
  `id_image_category` int(20) NOT NULL,
  PRIMARY KEY (`id_gambar`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Dumping data for table custome.gambar: ~9 rows (approximately)
DELETE FROM `gambar`;
/*!40000 ALTER TABLE `gambar` DISABLE KEYS */;
INSERT INTO `gambar` (`id_gambar`, `folder`, `name_gambar`, `cost`, `id_image_category`) VALUES
	(1, 'musics', 'guitar1.png', '15000', 1),
	(2, 'musics', 'guitar2.png', '10000', 1),
	(3, 'musics', 'guitar3.png', '20000', 1),
	(4, 'musics', 'guitar4.png', '22500', 1),
	(5, 'musics', 'guitar5.png', '20000', 1),
	(6, 'sports', 'basketball.png', '11500', 2),
	(7, 'sports', 'nba.png', '11000', 2),
	(8, 'sports', 'spalding.png', '13000', 2),
	(9, 'panoramas', 'mountain.jpg', '30000', 3);
/*!40000 ALTER TABLE `gambar` ENABLE KEYS */;

-- Dumping structure for table custome.general_infos
CREATE TABLE IF NOT EXISTS `general_infos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table custome.general_infos: ~7 rows (approximately)
DELETE FROM `general_infos`;
/*!40000 ALTER TABLE `general_infos` DISABLE KEYS */;
INSERT INTO `general_infos` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
	(1, 'website_logo', 'general/qsLNNlkavR4dZHhr7TOBFbT495oAbYJ6OTycdzBt.png', NULL, NULL),
	(2, 'website_icon', 'general/hSYeCEztFxQiGfyrC9ks71gYpEYoAC8fLNRrWieZ.png', NULL, NULL),
	(3, 'website_name', 'Print Logo', NULL, NULL),
	(4, 'website_email', 't-shirmaker@gmail.com', NULL, NULL),
	(5, 'whatsapp_number', '+970592722789', NULL, NULL),
	(6, 'shipping', '0', NULL, NULL),
	(7, 'tax', '0', NULL, NULL);
/*!40000 ALTER TABLE `general_infos` ENABLE KEYS */;

-- Dumping structure for table custome.image_category
CREATE TABLE IF NOT EXISTS `image_category` (
  `id_image_category` int(20) NOT NULL AUTO_INCREMENT,
  `name_image_category` varchar(50) NOT NULL,
  PRIMARY KEY (`id_image_category`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table custome.image_category: ~3 rows (approximately)
DELETE FROM `image_category`;
/*!40000 ALTER TABLE `image_category` DISABLE KEYS */;
INSERT INTO `image_category` (`id_image_category`, `name_image_category`) VALUES
	(1, 'Musics'),
	(2, 'Sports'),
	(3, 'Panoramas');
/*!40000 ALTER TABLE `image_category` ENABLE KEYS */;

-- Dumping structure for table custome.item_category
CREATE TABLE IF NOT EXISTS `item_category` (
  `id_item_category` int(10) NOT NULL AUTO_INCREMENT,
  `name_item_category` varchar(50) NOT NULL,
  `id_category` int(5) NOT NULL,
  PRIMARY KEY (`id_item_category`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table custome.item_category: ~2 rows (approximately)
DELETE FROM `item_category`;
/*!40000 ALTER TABLE `item_category` DISABLE KEYS */;
INSERT INTO `item_category` (`id_item_category`, `name_item_category`, `id_category`) VALUES
	(1, 'T-Shirts', 1),
	(2, 'Sweats', 1);
/*!40000 ALTER TABLE `item_category` ENABLE KEYS */;

-- Dumping structure for table custome.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table custome.migrations: ~20 rows (approximately)
DELETE FROM `migrations`;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(2, '2024_09_09_110401_create_general_infos_table', 1),
	(3, '2014_10_12_000000_create_users_table', 2),
	(4, '2014_10_12_100000_create_password_reset_tokens_table', 2),
	(5, '2019_08_19_000000_create_failed_jobs_table', 2),
	(6, '2024_09_09_112032_add_image_to_users', 3),
	(7, '2024_09_09_121541_create_product_types_table', 4),
	(8, '2024_09_09_121542_create_colors_table', 4),
	(9, '2024_09_09_121542_create_products_table', 4),
	(10, '2024_09_09_121543_create_pens_table', 4),
	(11, '2024_09_09_121543_create_product_colors_table', 4),
	(12, '2024_09_09_121543_create_sizes_table copy 2', 4),
	(13, '2024_09_09_121545_create_product_sizes_table', 4),
	(14, '2024_09_12_161301_create_categories_table', 5),
	(15, '2024_09_14_221238_create_temp_orders_table', 6),
	(16, '2024_09_15_184949_create_temp_orders_table', 7),
	(17, '2024_09_17_204119_create_type_categories_table', 8),
	(18, '2024_09_19_105157_create_sub_categories_table', 9),
	(19, '2024_09_19_143546_add_and_remove_columns_example', 10),
	(20, '2024_09_19_144145_add_attributs_to_sub_categories', 11),
	(21, '2024_09_19_145056_create_category_types_table', 12),
	(22, '2024_09_23_090816_add_attributs_to_products', 13),
	(23, '2024_09_23_091634_add_attributs_to_product_colors', 14),
	(24, '2024_09_24_143431_add_slug_to_products', 15),
	(25, '2024_09_24_144322_add_slug_to_products', 16),
	(26, '2024_09_27_111754_create_discount_codes_table', 17),
	(27, '2024_10_08_074816_create_clients_table', 18),
	(28, '2024_10_14_114445_add_attributs_to_products', 19),
	(29, '2024_10_16_111242_create_favorites_table', 20),
	(30, '2024_10_16_231821_add_attributs_to_products', 21);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table custome.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table custome.password_reset_tokens: ~0 rows (approximately)
DELETE FROM `password_reset_tokens`;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;

-- Dumping structure for table custome.pens
CREATE TABLE IF NOT EXISTS `pens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ink_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(8,2) DEFAULT NULL,
  `pen_image` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `product_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id_forgin` (`product_id`),
  CONSTRAINT `product_id_forgin` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table custome.pens: ~1 rows (approximately)
DELETE FROM `pens`;
/*!40000 ALTER TABLE `pens` DISABLE KEYS */;
/*!40000 ALTER TABLE `pens` ENABLE KEYS */;

-- Dumping structure for table custome.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table custome.personal_access_tokens: ~0 rows (approximately)
DELETE FROM `personal_access_tokens`;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;

-- Dumping structure for table custome.product
CREATE TABLE IF NOT EXISTS `product` (
  `id_product` int(20) NOT NULL AUTO_INCREMENT,
  `item_model` varchar(50) NOT NULL,
  `item_info` text NOT NULL,
  `item_color` varchar(50) NOT NULL,
  `cost` varchar(50) NOT NULL,
  `id_item_category` int(10) NOT NULL,
  PRIMARY KEY (`id_product`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table custome.product: ~0 rows (approximately)
DELETE FROM `product`;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
/*!40000 ALTER TABLE `product` ENABLE KEYS */;

-- Dumping structure for table custome.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_id` bigint(20) unsigned DEFAULT NULL,
  `subcategory_id` bigint(20) unsigned DEFAULT NULL,
  `category_id` bigint(20) unsigned DEFAULT NULL,
  `guidness_pic` longtext COLLATE utf8mb4_unicode_ci,
  `delivery_date` int(11) NOT NULL DEFAULT '5',
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  KEY `FK_products_type_categories` (`type_id`),
  KEY `subcategory_id` (`subcategory_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `FK_products_type_categories` FOREIGN KEY (`type_id`) REFERENCES `type_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `subcategory_id` FOREIGN KEY (`subcategory_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table custome.products: ~1 rows (approximately)
DELETE FROM `products`;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `name`, `slug`, `description`, `price`, `created_at`, `updated_at`, `image`, `type_id`, `subcategory_id`, `category_id`, `guidness_pic`, `delivery_date`) VALUES
	(30, '26656', 'CJRTR94009', 'qwd', 20.00, '2024-10-14 12:04:59', '2024-10-14 12:37:08', 'products/9iIsNMUGDVFsKZFlli7tTlM7IkHds24DoK5qAkwL.png', 1, 2, 11, '["1728908822-men1_blue_back.png","1728908822-men1_blue_front (1).png"]', 5);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

-- Dumping structure for table custome.product_colors
CREATE TABLE IF NOT EXISTS `product_colors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `color_id` bigint(20) unsigned NOT NULL,
  `front_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `back_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_colors_product_id_foreign` (`product_id`),
  KEY `product_colors_color_id_foreign` (`color_id`),
  CONSTRAINT `product_colors_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_colors_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table custome.product_colors: ~2 rows (approximately)
DELETE FROM `product_colors`;
/*!40000 ALTER TABLE `product_colors` DISABLE KEYS */;
INSERT INTO `product_colors` (`id`, `product_id`, `color_id`, `front_image`, `back_image`, `created_at`, `updated_at`, `price`) VALUES
	(56, 30, 1, 'products/7RvaTuJnVSTE4yFHuGsRv76PFsHGS6LxeJO82vDw.png', NULL, '2024-10-16 23:21:18', '2024-10-16 23:21:18', '15');
/*!40000 ALTER TABLE `product_colors` ENABLE KEYS */;

-- Dumping structure for table custome.product_sizes
CREATE TABLE IF NOT EXISTS `product_sizes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `size_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `price` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_sizes_product_id_foreign` (`product_id`),
  KEY `product_sizes_size_id_foreign` (`size_name`) USING BTREE,
  CONSTRAINT `product_sizes_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table custome.product_sizes: ~2 rows (approximately)
DELETE FROM `product_sizes`;
/*!40000 ALTER TABLE `product_sizes` DISABLE KEYS */;
INSERT INTO `product_sizes` (`id`, `product_id`, `size_name`, `price`, `created_at`, `updated_at`) VALUES
	(92, 30, 'XL', 20.00, '2024-10-16 23:21:18', '2024-10-16 23:21:18'),
	(93, 30, 'XXL', 10.00, '2024-10-16 23:21:18', '2024-10-16 23:21:18');
/*!40000 ALTER TABLE `product_sizes` ENABLE KEYS */;

-- Dumping structure for table custome.product_types
CREATE TABLE IF NOT EXISTS `product_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table custome.product_types: ~2 rows (approximately)
DELETE FROM `product_types`;
/*!40000 ALTER TABLE `product_types` DISABLE KEYS */;
INSERT INTO `product_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 't-shirt', NULL, NULL),
	(2, 'pen', NULL, NULL);
/*!40000 ALTER TABLE `product_types` ENABLE KEYS */;

-- Dumping structure for table custome.sizes
CREATE TABLE IF NOT EXISTS `sizes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table custome.sizes: ~7 rows (approximately)
DELETE FROM `sizes`;
/*!40000 ALTER TABLE `sizes` DISABLE KEYS */;
INSERT INTO `sizes` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'sm', NULL, '2024-09-12 12:08:18'),
	(2, 'L', NULL, '2024-09-12 12:08:32'),
	(3, 'XL', NULL, '2024-09-12 12:08:41'),
	(4, 'XXL', '2024-09-12 12:15:27', '2024-09-12 12:15:27'),
	(5, 'XXXL', '2024-09-12 12:17:01', '2024-09-12 12:17:01'),
	(6, 'test', '2024-09-17 10:56:09', '2024-09-17 10:56:09');
/*!40000 ALTER TABLE `sizes` ENABLE KEYS */;

-- Dumping structure for table custome.sub_categories
CREATE TABLE IF NOT EXISTS `sub_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `have_types` int(11) NOT NULL,
  `have_one_image` int(11) NOT NULL,
  `have_two_image` int(11) NOT NULL,
  `attributs` json NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sub_categories_category_id_foreign` (`category_id`),
  CONSTRAINT `sub_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table custome.sub_categories: ~2 rows (approximately)
DELETE FROM `sub_categories`;
/*!40000 ALTER TABLE `sub_categories` DISABLE KEYS */;
INSERT INTO `sub_categories` (`id`, `category_id`, `name`, `image`, `created_at`, `updated_at`, `have_types`, `have_one_image`, `have_two_image`, `attributs`) VALUES
	(1, 12, 'test', 'sub_categories/7ygvthK4eeQApPVdYdyeUlvNHSlQabeE7fZx6mtj.png', '2024-09-19 15:03:22', '2024-09-25 11:47:38', 1, 1, 0, '["sizes", "colors1"]'),
	(2, 11, 'islam shublaq', 'sub_categories/LDhAtDKOVpLeXLpOmEmVE25q5zKra1kPqaCrvnUW.png', '2024-09-19 15:07:27', '2024-09-20 18:58:39', 1, 1, 0, '["sizes", "colors2", "types"]'),
	(3, 12, 'هسمشة', 'sub_categories/52Ko0tbAxqfLc0vpMw6ySMH6PEyhEfSkuvXtJtkE.png', '2024-09-21 14:51:39', '2024-09-21 14:51:39', 1, 0, 0, '["types"]');
/*!40000 ALTER TABLE `sub_categories` ENABLE KEYS */;

-- Dumping structure for table custome.temp_orders
CREATE TABLE IF NOT EXISTS `temp_orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `front_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `back_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_id` bigint(20) unsigned DEFAULT NULL,
  `color_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `design_front` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `design_back` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `matriral` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `temp_orders_product_id_foreign` (`product_id`),
  KEY `temp_orders_color_id_foreign` (`color_id`),
  CONSTRAINT `temp_orders_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE CASCADE,
  CONSTRAINT `temp_orders_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table custome.temp_orders: ~1 rows (approximately)
DELETE FROM `temp_orders`;
/*!40000 ALTER TABLE `temp_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `temp_orders` ENABLE KEYS */;

-- Dumping structure for table custome.type_categories
CREATE TABLE IF NOT EXISTS `type_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table custome.type_categories: ~0 rows (approximately)
DELETE FROM `type_categories`;
/*!40000 ALTER TABLE `type_categories` DISABLE KEYS */;
INSERT INTO `type_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'قماش', '2024-09-17 20:48:51', '2024-09-17 20:52:01'),
	(2, 'بوليستر', '2024-09-17 20:48:51', '2024-09-17 20:52:01');
/*!40000 ALTER TABLE `type_categories` ENABLE KEYS */;

-- Dumping structure for table custome.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'users/defultUser.png',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table custome.users: ~1 rows (approximately)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `image`) VALUES
	(1, 'admin', 'admin@gmail.com', NULL, '$2y$12$wxmIHdZYJoOJ82Y08FToPeY53beTMVkSEc.XOq/7frKYUxQRfLAxO', NULL, '2024-09-09 11:10:58', '2024-09-15 20:58:12', 'users/c0le2AHsbCjnF6rLV9laYXQaXQIWuA0jUxGuALHj.jpg');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
