<?php
declare(strict_types = 1);
namespace School\Model;

abstract class AbstractModel
{

    public function exchangeArray($data)
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
}