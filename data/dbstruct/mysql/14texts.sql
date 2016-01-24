CREATE TABLE IF NOT EXISTS `{{dbpref}}_texts` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `searchtext` varchar(255) NOT NULL,
  `replacementtext` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;