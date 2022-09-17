<?php
namespace Inventory\Form;

use Laminas\Form\Form;
use Laminas\Form\Element\Select;

class RoleResourceForm extends Form {
    public function __construct($name = 'resources_role'){
        parent::__construct($name);
        
        $select = new Select('code_resource');
        $select->setLabel('Resource:');
        $this->add($select);
        $select = new Select('code_role');
        $select->setLabel('Role:');
        $this->add($select);
    }
}