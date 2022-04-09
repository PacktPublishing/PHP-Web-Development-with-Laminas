<?php
namespace Inventory\Controller;

use Laminas\Mvc\Controller\AbstractRestfulController;
use Laminas\View\Model\JsonModel;
use Inventory\Model\Discount;
use Inventory\Model\DiscountTable;

class DiscountAPIController extends AbstractRestfulController
{
    protected $identifierName = 'key';
    private DiscountTable $discountTable;
    
    public function __construct(DiscountTable $discountTable)
    {
        $this->discountTable = $discountTable;
    }
    
    public function create($data)
    {        
        $discount = new Discount();
        $inputFilter = $discount->getInputFilter();
        $inputFilter->setData($data);
        if (!$inputFilter->isValid()){
            return new JsonModel(['inserted' => 'invalid']);
        }
        $discount->exchangeArray($data);
        $inserted = $this->discountTable->save($discount);
        return new JsonModel(['inserted' => $inserted]);
    }
    
    public function get($id)
    {
        $field = (is_numeric($id) ? 'code' : 'name');
        $id = (is_numeric($id) ? (int) $id : $id);
        $discount = $this->discountTable->getByField($field, $id);
        return new JsonModel(['discount' => $discount->toArray()]);
    }
    
    public function update($id, $data)
    {
        $discount = $this->discountTable->getByField('code', $id);
        $inputFilter = $discount->getInputFilter();
        $inputFilter->setData($data);
        if (!$inputFilter->isValid()){
            return new JsonModel(['updated' => 'invalid']);
        }
        $discount->exchangeArray($data);
        $updated = $this->discountTable->save($discount);
        return new JsonModel(['updated' => $updated]);
    }
    
    public function delete($id)
    {
        $deleted = $this->discountTable->delete($id);
        return new JsonModel(['deleted' => $deleted]);        
    }
}