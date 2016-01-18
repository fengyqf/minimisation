-- phpMyAdmin SQL Dump
-- version 3.5.0
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 服务器版本: 5.5.27-log
-- PHP 版本: 5.5.30

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
  `group_id` int(11) NOT NULL DEFAULT '0',
  `time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '记录插入时间',
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  KEY `time` (`time`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=124 ;

-- --------------------------------------------------------

--
-- 表的结构 `mnms_allocation2layer`
--

CREATE TABLE IF NOT EXISTS `mnms_allocation2layer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `allocation_id` int(11) NOT NULL DEFAULT '0',
  `layer_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `allocation_layer` (`allocation_id`,`layer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=326 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- 表的结构 `mnms_group`
--

CREATE TABLE IF NOT EXISTS `mnms_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `study_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2013 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
