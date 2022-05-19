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
    
    /**
     * @OA\Post(
     *     path="/storeapi/customerapi/{key}",
     *     @OA\Parameter(
     *         name="key",
     *         in="path",
     *         description="customer IDN",
     *         required=false
     *     ),
     *     @OA\RequestBody(
     *     @OA\MediaType(mediaType="multipart/form-data",
     *         @OA\Schema(
     *             @OA\Property(property="IDN",type="integer"),
     *             @OA\Property(property="name",type="string"),
     *             @OA\Property(property="password",type="string"),
     *             @OA\Property(property="email",type="string"),             
     *             required={"name","password","email"}
     *         )
     *     )),
     *     @OA\Response(response="200", description="insert a customer"),
     *     @OA\MediaType(mediaType="application/json")
     * )
     */
    public function create($data)
    {
        $customer = new Customer();
        $customer->exchangeArray($data);
        $inserted = $this->customerTable->save($customer);
        return new JsonModel(['inserted' => $inserted]);
    }    
}