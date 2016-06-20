<?php
 
class Lenny_CartAnalysis_Adminhtml_TotalstatController extends Mage_Adminhtml_Controller_Action
{
    function indexAction()
    {
       
        $collection = Mage::getResourceModel('reports/quote_collection')->prepareForProductsInCarts()
            ->setSelectCountSqlType(Mage_Reports_Model_Resource_Quote_Collection::SELECT_COUNT_SQL_TYPE_CART);
        
        $totalOrders = 0;
        $totalCarts = 0;
        $totalPrice = 0;
        
        $mostLeftProductPrice = 0;
        $mostLeftProductName = "";
        $mostLeftProductCount = 0;
        
        $mostOrderedProductPrice = 0;
        $mostOrderedProductName = "";
        $mostOrderedProductCount = 0;
        
        foreach($collection as $item)
        {
            $totalCarts += $item['carts'];
            $totalOrders += $item['orders'];
            $totalPrice += $item['price'];

            if($item['carts'] > $mostLeftProductCount){
                $mostLeftProductCount = $item['carts'];
                $mostLeftProductName = $item['name'];
                $mostLeftProductPrice = $item['price'];
            }
            
            if($item['orders'] > $mostOrderedProductCount){
                $mostOrderedProductCount = $item['orders'];
                $mostOrderedProductName = $item['name'];
                $mostOrderedProductPrice = $item['price'];
            }
        }   
        
        $object = new Varien_Object();
        $object->setSold($totalOrders)
            ->setUnsold($totalCarts)
            ->setPrice($totalPrice)
            ->setMostLeftProductPrice($mostLeftProductPrice)
            ->setMostLeftProductName($mostLeftProductName)
            ->setMostLeftProductCount($mostLeftProductCount)
            ->setMostOrderedProductPrice($mostOrderedProductPrice)
            ->setMostOrderedProductName($mostOrderedProductName)
            ->setMostOrderedProductCount($mostOrderedProductCount);
        Mage::register('chartArgs', $object);
        
        $this->loadLayout();
        $this->_setActiveMenu('catalog/catalog');
        $this->renderLayout();

    }
}
