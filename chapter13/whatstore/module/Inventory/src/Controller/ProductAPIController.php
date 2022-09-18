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
    
    /**
     * @OA\Post(
     *     path="/inventoryapi/productapi/{key}",
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
     *             @OA\Property(property="code_discount",type="integer"),
     *             required={"name","price","code_discount"}
     *         )
     *     )),     
     *     @OA\Response(response="200", description="insert a product"),
     *     @OA\MediaType(mediaType="application/json")
     * )
     */
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
    
    /**
     * @OA\Get(
     *     path="/inventoryapi/productapi/{key}",
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
        $field = (is_numeric($id) ? 'code' : 'name');
        $id = (is_numeric($id) ? (int) $id : $id);
        $product = $this->productTable->getByField($field, $id);
        return new JsonModel(['product' => $product->toArray()]);
    }
    
    /**
     * @OA\Put(
     *     path="/inventoryapi/productapi/{key}",
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
     *             @OA\Property(property="code_discount",type="integer"),
     *             required={"name","price","code_discount"}
     *         )
     *     )),
     *     @OA\Response(response="200", description="update a product"),
     *     @OA\MediaType(mediaType="application/json")
     * )
     */
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
    
    /**
     * @OA\Delete(
     *     path="/inventoryapi/productapi/{key}",
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
        $deleted = $this->productTable->delete($id);
        return new JsonModel(['deleted' => $deleted]);        
    }
    
    /**
     * @OA\Get(
     *     path="/inventoryapi/productapi",
     *     @OA\Response(response="200", description="get list of products"),
     *     @OA\MediaType(mediaType="application/json")
     * )
     */
    public function getList()
    {
        $resultSet = $this->productTable->getAll();
        $products = [];
        foreach($resultSet as $result){
            $products[] = $result->toArray();
        }
        return new JsonModel(['products' => $products]);
    }
}