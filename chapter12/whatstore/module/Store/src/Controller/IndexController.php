<?php

declare(strict_types=1);

namespace Store\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Store\Form\ProductForm;
use Inventory\Model\ProductTable;
use Laminas\Db\Sql\Where;
use Store\Model\IdentityManager;

class IndexController extends AbstractActionController
{
    private ProductTable $productTable;
    private IdentityManager $identityManager;
    
    public function __construct(ProductTable $productTable, IdentityManager $identityManager)
    {
        $this->productTable = $productTable;
        $this->identityManager = $identityManager;
    }
    
    public function indexAction()
    {
        $name = $this->getRequest()->getPost('name');
        $where = null;
        if (!empty($name)){
            $where = new Where();
            $name = strtoupper($name);
            $where->like('products.name',"%$name%");
        }        
        $products = $this->productTable->getAll($where);
        $form = new ProductForm();
        return new ViewModel([
            'form' => $form,
            'products' => $products,
            'authenticated' => $this->identityManager->hasIdentity()
        ]);
    }
}
