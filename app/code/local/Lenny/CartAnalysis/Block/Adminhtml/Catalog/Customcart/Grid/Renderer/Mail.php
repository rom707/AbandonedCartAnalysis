<?php

class  Lenny_CartAnalysis_Block_Adminhtml_Catalog_Customcart_Grid_Renderer_Mail
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Input
{

    public function render(Varien_Object $row)
    {
        $html = '<button onclick= "location.href=\''
                                    .Mage::helper('adminhtml')->getUrl('*/*/sendReminderMail',
                                        array('name'=>$row->getCustomerName(), 
                                              'email'=>$row->getEmail()
                                             )).'\'">Send</button>';
        return $html;
    }
   
}