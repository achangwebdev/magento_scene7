<?php
class Achang_Scene7_Model_Product_Price_Goods extends Mage_Catalog_Model_Product_Type_Price{
    public function getFinalPrice($qty=null, $product){
        if ($sceneopt = $product->getCustomOption('scene_option')) {
                $price = $product->getPrice();
                $sceneoptions = unserialize($sceneopt->getValue());
                foreach ($sceneoptions as $key => $val) {
                    $goods = Mage::getModel('scenescene7/sceneitem')->load($val);
                    $price +=$goods->getSceneitemPrice();
                }
                return $price;
        }else {
              return parent::getFinalPrice($qty, $product);
        }
    }
}