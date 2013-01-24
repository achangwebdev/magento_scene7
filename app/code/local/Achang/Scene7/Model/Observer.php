<?php
class Achang_Scene7_Model_Observer{
    public function groupChanged($observer){
    	$links = $observer->getLinks();
        $type = $observer->getType();
        $productGroupLinkIds = array();
        foreach ($links as $link){
            if(!isset($productGroupLinkEntitys[$link['group_id']])){
                $productIds = Mage::getModel('scenescene7/product_group_link')
                ->getCollection()->addFieldToFilter('group_id', array('eq' => $link['group_id']))
                ->getColumnValues('product_id');
                $productGroupLinkIds[$link['group_link']] = $productIds;
            }else{
                $productIds = $productGroupLinkIds[$link['group_id']];
            }
            
                    foreach ($productIds as $productId) {
                if ('insert' == $type) {
                    $productSceneitemLink = Mage::getModel('scenescene7/product_sceneitem_link');
                    $productSceneitemLink->setProductId($productId);
                    $productSceneitemLink->setSceneitemId($link['sceneitem_id']);
                    $productSceneitemLink->save();
                }
                else if ('remove' == $type) {
                   $ProductSceneitemLinks =  Mage::getModel('scenescene7/product_sceneitem_link')->getCollection()
                                             ->addFieldToFilter('sceneitem_id', array('eq' => $link['sceneitem_id']))
                                             ->addFieldToFilter('product_id', array('eq' => $productId))->load();
                   foreach ($ProductSceneitemLinks as $sceneitemLink) {
                       $sceneitemLink->delete();
                   }
                }
            }
        }	
    }
    public function sceneitemChanged($observer){
        
    }
    public function prepareProductForm(Varien_Event_Observer $observer){
        $form = $observer->getForm();
        if ($ppap = $form->getElement('default_jewelgroup')) {
        	$ppap->setRenderer(
        	Mage::app()->getLayout()->createBlock('scenescene7/adminhtml_product_edit_tabs_scenescene7_jewelgroup'));
        }
       if ($ppap = $form->getElement('default_goodsgroup')) {
            $ppap->setRenderer(
            Mage::app()->getLayout()->createBlock('scenescene7/adminhtml_product_edit_tabs_scenescene7_goodsgroup')
            );
        }
        
        return $this;
    }
    
//    public function addJewelItem($observer){
//    	$item = $observer->getQuoteItem();
//    	$src_option = $item->getOptionByCode('src_option');
//    	$item->setScene7Src($src_option['src']);
//    	$item->save();
//    }
}
