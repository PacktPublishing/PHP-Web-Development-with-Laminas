<?php
namespace Inventory\Form;

use Laminas\Form\Form;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Select;
use Laminas\Form\Element\Text;

class ResourceForm extends Form {
    public function __construct($name = 'resource'){
        parent::__construct($name);
        
        $text = new Text('name');
        $text->setLabel('Name:');
        $text->setAttribute('autofocus', 'autofocus');
        $this->add($text);
        $select = new Select('method');
        $select->setLabel('Method:');
        $options = [
            'POST' => 'POST',
            'PUT' => 'PUT',
            'GET' => 'GET',
            'DELETE' => 'DELETE'
        ];
        $select->setValueOptions($options);
        $this->add($select);
        $hidden = new Hidden('code');
        $this->add($hidden);
    }
}