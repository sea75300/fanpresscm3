CREATE TABLE IF NOT EXISTS `{{dbpref}}_cronjobs` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cjname` varchar(64) NOT NULL,
  `lastexec` bigint(20) NOT NULL,
  `execinterval` bigint(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

INSERT INTO `{{dbpref}}_cronjobs` (`id`, `cjname`, `lastexec`, `execinterval`) VALUES
(1, 'anonymizeIps', 0, 2419200),
(2, 'clearLogs', 0, 2419200),
(3, 'clearTemp', 0, 604800),
(4, 'fmThumbs', 0, 604800),
(5, 'postponedArticles', 0, 600),
(6, 'updateCheck', 0, 86400),
(7, 'dbBackup', 0, 604800),
(8, 'fileindex', 0, 86400);