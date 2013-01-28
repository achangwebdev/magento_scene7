<?php

class Achang_Scene7_Model_Resource_Attribute extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the attribute_id refers to the key field in your database table.
        $this->_init('scenescene7/scene_scene7_attribute', 'attribute_id');
    }
}