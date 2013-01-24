<?php
class Achang_Scene7_Block_Adminhtml_Sceneitem_Edit_Tabs_Form extends Mage_Adminhtml_Block_Widget_Form{
    public function getSceneitem(){
        if (!($this->getData('sceneitem') instanceof Achang_Scene7_Model_Sceneitem)) {
            $this->setData('sceneitem', Mage::registry('scenescene7_sceneitem_data'));
        }
        return $this->getData('sceneitem');
    }
    protected function _prepareForm(){
        $form = new Varien_Data_Form();
        $form->setDataObject(Mage::registry('scenescene7_sceneitem_data')); 
        
        $currentSceneitem = Mage::registry('current_scenescene7_sceneitem');
        $values = $currentSceneitem->getData();

        $cacheKey = 'scenescene7_sceneitem_attribute';
        $attributes = unserialize(MAGE::app()->loadCache($cacheKey));
        if(!$attributes){
            $attributes = Mage::getResourceModel('eav/entity_attribute_collection')->setEntityTypeFilter('31')->load();
            Mage::app()->saveCache(serialize($attributes), $cacheKey, array('static'));
        }
        $fieldset = $form->addFieldset('general',array(
            'legend'=>'general',
            'class'=>'fieldset-wide',
        ));
        //Zend_Debug::dump($attributes->getData());die();
        $this->_setFieldset($attributes,$fieldset);
        if(!$currentSceneitem->getId()){
            foreach($attributes as $attribute){
                if(!isset($values[$attribute->getAttributeCode()])){
                    $values[$attribute->getAttributeCode()] = $attribute->getDefaultValue();
                }
            }
        }
        
        $form->addValues($values);
        $form->setFieldNameSuffix('sceneitem');
        $this->setForm($form);
        return parent::_prepareForm();
    }
}