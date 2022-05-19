<?php
namespace Inventory\Model;

use Generic\Model\AbstractModel;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\Input;
use Laminas\Filter\FilterChain;
use Laminas\Filter\ToInt;
use Laminas\Filter\StringToUpper;
use Laminas\Validator\ValidatorChain;
use Laminas\I18n\Filter\Alnum;
use Laminas\Validator\StringLength;
use Laminas\I18n\Filter\Alpha;

class EmployeeRole extends AbstractModel
{
    public int $code;
    public Role $role;
    public Employee $employee;
    
    public function exchangeArray($data)
    {
        $this->code = ($data['code'] ?? 0);
        $this->role = new Role();
        $this->employee = new Employee();
        $this->role->code = ($data['code_role'] ?? 0);
        $this->employee->ID = ($data['ID_employee'] ?? 0);
        
        $this->role->name = ($data['role'] ?? '');
        $this->employee->name = ($data['employee'] ?? '');        
    }
    
    public function getInputFilter(): InputFilter
    {
        $inputFilter = new InputFilter();
        
        $input = new Input('code_role');
        $filterChain = new FilterChain();
        $filterChain->attach(new ToInt());
        $input->setFilterChain($filterChain);
        $inputFilter->add($input);
        
        $input = new Input('ID_employee');
        $filterChain = new FilterChain();
        $filterChain->attach(new ToInt());
        $input->setFilterChain($filterChain);
        $inputFilter->add($input);

        return $inputFilter;
    }
    
    public function toArray()
    {
        $data = [
            'code_role' => $this->role->code,
            'ID_employee' => $this->employee->ID            
        ];
        $inputFilter = $this->getInputFilter();
        $inputFilter->setData($data);
        return $inputFilter->getValues();
    }
    
    public function getArrayCopy()
    {
        $data = [
            'code_role' => $this->role->code,
            'ID_employee' => $this->employee->ID            
        ];
        return $data;
    }
}