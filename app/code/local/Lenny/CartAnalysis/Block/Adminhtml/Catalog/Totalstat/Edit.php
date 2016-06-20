<?php

class Lenny_CartAnalysis_Block_Adminhtml_Catalog_Totalstat_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        
        $this->_objectId = 'id';
        $this->_blockGroup = 'lenny_cartanalysis';
        $this->_controller = 'adminhtml_catalog_totalstat';
        
        parent::__construct();
        $this->_removeButton('back');
        $this->_removeButton('reset');
        $this->_removeButton('delete');
        $this->_removeButton('save');
       
    }

    public function getHeaderText()
    {  
       
        return Mage::helper('lenny_cartanalysis')->__("Abandoned cart statistic");
    }

}
