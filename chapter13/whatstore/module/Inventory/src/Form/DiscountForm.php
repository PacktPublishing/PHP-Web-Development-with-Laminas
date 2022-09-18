<?php
namespace Inventory\Form;

use Laminas\Form\Form;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Number;
use Laminas\Form\Element\Select;
use Laminas\Form\Element\Text;

class DiscountForm extends Form {
    public function __construct($name = 'discount'){
        parent::__construct($name);
        
        $text = new Text('name');
        $text->setLabel('Name:');
        $text->setAttribute('autofocus', 'autofocus');
        $this->add($text);
        $select = new Select('operator');
        $select->setLabel('Operator:');
        $options = [
            '-' => '-',
            '*' => '*',
            '/' => '/',
        ];
        $select->setValueOptions($options);
        $this->add($select);
        $number = new Number('factor');        
        $number->setLabel('Factor:');
        $this->add($number);
        $hidden = new Hidden('code');
        $this->add($hidden);
    }
}