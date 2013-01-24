<?php
class Achang_Scene7_Model_Sceneitem extends Mage_Core_Model_Abstract{
    const ENTITY = 'scenescene7';
    protected $_eventPrefix = 'scenescene7';
    protected $_eventObject = 'sceneitem';
    
    public function _construct(){
        parent::_construct();
        $this->_init('scenescene7/sceneitem');
    }
    public function getSceneTypeOptionArray(){
       $product = Mage::getModel('catalog/product');
        $source = $product->getResource()->getAttribute('scene_type')->getSource();
        $options = $source->getAllOptions(true, true);
        
        $returnOption = array();
        foreach($options as $key => $val) {
            $returnOption[$val['value']] = $val['label'];
        }
        return $returnOption;
    }
}