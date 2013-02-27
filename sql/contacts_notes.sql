CREATE TABLE  `ty`.`contacts_notes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `contactID` int(10) unsigned NOT NULL,
  `note` text NOT NULL,
  `time` int(11) unsigned NOT NULL,
  `author` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8
