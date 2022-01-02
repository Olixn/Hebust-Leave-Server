-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2021-11-07 14:33:27
-- 服务器版本： 5.6.50-log
-- PHP 版本： 7.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `wx`
--

-- --------------------------------------------------------

--
-- 表的结构 `tp_admin`
--

CREATE TABLE `tp_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tp_admin`
--

INSERT INTO `tp_admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'ffc5e0a34f57435a6a396ca369ae6607a2b1cb81');

-- --------------------------------------------------------

--
-- 表的结构 `tp_tasks`
--

CREATE TABLE `tp_tasks` (
  `id` int(11) NOT NULL,
  `openid` varchar(32) NOT NULL,
  `taskid` varchar(16) NOT NULL,
  `stuName` varchar(255) DEFAULT NULL,
  `type` int(1) DEFAULT '0' COMMENT '0事假1病假2''实习3其他',
  `healthy` varchar(255) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `regionText` varchar(255) DEFAULT NULL,
  `regionDetail` varchar(255) DEFAULT NULL,
  `startTime` datetime DEFAULT NULL,
  `endTime` datetime DEFAULT NULL,
  `phoneOne` varchar(11) DEFAULT NULL,
  `phoneTwo` varchar(11) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '0审核中1通过2完成',
  `admin` varchar(255) NOT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `tp_user`
--

CREATE TABLE `tp_user` (
  `id` int(11) NOT NULL,
  `openid` varchar(32) NOT NULL,
  `stuName` varchar(255) DEFAULT NULL,
  `stuNum` varchar(32) DEFAULT NULL,
  `stuClass` varchar(255) DEFAULT NULL,
  `stuUni` varchar(255) DEFAULT NULL,
  `stuPro` varchar(255) DEFAULT NULL,
  `picUrl` text,
  `isOk` int(1) NOT NULL DEFAULT '0' COMMENT '0审核中1审核通过3审核不通过',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- 转储表的索引
--

--
-- 表的索引 `tp_admin`
--
ALTER TABLE `tp_admin`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `tp_tasks`
--
ALTER TABLE `tp_tasks`
  ADD PRIMARY KEY (`id`,`openid`) USING BTREE,
  ADD UNIQUE KEY `id` (`id`) USING BTREE;

--
-- 表的索引 `tp_user`
--
ALTER TABLE `tp_user`
  ADD PRIMARY KEY (`id`,`openid`) USING BTREE,
  ADD UNIQUE KEY `id` (`id`) USING BTREE;

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `tp_admin`
--
ALTER TABLE `tp_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `tp_tasks`
--
ALTER TABLE `tp_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120690;

--
-- 使用表AUTO_INCREMENT `tp_user`
--
ALTER TABLE `tp_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
