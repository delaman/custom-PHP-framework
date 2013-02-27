CREATE TABLE  `ty`.`items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `contactID` int(10) unsigned NOT NULL,
  `client` text NOT NULL,
  `artist` text NOT NULL,
  `title` text NOT NULL,
  `medium` text NOT NULL,
  `length` smallint(5) unsigned NOT NULL,
  `width` smallint(5) unsigned NOT NULL,
  `height` smallint(5) unsigned NOT NULL,
  `insuredBy` text NOT NULL,
  `value` int(10) unsigned NOT NULL,
  `location` varchar(20) NOT NULL,
  `transportation` text NOT NULL,
  `conditionedBy` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8
