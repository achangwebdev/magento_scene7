<?php
class Achang_Scene7_Block_Adminhtml_Group_Edit_Tabs_Related_Sceneitem extends Mage_Adminhtml_Block_Widget_Grid{
    public function __construct(){
        parent::__construct();
        $this->setId('related_sceneitem_grid');
        $this->setUseAjax(true);
        $this->setDefaultSort('entity_id');
        $this->setDefaultFilter(array('in_groups'=>1));
        $this->setSaveParametersInSession(false);
    }
    
    protected function _prepareCollection(){
        $collection = Mage::getResourceModel('scenescene7/sceneitem_collection')
        ->addAttributeToSelect('*');
        $tm_id = $this->getRequest()->getParam('id');
        if(!isset($tm_id)){
            $tm_id = 0;
        }
        Mage::getResourceModel('scenescene7/link')->addGridPosition($collection,$tm_id);
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'in_sceneitems'){
            $scenescene7Ids = $this->_getSelectedSceneitems();
            if(empty($scenescene7Ids)){
                $scenescene7Ids = 0;
            }
            if($column->getFilter()->getValue()){
                $this->getCollection()->addFieldToFilter('entity_id',array('in'=>$scenescene7Ids));
            }else{
                if($scenescene7Ids){
                    $this->getCollection()->addFieldToFilter('entity_id',array('nin'=>$scenescene7Ids));
                }
            }
        }else{
        	parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }
    public function isReadOnly(){
    	return false;
    }
    public function _getSceneitemGroup(){
    	$tm_id = $this->getRequest()->getParam('id');
    	$group = Mage::getModel('scenescene7/group')->load($tm_id);
    	return $group;
    }
    protected function _prepareColumns(){
            $this->addColumn('in_sceneitems',array(
                'header_css_class'  =>'a-center',
                'type'              =>'checkbox',
                'name'              =>'in_sceneitems',
                'values'            =>$this->_getSelectedSceneitems(),
                'align'             =>'center',
                'index'             =>'entity_id'
            ));

        $this->addColumn('entity_id',array(
            'header'=>Mage::helper('scenescene7')->__('ID'),
            'width' =>'10px',
            'index' =>'entity_id',
        ));
        
        $this->addColumn('name2',array(
            'header'=>Mage::helper('scenescene7')->__('Name'),
            'index' =>'name',
        ));
        $this->addColumn('code', array(
          'header'  => Mage::helper('scenescene7')->__('Code'),
          'index'   => 'code',
       ));
       $this->addColumn('scene_product_type',array(
            'header'    =>Mage::helper('scenescene7')->__('Scene Product Type'),
            'index'     =>'scene_product_type',
            'type'  => 'options',
            'options' => Mage::getSingleton('scenescene7/sceneitem')->getSceneTypeOptionArray(),
        ));
        $this->addColumn('position', array(
            'header'            => Mage::helper('scenescene7')->__('Position'),
            'name'              => 'position',
            'type'              => 'number',
            'validate_class'    => 'validate-number',
            'index'             => 'position',
            'editable'          => !$this->isReadonly(),
            'edit_only'         => !$this->_getSceneitemGroup()->getId()
       ));
       return parent::_prepareColumns();
    }
    public function getGridUrl(){
        return $this->getData('grid_url')
        ? $this->getData('grid_url')
        : $this->getUrl('scenescene7_admin/adminhtml_group/relatedSceneitemsGrid', array('_current'=>true));
    }
    protected function _getSelectedSceneitems(){
        $products = array_keys($this->getSelectedRelatedSceneitems());
        return $products;
    }
    public function getSelectedRelatedSceneitems(){
        $tm_id = $this->getRequest()->getParam('id');
        $group = Mage::getModel('scenescene7/group')->load($tm_id);
        $sceneitems = array();
        
        foreach (Mage::helper('scenescene7')->getRelatedSceneitems($group) as $link){
            $sceneitems[$link->getSceneitemId()] = array('position'=>$link->getPosition());
        }
        return $sceneitems;
    }
}