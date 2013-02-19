<?php
class Achang_Scene7_Model_Product_Type_Scene7 extends Mage_Catalog_Model_Product_Type_Abstract{
    public function prepareForCart(Varien_Object $buyRequest, $product = null)
    {
        $product = $this->getProduct($product);
        $data = $buyRequest->getData();
        $product->addCustomOption('src_option',$data['src_option']);
        return parent::prepareForCart($buyRequest,$product);
    }
    public function getOrderOptions($product = null){
    	$optionArr = parent::getOrderOptions($product);
        if ($product->hasCustomOptions()) {
            $src_option = $product->getCustomOption('src_option')->getValue();
            $option['label'] = 'Personalized Image';
            $option['value'] = "<img width='100' src='{$src_option}'>";//// array order page not ok
            $option['print_value'] = "<img width='100' src='{$src_option}'>";
            $option['custom_view'] = "<img width='100' src='{$src_option}'>";
            
            $optionArr['options'][] = $option;
        }
        
        return $optionArr;
    }
}