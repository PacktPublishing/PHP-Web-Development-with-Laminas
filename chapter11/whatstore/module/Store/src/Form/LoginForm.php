<?php
namespace Store\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;
use Laminas\Form\Element\Text;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Password;
use Laminas\Form\Element\Email;
use Laminas\Form\Element\Number;

class LoginForm extends Form {
    public function __construct($name = 'login'){
        parent::__construct($name);
        
        $text = new Email('email');
        $text->setLabel('e-mail:');
        $text->setAttribute('autofocus', 'autofocus');
        $this->add($text);
        $password = new Password('password');        
        $password->setLabel('Password:');
        $this->add($password);
    }
}