<?php
class Achang_Scene7_Model_Resource_Product_Default_Goodsgroup extends Mage_Core_Model_Mysql4_Abstract{
    public function _construct(){
        $this->_init('scenescene7/product_default_goodsgroup','value_id');
    }
    
    public function loadDefaultGoodsgroupData($productId){
        $adapter = $this->_getReadAdapter();
        $columns = array(
           'value_id'      =>$this->getIdFieldName(),
           'product_id'    =>'product_id',
           'goods_group'   =>'goods_group',
           'default_goods' =>'default_goods',
           'goods_label'   =>'goods_label',
           'position'      =>'position'
        );
        $select = $adapter->select()->
        from($this->getMainTable(),$columns)
        ->where('product_id=?',$productId)
        ->order('position asc');
        
        return $adapter->fetchAll($select);
    }
    
    public function saveDefaultGoodsgroupData(Varien_Object $defaultGoodsGroupObject){
        $adapter = $this->_getWriteAdapter();
        $data    = $this->_prepareDataForTable($defaultGoodsGroupObject, $this->getMainTable());
        if (!empty($data[$this->getIdFieldName()])) {
            $where = $adapter->quoteInto($this->getIdFieldName() . '=?', $data[$this->getIdFieldName()]);
            unset($data[$this->getIdFieldName()]);
            $adapter->update($this->getMainTable(), $data, $where);
        } else {
            $adapter->insert($this->getMainTable(), $data);
        }
        return $this;
    }
    
    public function deleteDefaultGoodsgroupById($valueId)
    {
        $adapter = $this->_getWriteAdapter();
        $conds   = array(
        $adapter->quoteInto('value_id=?', $valueId)
        );
        $where = join(' AND ', $conds);
        return $adapter->delete($this->getMainTable(), $where);
    }
    
    public function deleteDefaultGoodsgroupData($productId,$valueId=null){
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