<?php
namespace Inventory\Form;

use Laminas\Form\Form;
use Laminas\Form\Element\Select;

class EmployeeRoleForm extends Form {
    public function __construct($name = 'roles_employee'){
        parent::__construct($name);
        
        $select = new Select('code_role');
        $select->setLabel('Role:');
        $this->add($select);
        $select = new Select('ID_employee');
        $select->setLabel('Employee:');
        $this->add($select);        
    }
}