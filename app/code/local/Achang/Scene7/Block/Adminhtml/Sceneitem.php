<?php
class Achang_Scene7_Block_Adminhtml_Sceneitem extends Mage_Adminhtml_Block_Widget_Grid_Container{
    public function __construct(){
        $this->_controller = 'adminhtml_sceneitem';
        $this->_blockGroup = 'scenescene7';
        $this->_headerText = Mage::helper('scenescene7')->__('Sceneitem Manager');
        $this->_addButtonLabel = Mage::helper('scenescene7')->__('Add Sceneitem');
        parent::__construct();
    }
}