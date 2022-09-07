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
    
    public function create($data)
    {
        $employee = new Employee();
        $employee->exchangeArray($data);
        $inserted = $this->employeeTable->save($employee);
        return new JsonModel(['inserted' => $inserted]);
    }
    
    public function get($id)
    {
        $field = (is_numeric($id) ? 'ID' : 'name');
        $id = (is_numeric($id) ? (int) $id : $id);
        $employee = $this->employeeTable->getByField($field, $id);
        return new JsonModel(['employee' => $employee->toArray()]);
    }
    
    public function update($id, $data)
    {
        $employee = $this->employeeTable->getByField('ID', $id);
        $employee->exchangeArray($data);
        $updated = $this->employeeTable->save($employee);
        return new JsonModel(['updated' => $updated]);
    }
    
    public function delete($id)
    {
        $deleted = $this->employeeTable->delete($id);
        return new JsonModel(['deleted' => $deleted]);        
    }
}
