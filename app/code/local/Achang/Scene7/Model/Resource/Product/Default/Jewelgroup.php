<?php
class Achang_Scene7_Model_Resource_Product_Default_Jewelgroup extends Mage_Core_Model_Mysql4_Abstract{
    public function _construct(){
        $this->_init('scenescene7/product_default_jewelgroup','value_id');
    }
    
    public function loadDefaultJewelgroupData($productId){
    	$adapter = $this->_getReadAdapter();
    	$columns = array(
    	   'value_id'      =>$this->getIdFieldName(),
    	   'product_id'    =>'product_id',
    	   'jewel_group'   =>'jewel_group',
    	   'default_jewel' =>'default_jewel',
    	   'angle'         =>'angle',
    	   'jewel_label'   =>'jewel_label',
    	   'position'      =>'position'
    	);
    	$select = $adapter->select()->
    	from($this->getMainTable(),$columns)
    	->where('product_id=?',$productId)
    	->order('position asc');
    	
    	return $adapter->fetchAll($select);
    }
    
    public function saveDefaultJewelgroupData(Varien_Object $defaultJewelGroupObject){
        $adapter = $this->_getWriteAdapter();
        $data    = $this->_prepareDataForTable($defaultJewelGroupObject, $this->getMainTable());
        if (!empty($data[$this->getIdFieldName()])) {
            $where = $adapter->quoteInto($this->getIdFieldName() . '=?', $data[$this->getIdFieldName()]);
            unset($data[$this->getIdFieldName()]);
            $adapter->update($this->getMainTable(), $data, $where);
        } else {
            $adapter->insert($this->getMainTable(), $data);
        }
        return $this;
    }
    
    public function deleteDefaultJewelgroupById($valueId)
    {
        $adapter = $this->_getWriteAdapter();
        $conds   = array(
        $adapter->quoteInto('value_id=?', $valueId)
        );
        $where = join(' AND ', $conds);
        return $adapter->delete($this->getMainTable(), $where);
    }
    
    public function deleteDefaultJewelgroupData($productId,$valueId=null){
    	$adapter   = $this->_getWriteAdapter();
    	$conds     = array(
    	   $adapter->quoteInto('product_id=?',$productId)
    	);
    	if($valueId){
    	   $conds[] = $adapter->quoteInto('value_id=?',$valueId);
    	}
    	$where = join(' AND ',$conds);
    	return $adapter->delete($this->getMainTable(), $where);
    }
    public function getIdFieldName(){
            if (empty($this->_idFieldName)) {
            Mage::throwException(Mage::helper('core')->__('Empty identifier field name'));
        }
        return $this->_idFieldName;
    }
}