CREATE TABLE IF NOT EXISTS `{{dbpref}}_comments` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `articleid` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `private` tinyint(1) NOT NULL,
  `approved` tinyint(1) NOT NULL,
  `spammer` tinyint(1) NOT NULL,
  `ipaddress` varchar(512) NOT NULL,
  `createtime` bigint(20) NOT NULL,
  `changetime` bigint(20) NOT NULL,
  `changeuser` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;