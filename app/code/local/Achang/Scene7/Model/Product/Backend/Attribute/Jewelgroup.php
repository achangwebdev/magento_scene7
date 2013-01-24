<?php
class Achang_Scene7_Model_Product_Backend_Attribute_Jewelgroup extends Mage_Eav_Model_Entity_Attribute_Backend_Abstract{
    protected function _getResource(){
        return Mage::getResourceSingleton('scenescene7/product_default_jewelgroup');
    }
    
    public function validate($object){
        $arr = $object->getData($this->getAttribute()->getName());
        return true;
    }
    
    public function afterLoad($object){
        $data = $this->_getResource()->loadDefaultJewelgroupData($object->getId());
        //var_dump($data);die();
        $object->setData($this->getAttribute()->getName(),$data);
        $object->setOrigData($this->getAttribute()->getName(),$data);
        $valueChangedKey = $this->getAttribute()->getName().'_changed';
        $object->setOrigData($valueChangedKey, 0);
        $object->setData($valueChangedKey, 0);        
        return $this;
    }
    
    public function afterSave($object){
        $defaultJewelgroup = $object->getData($this->getAttribute()->getName());
        if(empty($defaultJewelgroup)){
        	return $this;
        }
        $old = array();
        $new = array();
        
        $origDefaultJewelgroup = $object->getOrigData($this->getAttribute()->getName());
        if(!is_array($origDefaultJewelgroup)){
            $origDefaultJewelgroup = array();
        }
        foreach ($origDefaultJewelgroup as $data){
        	$key = join('-',array($data['value_id'],$data['jewel_group'],$data['position']));
        	$old[$key] = $data;
        }
        //Mage::log($origDefaultJewelgroup,null,'old.log');
                
        
        foreach ($defaultJewelgroup as $data) {
        	if(!isset($data['jewel_group'])
        	||!isset($data['default_jewel'])
        	||!isset($data['angle'])
        	||!isset($data['jewel_label'])
        	|| !isset($data['position'])
        	|| !empty($data['delete'])
        	){
        		continue;
        	}
        	$key = join('-',array($data['value_id'],$data['jewel_group'],$data['position']));
        	$new[$key] = array(
        	   'jewel_group'     =>$data['jewel_group'],
        	   'default_jewel'   =>$data['default_jewel'],
        	   'angle'           =>$data['angle'],
        	   'jewel_label'     =>$data['jewel_label'],
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
        	   $this->_getResource()->deleteDefaultJewelgroupData($productId, $data['value_id']);
        	   $isChanged =true;
        	}
        }

        if(!empty($insert)){
        	foreach ($insert as $data) {
        		$jewelgroup = new Varien_Object($data);
        		$jewelgroup->setProductId($productId);
        		$this->_getResource()->saveDefaultJewelgroupData($jewelgroup);
        		$isChanged = true;
        	}
        }
        
        if(!empty($update)){
        	foreach($update as $k => $v){
        		if($old[$k]['jewel_group'] != $v['jewel_group']
        		  ||$old[$k]['default_jewel']!=$v['default_jewel'] 
        		  ||$old[$k]['angle']!=$v['angle']
        		  ||$old[$k]['jewel_label']!=$v['jewel_label']
        		  ||$old[$k]['position']!=$v['position']
        		){
        			$jewelgroup = new Varien_Object(array(
        			 'value_id'      =>$old[$k]['value_id'],
        			 'jewel_group'   =>$v['jewel_group'],
        			 'default_jewel'   =>$v['default_jewel'],
        			 'angle'         =>$v['angle'],
        			 'jewel_label'         =>$v['jewel_label'],
        			 'position'      =>$v['position'],
        			));
        			$this->_getResource()->saveDefaultJewelgroupData($jewelgroup);
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
    	$this->_getResource()->deleteDefaultJewelgroupData($object->getId());
    }

}