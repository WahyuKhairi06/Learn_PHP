-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Apr 2025 pada 14.29
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
-- Database: `uts_webpro`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `filename` varchar(128) NOT NULL,
  `filepath` varchar(128) NOT NULL,
  `filetype` varchar(128) NOT NULL,
  `filesize` int(11) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `files`
--

INSERT INTO `files` (`id`, `item_id`, `filename`, `filepath`, `filetype`, `filesize`, `uploaded_at`) VALUES
(12, 6, 'icon512.jpg', 'uploads/67fba71465039.jpg', 'image/jpeg', 12285, '2025-04-13 11:59:16'),
(14, 6, 'unand3.jpg', 'uploads/67fba7146603e.jpg', 'image/jpeg', 884514, '2025-04-13 11:59:16'),
(16, 7, 'Tugas Pengganti UTS Web Programming.pdf', 'uploads/67fba727e1296.pdf', 'application/pdf', 81383, '2025-04-13 11:59:35'),
(18, 6, '3.jpg', 'uploads/67fba776320ef_3.jpg', '', 0, '2025-04-13 12:00:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `description` varchar(128) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `items`
--

INSERT INTO `items` (`id`, `title`, `description`, `user_id`, `created_at`, `updated_at`) VALUES
(6, 'testing 1', 'testing Gambar', 1, '2025-04-13 11:59:16', '2025-04-13 11:59:16'),
(7, 'Testing File dokumen', 'dokumen', 1, '2025-04-13 11:59:35', '2025-04-13 11:59:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'Wahyu Khairi', 'wahyukhairi13@gmail.com', '$2y$10$QSlWcQLMGEz5Rc27iUl/d.IfftCttc3j47NRj17qTyFFSN3Jplpeq', '2025-04-12 23:16:30'),
(2, 'UTS', 'uts@gmail.com', '$2y$10$HNznXFD0r3hwb9b2S7YYy.gxBjLHz/vvkET0bLDBOsqeXwJU8IUdO', '2025-04-12 23:24:16'),
(3, 'Pe web', 'pe@gmail.com', '$2y$10$3K2M3nXSQQfmFnDHfSyl7uPivLSxuaSmRXIGEpjRaXg2GkI/tVrsK', '2025-04-13 06:34:41');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
