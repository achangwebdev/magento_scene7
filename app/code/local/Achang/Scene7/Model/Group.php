<?php
class Achang_Scene7_Model_Group extends Mage_Core_Model_Abstract{
    public function _construct(){
        parent::_construct();
        $this->_init('scenescene7/group');
    }
    public function getAllGroups(){
        $groups = Mage::getModel('scenescene7/group')->getCollection()->load();
        return $groups;
    }
}