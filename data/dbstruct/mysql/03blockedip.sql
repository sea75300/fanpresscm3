CREATE TABLE IF NOT EXISTS `{{dbpref}}_blockedip` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ipaddress` varchar(512) NOT NULL,
  `iptime` bigint(20) NOT NULL,
  `userid` bigint(20) NOT NULL,
  `nocomments` tinyint(4) NOT NULL,
  `nologin` tinyint(4) NOT NULL,
  `noaccess` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;