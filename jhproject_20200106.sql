-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 
-- 伺服器版本： 10.4.8-MariaDB
-- PHP 版本： 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `jhproject`
--

-- --------------------------------------------------------

--
<<<<<<< HEAD
-- 資料表結構 `messagelike`
--

CREATE TABLE `messagelike` (
  `l_id` int(12) NOT NULL,
  `m_id` int(12) NOT NULL,
  `u_ID` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- 傾印資料表的資料 `messagelike`
--

INSERT INTO `messagelike` (`l_id`, `m_id`, `u_ID`) VALUES
(36, 14, 96),
(37, 14, 99);

-- --------------------------------------------------------

--
=======
>>>>>>> origin/master
-- 資料表結構 `messages`
--

CREATE TABLE `messages` (
  `m_id` int(12) NOT NULL,
  `m_title` varchar(30) COLLATE utf8mb4_bin NOT NULL,
  `m_theme` varchar(10) COLLATE utf8mb4_bin NOT NULL,
  `m_message` varchar(256) COLLATE utf8mb4_bin NOT NULL,
  `u_ID` int(12) NOT NULL,
<<<<<<< HEAD
  `m_like` int(12) NOT NULL DEFAULT 0,
=======
>>>>>>> origin/master
  `rem` int(12) NOT NULL DEFAULT 0,
  `m_createtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `m_uptime` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- 傾印資料表的資料 `messages`
--

<<<<<<< HEAD
INSERT INTO `messages` (`m_id`, `m_title`, `m_theme`, `m_message`, `u_ID`, `m_like`, `rem`, `m_createtime`, `m_uptime`) VALUES
(14, '測試留言板功能', '有趣', '測試留言板功能', 96, 2, 5, '2020-01-03 20:51:13', '2020-01-06 04:51:18'),
(15, '測試留言板搜尋功能', '電影', '測試留言板搜尋功能', 96, 0, 0, '2020-01-03 21:07:57', '2020-01-04 05:07:57'),
(16, '20200106', '電影', '20200106', 96, 0, 0, '2020-01-05 18:03:22', '2020-01-06 02:03:22'),
(17, '歡迎來到美食版', '美食', '歡迎來到美食版', 96, 2, 0, '2020-01-05 18:22:08', '2020-01-06 03:11:00'),
(18, '歡迎來到閒聊版', '閒聊', '歡迎來到閒聊版', 96, 0, 0, '2020-01-05 18:22:40', '2020-01-06 02:22:40');
=======
INSERT INTO `messages` (`m_id`, `m_title`, `m_theme`, `m_message`, `u_ID`, `rem`, `m_createtime`, `m_uptime`) VALUES
(14, '測試留言板功能', '有趣', '測試留言板功能', 96, 5, '2020-01-03 20:51:13', '2020-01-04 04:52:49'),
(15, '測試留言板搜尋功能', '電影', '測試留言板搜尋功能', 96, 0, '2020-01-03 21:07:57', '2020-01-04 05:07:57');
>>>>>>> origin/master

-- --------------------------------------------------------

--
-- 資料表結構 `remessages`
--

CREATE TABLE `remessages` (
  `rem_id` int(12) NOT NULL,
  `rem_message` varchar(60) COLLATE utf8mb4_bin NOT NULL,
  `m_id` int(12) NOT NULL,
  `u_ID` int(12) NOT NULL,
  `rem_floor` int(12) NOT NULL DEFAULT 0,
  `rem_createtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `rem_uptime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- 傾印資料表的資料 `remessages`
--

INSERT INTO `remessages` (`rem_id`, `rem_message`, `m_id`, `u_ID`, `rem_floor`, `rem_createtime`, `rem_uptime`) VALUES
(91, '測試留言樓層', 14, 96, 1, '2020-01-03 20:52:07', '2020-01-04 04:52:07'),
(92, '測試留言樓層', 14, 96, 2, '2020-01-03 20:52:15', '2020-01-04 04:52:15'),
(93, '測試留言樓層', 14, 96, 3, '2020-01-03 20:52:20', '2020-01-04 04:52:20'),
(94, '測試留言樓層', 14, 96, 4, '2020-01-03 20:52:26', '2020-01-04 04:52:26'),
(95, '測試留言樓層', 14, 96, 5, '2020-01-03 20:52:49', '2020-01-04 04:52:49');

-- --------------------------------------------------------

--
-- 資料表結構 `userdata`
--

CREATE TABLE `userdata` (
  `u_ID` int(11) NOT NULL COMMENT '會員資料主鍵',
  `u_username` varchar(32) CHARACTER SET utf8 NOT NULL COMMENT '帳號',
  `u_password` varchar(32) CHARACTER SET utf8 NOT NULL COMMENT '密碼',
  `u_phone` varchar(15) CHARACTER SET utf8 NOT NULL COMMENT '電話',
  `u_email` varchar(32) CHARACTER SET utf8 NOT NULL COMMENT '信箱',
  `u_name` varchar(32) CHARACTER SET utf8 NOT NULL COMMENT '暱稱',
  `u_level` tinyint(1) NOT NULL,
  `u_createtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='使用者資料表';

--
-- 傾印資料表的資料 `userdata`
--

INSERT INTO `userdata` (`u_ID`, `u_username`, `u_password`, `u_phone`, `u_email`, `u_name`, `u_level`, `u_createtime`) VALUES
<<<<<<< HEAD
(96, 'tonight912@gmail.com', '69cce14f763f1bfa149d8502ccf8b2c7', '0934188017', 'tonight912@gmail.com', '鈞紘', 0, '2020-01-03 12:58:45'),
(98, 'jyunhong005@gmail.com', '25d55ad283aa400af464c76d713c07ad', '0911111111', 'jyunhong005@gmail.com', 'JH', 0, '2020-01-05 20:49:54'),
(99, 'jyunhong001@gmail.com', '25d55ad283aa400af464c76d713c07ad', '0911111111', 'jyunhong001@gmail.com', 'JHY', 0, '2020-01-05 20:50:50');
=======
(96, 'tonight912@gmail.com', '69cce14f763f1bfa149d8502ccf8b2c7', '0934188017', 'tonight912@gmail.com', '鈞紘', 0, '2020-01-03 12:58:45');
>>>>>>> origin/master

--
-- 已傾印資料表的索引
--

--
<<<<<<< HEAD
-- 資料表索引 `messagelike`
--
ALTER TABLE `messagelike`
  ADD PRIMARY KEY (`l_id`);

--
=======
>>>>>>> origin/master
-- 資料表索引 `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`m_id`);

--
-- 資料表索引 `remessages`
--
ALTER TABLE `remessages`
  ADD PRIMARY KEY (`rem_id`);

--
-- 資料表索引 `userdata`
--
ALTER TABLE `userdata`
  ADD PRIMARY KEY (`u_ID`),
  ADD UNIQUE KEY `u_username` (`u_username`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
<<<<<<< HEAD
-- 使用資料表自動遞增(AUTO_INCREMENT) `messagelike`
--
ALTER TABLE `messagelike`
  MODIFY `l_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `messages`
--
ALTER TABLE `messages`
  MODIFY `m_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
=======
-- 使用資料表自動遞增(AUTO_INCREMENT) `messages`
--
ALTER TABLE `messages`
  MODIFY `m_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
>>>>>>> origin/master

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `remessages`
--
ALTER TABLE `remessages`
  MODIFY `rem_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `userdata`
--
ALTER TABLE `userdata`
  MODIFY `u_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '會員資料主鍵', AUTO_INCREMENT=100;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
