<?php
$installer = $this;
$installer->startSetup();

$installer->run("
DROP TABLE IF EXISTS {$installer->getTable('scenescene7/product_default_jewelgroup')};
CREATE TABLE {$installer->getTable('scenescene7/product_default_jewelgroup')} (
  `value_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` varchar(255) NOT NULL, 
  `jewel_group` varchar(64) NOT NULL,
  `default_jewel` VARCHAR( 64 ) NOT NULL,
  `jewel_label` VARCHAR( 64 ) NOT NULL,  
  `position` tinyint(4) NOT NULL,
  PRIMARY KEY (`value_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->removeAttribute('catalog_product', 'default_jewelgroup');
$installer->addAttribute('catalog_product','default_jewelgroup',array(
    'group' =>'Scenescene7',
    'label' => 'Default Jewel Group',
    'backend'=>'scenescene7/product_backend_attribute_jewelgroup',
    'input' => 'text',
    'user_defined' => 1,
    'apply_to' => 'scene_jewel_product',
    'required'  => '1'
));
$installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, 'default_jewelgroup', 'apply_to', 'scene_jewel_product');

$installer->run("
DROP TABLE IF EXISTS {$installer->getTable('scenescene7/product_default_goodsgroup')};
CREATE TABLE {$installer->getTable('scenescene7/product_default_goodsgroup')} (
  `value_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` varchar(255) NOT NULL, 
  `goods_group` varchar(64) NOT NULL,
  `default_goods` varchar(64) NOT NULL,
  `goods_label` varchar(64) NOT NULL,
  `position` tinyint(4) NOT NULL,
  PRIMARY KEY (`value_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
$installer->removeAttribute('catalog_product', 'default_goodsgroup');
$installer->addAttribute('catalog_product','default_goodsgroup',array(
    'group' =>'Scenescene7',
    'label' => 'Default Goods Group',
    'backend'=>'scenescene7/product_backend_attribute_goodsgroup',
    'input' => 'text',
    'user_defined' => 1,
    'apply_to' => 'scene_goods_product',
    'required'  => '1'
));
$installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, 'default_goodsgroup', 'apply_to', 'scene_goods_product');

$installer->endSetup(); 