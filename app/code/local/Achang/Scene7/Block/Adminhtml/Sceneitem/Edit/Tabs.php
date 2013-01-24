<?php
class Achang_Scene7_Block_Adminhtml_Sceneitem_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs{
    public function __construct(){
        parent::__construct();
        $this->setId('scenescene7_sceneitem_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('scenescene7')->__('Sceneitem Information'));
    }
    protected function _beforeToHtml(){
        $this->addTab('general_section',array(
            'label'     => Mage::helper('scenescene7')->__('Basic Information'),
            'title'     => Mage::helper('scenescene7')->__('Basic Information'),
            'content'   => $this->getLayout()->createBlock('scenescene7/adminhtml_sceneitem_edit_tabs_form')->toHtml(),
        ));
        $this->addTab('group_section',array(
            'label' => Mage::helper('scenescene7')->__('Group'),
            'title' => Mage::helper('scenescene7')->__('Group'),
            'url'   => $this->getUrl('*/*/group', array('_current' => true)),
            'class' => 'ajax',
        ));
        return parent::_beforeToHtml();
    }
}