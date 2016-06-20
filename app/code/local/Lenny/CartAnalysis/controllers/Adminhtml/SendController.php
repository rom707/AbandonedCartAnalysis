<?php

class Lenny_CartAnalysis_Adminhtml_SendController extends Mage_Adminhtml_Controller_Action
{
    public function sendAction()
    {
        $collection = Mage::getResourceModel('reports/quote_collection')->prepareForAbandonedReport(Mage::app()->getStore()->getId());
        $result = "";
        foreach ($collection as $item)
        {
            $email = $item['customer_email'];
            $firstName = $item['customer_firstname'];
            $secondName = $item['customer_secondName'];
            $result = $this->sendMail($firstName, $secondName, $email);
            if ($result == true)
                $result = 'Success.';
            else 
                break;
        }
        Mage::app()->getResponse()->SetBody($result);
    }
    
    public function sendMail($customerFirstname, $customerSecondname, $customerEmail)
    {
        $emailTemplate = Mage::getModel('core/email_template')->loadDefault('abandoned_cart_reminder'); 

        $senderName = Mage::getStoreConfig('trans_email/ident_general/name');
        $senderEmail = Mage::getStoreConfig('trans_email/ident_general/email');
        
        $emailTemplateVariables = array();
        $emailTemplateVariables['firstname'] = $customerFirstname.$customerSecondname;
        $emailTemplateVariables['email'] = $customerEmail;

        $processedTemplate = $emailTemplate->getProcessedTemplate($emailTemplateVariables);
        $mail = Mage::getModel('core/email')
            ->setToName($customerFirstname.$customerSecondname)
            ->setToEmail($customerEmail)
            ->setBody($processedTemplate)
            ->setSubject('Subject :')
            ->setFromEmail($senderEmail)
            ->setFromName($senderName)
            ->setType('html');
        try{
            $mail->send();
            return true;
        }
        catch(Exception $error)
        {
            Mage::getSingleton('core/session')->addError($error->getMessage());
            return $error->getMessage();
        }
    }
}