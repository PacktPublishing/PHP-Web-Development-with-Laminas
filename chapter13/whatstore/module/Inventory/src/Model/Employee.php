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
use Generic\Filter\Encrypt;

class Employee extends AbstractModel
{
    public int $ID;
    public String $name;
    public String $nickname;    
    public String $password;
    
    public function exchangeArray($data):void
    {
        $filter = new Encrypt();
        $this->ID = ($data['ID'] ?? 0);
        $this->name = ($data['name'] ?? '');
        $this->nickname = ($data['nickname'] ?? '');        
        $this->password = (isset($data['password']) ? $filter->filter($data['password']) : '');
    }
    
    public function getInputFilter(): InputFilter
    {
        $inputFilter = new InputFilter();
        
        $input = new Input('ID');
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
        
        $input = new Input('nickname');
        $filterChain = new FilterChain();
        $filterChain->attach(new StringToUpper())
        ->attach(new Alnum(true));
        $input->setFilterChain($filterChain);
        $validatorChain = new ValidatorChain();
        $validatorChain->attach(new StringLength(['min' => 3]));
        $input->setValidatorChain($validatorChain);
        $inputFilter->add($input);
        
        $input = new Input('password');
        $input->setRequired(false);        
        $inputFilter->add($input);
        
        return $inputFilter;
    }
    
    public function toArray()
    {
        $inputFilter = $this->getInputFilter();
        $attributes = get_object_vars($this);
        if (empty($attributes['password'])){
            unset($attributes['password']);
        }        
        $inputFilter->setData($attributes);
        return $inputFilter->getValues();
    }
}
