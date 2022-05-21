<?php
namespace Application\Form;

use Laminas\Form\Element;
use Laminas\Form\Form;

class UploadForm extends Form
{
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
        $this->addElements();
    }
    
    public function addElements()
    {
        // File Input
        $file = new Element\File('image-file');
        $file->setLabel('Image Upload');
        $file->setAttribute('id', 'image-file');
        
        $this->add($file);
    }
}