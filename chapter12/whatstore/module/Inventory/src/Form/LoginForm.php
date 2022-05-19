<?php
namespace Inventory\Form;

use Laminas\Form\Form;
use Laminas\Form\Element\Text;
use Laminas\Form\Element\Password;

class LoginForm extends Form {
    public function __construct($name = 'user'){
        parent::__construct($name);
        
        $text = new Text('nickname');
        $text->setLabel('NickName:');
        $text->setAttribute('autofocus', 'autofocus');
        $this->add($text);
        $password = new Password('password');        
        $password->setLabel('Password:');
        $this->add($password);
    }
}