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
    
    /**
     * @OA\Post(
     *     path="/storeapi/productbasketapi/{key}",
     *     @OA\Parameter(
     *         name="key",
     *         in="path",
     *         description="product code",
     *         required=false
     *     ),
     *     @OA\RequestBody(
     *     @OA\MediaType(mediaType="multipart/form-data",
     *         @OA\Schema(
     *             @OA\Property(property="code",type="integer"),
     *             @OA\Property(property="name",type="string"),
     *             @OA\Property(property="price",type="float"),
     *             @OA\Property(property="amount",type="integer"),
     *             required={"code","name","price","amount"}
     *         )
     *     )),
     *     @OA\Response(response="200", description="insert a product"),
     *     @OA\MediaType(mediaType="application/json")
     * )
     */
    public function create($data)
    {   
        $inserted = $this->productBasket->create($data);
        return new JsonModel(['inserted' => $inserted]);
    }
    
    /**
     * @OA\Get(
     *     path="/storeapi/productbasketapi/{key}",
     *     @OA\Parameter(
     *         name="key",
     *         in="path",
     *         description="product code",
     *         required=false
     *     ),
     *     @OA\Response(response="200", description="get a product"),
     *     @OA\MediaType(mediaType="application/json")
     * )
     */
    public function get($id)
    {
        $id = (int) $id;
        return new JsonModel(['product' => $this->productBasket->get($id)]);
    }
    
    /**
     * @OA\Put(
     *     path="/storeapi/productbasketapi/{key}",
     *     @OA\Parameter(
     *         name="key",
     *         in="path",
     *         description="product code",
     *         required=false
     *     ),
     *     @OA\RequestBody(
     *     @OA\MediaType(mediaType="multipart/form-data",
     *         @OA\Schema(
     *             @OA\Property(property="code",type="integer"),
     *             @OA\Property(property="name",type="string"),
     *             @OA\Property(property="price",type="float"),
     *             @OA\Property(property="amount",type="integer"),
     *             required={"code","name","price","amount"}
     *         )
     *     )),
     *     @OA\Response(response="200", description="update a product"),
     *     @OA\MediaType(mediaType="application/json")
     * )
     */ 
    public function update($id, $data)
    {
        $updated = $this->productBasket->update($id, $data);
        return new JsonModel(['updated' => $updated]);
    }
    
    /**
     * @OA\Delete(
     *     path="/storeapi/productbasketapi/{key}",
     *     @OA\Parameter(
     *         name="key",
     *         in="path",
     *         description="product code",
     *         required=false
     *     ),
     *     @OA\Response(response="200", description="remove a product"),
     *     @OA\MediaType(mediaType="application/json")
     * )
     */
    public function delete($id)
    {
        $deleted = $this->productBasket->delete($id);
        return new JsonModel(['deleted' => $deleted]);        
    }
}