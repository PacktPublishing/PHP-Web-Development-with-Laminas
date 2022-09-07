<?php
namespace Store\Model;

use Generic\Model\AbstractModel;
use Laminas\Validator\EmailAddress;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\Input;
use Laminas\Filter\FilterChain;
use Laminas\Filter\HtmlEntities;
use Laminas\Filter\ToInt;
use Laminas\Filter\StringToUpper;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Validator\ValidatorChain;
use Laminas\Validator\StringLength;
use Laminas\I18n\Filter\Alnum;
use Laminas\Session\Container;

class Customer extends AbstractModel
{
    public int $IDN;
    public String $name;
    public String $password;
    public String $email;
    
    public function exchangeArray($data):void
    {
        $this->IDN = ($data['IDN'] ?? 0);
        $this->name = ($data['name'] ?? '');
        $this->password = self::encrypt(($data['password'] ?? ''));
        $this->email = ($data['email'] ?? '');
    }
    
    public static function encrypt(String $text)
    {
        $text = strrev(hash('md5', $text));
        return hash('sha256', $text);
    }
    
    public function getInputFilter(): InputFilter
    {
        $inputFilter = new InputFilter();
        
        $input = new Input('IDN');
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
        
        $input = new Input('password');
        $validatorChain = new ValidatorChain();
        $validatorChain->attach(new StringLength(['min' => 8]));
        $input->setValidatorChain($validatorChain);
        $inputFilter->add($input);
        
        $input = new Input('email');
        $filterChain = new FilterChain();
        $filterChain->attach(new StripTags())
        ->attach(new HtmlEntities())
        ->attach(new StringTrim());
        $input->setFilterChain($filterChain);        
        $validatorChain = new ValidatorChain();
        $validatorChain->attach(new EmailAddress());
        $input->setValidatorChain($validatorChain);
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
    
    public static function setCustomer(object $customer): void
    {
        $container = new Container();
        $container->customer = $customer;
    }
    
    public static function getCustomer(): object
    {
        $voidCustomer = new \stdClass();
        $voidCustomer->IDN = 0;
        $voidCustomer->name = 'Void customer';
        $container = new Container();
        return (isset($container->customer) ? $container->customer : $voidCustomer);
    }
    
}
