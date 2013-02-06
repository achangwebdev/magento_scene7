<?php

class Achang_Scene7_Block_Product_View_Options extends Mage_Catalog_Block_Product_View_Options
{
    public function __construct()
    {
        parent::__construct();
        $this->addOptionRenderer(
            Achang_Scene7_Model_Catalog_Product_Option::OPTION_GROUP_SCENE7SELECT,
            'scenescene7/product_view_options_type_scene7select',
            'scene7/catalog/product/view/options/type/scene7select.phtml'
        );
        
        $this->addOptionRenderer(
            Achang_Scene7_Model_Catalog_Product_Option::OPTION_GROUP_SCENE7TEXT,
            'scenescene7/catalog/product_view_options_type_scene7text',
            'scene7/catalog/product/view/options/type/scene7text.phtml'
        );
    }

    public function getJsonConfig()
    {
        $config = array();

        foreach ($this->getOptions() as $option) {
            /* @var $option Mage_Catalog_Model_Product_Option */
            $priceValue = 0;
            if ($option->getGroupByType() == Mage_Catalog_Model_Product_Option::OPTION_GROUP_SELECT || $option->getGroupByType() == Achang_Scene7_Model_Catalog_Product_Option::OPTION_GROUP_SCENE7SELECT) {
                $_tmpPriceValues = array();
                foreach ($option->getValues() as $value) {
                    /* @var $value Mage_Catalog_Model_Product_Option_Value */
                   $_tmpPriceValues[$value->getId()] = Mage::helper('core')->currency($value->getPrice(true), false, false);
                }
                $priceValue = $_tmpPriceValues;
            } else {
                $priceValue = Mage::helper('core')->currency($option->getPrice(true), false, false);
            }
            $config[$option->getId()] = $priceValue;
        }

        return Mage::helper('core')->jsonEncode($config);
    }
    
    public function getScene7AttributeJsonConfig()
    {
        $config = array();
        foreach ($this->getOptions() as $option) {
            if ($option->getGroupByType() == Achang_Scene7_Model_Catalog_Product_Option::OPTION_GROUP_SCENE7SELECT) {
            	 $values = Mage::getModel('catalog/product_option_value')->getCollection()
                        ->addScene7DetailToResult(Mage::app()->getStore()->getId())
                        ->addOptionToFilter(array($option->getId()));
                foreach ($values as $value) {
                   $config[$option->getId()][$value->getId()] = array('sku'=>$value->getSku(),'scene7_code'=>$value->getScene7Code(),'is_default'=>$value->getIsDefault());
                }
            } else if($option->getGroupByType() == Achang_Scene7_Model_Catalog_Product_Option::OPTION_GROUP_SCENE7TEXT){
                $config[$option->getId()] = array('sku'=>$value->getSku());
            }
        }
       return Mage::helper('core')->jsonEncode($config);
    }
}
