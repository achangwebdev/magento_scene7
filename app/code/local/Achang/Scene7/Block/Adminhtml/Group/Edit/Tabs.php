<?php
class Achang_Scene7_Block_Adminhtml_Group_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs{
    public function __construct(){
        parent::__construct();
        $this->setId('scenescene7_group_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('scenescene7')->__('Sceneitem Group Information'));
    }
    
    protected function _beforeToHtml(){
    	$this->addTab('form_section',array(
    	'label'    => Mage::helper('scenescene7')->__('General'),
    	'title'    => Mage::helper('scenescene7')->__('General'),
    	'content'  => $this->getLayout()->createBlock('scenescene7/adminhtml_group_edit_tabs_form')->toHtml(),
    	));
    	$this->addTab('sceneitem',array(
    	'label'=>Mage::helper('scenescene7')->__('Related Sceneitems'),
    	'title'=>Mage::helper('scenescene7')->__('Related Sceneitems'),
    	'class'=>ajax,
    	'url'=>$this->getUrl('*/*/relatedsceneitems',array('_current' => true)),
    	));
        return parent::_beforeToHtml();
    }
}