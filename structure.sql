-- phpMyAdmin SQL Dump
-- version 4.0.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 17, 2013 at 03:37 PM
-- Server version: 5.5.32-cll-lve
-- PHP Version: 5.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `openlaun_openlaunch`
--

-- --------------------------------------------------------

--
-- Table structure for table `BlogCategory`
--

CREATE TABLE IF NOT EXISTS `BlogCategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cs_created` int(24) NOT NULL,
  `cs_modified` int(24) NOT NULL,
  `name` varchar(128) NOT NULL,
  `page` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `BlogPost`
--

CREATE TABLE IF NOT EXISTS `BlogPost` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cs_created` int(24) NOT NULL,
  `cs_modified` int(24) NOT NULL,
  `name` varchar(128) NOT NULL,
  `content` text NOT NULL,
  `user` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `published` int(1) NOT NULL,
  `page` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `Comment`
--

CREATE TABLE IF NOT EXISTS `Comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cs_created` int(24) NOT NULL,
  `cs_modified` int(24) NOT NULL,
  `modeltype` varchar(128) NOT NULL,
  `model` int(32) NOT NULL,
  `user` int(11) NOT NULL,
  `content` varchar(40000) NOT NULL,
  `hidden` int(1) NOT NULL,
  `locked` int(1) NOT NULL,
  `element` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Table structure for table `Communication`
--

CREATE TABLE IF NOT EXISTS `Communication` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cs_created` int(24) NOT NULL,
  `cs_modified` int(24) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `phone` varchar(128) NOT NULL,
  `content` text NOT NULL,
  `user` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `ContactForm`
--

CREATE TABLE IF NOT EXISTS `ContactForm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cs_created` int(24) NOT NULL,
  `cs_modified` int(24) NOT NULL,
  `page` int(11) NOT NULL,
  `askname` int(1) NOT NULL,
  `askemail` int(1) NOT NULL,
  `askphone` int(1) NOT NULL,
  `askaddress` int(1) NOT NULL,
  `askcomment` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `FeatureGalleryCategory`
--

CREATE TABLE IF NOT EXISTS `FeatureGalleryCategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cs_created` int(24) NOT NULL,
  `cs_modified` int(24) NOT NULL,
  `name` varchar(128) NOT NULL,
  `order` int(11) NOT NULL,
  `page` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `FeatureGalleryEntry`
--

CREATE TABLE IF NOT EXISTS `FeatureGalleryEntry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cs_created` int(24) NOT NULL,
  `cs_modified` int(24) NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(128) NOT NULL,
  `category` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `Forum`
--

CREATE TABLE IF NOT EXISTS `Forum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cs_created` int(24) NOT NULL,
  `cs_modified` int(24) NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` varchar(5000) NOT NULL,
  `order` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `canpost` varchar(5000) NOT NULL,
  `canview` varchar(5000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `ForumCategory`
--

CREATE TABLE IF NOT EXISTS `ForumCategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cs_created` int(24) NOT NULL,
  `cs_modified` int(24) NOT NULL,
  `name` varchar(128) NOT NULL,
  `order` int(11) NOT NULL,
  `page` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `ForumTopic`
--

CREATE TABLE IF NOT EXISTS `ForumTopic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cs_created` int(24) NOT NULL,
  `cs_modified` int(24) NOT NULL,
  `name` varchar(128) NOT NULL,
  `closed` int(1) NOT NULL,
  `pinned` int(1) NOT NULL,
  `hidden` int(1) NOT NULL,
  `user` int(11) NOT NULL,
  `forum` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Table structure for table `GitHubProject`
--

CREATE TABLE IF NOT EXISTS `GitHubProject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cs_created` int(24) NOT NULL,
  `cs_modified` int(24) NOT NULL,
  `name` varchar(128) NOT NULL,
  `githubuser` varchar(128) NOT NULL,
  `githubproject` varchar(128) NOT NULL,
  `production` varchar(64) NOT NULL,
  `url` varchar(256) NOT NULL,
  `created` varchar(50) NOT NULL,
  `pushed` varchar(50) NOT NULL,
  `forks` int(11) NOT NULL,
  `branches` int(11) NOT NULL,
  `issues` int(11) NOT NULL,
  `watchers` int(11) NOT NULL,
  `language` varchar(20) NOT NULL,
  `size` int(11) NOT NULL,
  `page` int(11) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `LoginSession`
--

CREATE TABLE IF NOT EXISTS `LoginSession` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cs_created` int(24) NOT NULL,
  `cs_modified` int(24) NOT NULL,
  `user` int(11) NOT NULL,
  `cookie` text NOT NULL,
  `sessionid` varchar(128) NOT NULL,
  `browser` varchar(128) NOT NULL,
  `platform` varchar(128) NOT NULL,
  `ipaddress` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=98 ;

-- --------------------------------------------------------

--
-- Table structure for table `Page`
--

CREATE TABLE IF NOT EXISTS `Page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cs_created` int(24) NOT NULL,
  `cs_modified` int(24) NOT NULL,
  `name` varchar(128) NOT NULL,
  `website` int(11) NOT NULL,
  `parent` int(11) NOT NULL,
  `menu` int(1) NOT NULL,
  `home` int(1) NOT NULL,
  `order` int(32) NOT NULL,
  `template` varchar(128) NOT NULL,
  `can` varchar(20000) NOT NULL,
  `link` varchar(128) NOT NULL,
  `html` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `Person`
--

CREATE TABLE IF NOT EXISTS `Person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cs_created` int(24) NOT NULL,
  `cs_modified` int(24) NOT NULL,
  `prefix` varchar(128) NOT NULL,
  `first` varchar(128) NOT NULL,
  `middle` varchar(128) NOT NULL,
  `last` varchar(128) NOT NULL,
  `suffix` varchar(128) NOT NULL,
  `nickname` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `phone` varchar(128) NOT NULL,
  `street` varchar(128) NOT NULL,
  `suite` varchar(128) NOT NULL,
  `city` varchar(128) NOT NULL,
  `province` varchar(128) NOT NULL,
  `zip` varchar(128) NOT NULL,
  `country` varchar(128) NOT NULL,
  `website` varchar(128) NOT NULL,
  `organization` varchar(128) NOT NULL,
  `facebook` varchar(128) NOT NULL,
  `twitter` varchar(128) NOT NULL,
  `openid` varchar(128) NOT NULL,
  `profile` text NOT NULL,
  `roles` varchar(20000) NOT NULL,
  `ipaddress` varchar(128) NOT NULL,
  `ban` int(1) NOT NULL,
  `confirmed` int(1) NOT NULL,
  `confirmkey` varchar(128) NOT NULL,
  `signature` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `Role`
--

CREATE TABLE IF NOT EXISTS `Role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cs_created` int(24) NOT NULL,
  `cs_modified` int(24) NOT NULL,
  `name` varchar(128) NOT NULL,
  `permissions` varchar(20000) NOT NULL,
  `category` varchar(128) NOT NULL,
  `allmembers` int(1) NOT NULL,
  `allguests` int(1) NOT NULL,
  `allemployees` int(1) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `importance` int(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `WikiCategory`
--

CREATE TABLE IF NOT EXISTS `WikiCategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cs_created` int(24) NOT NULL,
  `cs_modified` int(24) NOT NULL,
  `name` varchar(128) NOT NULL,
  `order` int(11) NOT NULL,
  `page` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `WikiPage`
--

CREATE TABLE IF NOT EXISTS `WikiPage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cs_created` int(24) NOT NULL,
  `cs_modified` int(24) NOT NULL,
  `name` varchar(128) NOT NULL,
  `order` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
