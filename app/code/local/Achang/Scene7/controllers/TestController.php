<?php
/**
 * @author yxq
 *
 */
class Achang_Scene7_TestController extends Mage_Core_Controller_Front_Action{
    public function indexAction(){
        //$base = Mage::getModel("scenescene7/core")->getBaseCompany().'/test2'.Mage::getModel("scenescene7/core")->getValues().'?qlt=100,1&wid=360&hei=360&op_sharpen=1';
        //echo "<img src=".$base." alt='no image'/>";
        //$base = Mage::getModel('scenescene7/core')->getProduct();
        var_dump($base);die();
    }
}