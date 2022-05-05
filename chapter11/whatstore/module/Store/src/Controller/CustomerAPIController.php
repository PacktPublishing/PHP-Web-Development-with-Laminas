<?php
namespace Store\Controller;

use Laminas\Mvc\Controller\AbstractRestfulController;
use Laminas\View\Model\JsonModel;
use Store\Model\Customer;
use Store\Model\CustomerTable;

class CustomerAPIController extends AbstractRestfulController
{
    protected $identifierName = 'key';
    private CustomerTable $customerTable;
    
    public function __construct(CustomerTable $customerTable)
    {
        $this->customerTable = $customerTable;
    }
    
    public function create($data)
    {
        $customer = new Customer();
        $customer->exchangeArray($data);
        $inserted = $this->customerTable->save($customer);
        return new JsonModel(['inserted' => $inserted]);
    }    
}