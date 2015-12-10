CREATE TABLE IF NOT EXISTS `{{dbpref}}_modules` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `modkey` varchar(512) NOT NULL,
  `version` varchar(64) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;