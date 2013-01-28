<?php

class Achang_Scene7_Block_Adminhtml_Attribute_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('attributeGrid');
      $this->setDefaultSort('attribute_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('scenescene7/attribute')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('attribute_id', array(
          'header'    => Mage::helper('scenescene7')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'attribute_id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('scenescene7')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));

      $this->addColumn('scene7_code', array(
          'header'    => Mage::helper('scenescene7')->__('Scene7 Code'),
          'align'     =>'left',
          'index'     => 'scene7_code',
      ));
      
       $this->addColumn('attribute_code', array(
          'header'    => Mage::helper('scenescene7')->__('Attribute Code'),
          'align'     =>'left',
          'index'     => 'attribute_code',
      ));     
      
      $this->addColumn('type', array(
          'header'    => Mage::helper('scenescene7')->__('Attribute Type'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'type',
          'type'      => 'options',
          'options'   => array(
              Achang_Scene7_Model_Status::SCENE7TEXT => Mage::helper('scenescene7')->__('Scene7 Text'),
              Achang_Scene7_Model_Status::SCENE7SELECT => Mage::helper('scenescene7')->__('Scene7 Select'),
          ),
      ));
	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('scenescene7')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
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
		
		$this->addExportType('*/*/exportCsv', Mage::helper('scenescene7')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('scenescene7')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('attribute_id');
        $this->getMassactionBlock()->setFormFieldName('scenescene7attribute');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('scenescene7')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('scenescene7')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('scenescene7/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('scenescene7')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('scenescene7')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}