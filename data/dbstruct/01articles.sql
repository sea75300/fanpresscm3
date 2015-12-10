CREATE TABLE IF NOT EXISTS `{{dbpref}}_articles` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(512) NOT NULL,
  `content` mediumtext NOT NULL,
  `categories` varchar(512) NOT NULL,
  `createtime` bigint(20) NOT NULL,
  `createuser` bigint(20) NOT NULL,
  `changetime` bigint(20) NOT NULL,
  `changeuser` bigint(20) NOT NULL,
  `md5path` varchar(255) NOT NULL,
  `draft` tinyint(4) NOT NULL,
  `archived` tinyint(4) NOT NULL,
  `pinned` tinyint(4) NOT NULL,
  `postponed` tinyint(4) NOT NULL,
  `deleted` tinyint(4) NOT NULL,
  `comments` tinyint(4) NOT NULL,
  `approval` tinyint(4) NOT NULL,
  `imagepath` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `{{dbpref}}_articles` ADD INDEX ( `title` );
ALTER TABLE `{{dbpref}}_articles` ADD INDEX ( `categories` );
ALTER TABLE `{{dbpref}}_articles` ADD INDEX ( `createuser` );
ALTER TABLE `{{dbpref}}_articles` ADD INDEX ( `createtime` );
ALTER TABLE `{{dbpref}}_articles` ADD INDEX ( `pinned` );
ALTER TABLE `{{dbpref}}_articles` ADD INDEX ( `postponed` );
ALTER TABLE `{{dbpref}}_articles` ADD INDEX ( `deleted` );
ALTER TABLE `{{dbpref}}_articles` ADD INDEX ( `approval` );
ALTER TABLE `{{dbpref}}_articles` ADD INDEX ( `draft` );