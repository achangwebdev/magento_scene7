<?php
class Achang_Scene7_Model_Product_Price_Scene7 extends Mage_Catalog_Model_Product_Type_Price{
//    public function getFinalPrice($qty=null, $product){
//        if ($sceneopt = $product->getCustomOption('scene_option')) {
//                $price = $product->getPrice();
//                $sceneoptions = unserialize($sceneopt->getValue());
//                $numberoption = $product->getCustomOption('number_option')->getValue();
//                $number = 1;
//                foreach ($sceneoptions as $key => $val) {
//                    if ($number <= $numberoption) {
//                    $jewel = Mage::getModel('scenescene7/sceneitem')->load($val);
//                    $price +=$jewel->getSceneitemPrice();
//                    ++$number;
//                    }
//                }
//                return $price;
//        }else {
//              return parent::getFinalPrice($qty, $product);
//        }
//    }
}