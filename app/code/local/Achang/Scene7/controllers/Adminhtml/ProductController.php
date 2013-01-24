<?php
require_once 'Mage/Adminhtml/controllers/Catalog/ProductController.php';
class Achang_Scene7_Adminhtml_ProductController extends Mage_Adminhtml_Catalog_ProductController{
    protected function _initAction(){
        $this->loadLayout()
        ->_setActiveMenu('catalog')
        ->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'),Mage::helper('adminhtml')->__('Items Manager'));
        return $this;
    }
    
    public function indexAction(){
        $this->_initAction()->renderLayout();
    }
    
//    public function relatedSceneScene7Action(){
//        $this->getResponse()->setBody(
//            $this->getLayout()->createBlock('scenescene7/adminhtml_product_edit_tabs_scenescene7_jewelgroup', 'admin.product.scene7')->toHtml()
//        );
//    }
}