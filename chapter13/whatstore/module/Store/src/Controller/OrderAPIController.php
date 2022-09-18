<?php
namespace Store\Controller;

use Laminas\Mvc\Controller\AbstractRestfulController;
use Laminas\View\Model\JsonModel;
use Store\Model\Customer;
use Store\Model\CustomerTable;
use Laminas\Session\Container;
use Store\Model\ProductBasket;
use Store\Model\PurchaseOrder;
use Store\Model\OrderItem;
use Store\Model\PurchaseOrderTable;
use Store\Model\OrderItemTable;

class OrderAPIController extends AbstractRestfulController
{
    protected $identifierName = 'key';
    private ProductBasket $productBasket;
    private PurchaseOrderTable $purchaseOrderTable;
    private OrderItemTable $orderItemTable;
    
    public function __construct(ProductBasket $productBasket, PurchaseOrderTable $purchaseOrderTable, OrderItemTable $orderItemTable)
    {
        $this->productBasket = $productBasket;
        $this->purchaseOrderTable = $purchaseOrderTable;
        $this->orderItemTable = $orderItemTable;
    }
    
    /**
     * @OA\Post(
     *     path="/storeapi/orderapi/{key}",
     *     @OA\Parameter(
     *         name="key",
     *         in="path",
     *         description="order code",
     *         required=false
     *     ),
     *     @OA\Response(response="200", description="insert a purchase order"),
     *     @OA\MediaType(mediaType="application/json")
     * )
     */
    public function create($data)
    {        
        $idn = Customer::getCustomer()->IDN;
        
        $set = [
            'status' => PurchaseOrder::CREATED,
            'IDN' => $idn
        ];
        
        $inserted = false;
        try {
            $purchaseOrder = new PurchaseOrder();
            $purchaseOrder->exchangeArray($set);
            $this->purchaseOrderTable->save($purchaseOrder);
            $code = $this->purchaseOrderTable->getLastCreatedCode();
            
            $products = $this->productBasket->getProducts();
            
            foreach($products as $product){
                $set = [
                    'code_order' => $code,
                    'code_product' => $product['code'],
                    'price' => $product['price'],
                    'amount' => $product['amount']
                ];
                $orderItem = new OrderItem();
                $orderItem->exchangeArray($set);
                $this->orderItemTable->save($orderItem);
            }
            $this->productBasket->clear();
            $inserted = true;
        } catch (\Exception $e) {
            error_log($e->getMessage());
        }
        
        return new JsonModel(['inserted' => $inserted]);
    }
}