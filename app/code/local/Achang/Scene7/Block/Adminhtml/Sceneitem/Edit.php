<?php
class Achang_Scene7_Block_Adminhtml_Sceneitem_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{
    public function __construct(){
        parent::__construct();
        $this->_objectId    = 'id';
        $this->_blockGroup  = 'scenescene7';
        $this->_controller  = 'adminhtml_sceneitem';
        
        $this->_updateButton('save','label',Mage::helper('scenescene7')->__('Save Sceneitem'));
        $this->_addButton('saveandcontinue',array(
            'label'     =>Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   =>'saveAndContinueEdit()',
            'class'     =>'save',
        ),-100);
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
        $this->setId('sceneitem_edit');
    }
    public function getHeaderText(){
    	Mage::helper('scenescene7')->__('Add Sceneitem');
    }
}