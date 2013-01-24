<?php
class Achang_Scene7_Model_Resource_Link extends Mage_Core_Model_Mysql4_Abstract{
    public function _construct(){
        $this->_init('scenescene7/group_sceneitem_link', 'link_id');
    }
    public function saveSceneitemsLinks($sceneitem, $data)
    {
        if (!is_array($data)) {
          $data = array();
        }
        $actionData  = array('insert' => $data, 'update' => array(), 'remove' => array());

        $collection = Mage::getModel('scenescene7/link')->getCollection();
        $collection->addFieldToFilter('sceneitem_id',$sceneitem->getId());

        if ($collection->count()) {
            $actionData = $this->prepareUpdate($data, $collection, 'group_id');
        }

        $this->saveLinks($actionData);
        return $this;
    }
    
    public function saveLinks ($data) {
            foreach ($data['remove'] as $reData) {
            $link = Mage::getModel('scenescene7/link')->load($reData['id']);
            $link->delete();
        }
        if (count($data['remove'])) {
            Mage::dispatchEvent('scenescene7_group_changed', array('links' => $data['remove'], 'type' => 'remove'));
        }

        foreach ($data['insert'] as $inData) {
            $link = Mage::getModel('scenescene7/link');
            $link->setSceneitemId($inData['sceneitem_id']);
            $link->setGroupId($inData['group_id']);
            $link->setPosition($inData['position']);
            $link->save();
        }

        if (count($data['insert'])) {
            Mage::dispatchEvent('scenescene7_group_changed', array('links' => $data['insert'], 'type' => 'insert'));
        }

        foreach ($data['update'] as $upData) {
            $link = Mage::getModel('scenescene7/link')->load($upData['id']);
            $link->setPosition($upData['position']);
            $link->save();
        }
    }
    public function addGridPosition($collection,$manager_id){
        $table2 = $this->getMainTable();
        $cond = $this->_getWriteAdapter()->quoteInto('e.entity_id = t2.sceneitem_id','');
        $collection->getSelect()->joinLeft(array('t2'=>$table2), $cond);
        $collection->getSelect()->group('e.entity_id');
    }
    
    public function saveGroupLinks($group, $data)
    {
        if (!is_array($data)) {
            $data = array();
        }
        $actionData  = array('insert' => $data, 'update' => array(), 'remove' => array());

        $collection = Mage::getModel('scenescene7/link')->getCollection()->addFieldToFilter('group_id',$group->getId());
        if ($collection->count()) {
            $actionData = $this->prepareUpdate($data, $collection, 'sceneitem_id');
            
        }

        $this->saveLinks($actionData);
        return $this;
    }
    
        public function prepareUpdate($dataForUpdate, $collection, $field) {
        $actionData = array('insert'=> array(), 'update' => array(), 'remove'=>array());
        $newSceneitemsIds = array_keys($dataForUpdate);
        $oldSceneitemsIds = $collection->getColumnValues($field);

        $insert = array_diff($newSceneitemsIds, $oldSceneitemsIds);
        $remove = array_diff($oldSceneitemsIds, $newSceneitemsIds);
        $update = array_intersect($newSceneitemsIds, $oldSceneitemsIds);

        foreach ($remove as $reId) {
            $item = $collection->getItemByColumnValue($field,$reId);
            $actionData['remove'][] = array('id' => $item->getId(), 'sceneitem_id' => $item->getSceneitemId(), 'group_id' => $item->getGroupId());
        }

        foreach ($insert as $inId) {
            if (isset($dataForUpdate[$inId])) {
                $actionData['insert'][] = $dataForUpdate[$inId];
            }
        }

        foreach ($update as $upId) {
            if (isset($dataForUpdate[$upId])) {
                $oldItem = $collection->getItemByColumnValue($field,$upId);
                $newItem = $dataForUpdate[$upId];
                if ($oldItem->getPosition() != $newItem['position']) {
                    $actionData['update'][] = array('id' => $oldItem->getId(), 'position' => $newItem['position']);
                }
            }
        }

        return $actionData;
    }
    
}