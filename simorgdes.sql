-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 09 Apr 2026 pada 09.17
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
  `activity_date` date NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('draft','scheduled','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `activities`
--

INSERT INTO `activities` (`id`, `organization_id`, `title`, `activity_date`, `location`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Iyuran', '2026-03-08', 'Banjar Kaja Kauh', 'Wajib', 'scheduled', '2026-03-06 08:05:48', '2026-03-06 08:05:48'),
(2, 1, 'Tesss', '2026-03-12', 'Banjar Kaja Kauh', 'Tesss', 'scheduled', '2026-03-06 08:44:39', '2026-03-06 08:44:39'),
(3, 1, 'tess', '2026-03-09', 'Banjar Kaja Kauh', 'wewae', 'scheduled', '2026-03-07 21:25:08', '2026-03-07 21:25:08'),
(4, 2, 'Mereresik', '2026-03-14', 'Banjar Kaja Kauh', 'tessss', 'scheduled', '2026-03-13 10:07:11', '2026-03-13 10:07:30');

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
(1, 2, 3, 'tidak_hadir', NULL, 'manual', '2026-03-07 21:13:57', '2026-03-15 08:42:40'),
(2, 2, 2, 'tidak_hadir', NULL, 'manual', '2026-03-07 21:13:57', '2026-03-15 08:42:40'),
(3, 2, 1, 'hadir', '2026-03-15 08:59:43', 'qr', '2026-03-07 21:13:57', '2026-03-15 08:59:43'),
(4, 2, 4, 'tidak_hadir', NULL, 'manual', '2026-03-07 21:13:57', '2026-03-15 08:42:40'),
(5, 3, 3, 'tidak_hadir', NULL, 'manual', '2026-03-07 21:36:41', '2026-03-15 05:25:32'),
(6, 3, 2, 'tidak_hadir', NULL, 'manual', '2026-03-07 21:36:41', '2026-03-07 21:36:41'),
(7, 3, 1, 'hadir', '2026-03-15 08:58:40', 'qr', '2026-03-07 21:36:41', '2026-03-15 08:58:40'),
(8, 3, 4, 'tidak_hadir', NULL, 'manual', '2026-03-07 21:36:41', '2026-03-15 05:25:32'),
(9, 1, 3, 'tidak_hadir', NULL, 'manual', '2026-03-07 21:37:19', '2026-03-07 21:37:19'),
(10, 1, 2, 'tidak_hadir', NULL, 'manual', '2026-03-07 21:37:19', '2026-03-15 08:48:19'),
(11, 1, 1, 'hadir', '2026-03-23 07:45:49', 'qr', '2026-03-07 21:37:19', '2026-03-23 07:45:49'),
(12, 1, 4, 'tidak_hadir', NULL, 'manual', '2026-03-07 21:37:19', '2026-03-15 08:48:19'),
(13, 4, 5, 'hadir', NULL, 'manual', '2026-03-15 04:22:46', '2026-03-15 04:22:46'),
(14, 4, 6, 'hadir', NULL, 'manual', '2026-03-15 04:22:46', '2026-03-15 04:22:46');

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
(4, 1, 'Uantg Iyuran', 50000, 'Wajib', '2026-03-08 00:28:31', '2026-03-08 00:28:31');

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
(37, 19, 1, 'unpaid', NULL, '2026-03-08 00:28:31', '2026-03-08 00:28:31'),
(38, 19, 2, 'paid', '2026-03-13 20:55:19', '2026-03-08 00:28:31', '2026-03-13 20:55:19'),
(39, 19, 3, 'paid', '2026-03-15 04:19:41', '2026-03-08 00:28:31', '2026-03-15 04:19:41'),
(40, 19, 4, 'paid', '2026-04-09 00:22:24', '2026-03-08 00:28:31', '2026-04-09 00:22:24'),
(41, 20, 1, 'paid', '2026-03-13 20:55:20', '2026-03-08 00:28:31', '2026-03-13 20:55:20'),
(42, 20, 2, 'unpaid', NULL, '2026-03-08 00:28:31', '2026-03-08 00:28:31'),
(43, 20, 3, 'unpaid', NULL, '2026-03-08 00:28:31', '2026-03-13 20:54:20'),
(44, 20, 4, 'unpaid', NULL, '2026-03-08 00:28:31', '2026-03-13 20:54:14'),
(45, 21, 1, 'unpaid', NULL, '2026-03-08 00:28:31', '2026-03-08 08:10:09'),
(46, 21, 2, 'unpaid', NULL, '2026-03-08 00:28:31', '2026-03-13 20:54:16'),
(47, 21, 3, 'paid', '2026-03-15 04:19:42', '2026-03-08 00:28:31', '2026-03-15 04:19:42'),
(48, 21, 4, 'unpaid', NULL, '2026-03-08 00:28:31', '2026-03-13 20:54:15');

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
(19, 4, '2026-03-08', '2026-03-08 00:28:31', '2026-03-08 00:28:31'),
(20, 4, '2026-03-11', '2026-03-08 00:28:31', '2026-03-08 00:28:31'),
(21, 4, '2026-03-14', '2026-03-08 00:28:31', '2026-03-08 00:28:31');

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
  `transaction_date` date NOT NULL,
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
(12, 1, '2026-03-14', 'income', 'cash_payment', 'Kas Anggota', 'Pembayaran kas anggota', 50000.00, 38, 2, '2026-03-13 20:55:19', '2026-03-13 20:55:19'),
(13, 1, '2026-03-14', 'income', 'cash_payment', 'Kas Anggota', 'Pembayaran kas anggota', 50000.00, 41, 2, '2026-03-13 20:55:20', '2026-03-13 20:55:20'),
(14, 1, '2026-03-15', 'income', 'cash_payment', 'Kas Anggota', 'Pembayaran kas anggota', 50000.00, 39, 2, '2026-03-15 04:19:41', '2026-03-15 04:19:41'),
(15, 1, '2026-03-15', 'income', 'cash_payment', 'Kas Anggota', 'Pembayaran kas anggota', 50000.00, 47, 2, '2026-03-15 04:19:42', '2026-03-15 04:19:42'),
(16, 1, '2026-04-09', 'income', 'cash_payment', 'Kas Anggota', 'Pembayaran kas anggota', 50000.00, 40, 1, '2026-04-09 00:22:24', '2026-04-09 00:22:24');

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
(21, '2026_03_15_123809_add_qr_fields_to_activity_attendances_table', 8);

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
(1, 1, 'Xiadit shiro', '5104031609040004', 'L', 'Gianyar', '2026-03-07', 'bali\r\ngianyar', '087840335041', 'anggota', '2026-03-07', 'aktif', '2026-03-06 08:04:44', '2026-03-06 20:18:24', 3),
(2, 1, 'shiro', '5104036209050004', 'P', 'Gianyar', '2026-03-07', 'bali\r\ngianyar', '087840335041', 'bendahara', '2026-03-07', 'aktif', '2026-03-06 08:05:06', '2026-03-06 20:52:48', 2),
(3, 1, 'AAN 1', '5104031609040004', 'L', 'Gianyar', '2026-03-07', 'bali\r\ngianyar', '087840335041', 'ketua', '2026-03-07', 'aktif', '2026-03-06 20:54:12', '2026-03-06 20:59:52', 4),
(4, 1, 'Xiadit shiro', '5104031609040004', 'P', 'Gianyar', '2026-03-08', 'bali\r\ngianyar', '087840335041', 'sekretaris', '2026-03-08', 'aktif', '2026-03-07 10:31:24', '2026-03-07 10:31:32', 5),
(5, 2, 'Xiadit shiro', '5104031609040004', 'L', 'Gianyar', '2026-03-08', 'bali\r\ngianyar', '087840335041', 'ketua', '2026-03-08', 'aktif', '2026-03-07 20:53:51', '2026-03-07 20:54:26', 8),
(6, 2, 'Xiadit shiro', '5104031609040004', 'L', 'Gianyar', '2026-03-08', 'bali\r\ngianyar', '087840335041', 'bendahara', '2026-03-08', 'aktif', '2026-03-07 20:54:20', '2026-03-16 08:07:14', 7);

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
(4, 4, 1, 'proposalmu kurang bagus blok', '2026-04-09 00:44:41', '2026-04-09 00:44:41');

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
('gMyMgFw5oFb07mqlKgljkVM8NXaiEK9Yyglx0ur7', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTnR2ODFhT3ZXYklHSFBVYzF2U05ESGtCMDgwVFozMlVRT0g4ZUdPeiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTM6Imh0dHA6Ly9zdWl0ZWQtY29udmVuaWVudGx5LWxvcmVlLm5ncm9rLWZyZWUuZGV2L2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9fQ==', 1775725677),
('ZPJ1kfOLm3oci40AnT2jxX9hcqFYPHw6c00pyLfA', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiR2ttd2RZNHFVN3l2M2hDTWZ1WnUyelg4eWFEY3pDZnA4bW1pRDQwNSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Njc6Imh0dHA6Ly9zdWl0ZWQtY29udmVuaWVudGx5LWxvcmVlLm5ncm9rLWZyZWUuZGV2L2JlbmRhaGFyYS9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTk6ImJlbmRhaGFyYS5kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1775723185);

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
(2, 5, 1, 'shiro', 'bendahara@gmail.com', NULL, '$2y$12$kkDOkkqy6YT//m6Yurhhpu5DUBdF0rLG48Q4fyttln68IEmTQCIpC', 1, NULL, '2026-03-06 20:18:04', '2026-03-07 10:22:26'),
(3, 6, 1, 'Xiadit shiro', 'angota@gmail.com', NULL, '$2y$12$k2C/oZYhjhKMsFrHlJ7tMeGtk9/VlXb/gm4z5iJ02vqiej7IH2tCi', 1, 'tmUW4HC2aFKppF1M2jk4ENyyA3fKLkb5SL55QybYZuxIXNXZReA9iP49kkGg', '2026-03-06 20:18:24', '2026-03-07 10:22:13'),
(4, 3, 1, 'AAN 1', 'ketua@gmail.com', NULL, '$2y$12$NNp3oDAqGWzT97wLeq6ieOOvanijD3WtY0iQXu4qZKV2w/FpTL3k2', 1, NULL, '2026-03-06 20:54:23', '2026-03-07 10:21:54'),
(5, 4, 1, 'Xiadit shiro', 'seketaris@gmail.com', NULL, '$2y$12$b.jYZ/uKFtCF1mEJeLw2EOidGqXhkZlLsM8XquJ5SYuDJd0ReGiU.', 1, NULL, '2026-03-07 10:31:32', '2026-03-07 10:32:01'),
(6, 2, 1, 'Xiadit shiro', 'admindesa@test.com', NULL, '$2y$12$nYm5Ep72BN.wl677uX06Y.qfTX7eLQrRNZBux/g7KByP0xpS1xlVm', 1, NULL, '2026-03-07 10:42:48', '2026-03-07 10:42:48'),
(7, 5, 2, 'Xiadit shiro', 'bendaharakajanan@gmail.com', NULL, '$2y$12$K/M2Gen8zBpd08X0Cxl5suZCDC1IRkj9s4Lo28Vtilce2lWyvFBdu', 1, NULL, '2026-03-07 20:54:24', '2026-03-07 20:55:24'),
(8, 3, 2, 'Xiadit shiro', 'ketuakajanan@gmail.com', NULL, '$2y$12$1oZYV9haEmEhkY/UDn9vxeTptRR2yvX707vHjTbfEu.sfCduX7BK.', 1, NULL, '2026-03-07 20:54:26', '2026-03-07 20:55:06');

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
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `activities`
--
ALTER TABLE `activities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `activity_attendances`
--
ALTER TABLE `activity_attendances`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `cash_groups`
--
ALTER TABLE `cash_groups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `cash_payments`
--
ALTER TABLE `cash_payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT untuk tabel `cash_schedules`
--
ALTER TABLE `cash_schedules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `organization_members`
--
ALTER TABLE `organization_members`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `proposals`
--
ALTER TABLE `proposals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `proposal_messages`
--
ALTER TABLE `proposal_messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `villages`
--
ALTER TABLE `villages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
