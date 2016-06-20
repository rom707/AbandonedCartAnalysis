<?php
 
class Lenny_CartAnalysis_Block_Adminhtml_Catalog_Customcart_Grid extends Mage_Adminhtml_Block_Widget_Grid
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

        
        $filter = $this->getParam($this->getVarNameFilter(), array());
        if ($filter) {
            $filter = base64_decode($filter);
            parse_str(urldecode($filter), $data);
        }

        if (!empty($data)) {
            $collection->prepareForAbandonedReport($this->_storeIds, $data);
        } else {
            $collection->prepareForAbandonedReport($this->_storeIds);
        }
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _addColumnFilterToCollection($column)
    {
        $field = ( $column->getFilterIndex() ) ? $column->getFilterIndex() : $column->getIndex();
        $skip = array('subtotal', 'customer_name', 'email');

        if (in_array($field, $skip)) {
            return $this;
        }

        parent::_addColumnFilterToCollection($column);
        return $this;
    } 

    protected function _prepareColumns()
    {
        
        $this->addColumn('customer_name', array(
            'header'    =>Mage::helper('reports')->__('Customer Name'),
            'index'     =>'customer_name',
            'sortable'  =>false
        ));

        $this->addColumn('email', array(
            'header'    =>Mage::helper('reports')->__('Email'),
            'index'     =>'email',
            'sortable'  =>false
        ));

        $this->addColumn('items_count', array(
            'header'    =>Mage::helper('reports')->__('Number of Items'),
            'width'     =>'80px',
            'align'     =>'right',
            'index'     =>'items_count',
            'type'      =>'number',
			'sortable'  => false,
        ));

        $this->addColumn('items_qty', array(
            'header'    =>Mage::helper('reports')->__('Quantity of Items'),
            'width'     =>'80px',
            'align'     =>'right',
            'index'     =>'items_qty',
            'type'      =>'number',
			'sortable'  => false,
        ));

        if ($this->getRequest()->getParam('website')) {
            $storeIds = Mage::app()->getWebsite($this->getRequest()->getParam('website'))->getStoreIds();
        } else if ($this->getRequest()->getParam('group')) {
            $storeIds = Mage::app()->getGroup($this->getRequest()->getParam('group'))->getStoreIds();
        } else if ($this->getRequest()->getParam('store')) {
            $storeIds = array((int)$this->getRequest()->getParam('store'));
        } else {
            $storeIds = array();
        }
        $this->setStoreIds($storeIds);
        $currencyCode = $this->getCurrentCurrencyCode();

        $this->addColumn('subtotal', array(
            'header'        => Mage::helper('reports')->__('Subtotal'),
            'width'         => '80px',
            'type'          => 'currency',
            'currency_code' => $currencyCode,
            'index'         => 'subtotal',
            'sortable'      => false,
            'renderer'      => 'adminhtml/report_grid_column_renderer_currency',
            'rate'          => $this->getRate($currencyCode),
        ));

        $this->addColumn('coupon_code', array(
            'header'    =>Mage::helper('reports')->__('Applied Coupon'),
            'width'     =>'80px',
            'index'     =>'coupon_code',
            'sortable'  =>false
        ));

        $this->addColumn('created_at', array(
            'header'    =>Mage::helper('reports')->__('Created At'),
            'width'     =>'170px',
            'type'      =>'datetime',
            'index'     =>'created_at',
            'filter_index'=>'main_table.created_at',
            'sortable'  =>false
        ));

        $this->addColumn('updated_at', array(
            'header'    =>Mage::helper('reports')->__('Send'),
            'width'     =>'170px',
            'type'      =>'datetime',
            'index'     =>'updated_at',
            'filter_index'=>'main_table.updated_at',
            'sortable'  =>false
        ));
        
        $this->addColumn('reminder', array(
            'header'    => Mage::helper('reports')->__('Send reminder'),
            'width'     => '40px',
            'type'      => 'action',
            'align'     =>'center',
            'renderer'  => 'lenny_cartanalysis/adminhtml_catalog_customcart_grid_renderer_mail',
            'filter'    => false,
            'sortable'  => false,
            ));  

        $this->addExportType('*/*/exportCustomcartCsv', Mage::helper('reports')->__('CSV'));
        $this->addExportType('*/*/exportCustomcartExcel', Mage::helper('reports')->__('Excel XML'));

        return parent::_prepareColumns();
    }

}