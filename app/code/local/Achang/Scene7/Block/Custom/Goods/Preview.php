<?php
class Achang_Scene7_Block_Custom_Goods_Preview extends Mage_Core_Block_Template{
    public function getProduct()
    {
        if (!$this->hasData('product')) {
            $this->setData('product', Mage::registry('product'));
        }
        return $this->getData('product');
    }
    
    public function getImg(){
        $product = $this->getProduct();
        $img = Mage::getModel('scenescene7/goodscore')->setProduct($product)->toUrl();
        return $img;
    }
}