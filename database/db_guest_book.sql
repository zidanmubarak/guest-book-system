-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Apr 2025 pada 02.03
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
-- Database: `db_guest_book`
--
CREATE DATABASE IF NOT EXISTS `db_guest_book` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_guest_book`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_acara`
--

CREATE TABLE `tbl_acara` (
  `id` int(11) NOT NULL,
  `nama_acara` varchar(255) NOT NULL,
  `tanggal` datetime NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `penyelenggara` varchar(255) NOT NULL,
  `kapasitas` int(11) NOT NULL DEFAULT 0,
  `poster` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `user_nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `tbl_acara`
--

INSERT INTO `tbl_acara` (`id`, `nama_acara`, `tanggal`, `lokasi`, `deskripsi`, `penyelenggara`, `kapasitas`, `poster`, `created_at`, `updated_at`, `user_id`, `user_nama`) VALUES
(7, 'KEMERDEKAAN INDONESIA', '2025-08-17 06:12:00', 'JAKARTA', 'HARI KEMERDEKAAN INDONESIA', 'MASYARAKAT INDONESIA', 10, 'kemerdekaan_indonesia.jpg', '2025-04-01 18:12:42', NULL, 5, 'Administrator');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_bagian`
--

CREATE TABLE `tbl_bagian` (
  `id` int(11) NOT NULL,
  `nama_bagian` varchar(100) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `tbl_bagian`
--

INSERT INTO `tbl_bagian` (`id`, `nama_bagian`, `status`) VALUES
(2, 'Main Office', '1'),
(3, 'Gudang Sentral', '1'),
(4, 'Gedung  Depan', '1'),
(5, 'Gudang Belakang', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_jabatan`
--

CREATE TABLE `tbl_jabatan` (
  `id` int(11) NOT NULL,
  `nama_jabatan` varchar(100) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `tbl_jabatan`
--

INSERT INTO `tbl_jabatan` (`id`, `nama_jabatan`, `status`) VALUES
(1, 'Ketua', '1'),
(2, 'Anggota', '1'),
(3, 'Manajer', '1'),
(4, 'Supervisor', '1'),
(5, 'Staff', '1'),
(6, 'Cleaning Service', '0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_kartu_tamu`
--

CREATE TABLE `tbl_kartu_tamu` (
  `id` int(11) NOT NULL,
  `id_tamu` int(11) NOT NULL,
  `serial_kartu` varchar(100) NOT NULL,
  `tgl_dipakai` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_dikembalikan` datetime DEFAULT NULL,
  `status` enum('y','n') NOT NULL DEFAULT 'y'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tbl_kartu_tamu`
--

INSERT INTO `tbl_kartu_tamu` (`id`, `id_tamu`, `serial_kartu`, `tgl_dipakai`, `tgl_dikembalikan`, `status`) VALUES
(21, 17, '1234567889', '2025-04-02 06:11:51', '2025-04-02 06:20:37', 'n');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_kategori_peserta`
--

CREATE TABLE `tbl_kategori_peserta` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL,
  `kode` varchar(20) NOT NULL,
  `warna` varchar(20) DEFAULT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `tbl_kategori_peserta`
--

INSERT INTO `tbl_kategori_peserta` (`id`, `nama_kategori`, `kode`, `warna`, `status`) VALUES
(1, 'Umum', 'umum', '#777777', '1'),
(2, 'VIP', 'vip', '#3c8dbc', '1'),
(3, 'Pembicara', 'pembicara', '#00a65a', '1'),
(4, 'Panitia', 'panitia', '#f39c12', '1'),
(5, 'Media', 'media', '#605ca8', '1'),
(6, 'Sponsor', 'sponsor', '#dd4b39', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_lampiran`
--

CREATE TABLE `tbl_lampiran` (
  `id` int(11) NOT NULL,
  `id_tamu` int(11) NOT NULL,
  `file` varchar(100) NOT NULL,
  `tgl_upload` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_log_checkin`
--

CREATE TABLE `tbl_log_checkin` (
  `id` int(11) NOT NULL,
  `peserta_id` int(11) NOT NULL,
  `acara_id` int(11) NOT NULL,
  `waktu` datetime NOT NULL,
  `status` enum('success','failed') NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_paket_surat`
--

CREATE TABLE `tbl_paket_surat` (
  `id` int(11) NOT NULL,
  `asal_surat` varchar(100) NOT NULL,
  `tujuan` varchar(50) NOT NULL,
  `nama_penerima` varchar(150) NOT NULL,
  `isi_paket` varchar(200) NOT NULL,
  `photo` varchar(150) NOT NULL,
  `tgl_simpan` datetime NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `nama_user` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pegawai`
--

CREATE TABLE `tbl_pegawai` (
  `id` int(11) NOT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `bagian` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `status` enum('aktif','block') NOT NULL DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `tbl_pegawai`
--

INSERT INTO `tbl_pegawai` (`id`, `nip`, `nama`, `jabatan`, `bagian`, `no_hp`, `status`) VALUES
(1, '220705000', 'FAJAR', 'Manajer', 'Main Office', '081234567890', 'aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_peserta`
--

CREATE TABLE `tbl_peserta` (
  `id` int(11) NOT NULL,
  `acara_id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `institusi` varchar(100) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `kategori` enum('umum','vip','pembicara','panitia','media','sponsor') NOT NULL DEFAULT 'umum',
  `kode_undangan` varchar(20) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status_hadir` tinyint(1) NOT NULL DEFAULT 0,
  `waktu_checkin` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `user_nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `tbl_peserta`
--

INSERT INTO `tbl_peserta` (`id`, `acara_id`, `nama`, `email`, `no_hp`, `institusi`, `jabatan`, `kategori`, `kode_undangan`, `foto`, `status_hadir`, `waktu_checkin`, `created_at`, `user_id`, `user_nama`) VALUES
(7, 7, 'kelompok 3', 'kelompok3@gmail.com', '081234564321', 'INDONESIA', 'PANITIA', 'vip', '222704AA', 'foto_kelompok-3_peserta_2025-04-02.jpeg', 0, NULL, '2025-04-01 18:13:34', 5, 'Administrator');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_preregistrasi`
--

CREATE TABLE `tbl_preregistrasi` (
  `id` int(11) NOT NULL,
  `acara_id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `institusi` varchar(100) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `kode_registrasi` varchar(20) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_role`
--

CREATE TABLE `tbl_role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `role_desc` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `tbl_role`
--

INSERT INTO `tbl_role` (`role_id`, `role_name`, `role_desc`) VALUES
(1, 'Administrator', 'Full system access'),
(2, 'Petugas', 'Event registration and check-in only');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_tamu`
--

CREATE TABLE `tbl_tamu` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `jenkel` varchar(2) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `tujuan` varchar(200) NOT NULL,
  `tgl_datang` datetime NOT NULL DEFAULT current_timestamp(),
  `keperluan` text NOT NULL,
  `nama_tujuan` varchar(100) NOT NULL,
  `photo` varchar(150) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama_user` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tbl_tamu`
--

INSERT INTO `tbl_tamu` (`id`, `nama`, `alamat`, `jenkel`, `no_hp`, `tujuan`, `tgl_datang`, `keperluan`, `nama_tujuan`, `photo`, `user_id`, `nama_user`) VALUES
(17, 'kelompok3', 'domisili mana', 'L', '081234564321', 'Main Office', '2025-04-02 06:11:51', 'Tidak Ada', '1', 'foto_kelompok3_tamu_2025-04-02.jpeg', 5, '5');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenkel` enum('L','P') NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nohp` varchar(20) NOT NULL,
  `level` enum('1','2') NOT NULL DEFAULT '2',
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `nama`, `jenkel`, `username`, `password`, `email`, `nohp`, `level`, `photo`, `created_at`, `last_login`) VALUES
(5, 'Administrator', 'L', 'admin', '0192023a7bbd73250516f069df18b500', 'admin@example.com', '08123456789', '1', '', '2025-03-30 06:19:45', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_acara`
--
ALTER TABLE `tbl_acara`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_bagian`
--
ALTER TABLE `tbl_bagian`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_jabatan`
--
ALTER TABLE `tbl_jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_kartu_tamu`
--
ALTER TABLE `tbl_kartu_tamu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_kategori_peserta`
--
ALTER TABLE `tbl_kategori_peserta`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_lampiran`
--
ALTER TABLE `tbl_lampiran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_log_checkin`
--
ALTER TABLE `tbl_log_checkin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peserta_id` (`peserta_id`),
  ADD KEY `acara_id` (`acara_id`);

--
-- Indeks untuk tabel `tbl_paket_surat`
--
ALTER TABLE `tbl_paket_surat`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_pegawai`
--
ALTER TABLE `tbl_pegawai`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_peserta`
--
ALTER TABLE `tbl_peserta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_undangan` (`kode_undangan`),
  ADD KEY `acara_id` (`acara_id`);

--
-- Indeks untuk tabel `tbl_preregistrasi`
--
ALTER TABLE `tbl_preregistrasi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_registrasi` (`kode_registrasi`),
  ADD KEY `acara_id` (`acara_id`);

--
-- Indeks untuk tabel `tbl_role`
--
ALTER TABLE `tbl_role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indeks untuk tabel `tbl_tamu`
--
ALTER TABLE `tbl_tamu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_acara`
--
ALTER TABLE `tbl_acara`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tbl_bagian`
--
ALTER TABLE `tbl_bagian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tbl_jabatan`
--
ALTER TABLE `tbl_jabatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tbl_kartu_tamu`
--
ALTER TABLE `tbl_kartu_tamu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `tbl_kategori_peserta`
--
ALTER TABLE `tbl_kategori_peserta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tbl_lampiran`
--
ALTER TABLE `tbl_lampiran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tbl_log_checkin`
--
ALTER TABLE `tbl_log_checkin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_paket_surat`
--
ALTER TABLE `tbl_paket_surat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_pegawai`
--
ALTER TABLE `tbl_pegawai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tbl_peserta`
--
ALTER TABLE `tbl_peserta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tbl_preregistrasi`
--
ALTER TABLE `tbl_preregistrasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_role`
--
ALTER TABLE `tbl_role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tbl_tamu`
--
ALTER TABLE `tbl_tamu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tbl_log_checkin`
--
ALTER TABLE `tbl_log_checkin`
  ADD CONSTRAINT `tbl_log_checkin_ibfk_1` FOREIGN KEY (`peserta_id`) REFERENCES `tbl_peserta` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_log_checkin_ibfk_2` FOREIGN KEY (`acara_id`) REFERENCES `tbl_acara` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_peserta`
--
ALTER TABLE `tbl_peserta`
  ADD CONSTRAINT `tbl_peserta_ibfk_1` FOREIGN KEY (`acara_id`) REFERENCES `tbl_acara` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_preregistrasi`
--
ALTER TABLE `tbl_preregistrasi`
  ADD CONSTRAINT `tbl_preregistrasi_ibfk_1` FOREIGN KEY (`acara_id`) REFERENCES `tbl_acara` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
