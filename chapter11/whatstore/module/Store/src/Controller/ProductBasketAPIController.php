<?php
namespace Store\Controller;

use Laminas\Mvc\Controller\AbstractRestfulController;
use Laminas\View\Model\JsonModel;
use Store\Model\Customer;
use Store\Model\CustomerTable;
use Laminas\Session\Container;
use Store\Model\ProductBasket;

class ProductBasketAPIController extends AbstractRestfulController
{
    protected $identifierName = 'key';
    private ProductBasket $productBasket;    
    
    public function __construct(ProductBasket $productBasket)
    {
        $this->productBasket = $productBasket;
    }
    
    public function create($data)
    {   
        $inserted = $this->productBasket->create($data);
        return new JsonModel(['inserted' => $inserted]);
    }
    
    public function get($id)
    {
        $id = (int) $id;
        return new JsonModel(['product' => $this->productBasket->get($id)]);
    }
    
    public function update($id, $data)
    {
        $updated = $this->productBasket->update($id, $data);
        return new JsonModel(['updated' => $updated]);
    }
    
    public function delete($id)
    {
        $deleted = $this->productBasket->delete($id);
        return new JsonModel(['deleted' => $deleted]);        
    }
}