-- ********************************************************
-- *                                                      *
-- * IMPORTANT NOTE                                       *
-- *                                                      *
-- * Do not import this file manually but use the Contao  *
-- * install tool to create and maintain database tables! *
-- *                                                      *
-- ********************************************************

-- --------------------------------------------------------

--
-- Table `tl_boxes4ward_category`
--

CREATE TABLE `tl_boxes4ward_category` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table `tl_boxes4ward_article`
--

CREATE TABLE `tl_boxes4ward_article` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL default '0',
  `sorting` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `module_id` int(10) unsigned NOT NULL default '0',
  `pages` blob NULL,
  `weekdayFilter` char(1) NOT NULL default '',
  `weekdays` blob NULL,
  `monthFilter` char(1) NOT NULL default '',
  `monthes` blob NULL,
  `inheritPages` char(1) NOT NULL default '',
  `reversePages` char(1) NOT NULL default '',
  `cssID` varchar(255) NOT NULL default '',
  `start` varchar(10) NOT NULL default '',
  `stop` varchar(10) NOT NULL default '',
  `published` char(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table `tl_user`
--

CREATE TABLE `tl_user` (
  `boxes4ward` blob NULL,
  `boxes4ward_newp` blob NULL,
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table `tl_user_group`
--

CREATE TABLE `tl_user_group` (
  `boxes4ward` blob NULL,
  `boxes4ward_newp` blob NULL,
) ENGINE=MyISAM DEFAULT CHARSET=utf8;