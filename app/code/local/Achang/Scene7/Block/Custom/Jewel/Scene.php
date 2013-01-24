<?php
class Achang_Scene7_Block_Custom_Jewel_Scene extends Mage_Catalog_Block_Product_View{
    public function getCoName(){
        $co = Mage::getModel('scenescene7/jewelcore')->getCompanyName();
        return $co;
    }
    //http://s7d6.scene7.com/is/image/china/
    public function getSceneTemplate(){
        $product = $this->getProduct();
        $sceneTemplate = Mage::getModel('scenescene7/jewelcore')->setProduct($product)->getSceneTemplate();
        return $sceneTemplate;
    }
    //test3
    public function getTemplateName(){
        $product = $this->getProduct();
        $templateName = Mage::getModel('scenescene7/jewelcore')->setProduct($product)->getTemplateName();
        return $templateName;
    }
    //?qlt=100,1&hei=300&wei=300&op_sharpen=1
    public function getSceneParams(){
        $sceneParams = Mage::getModel('scenescene7/jewelcore')->getSceneParams();
        return $sceneParams;
    }
    public function getScene7Param(){
        $sceneparam = Mage::getModel('scenescene7/jewelcore')->getParam();
        return $sceneparam;
    }
    public function getProduct()
    {
        if (!$this->hasData('product')) {
            $this->setData('product', Mage::registry('product'));
        }
        return $this->getData('product');
    }
    public function getJewelsJson(){
        $product = $this->getProduct();
        $groups = $product->getDefaultJewelgroup();
        $jewelArr = array();
        foreach($groups as $k=>$group ){
            $jewelLink = Mage::getModel('scenescene7/link')->getCollection()
            ->addFieldToFilter('group_id',$group['jewel_group'])->load();
            foreach($jewelLink as $link){
                if(!isset($jewelArr[$link->getSceneitemId()])){
                    $jewel = Mage::getModel('scenescene7/sceneitem')->load($link->getSceneitemId());
                    $jewelArr[$link->getSceneitemId()] = array(
                    'name'=>$jewel->getName(),
                    'code'=>$jewel->getCode(),
                    'price'=>$jewel->getSceneitemPrice()
                    ); 
                }
            }
        }
       
       return Zend_Json::encode($jewelArr);
    }

}