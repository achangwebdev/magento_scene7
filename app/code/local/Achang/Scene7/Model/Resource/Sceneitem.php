<?php
class Achang_Scene7_Model_Resource_Sceneitem extends Mage_Eav_Model_Entity_Abstract{
    public function __construct()
    {
        $resource = Mage::getSingleton('core/resource');
        $this->setType(Achang_Scene7_Model_Sceneitem::ENTITY); 
        $this->setConnection(
            $resource->getConnection('scenescene7_write'),
            $resource->getConnection('sscenescene7_read')
        );
    }
}
