<?php

/**
 * Catalog product option values collection
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author     Magento Core Team <core@magentocommerce.com>
 */

class Achang_Scene7_Model_Resource_Product_Option_Value_Collection
    extends Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Option_Value_Collection
{
	
    public function getValues($store_id)
    {
        $this->getSelect()
            ->joinLeft(array('default_value_price'=>$this->getTable('catalog/product_option_type_price')),
                '`default_value_price`.option_type_id=`main_table`.option_type_id AND '.$this->getConnection()->quoteInto('`default_value_price`.store_id=?',0),
                array('default_price'=>'price','default_price_type'=>'price_type'))
            ->joinLeft(array('store_value_price'=>$this->getTable('catalog/product_option_type_price')),
                '`store_value_price`.option_type_id=`main_table`.option_type_id AND '.$this->getConnection()->quoteInto('`store_value_price`.store_id=?', $store_id),
                array('store_price'=>'price','store_price_type'=>'price_type',
                'price'=>new Zend_Db_Expr('IFNULL(`store_value_price`.price,`default_value_price`.price)'),
                'price_type'=>new Zend_Db_Expr('IFNULL(`store_value_price`.price_type,`default_value_price`.price_type)')))

             ->join(array('default_value_detail'=>$this->getTable('scenescene7/product_option_type_detail')),
                '`default_value_detail`.option_type_id=`main_table`.option_type_id',
                array('default_scene7_code'=>'scene7_code','default_is_default'=>'is_default'))
            ->joinLeft(array('store_value_detail'=>$this->getTable('scenescene7/product_option_type_detail')),
                '`store_value_detail`.option_type_id=`main_table`.option_type_id AND '.$this->getConnection()->quoteInto('`store_value_detail`.store_id=?',$store_id),
                array('store_scene7_code'=>'scene7_code','store_is_default'=>'is_default','scene7_code'=>new Zend_Db_Expr('IFNULL(`store_value_detail`.scene7_code,`default_value_detail`.scene7_code)'),'is_default'=>new Zend_Db_Expr('IFNULL(`store_value_detail`.is_default,`default_value_detail`.is_default)')))
                
                ->join(array('default_value_title'=>$this->getTable('catalog/product_option_type_title')),
                '`default_value_title`.option_type_id=`main_table`.option_type_id',
                array('default_title'=>'title'))
            ->joinLeft(array('store_value_title'=>$this->getTable('catalog/product_option_type_title')),
                '`store_value_title`.option_type_id=`main_table`.option_type_id AND '.$this->getConnection()->quoteInto('`store_value_title`.store_id=?',$store_id),
                array('store_title'=>'title','title'=>new Zend_Db_Expr('IFNULL(`store_value_title`.title,`default_value_title`.title)')))
            ->where('`default_value_title`.store_id=?',0);
        return $this;
    }
	
   public function addScene7DetailToResult($store_id){
   	  $this->getSelect()
            ->join(array('default_value_detail'=>$this->getTable('scenescene7/product_option_type_detail')),
                '`default_value_detail`.option_type_id=`main_table`.option_type_id',
                array('default_scene7_code'=>'scene7_code','default_is_default'=>'is_default'))
            ->joinLeft(array('store_value_detail'=>$this->getTable('scenescene7/product_option_type_detail')),
                '`store_value_detail`.option_type_id=`main_table`.option_type_id AND '.$this->getConnection()->quoteInto('`store_value_detail`.store_id=?',$store_id),
                array('store_scene7_code'=>'scene7_code','store_is_default'=>'is_default','scene7_code'=>new Zend_Db_Expr('IFNULL(`store_value_detail`.scene7_code,`default_value_detail`.scene7_code)'),'is_default'=>new Zend_Db_Expr('IFNULL(`store_value_detail`.is_default,`default_value_detail`.is_default)')))
            ->where('`default_value_detail`.store_id=?',0);
       return $this;
   }
   
   
   
   
}
