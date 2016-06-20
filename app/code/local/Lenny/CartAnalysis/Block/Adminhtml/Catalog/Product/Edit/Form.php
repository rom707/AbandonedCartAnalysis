<?php

class Lenny_CartAnalysis_Block_Adminhtml_Catalog_Product_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
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
                                    array(
                                    'legend'=>Mage::helper('lenny_cartanalysis')->__('DIAGRAM'),
                                    ));
        
        $fieldset->addType('canvas','Lenny_CartAnalysis_Block_Adminhtml_Catalog_Element_Diagram');

        $args = Mage::registry('chartArgs');

        $chart=$fieldset->addField('diagram', 'canvas', array(
            'name' => 'productStat',
            'values' =>array(
                            array('name'=>'Sold', 'value'=>$args->getSold()),
                            array('name'=>'Unsold', 'value'=>$args->getUnsold()),
                ),
        ));

        $form->setUseContainer(true);
        $this->setForm($form);
     
        return parent::_prepareForm();
    }
}