<?php
namespace Application\Validator;

use Laminas\Validator\ValidatorInterface;

class Palindrome implements ValidatorInterface
{
    private array $messages = [];
    
    public function isValid($value)
    {
        $value = strtolower($value);
        $value = str_replace(' ', '', $value);
        $valueLength = strlen($value);
        $repeated = (int)($valueLength/2);
        $n = $valueLength-1;
        for($i=0;$i<$repeated;$i++){
            $palindrome = ($value[$i] == $value[$n]);
            if (!$palindrome){
                $this->messages[] = "{$value[$i]} is different of {$value[$n]}";
                return false;
            }
            $n--;
        }
        return true;
    }
    
    public function getMessages()
    {
        return $this->messages;
    }
}
