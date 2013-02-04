<?php
$installer = $this;
$installer->startSetup();

$entityTypeId = $installer->getEntityTypeId('catalog_product');
$attrSetId =  $installer->getAttributeSetId($entityTypeId, 'Default');
Mage::helper('scenescene7')->createAttributeSet('Scene7', $attrSetId);

$installer->removeAttribute('catalog_product', 'scene7_template');
$installer->addAttribute('catalog_product','scene7_template',array(
    'group' =>'Scene7', 
    'label' => 'Scene7 Template Name',
    'input' => 'text',
    'type' => 'varchar',
    'user_defined' => 1,
    'apply_to' =>'scene7_product',

));
$installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, 'scene7_template', 'apply_to', 'scene7_product');

$installer->endSetup(); 