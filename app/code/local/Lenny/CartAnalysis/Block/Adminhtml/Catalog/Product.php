<?php
 
class Lenny_CartAnalysis_Block_Adminhtml_Catalog_Product extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'lenny_cartanalysis';
        $this->_controller = 'adminhtml_catalog_product';
        $this->_headerText = Mage::helper('lenny_cartanalysis')->__('Product - Report');
        
        parent::__construct();
        $this->_removeButton('add');
    }
}