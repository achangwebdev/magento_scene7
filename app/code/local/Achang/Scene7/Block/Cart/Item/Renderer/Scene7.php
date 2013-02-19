<?php

class Achang_Scene7_Block_Cart_Item_Renderer_Scene7 extends Mage_Checkout_Block_Cart_Item_Renderer
{
    public function getOptionList()
    {
        return array_merge($this->_getMgbOptions(), parent::getOptionList());
    }
    
    protected function _getMgbOptions($useCache = true)
    {      
        $product = $this->getProduct();
        $src_option = $product->getCustomOption('src_option');
        if($src_option){
            $options = array();
            $this->_addSimpleOptions($options, $product,$src_option->getValue());
            return $options;
        }else{
            return array();
        }
    }

    protected function _addSimpleOptions(&$options,$product, $src_option = '') {
    	if($src_option){
    	    $option = array('label' => 'Personalized Image');
	        $option['value'][] = "<img width='100' src='{$src_option}'>";
	        $options[] = $option;
    	}
    }
}