<?php
$installer = $this;
$installer->startSetup();
$installer->run("
ALTER TABLE {$this->getTable('scenescene7/product_default_jewelgroup')} 
Add COLUMN  `angle` VARCHAR( 64 ) NOT NULL;
");

$installer->endSetup();