<?php
namespace Inventory\Model;

use Generic\Model\AbstractModel;
use Generic\Model\InputFilter;
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
        
        $inputFilter->addInput('code',[new ToInt()])
        ->addInput('name',
            [
                new StringToUpper(),
                new Alnum(true)
            ],
            [new StringLength(['min' => 3])]
        )
        ->addInput('operator',[
            new AllowList(['list' => ['-','*','/']])
            ]
        )
        ->addInput('factor', [new ToFloat()]);
        
        return $inputFilter;
    }
    
    public function toArray()
    {
        $inputFilter = $this->getInputFilter();
        $inputFilter->setData(get_object_vars($this));
        return $inputFilter->getValues();
    }
    
}