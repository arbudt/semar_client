-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Waktu pembuatan: 24. Oktober 2015 jam 17:22
-- Versi Server: 5.5.16
-- Versi PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `semar_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `map_service`
--

CREATE TABLE IF NOT EXISTS `map_service` (
  `mser_id` int(11) NOT NULL AUTO_INCREMENT,
  `mrs_id` int(11) NOT NULL,
  `mser_nama` varchar(30) NOT NULL,
  `mser_url` varchar(225) NOT NULL,
  PRIMARY KEY (`mser_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `mst_pasien`
--

CREATE TABLE IF NOT EXISTS `mst_pasien` (
  `mpas_id` int(11) NOT NULL AUTO_INCREMENT,
  `mpas_nama` varchar(50) NOT NULL,
  `mpas_jenis_kelamin` char(1) NOT NULL,
  `mpas_tempat_lahir` varchar(50) NOT NULL,
  `mpas_tanggal_lahir` date NOT NULL,
  `rsk_id` int(11) NOT NULL,
  `rag_id` int(11) NOT NULL,
  `rgd_id` int(11) NOT NULL,
  `mpas_telepon` varchar(30) NOT NULL,
  `mpas_hp` varchar(30) NOT NULL,
  `mpas_no_identitas` varchar(30) NOT NULL,
  `mpas_alamat` varchar(225) NOT NULL,
  `rpro_id` int(11) NOT NULL,
  `rkab_id` int(11) NOT NULL,
  `rkec_id` int(11) NOT NULL,
  `rkel_id` int(11) NOT NULL,
  `rpend_id` int(11) NOT NULL,
  `rpek_id` int(11) NOT NULL,
  `mpas_nama_sutri` varchar(30) NOT NULL,
  `rpend_id_sutri` int(11) NOT NULL,
  `rpek_id_sutri` int(11) NOT NULL,
  `mpas_ayah` varchar(30) NOT NULL,
  `rpend_id_ayah` int(11) NOT NULL,
  `rpek_id_ayah` int(11) NOT NULL,
  `mpas_ibu` varchar(30) NOT NULL,
  `rpend_id_ibu` int(11) NOT NULL,
  `rpek_id_ibu` int(11) NOT NULL,
  `mpas_alergi` text NOT NULL,
  PRIMARY KEY (`mpas_id`),
  KEY `rsk_id` (`rsk_id`,`rag_id`,`rgd_id`,`rpro_id`,`rkab_id`,`rkec_id`,`rkel_id`,`mpas_nama_sutri`,`rpend_id_sutri`,`mpas_ayah`,`rpend_id_ayah`,`rpend_id_ibu`,`rpek_id_ibu`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `mst_rumah_sakit`
--

CREATE TABLE IF NOT EXISTS `mst_rumah_sakit` (
  `mrs_id` int(11) NOT NULL AUTO_INCREMENT,
  `mrs_nama` varchar(30) NOT NULL,
  `mrs_keterangan` varchar(225) NOT NULL,
  `mrs_isaktif` int(1) NOT NULL,
  `mrs_host` varchar(225) NOT NULL,
  PRIMARY KEY (`mrs_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data untuk tabel `mst_rumah_sakit`
--

INSERT INTO `mst_rumah_sakit` (`mrs_id`, `mrs_nama`, `mrs_keterangan`, `mrs_isaktif`, `mrs_host`) VALUES
(1, 'RSUD Jogja', 'rumah sakit umum daerah jogja', 1, ''),
(2, 'RSUD Sleman', 'rumah sakit umum daerah sleman', 1, ''),
(3, 'RSUD Magelang', 'rumah sakit umum daerah magelang', 1, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ref_agama`
--

CREATE TABLE IF NOT EXISTS `ref_agama` (
  `rag_id` int(11) NOT NULL AUTO_INCREMENT,
  `rag_nama` varchar(30) NOT NULL,
  `rag_isaktif` int(1) NOT NULL,
  PRIMARY KEY (`rag_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data untuk tabel `ref_agama`
--

INSERT INTO `ref_agama` (`rag_id`, `rag_nama`, `rag_isaktif`) VALUES
(1, 'Islam', 1),
(2, 'Kristen', 1),
(3, 'Katolik', 1),
(4, 'Hindu', 1),
(5, 'Budha', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ref_golongan_darah`
--

CREATE TABLE IF NOT EXISTS `ref_golongan_darah` (
  `rgd_id` varchar(2) NOT NULL,
  `rgd_isaktif` int(11) NOT NULL,
  PRIMARY KEY (`rgd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ref_golongan_darah`
--

INSERT INTO `ref_golongan_darah` (`rgd_id`, `rgd_isaktif`) VALUES
('A', 1),
('AB', 1),
('B', 1),
('O', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ref_kabupaten`
--

CREATE TABLE IF NOT EXISTS `ref_kabupaten` (
  `rkab_id` int(11) NOT NULL AUTO_INCREMENT,
  `rkab_nama` varchar(30) NOT NULL,
  `rpro_id` int(11) NOT NULL,
  `rkab_isaktif` int(1) NOT NULL,
  PRIMARY KEY (`rkab_id`),
  KEY `rp_id` (`rpro_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data untuk tabel `ref_kabupaten`
--

INSERT INTO `ref_kabupaten` (`rkab_id`, `rkab_nama`, `rpro_id`, `rkab_isaktif`) VALUES
(1, 'Jogja', 1, 1),
(2, 'Sleman', 1, 1),
(3, 'Bantul', 1, 1),
(4, 'Magelang', 2, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ref_kecamatan`
--

CREATE TABLE IF NOT EXISTS `ref_kecamatan` (
  `rkec_id` int(11) NOT NULL AUTO_INCREMENT,
  `rkec_nama` varchar(30) NOT NULL,
  `rkab_id` int(11) NOT NULL,
  `rkec_isaktif` int(1) NOT NULL,
  PRIMARY KEY (`rkec_id`),
  KEY `rkab_id` (`rkab_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `ref_kecamatan`
--

INSERT INTO `ref_kecamatan` (`rkec_id`, `rkec_nama`, `rkab_id`, `rkec_isaktif`) VALUES
(1, 'Umbulharjo', 1, 1),
(2, 'Ngampilan', 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ref_kelurahan`
--

CREATE TABLE IF NOT EXISTS `ref_kelurahan` (
  `rkel_id` int(11) NOT NULL AUTO_INCREMENT,
  `rkel_nama` varchar(30) NOT NULL,
  `rkec_id` int(11) NOT NULL,
  `rkel_isaktif` int(1) NOT NULL,
  PRIMARY KEY (`rkel_id`),
  KEY `rkec_id` (`rkec_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data untuk tabel `ref_kelurahan`
--

INSERT INTO `ref_kelurahan` (`rkel_id`, `rkel_nama`, `rkec_id`, `rkel_isaktif`) VALUES
(1, 'Kelurahan 1', 1, 1),
(2, 'Kelurahan 2', 1, 1),
(3, 'Kelurahan 1', 2, 1),
(4, 'Kelurahan 2', 2, 1),
(5, 'Kelurahan 1', 3, 1),
(6, 'Kelurahan 2', 3, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ref_pekerjaan`
--

CREATE TABLE IF NOT EXISTS `ref_pekerjaan` (
  `rpek_id` int(11) NOT NULL AUTO_INCREMENT,
  `rpek_nama` varchar(30) NOT NULL,
  `rpek_isaktif` int(1) NOT NULL,
  PRIMARY KEY (`rpek_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data untuk tabel `ref_pekerjaan`
--

INSERT INTO `ref_pekerjaan` (`rpek_id`, `rpek_nama`, `rpek_isaktif`) VALUES
(1, 'PNS', 1),
(2, 'Swasta', 1),
(3, 'TNI', 1),
(4, 'Petani', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ref_pendidikan`
--

CREATE TABLE IF NOT EXISTS `ref_pendidikan` (
  `rpend_id` int(11) NOT NULL AUTO_INCREMENT,
  `rpend_nama` varchar(30) NOT NULL,
  `rpend_isaktif` int(1) NOT NULL,
  PRIMARY KEY (`rpend_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data untuk tabel `ref_pendidikan`
--

INSERT INTO `ref_pendidikan` (`rpend_id`, `rpend_nama`, `rpend_isaktif`) VALUES
(1, 'SD', 1),
(2, 'SMP', 1),
(3, 'SMA', 1),
(4, 'S1', 1),
(5, 'S2', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ref_propinsi`
--

CREATE TABLE IF NOT EXISTS `ref_propinsi` (
  `rpro_id` int(11) NOT NULL AUTO_INCREMENT,
  `rpro_nama` varchar(30) NOT NULL,
  `rpro_isaktif` int(1) NOT NULL,
  PRIMARY KEY (`rpro_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data untuk tabel `ref_propinsi`
--

INSERT INTO `ref_propinsi` (`rpro_id`, `rpro_nama`, `rpro_isaktif`) VALUES
(1, 'D.I Yogyakarta', 1),
(2, 'Jawa Tengah', 1),
(3, 'Jawa Barat', 1),
(4, 'Jawa Timur', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ref_status_kawin`
--

CREATE TABLE IF NOT EXISTS `ref_status_kawin` (
  `rsk_id` int(11) NOT NULL AUTO_INCREMENT,
  `rsk_nama` varchar(30) NOT NULL,
  `rsk_isaktif` int(1) NOT NULL,
  PRIMARY KEY (`rsk_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data untuk tabel `ref_status_kawin`
--

INSERT INTO `ref_status_kawin` (`rsk_id`, `rsk_nama`, `rsk_isaktif`) VALUES
(1, 'Kawin', 1),
(2, 'Belum Kawin', 1),
(3, 'Janda', 1),
(4, 'Duda Kawin', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `trans_kunjungan`
--

CREATE TABLE IF NOT EXISTS `trans_kunjungan` (
  `tkunj_id` int(11) NOT NULL AUTO_INCREMENT,
  `mpas_id` int(11) NOT NULL,
  `mrs_id` int(11) NOT NULL,
  `tkunj_no_rm` varchar(30) NOT NULL,
  PRIMARY KEY (`tkunj_id`),
  KEY `mpas_id` (`mpas_id`,`mrs_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
