<?php
class Achang_Scene7_Model_Sceneitem_Attribute_Source_Scenetype extends Mage_Eav_Model_Entity_Attribute_Source_Abstract{
    protected $_optionsDefault = array();

    public function getAllOptions($withEmpty = true, $defaultValues = false)
    {
        $cacheKey = 'scenetype_options';
        $datas = unserialize(MAGE::app()->loadCache($cacheKey));
        if (!empty($datas)) {
            return $datas;
        }

        $product = Mage::getModel('catalog/product');
        $source = $product->getResource()->getAttribute('scene_type')->getSource();
        $options = $source->getAllOptions(true, true);
        
        $returnOption = array(''=>'None');
        foreach($options as $key => $val) {
            if($val['value']!="") {
                $brandKey = $val['value'] ;
                $returnOption[$brandKey] = $val['label'];
            }
        }


        Mage::app()->saveCache(serialize($returnOption), $cacheKey, array('scenetype_options_tag'));
        $this->_options = $returnOption;
        return $this->_options;
    }

    public function getOptionText($value)
    {
        if(!$value)$value ='0';
        $isMultiple = false;
        if (strpos($value, ',')) {
            $isMultiple = true;
            $value = explode(',', $value);
        }

        if (!$this->_options) {
            $this->getAllOptions();
        }

        if ($isMultiple) {
            $values = array();
            foreach ($value as $val) {
                $values[] = $this->_options[$val]['value'];
            }
            return $values;
        }
        else {
            return $this->_options[$value]['value'];
        }
    }
}