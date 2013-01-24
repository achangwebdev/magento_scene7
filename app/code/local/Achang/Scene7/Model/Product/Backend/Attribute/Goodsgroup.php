<?php
class Achang_Scene7_Model_Product_Backend_Attribute_Goodsgroup extends Mage_Eav_Model_Entity_Attribute_Backend_Abstract{
    protected function _getResource(){
        return Mage::getResourceSingleton('scenescene7/product_default_goodsgroup');
    }
    
    public function validate($object){
        $arr = $object->getData($this->getAttribute()->getName());
        return true;
    }
    
    public function afterLoad($object){
        $data = $this->_getResource()->loadDefaultGoodsgroupData($object->getId());
        //var_dump($data);die();
        $object->setData($this->getAttribute()->getName(),$data);
        $object->setOrigData($this->getAttribute()->getName(),$data);
        $valueChangedKey = $this->getAttribute()->getName().'_changed';
        $object->setOrigData($valueChangedKey, 0);
        $object->setData($valueChangedKey, 0);        
        return $this;
    }
    
    public function afterSave($object){
        $defaultGoodsgroup = $object->getData($this->getAttribute()->getName());
        if(empty($defaultGoodsgroup)){
            return $this;
        }
        $old = array();
        $new = array();
        
        $origDefaultGoodsgroup = $object->getOrigData($this->getAttribute()->getName());
        if(!is_array($origDefaultGoodsgroup)){
            $origDefaultGoodsgroup = array();
        }
        foreach ($origDefaultGoodsgroup as $data){
            $key = join('-',array($data['value_id'],$data['goods_group'],$data['position']));
            $old[$key] = $data;
        }
        //Mage::log($origDefaultGoodsgroup,null,'old.log');
                
        
        foreach ($defaultGoodsgroup as $data) {
            if(!isset($data['goods_group'])
            ||!isset($data['default_goods'])
            ||!isset($data['goods_label'])
            || !isset($data['position'])
            || !empty($data['delete'])
            ){
                continue;
            }
            $key = join('-',array($data['value_id'],$data['goods_group'],$data['position']));
            $new[$key] = array(
               'goods_group'     =>$data['goods_group'],
               'default_goods'   =>$data['default_goods'],
               'goods_label'     =>$data['goods_label'],
               'position'        =>$data['position'],
            );
        }
       
        $delete = array_diff_key($old,$new);
        $insert = array_diff_key($new,$old);
        $update = array_intersect_key($new,$old);
        
        $isChanged  = false;
        $productId  = $object->getId();

        if(!empty($delete)){
            foreach ($delete as $data){
               $this->_getResource()->deleteDefaultGoodsgroupData($productId, $data['value_id']);
               $isChanged =true;
            }
        }

        if(!empty($insert)){
            foreach ($insert as $data) {
                $goodsgroup = new Varien_Object($data);
                $goodsgroup->setProductId($productId);
                $this->_getResource()->saveDefaultGoodsgroupData($goodsgroup);
                $isChanged = true;
            }
        }
        
        if(!empty($update)){
            foreach($update as $k => $v){
                if($old[$k]['goods_group'] != $v['goods_group']
                  ||$old[$k]['default_goods']!=$v['default_goods'] 
                  ||$old[$k]['goods_label']!=$v['goods_label']
                  ||$old[$k]['position']!=$v['position']
                ){
                    $goodsgroup = new Varien_Object(array(
                     'value_id'      =>$old[$k]['value_id'],
                     'goods_group'   =>$v['goods_group'],
                     'default_goods'   =>$v['default_goods'],
                     'goods_label'         =>$v['goods_label'],
                     'position'      =>$v['position'],
                    ));
                    $this->_getResource()->saveDefaultGoodsgroupData($goodsgroup);
                    $isChanged = true;
                }
            }
        }
        
        if($isChanged){
            $valueChangedKey = $this->getAttribute()->getName() . '_changed';
            $object->setData($valueChangedKey, 1);
        }
        return $this;
    }
    public function afterDelete($object){
        $this->_getResource()->deleteDefaultGoodsgroupData($object->getId());
    }

}