<?php
declare(strict_types=1);

namespace Store\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Store\Model\CustomerTable;
use Store\Form\CustomerForm;
use Store\Model\ProductBasket;

class ProductBasketController extends AbstractActionController
{   
    private ProductBasket $productBasket;
    
    public function __construct(ProductBasket $productBasket)
    {
        $this->productBasket = $productBasket;
    }
    
    public function indexAction()
    {
        return new ViewModel(['products' => $this->productBasket->getProducts()]);
    }    
}