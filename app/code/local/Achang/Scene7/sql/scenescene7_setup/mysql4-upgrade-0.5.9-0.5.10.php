<?php

$installer = $this;

$installer->startSetup();

$installer->run("
ALTER TABLE  `{$installer->getTable('scenescene7/scene_scene7_attribute')}` ADD  `attribute_code` VARCHAR( 255 ) NOT NULL AFTER  `scene7_code`;
    ");

$installer->endSetup(); 