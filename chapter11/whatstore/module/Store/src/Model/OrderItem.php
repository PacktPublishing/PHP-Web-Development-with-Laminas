<?php
declare(strict_types=1);
namespace Store\Model;

use Generic\Model\AbstractModel;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\Input;
use Laminas\Filter\FilterChain;
use Laminas\Filter\ToInt;
use Laminas\Filter\ToFloat;

class OrderItem extends AbstractModel
{
    public int $code_order;
    public int $code_product;
    public float $price;
    public int $amount;
    
    public function exchangeArray($data):void
    {
        $this->code_order = ($data['code_order'] ?? 0);
        $this->code_product = ($data['code_product'] ?? 0);
        $this->price = ($data['price'] ?? 0);
        $this->amount = ($data['amount'] ?? 0);
    }
    
    public function getInputFilter(): InputFilter
    {
        $inputFilter = new InputFilter();

        $input = new Input('code_order');
        $filterChain = new FilterChain();
        $filterChain->attach(new ToInt());
        $input->setFilterChain($filterChain);
        $inputFilter->add($input);

        $input = new Input('code_product');
        $filterChain = new FilterChain();
        $filterChain->attach(new ToInt());
        $input->setFilterChain($filterChain);
        $inputFilter->add($input);
 
        $input = new Input('price');
        $filterChain = new FilterChain();
        $filterChain->attach(new ToFloat());
        $input->setFilterChain($filterChain);
        $inputFilter->add($input);
 
        $input = new Input('amount');
        $filterChain = new FilterChain();
        $filterChain->attach(new ToInt());
        $input->setFilterChain($filterChain);
        $inputFilter->add($input);

        return $inputFilter;
    }

    public function toArray()
    {
        $attributes = get_object_vars($this);
        $inputFilter = $this->getInputFilter();
        $inputFilter->setData($attributes);
        return $inputFilter->getValues();
    }    
}
