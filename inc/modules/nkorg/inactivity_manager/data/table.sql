CREATE TABLE IF NOT EXISTS `{{dbpref}}_{{tablename}}` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `starttime` bigint(20) NOT NULL,
  `stoptime` bigint(20) NOT NULL,
  `nocomments` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;