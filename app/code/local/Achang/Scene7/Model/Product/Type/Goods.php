<?php
class Achang_Scene7_Model_Product_Type_Goods extends Mage_Catalog_Model_Product_Type_Abstract{
    public function prepareForCart(Varien_Object $buyRequest, $product = null)
    {
        $product = $this->getProduct($product);
        $data = $buyRequest->getData();
        $product->addCustomOption('number_option',$data['numberoption']);
        $product->addCustomOption('src_option',$data['srcoption']);
        $product->addCustomOption('scene_option',serialize($data['sceneoption']));
        return parent::prepareForCart($buyRequest,$product);
    }
    public function getOrderOptions($product = null){
        $optionArr = array();
        if ($sceneopt = $this->getProduct($product)->getCustomOption('scene_option')){
            $options = unserialize($sceneopt->getValue());
        }
        foreach ($options as $option=>$val){
            $value = Mage::getModel('scenescene7/sceneitem')->load($val)->getCode();
            $optionArr ['options'][] = array('label' => $option,'value' => $value,'print_value' => $value );
        }
        //Mage::log($optionArr,null,'mage.log');
        return $optionArr;
    }
}