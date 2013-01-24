<?php
class Achang_Scene7_Block_Adminhtml_Sceneitem_Grid extends Mage_Adminhtml_Block_Widget_Grid{
    public function __construct(){
        parent::__construct();
        $this->setID('sceneitemGrid');
        $this->setDefaultSort('group_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }
    protected function _prepareCollection(){
        $collection = Mage::getResourceModel('scenescene7/sceneitem_collection')->addAttributeToSelect('*');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    protected function _prepareColumns(){
        $this->addColumn('entity_id',array(
            'header'    => Mage::helper('scenescene7')->__('ID'),
            'width'     => '10px',
            'index'     => 'entity_id',
        ));
        $this->addColumn('name',array(
            'header'    => Mage::helper('scenescene7')->__('Name'),
            'index'     => 'name',
        ));
        $this->addColumn('code',array(
            'header'    =>Mage::helper('scenescene7')->__('Code'),
            'index'     =>'code',
        ));
        $this->addColumn('sceneitem_price',array(
            'header'    =>Mage::helper('scenescene7')->__('Sceneitem Price'),
            'index'     =>'sceneitem_price',
        ));
       $this->addColumn('scene_product_type',array(
            'header'    =>Mage::helper('scenescene7')->__('Scene Product Type'),
            'index'     =>'scene_product_type',
            'type'  => 'options',
            'options' => Mage::getSingleton('scenescene7/sceneitem')->getSceneTypeOptionArray(),
        ));
        
        $this->addColumn('action',array(
            'header'    =>Mage::helper('scenescene7')->__('Action'),
            'width'     =>'100',
            'type'      =>'action',
            'getter'    =>'getId',
            'actions'   => array(
                array(
                'caption'   => Mage::helper('scenescene7')->__('Edit'),
                'url'       => array('base'=> '*/*/edit'),
                'field'     => 'id'
                    )
                ),
            'filter'    =>false,
            'sortable'  =>false,
            'index'     =>'stores',
            'is_system' =>true
        ));
        return parent::_prepareColumns();
    }
    protected function _prepareMassaction(){
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('scenescene7');
        $this->getMassactionBlock()->addItem('delete',array(
        'label'     => Mage::helper('scenescene7')->__('Delete'),
        'url'       => $this->getUrl('*/*/massDelete'),
        'confirm'   => Mage::helper('scenescene7')->__('Are you sure?')
        ));
        return $this;
    }
    
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getEntityId()));
    }
    
    
}