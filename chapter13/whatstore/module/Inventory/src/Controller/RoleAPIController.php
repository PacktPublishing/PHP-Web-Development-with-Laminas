<?php
namespace Inventory\Controller;

use Laminas\Mvc\Controller\AbstractRestfulController;
use Laminas\View\Model\JsonModel;
use Inventory\Model\Role;
use Inventory\Model\RoleTable;

class RoleAPIController extends AbstractRestfulController
{
    protected $identifierName = 'key';
    private RoleTable $roleTable;
    
    public function __construct(RoleTable $roleTable)
    {
        $this->roleTable = $roleTable;
    }
    
    /**
     * @OA\Post(
     *     path="/inventoryapi/roleapi/{key}",
     *     @OA\Parameter(
     *         name="key",
     *         in="path",
     *         description="role code",
     *         required=false
     *     ),
     *     @OA\RequestBody(
     *     @OA\MediaType(mediaType="multipart/form-data",
     *         @OA\Schema(
     *             @OA\Property(property="code",type="integer"),
     *             @OA\Property(property="name",type="string"),
     *             @OA\Property(property="nickname",type="string"),
     *             @OA\Property(property="password",type="string"),
     *             required={"name","nickname","password"}
     *         )
     *     )),
     *     @OA\Response(response="200", description="insert a role"),
     *     @OA\MediaType(mediaType="application/json")
     * )
     */
    public function create($data)
    {
        $role = new Role();
        $inputFilter = $role->getInputFilter();
        $inputFilter->setData($data);
        if (!$inputFilter->isValid()){
            return new JsonModel(['inserted' => 'invalid']);
        }
        $role->exchangeArray($data);
        $inserted = $this->roleTable->save($role);
        return new JsonModel(['inserted' => $inserted]);
    }
    
    /**
     * @OA\Get(
     *     path="/inventoryapi/roleapi/{key}",
     *     @OA\Parameter(
     *         name="key",
     *         in="path",
     *         description="role code",
     *         required=false
     *     ),
     *     @OA\Response(response="200", description="get a role"),
     *     @OA\MediaType(mediaType="application/json")
     * )
     */
    public function get($id)
    {
        $field = (is_numeric($id) ? 'code' : 'name');
        $id = (is_numeric($id) ? (int) $id : $id);
        $role = $this->roleTable->getByField($field, $id);
        return new JsonModel(['role' => $role->toArray()]);
    }
    
    /**
     * @OA\Put(
     *     path="/inventoryapi/roleapi/{key}",
     *     @OA\Parameter(
     *         name="key",
     *         in="path",
     *         description="role code",
     *         required=false
     *     ),
     *     @OA\RequestBody(
     *     @OA\MediaType(mediaType="multipart/form-data",
     *         @OA\Schema(
     *             @OA\Property(property="code",type="integer"),
     *             @OA\Property(property="name",type="string"),
     *             @OA\Property(property="nickname",type="string"),
     *             @OA\Property(property="password",type="string"),
     *             required={"name","nickname","password"}
     *         )
     *     )),
     *     @OA\Response(response="200", description="update a role"),
     *     @OA\MediaType(mediaType="application/json")
     * )
     */
    public function update($id, $data)
    {
        $role = $this->roleTable->getByField('code', $id);
        $inputFilter = $role->getInputFilter();
        $inputFilter->setData($data);
        if (!$inputFilter->isValid()){
            error_log(print_r($inputFilter->getMessages(),true));
            return new JsonModel(['updated' => 'invalid']);
        }
        $role->exchangeArray($data);
        $updated = $this->roleTable->save($role);
        return new JsonModel(['updated' => $updated]);
    }
    
    /**
     * @OA\Delete(
     *     path="/inventoryapi/roleapi/{key}",
     *     @OA\Parameter(
     *         name="key",
     *         in="path",
     *         description="role code",
     *         required=false
     *     ),
     *     @OA\Response(response="200", description="remove a role"),
     *     @OA\MediaType(mediaType="application/json")
     * )
     */
    public function delete($id)
    {
        $deleted = $this->roleTable->delete($id);
        return new JsonModel(['deleted' => $deleted]);        
    }
    
    /**
     * @OA\Get(
     *     path="/inventoryapi/roleapi",
     *     @OA\Response(response="200", description="get list of roles"),
     *     @OA\MediaType(mediaType="application/json")
     * )
     */
    public function getList()
    {
        $resultSet = $this->roleTable->getAll();
        $roles = [];
        foreach($resultSet as $result){
            $roles[] = $result->toArray();
        }
        return new JsonModel(['roles' => $roles]);
    }
}