<?php
$installer = $this;
$installer->startSetup();

$entityTypeId = $installer->getEntityTypeId('catalog_product');
$attrSetId =  $installer->getAttributeSetId($entityTypeId, 'Default');
Mage::helper('scenescene7')->createAttributeSet('Jewel', $attrSetId);
$installer->endSetup(); 