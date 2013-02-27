CREATE TABLE  `ty`.`addresses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `contactID` int(10) unsigned NOT NULL,
  `type` text NOT NULL,
  `role` tinyint(1) unsigned NOT NULL,
  `address1` text NOT NULL,
  `address2` text NOT NULL,
  `city` text NOT NULL,
  `state` varchar(2) NOT NULL,
  `postcode` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=112 DEFAULT CHARSET=utf8
