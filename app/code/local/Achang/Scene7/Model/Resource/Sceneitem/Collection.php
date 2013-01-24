<?php
class Achang_Scene7_Model_Resource_Sceneitem_Collection extends Mage_Eav_Model_Entity_Collection_Abstract{
    public function _construct(){
        parent::_construct();
        $this->_init('scenescene7/sceneitem');
    }
}