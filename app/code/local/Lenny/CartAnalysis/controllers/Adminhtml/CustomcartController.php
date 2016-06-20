<?php
 
class Lenny_CartAnalysis_Adminhtml_CustomcartController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('Catalog'))->_title($this->__('Abandoned Stat'))->_title($this->__('Customer'));
        $this->loadLayout();
        $this->_setActiveMenu('catalog/catalog');
        $this->_addContent($this->getLayout()->createBlock('lenny_cartanalysis/adminhtml_catalog_customcart'));
        $this->renderLayout();
    }
    

    public function sendReminderMailAction()
    {
        
        $emailTemplate = Mage::getModel('core/email_template')->loadDefault('abandoned_cart_reminder');

        $senderName = Mage::getStoreConfig('trans_email/ident_general/name');

        $senderEmail = Mage::getStoreConfig('trans_email/ident_general/email');
        
        $customerName = $this->getRequest()->getParam('name');
        $customerEmail = $this->getRequest()->getParam('email');
        $emailTemplateVariables = array();
        $emailTemplateVariables['firstname'] = $customerName;

        $processedTemplate = $emailTemplate->getProcessedTemplate($emailTemplateVariables);

        $mail = Mage::getModel('core/email')
            ->setToName($customerName)
            ->setToEmail($customerEmail)
            ->setBody($processedTemplate)
            ->setSubject('Subject :')
            ->setFromEmail($senderEmail)
            ->setFromName($senderName)
            ->setType('html');
        $this->_redirect('*/*/');
        try{

            $mail->send();
        }
        catch(Exception $error)
        {
            Mage::getSingleton('core/session')->addError($error->getMessage());
            return false;
        }
    }
    
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('lenny_cartanalysis/adminhtml_catalog_customcart_grid')->toHtml()
        );
    }
 
    public function exportCustomcartCsvAction()
    {
        $fileName = 'customer_lenny.csv';
        $grid = $this->getLayout()->createBlock('lenny_cartanalysis/adminhtml_catalog_customcart_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }
 
    public function exportCustomcartExcelAction()
    {
        $fileName = 'customer_lenny.xml';
        $grid = $this->getLayout()->createBlock('lenny_cartanalysis/adminhtml_catalog_customcart_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }
    
}