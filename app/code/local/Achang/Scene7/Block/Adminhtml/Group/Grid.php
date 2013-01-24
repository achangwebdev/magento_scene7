<?php
class Achang_Scene7_Block_Adminhtml_Group_Grid extends Mage_Adminhtml_Block_Widget_Grid{
    public function __construct()
    {
        parent::__construct();
        $this->setId('scenescene7groupGrid');
        $this->setDefaultSort('group_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('scenescene7/group')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    protected function _prepareColumns(){
        $this->addColumn('group_id',array(
        'hearder'   => Mage::helper('scenescene7')->__('ID'),
        'align'     =>'right',
        'width'     =>'50px',
        'index'     =>'group_id',
        ));
        $this->addColumn('name',array(
        'header'    =>Mage::helper('scenescene7')->__('Group Name'),
        'align'     =>'left',
        'index'     =>'name',
        ));
        $this->addColumn('action',array(
        'header'    =>Mage::helper('scenescene7')->__('Action'),
        'width'     =>'100px',
        'align'     =>'left',
        'getter'    => 'getId',
        'type'      =>'action',
        'actions'   => array(
            array(
            'caption'   => Mage::helper('scenescene7')->__('Edit'),
            'url'       => array('base'=> '*/*/edit'),
            'field'     => 'id'
                    )
                ),
        'filter'    => false,
        'sortable'  => false,
        'index'     => 'stores',
        'is_system' => true,
        
        ));
      return parent::_prepareColumns();
    }
    protected function _prepareMassaction(){
        $this->setMassactionIdField('group_id');
        $this->getMassactionBlock()->setFormFieldName('scenescene7group');
        $this->getMassactionBlock()->addItem('delete',array(
        'label'     => Mage::helper('scenescene7')->__('Delete'),
        'url'       => $this->getUrl('*/*/massDelete'),
        'confirm'   => Mage::helper('scenescene7')->__('Are you sure?')
        ));
        return $this;
    }
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}