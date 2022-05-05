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
            
    public function delete($id)
    {
        $deleted = $this->employeeRoleTable->delete($id);
        return new JsonModel(['deleted' => $deleted]);        
    }
}