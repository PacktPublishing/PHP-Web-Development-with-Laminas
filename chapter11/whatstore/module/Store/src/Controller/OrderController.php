<?php

declare(strict_types=1);

namespace Store\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Store\Form\ProductForm;
use Inventory\Model\ProductTable;
use Store\Model\PurchaseOrderTable;
use Store\Model\OrderItemTable;
use Store\Model\ProductBasket;
use Store\Model\Customer;

class OrderController extends AbstractActionController
{
    private ProductBasket $productBasket;
    private PurchaseOrderTable $purchaseOrderTable;
    private OrderItemTable $orderItemTable;
    
    public function __construct(ProductBasket $productBasket, PurchaseOrderTable $purchaseOrderTable, OrderItemTable $orderItemTable)
    {
        $this->productBasket = $productBasket;
        $this->purchaseOrderTable = $purchaseOrderTable;
        $this->orderItemTable = $orderItemTable;
    }
    
    public function indexAction()
    {
        $items = $this->productBasket->getProducts();
        return new ViewModel([
            'customer' => Customer::getCustomer(),
            'items' => $items            
        ]);
    }
}
