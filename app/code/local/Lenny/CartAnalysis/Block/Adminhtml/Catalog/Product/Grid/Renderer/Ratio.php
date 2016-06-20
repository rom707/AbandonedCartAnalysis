<?php

class Lenny_CartAnalysis_Block_Adminhtml_Catalog_Product_Grid_Renderer_Ratio extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $cart = $row->getCarts();
        $orders = $row->getOrders();
        if ($cart == 0)
            return $orders;
        else
            return round( (($orders / ($cart + $orders))* 100), 2);
    }
}