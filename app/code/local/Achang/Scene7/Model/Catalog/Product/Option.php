<?php
/**
 * Catalog product option model
 *
 * @category   Aijko
 * @package    Aijko_CustomOptionDescription
 * @author     Gerrit Pechmann <gp@aijko.de>
 * @copyright  Copyright (c) 2012, aijko GmbH (http://www.aijko.de)
 */
class Achang_Scene7_Model_Catalog_Product_Option extends Mage_Catalog_Model_Product_Option
{
	const OPTION_GROUP_SCENE7SELECT = 'scene7select';
	const OPTION_GROUP_SCENE7TEXT = 'scene7text';
	
    protected function _construct()
    {
        $this->_init('scenescene7/product_option');
    }
    
    public function getGroupByType($type = null)
    {
        if (is_null($type)) {
            $type = $this->getType();
        }
        $optionGroupsToTypes = array(
            Mage_Catalog_Model_Product_Option::OPTION_TYPE_FIELD => Mage_Catalog_Model_Product_Option::OPTION_GROUP_TEXT,
            Mage_Catalog_Model_Product_Option::OPTION_TYPE_AREA => Mage_Catalog_Model_Product_Option::OPTION_GROUP_TEXT,
            Mage_Catalog_Model_Product_Option::OPTION_TYPE_FILE => Mage_Catalog_Model_Product_Option::OPTION_GROUP_FILE,
            Mage_Catalog_Model_Product_Option::OPTION_TYPE_DROP_DOWN => Mage_Catalog_Model_Product_Option::OPTION_GROUP_SELECT,
            Mage_Catalog_Model_Product_Option::OPTION_TYPE_RADIO => Mage_Catalog_Model_Product_Option::OPTION_GROUP_SELECT,
            Mage_Catalog_Model_Product_Option::OPTION_TYPE_CHECKBOX => Mage_Catalog_Model_Product_Option::OPTION_GROUP_SELECT,
            Mage_Catalog_Model_Product_Option::OPTION_TYPE_MULTIPLE => Mage_Catalog_Model_Product_Option::OPTION_GROUP_SELECT,
            Mage_Catalog_Model_Product_Option::OPTION_TYPE_DATE => Mage_Catalog_Model_Product_Option::OPTION_GROUP_DATE,
            Mage_Catalog_Model_Product_Option::OPTION_TYPE_DATE_TIME => Mage_Catalog_Model_Product_Option::OPTION_GROUP_DATE,
            Mage_Catalog_Model_Product_Option::OPTION_TYPE_TIME => Mage_Catalog_Model_Product_Option::OPTION_GROUP_DATE,
        );
        
        $scene7groups = Achang_Scene7_Model_System_Config_Source_Product_Options_Type::getScene7OptionGroups();
        
        foreach($scene7groups as $k =>$v){
        	if(is_array($v['types'])){
        	   foreach($v['types'] as $k1=>$v1){
        	       if($v1['value'] == $type){
        	           return $k;
        	       }
        	   }
        	}
        }

        return isset($optionGroupsToTypes[$type])?$optionGroupsToTypes[$type]:'';
    }
    
    
    /**
     * Save options.
     *
     * @return Mage_Catalog_Model_Product_Option
     */
    public function saveOptions()
    {
        foreach ($this->getOptions() as $option) {
            $this->setData($option)
                ->setData('product_id', $this->getProduct()->getId())
                ->setData('store_id', $this->getProduct()->getStoreId());
            if ($this->getData('option_id') == '0') {
                $this->unsetData('option_id');
            } else {
                $this->setId($this->getData('option_id'));
            }
            $isEdit = (bool)$this->getId()? true:false;

            if ($this->getData('is_delete') == '1') {
                if ($isEdit) {
                    $this->getValueInstance()->deleteValue($this->getId());
                    $this->deletePrices($this->getId());
                    $this->deleteTitles($this->getId());
                    $this->delete();
                }
            } else {
                if ($this->getData('previous_type') != '') {
                    $previousType = $this->getData('previous_type');
                    //if previous option has dfferent group from one is came now need to remove all data of previous group
                    if ($this->getGroupByType($previousType) != $this->getGroupByType($this->getData('type'))) {

                        switch ($this->getGroupByType($previousType)) {
                            case Mage_Catalog_Model_Product_Option::OPTION_GROUP_SELECT:
                            	if($this->getGroupByType($this->getData('type')) != self::OPTION_GROUP_SCENE7SELECT){
                            	   $this->unsetData('values');
                            	   if ($isEdit) {
	                                    $this->getValueInstance()->deleteValue($this->getId());
	                               }
                            	}else{
                            	   $values = $this->getData('values');
                            	   foreach($values as $k=>$value){
                            	       if($value['option_type_id'] > 0){
                            	       	   unset($values[$k]);
                            	       }
                            	   }
                            	   $this->setData('values',$values);
                            	   if ($isEdit) {
                                        $this->getValueInstance()->deleteValue($this->getId());
                                   }
                            	}
                                

                                break;
                            /**
                             * addedd by Minglong
                             */
                            case self::OPTION_GROUP_SCENE7SELECT:
                                if($this->getGroupByType($this->getData('type')) != Mage_Catalog_Model_Product_Option::OPTION_GROUP_SELECT){
                                   $this->unsetData('values');
                                   if ($isEdit) {
	                                    $this->getValueInstance()->deleteValue($this->getId());
	                               }
                                }else{
                                   $values = $this->getData('values');
                                   foreach($values as $k=>$value){
                                       if($value['option_type_id'] > 0){
                                           unset($values[$k]);
                                       }
                                   }
                                   $this->setData('values',$values);
                                   if ($isEdit) {
                                        $this->getValueInstance()->deleteValue($this->getId());
                                   }
                                }
   
                                break;
                             /**
                             * ended by Minglong
                             */
                            case Mage_Catalog_Model_Product_Option::OPTION_GROUP_FILE:
                                $this->setData('file_extension', '');
                                $this->setData('image_size_x', '0');
                                $this->setData('image_size_y', '0');
                                break;
                            case Mage_Catalog_Model_Product_Option::OPTION_GROUP_TEXT:
                                if($this->getGroupByType($this->getData('type')) !=  self::OPTION_GROUP_SCENE7TEXT){
                                    $this->setData('max_characters', '0');
                                }
                                break;
                            case Mage_Catalog_Model_Product_Option::OPTION_GROUP_DATE:
                                break;
                            case self::OPTION_GROUP_SCENE7TEXT:
                            	if($this->getGroupByType($this->getData('type')) != Mage_Catalog_Model_Product_Option::OPTION_GROUP_SELECT && $this->getGroupByType($this->getData('type')) != self::OPTION_GROUP_SCENE7SELECT){
                            		
                            	}else{
                            		
                            	}
                                break;
                        }
                        if ($this->getGroupByType($this->getData('type')) == Mage_Catalog_Model_Product_Option::OPTION_GROUP_SELECT || $this->getGroupByType($this->getData('type')) == self::OPTION_GROUP_SCENE7SELECT) {
                            $this->setData('sku', '');
                            $this->unsetData('price');
                            $this->unsetData('price_type');
                            if ($isEdit) {
                                $this->deletePrices($this->getId());
                            }
                        }
                    }
                }
                $this->save();            }
        }//eof foreach()
        return $this;
    }

    protected function _afterSave()
    {
        $this->getValueInstance()->unsetValues();
        if (is_array($this->getData('values'))) {
            foreach ($this->getData('values') as $value) {
                $this->getValueInstance()->addValue($value);
            }

            $this->getValueInstance()->setOption($this)
                ->saveValues();
        } elseif ($this->getGroupByType($this->getType()) == Mage_Catalog_Model_Product_Option::OPTION_GROUP_SELECT || $this->getGroupByType($this->getType()) == self::OPTION_GROUP_SCENE7SELECT) {
            Mage::throwException(Mage::helper('catalog')->__('Select type options required values rows.'));
        }

        Mage_Core_Model_Abstract::_afterSave();
    }
    
    
    /**
     * Get Product Option Collection
     *
     * @param  Mage_Catalog_Model_Product $product
     * @return Aijko_CustomOptionDescription_Model_Resource_Eav_Mysql4_Product_Option_Collection
     */
    public function getProductOptionCollection(Mage_Catalog_Model_Product $product)
    {
        $collection = $this->getCollection()
            ->addFieldToFilter('product_id', $product->getId())
            ->addTitleToResult($product->getStoreId())
            ->addPriceToResult($product->getStoreId())
            ->addDescriptionToResult($product->getStoreId())
            ->setOrder('sort_order', 'asc')
            ->setOrder('title', 'asc')
            ->addValuesToResult($product->getStoreId());
        
        return $collection;
    }
    
    /**
     * Group model factory
     *
     * @param string $type Option type
     * @return Mage_Catalog_Model_Product_Option_Group_Abstract
     */
    public function groupFactory($type)
    {
        $group = $this->getGroupByType($type);
        if ($group == self::OPTION_GROUP_SCENE7SELECT){
            return Mage::getModel('scenescene7/catalog_product_option_type_' . $group);
        }
        if ($group == self::OPTION_GROUP_SCENE7TEXT){
            return Mage::getModel('scenescene7/catalog_product_option_type_' . $group);
        }
        if (!empty($group)) {
            return Mage::getModel('catalog/product_option_type_' . $group);
        }
        
        Mage::throwException(Mage::helper('catalog')->__('Wrong option type to get group instance.'));
    }
}