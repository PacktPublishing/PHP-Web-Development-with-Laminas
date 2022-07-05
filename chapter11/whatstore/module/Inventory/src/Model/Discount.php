<?php
namespace Inventory\Model;

use Generic\Model\AbstractModel;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\Input;
use Laminas\Filter\FilterChain;
use Laminas\Filter\ToInt;
use Laminas\Filter\StringToUpper;
use Laminas\I18n\Filter\Alnum;
use Laminas\Filter\AllowList;
use Laminas\Filter\ToFloat;
use Laminas\Validator\ValidatorChain;
use Laminas\Validator\StringLength;

class Discount extends AbstractModel
{
    public int $code;
    public string $name;
    public string $operator;
    public float $factor;
    
    public function exchangeArray($data)
    {
        $this->code = ($data['code'] ?? 0);
        $this->name = ($data['name'] ?? '');
        $this->operator = ($data['operator'] ?? '');
        $this->factor = ($data['factor'] ?? 0.0);
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
        
        $input = new Input('operator');
        $filterChain = new FilterChain();
        $filterChain->attach(new AllowList(['list' => ['-','*','/']]));
        $input->setFilterChain($filterChain);
        $inputFilter->add($input);
        
        $input = new Input('factor');
        $filterChain = new FilterChain();
        $filterChain->attach(new ToFloat());
        $input->setFilterChain($filterChain);
        $inputFilter->add($input);
        
        return $inputFilter;
    }
    
    public function toArray()
    {
        $inputFilter = $this->getInputFilter();
        $inputFilter->setData(get_object_vars($this));
        return $inputFilter->getValues();
    }
    
}