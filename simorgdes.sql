-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 04 Bulan Mei 2026 pada 01.47
-- Versi server: 8.0.30
-- Versi PHP: 8.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simorgdes`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `activities`
--

CREATE TABLE `activities` (
  `id` bigint UNSIGNED NOT NULL,
  `organization_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity_date` datetime NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `radius_meter` int NOT NULL DEFAULT '50',
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('draft','scheduled','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `activities`
--

INSERT INTO `activities` (`id`, `organization_id`, `title`, `activity_date`, `location`, `latitude`, `longitude`, `radius_meter`, `description`, `status`, `created_at`, `updated_at`) VALUES
(3, 1, 'tess', '2026-03-09 00:00:00', 'Banjar Kaja Kauh', NULL, NULL, 50, 'wewae', 'scheduled', '2026-03-07 21:25:08', '2026-03-07 21:25:08'),
(4, 2, 'Mereresik', '2026-03-14 00:00:00', 'Banjar Kaja Kauh', -8.54925700, 115.33377500, 63, 'tessss', 'scheduled', '2026-03-13 10:07:11', '2026-04-18 08:24:57'),
(5, 1, 'RAPAT', '2026-04-30 00:00:00', 'Banjar Kaja Kauh', -8.54921500, 115.33382100, 50, 'Tesssssss', 'scheduled', '2026-04-16 07:19:49', '2026-04-18 07:52:45'),
(6, 1, 'Rapat Rutin', '2026-04-25 14:25:00', 'Banjar', -8.54922600, 115.33382400, 65, 'tes', 'scheduled', '2026-04-18 10:27:13', '2026-04-18 10:32:26'),
(7, 1, 'Rapat Rutin', '2026-04-25 02:36:00', 'Banjar Kaja Kauh', -8.54914600, 115.33379700, 90, 'tessssss', 'scheduled', '2026-04-18 10:38:40', '2026-04-22 02:30:16'),
(8, 1, 'Mereresik Ring Lapangan', '2026-04-25 19:27:00', 'Lapangan', -8.55250400, 115.33449400, 60, 'Tesssss', 'scheduled', '2026-04-20 03:28:06', '2026-04-20 03:33:55'),
(12, 1, 'kegiatan', '2026-04-25 19:07:00', 'Jalan Ratna IV, Gianyar', -8.54948100, 115.33383100, 100, NULL, 'scheduled', '2026-04-22 03:08:04', '2026-04-22 03:08:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `activity_attendances`
--

CREATE TABLE `activity_attendances` (
  `id` bigint UNSIGNED NOT NULL,
  `activity_id` bigint UNSIGNED NOT NULL,
  `member_id` bigint UNSIGNED NOT NULL,
  `status` enum('hadir','tidak_hadir','izin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'hadir',
  `checked_in_at` timestamp NULL DEFAULT NULL,
  `attendance_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'manual',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `activity_attendances`
--

INSERT INTO `activity_attendances` (`id`, `activity_id`, `member_id`, `status`, `checked_in_at`, `attendance_method`, `created_at`, `updated_at`) VALUES
(5, 3, 3, 'tidak_hadir', NULL, 'manual', '2026-03-07 21:36:41', '2026-03-15 05:25:32'),
(6, 3, 2, 'tidak_hadir', NULL, 'manual', '2026-03-07 21:36:41', '2026-03-07 21:36:41'),
(7, 3, 1, 'tidak_hadir', '2026-04-15 00:50:15', 'qr', '2026-03-07 21:36:41', '2026-04-18 07:33:47'),
(8, 3, 4, 'tidak_hadir', NULL, 'manual', '2026-03-07 21:36:41', '2026-03-15 05:25:32'),
(13, 4, 5, 'tidak_hadir', NULL, 'manual', '2026-03-15 04:22:46', '2026-04-18 07:33:37'),
(14, 4, 6, 'tidak_hadir', NULL, 'manual', '2026-03-15 04:22:46', '2026-04-18 07:33:37'),
(15, 5, 3, 'tidak_hadir', NULL, 'manual', '2026-04-18 07:33:30', '2026-04-18 07:33:30'),
(16, 5, 8, 'tidak_hadir', NULL, 'manual', '2026-04-18 07:33:30', '2026-04-18 07:33:30'),
(17, 5, 2, 'tidak_hadir', NULL, 'manual', '2026-04-18 07:33:30', '2026-04-18 07:33:30'),
(18, 5, 9, 'tidak_hadir', NULL, 'manual', '2026-04-18 07:33:30', '2026-04-18 07:33:30'),
(19, 5, 1, 'hadir', '2026-04-18 08:00:06', 'self_qr', '2026-04-18 07:33:30', '2026-04-18 08:00:06'),
(20, 5, 4, 'tidak_hadir', NULL, 'manual', '2026-04-18 07:33:30', '2026-04-18 07:33:30'),
(21, 3, 8, 'tidak_hadir', NULL, 'manual', '2026-04-18 07:33:47', '2026-04-18 07:33:47'),
(22, 3, 9, 'tidak_hadir', NULL, 'manual', '2026-04-18 07:33:47', '2026-04-18 07:33:47'),
(27, 7, 1, 'tidak_hadir', '2026-04-22 02:30:37', 'self_qr', '2026-04-22 02:30:37', '2026-04-22 02:30:55'),
(28, 7, 10, 'tidak_hadir', NULL, 'manual', '2026-04-22 02:30:55', '2026-04-22 02:30:55'),
(29, 7, 8, 'tidak_hadir', NULL, 'manual', '2026-04-22 02:30:55', '2026-04-22 02:30:55'),
(30, 7, 2, 'tidak_hadir', NULL, 'manual', '2026-04-22 02:30:55', '2026-04-22 02:30:55'),
(31, 7, 3, 'tidak_hadir', NULL, 'manual', '2026-04-22 02:30:55', '2026-04-22 02:30:55'),
(32, 7, 9, 'tidak_hadir', NULL, 'manual', '2026-04-22 02:30:55', '2026-04-22 02:30:55'),
(33, 7, 4, 'tidak_hadir', NULL, 'manual', '2026-04-22 02:30:55', '2026-04-22 02:30:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-gedeadit643@gmail.com|2001:448a:5010:87c6:a112:a0a6:8aa5:5269', 'i:1;', 1776242986),
('laravel-cache-gedeadit643@gmail.com|2001:448a:5010:87c6:a112:a0a6:8aa5:5269:timer', 'i:1776242986;', 1776242986),
('laravel-cache-seketaris@gmail.comm|127.0.0.1', 'i:1;', 1775723915),
('laravel-cache-seketaris@gmail.comm|127.0.0.1:timer', 'i:1775723915;', 1775723915);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cash_groups`
--

CREATE TABLE `cash_groups` (
  `id` bigint UNSIGNED NOT NULL,
  `organization_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cash_groups`
--

INSERT INTO `cash_groups` (`id`, `organization_id`, `title`, `amount`, `description`, `created_at`, `updated_at`) VALUES
(4, 1, 'Uang Iyuran', 100000, 'Wajib', '2026-03-08 00:28:31', '2026-04-18 09:29:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cash_payments`
--

CREATE TABLE `cash_payments` (
  `id` bigint UNSIGNED NOT NULL,
  `cash_schedule_id` bigint UNSIGNED NOT NULL,
  `member_id` bigint UNSIGNED NOT NULL,
  `status` enum('paid','unpaid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cash_payments`
--

INSERT INTO `cash_payments` (`id`, `cash_schedule_id`, `member_id`, `status`, `paid_at`, `created_at`, `updated_at`) VALUES
(64, 25, 1, 'unpaid', NULL, '2026-04-16 07:22:40', '2026-04-16 07:22:40'),
(65, 25, 2, 'unpaid', NULL, '2026-04-16 07:22:40', '2026-04-16 07:22:40'),
(66, 25, 3, 'unpaid', NULL, '2026-04-16 07:22:40', '2026-04-18 09:44:06'),
(67, 25, 4, 'unpaid', NULL, '2026-04-16 07:22:40', '2026-04-18 09:55:17'),
(68, 25, 8, 'unpaid', NULL, '2026-04-16 07:22:40', '2026-04-16 07:22:40'),
(69, 26, 1, 'unpaid', NULL, '2026-04-16 07:32:07', '2026-04-18 09:55:12'),
(70, 26, 2, 'paid', '2026-04-20 02:45:53', '2026-04-16 07:32:07', '2026-04-20 02:45:53'),
(71, 26, 3, 'paid', '2026-04-16 07:32:12', '2026-04-16 07:32:07', '2026-04-16 07:32:12'),
(72, 26, 4, 'unpaid', NULL, '2026-04-16 07:32:07', '2026-04-18 09:55:25'),
(73, 26, 8, 'paid', '2026-04-16 07:32:20', '2026-04-16 07:32:07', '2026-04-16 07:32:20'),
(74, 27, 1, 'unpaid', NULL, '2026-04-16 07:32:07', '2026-04-16 07:32:07'),
(75, 27, 2, 'unpaid', NULL, '2026-04-16 07:32:07', '2026-04-18 09:55:33'),
(76, 27, 3, 'unpaid', NULL, '2026-04-16 07:32:07', '2026-04-18 09:55:32'),
(77, 27, 4, 'unpaid', NULL, '2026-04-16 07:32:07', '2026-04-18 09:44:01'),
(78, 27, 8, 'unpaid', NULL, '2026-04-16 07:32:07', '2026-04-18 09:44:04'),
(79, 28, 1, 'unpaid', NULL, '2026-04-16 07:32:07', '2026-04-18 09:55:28'),
(80, 28, 2, 'unpaid', NULL, '2026-04-16 07:32:07', '2026-04-16 07:32:07'),
(81, 28, 3, 'unpaid', NULL, '2026-04-16 07:32:07', '2026-04-18 09:55:29'),
(82, 28, 4, 'unpaid', NULL, '2026-04-16 07:32:07', '2026-04-16 07:32:07'),
(83, 28, 8, 'unpaid', NULL, '2026-04-16 07:32:07', '2026-04-16 07:32:07'),
(84, 25, 9, 'unpaid', NULL, '2026-04-16 07:40:02', '2026-04-18 09:55:31'),
(85, 25, 10, 'paid', '2026-04-20 03:35:51', '2026-04-20 03:30:08', '2026-04-20 03:35:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cash_schedules`
--

CREATE TABLE `cash_schedules` (
  `id` bigint UNSIGNED NOT NULL,
  `cash_group_id` bigint UNSIGNED NOT NULL,
  `due_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cash_schedules`
--

INSERT INTO `cash_schedules` (`id`, `cash_group_id`, `due_date`, `created_at`, `updated_at`) VALUES
(25, 4, '2026-04-30', '2026-04-16 07:22:40', '2026-04-16 07:22:40'),
(26, 4, '2026-04-10', '2026-04-16 07:32:07', '2026-04-16 07:32:07'),
(27, 4, '2026-04-12', '2026-04-16 07:32:07', '2026-04-16 07:32:07'),
(28, 4, '2026-04-18', '2026-04-16 07:32:07', '2026-04-16 07:32:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `financial_categories`
--

CREATE TABLE `financial_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `organization_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('income','expense') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `financial_categories`
--

INSERT INTO `financial_categories` (`id`, `organization_id`, `name`, `type`, `created_at`, `updated_at`) VALUES
(1, 1, 'Kas Anggota', 'income', '2026-03-08 00:25:03', '2026-03-08 00:25:03'),
(2, 1, 'Donasi', 'income', '2026-03-08 00:25:24', '2026-03-08 00:25:24'),
(3, 1, 'Konsumsi', 'expense', '2026-03-08 00:25:42', '2026-03-08 00:25:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `financial_transactions`
--

CREATE TABLE `financial_transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `organization_id` bigint UNSIGNED NOT NULL,
  `transaction_date` datetime NOT NULL,
  `type` enum('income','expense') COLLATE utf8mb4_unicode_ci NOT NULL,
  `source` enum('manual','cash_payment') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'manual',
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `amount` decimal(15,2) NOT NULL,
  `cash_payment_id` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `financial_transactions`
--

INSERT INTO `financial_transactions` (`id`, `organization_id`, `transaction_date`, `type`, `source`, `category`, `description`, `amount`, `cash_payment_id`, `created_by`, `created_at`, `updated_at`) VALUES
(21, 1, '2026-04-16 00:00:00', 'income', 'cash_payment', 'Kas Anggota', 'Pembayaran kas anggota', 50000.00, 71, 2, '2026-04-16 07:32:12', '2026-04-16 07:32:12'),
(23, 1, '2026-04-16 00:00:00', 'income', 'cash_payment', 'Kas Anggota', 'Pembayaran kas anggota', 50000.00, 73, 2, '2026-04-16 07:32:20', '2026-04-16 07:32:20'),
(29, 1, '2026-04-18 00:00:00', 'expense', 'manual', 'Konsumsi', 'Beli alat', 100000.00, NULL, 4, '2026-04-18 09:21:01', '2026-04-18 09:27:38'),
(40, 1, '2026-04-20 10:45:53', 'income', 'cash_payment', 'Kas Anggota', 'Pembayaran kas anggota', 100000.00, 70, 2, '2026-04-20 02:45:53', '2026-04-20 02:45:53'),
(41, 1, '2026-04-20 11:35:51', 'income', 'cash_payment', 'Kas Anggota', 'Pembayaran kas anggota', 100000.00, 85, 1, '2026-04-20 03:35:51', '2026-04-20 03:35:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_03_06_065258_create_roles_table', 1),
(5, '2026_03_06_065304_create_villages_table', 1),
(6, '2026_03_06_065316_create_organizations_table', 1),
(7, '2026_03_06_065325_create_organization_members_table', 1),
(8, '2026_03_06_070113_add_role_id_and_organization_id_to_users_table', 1),
(9, '2026_03_06_081648_create_activities_table', 1),
(10, '2026_03_06_084518_create_activity_attendances_table', 1),
(11, '2026_03_06_133839_create_cash_groups_table', 1),
(12, '2026_03_06_133840_create_cash_schedules_table', 1),
(13, '2026_03_06_133845_create_cash_payments_table', 1),
(14, '2026_03_06_141641_add_user_id_to_organization_members_table', 1),
(15, '2026_03_08_063508_create_financial_transactions_table', 2),
(16, '2026_03_08_073911_create_financial_categories_table', 3),
(17, '2026_03_10_155343_create_proposals_table', 4),
(18, '2026_03_10_161851_remove_requested_amount_from_proposals', 5),
(19, '2026_03_12_164148_add_target_to_proposals_table', 6),
(20, '2026_03_13_145340_create_proposal_messages_table', 7),
(21, '2026_03_15_123809_add_qr_fields_to_activity_attendances_table', 8),
(22, '2026_04_16_234200_create_settings_table', 9),
(23, '2026_04_16_235000_create_webhook_logs_table', 10),
(24, '2026_04_18_100000_add_coords_to_activities_table', 11),
(25, '2026_04_19_000000_add_radius_meter_to_activities_table', 12),
(26, '2026_04_19_073000_change_transaction_date_to_datetime_in_financial_transactions_table', 13),
(27, '2026_04_19_080000_change_activity_date_to_datetime_in_activities_table', 14);

-- --------------------------------------------------------

--
-- Struktur dari tabel `organizations`
--

CREATE TABLE `organizations` (
  `id` bigint UNSIGNED NOT NULL,
  `village_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `established_date` date DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `leader_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secretary_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `treasurer_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `legal_doc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `organizations`
--

INSERT INTO `organizations` (`id`, `village_id`, `name`, `type`, `established_date`, `address`, `phone`, `email`, `leader_name`, `secretary_name`, `treasurer_name`, `logo`, `legal_doc`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'WYB', 'STT', '2026-03-07', 'bali\r\ngianyar', '087840335041', 'xiaditshiro@gmail.com', 'Koming', 'Gede', 'Wayab', NULL, NULL, 'aktif', '2026-03-06 08:04:17', '2026-03-06 08:04:17'),
(2, 1, 'Tempek kajanan', 'STT', '2026-03-08', 'bali\r\ngianyar', '087840335041', 'xiaditshiro@gmail.com', 'Koming', 'Gede', 'Wayab', NULL, NULL, 'aktif', '2026-03-07 20:53:17', '2026-03-16 07:50:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `organization_members`
--

CREATE TABLE `organization_members` (
  `id` bigint UNSIGNED NOT NULL,
  `organization_id` bigint UNSIGNED NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('L','P') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_place` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` enum('ketua','sekretaris','bendahara','anggota') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'anggota',
  `join_date` date DEFAULT NULL,
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `organization_members`
--

INSERT INTO `organization_members` (`id`, `organization_id`, `full_name`, `nik`, `gender`, `birth_place`, `birth_date`, `address`, `phone`, `position`, `join_date`, `status`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 1, 'Xiadit shiro', '5104031609040004', 'L', 'Gianyar', '2026-03-07', 'bali\r\ngianyar', NULL, 'anggota', '2026-03-07', 'aktif', '2026-03-06 08:04:44', '2026-04-18 10:18:13', 3),
(2, 1, 'shiro', '5104036209050004', 'P', 'Gianyar', '2026-03-07', 'bali\r\ngianyar', NULL, 'bendahara', '2026-03-07', 'aktif', '2026-03-06 08:05:06', '2026-04-18 10:18:07', 2),
(3, 1, 'ShiroNE', '5104031609040004', 'L', 'Gianyar', '2026-03-07', 'bali\r\ngianyar', '087840335041', 'ketua', '2026-03-07', 'aktif', '2026-03-06 20:54:12', '2026-04-18 10:18:00', 4),
(4, 1, 'Xiadit shiro', '5104031609040004', 'P', 'Gianyar', '2026-03-08', 'bali\r\ngianyar', NULL, 'sekretaris', '2026-03-08', 'aktif', '2026-03-07 10:31:24', '2026-04-18 10:17:08', 5),
(5, 2, 'Xiadit shiro', '5104031609040004', 'L', 'Gianyar', '2026-03-08', 'bali\r\ngianyar', NULL, 'ketua', '2026-03-08', 'aktif', '2026-03-07 20:53:51', '2026-04-18 10:17:43', 8),
(6, 2, 'Xiadit shiro', '5104031609040004', 'L', 'Gianyar', '2026-03-08', 'bali\r\ngianyar', NULL, 'bendahara', '2026-03-08', 'aktif', '2026-03-07 20:54:20', '2026-04-18 10:17:15', 7),
(8, 1, 'Clasi', '234245252345234', 'P', 'Gianyar', '2025-02-05', 'bali\r\ngianyar', NULL, 'anggota', '2026-04-16', 'aktif', '2026-04-16 07:10:53', '2026-04-22 02:40:36', 10),
(9, 1, 'SURYA', NULL, 'L', 'Gianyar', '2026-04-17', 'bali\r\ngianyar', NULL, 'anggota', '2026-04-21', 'aktif', '2026-04-16 07:40:02', '2026-04-16 18:14:10', 11),
(10, 1, 'Aldi', '234245252345234', 'L', 'Gianyar', '2026-04-09', 'bali\r\ngianyar', '081246562480', 'anggota', '2026-04-20', 'aktif', '2026-04-20 03:30:08', '2026-04-20 03:31:10', 12);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('gedeadit643@gmail.com', '$2y$12$RjBxtpquoQpDZC3X89tHXeVI.JjDwo/aaAtsXS7cIikS2HW9hUG9a', '2026-03-16 09:38:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `proposals`
--

CREATE TABLE `proposals` (
  `id` bigint UNSIGNED NOT NULL,
  `organization_id` bigint UNSIGNED NOT NULL,
  `target_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `proposal_date` date NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `admin_notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `target_organization_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `proposals`
--

INSERT INTO `proposals` (`id`, `organization_id`, `target_type`, `created_by`, `title`, `proposal_date`, `description`, `file_path`, `status`, `admin_notes`, `created_at`, `updated_at`, `target_organization_id`) VALUES
(2, 1, 'organization', 4, 'csdcz', '2026-03-13', 'szczsc', 'proposals/MrG37w0o5ushJJvM8dSvWrT9pX8Tb63ofnzm6pUG.pdf', 'rejected', NULL, '2026-03-12 09:12:09', '2026-03-12 09:35:35', 2),
(3, 1, 'organization', 4, 'TESSS2', '2026-03-13', '2QEW12WE2 1', 'proposals/bT5jsHIP0nKTNQmJjhOd7EtHsIISWjGix50XNeQc.pdf', 'pending', NULL, '2026-03-12 09:52:59', '2026-03-12 09:52:59', 2),
(4, 1, 'desa', 4, 'UNDANGAN ULTAH STT WYB', '2026-04-11', 'TESSSSS', 'proposals/mgzsD3hvzhIJAqJ0nTyjl3BBZAadeYC294yEC5bB.pdf', 'pending', NULL, '2026-04-06 06:01:56', '2026-04-06 06:01:56', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `proposal_messages`
--

CREATE TABLE `proposal_messages` (
  `id` bigint UNSIGNED NOT NULL,
  `proposal_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `proposal_messages`
--

INSERT INTO `proposal_messages` (`id`, `proposal_id`, `user_id`, `message`, `created_at`, `updated_at`) VALUES
(1, 3, 5, 'tess chat', '2026-03-13 06:59:32', '2026-03-13 06:59:32'),
(2, 3, 8, 'iya kenapa?', '2026-03-13 07:00:02', '2026-03-13 07:00:02'),
(3, 3, 1, 'Halo Tess', '2026-03-16 09:02:24', '2026-03-16 09:02:24'),
(4, 4, 1, 'proposalmu kurang bagus blok', '2026-04-09 00:44:41', '2026-04-09 00:44:41'),
(5, 4, 1, 'alo', '2026-04-18 09:03:31', '2026-04-18 09:03:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `created_at`, `updated_at`) VALUES
(1, 'super_admin', 'Super Admin', '2026-03-06 07:51:14', '2026-03-06 07:51:14'),
(2, 'admin_desa', 'Admin Desa', '2026-03-06 07:51:14', '2026-03-06 07:51:14'),
(3, 'ketua', 'Ketua', '2026-03-06 07:51:14', '2026-03-06 07:51:14'),
(4, 'sekretaris', 'Sekretaris', '2026-03-06 07:51:14', '2026-03-06 07:51:14'),
(5, 'bendahara', 'Bendahara', '2026-03-06 07:51:14', '2026-03-06 07:51:14'),
(6, 'anggota', 'Anggota', '2026-03-06 07:51:14', '2026-03-06 07:51:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('8MvV45RG8y0Vg76A5kiypj2XoZ8giLlfNBF1SX7P', 3, '2001:448a:5010:87c6:a112:a0a6:8aa5:5269', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiN2FCcHhKU3dZeTRYWlpXV29WbDNOY0g0SXlpcGRJS2hYM2F1SHh2TiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjY6Imh0dHBzOi8vc3VpdGVkLWNvbnZlbmllbnRseS1sb3JlZS5uZ3Jvay1mcmVlLmRldi9hbmdnb3RhL2Rhc2hib2FyZCI7czo1OiJyb3V0ZSI7czoxNzoiYW5nZ290YS5kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozO30=', 1776241104),
('dBDPYn3kkc4XsY6SOm3dYmDFPq2EYQPmClW3lHoz', 1, '2001:448a:5010:87c6:a112:a0a6:8aa5:5269', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOXdyM09rMGlycE9ubXpSWDAxY3VhWldYVHo2UnByWjFLemlvSXBLYSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Njk6Imh0dHBzOi8vc3VpdGVkLWNvbnZlbmllbnRseS1sb3JlZS5uZ3Jvay1mcmVlLmRldi9zdXBlcmFkbWluL2Rhc2hib2FyZCI7czo1OiJyb3V0ZSI7czoyMDoic3VwZXJhZG1pbi5kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1776241090),
('eco7Wr9ojHE0n0RZ54LVvcMX96KfzuLy5feIA3JX', 4, '2001:448a:5010:87c6:a112:a0a6:8aa5:5269', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWVBEVzkxVkc3ZzNhT1V5c2xHSEJNVzhLbTN3YmFpcVlGN1BuZ21GVCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjQ6Imh0dHBzOi8vc3VpdGVkLWNvbnZlbmllbnRseS1sb3JlZS5uZ3Jvay1mcmVlLmRldi9rZXR1YS9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6ImtldHVhLmRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQ7fQ==', 1776241117),
('GncOMD9Os793Pj1Qv2L6qPk53U6JBV75wRNyZvsN', 1, '2001:448a:5010:87c6:a45a:e023:b70:ec', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMGRtaGZBTEx1RldHQUgwMEc4WGNtYm5IY3M2cVBSR2syTHVJdjRtViI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTQ6Imh0dHBzOi8vc3VpdGVkLWNvbnZlbmllbnRseS1sb3JlZS5uZ3Jvay1mcmVlLmRldi91c2VycyI7czo1OiJyb3V0ZSI7czoxMToidXNlcnMuaW5kZXgiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1776010800),
('oxaLcU16UNysEK9x0URAFHMBRpAPHdrFACNnMQvQ', 1, '2001:448a:5010:87c6:a112:a0a6:8aa5:5269', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidklub1FRdFFYSXRJa0ZnWG9CSU9md0lLUkxvUzRIU3Z3ZklManlpZiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTQ6Imh0dHBzOi8vc3VpdGVkLWNvbnZlbmllbnRseS1sb3JlZS5uZ3Jvay1mcmVlLmRldi9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1776241029),
('p4IeeVIRFCAbl2imx8wczkFP2BwdWwOIZ7dhpCA7', 5, '2001:448a:5010:87c6:a112:a0a6:8aa5:5269', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQjJrM3Z1VHdEUGU1SVpvc2lXM05leEtYdTcwbjVwb3p0Q01tdE5uaSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Njk6Imh0dHBzOi8vc3VpdGVkLWNvbnZlbmllbnRseS1sb3JlZS5uZ3Jvay1mcmVlLmRldi9zZWtyZXRhcmlzL2Rhc2hib2FyZCI7czo1OiJyb3V0ZSI7czoyMDoic2VrcmV0YXJpcy5kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo1O30=', 1776241125),
('w0IVusRxPKVJyvxpmxro1etr8Fk5FAViJfkh8wxU', 2, '2001:448a:5010:87c6:a112:a0a6:8aa5:5269', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiN2FxeU5aRFpPNU1GWjR4eW9jaHZCWGk0blZIZVhKeXc2YUZJUnM1TyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Njg6Imh0dHBzOi8vc3VpdGVkLWNvbnZlbmllbnRseS1sb3JlZS5uZ3Jvay1mcmVlLmRldi9iZW5kYWhhcmEvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjE5OiJiZW5kYWhhcmEuZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1776241073),
('WTaiTOUQOaEORAsnTGmGNct6AbKEhmeYPqSVp7eq', 5, '2001:448a:5010:87c6:a45a:e023:b70:ec', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNW5MSWhBMGwwYU82RlF2STJuTHNyUUQxdmxFQTNjTW45aHZFQVhoTCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTY6Imh0dHBzOi8vc3VpdGVkLWNvbnZlbmllbnRseS1sb3JlZS5uZ3Jvay1mcmVlLmRldi9tZW1iZXJzIjtzOjU6InJvdXRlIjtzOjEzOiJtZW1iZXJzLmluZGV4Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NTt9', 1776010826);

-- --------------------------------------------------------

--
-- Struktur dari tabel `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'chatbot_active', 'true', '2026-04-16 07:45:44', '2026-04-22 02:40:23'),
(2, 'maintenance_mode', 'false', '2026-04-16 07:55:14', '2026-04-20 03:35:11'),
(3, 'chatbot_standby_message', 'Maaf, asisten AI sedang dalam mode istirahat. Silakan hubungi pengurus organisasi secara langsung. Terima kasih 🙏', '2026-04-16 07:55:14', '2026-04-16 07:55:14'),
(4, 'wa_receipt_enabled', 'true', '2026-04-22 02:31:02', '2026-04-22 02:40:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED DEFAULT NULL,
  `organization_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `role_id`, `organization_id`, `name`, `email`, `email_verified_at`, `password`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'Shiro Super Admin', 'superadmin@gmail.com', NULL, '$2y$12$YovKFoH9qxVnVil7bZ4HYu4yaNFRFrRsUQLKMV/IIfVDpNGAS9tIa', 1, NULL, '2026-03-06 07:47:45', '2026-04-09 00:43:24'),
(2, 5, 1, 'shiro', 'bendahara@gmail.com', NULL, '$2y$12$kkDOkkqy6YT//m6Yurhhpu5DUBdF0rLG48Q4fyttln68IEmTQCIpC', 1, 'ukeiEmbB44O54mNQo3n8VCazr6qsXuhNJY2w9J8WxY7YkKyXgcTcyzitz6iX', '2026-03-06 20:18:04', '2026-03-07 10:22:26'),
(3, 6, 1, 'Xiadit shiro', 'angota@gmail.com', NULL, '$2y$12$k2C/oZYhjhKMsFrHlJ7tMeGtk9/VlXb/gm4z5iJ02vqiej7IH2tCi', 1, 'PGK5NTK93BLGS1CwJ2ANNF9xoSCWaMilQmsYUxeuwht4tazjdgwHe9aW7LFF', '2026-03-06 20:18:24', '2026-03-07 10:22:13'),
(4, 3, 1, 'ShiroNE', 'ketua@gmail.com', NULL, '$2y$12$NNp3oDAqGWzT97wLeq6ieOOvanijD3WtY0iQXu4qZKV2w/FpTL3k2', 1, 'y8QBVjdz0Kv5VmuzsImK89RyMloXKkPr77UqD0IPM4fZepNaHJtSRH2OOsm0', '2026-03-06 20:54:23', '2026-04-18 10:18:00'),
(5, 4, 1, 'Xiadit shiro', 'seketaris@gmail.com', NULL, '$2y$12$b.jYZ/uKFtCF1mEJeLw2EOidGqXhkZlLsM8XquJ5SYuDJd0ReGiU.', 1, NULL, '2026-03-07 10:31:32', '2026-03-07 10:32:01'),
(6, 2, 1, 'Xiadit shiro', 'admindesa@test.com', NULL, '$2y$12$nYm5Ep72BN.wl677uX06Y.qfTX7eLQrRNZBux/g7KByP0xpS1xlVm', 1, NULL, '2026-03-07 10:42:48', '2026-03-07 10:42:48'),
(7, 5, 2, 'Xiadit shiro', 'bendaharakajanan@gmail.com', NULL, '$2y$12$K/M2Gen8zBpd08X0Cxl5suZCDC1IRkj9s4Lo28Vtilce2lWyvFBdu', 1, NULL, '2026-03-07 20:54:24', '2026-03-07 20:55:24'),
(8, 3, 2, 'Xiadit shiro', 'ketuakajanan@gmail.com', NULL, '$2y$12$1oZYV9haEmEhkY/UDn9vxeTptRR2yvX707vHjTbfEu.sfCduX7BK.', 1, NULL, '2026-03-07 20:54:26', '2026-03-07 20:55:06'),
(10, 6, 1, 'Clasi', 'clasi@gmail.com', NULL, '$2y$12$5GIV3nUNo/FGMJ74Ln.nV.nq1Sr7GWojJlhl6frXjZ/.H6AU96KH2', 1, NULL, '2026-04-16 07:10:59', '2026-04-18 08:49:22'),
(11, 6, 1, 'SURYA', 'surya@simorgdes.local', NULL, '$2y$12$o2DDe6m7Ub8paiIxQHjqgOlEbkQPBWrKRn7uiyXDNP9UfQHK1mxFW', 1, NULL, '2026-04-16 18:14:10', '2026-04-16 18:14:10'),
(12, 6, 1, 'Aldi', 'aldi@simorgdes.local', NULL, '$2y$12$DkoBydM4CVBbD3Zg0Y7qruSXPhyWXwPvooqcs5Zvk/RWKMjC28BvS', 1, NULL, '2026-04-20 03:31:10', '2026-04-20 03:31:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `villages`
--

CREATE TABLE `villages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `regency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `villages`
--

INSERT INTO `villages` (`id`, `name`, `district`, `regency`, `province`, `address`, `postal_code`, `phone`, `email`, `created_at`, `updated_at`) VALUES
(1, 'Tegal Tuggu', 'Gianyar', 'gianyar', 'Bali', 'bali\r\ngianyar', '80511', '087840335041', 'xiaditshiro@gmail.com', '2026-03-06 08:03:44', '2026-03-06 08:03:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `webhook_logs`
--

CREATE TABLE `webhook_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `sender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `response` text COLLATE utf8mb4_unicode_ci,
  `status` enum('success','failed','skipped') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'success',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `webhook_logs`
--

INSERT INTO `webhook_logs` (`id`, `sender`, `message`, `response`, `status`, `created_at`, `updated_at`) VALUES
(1, '6287840335041', 'kas yang belum saya bayar berapa?', 'Maaf, asisten AI sedang dalam mode istirahat. Silakan hubungi pengurus organisasi secara langsung. Terima kasih 🙏', 'skipped', '2026-04-16 08:03:26', '2026-04-16 08:03:26'),
(2, '6287840335041', 'kas yang belum saya bayar berapa?', 'Selamat Malam 🌃, shiro. \nAnda memiliki beberapa kas yang belum dibayar, yaitu:\n1. Uantg Iyuran dengan jatuh tempo 2026-04-30 sebesar Rp 50.000\n2. Uantg Iyuran dengan jatuh tempo 2026-04-10 sebesar Rp 50.000\n3. Uantg Iyuran dengan jatuh tempo 2026-04-18 sebesar Rp 50.000\n\nTotal kas yang belum dibayar adalah Rp 150.000 💸. \n\nUntuk mencatat pembayaran, Anda bisa masuk ke menu \'Kas Anggota\' > klik detail jadwal > klik \'Lunas\' 📝.', 'success', '2026-04-16 08:03:50', '2026-04-16 08:03:50'),
(3, '6287840335041', 'Halo', '🌞 Selamat Pagi! 🌞 Saya Shiro Bot, Asisten AI Virtual untuk sistem SimOrgDes. Bagaimana saya bisa membantu Anda hari ini? 🤔', 'success', '2026-04-16 18:01:45', '2026-04-16 18:01:45'),
(4, '6287840335041', 'Kas yang belum dibayar lagi berapa woi', 'Maaf, terjadi gangguan pada otak AI saya (Groq). Status: 400', 'success', '2026-04-18 10:06:52', '2026-04-18 10:06:52'),
(5, '6287840335041', 'Kas yang belum dibayar lagi berapa woi', 'Selamat Malam 🌃, shiro. \n\nBerikut adalah daftar kas yang belum dibayar lagi:\n\n1. Uang Iyuran (Jatuh tempo: 2026-04-30) - Rp 100.000 📝\n2. Uang Iyuran (Jatuh tempo: 2026-04-10) - Rp 100.000 📝\n3. Uang Iyuran (Jatuh tempo: 2026-04-12) - Rp 100.000 📝\n4. Uang Iyuran (Jatuh tempo: 2026-04-18) - Rp 100.000 📝\n\nTotal kas yang belum dibayar: Rp 400.000 💸\n\nUntuk mencatat pembayaran, kamu bisa masuk ke menu \'Kas Anggota\' > klik detail jadwal > klik \'Lunas\'. 💡', 'success', '2026-04-18 10:09:30', '2026-04-18 10:09:30'),
(6, '6287840335041', 'apakah ada jadwal kegiatan yang akan datang?', 'Selamat Malam 🌃, shiro. \nYa, ada jadwal kegiatan yang akan datang. Berdasarkan data sistem, organisasi WYB memiliki kegiatan yang berjudul \"RAPAT\" yang akan dilaksanakan pada tanggal 30 April 2026 di Banjar Kaja Kauh. 📅\nUntuk melihat lebih detail, Anda bisa masuk ke menu \'Kegiatan\'. 📊', 'success', '2026-04-18 10:11:18', '2026-04-18 10:11:18'),
(7, '6287840335041', 'Kas yang belum dibayar lagi berapa woi', 'Selamat Malam 🌃, ShiroNE! 🙏\n\nUntuk melihat kas yang belum dibayar, kamu bisa masuk ke menu \'Kas Anggota\' dan lihat detail jadwal. Namun, saya bisa membantu kamu dengan informasi yang ada di sistem. 🤔\n\nBerdasarkan data sistem, terdapat beberapa kas yang belum dibayar dengan total sekitar 300.000 (3 kali 100.000). 📊\n\nJika kamu ingin melihat lebih detail, saya sarankan kamu untuk masuk ke menu \'Kas Anggota\' dan lihat detail jadwal untuk melihat kas yang belum dibayar. 📝', 'success', '2026-04-18 10:32:54', '2026-04-18 10:32:54'),
(8, '6287840335041', 'kas yang belum dibayar berapa wiiiiii', 'Selamat Malam 🌃, ShiroNE! 🙏\n\nUntuk melihat kas yang belum dibayar, Anda bisa masuk ke menu \'Kas Anggota\' dan lihat detail jadwal. Namun, saya bisa membantu Anda dengan data yang ada di sistem. 📊\n\nBerdasarkan data sistem, Anda memiliki beberapa kas yang belum dibayar dengan total amount sebesar 300.000 (100.000 + 100.000 + 100.000). 📝\n\nBerikut adalah daftar kas yang belum dibayar:\n1. Uang Iyuran (due date: 2026-04-30) - 100.000\n2. Uang Iyuran (due date: 2026-04-12) - 100.000\n3. Uang Iyuran (due date: 2026-04-18) - 100.000\n\nSilakan masuk ke menu \'Kas Anggota\' untuk melihat lebih lanjut! 📈', 'success', '2026-04-18 10:39:19', '2026-04-18 10:39:19'),
(9, '6287840335041', 'HALO', 'Selamat Sore 🌅! Saya Shiro Bot, asisten virtual untuk SimOrgDes. Bagaimana saya bisa membantu Anda hari ini? 🤔', 'success', '2026-04-20 02:33:33', '2026-04-20 02:33:33'),
(10, '6287840335041', 'HALO', 'Maaf, asisten AI sedang dalam mode istirahat. Silakan hubungi pengurus organisasi secara langsung. Terima kasih 🙏', 'skipped', '2026-04-20 02:34:06', '2026-04-20 02:34:06'),
(11, '6287840335041', 'oi', 'Maaf, asisten AI sedang dalam mode istirahat. Silakan hubungi pengurus organisasi secara langsung. Terima kasih 🙏', 'skipped', '2026-04-20 03:24:31', '2026-04-20 03:24:31'),
(12, '6287840335041', 'oi blok jadwal kegiatan bulain ini apa aja', 'Selamat Malam 🌃, ShiroNE! 🙋‍♂️\n\nUntuk melihat jadwal kegiatan bulan ini, kamu bisa masuk ke menu \'Kegiatan\' 📅. Di sana, kamu bisa melihat semua kegiatan yang telah dijadwalkan, termasuk tanggal, lokasi, dan deskripsi kegiatan 📝.\n\nBerikut adalah kegiatan yang dijadwalkan bulan ini:\n\n1. Rapat Rutin 📅 - 25 April 2026 - Banjar Kaja Kauh\n2. Rapat Rutin 📅 - 25 April 2026 - Banjar\n3. RAPAT 📅 - 30 April 2026 - Banjar Kaja Kauh\n\nSemoga informasi ini membantu! 🤞', 'success', '2026-04-20 03:25:23', '2026-04-20 03:25:23'),
(13, '6287840335041', 'saya lagi berapa belum bayar uang kas?', 'Selamat Sore 🌅, ShiroNE! \n\nSaya melihat data Anda di sistem SimOrgDes. Anda memiliki beberapa pembayaran yang belum dilunasi, yaitu: \n\n1. Uang Iyuran dengan due date 2026-04-30 sebesar Rp 100.000\n2. Uang Iyuran dengan due date 2026-04-12 sebesar Rp 100.000\n3. Uang Iyuran dengan due date 2026-04-18 sebesar Rp 100.000\n\nTotal tagihan yang belum dibayar adalah Rp 300.000 📊. \n\nUntuk mencatat pembayaran, Anda bisa meminta bantuan Bendahara atau Admin untuk mengakses menu \'Kas Anggota\' > klik detail jadwal > klik \'Lunas\' 📝.', 'success', '2026-04-22 02:48:23', '2026-04-22 02:48:23'),
(14, '6287840335041', 'lagi berapa saya belum bayar uang kas', 'Selamat Malam 🌃, ShiroNE! \nSaya melihat data kas Anda, dan ada beberapa pembayaran yang belum lunas. Total tagihan yang belum dibayarkan adalah:\n\n- Uang Iyuran (jatuh tempo 30 April 2026): Rp 100.000\n- Uang Iyuran (jatuh tempo 10 April 2026): sudah lunas\n- Uang Iyuran (jatuh tempo 12 April 2026): Rp 100.000\n- Uang Iyuran (jatuh tempo 18 April 2026): Rp 100.000\n\nJadi, total yang belum Anda bayar adalah Rp 300.000 📊. \nUntuk mencatat pembayaran, Anda bisa masuk ke menu \'Kas Anggota\' > klik detail jadwal > klik \'Lunas\' 📝.', 'success', '2026-04-22 03:08:50', '2026-04-22 03:08:50'),
(15, '6287840335041', 'halo', 'Selamat Sore 🌅! Saya Shiro Bot, asisten virtual untuk SimOrgDes. Bagaimana saya bisa membantu Anda hari ini? 🤔', 'success', '2026-04-29 02:41:30', '2026-04-29 02:41:30');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activities_organization_id_foreign` (`organization_id`);

--
-- Indeks untuk tabel `activity_attendances`
--
ALTER TABLE `activity_attendances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `activity_attendances_activity_id_member_id_unique` (`activity_id`,`member_id`),
  ADD KEY `activity_attendances_member_id_foreign` (`member_id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cash_groups`
--
ALTER TABLE `cash_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cash_groups_organization_id_foreign` (`organization_id`);

--
-- Indeks untuk tabel `cash_payments`
--
ALTER TABLE `cash_payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cash_payments_cash_schedule_id_member_id_unique` (`cash_schedule_id`,`member_id`),
  ADD KEY `cash_payments_member_id_foreign` (`member_id`);

--
-- Indeks untuk tabel `cash_schedules`
--
ALTER TABLE `cash_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cash_schedules_cash_group_id_foreign` (`cash_group_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `financial_categories`
--
ALTER TABLE `financial_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `financial_categories_organization_id_foreign` (`organization_id`);

--
-- Indeks untuk tabel `financial_transactions`
--
ALTER TABLE `financial_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `financial_transactions_organization_id_foreign` (`organization_id`),
  ADD KEY `financial_transactions_cash_payment_id_foreign` (`cash_payment_id`),
  ADD KEY `financial_transactions_created_by_foreign` (`created_by`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organizations_village_id_foreign` (`village_id`);

--
-- Indeks untuk tabel `organization_members`
--
ALTER TABLE `organization_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organization_members_organization_id_foreign` (`organization_id`),
  ADD KEY `organization_members_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `proposals`
--
ALTER TABLE `proposals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proposals_organization_id_foreign` (`organization_id`),
  ADD KEY `proposals_created_by_foreign` (`created_by`),
  ADD KEY `proposals_target_organization_id_foreign` (`target_organization_id`);

--
-- Indeks untuk tabel `proposal_messages`
--
ALTER TABLE `proposal_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proposal_messages_proposal_id_foreign` (`proposal_id`),
  ADD KEY `proposal_messages_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`),
  ADD KEY `users_organization_id_foreign` (`organization_id`);

--
-- Indeks untuk tabel `villages`
--
ALTER TABLE `villages`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `webhook_logs`
--
ALTER TABLE `webhook_logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `activities`
--
ALTER TABLE `activities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `activity_attendances`
--
ALTER TABLE `activity_attendances`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `cash_groups`
--
ALTER TABLE `cash_groups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `cash_payments`
--
ALTER TABLE `cash_payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT untuk tabel `cash_schedules`
--
ALTER TABLE `cash_schedules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `financial_categories`
--
ALTER TABLE `financial_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `financial_transactions`
--
ALTER TABLE `financial_transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `organization_members`
--
ALTER TABLE `organization_members`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `proposals`
--
ALTER TABLE `proposals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `proposal_messages`
--
ALTER TABLE `proposal_messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `villages`
--
ALTER TABLE `villages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `webhook_logs`
--
ALTER TABLE `webhook_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `activity_attendances`
--
ALTER TABLE `activity_attendances`
  ADD CONSTRAINT `activity_attendances_activity_id_foreign` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `activity_attendances_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `organization_members` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `cash_groups`
--
ALTER TABLE `cash_groups`
  ADD CONSTRAINT `cash_groups_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `cash_payments`
--
ALTER TABLE `cash_payments`
  ADD CONSTRAINT `cash_payments_cash_schedule_id_foreign` FOREIGN KEY (`cash_schedule_id`) REFERENCES `cash_schedules` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cash_payments_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `organization_members` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `cash_schedules`
--
ALTER TABLE `cash_schedules`
  ADD CONSTRAINT `cash_schedules_cash_group_id_foreign` FOREIGN KEY (`cash_group_id`) REFERENCES `cash_groups` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `financial_categories`
--
ALTER TABLE `financial_categories`
  ADD CONSTRAINT `financial_categories_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `financial_transactions`
--
ALTER TABLE `financial_transactions`
  ADD CONSTRAINT `financial_transactions_cash_payment_id_foreign` FOREIGN KEY (`cash_payment_id`) REFERENCES `cash_payments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `financial_transactions_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `financial_transactions_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `organizations`
--
ALTER TABLE `organizations`
  ADD CONSTRAINT `organizations_village_id_foreign` FOREIGN KEY (`village_id`) REFERENCES `villages` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `organization_members`
--
ALTER TABLE `organization_members`
  ADD CONSTRAINT `organization_members_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `organization_members_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `proposals`
--
ALTER TABLE `proposals`
  ADD CONSTRAINT `proposals_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `proposals_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `proposals_target_organization_id_foreign` FOREIGN KEY (`target_organization_id`) REFERENCES `organizations` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `proposal_messages`
--
ALTER TABLE `proposal_messages`
  ADD CONSTRAINT `proposal_messages_proposal_id_foreign` FOREIGN KEY (`proposal_id`) REFERENCES `proposals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `proposal_messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
