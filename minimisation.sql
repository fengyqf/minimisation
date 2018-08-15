-- phpMyAdmin SQL Dump
-- version 3.5.0
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2018 年 08 月 15 日 11:11
-- 服务器版本: 5.5.53
-- PHP 版本: 5.3.27

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `minimisation`
--

-- --------------------------------------------------------

--
-- 表的结构 `mnms_allocation`
--

CREATE TABLE IF NOT EXISTS `mnms_allocation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `center_id` int(11) NOT NULL DEFAULT '0' COMMENT 'fk to: center.id if study.separated_by_center=1',
  `group_id` int(11) NOT NULL DEFAULT '0',
  `time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '记录插入时间',
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  KEY `time` (`time`),
  KEY `center_id` (`center_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `mnms_allocation2layer`
--

CREATE TABLE IF NOT EXISTS `mnms_allocation2layer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `allocation_id` int(11) NOT NULL DEFAULT '0',
  `layer_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `allocation_layer` (`allocation_id`,`layer_id`),
  KEY `layer_allocation` (`layer_id`,`allocation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `mnms_center`
--

CREATE TABLE IF NOT EXISTS `mnms_center` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `study_id` int(11) NOT NULL DEFAULT '0' COMMENT 'fk to: study.id',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `study_id` (`study_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `mnms_factor`
--

CREATE TABLE IF NOT EXISTS `mnms_factor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `study_id` int(11) NOT NULL DEFAULT '0' COMMENT 'fk: to study.id',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '因素名',
  `weight` int(11) NOT NULL DEFAULT '1' COMMENT '权重比值',
  PRIMARY KEY (`id`),
  KEY `study_id` (`study_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `mnms_group`
--

CREATE TABLE IF NOT EXISTS `mnms_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `study_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `study_id` (`study_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `mnms_layer`
--

CREATE TABLE IF NOT EXISTS `mnms_layer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `factor_id` int(11) NOT NULL DEFAULT '0' COMMENT 'fk to: factor.id',
  PRIMARY KEY (`id`),
  KEY `factor_id` (`factor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `mnms_study`
--

CREATE TABLE IF NOT EXISTS `mnms_study` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '试验项目名',
  `bias` int(11) NOT NULL DEFAULT '80' COMMENT 'Bias probability distribution(1-100]',
  `group_count` int(11) NOT NULL DEFAULT '0' COMMENT '冗余数据，组数，即group表对应study_id数据条数',
  `owner_uid` int(11) NOT NULL DEFAULT '0' COMMENT '所有者id号，可以任意外部用户系统的uid',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `separated_by_center` int(11) NOT NULL DEFAULT '0' COMMENT '0,1:是否启用按中心分配',
  `access_token` varchar(100) NOT NULL DEFAULT '' COMMENT 'access token, 供http远程添加加分配记录',
  PRIMARY KEY (`id`),
  KEY `access_token` (`access_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `mnms_user`
--

CREATE TABLE IF NOT EXISTS `mnms_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `pass` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `study_id` (`pass`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `mnms_user`
--

INSERT INTO `mnms_user` (`id`, `name`, `pass`) VALUES
(7, 'admin', 'admin');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
