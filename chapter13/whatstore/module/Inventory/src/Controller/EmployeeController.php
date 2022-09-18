<?php
declare(strict_types=1);

namespace Inventory\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Inventory\Model\EmployeeTable;
use Inventory\Form\EmployeeForm;

class EmployeeController extends AbstractActionController
{   
    private ?EmployeeTable $employeeTable = null;
    
    public function __construct(EmployeeTable $employeeTable)
    {
        $this->employeeTable = $employeeTable;
    }
    
    public function indexAction()
    {
        $employees = $this->employeeTable->getAll();
        return new ViewModel(['employees' => $employees]);
    }
    
    public function editAction()
    {        
        $key = $this->params('key');
        $employee = $this->employeeTable->getByField('ID',$key);
        $form = new EmployeeForm();
        $form->bind($employee);
        return new ViewModel([
            'employee' => $employee,
            'form' => $form
        ]);
    }
}