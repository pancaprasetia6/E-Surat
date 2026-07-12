-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2025 at 08:03 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sim-surat`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_request_skd`
--

CREATE TABLE `data_request_skd` (
  `id_request_skd` int(11) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `tanggal_request` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `scan_ktp` text NOT NULL,
  `scan_kk` text NOT NULL,
  `keperluan` varchar(20) NOT NULL,
  `keterangan` varchar(50) NOT NULL DEFAULT 'Data sedang diperiksa oleh Staf',
  `request` varchar(20) NOT NULL DEFAULT 'DOMISILI',
  `status` int(11) NOT NULL DEFAULT '0',
  `acc` date NOT NULL,
  `no_surat` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_request_skd`
--

INSERT INTO `data_request_skd` (`id_request_skd`, `nik`, `tanggal_request`, `scan_ktp`, `scan_kk`, `keperluan`, `keterangan`, `request`, `status`, `acc`, `no_surat`) VALUES
(1, '1212', '2025-03-17 04:18:24', '20797.jpg', '23858.jpg', 'Sekolah', 'Surat dicetak, bisa diambil!', 'DOMISILI', 3, '2025-03-17', '120');

-- --------------------------------------------------------

--
-- Table structure for table `data_request_skp`
--

CREATE TABLE `data_request_skp` (
  `id_request_skp` int(11) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `tanggal_request` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `scan_ktp` text NOT NULL,
  `scan_kk` text NOT NULL,
  `keperluan` varchar(30) NOT NULL,
  `keterangan` varchar(50) NOT NULL DEFAULT 'Data sedang diperiksa oleh Staf',
  `request` varchar(20) NOT NULL DEFAULT 'LAINNYA',
  `status` int(11) NOT NULL DEFAULT '0',
  `acc` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data_request_sktm`
--

CREATE TABLE `data_request_sktm` (
  `id_request_sktm` int(11) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `tanggal_request` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `scan_ktp` text NOT NULL,
  `scan_kk` text NOT NULL,
  `keperluan` varchar(30) NOT NULL,
  `request` varchar(20) NOT NULL DEFAULT 'TIDAK MAMPU',
  `keterangan` varchar(50) NOT NULL DEFAULT 'Data sedang diperiksa oleh Staf',
  `status` int(11) NOT NULL DEFAULT '0',
  `acc` date NOT NULL,
  `no_surat` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_request_sktm`
--

INSERT INTO `data_request_sktm` (`id_request_sktm`, `nik`, `tanggal_request`, `scan_ktp`, `scan_kk`, `keperluan`, `request`, `keterangan`, `status`, `acc`, `no_surat`) VALUES
(51, '1212', '2025-03-16 23:50:18', '11462.jpg', '5255.jpg', 'Bantuan Anak Sekolah', 'TIDAK MAMPU', 'Surat dicetak, bisa diambil!', 3, '2025-03-17', '12');

-- --------------------------------------------------------

--
-- Table structure for table `data_request_sku`
--

CREATE TABLE `data_request_sku` (
  `id_request_sku` int(11) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `tanggal_request` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `scan_ktp` text NOT NULL,
  `scan_kk` text NOT NULL,
  `usaha` varchar(30) NOT NULL,
  `keperluan` varchar(30) NOT NULL,
  `keterangan` varchar(50) NOT NULL DEFAULT 'Data sedang diperiksa oleh Staf',
  `request` varchar(20) NOT NULL DEFAULT 'USAHA',
  `status` int(11) NOT NULL DEFAULT '0',
  `acc` date NOT NULL,
  `no_surat` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_request_sku`
--

INSERT INTO `data_request_sku` (`id_request_sku`, `nik`, `tanggal_request`, `scan_ktp`, `scan_kk`, `usaha`, `keperluan`, `keterangan`, `request`, `status`, `acc`, `no_surat`) VALUES
(10, '1212', '2025-03-17 00:28:22', '9688.jpg', '7473.jpg', 'Ternak Ayam', 'Program Bantuan', 'Surat dicetak, bisa diambil!', 'USAHA', 3, '2025-03-17', '45');

-- --------------------------------------------------------

--
-- Table structure for table `data_user`
--

CREATE TABLE `data_user` (
  `nik` varchar(16) NOT NULL,
  `password` varchar(225) NOT NULL,
  `hak_akses` varchar(225) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `tempat_lahir` varchar(30) NOT NULL,
  `jekel` varchar(20) NOT NULL,
  `agama` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `telepon` varchar(13) NOT NULL,
  `status_warga` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_user`
--

INSERT INTO `data_user` (`nik`, `password`, `hak_akses`, `nama`, `tanggal_lahir`, `tempat_lahir`, `jekel`, `agama`, `alamat`, `telepon`, `status_warga`) VALUES
('1212', 'kasep', 'Pemohon', 'Kasep', '2003-03-05', 'Konoha', 'Laki-Laki', 'Islam', ' Konoha Wakanda Selatan', '0865656565656', 'Kerja'),
('123', '123', 'Staf', 'Staf', '1999-03-10', 'Konoha Selatan', 'Laki-Laki', '', 'Konoha Selatan Wakanda', '', 'Kerja'),
('34', '123', 'Lurah', 'Putra Lurah', '1991-02-14', 'Konoha', 'Laki-Laki', '', 'Komnoha Wakanda Selatan', '', 'Kerja');

-- --------------------------------------------------------

--
-- Table structure for table `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id_pengumuman` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `poto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengumuman`
--

INSERT INTO `pengumuman` (`id_pengumuman`, `judul`, `isi`, `poto`) VALUES
(1, 'OPEN RECRUITMENT CALON PERANGKAT DESA', 'Lowongan Kerja 2 (dua) Orang Perangkat Desa Sebagai :\r\n\r\n    Perangkat Desa Pelaksana Kewilayahan / Kepala Dusun Binangun Desa Kondangjajar\r\n    Staf Pelaksana / Operator Kepala Urusan Keuangan Desa Kondangjajar\r\n\r\nAdapun syarat-syaratnya adalah sebagai berikut :\r\n\r\nBakal Calon Perangkat Desa Pelaksana Kewilayahan Dusun Binangun Desa Kondangjajar\r\n\r\n1. Bertaqwa kepada Tuhan Yang Maha Esa, yang dibuktikan dengan surat pernyataan bertaqwa kepada Tuhan Yang Maha Esa yang dibuat oleh yang bersangkutan di atas kertas segel atau bermaterai cukup (Formulir Disediakan Panitia).\r\n2. Setia kepada Pancasila sebagai Dasar Negara, Undang-Undang Dasar Negara Republik Indonesia Tahun 1945, Negara Kesatuan Republik Indonesia serta Pemerintah, yang dibuktikan dengan surat pernyataan yang dibuat oleh yang bersangkutan di atas kertas segel atau bermaterai cukup (Formulir Disediakan Panitia);\r\n3. Berpendidikan paling rendah Sekolah Menengah Umum atau Sederajat, yang dibuktikan dengan Ijazah / Surat Tanda Tamat Belajar (STTB) pendidikan formal dari tingkat dasar sampai dengan Ijazah / Surat Tanda Tamat Belajar (STTB) terakhir yang dilegalisir oleh pejabat yang berwenang;\r\n4. Berusia paling rendah 20 (dua puluh) tahun dan paling tinggi 42 (empat puluh dua) tahun, dibuktikan dengan Akta Kelahiran atau alat keterangan pembuktian kelahiran yang lain yang dilegalisir oleh pejabat yang berwenang, terhitung pada saat Penutupan Pendaftaran;\r\n5. Terdaftar sebagai Warga Negara Indonesia dan berasal dari serta bertempat tinggal tetap di Dusun Binangun Desa Kondangjajar dibuktikan dengan Kartu Tanda Penduduk (KTP) dan Kartu Keluarga (KK);\r\n6. Mengenal desanya dan dikenal oleh masyarakat Desa atau Dusun setempat yang dibuktikan dengan surat pernyataan yang dibuat oleh yang bersangkutan di atas kertas segel atau bermaterai cukup ditandatangani oleh RT, RW setempat dan diketahui Kepala Desa (Formulir Disediakan Panitia);\r\n7. Bersedia bertempat tinggal tetap di Desa Kondangjajar setelah ditetapkan menjadi perangkat desa, dibuktikan dengan surat pernyataan yang dibuat oleh yang bersangkutan di atas kertas segel atau bermaterai cukup (Formulir Disediakan Panitia);\r\n8. Sehat jasmani dan rohani, dibuktikan dengan Surat Keterangan dari Dokter Pemerintah;\r\n9. Berkelakuan baik, dibuktikan dengan Surat Keterangan Catatan Kepolisian atau Keterangan lain dari Kepolisaian Republik Indonesia (Polres);\r\n10. Tidak pernah dihukum karena melakukan tindak pidana kejahatan dengan hukuman paling singkat 5 (lima) tahun dengan dibuktikan surat keterangan dari Pengadilan Negeri;\r\n11. Tidak menggunakan narkotika dan obat-obat terlarang yang dibuktikan dengan surat keterangan bebas narkoba dari intansi yang berwenang (Labkesda);\r\n12. Tidak menjadi pengurus partai politik dan anggota atau pengurus organisasi terlarang yang dibuktikan dengan surat pernyataan yang dibuat oleh yang bersangkutan di atas kertas segel atau bermaterai cukup (Formulir Disediakan Panitia);\r\n13. Bagi Pegawai Negeri Sipil (PNS) yang akan mencalonkan menjadi Perangkat Desa, disamping memenuhi syarat sebagaimana dimaksud diatas, juga harus mendapatkan izin tertulis dari Pejabat Pembina Kepegawaian.\r\n14. Dalam hal Pegawai Negeri Sipil (PNS) yang diangkat menjadi Perangkat Desa, dibebaskan untuk sementara dari jabatannya tanpa kehilangan statusnya sebagai Pegawai Negeri Sipil (PNS).\r\n15. Bagi Bakal Calon Perangkat Desa yang berasal dari Anggota BPD disamping memenuhi syarat sebagaimana dimaksud diatas wajib mengundurkan diri dari keanggotaan BPD paling lambat pada saat mendaftarkan diri;\r\n\r\nPendaftaran  mulai  tanggal  19 s/d  30 Januari 2023 Pukul 08.00 WIB s/d 15.00 WIB setiap hari kerja di Kantor Desa Kondangjajar.\r\n\r\nBagi yang berminat segera mendaftar, untuk persyaratan lebih lengkap bisa ditanyakan pada Panitia dengan datang langsung ke Kantor Desa Kondangjajar.\r\n\r\nContact Person :\r\n0999999999999999 - asasasasasasa\r\n0888888888888888- tytytytytytytyt', '30603.jpg'),
(2, 'Pengumuman Lomba Desa Bersinar', 'Berdasarkan tahapan Lomba, dari mulai Surat Pemberitahuan Kepada BNNK/BNK se - DIY  tanggal 3 Juni 2024, Pengumpulan  Data Dukung, Seleksi Data Dukung oleh Tim Penilai, Kunjungan Lapangan Tim Penilai, Rapat Penentuan Pemenang dan Pengumuman Pemenang Lomba Desa Bersinar Tingkat DIY Dalam Rangka HANI 2024 oleh Panitia Melalui Surat Pemberitahuan Resmi dan Media Sosial BNNP DIY. Terkait dengan hal tersebut di atas, berdasarkan Keputusan Tim Juri Lomba Desa Bersinar DIY Tahun 2024,  hasil penilaian Tim Lomba Desa Bersinar dengan mempertimbangkan aspek penilaian , sebagai berikut :\r\n- Komitmen dan Kebijakan P4GN dari Lurah\r\n- Dukungan Anggaran P4GN Desa Bersinar.\r\n- Program P4GN di Desa Bersinar.\r\n- Media Sosial Desa Bersinar untuk Informasi Edukasi P4GN\r\n- Kegiatan P4GN berdasar Kearifan Lokal.\r\nDan Tinjauan Langsung ke Lapangan,\r\nDari proses penilaian maka diperoleh hasil, sebagai berikut :\r\n*JUARA I* : Kalurahan Condongcatur, Kab. Sleman\r\n*JUARA II* : Kalurahan Trirenggo, Kab. Bantul\r\n*JUARA III* : Kalurahan Bangunjiwo, Kab. Bantul\r\n\r\n*JUARA HARAPAN I* : Kalurahan Sariharjo, Kab. Sleman\r\n*JUARA HARAPAN II*: Kalurahan Wonosari, Kab.  Gunungkidul.', '23290.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `profil`
--

CREATE TABLE `profil` (
  `id_profil` int(11) NOT NULL,
  `text` text NOT NULL,
  `poto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profil`
--

INSERT INTO `profil` (`id_profil`, `text`, `poto`) VALUES
(1, 'Desa merupakan ujung tombak dalam penyelenggaraan pembangunan daerah yang berkelanjutan. Kesejahteraan desa menjadi indikator penting dalam perencanaan dan pembangunan wilayah. Oleh karena itu, pemerintah daerah perlu memahami potensi yang dimiliki setiap desa agar setiap kebijakan dan program pembangunan dapat berjalan tepat guna dan sasaran.\r\n\r\nPotensi desa dapat disajikan dalam berbagai bentuk, seperti data, dokumen, atau peta potensi desa. Profil desa berfungsi sebagai integrasi informasi yang mencakup potensi sumber daya alam, sumber daya manusia, kelembagaan, serta sarana dan prasarana desa. Penyajian informasi yang informatif dan aplikatif ini tidak hanya berguna untuk pembangunan desa, tetapi juga bagi seluruh pihak yang berkepentingan, termasuk pemerintah daerah.\r\n\r\nData profil desa diharapkan dapat menjadi dasar dalam perencanaan pembangunan yang lebih terarah, serta memberikan dampak positif terhadap kesejahteraan masyarakat desa. Selain itu, profil desa juga menjadi informasi penting bagi pemerintah daerah, provinsi, dan nasional dalam menetapkan kebijakan yang tepat. Kebijakan tersebut mencakup intervensi dan pemanfaatan data untuk menciptakan pembangunan desa yang berkesinambungan.\r\n\r\nDengan adanya profil desa yang jelas dan akurat, diharapkan perencanaan pembangunan dapat berjalan sinergis, menghindari tumpang tindih antara desa, pemerintah, dan lembaga terkait. Sehingga, terwujud satu data, satu informasi, dan satu solusi dalam pembangunan desa yang lebih maju dan berdaya saing.', '19208.jpg'),
(2, 'Profil kedua', 'foto2.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_request_skd`
--
ALTER TABLE `data_request_skd`
  ADD PRIMARY KEY (`id_request_skd`),
  ADD KEY `id_pemohon` (`nik`);

--
-- Indexes for table `data_request_skp`
--
ALTER TABLE `data_request_skp`
  ADD PRIMARY KEY (`id_request_skp`),
  ADD KEY `id_pemohon` (`nik`);

--
-- Indexes for table `data_request_sktm`
--
ALTER TABLE `data_request_sktm`
  ADD PRIMARY KEY (`id_request_sktm`),
  ADD KEY `id_pemohon` (`nik`);

--
-- Indexes for table `data_request_sku`
--
ALTER TABLE `data_request_sku`
  ADD PRIMARY KEY (`id_request_sku`),
  ADD KEY `id_pemohon` (`nik`);

--
-- Indexes for table `data_user`
--
ALTER TABLE `data_user`
  ADD PRIMARY KEY (`nik`);

--
-- Indexes for table `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id_pengumuman`);

--
-- Indexes for table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`id_profil`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_request_skd`
--
ALTER TABLE `data_request_skd`
  MODIFY `id_request_skd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `data_request_skp`
--
ALTER TABLE `data_request_skp`
  MODIFY `id_request_skp` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_request_sktm`
--
ALTER TABLE `data_request_sktm`
  MODIFY `id_request_sktm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `data_request_sku`
--
ALTER TABLE `data_request_sku`
  MODIFY `id_request_sku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id_pengumuman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `profil`
--
ALTER TABLE `profil`
  MODIFY `id_profil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `data_request_skd`
--
ALTER TABLE `data_request_skd`
  ADD CONSTRAINT `data_request_skd_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `data_user` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `data_request_skp`
--
ALTER TABLE `data_request_skp`
  ADD CONSTRAINT `data_request_skp_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `data_user` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `data_request_sktm`
--
ALTER TABLE `data_request_sktm`
  ADD CONSTRAINT `data_request_sktm_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `data_user` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `data_request_sku`
--
ALTER TABLE `data_request_sku`
  ADD CONSTRAINT `data_request_sku_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `data_user` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
