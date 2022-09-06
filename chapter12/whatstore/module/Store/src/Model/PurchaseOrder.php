<?php
namespace Store\Model;

use Generic\Model\AbstractModel;
use Laminas\Validator\EmailAddress;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\Input;
use Laminas\Filter\FilterChain;
use Laminas\Filter\ToInt;
use Laminas\Filter\StringToUpper;
use Laminas\Validator\ValidatorChain;
use Laminas\Validator\StringLength;
use Laminas\I18n\Filter\Alnum;

class PurchaseOrder extends AbstractModel
{
    public int $code;
    public int $status;
    public int $IDN;
    
    const CREATED = 0;
    const WAITING_PAYMENT = 1;
    const PROCESSED_PAYMENT = 2;
    const COLLECTING_PRODUCTS = 3;
    const TRANSPORTING = 4;
    const DELIVERED = 5;
    const CANCELLED = 6;
    
    public function exchangeArray($data):void
    {
        $this->code = ($data['code'] ?? 0);
        $this->status = ($data['status'] ?? 0);
        $this->IDN = ($data['IDN'] ?? 0);
    }
    
    public function getInputFilter(): InputFilter
    {
        $inputFilter = new InputFilter();
        
        $input = new Input('code');
        $filterChain = new FilterChain();
        $filterChain->attach(new ToInt());
        $input->setFilterChain($filterChain);
        $inputFilter->add($input);

        $input = new Input('status');
        $filterChain = new FilterChain();
        $filterChain->attach(new ToInt());
        $input->setFilterChain($filterChain);
        $inputFilter->add($input);
        
        $input = new Input('IDN');
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
