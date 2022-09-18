<?php
namespace Inventory\Form;

use Laminas\Form\Form;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Number;
use Laminas\Form\Element\Select;
use Laminas\Form\Element\Text;

class InventoryForm extends Form {
    public function __construct($name = 'product'){
        parent::__construct($name);

        $text = new Text('name');
        $text->setLabel('Product:');
        $text->setAttribute('readonly', 'readonly');
        $this->add($text);
        $select = new Select('operation');
        $select->setLabel('Operation:');
        $options = [
            'add' => 'add',
            'remove' => 'remove',
            'reserve' => 'reserve',
            'maximum' => 'maximum',
            'minimum' => 'minimum'
        ];
        $select->setValueOptions($options);
        $this->add($select);
        $number = new Number('amount');
        $number->setLabel('Amount:');
        $this->add($number);
        $hidden = new Hidden('code_product');
        $this->add($hidden);
    }
}