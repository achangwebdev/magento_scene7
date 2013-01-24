<?php
class Achang_Scene7_Model_Resource_Product_Group_Link_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract{
    protected function _construct()
    {
        parent::_construct();
        $this->_init('scenescene7/product_group_link');
    }
}
