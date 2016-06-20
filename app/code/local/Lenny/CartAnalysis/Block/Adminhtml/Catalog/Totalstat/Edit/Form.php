<?php

class Lenny_CartAnalysis_Block_Adminhtml_Catalog_Totalstat_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    public function __construct()
    {     
        parent::__construct();
        $this->setId('lenny_cartanalysis_diagram_form');
        
    }

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array('id' => 'id',
                                    'method' => 'post'));       
        
        $fieldset = $form->addFieldset('base_fieldsset', 
                                    array('legend'=>Mage::helper('lenny_cartanalysis')->__('All abandoned products')));
        
        $fieldset->addType('canvas','Lenny_CartAnalysis_Block_Adminhtml_Catalog_Element_Diagram');
        
        $args = Mage::registry('chartArgs');
        
        if ($args->getUnsold() == 0)
            $sold = $args->getSold();
        else
            $sold = round( (($args->getSold() / ($args->getUnsold() + $args->getSold()))* 100), 2);
        
        $unsold = 100 - $sold;
                
        $args = Mage::registry('chartArgs');
        $fieldset->addField('unsold', 'note', array(
            'label'     =>  "Abandoned products: ",
            'text'      =>  Mage::helper('lenny_cartanalysis')->__($args->getUnsold()." (".$unsold."%)"),
        )); 
        $fieldset->addField('sold', 'note', array(
            'label'     =>  "Ordered products: ",
            'text'      =>  Mage::helper('lenny_cartanalysis')->__($args->getSold()." (".$sold."%)"),
        )); 
        $fieldset->addField('price', 'note', array(
            'label'     =>  "Total abandoned products price: ",
            'text'      =>  Mage::helper('lenny_cartanalysis')->__($args->getPrice()." $"),
        )); 
        
        $chart=$fieldset->addField('diagram', 'canvas', array(
            'name'      => 'productStat',
            'values'    =>array(
                            array('name'=>'Sold', 'value'=>$sold),
                            array('name'=>'Unsold', 'value'=>$unsold),
                            )
        ));
        
        $fieldset = $form->addFieldset('fieldset_top', 
                                    array(
                                    'legend'=>Mage::helper('lenny_cartanalysis')->__('TOP statistic'),
                                         ));
        
        $fieldset->addField('leftName', 'note', array(
          'label'     =>  "Most left product name: ",
          'text'     => Mage::helper('lenny_cartanalysis')->__($args->getMostLeftProductName()),
        )); 
        $fieldset->addField('leftCount', 'note', array(
          'label'     =>  "Most left product count: ",
          'text'     => Mage::helper('lenny_cartanalysis')->__($args->getMostLeftProductCount()),
        )); 
        $fieldset->addField('leftPrice', 'note', array(
          'label'     =>  "Most left product price: ",
          'text'     => Mage::helper('lenny_cartanalysis')->__($args->getMostLeftProductPrice()),
        )); 
        $fieldset->addField('orderedName', 'note', array(
          'label'     =>  "Most ordered product name: ",
          'text'     => Mage::helper('lenny_cartanalysis')->__($args->getMostOrderedProductName()),
        )); 
        $fieldset->addField('orderedCount', 'note', array(
          'label'     =>  "Most ordered product count: ",
          'text'     => Mage::helper('lenny_cartanalysis')->__($args->getMostOrderedProductCount()),
        )); 
        $fieldset->addField('orderedPrice', 'note', array(
          'label'     =>  "Most ordered product price: ",
          'text'     => Mage::helper('lenny_cartanalysis')->__($args->getMostOrderedProductPrice()),
        )); 
        
        $form->setUseContainer(true);
        $this->setForm($form);
     
        return parent::_prepareForm();
    }
}