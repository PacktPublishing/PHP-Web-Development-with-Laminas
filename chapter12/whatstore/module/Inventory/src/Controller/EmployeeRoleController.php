<?php
declare(strict_types=1);

namespace Inventory\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Inventory\Model\EmployeeRoleTable;
use Inventory\Model\EmployeeTable;
use Inventory\Model\RoleTable;
use Inventory\Form\EmployeeRoleForm;

class EmployeeRoleController extends AbstractActionController
{   
    private ?EmployeeRoleTable $employeeRoleTable = null;
    private ?EmployeeTable $employeeTable = null;
    private ?RoleTable $roleTable = null;
    
    public function __construct(EmployeeRoleTable $employeeRoleTable, EmployeeTable $employeeTable, RoleTable $roleTable)
    {
        $this->employeeRoleTable = $employeeRoleTable;
        $this->employeeTable = $employeeTable;
        $this->roleTable = $roleTable;
    }
    
    public function indexAction()
    {
        $employeeRoles = $this->employeeRoleTable->getAll();
        return new ViewModel(['employeeRoles' => $employeeRoles]);
    }
    
    public function editAction()
    {        
        $form = new EmployeeRoleForm();
        $employees = [];
        $rows = $this->employeeTable->getAll();
        foreach($rows as $row){
            $employees[$row->ID] = $row->name;
        }
        $roles = [];
        $rows = $this->roleTable->getAll();
        foreach($rows as $row){
            $roles[$row->code] = $row->name;
        }
        $form->get('ID_employee')->setValueOptions($employees);
        $form->get('code_role')->setValueOptions($roles);
        return new ViewModel([
            'form' => $form
        ]);
    }
}