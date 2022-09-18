<?php
namespace Inventory\Controller;

use Laminas\Mvc\Controller\AbstractRestfulController;
use Laminas\View\Model\JsonModel;
use Inventory\Model\RoleResource;
use Inventory\Model\RoleResourceTable;

class RoleResourceAPIController extends AbstractRestfulController
{
    protected $identifierName = 'key';
    private RoleResourceTable $roleResourceTable;
    
    public function __construct(RoleResourceTable $roleResourceTable)
    {
        $this->roleResourceTable = $roleResourceTable;
    }
    
    /**
     * @OA\Post(
     *     path="/inventoryapi/roleresourceapi/{key}",
     *     @OA\Parameter(
     *         name="key",
     *         in="path",
     *         description="role resource code",
     *         required=false
     *     ),
     *     @OA\RequestBody(
     *     @OA\MediaType(mediaType="multipart/form-data",
     *         @OA\Schema(
     *             @OA\Property(property="code",type="integer"),
     *             @OA\Property(property="code_role",type="integer"),
     *             @OA\Property(property="code_resource",type="integer"),
     *             required={"code_role","code_resource"}
     *         )
     *     )),
     *     @OA\Response(response="200", description="insert a role resource"),
     *     @OA\MediaType(mediaType="application/json")
     * )
     */
    public function create($data)
    {
        $roleResource = new RoleResource();
        $inputFilter = $roleResource->getInputFilter();
        $inputFilter->setData($data);
        if (!$inputFilter->isValid()){
            return new JsonModel(['inserted' => 'invalid']);
        }
        $roleResource->exchangeArray($data);
        $inserted = $this->roleResourceTable->save($roleResource);
        return new JsonModel(['inserted' => $inserted]);
    }
            
    /**
     * @OA\Delete(
     *     path="/inventoryapi/roleresourceapi/{key}",
     *     @OA\Parameter(
     *         name="key",
     *         in="path",
     *         description="role resource code",
     *         required=false
     *     ),
     *     @OA\Response(response="200", description="remove a role resource"),
     *     @OA\MediaType(mediaType="application/json")
     * )
     */
    public function delete($id)
    {
        $deleted = $this->roleResourceTable->delete($id);
        return new JsonModel(['deleted' => $deleted]);        
    }
}