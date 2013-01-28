<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$installer->getTable('scenescene7/scene_scene7_attribute')};
CREATE TABLE {$installer->getTable('scenescene7/scene_scene7_attribute')} (
  `attribute_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `scene7_code` varchar(255) NOT NULL default '',
  `type` varchar(255) NOT NULL default '',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`attribute_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");

$installer->endSetup(); 