<?php
class Achang_Scene7_Model_System_Config_Source_Product_Options_Type
{
    const PRODUCT_OPTIONS_GROUPS_PATH = 'global/catalog/product/options/custom/groups';

    public function toOptionArray()
    {
        $groups = array(
            array('value' => '', 'label' => Mage::helper('adminhtml')->__('-- Please select --'))
        );
        foreach (Mage::getConfig()->getNode(self::PRODUCT_OPTIONS_GROUPS_PATH)->children() as $group) {
            $types = array();
            $typesPath = self::PRODUCT_OPTIONS_GROUPS_PATH . '/' . $group->getName() . '/types';
            foreach (Mage::getConfig()->getNode($typesPath)->children() as $type) {
                $labelPath = self::PRODUCT_OPTIONS_GROUPS_PATH . '/' . $group->getName() . '/types/' . $type->getName() . '/label';
                $types[] = array(
                    'label' => (string) Mage::getConfig()->getNode($labelPath),
                    'value' => $type->getName()
                );
            }

            $labelPath = self::PRODUCT_OPTIONS_GROUPS_PATH . '/' . $group->getName() . '/label';

            $groups[] = array(
                'label' => (string) Mage::getConfig()->getNode($labelPath),
                'value' => $types
            );
        }
        
        foreach(self::getScene7OptionGroups() as $k =>$v){
        	    $scene7Types = array();
        	    foreach($v['types'] as $k1=>$v1){
        	    	$scene7Types[] = array('label'=>$v1['label'],'value'=>$v1['value']);
        	    }
                $groups[] = array(
                'label' => $v['label'],
                'value' => $scene7Types
            );
        }

        
        return $groups;
    }
    
    static function getScene7OptionGroups(){
    $groups['scene7select'] = array('label' => 'Scene7 Select',
                                          'render' => 'scenescene7/adminhtml_catalog_product_edit_tab_options_type_select',
                                          'types' => array(
                                                            array('label'=>'Scene7 Drop-down','value'=>'scene7_drop_down'),
                                                            array('label'=>'Scene7 Drop-down2','value'=>'scene7_drop_down2')
                                                          )
                                    );
     $groups['scene7text'] = array('label' => 'Scene7 Text',
                                          'render' => 'adminhtml/catalog_product_edit_tab_options_type_text',
                                          'types' => array(
                                                            array('label'=>'Scene7 Text1','value'=>'scene7_text1'),
                                                            array('label'=>'Scene7 Text2','value'=>'scene7_text2')
                                                          )
                                    );	
    return $groups;
    }
}
