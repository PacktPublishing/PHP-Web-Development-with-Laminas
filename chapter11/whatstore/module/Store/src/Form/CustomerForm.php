<?php
namespace Store\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;
use Laminas\Form\Element\Text;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Password;
use Laminas\Form\Element\Email;
use Laminas\Form\Element\Number;

class CustomerForm extends Form {
    public function __construct($name = 'customer'){
        parent::__construct($name);
        
        $number = new Number('IDN');
        $number->setLabel('IDN:');
        $number->setAttribute('autofocus', 'autofocus');
        $this->add($number);
        $text = new Text('name');
        $text->setLabel('Name:');
        $this->add($text);
        $password = new Password('password');        
        $password->setLabel('Password:');
        $this->add($password);
        $text = new Email('email');
        $text->setLabel('e-mail:');
        $this->add($text);
    }
}