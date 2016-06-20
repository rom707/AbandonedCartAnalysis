<?php

class Lenny_CartAnalysis_Block_Adminhtml_Catalog_Element_Diagram extends Varien_Data_Form_Element_Abstract
{
    public function __construct($attributes=array())
    {
        parent::__construct($attributes);
    }

    public function getElementHtml()
    {
        $html = Mage::app()->getLayout()
                        ->createBlock('adminhtml/template', 'header')
                        ->setTemplate('lenny/canvas_element.phtml')
                        ->setData($this->getData())
                        ->toHtml();
        $html.= $this->getAfterElementHtml();
        return $html;
    }
}