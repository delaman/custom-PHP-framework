CREATE TABLE  `ty`.`contacts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name1` text NOT NULL,
  `name2` text NOT NULL,
  `email` text NOT NULL,
  `phone1` smallint(3) unsigned NOT NULL,
  `phone2` smallint(3) unsigned NOT NULL,
  `phone3` smallint(4) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=99 DEFAULT CHARSET=utf8
