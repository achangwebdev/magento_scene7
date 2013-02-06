<?php

class Achang_Scene7_Model_Resource_Product_Option_Value extends Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Option_Value
{


    protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
    	$scene7detailTable = $this->getTable('scenescene7/product_option_type_detail');
        //scene7 detail
        if (!$object->getData('scope', 'scene7_code')) {
            $statement = $this->_getReadAdapter()->select()
                ->from($scene7detailTable)
                ->where('option_type_id = '.$object->getId().' AND store_id = ?', 0);

            if ($this->_getReadAdapter()->fetchOne($statement)) {
                if ($object->getStoreId() == '0') {
                    $this->_getWriteAdapter()->update(
                        $scene7detailTable,
                            array('scene7_code' => $object->getScene7Code()),
                            $this->_getWriteAdapter()->quoteInto('option_type_id='.$object->getId().' AND store_id=?', 0)
                    );
                }
            } else {
                $this->_getWriteAdapter()->insert(
                    $scene7detailTable,
                        array(
                            'option_type_id' => $object->getId(),
                            'store_id' => 0,
                            'scene7_code' => $object->getScene7Code()
                ));
            }
        }

        if ($object->getStoreId() != '0' && !$object->getData('scope', 'scene7_code')) {
            $statement = $this->_getReadAdapter()->select()
                ->from($scene7detailTable)
                ->where('option_type_id = '.$object->getId().' AND store_id = ?', $object->getStoreId());

            if ($this->_getReadAdapter()->fetchOne($statement)) {
                $this->_getWriteAdapter()->update(
                    $scene7detailTable,
                        array('scene7_code' => $object->getScene7Code()),
                        $this->_getWriteAdapter()
                            ->quoteInto('option_type_id='.$object->getId().' AND store_id=?', $object->getStoreId()));
            } else {
                $this->_getWriteAdapter()->insert(
                    $scene7detailTable,
                        array(
                            'option_type_id' => $object->getId(),
                            'store_id' => $object->getStoreId(),
                            'scene7_code' => $object->getScene7Code()
                ));
            }
        } elseif ($object->getData('scope', 'scene7_code')) {
            $this->_getWriteAdapter()->delete(
                $scene7detailTable,
                $this->_getWriteAdapter()->quoteInto('option_type_id = '.$object->getId().' AND store_id = ?', $object->getStoreId())
            );
        }
        
            if (!$object->getData('scope', 'is_default')) {
            $statement = $this->_getReadAdapter()->select()
                ->from($scene7detailTable)
                ->where('option_type_id = '.$object->getId().' AND store_id = ?', 0);

            if ($this->_getReadAdapter()->fetchOne($statement)) {
                if ($object->getStoreId() == '0') {
                    $this->_getWriteAdapter()->update(
                        $scene7detailTable,
                            array('is_default' => $object->getIsDefault()),
                            $this->_getWriteAdapter()->quoteInto('option_type_id='.$object->getId().' AND store_id=?', 0)
                    );
                }
            } else {
                $this->_getWriteAdapter()->insert(
                    $scene7detailTable,
                        array(
                            'option_type_id' => $object->getId(),
                            'store_id' => 0,
                            'is_default' => $object->getIsDefault()
                ));
            }
        }

        if ($object->getStoreId() != '0' && !$object->getData('scope', 'is_default')) {
            $statement = $this->_getReadAdapter()->select()
                ->from($scene7detailTable)
                ->where('option_type_id = '.$object->getId().' AND store_id = ?', $object->getStoreId());

            if ($this->_getReadAdapter()->fetchOne($statement)) {
                $this->_getWriteAdapter()->update(
                    $scene7detailTable,
                        array('is_default' => $object->getIsDefault()),
                        $this->_getWriteAdapter()
                            ->quoteInto('option_type_id='.$object->getId().' AND store_id=?', $object->getStoreId()));
            } else {
                $this->_getWriteAdapter()->insert(
                    $scene7detailTable,
                        array(
                            'option_type_id' => $object->getId(),
                            'store_id' => $object->getStoreId(),
                            'is_default' => $object->getIsDefault()
                ));
            }
        } elseif ($object->getData('scope', 'is_default')) {
            $this->_getWriteAdapter()->delete(
                $scene7detailTable,
                $this->_getWriteAdapter()->quoteInto('option_type_id = '.$object->getId().' AND store_id = ?', $object->getStoreId())
            );
        }
        
        return parent::_afterSave($object);
    }

    public function deleteValues($option_type_id)
    {
        $childCondition = $this->_getWriteAdapter()->quoteInto('option_type_id=?', $option_type_id);
        $this->_getWriteAdapter()->delete(
            $this->getTable('scenescene7/product_option_type_detail'),
            $childCondition
        );
        parent::deleteValues($option_type_id);
    }

    /**
     * Duplicate product options value
     *
     * @param Mage_Catalog_Model_Product_Option_Value $object
     * @param int $oldOptionId
     * @param int $newOptionId
     * @return Mage_Catalog_Model_Product_Option_Value
     */
    public function duplicate(Mage_Catalog_Model_Product_Option_Value $object, $oldOptionId, $newOptionId)
    {
        $select = $this->_getReadAdapter()->select()
            ->from($this->getMainTable())
            ->where('option_id=?', $oldOptionId);
        $valueData = $this->_getReadAdapter()->fetchAll($select);

        $valueCond = array();

        foreach ($valueData as $data) {
            $optionTypeId = $data[$this->getIdFieldName()];
            unset($data[$this->getIdFieldName()]);
            $data['option_id'] = $newOptionId;

            $this->_getWriteAdapter()->insert($this->getMainTable(), $data);
            $valueCond[$optionTypeId] = $this->_getWriteAdapter()->lastInsertId();
        }

        unset($valueData);

        foreach ($valueCond as $oldTypeId => $newTypeId) {
            // price
            $table = $this->getTable('catalog/product_option_type_price');
            $sql = 'REPLACE INTO `' . $table . '` '
                . 'SELECT NULL, ' . $newTypeId . ', `store_id`, `price`, `price_type`'
                . 'FROM `' . $table . '` WHERE `option_type_id`=' . $oldTypeId;
            $this->_getWriteAdapter()->query($sql);

            // title
            $table = $this->getTable('catalog/product_option_type_title');
            $sql = 'REPLACE INTO `' . $table . '` '
                . 'SELECT NULL, ' . $newTypeId . ', `store_id`, `title`'
                . 'FROM `' . $table . '` WHERE `option_type_id`=' . $oldTypeId;
            $this->_getWriteAdapter()->query($sql);
            
            
            // scene7 detail
            $table = $this->getTable('scenescene7/product_option_type_detail');
            $sql = 'REPLACE INTO `' . $table . '` '
                . 'SELECT NULL, ' . $newTypeId . ', `store_id`, `scene7_code`,`is_default`'
                . 'FROM `' . $table . '` WHERE `option_type_id`=' . $oldTypeId;
            $this->_getWriteAdapter()->query($sql);
        }

        return $object;
    }
}
