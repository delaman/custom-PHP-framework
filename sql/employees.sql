CREATE TABLE  `ty`.`employees` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name1` text NOT NULL,
  `name2` text NOT NULL,
  `address1` text NOT NULL,
  `address2` text NOT NULL,
  `city` text NOT NULL,
  `postcode` mediumint(8) unsigned NOT NULL,
  `email` text NOT NULL,
  `phone1` smallint(3) unsigned NOT NULL,
  `phone2` smallint(3) unsigned NOT NULL,
  `phone3` smallint(4) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=87 DEFAULT CHARSET=utf8
