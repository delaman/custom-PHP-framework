CREATE TABLE  `ty`.`logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `log` text NOT NULL,
  `time` int(11) unsigned NOT NULL,
  `priority` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=138 DEFAULT CHARSET=utf8
