-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-09-04 06:23:09
-- 服务器版本： 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testguest`
--

-- --------------------------------------------------------

--
-- 表的结构 `tg_user`
--

CREATE TABLE `tg_user` (
  `tg_id` mediumint(8) UNSIGNED NOT NULL,
  `tg_uniqid` char(40) NOT NULL DEFAULT '',
  `tg_active` char(40) NOT NULL DEFAULT '' COMMENT '激活登陆用户',
  `tg_username` varchar(20) NOT NULL DEFAULT '',
  `tg_password` char(40) NOT NULL DEFAULT '',
  `tg_question` varchar(20) NOT NULL DEFAULT '',
  `tg_answer` char(40) NOT NULL DEFAULT '',
  `tg_email` varchar(40) DEFAULT NULL,
  `tg_qq` varchar(10) DEFAULT NULL,
  `tg_url` varchar(40) DEFAULT NULL,
  `tg_sex` char(1) NOT NULL DEFAULT '',
  `tg_face` char(12) NOT NULL DEFAULT '',
  `tg_reg_time` datetime DEFAULT NULL,
  `tg_last_time` datetime DEFAULT NULL,
  `tg_last_ip` varchar(20) NOT NULL DEFAULT '',
  `tg_level` tinyint(20) UNSIGNED NOT NULL DEFAULT '0',
  `tg_login_count` smallint(4) UNSIGNED NOT NULL DEFAULT '0' COMMENT '登录次数'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tg_user`
--

INSERT INTO `tg_user` (`tg_id`, `tg_uniqid`, `tg_active`, `tg_username`, `tg_password`, `tg_question`, `tg_answer`, `tg_email`, `tg_qq`, `tg_url`, `tg_sex`, `tg_face`, `tg_reg_time`, `tg_last_time`, `tg_last_ip`, `tg_level`, `tg_login_count`) VALUES
(32, '9fd17092ea0fd97b500520070b008a7077fa2388', '', '浪去郎来', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是大帅锅', 'b5dcd719e419448b75a726315e0182098009125b', '845327689@qq.com', '845327689', 'http://www.baidu.com', '男', 'face/1.png', '2017-09-01 11:59:25', '2017-09-04 13:54:56', '::1', 0, 4),
(31, 'faae8dd10d4a36d3e23fff124c239699252a960a', '', '钢铁侠', '083a6239151d40eaef6a30b60b1b5a6123ab2c7c', '这个东西怎么样', '45dfdc58a1350f712be64908a04361aa32a5550a', '7879788768@qq.com', '7845415454', 'http://www.xiake.com', '男', 'face/3.png', '2017-08-31 11:24:25', '2017-09-04 11:59:23', '::1', 0, 1),
(30, 'cd611b78aa5b2cee6f8883ecf5e0fd69eb76b969', '', '周杰伦', '5cb14dc2db012612b37ae48195ffbb89757f428e', '他长的怎么样', 'f74353cfab4afc5376fb5e704064fafdd8eb6202', '79878776@qq.com', '458745454', 'http://www.zhou.com', '男', 'face/15.png', '2017-08-31 11:23:04', '2017-09-04 11:59:23', '::1', 0, 1),
(29, 'e50ee33ebc8f87672abd86eace37060105cd0023', '', '邓紫棋', 'c05c49a968bdcff8629318389bab94ed257486e2', '她的歌哪首好听', '8ac869f066f02bcc033d7d359974a534d8dd4048', '46446546@qq.com', '784696569', 'http://www.dzq.com', '女', 'face/6.png', '2017-08-31 11:22:02', '2017-09-04 11:59:23', '::1', 0, 1),
(28, '72759d75e849fa2918470e9b89546ca086316d8f', '', '苍老师', 'bbcd6f1bec741e610b42e83fc48198fe9b67d999', '稍微描述一下', '0aa6fc662b1bca3eef6ac522abcb2326b0bb169f', '787878545@qq.com', '784510147', 'http://www.cang.com', '女', 'face/7.png', '2017-08-31 11:20:43', '2017-09-04 11:59:23', '::1', 0, 1),
(27, '7e746e20cdec5de5b6ee34e2b5007cbd83004441', '', '海盗船长', 'e45fec0160ec7a026f2f65154d0d14bc0e405476', '这是个什么东西', '8565d86f3b4c4cf631270e27139ca027cce7e0de', '4646465658@qq.com', '7854695285', 'http://www.haidao.com', '男', 'face/12.png', '2017-08-31 11:19:33', '2017-09-04 11:59:23', '::1', 0, 1),
(26, '512e6663bd17ed397d16968e46f6e2b59208bfda', '', '樱桃小丸子', '8893ea7cbb10804797f62947771a446ace637e22', '这是个小萝莉', '5d59bc65bd1187f09b1641381d5812706a6eeb49', '4654646546@qq.com', '785278528', 'http://www.xiaowanzi.com', '女', 'face/13.png', '2017-08-31 11:18:31', '2017-09-04 11:59:23', '::1', 0, 1),
(25, 'bd9ae9d6cdbe85d24ac5a63c5522fefe5381e607', '', '美少女战士', '667a25b0855ad6bc24c4547775c848d87cb93ba2', '什么时候最美', '208421120105928f7001242d034eb19050cf5d22', '4887498787@qq.com', '7845896321', 'http://www.meishaonv.com', '女', 'face/9.png', '2017-08-31 11:17:25', '2017-09-04 11:59:23', '::1', 0, 1),
(23, '204388ecce164c4e08f07fc7702b19dc1690b8f6', '', '铁胆火车侠', '6c5701ee14121fc50efdbf7150285978cc4ee5e8', '这是个铁皮', '62ac6badfd6133960a042957edbd86bb97366934', '4564654654@qq.com', '785425698', 'http://www.tiepi.com', '男', 'face/2.png', '2017-08-31 11:13:41', '2017-09-04 11:59:23', '::1', 0, 1),
(22, '2a396fdd98b577e37242f54aeaeeeb8f71a3379c', '', '火影忍者', 'be9b4fdeb6924b0554ad64363ab01ec6f5137919', '这是个神额', '5c9f94599bf3dd71c019cf53a1815c81a2aa591f', '6464654654@qq.com', '4654845201', 'http://www.huoxing.com', '男', 'face/12.png', '2017-08-31 11:12:41', '2017-09-04 11:59:23', '::1', 0, 1),
(21, '8c732dfcaeb32f1d2721d584a94b9e0084c19d57', '', '黄渤', 'df2983700ffecb52e6649f0cb3981b66537083a4', '这特么长得', '0649c2abada7bb346852cfb5ee86069dbb3fb372', '464646466@qq.com', '647647658', 'http://www.huangbo.com', '男', 'face/8.png', '2017-08-31 11:11:45', '2017-09-04 11:59:23', '::1', 0, 1),
(20, 'd9811488f79f15b184b0ae3b96bcef852f7423af', '', '景甜', 'b41d0a583be903b5c71624e312582985ebe0d6e8', '大美女有木有', 'c7f9234c2acd2e8fef9e2c260c1fce7b6964ae25', '46546464@qq.com', '54656465', 'http://www.jingtianl.com', '女', 'face/20.png', '2017-08-31 11:10:48', '2017-09-04 11:59:23', '::1', 0, 1),
(24, 'f89d3cc80ac6e1f000b9491d3cc99bac5812aab0', '', '吴飞', 'df2983700ffecb52e6649f0cb3981b66537083a4', '这是个肌肉男', '052f0f66c1b46f859ca54c058c53e95b62b1be67', '46546546@qq.com', '458451258', 'http://www.wufei.com', '男', 'face/1.png', '2017-08-31 11:16:18', '2017-09-04 11:59:23', '::1', 0, 1),
(19, '65766e4c309e1316c3c4b95cf6460154e4ba1ef2', '', '浪去浪来', '7c4a8d09ca3762af61e59520943dc26494f8941b', '我是大帅锅', '2d56fc9e902ea0cb5d0566fcf92adf15cc3c5af8', '845327689@qq.com', '845327689', 'http://www.baidu.com', '男', 'face/11.png', '2017-08-31 11:09:18', '2017-09-04 11:59:23', '::1', 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tg_user`
--
ALTER TABLE `tg_user`
  ADD PRIMARY KEY (`tg_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `tg_user`
--
ALTER TABLE `tg_user`
  MODIFY `tg_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
