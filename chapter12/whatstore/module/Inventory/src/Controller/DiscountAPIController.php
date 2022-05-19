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
    
    /**
     * @OA\Post(
     *     path="/inventoryapi/discountapi/{key}",
     *     @OA\Parameter(
     *         name="key",
     *         in="path",
     *         description="discount code",
     *         required=false
     *     ),
     *     @OA\RequestBody(
     *     @OA\MediaType(mediaType="multipart/form-data",
     *         @OA\Schema(
     *             @OA\Property(property="code",type="integer"),
     *             @OA\Property(property="name",type="string"),
     *             @OA\Property(property="operator",type="char"),
     *             @OA\Property(property="factor",type="double"),
     *             required={"name","operator","factor"}
     *         )
     *     )),
     *     @OA\Response(response="200", description="insert a discount"),
     *     @OA\MediaType(mediaType="application/json")
     * )
     */
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
    
    /**
     * @OA\Get(
     *     path="/inventoryapi/discountapi/{key}",
     *     @OA\Parameter(
     *         name="key",
     *         in="path",
     *         description="discount code",
     *         required=false
     *     ),
     *     @OA\Response(response="200", description="get a discount"),
     *     @OA\MediaType(mediaType="application/json")
     * )
     */    
    public function get($id)
    {
        $field = (is_numeric($id) ? 'code' : 'name');
        $id = (is_numeric($id) ? (int) $id : $id);
        $discount = $this->discountTable->getByField($field, $id);
        return new JsonModel(['discount' => $discount->toArray()]);
    }
    
    /**
     * @OA\Put(
     *     path="/inventoryapi/discountapi/{key}",
     *     @OA\Parameter(
     *         name="key",
     *         in="path",
     *         description="discount code",
     *         required=false
     *     ),
     *     @OA\RequestBody(
     *     @OA\MediaType(mediaType="multipart/form-data",
     *         @OA\Schema(
     *             @OA\Property(property="code",type="integer"),
     *             @OA\Property(property="name",type="string"),
     *             @OA\Property(property="operator",type="char"),
     *             @OA\Property(property="factor",type="double"),
     *             required={"name","operator","factor"}
     *         )
     *     )),
     *     @OA\Response(response="200", description="update a discount"),
     *     @OA\MediaType(mediaType="application/json")
     * )
     */
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
    
    /**
     * @OA\Delete(
     *     path="/inventoryapi/discountapi/{key}",
     *     @OA\Parameter(
     *         name="key",
     *         in="path",
     *         description="discount code",
     *         required=false
     *     ),
     *     @OA\Response(response="200", description="remove a discount"),
     *     @OA\MediaType(mediaType="application/json")
     * )
     */
    public function delete($id)
    {
        $deleted = $this->discountTable->delete($id);
        return new JsonModel(['deleted' => $deleted]);        
    }
    
    /**
     * @OA\Get(
     *     path="/inventoryapi/discountapi",
     *     @OA\Response(response="200", description="get list of discounts"),
     *     @OA\MediaType(mediaType="application/json")
     * )
     */
    public function getList()
    {
        $resultSet = $this->discountTable->getAll();
        $discounts = [];
        foreach($resultSet as $result){
            $discounts[] = $result->toArray();
        }
        return new JsonModel(['discounts' => $discounts]);
    }    
}