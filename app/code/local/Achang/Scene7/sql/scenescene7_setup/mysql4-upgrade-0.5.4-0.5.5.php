<?php
$installer = $this;
$installer->startSetup();

$installer->removeAttribute('catalog_product', 'scene_type');
$installer->addAttribute('catalog_product','scene_type',array(
    'label' => 'Scene Type',  
    'input' => 'select',
    'type' => 'int',
    'source' => 'eav/entity_attribute_source_table',
    'user_defined' => 1,
    'required'  => '0',
     'option' => array (
                'value' => array(
                        'jewel' => array('Jewel'),
                        'goods' => array('Goods')
                        )
                ),
));

$installer->removeAttribute('scenescene7', 'code');
$installer->addAttribute('scenescene7','code',array(
    'label' => 'Code',  
    'type' => 'varchar',
    'input' => 'text',
    'user_defined' => 1,
    'required'  => '1'
));


$installer->removeAttribute('scenescene7', 'name');
$installer->addAttribute('scenescene7','name',array(
    'label' => 'Name',  
    'type' => 'varchar',
    'input' => 'text',
    'user_defined' => 1,
    'required'  => '1'
));

$installer->removeAttribute('scenescene7', 'sceneitem_price');
$installer->addAttribute('scenescene7','sceneitem_price',array(
    'label' => 'Sceneitem Price',  
    'type' => 'varchar',
    'input' => 'text',
    'user_defined' => 1,
    'required'  => '0'
));

$installer->removeAttribute('scenescene7', 'scene_product_type');
$installer->addAttribute('scenescene7','scene_product_type',array(
    'label' => 'Scene Product Type',  
    'type' => 'int',
    'input' => 'select',
    'backend'=>'eav/entity_attribute_backend_array',
    'source' => 'scenescene7/sceneitem_attribute_source_scenetype',
    'required'  => '0'
));
$installer->endSetup(); 