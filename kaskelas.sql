-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Jan 2025 pada 23.27
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kaskelas`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `customer`
--

CREATE TABLE `customer` (
  `Customer_ID` int(11) NOT NULL,
  `Nama` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `No_Telepon` varchar(15) DEFAULT NULL,
  `Alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `customer`
--

INSERT INTO `customer` (`Customer_ID`, `Nama`, `Email`, `No_Telepon`, `Alamat`) VALUES
(1, 'zaky', 'syaifulwahyu@students.amikom.ac.id', '8946982164', 'sfkglf'),
(2, 'ipul', 'syaiful432@dsad', 'fsafsafa', 'sadfsadsad'),
(3, 'abi', 'safsafadf@gmai', '25345345', 'sdfsdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pemesanan`
--

CREATE TABLE `detail_pemesanan` (
  `Detail_ID` int(11) NOT NULL,
  `Pemesanan_ID` int(11) DEFAULT NULL,
  `Menu_ID` int(11) DEFAULT NULL,
  `Jumlah` int(11) DEFAULT NULL,
  `Subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_pemesanan`
--

INSERT INTO `detail_pemesanan` (`Detail_ID`, `Pemesanan_ID`, `Menu_ID`, `Jumlah`, `Subtotal`) VALUES
(1, 0, 0, 1, 50000.00),
(2, 17, 1, 1, 50000.00),
(3, 18, 1, 1, 50000.00),
(4, 18, 2, 1, 15000.00),
(5, 19, 1, 1, 50000.00),
(6, 20, 1, 1, 50000.00),
(7, 21, 1, 1, 50000.00),
(8, 21, 2, 1, 15000.00),
(9, 22, 1, 1, 50000.00),
(10, 23, 1, 1, 50000.00),
(11, 24, 1, 1, 50000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `Menu_ID` int(11) NOT NULL,
  `Nama_Menu` varchar(100) DEFAULT NULL,
  `Harga` decimal(10,2) DEFAULT NULL,
  `Deskripsi` text DEFAULT NULL,
  `Kategori` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`Menu_ID`, `Nama_Menu`, `Harga`, `Deskripsi`, `Kategori`) VALUES
(1, 'Coffe Latee', 50000.00, 'less sugar', 'Minuman'),
(2, 'kentang goreng', 15000.00, 'balado', 'Makanan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `Pembayaran_ID` int(11) NOT NULL,
  `Pemesanan_ID` int(11) DEFAULT NULL,
  `Tanggal_Pembayaran` date DEFAULT NULL,
  `Metode_Pembayaran` varchar(50) DEFAULT NULL,
  `Jumlah_Pembayaran` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`Pembayaran_ID`, `Pemesanan_ID`, `Tanggal_Pembayaran`, `Metode_Pembayaran`, `Jumlah_Pembayaran`) VALUES
(1, 15, '2025-01-23', 'Cash', 15.00),
(2, 23, '2025-01-23', 'Cash', 50.00),
(3, 1, '2025-01-23', 'Cash', 10000.00),
(4, 15, '2025-01-23', 'Cash', 15000.00),
(5, 21, '2025-01-23', 'Cash', 65000.00),
(6, 21, '2025-01-23', 'Cash', 65000.00),
(7, 22, '2025-01-23', 'Cash', 50000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemesanan`
--

CREATE TABLE `pemesanan` (
  `Pemesanan_ID` int(11) NOT NULL,
  `Tanggal_Pemesanan` date DEFAULT NULL,
  `Total_Harga` decimal(10,2) DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `Customer_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pemesanan`
--

INSERT INTO `pemesanan` (`Pemesanan_ID`, `Tanggal_Pemesanan`, `Total_Harga`, `Status`, `Customer_ID`) VALUES
(1, '2025-01-23', 0.00, 'Pending', 0),
(12, '2025-01-23', 0.00, 'Pending', 2),
(13, '2025-01-23', 0.00, 'Pending', 2),
(14, '2025-01-23', 15000.00, 'Pending', 1),
(15, '2025-01-23', 15000.00, 'Pending', 1),
(16, '2025-01-23', 0.00, 'Pending', 1),
(17, '2025-01-23', 0.00, 'Pending', 3),
(18, '2025-01-23', 0.00, 'Pending', 1),
(19, '2025-01-23', 0.00, 'Pending', 1),
(20, '2025-01-23', 0.00, 'Pending', 1),
(21, '2025-01-23', 65000.00, 'Pending', 1),
(22, '2025-01-23', 50000.00, 'Pending', 1),
(23, '2025-01-23', 50000.00, 'Pending', 1),
(24, '2025-01-23', 50000.00, 'Pending', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`Customer_ID`);

--
-- Indeks untuk tabel `detail_pemesanan`
--
ALTER TABLE `detail_pemesanan`
  ADD PRIMARY KEY (`Detail_ID`),
  ADD KEY `Pemesanan_ID` (`Pemesanan_ID`),
  ADD KEY `Menu_ID` (`Menu_ID`);

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`Menu_ID`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`Pembayaran_ID`),
  ADD KEY `Pemesanan_ID` (`Pemesanan_ID`);

--
-- Indeks untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`Pemesanan_ID`),
  ADD KEY `Customer_ID` (`Customer_ID`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `customer`
--
ALTER TABLE `customer`
  MODIFY `Customer_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `detail_pemesanan`
--
ALTER TABLE `detail_pemesanan`
  MODIFY `Detail_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `Menu_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `Pembayaran_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `Pemesanan_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_pemesanan`
--
ALTER TABLE `detail_pemesanan`
  ADD CONSTRAINT `detail_pemesanan_ibfk_1` FOREIGN KEY (`Pemesanan_ID`) REFERENCES `pemesanan` (`Pemesanan_ID`),
  ADD CONSTRAINT `detail_pemesanan_ibfk_2` FOREIGN KEY (`Menu_ID`) REFERENCES `menu` (`Menu_ID`);

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`Pemesanan_ID`) REFERENCES `pemesanan` (`Pemesanan_ID`);

--
-- Ketidakleluasaan untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_ibfk_1` FOREIGN KEY (`Customer_ID`) REFERENCES `customer` (`Customer_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
