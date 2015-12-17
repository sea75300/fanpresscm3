CREATE TABLE IF NOT EXISTS `{{dbpref}}_smileys` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `smileycode` varchar(32) NOT NULL,
  `filename` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

INSERT INTO `fpcm_smileys` (`id`, `smileycode`, `filename`) VALUES
(1, ':annoyed:', 'annoyed.gif'),
(2, ':D', 'biggrin.gif'),
(3, ':blah:', 'blah.gif')
(4, ':|', 'blank.gif'),
(5, ':blush:', 'blush.gif'),
(6, ':bored:', 'bored.gif'),
(7, ':bounce:', 'bounce.gif'),
(8, ':confused:', 'confused.gif'),
(9, ':cool:', 'cool.gif'),
(10, ':cry:', 'cry.gif'),
(11, ':cute:', 'cute.gif'),
(12, ':evil:', 'evil.gif'),
(13, ':frustrated:', 'frustrated.gif'),
(14, ':grins:', 'grin.gif'),
(15, ':gross:', 'gross.gif'),
(16, ':grr:', 'grr.gif'),
(17, ':heart.gif:', 'heart.gif'),
(18, ':huh:', 'huh.gif'),
(19, ':kiss:', 'kissy.gif'),
(20, ':lol:', 'laugh.gif'),
(21, ':love:', 'love.gif'),
(22, ':mad:', 'mad.gif'),
(23, ':nono:', 'no.gif'),
(24, ':ouch:', 'ouch.gif'),
(25, ':(', 'sad.gif'),
(26, ':secret:', 'secret.gif'),
(27, ':shocked:', 'shocked.gif'),
(28, ':sleepy:', 'sleepy.gif'),
(29, ':)', 'smile.gif'),
(30, ':spin:', 'spin.gif'),
(31, ':sweat:', 'sweatdrop.gif'),
(32, ':think:', 'thinking.gif'),
(33, ':P', 'tongue.gif'),
(34, ':whoa:', 'whoa.gif'),
(35, ';)', 'wink.gif'),
(36, ':whoohoo:', 'woohoo.gif'),
(37, ':yeah:', 'yes.gif'),
(38, ':yummy:', 'yum.gif');