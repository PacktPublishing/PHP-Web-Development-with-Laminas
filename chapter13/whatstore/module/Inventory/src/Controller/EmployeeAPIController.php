<?php
namespace Inventory\Controller;

use Laminas\Mvc\Controller\AbstractRestfulController;
use Laminas\View\Model\JsonModel;
use Inventory\Model\Employee;
use Inventory\Model\EmployeeTable;

class EmployeeAPIController extends AbstractRestfulController
{
    protected $identifierName = 'key';
    private EmployeeTable $employeeTable;
    
    public function __construct(EmployeeTable $employeeTable)
    {
        $this->employeeTable = $employeeTable;
    }
    
    /**
     * @OA\Post(
     *     path="/inventoryapi/employeeapi/{key}",
     *     @OA\Parameter(
     *         name="key",
     *         in="path",
     *         description="employee ID",
     *         required=false
     *     ),
     *     @OA\RequestBody(
     *     @OA\MediaType(mediaType="multipart/form-data",
     *         @OA\Schema(
     *             @OA\Property(property="ID",type="integer"),
     *             @OA\Property(property="name",type="string"),
     *             @OA\Property(property="nickname",type="string"),
     *             @OA\Property(property="password",type="string"),
     *             required={"name","nickname","password"}
     *         )
     *     )),
     *     @OA\Response(response="200", description="insert an employee"),
     *     @OA\MediaType(mediaType="application/json")
     * )
     */
    public function create($data)
    {
        $employee = new Employee();
        $inputFilter = $employee->getInputFilter();
        $inputFilter->setData($data);
        if (!$inputFilter->isValid()){
            return new JsonModel(['inserted' => 'invalid']);
        }
        $employee->exchangeArray($data);
        $inserted = $this->employeeTable->save($employee);
        return new JsonModel(['inserted' => $inserted]);
    }
    
    /**
     * @OA\Get(
     *     path="/inventoryapi/employeeapi/{key}",
     *     @OA\Parameter(
     *         name="key",
     *         in="path",
     *         description="employee ID",
     *         required=false
     *     ),
     *     @OA\Response(response="200", description="get an employee"),
     *     @OA\MediaType(mediaType="application/json")
     * )
     */
    public function get($id)
    {
        $field = (is_numeric($id) ? 'ID' : 'name');
        $id = (is_numeric($id) ? (int) $id : $id);
        $employee = $this->employeeTable->getByField($field, $id);
        return new JsonModel(['employee' => $employee->toArray()]);
    }
    
    /**
     * @OA\Put(
     *     path="/inventoryapi/employeeapi/{key}",
     *     @OA\Parameter(
     *         name="key",
     *         in="path",
     *         description="employee ID",
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
     *     @OA\Response(response="200", description="update an employee"),
     *     @OA\MediaType(mediaType="application/json")
     * )
     */
    public function update($id, $data)
    {
        $employee = $this->employeeTable->getByField('ID', $id);
        $inputFilter = $employee->getInputFilter();
        $inputFilter->setData($data);
        if (!$inputFilter->isValid()){
            error_log(print_r($inputFilter->getMessages(),true));
            return new JsonModel(['updated' => 'invalid']);
        }
        $employee->exchangeArray($data);
        $updated = $this->employeeTable->save($employee);
        return new JsonModel(['updated' => $updated]);
    }
    
    /**
     * @OA\Delete(
     *     path="/inventoryapi/employeeapi/{key}",
     *     @OA\Parameter(
     *         name="key",
     *         in="path",
     *         description="employee ID",
     *         required=false
     *     ),
     *     @OA\Response(response="200", description="remove an employee"),
     *     @OA\MediaType(mediaType="application/json")
     * )
     */    
    public function delete($id)
    {
        $deleted = $this->employeeTable->delete($id);
        return new JsonModel(['deleted' => $deleted]);        
    }
    
    /**
     * @OA\Get(
     *     path="/inventoryapi/employeeapi",
     *     @OA\Response(response="200", description="get list of employees"),
     *     @OA\MediaType(mediaType="application/json")
     * )
     */
    public function getList()
    {
        $resultSet = $this->employeeTable->getAll();
        $employees = [];
        foreach($resultSet as $result){
            $employees[] = $result->toArray();
        }
        return new JsonModel(['employees' => $employees]);
    }
}