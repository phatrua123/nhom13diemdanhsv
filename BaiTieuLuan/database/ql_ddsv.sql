-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 03, 2024 lúc 12:33 PM
-- Phiên bản máy phục vụ: 10.4.27-MariaDB
-- Phiên bản PHP: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `ql_ddsv`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `diemdanh`
--

CREATE TABLE `diemdanh` (
  `DiemDanh` int(11) NOT NULL,
  `matkb` int(11) NOT NULL,
  `ngaydiemdanh` date NOT NULL,
  `comat` varchar(5) NOT NULL DEFAULT 'C',
  `vang` varchar(5) NOT NULL DEFAULT 'V',
  `ghichu` varchar(100) NOT NULL,
  `Masv` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `diemdanh`
--

INSERT INTO `diemdanh` (`DiemDanh`, `matkb`, `ngaydiemdanh`, `comat`, `vang`, `ghichu`, `Masv`) VALUES
(0, 1, '2024-05-16', 'C', '', 'Buổi học 1', 'R001'),
(2, 1, '2024-05-17', 'C', '', 'Buổi học 2', 'R002'),
(3, 2, '2024-05-02', 'C', '', 'Buổi học 1', 'R003'),
(4, 3, '2024-05-02', 'C', '', 'Buổi học 1', 'R004'),
(5, 4, '2024-05-02', 'C', '', 'Buổi học 1', 'R005'),
(6, 1, '2024-06-01', 'C', '', '', 'R001'),
(7, 1, '2024-06-01', 'C', '', '', 'R002'),
(8, 2, '2024-06-01', 'C', '', '', 'R003'),
(9, 2, '2024-06-01', 'C', '', '', 'R003'),
(10, 2, '2024-06-01', 'C', '', '', 'R003'),
(11, 3, '2024-06-01', 'C', '', '', 'R004'),
(12, 4, '2024-06-01', 'C', '', '', 'R005'),
(13, 4, '2024-06-01', 'C', '', '', 'R005'),
(14, 4, '2024-06-01', 'C', '', '', 'R005'),
(18, 3, '2024-06-02', 'C', '', '', 'R001'),
(58, 1, '2024-06-03', 'C', '', '', 'R001'),
(59, 2, '2024-06-03', 'C', '', '', 'R001'),
(60, 4, '2024-06-03', '', 'V', '', 'R005'),
(61, 3, '2024-06-03', '', 'V', '', 'R004');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giaovien`
--

CREATE TABLE `giaovien` (
  `Magv` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `name` varchar(150) NOT NULL,
  `ngaysinh` date NOT NULL,
  `gioitinh` varchar(15) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 3 COMMENT '1=Admin,2=Staff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `giaovien`
--

INSERT INTO `giaovien` (`Magv`, `email`, `name`, `ngaysinh`, `gioitinh`, `username`, `password`, `type`) VALUES
(1, 'tranvandiep.it@gmail.com', 'Tran Van', '1986-02-02', 'Nữ', 'tranvandiep', '123', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lop`
--

CREATE TABLE `lop` (
  `Malop` int(11) NOT NULL,
  `Mamh` int(11) NOT NULL,
  `Magv` int(11) NOT NULL,
  `TenLop` varchar(50) NOT NULL,
  `Thamgia` date NOT NULL,
  `Ketthuc` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `lop`
--

INSERT INTO `lop` (`Malop`, `Mamh`, `Magv`, `TenLop`, `Thamgia`, `Ketthuc`) VALUES
(1, 1, 1, 'Ngôn ngữ lập trình', '2024-05-15', '2024-05-31'),
(2, 2, 1, 'Thiết kế Web', '2024-05-01', '2024-05-31'),
(3, 3, 1, 'Lập trình web', '2024-05-01', '2024-05-31'),
(4, 4, 1, 'Hệ thống thông tin', '2024-05-01', '2024-05-31'),
(5, 5, 1, 'Lập trình mã nguồn mở', '2024-05-01', '2024-05-31');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `monhoc`
--

CREATE TABLE `monhoc` (
  `Mamh` int(11) NOT NULL,
  `Tenmh` varchar(50) NOT NULL,
  `session` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `monhoc`
--

INSERT INTO `monhoc` (`Mamh`, `Tenmh`, `session`) VALUES
(1, 'Lap Trinh C', 10),
(2, 'Bootstrap/jQuery', 6),
(3, 'HTML/CSS/JS', 10),
(4, 'SQL Server', 10),
(5, 'PHP/Laravel', 10);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sinhvien`
--

CREATE TABLE `sinhvien` (
  `Masv` varchar(20) NOT NULL,
  `Hotensv` varchar(50) NOT NULL,
  `GioiTinh` varchar(15) NOT NULL,
  `Diachi` varchar(150) NOT NULL,
  `Ngaysinh` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sinhvien`
--

INSERT INTO `sinhvien` (`Masv`, `Hotensv`, `GioiTinh`, `Diachi`, `Ngaysinh`) VALUES
('R001', 'Tran Van A', 'Nam', 'Ha Noi', '1999-03-06'),
('R002', 'Tran Van B', 'Nam', 'Nam Dinh', '1997-05-19'),
('R003', 'Tran Van C', 'Nam', 'Ha Nam', '1993-02-09'),
('R004', 'Tran Van D', 'Nam', 'Thai Binh', '1998-01-19'),
('R005', 'Tran Van E', 'Nam', 'Hung Yen', '1991-09-29'),
('R006', 'Nguyen Manh Phat', 'Nam', 'HCM', '2003-11-20');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thanhvienlop`
--

CREATE TABLE `thanhvienlop` (
  `Masv` varchar(20) NOT NULL,
  `Malop` int(11) NOT NULL,
  `Thamgia` date NOT NULL,
  `Ketthuc` date NOT NULL,
  `TongNgayNghi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `thanhvienlop`
--

INSERT INTO `thanhvienlop` (`Masv`, `Malop`, `Thamgia`, `Ketthuc`, `TongNgayNghi`) VALUES
('R001', 1, '2024-05-15', '2024-05-31', 0),
('R002', 1, '2024-05-15', '2024-05-31', 0),
('R003', 2, '2024-05-01', '2024-05-31', 0),
('R004', 3, '2024-05-01', '2024-05-31', 0),
('R005', 4, '2024-05-01', '2024-05-31', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thoikhoabieu`
--

CREATE TABLE `thoikhoabieu` (
  `matkb` int(11) NOT NULL,
  `Malop` int(11) NOT NULL,
  `ngaybatdau` date NOT NULL,
  `ngayketthuc` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `thoikhoabieu`
--

INSERT INTO `thoikhoabieu` (`matkb`, `Malop`, `ngaybatdau`, `ngayketthuc`) VALUES
(1, 1, '2024-05-15', '2024-05-31'),
(2, 2, '2024-05-01', '2024-05-31'),
(3, 3, '2024-05-01', '2024-05-31'),
(4, 4, '2024-05-01', '2024-05-31'),
(5, 5, '2024-05-01', '2024-05-31');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `diemdanh`
--
ALTER TABLE `diemdanh`
  ADD PRIMARY KEY (`DiemDanh`),
  ADD KEY `fk_thoikhoabieu_matkb` (`matkb`),
  ADD KEY `fk_sv_masv` (`Masv`);

--
-- Chỉ mục cho bảng `giaovien`
--
ALTER TABLE `giaovien`
  ADD PRIMARY KEY (`Magv`);

--
-- Chỉ mục cho bảng `lop`
--
ALTER TABLE `lop`
  ADD PRIMARY KEY (`Malop`),
  ADD KEY `fk_GiaoVien_magv` (`Magv`),
  ADD KEY `fk_MonHoc_Mamh` (`Mamh`);

--
-- Chỉ mục cho bảng `monhoc`
--
ALTER TABLE `monhoc`
  ADD PRIMARY KEY (`Mamh`);

--
-- Chỉ mục cho bảng `sinhvien`
--
ALTER TABLE `sinhvien`
  ADD PRIMARY KEY (`Masv`);

--
-- Chỉ mục cho bảng `thanhvienlop`
--
ALTER TABLE `thanhvienlop`
  ADD UNIQUE KEY `Masv` (`Masv`) USING BTREE,
  ADD KEY `fk_Lop_malop` (`Malop`);

--
-- Chỉ mục cho bảng `thoikhoabieu`
--
ALTER TABLE `thoikhoabieu`
  ADD PRIMARY KEY (`matkb`),
  ADD KEY `fk_thoikhoabieu_Lop_Malop` (`Malop`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `diemdanh`
--
ALTER TABLE `diemdanh`
  MODIFY `DiemDanh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT cho bảng `giaovien`
--
ALTER TABLE `giaovien`
  MODIFY `Magv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `lop`
--
ALTER TABLE `lop`
  MODIFY `Malop` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `monhoc`
--
ALTER TABLE `monhoc`
  MODIFY `Mamh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `thoikhoabieu`
--
ALTER TABLE `thoikhoabieu`
  MODIFY `matkb` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `diemdanh`
--
ALTER TABLE `diemdanh`
  ADD CONSTRAINT `fk_sv_masv` FOREIGN KEY (`Masv`) REFERENCES `sinhvien` (`Masv`),
  ADD CONSTRAINT `fk_thoikhoabieu_matkb` FOREIGN KEY (`matkb`) REFERENCES `thoikhoabieu` (`matkb`);

--
-- Các ràng buộc cho bảng `lop`
--
ALTER TABLE `lop`
  ADD CONSTRAINT `fk_GiaoVien_magv` FOREIGN KEY (`Magv`) REFERENCES `giaovien` (`Magv`),
  ADD CONSTRAINT `fk_MonHoc_Mamh` FOREIGN KEY (`Mamh`) REFERENCES `monhoc` (`Mamh`);

--
-- Các ràng buộc cho bảng `thanhvienlop`
--
ALTER TABLE `thanhvienlop`
  ADD CONSTRAINT `fk_Lop_malop` FOREIGN KEY (`Malop`) REFERENCES `lop` (`Malop`),
  ADD CONSTRAINT `fk_SinhVien_masv` FOREIGN KEY (`Masv`) REFERENCES `sinhvien` (`Masv`);

--
-- Các ràng buộc cho bảng `thoikhoabieu`
--
ALTER TABLE `thoikhoabieu`
  ADD CONSTRAINT `fk_thoikhoabieu_Lop_Malop` FOREIGN KEY (`Malop`) REFERENCES `lop` (`Malop`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
