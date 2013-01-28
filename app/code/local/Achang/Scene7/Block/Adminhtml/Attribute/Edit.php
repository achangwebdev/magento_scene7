<?php

class Achang_Scene7_Block_Adminhtml_Attribute_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'scenescene7';
        $this->_controller = 'adminhtml_attribute';
        
        $this->_updateButton('save', 'label', Mage::helper('scenescene7')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('scenescene7')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('attribute_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'attribute_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'attribute_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('attribute_data') && Mage::registry('attribute_data')->getId() ) {
            return Mage::helper('scenescene7')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('attribute_data')->getTitle()));
        } else {
            return Mage::helper('scenescene7')->__('Add Item');
        }
    }
}