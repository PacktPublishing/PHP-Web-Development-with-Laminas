<?php
namespace Inventory\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;
use Laminas\Form\Element\Text;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Password;

class EmployeeForm extends Form {
    public function __construct($name = 'employee'){
        parent::__construct($name);
        
        $text = new Text('name');
        $text->setLabel('Name:');
        $text->setAttribute('autofocus', 'autofocus');
        $this->add($text);
        $text = new Text('nickname');
        $text->setLabel('Nickname:');
        $this->add($text);
        $password = new Password('password');        
        $password->setLabel('Password:');
        $this->add($password);
        $hidden = new Hidden('ID');
        $this->add($hidden);
    }
}