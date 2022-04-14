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
    
    public function get($id)
    {
        $field = (is_numeric($id) ? 'IDN' : 'name');
        $id = (is_numeric($id) ? (int) $id : $id);
        $customer = $this->customerTable->getByField($field, $id);
        return new JsonModel(['customer' => $customer->toArray()]);
    }
    
    public function update($id, $data)
    {
        $customer = $this->customerTable->getByField('IDN', $id);
        $customer->exchangeArray($data);
        $updated = $this->customerTable->save($customer);
        return new JsonModel(['updated' => $updated]);
    }
    
    public function delete($id)
    {
        $deleted = $this->customerTable->delete($id);
        return new JsonModel(['deleted' => $deleted]);        
    }
}