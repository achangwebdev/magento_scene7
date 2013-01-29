<?php
/**
 * @author minglong
 *
 */
class Achang_Scene7_Model_Scene7 extends Mage_Core_Model_Abstract{

	private $_product = null;
	private $_options = null;
	
    public function getBaseUrl(){
        $baseUrl = Mage::getStoreConfig('scenescene7/scene7settings/scene7_main_url');
        return $baseUrl;
    }
    
    public function getCompanyName(){
        $companyName = Mage::getStoreConfig('scenescene7/scene7settings/scene7_company');
        return $companyName;
    }
    
    public function getProduct() {
        return $this->_product; 
    }
    
    public function setProduct($product) {
        $this->_product = $product;  
        return $this;  
    }
    
    public function getTemplateName() {
        $product = $this->getProduct();          
        $templateName = $product->getScene7Template();        
        return $templateName;   
    }

    public function getSceneTemplate(){
        $baseUrl = $this->getBaseUrl();
        $co = $this->getCompanyName();
        $sceneTemplate = $baseUrl.$co.'/';
    	return $sceneTemplate;
    }
    
    public function getDefaultSceneTemplate(){
        $template = $this->getTemplateName();
        $sceneDefaultTemplate = $this->getSceneTemplate().$template;
        return $sceneDefaultTemplate;
    }
    
    public function getSceneParams(){
        $size = array(300,300);
        $hei = $size[0];
        $wid = $size[1];
        $sceneParams = '?qlt=100,1'.'&hei='.$hei.'&wei='.$wid.'&op_sharpen=1';
        return $sceneParams;
    }
    
    public function setOptions($options){
    	$tempOption = array();
    	foreach($options as $k => $v){
    	   $option = Mage::getModel('catalog/product_option')->load($k);
    	   if ($option->getGroupByType() == Achang_Scene7_Model_Catalog_Product_Option::OPTION_GROUP_SCENE7SELECT) {
    	   	   $attributes = Mage::getModel('scenescene7/attribute')->getCollection()->addFieldToFilter('attribute_code',array('eq'=>$option->getType()));
    	   	   if(count($attributes) == 1){
    	   	   	   $attribute = $attributes->getFirstItem();
    	   	   	   $values = Mage::getModel('catalog/product_option_value')->getCollection()->addFieldToFilter('`main_table`.`option_type_id`',array('eq'=>$v))
                   ->addScene7DetailToResult(Mage::app()->getStore()->getId())
                   ->addOptionToFilter(array($option->getId()));
                   if(count($values) == 1){
                    	$value = $values->getFirstItem();
                    	$tempOption[$attribute->getScene7Code()] = array('value'=>$value->getScene7Code(),'params'=>$this->getOptionParams($k));
                   }else{
                        continue;
                   }
    	   	   }else{
    	   	       continue;
    	   	   }
    	   }
    	}
        $this->_options = $tempOption;
         return $this;  
    }
    
    public function getOptionParams($optionId){
            $collection = Mage::getModel('catalog/product_option')->getCollection()
            ->addFieldToFilter('`main_table`.`option_id`', $optionId)
            ->addDescriptionToResult(Mage::app()->getStore()->getId());
            if(count($collection) == 1){
            	return $collection->getFirstItem()->getDescription();
            }else{
                return '';
            }
    }
    
    public function getOptions(){
         return $this->_options;  
    }
    
    public function getUrl(){
        $url = $this->getDefaultSceneTemplate().$this->getSceneParams();
        return $url;
    }
    
    public function toUrl(){
    	try{
    	    $co = $this->getCompanyName();
	        $params =  $this->getOptions();
	        $url = '';
	        if($params){
	             foreach($params as $k => $v){
	               $temp= '&$'.$k.'=is{'.$co.'/'.$v['value'];
	               if($v['params']){
	                $temp .= '?'.$v['params'].'}';
	               }else{
	                   $temp .= '}';
	               }
	               $url .= $temp;
	            }
	        }
	        $ImageUrl = $this->getUrl().$url;
	        return $ImageUrl;
    	}
    	catch(Exception $e){
    	   return '';
    	}

    }
}