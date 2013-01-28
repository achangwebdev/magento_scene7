<?php
$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('catalog_product_option_description')};
CREATE TABLE {$this->getTable('catalog_product_option_description')} (
    `option_description_id` int(10) unsigned NOT NULL auto_increment,
    `option_id` int(10) unsigned NOT NULL default '0',
    `store_id` smallint(5) unsigned NOT NULL default '0',
    `description` VARCHAR(500) NOT NULL default '',
    PRIMARY KEY (`option_description_id`),
    KEY `CATALOG_PRODUCT_OPTION_DESCRIPTION_OPTION` (`option_id`),
    KEY `CATALOG_PRODUCT_OPTION_DESCRIPTION_STORE` (`store_id`),
    CONSTRAINT `FK_CATALOG_PRODUCT_OPTION_DESCRIPTION_OPTION` FOREIGN KEY (`option_id`) REFERENCES {$this->getTable('catalog_product_option')} (`option_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_CATALOG_PRODUCT_OPTION_DESCRIPTION_STORE` FOREIGN KEY (`store_id`) REFERENCES {$this->getTable('core_store')} (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB default CHARSET=utf8;


-- DROP TABLE IF EXISTS {$this->getTable('catalog_product_option_type_detail')};
CREATE TABLE {$this->getTable('catalog_product_option_type_detail')} (
    `catalog_product_option_type_detail_id` int(10) unsigned NOT NULL auto_increment,
    `option_type_id` int(10) unsigned NOT NULL default '0',
    `store_id` smallint(5) unsigned NOT NULL default '0',
    `scene7_code` VARCHAR(500) default '',
    PRIMARY KEY (`catalog_product_option_type_detail_id`),
    KEY `CATALOG_PRODUCT_OPTION_TYPE_DETAIL_OPTION_TYPE` (`option_type_id`),
    KEY `CATALOG_PRODUCT_OPTION_TYPE_DETAIL_STORE` (`store_id`),
    CONSTRAINT `FK_CATALOG_PRODUCT_OPTION_TYPE_DETAIL_OPTION_TYPE` FOREIGN KEY (`option_type_id`) REFERENCES {$this->getTable('catalog_product_option_type_value')} (`option_type_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_CATALOG_PRODUCT_OPTION_TYPE_DETAIL_STORE` FOREIGN KEY (`store_id`) REFERENCES {$this->getTable('core_store')} (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB default CHARSET=utf8;

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