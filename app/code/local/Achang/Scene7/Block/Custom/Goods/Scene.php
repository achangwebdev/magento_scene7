<?php
class Achang_Scene7_Block_Custom_Goods_Scene extends Mage_Catalog_Block_Product_View{
    public function getCoName(){
        $co = Mage::getModel('scenescene7/goodscore')->getCompanyName();
        return $co;
    }
    public function getScene7Url(){
        $product = $this->getProduct();
        $url = Mage::getModel('scenescene7/goodscore')->setProduct($product)->getUrl();
        return $url;
    }
    public function getScene7Param(){
        $goodsparam = Mage::getModel('scenescene7/goodscore')->getGoodsParam();
        return $goodsparam;
    }
    public function getProduct()
    {
        if (!$this->hasData('product')) {
            $this->setData('product', Mage::registry('product'));
        }
        return $this->getData('product');
    }
    public function getGoodssJson(){
        $product = $this->getProduct();
        $groups = $product->getDefaultGoodsgroup();
        $goodsArr = array();
        foreach($groups as $k=>$group ){
            $jewelLink = Mage::getModel('scenescene7/link')->getCollection()
            ->addFieldToFilter('group_id',$group['goods_group'])->load();
            foreach($jewelLink as $link){
                if(!isset($jewelArr[$link->getSceneitemId()])){
                    $goods = Mage::getModel('scenescene7/sceneitem')->load($link->getSceneitemId());
                    $goodsArr[$link->getSceneitemId()] = array(
                    'name'=>$goods->getName(),
                    'code'=>$goods->getCode(),
                    'price'=>$goods->getSceneitemPrice()
                    ); 
                }
            }
        }
       
       return Zend_Json::encode($goodsArr);
    }
}