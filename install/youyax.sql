CREATE DATABASE IF NOT EXISTS {database} DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

CREATE TABLE IF NOT EXISTS `{prefix}admin` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `user` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `purview` text COLLATE utf8_unicode_ci NOT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `{prefix}big_block`
--

CREATE TABLE IF NOT EXISTS `{prefix}big_block` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `bzone` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `{prefix}mark1`
--

CREATE TABLE IF NOT EXISTS `{prefix}mark1` (
  `id` smallint(4) NOT NULL AUTO_INCREMENT,
  `tid` smallint(4) NOT NULL,
  `marker` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `pic` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `count` tinyint(4) NOT NULL,
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `{prefix}mark2`
--

CREATE TABLE IF NOT EXISTS `{prefix}mark2` (
  `id` smallint(4) NOT NULL AUTO_INCREMENT,
  `rid` smallint(4) NOT NULL,
  `tid` smallint(4) NOT NULL,
  `marker` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `pic` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `count` tinyint(4) NOT NULL,
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------
--
-- Table structure for table `{prefix}plugin`
--

CREATE TABLE IF NOT EXISTS `{prefix}plugin` (
  `id` smallint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------
--
-- Table structure for table `{prefix}reply`
--

CREATE TABLE IF NOT EXISTS `{prefix}reply` (
  `id2` int(4) NOT NULL AUTO_INCREMENT,
  `zuozhe1` varchar(7) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ori_content1` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `content1` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `rid` int(4) DEFAULT NULL,
  `num2` int(4) NOT NULL COMMENT '回复次数',
  `time2` datetime NOT NULL,
  `face1` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `timezc2` datetime NOT NULL,
  `fatieshu2` smallint(4) NOT NULL,
  `parentid2` int(4) NOT NULL,
  `laud2` int(4) NOT NULL DEFAULT '0',
  `laud2_ips` mediumtext NOT NULL,
  `last_modify2` datetime NOT NULL,
  PRIMARY KEY (`id2`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `{prefix}small_block`
--

CREATE TABLE IF NOT EXISTS `{prefix}small_block` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `szone` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `mark` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `icon_url` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `bid` int(4) NOT NULL,
  `sid` int(4) NOT NULL,
  `ssort` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `{prefix}online`
--

CREATE TABLE IF NOT EXISTS `{prefix}online` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) NOT NULL,
  `lasttime` int(4) NOT NULL,
  `user` varchar(7) NOT NULL,
  `zone` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `{prefix}talk`
--

CREATE TABLE IF NOT EXISTS `{prefix}talk` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `zuozhe` varchar(7) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ori_content` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `content` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `num1` int(4) NOT NULL DEFAULT '0',
  `timeup` datetime NOT NULL,
  `time1` datetime NOT NULL,
  `face` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `timezc1` datetime NOT NULL,
  `fatieshu1` smallint(4) NOT NULL,
  `parentid` int(4) NOT NULL,
  `lock_status` tinyint(1) NOT NULL,
  `is_visible` tinyint(1) NOT NULL,
  `is_limit1` tinyint(1) NOT NULL,
  `is_grap` tinyint(1) NOT NULL,
  `is_question` tinyint(1) NOT NULL,
  `is_allow` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `tags` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `question_bid` int(4) NOT NULL DEFAULT '0',
  `laud` int(4) NOT NULL DEFAULT '0',
  `laud_ips` mediumtext NOT NULL,
  `last_modify1` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `{prefix}user`
--

CREATE TABLE IF NOT EXISTS `{prefix}user` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `user` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `complete` int(4) NOT NULL,
  `face` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `time` datetime NOT NULL,
  `fatieshu` smallint(4) NOT NULL,
  `bid` int(4) NOT NULL DEFAULT '0',
  `codes` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `ip_addr` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `user_group` tinyint(1) NOT NULL,
  `openid` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `weiboid` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `cookieid` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `lasttime` int(4) NOT NULL,
  `lastzone` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- 表的结构 `{prefix}user_group`
--

CREATE TABLE IF NOT EXISTS `{prefix}user_group` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `purview` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- 表的结构 `{prefix}vote`
--

CREATE TABLE IF NOT EXISTS `{prefix}vote` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `rid` int(4) NOT NULL,
  `comb` mediumtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- 表的结构 `{prefix}vote_ips`
--

CREATE TABLE IF NOT EXISTS `{prefix}vote_ips` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `vid` int(4) NOT NULL,
  `ips` mediumtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- 表的结构 `{prefix}count`
--

CREATE TABLE IF NOT EXISTS `{prefix}count` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `user_count` text NOT NULL,
  `post_count` text NOT NULL,
  `user_hot` text NOT NULL,
  `tags_hot` text NOT NULL,
  `week_order` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--
--
-- 表的结构 `{prefix}message`
--

CREATE TABLE IF NOT EXISTS `{prefix}message` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `mfrom` varchar(7) NOT NULL,
  `mto` varchar(7) NOT NULL,
  `mcon` varchar(100) NOT NULL,
  `time` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- 表的结构 `{prefix}message_status`
--

CREATE TABLE IF NOT EXISTS `{prefix}message_status` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `muser` varchar(7) NOT NULL,
  `mstatus` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- 表的结构 `{prefix}favor`
--

CREATE TABLE IF NOT EXISTS `{prefix}favor` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `user` varchar(7) NOT NULL,
  `favor` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- 表的结构 `{prefix}topic_limit`
--

CREATE TABLE IF NOT EXISTS `{prefix}topic_limit` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `user` varchar(7) NOT NULL,
  `time` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- 表的结构 `{prefix}jubao`
--

CREATE TABLE IF NOT EXISTS `{prefix}jubao` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `jubao_to` varchar(7) NOT NULL,
  `jubao_reason` varchar(30) NOT NULL,
  `jubao_from` varchar(7) NOT NULL,
  `jubao_url` varchar(100) NOT NULL,
  `time` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- 表的结构 `{prefix}login_limit`
--

CREATE TABLE IF NOT EXISTS `{prefix}login_limit` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `ip` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `errornum` tinyint(1) NOT NULL,
  `time` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;