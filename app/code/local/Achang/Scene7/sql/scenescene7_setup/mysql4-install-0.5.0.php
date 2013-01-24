<?php
$installer = $this;
/* @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */

$installer->startSetup();
$installer->run("
DROP TABLE IF EXISTS {$this->getTable('scene_eav_scenescene7_entity')};
CREATE TABLE {$this->getTable('scene_eav_scenescene7_entity')} (
  `entity_id` int(10) unsigned NOT NULL auto_increment,
  `entity_type_id` smallint(8) unsigned NOT NULL default '0',
  `store_id` smallint(5) unsigned NOT NULL default '0',
  `attribute_set_id` smallint(5) unsigned NOT NULL default '0',
  `parent_id` int(10) unsigned NOT NULL default '0',
  `created_at` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL default '0000-00-00 00:00:00',
  `is_active` tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (`entity_id`),
  KEY `FK_SCENE_EAV_SCENESCENE7_ENTITY_ENTITY_TYPE` (`entity_type_id`),
  KEY `FK_SCENE_EAV_SCENESCENE7_ENTITY_STORE` (`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Scene7 Entities';

DROP TABLE IF EXISTS {$this->getTable('scene_eav_scenescene7_entity_varchar')};
CREATE TABLE {$this->getTable('scene_eav_scenescene7_entity_varchar')} (
  `value_id` int(11) NOT NULL auto_increment,
  `entity_type_id` smallint(5) unsigned NOT NULL default '0',
  `attribute_id` smallint(5) unsigned NOT NULL default '0',
  `store_id` smallint(5) unsigned NOT NULL default '0',
  `entity_id` int(10) unsigned NOT NULL default '0',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`value_id`),

  UNIQUE KEY `IDX_SCENE_EAV_SCENESCENE7_ENTITY_VARCHAR_ENTITY_ATTRIBUTE_STORE` USING BTREE (`entity_type_id`,`entity_id`,`attribute_id`,`store_id`),

  KEY `IDX_SCENE_EAV_SCENESCENE7_ENTITY_VARCHAR_ENTITY_ID` (`entity_id`),
  KEY `IDX_SCENE_EAV_SCENESCENE7_ENTITY_VARCHAR_ATTRIBUTE_ID` (`attribute_id`),
  KEY `IDX_SCENE_EAV_SCENESCENE7_ENTITY_VARCHAR_STORE_ID` (`store_id`),

  CONSTRAINT `FK_SCENE_EAV_SCENESCENE7_ENTITY_VARCHAR_ATTRIBUTE_ID` FOREIGN KEY (`attribute_id`) REFERENCES {$this->getTable('eav_attribute')} (`attribute_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_SCENE_EAV_SCENESCENE7_ENTITY_VARCHAR_ENTITY_ID` FOREIGN KEY (`entity_id`) REFERENCES {$this->getTable('scene_eav_scenescene7_entity')} (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_SCENE_EAV_SCENESCENE7_ENTITY_VARCHAR_STORE_ID` FOREIGN KEY (`store_id`) REFERENCES {$this->getTable('core_store')} (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
  
DROP TABLE IF EXISTS {$this->getTable('scene_eav_scenescene7_entity_int')};
CREATE TABLE {$this->getTable('scene_eav_scenescene7_entity_int')} (
  `value_id` int(11) NOT NULL auto_increment,
  `entity_type_id` smallint(5) unsigned NOT NULL default '0',
  `attribute_id` smallint(5) unsigned NOT NULL default '0',
  `store_id` smallint(5) unsigned NOT NULL default '0',
  `entity_id` int(10) unsigned NOT NULL default '0',
  `value` int(11) NOT NULL default '0',
  PRIMARY KEY  (`value_id`),
  UNIQUE KEY `IDX_SCENE_EAV_SCENESCENE7_ENTITY_INT_ENTITY_ATTRIBUTE_STORE` (`entity_type_id`,`entity_id`,`attribute_id`,`store_id`),
  KEY `IDX_SCENE_EAV_SCENESCENE7_ENTITY_INT_ENTITY_ID` (`entity_id`),
  KEY `IDX_SCENE_EAV_SCENESCENE7_ENTITY_INT_ATTRIBUTE_ID` (`attribute_id`),
  KEY `IDX_SCENE_EAV_SCENESCENE7_ENTITY_INT_STORE_ID` (`store_id`),
  CONSTRAINT `FK_SCENE_EAV_SCENESCENE7_ENTITY_INT_ATTRIBUTE_ID` FOREIGN KEY (`attribute_id`) REFERENCES {$this->getTable('eav_attribute')} (`attribute_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_SCENE_EAV_SCENESCENE7_ENTITY_INT_ENTITY_ID` FOREIGN KEY (`entity_id`) REFERENCES {$this->getTable('scene_eav_scenescene7_entity')} (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_SCENE_EAV_SCENESCENE7_ENTITY_INT_STORE_ID` FOREIGN KEY (`store_id`) REFERENCES {$this->getTable('core_store')} (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup();

$installer->installEntities();