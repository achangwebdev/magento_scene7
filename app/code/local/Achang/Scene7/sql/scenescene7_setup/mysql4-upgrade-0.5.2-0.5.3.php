<?php
$installer = $this;
$installer->startSetup();

$installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, 'price', 'apply_to', 'scene7_product');
$installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, 'cost', 'apply_to', 'scene7_product');
$installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, 'tier_price', 'apply_to', 'scene7_product');
$installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, 'special_price', 'apply_to', 'scene7_product');
$installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, 'special_from_date', 'apply_to', 'scene7_product');
$installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, 'special_to_date', 'apply_to', 'scene7_product');
$installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, 'enable_googlecheckout', 'apply_to', 'scene7_product');

$installer->endSetup(); 