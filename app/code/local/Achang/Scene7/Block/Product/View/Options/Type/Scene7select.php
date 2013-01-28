<?php
/**
 * Product options text type block
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Achang_Scene7_Block_Product_View_Options_Type_Scene7select
    extends Mage_Catalog_Block_Product_View_Options_Abstract
{

    public function getValuesHtml()
    {
        $_option = $this->getOption();

        if (Mage::getSingleton('catalog/product_option')->getGroupByType($_option->getType()) == Achang_Scene7_Model_Catalog_Product_Option::OPTION_GROUP_SCENE7SELECT) {
            $require = ($_option->getIsRequire()) ? ' required-entry' : '';
            $extraParams = '';
            $select = $this->getLayout()->createBlock('core/html_select')
                ->setData(array(
                    'id' => 'select_'.$_option->getId(),
                    'class' => $require.' product-custom-option'
                ));
            if (Mage::getSingleton('catalog/product_option')->getGroupByType($_option->getType()) == Achang_Scene7_Model_Catalog_Product_Option::OPTION_GROUP_SCENE7SELECT) {
                $select->setName('options['.$_option->getid().']')
                    ->addOption('', $this->__('-- Please Select --'));
            } else {
                $select->setName('options['.$_option->getid().'][]');
                $select->setClass('multiselect'.$require.' product-custom-option');
            }
            foreach ($_option->getValues() as $_value) {
                $priceStr = $this->_formatPrice(array(
                    'is_percent' => ($_value->getPriceType() == 'percent') ? true : false,
                    'pricing_value' => $_value->getPrice(true)
                ), false);
                $select->addOption(
                    $_value->getOptionTypeId(),
                    $_value->getTitle() . ' ' . $priceStr . ''
                );
            }
//            if ($_option->getType() == Mage_Catalog_Model_Product_Option::OPTION_TYPE_MULTIPLE) {
//                $extraParams = ' multiple="multiple"';
//            }
            $select->setExtraParams('onchange="opConfig.reloadPrice()"'.$extraParams);

            return $select->getHtml();
        }
    }

}
