CREATE TABLE IF NOT EXISTS `{{dbpref}}_cronjobs` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cjname` varchar(64) NOT NULL,
  `lastexec` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

INSERT INTO `{{dbpref}}_cronjobs` (`id`, `cjname`, `lastexec`) VALUES
(1, 'anonymizeIps', 0),
(2, 'clearLogs', 0),
(3, 'clearTemp', 0),
(4, 'fmThumbs', 0),
(5, 'postponedArticles', 0),
(6, 'updateCheck', 0),
(7, 'dbBackup', 0);