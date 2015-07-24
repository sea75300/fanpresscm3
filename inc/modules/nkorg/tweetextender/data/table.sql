CREATE TABLE IF NOT EXISTS `{{dbpref}}_{{tablename}}` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `searchterm` varchar(255) NOT NULL,
  `replaceterm` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;