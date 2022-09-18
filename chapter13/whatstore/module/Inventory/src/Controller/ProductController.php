<?php
declare(strict_types=1);

namespace Inventory\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Inventory\Model\ProductTable;
use Inventory\Model\DiscountTable;
use Inventory\Form\ProductForm;

class ProductController extends AbstractActionController
{   
    private ?ProductTable $productTable = null;
    private ?DiscountTable $discountTable = null;
    
    public function __construct(ProductTable $productTable, DiscountTable $discountTable)
    {
        $this->productTable = $productTable;
        $this->discountTable = $discountTable;
    }
    
    public function indexAction()
    {
        $products = $this->productTable->getAll();
        return new ViewModel(['products' => $products]);}
    
    public function editAction()
    {        
        $key = $this->params('key');
        $product = $this->productTable->getByField('code',$key);
        $discounts = $this->discountTable->getAll();
        $options = [];
        foreach($discounts as $discount){
            $options[$discount->code] = $discount->name;
        }
        $form = new ProductForm();
        $form->get('code_discount')->setValueOptions($options);
        $form->bind($product);        
        return new ViewModel([
            'product' => $product,
            'form' => $form
        ]);
    }
}