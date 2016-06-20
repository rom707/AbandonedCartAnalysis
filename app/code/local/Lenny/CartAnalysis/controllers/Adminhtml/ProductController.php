<?php
 
class Lenny_CartAnalysis_Adminhtml_ProductController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('Catalog'))->_title($this->__('Abandoned Stat'))->_title($this->__('Product'));
        $this->loadLayout();
        $this->_setActiveMenu('catalog/catalog');
        $this->_addContent($this->getLayout()->createBlock('lenny_cartanalysis/adminhtml_catalog_product'));
        $this->renderLayout();
    }

    public function diagramAction()
    {
        $carts  = $this->getRequest()->getParam('Carts');
        $orders  = $this->getRequest()->getParam('Orders');
        $productId = (int) $this->getRequest()->getParam('Product');
        $product = Mage::getModel('catalog/product')->load($productId);
        if ($carts == 0)
            $sold = $orders;
        else
            $sold = round( (($orders / ($carts + $orders))* 100), 2);
        
        $unsold = 100 - $sold;
        
        $object = new Varien_Object();
        $object->setSold($sold)
            ->setUnsold($unsold)
            ->setProduct($product);
        Mage::register('chartArgs',  $object);
        
        $this->loadLayout();
        $this->_setActiveMenu('catalog/catalog');
        $this->renderLayout();
    }
    
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('lenny_cartanalysis/adminhtml_catalog_product_grid')->toHtml()
        );
    }
 
    public function exportProductCsvAction()
    {
        $fileName = 'product_lenny.csv';
        $grid = $this->getLayout()->createBlock('lenny_cartanalysis/adminhtml_catalog_product_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }
 
    public function exportProductExcelAction()
    {
        $fileName = 'product_lenny.xml';
        $grid = $this->getLayout()->createBlock('lenny_cartanalysis/adminhtml_catalog_product_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }
}