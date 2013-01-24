<?php
/**
 * @author yxq
 *
 */
class Achang_Scene7_Model_Jewelcore extends Mage_Core_Model_Abstract{
    /*
     * get static values1 
     * */
    public function getBaseUrl(){
        $baseUrl = Mage::getStoreConfig('scenescene7/scene7settings/scene7_main_url');
        return $baseUrl;
    }
    public function getCompanyName(){
        $companyName = Mage::getStoreConfig('scenescene7/scene7settings/scene7_company');
        return $companyName;
    }
    public function getParam(){
        $param = Mage::getStoreConfig('scenescene7/scene7settings/scene7_jewel_param');
        return $param;
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
        $templateName = $product->getScene7Template();        
        return $templateName;   
    }
    public function getJewelDefaultNumber(){
        $product = $this->getProduct();          
        $defaultNumber = $product->getJewelDefaultNumber();        
        return $defaultNumber;   
    }
    /*
     *  http://s7ap1.scene7.com/is/image/china/test2?qlt=100,1&wid=360&hei=360&&op_sharpen=1
     *  &$dim4=is{china/green3?rotate=40}
     *  &$dim3=is{china/blue3?rotate=40}
     *  &$dim2=is{china/white3?rotate=40}
     *  &$dim1=is{china/pink3?rotate=30}
     * */
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
        $defaultNumber = $this->getJewelDefaultNumber();
        $sceneDefaultTemplate = $this->getSceneTemplate().$template.'-'.$defaultNumber;
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
    //
    public function getDefault(){
        $product = $this->getProduct();
        $default = $product->getDefaultJewelgroup();
        $n = count($default);
        $angle = array();
        $jewelparam = '';
        for ($i = 1; $i <= $n; $i++) {
            $position = $default[$i-1]['position'];
            $jewelId = $default[$position-1]['default_jewel'];
            $angle   = $default[$position-1]['angle'];
            $defauljewel = Mage::getModel('scenescene7/sceneitem')->load($jewelId)->getCode();
            $jewelparam .= "&$" . $this->getParam() . $i . "=is{" . $this->getCompanyName() . "/" . $defauljewel . "?rotate=" . $angle .'}';
        }
        return $jewelparam;
    }
    public function toUrl(){
        $jewelUrl = $this->getUrl().$this->getDefault();
        return $jewelUrl;
    }
}