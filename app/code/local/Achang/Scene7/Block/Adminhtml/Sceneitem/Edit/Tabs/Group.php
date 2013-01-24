<?php
class Achang_Scene7_Block_Adminhtml_Sceneitem_Edit_Tabs_Group extends Mage_Adminhtml_Block_Widget_Grid{
    protected $_selectedGroups = null ;
    
    public function __construct(){
        parent::__construct();
        $this->setId('related_group_grid');
        $this->setDefaultSort('group_id');
        $this->setUseAjax(true);
        if ($this->getSceneitem()->getId()) {
            $this->setDefaultFilter(array('in_sceneitems'=>1));
        }
        $this->setSaveParametersInSession(false);
    }
    public function getSceneitem(){
        if (!($this->getData('sceneitem')instanceof Achang_Scene7_Model_Sceneitem)) {
        	$this->setData('sceneitem',Mage::registry('scenescene7_sceneitem_data'));
        }
        return $this->getData('sceneitem');
    }
    protected function _prepareCollection(){
        $collection = Mage::getResourceModel('scenescene7/group_collection');
        if ($this->isReadonly()) {
            $scenescene7Ids = $this->_getSelectedGroups();
            if (empty($scenescene7Ids)) {
            	$scenescene7Ids = array(0);
            }
            $collection->addFieldToFilter('group_id', array('in'=>$scenescene7Ids));
        }
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    
    protected function _addColumnFilterToCollection($column){
        if ($column->getId() == 'in_groups') {
            $groupIds = $this->_getSelectedGroups();
            if (empty($groupIds)) {
                $groupIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('group_id', array('in'=>$groupIds));
            } else {
                if($groupIds) {
                    $this->getCollection()->addFieldToFilter('group_id', array('nin'=>$groupIds));
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }
    protected function _getSelectedGroups(){
        if (!$this->_selectedGroups) {
            $this->_selectedGroups = array_keys($this->getSelectedRelatedGroups());
        }
        return $this->_selectedGroups ;
    }
    public function getSelectedRelatedGroups(){
    	
    	
    	$cur = $this->getSceneitem();
    	
    	if (!$cur->getId()) {
    		return array();
    	}
    	$groups = array();
    	
    	foreach (Mage::helper('scenescene7')->getRelatedGroups($cur) as $link){
    		$groups[$link->getGroupId()] = array();
    	}
    	
    	return $groups;
    }
    public function isReadonly()
    {
        return false;
    }
    
    protected function _prepareColumns(){
        if (!$this->isReadonly()) {
            $this->addColumn('in_groups',array(
                'header_css_class'  => 'a-center',
                'type'              => 'checkbox',
                'name'              => 'in_groups',
                'values'            => $this->_getSelectedGroups(),
                'align'             => 'center',
                'index'             => 'group_id'
            ));
            $this->addColumn('group_id',array(
            'header'    => Mage::helper('scenescene7')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'group_id',
            ));
            $this->addColumn('name',array(
            'header'    => Mage::helper('scenescene7')->__('Name'),
            'align'     =>'left',
            'index'     => 'name',
            ));
            $this->addColumn('position',array(
            'header'            => Mage::helper('scenescene7')->__('Position'),
            'name'              => 'position',
            'type'              => 'number',
            'validate_class'    => 'validate-number',
            'index'             => 'position',
            'width'             => 60,
            'style'             => 'display:none',
            'editable'          => !$this->isReadonly(),
            'edit_only'         => !$this->getSceneitem()->getId()
            ));
        }
        return parent::_prepareColumns();
    }
    public function getGridUrl()
    {
        return $this->_getData('grid_url') ? $this->_getData('grid_url') : $this->getUrl('scenescene7_admin/adminhtml_sceneitem/groupgrid', array('_current'=>true));
    }
}