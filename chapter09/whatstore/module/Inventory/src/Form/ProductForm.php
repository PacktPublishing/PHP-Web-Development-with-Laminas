<?php
namespace Inventory\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;
use Laminas\Form\Element\Text;
use Laminas\Form\Element\Select;
use Laminas\Form\Element\Hidden;

class ProductForm extends Form {
    public function __construct($name = 'product'){
        parent::__construct($name);
        
        $text = new Text('name');
        $text->setLabel('Name:');
        $text->setAttribute('autofocus', 'autofocus');
        $this->add($text);
        $text = new Text('price');
        $text->setLabel('Price:');
        $this->add($text);
        $select = new Select('code_discount');
        $select->setLabel('Discount:');
        $this->add($select);
        $hidden = new Hidden('code');
        $this->add($hidden);
    }
}