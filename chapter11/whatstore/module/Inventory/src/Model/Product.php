<?php
namespace Inventory\Model;

use Generic\Model\AbstractModel;
use Laminas\Filter\ToFloat;
use Laminas\Filter\ToInt;
use Laminas\InputFilter\InputFilter;
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
    
    public function exchangeArray($data)
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
        
        $input = new Input('code');
        $filterChain = new FilterChain();
        $filterChain->attach(new ToInt());
        $input->setFilterChain($filterChain);
        $inputFilter->add($input);
        
        $input = new Input('name');
        $filterChain = new FilterChain();
        $filterChain->attach(new StringToUpper())
        ->attach(new Alnum(true));
        $input->setFilterChain($filterChain);
        $validatorChain = new ValidatorChain();
        $validatorChain->attach(new StringLength(['min' => 3]));
        $input->setValidatorChain($validatorChain);
        $inputFilter->add($input);
        
        $input = new Input('price');
        $filterChain = new FilterChain();
        $filterChain->attach(new ToFloat());
        $input->setFilterChain($filterChain);
        $inputFilter->add($input);
        
        $input = new Input('code_discount');
        $filterChain = new FilterChain();
        $filterChain->attach(new ToInt());
        $input->setFilterChain($filterChain);
        $inputFilter->add($input);
        
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