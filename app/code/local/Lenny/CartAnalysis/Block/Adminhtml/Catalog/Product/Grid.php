<?php
 
class Lenny_CartAnalysis_Block_Adminhtml_Catalog_Product_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('lenny_cartanalysis_grid');
    }
 
    protected function _prepareCollection()
    {
        /** @var $collection Mage_Reports_Model_Resource_Quote_Collection */
        $collection = Mage::getResourceModel('reports/quote_collection');
        $collection->prepareForProductsInCarts()
            ->setSelectCountSqlType(Mage_Reports_Model_Resource_Quote_Collection::SELECT_COUNT_SQL_TYPE_CART);
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        
        $this->addColumn('name', array(
            'header'    =>Mage::helper('reports')->__('Product Name'),
            'index'     =>'name'
        ));

        $currencyCode = $this->getCurrentCurrencyCode();

        $this->addColumn('orders', array(
            'header'    =>Mage::helper('reports')->__('Orders'),
            'width'     =>'80px',
            'align'     =>'right',
            'index'     =>'orders'
        ));
        
        $this->addColumn('carts', array(
            'header'    =>Mage::helper('reports')->__('Carts'),
            'width'     =>'80px',
            'align'     =>'right',
            'index'     =>'carts'
        ));

        $this->addColumn('sold/unsold %', array(
            'header'    =>Mage::helper('reports')->__('Sold/Unsold %'),
            'width'     =>'80px',
            'align'     =>'right',
            'index'     =>'ratio',
            'renderer' => new Lenny_CartAnalysis_Block_Adminhtml_Catalog_Product_Grid_Renderer_Ratio() ,
            'sortable'  =>false
        ));
        
        $this->setFilterVisibility(false);

        $this->addExportType('*/*/exportProductCsv', Mage::helper('reports')->__('CSV'));
        $this->addExportType('*/*/exportProductExcel', Mage::helper('reports')->__('Excel XML'));

        return parent::_prepareColumns();
    }
        
    
    public function getRowUrl($row)
    {
        return $this->getUrl('adminhtml/product/diagram', 
                             array('Carts'=>$row->getCarts(), 
                                   'Orders'=>$row->getOrders(), 
                                   'Product'=>$row->getEntityId()));
    }
}