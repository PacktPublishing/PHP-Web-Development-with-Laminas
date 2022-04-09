<?php
declare(strict_types=1);

namespace Inventory\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Inventory\Model\DiscountTable;
use Inventory\Form\DiscountForm;

class DiscountController extends AbstractActionController
{   
    private ?DiscountTable $discountTable = null;
    
    public function __construct(DiscountTable $discountTable)
    {
        $this->discountTable = $discountTable;
    }
    
    public function indexAction()
    {
        $discounts = $this->discountTable->getAll();
        return new ViewModel(['discounts' => $discounts]);
    }
    
    public function editAction()
    {        
        $key = $this->params('key');
        $discount = $this->discountTable->getByField('code',$key);
        $form = new DiscountForm();
        $form->bind($discount);
        return new ViewModel([
            'discount' => $discount,
            'form' => $form
        ]);
    }
}