<?php
declare(strict_types=1);

namespace Generic\Model;

use Laminas\InputFilter\InputFilter as LaminasInputFilter;
use Laminas\InputFilter\Input;
use Laminas\Filter\FilterChain;
use Laminas\Validator\ValidatorChain;

class InputFilter extends LaminasInputFilter
{
    public function addInput(string $name, array $filters = [], array $validators = []): self
    {
        $input = new Input($name);
        $filterChain = new FilterChain();
        foreach($filters as $filter){
            $filterChain->attach($filter);
        }        
        $input->setFilterChain($filterChain);
        $validatorChain = new ValidatorChain();
        foreach($validators as $validator){
            $validatorChain->attach($validator);
        }
        $input->setValidatorChain($validatorChain);        
        $this->add($input);
        return $this;
    }    
}