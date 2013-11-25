# OpenLaunch

OpenLaunch is a revolutionary open source web content management system.

## Installation

### Command Line

The following linux commands will install the CMS:

    wget https://github.com/Eskridge/OpenLaunch/archive/production.zip
    unzip production.zip

## Developer Guide

OpenLaunch is a product which is built upon the CreationShare Web Framework. For
a guide on how to develop applications within OpenLaunch and its framework, view
the documentation for the CSframework project

Sample database config file:

	$settings["database.server"] = "localhost";
	$settings["database.name"] = "framework";
	$settings["database.user"] = "root";
	$settings["database.password"] = "root";

Sample website config file:

	$settings["website.name"] = "Name";
	$settings["website.theme"] = "Framework-Open-Blue";
	$settings["website.organization"] = "Eskridge";

Sample database structure:

	CREATE TABLE IF NOT EXISTS `LoginSession` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `cs_created` int(24) NOT NULL,
	  `cs_modified` int(24) NOT NULL,
	  `user` int(11) NOT NULL,
	  `cookie` varchar(256) NOT NULL,
	  `sessionid` varchar(256) NOT NULL,
	  `browser` varchar(48) NOT NULL,
	  `platform` varchar(48) NOT NULL,
	  `ipaddress` varchar(48) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=175 ;

	CREATE TABLE IF NOT EXISTS `Person` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `cs_created` int(24) NOT NULL,
	  `cs_modified` int(24) NOT NULL,
	  `prefix` varchar(10) NOT NULL,
	  `first` varchar(48) NOT NULL,
	  `middle` varchar(48) NOT NULL,
	  `last` varchar(48) NOT NULL,
	  `suffix` varchar(24) NOT NULL,
	  `nickname` varchar(48) NOT NULL,
	  `email` varchar(128) NOT NULL,
	  `phone` varchar(24) NOT NULL,
	  `street` varchar(48) NOT NULL,
	  `suite` varchar(48) NOT NULL,
	  `city` varchar(48) NOT NULL,
	  `province` varchar(48) NOT NULL,
	  `country` varchar(48) NOT NULL,
	  `website` varchar(128) NOT NULL,
	  `organization` varchar(48) NOT NULL,
	  `facebook` varchar(48) NOT NULL,
	  `twitter` varchar(48) NOT NULL,
	  `openid` varchar(1024) NOT NULL,
	  `office` varchar(128) NOT NULL,
	  `building` int(11) NOT NULL,
	  `profile` text NOT NULL,
	  `roles` varchar(20000) NOT NULL,
	  `ipaddress` varchar(64) NOT NULL,
	  `zip` varchar(24) NOT NULL,
	  `ban` int(1) NOT NULL,
	  `confirmed` int(1) DEFAULT NULL,
	  `confirmkey` varchar(128) DEFAULT NULL,
	  `signature` varchar(128) DEFAULT NULL,
	  `unique` varchar(128) DEFAULT NULL,
	  `type` varchar(128) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

	CREATE TABLE IF NOT EXISTS `Role` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `cs_created` int(24) NOT NULL,
	  `cs_modified` int(24) NOT NULL,
	  `name` varchar(128) NOT NULL,
	  `permissions` varchar(30000) NOT NULL,
	  `category` varchar(128) NOT NULL,
	  `allmembers` int(1) NOT NULL,
	  `allguests` int(1) NOT NULL,
	  `allemployees` int(1) NOT NULL,
	  `icon` varchar(128) DEFAULT NULL,
	  `importance` int(32) DEFAULT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

## Essential Concepts

If you want to contribute changes, you are free to, but it is not required.
Simply fork the project, make your changes, and contact us. If we choose to
merge your changes, and you give consent, all changes you make will be licensed
under the MIT license.

## Licensing, Contribution, & Ownership

This platform is licensed under the MIT License, meaning that you are allowed to
do anything you'd like with the platform, so long as you provide attribution, and
you acknowledge the MIT License's various disclaimers. You are free to fork this
project, with attribution, and to create a website with it, with attribution.
What is considered "attribution?" the copyright notice included in the license
must be included in all copies of the server-side source code.
