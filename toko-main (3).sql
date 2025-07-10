-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Jul 2025 pada 16.09
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko-main`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cart`
--

CREATE TABLE `cart` (
  `idcart` int(11) NOT NULL,
  `orderid` varchar(100) NOT NULL,
  `userid` int(11) NOT NULL,
  `tglorder` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL DEFAULT 'Cart'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `cart`
--

INSERT INTO `cart` (`idcart`, `orderid`, `userid`, `tglorder`, `status`) VALUES
(1, '17UQcpWmrQlx2', 1, '2025-05-05 09:01:12', 'Confirmed');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detailorder`
--

CREATE TABLE `detailorder` (
  `detailid` int(11) NOT NULL,
  `orderid` varchar(100) NOT NULL,
  `idproduk` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detailorder`
--

INSERT INTO `detailorder` (`detailid`, `orderid`, `idproduk`, `qty`) VALUES
(1, '17UQcpWmrQlx2', 6, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `idkategori` int(11) NOT NULL,
  `namakategori` varchar(20) NOT NULL,
  `tgldibuat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`idkategori`, `namakategori`, `tgldibuat`) VALUES
(1, 'Buket', '2024-12-09 03:43:04'),
(2, 'Bunga Hias', '2024-12-09 03:43:10'),
(3, 'Bunga Tanam', '2024-12-09 03:43:16'),
(10, 'Bunga Hidup', '2025-01-14 11:23:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `konfirmasi`
--

CREATE TABLE `konfirmasi` (
  `idkonfirmasi` int(11) NOT NULL,
  `orderid` varchar(100) NOT NULL,
  `userid` int(11) NOT NULL,
  `payment` varchar(10) NOT NULL,
  `namarekening` varchar(25) NOT NULL,
  `tglbayar` date NOT NULL,
  `tglsubmit` timestamp NOT NULL DEFAULT current_timestamp(),
  `gambar` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `konfirmasi`
--

INSERT INTO `konfirmasi` (`idkonfirmasi`, `orderid`, `userid`, `payment`, `namarekening`, `tglbayar`, `tglsubmit`, `gambar`) VALUES
(1, '17UQcpWmrQlx2', 1, 'Shopeepay', 'Abidin Zaenal', '2025-07-24', '2025-07-05 15:22:59', 'bukti/akmal.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `login`
--

CREATE TABLE `login` (
  `userid` int(11) NOT NULL,
  `namalengkap` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL,
  `notelp` varchar(15) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `tgljoin` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` varchar(7) NOT NULL DEFAULT 'Member',
  `lastlogin` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `login`
--

INSERT INTO `login` (`userid`, `namalengkap`, `email`, `password`, `notelp`, `alamat`, `tgljoin`, `role`, `lastlogin`) VALUES
(1, 'Admin Akmal', 'admin@gmail.com', '1', '081292616603', 'Perum griya mukti', '2024-12-09 08:42:07', 'Admin', NULL),
(12, 'Muhammad Akmal Rizki', 'akmalrizki0102@gmail.com', '1', '081311469900', 'Perumahan Griya Mukti Jl. Blk. I No.17, Ciwareng, Kec. Babakancikao, Kabupaten Purwakarta, Jawa Barat 41151', '2024-12-26 13:17:18', 'Member', NULL),
(14, 'Rizki Akmal', 'rizkiakmal@gmail.com', '123', '081292616603', 'Perum Griya Mukti X Y Z blok i / 17', '2025-01-14 11:16:00', 'Member', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `no` int(11) NOT NULL,
  `metode` varchar(25) NOT NULL,
  `norek` varchar(25) NOT NULL,
  `logo` text DEFAULT NULL,
  `an` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`no`, `metode`, `norek`, `logo`, `an`) VALUES
(1, 'Gopay', '081311469900', 'images/Gopay.webp', 'Muhammad Akmal Rizki'),
(2, 'Shopeepay', '081292616603', 'images/Shopeepay.webp', 'Akmal Rizki'),
(5, 'Mandiri', '0912491514', 'images/mandiri.webp', 'Akmal'),
(6, 'OVO', '081234567890', 'images/OVO.webp', 'Akmal Rizki');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `idproduk` int(11) NOT NULL,
  `idkategori` int(11) NOT NULL,
  `namaproduk` varchar(30) NOT NULL,
  `gambar` varchar(100) NOT NULL,
  `deskripsi` varchar(200) NOT NULL,
  `rate` int(11) NOT NULL,
  `hargabefore` int(11) NOT NULL,
  `hargaafter` int(11) NOT NULL,
  `tgldibuat` timestamp NOT NULL DEFAULT current_timestamp(),
  `flashsale` varchar(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`idproduk`, `idkategori`, `namaproduk`, `gambar`, `deskripsi`, `rate`, `hargabefore`, `hargaafter`, `tgldibuat`, `flashsale`) VALUES
(1, 2, 'Flowers daisy pink stick', 'produk/1.jpg', 'Bunga hias 1 pcs per pembelian', 5, 15000, 14000, '2024-12-09 08:41:28', '0'),
(3, 2, 'Bunga karangan mekar', 'produk/5.jpg', 'Bunga hias 1 pcs per pembelian', 5, 25000, 24000, '2024-12-16 22:27:24', '0'),
(4, 2, 'Stik merah bunga anggrek', 'produk/2.jpg', 'Bunga hias 1 pcs per pembelian', 3, 17000, 16000, '2024-12-16 22:28:24', '0'),
(5, 2, 'Tongkat bunga merah', 'produk/3.jpg', 'Bunga hias 1 pcs per pembelian', 5, 19000, 18000, '2024-12-16 22:29:22', '0'),
(6, 2, 'Bunga merah muda daster', 'produk/7.jpg', 'Bunga hias 1 pcs per pembelian', 5, 42000, 41000, '2024-12-16 22:43:07', '0'),
(9, 2, 'Bunga matahari ku', 'produk/9.jpg', 'Bunga hias 1 pcs per pembelian', 4, 45000, 42000, '2024-12-17 22:56:49', '0'),
(10, 1, 'Love lullaby bouquet', 'produk/Blossom-Kiss-Bouquet_350x.webp', 'Buket Bunga Perpaduan Sempurna dari Mixed Color Rose, Lily Putih, dan Filler yang Segar Dirangkai Indah dan Dibalut dengan Wrapping Paper, lalu Dihias dengan Ornamen Pita Satin', 5, 430000, 420000, '2024-12-17 23:06:18', '0'),
(11, 1, 'Rainbow joy bouquet', 'produk/Rainbow-Joy-Bouquet_350x.webp', 'Buket Bunga Perpaduan Sempurna dari Mawar Ungu, Mawar Merah, Gompi Pink, Gompi Kuning, dan Solidago yang Segar Dirangkai Indah dan Dibalut dengan Wrapping Paper, lalu Dihias dengan Ornamen Pita Satin', 5, 255000, 250000, '2024-12-17 23:11:59', '0'),
(12, 1, 'Morning glow bouquet', 'produk/Morning-Glow-Bouquet_350x.webp', 'Kombinasi Aster Kuning, Mawar Peach, dan Daun Ruskus yang Segar Dirangkai dengan Wrapping Paper Premium dan Dihias Pita Satin Elegan serta Tag Buket Ceria yang Cocok untuk Merayakan Hari Ibu', 5, 275000, 260000, '2024-12-17 23:13:13', '0'),
(13, 1, 'Pink darling bouquet', 'produk/Pink-Darling-Bouquet_350x.webp', 'Buket Bunga dari Outerbloom Sebuah Perpaduan Sempurna yang terdiri atas Pink Rose, Pompom, Baby Breath, dan Filler Dirangkai Indah menjadi Satu Kesatuan', 5, 485000, 475000, '2024-12-17 23:15:28', '0'),
(14, 1, 'Bouquet Kris Kringle', 'produk/KrisKringle_01_493x.webp', 'Classic series of bouquet between baby breath and 12 red roses are luxurious. Suitable for romantic, birthday, or anniversary events for your loved ones.', 5, 499000, 480000, '2025-01-02 13:14:58', '0'),
(15, 1, 'BLUE SERENADE BOUQUET', 'produk/Blue-Serenade-Bouquet_350x.webp', 'Berisi Dried Flower Hydrangea Baby Blue Dibalut dalam Wrapping Paper Hologram dan Dihiasi Pita serta Tag Pilihan Tepat untuk Memberikan Sentuhan Spesial pada Momen-Momen Istimewa, seperti Hari Ulang T', 4, 430000, 420000, '2025-01-14 11:25:09', '0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `total_pengunjung`
--

CREATE TABLE `total_pengunjung` (
  `id` int(10) NOT NULL,
  `ip` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `total_pengunjung`
--

INSERT INTO `total_pengunjung` (`id`, `ip`) VALUES
(1, '::1'),
(2, '::1'),
(3, '::1'),
(4, '::1'),
(5, '::1'),
(6, '::1'),
(7, '::1'),
(8, '::1'),
(9, '::1'),
(10, '::1'),
(11, '::1'),
(12, '::1'),
(13, '::1'),
(14, '::1'),
(15, '::1'),
(16, '::1'),
(17, '::1'),
(18, '::1'),
(19, '::1');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`idcart`),
  ADD UNIQUE KEY `orderid` (`orderid`),
  ADD KEY `orderid_2` (`orderid`);

--
-- Indeks untuk tabel `detailorder`
--
ALTER TABLE `detailorder`
  ADD PRIMARY KEY (`detailid`),
  ADD KEY `orderid` (`orderid`),
  ADD KEY `idproduk` (`idproduk`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`idkategori`);

--
-- Indeks untuk tabel `konfirmasi`
--
ALTER TABLE `konfirmasi`
  ADD PRIMARY KEY (`idkonfirmasi`),
  ADD KEY `userid` (`userid`);

--
-- Indeks untuk tabel `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`userid`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`no`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`idproduk`),
  ADD KEY `idkategori` (`idkategori`);

--
-- Indeks untuk tabel `total_pengunjung`
--
ALTER TABLE `total_pengunjung`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `cart`
--
ALTER TABLE `cart`
  MODIFY `idcart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `detailorder`
--
ALTER TABLE `detailorder`
  MODIFY `detailid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `idkategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `konfirmasi`
--
ALTER TABLE `konfirmasi`
  MODIFY `idkonfirmasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `login`
--
ALTER TABLE `login`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `idproduk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `total_pengunjung`
--
ALTER TABLE `total_pengunjung`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detailorder`
--
ALTER TABLE `detailorder`
  ADD CONSTRAINT `idproduk` FOREIGN KEY (`idproduk`) REFERENCES `produk` (`idproduk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orderid` FOREIGN KEY (`orderid`) REFERENCES `cart` (`orderid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `konfirmasi`
--
ALTER TABLE `konfirmasi`
  ADD CONSTRAINT `userid` FOREIGN KEY (`userid`) REFERENCES `login` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `idkategori` FOREIGN KEY (`idkategori`) REFERENCES `kategori` (`idkategori`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
