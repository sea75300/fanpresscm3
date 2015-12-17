CREATE TABLE IF NOT EXISTS `{{dbpref}}_categories` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `iconPath` text NOT NULL,
  `groups` varchar(1024) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

INSERT INTO `{{dbpref}}_categories` (`id`, `name`, `iconPath`, `groups`) VALUES
(1, 'Allgemein', '', '1;2;3');