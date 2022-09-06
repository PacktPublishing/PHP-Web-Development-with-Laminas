<?php
namespace Inventory\Model;

use Generic\Model\AbstractModel;
use Laminas\Filter\ToFloat;
use Laminas\Filter\ToInt;
use Generic\Model\InputFilter;
use Laminas\InputFilter\Input;
use Laminas\Filter\FilterChain;
use Laminas\Filter\StringToUpper;
use Laminas\Validator\StringLength;
use Laminas\I18n\Filter\Alnum;
use Laminas\Validator\ValidatorChain;

class Product extends AbstractModel
{
    public int $code;
    public String $name;
    public float $price;
    public Discount $discount;
    
    public function exchangeArray($data):void
    {
        $this->code = ($data['code'] ?? 0);
        $this->name = ($data['name'] ?? '');
        $this->price = ($data['price'] ?? 0.0);
        $this->price = ($data['discountedprice'] ?? $this->price);
        $this->discount = new Discount();
        $this->discount->code = ($data['code_discount'] ?? 0);
        $this->discount->name = ($data['name_discount'] ?? '');        
    }

    public function getInputFilter(): InputFilter
    {
        $inputFilter = new InputFilter();
        
        $inputFilter->addInput('code',[new ToInt()])
        ->addInput('name',
            [
                new StringToUpper(),
                new Alnum(true)
            ],
            [new StringLength(['min' => 3])]
        )
        ->addInput('price',[new ToFloat()])
        ->addInput('code_discount',[new ToInt()]);
        
        return $inputFilter;
    }
    
    public function toArray()
    {
        $inputFilter = $this->getInputFilter();
        $attributes = get_object_vars($this);
        unset($attributes['discount']);
        unset($attributes['name_discount']);
        $attributes['code_discount'] = $this->discount->code;        
        $inputFilter->setData($attributes);
        return $inputFilter->getValues();
    }
    
    public function getArrayCopy()
    {
        $inputFilter = $this->getInputFilter();
        $attributes = get_object_vars($this);
        unset($attributes['discount']);
        unset($attributes['name_discount']);
        $attributes['code_discount'] = $this->discount->code;
        $inputFilter->setData($attributes);
        return $inputFilter->getValues();
    }
}
