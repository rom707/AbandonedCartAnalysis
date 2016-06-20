<?php

class Lenny_CartAnalysis_Block_Adminhtml_Catalog_Product_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        
        $this->_objectId = 'id';
        $this->_blockGroup = 'lenny_cartanalysis';
        $this->_controller = 'adminhtml_catalog_product';
        
        parent::__construct();
        $this->_removeButton('back');
        $this->_removeButton('reset');
        $this->_removeButton('delete');
        $this->_removeButton('save');
       
    }

    public function getHeaderText()
    {  
        $prodstat = Mage::registry('chartArgs');
        return Mage::helper('lenny_cartanalysis')->__("'%s' statistic", $this->escapeHtml($prodstat->getProduct()->getName()));
    }

}
