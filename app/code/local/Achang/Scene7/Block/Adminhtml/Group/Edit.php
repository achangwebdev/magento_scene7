<?php
class Achang_Scene7_Block_Adminhtml_Group_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'scenescene7';
        $this->_controller = 'adminhtml_group';
        
        $this->_updateButton('save', 'label', Mage::helper('scenescene7')->__('Save Group'));
        $this->_updateButton('delete', 'label', Mage::helper('scenescene7')->__('Delete Group'));
        
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('scenescene7group_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'scenescene7group_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'scenescene7group_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('scenescene7group_data') && Mage::registry('scenescene7group_data')->getId() ) {
            return Mage::helper('scenescene7')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('scenescene7group_data')->getName()));
        } else {
            return Mage::helper('scenescene7')->__('Add Item');
        }
    }
}