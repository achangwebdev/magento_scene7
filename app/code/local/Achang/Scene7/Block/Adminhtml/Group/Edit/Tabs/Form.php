<?php
class Achang_Scene7_Block_Adminhtml_Group_Edit_Tabs_Form extends Mage_Adminhtml_Block_Widget_Form{
    public function _prepareForm(){
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('scenescene7group_form',array('legend'=>Mage::helper('scenescene7')->__('General')));
        
        $fieldset->addField('name','text',array(
        'label'     =>Mage::helper('scenescene7')->__('Name'),
        'name'      =>'name',
        'class'     =>'required-entry',
        'required'  =>true,
        ));
        
        if(Mage::getSingleton('adminhtml/session')->getScenescene7groupData()){
            $form->setValues(Mage::getSingleton('adminhtml/sesssion')->getScenescene7groupData());
            Mage::getSingleton('adminhtml/sesssion')->getScenescene7groupData(null);
        }elseif(Mage::registry('scenescene7group_data')){
            $form->setValues(Mage::registry('scenescene7group_data')->getData());
        }
        return parent::_prepareForm();
    }
}