<?php
namespace Inventory\Controller;

use Laminas\Mvc\Controller\AbstractRestfulController;
use Laminas\View\Model\JsonModel;
use Inventory\Model\EmployeeRole;
use Inventory\Model\EmployeeRoleTable;

class EmployeeRoleAPIController extends AbstractRestfulController
{
    protected $identifierName = 'key';
    private EmployeeRoleTable $employeeRoleTable;
    
    public function __construct(EmployeeRoleTable $employeeRoleTable)
    {
        $this->employeeRoleTable = $employeeRoleTable;
    }
    
    /**
     * @OA\Post(
     *     path="/inventoryapi/employeeroleapi/{key}",
     *     @OA\Parameter(
     *         name="key",
     *         in="path",
     *         description="employee role code",
     *         required=false
     *     ),
     *     @OA\RequestBody(
     *     @OA\MediaType(mediaType="multipart/form-data",
     *         @OA\Schema(
     *             @OA\Property(property="code",type="integer"),
     *             @OA\Property(property="code_role",type="integer"),
     *             @OA\Property(property="ID_employee",type="integer"),
     *             required={"code_role","ID_employee"}
     *         )
     *     )),
     *     @OA\Response(response="200", description="insert a employee role"),
     *     @OA\MediaType(mediaType="application/json")
     * )
     */
    public function create($data)
    {
        $employeeRole = new EmployeeRole();
        $inputFilter = $employeeRole->getInputFilter();
        $inputFilter->setData($data);
        if (!$inputFilter->isValid()){
            return new JsonModel(['inserted' => 'invalid']);
        }
        $employeeRole->exchangeArray($data);
        $inserted = $this->employeeRoleTable->save($employeeRole);
        return new JsonModel(['inserted' => $inserted]);
    }

    /**
     * @OA\Delete(
     *     path="/inventoryapi/employeeroleapi/{key}",
     *     @OA\Parameter(
     *         name="key",
     *         in="path",
     *         description="employee role code",
     *         required=false
     *     ),
     *     @OA\Response(response="200", description="remove a employee role"),
     *     @OA\MediaType(mediaType="application/json")
     * )
     */
    public function delete($id)
    {
        $deleted = $this->employeeRoleTable->delete($id);
        return new JsonModel(['deleted' => $deleted]);        
    }
}