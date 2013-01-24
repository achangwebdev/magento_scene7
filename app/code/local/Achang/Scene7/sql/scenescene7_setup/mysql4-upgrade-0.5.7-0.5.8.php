<?php
$installer = $this;

$installer->startSetup();

$installer->run("

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

");

$installer->endSetup();