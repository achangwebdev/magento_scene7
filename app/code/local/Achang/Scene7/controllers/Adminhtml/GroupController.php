<?php
class Achang_Scene7_Adminhtml_GroupController extends Mage_Adminhtml_Controller_action{
    protected function _initAction(){
        $this->loadLayout()
            ->_setActiveMenu('catalog')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
        return $this;
    }
    public function indexAction(){
        $this->_initAction()
            ->renderLayout();
    }
    public function editAction(){
        $id     = $this->getRequest()->getParam('id');
        $model  = Mage::getModel('scenescene7/group')->load($id);
        if($model->getId()||$id == 0){
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if(!empty($data)){
                $model->setData($data);
            }
            Mage::register('scenescene7group_data',$model);
            //var_dump(Mage::registry('scenescene7group_data',$model)->getData());die();
            $this->loadLayout();

            $this->_setActiveMenu('catalog');
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'),Mage::helper('adminhtml')->__('Item Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item New'),Mage::helper('adminhtml')->__('Item New'));
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            
            $this->_addContent($this->getLayout()->createBlock('scenescene7/adminhtml_group_edit'))
                ->_addLeft($this->getLayout()->createBlock('scenescene7/adminhtml_group_edit_tabs'));
            $this->renderLayout();
        }else{
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('scenescene7')->__('Item does not exist'));
            $this->_redirect('*/*/');
        }
    }
    public function newAction(){
        $this->_forward('edit');
    }
    public function saveAction(){
        if ($data = $this->getRequest()->getPost()) {
            $model = Mage::getModel('scenescene7/group');
            $model->setData($data)
            ->setId($this->getRequest()->getParam('id'));
            try{
                if ($model->getCreatedTime() == NULL || $model->getUpdateTime() == NULL) {
                    $model->setCreatedTime(now())
                        ->setUpdateTime(now());
                } else {
                    $model->setUpdateTime(now());
                }  
                $model->save();
                Mage::getModel('scenescene7/link')->prepareGroupRelations($data,$model);
//                Zend_Debug::dump($data);
//                Zend_Debug::dump($model->getData());die();
                Mage::getModel('scenescene7/link')->saveGroupRelations($model);
                //var_dump(Mage::getModel('scenescene7/link')->getCollection()->getData());die();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('scenescene7')->__('Sceneitem Group was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            }catch (Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('scenescene7')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }
    public function deleteAction(){
        if ($this->getRequest()->getParam('id')>0) {
            try{
                $model = Mage::getModel('scenescene7/group');
                $model->setId($this->getRequest()->getParam('id'))->delete();
                
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
                $this->_redirect('*/*/');
           }catch (Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
           }
        }
        $this->_redirect('*/*/');
    }
    public function massDeleteAction(){
        $scenescene7groupIds = $this->getRequest()->getParam('scenescene7group');
        if(!is_array($scenescene7groupIds)){
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        }else{
            try {
                foreach ($scenescene7groupIds as $scenescene7groupId) {
                    $scenescene7group = Mage::getModel('scenescene7/group')->load($scenescene7groupId);
                    $scenescene7group->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($scenescene7groupIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
         $this->_redirect('*/*/index');
    }
    public function relatedSceneitemsGridAction(){
        $this->loadLayout();
        $this->getLayout()->getBlock('related_sceneitems.grid')
        ->setRelatedSceneitems($this->getRequest()->getPost('related_sceneitems', null));
        $this->renderLayout();
    }

    public function relatedSceneitemsAction(){
        $this->loadLayout();
        $this->getLayout()->getBlock('related_sceneitems.grid')
        ->setRelatedSceneitems($this->getRequest()->getPost('related_sceneitems', null));
        $this->renderLayout();
    }
}