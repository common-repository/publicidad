CREATE TABLE IF NOT EXISTS `sa_publicidad` (
  `id` int(11) NOT NULL auto_increment,
  `cliente` varchar(250) NOT NULL,
  `redireccion` text NOT NULL,
  `clicks` int(11) default NULL,
  `imp` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;