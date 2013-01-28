<?php

class Achang_Scene7_Block_Adminhtml_Attribute_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('attribute_form', array('legend'=>Mage::helper('scenescene7')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('scenescene7')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

     $fieldset->addField('scene7_code', 'text', array(
          'label'     => Mage::helper('scenescene7')->__('Scene7 Code'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'scene7_code',
      ));
		
       $fieldset->addField('attribute_code', 'text', array(
          'label'     => Mage::helper('scenescene7')->__('Attribute Code'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'attribute_code',
      ));    
      
      
      $fieldset->addField('type', 'select', array(
          'label'     => Mage::helper('scenescene7')->__('Attribute Type'),
          'name'      => 'type',
          'values'    => array(
              array(
                  'value'     => Achang_Scene7_Model_Status::SCENE7TEXT,
                  'label'     => Mage::helper('scenescene7')->__('Scene7 Text'),
              ),

              array(
                  'value'     => Achang_Scene7_Model_Status::SCENE7SELECT,
                  'label'     => Mage::helper('scenescene7')->__('Scene7 Select'),
              ),
          ),
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getAttributeData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getAttributeData());
          Mage::getSingleton('adminhtml/session')->setAttributeData(null);
      } elseif ( Mage::registry('attribute_data') ) {
          $form->setValues(Mage::registry('attribute_data')->getData());
      }
      return parent::_prepareForm();
  }
}