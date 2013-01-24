<?php
$installer = $this;
$installer->startSetup();
$installer->run("
DROP TABLE IF EXISTS {$installer->getTable('scenescene7/group')};
CREATE TABLE {$installer->getTable('scenescene7/group')} (
  `group_id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS {$installer->getTable('scenescene7/group_sceneitem_link')};
CREATE TABLE {$installer->getTable('scenescene7/group_sceneitem_link')} (
  `link_id` int(11) unsigned  NOT NULL auto_increment,
  `group_id` int(10) unsigned  NOT NULL default '0',
  `sceneitem_id` int(10) unsigned  NOT NULL default '0',
  PRIMARY KEY  (`link_id`),
  KEY `FK_LINK_GROUP` (`group_id`),
  KEY `FK_LINKED_SCENEITEM` (`sceneitem_id`),
  CONSTRAINT `FK_SCENEITEM_LINK_LINKED_SCENEITEM_Link_YE` FOREIGN KEY (`sceneitem_id`) REFERENCES {$installer->getTable('scenescene7/scenescene7')} (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_GROUP_LINK_GROUP_Link_YE` FOREIGN KEY (`group_id`) REFERENCES {$installer->getTable('scenescene7/group')} (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Related Sceneitems';

DROP TABLE IF EXISTS {$installer->getTable('scenescene7/product_sceneitem_link')};
CREATE TABLE {$installer->getTable('scenescene7/product_sceneitem_link')} (
  `link_id` int(11) unsigned NOT NULL auto_increment,
  `product_id` int(10) unsigned NOT NULL default '0',
  `sceneitem_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`link_id`),
  KEY `FK_LINK_PRPDUCT` (`product_id`),
  KEY `FK_LINKED_SCENEITEM` (`sceneitem_id`),
  CONSTRAINT `FK_SCENEITEM_LINK_LINKED_SCENEITEM_Link_YE_new` FOREIGN KEY (`sceneitem_id`) REFERENCES {$installer->getTable('scenescene7/scenescene7')} (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_PRODUCT_LINK_PRODUCT_Link_YE_new` FOREIGN KEY (`product_id`) REFERENCES {$installer->getTable('catalog/product')} (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Product Related colors';

DROP TABLE IF EXISTS {$installer->getTable('scenescene7/product_group_link')};
CREATE TABLE {$installer->getTable('scenescene7/product_group_link')} (
  `link_id` int(11) unsigned NOT NULL auto_increment,
  `product_id` int(10) unsigned NOT NULL default '0',
  `group_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`link_id`),
  KEY `FK_LINK_PRPDUCT2` (`product_id`),
  KEY `FK_LINKED_GROUP` (`group_id`),
  CONSTRAINT `FK_GROUP_LINK_LINKED_GROUP_Link_YE2` FOREIGN KEY (`group_id`) REFERENCES {$installer->getTable('scenescene7/group')} (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_PRODUCT_LINK_PRODUCT_Link_YE2` FOREIGN KEY (`product_id`) REFERENCES {$installer->getTable('catalog/product')} (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Product Related groups';
");
$installer->endSetup(); 