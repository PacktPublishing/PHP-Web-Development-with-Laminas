<?php
declare(strict_types = 1);
namespace Generic\Model;

abstract class AbstractModel
{
    public function __construct()
    {
        $this->exchangeArray([]);
    }    
    
    public function exchangeArray($data):void
    {
        $attributes = get_object_vars($this);
        foreach ($attributes as $attribute => $value) {
            $this->$attribute = (is_int($this->$attribute) ? (int) $data[$attribute] : $data[$attribute]);
        }
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
