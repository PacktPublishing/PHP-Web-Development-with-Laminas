<?php
namespace Inventory\Model;

use Generic\Model\AbstractModel;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\Input;
use Laminas\Filter\FilterChain;
use Laminas\Filter\ToInt;
use Laminas\Filter\StringToUpper;
use Laminas\Validator\ValidatorChain;
use Laminas\I18n\Filter\Alnum;
use Laminas\Validator\StringLength;
use Laminas\I18n\Filter\Alpha;

class Resource extends AbstractModel
{
    public int $code;
    public String $name;
    public String $method;
    
    public function exchangeArray($data)
    {
        $this->code = ($data['code'] ?? 0);
        $this->name = ($data['name'] ?? '');
        $this->method = ($data['method'] ?? '');
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
        $validatorChain = new ValidatorChain();
        $validatorChain->attach(new StringLength(['min' => 3]));
        $input->setValidatorChain($validatorChain);
        $inputFilter->add($input);
        
        $input = new Input('method');
        $filterChain = new FilterChain();
        $filterChain->attach(new Alpha(true));
        $input->setFilterChain($filterChain);
        $validatorChain = new ValidatorChain();
        $validatorChain->attach(new StringLength(['min' => 3]));
        $input->setValidatorChain($validatorChain);
        $inputFilter->add($input);
        
        return $inputFilter;
    }
    
    public function toArray()
    {
        $inputFilter = $this->getInputFilter();
        $inputFilter->setData(parent::toArray());
        return $inputFilter->getValues();
    }
}