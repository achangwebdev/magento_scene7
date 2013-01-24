<?php
class Achang_Scene7_Model_Goodscore extends Mage_Core_Model_Abstract{
    public function getBaseUrl(){
        $baseUrl = Mage::getStoreConfig('scenescene7/scene7settings/scene7_main_url');
        return $baseUrl;
    }
    
    public function getCompanyName(){
        $companyName = Mage::getStoreConfig('scenescene7/scene7settings/scene7_company');
        return $companyName;
    }
    
    public function getGoodsParam(){
        $goodsparam = Mage::getStoreConfig('scenescene7/scene7settings/scene7_goods_param');
        return $goodsparam;
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
        //Zend_Debug::dump($product->getData());         
        $templateName = $product->getScene7Template();        
        return $templateName;   
    }
    
    //http://s7ap1.scene7.com/is/image/china/
    public function getSceneTemplate(){
        //1.get base jewel bracket url
        $baseUrl = $this->getBaseUrl();
        $co = $this->getCompanyName();
        $sceneTemplate = $baseUrl.$co.'/';
        return $sceneTemplate;
    }
    //http://s7ap1.scene7.com/is/image/china/test2-4
    public function getDefaultSceneTemplate(){
        $template = $this->getTemplateName();
        $sceneDefaultTemplate = $this->getSceneTemplate().$template;
        return $sceneDefaultTemplate;
    }
    //?qlt=100,1&wid=360&hei=360&&op_sharpen=1
    public function getSceneParams(){
        $size = array(300,300);
        $hei = $size[0];
        $wid = $size[1];
        $sceneParams = '?qlt=100,1'.'&hei='.$hei.'&wei='.$wid.'&op_sharpen=1';
        return $sceneParams;
    }
    //http://s7ap1.scene7.com/is/image/china/test2-4?qlt=100,1&wid=360&hei=360&&op_sharpen=1
    public function getUrl(){
        $url = $this->getDefaultSceneTemplate().$this->getSceneParams();
        return $url;
    }
    
    public function getDefault(){
        $product = $this->getProduct();
        $default = $product->getDefaultGoodsgroup();
        $n = count($default);
        $goodsparam = '';

        $co = $this->getCompanyName();
        for ($i = 1; $i <= $n; $i++) {
            $position = $default[$i-1]['position'];
            $goodsId = $default[$position-1]['default_goods'];
            $defaulgoods = Mage::getModel('scenescene7/sceneitem')->load($goodsId)->getCode();
            $goodsparam .= "&$".$this->getGoodsParam().$i."=is{".$co.'/'.$defaulgoods."}";
        }
        return $goodsparam;
    }
    
    public function toUrl(){
        $goodsUrl = $this->getUrl().$this->getDefault();
        return $goodsUrl;
    }
}
