<?php
/**
 * Catalog product custom option resource model
 *
 * @category   Aijko
 * @package    Aijko_CustomOptionDescription
 * @author     Gerrit Pechmann <gp@aijko.de>
 * @copyright  Copyright (c) 2012, aijko GmbH (http://www.aijko.de)
 */
class Achang_Scene7_Model_Resource_Product_Option extends Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Option
{
    protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
    	
        $priceTable = $this->getTable('catalog/product_option_price');
        $titleTable = $this->getTable('catalog/product_option_title');

        
        $opt = new Achang_Scene7_Model_Catalog_Product_Option();
        $issvene7text = false;
        if($opt->getGroupByType($object->getType()) == 'scene7text'){
            $issvene7text = true;
        }
        //better to check param 'price' and 'price_type' for saving. If there is not price scip saving price
        if ($object->getType() == Mage_Catalog_Model_Product_Option::OPTION_TYPE_FIELD
            || $object->getType() == Mage_Catalog_Model_Product_Option::OPTION_TYPE_AREA
            || $object->getType() == Mage_Catalog_Model_Product_Option::OPTION_TYPE_FILE
            || $object->getType() == Mage_Catalog_Model_Product_Option::OPTION_TYPE_DATE
            || $object->getType() == Mage_Catalog_Model_Product_Option::OPTION_TYPE_DATE_TIME
            || $object->getType() == Mage_Catalog_Model_Product_Option::OPTION_TYPE_TIME
            || $issvene7text
        ) {

            //save for store_id = 0
            if (!$object->getData('scope', 'price')) {
                $statement = $this->_getReadAdapter()->select()
                    ->from($priceTable)
                    ->where('option_id = '.$object->getId().' AND store_id = ?', 0);
                if ($this->_getReadAdapter()->fetchOne($statement)) {
                    if ($object->getStoreId() == '0') {
                        $this->_getWriteAdapter()->update(
                            $priceTable,
                            array(
                                'price' => $object->getPrice(),
                                'price_type' => $object->getPriceType()
                            ),
                            $this->_getWriteAdapter()->quoteInto('option_id = '.$object->getId().' AND store_id = ?', 0)
                        );
                    }
                } else {
                    $this->_getWriteAdapter()->insert(
                        $priceTable,
                        array(
                            'option_id' => $object->getId(),
                            'store_id' => 0,
                            'price' => $object->getPrice(),
                            'price_type' => $object->getPriceType()
                        )
                    );
                }
            }

            $scope = (int) Mage::app()->getStore()->getConfig(Mage_Core_Model_Store::XML_PATH_PRICE_SCOPE);

            if ($object->getStoreId() != '0' && $scope == Mage_Core_Model_Store::PRICE_SCOPE_WEBSITE
                && !$object->getData('scope', 'price')) {

                $baseCurrency = Mage::app()->getBaseCurrencyCode();

                $storeIds = Mage::app()->getStore($object->getStoreId())->getWebsite()->getStoreIds();
                if (is_array($storeIds)) {
                    foreach ($storeIds as $storeId) {
                        if ($object->getPriceType() == 'fixed') {
                            $storeCurrency = Mage::app()->getStore($storeId)->getBaseCurrencyCode();
                            $rate = Mage::getModel('directory/currency')->load($baseCurrency)->getRate($storeCurrency);
                            if (!$rate) {
                                $rate=1;
                            }
                            $newPrice = $object->getPrice() * $rate;
                        } else {
                            $newPrice = $object->getPrice();
                        }
                        $statement = $this->_getReadAdapter()->select()
                            ->from($priceTable)
                            ->where('option_id = '.$object->getId().' AND store_id = ?', $storeId);

                        if ($this->_getReadAdapter()->fetchOne($statement)) {
                            $this->_getWriteAdapter()->update(
                                $priceTable,
                                array(
                                    'price' => $newPrice,
                                    'price_type' => $object->getPriceType()
                                ),
                                $this->_getWriteAdapter()->quoteInto('option_id = '.$object->getId().' AND store_id = ?', $storeId)
                            );
                        } else {
                            $this->_getWriteAdapter()->insert(
                                $priceTable,
                                array(
                                    'option_id' => $object->getId(),
                                    'store_id' => $storeId,
                                    'price' => $newPrice,
                                    'price_type' => $object->getPriceType()
                                )
                            );
                        }
                    }// end foreach()
                }
            } elseif ($scope == Mage_Core_Model_Store::PRICE_SCOPE_WEBSITE && $object->getData('scope', 'price')) {
                $this->_getWriteAdapter()->delete(
                    $priceTable,
                    $this->_getWriteAdapter()->quoteInto('option_id = '.$object->getId().' AND store_id = ?', $object->getStoreId())
                );
            }
        }

        //title
        if (!$object->getData('scope', 'title')) {
            $statement = $this->_getReadAdapter()->select()
                ->from($titleTable)
                ->where('option_id = '.$object->getId().' and store_id = ?', 0);

            if ($this->_getReadAdapter()->fetchOne($statement)) {
                if ($object->getStoreId() == '0') {
                    $this->_getWriteAdapter()->update(
                        $titleTable,
                            array('title' => $object->getTitle()),
                            $this->_getWriteAdapter()->quoteInto('option_id='.$object->getId().' AND store_id=?', 0)
                    );
                }
            } else {
                $this->_getWriteAdapter()->insert(
                    $titleTable,
                        array(
                            'option_id' => $object->getId(),
                            'store_id' => 0,
                            'title' => $object->getTitle()
                ));
            }
        }

        if ($object->getStoreId() != '0' && !$object->getData('scope', 'title')) {
            $statement = $this->_getReadAdapter()->select()
                ->from($titleTable)
                ->where('option_id = '.$object->getId().' and store_id = ?', $object->getStoreId());

            if ($this->_getReadAdapter()->fetchOne($statement)) {
                $this->_getWriteAdapter()->update(
                    $titleTable,
                        array('title' => $object->getTitle()),
                        $this->_getWriteAdapter()
                            ->quoteInto('option_id='.$object->getId().' AND store_id=?', $object->getStoreId()));
            } else {
                $this->_getWriteAdapter()->insert(
                    $titleTable,
                        array(
                            'option_id' => $object->getId(),
                            'store_id' => $object->getStoreId(),
                            'title' => $object->getTitle()
                ));
            }
        } elseif ($object->getData('scope', 'title')) {
            $this->_getWriteAdapter()->delete(
                $titleTable,
                $this->_getWriteAdapter()->quoteInto('option_id = '.$object->getId().' AND store_id = ?', $object->getStoreId())
            );
        }
    	
    	//////////////////////////
        $descriptionTable = $this->getTable('scenescene7/product_option_description');
        
        if (!$object->getData('scope', 'description')) {
            $statement = $this->_getReadAdapter()->select()
                ->from($descriptionTable)
                ->where('option_id = '.$object->getId().' and store_id = ?', 0);

            if ($this->_getReadAdapter()->fetchOne($statement)) {
                if ($object->getStoreId() == '0') {
                    $this->_getWriteAdapter()->update(
                        $descriptionTable,
                            array('description' => $object->getDescription()),
                            $this->_getWriteAdapter()->quoteInto('option_id='.$object->getId().' AND store_id=?', 0)
                    );
                }
            } else {
                $this->_getWriteAdapter()->insert(
                    $descriptionTable,
                        array(
                            'option_id' => $object->getId(),
                            'store_id' => 0,
                            'description' => $object->getDescription()
                ));
            }
        }

        if ($object->getStoreId() != '0' && !$object->getData('scope', 'description')) {
            $statement = $this->_getReadAdapter()->select()
                ->from($descriptionTable)
                ->where('option_id = '.$object->getId().' and store_id = ?', $object->getStoreId());

            if ($this->_getReadAdapter()->fetchOne($statement)) {
                $this->_getWriteAdapter()->update(
                    $descriptionTable,
                        array('description' => $object->getDescription()),
                        $this->_getWriteAdapter()
                            ->quoteInto('option_id='.$object->getId().' AND store_id=?', $object->getStoreId()));
            } else {
                $this->_getWriteAdapter()->insert(
                    $descriptionTable,
                        array(
                            'option_id' => $object->getId(),
                            'store_id' => $object->getStoreId(),
                            'description' => $object->getDescription()
                ));
            }
        } elseif ($object->getData('scope', 'description')) {
            $this->_getWriteAdapter()->delete(
                $descriptionTable,
                $this->_getWriteAdapter()->quoteInto('option_id = '.$object->getId().' AND store_id = ?', $object->getStoreId())
            );
        }

        return Mage_Core_Model_Mysql4_Abstract::_afterSave($object);
    }
    
    /**
     * Duplicate custom options for product
     *
     * @param Mage_Catalog_Model_Product_Option $object
     * @param int $oldProductId
     * @param int $newProductId
     * @return Mage_Catalog_Model_Product_Option
     */
    public function duplicate(Mage_Catalog_Model_Product_Option $object, $oldProductId, $newProductId)
    {
        $write  = $this->_getWriteAdapter();
        $read   = $this->_getReadAdapter();

        $optionsCond = array();
        $optionsData = array();

        // read and prepare original product options
        $select = $read->select()
            ->from($this->getTable('catalog/product_option'))
            ->where('product_id=?', $oldProductId);
        $query = $read->query($select);
        while ($row = $query->fetch()) {
            $optionsData[$row['option_id']] = $row;
            $optionsData[$row['option_id']]['product_id'] = $newProductId;
            unset($optionsData[$row['option_id']]['option_id']);
        }

        // insert options to duplicated product
        foreach ($optionsData as $oId => $data) {
            $write->insert($this->getMainTable(), $data);
            $optionsCond[$oId] = $write->lastInsertId();
        }

        // copy options prefs
        foreach ($optionsCond as $oldOptionId => $newOptionId) {
            // title
            $table = $this->getTable('catalog/product_option_title');
            $sql = 'REPLACE INTO `' . $table . '` '
                . 'SELECT NULL, ' . $newOptionId . ', `store_id`, `title`'
                . 'FROM `' . $table . '` WHERE `option_id`=' . $oldOptionId;
            $this->_getWriteAdapter()->query($sql);

            // price
            $table = $this->getTable('catalog/product_option_price');
            $sql = 'REPLACE INTO `' . $table . '` '
                . 'SELECT NULL, ' . $newOptionId . ', `store_id`, `price`, `price_type`'
                . 'FROM `' . $table . '` WHERE `option_id`=' . $oldOptionId;
            $this->_getWriteAdapter()->query($sql);
            
            // description
            $table = $this->getTable('scenescene7/product_option_description');
            $sql = 'REPLACE INTO `' . $table . '` '
                . 'SELECT NULL, ' . $newOptionId . ', `store_id`, `description`'
                . 'FROM `' . $table . '` WHERE `option_id`=' . $oldOptionId;
            $this->_getWriteAdapter()->query($sql);

            $object->getValueInstance()->duplicate($oldOptionId, $newOptionId);
        }

        return $object;
    }
}