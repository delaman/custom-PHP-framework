CREATE TABLE  `ty`.`users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employeeID` int(10) unsigned NOT NULL,
  `clientID` int(10) unsigned NOT NULL,
  `role` tinyint(3) unsigned NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8
