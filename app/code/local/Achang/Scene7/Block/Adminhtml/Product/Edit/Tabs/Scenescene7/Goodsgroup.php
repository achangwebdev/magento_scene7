<?php
class Achang_Scene7_Block_Adminhtml_Product_Edit_Tabs_Scenescene7_Goodsgroup
extends Mage_Adminhtml_Block_Widget
implements Varien_Data_Form_Element_Renderer_Interface{
    protected $_element;
    public function setElement(Varien_Data_Form_Element_Abstract $element)
    {
        $this->_element = $element;
        return $this;
    }
    public function getElement()
    {
        return $this->_element;
    }
    
    public function render(Varien_Data_Form_Element_Abstract $element){
        $this->setElement($element);
        return $this->toHtml();
    }
    
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('scene7/product/edit/tabs/goodsgroup.phtml');
    }

    public function getProduct()
    {
        return Mage::registry('product');
    }
    
    public function getValues(){
        $values = array();
        $data = $this->getElement()->getValue();
        if ( is_array($data)) {
           $values = $data;
        }
        return $values;
    }
    public function getAttribute(){
        return $this->getElement()->getEntityAttribute();
    }
    public function getSceneitemGroup(){
        $groups = Mage::getModel('scenescene7/group')->getAllGroups();
        foreach ($groups as $key=>$val) {
            $group[] = array('label' => $val->getName(), 'value'=>$val->getId());
      }
      return $group;
    }
    public function getSceneitems(){
        $sceneitems = Mage::getModel('scenescene7/sceneitem')->getCollection()->addAttributeToSelect('*');
        foreach ($sceneitems as $key=>$val){
            $sceneitem[] =array('label' =>$val->getCode(),'value' =>$val->getEntityId());
        }
        return $sceneitem;
    }
    public function getAddButtonHtml()
    {
        return $this->getChildHtml('add_button');
    }
    
    protected function _prepareLayout()
    {
        $button = $this->getLayout()->createBlock('adminhtml/widget_button')
        ->setData(array(
                'label'     => Mage::helper('catalog')->__('Add Group Line'),
                'onclick'   => 'return defaultGroupControl.addItem()',
                'class'     => 'add'
                ));
                $button->setName('add_sceneitem_group_item_button');

                $this->setChild('add_button', $button);
                return parent::_prepareLayout();
    }
}