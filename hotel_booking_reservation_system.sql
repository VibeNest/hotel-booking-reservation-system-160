-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2026 at 11:13 AM
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
-- Database: `hotel_booking_reservation_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_ons`
--

CREATE TABLE `add_ons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `add_ons`
--

INSERT INTO `add_ons` (`id`, `name`, `price`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Breakfast Buffet', 40.00, 'Rất ngon', '2026-06-25 21:15:15', '2026-06-25 21:38:41'),
(2, 'Extra Bed', 20.00, 'Giường êm ái', '2026-06-25 21:37:57', '2026-06-25 21:37:57');

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `category_name`, `category_slug`, `created_at`, `updated_at`) VALUES
(1, 'Travel Destinations', 'travel-destinations', NULL, '2026-06-09 08:43:08'),
(2, 'Luxury Hotels', 'luxury-hotels', NULL, NULL),
(3, 'Boutique Hotels', 'boutique-hotels', NULL, NULL),
(4, 'Travel Tips and Hacks', 'travel-tips-and-hacks', NULL, NULL),
(5, 'Hotel Reviews', 'hotel-reviews', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `blog_cat_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_slug` varchar(255) NOT NULL,
  `post_image` varchar(255) NOT NULL,
  `short_desc` text NOT NULL,
  `long_desc` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `blog_cat_id`, `user_id`, `post_title`, `post_slug`, `post_image`, `short_desc`, `long_desc`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Hotel Management is the Best Issue', 'hotel-management-is-the-best-issue', 'upload/posts/1867587422391369.jpg', 'This is one of the best & quality full hotels in the world that will help you to make an excellent study market.', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore</p>\r\n<p>Ecespiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quci velit modi tempora incidunt ut labore et dolore magnam aliquam quaerat .</p>', '2026-06-10 07:09:46', '2026-06-10 07:09:46'),
(2, 2, 1, 'Hotel Management is the Best Policy', 'hotel-management-is-the-best-policy', 'upload/posts/1867597939978147.jpg', 'This is one of the best & quality full hotels in the world that will help you to make an excellent study market.', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore</p>\r\n<p>Ecespiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quci velit modi tempora incidunt ut labore et dolore magnam aliquam quaerat .</p>', '2026-06-10 07:08:45', '2026-06-10 07:08:45'),
(4, 1, 1, '3d Hotel Models Have an Important Model', '3d-hotel-models-have-an-important-model', 'upload/posts/1867614874045465.jpg', 'This is one of the best & quality full hotels in the world that will help you to make an excellent study market.', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore</p>\r\n<p>Ecespiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quci velit modi tempora incidunt ut labore et dolore magnam aliquam quaerat .</p>', '2026-06-10 22:00:35', '2026-06-10 22:00:35'),
(5, 3, 1, 'How to Decorate a Small Living Room | Houzz', 'how-to-decorate-a-small-living-room-|-houzz', 'upload/posts/1867618810544763.jpg', 'This is one of the best & quality full hotels in the world that will help you to make an excellent study market.', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore</p>\r\n<p>Ecespiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quci velit modi tempora incidunt ut labore et dolore magnam aliquam quaerat .</p>', '2026-06-10 07:01:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rooms_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `check_in` varchar(255) DEFAULT NULL,
  `check_out` varchar(255) DEFAULT NULL,
  `person` varchar(255) DEFAULT NULL,
  `number_of_rooms` varchar(255) DEFAULT NULL,
  `total_night` int(11) NOT NULL DEFAULT 0,
  `actual_price` double NOT NULL DEFAULT 0,
  `subtotal` double NOT NULL DEFAULT 0,
  `discount` int(11) NOT NULL DEFAULT 0,
  `total_price` double NOT NULL DEFAULT 0,
  `payment_method` varchar(255) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `payment_status` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_room_lists`
--

CREATE TABLE `booking_room_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `room_number_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `book_areas`
--

CREATE TABLE `book_areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sub_title` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `link_url` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `book_areas`
--

INSERT INTO `book_areas` (`id`, `sub_title`, `title`, `description`, `link_url`, `image`, `created_at`, `updated_at`) VALUES
(1, 'MAKE A QUICK BOOKING', 'We Are the Best in All-time & So Please Get a Quick Booking', 'Atoli is one of the best resorts in the global market and that\'s why you will get a luxury life period on the global market. We always provide you a special support for all of our guests and that\'s will be the main reason to be the most popular.', 'http://127.0.0.1:8000/booking', 'upload/book_area/1867619102301127.jpg', '2026-06-10 07:06:11', '2026-06-21 07:23:06');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('hotel-booking-reservation-system-cache-boost.roster.scan', 'a:2:{s:6:\"roster\";O:21:\"Laravel\\Roster\\Roster\":3:{s:13:\"\0*\0approaches\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:11:\"\0*\0packages\";O:32:\"Laravel\\Roster\\PackageCollection\":2:{s:8:\"\0*\0items\";a:10:{i:0;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:5:\"^12.0\";s:10:\"\0*\0package\";E:37:\"Laravel\\Roster\\Enums\\Packages:LARAVEL\";s:14:\"\0*\0packageName\";s:17:\"laravel/framework\";s:10:\"\0*\0version\";s:7:\"12.59.0\";s:6:\"\0*\0dev\";b:0;}i:1;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:7:\"v0.3.17\";s:10:\"\0*\0package\";E:37:\"Laravel\\Roster\\Enums\\Packages:PROMPTS\";s:14:\"\0*\0packageName\";s:15:\"laravel/prompts\";s:10:\"\0*\0version\";s:6:\"0.3.17\";s:6:\"\0*\0dev\";b:0;}i:2;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:1:\"*\";s:10:\"\0*\0package\";E:36:\"Laravel\\Roster\\Enums\\Packages:BREEZE\";s:14:\"\0*\0packageName\";s:14:\"laravel/breeze\";s:10:\"\0*\0version\";s:5:\"2.4.1\";s:6:\"\0*\0dev\";b:1;}i:3;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:6:\"v0.5.9\";s:10:\"\0*\0package\";E:33:\"Laravel\\Roster\\Enums\\Packages:MCP\";s:14:\"\0*\0packageName\";s:11:\"laravel/mcp\";s:10:\"\0*\0version\";s:5:\"0.5.9\";s:6:\"\0*\0dev\";b:1;}i:4;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:5:\"^1.24\";s:10:\"\0*\0package\";E:34:\"Laravel\\Roster\\Enums\\Packages:PINT\";s:14:\"\0*\0packageName\";s:12:\"laravel/pint\";s:10:\"\0*\0version\";s:6:\"1.29.1\";s:6:\"\0*\0dev\";b:1;}i:5;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:5:\"^1.41\";s:10:\"\0*\0package\";E:34:\"Laravel\\Roster\\Enums\\Packages:SAIL\";s:14:\"\0*\0packageName\";s:12:\"laravel/sail\";s:10:\"\0*\0version\";s:6:\"1.59.0\";s:6:\"\0*\0dev\";b:1;}i:6;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:1:\"*\";s:10:\"\0*\0package\";E:34:\"Laravel\\Roster\\Enums\\Packages:PEST\";s:14:\"\0*\0packageName\";s:12:\"pestphp/pest\";s:10:\"\0*\0version\";s:5:\"3.8.6\";s:6:\"\0*\0dev\";b:1;}i:7;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:7:\"11.5.50\";s:10:\"\0*\0package\";E:37:\"Laravel\\Roster\\Enums\\Packages:PHPUNIT\";s:14:\"\0*\0packageName\";s:15:\"phpunit/phpunit\";s:10:\"\0*\0version\";s:7:\"11.5.50\";s:6:\"\0*\0dev\";b:1;}i:8;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:10:\"\0*\0package\";E:38:\"Laravel\\Roster\\Enums\\Packages:ALPINEJS\";s:14:\"\0*\0packageName\";s:8:\"alpinejs\";s:10:\"\0*\0version\";s:6:\"3.15.8\";s:6:\"\0*\0dev\";b:1;}i:9;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:10:\"\0*\0package\";E:41:\"Laravel\\Roster\\Enums\\Packages:TAILWINDCSS\";s:14:\"\0*\0packageName\";s:11:\"tailwindcss\";s:10:\"\0*\0version\";s:5:\"4.2.2\";s:6:\"\0*\0dev\";b:1;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:21:\"\0*\0nodePackageManager\";E:43:\"Laravel\\Roster\\Enums\\NodePackageManager:NPM\";}s:9:\"timestamp\";i:1781857014;}', 1781943414),
('hotel-booking-reservation-system-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:5:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"group_name\";s:1:\"d\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:99:{i:0;a:5:{s:1:\"a\";i:1;s:1:\"b\";s:9:\"team.menu\";s:1:\"c\";s:16:\"Teams Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:1;a:5:{s:1:\"a\";i:3;s:1:\"b\";s:9:\"team.view\";s:1:\"c\";s:16:\"Teams Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:2;a:5:{s:1:\"a\";i:4;s:1:\"b\";s:11:\"team.create\";s:1:\"c\";s:16:\"Teams Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:3;a:5:{s:1:\"a\";i:5;s:1:\"b\";s:11:\"team.update\";s:1:\"c\";s:16:\"Teams Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:4;a:5:{s:1:\"a\";i:6;s:1:\"b\";s:11:\"team.delete\";s:1:\"c\";s:16:\"Teams Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:5;a:5:{s:1:\"a\";i:7;s:1:\"b\";s:16:\"testimonial.menu\";s:1:\"c\";s:22:\"Testimonial Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:6;a:5:{s:1:\"a\";i:8;s:1:\"b\";s:16:\"testimonial.view\";s:1:\"c\";s:22:\"Testimonial Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:7;a:5:{s:1:\"a\";i:9;s:1:\"b\";s:18:\"testimonial.create\";s:1:\"c\";s:22:\"Testimonial Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:8;a:5:{s:1:\"a\";i:10;s:1:\"b\";s:16:\"testimonial.edit\";s:1:\"c\";s:22:\"Testimonial Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:9;a:5:{s:1:\"a\";i:11;s:1:\"b\";s:18:\"testimonial.delete\";s:1:\"c\";s:22:\"Testimonial Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:10;a:5:{s:1:\"a\";i:12;s:1:\"b\";s:14:\"book.area.menu\";s:1:\"c\";s:20:\"Book Area Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:11;a:5:{s:1:\"a\";i:14;s:1:\"b\";s:9:\"team.edit\";s:1:\"c\";s:16:\"Teams Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:12;a:5:{s:1:\"a\";i:15;s:1:\"b\";s:18:\"testimonial.update\";s:1:\"c\";s:22:\"Testimonial Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:13;a:5:{s:1:\"a\";i:16;s:1:\"b\";s:18:\"blog.category.view\";s:1:\"c\";s:4:\"Blog\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:14;a:5:{s:1:\"a\";i:17;s:1:\"b\";s:20:\"blog.category.create\";s:1:\"c\";s:4:\"Blog\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:15;a:5:{s:1:\"a\";i:18;s:1:\"b\";s:18:\"blog.category.edit\";s:1:\"c\";s:4:\"Blog\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:16;a:5:{s:1:\"a\";i:19;s:1:\"b\";s:20:\"blog.category.delete\";s:1:\"c\";s:4:\"Blog\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:17;a:5:{s:1:\"a\";i:20;s:1:\"b\";s:14:\"blog.post.view\";s:1:\"c\";s:4:\"Blog\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:18;a:5:{s:1:\"a\";i:21;s:1:\"b\";s:16:\"blog.post.create\";s:1:\"c\";s:4:\"Blog\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:19;a:5:{s:1:\"a\";i:22;s:1:\"b\";s:14:\"blog.post.edit\";s:1:\"c\";s:4:\"Blog\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:20;a:5:{s:1:\"a\";i:23;s:1:\"b\";s:16:\"blog.post.delete\";s:1:\"c\";s:4:\"Blog\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:21;a:5:{s:1:\"a\";i:24;s:1:\"b\";s:12:\"comment.view\";s:1:\"c\";s:18:\"Comment Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:22;a:5:{s:1:\"a\";i:25;s:1:\"b\";s:15:\"comment.approve\";s:1:\"c\";s:18:\"Comment Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:23;a:5:{s:1:\"a\";i:26;s:1:\"b\";s:13:\"comment.reply\";s:1:\"c\";s:18:\"Comment Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:24;a:5:{s:1:\"a\";i:27;s:1:\"b\";s:14:\"comment.delete\";s:1:\"c\";s:18:\"Comment Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:25;a:5:{s:1:\"a\";i:28;s:1:\"b\";s:14:\"book.area.view\";s:1:\"c\";s:20:\"Book Area Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:26;a:5:{s:1:\"a\";i:29;s:1:\"b\";s:16:\"book.area.create\";s:1:\"c\";s:20:\"Book Area Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:27;a:5:{s:1:\"a\";i:30;s:1:\"b\";s:14:\"book.area.edit\";s:1:\"c\";s:20:\"Book Area Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:28;a:5:{s:1:\"a\";i:31;s:1:\"b\";s:16:\"book.area.update\";s:1:\"c\";s:20:\"Book Area Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:29;a:5:{s:1:\"a\";i:32;s:1:\"b\";s:16:\"book.area.delete\";s:1:\"c\";s:20:\"Book Area Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:30;a:5:{s:1:\"a\";i:33;s:1:\"b\";s:12:\"gallery.view\";s:1:\"c\";s:13:\"Hotel Gallery\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:31;a:5:{s:1:\"a\";i:34;s:1:\"b\";s:14:\"gallery.create\";s:1:\"c\";s:13:\"Hotel Gallery\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:32;a:5:{s:1:\"a\";i:35;s:1:\"b\";s:12:\"gallery.edit\";s:1:\"c\";s:13:\"Hotel Gallery\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:33;a:5:{s:1:\"a\";i:36;s:1:\"b\";s:14:\"gallery.delete\";s:1:\"c\";s:13:\"Hotel Gallery\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:34;a:5:{s:1:\"a\";i:37;s:1:\"b\";s:14:\"room.type.view\";s:1:\"c\";s:20:\"Room Type Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:35;a:5:{s:1:\"a\";i:38;s:1:\"b\";s:16:\"room.type.create\";s:1:\"c\";s:20:\"Room Type Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:36;a:5:{s:1:\"a\";i:39;s:1:\"b\";s:14:\"room.type.edit\";s:1:\"c\";s:20:\"Room Type Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:37;a:5:{s:1:\"a\";i:40;s:1:\"b\";s:16:\"room.type.update\";s:1:\"c\";s:20:\"Room Type Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:38;a:5:{s:1:\"a\";i:41;s:1:\"b\";s:16:\"room.type.delete\";s:1:\"c\";s:20:\"Room Type Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:39;a:5:{s:1:\"a\";i:42;s:1:\"b\";s:12:\"booking.view\";s:1:\"c\";s:7:\"Booking\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:40;a:5:{s:1:\"a\";i:43;s:1:\"b\";s:14:\"booking.create\";s:1:\"c\";s:7:\"Booking\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:41;a:5:{s:1:\"a\";i:44;s:1:\"b\";s:12:\"booking.edit\";s:1:\"c\";s:7:\"Booking\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:42;a:5:{s:1:\"a\";i:45;s:1:\"b\";s:14:\"booking.update\";s:1:\"c\";s:7:\"Booking\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:43;a:5:{s:1:\"a\";i:46;s:1:\"b\";s:14:\"booking.delete\";s:1:\"c\";s:7:\"Booking\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:44;a:5:{s:1:\"a\";i:47;s:1:\"b\";s:14:\"booking.detail\";s:1:\"c\";s:7:\"Booking\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:45;a:5:{s:1:\"a\";i:48;s:1:\"b\";s:14:\"room.list.view\";s:1:\"c\";s:20:\"Room List Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:46;a:5:{s:1:\"a\";i:49;s:1:\"b\";s:16:\"room.list.create\";s:1:\"c\";s:20:\"Room List Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:47;a:5:{s:1:\"a\";i:50;s:1:\"b\";s:14:\"room.list.edit\";s:1:\"c\";s:20:\"Room List Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:48;a:5:{s:1:\"a\";i:51;s:1:\"b\";s:16:\"room.list.update\";s:1:\"c\";s:20:\"Room List Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:49;a:5:{s:1:\"a\";i:52;s:1:\"b\";s:16:\"room.list.delete\";s:1:\"c\";s:20:\"Room List Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:50;a:5:{s:1:\"a\";i:53;s:1:\"b\";s:19:\"booking.report.view\";s:1:\"c\";s:14:\"Booking Report\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:51;a:5:{s:1:\"a\";i:54;s:1:\"b\";s:21:\"booking.report.export\";s:1:\"c\";s:14:\"Booking Report\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:52;a:5:{s:1:\"a\";i:55;s:1:\"b\";s:21:\"booking.report.filter\";s:1:\"c\";s:14:\"Booking Report\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:53;a:5:{s:1:\"a\";i:56;s:1:\"b\";s:15:\"permission.view\";s:1:\"c\";s:19:\"Role and Permission\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:54;a:5:{s:1:\"a\";i:57;s:1:\"b\";s:17:\"permission.create\";s:1:\"c\";s:19:\"Role and Permission\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:55;a:5:{s:1:\"a\";i:58;s:1:\"b\";s:15:\"permission.edit\";s:1:\"c\";s:19:\"Role and Permission\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:56;a:5:{s:1:\"a\";i:59;s:1:\"b\";s:17:\"permission.delete\";s:1:\"c\";s:19:\"Role and Permission\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:57;a:5:{s:1:\"a\";i:60;s:1:\"b\";s:9:\"role.view\";s:1:\"c\";s:19:\"Role and Permission\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:58;a:5:{s:1:\"a\";i:61;s:1:\"b\";s:11:\"role.create\";s:1:\"c\";s:19:\"Role and Permission\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:59;a:5:{s:1:\"a\";i:62;s:1:\"b\";s:9:\"role.edit\";s:1:\"c\";s:19:\"Role and Permission\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:60;a:5:{s:1:\"a\";i:63;s:1:\"b\";s:11:\"role.delete\";s:1:\"c\";s:19:\"Role and Permission\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:61;a:5:{s:1:\"a\";i:64;s:1:\"b\";s:11:\"role.assign\";s:1:\"c\";s:19:\"Role and Permission\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:62;a:5:{s:1:\"a\";i:65;s:1:\"b\";s:20:\"contact.message.view\";s:1:\"c\";s:7:\"Contact\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:63;a:5:{s:1:\"a\";i:66;s:1:\"b\";s:22:\"contact.message.detail\";s:1:\"c\";s:7:\"Contact\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:64;a:5:{s:1:\"a\";i:67;s:1:\"b\";s:21:\"contact.message.reply\";s:1:\"c\";s:7:\"Contact\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:65;a:5:{s:1:\"a\";i:68;s:1:\"b\";s:22:\"contact.message.delete\";s:1:\"c\";s:7:\"Contact\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:66;a:5:{s:1:\"a\";i:69;s:1:\"b\";s:17:\"smtp.setting.view\";s:1:\"c\";s:7:\"Setting\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:67;a:5:{s:1:\"a\";i:70;s:1:\"b\";s:19:\"smtp.setting.update\";s:1:\"c\";s:7:\"Setting\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:68;a:5:{s:1:\"a\";i:71;s:1:\"b\";s:17:\"site.setting.view\";s:1:\"c\";s:7:\"Setting\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:69;a:5:{s:1:\"a\";i:72;s:1:\"b\";s:19:\"site.setting.update\";s:1:\"c\";s:7:\"Setting\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:70;a:5:{s:1:\"a\";i:73;s:1:\"b\";s:14:\"dashboard.view\";s:1:\"c\";s:9:\"Dashboard\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:71;a:5:{s:1:\"a\";i:74;s:1:\"b\";s:9:\"blog.menu\";s:1:\"c\";s:4:\"Blog\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:72;a:5:{s:1:\"a\";i:75;s:1:\"b\";s:12:\"comment.menu\";s:1:\"c\";s:18:\"Comment Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:73;a:5:{s:1:\"a\";i:76;s:1:\"b\";s:12:\"gallery.menu\";s:1:\"c\";s:13:\"Hotel Gallery\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:74;a:5:{s:1:\"a\";i:77;s:1:\"b\";s:14:\"room.type.menu\";s:1:\"c\";s:20:\"Room Type Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:75;a:5:{s:1:\"a\";i:78;s:1:\"b\";s:10:\"addon.menu\";s:1:\"c\";s:27:\"Add-ons Facility Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:76;a:5:{s:1:\"a\";i:79;s:1:\"b\";s:10:\"addon.view\";s:1:\"c\";s:27:\"Add-ons Facility Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:77;a:5:{s:1:\"a\";i:80;s:1:\"b\";s:12:\"addon.create\";s:1:\"c\";s:27:\"Add-ons Facility Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:78;a:5:{s:1:\"a\";i:81;s:1:\"b\";s:10:\"addon.edit\";s:1:\"c\";s:27:\"Add-ons Facility Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:79;a:5:{s:1:\"a\";i:82;s:1:\"b\";s:12:\"addon.delete\";s:1:\"c\";s:27:\"Add-ons Facility Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:80;a:5:{s:1:\"a\";i:83;s:1:\"b\";s:10:\"admin.menu\";s:1:\"c\";s:12:\"Manage Admin\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:81;a:5:{s:1:\"a\";i:84;s:1:\"b\";s:10:\"admin.view\";s:1:\"c\";s:12:\"Manage Admin\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:82;a:5:{s:1:\"a\";i:85;s:1:\"b\";s:12:\"admin.create\";s:1:\"c\";s:12:\"Manage Admin\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:83;a:5:{s:1:\"a\";i:86;s:1:\"b\";s:10:\"admin.edit\";s:1:\"c\";s:12:\"Manage Admin\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:84;a:5:{s:1:\"a\";i:87;s:1:\"b\";s:12:\"admin.delete\";s:1:\"c\";s:12:\"Manage Admin\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:85;a:5:{s:1:\"a\";i:88;s:1:\"b\";s:12:\"booking.menu\";s:1:\"c\";s:7:\"Booking\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:86;a:5:{s:1:\"a\";i:89;s:1:\"b\";s:14:\"room.list.menu\";s:1:\"c\";s:20:\"Room List Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:87;a:5:{s:1:\"a\";i:90;s:1:\"b\";s:19:\"booking.report.menu\";s:1:\"c\";s:14:\"Booking Report\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:88;a:5:{s:1:\"a\";i:91;s:1:\"b\";s:15:\"permission.menu\";s:1:\"c\";s:19:\"Role and Permission\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:89;a:5:{s:1:\"a\";i:92;s:1:\"b\";s:20:\"contact.message.menu\";s:1:\"c\";s:7:\"Contact\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:90;a:5:{s:1:\"a\";i:93;s:1:\"b\";s:12:\"setting.menu\";s:1:\"c\";s:7:\"Setting\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:91;a:5:{s:1:\"a\";i:94;s:1:\"b\";s:17:\"permission.import\";s:1:\"c\";s:19:\"Role and Permission\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:92;a:5:{s:1:\"a\";i:95;s:1:\"b\";s:17:\"permission.export\";s:1:\"c\";s:19:\"Role and Permission\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:93;a:5:{s:1:\"a\";i:96;s:1:\"b\";s:13:\"customer.menu\";s:1:\"c\";s:19:\"Customer Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:94;a:5:{s:1:\"a\";i:97;s:1:\"b\";s:15:\"customer.create\";s:1:\"c\";s:19:\"Customer Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:95;a:5:{s:1:\"a\";i:98;s:1:\"b\";s:13:\"customer.edit\";s:1:\"c\";s:19:\"Customer Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:96;a:5:{s:1:\"a\";i:99;s:1:\"b\";s:15:\"customer.update\";s:1:\"c\";s:19:\"Customer Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:97;a:5:{s:1:\"a\";i:100;s:1:\"b\";s:13:\"customer.view\";s:1:\"c\";s:19:\"Customer Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:98;a:5:{s:1:\"a\";i:101;s:1:\"b\";s:15:\"customer.delete\";s:1:\"c\";s:19:\"Customer Management\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}}s:5:\"roles\";a:4:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:11:\"Super Admin\";s:1:\"d\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:5:\"Admin\";s:1:\"d\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:12:\"Receptionist\";s:1:\"d\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";i:4;s:1:\"b\";s:7:\"Manager\";s:1:\"d\";s:3:\"web\";}}}', 1782982305);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `post_id`, `message`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 4, 'Bài post này hay quá!', '1', '2026-06-11 07:32:52', '2026-06-13 01:53:39'),
(2, 3, 4, 'Bài post này tuyệt vời quá!', '1', '2026-06-13 00:48:28', '2026-06-13 01:54:47');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `subject` text NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `phone`, `subject`, `message`, `created_at`, `updated_at`) VALUES
(1, 'Thanh Tùng', 'tung@gmail.com', '0376734165', 'Tôi cần giúp đỡ', 'Tôi đặt phòng nhưng hệ thống bị lỗi. Bạn kiểm tra giúp tôi xem', '2026-06-16 21:53:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rooms_id` int(11) NOT NULL,
  `facility_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `rooms_id`, `facility_name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Wake-up service', '2026-06-06 02:55:09', '2026-06-06 02:55:09'),
(2, 1, 'Hair dryer', '2026-06-06 02:55:09', '2026-06-06 02:55:09'),
(3, 1, 'Rain Shower', '2026-06-06 02:55:09', '2026-06-06 02:55:09'),
(8, 2, 'Hair dryer', '2026-06-21 07:41:35', '2026-06-21 07:41:35'),
(9, 2, 'Wake-up service', '2026-06-21 07:41:35', '2026-06-21 07:41:35'),
(10, 3, 'Hair dryer', '2026-06-29 02:33:16', '2026-06-29 02:33:16'),
(11, 4, 'Rain Shower', '2026-06-29 02:37:55', '2026-06-29 02:37:55'),
(12, 4, 'Minibar', '2026-06-29 02:37:55', '2026-06-29 02:37:55'),
(13, 5, 'Wake-up service', '2026-06-29 02:43:45', '2026-06-29 02:43:45'),
(14, 6, 'Smoke alarms', '2026-06-29 02:45:43', '2026-06-29 02:45:43');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `photo_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `photo_name`, `created_at`, `updated_at`) VALUES
(2, 'upload/gallery/1867992933458170.jpg', '2026-06-14 10:08:04', NULL),
(3, 'upload/gallery/1867992933719820.jpg', '2026-06-14 10:08:04', NULL),
(5, 'upload/gallery/1867992982975291.jpg', '2026-06-14 10:08:51', NULL),
(6, 'upload/gallery/1867992983179203.jpg', '2026-06-14 10:08:51', NULL),
(7, 'upload/gallery/1867992983373768.jpg', '2026-06-14 10:08:51', NULL),
(13, 'upload/gallery/1868163226635923.jpg', '2026-06-16 07:14:48', NULL),
(14, 'upload/gallery/1868163226750619.jpg', '2026-06-16 07:14:48', NULL),
(15, 'upload/gallery/1868164755359088.jpg', '2026-06-16 07:39:06', NULL),
(16, 'upload/gallery/1868164755483682.jpg', '2026-06-16 07:39:06', NULL),
(17, 'upload/gallery/1868616855893000.jpg', '2026-06-21 07:25:02', '2026-06-21 07:25:02'),
(18, 'upload/gallery/1868616856039492.jpg', '2026-06-21 07:25:02', '2026-06-21 07:25:02'),
(19, 'upload/gallery/1868616856131965.jpg', '2026-06-21 07:25:03', '2026-06-21 07:25:03');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
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
-- Table structure for table `job_batches`
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
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_09_150339_create_teams_table', 1),
(5, '2026_04_13_133903_create_book_areas_table', 1),
(6, '2026_04_16_043002_create_room_types_table', 1),
(7, '2026_04_17_140918_create_rooms_table', 1),
(8, '2026_04_17_141002_create_facilities_table', 1),
(9, '2026_04_17_141046_create_multi_images_table', 1),
(10, '2026_04_27_084342_create_room_numbers_table', 1),
(11, '2026_05_08_032001_create_bookings_table', 1),
(12, '2026_05_08_034209_create_room_booked_dates_table', 1),
(13, '2026_05_08_105033_create_booking_room_lists_table', 1),
(14, '2026_06_08_141037_create_smtp_settings_table', 2),
(15, '2026_06_09_024808_create_testimonials_table', 3),
(16, '2026_06_09_133756_create_blog_categories_table', 4),
(17, '2026_06_10_041414_create_blog_posts_table', 5),
(18, '2026_06_11_134731_create_comments_table', 6),
(19, '2026_06_14_080757_create_site_settings_table', 7),
(20, '2026_06_14_140425_create_galleries_table', 8),
(21, '2026_06_17_041906_create_contacts_table', 9),
(22, '2026_06_18_025907_create_notifications_table', 10),
(23, '2026_06_18_141218_create_permission_tables', 11),
(24, '2026_06_25_154500_create_add_ons_table', 12);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `multi_images`
--

CREATE TABLE `multi_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rooms_id` int(11) NOT NULL,
  `multi_img` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `multi_images`
--

INSERT INTO `multi_images` (`id`, `rooms_id`, `multi_img`, `created_at`, `updated_at`) VALUES
(1, 1, 'upload/room_images/multi_img/6a23ee7d69d6f.jpg', '2026-06-06 02:55:09', '2026-06-06 02:55:09'),
(2, 1, 'upload/room_images/multi_img/6a23ee7da9797.jpg', '2026-06-06 02:55:09', '2026-06-06 02:55:09'),
(3, 1, 'upload/room_images/multi_img/6a23ee7de6df0.jpg', '2026-06-06 02:55:10', '2026-06-06 02:55:10'),
(7, 2, 'upload/room_images/multi_img/6a37f5a2e9eb4.jpg', '2026-06-21 07:30:58', '2026-06-21 07:30:58'),
(8, 2, 'upload/room_images/multi_img/6a37f5a2eb204.jpg', '2026-06-21 07:30:58', '2026-06-21 07:30:58'),
(9, 2, 'upload/room_images/multi_img/6a37f5a2ec06d.jpg', '2026-06-21 07:30:58', '2026-06-21 07:30:58'),
(10, 3, 'upload/room_images/multi_img/6a423bdce1300.jpg', '2026-06-29 02:33:16', '2026-06-29 02:33:16'),
(11, 3, 'upload/room_images/multi_img/6a423bdce5af3.jpg', '2026-06-29 02:33:16', '2026-06-29 02:33:16'),
(12, 3, 'upload/room_images/multi_img/6a423bdce6d40.jpg', '2026-06-29 02:33:16', '2026-06-29 02:33:16'),
(13, 4, 'upload/room_images/multi_img/6a423cf3508eb.jpg', '2026-06-29 02:37:55', '2026-06-29 02:37:55'),
(14, 4, 'upload/room_images/multi_img/6a423cf351dce.jpg', '2026-06-29 02:37:55', '2026-06-29 02:37:55'),
(15, 4, 'upload/room_images/multi_img/6a423cf3534b6.jpg', '2026-06-29 02:37:55', '2026-06-29 02:37:55'),
(16, 5, 'upload/room_images/multi_img/6a423e51e9bc1.jpg', '2026-06-29 02:43:45', '2026-06-29 02:43:45'),
(17, 5, 'upload/room_images/multi_img/6a423e51eb97d.jpg', '2026-06-29 02:43:45', '2026-06-29 02:43:45'),
(18, 5, 'upload/room_images/multi_img/6a423e51ecf21.jpg', '2026-06-29 02:43:45', '2026-06-29 02:43:45'),
(19, 6, 'upload/room_images/multi_img/6a423ec79a8ab.jpg', '2026-06-29 02:45:43', '2026-06-29 02:45:43'),
(20, 6, 'upload/room_images/multi_img/6a423ec79d8b4.jpg', '2026-06-29 02:45:43', '2026-06-29 02:45:43'),
(21, 6, 'upload/room_images/multi_img/6a423ec79f77d.jpg', '2026-06-29 02:45:43', '2026-06-29 02:45:43');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('0589932f-fa9a-495f-a95d-f3c54abcf9ce', 'App\\Notifications\\BookingComplete', 'App\\Models\\User', 5, '{\"message\":\"Added new booking in Hotel\",\"user_image\":\"202606270835-avatar-5.png\",\"user_id\":6}', NULL, '2026-06-28 06:37:45', '2026-06-28 06:37:45'),
('24734ec0-2adc-4849-b2d9-7417b8123b29', 'App\\Notifications\\BookingComplete', 'App\\Models\\User', 6, '{\"message\":\"Added new booking in Hotel\",\"user_image\":\"202606270835-avatar-5.png\",\"user_id\":6}', NULL, '2026-06-28 03:25:15', '2026-06-28 03:25:15'),
('46b7903c-cb97-4fb6-acb1-ad0cda71fbe5', 'App\\Notifications\\BookingComplete', 'App\\Models\\User', 6, '{\"message\":\"Added new booking in Hotel\",\"user_image\":\"202606111451-avatar-1.png\",\"user_id\":3}', NULL, '2026-06-28 06:43:39', '2026-06-28 06:43:39'),
('5fa83112-2979-441c-8601-cc4a704f3704', 'App\\Notifications\\BookingComplete', 'App\\Models\\User', 6, '{\"message\":\"Added new booking in Hotel\",\"user_image\":\"202606111451-avatar-1.png\",\"user_id\":3}', NULL, '2026-06-28 06:47:44', '2026-06-28 06:47:44'),
('639cf5e4-0520-4e89-bb2c-4c5074a3cfd1', 'App\\Notifications\\BookingComplete', 'App\\Models\\User', 1, '{\"message\":\"Added new booking in Hotel\",\"user_image\":\"202606111451-avatar-1.png\",\"user_id\":3}', '2026-06-28 06:48:08', '2026-06-28 06:47:44', '2026-06-28 06:48:08'),
('6508889a-0b89-4b21-ab75-2d015e87091a', 'App\\Notifications\\BookingComplete', 'App\\Models\\User', 1, '{\"message\":\"Added new booking in Hotel\",\"user_image\":\"202606131605-avatar-5.png\",\"user_id\":1}', '2026-06-26 06:14:57', '2026-06-25 21:40:04', '2026-06-26 06:14:57'),
('6571434f-c660-4e9e-b184-19e8dc98dcf4', 'App\\Notifications\\BookingComplete', 'App\\Models\\User', 1, '{\"message\":\"Added new booking in Hotel\",\"user_image\":\"202606111451-avatar-1.png\",\"user_id\":3}', '2026-06-18 01:15:22', '2026-06-17 23:01:21', '2026-06-18 01:15:22'),
('697e0c15-f6ff-424f-99a8-9f3c220ddcec', 'App\\Notifications\\BookingComplete', 'App\\Models\\User', 1, '{\"message\":\"Added new booking in Hotel\",\"user_image\":\"202606131605-avatar-5.png\",\"user_id\":1}', '2026-06-23 06:32:55', '2026-06-21 07:42:24', '2026-06-23 06:32:55'),
('6f226b1c-4a1e-491f-b657-177ff8131614', 'App\\Notifications\\BookingComplete', 'App\\Models\\User', 5, '{\"message\":\"Added new booking in Hotel\",\"user_image\":\"202606270835-avatar-5.png\",\"user_id\":6}', NULL, '2026-06-28 03:25:15', '2026-06-28 03:25:15'),
('7d22d0aa-f791-4041-8ca5-fef6e5d6175b', 'App\\Notifications\\BookingComplete', 'App\\Models\\User', 1, '{\"message\":\"Added new booking in Hotel\"}', '2026-06-18 01:26:11', '2026-06-17 22:35:22', '2026-06-18 01:26:11'),
('815b40fc-1a2a-4a90-b258-74547c5a7761', 'App\\Notifications\\BookingComplete', 'App\\Models\\User', 1, '{\"message\":\"Added new booking in Hotel\",\"user_image\":\"202606270835-avatar-5.png\",\"user_id\":6}', '2026-06-28 06:38:09', '2026-06-28 06:37:45', '2026-06-28 06:38:09'),
('a220f7b8-f957-45d5-8d82-dbc865638953', 'App\\Notifications\\BookingComplete', 'App\\Models\\User', 5, '{\"message\":\"Added new booking in Hotel\",\"user_image\":\"202606111451-avatar-1.png\",\"user_id\":3}', NULL, '2026-06-28 06:43:39', '2026-06-28 06:43:39'),
('a5b64714-9d8e-41b4-bc5f-8805674e10cd', 'App\\Notifications\\BookingComplete', 'App\\Models\\User', 6, '{\"message\":\"Added new booking in Hotel\",\"user_image\":\"202606270835-avatar-5.png\",\"user_id\":6}', NULL, '2026-06-28 06:37:45', '2026-06-28 06:37:45'),
('b3670b79-2952-4c39-9bcd-aeab40fbdbaf', 'App\\Notifications\\BookingComplete', 'App\\Models\\User', 1, '{\"message\":\"Added new booking in Hotel\",\"user_image\":\"202606270835-avatar-5.png\",\"user_id\":6}', '2026-06-28 03:26:08', '2026-06-28 03:25:15', '2026-06-28 03:26:08'),
('c06a7fc2-c287-4349-858f-62a720bb7285', 'App\\Notifications\\BookingComplete', 'App\\Models\\User', 1, '{\"message\":\"Added new booking in Hotel\",\"user_image\":\"202606131605-avatar-5.png\",\"user_id\":1}', '2026-06-26 06:15:00', '2026-06-25 21:50:01', '2026-06-26 06:15:00'),
('e09e25c0-b04b-4aaf-8b7c-5937587f6231', 'App\\Notifications\\BookingComplete', 'App\\Models\\User', 5, '{\"message\":\"Added new booking in Hotel\",\"user_image\":\"202606111451-avatar-1.png\",\"user_id\":3}', NULL, '2026-06-28 06:47:44', '2026-06-28 06:47:44'),
('e28f8766-1ea7-4ffd-b568-9f0681f04549', 'App\\Notifications\\BookingComplete', 'App\\Models\\User', 1, '{\"message\":\"Added new booking in Hotel\",\"user_image\":\"202606111451-avatar-1.png\",\"user_id\":3}', '2026-06-18 01:29:21', '2026-06-18 01:28:54', '2026-06-18 01:29:21'),
('fcb6ca74-d2e0-4d08-94b6-b861bb8e85a2', 'App\\Notifications\\BookingComplete', 'App\\Models\\User', 1, '{\"message\":\"Added new booking in Hotel\",\"user_image\":\"202606111451-avatar-1.png\",\"user_id\":3}', '2026-06-28 06:48:07', '2026-06-28 06:43:39', '2026-06-28 06:48:07');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `group_name` varchar(255) DEFAULT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `group_name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'team.menu', 'Teams Management', 'web', '2026-06-18 19:42:07', '2026-06-18 20:03:13'),
(3, 'team.view', 'Teams Management', 'web', '2026-06-19 01:49:54', '2026-06-19 01:49:54'),
(4, 'team.create', 'Teams Management', 'web', '2026-06-19 01:50:09', '2026-06-19 01:50:09'),
(5, 'team.update', 'Teams Management', 'web', '2026-06-19 02:31:12', '2026-06-19 02:31:12'),
(6, 'team.delete', 'Teams Management', 'web', '2026-06-19 02:31:12', '2026-06-19 02:31:12'),
(7, 'testimonial.menu', 'Testimonial Management', 'web', '2026-06-23 07:17:36', '2026-06-23 07:17:36'),
(8, 'testimonial.view', 'Testimonial Management', 'web', '2026-06-23 07:17:54', '2026-06-23 07:17:54'),
(9, 'testimonial.create', 'Testimonial Management', 'web', '2026-06-23 07:18:09', '2026-06-23 07:18:09'),
(10, 'testimonial.edit', 'Testimonial Management', 'web', '2026-06-23 07:18:20', '2026-06-23 07:18:20'),
(11, 'testimonial.delete', 'Testimonial Management', 'web', '2026-06-23 07:19:11', '2026-06-23 07:19:11'),
(12, 'book.area.menu', 'Book Area Management', 'web', '2026-06-23 07:19:45', '2026-06-23 07:19:45'),
(14, 'team.edit', 'Teams Management', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(15, 'testimonial.update', 'Testimonial Management', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(16, 'blog.category.view', 'Blog', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(17, 'blog.category.create', 'Blog', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(18, 'blog.category.edit', 'Blog', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(19, 'blog.category.delete', 'Blog', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(20, 'blog.post.view', 'Blog', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(21, 'blog.post.create', 'Blog', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(22, 'blog.post.edit', 'Blog', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(23, 'blog.post.delete', 'Blog', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(24, 'comment.view', 'Comment Management', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(25, 'comment.approve', 'Comment Management', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(26, 'comment.reply', 'Comment Management', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(27, 'comment.delete', 'Comment Management', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(28, 'book.area.view', 'Book Area Management', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(29, 'book.area.create', 'Book Area Management', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(30, 'book.area.edit', 'Book Area Management', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(31, 'book.area.update', 'Book Area Management', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(32, 'book.area.delete', 'Book Area Management', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(33, 'gallery.view', 'Hotel Gallery', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(34, 'gallery.create', 'Hotel Gallery', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(35, 'gallery.edit', 'Hotel Gallery', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(36, 'gallery.delete', 'Hotel Gallery', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(37, 'room.type.view', 'Room Type Management', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(38, 'room.type.create', 'Room Type Management', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(39, 'room.type.edit', 'Room Type Management', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(40, 'room.type.update', 'Room Type Management', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(41, 'room.type.delete', 'Room Type Management', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(42, 'booking.view', 'Booking', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(43, 'booking.create', 'Booking', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(44, 'booking.edit', 'Booking', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(45, 'booking.update', 'Booking', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(46, 'booking.delete', 'Booking', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(47, 'booking.detail', 'Booking', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(48, 'room.list.view', 'Room List Management', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(49, 'room.list.create', 'Room List Management', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(50, 'room.list.edit', 'Room List Management', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(51, 'room.list.update', 'Room List Management', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(52, 'room.list.delete', 'Room List Management', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(53, 'booking.report.view', 'Booking Report', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(54, 'booking.report.export', 'Booking Report', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(55, 'booking.report.filter', 'Booking Report', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(56, 'permission.view', 'Role and Permission', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(57, 'permission.create', 'Role and Permission', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(58, 'permission.edit', 'Role and Permission', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(59, 'permission.delete', 'Role and Permission', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(60, 'role.view', 'Role and Permission', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(61, 'role.create', 'Role and Permission', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(62, 'role.edit', 'Role and Permission', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(63, 'role.delete', 'Role and Permission', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(64, 'role.assign', 'Role and Permission', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(65, 'contact.message.view', 'Contact', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(66, 'contact.message.detail', 'Contact', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(67, 'contact.message.reply', 'Contact', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(68, 'contact.message.delete', 'Contact', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(69, 'smtp.setting.view', 'Setting', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(70, 'smtp.setting.update', 'Setting', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(71, 'site.setting.view', 'Setting', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(72, 'site.setting.update', 'Setting', 'web', '2026-06-23 07:25:47', '2026-06-23 07:25:47'),
(73, 'dashboard.view', 'Dashboard', 'web', '2026-06-27 22:49:10', '2026-06-27 22:49:10'),
(74, 'blog.menu', 'Blog', 'web', '2026-06-27 22:54:38', '2026-06-27 22:54:38'),
(75, 'comment.menu', 'Comment Management', 'web', '2026-06-27 22:55:35', '2026-06-27 22:55:35'),
(76, 'gallery.menu', 'Hotel Gallery', 'web', '2026-06-27 22:57:48', '2026-06-27 22:57:48'),
(77, 'room.type.menu', 'Room Type Management', 'web', '2026-06-27 22:58:31', '2026-06-27 22:58:31'),
(78, 'addon.menu', 'Add-ons Facility Management', 'web', '2026-06-27 23:04:22', '2026-06-27 23:04:22'),
(79, 'addon.view', 'Add-ons Facility Management', 'web', '2026-06-27 23:04:49', '2026-06-27 23:04:49'),
(80, 'addon.create', 'Add-ons Facility Management', 'web', '2026-06-27 23:05:07', '2026-06-27 23:05:15'),
(81, 'addon.edit', 'Add-ons Facility Management', 'web', '2026-06-27 23:05:32', '2026-06-27 23:05:32'),
(82, 'addon.delete', 'Add-ons Facility Management', 'web', '2026-06-27 23:05:42', '2026-06-27 23:05:47'),
(83, 'admin.menu', 'Manage Admin', 'web', '2026-06-27 23:06:24', '2026-06-27 23:06:24'),
(84, 'admin.view', 'Manage Admin', 'web', '2026-06-27 23:06:37', '2026-06-27 23:06:37'),
(85, 'admin.create', 'Manage Admin', 'web', '2026-06-27 23:06:51', '2026-06-27 23:06:51'),
(86, 'admin.edit', 'Manage Admin', 'web', '2026-06-27 23:07:03', '2026-06-27 23:07:03'),
(87, 'admin.delete', 'Manage Admin', 'web', '2026-06-27 23:07:19', '2026-06-27 23:07:19'),
(88, 'booking.menu', 'Booking', 'web', '2026-06-27 23:09:19', '2026-06-27 23:09:19'),
(89, 'room.list.menu', 'Room List Management', 'web', '2026-06-27 23:09:59', '2026-06-27 23:09:59'),
(90, 'booking.report.menu', 'Booking Report', 'web', '2026-06-27 23:11:33', '2026-06-27 23:11:33'),
(91, 'permission.menu', 'Role and Permission', 'web', '2026-06-27 23:13:02', '2026-06-27 23:13:02'),
(92, 'contact.message.menu', 'Contact', 'web', '2026-06-27 23:16:47', '2026-06-27 23:16:47'),
(93, 'setting.menu', 'Setting', 'web', '2026-06-27 23:17:04', '2026-06-27 23:17:04'),
(94, 'permission.import', 'Role and Permission', 'web', '2026-06-28 02:43:46', '2026-06-28 02:43:46'),
(95, 'permission.export', 'Role and Permission', 'web', '2026-06-28 02:43:57', '2026-06-28 02:43:57'),
(96, 'customer.menu', 'Customer Management', 'web', '2026-07-01 01:49:55', '2026-07-01 01:49:55'),
(97, 'customer.create', 'Customer Management', 'web', '2026-07-01 01:50:09', '2026-07-01 01:50:09'),
(98, 'customer.edit', 'Customer Management', 'web', '2026-07-01 01:50:25', '2026-07-01 01:50:25'),
(99, 'customer.update', 'Customer Management', 'web', '2026-07-01 01:50:42', '2026-07-01 01:50:42'),
(100, 'customer.view', 'Customer Management', 'web', '2026-07-01 01:50:54', '2026-07-01 01:50:54'),
(101, 'customer.delete', 'Customer Management', 'web', '2026-07-01 01:51:19', '2026-07-01 01:51:19');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', '2026-06-23 06:56:53', '2026-06-23 06:56:53'),
(2, 'Admin', 'web', '2026-06-23 06:57:15', '2026-06-23 06:57:15'),
(3, 'Receptionist', 'web', '2026-06-23 06:57:33', '2026-06-23 06:57:33'),
(4, 'Manager', 'web', '2026-06-23 06:57:43', '2026-06-23 07:10:42');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(3, 1),
(3, 2),
(3, 3),
(4, 1),
(4, 2),
(5, 1),
(5, 2),
(5, 3),
(6, 1),
(6, 2),
(7, 1),
(7, 2),
(7, 3),
(8, 1),
(8, 2),
(8, 3),
(9, 1),
(9, 2),
(10, 1),
(10, 2),
(11, 1),
(11, 2),
(12, 1),
(12, 2),
(12, 3),
(14, 1),
(14, 2),
(15, 1),
(15, 2),
(15, 3),
(16, 1),
(16, 2),
(16, 3),
(17, 1),
(17, 2),
(18, 1),
(18, 2),
(18, 3),
(19, 1),
(19, 2),
(19, 3),
(20, 1),
(20, 2),
(20, 3),
(21, 1),
(21, 2),
(22, 1),
(22, 2),
(23, 1),
(23, 2),
(24, 1),
(24, 2),
(24, 3),
(25, 1),
(25, 2),
(25, 3),
(26, 1),
(26, 2),
(26, 3),
(27, 1),
(27, 2),
(27, 3),
(28, 1),
(28, 2),
(28, 3),
(29, 1),
(29, 2),
(30, 1),
(30, 2),
(31, 1),
(31, 2),
(31, 3),
(32, 1),
(32, 2),
(33, 1),
(33, 2),
(33, 3),
(34, 1),
(34, 2),
(35, 1),
(35, 2),
(36, 1),
(36, 2),
(37, 1),
(37, 2),
(37, 3),
(38, 1),
(38, 2),
(39, 1),
(39, 2),
(40, 1),
(40, 2),
(40, 3),
(41, 1),
(41, 2),
(42, 1),
(42, 2),
(42, 3),
(42, 4),
(43, 1),
(43, 2),
(43, 4),
(44, 1),
(44, 2),
(44, 3),
(44, 4),
(45, 1),
(45, 2),
(45, 3),
(45, 4),
(46, 1),
(46, 2),
(46, 4),
(47, 1),
(47, 2),
(47, 3),
(47, 4),
(48, 1),
(48, 2),
(48, 3),
(49, 1),
(49, 2),
(49, 3),
(50, 1),
(50, 2),
(50, 3),
(51, 1),
(51, 2),
(51, 3),
(52, 1),
(52, 2),
(52, 3),
(53, 1),
(53, 2),
(53, 3),
(53, 4),
(54, 1),
(54, 2),
(54, 3),
(54, 4),
(55, 1),
(55, 2),
(55, 3),
(55, 4),
(56, 1),
(56, 2),
(56, 3),
(57, 1),
(57, 2),
(58, 1),
(58, 2),
(59, 1),
(59, 2),
(60, 1),
(60, 2),
(60, 3),
(61, 1),
(61, 2),
(62, 1),
(62, 2),
(63, 1),
(63, 2),
(64, 1),
(64, 2),
(64, 3),
(65, 1),
(65, 2),
(65, 3),
(66, 1),
(66, 2),
(66, 3),
(67, 1),
(67, 2),
(67, 3),
(68, 1),
(68, 2),
(68, 3),
(69, 1),
(69, 2),
(69, 3),
(70, 1),
(70, 2),
(70, 3),
(71, 1),
(71, 2),
(71, 3),
(72, 1),
(72, 2),
(72, 3),
(73, 1),
(73, 2),
(73, 3),
(74, 1),
(74, 2),
(74, 3),
(75, 1),
(75, 2),
(75, 3),
(76, 1),
(76, 2),
(76, 3),
(77, 1),
(77, 2),
(77, 3),
(78, 1),
(78, 2),
(78, 3),
(79, 1),
(79, 2),
(79, 3),
(80, 1),
(80, 2),
(81, 1),
(81, 2),
(82, 1),
(82, 2),
(83, 1),
(83, 2),
(83, 3),
(84, 1),
(84, 2),
(84, 3),
(85, 1),
(85, 2),
(86, 1),
(86, 2),
(87, 1),
(87, 2),
(88, 1),
(88, 2),
(88, 3),
(89, 1),
(89, 2),
(89, 3),
(90, 1),
(90, 2),
(90, 3),
(91, 1),
(91, 2),
(91, 3),
(92, 1),
(92, 2),
(92, 3),
(93, 1),
(93, 2),
(93, 3),
(94, 1),
(95, 1),
(96, 1),
(97, 1),
(98, 1),
(99, 1),
(100, 1),
(101, 1);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `roomtype_id` int(11) NOT NULL,
  `total_adult` varchar(255) DEFAULT NULL,
  `total_child` varchar(255) DEFAULT NULL,
  `room_capacity` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `view` varchar(255) DEFAULT NULL,
  `bed_style` varchar(255) DEFAULT NULL,
  `discount` int(11) NOT NULL DEFAULT 0,
  `short_desc` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `roomtype_id`, `total_adult`, `total_child`, `room_capacity`, `image`, `price`, `size`, `view`, `bed_style`, `discount`, `short_desc`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '2', '2', '4', '6a23ee788728d.jpg', '120', '25', 'Hill View', 'Twin Bed', 10, '<p>Lorem ipsum dolor sit amet, adipiscing elit. Suspendisse et faucibus felis, sed pulvinar purus.</p>', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore</p>\r\n<p>Ecespiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quci velit modi tempora incidunt ut labore et dolore magnam aliquam quaerat .</p>', 1, NULL, '2026-06-06 02:55:09'),
(2, 2, '2', '2', '4', '6a37f5a2baba2.jpg', '150', '30', 'Hill View', 'King Bed', 10, '<p>Lorem ipsum dolor sit amet, adipiscing elit. Suspendisse et faucibus felis, sed pulvinar purus.</p>', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore</p>\r\n<p>Ecespiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quci velit modi tempora incidunt ut labore et dolore magnam aliquam quaerat .</p>', 1, NULL, '2026-06-21 07:41:35'),
(3, 3, '2', '1', '3', '6a423bdc9f506.jpg', '150', '35', 'Mountain View', 'King Bed', 10, '<p>Lorem ipsum dolor sit amet, adipiscing elit. Suspendisse et faucibus felis, sed pulvinar purus.</p>', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore</p>\r\n<p>Ecespiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quci velit modi tempora incidunt ut labore et dolore magnam aliquam quaerat .</p>', 1, NULL, '2026-06-29 02:33:16'),
(4, 4, '1', '1', '2', '6a423cf31cb7b.jpg', '300', '50', 'Garden View', 'Double Bed', 0, '<p>Lorem ipsum dolor sit amet, adipiscing elit. Suspendisse et faucibus felis, sed pulvinar purus.</p>', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore</p>\r\n<p>Ecespiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quci velit modi tempora incidunt ut labore et dolore magnam aliquam quaerat .</p>', 1, NULL, '2026-06-29 02:37:55'),
(5, 5, '3', '2', '5', '6a423e51c17c6.jpg', '350', '45', 'Mountain View', 'Sofa Bed', 0, '<p>Lorem ipsum dolor sit amet, adipiscing elit. Suspendisse et faucibus felis, sed pulvinar purus.</p>', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore</p>\r\n<p>Ecespiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quci velit modi tempora incidunt ut labore et dolore magnam aliquam quaerat .</p>', 1, NULL, '2026-06-29 02:43:45'),
(6, 6, '3', '3', '6', '6a423ec774624.jpg', '500', '60', 'Hill View', 'Double Bed', 10, '<p>Lorem ipsum dolor sit amet, adipiscing elit. Suspendisse et faucibus felis, sed pulvinar purus.</p>', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore</p>\r\n<p>Ecespiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quci velit modi tempora incidunt ut labore et dolore magnam aliquam quaerat .</p>', 1, NULL, '2026-06-29 02:45:43');

-- --------------------------------------------------------

--
-- Table structure for table `room_booked_dates`
--

CREATE TABLE `room_booked_dates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `book_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `room_numbers`
--

CREATE TABLE `room_numbers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rooms_id` int(11) NOT NULL,
  `room_type_id` int(11) NOT NULL,
  `room_number` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `room_numbers`
--

INSERT INTO `room_numbers` (`id`, `rooms_id`, `room_type_id`, `room_number`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '100', 'Active', '2026-06-06 02:55:35', '2026-06-06 02:55:35'),
(2, 1, 1, '101', 'Active', '2026-06-06 02:55:45', '2026-06-06 02:55:45'),
(3, 1, 1, '102', 'Active', '2026-06-06 02:55:53', '2026-06-06 02:55:53'),
(4, 2, 2, '200', 'Active', '2026-06-21 07:39:43', '2026-06-21 07:39:43'),
(5, 2, 2, '201', 'Active', '2026-06-21 07:39:51', '2026-06-21 07:39:51'),
(6, 3, 3, '300', 'Active', '2026-06-29 02:38:36', '2026-06-29 02:38:36'),
(7, 3, 3, '301', 'Active', '2026-06-29 02:38:49', '2026-06-29 02:38:49'),
(8, 3, 3, '302', 'Active', '2026-06-29 02:38:58', '2026-06-29 02:38:58'),
(9, 3, 3, '303', 'Active', '2026-06-29 02:39:05', '2026-06-29 02:39:05'),
(10, 4, 4, '400', 'Active', '2026-06-29 02:39:28', '2026-06-29 02:39:28'),
(11, 4, 4, '401', 'Active', '2026-06-29 02:39:38', '2026-06-29 02:39:38'),
(12, 4, 4, '402', 'Active', '2026-06-29 02:39:47', '2026-06-29 02:39:47'),
(13, 4, 4, '403', 'Active', '2026-06-29 02:39:56', '2026-06-29 02:39:56'),
(14, 5, 5, '500', 'Active', '2026-06-29 02:43:59', '2026-06-29 02:43:59'),
(15, 5, 5, '501', 'Active', '2026-06-29 02:44:07', '2026-06-29 02:44:07'),
(16, 5, 5, '502', 'Active', '2026-06-29 02:44:15', '2026-06-29 02:44:15'),
(17, 6, 6, '600', 'Active', '2026-06-29 02:46:43', '2026-06-29 02:46:43'),
(18, 6, 6, '601', 'Active', '2026-06-29 02:46:52', '2026-06-29 02:46:52'),
(19, 6, 6, '602', 'Active', '2026-06-29 02:47:00', '2026-06-29 02:47:00');

-- --------------------------------------------------------

--
-- Table structure for table `room_types`
--

CREATE TABLE `room_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `room_types`
--

INSERT INTO `room_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'EXECUTIVE SUITE', '2026-06-06 02:46:28', NULL),
(2, 'DELUXE TWIN', '2026-06-21 06:50:44', NULL),
(3, 'PREMIER SINGLE', '2026-06-29 02:31:37', NULL),
(4, 'PREMIER DELUXE', '2026-06-29 02:36:46', NULL),
(5, 'Royal Suite', '2026-06-29 02:41:16', NULL),
(6, 'Luxury Room', '2026-06-29 02:41:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
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
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('wPs1LXcRixR3qMNV0Bsoc0lX5KGkfjWpnjUSvhoG', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZ1p4STUyM205U3c5R2RCcTVlWHRLajN1eFBuN3p5NGRHZDRkb2puVSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1782897208),
('wsYv76PPujACHi0y90C3k2NVgICV6cj2eQ2ivwTh', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRHpSaHd5SEpublFUdGlCZ1NUNzF3bnBncWtxOFp4bzlMc1EyRHNXVSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1782895930);

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `tiktok` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `copyright` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `logo`, `phone`, `address`, `email`, `facebook`, `tiktok`, `instagram`, `copyright`, `created_at`, `updated_at`) VALUES
(1, 'upload/site/1867964200608690.png', '0376734165', '123 số 2 B1, Phù Cừ, Hưng Yên', 'tungvuvanthanh@gmail.com', 'https://www.facebook.com/', 'https://www.tiktok.com/', 'https://www.instagram.com/', 'Copyright @ 2026 HotelHub. All Rights Reserved by Tùng dev 2k4', '2026-06-14 02:31:22', '2026-06-14 02:31:22');

-- --------------------------------------------------------

--
-- Table structure for table `smtp_settings`
--

CREATE TABLE `smtp_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mailer` varchar(255) DEFAULT NULL,
  `host` varchar(255) DEFAULT NULL,
  `port` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `from_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `smtp_settings`
--

INSERT INTO `smtp_settings` (`id`, `mailer`, `host`, `port`, `username`, `password`, `from_address`, `created_at`, `updated_at`) VALUES
(1, 'smtp', 'sandbox.smtp.mailtrap.io', '2525', '4db4d9bb5de191', 'b1c233123d587e', 'tungvuvanthanh@gmail.com', NULL, '2026-06-08 07:49:34');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `tiktok` varchar(255) NOT NULL,
  `instagram` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `image`, `name`, `position`, `facebook`, `tiktok`, `instagram`, `created_at`, `updated_at`) VALUES
(1, 'upload/team/1867618902168940.jpg', 'Hữu Trúc', 'Web Developer', 'https://www.facebook.com/', 'https://www.tiktok.com/', 'https://www.instagram.com/', '2026-06-10 07:03:00', '2026-06-10 07:03:00'),
(2, 'upload/team/1867618937129196.jpg', 'Duy Tứ', 'Leader', 'https://www.facebook.com/', 'https://www.tiktok.com/', 'https://www.instagram.com/', '2026-06-10 07:03:33', '2026-06-10 07:03:33'),
(3, 'upload/team/1867618971141001.jpg', 'Thúy Dung', 'BA', 'https://www.facebook.com/', 'https://www.tiktok.com/', 'https://www.instagram.com/', '2026-06-10 07:04:05', '2026-06-10 07:04:05'),
(4, 'upload/team/1868616566177107.png', 'Thanh Tùng', 'CEO', 'https://www.facebook.com/', 'https://www.tiktok.com/', 'https://www.instagram.com/', '2026-06-21 07:20:26', '2026-06-21 07:21:22');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `message` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `city`, `image`, `message`, `created_at`, `updated_at`) VALUES
(1, 'Thành', 'Hà Nội', 'upload/testimonials/1867525031543001.png', 'Feedback được hiểu đơn giản chính là những ý kiến phản hồi, đánh giá từ phía khách hàng sau khi đã sử dụng những dịch vụ, sản phẩm của doanh nghiệp', '2026-06-09 06:11:00', '2026-06-09 06:11:00'),
(2, 'Trúc', 'Hưng Yên', 'upload/testimonials/1867489541330395.png', 'Feedback được hiểu đơn giản chính là những ý kiến phản hồi, đánh giá từ phía khách hàng sau khi đã sử dụng những dịch vụ, sản phẩm của doanh nghiệp', '2026-06-08 20:46:51', NULL),
(4, 'Thúy Dung', 'Hưng Yên', 'upload/testimonials/1868617081228322.png', 'Đặt phòng khách sạn dễ dàng, không phức tạp và đặc biệt nhanh chóng', '2026-06-21 07:28:37', '2026-06-21 07:29:14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `role` enum('admin','instructor','user') NOT NULL DEFAULT 'user',
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `otp_code` varchar(255) DEFAULT NULL,
  `otp_expires_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `photo`, `phone`, `address`, `role`, `status`, `otp_code`, `otp_expires_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin', 'admin@gmail.com', NULL, '$2y$12$3AR5pmKDwr2mB2dBPC21AOs4tOWND6.fXvGgIxLPvEKXILZBpmYOa', '202606131605-avatar-5.png', '0123456789', 'Hưng Yên', 'admin', '1', NULL, NULL, NULL, NULL, '2026-06-13 09:05:34'),
(2, 'Instructor', 'instructor', 'instructor@gmail.com', NULL, '$2y$12$D1rX/xMLLsU2RgO93rWAVeeBR6no17iEooHJQTEuqe8a6DQ/kk.Um', NULL, '0123456789', 'Hưng Yên', 'instructor', '1', NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_ons`
--
ALTER TABLE `add_ons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_room_lists`
--
ALTER TABLE `booking_room_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `book_areas`
--
ALTER TABLE `book_areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `multi_images`
--
ALTER TABLE `multi_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_booked_dates`
--
ALTER TABLE `room_booked_dates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_numbers`
--
ALTER TABLE `room_numbers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_types`
--
ALTER TABLE `room_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `smtp_settings`
--
ALTER TABLE `smtp_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_ons`
--
ALTER TABLE `add_ons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `booking_room_lists`
--
ALTER TABLE `booking_room_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `book_areas`
--
ALTER TABLE `book_areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `multi_images`
--
ALTER TABLE `multi_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `room_booked_dates`
--
ALTER TABLE `room_booked_dates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `room_numbers`
--
ALTER TABLE `room_numbers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `room_types`
--
ALTER TABLE `room_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `smtp_settings`
--
ALTER TABLE `smtp_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
