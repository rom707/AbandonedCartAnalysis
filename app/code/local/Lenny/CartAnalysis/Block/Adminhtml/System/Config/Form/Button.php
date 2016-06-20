<?php 
class Lenny_CartAnalysis_Block_Adminhtml_System_Config_Form_Button extends Mage_Adminhtml_Block_System_Config_Form_Field
{

    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('lenny/button.phtml');
    }
    
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        return $this->_toHtml();
    }
    
    public function getAjaxSendOutUrl()
    {
        return Mage::helper('adminhtml')->getUrl('adminhtml/send/send');
    }
    
    public function getButtonHtml()
    {
        $button = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(array(
                'id'        =>  'send_out_button',
                'label'     =>  $this->helper('adminhtml')->__('Send out'),
                'onclick'   =>  'javascript:Send(); return false;',   
            ));
        return $button->_toHtml();
    }
}