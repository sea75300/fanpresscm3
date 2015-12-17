CREATE TABLE IF NOT EXISTS `{{dbpref}}_userrolls` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `leveltitle` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

INSERT INTO `{{dbpref}}_userrolls` (`id`, `leveltitle`) VALUES
(1, 'GLOBAL_ADMINISTRATOR'),
(2, 'GLOBAL_EDITOR'),
(3, 'GLOBAL_AUTHOR');