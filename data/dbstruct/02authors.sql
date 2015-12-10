CREATE TABLE IF NOT EXISTS `{{dbpref}}_authors` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `displayname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `registertime` bigint(11) NOT NULL,
  `roll` int(11) NOT NULL,
  `usrmeta` blob NOT NULL,
  `disabled` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;