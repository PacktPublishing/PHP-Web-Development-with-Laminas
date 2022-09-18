<?php
namespace Inventory\Form;

use Laminas\Form\Form;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Text;

class RoleForm extends Form {
    public function __construct($name = 'role'){
        parent::__construct($name);
        
        $text = new Text('name');
        $text->setLabel('Name:');
        $text->setAttribute('autofocus', 'autofocus');
        $this->add($text);
        $hidden = new Hidden('code');
        $this->add($hidden);
    }
}