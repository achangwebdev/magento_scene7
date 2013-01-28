<?php
$installer = $this;

/* @var $this Achang_Scene7_Model_Mysql4_Setup */
/* @var $installer Achang_Scene7_Model_Mysql4_Setup */

$installer->startSetup();
$installer->removeAttribute('catalog_product', 'scene7_template');
$installer->addAttribute('catalog_product','scene7_template',array(
    'group' =>'Scenescene7', 
    'label' => 'Scene7 Template Name',
    'input' => 'text',
    'type' => 'varchar',
    'user_defined' => 1,
    'apply_to' =>'scene_jewel_product',

));
$installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, 'scene7_template', 'apply_to', 'scene_jewel_product');

$installer->endSetup();