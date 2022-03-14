<?php
use Behat\Behat\Tester\Exception\PendingException;
use Generic\Context\AbstractContext;
use Inventory\Model\Employee;
use Inventory\Model\EmployeeTable;
use PHPUnit\Framework\Assert;

class EmployeeCRUDContext extends AbstractContext
{
    private ?Employee $employee = null;
    private ?EmployeeTable $employeeTable = null;
    
    public function __construct()
    {
        $this->employee = new Employee();
        $this->employeeTable = $this->getApplication()->getServiceManager()->get('EmployeeTable');
    }


    /**
     * @Given an employee called :arg1 with ID :arg2 and with nickname :arg3
     */
    public function anEmployeeCalledWithIdAndWithNickname($arg1, $arg2, $arg3)
    {
        $data = [
            'ID' => $arg2,
            'name' => $arg1,
            'nickname' => $arg3,
            'password' => '4321'
        ];
        $this->employee->exchangeArray($data);        
    }

    /**
     * @When I add this employee
     */
    public function iAddThisEmployee()
    {
        $this->employeeTable->save($this->employee);
    }

    /**
     * @Then I have an employee called :arg1 in the table employees
     */
    public function iHaveAnEmployeeCalledInTheTableEmployees($arg1)
    {
        $employee = $this->employeeTable->getByField('name', $arg1);
        
        Assert::assertEquals($arg1, $employee->name);
    }
    
    public function __destruct()
    {
        $employee = $this->employeeTable->getByField('name', $this->employee->name);
        $this->employeeTable->delete($employee->ID);
    }
    
}
