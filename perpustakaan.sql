-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2020 at 11:42 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan`
--

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `idBuku` varchar(6) NOT NULL,
  `idKategori` varchar(5) NOT NULL,
  `judul` varchar(150) NOT NULL,
  `idPenerbit` varchar(5) NOT NULL,
  `penulis` varchar(150) NOT NULL,
  `qty` int(11) NOT NULL,
  `image` varchar(50) NOT NULL,
  `sinopsis` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`idBuku`, `idKategori`, `judul`, `idPenerbit`, `penulis`, `qty`, `image`, `sinopsis`) VALUES
('1', '2', 'Assassins Creed Odyssey ', '1', 'Ubisoft', 10, 'acdetail.jpg', 'Assassins creed seri terbaru yang berjudul Odyssey yang menceritakan tentang kehidupan dizaman Sparta'),
('2', '1', 'Far Cry 5', '3', 'Ubisoft', 19, 'android.png', 'farcry 5'),
('3', '1', 'Fortnite', '2', 'Epic Games', 10, 'fortnitedetail.jpg', 'Game battle royal '),
('4', '1', 'NBA 2k19', '4', '2K Games', 10, 'nbadetail.jpg', 'Official game of NBA'),
('5', '2', 'PUBG', '1', 'PUBG corp', 10, 'pubgdetail.jpg', 'Game battle royal realistic '),
('6', '2', 'watch dog 2', '1', 'Ubisoft', 100, 'wddetail.jpg', 'Game hacker yang berada di kota San Fransisco Amerika Serikat'),
('7', '2', 'MotoGP 19 ', '4', 'Milestone ', 199, 'gpdetail.jpg', 'game motogp terbaru dari milestone. Game ini official video game dari motogp');

-- --------------------------------------------------------

--
-- Table structure for table `detailtransaksi`
--

CREATE TABLE `detailtransaksi` (
  `idTransaksi` varchar(7) NOT NULL,
  `idBuku` varchar(6) NOT NULL,
  `tglKembali` date NOT NULL,
  `status` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detailtransaksi`
--

INSERT INTO `detailtransaksi` (`idTransaksi`, `idBuku`, `tglKembali`, `status`) VALUES
('1', '2', '0000-00-00', '0'),
('2', '4', '2020-04-20', '1'),
('2', '7', '2020-04-20', '1');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `idKategori` varchar(5) NOT NULL,
  `kategoriBuku` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`idKategori`, `kategoriBuku`) VALUES
('1', 'Romantis'),
('2', 'Horor');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `idPustakawan` varchar(4) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `hakUser` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`idPustakawan`, `username`, `password`, `hakUser`) VALUES
('1', 'dekatech', 'admin', 'admin'),
('3', 'dimas', 'pus', 'pustakawan');

-- --------------------------------------------------------

--
-- Table structure for table `penerbit`
--

CREATE TABLE `penerbit` (
  `idPenerbit` varchar(5) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penerbit`
--

INSERT INTO `penerbit` (`idPenerbit`, `nama`, `alamat`, `phone`, `email`) VALUES
('1', 'Deka corp & Deka Tech', 'San Fransisco', '1234567890', 'dekacorp@dekatech.com'),
('2', 'Deka institute', 'dekacorp headquarters', '1234567890', 'dekacorp@dekatech.com'),
('3', 'Gramedia', 'Gramedia head Quarters', '0987654321', 'gramedia@gramedia.com'),
('4', 'PUSPEN TNI', 'MABES TNI', '0987654321', 'mabestni@go.id');

-- --------------------------------------------------------

--
-- Table structure for table `pustakawan`
--

CREATE TABLE `pustakawan` (
  `idPustakawan` varchar(4) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pustakawan`
--

INSERT INTO `pustakawan` (`idPustakawan`, `nama`, `alamat`, `phone`, `email`, `image`) VALUES
('1', 'Dekacorp CEO', 'dekacorp headquarters', '0882891019', 'adrian@dekatech.com', 'deka.jpg'),
('3', 'Imanuel Dimas', 'Jajar Stone', '1234567890', 'dimdim@edit.com', 'dimas.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `nis` varchar(9) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(150) NOT NULL,
  `jurusan` varchar(5) NOT NULL,
  `tingkat` char(2) NOT NULL,
  `kelas` char(1) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`nis`, `nama`, `alamat`, `jurusan`, `tingkat`, `kelas`, `phone`, `email`, `image`) VALUES
('181113820', 'Adam Albani', 'Rumah Adam edit', 'RPL', 'XI', 'B', '0987654321', 'adam@adam.com', 'adamedit.png'),
('181113821', 'Adrian Daniel', 'Rumah Adrian', 'RPL', 'XI', 'A', '0987654321', 'dekacorp@dekatech.com', 'inideka.png'),
('181113822', 'Ganiya Mustafa', 'Rumah pa dede', 'RPL', 'XI', 'A', '1234567890', 'ganiya@ganiya.com', 'Ganiya.png'),
('181113823', 'Fahmi Raihan', 'Rumah Fahmi dibaros', 'EIND', 'XI', 'D', '0987654321', 'fahmi@fahmi.com', 'fahmi (2).png'),
('181113824', 'Shaddam Amru Hasibuan', 'Rumah Pa Amri', 'RPL', 'XI', 'A', '0987654321', 'Sadam@hasibuan.com', 'Shaddam Amru.png'),
('181113825', 'Hariz Sufyan Munawar', 'Lembah Teratai', 'RPL', 'XI', 'A', '0987654321', 'Hariz@hariz.com', 'Hariz.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `idTransaksi` varchar(7) NOT NULL,
  `nis` varchar(9) NOT NULL,
  `idPustakawan` varchar(4) NOT NULL,
  `tglPinjam` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`idTransaksi`, `nis`, `idPustakawan`, `tglPinjam`) VALUES
('1', '181113820', '3', '2020-04-20'),
('2', '181113821', '3', '2020-04-20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`idBuku`),
  ADD KEY `idBuku` (`idBuku`),
  ADD KEY `idKategori` (`idKategori`),
  ADD KEY `idPenerbit` (`idPenerbit`);

--
-- Indexes for table `detailtransaksi`
--
ALTER TABLE `detailtransaksi`
  ADD KEY `idBuku` (`idBuku`),
  ADD KEY `idTransaksi` (`idTransaksi`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`idKategori`),
  ADD KEY `idKategori` (`idKategori`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`idPustakawan`,`username`);

--
-- Indexes for table `penerbit`
--
ALTER TABLE `penerbit`
  ADD PRIMARY KEY (`idPenerbit`),
  ADD KEY `idPenerbit` (`idPenerbit`);

--
-- Indexes for table `pustakawan`
--
ALTER TABLE `pustakawan`
  ADD PRIMARY KEY (`idPustakawan`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`nis`),
  ADD KEY `nis` (`nis`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD KEY `idTransaksi` (`idTransaksi`),
  ADD KEY `nis` (`nis`),
  ADD KEY `idPustakawan` (`idPustakawan`),
  ADD KEY `idPustakawan_2` (`idPustakawan`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`idKategori`) REFERENCES `kategori` (`idKategori`) ON UPDATE CASCADE,
  ADD CONSTRAINT `buku_ibfk_2` FOREIGN KEY (`idPenerbit`) REFERENCES `penerbit` (`idPenerbit`) ON UPDATE CASCADE;

--
-- Constraints for table `detailtransaksi`
--
ALTER TABLE `detailtransaksi`
  ADD CONSTRAINT `detailtransaksi_ibfk_1` FOREIGN KEY (`idBuku`) REFERENCES `buku` (`idBuku`) ON UPDATE CASCADE,
  ADD CONSTRAINT `detailtransaksi_ibfk_2` FOREIGN KEY (`idTransaksi`) REFERENCES `transaksi` (`idTransaksi`) ON UPDATE CASCADE;

--
-- Constraints for table `pustakawan`
--
ALTER TABLE `pustakawan`
  ADD CONSTRAINT `pustakawan_ibfk_1` FOREIGN KEY (`idPustakawan`) REFERENCES `login` (`idPustakawan`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`idPustakawan`) REFERENCES `pustakawan` (`idPustakawan`),
  ADD CONSTRAINT `transaksi_ibfk_3` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
