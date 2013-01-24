<?php
class Achang_Scene7_Model_Resource_Link_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract{
    public function _construct(){
        parent::_construct();
        $this->_init('scenescene7/link');
    }
}