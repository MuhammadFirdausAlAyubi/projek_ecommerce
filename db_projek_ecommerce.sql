-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Okt 2026 pada 14.49
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
-- Database: `db_projek_ecommerce`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alamat`
--

CREATE TABLE `alamat` (
  `id_alamat` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `nama_penerima` varchar(100) NOT NULL,
  `no_telp_penerima` varchar(20) NOT NULL,
  `provinsi` varchar(100) NOT NULL,
  `kota` varchar(100) NOT NULL,
  `kecamatan` varchar(100) NOT NULL,
  `kode_pos` varchar(10) NOT NULL,
  `alamat_lengkap` text NOT NULL,
  `is_utama` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `bank`
--

CREATE TABLE `bank` (
  `id_bank` int(10) UNSIGNED NOT NULL,
  `nama_bank` varchar(100) NOT NULL,
  `no_rekening` varchar(50) NOT NULL,
  `atas_nama` varchar(100) NOT NULL,
  `status_bank` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `brand`
--

CREATE TABLE `brand` (
  `id_brand` int(10) UNSIGNED NOT NULL,
  `nama_brand` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_keranjang`
--

CREATE TABLE `detail_keranjang` (
  `id_detail_keranjang` int(10) UNSIGNED NOT NULL,
  `id_keranjang` int(10) UNSIGNED NOT NULL,
  `id_produk` int(10) UNSIGNED NOT NULL,
  `jumlah` int(11) NOT NULL DEFAULT 1,
  `tanggal_ditambahkan` datetime NOT NULL DEFAULT current_timestamp()
) ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pembelian`
--

CREATE TABLE `detail_pembelian` (
  `id_detail_pembelian` int(10) UNSIGNED NOT NULL,
  `id_pembelian` int(10) UNSIGNED NOT NULL,
  `id_produk` int(10) UNSIGNED NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga_beli` decimal(12,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL
) ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_detail_pesanan` int(10) UNSIGNED NOT NULL,
  `id_pesanan` int(10) UNSIGNED NOT NULL,
  `id_produk` int(10) UNSIGNED NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga_satuan` decimal(12,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL
) ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ekspedisi`
--

CREATE TABLE `ekspedisi` (
  `id_ekspedisi` int(10) UNSIGNED NOT NULL,
  `nama_ekspedisi` varchar(50) NOT NULL,
  `status_ekspedisi` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `ekspedisi`
--

INSERT INTO `ekspedisi` (`id_ekspedisi`, `nama_ekspedisi`, `status_ekspedisi`) VALUES
(1, 'JNE', 'aktif'),
(2, 'J&T Express', 'aktif'),
(3, 'SiCepat', 'aktif'),
(4, 'Pos Indonesia', 'aktif'),
(5, 'AnterAja', 'aktif'),
(6, 'Ninja Xpress', 'aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(10) UNSIGNED NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `keranjang`
--

CREATE TABLE `keranjang` (
  `id_keranjang` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `tanggal_dibuat` datetime NOT NULL DEFAULT current_timestamp(),
  `status_keranjang` enum('aktif','checkout','dikosongkan') NOT NULL DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(10) UNSIGNED NOT NULL,
  `id_pesanan` int(10) UNSIGNED NOT NULL,
  `id_bank` int(10) UNSIGNED DEFAULT NULL,
  `metode_pembayaran` enum('transfer','cod','ewallet') NOT NULL,
  `tanggal_pembayaran` datetime DEFAULT NULL,
  `nominal` decimal(12,2) NOT NULL,
  `status_pembayaran` enum('menunggu','berhasil','gagal','dikembalikan') NOT NULL DEFAULT 'menunggu'
) ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian`
--

CREATE TABLE `pembelian` (
  `id_pembelian` int(10) UNSIGNED NOT NULL,
  `id_supplier` int(10) UNSIGNED NOT NULL,
  `tanggal_pembelian` datetime NOT NULL DEFAULT current_timestamp(),
  `total_pembelian` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status_pembelian` enum('dipesan','diterima','dibatalkan') NOT NULL DEFAULT 'dipesan'
) ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengiriman`
--

CREATE TABLE `pengiriman` (
  `id_pengiriman` int(10) UNSIGNED NOT NULL,
  `id_pesanan` int(10) UNSIGNED NOT NULL,
  `id_ekspedisi` int(10) UNSIGNED NOT NULL,
  `no_resi` varchar(100) DEFAULT NULL,
  `tanggal_pengiriman` datetime DEFAULT NULL,
  `tanggal_diterima` datetime DEFAULT NULL,
  `status_pengiriman` enum('menunggu','dikemas','dikirim','diterima','gagal') NOT NULL DEFAULT 'menunggu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `id_alamat` int(10) UNSIGNED DEFAULT NULL,
  `alamat_pengiriman_snapshot` text NOT NULL,
  `tanggal_pesanan` datetime NOT NULL DEFAULT current_timestamp(),
  `total_harga` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status_pesanan` enum('menunggu_pembayaran','dibayar','diproses','dikirim','selesai','dibatalkan') NOT NULL DEFAULT 'menunggu_pembayaran'
) ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(10) UNSIGNED NOT NULL,
  `id_kategori` int(10) UNSIGNED NOT NULL,
  `id_brand` int(10) UNSIGNED NOT NULL,
  `nama_produk` varchar(150) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `spesifikasi` text DEFAULT NULL,
  `harga_jual` decimal(12,2) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `status_produk` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `retur_produk`
--

CREATE TABLE `retur_produk` (
  `id_retur` int(10) UNSIGNED NOT NULL,
  `id_detail_pesanan` int(10) UNSIGNED NOT NULL,
  `tanggal_retur` datetime NOT NULL DEFAULT current_timestamp(),
  `jumlah_retur` int(11) NOT NULL,
  `alasan` text NOT NULL,
  `status_retur` enum('diajukan','disetujui','ditolak','selesai') NOT NULL DEFAULT 'diajukan',
  `keputusan_admin` text DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `stok`
--

CREATE TABLE `stok` (
  `id_stok` int(10) UNSIGNED NOT NULL,
  `id_produk` int(10) UNSIGNED NOT NULL,
  `jumlah_stok` int(11) NOT NULL DEFAULT 0,
  `stok_minimum` int(11) NOT NULL DEFAULT 0,
  `update_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(10) UNSIGNED NOT NULL,
  `nama_supplier` varchar(100) NOT NULL,
  `alamat_supplier` text DEFAULT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier_produk`
--

CREATE TABLE `supplier_produk` (
  `id_supplier_produk` int(10) UNSIGNED NOT NULL,
  `id_supplier` int(10) UNSIGNED NOT NULL,
  `id_produk` int(10) UNSIGNED NOT NULL,
  `harga_beli` decimal(12,2) NOT NULL,
  `waktu_penyediaan` int(11) NOT NULL DEFAULT 0
) ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(10) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `role` enum('admin','pelanggan') NOT NULL DEFAULT 'pelanggan',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `alamat`
--
ALTER TABLE `alamat`
  ADD PRIMARY KEY (`id_alamat`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id_bank`);

--
-- Indeks untuk tabel `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id_brand`);

--
-- Indeks untuk tabel `detail_keranjang`
--
ALTER TABLE `detail_keranjang`
  ADD PRIMARY KEY (`id_detail_keranjang`),
  ADD UNIQUE KEY `id_keranjang` (`id_keranjang`,`id_produk`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indeks untuk tabel `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  ADD PRIMARY KEY (`id_detail_pembelian`),
  ADD KEY `id_pembelian` (`id_pembelian`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indeks untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_detail_pesanan`),
  ADD KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indeks untuk tabel `ekspedisi`
--
ALTER TABLE `ekspedisi`
  ADD PRIMARY KEY (`id_ekspedisi`),
  ADD UNIQUE KEY `nama_ekspedisi` (`nama_ekspedisi`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_keranjang`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD UNIQUE KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `id_bank` (`id_bank`);

--
-- Indeks untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id_pembelian`),
  ADD KEY `id_supplier` (`id_supplier`);

--
-- Indeks untuk tabel `pengiriman`
--
ALTER TABLE `pengiriman`
  ADD PRIMARY KEY (`id_pengiriman`),
  ADD UNIQUE KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `id_ekspedisi` (`id_ekspedisi`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_alamat` (`id_alamat`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `id_kategori` (`id_kategori`),
  ADD KEY `id_brand` (`id_brand`);

--
-- Indeks untuk tabel `retur_produk`
--
ALTER TABLE `retur_produk`
  ADD PRIMARY KEY (`id_retur`),
  ADD KEY `id_detail_pesanan` (`id_detail_pesanan`);

--
-- Indeks untuk tabel `stok`
--
ALTER TABLE `stok`
  ADD PRIMARY KEY (`id_stok`),
  ADD UNIQUE KEY `id_produk` (`id_produk`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indeks untuk tabel `supplier_produk`
--
ALTER TABLE `supplier_produk`
  ADD PRIMARY KEY (`id_supplier_produk`),
  ADD UNIQUE KEY `id_supplier` (`id_supplier`,`id_produk`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `alamat`
--
ALTER TABLE `alamat`
  MODIFY `id_alamat` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `bank`
--
ALTER TABLE `bank`
  MODIFY `id_bank` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `brand`
--
ALTER TABLE `brand`
  MODIFY `id_brand` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `detail_keranjang`
--
ALTER TABLE `detail_keranjang`
  MODIFY `id_detail_keranjang` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  MODIFY `id_detail_pembelian` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id_detail_pesanan` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `ekspedisi`
--
ALTER TABLE `ekspedisi`
  MODIFY `id_ekspedisi` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_keranjang` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id_pembelian` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengiriman`
--
ALTER TABLE `pengiriman`
  MODIFY `id_pengiriman` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `retur_produk`
--
ALTER TABLE `retur_produk`
  MODIFY `id_retur` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `stok`
--
ALTER TABLE `stok`
  MODIFY `id_stok` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `supplier_produk`
--
ALTER TABLE `supplier_produk`
  MODIFY `id_supplier_produk` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `alamat`
--
ALTER TABLE `alamat`
  ADD CONSTRAINT `alamat_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_keranjang`
--
ALTER TABLE `detail_keranjang`
  ADD CONSTRAINT `detail_keranjang_ibfk_1` FOREIGN KEY (`id_keranjang`) REFERENCES `keranjang` (`id_keranjang`) ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_keranjang_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  ADD CONSTRAINT `detail_pembelian_ibfk_1` FOREIGN KEY (`id_pembelian`) REFERENCES `pembelian` (`id_pembelian`) ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_pembelian_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `detail_pesanan_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_pesanan_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `keranjang_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pembayaran_ibfk_2` FOREIGN KEY (`id_bank`) REFERENCES `bank` (`id_bank`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `pembelian_ibfk_1` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pengiriman`
--
ALTER TABLE `pengiriman`
  ADD CONSTRAINT `pengiriman_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pengiriman_ibfk_2` FOREIGN KEY (`id_ekspedisi`) REFERENCES `ekspedisi` (`id_ekspedisi`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pesanan_ibfk_2` FOREIGN KEY (`id_alamat`) REFERENCES `alamat` (`id_alamat`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON UPDATE CASCADE,
  ADD CONSTRAINT `produk_ibfk_2` FOREIGN KEY (`id_brand`) REFERENCES `brand` (`id_brand`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `retur_produk`
--
ALTER TABLE `retur_produk`
  ADD CONSTRAINT `retur_produk_ibfk_1` FOREIGN KEY (`id_detail_pesanan`) REFERENCES `detail_pesanan` (`id_detail_pesanan`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `stok`
--
ALTER TABLE `stok`
  ADD CONSTRAINT `stok_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `supplier_produk`
--
ALTER TABLE `supplier_produk`
  ADD CONSTRAINT `supplier_produk_ibfk_1` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`) ON UPDATE CASCADE,
  ADD CONSTRAINT `supplier_produk_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
