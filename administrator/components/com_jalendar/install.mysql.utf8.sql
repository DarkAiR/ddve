CREATE TABLE IF NOT EXISTS `#__jalendar` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `id_article` int(11) unsigned NOT NULL default '0',
  `date` date default NULL,
  `type` tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM CHARACTER SET `utf8`;