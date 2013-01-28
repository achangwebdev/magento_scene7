<?php

class Achang_Scene7_Model_Status extends Varien_Object
{
    const SCENE7TEXT	= 'text';
    const SCENE7SELECT	= 'select';

    static public function getOptionArray()
    {
        return array(
            self::SCENE7TEXT    => Mage::helper('scenescene7')->__('Scene7 text'),
            self::SCENE7SELECT   => Mage::helper('scenescene7')->__('Scene7 select')
        );
    }
}