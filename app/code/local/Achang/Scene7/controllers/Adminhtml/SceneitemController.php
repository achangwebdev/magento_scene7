<?php
class Achang_Scene7_Adminhtml_SceneitemController extends Mage_Adminhtml_Controller_action{
    protected function _initSceneitem(){
        $id = $this->getRequest()->getParam('id',null);
        if ($id && (!is_array($id))) {
            $_model = Mage::getModel('scenescene7/sceneitem')->load($id);
        }else {
            $_model = Mage::getModel('scenescene7/sceneitem');
        }
        Mage::register('scenescene7_sceneitem_data',$_model);
        Mage::register('current_scenescene7_sceneitem',$_model);
        return $_model;
    }
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
        $_model = $this->_initSceneitem();
        $id = $this->getRequest()->getParam('id', null);

        if ($id && !$_model->getId()) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('scenescene7')->__('Color does not exist'));
            $this->_redirect('*/*/');
        }

        $this->_initAction();
        $this->_addBreadcrumb(Mage::helper('scenescene7')->__('Sceneitem Manager'), Mage::helper('scenescene7')->__('Sceneitem Manager'), $this->getUrl('*/*/'));
        $this->_addBreadcrumb(Mage::helper('scenescene7')->__('Add Sceneitem'), Mage::helper('adminhtml')->__('Add Sceneitem'));

        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
        $this->_addContent($this->getLayout()->createBlock('scenescene7/adminhtml_sceneitem_edit'))
                ->_addLeft($this->getLayout()->createBlock('scenescene7/adminhtml_sceneitem_edit_tabs'));

        $this->renderLayout();
        
    }
    public function newAction(){
        $this->_forward('edit');
    }
    public function saveAction(){
        if ($data = $this->getRequest()->getPost()) {
        	//var_dump($data);die();
         try
            {
            	$id = $this->getRequest()->getParam('id', null);
                $modelData = $data['sceneitem'];
            	$model = Mage::getModel('scenescene7/sceneitem')->load($id);
                if ($model->getId()) {
                    foreach ($modelData as $key => $dataItem) {
                        if ($model->getData($key) != $dataItem) {
                            $model->setData($key, $dataItem);
                        }
                    }
                } else {
                    $model->setData($modelData);
                }
                $model->save();
                Mage::getModel('scenescene7/link')->prepareSceneitemRelations($data,$model);
                //Zend_Debug::dump($data);
                // Zend_Debug::dump($model->getData());die();
                Mage::getModel('scenescene7/link')->saveSceneitemRelations($model);
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('scenescene7')->__('Sceneitem was successfully saved'));
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }
                return $this->_redirect('*/*/');
            }catch(Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setPageData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }
    public function deleteAction(){
        $id = $this->getRequest()->getParam('id');
        $sceneitem = Mage::getModel('scenescene7/sceneitem')->load($id);
        if ($sceneitem->getId()) {
        	$_model = Mage::getModel('scenescene7/sceneitem')->load($id);
        	$_model->delete();
        	Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('scenescene7')->__('Sceneitem was successfully removed'));
            return $this->_redirect('*/*/');
        }
        Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('scenescene7')->__('Something is wrong when remove this Sceneitem'));
        $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
    }
    public function massDeleteAction(){
        if (($data = $this->getRequest()->getPost()) && isset($data['scenescene7']) && count($data['scenescene7'])) {
            try {
                foreach ($data['scenescene7'] as $sceneitem_id) {
                    Mage::getModel('scenescene7/sceneitem')->load($sceneitem_id)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('scenescene7')->__('Sceneitems were successfully removed'));
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setPageData($data);
            }
        }
        else {
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('scenescene7')->__('Something is wrong when remove this Sceneitems'));
        }

        $this->_redirect('*/*/');
    }
    public function groupAction(){
    	$this->_initSceneitem();
    	$this->loadLayout();
        $this->getLayout()->getBlock('sceneitem.related.group.grid')->setRelatedGroups($this->getRequest()->getPost('related_groups', null));
    	$this->renderLayout();
    }
    public function groupgridAction(){
        $this->_initSceneitem();
        $this->loadLayout();
        $this->getLayout()->getBlock('sceneitem.related.group.grid')->setRelatedGroups($this->getRequest()->getPost('related_groups', null));
        $this->renderLayout();
    
    }
}