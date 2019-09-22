-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 23 Sep 2019 pada 02.23
-- Versi server: 10.3.13-MariaDB-log
-- Versi PHP: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `amanbos`
--

DELIMITER $$
--
-- Prosedur
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `koderekening_lengkap` ()  BEGIN
	#Routine body goes here...
	WITH RECURSIVE category_path (id, nama_rekening, parent_id, path, kode, deleted_at) AS
(
	SELECT id, nama_rekening, parent_id, kode_rekening as path, kode_rekening, deleted_at
		FROM koderekening
		WHERE parent_id IS NULL
	UNION ALL
	SELECT c.id, c.nama_rekening, c.parent_id, CONCAT(cp.path, '.', c.kode_rekening), kode_rekening, c.deleted_at
		FROM category_path AS cp JOIN koderekening AS c
			ON cp.id = c.parent_id
)
SELECT * FROM category_path
ORDER BY path;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `koderekening_node` ()  BEGIN
	#Routine body goes here...
	WITH RECURSIVE category_path (id, nama_rekening, nomor_rekening,parent_id, kode, deleted_at) AS
(
SELECT id, nama_rekening, kode_rekening as nomor_rekening, parent_id, kode_rekening, deleted_at
	FROM koderekening
	WHERE parent_id IS NULL
UNION ALL
SELECT c.id, c.nama_rekening, CONCAT(cp.nomor_rekening, '.', c.kode_rekening), c.parent_id, c.kode_rekening, c.deleted_at
	FROM category_path AS cp JOIN koderekening AS c
		ON cp.id = c.parent_id
)
SELECT
core.id, core.nama_rekening, nomor_rekening,
kr2.nama_rekening as parent, kode, core.deleted_at
FROM category_path core
INNER JOIN koderekening kr2 ON kr2.id=core.parent_id
ORDER BY nomor_rekening;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(5) NOT NULL,
  `telepon` varchar(20) NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `nama`, `username`, `password`, `role`, `telepon`, `foto`) VALUES
(1, 'admin', 'admin', 'admin', 1, '08123456789', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `belanjas`
--

CREATE TABLE `belanjas` (
  `id` int(11) NOT NULL,
  `triwulan` tinyint(1) NOT NULL,
  `rka_id` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `nilai` float NOT NULL,
  `tanggal_belanja` date DEFAULT NULL,
  `nomor` varchar(255) DEFAULT NULL,
  `penerima` varchar(255) DEFAULT NULL,
  `ppn` float DEFAULT NULL,
  `pph21` float DEFAULT NULL,
  `pph23` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `belanjas`
--

INSERT INTO `belanjas` (`id`, `triwulan`, `rka_id`, `nama`, `nilai`, `tanggal_belanja`, `nomor`, `penerima`, `ppn`, `pph21`, `pph23`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'Gaji GTT S1', 820000, '2019-01-30', '1', 'Pak Min dan GTT Lainnya', 0, 0, 0, '2019-09-21 07:09:57', '2019-09-21 07:09:57', NULL),
(2, 1, 2, 'Gaji GTT D4', 820000, '2019-01-30', '2', 'Pak Man dan GTT Lainnya', 0, 0, 0, '2019-09-21 07:13:59', '2019-09-21 07:13:59', NULL),
(3, 1, 3, 'Beli Kertas A4 21 RIM', 945000, '2019-01-10', 'ATK/01', 'Toko Makin Jaya', 94500, 0, 0, '2019-09-21 07:17:19', '2019-09-21 07:17:19', NULL),
(4, 1, 4, 'Beli Materai 6000', 300000, '2019-01-16', 'OFC/01', 'Kantor POS Ambarawa', 0, 0, 0, '2019-09-21 07:19:33', '2019-09-21 07:23:01', NULL),
(5, 1, 5, 'Pembayaran Telepon dan Internet', 500000, '2019-01-20', 'OC/01', 'SuperNet, PT', 50000, 0, 0, '2019-09-21 07:21:52', '2019-09-21 07:21:52', NULL),
(6, 1, 6, 'Pembayaran Listrik PLN', 1000000, '2019-01-22', 'OC/02', 'PLN', 100000, 0, 0, '2019-09-21 07:24:17', '2019-09-21 07:24:17', NULL),
(7, 1, 7, 'Foto Copy Berkas', 100000, '2019-01-31', '03', 'Toko FC Cepat', 0, 0, 0, '2019-09-21 07:25:46', '2019-09-21 07:25:46', NULL),
(8, 1, 8, 'Beli Printer', 2500000, '2019-02-04', '04', 'Computer Media Store', 250000, 0, 0, '2019-09-21 07:27:07', '2019-09-21 07:27:07', NULL),
(9, 1, 3, 'Beli Kertas A4 21 RIM', 945000, '2019-02-06', '05', 'Toko Buku Meriah', 94500, 0, 0, '2019-09-22 05:39:45', '2019-09-22 05:39:45', NULL),
(10, 1, 7, 'Foto Copy Ulangan Harian', 240000, '2019-02-11', '06', 'FC Mekar', 0, 0, 0, '2019-09-22 05:41:02', '2019-09-22 05:41:02', NULL),
(11, 1, 7, 'Fotokopi berkas kantor', 160000, '2019-02-18', '07', 'FC Mekar', 0, 0, 0, '2019-09-22 05:42:08', '2019-09-22 05:42:08', NULL),
(12, 1, 5, 'Bayar Telepon dan Internet', 500000, '2019-02-19', 'OC/04', 'SuperNet, PT', 50000, 0, 0, '2019-09-22 05:43:54', '2019-09-22 05:43:54', NULL),
(13, 1, 6, 'Bayar Tagihan Listrik', 1000000, '2019-02-20', 'OC/05', 'PLN', 100000, 0, 0, '2019-09-22 05:45:18', '2019-09-22 05:45:18', NULL),
(14, 1, 3, 'Beli Kertas A4 21 RIM', 945000, '2019-03-04', '08', 'Toko Buku Juang', 94500, 0, 0, '2019-09-22 05:46:55', '2019-09-22 05:46:55', NULL),
(15, 1, 7, 'Fotokopi berkas kantor', 100000, '2019-03-11', '09', 'FC Megah', 0, 0, 0, '2019-09-22 05:47:52', '2019-09-22 05:47:52', NULL),
(16, 1, 7, 'Fotokopi Ulangan Tengah Semester', 300000, '2019-03-18', '10', 'FC Murah', 0, 0, 0, '2019-09-22 05:48:56', '2019-09-22 05:48:56', NULL),
(17, 1, 5, 'Bayar Telepon dan Internet', 500000, '2019-03-19', 'OC/07', 'SuperNet, PT', 50000, 0, 0, '2019-09-22 05:49:50', '2019-09-22 05:49:50', NULL),
(18, 1, 6, 'Bayar Tagihan Listrik', 1000000, '2019-03-20', 'OC/08', 'PLN', 100000, 0, 0, '2019-09-22 05:50:48', '2019-09-22 05:50:48', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `belanjathlalus`
--

CREATE TABLE `belanjathlalus` (
  `id` int(11) NOT NULL,
  `ta` year(4) NOT NULL,
  `npsn` varchar(15) NOT NULL,
  `triwulan` tinyint(1) NOT NULL DEFAULT 4,
  `program_id` int(11) NOT NULL,
  `pembiayaan_id` int(11) NOT NULL,
  `rekening_id` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `nilai` float NOT NULL,
  `tanggal_belanja` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `belanjathlalu_modals`
--

CREATE TABLE `belanjathlalu_modals` (
  `id` int(11) NOT NULL,
  `belanjathlalu_id` int(11) NOT NULL,
  `nama_barang` varchar(500) NOT NULL,
  `merek` varchar(255) DEFAULT NULL,
  `tipe` varchar(255) DEFAULT NULL,
  `bahan` varchar(255) DEFAULT NULL,
  `bukti_tanggal` int(2) NOT NULL,
  `bukti_bulan` int(2) NOT NULL,
  `bukti_nomor` int(100) NOT NULL,
  `satuan` varchar(255) DEFAULT NULL,
  `harga_satuan` float NOT NULL,
  `qty` int(5) NOT NULL,
  `total` float NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `belanjathlalu_persediaans`
--

CREATE TABLE `belanjathlalu_persediaans` (
  `id` int(11) NOT NULL,
  `belanjathlalu_id` int(11) NOT NULL,
  `nama_persediaan` varchar(500) NOT NULL,
  `satuan` varchar(255) NOT NULL,
  `harga_satuan` float NOT NULL,
  `qty` int(5) NOT NULL,
  `total` float NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `belanja_modals`
--

CREATE TABLE `belanja_modals` (
  `id` int(11) NOT NULL,
  `belanja_id` int(11) NOT NULL,
  `nama_barang` varchar(500) NOT NULL,
  `kode_barang` int(11) DEFAULT NULL,
  `warna` varchar(255) DEFAULT NULL,
  `merek` varchar(255) DEFAULT NULL,
  `tipe` varchar(255) DEFAULT NULL,
  `bahan` varchar(255) DEFAULT NULL,
  `bukti_tanggal` date DEFAULT NULL,
  `bukti_bulan` int(2) DEFAULT NULL,
  `bukti_nomor` varchar(255) DEFAULT NULL,
  `satuan` varchar(255) DEFAULT NULL,
  `harga_satuan` float NOT NULL,
  `qty` int(5) NOT NULL,
  `total` float NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `belanja_modals`
--

INSERT INTO `belanja_modals` (`id`, `belanja_id`, `nama_barang`, `kode_barang`, `warna`, `merek`, `tipe`, `bahan`, `bukti_tanggal`, `bukti_bulan`, `bukti_nomor`, `satuan`, `harga_satuan`, `qty`, `total`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 8, 'Printer EPSON L3600', 357, 'Hitam', 'EPSON', 'L3600', 'Elektronik', '2019-02-04', NULL, 'ABC/02/19/000291', 'Unit', 2500000, 1, 2500000, '2019-09-21 08:53:58', '2019-09-21 08:53:58', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `belanja_persediaans`
--

CREATE TABLE `belanja_persediaans` (
  `id` int(11) NOT NULL,
  `belanja_id` int(11) NOT NULL,
  `nama_persediaan` varchar(500) NOT NULL,
  `satuan` varchar(255) NOT NULL,
  `harga_satuan` float NOT NULL,
  `qty` int(5) NOT NULL,
  `total` float NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `belanja_persediaans`
--

INSERT INTO `belanja_persediaans` (`id`, `belanja_id`, `nama_persediaan`, `satuan`, `harga_satuan`, `qty`, `total`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 'Kertas A4', 'RIM', 45000, 21, 945000, '2019-09-21 07:58:42', '2019-09-21 07:58:42', NULL),
(2, 4, 'Materai 6000', 'pcs', 6000, 50, 300000, '2019-09-21 07:59:54', '2019-09-21 07:59:54', NULL),
(3, 9, 'Kertas A4 Sidu', 'RIM', 45000, 21, 945000, '2019-09-22 05:54:30', '2019-09-22 05:54:30', NULL),
(4, 14, 'Kertas A4 Sidu', 'RIM', 45000, 21, 945000, '2019-09-22 05:54:57', '2019-09-22 05:54:57', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kecamatan`
--

CREATE TABLE `kecamatan` (
  `id` int(11) NOT NULL,
  `nama_kecamatan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kecamatan`
--

INSERT INTO `kecamatan` (`id`, `nama_kecamatan`) VALUES
(1, 'UNGARAN BARAT'),
(2, 'UNGARAN TIMUR'),
(3, 'BERGAS'),
(4, 'PRINGAPUS'),
(5, 'BAWEN'),
(6, 'BRINGIN'),
(7, 'TUNTANG'),
(8, 'PABELAN'),
(9, 'BANCAK'),
(10, 'SURUH'),
(11, 'SUSUKAN'),
(12, 'KALIWUNGU'),
(13, 'TENGARAN'),
(14, 'GETASAN'),
(15, 'BANYUBIRU'),
(16, 'SUMOWONO'),
(17, 'AMBARAWA'),
(18, 'JAMBU'),
(19, 'BANDUNGAN');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kodebarang`
--

CREATE TABLE `kodebarang` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `parent_rekening` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kodebarang`
--

INSERT INTO `kodebarang` (`id`, `kode_barang`, `nama_barang`, `parent_rekening`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1.3.2.01.03.05.010.', 'Pompa Air', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(2, '1.3.2.02.02.01.001.', 'Gerobak Tarik', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(3, '1.3.2.02.02.01.002.', 'Gerobak Dorong', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(4, '1.3.2.02.02.02.001.', 'Sepeda', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(5, '1.3.2.03.01.06.001.', 'Mesin Gergaji', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(6, '1.3.2.03.01.06.002.', 'Mesin Ketam (Perkakas Bengkel Kayu)', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(7, '1.3.2.03.01.06.003.', 'Mesin Bor Kayu', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(8, '1.3.2.03.01.06.004.', 'Mesin Penghalus', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(9, '1.3.2.03.01.06.007.', 'Pasah Listrik MKC', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(10, '1.3.2.03.01.06.008.', 'Profile Listrik MKC', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(11, '1.3.2.03.01.06.010.', 'Gergaji Bengkok ATS', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(12, '1.3.2.03.01.06.011.', 'Amplas Listrik GMT', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(13, '1.3.2.03.01.06.012.', 'Gergaji Chain Saw', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(14, '1.3.2.03.01.06.013.', 'Table Saw 10 Eastco', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(15, '1.3.2.03.01.06.014.', 'Dst....', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(16, '1.3.2.05.01.01.001.', 'Mesin Ketik Manual Portable (11-13 Inci)', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(17, '1.3.2.05.01.01.002.', 'Mesin Ketik Manual Standard (14-16Inci)', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(18, '1.3.2.05.01.01.003.', 'Mesin Ketik Manual Langewagon (18-27Inci)', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(19, '1.3.2.05.01.01.004.', 'Mesin Ketik Listrik', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(20, '1.3.2.05.01.01.005.', 'Mesin Ketik Listrik Potable (11-13 Inci)', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(21, '1.3.2.05.01.01.006.', 'Mesin Ketik Listrik Standard (14-16 Inci)', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(22, '1.3.2.05.01.01.007.', 'Mesin Ketik Listrik Langewagon (18-27Inci)', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(23, '1.3.2.05.01.01.008.', 'Mesin Ketik Elektronik/Selektrik', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(24, '1.3.2.05.01.01.009.', 'Mesin Ketik Braille', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(25, '1.3.2.05.01.01.010.', 'Mesin Phromosons', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(26, '1.3.2.05.01.01.011.', 'Mesin Cetak Stereo Piper (Braille)', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(27, '1.3.2.05.01.01.012.', 'Mesin Ketik Lainnya ', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(28, '1.3.2.05.01.03.001.', 'Mesin Stensil Manual Folio', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(29, '1.3.2.05.01.03.002.', 'Mesin Stensil Manual Double Folio', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(30, '1.3.2.05.01.03.003.', 'Mesin Stensil Listrik Folio', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(31, '1.3.2.05.01.03.004.', 'Mesin Stensil Listrik Double Folio', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(32, '1.3.2.05.01.03.005.', 'Mesin Stensil Spiritus Manual', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(33, '1.3.2.05.01.03.006.', 'Mesin Stensil Spiritus Listrik', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(34, '1.3.2.05.01.03.007.', 'Mesin Fotocopy Folio', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(35, '1.3.2.05.01.03.008.', 'Mesin Fotocopy Double Folio', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(36, '1.3.2.05.01.03.009.', 'Mesin Fotocopy Electronic', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(37, '1.3.2.05.01.03.010.', 'Mesin Thermoforn', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(38, '1.3.2.05.01.03.011.', 'Mesin Fotocopy Lainnya', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(39, '1.3.2.05.01.03.012.', 'Risograf', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(40, '1.3.2.05.01.03.013.', 'Mesin Perekam Stensil Folio', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(41, '1.3.2.05.01.03.014.', 'Mesin Perekam Stensil Double Folio', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(42, '1.3.2.05.01.03.015.', 'Mesin Plate Folio', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(43, '1.3.2.05.01.03.016.', 'Mesin Plate Double Folio', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(44, '1.3.2.05.01.03.017.', 'Mesin Reproduksi Lainnya ', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(45, '1.3.2.05.01.03.018.', 'Dst....', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(46, '1.3.2.05.01.04.001.', 'Lemari Besi/Metal', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(47, '1.3.2.05.01.04.002.', 'Lemari Kayu', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(48, '1.3.2.05.01.04.003.', 'Rak Besi', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(49, '1.3.2.05.01.04.004.', 'Rak Kayu', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(50, '1.3.2.05.01.04.005.', 'Filing Cabinet Besi', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(51, '1.3.2.05.01.04.006.', 'Filing Cabinet Kayu', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(52, '1.3.2.05.01.04.007.', 'Brandkas', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(53, '1.3.2.05.01.04.008.', 'Peti Uang/Cash Box/Coin Box', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(54, '1.3.2.05.01.04.009.', 'Kardex Besi', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(55, '1.3.2.05.01.04.010.', 'Kardex Kayu', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(56, '1.3.2.05.01.04.011.', 'Rotary Filling', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(57, '1.3.2.05.01.04.012.', 'Compact Rolling', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(58, '1.3.2.05.01.04.013.', 'Buffet', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(59, '1.3.2.05.01.04.014.', 'Mobile File', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(60, '1.3.2.05.01.04.015.', 'Locker', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(61, '1.3.2.05.01.04.016.', 'Roll Opek', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(62, '1.3.2.05.01.04.017.', 'Tempat Menyimpan Gambar', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(63, '1.3.2.05.01.04.018.', 'Kontainer', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(64, '1.3.2.05.01.04.019.', 'Coin Box', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(65, '1.3.2.05.01.04.020.', 'Lemari Display', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(66, '1.3.2.05.01.04.021.', 'Water Proof Box', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(67, '1.3.2.05.01.04.022.', 'Folding Container Box', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(68, '1.3.2.05.01.04.023.', 'Box Truck', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(69, '1.3.2.05.01.04.024.', 'Laci Box', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(70, '1.3.2.05.01.04.025.', 'Lemari Katalog', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(71, '1.3.2.05.01.04.026.', 'Lemari Sorok', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(72, '1.3.2.05.01.04.027.', 'Lemari Kaca', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(73, '1.3.2.05.01.04.028.', 'Lemari Makan', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(74, '1.3.2.05.01.04.030.', 'Alat Penyimpanan Perlengkapan Kantor Lainnya ', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(75, '1.3.2.05.01.05.001.', 'Narkotik Test', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(76, '1.3.2.05.01.05.002.', 'CCTV - Camera Control TelevisionSystem', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(77, '1.3.2.05.01.05.003.', 'Papan Visual/Papan Nama', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(78, '1.3.2.05.01.05.004.', 'Movitex Board', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(79, '1.3.2.05.01.05.005.', 'White Board', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(80, '1.3.2.05.01.05.006.', 'Alat Detektor Uang Palsu', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(81, '1.3.2.05.01.05.007.', 'Alat Detektor Barang Terlarang/X Ray', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(82, '1.3.2.05.01.05.008.', 'Copy Board/Elektric White Board', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(83, '1.3.2.05.01.05.009.', 'Peta', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(84, '1.3.2.05.01.05.010.', 'Alat Penghancur Kertas', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(85, '1.3.2.05.01.05.011.', 'Globe', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(86, '1.3.2.05.01.05.012.', 'Mesin Absensi', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(87, '1.3.2.05.01.05.013.', 'Dry Seal', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(88, '1.3.2.05.01.05.014.', 'Fergulator', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(89, '1.3.2.05.01.05.015.', 'Cream Polisher', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(90, '1.3.2.05.01.05.016.', 'Mesin Perangko', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(91, '1.3.2.05.01.05.017.', 'Check Writer', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(92, '1.3.2.05.01.05.018.', 'Numerator', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(93, '1.3.2.05.01.05.019.', 'Alat Pemotong Kertas', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(94, '1.3.2.05.01.05.020.', 'Headmachine Besar', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(95, '1.3.2.05.01.05.021.', 'Perforator Besar', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(96, '1.3.2.05.01.05.022.', 'Alat Pencetak Label', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(97, '1.3.2.05.01.05.023.', 'Overhead Projector', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(98, '1.3.2.05.01.05.024.', 'Hand Metal Detector', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(99, '1.3.2.05.01.05.025.', 'Walkman Detector', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(100, '1.3.2.05.01.05.026.', 'Panel Pameran', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(101, '1.3.2.05.01.05.027.', 'Alat Pengaman / Sinyal', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(102, '1.3.2.05.01.05.028.', 'Board Modulux', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(103, '1.3.2.05.01.05.029.', 'Porto Safe Travel Cose', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(104, '1.3.2.05.01.05.030.', 'Disk Prime', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(105, '1.3.2.05.01.05.031.', 'Megashow', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(106, '1.3.2.05.01.05.032.', 'White Board Electronic', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(107, '1.3.2.05.01.05.033.', 'Laser Pointer', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(108, '1.3.2.05.01.05.034.', 'Display', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(109, '1.3.2.05.01.05.035.', 'Exhauster Form', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(110, '1.3.2.05.01.05.036.', 'Rubu Mujayyab', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(111, '1.3.2.05.01.05.037.', 'Electric Dumper', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(112, '1.3.2.05.01.05.038.', 'Mesin Teraan', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(113, '1.3.2.05.01.05.039.', 'Mesin Laminating', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(114, '1.3.2.05.01.05.040.', 'Penangkal Petir', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(115, '1.3.2.05.01.05.041.', 'Stempel Timbul/Bulat', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(116, '1.3.2.05.01.05.042.', 'Lampu-lampu Kristal', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(117, '1.3.2.05.01.05.043.', 'LCD Projector/Infocus', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(118, '1.3.2.05.01.05.044.', 'Flip Chart', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(119, '1.3.2.05.01.05.045.', 'Binding Machine', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(120, '1.3.2.05.01.05.055.', 'Proyector Spider Bracket', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(121, '1.3.2.05.01.05.056.', 'Papan Gambar', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(122, '1.3.2.05.01.05.057.', 'Bel', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(123, '1.3.2.05.01.05.058.', 'Electric Pressing Machine', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(124, '1.3.2.05.01.05.059.', 'Encapsulator (Jarasonic welder)', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(125, '1.3.2.05.01.05.060.', 'Deacidificator Unit (Non Aquas)', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(126, '1.3.2.05.01.05.061.', 'Full Automatic Leaf Caster', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(127, '1.3.2.05.01.05.062.', 'Conservation Tools', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(128, '1.3.2.05.01.05.063.', 'Board Stan', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(129, '1.3.2.05.01.05.064.', 'Vacum Freeze Dry Chamber', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(130, '1.3.2.05.01.05.065.', 'Kotak Surat', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(131, '1.3.2.05.01.05.066.', 'Gembok', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(132, '1.3.2.05.01.05.067.', 'Compact Hand Projector', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(133, '1.3.2.05.01.05.068.', 'Alat Sidik Jari', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(134, '1.3.2.05.01.05.069.', 'Alat Penghancur Jarum', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(135, '1.3.2.05.01.05.070.', 'Walkthrough/ Portal Metal Detector', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(136, '1.3.2.05.01.05.071.', 'Handheld Trace Detector', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(137, '1.3.2.05.01.05.072.', 'Alat Deteksi Pita Cukai Palsu/ VideoSpectral Comparator', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(138, '1.3.2.05.01.05.073.', 'Mesin Packing/ Starpping Machine', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(139, '1.3.2.05.01.05.074.', 'Television Control Operasional Lift', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(140, '1.3.2.05.01.05.075.', 'Mesin Antrian', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(141, '1.3.2.05.01.05.076.', 'Papan Nama Instansi', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(142, '1.3.2.05.01.05.077.', 'Papan Pengumuman', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(143, '1.3.2.05.01.05.078.', 'Papan Tulis', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(144, '1.3.2.05.01.05.079.', 'Papan Absen', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(145, '1.3.2.05.01.05.080.', 'Mesin Fogging', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(146, '1.3.2.05.01.05.081.', 'Teralis', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(147, '1.3.2.05.01.05.082.', 'Alat Penerjemah', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(148, '1.3.2.05.01.05.083.', 'Alat Penghancur Plastik', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(149, '1.3.2.05.01.05.084.', 'Proteksi Petir Terpadu', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(150, '1.3.2.05.01.05.085.', 'Pakaian Toga', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(151, '1.3.2.05.01.05.086.', 'Sirine', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(152, '1.3.2.05.01.05.087.', 'Tongkat Pedel', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(153, '1.3.2.05.01.05.088.', 'Perkakas Kantor ', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(154, '1.3.2.05.02.01.001.', 'Meja Kerja Besi/Metal', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(155, '1.3.2.05.02.01.002.', 'Meja Kerja Kayu', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(156, '1.3.2.05.02.01.003.', 'Kursi Besi/Metal', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(157, '1.3.2.05.02.01.004.', 'Kursi Kayu', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(158, '1.3.2.05.02.01.005.', 'Sice', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(159, '1.3.2.05.02.01.006.', 'Bangku Panjang Besi/Metal', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(160, '1.3.2.05.02.01.007.', 'Bangku Panjang Kayu', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(161, '1.3.2.05.02.01.008.', 'Meja Rapat', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(162, '1.3.2.05.02.01.009.', 'Tempat Tidur Besi', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(163, '1.3.2.05.02.01.010.', 'Tempat Tidur Kayu', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(164, '1.3.2.05.02.01.011.', 'Meja Ketik', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(165, '1.3.2.05.02.01.012.', 'Meja Telepon', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(166, '1.3.2.05.02.01.013.', 'Meja Podium', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(167, '1.3.2.05.02.01.014.', 'Meja Resepsionis', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(168, '1.3.2.05.02.01.015.', 'Meja Marmer', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(169, '1.3.2.05.02.01.016.', 'Meja Tambahan', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(170, '1.3.2.05.02.01.017.', 'Meja Panjang', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(171, '1.3.2.05.02.01.018.', 'Meja Bundar', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(172, '1.3.2.05.02.01.019.', 'Meja Periksa Pasien', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(173, '1.3.2.05.02.01.020.', 'Meja Obat', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(174, '1.3.2.05.02.01.021.', 'Meja Kartu', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(175, '1.3.2.05.02.01.022.', 'Meja Bayi', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(176, '1.3.2.05.02.01.023.', 'Meja Sekolah', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(177, '1.3.2.05.02.01.024.', 'Meja 1/2 Biro', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(178, '1.3.2.05.02.01.025.', 'Kasur/Spring Bed', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(179, '1.3.2.05.02.01.026.', 'Sketsel', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(180, '1.3.2.05.02.01.027.', 'Meja Makan Besi', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(181, '1.3.2.05.02.01.028.', 'Meja Makan Kayu', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(182, '1.3.2.05.02.01.029.', 'Kursi Fiber Glas/Plastik', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(183, '1.3.2.05.02.01.030.', 'Kursi Rapat', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(184, '1.3.2.05.02.01.031.', 'Kursi Tamu', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(185, '1.3.2.05.02.01.032.', 'Kursi Putar', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(186, '1.3.2.05.02.01.033.', 'Kursi Biasa', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(187, '1.3.2.05.02.01.034.', 'Bangku Sekolah', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(188, '1.3.2.05.02.01.035.', 'Bangku Tunggu', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(189, '1.3.2.05.02.01.036.', 'Kursi Lipat', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(190, '1.3.2.05.02.01.037.', 'Bangku Injak', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(191, '1.3.2.05.02.01.038.', 'Meja Cetakan', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(192, '1.3.2.05.02.01.039.', 'Meja Komputer', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(193, '1.3.2.05.02.01.040.', 'Pot Bunga', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(194, '1.3.2.05.02.01.041.', 'Partisi', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(195, '1.3.2.05.02.01.042.', 'Publik Astari (Pembatas Antrian)', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(196, '1.3.2.05.02.01.043.', 'Rak Sepatu ( Almunium )', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(197, '1.3.2.05.02.01.044.', 'Gantungan Jas', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(198, '1.3.2.05.02.01.045.', 'Nakas', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(199, '1.3.2.05.02.01.046.', 'Cubikal', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(200, '1.3.2.05.02.01.047.', 'Workstation', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(201, '1.3.2.05.02.01.048.', 'Sofa', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(202, '1.3.2.05.02.01.049.', 'Meja Rias', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(203, '1.3.2.05.02.01.050.', 'Alat Kantor Lainnya ', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(204, '1.3.2.05.02.01.051.', 'Kursi Tangan ', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(205, '1.3.2.05.02.01.052.', 'Bantal ', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(206, '1.3.2.05.02.01.053.', 'Locker Katun', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(207, '1.3.2.05.02.01.054.', 'Sepre', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(208, '1.3.2.05.02.01.055.', 'Daun Pintu Alumunium', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(209, '1.3.2.05.02.01.056.', 'Lemari Pakian', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(210, '1.3.2.05.02.01.057.', 'Lemari Rias', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(211, '1.3.2.05.02.01.058.', 'Meubair Lain-lain', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(212, '1.3.2.05.02.02.001.', 'Jam Mekanis', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(213, '1.3.2.05.02.02.002.', 'Jam Listrik', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(214, '1.3.2.05.02.02.003.', 'Jam Elektronik', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(215, '1.3.2.05.02.02.004.', 'Control Clock', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(216, '1.3.2.05.02.02.005.', 'Alat Pengukur Waktu Lainnya ', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(217, '1.3.2.05.02.03.001.', 'Mesin Penghisap Debu/Vacuum Cleaner', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(218, '1.3.2.05.02.03.002.', 'Mesin Pel/Poles', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(219, '1.3.2.05.02.03.003.', 'Mesin Pemotong Rumput', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(220, '1.3.2.05.02.03.004.', 'Mesin Cuci', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(221, '1.3.2.05.02.03.005.', 'Air Cleaner', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(222, '1.3.2.05.02.03.006.', 'Alat Pembersih Salju', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(223, '1.3.2.05.02.03.007.', 'Alat Pembersih Lainnya ', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(224, '1.3.2.05.02.04.001.', 'Lemari Es', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(225, '1.3.2.05.02.04.002.', 'A.C. Sentral', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(226, '1.3.2.05.02.04.003.', 'A.C. Window', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(227, '1.3.2.05.02.04.004.', 'A.C. Split', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(228, '1.3.2.05.02.04.005.', 'Portable Air Conditioner (Alat Pendingin)', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(229, '1.3.2.05.02.04.006.', 'Kipas Angin', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(230, '1.3.2.05.02.04.007.', 'Exhause Fan', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(231, '1.3.2.05.02.04.008.', 'Cold Storage (Alat Pendingin)', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(232, '1.3.2.05.02.04.009.', 'Reach In Frezzer', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(233, '1.3.2.05.02.04.010.', 'Reach In Chiller', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(234, '1.3.2.05.02.04.011.', 'Up Right Chiller/Frezzer', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(235, '1.3.2.05.02.04.012.', 'Cold Room Frezzer', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(236, '1.3.2.05.02.04.013.', 'Air Curtain', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(237, '1.3.2.05.02.04.014.', 'Air Handling Unit', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(238, '1.3.2.05.02.04.015.', 'Alat Pendingin lainnya ', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(239, '1.3.2.05.02.05.001.', 'Kompor Listrik (Alat Dapur)', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(240, '1.3.2.05.02.05.002.', 'Kompor Gas (Alat Dapur)', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(241, '1.3.2.05.02.05.003.', 'Kompor Minyak', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(242, '1.3.2.05.02.05.004.', 'Teko Listrik', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(243, '1.3.2.05.02.05.005.', 'Rice Cooker (Alat Dapur)', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(244, '1.3.2.05.02.05.006.', 'Oven Listrik', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(245, '1.3.2.05.02.05.007.', 'Rice Warmer', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(246, '1.3.2.05.02.05.008.', 'Kitchen Set', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(247, '1.3.2.05.02.05.009.', 'Tabung Gas', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(248, '1.3.2.05.02.05.010.', 'Mesin Giling Bumbu', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(249, '1.3.2.05.02.05.011.', 'Treng Air/Tandon Air', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(250, '1.3.2.05.02.05.012.', 'Mesin Parutan Kelapa', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(251, '1.3.2.05.02.05.013.', 'Kompor Kompresor', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(252, '1.3.2.05.02.05.014.', 'Alat Pemanggang Roti/Sate', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(253, '1.3.2.05.02.05.015.', 'Rak Piring Alumunium', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(254, '1.3.2.05.02.05.016.', 'Alat Penyimpan Beras', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(255, '1.3.2.05.02.05.017.', 'Panci', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(256, '1.3.2.05.02.05.018.', 'Blender', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(257, '1.3.2.05.02.05.019.', 'Mixer', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(258, '1.3.2.05.02.05.020.', 'Oven Gas', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(259, '1.3.2.05.02.05.021.', 'Presto Cooker', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(260, '1.3.2.05.02.05.022.', 'Wonder Pan', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(261, '1.3.2.05.02.05.023.', 'Mesin Giling Daging', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(262, '1.3.2.05.02.05.024.', 'Heating Set', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(263, '1.3.2.05.02.05.025.', 'Thermos Air', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(264, '1.3.2.05.02.05.026.', 'Alat Dapur Lainnya ', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(265, '1.3.2.05.02.06.001.', 'Radio', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(266, '1.3.2.05.02.06.002.', 'Televisi', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(267, '1.3.2.05.02.06.003.', 'Video Cassette', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(268, '1.3.2.05.02.06.004.', 'Tape Recorder (Alat Rumah TanggaLainnya ( Home Use )', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(269, '1.3.2.05.02.06.005.', 'Amplifier', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(270, '1.3.2.05.02.06.006.', 'Equalizer', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(271, '1.3.2.05.02.06.007.', 'Loudspeaker', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(272, '1.3.2.05.02.06.008.', 'Sound System', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(273, '1.3.2.05.02.06.009.', 'Compact Disc', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(274, '1.3.2.05.02.06.010.', 'Laser Disc', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(275, '1.3.2.05.02.06.011.', 'Karaoke', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(276, '1.3.2.05.02.06.012.', 'Wireless', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(277, '1.3.2.05.02.06.013.', 'Megaphone', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(278, '1.3.2.05.02.06.014.', 'Microphone', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(279, '1.3.2.05.02.06.015.', 'Microphone Floor Stand', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(280, '1.3.2.05.02.06.016.', 'Microphone Table Stand', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(281, '1.3.2.05.02.06.017.', 'Mic Conference', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(282, '1.3.2.05.02.06.018.', 'Unit Power Supply', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(283, '1.3.2.05.02.06.019.', 'Step Up/Down (Alat Rumah TanggaLainnya ( Home Use )', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(284, '1.3.2.05.02.06.020.', 'Stabilisator', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(285, '1.3.2.05.02.06.021.', 'Camera Video', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(286, '1.3.2.05.02.06.022.', 'Camera film', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(287, '1.3.2.05.02.06.023.', 'Tustel', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(288, '1.3.2.05.02.06.024.', 'Mesin Jahit', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(289, '1.3.2.05.02.06.025.', 'Timbangan Orang', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(290, '1.3.2.05.02.06.026.', 'Timbangan Barang', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(291, '1.3.2.05.02.06.027.', 'Alat Hiasan', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(292, '1.3.2.05.02.06.028.', 'Lambang Garuda Pancasila', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(293, '1.3.2.05.02.06.029.', 'Gambar Presiden/Wakil Presiden', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(294, '1.3.2.05.02.06.030.', 'Lambang Korpri/Dharma Wanita', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(295, '1.3.2.05.02.06.031.', 'Aquarium (Alat Rumah Tangga Lainnya (Home Use )', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(296, '1.3.2.05.02.06.032.', 'Tiang Bendera', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(297, '1.3.2.05.02.06.033.', 'Pataka', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(298, '1.3.2.05.02.06.034.', 'Seterika', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(299, '1.3.2.05.02.06.035.', 'Water Filter', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(300, '1.3.2.05.02.06.036.', 'Tangga Aluminium', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(301, '1.3.2.05.02.06.037.', 'Kaca Hias', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(302, '1.3.2.05.02.06.038.', 'Dispenser', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(303, '1.3.2.05.02.06.039.', 'Mimbar/Podium', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(304, '1.3.2.05.02.06.040.', 'Gucci', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(305, '1.3.2.05.02.06.041.', 'Tangga Hidrolik', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(306, '1.3.2.05.02.06.042.', 'Palu Sidang', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(307, '1.3.2.05.02.06.043.', 'Mesin Pengering Pakaian', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(308, '1.3.2.05.02.06.044.', 'Lambang Instansi', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(309, '1.3.2.05.02.06.045.', 'Lonceng/Genta', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(310, '1.3.2.05.02.06.046.', 'Mesin Pemotong Keramik', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(311, '1.3.2.05.02.06.047.', 'Coffee Maker', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(312, '1.3.2.05.02.06.048.', 'Handy Cam', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(313, '1.3.2.05.02.06.049.', 'Mesin Obras', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(314, '1.3.2.05.02.06.050.', 'Mesin Potong Kain', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(315, '1.3.2.05.02.06.051.', 'Mesin Pelubang Kancing', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(316, '1.3.2.05.02.06.052.', 'Meja Potong', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(317, '1.3.2.05.02.06.053.', 'Rader', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(318, '1.3.2.05.02.06.054.', 'Manequin (Boneka)', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(319, '1.3.2.05.02.06.055.', 'Mini Compo', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(320, '1.3.2.05.02.06.056.', 'Heater (Alat Rumah Tangga Lainnya (Home Use )', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(321, '1.3.2.05.02.06.057.', 'Karpet', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(322, '1.3.2.05.02.06.058.', 'Vertikal Blind', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(323, '1.3.2.05.02.06.059.', 'Gordyin/Kray', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(324, '1.3.2.05.02.06.060.', 'Asbak Tinggi', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(325, '1.3.2.05.02.06.061.', 'Sun Screen', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(326, '1.3.2.05.02.06.062.', 'Alat Pemanas Ruangan', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(327, '1.3.2.05.02.06.063.', 'Lemari Plastik', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(328, '1.3.2.05.02.06.064.', 'Mesin Pengering Tangan', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(329, '1.3.2.05.02.06.065.', 'Panggung', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(330, '1.3.2.05.02.06.066.', 'Mesin Pedding', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(331, '1.3.2.05.02.06.067.', 'DVD Player', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(332, '1.3.2.05.02.06.068.', 'Tangga', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(333, '1.3.2.05.02.06.069.', 'Lampu', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(334, '1.3.2.05.02.06.070.', 'Jemuran', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(335, '1.3.2.05.02.06.071.', 'Patung Peraga Pakaian', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(336, '1.3.2.05.02.06.072.', 'Gendola', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(337, '1.3.2.05.02.06.073.', 'Alat Pangkas Rambut Listrik', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(338, '1.3.2.05.02.06.075.', 'Tangki Air / tandon', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(339, '1.3.2.05.02.06.076.', 'Home Theater', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(340, '1.3.2.05.02.07.001.', 'Alat Pemadam/Portable', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(341, '1.3.2.05.02.07.017.', 'Alat Pemadam Kebakaran Lainnya ', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(342, '1.3.2.10.01.01.001.', 'Mainframe (Komputer Jaringan)', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(343, '1.3.2.10.01.01.002.', 'Mini Komputer', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(344, '1.3.2.10.01.01.003.', 'Local Area Network (LAN)', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(345, '1.3.2.10.01.01.004.', 'Internet', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(346, '1.3.2.10.01.01.005.', 'Komputer Wedis', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(347, '1.3.2.10.01.01.006.', 'Komputer Synergie', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(348, '1.3.2.10.01.01.007.', 'PC Workstation', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(349, '1.3.2.10.01.02.001.', 'P.C Unit', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(350, '1.3.2.10.01.02.002.', 'Lap Top', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(351, '1.3.2.10.01.02.003.', 'Note Book', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(352, '1.3.2.10.01.02.004.', 'Palm Top', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(353, '1.3.2.10.01.02.007.', 'Net Book', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(354, '1.3.2.10.01.02.009.', 'Tablet PC', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(355, '1.3.2.10.02.03.001.', 'CPU (Peralatan Personal Komputer)', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(356, '1.3.2.10.02.03.002.', 'Monitor', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(357, '1.3.2.10.02.03.003.', 'Printer (Peralatan Personal Komputer)', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(358, '1.3.2.10.02.03.004.', 'Scanner (Peralatan Personal Komputer)', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(359, '1.3.2.10.02.03.005.', 'Plotter (Peralatan Personal Komputer)', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(360, '1.3.2.10.02.03.006.', 'Viewer (Peralatan Personal Komputer)', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(361, '1.3.2.10.02.03.007.', 'External', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(362, '1.3.2.10.02.03.008.', 'Digitizer (Peralatan Personal Komputer)', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(363, '1.3.2.10.02.03.009.', 'Keyboard (Peralatan Personal Komputer)', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(364, '1.3.2.10.02.03.010.', 'CD Writter', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(365, '1.3.2.10.02.03.011.', 'DVD Writer', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(366, '1.3.2.10.02.03.012.', 'Firewire Card', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(367, '1.3.2.10.02.03.013.', 'Capture Card', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(368, '1.3.2.10.02.03.014.', 'LAN Card', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(369, '1.3.2.10.02.03.015.', 'External CD/ DVD Drive (ROM)', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(370, '1.3.2.10.02.03.016.', 'External Floppy Disk Drive', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(371, '1.3.2.10.02.03.017.', 'External/ Portable Hardisk', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(372, '1.3.2.10.02.04.001.', 'Server', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(373, '1.3.2.10.02.04.002.', 'Router', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(374, '1.3.2.10.02.04.003.', 'Hub', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(375, '1.3.2.10.02.04.004.', 'Modem', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(376, '1.3.2.10.02.04.005.', 'Netware Interface External', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(377, '1.3.2.10.02.04.006.', 'Repeater and Transciever', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(378, '1.3.2.10.02.04.007.', 'Head Copy Terminal', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(379, '1.3.2.10.02.04.008.', 'rack Modem', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(380, '1.3.2.10.02.04.009.', 'Card Punch', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(381, '1.3.2.10.02.04.010.', 'Head Copy Printer', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(382, '1.3.2.10.02.04.011.', 'Character Terminal', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(383, '1.3.2.10.02.04.012.', 'Graphic Terminal', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(384, '1.3.2.10.02.04.013.', 'Terminal', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(385, '1.3.2.10.02.04.014.', 'Rak Server', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(386, '1.3.2.10.02.04.015.', 'Firewall', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(387, '1.3.2.10.02.04.016.', 'Switch Rak', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(388, '1.3.2.10.02.04.017.', 'Wanscaller', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(389, '1.3.2.10.02.04.018.', 'E-Mail Security', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(390, '1.3.2.10.02.04.019.', 'Client Clearing House', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(391, '1.3.2.10.02.04.020.', 'CAT 6 Cable', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(392, '1.3.2.10.02.04.021.', 'Kabel UTP', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(393, '1.3.2.10.02.04.022.', 'Wireless PCI Card', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(394, '1.3.2.10.02.04.023.', 'Wireless Access Point', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(395, '1.3.2.10.02.04.024.', 'Switch', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(396, '1.3.2.10.02.04.025.', 'Hubbel UTP', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(397, '1.3.2.10.02.04.026.', 'Acces Point', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(398, '1.3.2.10.02.04.027.', 'Rackmount', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(399, '1.3.2.10.02.04.028.', 'KVM Keyboard Video Monitor', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(400, '1.3.2.10.02.04.029.', 'Mobile Modem GSM/ CDMA', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(401, '1.3.2.10.02.04.030.', 'Network Cable Tester', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(402, '1.3.2.10.02.04.031.', 'Jaringan Satpas', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(403, '1.3.2.10.02.04.032.', 'NComputing', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(404, '1.3.2.10.02.04.033.', 'Peralatan Jaringan Lainnya ', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(405, '1.3.2.06.01.01.001.', 'Audio Mixing Console', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(406, '1.3.2.06.01.01.002.', 'Audio Mixing Portable', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(407, '1.3.2.06.01.01.003.', 'Audio Mixing Stationer', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(408, '1.3.2.06.01.01.005.', 'Audio Amplifier', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(409, '1.3.2.06.01.01.016.', 'Compact Disc Player', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(410, '1.3.2.06.01.01.017.', 'Cassette Duplicator', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(411, '1.3.2.06.01.01.018.', 'Disc Record Player', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(412, '1.3.2.06.01.01.019.', 'Multitrack Recorder', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(413, '1.3.2.06.01.01.036.', 'Microphone/Wireless MIC', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(414, '1.3.2.06.01.01.037.', 'Microphone/Boom Stand', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(415, '1.3.2.06.01.01.038.', 'Microphone Connector Box', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(416, '1.3.2.06.01.01.039.', 'Light Signal', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(417, '1.3.2.06.01.01.040.', 'Power Supply Microphone', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(418, '1.3.2.06.01.01.042.', 'Audio Master Control Unit', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(419, '1.3.2.06.01.01.059.', 'Power Amplifier', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(420, '1.3.2.06.01.01.071.', 'Audio Tape Reel Recorder', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(421, '1.3.2.06.01.01.072.', 'Audio Cassette Recorder', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(422, '1.3.2.06.01.01.073.', 'Compact Disc Recorder', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(423, '1.3.2.06.01.01.078.', 'Microphone Cable', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(424, '1.3.2.06.01.02.045.', 'Tripod Camera', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(425, '1.3.2.06.01.02.125.', 'Camera Under Water', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(426, '1.3.2.06.01.02.126.', 'Camera Digital', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(427, '1.3.2.06.01.02.127.', 'Tas Kamera', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(428, '1.3.2.06.01.02.128.', 'Lampu Blitz Kamera', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(429, '1.3.2.06.01.02.129.', 'Lensa Filter', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(430, '1.3.2.06.02.01.001.', 'Telephone (PABX)', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(431, '1.3.2.06.02.01.002.', 'Intermediate Telephone/Key Telephone', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(432, '1.3.2.06.02.01.003.', 'Pesawat Telephone', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(433, '1.3.2.06.02.01.004.', 'Telephone Mobile', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(434, '1.3.2.06.02.01.005.', 'Pager', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(435, '1.3.2.06.02.01.006.', 'Handy Talky (HT)', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(436, '1.3.2.06.02.01.007.', 'Telex', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(437, '1.3.2.06.02.01.010.', 'Facsimile', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(438, '1.3.2.06.02.01.020.', 'Telepon Digital', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(439, '1.3.2.06.02.01.021.', 'Telepon Analog', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(440, '1.3.2.06.02.01.022.', 'Alat Komunikasi Telephone Lainnya ', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(441, '1.3.2.07.01.01.004.', 'Stetoscope (Alat Kedokteran Umum)', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(442, '1.3.2.07.01.01.005.', 'Tensimeter', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(443, '1.3.2.07.01.01.009.', 'Timbangan Badan (Alat KedokteranUmum)', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(444, '1.3.2.07.01.01.010.', 'Timbangan Bayi', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(445, '1.3.2.07.01.01.011.', 'Kocher', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(446, '1.3.2.07.01.01.174.', 'Alat Kedokteran Umum Lainnya ', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(447, '1.3.2.08.01.01.019.', 'Beaker Glass', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(448, '1.3.2.08.01.11.010.', 'Microscope', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(449, '1.3.2.08.01.11.020.', 'Stop Watch', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(450, '1.3.2.08.01.12.041.', 'Microscope Monocular', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(451, '1.3.2.08.01.12.042.', 'Microscope Binocular', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(452, '1.3.2.08.04.06.001.', 'Analog Volmeter', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(453, '1.3.2.08.04.06.002.', 'Digital Volmeter', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(454, '1.3.2.08.04.06.003.', 'Amperemeter', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(455, '1.3.2.08.04.06.004.', 'Ohmmeter', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(456, '1.3.2.08.04.06.005.', 'Frequency Meter', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(457, '1.3.2.08.04.06.053.', 'Multimeter', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(458, '1.3.2.18.01.02.012.', 'cone', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(459, '1.5.3.01.01.05.001.', 'Software.....(aset takberwujud)', 3, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(460, '1.3.3.01.01.10.001.', 'Bangunan Gedung Pendidikan Permanen', 4, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(461, '1.3.3.01.01.10.002.', 'Bangunan Gedung Pendidikan SemiPermanen', 4, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(462, '1.3.5.01.01.01.001.', 'Buku Monograf', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(463, '1.3.5.01.01.01.002.', 'Buku Referensi', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(464, '1.3.5.01.01.01.003.', 'Buku Ilmu Pengetahuan Umum', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(465, '1.3.5.01.01.01.004.', 'Buku Bibliografi, Katalog', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(466, '1.3.5.01.01.01.005.', 'Buku Ilmu Perpustakaan', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(467, '1.3.5.01.01.01.006.', 'Buku Ensyclopedia, Kamus, Buku Referensi', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(468, '1.3.5.01.01.01.007.', 'Buku Essay, Pamflet', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(469, '1.3.5.01.01.01.008.', 'Buku Berkala', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(470, '1.3.5.01.01.01.009.', 'Buku Institut, Asosiasi, Musium', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(471, '1.3.5.01.01.01.010.', 'Buku Harian', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(472, '1.3.5.01.01.01.011.', 'Buku Manuskrip', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(473, '1.3.5.01.01.01.012.', 'Buku Buku Teks Kurikulum', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(474, '1.3.5.01.01.01.013.', 'Buku Buku Umum Lainnya', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(475, '1.3.5.01.01.02.001.', 'Buku Metafisika', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(476, '1.3.5.01.01.02.002.', 'Buku Sistem Filsafat', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(477, '1.3.5.01.01.02.003.', 'Buku Ilmu Jiwa', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(478, '1.3.5.01.01.02.004.', 'Buku Logika', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(479, '1.3.5.01.01.02.005.', 'Buku Etika', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(480, '1.3.5.01.01.02.006.', 'Buku Filsafat lainnya', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(481, '1.3.5.01.01.03.001.', 'Buku Agama Islam', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL);
INSERT INTO `kodebarang` (`id`, `kode_barang`, `nama_barang`, `parent_rekening`, `created_at`, `updated_at`, `deleted_at`) VALUES
(482, '1.3.5.01.01.03.002.', 'Buku Agama Kristen', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(483, '1.3.5.01.01.03.003.', 'Buku Agama Budha', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(484, '1.3.5.01.01.03.004.', 'Buku Agama Hindu', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(485, '1.3.5.01.01.03.005.', 'Buku Agama Lainnya', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(486, '1.3.5.01.01.04.001.', 'Buku Sosiologi', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(487, '1.3.5.01.01.04.002.', 'Buku Statistik', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(488, '1.3.5.01.01.04.003.', 'Buku Ilmu Politik', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(489, '1.3.5.01.01.04.004.', 'Buku Ekonomi', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(490, '1.3.5.01.01.04.005.', 'Buku Hukum', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(491, '1.3.5.01.01.04.006.', 'Buku Administrasi, Pertahanan dan Keamanan', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(492, '1.3.5.01.01.04.007.', 'Buku Service Umum Sosial', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(493, '1.3.5.01.01.04.008.', 'Buku Pendidikan', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(494, '1.3.5.01.01.04.009.', 'Buku Perdagangan', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(495, '1.3.5.01.01.04.010.', 'Buku Etnografi, Cerita Rakyat', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(496, '1.3.5.01.01.04.011.', 'Buku Ilmu Sosial Lainnya', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(497, '1.3.5.01.01.05.001.', 'Buku Umum', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(498, '1.3.5.01.01.05.002.', 'Buku Pengetahuan Bahasa Indonesia', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(499, '1.3.5.01.01.05.003.', 'Buku Pengetahuan Bahasa Inggris', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(500, '1.3.5.01.01.05.004.', 'Buku Ilmu Bahasa Lainnya', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(501, '1.3.5.01.01.06.001.', 'Buku Matematika', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(502, '1.3.5.01.01.06.002.', 'Buku Astronomi, Geodesi', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(503, '1.3.5.01.01.06.003.', 'Buku Fisika dan Mekanika', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(504, '1.3.5.01.01.06.004.', 'Buku Kimia', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(505, '1.3.5.01.01.06.005.', 'Buku Geologi, Metrologi', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(506, '1.3.5.01.01.06.006.', 'Buku Palaentologi', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(507, '1.3.5.01.01.06.007.', 'Buku Biologi, Antropologi', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(508, '1.3.5.01.01.06.008.', 'Buku Bitani', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(509, '1.3.5.01.01.06.009.', 'Buku Zoologi (Ilmu Hewan)', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(510, '1.3.5.01.01.06.010.', 'Buku Matematika dan Pengetahuan Alam Lainnya', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(511, '1.3.5.01.01.07.001.', 'Buku Ilmu Kedokteran', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(512, '1.3.5.01.01.07.002.', 'Buku Teknologi', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(513, '1.3.5.01.01.07.003.', 'Buku Pertanian, Kehutanan, Perikanan', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(514, '1.3.5.01.01.07.004.', 'Buku Ilmu Kerumah Tanggaan', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(515, '1.3.5.01.01.07.005.', 'Buku Management dan Perkantoran', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(516, '1.3.5.01.01.07.006.', 'Buku Industri Kimia', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(517, '1.3.5.01.01.07.007.', 'Buku Teknik Industri dan Kerajinan', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(518, '1.3.5.01.01.07.008.', 'Buku Ilmu Perdagangan Khusus Industri', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(519, '1.3.5.01.01.07.009.', 'Buku Industri Konstruksi dan Perdagangan', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(520, '1.3.5.01.01.07.010.', 'Buku Ilmu Pengetahuan Praktis Lainnya', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(521, '1.3.5.01.01.08.001.', 'Buku Perencanaan Fisik, Pertamanan dll', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(522, '1.3.5.01.01.08.002.', 'Buku Arsitektur', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(523, '1.3.5.01.01.08.003.', 'Buku Seni Pahat', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(524, '1.3.5.01.01.08.004.', 'Buku Seni Lukis, Ukir', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(525, '1.3.5.01.01.08.005.', 'Buku Seni Gambar, Grafika', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(526, '1.3.5.01.01.08.006.', 'Buku Fotografi, Senimatografi', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(527, '1.3.5.01.01.08.007.', 'Buku Musik', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(528, '1.3.5.01.01.08.008.', 'Buku Permainan dan Olah Raga', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(529, '1.3.5.01.01.08.009.', 'Buku Arsitektur Kesenian Olah Raga Lainnya', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(530, '1.3.5.01.01.09.001.', 'Buku Geografi, Eksplorasi', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(531, '1.3.5.01.01.09.002.', 'Buku Biografi', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(532, '1.3.5.01.01.09.003.', 'Buku Sejarah', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(533, '1.3.5.01.02.01.001.', 'Kaset', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(534, '1.3.5.01.02.01.002.', 'Video', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(535, '1.3.5.01.02.01.003.', 'CD/VCD/DVD/LD', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(536, '1.3.5.01.02.01.004.', 'Pita Film', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(537, '1.3.5.01.02.01.005.', 'Pita Suara', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(538, '1.3.5.01.02.01.006.', 'Piringan Hitam', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(539, '1.3.5.01.02.01.007.', 'Peta Digital', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(540, '1.3.5.02.01.01.001.', 'Alat Musik Tradisional/Daerah', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(541, '1.3.5.02.01.01.002.', 'Alat Musik Modern/Band', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(542, '1.3.5.02.01.02.001.', 'Lukisan Cat Air', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(543, '1.3.5.02.01.02.002.', 'Sulaman / Tempelan', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(544, '1.3.5.02.01.02.003.', 'Lukisan Cat Minyak', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(545, '1.3.5.02.01.02.004.', 'Lukisan Bulu', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(546, '1.3.5.02.01.02.005.', 'Seni Relief', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(547, '1.3.5.02.01.02.006.', 'Lukisan Lainnya', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(548, '1.3.5.02.01.03.001.', 'Wayang Golek', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(549, '1.3.5.02.01.03.002.', 'Wayang Kulit', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(550, '1.3.5.02.01.04.001.', 'Alat Kesenian Lainnya', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(551, '1.3.5.02.02.01.001.', 'Pahatan Batu', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(552, '1.3.5.02.02.01.002.', 'Pahatan Kayu', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(553, '1.3.5.02.02.01.003.', 'Pahatan Logam', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(554, '1.3.5.02.02.01.004.', 'Alat Sepak Bola', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(555, '1.3.5.02.02.01.005.', 'Alat Olahraga Lainnya', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(556, '1.3.5.02.02.02.001.', 'Maket/Miniatur/Replika', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(557, '1.3.5.02.02.02.002.', 'Foto Dokumen', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(558, '1.3.5.02.02.02.003.', 'Naskah Kuno', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(559, '1.3.5.02.02.02.004.', 'Koleksi Mata Uang/ Numismatik', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(560, '1.3.5.02.02.02.005.', 'Perhiasan', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(561, '1.3.5.02.02.02.006.', 'Barang Keramik/ Gerabah', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(562, '1.3.5.02.02.02.007.', 'Arca/ Patung', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(563, '1.3.5.02.02.02.008.', 'Benda Kuno/ Unik', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(564, '1.3.5.02.02.02.009.', 'Fosil', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(565, '1.3.5.02.02.02.010.', 'Mumy', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(566, '1.3.5.02.02.02.011.', 'Benda-Benda Purbakala', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(567, '1.3.5.02.02.02.012.', 'Dokumentasi Bersejarah', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(568, '1.3.5.02.02.02.013.', 'Barang Koleksi Rumah Tangga', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(569, '1.3.5.02.02.02.014.', 'Lukisan Bersejarah', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(570, '1.3.5.02.02.02.015.', 'Maket dan Foto Dokumen Lainnya', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(571, '1.3.5.02.02.03.001.', 'Keramik (Guji)', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(572, '1.3.5.02.02.03.002.', 'Logam (Gong, Mandau)', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(573, '1.3.5.02.02.03.003.', 'Kayu (Sampit, Telabang)', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(574, '1.3.5.02.02.03.004.', 'Anyaman (Tikar, Rotan)', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(575, '1.3.5.02.02.03.005.', 'Tenunan Sutra', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(576, '1.3.5.02.02.03.006.', 'Anyaman Purun', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(577, '1.3.5.02.02.03.007.', 'Anyaman Bambu', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(578, '1.3.5.02.02.03.008.', 'Barang Kerajinan Lainnya', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(579, '1.3.5.02.02.04.001.', 'Senam Lainnya', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(580, '1.3.5.02.02.04.002.', 'Alat Olahraga Air Lainnya', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(581, '1.3.5.02.02.04.003.', 'Alat Olahraga ', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(582, '1.5.3.01.01.02.001.', 'Lisensi dan Frenchise....', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(583, '1.5.3.01.01.03.001.', 'Hak Cipta....', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(584, '1.5.3.01.01.04.001.', 'Hak Paten', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(585, '1.5.3.01.01.05.001.', 'Software.....', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(586, '1.5.3.01.01.06.001.', 'Kajian.....', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(587, '1.5.3.01.01.07.001.', 'film.....', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL),
(588, '1.5.3.01.01.07.002.', 'Karya Seni/Budaya.....', 5, '2019-09-09 04:34:25', '2019-09-09 04:35:09', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kodepembiayaan`
--

CREATE TABLE `kodepembiayaan` (
  `id` int(11) NOT NULL,
  `kode_pembiayaan` varchar(20) NOT NULL,
  `nama_pembiayaan` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data untuk tabel `kodepembiayaan`
--

INSERT INTO `kodepembiayaan` (`id`, `kode_pembiayaan`, `nama_pembiayaan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'KP.01', 'Pengembangan Perpustakaan', NULL, NULL, NULL),
(2, 'KP.02', 'Penerimaan Peserta Didik Baru', NULL, NULL, NULL),
(3, 'KP.03', 'Kegiatan Pembelajaran dan Ekstrakurikuler', NULL, NULL, NULL),
(4, 'KP.04', 'Kegiatan Evaluasi Pembelajaran', NULL, NULL, NULL),
(5, 'KP.05', 'Pengelolaan Sekolah', NULL, NULL, NULL),
(6, 'KP.06', 'Pengembangan Profesi Guru dan Tenaga Kependidikan, serta Pengembangan Majanemen Sekolah', NULL, NULL, NULL),
(7, 'KP.07', 'Langganan Daya dan Jasa', NULL, NULL, NULL),
(8, 'KP.08', 'Pemeliharaan dan Perawatan Sarana dan Prasarana Sekolah', NULL, NULL, NULL),
(9, 'KP.09', 'Pembayaran Honor', NULL, NULL, NULL),
(10, 'KP.10', 'Pembelian/Perawatan Alat Multi Media Pembelajaran', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kodeprogram`
--

CREATE TABLE `kodeprogram` (
  `id` int(11) NOT NULL,
  `kode_program` varchar(20) NOT NULL,
  `nama_program` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data untuk tabel `kodeprogram`
--

INSERT INTO `kodeprogram` (`id`, `kode_program`, `nama_program`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Program.1', 'Pengembangan Kompetensi Lulusan', NULL, NULL, NULL),
(2, 'Program.2', 'Pengembangan Standar Isi', NULL, NULL, NULL),
(3, 'Program.3', 'Pengembangan Standar Proses', NULL, NULL, NULL),
(4, 'Program.4', 'Pengembangan Pendidik dan Tenaga Kependidikan', NULL, NULL, NULL),
(5, 'Program.5', 'Pengembangan Sarana dan Prasarana Sekolah', NULL, NULL, NULL),
(6, 'Program.6', 'Pengembangan Standar Pengelolaan', NULL, NULL, NULL),
(7, 'Program.7', 'Pengembangan Standar Pembiayaan', NULL, NULL, NULL),
(8, 'Program.8', 'Pengembangan dan Implementasi Sistem Penilaian', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `koderekening`
--

CREATE TABLE `koderekening` (
  `id` int(11) UNSIGNED NOT NULL,
  `kode_rekening` varchar(15) NOT NULL,
  `nama_rekening` varchar(255) NOT NULL,
  `parent_id` int(11) UNSIGNED DEFAULT NULL,
  `jenis` int(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `koderekening`
--

INSERT INTO `koderekening` (`id`, `kode_rekening`, `nama_rekening`, `parent_id`, `jenis`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1', 'Belanja Pegawai', NULL, 0, NULL, NULL, NULL),
(2, '2', 'Belanja Barang Jasa', NULL, 0, NULL, NULL, NULL),
(3, '3', 'Belanja Modal Peralatan dan Mesin', NULL, 0, NULL, NULL, NULL),
(4, '4', 'Belanja Modal Aset Tetap Lainnya', NULL, 0, NULL, NULL, NULL),
(5, '5', 'Belanja Modal Gedung dan Bangunan', NULL, 0, NULL, NULL, NULL),
(6, '01', 'Belanja Peralatan dan Mesin', 3, 1, NULL, NULL, NULL),
(7, '01', 'Belanja Aset Tetap Lainnya', 4, 1, NULL, NULL, NULL),
(8, '01', 'Belanja Gedung dan Bangunan', 5, 1, NULL, NULL, NULL),
(9, '01', 'Honorarium Pengelola Keuangan', 1, 0, NULL, NULL, NULL),
(10, '02', 'Honorarium GTT/PTT', 1, 0, NULL, NULL, NULL),
(11, '03', 'Uang Lembur PNS', 1, 0, NULL, NULL, NULL),
(12, '04', 'Uang Lembur Non PNS', 1, 0, NULL, NULL, NULL),
(13, '01', 'Persediaan Alat Tulis Kantor', 2, 2, NULL, NULL, NULL),
(14, '02', 'Persediaan Alat Listrik dan Elektronik', 2, 2, NULL, NULL, NULL),
(15, '03', 'Persediaan Perangko, Materai Dan Benda Pos Lainnya', 2, 2, NULL, NULL, NULL),
(16, '04', 'Persediaan Peralatan Kebersihan Dan Bahan Pembersih', 2, 2, NULL, NULL, NULL),
(17, '05', 'Persediaan Pengisian Isi Tabung Gas', 2, 2, NULL, NULL, NULL),
(18, '06', 'Belanja Bahan Bakar Minyak/Gas', 2, 0, NULL, NULL, NULL),
(19, '07', 'Bahan Pakai Habis Kesehatan Medis', 2, 0, NULL, NULL, NULL),
(20, '08', 'Bahan/ Bibit Tanaman', 2, 0, NULL, NULL, NULL),
(21, '09', 'Piagam/ Piala/ Sertifikat', 2, 0, NULL, NULL, NULL),
(22, '10', 'Cinderamata, Fandel, Plakat, Dan Sejenisnya', 2, 0, NULL, NULL, NULL),
(23, '11', 'Perlengkapan Rumah Tangga Kantor', 2, 0, NULL, NULL, NULL),
(24, '12', 'Belanja Alat-Alat Olahraga', 2, 0, NULL, NULL, NULL),
(25, '13', 'Alat Praktek/ Peraga', 2, 0, NULL, NULL, NULL),
(26, '14', 'Bahan Laboratorium', 2, 0, NULL, NULL, NULL),
(27, '15', 'Jasa Telepon', 2, 0, NULL, NULL, NULL),
(28, '16', 'Jasa Air', 2, 0, NULL, NULL, NULL),
(29, '17', 'Jasa Listrik', 2, 0, NULL, NULL, NULL),
(30, '18', 'Jasa Surat Kabar/Majalah', 2, 0, NULL, NULL, NULL),
(31, '19', 'Jasa Kawat/Faksimili/Internet', 2, 0, NULL, NULL, NULL),
(32, '20', 'Transportasi Dan Akomodasi (Pihak Ketiga)', 2, 0, NULL, NULL, NULL),
(33, '21', 'Jasa Dekorasi, Dokumentasi, Publikasi', 2, 0, NULL, NULL, NULL),
(34, '22', 'Jasa Pemasangan Listrik, Air, Telpon Dan Gas', 2, 0, NULL, NULL, NULL),
(35, '23', 'Jasa Pihak Ketiga / Outsourching', 2, 0, NULL, NULL, NULL),
(36, '24', 'Kontribusi/ Kompensasi', 2, 0, NULL, NULL, NULL),
(37, '25', 'Cetak', 2, 0, NULL, NULL, NULL),
(38, '26', 'Penggandaan', 2, 0, NULL, NULL, NULL),
(39, '27', 'Sewa Sarana Mobilitas Darat', 2, 0, NULL, NULL, NULL),
(40, '28', 'Sewa Meja Kursi', 2, 0, NULL, NULL, NULL),
(41, '29', 'Sewa Generator', 2, 0, NULL, NULL, NULL),
(42, '30', 'Sewa Tenda', 2, 0, NULL, NULL, NULL),
(43, '31', 'Sewa Pakaian Adat/Tradisional', 2, 0, NULL, NULL, NULL),
(44, '32', 'Sewa Sound System', 2, 0, NULL, NULL, NULL),
(45, '33', 'Makanan Dan Minuman Harian Pegawai', 2, 0, NULL, NULL, NULL),
(46, '34', 'Makanan Dan Minuman Rapat', 2, 0, NULL, NULL, NULL),
(47, '35', 'Makanan Dan Minuman Tamu', 2, 0, NULL, NULL, NULL),
(48, '36', 'Perjalanan Dinas Dalam Daerah', 2, 0, NULL, NULL, NULL),
(49, '37', 'Perjalanan Dinas Luar Daerah', 2, 0, NULL, NULL, NULL),
(50, '38', 'Pemeliharan Peralatan Dan Mesin', 2, 0, NULL, NULL, NULL),
(51, '39', 'Pemeliharan Gedung Dan Bangunan', 2, 0, NULL, NULL, NULL),
(52, '40', 'Kursus-Kursus Singkat/ Pelatihan', 2, 0, NULL, NULL, NULL),
(53, '41', 'Honorarium Tenaga Ahli/Narasumber/Instruktur', 2, 0, NULL, NULL, NULL),
(54, '42', 'Uang Untuk Diberikan Kepada Pihak Ketiga (Hadiah)', 2, 0, NULL, NULL, NULL),
(55, '43', 'Beasiswa Anak Didik', 2, 0, NULL, NULL, NULL),
(56, '44', 'Beban Pajak Bumi Dan Bangunan', 2, 0, NULL, NULL, NULL),
(57, '45', 'Seragam Sekolah', 2, 0, NULL, NULL, NULL),
(58, '01', 'Uang Lembur Remote', 9, 0, NULL, '2019-07-02 03:58:42', '2019-07-02 03:58:42'),
(59, '01', 'Lembur Freelance Edit', 58, 0, NULL, '2019-07-02 03:58:39', '2019-07-02 03:58:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  `id_modul` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`id`, `id_role`, `id_modul`) VALUES
(1, 1, 1),
(2, 1, 12),
(3, 1, 2),
(5, 1, 4),
(7, 1, 6),
(8, 1, 5),
(9, 1, 8),
(10, 1, 9),
(11, 1, 10),
(12, 2, 1),
(13, 2, 12),
(16, 2, 2),
(18, 2, 4),
(19, 1, 11),
(20, 2, 6),
(22, 2, 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `modul`
--

CREATE TABLE `modul` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `url` varchar(255) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `isparent` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `modul`
--

INSERT INTO `modul` (`id`, `nama`, `url`, `icon`, `isparent`) VALUES
(1, 'Dasbor', 'index.php', 'mdi-home', 0),
(2, 'Data RKA', 'javascript:void()', 'mdi-plus-circle', 1),
(3, 'Penerimaan Dana', 'pencairan.php', 'mdi-check-circle', 0),
(4, 'Saldo', 'javascript:void()', 'mdi-star-circle', 1),
(5, 'Sekolah', 'javascript:void()', 'mdi-school', 1),
(6, 'Belanja', 'javascript:void()', 'mdi-cart', 1),
(7, 'Perubahan RKA', 'javascript:void()', 'mdi-backup-restore', 1),
(8, 'Program Kegiatan', 'javascript:void()', 'mdi-table', 1),
(9, 'Komponen Dana Bos', 'javascript:void()', 'mdi-currency-usd', 1),
(10, 'Kode Rekening', 'javascript:void()', 'mdi-view-list', 1),
(11, 'Laporan', 'javascript:void()', 'mdi-view-list', 1),
(12, 'Pagu', 'javascript:void()', 'mdi-plus', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pagus`
--

CREATE TABLE `pagus` (
  `id` int(11) NOT NULL,
  `ta` year(4) NOT NULL,
  `npsn` varchar(15) NOT NULL,
  `pagu` float NOT NULL,
  `tw1` float NOT NULL,
  `tw2` float NOT NULL,
  `tw3` float NOT NULL,
  `tw4` float NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pagus`
--

INSERT INTO `pagus` (`id`, `ta`, `npsn`, `pagu`, `tw1`, `tw2`, `tw3`, `tw4`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2019, '20320752', 67000000, 13400000, 26800000, 13400000, 13400000, '2019-09-20 03:35:56', '2019-09-20 03:35:56', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pagu_kemarins`
--

CREATE TABLE `pagu_kemarins` (
  `id` int(11) NOT NULL,
  `ta` year(4) NOT NULL,
  `npsn` varchar(15) NOT NULL,
  `pagu` double NOT NULL,
  `sisa` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pagu_perubahans`
--

CREATE TABLE `pagu_perubahans` (
  `id` int(11) NOT NULL,
  `ta` year(4) NOT NULL,
  `npsn` varchar(15) NOT NULL,
  `pagu` double NOT NULL,
  `sisa` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pagu_sisas`
--

CREATE TABLE `pagu_sisas` (
  `id` int(11) NOT NULL,
  `pagu_id` int(11) NOT NULL,
  `tw1` float NOT NULL,
  `tw2` float NOT NULL,
  `tw3` float NOT NULL,
  `tw4` float NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data untuk tabel `pagu_sisas`
--

INSERT INTO `pagu_sisas` (`id`, `pagu_id`, `tw1`, `tw2`, `tw3`, `tw4`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 725000, 150000, 225000, 25000, '2019-09-20 03:35:56', '2019-09-21 07:06:28', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pencairans`
--

CREATE TABLE `pencairans` (
  `id` int(11) NOT NULL,
  `ta` year(4) NOT NULL,
  `triwulan` tinyint(1) NOT NULL,
  `npsn` varchar(15) NOT NULL,
  `saldo` float NOT NULL,
  `sumber_dana` enum('BOS','Dana Lainnya') NOT NULL DEFAULT 'BOS',
  `tanggal_pencairan` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pencairans`
--

INSERT INTO `pencairans` (`id`, `ta`, `triwulan`, `npsn`, `saldo`, `sumber_dana`, `tanggal_pencairan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2019, 1, '20320752', 14000000, 'BOS', '2019-01-01', '2019-09-20 03:36:40', '2019-09-20 03:36:40', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pencairan_sisas`
--

CREATE TABLE `pencairan_sisas` (
  `id` int(11) NOT NULL,
  `pencairan_id` int(11) NOT NULL,
  `saldo` float NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rkas`
--

CREATE TABLE `rkas` (
  `id` int(11) NOT NULL,
  `ta` year(4) NOT NULL,
  `npsn` varchar(15) NOT NULL,
  `triwulan` tinyint(1) NOT NULL,
  `program_id` int(11) NOT NULL,
  `pembiayaan_id` int(11) NOT NULL,
  `rekening_id` int(11) NOT NULL,
  `uraian` varchar(255) NOT NULL,
  `nilai` float NOT NULL,
  `jenis_rka` enum('RKA Tahun Berjalan','RKA Perubahan','RKA Tahun Lalu') NOT NULL DEFAULT 'RKA Tahun Berjalan',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `rkas`
--

INSERT INTO `rkas` (`id`, `ta`, `npsn`, `triwulan`, `program_id`, `pembiayaan_id`, `rekening_id`, `uraian`, `nilai`, `jenis_rka`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2019, '20320752', 1, 4, 9, 10, 'Honorarium Guru Tidak Tetap Bulanan (S1)', 820000, 'RKA Tahun Berjalan', '2019-09-20 04:03:57', '2019-09-20 04:03:57', NULL),
(2, 2019, '20320752', 1, 4, 9, 10, 'Honorarium Guru Tidak Tetap Bulanan (D4))', 820000, 'RKA Tahun Berjalan', '2019-09-20 04:03:57', '2019-09-20 04:03:57', NULL),
(3, 2019, '20320752', 1, 5, 5, 13, 'Belanja Kertas A4', 2835000, 'RKA Tahun Berjalan', '2019-09-20 04:03:57', '2019-09-20 04:03:57', NULL),
(4, 2019, '20320752', 1, 6, 5, 15, 'Belanja Materai 6000', 300000, 'RKA Tahun Berjalan', '2019-09-20 04:03:57', '2019-09-20 04:03:57', NULL),
(5, 2019, '20320752', 1, 6, 7, 27, 'Pembayaran Rekening Telepon', 1500000, 'RKA Tahun Berjalan', '2019-09-20 04:03:57', '2019-09-20 04:03:57', NULL),
(6, 2019, '20320752', 1, 5, 7, 29, 'Pembayaran Rekening Listrik', 3000000, 'RKA Tahun Berjalan', '2019-09-20 04:03:57', '2019-09-20 04:03:57', NULL),
(7, 2019, '20320752', 1, 6, 3, 38, 'Belanja Fotocopy', 900000, 'RKA Tahun Berjalan', '2019-09-20 04:03:57', '2019-09-20 04:03:57', NULL),
(8, 2019, '20320752', 1, 5, 8, 6, 'Pembelian Printer', 2500000, 'RKA Tahun Berjalan', '2019-09-20 04:03:58', '2019-09-20 04:03:58', NULL),
(9, 2019, '20320752', 2, 4, 9, 10, 'Honorarium Guru Tidak Tetap Bulanan (S1)', 820000, 'RKA Tahun Berjalan', '2019-09-20 04:19:47', '2019-09-20 04:19:47', NULL),
(10, 2019, '20320752', 2, 4, 9, 10, 'Honorarium Guru Tidak Tetap Bulanan (D4)', 820000, 'RKA Tahun Berjalan', '2019-09-20 04:19:47', '2019-09-20 04:19:47', NULL),
(11, 2019, '20320752', 2, 5, 5, 13, 'Belanja Kertas A4', 2835000, 'RKA Tahun Berjalan', '2019-09-20 04:19:47', '2019-09-20 04:19:47', NULL),
(12, 2019, '20320752', 2, 6, 5, 15, 'Belanja Materai 6000', 300000, 'RKA Tahun Berjalan', '2019-09-20 04:19:47', '2019-09-20 04:19:47', NULL),
(13, 2019, '20320752', 2, 6, 5, 15, 'Belanja Materai 3000', 150000, 'RKA Tahun Berjalan', '2019-09-20 04:19:47', '2019-09-20 04:19:47', NULL),
(14, 2019, '20320752', 2, 6, 2, 37, 'Spanduk Penerimaan Siswa Baru', 125000, 'RKA Tahun Berjalan', '2019-09-20 04:19:47', '2019-09-20 04:19:47', NULL),
(15, 2019, '20320752', 2, 6, 7, 27, 'Pembayaran Rekening Telepon', 1500000, 'RKA Tahun Berjalan', '2019-09-20 04:19:47', '2019-09-20 04:19:47', NULL),
(16, 2019, '20320752', 2, 6, 7, 29, 'Pembayaran Rekening Listrik', 3000000, 'RKA Tahun Berjalan', '2019-09-20 04:19:47', '2019-09-20 04:19:47', NULL),
(17, 2019, '20320752', 2, 3, 4, 38, 'Penggandaan Soal', 1900000, 'RKA Tahun Berjalan', '2019-09-20 04:19:47', '2019-09-20 04:19:47', NULL),
(18, 2019, '20320752', 2, 6, 3, 38, 'Belanja Fotocopy', 900000, 'RKA Tahun Berjalan', '2019-09-20 04:19:47', '2019-09-20 04:19:47', NULL),
(19, 2019, '20320752', 2, 5, 10, 6, 'Pembelian Komputer', 8500000, 'RKA Tahun Berjalan', '2019-09-20 04:19:47', '2019-09-20 04:19:47', NULL),
(20, 2019, '20320752', 2, 2, 1, 7, 'Pembelian Buku Bahasa Indonesia', 5800000, 'RKA Tahun Berjalan', '2019-09-20 04:19:47', '2019-09-20 04:19:47', NULL),
(21, 2019, '20320752', 3, 4, 9, 10, 'Honorarium Guru Tidak Tetap Bulanan (S1)', 820000, 'RKA Tahun Berjalan', '2019-09-20 04:26:48', '2019-09-20 04:26:48', NULL),
(22, 2019, '20320752', 3, 4, 9, 10, 'Honorarium Guru Tidak Tetap Bulanan (D4)', 820000, 'RKA Tahun Berjalan', '2019-09-20 04:26:48', '2019-09-20 04:26:48', NULL),
(23, 2019, '20320752', 3, 5, 5, 13, 'Belanja Kertas A4', 2835000, 'RKA Tahun Berjalan', '2019-09-20 04:26:48', '2019-09-20 04:26:48', NULL),
(24, 2019, '20320752', 3, 6, 5, 15, 'Belanja Materai 6000', 300000, 'RKA Tahun Berjalan', '2019-09-20 04:26:48', '2019-09-20 04:26:48', NULL),
(25, 2019, '20320752', 3, 6, 7, 27, 'Pembayaran Rekening Telepon', 1500000, 'RKA Tahun Berjalan', '2019-09-20 04:26:48', '2019-09-20 04:26:48', NULL),
(26, 2019, '20320752', 3, 6, 7, 29, 'Pembayaran Rekening Listrik', 3000000, 'RKA Tahun Berjalan', '2019-09-20 04:26:48', '2019-09-20 04:26:48', NULL),
(27, 2019, '20320752', 3, 6, 3, 38, 'Belanja Fotocopy', 900000, 'RKA Tahun Berjalan', '2019-09-20 04:26:48', '2019-09-20 04:26:48', NULL),
(28, 2019, '20320752', 3, 5, 8, 6, 'Pembelian Sound System', 3000000, 'RKA Tahun Berjalan', '2019-09-20 04:28:19', '2019-09-20 04:28:19', NULL),
(29, 2019, '20320752', 4, 4, 9, 10, 'Honorarium Guru Tidak Tetap Bulanan (S1)', 820000, 'RKA Tahun Berjalan', '2019-09-20 04:30:02', '2019-09-20 04:30:02', NULL),
(30, 2019, '20320752', 4, 4, 9, 10, 'Honorarium Guru Tidak Tetap Bulanan (D4)', 820000, 'RKA Tahun Berjalan', '2019-09-20 04:30:02', '2019-09-20 04:30:02', NULL),
(31, 2019, '20320752', 4, 5, 5, 13, 'Belanja Kertas A4', 2835000, 'RKA Tahun Berjalan', '2019-09-21 07:06:28', '2019-09-21 07:06:28', NULL),
(32, 2019, '20320752', 4, 5, 5, 13, 'Belanja Materai 6000', 300000, 'RKA Tahun Berjalan', '2019-09-21 07:06:28', '2019-09-21 07:06:28', NULL),
(33, 2019, '20320752', 4, 6, 7, 27, 'Pembayaran Rekening Telepon', 1500000, 'RKA Tahun Berjalan', '2019-09-21 07:06:28', '2019-09-21 07:06:28', NULL),
(34, 2019, '20320752', 4, 6, 7, 29, 'Pembayaran Rekening Listrik', 3000000, 'RKA Tahun Berjalan', '2019-09-21 07:06:28', '2019-09-21 07:06:28', NULL),
(35, 2019, '20320752', 4, 5, 5, 7, 'Pembelian Lemari', 4100000, 'RKA Tahun Berjalan', '2019-09-21 07:06:28', '2019-09-21 07:06:28', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `rka_sisas`
--

CREATE TABLE `rka_sisas` (
  `id` int(11) NOT NULL,
  `rka_id` int(11) NOT NULL,
  `nilai` float NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `rka_sisas`
--

INSERT INTO `rka_sisas` (`id`, `rka_id`, `nilai`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 0, '2019-09-20 04:03:58', '2019-09-21 07:09:57', NULL),
(2, 2, 0, '2019-09-20 04:03:58', '2019-09-21 07:13:59', NULL),
(3, 3, 0, '2019-09-20 04:03:58', '2019-09-22 05:46:56', NULL),
(4, 4, 0, '2019-09-20 04:03:58', '2019-09-21 07:19:33', NULL),
(5, 5, 0, '2019-09-20 04:03:58', '2019-09-22 05:49:50', NULL),
(6, 6, 0, '2019-09-20 04:03:58', '2019-09-22 05:50:48', NULL),
(7, 7, 0, '2019-09-20 04:03:58', '2019-09-22 05:48:56', NULL),
(8, 8, 0, '2019-09-20 04:03:58', '2019-09-21 07:27:07', NULL),
(9, 9, 820000, '2019-09-20 04:19:47', '2019-09-20 04:19:47', NULL),
(10, 10, 820000, '2019-09-20 04:19:47', '2019-09-20 04:19:47', NULL),
(11, 11, 2835000, '2019-09-20 04:19:47', '2019-09-20 04:19:47', NULL),
(12, 12, 300000, '2019-09-20 04:19:47', '2019-09-20 04:19:47', NULL),
(13, 13, 150000, '2019-09-20 04:19:47', '2019-09-20 04:19:47', NULL),
(14, 14, 125000, '2019-09-20 04:19:47', '2019-09-20 04:19:47', NULL),
(15, 15, 1500000, '2019-09-20 04:19:47', '2019-09-20 04:19:47', NULL),
(16, 16, 3000000, '2019-09-20 04:19:47', '2019-09-20 04:19:47', NULL),
(17, 17, 1900000, '2019-09-20 04:19:48', '2019-09-20 04:19:48', NULL),
(18, 18, 900000, '2019-09-20 04:19:48', '2019-09-20 04:19:48', NULL),
(19, 19, 8500000, '2019-09-20 04:19:48', '2019-09-20 04:19:48', NULL),
(20, 20, 5800000, '2019-09-20 04:19:48', '2019-09-20 04:19:48', NULL),
(21, 21, 820000, '2019-09-20 04:26:48', '2019-09-20 04:26:48', NULL),
(22, 22, 820000, '2019-09-20 04:26:48', '2019-09-20 04:26:48', NULL),
(23, 23, 2835000, '2019-09-20 04:26:48', '2019-09-20 04:26:48', NULL),
(24, 24, 300000, '2019-09-20 04:26:48', '2019-09-20 04:26:48', NULL),
(25, 25, 1500000, '2019-09-20 04:26:48', '2019-09-20 04:26:48', NULL),
(26, 26, 3000000, '2019-09-20 04:26:48', '2019-09-20 04:26:48', NULL),
(27, 27, 900000, '2019-09-20 04:26:48', '2019-09-20 04:26:48', NULL),
(28, 28, 3000000, '2019-09-20 04:28:19', '2019-09-20 04:28:19', NULL),
(29, 29, 820000, '2019-09-20 04:30:02', '2019-09-20 04:30:02', NULL),
(30, 30, 820000, '2019-09-20 04:30:02', '2019-09-20 04:30:02', NULL),
(31, 31, 2835000, '2019-09-21 07:06:28', '2019-09-21 07:06:28', NULL),
(32, 32, 300000, '2019-09-21 07:06:28', '2019-09-21 07:06:28', NULL),
(33, 33, 1500000, '2019-09-21 07:06:28', '2019-09-21 07:06:28', NULL),
(34, 34, 3000000, '2019-09-21 07:06:28', '2019-09-21 07:06:28', NULL),
(35, 35, 4100000, '2019-09-21 07:06:28', '2019-09-21 07:06:28', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `id` int(5) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `role`
--

INSERT INTO `role` (`id`, `nama`) VALUES
(1, 'Admin'),
(2, 'Sekolah');

-- --------------------------------------------------------

--
-- Struktur dari tabel `saldos`
--

CREATE TABLE `saldos` (
  `id` int(11) NOT NULL,
  `npsn` varchar(15) NOT NULL,
  `ta` year(4) NOT NULL,
  `sisa` float NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `saldos`
--

INSERT INTO `saldos` (`id`, `npsn`, `ta`, `sisa`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '20320752', 2019, 1325000, '2019-09-20 03:36:40', '2019-09-22 05:50:48', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sekolah`
--

CREATE TABLE `sekolah` (
  `id_sekolah` int(11) NOT NULL,
  `npsn` varchar(15) NOT NULL,
  `nama_sekolah` varchar(200) NOT NULL,
  `jenjang` enum('SD','SMP') NOT NULL,
  `status` enum('Negeri','Swasta') NOT NULL,
  `kecamatan` int(11) DEFAULT NULL,
  `password` varchar(200) NOT NULL,
  `role` int(1) NOT NULL DEFAULT 2,
  `alamat` varchar(255) DEFAULT NULL,
  `telepon` varchar(15) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `nama_kepsek` varchar(200) DEFAULT NULL,
  `nip_kepsek` varchar(50) DEFAULT NULL,
  `nama_bendahara` varchar(200) DEFAULT NULL,
  `nip_bendahara` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `sekolah`
--

INSERT INTO `sekolah` (`id_sekolah`, `npsn`, `nama_sekolah`, `jenjang`, `status`, `kecamatan`, `password`, `role`, `alamat`, `telepon`, `foto`, `nama_kepsek`, `nip_kepsek`, `nama_bendahara`, `nip_bendahara`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '20320752', 'SD NEGERI BARAN 01 ', 'SD', 'Negeri', 17, '20320752', 2, ' Baran ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, '20320751', ' SD NEGERI BARAN 02 ', 'SD', 'Negeri', 17, '20320751', 2, ' Jl Bandungan No 38 Ambarawa ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, '20320750', ' SD NEGERI BEJALEN ', 'SD', 'Negeri', 17, '20320750', 2, ' Bejalen ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, '20320100', ' SD NEGERI KRANGGAN 01 ', 'SD', 'Negeri', 17, '20320100', 2, ' Jalan Doktor Cipto No.111 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, '20320099', ' SD NEGERI KUPANG 01 ', 'SD', 'Negeri', 17, '20320099', 2, ' Jl J. Sudirman No 128 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, '20320085', ' SD NEGERI KUPANG 02 ', 'SD', 'Negeri', 17, '20320085', 2, ' Jl Gatot Subroto No. 25 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, '20320149', ' SD NEGERI KUPANG 03 ', 'SD', 'Negeri', 17, '20320149', 2, ' Jl.Bougenvile II NO.23 Kupang Dukuh ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, '20320202', ' SD NEGERI KUPANG 04 ', 'SD', 'Negeri', 17, '20320202', 2, ' Jl Bugenvil II Kupang Dukuh ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, '20320194', ' SD NEGERI LODOYONG 02 ', 'SD', 'Negeri', 17, '20320194', 2, ' Jl Brigjen Sudiarto 62 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, '20320193', ' SD NEGERI LODOYONG 03 ', 'SD', 'Negeri', 17, '20320193', 2, ' Lodoyong ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, '20320172', ' SD NEGERI NGAMPIN 01 ', 'SD', 'Negeri', 17, '20320172', 2, ' Jl Mgr Sugiyopranoto No 100 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, '20320171', ' SD NEGERI NGAMPIN 02 ', 'SD', 'Negeri', 17, '20320171', 2, ' GARUNG ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, '20320018', ' SD NEGERI PANJANG 02 ', 'SD', 'Negeri', 17, '20320018', 2, ' Jl Pemuda No 90 Ambarawa ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, '20320029', ' SD NEGERI PANJANG 03 ', 'SD', 'Negeri', 17, '20320029', 2, ' Panjang ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, '20320028', ' SD NEGERI PANJANG 04 ', 'SD', 'Negeri', 17, '20320028', 2, ' Jl Tentara Pelajar No 30 Ambarawa ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, '20320024', ' SD NEGERI PASEKAN 01 ', 'SD', 'Negeri', 17, '20320024', 2, ' Jl. Ki Cogati 1 Pasekan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, '20320023', ' SD NEGERI PASEKAN 02 ', 'SD', 'Negeri', 17, '20320023', 2, ' Pluwang ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, '20320022', ' SD NEGERI PASEKAN 03 ', 'SD', 'Negeri', 17, '20320022', 2, ' Kintelan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, '20319959', 'SD NEGERI POJOKSARI ', 'SD', 'Negeri', 17, '20319959', 2, 'Jl Pemuda No 137', '', NULL, '', '', '', '', NULL, '2019-08-28 07:02:10', NULL),
(20, '20320050', ' SD NEGERI SUDIRMAN ', 'SD', 'Negeri', 17, '20320050', 2, ' Jl.kartini 34 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, '20320362', ' SD NEGERI TAMBAKBOYO 01 ', 'SD', 'Negeri', 17, '20320362', 2, ' Jl. Kartini 38 Tambakboyo ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, '20320361', ' SD NEGERI TAMBAKBOYO 02 ', 'SD', 'Negeri', 17, '20320361', 2, ' Tambakboyo ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, '20320804', ' SD KANISIUS LODOYONG ', 'SD', 'Swasta', 17, '20320804', 2, ' JL. BRIGJEN SUDIARTO 81 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, '20320790', ' SD KRISTEN LENTERA AMBARAWA ', 'SD', 'Swasta', 17, '20320790', 2, ' Jl.dr.Cipto Mangun Kusumo No 20 C ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, '20320785', ' SD KRISTEN NGAMPIN ', 'SD', 'Swasta', 17, '20320785', 2, ' Jl.magelang Km 3 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, '20320781', ' SD PANGUDI LUHUR AMBARAWA ', 'SD', 'Swasta', 17, '20320781', 2, ' Jl. Mgr. Soegijapranata No. 30 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, '20320780', ' SD VIRGO MARIA 1 ', 'SD', 'Swasta', 17, '20320780', 2, ' Jl Mgr Soegijapranata No. 70 Ambarawa ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, '69754220', ' SDIT AR ROHMAH AMBARAWA ', 'SD', 'Swasta', 17, '69754220', 2, ' Desa Pojoksari Rt 5 Rw 1 Ambarawa ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, '20320499', ' SDIT IBNU MAS`UD ', 'SD', 'Swasta', 17, '20320499', 2, ' Ngampin Ambarawa ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, '20320290', ' SMP NEGERI 1 AMBARAWA ', 'SMP', 'Negeri', 17, '20320290', 2, ' Jl. Dr. Cipto Mangunkusumo 42 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, '20320286', ' SMP NEGERI 2 AMBARAWA ', 'SMP', 'Negeri', 17, '20320286', 2, ' Jl. Kartini 1a ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, '20320284', ' SMP NEGERI 3 AMBARAWA ', 'SMP', 'Negeri', 17, '20320284', 2, ' Ngampin ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, '20320276', ' SMP NEGERI 4 AMBARAWA ', 'SMP', 'Negeri', 17, '20320276', 2, ' Rejosari ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(34, '20320274', ' SMP NEGERI 5 AMBARAWA ', 'SMP', 'Negeri', 17, '20320274', 2, ' Jl. Yos Sudarso ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(35, '20341205', ' SMP NEGERI 6 AMBARAWA SATU ATAP ', 'SMP', 'Negeri', 17, '20341205', 2, ' Pluwang Rt 20 Rw 07 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(36, '20320213', ' SMP ISLAM SUDIRMAN AMBARAWA ', 'SMP', 'Swasta', 17, '20320213', 2, ' Kupang Lor Ambarawa ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, '20320296', ' SMP KRISTEN LENTERA AMBARAWA ', 'SMP', 'Swasta', 17, '20320296', 2, ' Jl. Dr Cipto No.20 A Ambarawa ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, '20320226', ' SMP MATER ALMA ', 'SMP', 'Swasta', 17, '20320226', 2, ' Jl Mgr Sugiyopranoto 58 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(39, '20320225', ' SMP MUHAMMADIYAH AMBARAWA ', 'SMP', 'Swasta', 17, '20320225', 2, ' Jl. Bougenville II Kupang ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(40, '20320204', ' SMP PANGUDI LUHUR AMBARAWA ', 'SMP', 'Swasta', 17, '20320204', 2, ' Jl. Mgr. Sugiyapranata No.191 Ambarawa ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(41, '20320295', ' SMP TAMAN DEWASA AMBARAWA ', 'SMP', 'Swasta', 17, '20320295', 2, ' Jl Dr Cipto 63 Ambarawa ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(42, '20320798', ' SD NEGERI BANCAK 01 ', 'SD', 'Negeri', 9, '20320798', 2, ' Krajan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(43, '20320760', ' SD NEGERI BANTAL ', 'SD', 'Negeri', 9, '20320760', 2, ' Bantal Gunung Rt 02/01 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44, '20320845', ' SD NEGERI BOTO 01 ', 'SD', 'Negeri', 9, '20320845', 2, ' Boto ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(45, '20320846', ' SD NEGERI BOTO 02 ', 'SD', 'Negeri', 9, '20320846', 2, ' Boto ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(46, '20320730', ' SD NEGERI JLUMPANG ', 'SD', 'Negeri', 9, '20320730', 2, ' Jlumpang ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(47, '20320190', ' SD NEGERI LEMBU ', 'SD', 'Negeri', 9, '20320190', 2, ' Jln Nusa Indah ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(48, '20319960', ' SD NEGERI PLUMUTAN ', 'SD', 'Negeri', 9, '20319960', 2, ' KALISARI ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(49, '20319973', ' SD NEGERI PUCUNG ', 'SD', 'Negeri', 9, '20319973', 2, ' Pucung ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(50, '20320065', ' SD NEGERI REJOSARI 01 ', 'SD', 'Negeri', 9, '20320065', 2, ' Dsn Ngaglik ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51, '20320064', ' SD NEGERI REJOSARI 02 ', 'SD', 'Negeri', 9, '20320064', 2, ' Krajan RT 01 RK 01 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(52, '20320063', ' SD NEGERI REJOSARI 03 ', 'SD', 'Negeri', 9, '20320063', 2, ' Galangan Rejosari ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(53, '20320414', ' SD NEGERI WONOKERTO ', 'SD', 'Negeri', 9, '20320414', 2, ' Jl. Sultan Agung No. 05 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(54, '20320289', ' SMP NEGERI 1 BANCAK ', 'SMP', 'Negeri', 9, '20320289', 2, ' Jl. Raya Rejosari-Bringin Km. 18 Bancak ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(55, '20320212', ' SMP ISLAM SUDIRMAN 1 BANCAK ', 'SMP', 'Swasta', 9, '20320212', 2, ' Jl.sultan Agung No. 172 Boto ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(56, '20320776', ' SD NEGERI BANDUNGAN 01 ', 'SD', 'Negeri', 19, '20320776', 2, ' Jln. Diponegoro KM 01 Bandungan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(57, '20320775', ' SD NEGERI BANDUNGAN 02 ', 'SD', 'Negeri', 19, '20320775', 2, ' Ds Piyoto ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(58, '20320761', ' SD NEGERI BANDUNGAN 03 ', 'SD', 'Negeri', 19, '20320761', 2, ' Jl Tirtomoyo No 63 Bandungan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(59, '20320753', ' SD NEGERI BANYUKUNING ', 'SD', 'Negeri', 19, '20320753', 2, ' Banyukuning ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(60, '20320832', ' SD NEGERI CANDI 01 ', 'SD', 'Negeri', 19, '20320832', 2, ' Jl Raya Bandungan-Sumowono Km 03 Tarukan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(61, '20320831', ' SD NEGERI CANDI 02 ', 'SD', 'Negeri', 19, '20320831', 2, ' Ds Ngonto ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(62, '20320817', ' SD NEGERI CANDI 03 ', 'SD', 'Negeri', 19, '20320817', 2, ' Jl Gedong Songo No 8 Ngipik ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(63, '20331135', ' SD NEGERI DUREN ', 'SD', 'Negeri', 19, '20331135', 2, ' Jalan Mayor Soeyoto Km.8 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(64, '20340384', ' SD NEGERI JETIS 01 ', 'SD', 'Negeri', 19, '20340384', 2, ' Jl. Bandungan Km. 4 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(65, '20320734', ' SD NEGERI JETIS 02 ', 'SD', 'Negeri', 19, '20320734', 2, ' Ngasem ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(66, '20320731', ' SD NEGERI JIMBARAN 01 ', 'SD', 'Negeri', 19, '20320731', 2, ' Jimbaran ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(67, '20320139', ' SD NEGERI KENTENG 01 ', 'SD', 'Negeri', 19, '20320139', 2, ' Jalan Sukorini No. 5 Karanglo-Kenteng, Kec. Bandungan, Kab. semarang Jateng ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(68, '20320138', ' SD NEGERI KENTENG 02 ', 'SD', 'Negeri', 19, '20320138', 2, ' Dsn.Clowok ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(69, '20320160', ' SD NEGERI MLILIR 01 ', 'SD', 'Negeri', 19, '20320160', 2, ' Jln. Raya Desa Mlilir Kec. Bandungan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(70, '20320159', ' SD NEGERI MLILIR 02 ', 'SD', 'Negeri', 19, '20320159', 2, ' JURANG BELIK PRAMPELAN ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(71, '20319985', ' SD NEGERI PAKOPEN 01 ', 'SD', 'Negeri', 19, '20319985', 2, ' Pakopen. ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(72, '20320017', ' SD NEGERI PAKOPEN 02 ', 'SD', 'Negeri', 19, '20320017', 2, ' Pakopen ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(73, '20320037', ' SD NEGERI SIDOMUKTI 02 ', 'SD', 'Negeri', 19, '20320037', 2, ' Sidomukti ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(74, '20320036', ' SD NEGERI SIDOMUKTI 03 ', 'SD', 'Negeri', 19, '20320036', 2, ' Sidomukti ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(75, '20320035', ' SD NEGERI SIDOMUKTI 04 ', 'SD', 'Negeri', 19, '20320035', 2, ' Geblog, Sidomukti, Bandungan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(76, '20331133', ' SD IT ASSALAM BANDUNGAN ', 'SD', 'Swasta', 19, '20331133', 2, ' Jalan Ambarawa km 02 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(77, '20320478', ' SD KANISIUS JIMBARAN ', 'SD', 'Swasta', 19, '20320478', 2, ' Jl. Mawar No 6 Jimbaran ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(78, '20320640', ' SD KANISIUS KALIWINONG ', 'SD', 'Swasta', 19, '20320640', 2, ' Kaliwinong ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(79, '69974269', ' SD ALAM AZ-ZIDA ', 'SD', 'Swasta', 19, '69974269', 2, ' Jl. Jimbaran Km.01 Tegal Panas ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(80, '20320283', ' SMP NEGERI 1 BANDUNGAN ', 'SMP', 'Negeri', 19, '20320283', 2, ' JIMBARAN ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(81, '20339206', ' SMP NEGERI 2 BANDUNGAN SATU ATAP ', 'SMP', 'Negeri', 19, '20339206', 2, ' Kenteng ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(82, '69887368', ' SMP AL MAS`UDIYYAH BANDUNGAN ', 'SMP', 'Swasta', 19, '69887368', 2, ' Blater ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(83, '69972267', ' SMP IT ASSALAM BANDUNGAN ', 'SMP', 'Swasta', 19, '69972267', 2, ' Jl. Ambarawa-Bandungan Km 2 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(84, '69972949', ' SMP IT AL FALAH BANDUNGAN ', 'SMP', 'Swasta', 19, '69972949', 2, ' Jl. Ambarawa-Bandungan Km 5 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(85, '20320759', ' SD NEGERI BANYUBIRU 01 ', 'SD', 'Negeri', 15, '20320759', 2, ' Jalan Melati No 4 Banyubiru ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(86, '20320757', ' SD NEGERI BANYUBIRU 03 ', 'SD', 'Negeri', 15, '20320757', 2, ' Banyubiru ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87, '20320756', ' SD NEGERI BANYUBIRU 04 ', 'SD', 'Negeri', 15, '20320756', 2, ' Banyubiru ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(88, '20320755', ' SD NEGERI BANYUBIRU 05 ', 'SD', 'Negeri', 15, '20320755', 2, ' Jln. Kyai Djojoprojo No. 10 Banyubiru Krajan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(89, '20320754', ' SD NEGERI BANYUBIRU 06 ', 'SD', 'Negeri', 15, '20320754', 2, ' Jalan WijayaKusuma No. 20 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(90, '20320682', ' SD NEGERI GEDONG 01 ', 'SD', 'Negeri', 15, '20320682', 2, ' Banyudono ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(91, '20320683', ' SD NEGERI GEDONG 02 ', 'SD', 'Negeri', 15, '20320683', 2, ' Jl.Gajahmungkur N0.02 Kayuwangi ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(92, '20320694', ' SD NEGERI GEDONG 03 ', 'SD', 'Negeri', 15, '20320694', 2, ' Gedong ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(93, '20320133', ' SD NEGERI KEBONDOWO 01 ', 'SD', 'Negeri', 15, '20320133', 2, ' Jl.banyubiru Sltg Km 1,5 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(94, '20320132', ' SD NEGERI KEBONDOWO 02 ', 'SD', 'Negeri', 15, '20320132', 2, ' Jl.Delima No 8 Pundan Rt01 Rw04 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(95, '20320131', ' SD NEGERI KEBONDOWO 03 ', 'SD', 'Negeri', 15, '20320131', 2, ' Jl.raya Banyubiru Muncul ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(96, '20320118', ' SD NEGERI KEBUMEN 01 ', 'SD', 'Negeri', 15, '20320118', 2, ' Jl.perengkuning No 27 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(97, '20320116', ' SD NEGERI KEBUMEN 03 ', 'SD', 'Negeri', 15, '20320116', 2, ' Jl. Kapuas no. 2 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(98, '20320146', ' SD NEGERI KEMAMBANG 02 ', 'SD', 'Negeri', 15, '20320146', 2, ' Jln. Telomoyo No. 1 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(99, '20320070', ' SD NEGERI RAPAH 02 ', 'SD', 'Negeri', 15, '20320070', 2, ' JLN. HM NOOR N0 03 NGRAPAH ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100, '20320069', ' SD NEGERI RAPAH 03 ', 'SD', 'Negeri', 15, '20320069', 2, ' Dusun Mendut RT 02 RW 03 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(101, '20320081', ' SD NEGERI ROWOBONI 01 ', 'SD', 'Negeri', 15, '20320081', 2, ' Rowokasam, Rt 02 Rw 03 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(102, '20320080', ' SD NEGERI ROWOBONI 02 ', 'SD', 'Negeri', 15, '20320080', 2, ' Jl.Raya Muncul Km.4 Candisari ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(103, '20320041', ' SD NEGERI SEPAKUNG ', 'SD', 'Negeri', 15, '20320041', 2, ' Jl.asparagus No 27 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(104, '20320323', ' SD NEGERI TEGARON 01 ', 'SD', 'Negeri', 15, '20320323', 2, ' Tegaron ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(105, '20320322', ' SD NEGERI TEGARON 02 ', 'SD', 'Negeri', 15, '20320322', 2, ' Tegaron ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(106, '20320419', ' SD NEGERI WIROGOMO 01 ', 'SD', 'Negeri', 15, '20320419', 2, ' Jl Telomoyo 08 Wirogomo Lor ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(107, '20320418', ' SD NEGERI WIROGOMO 02 ', 'SD', 'Negeri', 15, '20320418', 2, ' Wirogomo ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(108, '20320288', ' SMP NEGERI 1 BANYUBIRU ', 'SMP', 'Negeri', 15, '20320288', 2, ' Jln. Melati No. 19 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(109, '20320285', ' SMP NEGERI 2 BANYUBIRU ', 'SMP', 'Negeri', 15, '20320285', 2, ' Jln. Brantas ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(110, '20339167', ' SMP NEGERI 3 BANYUBIRU ', 'SMP', 'Negeri', 15, '20339167', 2, ' Jl. TELOMOYO, KM 6 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(111, '20320211', ' SMP ISLAM SUDIRMAN BANYUBIRU ', 'SMP', 'Swasta', 15, '20320211', 2, ' Tegaron ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(112, '20320312', ' SMP PGRI BANYUBIRU ', 'SMP', 'Swasta', 15, '20320312', 2, ' Tegal Wuni ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(113, '20320792', ' SD NEGERI ASINAN 01 ', 'SD', 'Negeri', 5, '20320792', 2, ' Asinan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(114, '20320803', ' SD NEGERI ASINAN 02 ', 'SD', 'Negeri', 5, '20320803', 2, ' Dusun sumurup Rt 11 Rw 04 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(115, '20320770', ' SD NEGERI BAWEN 01 ', 'SD', 'Negeri', 5, '20320770', 2, ' Bawen ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(116, '20320769', ' SD NEGERI BAWEN 03 ', 'SD', 'Negeri', 5, '20320769', 2, ' Dusun Berokan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(117, '20320768', ' SD NEGERI BAWEN 04 ', 'SD', 'Negeri', 5, '20320768', 2, ' Jl Slamet Riyadi No 43 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(118, '20320695', ' SD NEGERI DOPLANG 02 ', 'SD', 'Negeri', 5, '20320695', 2, ' Jurangsari ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(119, '20320653', ' SD NEGERI HARJOSARI 01 ', 'SD', 'Negeri', 5, '20320653', 2, ' Harjosari ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(120, '20320654', ' SD NEGERI HARJOSARI 02 ', 'SD', 'Negeri', 5, '20320654', 2, ' Jl. Kendalisodo No. 53 Gandekan Harjosari ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(121, '20320704', ' SD NEGERI KANDANGAN 01 ', 'SD', 'Negeri', 5, '20320704', 2, ' Kandangan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(122, '20320703', ' SD NEGERI KANDANGAN 02 ', 'SD', 'Negeri', 5, '20320703', 2, ' Kandangan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(123, '20320702', ' SD NEGERI KANDANGAN 03 ', 'SD', 'Negeri', 5, '20320702', 2, ' Krajan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(124, '20331139', ' SD NEGERI KANDANGAN 04 ', 'SD', 'Negeri', 5, '20331139', 2, ' Geneng ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(125, '20320186', ' SD NEGERI LEMAHIRENG 01 ', 'SD', 'Negeri', 5, '20320186', 2, ' Lemahireng ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(126, '20320179', ' SD NEGERI LEMAHIRENG 02 ', 'SD', 'Negeri', 5, '20320179', 2, ' Krajan RT 06 RW 01 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(127, '20320178', ' SD NEGERI LEMAHIRENG 03 ', 'SD', 'Negeri', 5, '20320178', 2, ' Lemahireng ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(128, '20320189', ' SD NEGERI LEMAHIRENG 05 ', 'SD', 'Negeri', 5, '20320189', 2, ' Lemahireng ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(129, '20319969', ' SD NEGERI POLOSIRI 01 ', 'SD', 'Negeri', 5, '20319969', 2, ' Polosiri ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(130, '20319970', ' SD NEGERI POLOSIRI 02 ', 'SD', 'Negeri', 5, '20319970', 2, ' Kaliputih ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(131, '20319981', ' SD NEGERI PONCORUSO ', 'SD', 'Negeri', 5, '20319981', 2, ' Poncoroso ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(132, '20320078', ' SD NEGERI SAMBAN 01 ', 'SD', 'Negeri', 5, '20320078', 2, ' Samban ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(133, '20320077', ' SD NEGERI SAMBAN 02 ', 'SD', 'Negeri', 5, '20320077', 2, ' Samban Rt 03/ Rw 02 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(134, '20320500', ' SD ISLAM PLUS HAJI MUHAMMAD SUBANDI ', 'SD', 'Swasta', 5, '20320500', 2, ' Kadipaten RT 01 RW 04 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(135, '20320498', ' SD ISLAM TERPADU PERMATA BUNDA ', 'SD', 'Swasta', 5, '20320498', 2, ' Jl. Gatot Subroto No. 15 Bawen ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(136, '20320492', ' SD KANISIUS HARJOSARI ', 'SD', 'Swasta', 5, '20320492', 2, ' Glodogan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(137, '20320779', ' SD VIRGO MARIA 2 ', 'SD', 'Swasta', 5, '20320779', 2, ' Jl. Palagan No. 59 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(138, '20320299', ' SMP NEGERI 1 BAWEN ', 'SMP', 'Negeri', 5, '20320299', 2, ' Jl Soekarno-hatta 54 Bawen ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(139, '20320271', ' SMP NEGERI 2 BAWEN ', 'SMP', 'Negeri', 5, '20320271', 2, ' Dsn.kandangan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(140, '20320291', ' SMP 17 XII BAWEN ', 'SMP', 'Swasta', 5, '20320291', 2, ' Jl. HARJOSARI BAWEN ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(141, '20320230', ' SMP DARUL FIKRI BAWEN ', 'SMP', 'Swasta', 5, '20320230', 2, ' Gatot Subroto Bawen ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(142, '20320839', ' SD NEGERI BERGAS KIDUL 01 ', 'SD', 'Negeri', 3, '20320839', 2, ' Jl Flamboyan No. 28 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(143, '20320838', ' SD NEGERI BERGAS KIDUL 03 ', 'SD', 'Negeri', 3, '20320838', 2, ' Jl. Lemah Abang-Bandungan Km.3 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(144, '20320837', ' SD NEGERI BERGAS KIDUL 04 ', 'SD', 'Negeri', 3, '20320837', 2, ' Kebon Kliwon ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(145, '20320836', ' SD NEGERI BERGAS LOR 01 ', 'SD', 'Negeri', 3, '20320836', 2, ' Jl.Soekarno-Hatta 61 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(146, '20320835', ' SD NEGERI BERGAS LOR 02 ', 'SD', 'Negeri', 3, '20320835', 2, ' Jl.raya Bandungan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(147, '20320806', ' SD NEGERI DIWAK ', 'SD', 'Negeri', 3, '20320806', 2, ' Diwak ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(148, '20320676', ' SD NEGERI GEBUGAN 01 ', 'SD', 'Negeri', 3, '20320676', 2, ' Gebugan Rt01/Rw1 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(149, '20320675', ' SD NEGERI GEBUGAN 02 ', 'SD', 'Negeri', 3, '20320675', 2, ' Bengkle RT 01/05 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(150, '20320674', ' SD NEGERI GEBUGAN 03 ', 'SD', 'Negeri', 3, '20320674', 2, ' Tegalmelik ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(151, '20320645', ' SD NEGERI GONDORIYO 02 ', 'SD', 'Negeri', 3, '20320645', 2, ' Jl. Munadi No. 07 Dsn. Setro RT. 04 / RW. 011 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(152, '20320644', ' SD NEGERI GONDORIYO 03 ', 'SD', 'Negeri', 3, '20320644', 2, ' Gondoriyo ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(153, '20320661', ' SD NEGERI JATIJAJAR 01 ', 'SD', 'Negeri', 3, '20320661', 2, ' Jatijajar, RT 01 RW I, Bergas - 50552 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(154, '20320660', ' SD NEGERI JATIJAJAR 02 ', 'SD', 'Negeri', 3, '20320660', 2, ' Kebonan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(155, '20320719', ' SD NEGERI KARANGJATI 01 ', 'SD', 'Negeri', 3, '20320719', 2, ' Jl. Krakatau No. 1A Ds. Gembongan, Kel. Karangjati, Kec. Bergas 50552 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(156, '20320718', ' SD NEGERI KARANGJATI 02 ', 'SD', 'Negeri', 3, '20320718', 2, ' JALAN MERAK NO 7 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(157, '20320717', ' SD NEGERI KARANGJATI 03 ', 'SD', 'Negeri', 3, '20320717', 2, ' Jl.teladan 27 C Rt 06 Rw 02 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(158, '20320716', ' SD NEGERI KARANGJATI 04 ', 'SD', 'Negeri', 3, '20320716', 2, ' RT 11 RW IV Gembongan - Karangjati ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(159, '20320152', ' SD NEGERI MUNDING ', 'SD', 'Negeri', 3, '20320152', 2, ' Munding Rt 08 Rw 01 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(160, '20320168', ' SD NEGERI NGEMPON 01 ', 'SD', 'Negeri', 3, '20320168', 2, ' Jl Tlompak Sari ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(161, '20320167', ' SD NEGERI NGEMPON 02 ', 'SD', 'Negeri', 3, '20320167', 2, ' Jl. Raya Ngempon No.11 RT 04 / RW 03 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(162, '20319989', ' SD NEGERI PAGERSARI 01 ', 'SD', 'Negeri', 3, '20319989', 2, ' Pagersari ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(163, '20319988', ' SD NEGERI PAGERSARI 02 ', 'SD', 'Negeri', 3, '20319988', 2, ' Dusun Pagersari RT 02 RW 02 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(164, '20320031', ' SD NEGERI RANDUGUNTING ', 'SD', 'Negeri', 3, '20320031', 2, ' Randugunting ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(165, '20320395', ' SD NEGERI WRINGIN PUTIH 03 ', 'SD', 'Negeri', 3, '20320395', 2, ' Dusun Ngobo ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(166, '20320410', ' SD NEGERI WRINGINPUTIH 01 ', 'SD', 'Negeri', 3, '20320410', 2, ' Wringinputih ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(167, '20320396', ' SD NEGERI WRINGINPUTIH 02 ', 'SD', 'Negeri', 3, '20320396', 2, ' JL Raya PTP IX Ngobo ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(168, '20320394', ' SD NEGERI WUJIL 01 ', 'SD', 'Negeri', 3, '20320394', 2, ' Jl Purwoko No 06 RT 02 RW 01 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(169, '20320380', ' SD NEGERI WUJIL 02 ', 'SD', 'Negeri', 3, '20320380', 2, ' JL. SUKORINI NO. 25 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(170, '20320501', ' SD IT CAHAYA UMMAT BERGAS ', 'SD', 'Swasta', 3, '20320501', 2, ' Jl. Kalinjaro ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(171, '20320493', ' SD KANISIUS GIRISONTA ', 'SD', 'Swasta', 3, '20320493', 2, ' Jl.Soekarno - Hatta No.97 Bergas ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(172, '69971642', ' SD ISLAM CENDEKIA NGEMPON ', 'SD', 'Swasta', 3, '69971642', 2, ' Lingkungan Ngempon Kidul, RT 01/05 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(173, '20320300', ' SMP NEGERI 1 BERGAS ', 'SMP', 'Negeri', 3, '20320300', 2, ' Karangjati ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(174, '69955005', ' SMP DARUSSALAM BERGAS ', 'SMP', 'Swasta', 3, '69955005', 2, ' Jl. Syekh Penanggalan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(175, '20331044', ' SMP ISLAM TERPADU CAHAYA UMMAT ', 'SMP', 'Swasta', 3, '20331044', 2, ' Jl Kalinjaro ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(176, '20320216', ' SMP KANSIUS GIRISONTA ', 'SMP', 'Swasta', 3, '20320216', 2, ' Jl. Soekarno - Hatta, Karangjati Bergas ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(177, '20320298', ' SMP PGRI BERGAS ', 'SMP', 'Swasta', 3, '20320298', 2, ' Jl. PTP NGOBO ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(178, '20320793', ' SD NEGERI BANDING 01 ', 'SD', 'Negeri', 6, '20320793', 2, ' Dusun Gendor ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(179, '20320778', ' SD NEGERI BANDING 02 ', 'SD', 'Negeri', 6, '20320778', 2, ' Jl.h. Juanda No.86 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(180, '20320857', ' SD NEGERI BRINGIN 01 ', 'SD', 'Negeri', 6, '20320857', 2, ' Jl.diponegoro 116 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(181, '20320856', ' SD NEGERI BRINGIN 02 ', 'SD', 'Negeri', 6, '20320856', 2, ' Jl.Diponegoro 80 Bringin ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(182, '20320855', ' SD NEGERI BRINGIN 03 ', 'SD', 'Negeri', 6, '20320855', 2, ' Dsn Kroyo ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(183, '20320649', ' SD NEGERI GOGODALEM 01 ', 'SD', 'Negeri', 6, '20320649', 2, ' Jl.Nitinegoro Gogodalem ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(184, '20320648', ' SD NEGERI GOGODALEM 02 ', 'SD', 'Negeri', 6, '20320648', 2, ' Gogodalem ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(185, '20320748', ' SD NEGERI KALIJAMBE ', 'SD', 'Negeri', 6, '20320748', 2, ' Kalijambe ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(186, '20320745', ' SD NEGERI KALIKURMO ', 'SD', 'Negeri', 6, '20320745', 2, ' Kalikurmo ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(187, '20320180', ' SD NEGERI LEBAK ', 'SD', 'Negeri', 6, '20320180', 2, ' Jl.raden Patah ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(188, '20320015', ' SD NEGERI NYEMOH ', 'SD', 'Negeri', 6, '20320015', 2, ' Dusun Nyemoh ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(189, '20319986', ' SD NEGERI PAKIS ', 'SD', 'Negeri', 6, '20319986', 2, ' Jl.merpati 64d ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(190, '20319980', ' SD NEGERI POPONGAN ', 'SD', 'Negeri', 6, '20319980', 2, ' Jl. H. Agus Salim No. 01 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(191, '20320071', ' SD NEGERI REMBES 01 ', 'SD', 'Negeri', 6, '20320071', 2, ' Watugimbal ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(192, '20320072', ' SD NEGERI REMBES 02 ', 'SD', 'Negeri', 6, '20320072', 2, ' Rembes ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(193, '20320076', ' SD NEGERI SAMBIREJO 01 ', 'SD', 'Negeri', 6, '20320076', 2, ' Sambirejo ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(194, '20320075', ' SD NEGERI SAMBIREJO 02 ', 'SD', 'Negeri', 6, '20320075', 2, ' Sambirejo ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(195, '20320043', ' SD NEGERI SENDANG 01 ', 'SD', 'Negeri', 6, '20320043', 2, ' Jl.sultan Agung ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(196, '20320360', ' SD NEGERI TANJUNG 01 ', 'SD', 'Negeri', 6, '20320360', 2, ' Naligunung ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(197, '20320359', ' SD NEGERI TANJUNG 02 ', 'SD', 'Negeri', 6, '20320359', 2, ' Tanjung ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(198, '20320321', ' SD NEGERI TEMPURAN 01 ', 'SD', 'Negeri', 6, '20320321', 2, ' Tempuran ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(199, '20320320', ' SD NEGERI TEMPURAN 02 ', 'SD', 'Negeri', 6, '20320320', 2, ' Jl. Senjoyo No. 01 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(200, '20320331', ' SD NEGERI TRUKO 01 ', 'SD', 'Negeri', 6, '20320331', 2, ' Truko ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(201, '20320330', ' SD NEGERI TRUKO 02 ', 'SD', 'Negeri', 6, '20320330', 2, ' Truko ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(202, '20320417', ' SD NEGERI WIRU 01 ', 'SD', 'Negeri', 6, '20320417', 2, ' Wiru ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(203, '20320415', ' SD NEGERI WIRU 03 ', 'SD', 'Negeri', 6, '20320415', 2, ' Kedunglaran RT 02 RW 06 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(204, '20320311', ' SMP NEGERI 1 BRINGIN ', 'SMP', 'Negeri', 6, '20320311', 2, ' Jl. Raya Bringin Km. 04 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(205, '20320270', ' SMP NEGERI 2 BRINGIN ', 'SMP', 'Negeri', 6, '20320270', 2, ' Pakis ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(206, '20331725', ' SMP NEGERI 3 BRINGIN ', 'SMP', 'Negeri', 6, '20331725', 2, ' Jl. Raya Bringin-kalikurma Km.05, Bringin ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(207, '20320214', ' SMP ISLAM SUDIRMAN 1 BRINGIN ', 'SMP', 'Swasta', 6, '20320214', 2, ' Jl. Diponegoro No.20 Bringin ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(208, '20320774', ' SD NEGERI BATUR 01 ', 'SD', 'Negeri', 14, '20320774', 2, ' Gondang ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(209, '20320772', ' SD NEGERI BATUR 03 ', 'SD', 'Negeri', 14, '20320772', 2, ' SELONGISOR ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(210, '20320771', ' SD NEGERI BATUR 04 ', 'SD', 'Negeri', 14, '20320771', 2, ' Krangkeng ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(211, '20320669', ' SD NEGERI GETASAN ', 'SD', 'Negeri', 14, '20320669', 2, ' Getasan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(212, '20320655', ' SD NEGERI JETAK 01 ', 'SD', 'Negeri', 14, '20320655', 2, ' Setugur ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(213, '20320696', ' SD NEGERI JETAK 03 ', 'SD', 'Negeri', 14, '20320696', 2, ' Tosoro ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(214, '20320086', ' SD NEGERI KOPENG 01 ', 'SD', 'Negeri', 14, '20320086', 2, ' Plalar ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(215, '20320097', ' SD NEGERI KOPENG 02 ', 'SD', 'Negeri', 14, '20320097', 2, ' Blancir ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(216, '20320098', ' SD NEGERI KOPENG 03 ', 'SD', 'Negeri', 14, '20320098', 2, ' Kopeng Getasan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(217, '20320176', ' SD NEGERI MANGGIHAN ', 'SD', 'Negeri', 14, '20320176', 2, ' Manggihan Rt 01/01 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(218, '20320166', ' SD NEGERI NGRAWAN 02 ', 'SD', 'Negeri', 14, '20320166', 2, ' Tegalsari ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(219, '20320165', ' SD NEGERI NOGOSAREN ', 'SD', 'Negeri', 14, '20320165', 2, ' Nogosaren ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(220, '20319958', ' SD NEGERI POLOBOGO 01 ', 'SD', 'Negeri', 14, '20319958', 2, ' Polobogo ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(221, '20319957', ' SD NEGERI POLOBOGO 02 ', 'SD', 'Negeri', 14, '20319957', 2, ' Kebonpete ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(222, '20319968', ' SD NEGERI POLOBOGO 03 ', 'SD', 'Negeri', 14, '20319968', 2, ' Clowok ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(223, '20320074', ' SD NEGERI SAMIRONO ', 'SD', 'Negeri', 14, '20320074', 2, ' Pongangan,samirono, Getasan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(224, '20320352', ' SD NEGERI SUMOGAWE 01 ', 'SD', 'Negeri', 14, '20320352', 2, ' Jl. Pangeran Diponegoro Km.1 Sumogawe ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(225, '20320351', ' SD NEGERI SUMOGAWE 02 ', 'SD', 'Negeri', 14, '20320351', 2, ' Sumogawe ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(226, '20320350', ' SD NEGERI SUMOGAWE 03 ', 'SD', 'Negeri', 14, '20320350', 2, ' Bumiayu ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(227, '20320349', ' SD NEGERI SUMOGAWE 04 ', 'SD', 'Negeri', 14, '20320349', 2, ' Dusun Piji RT.10 RW.05 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(228, '20320363', ' SD NEGERI TAJUK ', 'SD', 'Negeri', 14, '20320363', 2, ' DUKUH ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(229, '20320335', ' SD NEGERI TOLOKAN ', 'SD', 'Negeri', 14, '20320335', 2, ' Tolokan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(230, '20320397', ' SD NEGERI WATES 01 ', 'SD', 'Negeri', 14, '20320397', 2, ' Jl.Pangeran Dipnegoro Km.12 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(231, '20320408', ' SD NEGERI WATES 02 ', 'SD', 'Negeri', 14, '20320408', 2, ' Wates ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(232, '20331134', ' SD IT IZZATUL ISLAM GETASAN ', 'SD', 'Swasta', 14, '20331134', 2, ' PONGANGAN ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(233, '20320787', ' SD KRISTEN KARMEL 01 ', 'SD', 'Swasta', 14, '20320787', 2, ' Ngaduman ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(234, '20320786', ' SD KRISTEN KARMEL II ', 'SD', 'Swasta', 14, '20320786', 2, ' Batur ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(235, '20349045', ' SDIST AT-TAQWA GETASAN ', 'SD', 'Swasta', 14, '20349045', 2, ' Jl. Salatiga - Kopeng Km. 05 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(236, '20320310', ' SMP NEGERI 1 GETASAN ', 'SMP', 'Negeri', 14, '20320310', 2, ' Jampelan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(237, '20320269', ' SMP NEGERI 2 GETASAN ', 'SMP', 'Negeri', 14, '20320269', 2, ' Setugur ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(238, '20320282', ' SMP NEGERI 3 GETASAN ', 'SMP', 'Negeri', 14, '20320282', 2, ' Jl. Kalipancur ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(239, '69895572', ' SMP IT IZZATUL ISLAM GETASAN ', 'SMP', 'Swasta', 14, '69895572', 2, ' Pongangan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(240, '20320229', ' SMP KRISTEN GETASAN ', 'SMP', 'Swasta', 14, '20320229', 2, ' Jl. Pangeran Diponegoro. Km. 9 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(241, '20320765', ' SD NEGERI BEDONO 02 ', 'SD', 'Negeri', 18, '20320765', 2, ' Jl. Sukresna 9 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(242, '20320764', ' SD NEGERI BEDONO 03 ', 'SD', 'Negeri', 18, '20320764', 2, ' Dsn Jurang ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(243, '20320853', ' SD NEGERI BRONGKOL 01 ', 'SD', 'Negeri', 18, '20320853', 2, ' Krajan Rt 04/02 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(244, '20320852', ' SD NEGERI BRONGKOL 02 ', 'SD', 'Negeri', 18, '20320852', 2, ' Gertas ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(245, '20320850', ' SD NEGERI BRONGKOL 04 ', 'SD', 'Negeri', 18, '20320850', 2, ' Tabaggunung ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(246, '20320693', ' SD NEGERI GEMAWANG 02 ', 'SD', 'Negeri', 18, '20320693', 2, ' Dsn Guyangwarak ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(247, '20320688', ' SD NEGERI GENTING 01 ', 'SD', 'Negeri', 18, '20320688', 2, ' Genting ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(248, '20320687', ' SD NEGERI GENTING 02 ', 'SD', 'Negeri', 18, '20320687', 2, ' Genting ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(249, '20320686', ' SD NEGERI GENTING 03 ', 'SD', 'Negeri', 18, '20320686', 2, ' Genting ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(250, '20320647', ' SD NEGERI GONDORIYO ', 'SD', 'Negeri', 18, '20320647', 2, ' Jl. Raya Ambarawa - Magelang Km 3,4 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(251, '20320665', ' SD NEGERI ISDIMAN ', 'SD', 'Negeri', 18, '20320665', 2, ' Jl.raya Ambarawa Magelang Km.7,3 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(252, '20320664', ' SD NEGERI JAMBU 01 ', 'SD', 'Negeri', 18, '20320664', 2, ' Jambu ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(253, '20320663', ' SD NEGERI JAMBU 02 ', 'SD', 'Negeri', 18, '20320663', 2, ' Klepon Rt 01 Rw 05 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(254, '20320148', ' SD NEGERI KEBONDALEM 01 ', 'SD', 'Negeri', 18, '20320148', 2, ' Kebondalem ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(255, '20320134', ' SD NEGERI KEBONDALEM 02 ', 'SD', 'Negeri', 18, '20320134', 2, ' Kebondalem ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(256, '20320188', ' SD NEGERI KUWARASAN 01 ', 'SD', 'Negeri', 18, '20320188', 2, ' Kuwarasan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(257, '20320187', ' SD NEGERI KUWARASAN 02 ', 'SD', 'Negeri', 18, '20320187', 2, ' KALISARI ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(258, '20320066', ' SD NEGERI REJOSARI ', 'SD', 'Negeri', 18, '20320066', 2, ' Dusun Kebonlegi Rt.003 Rw.001 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(259, '20320495', ' SD KANISIUS BEDONO ', 'SD', 'Swasta', 18, '20320495', 2, ' Wawar Lor ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(260, '20320309', ' SMP NEGERI 1 JAMBU ', 'SMP', 'Negeri', 18, '20320309', 2, ' Dusun Ngasemsari ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(261, '20320268', ' SMP NEGERI 2 JAMBU ', 'SMP', 'Negeri', 18, '20320268', 2, ' Jl.Durian 112 Genting ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(262, '20320224', ' SMP MUHAMMADIYAH JAMBU ', 'SMP', 'Swasta', 18, '20320224', 2, ' Jambu ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(263, '20320293', ' SMP THERESIANA JAMBU ', 'SMP', 'Swasta', 18, '20320293', 2, ' Krajan RT. 09 RW. 01 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(264, '20320749', ' SD NEGERI JETIS 01 ', 'SD', 'Negeri', 12, '20320749', 2, ' Kaliwungu Kab.semarang Jateng ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(265, '20320733', ' SD NEGERI JETIS 02 ', 'SD', 'Negeri', 12, '20320733', 2, ' Brungkah ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(266, '20320732', ' SD NEGERI JETIS 03 ', 'SD', 'Negeri', 12, '20320732', 2, ' Dusun Gumuk ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(267, '20320739', ' SD NEGERI KALIWUNGU 01 ', 'SD', 'Negeri', 12, '20320739', 2, ' Kaliwungu ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(268, '20320738', ' SD NEGERI KALIWUNGU 02 ', 'SD', 'Negeri', 12, '20320738', 2, ' Kaliwungu ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(269, '20320724', ' SD NEGERI KALIWUNGU 03 ', 'SD', 'Negeri', 12, '20320724', 2, ' Kaliwungu ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(270, '20320723', ' SD NEGERI KALIWUNGU 04 ', 'SD', 'Negeri', 12, '20320723', 2, ' Dusun Kalisat ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(271, '20320722', ' SD NEGERI KALIWUNGU 05 ', 'SD', 'Negeri', 12, '20320722', 2, ' Ngemplak ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(272, '20320141', ' SD NEGERI KENER ', 'SD', 'Negeri', 12, '20320141', 2, ' KENER ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(273, '20320105', ' SD NEGERI KRADENAN 01 ', 'SD', 'Negeri', 12, '20320105', 2, ' Kradenan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(274, '20320104', ' SD NEGERI KRADENAN 02 ', 'SD', 'Negeri', 12, '20320104', 2, ' Kedesen ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(275, '20320156', ' SD NEGERI MUKIRAN 03 ', 'SD', 'Negeri', 12, '20320156', 2, ' Mukiran ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(276, '20320155', ' SD NEGERI MUKIRAN 04 ', 'SD', 'Negeri', 12, '20320155', 2, ' Mukiran ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(277, '20320010', ' SD NEGERI PAGER ', 'SD', 'Negeri', 12, '20320010', 2, ' Pager ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(278, '20320027', ' SD NEGERI PAPRINGAN 02 ', 'SD', 'Negeri', 12, '20320027', 2, ' Kadirojo ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(279, '20320026', ' SD NEGERI PAPRINGAN 03 ', 'SD', 'Negeri', 12, '20320026', 2, ' Papringan, RT : 07, RW : 02 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(280, '20320025', ' SD NEGERI PAPRINGAN 04 ', 'SD', 'Negeri', 12, '20320025', 2, ' Dsn.pacean, Ds.papringan, Kec.kaliwungu ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(281, '20320019', ' SD NEGERI PAYUNGAN ', 'SD', 'Negeri', 12, '20320019', 2, ' Payungan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(282, '20320083', ' SD NEGERI ROGOMULYO 01 ', 'SD', 'Negeri', 12, '20320083', 2, ' Rogomulyo ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(283, '20320082', ' SD NEGERI ROGOMULYO 02 ', 'SD', 'Negeri', 12, '20320082', 2, ' Rogomulyo ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(284, '20320045', ' SD NEGERI SIWAL 01 ', 'SD', 'Negeri', 12, '20320045', 2, ' Siwal ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(285, '20320056', ' SD NEGERI SIWAL 02 ', 'SD', 'Negeri', 12, '20320056', 2, ' Siwal ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(286, '20320407', ' SD NEGERI UDANUWUH 02 ', 'SD', 'Negeri', 12, '20320407', 2, ' Ds Gumukrejo ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(287, '20353950', ' SD IT QURAN INSAN MULIA ', 'SD', 'Swasta', 12, '20353950', 2, ' Dsn. Kebatan, Ds. Kradenan, Kec.kaliwungu ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(288, '20320308', ' SMP NEGERI 1 KALIWUNGU ', 'SMP', 'Negeri', 12, '20320308', 2, ' Ds.kaliwungu ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(289, '20320267', ' SMP NEGERI 2 KALIWUNGU ', 'SMP', 'Negeri', 12, '20320267', 2, ' Jl. Boyolali Simo Km 07 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(290, '20320217', ' SMP KERABAT ', 'SMP', 'Swasta', 12, '20320217', 2, ' DUSUN MUKIRAN I ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(291, '20320842', ' SD NEGERI BENDUNGAN ', 'SD', 'Negeri', 8, '20320842', 2, ' Bendungan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(292, '20320667', ' SD NEGERI GILING ', 'SD', 'Negeri', 8, '20320667', 2, ' Jl. Koptu Suparjan Macanan Semowo KM 2 Desa Giling RT 03 RW 01 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(293, '20320652', ' SD NEGERI GLAWAN ', 'SD', 'Negeri', 8, '20320652', 2, ' Glawan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(294, '20320656', ' SD NEGERI JEMBRAK ', 'SD', 'Negeri', 8, '20320656', 2, ' Jembrak ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(295, '20320725', ' SD NEGERI KADIREJO 02 ', 'SD', 'Negeri', 8, '20320725', 2, ' Dusun Bungas RT 13 RW 05 Kadirejo ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(296, '20320736', ' SD NEGERI KADIREJO 03 ', 'SD', 'Negeri', 8, '20320736', 2, ' Gelangan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(297, '20320700', ' SD NEGERI KARANGGONDANG ', 'SD', 'Negeri', 8, '20320700', 2, ' Karanggondang ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(298, '20320715', ' SD NEGERI KAUMAN LOR 01 ', 'SD', 'Negeri', 8, '20320715', 2, ' Dusun Getas RT. 04 / RW. II ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(299, '20320714', ' SD NEGERI KAUMAN LOR 03 ', 'SD', 'Negeri', 8, '20320714', 2, ' Getas Rt.09 Rw.02 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(300, '20320014', ' SD NEGERI PABELAN ', 'SD', 'Negeri', 8, '20320014', 2, ' Pabelan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(301, '20320011', ' SD NEGERI PADAAN 02 ', 'SD', 'Negeri', 8, '20320011', 2, ' Ngasinan Rt03 Rw03 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(302, '20320073', ' SD NEGERI SEGIRI 01 ', 'SD', 'Negeri', 8, '20320073', 2, ' Segiri ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(303, '20320059', ' SD NEGERI SEGIRI 02 ', 'SD', 'Negeri', 8, '20320059', 2, ' Segiri Rt.10/03 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(304, '20320058', ' SD NEGERI SEMOWO ', 'SD', 'Negeri', 8, '20320058', 2, ' Semowo, RT 01 RW 01 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(305, '20320046', ' SD NEGERI SUKOHARJO ', 'SD', 'Negeri', 8, '20320046', 2, ' Susukan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(306, '20320367', ' SD NEGERI SUMBEREJO 01 ', 'SD', 'Negeri', 8, '20320367', 2, ' Dsn. Krajan Kidul RT: 3 RW: 5 Ds.Sumberejo ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(307, '20320353', ' SD NEGERI SUMBEREJO 02 ', 'SD', 'Negeri', 8, '20320353', 2, ' Sumberejo, Ngasinan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(308, '20320315', ' SD NEGERI TERBAN ', 'SD', 'Negeri', 8, '20320315', 2, ' Terban Jln. Kaligandu ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(309, '20320328', ' SD NEGERI TUKANG ', 'SD', 'Negeri', 8, '20320328', 2, ' Dusun Sindon ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(310, '20320406', ' SD NEGERI UJUNG-UJUNG 01 ', 'SD', 'Negeri', 8, '20320406', 2, ' Ujung-ujung RT 02 RW 01 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(311, '20320404', ' SD NEGERI UJUNG-UJUNG 03 ', 'SD', 'Negeri', 8, '20320404', 2, ' Mukus, Rt.01/03 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(312, '20320307', ' SMP NEGERI 1 PABELAN ', 'SMP', 'Negeri', 8, '20320307', 2, ' Jl.raya Salatiga-bringin Km.08 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(313, '20320266', ' SMP NEGERI 2 PABELAN ', 'SMP', 'Negeri', 8, '20320266', 2, ' Jembrak ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(314, '20320281', ' SMP NEGERI 3 PABELAN ', 'SMP', 'Negeri', 8, '20320281', 2, ' DESA TUKANG ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(315, '20320811', ' SD NEGERI CANDIREJO 01 ', 'SD', 'Negeri', 4, '20320811', 2, ' CANDIREJO RT 5 RW 2 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(316, '20320808', ' SD NEGERI CANDIREJO 02 ', 'SD', 'Negeri', 4, '20320808', 2, ' Candirejo ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(317, '20320807', ' SD NEGERI CANDIREJO 03 ', 'SD', 'Negeri', 4, '20320807', 2, ' Banger ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(318, '20320822', ' SD NEGERI DEREKAN ', 'SD', 'Negeri', 4, '20320822', 2, ' Derekan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(319, '20331138', ' SD NEGERI JATIRUNGGO 01 ', 'SD', 'Negeri', 4, '20331138', 2, ' JATIRUNGGO ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(320, '20320658', ' SD NEGERI JATIRUNGGO 02 ', 'SD', 'Negeri', 4, '20320658', 2, ' Kunci Putih ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(321, '20320657', ' SD NEGERI JATIRUNGGO 03 ', 'SD', 'Negeri', 4, '20320657', 2, ' Jatisari ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(322, '20340387', ' SD NEGERI KLEPU 01 ', 'SD', 'Negeri', 4, '20340387', 2, ' Krajan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sekolah` (`id_sekolah`, `npsn`, `nama_sekolah`, `jenjang`, `status`, `kecamatan`, `password`, `role`, `alamat`, `telepon`, `foto`, `nama_kepsek`, `nip_kepsek`, `nama_bendahara`, `nip_bendahara`, `created_at`, `updated_at`, `deleted_at`) VALUES
(323, '20340389', ' SD NEGERI KLEPU 02 ', 'SD', 'Negeri', 4, '20340389', 2, ' Jl.Klepu Raya Km 1,5 RT 2, RW 1 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(324, '20320092', ' SD NEGERI KLEPU 03 ', 'SD', 'Negeri', 4, '20320092', 2, ' Bodean RT 04/ RW 03, Desa Klepu ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(325, '20320091', ' SD NEGERI KLEPU 04 ', 'SD', 'Negeri', 4, '20320091', 2, ' Jl. Wisanggeni No.46 Kemasan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(326, '20320090', ' SD NEGERI KLEPU 05 ', 'SD', 'Negeri', 4, '20320090', 2, ' Jalan Antasena No.24 Kaliulo ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(327, '20319983', ' SD NEGERI PENAWANGAN 01 ', 'SD', 'Negeri', 4, '20319983', 2, ' PENAWANGAN RT. 07 RW. 02 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(328, '20319982', ' SD NEGERI PENAWANGAN 02 ', 'SD', 'Negeri', 4, '20319982', 2, ' Secang RT 03, RW 01 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(329, '20319979', ' SD NEGERI PRINGAPUS 01 ', 'SD', 'Negeri', 4, '20319979', 2, ' Jl Supriadi No 11 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(330, '20319978', ' SD NEGERI PRINGAPUS 02 ', 'SD', 'Negeri', 4, '20319978', 2, ' Jl Syeh Basyarudin ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(331, '20319977', ' SD NEGERI PRINGAPUS 03 ', 'SD', 'Negeri', 4, '20319977', 2, ' Jalan Supriyadi, No.20 Pringapus ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(332, '20319976', ' SD NEGERI PRINGAPUS 04 ', 'SD', 'Negeri', 4, '20319976', 2, ' Dk Kalikidang ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(333, '20319975', ' SD NEGERI PRINGSARI 01 ', 'SD', 'Negeri', 4, '20319975', 2, ' Kertosari ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(334, '20319974', ' SD NEGERI PRINGSARI 02 ', 'SD', 'Negeri', 4, '20319974', 2, ' Pringsari ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(335, '20331142', ' SD NEGERI WONOREJO 01 ', 'SD', 'Negeri', 4, '20331142', 2, ' Krajan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(336, '20320413', ' SD NEGERI WONOREJO 02 ', 'SD', 'Negeri', 4, '20320413', 2, ' Dsn Mranak ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(337, '20331143', ' SD NEGERI WONOREJO 03 ', 'SD', 'Negeri', 4, '20331143', 2, ' Sambiroto ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(338, '20320412', ' SD NEGERI WONOREJO 04 ', 'SD', 'Negeri', 4, '20320412', 2, ' RT 01 - RW 01 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(339, '20320411', ' SD NEGERI WONOYOSO ', 'SD', 'Negeri', 4, '20320411', 2, ' Krajan RT. 02 RW. 01 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(340, '20320306', ' SMP NEGERI 1 PRINGAPUS ', 'SMP', 'Negeri', 4, '20320306', 2, ' Jalan Siswa ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(341, '20320265', ' SMP NEGERI 2 PRINGAPUS ', 'SMP', 'Negeri', 4, '20320265', 2, ' JATISARI ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(342, '20341203', ' SMP NEGERI 3 PRINGAPUS SATU ATAP ', 'SMP', 'Negeri', 4, '20341203', 2, ' Penawangan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(343, '20320231', ' SMP ISLAM AL-HIDAYAAT PRINGAPUS ', 'SMP', 'Swasta', 4, '20320231', 2, ' Komplek Pondok Pesantren Al-Hidayaat Duwet RT 01 RW 04 Klepu Kec. Pringapus ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(344, '20320849', ' SD NEGERI BUMEN ', 'SD', 'Negeri', 16, '20320849', 2, ' Jl.Ahmad Yani No. 1 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(345, '20320816', ' SD NEGERI CANDIGARON 01 ', 'SD', 'Negeri', 16, '20320816', 2, ' Bodean ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(346, '20320815', ' SD NEGERI CANDIGARON 02 ', 'SD', 'Negeri', 16, '20320815', 2, ' Candigaron ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(347, '20320814', ' SD NEGERI CANDIGARON 03 ', 'SD', 'Negeri', 16, '20320814', 2, ' Candigaron ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(348, '20340391', ' SD NEGERI CANDIGARON 04 ', 'SD', 'Negeri', 16, '20340391', 2, ' Dusun Semanding ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(349, '20320681', ' SD NEGERI DUREN ', 'SD', 'Negeri', 16, '20320681', 2, ' Desa Duren ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(350, '20320728', ' SD NEGERI JUBELAN 01 ', 'SD', 'Negeri', 16, '20320728', 2, ' Jubelan RT 1 Rw1 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(351, '20320727', ' SD NEGERI JUBELAN 02 ', 'SD', 'Negeri', 16, '20320727', 2, ' Dsn Logung ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(352, '20320711', ' SD NEGERI KEBONAGUNG 01 ', 'SD', 'Negeri', 16, '20320711', 2, ' Rt 01/ Rw 01 Kebonagung ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(353, '20320697', ' SD NEGERI KEBONAGUNG 03 ', 'SD', 'Negeri', 16, '20320697', 2, ' Kebonagung ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(354, '20320145', ' SD NEGERI KEMAWI ', 'SD', 'Negeri', 16, '20320145', 2, ' Jl. Limbangan KM. 03 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(355, '20320143', ' SD NEGERI KEMITIR 01 ', 'SD', 'Negeri', 16, '20320143', 2, ' Kemitir ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(356, '20320142', ' SD NEGERI KEMITIR 02 ', 'SD', 'Negeri', 16, '20320142', 2, ' Kemitir ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(357, '20320113', ' SD NEGERI KESENENG ', 'SD', 'Negeri', 16, '20320113', 2, ' Keseneng ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(358, '20320182', ' SD NEGERI LANJAN 01 ', 'SD', 'Negeri', 16, '20320182', 2, ' Lanjan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(359, '20320181', ' SD NEGERI LANJAN 02 ', 'SD', 'Negeri', 16, '20320181', 2, ' Lanjan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(360, '20320177', ' SD NEGERI LOSARI ', 'SD', 'Negeri', 16, '20320177', 2, ' Losari ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(361, '20320161', ' SD NEGERI MEDONGAN ', 'SD', 'Negeri', 16, '20320161', 2, ' Mendongan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(362, '20320151', ' SD NEGERI NGADIKERSO 01 ', 'SD', 'Negeri', 16, '20320151', 2, ' Ngadikerso ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(363, '20320162', ' SD NEGERI NGADIKERSO 02 ', 'SD', 'Negeri', 16, '20320162', 2, ' Ngadirekso ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(364, '20319967', ' SD NEGERI PIYANGGANG 01 ', 'SD', 'Negeri', 16, '20319967', 2, ' Jl. Goa Paleburgongso No.2 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(365, '20319966', ' SD NEGERI PIYANGGANG 02 ', 'SD', 'Negeri', 16, '20319966', 2, ' Piyanggang ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(366, '20319965', ' SD NEGERI PLEDOKAN ', 'SD', 'Negeri', 16, '20319965', 2, ' PLEDOKAN ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(367, '20320347', ' SD NEGERI SUMOWONO ', 'SD', 'Negeri', 16, '20320347', 2, ' Jl.h Anwar No 39 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(368, '20320332', ' SD NEGERI TRAYU ', 'SD', 'Negeri', 16, '20320332', 2, ' Jl. Cempaka No.2 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(369, '20320305', ' SMP NEGERI 1 SUMOWONO ', 'SMP', 'Negeri', 16, '20320305', 2, ' Jl.palagan No 25 Sumowono ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(370, '20320264', ' SMP NEGERI 2 SUMOWONO ', 'SMP', 'Negeri', 16, '20320264', 2, ' Desa Candigaron ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(371, '20320209', ' SMP ISLAM SUDIRMAN SUMOWONO ', 'SMP', 'Swasta', 16, '20320209', 2, ' Jl. Sukorini 30 Sumowono ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(372, '20320292', ' SMP THERESIANA SUMOWONO ', 'SMP', 'Swasta', 16, '20320292', 2, ' Jl. Pahlawan No. 18 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(373, '20320844', ' SD NEGERI BEJILOR 01 ', 'SD', 'Negeri', 10, '20320844', 2, ' BEJILOR ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(374, '20320843', ' SD NEGERI BEJILOR 02 ', 'SD', 'Negeri', 10, '20320843', 2, ' Bejilor ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(375, '20320834', ' SD NEGERI BONOMERTO 02 ', 'SD', 'Negeri', 10, '20320834', 2, ' GEDONG RT 02/RW 05 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(376, '20320819', ' SD NEGERI CUKILAN 01 ', 'SD', 'Negeri', 10, '20320819', 2, ' Krajan Cukilan Suruh ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(377, '20320829', ' SD NEGERI CUKILAN 03 ', 'SD', 'Negeri', 10, '20320829', 2, ' Cukilan RT : 32/07 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(378, '20320828', ' SD NEGERI DADAPAYAM 01 ', 'SD', 'Negeri', 10, '20320828', 2, ' Krajan Rt 01 Rw 01 Dadapayam Suruh ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(379, '20320827', ' SD NEGERI DADAPAYAM 02 ', 'SD', 'Negeri', 10, '20320827', 2, ' Dadapayam ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(380, '20320826', ' SD NEGERI DADAPAYAM 03 ', 'SD', 'Negeri', 10, '20320826', 2, ' Jangglengan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(381, '20320821', ' SD NEGERI DERSANSARI 01 ', 'SD', 'Negeri', 10, '20320821', 2, ' Kalegen RT03/RW01 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(382, '20320820', ' SD NEGERI DERSANSARI 02 ', 'SD', 'Negeri', 10, '20320820', 2, ' Dersansari ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(383, '20320643', ' SD NEGERI GUNUNGTUMPENG 01 ', 'SD', 'Negeri', 10, '20320643', 2, ' Gunung Tumpeng ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(384, '20320642', ' SD NEGERI GUNUNGTUMPENG 02 ', 'SD', 'Negeri', 10, '20320642', 2, ' Krajan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(385, '20320659', ' SD NEGERI JATIREJO ', 'SD', 'Negeri', 10, '20320659', 2, ' Jatirejo ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(386, '20320130', ' SD NEGERI KEBOWAN 01 ', 'SD', 'Negeri', 10, '20320130', 2, ' Dusun Kebowan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(387, '20320119', ' SD NEGERI KEBOWAN 02 ', 'SD', 'Negeri', 10, '20320119', 2, ' Kebowan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(388, '20320115', ' SD NEGERI KEDUNGRINGIN 01 ', 'SD', 'Negeri', 10, '20320115', 2, ' Kedungringin ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(389, '20320114', ' SD NEGERI KEDUNGRINGIN 02 ', 'SD', 'Negeri', 10, '20320114', 2, ' Lestri ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(390, '20320135', ' SD NEGERI KEDUNGRINGIN 03 ', 'SD', 'Negeri', 10, '20320135', 2, ' BOROKIDUL ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(391, '20320136', ' SD NEGERI KEDUNGRINGIN 04 ', 'SD', 'Negeri', 10, '20320136', 2, ' Krisik ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(392, '20320095', ' SD NEGERI KETANGGI 01 ', 'SD', 'Negeri', 10, '20320095', 2, ' KRAJAN RT.04/RW.01 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(393, '20320103', ' SD NEGERI KRANDON LOR 01 ', 'SD', 'Negeri', 10, '20320103', 2, ' Jengglong ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(394, '20320102', ' SD NEGERI KRANDON LOR 02 ', 'SD', 'Negeri', 10, '20320102', 2, ' Krandonlor ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(395, '20320101', ' SD NEGERI KRANDON LOR 03 ', 'SD', 'Negeri', 10, '20320101', 2, ' Pringapus ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(396, '20320175', ' SD NEGERI MEDAYU 01 ', 'SD', 'Negeri', 10, '20320175', 2, ' Medayu ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(397, '20319964', ' SD NEGERI PLUMBON 01 ', 'SD', 'Negeri', 10, '20319964', 2, ' Plumbon ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(398, '20319963', ' SD NEGERI PLUMBON 02 ', 'SD', 'Negeri', 10, '20319963', 2, ' Jln. Raya Suruh Salatiga KM 3 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(399, '20319961', ' SD NEGERI PLUMBON 04 ', 'SD', 'Negeri', 10, '20319961', 2, ' Plumbon ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(400, '20319971', ' SD NEGERI PURWOREJO ', 'SD', 'Negeri', 10, '20319971', 2, ' SARADAN Rt.03/RW.01 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(401, '20320062', ' SD NEGERI REKSOSARI 01 ', 'SD', 'Negeri', 10, '20320062', 2, ' Dusun Kepundung Desa Reksosari ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(402, '20320061', ' SD NEGERI REKSOSARI 02 ', 'SD', 'Negeri', 10, '20320061', 2, ' Banjarsari ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(403, '20320060', ' SD NEGERI REKSOSARI 03 ', 'SD', 'Negeri', 10, '20320060', 2, ' Jln.suruh Karanggede Km 03 Dusun Karangsalam ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(404, '20320203', ' SD NEGERI SUKOREJO ', 'SD', 'Negeri', 10, '20320203', 2, ' Sukorejo ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(405, '20320346', ' SD NEGERI SURUH 01 ', 'SD', 'Negeri', 10, '20320346', 2, ' Jl Suruh Salatiga ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(406, '20320344', ' SD NEGERI SURUH 02 ', 'SD', 'Negeri', 10, '20320344', 2, ' Krajan Rt.02 Rw.05 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(407, '20320343', ' SD NEGERI SURUH 03 ', 'SD', 'Negeri', 10, '20320343', 2, ' Mesu RT 01/07 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(408, '20341208', ' SD ISLAM AR RAHMAH ', 'SD', 'Swasta', 10, '20341208', 2, ' Jl suruh-Dadapayam km 0,5 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(409, '20320782', ' SD MUHAMMADIYAH SURUH ', 'SD', 'Swasta', 10, '20320782', 2, ' Suruh ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(410, '69971083', ' SDIT INSAN KAMIL SURUH ', 'SD', 'Swasta', 10, '69971083', 2, ' Jl. Jatirejo-Suruh, Dsn. Pandean ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(411, '20320304', ' SMP NEGERI 1 SURUH ', 'SMP', 'Negeri', 10, '20320304', 2, ' Jl. Dadapayam-Suruh ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(412, '20320263', ' SMP NEGERI 2 SURUH ', 'SMP', 'Negeri', 10, '20320263', 2, ' Jl. Salatiga-Dadapayam Km. 11 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(413, '20320280', ' SMP NEGERI 3 SURUH ', 'SMP', 'Negeri', 10, '20320280', 2, ' Jl. Suruh-gunungtumpeng Km. 05 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(414, '20320232', ' SMP AL ISLAM SURUH ', 'SMP', 'Swasta', 10, '20320232', 2, ' Jl Suruh Karanggede Km 04 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(415, '69956648', ' SMP ISLAM AR-RAHMAH SURUH ', 'SMP', 'Swasta', 10, '69956648', 2, ' Jl. Wetanjaro ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(416, '20320208', ' SMP ISLAM SUDIRMAN SURUH ', 'SMP', 'Swasta', 10, '20320208', 2, ' Jl Dadapayam-Salatiga KM 01 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(417, '20320221', ' SMP MUHAMMADIYAH SURUH ', 'SMP', 'Swasta', 10, '20320221', 2, ' Jl. Raya Suruh Salatiga No.130 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(418, '20320219', ' SMP NU SURUH ', 'SMP', 'Swasta', 10, '20320219', 2, ' Jl Karanggede Km2 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(419, '20320801', ' SD NEGERI BADRAN ', 'SD', 'Negeri', 11, '20320801', 2, ' Ngunggen ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(420, '20320800', ' SD NEGERI BAKALREJO 01 ', 'SD', 'Negeri', 11, '20320800', 2, ' Karangsari ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(421, '20320799', ' SD NEGERI BAKALREJO 02 ', 'SD', 'Negeri', 11, '20320799', 2, ' Dolog Bakalrejo Susukan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(422, '20320692', ' SD NEGERI GENTAN 01 ', 'SD', 'Negeri', 11, '20320692', 2, ' Galangan Rt.04 Rw.05 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(423, '20320691', ' SD NEGERI GENTAN 02 ', 'SD', 'Negeri', 11, '20320691', 2, ' Dusun Kebonjeruk ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(424, '20320690', ' SD NEGERI GENTAN 03 ', 'SD', 'Negeri', 11, '20320690', 2, ' Dsn Kebon Jeruk ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(425, '20320689', ' SD NEGERI GENTAN 04 ', 'SD', 'Negeri', 11, '20320689', 2, ' Gentan Susukan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(426, '20320144', ' SD NEGERI KEMETUL ', 'SD', 'Negeri', 11, '20320144', 2, ' Sipenggung ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(427, '20320140', ' SD NEGERI KENTENG 01 ', 'SD', 'Negeri', 11, '20320140', 2, ' Kenteng ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(428, '20320137', ' SD NEGERI KENTENG 02 ', 'SD', 'Negeri', 11, '20320137', 2, ' Susukan Kab. Semarang Jateng ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(429, '20320094', ' SD NEGERI KETAPANG 01 ', 'SD', 'Negeri', 11, '20320094', 2, ' Baran ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(430, '20320093', ' SD NEGERI KETAPANG 03 ', 'SD', 'Negeri', 11, '20320093', 2, ' Ketapang ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(431, '20320109', ' SD NEGERI KORIPAN 01 ', 'SD', 'Negeri', 11, '20320109', 2, ' Jln. Soebowo Soepangat km 07 Dsn. Semagu ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(432, '20320108', ' SD NEGERI KORIPAN 02 ', 'SD', 'Negeri', 11, '20320108', 2, ' Plaur ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(433, '20320106', ' SD NEGERI KORIPAN 04 ', 'SD', 'Negeri', 11, '20320106', 2, ' Dusun Krandon ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(434, '20320154', ' SD NEGERI MUNCAR 01 ', 'SD', 'Negeri', 11, '20320154', 2, ' Dsn.Jaten ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(435, '20320153', ' SD NEGERI MUNCAR 02 ', 'SD', 'Negeri', 11, '20320153', 2, ' Dsn. Muncar Rt.01 Rw.03 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(436, '20320170', ' SD NEGERI NGASINAN ', 'SD', 'Negeri', 11, '20320170', 2, ' Ngasinan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(437, '20320039', ' SD NEGERI SIDOHARJO ', 'SD', 'Negeri', 11, '20320039', 2, ' Sidoharjo, Rt 01 RW 01 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(438, '20320354', ' SD NEGERI SUSUKAN 01 ', 'SD', 'Negeri', 11, '20320354', 2, ' Jl. Imam Puro km 7 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(439, '20320355', ' SD NEGERI SUSUKAN 02 ', 'SD', 'Negeri', 11, '20320355', 2, ' Jl. KH.Umar Imam Puro Km.07 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(440, '20320358', ' SD NEGERI TAWANG 01 ', 'SD', 'Negeri', 11, '20320358', 2, ' Dsn Tawang 4 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(441, '20320356', ' SD NEGERI TAWANG 03 ', 'SD', 'Negeri', 11, '20320356', 2, ' Dsn Tawang 2 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(442, '20320314', ' SD NEGERI TIMPIK 01 ', 'SD', 'Negeri', 11, '20320314', 2, ' Dsn. Bogo, Ds. Timpik RT 01/RW 15 Kec. Susukan, Kab. Semarang 50777 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(443, '20320325', ' SD NEGERI TIMPIK 02 ', 'SD', 'Negeri', 11, '20320325', 2, ' Dsn Kauman Desa Timpik Kec.Susukan Kab.Semarang ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(444, '20320326', ' SD NEGERI TIMPIK 04 ', 'SD', 'Negeri', 11, '20320326', 2, ' Ngasinan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(445, '20320303', ' SMP NEGERI 1 SUSUKAN ', 'SMP', 'Negeri', 11, '20320303', 2, ' Susukan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(446, '20320262', ' SMP NEGERI 2 SUSUKAN ', 'SMP', 'Negeri', 11, '20320262', 2, ' Ds. Koripan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(447, '20320215', ' SMP ISLAM BINA INSANI ', 'SMP', 'Swasta', 11, '20320215', 2, ' Ketapang ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(448, '20320207', ' SMP ISLAM SUDIRMAN SUSUKAN ', 'SMP', 'Swasta', 11, '20320207', 2, ' Jl Suruh Karanggede Km 04 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(449, '20320220', ' SMP MUHAMMADIYAH SUSUKAN ', 'SMP', 'Swasta', 11, '20320220', 2, ' Susukan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(450, '20320762', ' SD NEGERI BARUKAN 01 ', 'SD', 'Negeri', 13, '20320762', 2, ' Barukan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(451, '20320763', ' SD NEGERI BARUKAN 02 ', 'SD', 'Negeri', 13, '20320763', 2, ' Barukan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(452, '20320841', ' SD NEGERI BENER 01 ', 'SD', 'Negeri', 13, '20320841', 2, ' Jl Soekarno Hatta ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(453, '20320848', ' SD NEGERI BUTUH 01 ', 'SD', 'Negeri', 13, '20320848', 2, ' Banaran Rt16/10 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(454, '20320847', ' SD NEGERI BUTUH 02 ', 'SD', 'Negeri', 13, '20320847', 2, ' Kemloko ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(455, '20320818', ' SD NEGERI CUKIL 01 ', 'SD', 'Negeri', 13, '20320818', 2, ' JL. Peltu Soebowo Soepangat Km. 3 Ds. Cukil Kec. Tengaran 50775 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(456, '20340670', ' SD NEGERI DUREN 01 ', 'SD', 'Negeri', 13, '20340670', 2, ' Duren ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(457, '20320677', ' SD NEGERI DUREN 03 ', 'SD', 'Negeri', 13, '20320677', 2, ' Duren ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(458, '20320709', ' SD NEGERI KARANGDUREN 01 ', 'SD', 'Negeri', 13, '20320709', 2, ' Karang Duren ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(459, '20320710', ' SD NEGERI KARANGDUREN 02 ', 'SD', 'Negeri', 13, '20320710', 2, ' Jl Jomblang No 2 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(460, '20320721', ' SD NEGERI KARANGDUREN 03 ', 'SD', 'Negeri', 13, '20320721', 2, ' Karangduren ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(461, '20320720', ' SD NEGERI KARANGDUREN 04 ', 'SD', 'Negeri', 13, '20320720', 2, ' Prokimad Rt.38 Rw.10 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(462, '20320089', ' SD NEGERI KLERO 01 ', 'SD', 'Negeri', 13, '20320089', 2, ' Klero ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(463, '20320088', ' SD NEGERI KLERO 02 ', 'SD', 'Negeri', 13, '20320088', 2, ' Jln. Salatiga - Solo Km 09 Ds Klero ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(464, '20320087', ' SD NEGERI KLERO 03 ', 'SD', 'Negeri', 13, '20320087', 2, ' Ngentak ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(465, '20320164', ' SD NEGERI NYAMAT ', 'SD', 'Negeri', 13, '20320164', 2, ' Nyamat ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(466, '20320021', ' SD NEGERI PATEMON 01 ', 'SD', 'Negeri', 13, '20320021', 2, ' Patemon ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(467, '20320020', ' SD NEGERI PATEMON 02 ', 'SD', 'Negeri', 13, '20320020', 2, ' Dsn Nalan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(468, '20320068', ' SD NEGERI REGUNUNG 01 ', 'SD', 'Negeri', 13, '20320068', 2, ' Jalan Fastabikhul Khoirot Dusun Gumuk Rejo RT 16 RW 05 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(469, '20320067', ' SD NEGERI REGUNUNG 03 ', 'SD', 'Negeri', 13, '20320067', 2, ' Ngaduman ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(470, '20320053', ' SD NEGERI SRUWEN 01 ', 'SD', 'Negeri', 13, '20320053', 2, ' Sruwen ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(471, '20320052', ' SD NEGERI SRUWEN 02 ', 'SD', 'Negeri', 13, '20320052', 2, ' Jl. Kemetiran No.86 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(472, '20320051', ' SD NEGERI SRUWEN 03 ', 'SD', 'Negeri', 13, '20320051', 2, ' Sruwen ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(473, '20320049', ' SD NEGERI SUGIHAN 01 ', 'SD', 'Negeri', 13, '20320049', 2, ' Sugihan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(474, '20320048', ' SD NEGERI SUGIHAN 03 ', 'SD', 'Negeri', 13, '20320048', 2, ' Gatak RT. 32 RW. 08 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(475, '20320047', ' SD NEGERI SUGIHAN 04 ', 'SD', 'Negeri', 13, '20320047', 2, ' Dukuhan RT 15 RW 03 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(476, '20320341', ' SD NEGERI TEGALREJO 01 ', 'SD', 'Negeri', 13, '20320341', 2, ' RT 05 RW 03 Tegal Rejo ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(477, '20320340', ' SD NEGERI TEGALREJO 02 ', 'SD', 'Negeri', 13, '20320340', 2, ' Tegalrejo ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(478, '20320339', ' SD NEGERI TEGALWATON 01 ', 'SD', 'Negeri', 13, '20320339', 2, ' Tegalwaton ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(479, '20320324', ' SD NEGERI TEGALWATON 03 ', 'SD', 'Negeri', 13, '20320324', 2, ' Tegal Waton ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(480, '20320318', ' SD NEGERI TENGARAN ', 'SD', 'Negeri', 13, '20320318', 2, ' Jl. Masjid Besar No 15b ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(481, '20320497', ' SD ISLAM TERPADU NURUL ISLAM BUTUH ', 'SD', 'Swasta', 13, '20320497', 2, ' Gintungan RT 20 RW 11 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(482, '20320584', ' SDITQ AL IRSYAD ', 'SD', 'Swasta', 13, '20320584', 2, ' Jl. Semarang - Solo Km 45. Ds. Butuh ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(483, '20320302', ' SMP NEGERI 1 TENGARAN ', 'SMP', 'Negeri', 13, '20320302', 2, ' Jl. Masjid Besar Tengaran ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(484, '20320261', ' SMP NEGERI 2 TENGARAN ', 'SMP', 'Negeri', 13, '20320261', 2, ' Jl. Salatiga-Solo Km. 7 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(485, '20320279', ' SMP NEGERI 3 TENGARAN ', 'SMP', 'Negeri', 13, '20320279', 2, ' Tengaran ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(486, '20341204', ' SMP NEGERI 4 TENGARAN SATU ATAP ', 'SMP', 'Negeri', 13, '20341204', 2, ' Miri ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(487, '20320206', ' SMP ISLAM SUDIRMAN TENGARAN ', 'SMP', 'Swasta', 13, '20320206', 2, ' Jl Masjid Besar 39 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(488, '20341207', ' SMPIT NURUL ISLAM TENGARAN ', 'SMP', 'Swasta', 13, '20341207', 2, ' Jl. Semarang - Solo Km 8, Kaligandu RT 11/ RW 03 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(489, '20340671', ' SD NEGERI CANDIREJO ', 'SD', 'Negeri', 7, '20340671', 2, ' Jalan Mertokusumo, No. 32 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(490, '20320825', ' SD NEGERI DELIK 01 ', 'SD', 'Negeri', 7, '20320825', 2, ' Delik ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(491, '20320824', ' SD NEGERI DELIK 02 ', 'SD', 'Negeri', 7, '20320824', 2, ' Delik ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(492, '20320823', ' SD NEGERI DELIK 03 ', 'SD', 'Negeri', 7, '20320823', 2, ' Jln. Tuntang-Bringin Km 2 Kec. Tuntang 50773 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(493, '20320673', ' SD NEGERI GEDANGAN 01 ', 'SD', 'Negeri', 7, '20320673', 2, ' Jl. Raya Salatiga - Muncul Km.4 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(494, '20320729', ' SD NEGERI JOMBOR ', 'SD', 'Negeri', 7, '20320729', 2, ' Jl. Sumbawa No. 2 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(495, '20320737', ' SD NEGERI KALIBEJI 01 ', 'SD', 'Negeri', 7, '20320737', 2, ' Cebur RT 01 RW 02 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(496, '20320701', ' SD NEGERI KARANGANYAR 01 ', 'SD', 'Negeri', 7, '20320701', 2, ' Karanganyar ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(497, '20320698', ' SD NEGERI KARANGTENGAH 01 ', 'SD', 'Negeri', 7, '20320698', 2, ' Karangtengah ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(498, '20320112', ' SD NEGERI KESONGO 01 ', 'SD', 'Negeri', 7, '20320112', 2, ' DSN KRAJAN RT 05 RW 01 DS KESONGO ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(499, '20320096', ' SD NEGERI KESONGO 04 ', 'SD', 'Negeri', 7, '20320096', 2, ' BANJARAN, RT: 02, RW: 07 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(500, '20320192', ' SD NEGERI LOPAIT 01 ', 'SD', 'Negeri', 7, '20320192', 2, ' Gudang ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(501, '20320191', ' SD NEGERI LOPAIT 02 ', 'SD', 'Negeri', 7, '20320191', 2, ' Gudang Lopait ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(502, '20320163', ' SD NEGERI NGAJARAN 01 ', 'SD', 'Negeri', 7, '20320163', 2, ' Ngajaran, RT 4/RW 5, Petet, Ngajaran, Tuntang, Kab. Semarang ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(503, '20320174', ' SD NEGERI NGAJARAN 02 ', 'SD', 'Negeri', 7, '20320174', 2, ' Ngajaran ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(504, '20320173', ' SD NEGERI NGAJARAN 03 ', 'SD', 'Negeri', 7, '20320173', 2, ' NGAJARAN ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(505, '20320079', ' SD NEGERI ROWOSARI ', 'SD', 'Negeri', 7, '20320079', 2, ' Rowosari ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(506, '20320055', ' SD NEGERI SRATEN ', 'SD', 'Negeri', 7, '20320055', 2, ' Sraten, RT 03/04, kec. Tuntang, kab. Semarang, Jawa Tengah ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(507, '20320338', ' SD NEGERI TLOGO ', 'SD', 'Negeri', 7, '20320338', 2, ' Tlogo ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(508, '20320337', ' SD NEGERI TLOMPAKAN 01 ', 'SD', 'Negeri', 7, '20320337', 2, ' Tlompakan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(509, '20320336', ' SD NEGERI TLOMPAKAN 03 ', 'SD', 'Negeri', 7, '20320336', 2, ' Tlompakan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(510, '20320327', ' SD NEGERI TUNTANG 01 ', 'SD', 'Negeri', 7, '20320327', 2, ' Jl. Fatmawati No. 6 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(511, '20320313', ' SD NEGERI TUNTANG 02 ', 'SD', 'Negeri', 7, '20320313', 2, ' Tuntang JL.Merak No.02 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(512, '20320368', ' SD NEGERI TUNTANG 03 ', 'SD', 'Negeri', 7, '20320368', 2, ' Jl. Fatmawati 116 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(513, '20320421', ' SD NEGERI TUNTANG 04 ', 'SD', 'Negeri', 7, '20320421', 2, ' Cikal ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(514, '20320409', ' SD NEGERI WATUAGUNG 01 ', 'SD', 'Negeri', 7, '20320409', 2, ' Watuagung ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(515, '20320420', ' SD NEGERI WATUAGUNG 02 ', 'SD', 'Negeri', 7, '20320420', 2, ' Watuagung ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(516, '20320301', ' SMP NEGERI 1 TUNTANG ', 'SMP', 'Negeri', 7, '20320301', 2, ' Jl. Jelok-Timo KM.04 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(517, '20320272', ' SMP NEGERI 2 TUNTANG ', 'SMP', 'Negeri', 7, '20320272', 2, ' Jl. Mertokusumo ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(518, '20320278', ' SMP NEGERI 3 TUNTANG ', 'SMP', 'Negeri', 7, '20320278', 2, ' Beran ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(519, '69969346', ' SMP ISLAM PLUS AT TOHARI TUNTANG ', 'SMP', 'Swasta', 7, '69969346', 2, ' Gading RT.06, RW.02 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(520, '20320218', ' SMP NUSANTARA TUNTANG ', 'SMP', 'Swasta', 7, '20320218', 2, ' Jl Raya Muncul Salatiga Gedangan Tuntang ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(521, '20320259', ' SMP PANGUDI LUHUR TUNTANG ', 'SMP', 'Swasta', 7, '20320259', 2, ' Jl. Raya Tuntang Bringin Km 5 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(522, '20320796', ' SD NEGERI BANDARJO 01 ', 'SD', 'Negeri', 1, '20320796', 2, ' Jl.telomoyo Tengah Iv/2 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(523, '20320795', ' SD NEGERI BANDARJO 02 ', 'SD', 'Negeri', 1, '20320795', 2, ' Sindoro II/21 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(524, '20320794', ' SD NEGERI BANDARJO 03 ', 'SD', 'Negeri', 1, '20320794', 2, ' Jl.Gatot Subroto 123a ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(525, '20320858', ' SD NEGERI BRANJANG ', 'SD', 'Negeri', 1, '20320858', 2, ' Cemanggah Lor ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(526, '20320812', ' SD NEGERI CANDIREJO 01 ', 'SD', 'Negeri', 1, '20320812', 2, ' Jl. Gedongsongo No. 01 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(527, '20320809', ' SD NEGERI CANDIREJO 02 ', 'SD', 'Negeri', 1, '20320809', 2, ' JL.BOROBUDUR ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(528, '20320685', ' SD NEGERI GENUK 01 ', 'SD', 'Negeri', 1, '20320685', 2, ' Jl S Parman 108 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(529, '20320684', ' SD NEGERI GENUK 02 ', 'SD', 'Negeri', 1, '20320684', 2, ' Jl.Diponegoro 154 A ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(530, '20320651', ' SD NEGERI GOGIK 01 ', 'SD', 'Negeri', 1, '20320651', 2, ' Jln. Danau Toba No. 08 Gogik ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(531, '20320742', ' SD NEGERI KALISIDI 01 ', 'SD', 'Negeri', 1, '20320742', 2, ' Jl. Intan raya, Dsn. Compok ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(532, '20320741', ' SD NEGERI KALISIDI 02 ', 'SD', 'Negeri', 1, '20320741', 2, ' Manikmoyo Kalisidi ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(533, '20320740', ' SD NEGERI KALISIDI 03 ', 'SD', 'Negeri', 1, '20320740', 2, ' Jl.gebug ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(534, '20320147', ' SD NEGERI KEJI ', 'SD', 'Negeri', 1, '20320147', 2, ' Jl.raya Suruhan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(535, '20320184', ' SD NEGERI LANGENSARI 01 ', 'SD', 'Negeri', 1, '20320184', 2, ' Jl Jend Sudirman 138 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(536, '20331141', ' SD NEGERI LANGENSARI 02 ', 'SD', 'Negeri', 1, '20331141', 2, ' Jl Erlangga No 11 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(537, '20320183', ' SD NEGERI LANGENSARI 03 ', 'SD', 'Negeri', 1, '20320183', 2, ' Jl Kertanegara No 35 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(538, '20320185', ' SD NEGERI LANGENSARI 04 ', 'SD', 'Negeri', 1, '20320185', 2, ' Jl Brawijaya Langensari III ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(539, '20320201', ' SD NEGERI LEREP 01 ', 'SD', 'Negeri', 1, '20320201', 2, ' Jl Srikandi Raya no 2 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(540, '20320200', ' SD NEGERI LEREP 02 ', 'SD', 'Negeri', 1, '20320200', 2, ' Jl Kalimasada No 08 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(541, '20320199', ' SD NEGERI LEREP 04 ', 'SD', 'Negeri', 1, '20320199', 2, ' Lerep Rt. 02/RW.2 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(542, '20320198', ' SD NEGERI LEREP 05 ', 'SD', 'Negeri', 1, '20320198', 2, ' Jl Ismaya Raya no. 19 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(543, '20320197', ' SD NEGERI LEREP 06 ', 'SD', 'Negeri', 1, '20320197', 2, ' Jl Bima raya No 01 Mapagan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(544, '20320150', ' SD NEGERI NYATNYONO 01 ', 'SD', 'Negeri', 1, '20320150', 2, ' Jl.hasan Munadi ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(545, '20320030', ' SD NEGERI NYATNYONO 02 ', 'SD', 'Negeri', 1, '20320030', 2, ' Jl Kyai Mojo No 55 Sendang Rejo ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(546, '20320034', ' SD NEGERI SIDOMULYO 01 ', 'SD', 'Negeri', 1, '20320034', 2, ' Jl Rindang Asih ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(547, '20320403', ' SD NEGERI UNGARAN 01 ', 'SD', 'Negeri', 1, '20320403', 2, ' Jl. Diponegoro No 04 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(548, '20320402', ' SD NEGERI UNGARAN 02 ', 'SD', 'Negeri', 1, '20320402', 2, ' Jl. MT. Haryono No 16 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(549, '20320399', ' SD NEGERI UNGARAN 05 ', 'SD', 'Negeri', 1, '20320399', 2, ' Jl.Hos Cokroaminoto 20 Ungaran ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(550, '20320491', ' SD ISLAM ISTIQOMAH ', 'SD', 'Swasta', 1, '20320491', 2, ' Jl. Diponegoro No. 36 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(551, '20320502', ' SD ISLAM TERPADU ASSALAMAH ', 'SD', 'Swasta', 1, '20320502', 2, ' Jl Gatot Subroto 104 B ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(552, '20339183', ' SD KANAAN ', 'SD', 'Swasta', 1, '20339183', 2, ' Jl. Kyai Sono No. 2 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(553, '20320496', ' SD KANISIUS GENUK ', 'SD', 'Swasta', 1, '20320496', 2, ' Jl Diponegoro No 232 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(554, '20320788', ' SD KRISTEN BANDARJO ', 'SD', 'Swasta', 1, '20320788', 2, ' JALAN SINDORO II NO. 32 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(555, '20320784', ' SD MARDI RAHAYU 01 ', 'SD', 'Swasta', 1, '20320784', 2, ' Jl Diponegoro No 741 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(556, '20320783', ' SD MARDI RAHAYU 02 ', 'SD', 'Swasta', 1, '20320783', 2, ' Jl. Diponegoro No. 741 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(557, '20361979', ' SD SOLAFIDE (SOLAFIDE SCHOOL) ', 'SD', 'Swasta', 1, '20361979', 2, ' Jl KH Hasyim Ashari No101 Ungaran Barat ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(558, '20348573', ' SEKOLAH DASAR ALAM UNGARAN ', 'SD', 'Swasta', 1, '20348573', 2, ' Jl. Ismaya Raya No.57 Rt.02/Rw.6 Dsn. Lorog ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(559, '69960205', ' SEKOLAH DASAR ISLAM GINTUNGAN ', 'SD', 'Swasta', 1, '69960205', 2, ' Desa Gogik Dusun Gintungan Rt 06/ Rw 02 Ungaran Barat ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(560, '69974735', ' SD WUJUD KASIH UNGARAN ', 'SD', 'Swasta', 1, '69974735', 2, ' Jln. Sindoro I/10 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(561, '20320277', ' SMP NEGERI 3 UNGARAN ', 'SMP', 'Negeri', 1, '20320277', 2, ' Jl. Patimura I-a ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(562, '20320275', ' SMP NEGERI 4 UNGARAN ', 'SMP', 'Negeri', 1, '20320275', 2, ' Jl. Erlangga ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(563, '20339207', ' SMP NEGERI 6 UNGARAN SATU ATAP ', 'SMP', 'Negeri', 1, '20339207', 2, ' LEREP ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(564, '69873980', ' SMP DAARUL QUR`AN UNGARAN ', 'SMP', 'Swasta', 1, '69873980', 2, ' Dusun Suruhan Desa Keji ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(565, '20331721', ' SMP ISLAM PLUS ASSALAMAH UNGARAN ', 'SMP', 'Swasta', 1, '20331721', 2, ' J.l Gatot Subroto No. 104 B Ungaran ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(566, '20320205', ' SMP ISLAM UNGARAN ', 'SMP', 'Swasta', 1, '20320205', 2, ' Jl. Kauman Selatan No. 1 Ungaran ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(567, '20363772', ' SMP KANAAN ', 'SMP', 'Swasta', 1, '20363772', 2, ' GENUK ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(568, '20320228', ' SMP MARDI RAHAYU UNGARAN ', 'SMP', 'Swasta', 1, '20320228', 2, ' Jl.diponegoro 741 Ungaran ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(569, '20320227', ' SMP MASEHI PSAK UNGARAN ', 'SMP', 'Swasta', 1, '20320227', 2, ' Jl. Kartini 7 UNGARAN ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(570, '20320297', ' SMP PGRI UNGARAN ', 'SMP', 'Swasta', 1, '20320297', 2, ' Jl MT Haryono No 14A Ungaran ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(571, '69971138', ' SMP AN NUR UNGARAN ', 'SMP', 'Swasta', 1, '69971138', 2, ' Jl. Danau Toba No 1A ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(572, '20320805', ' SD NEGERI BEJI 01 ', 'SD', 'Negeri', 2, '20320805', 2, ' Jl Merdeka N0 11 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(573, '20320833', ' SD NEGERI BEJI 02 ', 'SD', 'Negeri', 2, '20320833', 2, ' Jl Sentani No 1 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(574, '20320672', ' SD NEGERI GEDANGANAK 01 ', 'SD', 'Negeri', 2, '20320672', 2, ' Jl. Jendral Sudirman No.9 Ungaran ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(575, '20320671', ' SD NEGERI GEDANGANAK 02 ', 'SD', 'Negeri', 2, '20320671', 2, ' Jl.sulawesi No 9 B ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(576, '20320670', ' SD NEGERI GEDANGANAK 03 ', 'SD', 'Negeri', 2, '20320670', 2, ' Jl.Karimunjawa 22 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(577, '20320747', ' SD NEGERI KALIKAYEN ', 'SD', 'Negeri', 2, '20320747', 2, ' RT 04 RW 01 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(578, '20320744', ' SD NEGERI KALIREJO 01 ', 'SD', 'Negeri', 2, '20320744', 2, ' Jl.jati Raya No 58 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(579, '20320743', ' SD NEGERI KALIREJO 02 ', 'SD', 'Negeri', 2, '20320743', 2, ' Jl. Sukun No.4 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(580, '20320708', ' SD NEGERI KALONGAN 01 ', 'SD', 'Negeri', 2, '20320708', 2, ' Jl Nakula 123 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(581, '20320707', ' SD NEGERI KALONGAN 02 ', 'SD', 'Negeri', 2, '20320707', 2, ' Jl Gatotkaca RT 2 RW 2 Kajangan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(582, '20320706', ' SD NEGERI KALONGAN 03 ', 'SD', 'Negeri', 2, '20320706', 2, ' Jl.amarta No 1 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(583, '20320713', ' SD NEGERI KAWENGEN 01 ', 'SD', 'Negeri', 2, '20320713', 2, ' Dsn. Genurid Desa Kawengen ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(584, '20320712', ' SD NEGERI KAWENGEN 02 ', 'SD', 'Negeri', 2, '20320712', 2, ' Jl.raya Kawengan No 1 Rt 01 Rw 03 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(585, '20320196', ' SD NEGERI LEYANGAN ', 'SD', 'Negeri', 2, '20320196', 2, ' Leyangan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(586, '20320158', ' SD NEGERI MLUWEH 01 ', 'SD', 'Negeri', 2, '20320158', 2, ' Jl. Penggaron Mluweh Km 4 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(587, '20320033', ' SD NEGERI SIDOMULYO 03 ', 'SD', 'Negeri', 2, '20320033', 2, ' Jl. Mayjend Sutoyo No.52 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(588, '20320044', ' SD NEGERI SIDOMULYO 04 ', 'SD', 'Negeri', 2, '20320044', 2, ' Jl.Letjen Suprapto 39 Ungaran ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(589, '20320342', ' SD NEGERI SUSUKAN 01 ', 'SD', 'Negeri', 2, '20320342', 2, ' Jl. Panjaitan Raya No. 20 Susukan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(590, '20320366', ' SD NEGERI SUSUKAN 02 ', 'SD', 'Negeri', 2, '20320366', 2, ' Jl.Urip Sumoharjo No 25 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(591, '20320364', ' SD NEGERI SUSUKAN 04 ', 'SD', 'Negeri', 2, '20320364', 2, ' Jl.kol Sugiyono No 2 Rt 04 / 04 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(592, '20320490', ' SD HJ. ISRIATI MOENADI ', 'SD', 'Swasta', 2, '20320490', 2, ' Jl.letjen Suprapto 29 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(593, '69968264', ' SD ISLAM MULTIPLUS AR-RAHIIM ', 'SD', 'Swasta', 2, '69968264', 2, ' Jl. Arjuna 1 Kajangan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(594, '69952347', ' Sekolah Dasar Islam Al-Madinah ', 'SD', 'Swasta', 2, '69952347', 2, ' Desa Kalongan Kecamatan Ungaran Timur ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(595, '20320287', ' SMP NEGERI 1 UNGARAN ', 'SMP', 'Negeri', 2, '20320287', 2, ' Jl. Diponegoro 197 Ungaran ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(596, '20320273', ' SMP NEGERI 2 UNGARAN ', 'SMP', 'Negeri', 2, '20320273', 2, ' Jl.letjend Suprapto No 65 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(597, '20320260', ' SMP NEGERI 5 UNGARAN ', 'SMP', 'Negeri', 2, '20320260', 2, ' Jl.nakula ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(598, '20331722', ' SMP ISLAM TERPADU MIFTAHUL ULUM UNGARAN ', 'SMP', 'Swasta', 2, '20331722', 2, ' Jl. Kol Sugiyono No. I ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(599, '20331724', ' SMP MUHAMMADIYAH UNGARAN ', 'SMP', 'Swasta', 2, '20331724', 2, ' Jl. Raya Babadan-Leyangan Km. 3 , Dsn. Paraan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(600, '123456', 'SMPIT ALHASIL', 'SMP', 'Swasta', 1, '123456', 2, 'Lama Lama Hilang', '10101010', NULL, 'Guntur', '01010', 'Pao Pao', '10222', '2019-08-28 06:26:44', '2019-08-29 04:19:05', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `submenu`
--

CREATE TABLE `submenu` (
  `id` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  `id_submodul` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `submenu`
--

INSERT INTO `submenu` (`id`, `id_role`, `id_submodul`) VALUES
(1, 1, 1),
(2, 1, 2),
(6, 1, 6),
(7, 1, 7),
(9, 1, 9),
(11, 1, 3),
(12, 1, 12),
(15, 1, 15),
(16, 1, 16),
(17, 1, 17),
(18, 1, 18),
(19, 1, 19),
(20, 1, 20),
(23, 2, 1),
(24, 2, 3),
(28, 2, 9),
(29, 1, 29),
(31, 1, 24),
(32, 1, 25),
(33, 2, 24),
(34, 2, 25),
(35, 1, 28),
(36, 1, 30),
(37, 1, 31),
(38, 1, 32),
(39, 1, 37),
(40, 1, 33),
(41, 1, 34),
(42, 1, 35),
(43, 1, 36),
(44, 1, 38),
(45, 1, 39),
(46, 2, 2),
(47, 2, 6),
(48, 2, 38),
(49, 2, 39),
(50, 2, 7),
(51, 1, 40),
(52, 2, 40),
(53, 2, 41),
(54, 2, 42),
(55, 2, 43),
(56, 1, 41),
(57, 1, 42),
(58, 1, 43),
(59, 1, 44),
(60, 2, 44),
(61, 2, 45),
(62, 2, 46),
(63, 2, 47),
(64, 1, 45),
(65, 1, 46),
(66, 1, 47),
(67, 2, 48),
(68, 2, 49),
(69, 2, 50),
(70, 1, 48),
(71, 1, 49),
(72, 1, 50);

-- --------------------------------------------------------

--
-- Struktur dari tabel `submodul`
--

CREATE TABLE `submodul` (
  `id` int(11) NOT NULL,
  `id_modul` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `url` varchar(255) NOT NULL,
  `isparent` int(1) NOT NULL DEFAULT 0,
  `submodul` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `submodul`
--

INSERT INTO `submodul` (`id`, `id_modul`, `nama`, `url`, `isparent`, `submodul`) VALUES
(1, 2, 'Data RKA', 'rka.php', 0, 0),
(2, 2, 'RKA Perubahan', 'rkaperubahan.php', 0, 0),
(3, 7, 'Data Perubahan', 'tabelperubahan.php', 0, 0),
(4, 3, 'Penerimaan RKA', 'tabelpencairan.php', 0, 0),
(5, 3, 'Import Penerimaan', 'importpencairan.php', 0, 0),
(6, 4, 'Penerimaan Dana', 'pencairan.php', 0, 0),
(7, 5, 'Data Sekolah', 'tabelsekolah.php', 0, 0),
(8, 5, 'Import Sekolah', 'importsekolah.php', 0, 0),
(9, 6, 'Data Belanja', 'belanja.php', 0, 41),
(12, 7, 'Input Perubahan', 'inputperubahanrka.php', 0, 0),
(15, 8, 'Data Program', 'tabelprogram.php', 0, 0),
(16, 8, 'Tambah Program', 'tambahprogram.php', 0, 0),
(17, 9, 'Data Komponen', 'tabelkomponen.php', 0, 0),
(18, 9, 'Tambah Komponen', 'tambahkomponen.php', 0, 0),
(19, 10, 'Data Rekening', 'tabelrekening.php', 0, 0),
(20, 10, 'Tambah Rekening', 'tambahrekening.php', 0, 0),
(21, 6, 'Tambah Belanja', 'tambahbelanja.php', 0, 0),
(22, 4, 'Saldo Triwulan', 'saldotriwulan.php', 0, 0),
(23, 4, 'Sisa Pagu', 'sisapagu.php', 0, 0),
(24, 6, 'Data Persediaan', 'tabelbelanjapersediaan.php', 0, 41),
(25, 6, 'Data Belanja Modal', 'tabelbelanjamodal.php', 0, 41),
(26, 6, 'Belanja Persediaan', 'belanjapersediaan.php', 0, 0),
(27, 6, 'Belanja Modal', 'belanjamodal.php', 0, 0),
(28, 11, 'Cetak Data Sekolah', 'laporan/cetak_datasekolah.php', 0, 0),
(29, 11, 'Cetak Kode Rekening', 'laporan/cetak_koderekening.php', 0, 0),
(30, 11, 'Cetak Prog. Kegiatan', 'laporan/cetak_prokegiatan.php', 0, 0),
(31, 11, 'Cetak Komponen Bos', 'laporan/cetak_komponenbos.php', 0, 0),
(32, 11, 'Cetak Pagu-1', 'laporan/cetak_pagu1.php', 0, 0),
(33, 11, 'Cetak Perubahan Pagu', 'laporan/cetak_perubahanpagu.php', 0, 0),
(34, 11, 'Cetak Pengajuan RKAS', 'laporan/cetak_pengajuanrkas.php', 0, 0),
(35, 11, 'Cetak Perubahan RKAS', 'lap_perubahan_pagu.php', 0, 0),
(36, 11, 'Pencairan RKAS', 'lap_perubahan_pagu.php', 0, 0),
(37, 11, 'Cetak Pagu-2', 'laporan/cetak_pagu2.php', 0, 0),
(38, 12, 'Data Pagu', 'pagu.php', 0, 0),
(39, 12, 'Pagu Perubahan', 'paguperubahan.php', 0, 0),
(40, 4, 'Saldo Sekolah', 'tabelsaldo.php', 0, 0),
(41, 6, 'Belanja Th Berjalan', 'javascript:void()', 1, 0),
(42, 6, 'Belanja Perubahan', 'javascript:void()', 1, 0),
(43, 6, 'Belanja Th Lalu', 'javascript:void()', 1, 0),
(44, 4, 'Saldo Th Lalu', 'tabelsaldolalu.php', 0, 0),
(45, 6, 'Data Belanja', 'belanjaperubahan.php', 0, 42),
(46, 6, 'Data Persediaan', 'tabelbelanjapersediaan2.php', 0, 42),
(47, 6, 'Data Belanja Modal', 'tabelbelanjamodal2.php', 0, 42),
(48, 6, 'Data Belanja', 'belanjathlalu.php', 0, 43),
(49, 6, 'Data Persediaan', 'tabelbelanjapersediaan3.php', 0, 43),
(50, 6, 'Data Belanja Modal', 'tabelbelanjamodal3.php', 0, 43);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `belanjas`
--
ALTER TABLE `belanjas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `belanjathlalus`
--
ALTER TABLE `belanjathlalus`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `belanjathlalu_modals`
--
ALTER TABLE `belanjathlalu_modals`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `belanjathlalu_persediaans`
--
ALTER TABLE `belanjathlalu_persediaans`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `belanja_modals`
--
ALTER TABLE `belanja_modals`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `belanja_persediaans`
--
ALTER TABLE `belanja_persediaans`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kecamatan`
--
ALTER TABLE `kecamatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kodebarang`
--
ALTER TABLE `kodebarang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kodepembiayaan`
--
ALTER TABLE `kodepembiayaan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_pembiayaan` (`kode_pembiayaan`);

--
-- Indeks untuk tabel `kodeprogram`
--
ALTER TABLE `kodeprogram`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_program` (`kode_program`);

--
-- Indeks untuk tabel `koderekening`
--
ALTER TABLE `koderekening`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idmodulmenu` (`id_modul`),
  ADD KEY `idrolemenu` (`id_role`);

--
-- Indeks untuk tabel `modul`
--
ALTER TABLE `modul`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pagus`
--
ALTER TABLE `pagus`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pagu_kemarins`
--
ALTER TABLE `pagu_kemarins`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pagu_perubahans`
--
ALTER TABLE `pagu_perubahans`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pagu_sisas`
--
ALTER TABLE `pagu_sisas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pencairans`
--
ALTER TABLE `pencairans`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pencairan_sisas`
--
ALTER TABLE `pencairan_sisas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `rkas`
--
ALTER TABLE `rkas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `rka_sisas`
--
ALTER TABLE `rka_sisas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `saldos`
--
ALTER TABLE `saldos`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sekolah`
--
ALTER TABLE `sekolah`
  ADD PRIMARY KEY (`id_sekolah`),
  ADD UNIQUE KEY `npsn` (`npsn`);

--
-- Indeks untuk tabel `submenu`
--
ALTER TABLE `submenu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idsubmodulmenu` (`id_submodul`),
  ADD KEY `idrolesubmenu` (`id_role`);

--
-- Indeks untuk tabel `submodul`
--
ALTER TABLE `submodul`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idmodul` (`id_modul`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `belanjas`
--
ALTER TABLE `belanjas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `belanjathlalus`
--
ALTER TABLE `belanjathlalus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `belanjathlalu_modals`
--
ALTER TABLE `belanjathlalu_modals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `belanjathlalu_persediaans`
--
ALTER TABLE `belanjathlalu_persediaans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `belanja_modals`
--
ALTER TABLE `belanja_modals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `belanja_persediaans`
--
ALTER TABLE `belanja_persediaans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `kecamatan`
--
ALTER TABLE `kecamatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `kodebarang`
--
ALTER TABLE `kodebarang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=589;

--
-- AUTO_INCREMENT untuk tabel `kodepembiayaan`
--
ALTER TABLE `kodepembiayaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `kodeprogram`
--
ALTER TABLE `kodeprogram`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `koderekening`
--
ALTER TABLE `koderekening`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `modul`
--
ALTER TABLE `modul`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `pagus`
--
ALTER TABLE `pagus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pagu_kemarins`
--
ALTER TABLE `pagu_kemarins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pagu_perubahans`
--
ALTER TABLE `pagu_perubahans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pagu_sisas`
--
ALTER TABLE `pagu_sisas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pencairans`
--
ALTER TABLE `pencairans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pencairan_sisas`
--
ALTER TABLE `pencairan_sisas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `rkas`
--
ALTER TABLE `rkas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `rka_sisas`
--
ALTER TABLE `rka_sisas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `role`
--
ALTER TABLE `role`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `saldos`
--
ALTER TABLE `saldos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `sekolah`
--
ALTER TABLE `sekolah`
  MODIFY `id_sekolah` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=601;

--
-- AUTO_INCREMENT untuk tabel `submenu`
--
ALTER TABLE `submenu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT untuk tabel `submodul`
--
ALTER TABLE `submodul`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `koderekening`
--
ALTER TABLE `koderekening`
  ADD CONSTRAINT `koderekening_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `koderekening` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `idmodulmenu` FOREIGN KEY (`id_modul`) REFERENCES `modul` (`id`),
  ADD CONSTRAINT `idrolemenu` FOREIGN KEY (`id_role`) REFERENCES `role` (`id`);

--
-- Ketidakleluasaan untuk tabel `submenu`
--
ALTER TABLE `submenu`
  ADD CONSTRAINT `idrolesubmenu` FOREIGN KEY (`id_role`) REFERENCES `role` (`id`),
  ADD CONSTRAINT `idsubmodulmenu` FOREIGN KEY (`id_submodul`) REFERENCES `submodul` (`id`);

--
-- Ketidakleluasaan untuk tabel `submodul`
--
ALTER TABLE `submodul`
  ADD CONSTRAINT `idmodul` FOREIGN KEY (`id_modul`) REFERENCES `modul` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
