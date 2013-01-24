<?php
class Achang_Scene7_Model_Link extends Mage_Core_Model_Abstract{
    public function _construct(){
    	parent::_construct();
        $this->_init('scenescene7/link');
    }
    
    public function prepareGroupRelations($links, &$group){
        $data = array();
        if (isset($links['links']['related_sceneitems'])) {
            $jsParam = Mage::helper('adminhtml/js')->decodeGridSerializedInput($links['links']['related_sceneitems']);
            foreach ($jsParam as $id => $sceneitem) {
                $data[$id] = array('group_id' => $group->getId(), 'sceneitem_id' => $id, 'position' => $sceneitem['position']);
            }
        }
        $group->setRelatedSceneitemsData($data);
        return $this;
    }
    
    public function saveGroupRelations($group)
    {
        $data = $group->getRelatedSceneitemsData();
        if (!is_null($data)) {
            $this->_getResource()->saveGroupLinks($group, $data);
        }
        return $this;
    }
    
    public function prepareSceneitemRelations($links, &$sceneitem)
    {
        $data = array();
        if (isset($links['links']['related_group']) && !$sceneitem->getRelatedReadonly()) {
            $jsParam = Mage::helper('adminhtml/js')->decodeGridSerializedInput($links['links']['related_group']);
            foreach ($jsParam as $id => $group) {
                $data[$id] = array('sceneitem_id' => $sceneitem->getId(), 'group_id' => $id, 'position' => $group['position']);
            }
            $sceneitem->setRelatedGroupsData($data);
        }
        return $this;
    }
    public function saveSceneitemRelations($sceneitem){
        $data = $sceneitem->getRelatedGroupsData();
        if (!is_null($data)) {
            $this->_getResource()->saveSceneitemsLinks($sceneitem, $data);
        }
        return $this;
    }
}
