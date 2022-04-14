<?php
namespace Inventory\Controller;

use Laminas\Mvc\Controller\AbstractRestfulController;
use Laminas\View\Model\JsonModel;
use Inventory\Model\Product;
use Inventory\Model\ProductTable;

class ProductAPIController extends AbstractRestfulController
{
    protected $identifierName = 'key';
    private ProductTable $productTable;
    
    public function __construct(ProductTable $productTable)
    {
        $this->productTable = $productTable;
    }
    
    public function create($data)
    {
        $product = new Product();
        $inputFilter = $product->getInputFilter();
        $inputFilter->setData($data);
        if (!$inputFilter->isValid()){
            return new JsonModel(['inserted' => 'invalid']);
        }
        $product->exchangeArray($data);
        $inserted = $this->productTable->save($product);
        return new JsonModel(['inserted' => $inserted]);
    }
    
    public function get($id)
    {
        $field = (is_numeric($id) ? 'code' : 'name');
        $id = (is_numeric($id) ? (int) $id : $id);
        $product = $this->productTable->getByField($field, $id);
        return new JsonModel(['product' => $product->toArray()]);
    }
    
    public function update($id, $data)
    {
        $product = $this->productTable->getByField('code', $id);
        $inputFilter = $product->getInputFilter();
        $inputFilter->setData($data);
        if (!$inputFilter->isValid()){
            return new JsonModel(['updated' => 'invalid']);
        }
        $product->exchangeArray($data);
        $updated = $this->productTable->save($product);
        return new JsonModel(['updated' => $updated]);
    }
    
    public function delete($id)
    {
        $deleted = $this->productTable->delete($id);
        return new JsonModel(['deleted' => $deleted]);        
    }
}