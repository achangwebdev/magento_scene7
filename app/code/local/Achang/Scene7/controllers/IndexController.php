<?php

class Achang_Scene7_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $datas = $this->getRequest()->getPost();
        $product = Mage::getModel('catalog/product')->load($datas['product']);
        $url = Mage::getModel('scenescene7/scene7')->setProduct($product)->setOptions($datas['options'])->toUrl();
        if($url){
            $arr = array('result'=>'ok','url'=>$url);
        }else{
            $arr = array('result'=>'failed','error'=>'error');
        }
       // Mage::log($arr);
        echo Zend_Json::encode($arr);die();
    }
}
