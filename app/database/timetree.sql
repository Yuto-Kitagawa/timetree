-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2023-01-31 18:03:48
-- サーバのバージョン： 10.4.27-MariaDB
-- PHP のバージョン: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `test`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `timetree`
--

CREATE TABLE `timetree` (
  `id` varchar(255) NOT NULL,
  `title` varchar(64) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `timetree`
--

INSERT INTO `timetree` (`id`, `title`, `start_time`, `end_time`) VALUES
('1564d423b6df413c89c5958d208cf40b', 'ゼミ発表(聞くだけ)', '2023-01-31 13:30:00', '2023-01-31 17:30:00'),
('2199a9f743f44f8380d32cd895bd3f9f', 'プレゼン最終調整', '2023-02-01 09:30:00', '2023-02-01 12:30:00'),
('b58df9c6b63a4ae69a26b023f81b93ba', 'ともと昼ごはん', '2023-02-02 09:00:00', '2023-02-02 09:00:00'),
('bf394e00fb054f18bf7bf226263f890c', '松本さんに電話', '2023-01-31 12:30:00', '2023-01-31 13:30:00'),
('e54f6be43a754d41a58efad9e3d42623', '卒制発表', '2023-02-03 09:30:00', '2023-02-03 12:30:00'),
('ea847d5bdaa44c41a86d8706b7a74230', 'ともとドライブ', '2023-02-06 09:00:00', '2023-02-06 09:00:00');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `timetree`
--
ALTER TABLE `timetree`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
