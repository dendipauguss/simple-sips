-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table sips.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','pegawai','ketua_tim') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pegawai',
  `status` tinyint NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sips.users: ~12 rows (approximately)
INSERT INTO `users` (`id`, `nama`, `email`, `username`, `password`, `role`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES	
	(5, 'Agus Sulistiyanto', 'agussulistiyanto@gmail.com', 'agussulistiyanto', '$2y$12$ZFGGPn/a5vEc/fKCNseREu1M2QuaJLex1bKlsYOc4a/YcsDYZMGrO', 'pegawai', 1, NULL, '2026-01-05 01:56:24', '2026-01-05 01:56:24'),
	(6, 'Bernard Asido', 'bernardasido@gmail.com', 'bernardasido', '$2y$12$5PypSxO3wpIdXAlL2s0pMeoP4vpDV8FolDTK1NbIKvqzxOczb8HmG', 'pegawai', 1, NULL, '2026-01-05 01:57:53', '2026-01-05 01:57:53'),
	(7, 'Pirdaus Sabana', 'pirdaussabana@gmail.com', 'pirdaussabana', '$2y$12$PeMyjrXkakvwr2W2bdcOq.CWTGc3Vq4J9thu43jpK.B8Go4muIzSy', 'pegawai', 1, NULL, '2026-01-05 01:58:46', '2026-01-05 01:58:46'),
	(8, 'Chandra Fredrik Purba', 'chandrafredrikpurba@gmail.com', 'chandrafredrikpurba', '$2y$12$xSd9cz/67cJTTGA.HBE.KeDI2AKuX0ce1F/efBpcl8HkLXxNSu9iu', 'pegawai', 1, NULL, '2026-01-05 01:59:46', '2026-01-05 01:59:46'),
	(9, 'Tito Yassin', 'titoyassin@gmail.com', 'titoyassin', '$2y$12$t30j4V5skg4zAQOJw7yI2eiah0stqPG.w0vZsEY.mDewps1Ia0oWy', 'pegawai', 1, NULL, '2026-01-05 02:00:18', '2026-01-05 02:00:18'),
	(10, 'Rendy Cisara Sandy', 'rendycisarasandy@gmail.com', 'rendycisarasandy', '$2y$12$RBwdBShGsFdxoGgjQg9aFetk/LR1vZSjqlWLPCnxKKGIc0W59NIGq', 'pegawai', 1, NULL, '2026-01-05 02:01:14', '2026-01-05 02:01:14'),
	(11, 'Aulia Puspa Ramadhani', 'auliapusparamadhani@gmail.com', 'auliapusparamadhani', '$2y$12$jdv9lpTaKRg6ZMzZ4UNnAeKV0h8t2GBYFygmHdKB0/gaco9.0zfzy', 'pegawai', 1, NULL, '2026-01-05 02:02:16', '2026-01-05 02:02:16'),
	(12, 'Amser Irawan Panjaitan', 'amserirawanpanjaitan@gmail.com', 'amserirawanpanjaitan', '$2y$12$bIAi3YOJ.pFlPQI0T2Sx.eIVHGC6x1eUdd6e9Uuos6RsgRrEJlFf6', 'ketua_tim', 1, NULL, '2026-01-05 02:03:55', '2026-01-05 21:31:31');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
caffe_db