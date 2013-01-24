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
    'apply_to' =>'scene_jewel_product,scene_goods_product',

));
$installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, 'scene7_template', 'apply_to', 'scene_jewel_product,scene_goods_product');

$installer->removeAttribute('catalog_product', 'jewel_default_number');
$installer->addAttribute('catalog_product','jewel_default_number',array(
    'group' =>'Scenescene7',
    'label' => 'Jewel Default Number',
    'input' => 'text',
    'type' => 'text',
    'user_defined' => 1,
    'apply_to' => 'scene_jewel_product'
));
$installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, 'jewel_default_number', 'apply_to', 'scene_jewel_product');

$installer->removeAttribute('catalog_product', 'jewel_number');
$installer->addAttribute('catalog_product','jewel_number',array(
    'group' =>'Scenescene7',
    'label' => 'Jewel Number',
    'input' => 'text',
    'type' => 'varchar',
    'user_defined' => 1,
    'apply_to' => 'scene_jewel_product'
));
$installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, 'jewel_number', 'apply_to', 'scene_jewel_product');

$installer->endSetup();