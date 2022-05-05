<?php

declare(strict_types=1);

namespace Store\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Store\Form\ProductForm;
use Inventory\Model\ProductTable;

class IndexController extends AbstractActionController
{
    private ProductTable $productTable;
    
    public function __construct(ProductTable $productTable)
    {
        $this->productTable = $productTable;
    }
    
    public function indexAction()
    {
        $products = $this->productTable->getAll();
        $form = new ProductForm();
        return new ViewModel([
            'form' => $form,
            'products' => $products            
        ]);
    }
}
