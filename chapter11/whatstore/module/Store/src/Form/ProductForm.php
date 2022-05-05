<?php
namespace Store\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;
use Laminas\Form\Element\Text;
use Laminas\Form\Element\Number;
use Laminas\Form\Element\Hidden;

class ProductForm extends Form {
    public function __construct($name = 'product'){
        parent::__construct($name);
        
        $text = new Text('name');
        $text->setAttribute('readonly', 'readonly');        
        $this->add($text);
        $text = new Text('price');
        $text->setLabel('Price:');
        $text->setAttribute('readonly', 'readonly');
        $text->setAttribute('size','15');
        $this->add($text);
        $number = new Number('amount');
        $number->setLabel('Amount:');
        $number->setAttribute('style','width: 3em');
        $this->add($number);
        $hidden = new Hidden('code');
        $this->add($hidden);
    }
}