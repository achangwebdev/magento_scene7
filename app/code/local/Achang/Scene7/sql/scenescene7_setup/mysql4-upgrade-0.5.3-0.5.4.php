<?php
$installer = $this;

$installer->startSetup();

$installer->run("
ALTER TABLE  `{$this->getTable('catalog_product_option_type_detail')}` ADD  `is_default` INT NOT NULL AFTER  `scene7_code`;
");

$installer->endSetup();