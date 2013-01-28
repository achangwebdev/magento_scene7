<?php
class Achang_Scene7_Block_Adminhtml_Attribute extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_attribute';
    $this->_blockGroup = 'scenescene7';
    $this->_headerText = Mage::helper('scenescene7')->__('Attributes Manager');
    $this->_addButtonLabel = Mage::helper('scenescene7')->__('Add Attribute');
    parent::__construct();
  }
}