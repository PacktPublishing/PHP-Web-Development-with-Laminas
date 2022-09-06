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

class RoleResource extends AbstractModel
{
    public int $code;
    public Resource $resource;
    public Role $role;
    
    public function exchangeArray($data):void
    {
        $this->code = ($data['code'] ?? 0);
        $this->resource = new Resource();
        $this->role = new Role();
        $this->resource->code = ($data['code_resource'] ?? 0);
        $this->role->code = ($data['code_role'] ?? 0);
        $this->resource->name = ($data['resource'] ?? '');
        $this->role->name = ($data['role'] ?? '');
    }
    
    public function getInputFilter(): InputFilter
    {
        $inputFilter = new InputFilter();
        
        $input = new Input('code_resource');
        $filterChain = new FilterChain();
        $filterChain->attach(new ToInt());
        $input->setFilterChain($filterChain);
        $inputFilter->add($input);
        
        $input = new Input('code_role');
        $filterChain = new FilterChain();
        $filterChain->attach(new ToInt());
        $input->setFilterChain($filterChain);
        $inputFilter->add($input);

        return $inputFilter;
    }
    
    public function toArray()
    {
        $data = [
            'code_resource' => $this->resource->code,
            'code_role' => $this->role->code
        ];
        $inputFilter = $this->getInputFilter();
        $inputFilter->setData($data);
        return $inputFilter->getValues();
    }
    
    public function getArrayCopy()
    {
        $data = [
            'code_resource' => $this->resource->code,
            'code_role' => $this->role->code
        ];
        return $data;
    }
}
