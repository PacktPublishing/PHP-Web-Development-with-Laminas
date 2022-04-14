<?php
declare(strict_types=1);

namespace Store\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Store\Model\CustomerTable;
use Store\Form\CustomerForm;

class CustomerController extends AbstractActionController
{   
    private ?CustomerTable $customerTable = null;
    
    public function __construct(CustomerTable $customerTable)
    {
        $this->customerTable = $customerTable;
    }
    
    public function indexAction()
    {
        $customers = $this->customerTable->getAll();
        return new ViewModel(['customers' => $customers]);
    }
    
    public function editAction()
    {        
        $key = $this->params('key');
        $customer = $this->customerTable->getByField('IDN',$key);
        $form = new CustomerForm();
        $form->bind($customer);
        return new ViewModel([
            'customer' => $customer,
            'form' => $form
        ]);
    }
}