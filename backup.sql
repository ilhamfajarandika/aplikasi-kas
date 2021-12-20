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

-- Dumping data for table kas.anggota: ~5 rows (approximately)
/*!40000 ALTER TABLE `anggota` DISABLE KEYS */;
INSERT INTO `anggota` (`idanggota`, `nama`) VALUES
	(1, 'Aldi'),
	(2, 'Agus'),
	(3, 'Sukri'),
	(4, 'Denis'),
	(17, 'Muhammad Ali Nurdin Nugroho');
/*!40000 ALTER TABLE `anggota` ENABLE KEYS */;

-- Dumping data for table kas.role_user: ~2 rows (approximately)
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
INSERT INTO `role_user` (`idrole`, `role`) VALUES
	(1, 'admin'),
	(2, 'super user'),
	(3, 'member');
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;

-- Dumping data for table kas.transaksi: ~16 rows (approximately)
/*!40000 ALTER TABLE `transaksi` DISABLE KEYS */;
INSERT INTO `transaksi` (`idtransaksi`, `idanggota`, `notransaksi`, `indikator`, `tanggal`, `nominal`, `rincian`, `jenis`) VALUES
	(154, 1, 'IM-836856-20211202', 'hadi@20211202.144757', '2021-12-02', 20000, 'kas', 'M'),
	(156, 17, 'IM-863225-20211202', 'hadi@20211202.150150', '2021-12-02', 20000, 'makan nasi', 'K'),
	(159, 2, 'IM-230126-20211207', 'hadi@20211207.093513', '2021-12-07', 398500, 'Meja', 'K'),
	(160, 1, 'IM-453097-20211202', 'hadi@20211208.150931', '2021-12-02', 400000, 'makan', 'M'),
	(161, 1, 'IM-693783-20211208', 'hadi@20211208.164116', '2021-12-08', 10000, 'misedap', 'M'),
	(162, 4, 'IM-766133-20210108', 'hadi@20211208.170006', '2021-01-08', 550000, 'misedap', 'K'),
	(164, 1, 'MG-3529-20211220', 'hadi-MG@20211220.105154', '2021-09-01', 122000, 'misedap', 'K'),
	(165, 2, 'MG-4538-20211220', 'hadi-MG@20211220.105154', '2021-08-30', 20000, 'indomie', 'M'),
	(166, 2, 'MG-4091-20211220', 'hadi-MG@20211220.105154', '2021-08-24', 120000, 'Pemakaman', 'M'),
	(167, 2, 'MG-2293-20211220', 'hadi-MG@20211220.105154', '2021-09-01', 123000, 'makan', 'K'),
	(168, 2, 'MG-3569-20211220', 'hadi-MG@20211220.105154', '2021-09-01', 253000, 'makan', 'K'),
	(169, 2, 'MG-2647-20211220', 'hadi-MG@20211220.105154', '2021-09-02', 20000, 'makan', 'M'),
	(170, 2, 'MG-4662-20211220', 'hadi-MG@20211220.105154', '2021-09-09', 12000, 'minum', 'M'),
	(171, 3, 'MG-1415-20211220', 'hadi-MG@20211220.105154', '2021-09-03', 600000, 'Pemasukan Anggota', 'M'),
	(172, 4, 'MG-3921-20211220', 'hadi-MG@20211220.105154', '2021-08-11', 250000, 'gaus', 'M'),
	(173, 4, 'MG-1116-20211220', 'hadi-MG@20211220.105154', '2021-09-06', 87000, 'Makan', 'K');
/*!40000 ALTER TABLE `transaksi` ENABLE KEYS */;

-- Dumping data for table kas.user: ~4 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`iduser`, `nama`, `email`, `password`, `image`, `is_active`, `role_id`, `last_seen`, `date_created`) VALUES
	(4, 'Sukri', 'sukri@gmail.com', '$2y$10$nDKqVfbPUFfni9XrPw0WKe3Lxun7jmhWFhfY369nMh76Z4i0Fr9r6', 'default.jpg', 0, 2, '2021-12-20 09:56:00', '2021-08-26'),
	(22, 'Hadi', 'hadi@gmail.com', '$2y$10$XSKiaAV.7wT.yAdPhqRttOxygdNIShwHqm0HcHK0uJl89dsQRqiHa', 'default.jpg', 0, 1, '2021-12-20 11:30:41', '2021-08-27'),
	(26, 'Dewi', 'dewi@gmail.com', '$2y$10$TgVXfH9EatENU.caDa1/lO77XIi0QNN8twcNdm115W0iAhoMFBKF2', 'default.jpg', 0, 3, '2021-12-20 09:50:12', '2021-12-06');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
