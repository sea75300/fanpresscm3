CREATE TABLE IF NOT EXISTS `{{dbpref}}_sessions` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userId` bigint(20) NOT NULL,
  `sessionId` varchar(255) NOT NULL,
  `login` bigint(20) NOT NULL,
  `logout` bigint(20) NOT NULL,
  `lastaction` bigint(20) NOT NULL,
  `ip` varchar(512) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;